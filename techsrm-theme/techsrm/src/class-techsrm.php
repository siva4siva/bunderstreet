<?php

/**
 *
 *
 * @author TechSrm MultiTech
 */
class TechSrm {

    public $module_name;
    public $version;
    public $directory;
    public $uri;
    public $base_name;

    public function __construct() {
        $this->load_data();
    }


    public function load_data() {
        $this->module_name = '';
        $this->version = 2;
        $this->directory = __DIR__;
        $this->uri = get_template_directory_uri();
        $this->base_name = 'TechSrm';
    }

    public function load_module($module_name = "", $base_name = "") {
        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        if($base_name === ""){
            $base_name = $this->base_name;
        }
        $module_path = $this->get_module_path($module_name) . '/class-'.$base_name.'-' . $module_name . '.php';

        if ($module_path !== FALSE) {
            require_once($module_path);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function load_style($name, $dependancies = array(), $module_name = '', $base_name = "", $extension = 'css') {

        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        if($base_name === ""){
            $base_name = $this->base_name;
        }
        wp_enqueue_style(
                $base_name.'-styles-' . $name, $this->uri . "/assets/css/{$name}.{$extension}", $dependancies, $this->get_module_version($module_name), 'all'
        );
    }

    public function load_script($name, $dependancies = array(), $module_name = "", $base_name = "", $extension = 'js') {

        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        if($base_name === ""){
            $base_name = $this->base_name;
        }
        wp_enqueue_script(
                $base_name.'-script-' . $name, $this->uri . "/assets/js/{$name}.{$extension}", $dependancies, $this->get_module_version($module_name)
        );
    }

    public function load_class($name, $module_name="",$base_name=""){
        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        if($base_name === ""){
            $base_name = $this->base_name;
        }
        require_once($this->get_module_path($module_name) . "/classes/class-{$base_name}-{$module_name}-{$name}.php");

    }

    public function register_localize_script($name, $dependancies = array(), $object_name, $data, $module_name = "", $extension = 'js') {

        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        wp_register_script(
                $base_name.'-script-' . $name, $this->uri . "/assets/js/{$name}.{$extension}", $dependancies, $this->get_module_version($module_name)
        );

        wp_localize_script($base_name.'-script-' . $name, $object_name, $data);
        wp_enqueue_script($base_name.'-script-' . $name);
    }

    public function get_image_url($path, $module_name = "") {
        if ($module_name !== "") {
            $module_name = $this->module_name;
            return $this->get_module_uri( $this->module_name) . "/assets/img{$path}";
        }
        return $this->uri ."/".$module_name. "/assets/images{$path}";
    }

    public function get_module_path($module_name = "") {
        $module_path = $this->directory;

        if ($this->module_name === "") {
            $module_path = $module_path . '/' . $module_name;

        }


        if (file_exists($module_path)) {
            return $module_path;
        } else {
            return FALSE;
        }
    }

    public function get_module_version() {

        return $this->version;
    }

    public function get_module_uri($module_name = "") {

        if ($module_name === "") {
            $module_name = $this->module_name;
        }
        $module_uri = get_template_directory_uri() . '/techsrm/src/' . $module_name;
        return $module_uri;
    }

    /**
     * Null/Empty field validating function.
     * If the field is found to be an empty it allows to
     * pass an admin error message to print.
     *
     * @param string $field_name
     * @param string $display_admin_error
     * @return boolean
     */
    public function process_field($field_name, $post_id = 0, $display_admin_error = FALSE) {
        if ($post_id === 0) {
            global $post;
            $post_id = $post->ID;
            if ($post_id === "" || $post_id === NULL) {
                return FALSE;
            }
        }

        $field = get_field($field_name, $post_id);

        if ($field) {
            return $field;
        } else {
            if ($display_admin_error) {
                TS_Debug::admin_message($display_admin_error);
                echo "<br />";
            }
            return FALSE;
        }
    }

    // get select box value
    public function process_field_text($field_name, $post_id = 0) {
        if ($post_id === 0) {
            global $post;
            $post_id = $post->ID;
            if ($post_id === "" || $post_id === NULL) {
                return FALSE;
            }
        }
        $field = get_field_object($field_name, $post_id);

        if ($field) {
            $field_text = $field['choices'][$field['value']];
            return $field_text;
        } else {
            if ($display_admin_error) {
                TS_Debug::admin_message($display_admin_error);
                echo "<br />";
            }
            return FALSE;
        }
    }

    /**
     * Returns all custom fields packed with an array for the current post.
     * Also its processing the fields for empty check.
     *
     * @return type
     */
    public function get_custom_fields($post_id = 0, $display_admin_message = false) {

        if ($post_id === 0) {
            global $post;
            $post_id = $post->ID;
            if ($post_id === "" || $post_id === NULL) {
                return FALSE;
            }
        }
        $fields = get_fields($post_id);
        $return_data = array();
        if ($fields) {
            foreach ($fields as $field_name => $value) {
                $error_message = $display_admin_message ? $field_name . " is empty." : false;
                $return_data[$field_name] = $this->process_field($field_name, $post_id, $error_message);
            }
        }
        return $return_data;
    }

    /**
     * Default load_template function in wordpress can't get the
     * scope of local variables. So we go for our load_template
     * function, where we can sent data to our template.
     *
     * @param string $path relative path to the template file
     * @param array $data array of data to be used in the template
     * @param bool $debug to print the return object for debug
     *
     * includes the template file and uses the scope of $data array to substitue
     * the values in template files
     */
    public function load_template($template, $data = array(), $extension = "php", $module_name = "", $debug = FALSE) {
        if ($debug) {
            TS_Debug::print_object($data);
        }
        if ($module_name === "") {
            $module_name = $this->module_name;

        }
        require( $this->get_module_path($module_name) . '/template' . $template . '.' . $extension);
    }

    public function get_template($template, $data = array(), $extension = "php", $module_name = "", $debug = FALSE) {
        if ($debug) {
            TS_Debug::print_object($data);
        }
        if ($module_name === "") {
            $module_name = $this->module_name;

        }
        ob_start();
        require( $this->get_module_path($module_name) . '/template' . $template . '.' . $extension);
        return ob_get_clean();
    }

    //print the post title for the given id(for select option ex:-brand)
    public function the_name($post_id) {
        $post_tile = get_the_title($post_id);
        esc_html_e($post_tile);
    }

    public function get_image_path($post_id = 0, $field_name = "", $type = "", $registered_image_size = "tile-image") {
        $image_content = array();
        if ($post_id == 0) {
            global $post;
            $post_id = $post->ID;
        }
        $image_data = array();
        if ($field_name != "") {
            $image_data = $this->process_field($field_name, $post_id);
            $get_thumbnail = array();
            if (is_array($image_data)) {
                if (array_key_exists("ID", $image_data)) {
                    if ($image_data['sizes'][$registered_image_size] != '') {
                        $get_thumbnail = $image_data['sizes'];
                        $image_content["image_url"] = $get_thumbnail[$registered_image_size];
                        $image_content["image_title"] = $image_data["title"];
                    } else {
                        $image_content["image_url"] = $image_data["url"];
                        $image_content["image_title"] = $image_data["title"];
                    }
                    return $image_content;
                }
            }
        }

        if (has_post_thumbnail($post_id)) {
            $image_meta = get_post(get_post_thumbnail_id($post_id));
            if (isset($image_meta)) {
                $image_content["image_url"] = $image_meta->guid;
                $image_content["image_title"] = $image_meta->post_title;
            }
            if ($image_content["image_url"] != "") {
                return $image_content;
            }
        } else {
            if (get_field('default_image','option')) {
                $image_meta = get_field('default_image','option');
                $image_content["image_url"] = $image_meta["url"];
                $image_content["image_title"] = get_the_title($image_meta["id"]);
            }
            if ($image_content["image_url"] != "") {
                return $image_content;
            }
            $image_content["image_url"] = $this->get_module_uri("theme") . "/assets/images/no-data.jpg";
            $image_content["image_title"] = "Award City";
            return $image_content;
        }
        return false;
    }

    public function the_image_path($post_id) {
        $post_image = $this->get_image_path($post_id);
        esc_html_e($post_image);
    }

    function post_exists($post_id){
        if ( FALSE === get_post_status( $post_id ) ) {
          return FALSE;
        } else {
          return TRUE;
        }
    }

    /**
     * Function help us to print the post data's.
     *
     * @param string $type
     * @param string $post_per_page
     * @param string $group
     * @return option array
     */
    public function get_post_data($type, $post_per_page, $term = "") {
        $args = array(
            'posts_per_page' => $post_per_page,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => $type,
            'group' => $term,
            'post_status' => 'publish'
        );

        $data = get_posts($args);
        return $data;
    }

    function get_posts_and_meta($post_type, $args= array(), $selected_meta_fields = false){
         $args_default = array(
            	'posts_per_page'   => -1,
            	'orderby'          => 'date',
            	'order'            => 'DESC',
            	'post_type'        => $post_type,
            	'post_status'      => 'publish',
            	'suppress_filters' => true,
        );

        $args = array_merge($args_default, $args);

        $posts = get_posts( $args );

        $post_data= array();
        foreach($posts as $post){
            $data = array();
            $data['post'] = $post;
            if($selected_meta_fields === false ){
                $data['meta'] = $this->get_custom_fields($post->ID);
            } else{

                foreach ($selected_meta_fields as $meta_key){
                    $data['meta'][$meta_key] = get_post_meta($post->ID, $meta_key,true);
                }
            }

            $post_data[] = $data;
        }
        return $post_data;
    }

    public function is_administrator(){
        if(current_user_can('manage_options')){
            return true;
        } else {
            return false;
        }
    }

    public function is_super_administrator($user_id = ""){
        if($user_id === ""){
            $user_id = get_current_user_id();
        }
        return is_super_admin($user_id);
    }

}

global $techsrm;
$techsrm = new TechSrm();
