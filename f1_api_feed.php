<?php
/**
 * Author: tropicandid
 * Author URI: https://github.com/tropicandid
 * Description: The New York Times best selling book feed.
 * License: GPL v2 or later
 * Plugin Name: F1 API Feed
 * Version: 1.0.0
 */


$GLOBALS['f1_api_feed_options_page'] = admin_url('options-general.php?page=f1-api-feed');


if ( !class_exists( 'F1_API_Feed_Settings' ) ) {

    class F1_API_Feed_Settings {

        private static $instance = null;

        public static function get_instance() {

            if ( null == self::$instance ) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        private function __construct() {
            add_action( 'admin_menu', array( &$this, 'f1_api_feed_add_to_menu' ) );
            add_action( 'admin_init', array( &$this, 'f1_api_feed_post_info' ) );
            add_action( 'admin_init', array( &$this, 'f1_api_feed_init_db_entry' ) );

            require_once dirname( __FILE__ ) . '/inc/f1_api_feed_block.php';
        }

        public static function f1_api_feed_init_db_entry() {
            add_option('f1_api_feed_key','GHlGPXCBY8b3InkVjOqAbyRPJ1as0Znr');
            add_option('f1_api_feed_settings','https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json');
            add_option('f1_api_feed_settings_title','');
            add_option('f1_api_feed_settings_author','');
            add_option('f1_api_feed_settings_contributor','');
            add_option('f1_api_feed_settings_publisher','');
            add_option('f1_api_feed_settings_price','');
            add_option('f1_api_feed_settings_records','');
        }

        public static function f1_api_feed_add_to_menu() {
            add_options_page('F1 API Feed','F1 API Feed','manage_options', 'f1-api-feed', array( $this, 'f1_api_feed_options_page' ) );
        }

        public static function f1_api_feed_options_page() {
            require_once dirname( __FILE__ ) . '/inc/f1_api_feed_admin.php';
        }

        public static function f1_api_feed_post_info() {   
            register_setting( 'f1-api-feed-info-settings', 'f1_api_feed_info' ); 
        } 
    }

    F1_API_Feed_Settings::get_instance();
}

