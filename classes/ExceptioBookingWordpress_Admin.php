<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ExceptioBookingWordpress_Admin' ) ) :
	class ExceptioBookingWordpress_Admin{
		
		public static function init(){
			add_action( 'admin_init', 'exceptiobookingwordpress_settings_init');
            add_action( 'admin_menu', 'exceptiobookingwordpress_options_page' );            
			add_filter( 'plugin_action_links_'.ExceptioBookingWordpress_PLUGIN_BASENAME, 'exceptiobookingwordpress_action_links');
			add_action( 'admin_enqueue_scripts', 'exceptiobookingwordpress_enqueuescripts');

			// creating Ajax call for WordPress            
            add_action( 'wp_ajax_exceptiobookingwordpress_migrate_phone', 'exceptiobookingwordpress_migrate_phone' );
		}

		/**
	     * Register a flag useful for redirect to dashboard after activation
	     *
	     * @return void
	     */
	    public static function register_plugin_activation() {	    	
	        add_option( 'exceptiobookingwordpress_just_activated', true );
	    }
	}

endif;
?>