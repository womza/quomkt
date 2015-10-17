<?php
wt_setPostViews(get_the_ID());
$blog_page = wt_get_option('blog','blog_page');
if($blog_page == $post->ID){
	return require(THEME_DIR . "/template_blog.php");
}
$featured_image_type = wt_get_option('portfolio', 'layout');
$type = get_post_meta($post->ID, '_intro_type', true);
$layout= wt_get_option('portfolio','layout');
$terms = get_the_terms(get_the_ID(), 'wt_portfolio_category');
?>
<?php get_header(); ?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
	<?php wt_theme_generator('wt_breadcrumbs',$post->ID); ?>
    <?php wt_theme_generator('wt_custom_header',$post->ID); ?>
    <?php wt_theme_generator('wt_containerWrapp',$post->ID);?>
        <div id="wt_container" class="clearfix">
            <?php wt_theme_generator('wt_content',$post->ID);?>
                <div class="container">
                	<div class="row"> 
						<?php if($layout == 'full') {
                            echo '<div class="col-md-12">';
                        }?>
						<?php if($layout == 'left') {
                            echo '<aside id="wt_sidebar" class="col-md-3">';
                            get_sidebar(); 
                            echo '</aside> <!-- End wt_sidebar -->'; 
                        }?>
                        <?php if($layout != 'full') {
                            echo '<div id="wt_main" role="main" class="col-md-9">'; 
                            echo '<div id="wt_mainInner">'; 
                        }?>
                        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" class="portEntry">
                                <?php if(wt_get_option('portfolio','featured_image')):?>
                                    <?php echo wt_theme_generator('wt_portfolio_featured_image'); ?>
                                <?php endif; ?>
                               <?php //wt_theme_generator('wt_breadcrumbs',$post->ID); ?>
                                <div class="portEntry_content">
                                                                
                                <?php the_content(); ?> 
                                <?php wp_link_pages( array( 'before' => '<div class="wp-pagenavi post_navi"><span class="page-links-title">' . esc_html__( 'Pages:', 'wt_front' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                                </div>
                                
                                
                            </article>     
                            
                            <?php if($layout != 'full') {
                                echo '</div> <!-- End wt_mainInner -->'; 
                                echo '</div> <!-- End wt_main -->'; 
                                
                            } ?>
                            <?php if($layout == 'right') {
							   echo '<aside id="wt_sidebar" class="col-md-3">';
                               get_sidebar(); 
                               echo '</aside> <!-- End wt_sidebar -->'; 
                            }
                            ?>
                            
                            <?php if(wt_get_option('portfolio','single_navigation')):?>
                                <div class="entry_navigation">
                                    <div class="nav-previous">
                                        <?php wt_previous_post_link_plus(); ?>
                                    </div>
                                    <div class="nav-next">
                                        <?php wt_next_post_link_plus(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        
                            <?php if(wt_get_option('portfolio','enable_comment')) comments_template( '', true ); ?>
                        <?php endwhile; // end of the loop ?>
                        
						<?php if($layout == 'full') {
                            echo '</div>';
                        }?>
                    </div> <!-- End row -->
            	</div> <!-- End container -->
            </div> <!-- End wt_content -->
        </div> <!-- End wt_container -->
    </div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>