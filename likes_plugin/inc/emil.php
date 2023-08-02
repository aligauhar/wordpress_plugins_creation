<?php // two types of hooks action and filters
// filters return data

function send_mail(){
    global $post;
    $author = $post->author;
    $name = get_the_author_meta('display_name', $author);
    $email = get_the_athor_meta('user_email',$author);
    $title = $post->post_title;
    $edit = get_edit_post_link($ID);
    $to[] =  sprintf('%s <%s>', $title);
    $message = sprintf('Published: %s', $title);
    $message .=sprintf('View: %s', $permalink);
    $header[] = '';
    wp_mail($to, $subject, $message, $header);

}
// runns when the post is published
// send mail to the user
add_action('publish_post','send_mail');
?>