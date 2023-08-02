function wpac_like_btn_ajax(postID, usrid) {
    var post_id = postID;
    var usr_ID = usrid;

    jQuery.ajax({
        url: wpac_ajax_url.ajax_url, // Corrected variable name
        type: 'post',
        data: {
            action: 'wpac_like_btn_ajax_action',
            pid: post_id,
            uid: usr_ID
        },
        success: function(response) {
            jQuery("#wpacAjaxResponse span").html(response);
        }
    });
}
