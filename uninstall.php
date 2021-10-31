<?php

/**
 * File that is run during plugin uninstall (not just de-activate)
 *
 * @TODO: delete all tables in network if on multisite
 */

// If uninstall not called from WordPress exit
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

/*
Go on with uninstall actions:
 - Remove our database table
 - Remove options:
*/

// Remove options
$arr_options = array(
     'robismslogin_username',
     'robismslogin_password',
     'robismslogin_from',
     'robismslogin_domain',
     'robismslogin_otp_resend_time',
     'robismslogin_otp_resend_max',
     'robismslogin_hide_email',
);

foreach ($arr_options as $one_option) {
    delete_option($one_option);
}

global $wpdb;

// Remove database tables
$table_name = $wpdb->prefix . 'robismslogin_otp';
$wpdb->query("DROP TABLE IF EXISTS $table_name");


// And we are done.
