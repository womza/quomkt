<?php
$config = array(
	'title' => sprintf( esc_html__('%s Featured Video','wt_admin'),THEME_NAME),
	'id' => 'featured_video',
	'pages' => array('page', 'post', 'portfolio'),
	'callback' => '',
	'context' => 'side',
	'priority' => 'default',
);
$options = array(
	array(
		"name" => esc_html__("Paste video link below:",'wt_admin'),
		"desc" => esc_html__("Accepted videos: YouTube, Vimeo, Daylimotion, Metacafe",'wt_admin'),
		"id" => "_featured_video",
		"class" => "large_width featured_video",
		"default" => "",
		"type" => "wt_featured_video"
	),	
);
new wt_metaboxes($config,$options);