<?php

class Tech_Srm extends TechSrm {

    public $module_name;
    public $version;
    public $directory;
    public $uri;
    public $base_name;

    public function __construct() {
        $this->load_data();

        add_action('wp_enqueue_scripts', array($this, 'theme_scripts'));
        add_action('after_setup_theme', array($this, 'theme_setup'));
    }

    public function load_data() {
        $this->module_name = 'theme';
        $this->version = 2;
        $this->directory = __DIR__;
        $this->uri = $this->get_module_uri();
        $this->base_name = 'techsrm';
    }

    public function theme_scripts() {
        global $ts_components;
        $ts_components->load_jquery();
        $ts_components->load_popper();
        $ts_components->load_bootstrap();

        $this->load_script('theme', array('jquery'));
        $this->load_style('theme');
    }


    public function theme_setup() {


        add_theme_support('post-thumbnails');

        add_theme_support('woocommerce');

        add_theme_support('menus');

        register_nav_menu('primary', __('Primary navigation', 'techsrm'));
    }
}

global $tech_srm;
$tech_srm = new Tech_Srm();
