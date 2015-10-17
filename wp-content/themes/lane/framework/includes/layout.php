<?php 
global $layout;
if (is_front_page()) {
	$layout = 'full';	
}
elseif (!is_search() && !is_404() && $post->post_type == 'wt_portfolio') {
		$layout = get_post_meta($post->ID, '_sidebar_alignment', true);
	if((empty($layout) || $layout == 'default') && !is_search()){
		$layout= wt_get_option('portfolio','layout');
	}
	elseif (is_search()) {
		$layout= wt_get_option('blog','layout');
	}
}
elseif (is_page_template( 'template_blog.php' )  || is_tag() ) {
	$layout= wt_get_option('blog','layout');
}
elseif (is_single()) {
	$layout = get_post_meta($post->ID, '_sidebar_alignment', true);
	if(empty($layout) || $layout == 'default'){
		$layout= wt_get_option('blog','single_layout');
	}
}
elseif (is_archive()) {
	if (is_tax('wt_portfolio')) {
		$layout = wt_get_option('portfolio','layout');
	}
	elseif ((wt_get_option('general', 'woocommerce')) && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
		$layout = 'right';
	}
	else {
		$layout = 'right';
	}
}
elseif (is_search() ) {
	$layout= wt_get_option('blog','layout');
}
elseif (is_page_template('template_left_sidebar.php') ) {
    $layout = 'left';
}
elseif (is_page_template('template_right_sidebar.php') ) {
    $layout = 'right';
}
elseif (is_page_template('template_fullwidth.php') || is_404()) {
	$layout = 'full';
}
else {
	$layout = 'full';
}
?>