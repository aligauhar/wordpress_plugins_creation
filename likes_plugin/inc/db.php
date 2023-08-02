<?php
// Function to create the custom table on plugin activation
 
function AGK_likes_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . "AGK_Like_dislike_system";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time timestamp DEFAULT '0000-00-00 00:00:00' NOT NULL,
        user_id mediumint(9) NOT NULL,
        post_id mediumint(9) NOT NULL,
        like_count mediumint(9) NOT NULL,
        dislike_count mediumint(9) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Register the AGK_likes_table function to run on plugin activation
register_activation_hook(__FILE__, 'AGK_likes_table');
?>