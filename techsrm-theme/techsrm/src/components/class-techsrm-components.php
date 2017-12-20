<?php

class TS_Components extends TechSrm {

    public $module_name;
    public $version;
    public $directory;
    public $uri;
    public $base_name;
    public $dev;

    public function __construct() {
        $this->load_data();
        $this->dev = false;

        add_filter('script_loader_tag', array($this, 'add_defer_attribute'), 10, 2);
    }

    public function load_data() {
        $this->module_name = 'components';
        $this->version = 1;
        $this->directory = __DIR__;
        $this->uri = $this->get_module_uri();
        $this->base_name = 'superbotics';
    }

    function add_defer_attribute($tag, $handle) {
        if (strpos($handle, 'techsrm') === 0)
            return str_replace(' src', ' async="async" src', $tag);
        return $tag;
    }

    public function load_lib($path, $name, $extension = 'php') {
        require_once($this->get_module_uri($this->module_name) . "/lib{$path}{$name}.{$extension}");
    }

    public function load_lib_style($path, $name, $version, $extension = 'css', $dependancies = array()) {

        wp_enqueue_style(
                'techsrm-style-' . $name, $this->get_module_uri($this->module_name) . "/lib/{$path}/{$name}.{$extension}", $dependancies, $version
        );
    }

    public function load_lib_script($path, $name, $version, $dependancies = array(), $nonAsync = "", $extension = 'js') {

        wp_enqueue_script(
                $nonAsync . 'techsrm-script-' . $name, $this->get_module_uri($this->module_name) . "/lib{$path}{$name}.{$extension}", $dependancies, $version
        );
    }

    public function load_jquery() {
        if ($this->dev) {
            $this->load_lib_script('/client/jquery/', 'jquery-3.2.1.min', '3.2.1');
        } else {
            $this->load_lib_script('/client/jquery/', 'jquery-3.2.1.min', '3.2.1');
        }
    }

    public function load_popper() {
        if ($this->dev) {
            $this->load_lib_script('/client/popper/', 'popper.min', '1.12.6', array('jquery'));
        } else {
            $this->load_lib_script('/client/popper/', 'popper.min', '1.12.6', array('jquery'));
        }
    }

    public function load_bootstrap() {
        if ($this->dev) {
            $this->load_lib_style('/client/bootstrap-4.0.0/dist/css/', 'bootstrap', '4.0.0');
            $this->load_lib_script('/client/bootstrap-4.0.0/dist/js/', 'bootstrap', '4.0.0', array('jquery'));
        } else {
            $this->load_lib_style('client/bootstrap-4.0.0/dist/css/', 'bootstrap.min', '4.0.0');
            $this->load_lib_script('/client/bootstrap-4.0.0/dist/js/', 'bootstrap.min', '4.0.0', array('jquery'));
        }
    }

    public function load_bootstrap_dialog() {
        if ($this->dev) {
            $this->load_lib_script('/client/bootstrap-dialog/', 'bootstrap-dialog.min', '4.0.0', array('bootstrap'));
        } else {
            $this->load_lib_script('/client/bootstrap-dialog/', 'bootstrap-dialog.min', '4.0.0', array('bootstrap'));
        }
    }

}

global $ts_components;
$ts_components = new TS_Components();
