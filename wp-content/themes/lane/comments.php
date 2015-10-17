<?php 
function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
    
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment_wrap clearfix">
			<div class="gravatar">
				<?php echo get_avatar($comment,$size='80',$default='http://s.gravatar.com/avatar/e18c83a4de25393a9465e613f15b86e0'); ?>
            </div>
			<div class='comment_content'>
				<footer class="comment_meta">
					<?php printf( '<cite class="comment_author">%s</cite>', get_comment_author_link()); ?><?php edit_comment_link(esc_html__('(Edit)', 'wt_front' ),'  ','') ?>
                    <?php
                    $d = 'F j, Y \a\t g:i A';
					$comment_date = get_comment_date( $d );
					?>
					<span class="comment_time"><a><?php echo esc_attr( $comment_date ); ?></a></span>
				<span class="btn-reply"> - <?php 
					comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</span>
				</footer>
				<div class='comment_text'>
					<?php comment_text() ?>
<?php if ($comment->comment_approved == '0') : ?>
					<span class="unapproved"><?php esc_html_e('Your comment is awaiting moderation.', 'wt_front') ?></span>
<?php endif; ?>
				</div>
			</div>
		</article>
<?php
}
?>

<section id="comments" role="complementary"><?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'wt_front'); ?></p>
<?php
		return;
	endif;
	
if ( have_comments() ) : ?>
	<div class="wt_commentsTitle">
        <h3 id="commentsTitle"><?php 
			printf( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'wt_front' ), 
            number_format_i18n( get_comments_number() ), get_the_title() );	
		?></h3>
    </div>

	<ul class="commentList">
		<?php
			wp_list_comments( array( 'callback' => 'theme_comments' ) );
		?>
	</ul>


<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="comments_navigation">
		<div class="nav_previous"><?php previous_comments_link(); ?></div>
		<div class="nav_next"><?php next_comments_link(); ?></div>
	</div>
<?php endif; // check for comment navigation ?>


<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
	/*<p class="nocomments"><?php esc_html_e( 'Comments are closed.', 'wt_front' ); ?></p>*/
?>
	
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php if ( comments_open() ) :// Comment Form ?>

	<div id="respond">
		<div id="respond_title">
        	<h3><?php comment_form_title( esc_html__('Leave a Reply', 'wt_front'), esc_html__('Leave a Reply to %s', 'wt_front') ); ?></h3>
            <p><?php esc_html_e('Make sure you fill in all mandatory fields. Required fields are marked *', 'wt_front') ?></p>
        </div>
<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php printf(esc_html__('You must be', 'wt_front') . ' <a href="%s">' . esc_html__( 'logged in', 'wt_front') .' </a>'. esc_html__('to post a comment', 'wt_front'),wp_login_url( get_permalink() )); ?></p>
<?php else : ?>
   		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="row" role="form">
        
	<?php if ( is_user_logged_in() ) : ?>
			<p class="logged col-md-12"><?php printf(esc_html__( 'Logged in as', 'wt_front') . ' <a href="%1$s">%2$s</a>. <a href="%3$s" title="'.esc_attr__( 'Log out of this account', 'wt_front').'">' . esc_html__( 'Log out?', 'wt_front') . '</a>', admin_url( 'profile.php' ), $user_identity, wp_logout_url( get_permalink()  ) )?></p>
    <?php else : ?>	
            <fieldset>
                <div id="form_input_name" class="col-md-4">
                    <input type="text" name="author" class="required form-control" id="author" value="<?php echo esc_attr( $comment_author ); ?>" size="22" tabindex="1" minlength="3" placeholder="Name *" />
                </div>
                <div id="form_input_email" class="col-md-4">
                    <input type="text" name="email" class="required email form-control" id="email" value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" tabindex="2" placeholder="Email *" />
                </div>
                <div id="form_input_website" class="col-md-4">
                    <input type="text" name="url" class="url form-control" id="url" value="<?php echo esc_attr( $comment_author_url ); ?>" size="22" tabindex="3" placeholder="Website" />
                </div>
            </fieldset>
    <?php endif; ?>

			<fieldset id="form_input_message" class="col-md-12">
                <textarea class="required form-control" name="comment" id="comment" rows="6" tabindex="4" minlength="5" placeholder="Message... *"></textarea>
            </fieldset>
            
			<fieldset id="form_btn" class="text-center col-md-12">                                
			    <a id="submit" href="#" onclick="jQuery('#commentform').submit();return false;" class="btn btn-main btn-theme"><span><?php esc_html_e('Post Comment', 'wt_front');?></span></a><?php comment_id_fields(); ?>  
                <?php cancel_comment_reply_link('Cancel Reply'); ?>
                <?php do_action('comment_form', $post->ID); ?>
            </fieldset>
            
			<?php wp_enqueue_script( 'wt-validate' ); ?>
            <?php wp_enqueue_script( 'wt-validate-translation' ); ?>
             <script type="text/javascript">
                 jQuery(document).ready(function($) { jQuery("#commentform").validate(); });		
             </script>
             
		</form>
<?php endif; // If registration required and not logged in ?>
	</div><!--/respond-->
<?php endif; ?>
</section>