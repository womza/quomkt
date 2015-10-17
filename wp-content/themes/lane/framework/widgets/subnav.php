<?php
/**
 * Sub Navigation Widget Class
 */
class Wt_Widget_SubNav extends WP_Widget {

	function Wt_Widget_SubNav() {
		$widget_ops = array('classname' => 'widget_subnav', 'description' => esc_html__( 'Displays a list of SubPages', 'wt_admin') );
		parent::__construct('subnav', THEME_SLUG.' - '.esc_html__('Sub Navigation', 'wt_admin'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $post;
		$children=wp_list_pages( 'echo=0&child_of=' . $post->ID . '&title_li=' );
		if ($children) {
			$parent = $post->ID;
		}else{
			$parent = $post->post_parent;
			if(!$parent){
				$parent = $post->ID;
			}
		}
		$parent_title = get_the_title($parent);
		
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? $parent_title : $instance['title'], $instance, $this->id_base);
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = empty( $instance['exclude'] ) ? wt_get_excluded_pages() : $instance['exclude'].','.wt_get_excluded_pages();
		
		$output = wp_list_pages( array('title_li' => '', 'echo' => 0, 'child_of' =>$parent, 'sort_column' => $sortby, 'exclude' => $exclude) );

		if ( !empty( $output ) ) {
			echo balanceTags( $before_widget );
			if ( $title)
				echo balanceTags( $before_title . $title . $after_title );
		?>
		<ul class="wt_side-nav">
			<?php echo balanceTags( $output ); ?>
		</ul>
		<?php
			echo balanceTags( $after_widget );
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}

		$instance['exclude'] = strip_tags( $new_instance['exclude'] );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'menu_order', 'title' => '', 'exclude' => '') );
		$title = esc_attr( $instance['title'] );
		$exclude = esc_attr( $instance['exclude'] );
	?>
		<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'wt_admin'); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('sortby') ); ?>"><?php esc_html_e( 'Sort by:', 'wt_admin'); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name('sortby') ); ?>" id="<?php echo esc_attr( $this->get_field_id('sortby') ); ?>" class="widefat">
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php esc_html_e('Page order', 'wt_admin'); ?></option>
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php esc_html_e('Page title', 'wt_admin'); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php esc_html_e( 'Page ID', 'wt_admin' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('exclude') ); ?>"><?php esc_html_e( 'Exclude:', 'wt_admin' ); ?></label> <input type="text" value="<?php echo esc_attr( $exclude ); ?>" name="<?php echo esc_attr( $this->get_field_name('exclude') ); ?>" id="<?php echo esc_attr( $this->get_field_id('exclude') ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Page IDs, separated by commas.' ,'wt_admin'); ?></small>
		</p>
<?php
	}
}