<?php
$wt_options = array(
	array(
		"class" => "nav-tab-wrapper",
		"default" => '',
		"options" => array(
			"homepage"    => esc_html__('Homepage','wt_admin'),
			"header"      => esc_html__('Header','wt_admin'),
			"breadcrumbs" => esc_html__('Breadcrumbs','wt_admin'),
			"content"     => esc_html__('Content','wt_admin'),
			"footer"      => esc_html__('Footer','wt_admin'),
		),
		"type" => "wt_navigation",
	),
	
	array(
		"type" => "wt_group_start",
		"group_id" => "homepage",
	),
		array(
			"name" => esc_html__("Background Type",'wt_admin'),
			"type" => "wt_open",
		),
			array(
				"name" => esc_html__("",'wt_admin'),
				"one_col" => "true",
				"id" => "background_type",
				"default" => 'image_bg',
				"options" => array(
					//"revSlider" => esc_html__('Revolution Slider Background','wt_admin'),
					"pattern"   => esc_html__('Pattern Background','wt_admin'),
					"parallax"  => esc_html__('Parallax Image Background','wt_admin'),
					"image_bg"  => esc_html__('Image Background','wt_admin'),
					"slideshow" => esc_html__('Slideshow','wt_admin'),
					"video"     => esc_html__('Video','wt_admin'),
				),
				"chosen" => "true",
				"type" => "wt_select",
			),	
			
		array(
			"type" => "wt_close"
		),
		array(
			"type" => "wt_reset"
		),
			/*
			array(
				"open_class" => "revSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "rev_bg",
				),
					array(
						"name" => esc_html__("Revolution Slider Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(	
							"name" => esc_html__('Revolution Slider', 'wt_admin'),
							"desc" => esc_html__("Select one of the Revolution Sliders. The \"Revolution Slider\" plugin should be installed and the sliders should be created / imported first.",'wt_admin'),
							"id" => "rev_slideshow",
							"prompt" => esc_html__("Choose Revolution Slider...",'wt_admin'),
							"type" => "wt_selectRev"
					),	
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			), 
			*/
			array(
				"open_class" => "patternSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "pattern_bg",
				),
					array(
						"name" => esc_html__("Pattern Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(
							"name" => esc_html__("Pattern Background Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "pattern_bg",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Pattern Background Position",'wt_admin'),
							"desc" => "Choose the background image position.",
							"id" => "pattern_position_x",
							"default" => 'center',
							"options" => array(
								"left" => esc_html__('Left','wt_admin'),
								"center" => esc_html__('Center','wt_admin'),
								"right" => esc_html__('Right','wt_admin'),
							),
							"type" => "wt_select",
						),
						array(
							"name" => esc_html__("Pattern Background Repeat",'wt_admin'),
							"desc" => "Choose the background image repeat style.",
							"id" => "pattern_repeat",
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
							"name" => esc_html__("Pattern Background Color",'wt_admin'),
							"desc" => esc_html__("Here you can choose a specific page background color. Set it to transparent in order to disable this.",'wt_admin'),
							"id" => "pattern_bg_color",
							"default" => "",
							"type" => "wt_color"		
						),
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			),	
			array(
				"open_class" => "imageSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "image_bg",
				),
					array(
						"name" => esc_html__("Image Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(
							"name" => esc_html__("Background Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "image_bg",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Background Image 'X' Position",'wt_admin'),
							"desc" => "Choose the background image 'X' position.",
							"id" => "image_position_x",
							"default" => 'center',
							"options" => array(
								"left" => esc_html__('Left','wt_admin'),
								"center" => esc_html__('Center','wt_admin'),
								"right" => esc_html__('Right','wt_admin'),
							),
							"type" => "wt_select",
						),
						array(
							"name" => esc_html__("Background Image 'Y' Position",'wt_admin'),
							"desc" => "Choose the background image 'Y' position.",
							"id" => "image_position_y",
							"default" => 'top',
							"options" => array(
								"top" => esc_html__('Top','wt_admin'),
								"center" => esc_html__('Center','wt_admin'),
								"bottom" => esc_html__('Bottom','wt_admin'),
							),
							"type" => "wt_select",
						),
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			),
			array(
				"open_class" => "parallaxSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "parallax_bg",
				),
					array(
						"name" => esc_html__("Parallax Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(
							"name" => esc_html__("Parallax Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "parallax_bg",
							"default" => "",
							"type" => "wt_upload"
						),
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			),
			array(
				"open_class" => "slideshowSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "slideshow_bg",
				),
					array(
						"name" => esc_html__("Slideshow Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(
							"name" => esc_html__("Slideshow Background Image 1",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "slide_bg_1",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Slideshow Background Image 2",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "slide_bg_2",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Slideshow Background Image 3",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "slide_bg_3",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Slideshow Background Image 4",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "slide_bg_4",
							"default" => "",
							"type" => "wt_upload"
						),
						array(
							"name" => esc_html__("Slideshow Background Image 5",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "slide_bg_5",
							"default" => "",
							"type" => "wt_upload"
						),
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			),	
			array(
				"open_class" => "videoSwitch",
				"type" => "wt_open_group",
			),		
				array(
					"type" => "wt_group_start",
					"group_id" => "video_bg",
				),
					array(
						"name" => esc_html__("Video Background",'wt_admin'),
						"type" => "wt_open"
					),		
						array(
							"name" => esc_html__("Video Link",'wt_admin'),
							"desc" => esc_html__("You need to paste the full URL (including ") . "<code>http://</code>" . esc_html__("), of the video to be used as a background video. Only 'YouTube' accepted.",'wt_admin'),
							"id" => "video_link",
							"default" => "",
							"type" => "wt_text"
						),
						array(
							"name" => esc_html__("Show Video Controls",'wt_admin'),
							"desc" => esc_html__("This option enables video controls.",'wt_admin'),
							"id" => "video_controls",
							"default" => true,
							"type" => "wt_toggle"
						),
						array(
							"name" => esc_html__("Background Mobile",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
							"id" => "video_mobile_bg",
							"default" => "",
							"type" => "wt_upload"
						),
					array(
						"type" => "wt_close"
					),
					array(
						"type" => "wt_reset"
					),
				array(
					"type" => "wt_group_end",
				),
			array(
				"type" => "wt_close_group"
			),						
		array(
			"type" => "wt_group_end",
		),
		
	array(
		"type" => "wt_group_start",
		"group_id" => "header",
	),
		array(
			"name" => esc_html__("Header Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Header Background Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "header_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Header Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "header_position_x",
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
			"id" => "header_repeat",
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
			"desc" => esc_html__("Here you can choose a specific background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "header_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"type" => "wt_close"
		),
		array(
			"type" => "wt_reset"
		),
	array(
		"type" => "wt_group_end",
	),	
		
	array(
		"type" => "wt_group_start",
		"group_id" => "breadcrumbs",
	),
		array(
			"name" => esc_html__("Breadcrumbs Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Breadcrumbs Background Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "breadcrumbs_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Breadcrumbs Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "breadcrumbs_position_x",
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
			"id" => "breadcrumbs_repeat",
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
			"desc" => esc_html__("Here you can choose a specific background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "breadcrumbs_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"name" => esc_html__("Breadcrumbs Text Color",'wt_admin'),
			"desc" => esc_html__("Here you can choose a specific text color.",'wt_admin'),
			"id" => "breadcrumbs_text_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"type" => "wt_close"
		),
		array(
			"type" => "wt_reset"
		),
	array(
		"type" => "wt_group_end",
	),
	
		
	array(
		"type" => "wt_group_start",
		"group_id" => "content",
	),
		array(
			"name" => esc_html__("Content Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Content Background Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "content_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Content Background Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "content_position_x",
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
			"id" => "content_repeat",
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
			"desc" => esc_html__("Here you can choose a specific background color. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "content_bg_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"type" => "wt_close"
		),
		array(
			"type" => "wt_reset"
		),
	array(
		"type" => "wt_group_end",
	),
	
	array(
		"type" => "wt_group_start",
		"group_id" => "footer",
	),
	
		array(
			"name" => esc_html__("Footer Top Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Custom Footer Top Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "footer_top_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Top Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "footer_top_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Top Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "footer_top_repeat",
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
			"desc" => esc_html__("If you specify a color below, this option will override the global configuration. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "footer_top_color",
			"default" => "",
			"type" => "wt_color"		
		),

		array(
			"type" => "wt_close"
		),
		array(
			"name" => esc_html__("Footer Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Custom Footer Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "footer_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "footer_position_x",
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
			"id" => "footer_repeat",
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
			"id" => "footer_color",
			"default" => "",
			"type" => "wt_color"		
		),
		
		array(
			"type" => "wt_close"
		),
		array(
			"name" => esc_html__("Footer Bottom Background",'wt_admin'),
			"type" => "wt_open"
		),
		array(
			"name" => esc_html__("Custom Footer Bottom Image",'wt_admin'),
							"desc" => esc_html__("You can paste the full URL of the image (including ") . "<code>http://</code>" . esc_html__("), to be used as a background image, or you can simply upload it using the button.",'wt_admin'),
			"id" => "footer_bottom_bg",
			"default" => "",
			"type" => "wt_upload"
		),
		array(
			"name" => esc_html__("Footer Bottom Position",'wt_admin'),
			"desc" => "Choose the background image position.",
			"id" => "footer_bottom_position_x",
			"default" => 'center',
			"options" => array(
				"left" => esc_html__('Left','wt_admin'),
				"center" => esc_html__('Center','wt_admin'),
				"right" => esc_html__('Right','wt_admin'),
			),
			"type" => "wt_select",
		),
		array(
			"name" => esc_html__("Footer Bottom Repeat",'wt_admin'),
			"desc" => "Choose the background image repeat style.",
			"id" => "footer_bottom_repeat",
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
			"desc" => esc_html__("If you specify a color below, this option will override the global configuration. Set it to transparent in order to disable this.",'wt_admin'),
			"id" => "footer_bottom_color",
			"default" => "",
			"type" => "wt_color"		
		),
		array(
			"type" => "wt_close"
		),
		array(
			"type" => "wt_reset"
		),
	array(
		"type" => "wt_group_end",
	),	
);
return array(
	'auto' => true,
	'name' => 'background',
	'options' => $wt_options
);