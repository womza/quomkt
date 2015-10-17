<?php get_header(); ?>
<?php 
if(is_search() || is_404()) { 
	$post_id = NULL;
} else {
	$post_id = $post->ID; 
}
?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
	<?php wt_theme_generator('wt_breadcrumbs'); ?>
	<?php wt_theme_generator('wt_custom_header',$post_id); ?>
	<?php wt_theme_generator('wt_containerWrapp',$post_id);?>
        <div id="wt_container" class="clearfix">
            <?php wt_theme_generator('wt_content',$post_id);?>
                <div class="container">
                    <div class="row">
                        <?php if($layout != 'full') {
                            echo '<div id="wt_main" role="main" class="col-md-9">'; 
                            echo '<div id="wt_mainInner">';
                        }?> 
                        
                        <?php 
							$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$s = get_query_var('s');
							query_posts("s=$s&paged=$page&cat=");
							if (query_posts("s=$s&paged=$page")){
								get_template_part( 'loop','search'); 
							}
							else {
								echo "<h3>Sorry, the search didn't return any results.</h3>";
								echo '<p>If you want to rephrase your query, here is your chance:</p>';
								echo '<div class="row"><div class="col-md-6">';
								echo get_search_form();
								echo '</div></div>';
							}
						?>
                        
                        <?php if($layout != 'full') {
                            echo '</div> <!-- End wt_mainInner -->'; 
                            echo '</div> <!-- End wt_main -->'; 
                        }?>
                        
                        <?php if($layout != 'full') {
                            echo '<aside id="wt_sidebar" class="col-md-3">';
                            get_sidebar(); 
                            echo '</aside> <!-- End wt_sidebar -->'; 
                        }?>
                    </div> <!-- End row -->
                </div> <!-- End container -->
            </div> <!-- End wt_content -->
        </div> <!-- End wt_container -->
    </div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>