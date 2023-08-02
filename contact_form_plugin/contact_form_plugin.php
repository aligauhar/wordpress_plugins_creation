<?php
/*
Plugin Name: Custom Contact Form
Description: A simple custom contact form plugin for WordPress.
Version: 1.0
Author: Ali Gauhar
License: AGK
Text Domain: custom-contact-form
*/

function custom_contact_form_shortcode() {
    ob_start();
    ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="custom_contact_form_submit">
        <?php wp_nonce_field('custom_contact_form'); ?>

        <label for="cf_name">Name:</label>
        <input type="text" name="cf_name" required>

        <label for="cf_email">Email:</label>
        <input type="email" name="cf_email" required>

        <label for="cf_message">Message:</label>
        <textarea name="cf_message" required></textarea>

        <input type="submit" value="Submit">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_contact_form', 'custom_contact_form_shortcode');

function custom_create_contact_submission_post_type() {
    register_post_type('contact_submission',
        array('labels' => array(
                'name' => 'Contact Submissions',
                'singular_name' => 'Contact Submission',
            ),'public' => false,'show_ui' => true,'supports' => array('title', 'editor'),
        )
    );
}
add_action('init', 'custom_create_contact_submission_post_type');

function custom_contact_form_process() {
    if (isset($_POST['action']) && $_POST['action'] === 'custom_contact_form_submit') {
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'custom_contact_form')) {
            wp_die('Security check failed.');
        }

        $name = sanitize_text_field($_POST['cf_name']);
        $email = sanitize_email($_POST['cf_email']);
        $message = sanitize_textarea_field($_POST['cf_message']);

        // Save form submission as a custom post type
        $submission_data = array(
            'post_title'   => 'Contact Form Submission from ' . $name,
            'post_content' => 'Email: ' . $email . "\n\n" . 'Message: ' . $message,
            'post_type'    => 'contact_submission',
            'post_status'  => 'publish',
        );

        $submission_id = wp_insert_post($submission_data);

        if (!is_wp_error($submission_id)) {
            // Redirect to the homepage after successful form submission
            wp_redirect(home_url());
            exit;
        } else {
            // If there was an error while saving the submission, display an error message
            wp_die('Error while saving form submission.');
        }
    }
}
add_action('admin_post_custom_contact_form_submit', 'custom_contact_form_process');
add_action('admin_post_nopriv_custom_contact_form_submit', 'custom_contact_form_process');

function custom_contact_form_enqueue_styles() {
    wp_enqueue_style('custom-contact-form-styles', plugin_dir_url(__FILE__) . 'styles.css');
}
add_action('wp_enqueue_scripts', 'custom_contact_form_enqueue_styles');
