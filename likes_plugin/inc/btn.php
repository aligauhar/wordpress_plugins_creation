<?php
// creating like dislike button using filter
function AGK_like_dislike_button($content){
    $like_btn_label = get_option('like_btn_label', 'like');
    $dislike_btn_label = get_option('dislike_btn_label', 'dislike');

    $user_id = get_current_user_id();
    $post_id = get_the_ID();

    $like_btn_wrap = '<div class="AGK-button-container">';
    $like_btn = '<a href="javascript:;" onclick="wpac_like_btn_ajax('.$post_id.','.$user_id.')" class="AGK-btn AGK-like-btn">'.$like_btn_label.' </a>';
    $dislike_btn = '<a href="javascript:;" class="AGK-btn AGK-dislike-btn">'.$dislike_btn_label.'</a>';
    $like_btn_wrap_end = '</div>';

$wpac_ajax_response = '<div id= "wpacAjaxResponse" class="wpac-ajax-response"><span></span></div>';

    $content .= $like_btn_wrap;
    $content .= $like_btn;
    $content .= $dislike_btn;
    $content .= $like_btn_wrap_end;
    $content .= $wpac_ajax_response;

    return $content;
}
// this will execute the plugin on every page and post
//add_filter('the_content', 'AGK_like_dislike_button');
add_filter('like', 'AGK_like_dislike_button');
