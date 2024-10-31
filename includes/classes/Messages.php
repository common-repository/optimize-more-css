<?php

if (!defined('WPINC')) {
    die;
}

class OPM_CSS_Messages {
    public static function queue($message, $class = '')
    {
        $default_allowed_classes = array('error', 'warning', 'success', 'info');
        $allowed_classes = apply_filters('opm_css_messages_allowed_classes', $default_allowed_classes);
        $default_class = apply_filters('opm_css_messages_default_class', 'success');

        if (!in_array($class, $allowed_classes)) {
            $class = $default_class;
        }

        $messages = maybe_unserialize(get_option('_opm_css_messages', array()));
        $messages[$class][] = $message;

        update_option('_opm_css_messages', $messages);
    }

    public static function show()
    {
        $group_messages = maybe_unserialize(get_option('_opm_css_messages'));
        
        if (!$group_messages) {
            return;
        }

        $errors = "";
        if (is_array($group_messages)) {
            foreach ($group_messages as $class => $messages) {
                $errors .= '<div class="notice opm_css-notice notice-' . $class . ' is-dismissible"">';
                $prev_message = '';
                foreach ($messages as $message) {
                    if( $prev_message !=  $message)
                    $errors .= '<p>' . $message . '</p>';
                    $prev_message =  $message;
                }
                $errors .= '</div>';
            }
        }

        delete_option('_opm_css_messages');

        print $errors;
    }
}

if (class_exists('OPM_CSS_Messages') && !function_exists('OPM_CSS_Queue')) {
    function OPM_CSS_Queue($message, $class = null)
    {
        OPM_CSS_Messages::queue($message, $class);
    }
}
add_action('admin_notices', array('OPM_CSS_Messages', 'show'));