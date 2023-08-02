<?php
/*
*Plugin Name: Like Plugin
* Plugin URI: 
* Author: Ali Gauhar
* Discription: Simple Post like dislike system
*version: 1.0.0
*Licence:GPL2
*Licence URI:https://www.gnu.org/licenses/gpl-2.0.html
*Text Domain: wporg
*/
// if file is called directly , abbrot
if(!defined('WPINC'))
{
    die('cant access directly');
}


// defining the constants

if(!defined('AGK_PLUGIN_VERSION')){
    define('AGK_PLUGIN_VERSION', '1.0.0');
}


if(!defined('AGK_PLUGIN_DIR')){
    define('AGK_PLUGIN_DIR', plugin_dir_url( __FILE__));
}


// call the funciton like this
if(!function_exists('AGK_function_1')){
    function AGK_function_1(){
    }
}


if(!function_exists('AGK_Script')){
    function AGK_Script(){
        wp_enqueue_style('wpac-css',AGK_PLUGIN_DIR.'assets/css/style.css');
        wp_enqueue_script('wpac-js',AGK_PLUGIN_DIR.'assets/js/main.js', 'jQuery', '1.0.0', true );
        wp_enqueue_script('wpac-ajax',AGK_PLUGIN_DIR.'assets/js/ajax.js', 'jQuery', '1.0.0', true );
        wp_localize_script('wpac-ajax', 'wpac_ajax_url', array('ajax_url' => admin_url('admin-ajax.php')));

    }
    add_action('wp_enqueue_scripts', 'AGK_Script');
}


// Require the setting_like.php file
require plugin_dir_path(__FILE__) . '/inc/setting_like.php';

// database storing file
require plugin_dir_path(__FILE__) . '/inc/db.php';
// btn creation file
require plugin_dir_path(__FILE__) . '/inc/btn.php';



//WPAC Plugin AJAx function
function wpac_like_btn_ajax_action()
{   // access the database
    global $wpdb;
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = $wpdb->prefix . "AGK_Like_dislike_system";
    if (isset($_POST['pid']) && isset($_POST['uid'])) {
        $user_id = $_POST['uid'];
        $post_id = $_POST['pid'];
        $check_like = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id = '$user_id' AND post_id = '$post_id' AND like_count=1 ");
        if ($check_like > 0) {
            echo "Sorry, but you have already liked this post!";
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $_POST['pid'],
                    'user_id' => $_POST['uid'],
                    'like_count' => 1,
                ),
                array('%d', '%d', '%d')
            );
            if ($wpdb->insert_id) {
                echo "Thank you for loving this post!";
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_wpac_like_btn_ajax_action', 'wpac_like_btn_ajax_action');
add_action('wp_ajax_nopriv_wpac_like_btn_ajax_action', 'wpac_like_btn_ajax_action');

function register_like_shortcode() {
    add_shortcode('like', 'AGK_like_dislike_button');
}
add_action('init', 'register_like_shortcode');
function wpac_show_like_count($content){
    global $wpdb;
    $table_name = $wpdb->prefix . "AGK_Like_dislike_system";
    $post_id = get_the_ID();
    $like_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE  post_id = '$post_id' AND like_count=1 ");
    $like_count_result = "<center> This post has been liked <strong>".$like_count."</strong>, time(s)</center>";

    $content .=$like_count_result;

    return $content;
}
add_filter('like', 'wpac_show_like_count' );
?>