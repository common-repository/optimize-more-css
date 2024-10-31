<?php

function opm_css_field_setting($key = "", $default = false) {
        if (isset($_POST)) {
            if (isset($_POST['opm_css'][$key])) {
                return $_POST['opm_css'][$key];
            }
        }

        $value = opm_css()->Settings()->get($key, $default);
        return $value;
}

function opm_css_array_value($data = array(), $default = false) {
        return isset($data) ? $data : $default;
}

function opm_css_sanitize_text_field($value) {
        if (!is_array($value)) {
            return wp_kses_post($value);
        }

        foreach ($value as $key => $array_value) {
            $value[$key] = opm_css_sanitize_text_field($array_value);
        }
        return $value;
}

function opm_css_esc_html_e($value) {
        return opm_css_sanitize_text_field($value);
}

function opm_css_removeslashes($value) {
        return stripslashes_deep($value);
}

function opm_css_kses($value, $callback = 'wp_kses_post') {
        if (is_array($value)) {
            foreach ($value as $index => $item) {
                $value[$index] = opm_css_kses($item, $callback);
            }
        } elseif (is_object($value)) {
            $object_vars = get_object_vars($value);
            foreach ($object_vars as $property_name => $property_value) {
                $value->$property_name = opm_css_kses($property_value, $callback);
            }
        } else {
            $value = call_user_func($callback, $value);
        }

        return $value;
}


function opm_css_fix_json($matches) {
    return "s:" . strlen($matches[2]) . ':"' . $matches[2] . '";';
}

