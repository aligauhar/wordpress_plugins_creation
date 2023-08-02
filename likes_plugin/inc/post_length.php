
<?php
// to show limited words in post
function filters($word){
    return 10;
}
add_filter('excerpt_length', 'filters');

// to show limited words and show more option
function filtermore($more){
    $more = '<a href="'.get_the_permalink().'">More</a>';
    return $more;
}
add_filter('excerpt_more', 'filtermore');

?>