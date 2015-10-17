<?php 
$config = array(
	'title' => esc_html__('Blog Single Options','wt_admin'),
	'id' => 'single',
	'pages' => array('post'),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'low',
);
$options = array(
	array(
		"name" => esc_html__("Featured Post Entry",'wt_admin'),
		"desc" => esc_html__("Here you can choose to dispaly or not Featured Image/Video/Mp3/Slideshow in Single Blog post only.",'wt_admin'),
		"id" => "_featured_image",
		"default" => '',
		"type" => "wt_tritoggle",
	),
	array(
		"name" => esc_html__("Thumbnail Types",'wt_admin'),
		"desc" => sprintf(esc_html__("Thumbnail Types",'wt_admin'),THEME_NAME),
		"id" => "_thumbnail_type",
		"default" => 'timage',
		"options" => array(
			"timage" => esc_html__('Image','wt_admin'),
			"tvideo" => esc_html__('Video','wt_admin'),
			"tplayer" => esc_html__('Audio','wt_admin'),
			"tslide" => esc_html__('Slide','wt_admin'),
		),
		"type" => "wt_select",
	),
	array(
		"type" => "wt_group_start",
		"group_id" => "thumbnail_player",
		"group_class" => "featured_type",
	),
	array(
		"name" => esc_html__("SoundCloud Link",'wt_admin'),
		"desc" => esc_html__("The SoundCloud url, ex: <b>\"https://soundcloud.com/fiersa/fiersa-besari-roar-katy-perry\"</b> or <b>\"http://api.soundcloud.com/tracks/129129144\"</b>",'wt_admin'),
		"size" => 30,
		"id" => "_thumbnail_player",
		"default" => '',
		"class" => 'full',
		"type" => "wt_text",
	),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_group_start",
		"group_id" => "thumbnail_slide",
		"group_class" => "featured_type",
	),

	array(
		"name" => esc_html__("Slide Type",'wt_admin'),
		"id" => "_slide_type",
		"desc" => esc_html__("Here you can choose the type of slideshow you want to use on this post.",'wt_admin'),
		"default" => 'owl',
		"options" => array(
			"owl" => 'Owl Slider',
			"flex" => 'Flex Slider',
			"nivo" => 'Nivo Slider',
		),
		"type" => "wt_select",
	),
	array(
		"name" => esc_html__("Flex Slide Effect",'wt_admin'),
		"id" => "_flex_slide_effect",
		"desc" => esc_html__("Here you can choose the FLEX slide effect.",'wt_admin'),
		"default" => 'fade',
		"options" => array(
			"fade" => 'Fade',
			"slide" => 'Slide',
		),
		"type" => "wt_select",
	),
	array(
		"name" => esc_html__("Nivo Slide Effect",'wt_admin'),
		"id" => "_slide_effect",
		"desc" => esc_html__("Here you can choose the NIVO slide effect.",'wt_admin'),
		"default" => 'slideInLeft',
		"options" => array(
			"sliceDown" => 'sliceDown',
			"sliceDownLeft" => 'sliceDownLeft',
			"sliceUp" => 'sliceUp',
			"sliceUpLeft" => 'sliceUpLeft',
			"sliceUpDown" => 'sliceUpDown',
			"sliceUpDownLeft" => 'sliceUpDownLeft',
			"fade" => 'fade',
			"fold" => 'fold',
			"random" => 'random',
			"slideInRight" => 'slideInRight',
			"slideInLeft" => 'slideInLeft',
			"boxRandom" => 'boxRandom',
			"boxRain" => 'boxRain',
			"boxRainReverse" => 'boxRainReverse',
			"boxRainGrow" => 'boxRainGrow',
			"boxRainGrowReverse" => 'boxRainGrowReverse',
		),
		"type" => "wt_select",
	),
	array(
		"type" => "wt_group_end",
	),
	array(
		"name" => esc_html__("Layout",'wt_admin'),
		"desc" => esc_html__("Choose the layout for this single page/post.",'wt_admin'),
		"id" => "_sidebar_alignment",
		"default" => 'default',
		"options" => array(
			"default" => esc_html__('Default','wt_admin'),
			"full" => esc_html__('Full Width','wt_admin'),
			"right" => esc_html__('Right Sidebar','wt_admin'),
			"left" => esc_html__('Left Sidebar','wt_admin'),
		),
		"type" => "wt_select",
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
		"name" => esc_html__("Custom Sidebar",'wt_admin'),
		"desc" => esc_html__("If there are any custum sidebars created in your theme option panel then you can choose one of them to be displayed on this.",'wt_admin'),
		"id" => "_sidebar",
		"prompt" => esc_html__("Choose one..",'wt_admin'),
		"default" => '',
		"options" => get_sidebar_options(),
		"type" => "wt_select",
	),
);
new wt_metaboxes($config,$options);