<?php
$config = array(
	'title' => sprintf( esc_html__('Page General Options','wt_admin'),THEME_NAME),
	'id' => 'page_general',
	'pages' => array('page','post'),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'low',
);
function get_sidebar_options(){
	$sidebars = wt_get_option('sidebar','sidebars');
	if(!empty($sidebars)){
		$sidebars_array = explode(',',$sidebars);
		
		$options = array();
		foreach ($sidebars_array as $sidebar){
			$options[$sidebar] = $sidebar;
		}
		return $options;
	}else{
		return array();
	}
}
$options = array(
	array(
		"name" => esc_html__("Page Intro Area Type",'wt_admin'),
		"desc" => esc_html__("Choose which type of header area you want to display on this page. Static images / videos are setted in the \"Featured Image\" / \"Whoathemes Featured Video\" areas.",'wt_admin'),
		"id" => "_intro_type",
		"options" => array(
			"default" => "Default",
			"title" => "Title only",
			"custom" => "Custom text only",
			"title_custom" => "Title with custom text",
			//"slideshow" => "Slideshow",
			/*"static_image" => "Static Image",
			"static_video" => "Static Video",*/
			"disable" => "Disable",
		),
		"default" => "default",
		"chosen" => "true", 
		"type" => "wt_select",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "intro_title",
		"group_class" => "intro_type",
	),
	array(
		"name" => esc_html__("Page Intro Custom Title",'wt_admin'),
		"desc" => esc_html__('If you enter a text here, this will override the default header title.','wt_admin'),
		"id" => "_custom_title",
		"default" => "",
		"class" => 'full',
		"type" => "wt_text"		
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "intro_text",
		"group_class" => "intro_type",
	),
	array(
		"name" => esc_html__("Page Intro Custom Text",'wt_admin'),
		"desc" => esc_html__('If you enter a text here, this will override your default header custom text only if custom text option above is selected.','wt_admin'),
		"id" => "_custom_introduce_text",
		"rows" => "2",
		"default" => "",
		"type" => "wt_textarea"
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "intro_slideshow",
		"group_class" => "intro_type",
	),
	array(
		"name" => esc_html__("SlideShow Type",'wt_admin'),
		"desc" => esc_html__("Select which type of slideshow you want on this page/post.",'wt_admin'),
		"id" => "_slideshow_type",
		"prompt" => esc_html__("Choose Slideshow Type",'wt_admin'),
		"default" => '',
		"options" => array(
			"rev" => esc_html__('Revolution Slider','wt_admin'),
			"flex" => esc_html__('Flex Slider','wt_admin'),
			"nivo" => esc_html__('Nivo Slider','wt_admin'),
			"cycle" => esc_html__('Cycle Slider','wt_admin'),
		),
		"type" => "wt_select",
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "slideshow_rev",
		"group_class" => "slideshow_type",
	),
	array(
		"name" => esc_html__("Rev SlideShow Type",'wt_admin'),
		"prompt" => esc_html__("Choose Slideshow Type",'wt_admin'),
		"desc" => esc_html__("Select which type of slideshow you want on this page/post.",'wt_admin'),
		"id" => "_rev_slideshow",
		"type" => "wt_selectRev",
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "slideshow_layerS",
		"group_class" => "slideshow_type",
	),
	array(
		"name" => esc_html__("Layer SlideShow Type",'wt_admin'),
		"prompt" => esc_html__("Choose Slideshow Type",'wt_admin'),
		"desc" => esc_html__("Select which type of slideshow you want on this page/post.",'wt_admin'),
		"id" => "_layer_slideshow",
		"type" => "wt_selectLayerS",
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"name" => esc_html__("Disable Breadcrumbs",'wt_admin'),
		"desc" => esc_html__('This option disables breadcrumbs on a page/post.','wt_admin'),
		"id" => "_disable_breadcrumb",
		"label" => "Check to disable breadcrumbs on this post",
		"default" => "",
		"type" => "wt_tritoggle"
	),	
	array(
		"name" => esc_html__("Top section margin",'wt_admin'),
		"id" => "_top_margins",
		"min" => "0",
		"max" => "150",
		"step" => "1",
		"unit" => 'px',
		"default" => "0",
		"type" => "wt_range",
	),
	
	array(
		"name" => esc_html__("Bottom section margin",'wt_admin'),
		"id" => "_bottom_margins",
		"min" => "0",
		"max" => "150",
		"step" => "1",
		"unit" => 'px',
		"default" => "0",
		"type" => "wt_range",
	),
	array(
		"name" => esc_html__("Custom Sidebar",'wt_admin'),
		"desc" => esc_html__("If there are any custum sidebars created in your theme option panel then you can choose one of them to be displayed on this.",'wt_admin'),
		"id" => "_sidebar",
		"prompt" => esc_html__("Choose one...",'wt_admin'),
		"default" => '',
		"options" => get_sidebar_options(),
		"type" => "wt_select",
	),
	
);

new wt_metaboxes($config,$options);