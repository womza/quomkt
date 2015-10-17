<?php
$config = array(
	'title' => sprintf( esc_html__('Page Bg Options','wt_admin'),THEME_NAME),
	'id' => 'page_bg',
	'pages' => array('page','post'),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'low',
);
$options = array(
	array(
		"class" => "nav-tab-wrapper",
		"default" => '',
		"options" => array(
			"header" => esc_html__('Header','wt_admin'),
			"breadcrumbs" => esc_html__('Breadcrumbs','wt_admin'),
			"page" => esc_html__('Page','wt_admin'),
			"footer" => esc_html__('Footer','wt_admin'),
		),
		"type" => "wt_navigation",
	),	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "page",
	),
		array(
			"name" => esc_html__("Page Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_page_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Page Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_page_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Page Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_page_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Page Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific page background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_page_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "header",
	),
		array(
			"name" => esc_html__("Header Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_header_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Header Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_header_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Header Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_header_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Header Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific page background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_header_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "breadcrumbs",
	),	
		array(
			"name" => esc_html__("Breadcrumbs Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_breadcrumbs_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Breadcrumbs Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_breadcrumbs_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Breadcrumbs Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_breadcrumbs_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Breadcrumbs Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific intro background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_breadcrumbs_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"name" => esc_html__("Breadcrumbs Text Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific text color.",'wt_admin'),
			"id" => "_breadcrumbs_text_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "intro",
	),	
		array(
			"name" => esc_html__("Intro Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_intro_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Intro Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_intro_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Intro Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_intro_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Intro Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific intro background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_intro_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"name" => esc_html__("Intro Text Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific intro text color.",'wt_admin'),
			"id" => "_intro_text_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "container",
	),	
		array(
			"name" => esc_html__("Container Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_container_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Container Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_container_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Container Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_container_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Container Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific intro background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_container_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "content",
	),	
		array(
			"name" => esc_html__("Content Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_content_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Content Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_content_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Content Background Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_content_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Content Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific intro background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_content_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_option_group_start",
		"group_id" => "footer",
	),
		array(
			"name" => esc_html__("Footer Top",'wt_admin'),
			"type" => "wt_title",
		),
		array(
			"name" => esc_html__("Footer Top Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_footer_top_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_footer_top_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_footer_top_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Top Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific page background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_footer_top_color",
			"default" => "",
			"type" => "wt_color"		
		),
		
		array(
			"name" => esc_html__("Footer Middle",'wt_admin'),
			"type" => "wt_title",
		),
		array(
			"name" => esc_html__("Footer Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_footer_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_footer_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_footer_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Background Color",'wt_admin'),
			"desc" => esc_html__("If you specify a color below, this option will override the global configuration. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_footer_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		
		
		array(
			"name" => esc_html__("Footer Bottom",'wt_admin'),
			"type" => "wt_title",
		),
		array(
			"name" => esc_html__("Footer Bottom Background Image",'wt_admin'),
			"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "_footer_bottom_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "_footer_bottom_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "_footer_bottom_repeat",
			"default" => 'no-repeat',
			"options" => array(
				"no-repeat" => esc_html__('No Repeat','wt_admin'),
				"repeat" => esc_html__('Repeat','wt_admin'),
				"repeat-x" => esc_html__('Repeat Horizontally','wt_admin'),
				"repeat-y" => esc_html__('Repeat Vertically','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Bottom Background Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific page background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "_footer_bottom_color",
			"default" => "",
			"type" => "wt_color"		
		),
	array(
		"type" => "wt_group_end",
	),	
);

new wt_metaboxes($config,$options);