<?php 
if(is_search() || is_404()) { 
	$post_id = NULL;
} else {
	$post_id = $post->ID; 
}

$animations = wt_get_option('general','enable_animation');
?>

<?php 
$anim_enabled    = false;
$anim_footer_col = '';

if( $animations && defined('__VC_EXTENSIONS__') ):
	wp_enqueue_script( 'waypoints' ); // VC file
	$anim_enabled = true;
endif;

if( $anim_enabled ):
	$anim_footer_col = ' wt_animate wt_animate_if_visible';
endif;
?>

<?php wt_theme_generator('wt_footerWrapper',$post_id);?>

<?php if(wt_get_option('footer','footer_top')):?>
	<?php wt_theme_generator('wt_footerTop',$post_id);?>
		<div class="row">
            <div class="col-md-12">
				<?php if(is_active_sidebar('sidebar-footer-top-area')){dynamic_sidebar(esc_html__('Footer Top Area','wt_admin')); } ?>     
            </div> <!-- End col -->         
		</div> <!-- End row -->           
	</div> <!-- End container -->
</footer> <!-- End footerTop -->
<?php endif;?>

<?php if(wt_get_option('footer','footer')):?>
<?php wt_theme_generator('wt_footer',$post_id);?>
	<div class="container">
		<div class="row">
<?php
$footer_column = wt_get_option('footer','column');
if(is_numeric($footer_column)):
	switch ( $footer_column ):
		case 1:
			$class = 'wt_footer_col col-md-12'.$anim_footer_col;
			break;
		case 2:
			$class = 'wt_footer_col col-md-6'.$anim_footer_col;
			break;
		case 3:
			$class_1 = 'wt_footer_col col-sm-6 col-md-4'.$anim_footer_col;
			$class   = 'wt_footer_col col-sm-12 col-md-4'.$anim_footer_col;
			break;
		case 4:
			$class = 'wt_footer_col col-md-3'.$anim_footer_col;
			break;
		case 6:
			$class = 'wt_footer_col col-md-2'.$anim_footer_col;
			break;
	endswitch;
	
	for( $i=1; $i<=$footer_column; $i++ ): 
		if ($footer_column == 3): ?>	
			<div class="<?php if ($i == 3): echo esc_attr( $class ); else: echo esc_attr( $class_1 ); endif; ?>" data-animation="fadeInDown" data-animation-delay="<?php echo (int)$i*150; ?>"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<?php		
        else: ?>
			<div class="<?php echo esc_attr( $class ); ?>" data-animation="fadeInDown" data-animation-delay="<?php echo (int)$i*150; ?>"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<?php	
		endif;		
	endfor; 
	
else:
	switch($footer_column):
		case 'col-9-3':
?>
		<div class="wt_footer_col col-md-9"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-3-9':
?>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-9"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-2-5-5':
?>
		<div class="wt_footer_col col-md-2"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-5"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-5"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-3-3-6':
?>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-6"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-3-6-3':
?>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-6"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
			
		case 'col-6-3-3':
?>
		<div class="wt_footer_col col-md-6"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-3"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-4-8':
?>
		<div class="wt_footer_col col-md-4"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-8"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-8-4':
?>
		<div class="wt_footer_col col-md-8"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-4"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-5-7':
?>
		<div class="wt_footer_col col-md-5"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-7"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
		case 'col-5-5-2':
?>
		<div class="wt_footer_col col-md-5"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-5"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
		<div class="wt_footer_col col-md-2"><?php wt_theme_generator('wt_footer_sidebar'); ?></div>
<?php
			break;
	endswitch;
endif;
?>      
		</div> <!-- End row -->
	</div> <!-- End container -->
</footer> <!-- End footer -->
<?php endif;?>
<?php if(wt_get_option('footer','sub_footer')):?>
	<?php wt_theme_generator('wt_footerBottom',$post_id);?>
		<div class="row">
            <div class="col-md-12">
                <?php if(wt_get_option('footer','copyright')):?>
                    <p class="wt_copyright">
                        <?php echo wpml_t(THEME_NAME, 'Copyright Footer Text',strip_tags(wt_get_option('footer','copyright'), '<span><a><strong><br>')); ?>
                    </p>
                <?php endif;?>
                <?php if(is_active_sidebar('sidebar-footer-bottom-area')){dynamic_sidebar(esc_html__('Footer Bottom Area','wt_admin')); } ?>
            </div> <!-- End col -->         
		</div> <!-- End row -->     
	</div> <!-- End container -->
</footer> <!-- End footerBottom -->
<?php endif;?>
</div> <!-- End footerWrapper -->

</div> <!-- End wt_page -->
</div> <!-- End wrapper -->
<script type="text/javascript">
/* <![CDATA[ */
var theme_uri="<?php echo THEME_URI;?>";
/* ]]> */
</script>
<?php
wt_scripts();
?>
<?php
wp_footer();
?>
</body>
</html>