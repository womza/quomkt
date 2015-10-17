<?php get_header(); ?>
<?php
$homeContent = wt_get_option('general','one_page_home');
$layout = wt_get_option('general','layout');
$show_menu = wt_get_option('general', 'show_menu');
$theme_style = wt_get_option('general', 'theme_style');
 ?>
<?php
if($show_menu): ?>
</div> <!-- End headerWrapper -->
<?php endif; ?> 
<div id="wt_containerWrapper" class="clearfix">
	<?php wt_theme_generator('wt_containerWrapp',$post->ID); ?>
    <?php 
	if ( ( $theme_style == 'onepage' )) {
		if ( ( $locations = get_nav_menu_locations() ) && $locations['primary-menu'] && (!empty($homeContent)) && (!is_front_page() || !is_blog()  ) ) {
			require_once (THEME_FILES . '/homeContent.php');
			$menu = wp_get_nav_menu_object( $locations['primary-menu'] );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			$include = array();
			foreach($menu_items as $item) {
				if($item->object == 'page') {
					$include[] = $item->object_id;
				} else { 
					$include[] = ''; 
				}
			}
			query_posts( array( 'post_type' => 'page', 'post__in' => $include, 'posts_per_page' => count($include), 'orderby' => 'post__in' ) );
			$i = 1;		
			
			while (have_posts()) : 
				the_post();
				$intro_type = get_post_meta($post->ID, '_intro_type', true);
				$top_margins = get_post_meta($post->ID, '_top_margins', true);
				$bottom_margins = get_post_meta($post->ID, '_bottom_margins', true);
				if ($top_margins != '0') {
					$top_margins = 'padding-top:'.$top_margins.'px; ';
				} else {
					$top_margins = ''; 
				}
				if ($bottom_margins != '0') {
					$bottom_margins = 'padding-bottom:'.$bottom_margins.'px; ';
				} else {
					$bottom_margins = ''; 
				}
				?>
			 <section id="<?php echo esc_attr( $post->post_name );?>" class="wt_section_area"<?php if($top_margins != '0' || $bottom_margins != '0') {echo' style="'. $top_margins .  $bottom_margins . '"';} ?>>
			   <?php if($intro_type != 'disable'): ?>
					<div class="container">
						<?php wt_theme_generator('wt_custom_title',$post->ID); ?>
					</div>   
			   <?php endif; ?>
				<?php if (!class_exists('WPBakeryVisualComposerAbstract')) { ?>
			   <div class="container">
			   <?php } ?>
				   <?php the_content(); ?>
			   <?php if (!class_exists('WPBakeryVisualComposerAbstract')) { ?>
			   </div> 
			   <?php } ?>
			</section>
			<?php $i++; 
			endwhile; 
			wp_reset_postdata();
			} 	
		else { 
		   return require(THEME_DIR . "/blog.php"); }
		}
		elseif ( ( $theme_style == 'multipage' || is_front_page())) {
		   require_once(THEME_DIR . "/template_home.php");} ?>
    
    </div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>