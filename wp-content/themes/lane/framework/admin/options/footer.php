<?php
if (! function_exists("wt_footer_column_option")) {
	function wt_footer_column_option($value, $default) {
		
		echo '<script type="text/javascript" src="' . THEME_ADMIN_ASSETS_URI . '/js/theme-footer-column.js"></script>';
		echo '<div class="theme-footer-columns">';
		echo '<a href="#" rel="1"><img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/1.png" /></a>';
		echo '<a href="#" rel="2"><img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/2.png" /></a>';
		echo '<a href="#" rel="3"><img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/3.png" /></a>';
		echo '<a href="#" rel="4"><img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/4.png" /></a>';
		echo '<a href="#" rel="6"><img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/5.png" /></a>';
		echo '<a href="#" rel="col-9-3">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/three_fourth_one_fourth.png" /></a>';
		echo '<a href="#" rel="col-3-9">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_fourth_three_fourth.png" /></a>';
		echo '<a href="#" rel="col-2-5-5">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_fifth_two_fifth_two_fifth.png" /></a>';
		echo '<a href="#" rel="col-3-3-6">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_fourth_one_fourth_one_half.png" /></a>';
		echo '<a href="#" rel="col-6-3-3">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_half_one_fourth_one_fourth.png" /></a>';
		echo '<a href="#" rel="col-3-6-3">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_fourth_one_half_one_fourth.png" /></a>';
		echo '<a href="#" rel="col-4-8">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/one_third_two_third.png" /></a>';
		echo '<a href="#" rel="col-8-4">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/three_fifth_two_fifth.png" /></a>';
		echo '<a href="#" rel="col-5-7">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/two_fifth_three_fifth.png" /></a>';
		echo '<a href="#" rel="col-5-5-2">
			<img src="' . THEME_ADMIN_ASSETS_URI . '/images/footer_column/two_fifth_two_fifth_one_fifth.png" /></a>';
		echo '<input type="hidden" value="' . $default . '" name="' . $value['id'] . '" id="' . $value['id'] . '"/>';
		echo '</div>';
	}
}
$wt_options = array(
	array(
		"name" => esc_html__("Footer",'wt_admin'),
		"type" => "wt_title"
	),
	array(
		"name" => esc_html__("Footer",'wt_admin'),
		"type" => "wt_open"
	),
		array(
			"name" => esc_html__("Footer Top",'wt_admin'),
			"desc" => esc_html__("If the button is set to OFF then the footer top area won't be displayed.",'wt_admin'),
			"id" => "footer_top",
			"default" => false,
			"type" => "wt_toggle"
		),
		array(
			"name" => esc_html__("Footer",'wt_admin'),
			"desc" => esc_html__("If the button is set to OFF then the footer area won't be displayed.",'wt_admin'),
			"id" => "footer",
			"default" => false,
			"type" => "wt_toggle"
		),
		array(
			"name" => esc_html__("Footer Bottom",'wt_admin'),
			"desc" => esc_html__("If the button is set to OFF then the sub footer area won't be displayed.",'wt_admin'),
			"id" => "sub_footer",
			"default" => true,
			"type" => "wt_toggle"
		),
		array(
			"name" => esc_html__("Footer Column Layout",'wt_admin'),
			"desc" => esc_html__("Choose the footer column layout.",'wt_admin'),
			"id" => "column",
			"function" => "wt_footer_column_option",
			"default" => "1",
			"type" => "wt_custom"
		),
		array(
			"name" => esc_html__("Copyright Text",'wt_admin'),
			"desc" => esc_html__("Here you can enter the copyright text which is displayed in the sub footer.",'wt_admin'),
			"id" => "copyright",
			"default" => "&copy; 2015 <span>Sleek</span>. All rights reserved. Developed by <a href=\"http://themeforest.net/user/whoathemes\" target=\"_blank\">WhoaThemes</a>",
			"rows" => 4,
			"type" => "wt_textarea"
		),
	array(
		"type" => "wt_close"
	),
	array(
		"type" => "wt_reset"
	),
);
return array(
	'auto' => true,
	'name' => 'footer',
	'options' => $wt_options
);