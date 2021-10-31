<?php
/**
 * Plugin Name
 *
 * @package           ExceptioBookingWordpress
 * @author            Ahsan Zahid Chowdhury
 * @copyright         2021 Exception Solutions
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Exceptio Booking Wordpress
 * Plugin URI:        https://github.com/azcpavel/exceptio-booking-wordpress
 * Description:       To Enable Booking System in Wordpress.
 * Version:           1.0.0
 * Requires at least: 5.7
 * Requires PHP:      7.2
 * Author:            Exception Solutions
 * Author URI:        https://exceptionsolutions.com/
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ExceptioBookingWordpress' ) ) :

    /**
     * Main ExceptioBookingWordpress Class.
     *
     * @class ExceptioBookingWordpress
     * @version 1.0.0
     */
    final class ExceptioBookingWordpress {

        /**
         * ExceptioBookingWordpress version.
         *
         * @var string
         */
        public $version = '1.0.0';

        /**
         * The single instance of the class.
         *
         * @var ExceptioBookingWordpress|null
         */
        protected static $instance = null;

        public static $message;

        /**
         * Main ExceptioBookingWordpress Instance.
         *
         * Ensures only one instance of ExceptioBookingWordpress is loaded or can be loaded.
         *
         * @static
         * @see ExceptioBookingWordpress()
         * @return ExceptioBookingWordpress - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
                self::$instance->setup();
            }
            return self::$instance;
        }

        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'exceptiobookingwordpress' ), '1.0.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'exceptiobookingwordpress' ), '1.0.0' );
        }

        /**
         * ExceptioBookingWordpress Constructor.
         */
        public function __construct() {
            define( 'ExceptioBookingWordpress_PLUGIN_FILE', __FILE__ );
            define( 'ExceptioBookingWordpress_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            define( 'ExceptioBookingWordpress_VERSION', $this->version );
            define( 'ExceptioBookingWordpress_PHP_VERSION_REQUIREMENT', '7.2.5' );
            define( 'ExceptioBookingWordpress_DIR', dirname( plugin_basename( __FILE__ ) ) );            
            
            if ( ! defined( 'ExceptioBookingWordpress_DEBUG' ) ) {
                define( 'ExceptioBookingWordpress_DEBUG', false );
            }

            ExceptioBookingWordpress::$message = [
                'OTP_TIME_LIMIT' => [
                    'code' => 'OTP001',
                    'message' => 'Please wait '.get_option('exceptiobookingwordpress_otp_resend_time').' munites for retry!'
                ]                
            ];

            do_action( 'exceptiobookingwordpress_loaded' );
        }

        /**
         * Hook into actions and filters.
         *
         * @return void
         */
        private function setup() {

            // Register tasks on register_plugin_activation.
            register_activation_hook( __FILE__, array( 'ExceptioBookingWordpress_Admin', 'register_plugin_activation' ) );

            $this->includes();
            $this->init_hooks();
        }

        /**
         * Hook into actions and filters.
         *
         * @return void
         */
        private function init_hooks() {
            add_action( 'init', array( $this, 'init' ) );           
        }

        /**
         * Init ExceptioBookingWordpress when WordPress Initialises.
         *
         * @return void
         */
        public function init() {                       
            
            // add_action( 'personal_options_update', 'save_exceptiobookingwordpress_user_profile_fields' );
            // add_action( 'edit_user_profile_update', 'save_exceptiobookingwordpress_user_profile_fields' );
            // add_action( 'woocommerce_save_account_details', 'save_exceptiobookingwordpress_user_profile_fields' );

            // Before init action.            

            // Init action.            
        }

        /**
         * Include required core files used in admin and on the frontend.
         *
         * @return void
         */
        public function includes() {
            require_once dirname( __FILE__ ) . '/vendor/autoload.php';            

            // Admin includes.
            if ( is_admin() || defined( 'DOING_CRON' ) && DOING_CRON ) {
                add_action( 'plugins_loaded', array( 'ExceptioBookingWordpress_Admin', 'init' ) );
                add_action( 'plugins_loaded', array( 'ExceptioBookingWordpress_Cron', 'init' ) );
            }
            
            // creating Ajax call for WordPress 
            // OTP Add Phone
            //add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_add_phone_otp', 'exceptiobookingwordpress_add_phone_otp' );
            add_action( 'wp_ajax_exceptiobookingwordpress_add_phone_otp', 'exceptiobookingwordpress_add_phone_otp' );
            // OTP Verify Add Phone
            //add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_verify_otp_add_phone', 'exceptiobookingwordpress_verify_otp_add_phone' );
            add_action( 'wp_ajax_exceptiobookingwordpress_verify_otp_add_phone', 'exceptiobookingwordpress_verify_otp_add_phone' );
            // OTP Login
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_send_login_otp', 'exceptiobookingwordpress_send_login_otp' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_send_login_otp', 'exceptiobookingwordpress_send_login_otp' );
            // OTP Verify
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_verify_otp', 'exceptiobookingwordpress_verify_otp' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_verify_otp', 'exceptiobookingwordpress_verify_otp' );
            // OTP Login
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_send_password_otp', 'exceptiobookingwordpress_send_password_otp' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_send_password_otp', 'exceptiobookingwordpress_send_password_otp' );
            // OTP Verify Forget Pass
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_verify_otp_password', 'exceptiobookingwordpress_verify_otp_password' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_verify_otp_password', 'exceptiobookingwordpress_verify_otp_password' );  
            // OTP Register
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_register_otp', 'exceptiobookingwordpress_register_otp' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_register_otp', 'exceptiobookingwordpress_register_otp' );
            // OTP Verify Register
            add_action( 'wp_ajax_nopriv_exceptiobookingwordpress_verify_otp_register', 'exceptiobookingwordpress_verify_otp_register' );
            //add_action( 'wp_ajax_exceptiobookingwordpress_verify_otp_register', 'exceptiobookingwordpress_verify_otp_register' );  

            // Frontend inclusions.
            if ( ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) ) {
                // Hook to 'wp' because we need to check the current user.
                add_action( 'init', array( $this, 'frontend_includes' ), 1 );                
                add_action( 'wp_enqueue_scripts', 'exceptiobookingwordpress_enqueuescripts');                                                        
            }
        }

        /**
         * Frontend Include required core files used on the frontend.
         *
         * @return void
         */
         public function frontend_includes() {
            
         }

        /**
         * Get the plugin url.
         *
         * @return string
         */
        public function plugin_url() {
            return untrailingslashit( plugins_url( '/', __FILE__ ) );
        }

        /**
         * Get the plugin path.
         *
         * @return string
         */
        public function plugin_path() {
            return untrailingslashit( plugin_dir_path( __FILE__ ) );
        }

        /**
         * Get Ajax URL.
         *
         * @return string
         */
        public function ajax_url() {
            return admin_url( 'admin-ajax.php', 'relative' );
        }

        /**
         * Get the plugin url.
         *
         * @param string $path The path to append into the build pathname.
         *
         * @return string
         */
        public function build_url( $path ) {
            return untrailingslashit( plugins_url( '/build/' . $path, __FILE__ ) );
        }

        /**
         * Debug mode enabled
         *
         * @return bool
         */
        public function is_debug_mode() {
            return 'yes' === get_option( 'exceptiobookingwordpress_enable_debug_mode' ) || ( defined( 'ExceptioBookingWordpress_DEBUG' ) && ExceptioBookingWordpress_DEBUG );
        }

        public static function message($type){

            return ExceptioBookingWordpress::$message[$type];
        }
    }

endif;

/**
 * Main instance of ExceptioBookingWordpress.
 *
 * @return ExceptioBookingWordpress
 */
function ExceptioBookingWordpress() {  // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
    return ExceptioBookingWordpress::instance();
}

ExceptioBookingWordpress();