<?php

if (!defined('WPINC')) {
    die;
}


class OPM_CSS_Loader {
    const CLASS_DIR = 'includes/classes/';
    const VIEW_DIR = 'view/';

    private $admin_core_class;
    private $settings_class;
    private $upgrade_class;

    private $admin_url;
	
	private $remove_class;
	private $async_class;
	private $delay_class;
	private $preload_class;

    private static $_instance; //The single instance


    function __construct()
    {
        $this->loadClasses();
    }

    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function loadClasses()
    {
        $this->require_class('Messages');

        $this->require_class('Admin_Core');
        $this->admin_core_class = new OPM_CSS_Admin_Core();

        $this->require_class('Settings');
        $this->settings_class = new OPM_CSS_Settings();
				
		$this->require_class('Remove');
        $this->remove_class = new OPM_CSS_Remove();
		
		$this->require_class('Async');
        $this->async_class = new OPM_CSS_Async();
		
		$this->require_class('Delay');
        $this->delay_class = new OPM_CSS_Delay();
		
		$this->require_class('Preload');
        $this->preload_class = new OPM_CSS_Preload();
		
    }

    public function Admin_Core()
    {
        return $this->admin_core_class;
    }

    public function Settings()
    {
        return $this->settings_class;
    }
	
	public function Remove()
    {
        return $this->remove_class;
    }
	
	public function Async()
    {
        return $this->async_class;
    }
	
	public function Delay()
    {
        return $this->delay_class;
    }
	
	public function Preload()
    {
        return $this->preload_class;
    }	
		

    public function require_class($file = "")
    {
        return $this->required(self::CLASS_DIR . $file);
    }

    public function admin_url($view = 'settings')
    {
        return admin_url('admin.php?page=optimize-more-css&view=' . $view);
    }

    public function required($file = "")
    {
        $dir = OPM_CSS_DIR;

        if (empty($dir) || !is_dir($dir)) {
            return false;
        }

        $file = path_join($dir, $file . '.php');

        if (!file_exists($file)) {
            return false;
        }

        require_once $file;
    }

    public function get_view($file = "")
    {
        $this->required(self::VIEW_DIR . $file);
    }

    public function admin_view($file = "")
    {
        $this->get_view('admin/' . $file);
    }

    public function get_active_view()
    {
        $default = 'settings';

        if (!isset($_GET['view'])) {
            return $default;
        }

        $view = wp_filter_kses($_GET['view']);

        return ($view) ? $view : $default;

    }
}
