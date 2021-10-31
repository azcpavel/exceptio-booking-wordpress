<?php

function exceptiobookingwordpress_settings_init()
{
	// register a new setting for "wporg" page
    register_setting('exceptiobookingwordpress', 'exceptiobookingwordpress_migration');
 
    // register a new section API details
    add_settings_section(
        'exceptiobookingwordpress_settings_section',
        'RobiSMSLogin Settings', 'exceptiobookingwordpress_settings_section_callback',
        'exceptiobookingwordpress'
    ); 
    
    add_settings_field(
        'exceptiobookingwordpress_username_field',
        'Username *', 'exceptiobookingwordpress_username_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_password_field',
        'Password *', 'exceptiobookingwordpress_password_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_from_field',
        'From *', 'exceptiobookingwordpress_from_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_domain_field',
        'API Domain * <span class="help-text">(with http:// or https://)</span>', 'exceptiobookingwordpress_domain_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_otp_resend_time_field',
        'OTP Resend Time * <span class="help-text">(Munites)</span>', 'exceptiobookingwordpress_otp_resend_time_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_otp_resend_max_field',
        'MAX Resend Time * <span class="help-text">(in a hour)</span>', 'exceptiobookingwordpress_otp_resend_max_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );
    add_settings_field(
        'exceptiobookingwordpress_hide_email_field',
        'Hide Email Option *', 'exceptiobookingwordpress_hide_email_field_callback',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_settings_section'
    );

    // register a new section migration
    add_settings_section(
        'exceptiobookingwordpress_migration_section',
        'RobiSMSLogin Migration', 'exceptiobookingwordpress_migration_section_callback',
        'exceptiobookingwordpress_migration'
    );

    add_settings_field(
        'exceptiobookingwordpress_user_metakey_field',
        'User META KEY *', 'exceptiobookingwordpress_user_metakey_field_callback',
        'exceptiobookingwordpress_migration',
        'exceptiobookingwordpress_migration_section'
    );
}

// section content cb
function exceptiobookingwordpress_settings_section_callback() {
    echo '<p>RobiSMSLogin API Details.</p>';
}

// section content cb
function exceptiobookingwordpress_migration_section_callback() {
    echo '<p>RobiSMSLogin Migration will copy the user meta value from other meta key.</p>';
}
 
// field content cb
function exceptiobookingwordpress_username_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_username');
    // output the field
    ?>
    <input type="text" name="exceptiobookingwordpress_username" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_password_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_password');
    // output the field
    ?>
    <input type="text" name="exceptiobookingwordpress_password" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_from_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_from');
    // output the field
    ?>
    <input type="text" name="exceptiobookingwordpress_from" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_domain_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_domain');
    // output the field
    ?>
    <input type="text" name="exceptiobookingwordpress_domain" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_otp_resend_time_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_otp_resend_time');
    // output the field
    ?>
    <input type="number" min="2" name="exceptiobookingwordpress_otp_resend_time" placeholder="2" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_otp_resend_max_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_otp_resend_max');
    // output the field
    ?>
    <input type="number" min="5" name="exceptiobookingwordpress_otp_resend_max" placeholder="5" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" required>
    <?php
}

function exceptiobookingwordpress_hide_email_field_callback() {    
    $setting = get_option('exceptiobookingwordpress_hide_email');
    // output the field
    ?>
    <select name="exceptiobookingwordpress_hide_email">
        <option value="0" <?php echo ((esc_attr($setting) == 0) ? 'selected' : '');?> >No</option>
        <option value="1" <?php echo ((esc_attr($setting) == 1) ? 'selected' : '');?> >Yes</option>
    </select>    
    <?php
}

function exceptiobookingwordpress_user_metakey_field_callback(){    
    ?>
    <input type="text" name="exceptiobookingwordpress_user_metakey" id="exceptiobookingwordpress_user_metakey" placeholder="WP User META KEY" value="" required>
    <button type="button" class="button button-primary" id="exceptiobookingwordpress_user_metakey_btn" onclick="exceptiobookingwordpress.migrate()">Migrate</button>
    <?php
}

function exceptiobookingwordpress_options_page_html() {
    ?>
    <div class="wrap" id="exceptiobookingwordpress_form">
      <style type="text/css">
          #exceptiobookingwordpress_form .help-text{
            font-size: 10px;
            color: #696969;
          }
      </style>      
      <form action="<?php echo admin_url( '?page=exceptiobookingwordpress&exceptiobookingwordpress-setup=1');?>" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        //settings_fields( 'exceptiobookingwordpress_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'exceptiobookingwordpress' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
      <div id="exceptiobookingwordpress_migration">
        <?php
        // output security fields for the registered setting "wporg_options"
        do_settings_sections( 'exceptiobookingwordpress_migration' );  
        ?>
      </div>
      <div>Developed by <a href="https://exceptionsolutions.com/" target="_blank" style="color:#F25C27;">Exception Solutions</a></div>
    </div>
    <?php
}
function exceptiobookingwordpress_options_page() {
    add_menu_page(
        'RobiSMSLogin',
        'RobiSMSLogin',
        'manage_options',
        'exceptiobookingwordpress',
        'exceptiobookingwordpress_options_page_html',
        'dashicons-smartphone',
        20
    );
}

function exceptiobookingwordpress_action_links ( $actions ) {
   $mylinks = array(
      '<a href="' . admin_url( '?page=exceptiobookingwordpress' ) . '">Settings</a>',
   );
   $actions = array_merge( $actions, $mylinks );
   return $actions;
}

function exceptiobookingwordpress_enqueuescripts(){
    wp_enqueue_script('robi-sms-login', plugins_url(RobiSMSLogin_DIR.'/js/exceptiobookingwordpress.js'), array('jquery'));
    wp_localize_script('robi-sms-login', 'exceptiobookingwordpress', array(
        'debug' => ((RobiSMSLogin_DEBUG) ? 'true' : 'false'),
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'resend_time' => get_option('exceptiobookingwordpress_otp_resend_time'),
        'site_url' => get_site_url(),
        'hide_email' => get_option('exceptiobookingwordpress_hide_email'),
    ));
}

function exceptiobookingwordpress_check_db_table(){
    global $wpdb;
    $table = $wpdb->prefix.RobiSMSLogin_OTP_TABLE;    
    $check_table = $wpdb->get_results("SHOW TABLES LIKE '{$table}'",OBJECT);    
    if(count($check_table) == 0){
        $rows_affected = $wpdb->query("
            CREATE TABLE `{$table}`(
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `message_id` varchar(20) NULL,
                `phone` varchar(18) NOT NULL,
                `otp` varchar(6) NOT NULL,
                `created_at` timestamp default current_timestamp
            )ENGINE=InnoDB;
        ");
    }
    return 1;
}

function exceptiobookingwordpress_phone_login_html()
{
    require_once plugin_dir_path( __FILE__ ).'/login-form.php';
}

function exceptiobookingwordpress_hide_login_email_html(){
    require_once plugin_dir_path( __FILE__ )."/login-form-hide.php";
}

function exceptiobookingwordpress_user_password_reset_html() {
    require_once plugin_dir_path( __FILE__ )."/reset-password-form.php";
}

function exceptiobookingwordpress_hide_password_reset_email_html(){
    require_once plugin_dir_path( __FILE__ )."/reset-password-form-hide.php";
}

function exceptiobookingwordpress_register_html(){
    require_once plugin_dir_path( __FILE__ )."/register-form.php";
}

function exceptiobookingwordpress_hide_register_html(){
    require_once plugin_dir_path( __FILE__ )."/register-form-hide.php";
}

function exceptiobookingwordpress_user_profile_html( $user ) {
    if(gettype($user) == "string" && $user == ""){
        $user_id = get_current_user_id();
        if($user_id > 0){
            $user = get_user_by( 'id', $user_id );
        }
    }

    require_once plugin_dir_path( __FILE__ )."/save-form.php";
}

function save_exceptiobookingwordpress_user_profile_fields( $user_id ){
    if(gettype($user_id) == "string" && $user_id == ""){
        $user_id = get_current_user_id();        
    }

    if ((empty( $_POST['save-account-details-nonce']) || ! wp_verify_nonce( $_POST['save-account-details-nonce'], 'save_account_details')) && ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) )) {
        return;
    }
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }

    update_user_meta( $user_id, 'exceptiobookingwordpress_phone', sanitize_text_field($_POST['exceptiobookingwordpress_phone']) );
}
?>