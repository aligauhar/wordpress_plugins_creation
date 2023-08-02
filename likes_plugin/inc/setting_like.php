<?php
// Register the Like/Dislike settings page
function register_like_fn(){
    add_theme_page('Like\Dislike Menu', 'Like|Dislike Setting', 'manage_options', 'like_dislike_settings', 'like_dislike_settings', 30);
}
add_action('admin_menu', 'register_like_fn');

// Callback for the Like/Dislike settings page
function like_dislike_settings(){
    if(!is_admin()){
        return;
    }
    ?>
    <div class="wrap">
        <h1><?=esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // Output nonce and settings field for the form
            settings_fields('like_dislike_settings');
            // Output sections and fields for the form
            do_settings_sections('like_dislike_settings');
            // Output the "Save Changes" button
            submit_button('Save Changes');
            ?>
        </form>
    </div>
    <?php
}

// Callback for the Like/Dislike settings fields
function like_fn(){
    // Register settings for the Like and Dislike button labels
    register_setting('like_dislike_settings', 'like_btn_label');
    register_setting('like_dislike_settings', 'dislike_btn_label');

    // Add the Like/Dislike Button Labels section
    add_settings_section('like_dislike_label_settings_section', 'Like/Dislike Button Labels', 'like_dislike_plugin_settings_section_cb', 'like_dislike_settings');

    // Add the Like Button Label field
    add_settings_field('like_label_field', 'Like Button Label', 'like_plugin_label_field_cb', 'like_dislike_settings', 'like_dislike_label_settings_section');

    // Add the Dislike Button Label field
    add_settings_field('dislike_label_field', 'Dislike Button Label', 'dislike_plugin_label_field_cb', 'like_dislike_settings', 'like_dislike_label_settings_section');
}
add_action('admin_init', 'like_fn');

// Callback for the Like/Dislike plugin settings section
function like_dislike_plugin_settings_section_cb(){
    echo '<p> Define Button Labels </p>';
}

// Callback for the Like Button Label field
function like_plugin_label_field_cb(){
    $like_setting = get_option('like_btn_label');
    ?>
    <input type="text" name="like_btn_label" value="<?php echo isset($like_setting) ? esc_attr($like_setting) : ''; ?>">
    <?php
}

// Callback for the Dislike Button Label field
function dislike_plugin_label_field_cb(){
    $dislike_setting = get_option('dislike_btn_label');
    ?>
    <input type="text" name="dislike_btn_label" value="<?php echo isset($dislike_setting) ? esc_attr($dislike_setting) : ''; ?>">
    <?php
}
