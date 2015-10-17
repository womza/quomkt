<!DOCTYPE html>
<?php 
if(wt_get_option('general','enable_responsive')){ 
	$responsive = 'responsive ';
} else {
	$responsive = '';
}
$niceScroll   = wt_get_option('general', 'nice_scroll');
$smoothScroll = wt_get_option('general', 'smooth_scroll');
if($smoothScroll) {
	$niceScroll = false; // disable nicescroll if smoothScroll is enabled
}
?>
<!--[if lt IE 7]> <html class="<?php echo esc_attr( $responsive ); ?>no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="<?php echo esc_attr( $responsive ); ?>no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="<?php echo esc_attr( $responsive ); ?>no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<html class="<?php echo esc_attr( $responsive ); ?><?php if($niceScroll):?>wt-nice-scrolling <?php endif; ?><?php if($smoothScroll):?>wt-smooth-scrolling <?php endif; ?>no-js" <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<?php if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        header('X-UA-Compatible: IE=edge,chrome=1'); ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if(wt_get_option('general','enable_responsive')){ ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php } ?>
<?php 
if($favicon = wt_get_option('general','favicon')) { ?>
<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" />
<?php } 
if($favicon_57 = wt_get_option('general','favicon_57')) { ?>
<link rel="apple-touch-icon" href="<?php echo esc_url($favicon_57); ?>" />
<?php } 
if($favicon_72 = wt_get_option('general','favicon_72')) { ?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($favicon_72); ?>" />
<?php } 
if($favicon_114 = wt_get_option('general','favicon_114')) { ?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($favicon_114); ?>" />
<?php } 
if($favicon_144 = wt_get_option('general','favicon_144')) { ?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url($favicon_144); ?>" />
<?php } ?>
<!--[if lt IE 10]>
    <style type="text/css">
    html:not(.is_smallScreen) .wt_animations .wt_animate { visibility:visible;}
    </style>
<![endif]-->
<?php wp_head(); ?>
</head>
<?php
if (is_blog()){
	global $blog_page_id;
	global $post;
	$blog_page_id = wt_get_option('blog','blog_page');
	$post->ID = get_object_id($blog_page_id,'page');
}

/* Sidebar Alignement  */
require_once (THEME_FILES . '/layout.php');

if(!is_search() && !is_404()) {
	$type          = get_post_meta($post->ID, '_intro_type', true);
	$bg            = wt_check_input(get_post_meta($post->ID, '_page_bg', true));
	$bg_position   = get_post_meta($post->ID, '_page_position_x', true);
	$bg_repeat     = get_post_meta($post->ID, '_page_repeat', true);
	$color 		   = get_post_meta($post->ID, '_page_bg_color', true);
	$breadcrumbs   = get_post_meta($post->ID, '_disable_breadcrumb', true);
} else {
	$type          = 'default'; 
	$breadcrumbs   = true;
}
$homeContent    = wt_get_option('general', 'one_page_home');
$show_menu      = wt_get_option('general', 'show_menu');
$stickyHeader   = wt_get_option('general', 'sticky_header');
$noStickyOnSS   = wt_get_option('general', 'no_sticky_on_ss');
$retinaLogo     = wt_get_option('general', 'logo_retina');
$retinaLogoAlt  = wt_get_option('general', 'logo_retina_alt');
$enable_retina  = wt_get_option('general', 'enable_retina');
$animations     = wt_get_option('general','enable_animation');
$pageLoader     = wt_get_option('general','page_loader');
$responsiveNav  = wt_get_option('general', 'responsive_nav');
$generalBcrumbs = wt_get_option('general','disable_breadcrumb');
$menu_type      = 'top';
$theme_style 	= wt_get_option('general', 'theme_style');

if($stickyHeader) {
	$navbar = ' navbar-fixed-top';
}else{
	$navbar = ' navbar-static-top';
}

if($show_menu) {
	$show_menu_cls = '';
}else{
	if(is_front_page()) {
		$show_menu_cls = ' wt_hide_menu';
	} else  {
		$show_menu_cls = '';
	}
}

if(!wt_is_enabled($breadcrumbs, $generalBcrumbs)) {
	$breadcrumbs_cls = ' wt_bcrumbs_enabled';
} else {
	$breadcrumbs_cls = ' wt_bcrumbs_disabled';
}

if(is_search()) { 
	$breadcrumbs_cls = ' wt_bcrumbs_enabled';
}

if(!empty($color) && $color != "transparent"){
	$color = 'background-color:'.$color.';';
}else{
	$color = '';
}
if(!empty($bg)){
	$bg = 'background-image:url('.$bg.');background-position:top '.$bg_position.';background-repeat:'.$bg_repeat.'';
}else{
	$bg = '';
}
if ($stickyHeader) {
	wp_enqueue_script('jquery-sticky');
}
if($smoothScroll) {
	wp_enqueue_script('smooth-scroll');
}
if ($niceScroll) {
	wp_enqueue_script('nice-scroll');
}
?>
<body <?php body_class(); ?> <?php if($niceScroll):?> data-nice-scrolling="1"<?php endif; ?>>

<?php if($pageLoader){ ?>
    <div id="wt_loader"><div class="wt_loader_html"></div></div>
<?php } ?>

<div id="wt_wrapper" class="<?php if($layout=='right'):?>withSidebar rightSidebar<?php endif;?><?php if($layout=='left'):?>withSidebar leftSidebar<?php endif;?><?php if($layout=='full'):?> fullWidth<?php endif; ?><?php if($stickyHeader):?> wt_stickyHeader<?php endif; ?><?php if($noStickyOnSS):?> wt_noSticky_on_ss<?php endif; ?><?php if($type=='disable'):?> wt_intro_disabled<?php endif; ?><?php echo esc_attr( $show_menu_cls ) ?><?php echo esc_attr( $breadcrumbs_cls ) ?><?php if($animations):?> wt_animations<?php endif; ?><?php if($menu_type == "top"):?> wt_nav_top<?php else:?> wt_nav_side<?php endif; ?> clearfix"<?php if(!empty($color) || !empty($bg)){echo' style="'.$color.''.$bg.'"';} ?>>
<div id="wt_page" class="<?php if(wt_get_option('general','layout_style')== 'wt_boxed'){echo 'wt_boxed';} else {echo 'wt_wide';} ?>">
<?php
if($show_menu) { ?>
	<?php if(is_search() || is_404()) {
		$responsiveNav = 'wt_resp_nav_under_' . $responsiveNav . ' ';
		echo '<div id="wt_headerWrapper" role="banner" class="clearfix">';
		echo '<header id="wt_header" class="'.$responsiveNav.'navbar'.$navbar.' responsive_nav clearfix" role="banner">';
    } else { 
		wt_theme_generator('wt_headerWrapper',$post->ID);
		wt_theme_generator('wt_header',$post->ID); }?>
    	<div class="container">
			<?php if(!wt_get_option('general','display_logo') && $custom_logo = wt_get_option('general','logo')): ?>			
                <div id="logo" class="navbar-header">
                    <?php if($enable_retina): ?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo wt_get_option('general','logo'); ?>" data-at2x="<?php echo esc_attr( $retinaLogo ); ?>" alt="" /></a>
                    <?php else:?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo wt_get_option('general','logo'); ?>" alt="" /></a>
                    <?php endif; ?> 
                </div>
            <?php else:?>
                <div id="logo" class="logo_text navbar-header">
                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php echo wpml_t(THEME_NAME, 'Logo Text',strip_tags(wt_get_option('general','plain_logo'), '<span><a><strong>')); ?>
					</a>
                <?php if(wt_get_option('general','display_site_desc')){
                        $site_desc = get_bloginfo( 'description' );
                        if(!empty($site_desc)):?>
                        <div id="siteDescription"><?php bloginfo( 'description' ); ?></div>
                <?php endif;}?>
                </div>
            <?php endif; ?>
                             
            <!-- Header Widget -->            
            <div id="headerWidget"><?php if(is_active_sidebar('sidebar-header-area')){dynamic_sidebar(esc_html__('Header Area','wt_admin')); } ?></div>  
                        
            <?php  		
            if ( $responsiveNav == 'drop_down' ) { 
                wp_enqueue_script('mobileMenu');
            }			
            ?> 
            <!-- Navigation -->
            <?php 
			if(is_search() || is_404()) {
				echo '<nav id="nav" class="wt_nav_top collapse navbar-collapse" role="navigation" data-select-name="-- Main Menu --">';
			} else {
				wt_theme_generator('wt_nav',$post->ID);}?>      
            <?php  if ( has_nav_menu( 'primary-menu' ) ) {
                if (empty($homeContent)|| ($theme_style == 'multipage') ) {
				wt_theme_generator('wt_menu');
			} else {
				wt_theme_generator('wt_menu_one_page');
			}
            } else {
				echo '<span class="wt_no_custom_nav">No custom menu created! Go to Appearance - Menus and create one!<span>';
            }
            ?>
            </nav>                  
		</div> 	<!-- End container -->    
	</header> <!-- End header --> <?php echo "\n"; ?> 
<?php } else {
	if(!is_front_page()) { ?>
			<?php if(is_search() || is_404()) {
		$responsiveNav = 'wt_resp_nav_under_' . $responsiveNav . ' ';
		echo '<div id="wt_headerWrapper" role="banner" class="clearfix">';
		echo '<header id="wt_header" class="'.$responsiveNav.'navbar'.$navbar.' responsive_nav clearfix" role="banner">';
    } else { 
		wt_theme_generator('wt_headerWrapper',$post->ID);
		wt_theme_generator('wt_header',$post->ID); }?>
    	<div class="container">
			<?php if(!wt_get_option('general','display_logo') && $custom_logo = wt_get_option('general','logo')): ?>			
                <div id="logo" class="navbar-header">
                    <?php if($enable_retina): ?>
                        <?php if(is_front_page()): ?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( wt_get_option('general','logo') ); ?>" data-at2x="<?php echo esc_attr( $retinaLogo ); ?>" alt="" /></a>
                        <?php else:?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $custom_logo ); ?>" data-at2x="<?php echo esc_attr( $retinaLogoAlt ); ?>" alt="" /></a>
                        <?php endif; ?> 
                    <?php else:?>
                        <?php if(is_front_page()): ?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( wt_get_option('general','logo_retina') ); ?>" alt="" /></a>
                        <?php else:?>
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $custom_logo ); ?>" alt="" /></a>
                        <?php endif; ?> 
                    <?php endif; ?> 
                </div>
            <?php else:?>
                <div id="logo" class="logo_text navbar-header">
                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php echo wpml_t(THEME_NAME, 'Logo Text',strip_tags(wt_get_option('general','plain_logo'), '<span><a><strong>')); ?></a>
                <?php if(wt_get_option('general','display_site_desc')){
                        $site_desc = get_bloginfo( 'description' );
                        if(!empty($site_desc)):?>
                        <div id="siteDescription"><?php bloginfo( 'description' ); ?></div>
                <?php endif;}?>
                </div>
            <?php endif; ?>
                                
            <!-- Header Widget -->
            <div id="headerWidget"><?php if(is_active_sidebar('sidebar-header-area')){dynamic_sidebar(esc_html__('Header Area','wt_admin')); } ?></div> 
            
            <?php  		
            if ( $responsiveNav == 'drop_down' ) { 
                wp_enqueue_script('mobileMenu');
            }			
            ?> 
            <!-- Navigation -->
            <?php 
			if(is_search() || is_404()) {
				echo '<nav id="nav" class="wt_nav_top collapse navbar-collapse" role="navigation" data-select-name="-- Main Menu --">';
			} else {
				wt_theme_generator('wt_nav',$post->ID);}?>      
            <?php  if ( has_nav_menu( 'primary-menu' ) ) {
                if ( ( $locations = get_nav_menu_locations() ) && $locations['primary-menu'] && (!empty($homeContent)) || ($theme_style == 'multipage') ) {
					wt_theme_generator('wt_menu');
				} else {
					wt_theme_generator('wt_menu_one_page');
				}
            } else {
				echo '<span class="wt_no_custom_nav">No custom menu created! Go to Appearance - Menus and create one!<span>';
            }
            ?>
            </nav>      
		</div> 	<!-- End container -->    
	</header> <!-- End header --> <?php echo "\n"; ?> 
	<?php }
}
?>