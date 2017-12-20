<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TS_Debug extends TechSrm {

    public static function start(){

    }
    /*
     * Only display the message, if the current user is an admin.
     * Do not be confused by is_admin(). That only checks if the
     * current page is part of the WordPress admin dashboard or API call.
     * To verify if the current user is an admin, we need to check
     * their privileges.
     */
    public static function admin_message($message, $additional_data = array()) {

        if (current_user_can('manage_options')) {
            /* A user with admin privileges */
            echo 'Error for Admin: <span style="color:red">' . $message . "</span><br/>";
        }
        /*
         * Write the error to log file which is not accessable
         * to the website, so itcan't be viewed by outsiders
         * who know the URL of the log file.
         */
        $error_file_location = $_SERVER['DOCUMENT_ROOT'] . '/../website_errors.log';
        /*
         * Build the error message for the log file
         */
        $error_message = date("Y-m-d H:i:s") . "\n{$message}\n";
        if ($additional_data !== null) {
            $error_message .= print_r($additional_data, true) . "\n";
        }
        $error_message .= "\n\n";
        /*
         * Write the details to the log file.
         */
        file_put_contents($error_file_location, $error_message, FILE_APPEND);
    }
    /**
     * prints an object to the page for debug
     *
     * @param object $what_to_print
     * @param bool $should_i_die set true to perfomr a die()
     * @param string $username if set the specified user alone gets the error message
     */
    public static function print_object($what_to_print, $should_i_die = false, $username = "") {
        if($username !== ""){
            $current_user = wp_get_current_user();
            if($current_user->user_login != $username){
                return;
            }
        }

        echo '<pre>';
        print_r($what_to_print);
        echo '</pre>';
        if ($should_i_die) {
            die();
        }
    }

    /**
     * Dumps an object to the page for debug
     *
     * @param object $what_to_dump
     * @param bool $should_i_die set true to perfomr a die()
     */
    public static function dump_object($what_to_dump, $should_i_die = false) {
        echo '<pre>';
        var_dump($what_to_dump);
        echo '</pre>';
        if ($should_i_die) {
            die();
        }
    }

};
TS_Debug::start();
?>
