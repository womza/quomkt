<?php
/**
 * The `optionGenerator` class help generate the html code for theme options page.
 */
class wt_options {
	var $name;
	var $options;
	var $saved_options;
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array $options
	 */
	function wt_options($name, $options) {
		
		$this->name = $name;
		$this->options = $options;
		
		$this->wt_reset_options();
		$this->wt_save_options();
		$this->wt_render();
	}
	
	function wt_save_options() {
		$options = get_option(THEME_SLUG . '_' . $this->name);
		
		if (isset($_POST['save_options'])) {
			
			foreach($this->options as $get_options) {
				
				if (isset($get_options['id']) && ! empty($get_options['id'])) {
					if (isset($_POST[$get_options['id']])) {
						if ($get_options['type'] == 'wt_multidropdown') {
							if(empty($_POST[$get_options['id']])){
								$options[$get_options['id']] = array();
							}else{
								$options[$get_options['id']] = array_unique(explode(',', $_POST[$get_options['id']]));
							}
						}elseif($get_options['type'] == 'wt_toggle'){
							if($_POST[$get_options['id']] == 'true'){
								$options[$get_options['id']] = true;
							}else{
								$options[$get_options['id']] = false;
							}
						}elseif($get_options['type'] == 'wt_tritoggle'){
							if($_POST[$get_options['id']] == 'true'){
								$options[$get_options['id']] = true;
							}elseif($_POST[$get_options['id']] == 'false'){
								$options[$get_options['id']] = false;
							}else{
								$options[$get_options['id']] = 'default';
							}
						} else {
							$options[$get_options['id']] = $_POST[$get_options['id']];
						}
					} else {
						$options[$get_options['id']] = false;
					}
				}
				if (isset($get_options['process']) && function_exists($get_options['process'])) {
					$options[$get_options['id']] = $get_options['process']($get_options,$options[$get_options['id']]);
				}
			}
			if ($options != $this->options) {				
												
				// Updates Header Intro Slider Settings				
				foreach ($_POST as $key => $value) {
					if ( preg_match("/custom_slider_/", $key) ) {
						$options[$key] = $value;
					}		
				}
				
				update_option(THEME_SLUG . '_' . $this->name, $options);
				global $theme_options;
				$theme_options[$this->name] = $options;
								
				wt_generate_skin_css();
			}
			
			echo '<div id="message" class="updated fade"><p><strong>Updated Successfully</strong></p></div>';
		}
		
		$this->saved_options = $options;
	
	}	
	
	function wt_reset_options() {
		$options = get_option(THEME_SLUG . '_' . $this->name);
		if (isset($_POST['reset_options'])) {
			delete_option(THEME_SLUG . '_' . $this->name, $options);
		}
	}			
	function wt_render() {
		echo '<div class="wrap theme-options-page clearfix"';
		global $wp_version;
		if(version_compare($wp_version, "3.5", '>')){
			echo ' data-version="gt3_5"';
		}
		echo '>';
		echo '<form method="post" action="">';
		
		foreach($this->options as $option) {
			if (method_exists($this, $option['type'])) {
				$this->$option['type']($option);
			}
		
		}
		echo '</form>';
		echo '</div>';
	}
		
	/**
	 * prints out the navigation tabs 
	 */
	function wt_navigation($get_options) {
		if (isset($get_options['target'])) {
			if (isset($get_options['options'])) {
				$get_options['options'] = $get_options['options'] + $this->wt_get_select_target_options($get_options['target']);
			} else {
				$get_options['options'] = $this->wt_get_select_target_options($get_options['target']);
			}
		}
				
		echo '<div class="whoathemes_options_tabs">';
		echo '<div id="icon-themes" class="icon32"></div>';
		echo '<div class="' . $get_options['class'] . '">';		
		
		if (isset($get_options['options'])) {
			foreach($get_options['options'] as $key => $option) {
				echo "<a id='wt-option-" . $key . "-tab'";				
				echo " class='nav-tab'";							
				echo " href='#wt-option-" . $key . "'";				
				echo " title='" . $option . "'";
			
				echo '>' . $option . '</a>';
			}
		}
		
		echo '</div>';				
		echo '</div>';
	}
		
	/**
	 * prints out the options page groups
	 */
	function wt_group_start($get_options){
		echo '<div class="wt-option-group';		
		if(isset($get_options['group_class'])){
			echo ' '.$get_options['group_class'];
		}		
		echo '"';
		if(isset($get_options['group_id'])){
			echo ' id="wt-option-'.$get_options['group_id'].'"';
		}
		echo '>';
	}
	
	function wt_group_end($get_options){
		echo '</div>';
	}
	
	/**
	 * begins the group section
	 */
	function wt_open($get_options) {		
		if(isset($get_options['open_class'])){
			$class = ' '.$get_options['open_class'];
		} else {
			$class = '';
		}		
		echo '<div class="theme-options-group';	
		echo esc_attr( $class ) . '"';
		if(isset($get_options['open_id'])){
			echo ' id="'.$get_options['open_id'].'"';
		}
		echo '>';
		echo '<table cellspacing="0" class="widefat theme-options-table">';
		echo '<thead><tr>';
		if ($class != '') $class = 'class="'.trim($class).'_title"';
		echo '<th scope="row" colspan="2"'.$class.'>' . $get_options['name'] . '</th>';
		echo '</tr></thead><tbody>';	
	}
	
	function wt_open_group($get_options) {		
		if(isset($get_options['open_class'])){
			$class = ' '.$get_options['open_class'];
		} else {
			$class = '';
		}		
		echo '<div class="theme-options-group';	
		echo esc_attr( $class ) . '"';
		if(isset($get_options['open_id'])){
			echo ' id="'.$get_options['open_id'].'"';
		}
		echo '>';
	}		
	
	/**
	 * closes the group section
	 */
	function wt_close($get_options) {
		echo '</tbody></table></div><p class="submit"><input type="submit" name="save_options" class="button button-primary button-large autowidth" value="Save Changes" /></p>';
	}
	function wt_just_close($get_options) {
		echo '</tbody></table></div>';
	}
	function wt_close_group($get_options) {
		echo '</div>';
	}
	function wt_save_close($get_options) {
		echo '<p class="submit"><input type="submit" name="save_options" class="button button-primary button-large autowidth" value="Save Changes" /></p>';
	}
	function wt_reset($get_options) {
		echo "<p class=\"reset\"><input type=\"submit\" name=\"reset_options\" class=\"button button-secondary button-large autowidth\" value=\"Reset\" onclick=\"return confirm( 'Are you sure you want to reset? All the above settings will be reset to defauls!";
		echo '\n';
		echo "\'Cancel\' to stop, \'OK\' to reset.' );\" /></p>";
	}
	
	/**
	 * prints out the options page titles and descriptions
	 */
	function wt_title($get_options) {
		if (isset($get_options['name'])) {
			echo '<h2>' . $get_options['name'] . '</h2>';
		}
		if (isset($get_options['desc'])) {
			echo '<p>' . $get_options['desc'] . '</p>';
		}
	}		
	function wt_desc($get_options) {
		echo '<tr><td scope="row" colspan="2">' . $get_options['desc'] . '</td></tr>';
	}
	
	/**
	 * displays a text input
	 */
	function wt_text($get_options) {
		$size = isset($get_options['size']) ? $get_options['size'] : '10';		
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		
		echo '<div class="my_theme_options">';
				
		echo '<input name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" type="text" size="' . $size . '" value="';
		if (isset($this->saved_options[$get_options['id']])) {
			echo wt_check_input($this->saved_options[$get_options['id']]);
		} else {
			echo esc_attr( $get_options['default'] );
		}
		echo '" />';
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
				
	/**
	 * displays a textarea
	 */
	function wt_textarea($get_options) {
		$rows = isset($get_options['rows']) ? $get_options['rows'] : '5';
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		echo '<div class="my_theme_options">';
		$elastic = isset($get_options['elastic'])=="true" ? ' elastic' : '';
		echo '<textarea id="'.$get_options['id'].'" rows="' . $rows . '" name="' . $get_options['id'] . '" type="' . $get_options['type'] . '" class="code'. $elastic .'">';
		if (isset($this->saved_options[$get_options['id']])) {
			echo wt_check_input($this->saved_options[$get_options['id']]);
		} else {
			echo esc_attr( $get_options['default'] );
		}
		echo '</textarea>';
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top:0px;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
		
	/**
	 * displays a select
	 */
	function wt_select($get_options) {
		if (isset($get_options['target'])) {
			if (isset($get_options['options'])) {
				$get_options['options'] = $get_options['options'] + $this->wt_get_select_target_options($get_options['target']);
			} else {
				$get_options['options'] = $this->wt_get_select_target_options($get_options['target']);
			}
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		echo '<div class="my_theme_options">';
		if (isset($get_options['chosen'])=="true") {
			echo '<select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" class="chzn-select">';
		}else{
			echo '<span class="wt_select_wrapp"><select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '">';
		}
		$selected_value = '';
		if(isset($get_options['prompt'])){
			echo '<option value="">'.$get_options['prompt'].'</option>';
			$selected_value = $get_options['prompt'];
		}
		if (isset($get_options['options'])) {
			foreach($get_options['options'] as $key => $option) {
				echo "<option value='" . $key . "'";
				if (isset($this->saved_options[$get_options['id']])) {
					if (stripslashes($this->saved_options[$get_options['id']]) == $key) {
						echo ' selected="selected"';
						$selected_value = $option;
					}
				} else if (isset($get_options['default']) && $key == $get_options['default']) {
					echo ' selected="selected"';
					$selected_value = $option;
				}
			
				echo '>' . $option . '</option>';
			}
		}
		if (isset($get_options['page'])){
			$depth = $get_options['page'];
			$selected = isset($this->saved_options[$get_options['id']])?stripslashes($this->saved_options[$get_options['id']]):$get_options['default'];
			$args = array(
				'depth' => $depth, 'child_of' => 0,
				'selected' => $selected, 'echo' => 1,
				'name' => 'page_id', 'id' => '',
				'show_option_none' => '', 'show_option_no_change' => '',
				'option_none_value' => ''
			);
			$pages = get_pages($args);
			
			echo walk_page_dropdown_tree($pages,$depth,$args);
		}
		
		
		if (isset($get_options['chosen'])=="true") {
			echo '</select>';
		} else {
			echo '</select>';			
			echo '<span class="wt_option_selected">'.$selected_value.'</span>';
			echo '</span>';
		}
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	/**
	 * displays a select for Revolution Slider
	 **/
	function wt_selectRev($get_options) {
		if (isset($this->saved_options[$get_options['id']])) {
			$get_options['default']=$this->saved_options[$get_options['id']];
		} 
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		echo '<div class="my_theme_options">';
		if (isset($get_options['chosen'])=="true") {
			echo '<select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" class="chzn-select">';
		} else {
			echo '<span class="wt_select_wrapp">';
			echo '<select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '">';
		}
		
		$selected_value = '';
		if(isset($get_options['prompt'])){
			echo '<option value="">'.$get_options['prompt'].'</option>';
			$selected_value = $get_options['prompt'];
		}
		
		if ( class_exists( 'GlobalsRevSlider' ) ) {
			global $wpdb;
			$table_name = $wpdb->base_prefix . "revslider_sliders";
			$sql = $wpdb->prepare( "SELECT * FROM $table_name ORDER BY id = %d", $id );

			$results = $wpdb->get_results($sql);
						
			foreach($results as $key => $option) {
				$valueS = $option->alias;
			    echo "<option name='".$option->title."'";
				echo " value='".$option->alias."'";
				if ($valueS == $get_options['default']) {
						echo ' selected="selected"';
						$selected_value = $option->title;
				}
				echo ">".$option->title."</option>";
			}
		}
		if (isset($get_options['chosen'])=="true") {
			echo '</select>';
		} else {
			echo '</select>'; 		
			echo '<span class="wt_option_selected">'. $selected_value .'</span>';
			echo '</span>'; 
		}
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}	
	
	/**
	 * displays a select for Layer Slider
	 */
	function wt_selectLayerS($get_options) {
		if (isset($this->saved_options[$get_options['id']])) {
			$get_options['default']=$this->saved_options[$get_options['id']];
		} 
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		echo '<div class="my_theme_options">';
		if (isset($get_options['chosen'])=="true") {
			echo '<select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" class="chzn-select">';
		} else {
			echo '<span class="wt_select_wrapp">';
			echo '<select name="' . $get_options['id'] . '" id="' . $get_options['id'] . '">';
		}
		
		$selected_value = '';
		if(isset($get_options['prompt'])){
			echo '<option value="">'.$get_options['prompt'].'</option>';
			$selected_value = $get_options['prompt'];
		}
		
		if(function_exists('layerslider_activation_scripts')){
			global $wpdb;
			$flag_hidden  = 0;
			$flag_deleted = 0;
			$table_name   = $wpdb->base_prefix . "layerslider";
			
			$sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE flag_hidden = %d AND flag_deleted = %d ORDER BY id", $flag_hidden,$flag_deleted );
			$results = $wpdb->get_results($sql);
						
			foreach($results as $key => $option) {
				$valueS = $option->id;
			    echo "<option name='".$option->name."'";
				echo " value='".$option->id."'";
				if ($valueS == $get_options['default']) {
					echo ' selected="selected"';
					$selected_value = $option->name;
				}
				echo ">".$option->name."</option>";
			}
		}
		if (isset($get_options['chosen'])=="true") {
			echo '</select>';
		} else {
			echo '</select>'; 		
			echo '<span class="wt_option_selected">'. $selected_value .'</span>';
			echo '</span>'; 
		}
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	/**
	 * displays a multiselect
	 */
	function wt_multiselect($get_options) {
		$size = isset($get_options['size']) ? $get_options['size'] : '5';
		if (isset($get_options['target'])) {
			if (isset($get_options['options'])) {
				$get_options['options'] = $get_options['options'] + $this->wt_get_select_target_options($get_options['target']);
			} else {
				$get_options['options'] = $this->wt_get_select_target_options($get_options['target']);
			}
		}		
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
		
		if (isset($get_options['chosen'])=="true") {
			echo '<select name="' . $get_options['id'] . '[]" id="' . $get_options['id'] . '" class="chzn-select" multiple="multiple" size="' . $size . '" style="height:auto">';
		}else{
			echo '<select name="' . $get_options['id'] . '[]" id="' . $get_options['id'] . '" multiple="multiple" size="' . $size . '" style="height:auto">';
		}
		
		if(!empty($get_options['options']) && is_array($get_options['options'])){
			foreach($get_options['options'] as $key => $option) {
				echo '<option value="' . $key . '"';
				if (isset($this->saved_options[$get_options['id']])) {
					if (is_array($this->saved_options[$get_options['id']])) {
						if (in_array($key, $this->saved_options[$get_options['id']])) {
							echo ' selected="selected"';
						}
					}
				} else if (in_array($key, $get_options['default'])) {
					echo ' selected="selected"';
				}
				echo '>' . $option . '</option>';
			}
		}
		
		echo '</select>';		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top:0px;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
			
	/**
	 * displays a multidropdown
	 */
	function wt_multidropdown($get_options) {
		if (isset($get_options['target'])) {
			if (isset($get_options['options'])) {
				$get_options['options'] = $get_options['options'] + $this->wt_get_select_target_options($get_options['target']);
			} else {
				$get_options['options'] = $this->wt_get_select_target_options($get_options['target']);
			}
		}
		if (isset($this->saved_options[$get_options['id']])) {
			$selected_keys = $this->saved_options[$get_options['id']];
		} else {
			$selected_keys = $get_options['default'];
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		echo '<input type="hidden" id="' . $get_options['id'] . '" name="' . $get_options['id'] . '" value="' . implode(',', $selected_keys) . '"/>';
		echo '<div class="multidropdown-wrap">';
		
		$i = 0;
		if (isset($get_options['page'])){
			$depth = $get_options['page'];
			$pages = get_pages();
		}
		
		foreach($selected_keys as $selected) {
			echo '<select name="' . $get_options['id'] . '_' . $i . '" id="' . $get_options['id'] . '_' . $i . '">';
			if(isset($get_options['prompt'])){
				echo '<option value="">'.$get_options['prompt'].'</option>';
			}
			if (isset($get_options['options'])) {
				foreach($get_options['options'] as $key => $option) {
					echo '<option value="' . $key . '"';
					if ($selected == $key) {
						echo ' selected="selected"';
					}
					echo '>' . $option . '</option>';
				}
			}
			if (isset($get_options['page'])){
				$args = array(
					'depth' => $depth, 'child_of' => 0,
					'selected' => $selected, 'echo' => 1,
					'name' => 'page_id', 'id' => '',
					'show_option_none' => '', 'show_option_no_change' => '',
					'option_none_value' => ''
				);
				echo walk_page_dropdown_tree($pages,$depth,$args);
			}
			$i++;
			echo '</select>';
		}
		
		echo '<select name="' . $get_options['id'] . '_' . $i . '" id="' . $get_options['id'] . '_' . $i . '">';
		if(isset($get_options['prompt'])){
			echo '<option value="">'.$get_options['prompt'].'</option>';
		}
		if (isset($get_options['options'])) {
			foreach($get_options['options'] as $key => $option) {
				echo '<option value="' . $key . '">' . $option . '</option>';
			}
		}
		if (isset($get_options['page'])){
			$args = array(
				'depth' => $depth, 'child_of' => 0,
				'selected' => 0, 'echo' => 1,
				'name' => 'page_id', 'id' => '',
				'show_option_none' => '', 'show_option_no_change' => '',
				'option_none_value' => ''
			);
			echo walk_page_dropdown_tree($pages,$depth,$args);
		}
		echo '</select>';
		if(isset($get_options['desc'])){
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div></td></tr>';
	}
	
	/**
	 * displays a checkbox
	 */
	function wt_checkbox($get_options) {
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		if(isset($get_options['desc'])){
			echo '<p class="description">' . $get_options['desc'] . '</p>';
		}
		$i = 0;
		foreach($get_options['options'] as $key => $option) {
			$i++;
			$checked = '';
			if (isset($this->saved_options[$get_options['id']])) {
				if (is_array($this->saved_options[$get_options['id']])) {
					if (in_array($key, $this->saved_options[$get_options['id']])) {
						$checked = ' checked="checked"';
					}
				}
			} else if (in_array($key, $get_options['default'])) {
				$checked = ' checked="checked"';
			}
			
			echo '<input type="checkbox" id="' . $get_options['id'] . '_' . $i . '" name="' . $get_options['id'] . '[]" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $get_options['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		echo '</td></tr>';
	}
	
	/**
	 * displays checkboxs
	 */
	function wt_checkboxs($get_options) {
		$size = isset($get_options['size']) ? $get_options['size'] : '5';
		if (isset($get_options['target'])) {
			if (isset($get_options['options'])) {
				$get_options['options'] = $get_options['options'] + $this->wt_get_select_target_options($get_options['target']);
			} else {
				$get_options['options'] = $this->wt_get_select_target_options($get_options['target']);
			}
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		if(isset($get_options['desc'])){
			echo '<p class="description">' . $get_options['desc'] . '</p>';
		}
		
		if(!empty($get_options['options']) && is_array($get_options['options'])){
			foreach($get_options['options'] as $key => $option) {
				echo '<label><input type="checkbox" value="' . $key . '" name="' . $get_options['id'] . '[]"';
				if (isset($this->saved_options[$get_options['id']])) {
					if (is_array($this->saved_options[$get_options['id']])) {
						if (in_array($key, $this->saved_options[$get_options['id']])) {
							echo ' checked="checked"';
						}
					}
				} else if (in_array($key, $get_options['default'])) {
					echo ' checked="checked"';
				}
				echo '>' . $option . '</label><br/>';
			}
		}
		
		echo '</td></tr>';
	}
	
	/**
	 * displays a radio
	 */
	 
	function wt_radio($get_options) {
		
		if (isset($this->saved_options[$get_options['id']])) {
			$checked_key = $this->saved_options[$get_options['id']];
		} else {
			$checked_key = $get_options['default'];
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
				
		echo '<div class="my_theme_options">';
		$i = 0;
		foreach($get_options['options'] as $key => $option) {
			$i++;
			$checked = '';
			if ($key == $checked_key) {
				$checked = ' checked="checked"';
			}
			
			echo '<input type="radio" id="' . $get_options['id'] . '_' . $i . '" name="' . $get_options['id'] . '" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $get_options['id'] . '_' . $i . '" style="margin-right:10px;">' . $option . '</label>';
		}
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		echo '</td></tr>';
	}
	
	/**
	 * displays an upload field
	 
	 */
	 
	function wt_upload($get_options) {
		
		$button = isset($get_options['button']) ? $get_options['button'] : 'Insert Image';
		$removebutton = isset($get_options['button']) ? $get_options['button'] : 'Remove Image';
		if (isset($this->saved_options[$get_options['id']])) {
			$get_options['default'] = stripslashes($this->saved_options[$get_options['id']]);
		}	
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
			
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
		
		echo '<div class="my_theme_options">';
		isset($get_options['crop'])=="false" ? $crop=" no_crop" : $crop='';
		echo '<div id="' . $get_options['id'] . '_preview" class="image-preview'. $crop .'">';
		if (! empty($get_options['default'])) {			
			
			if (isset($get_options['crop'])=="false") {
				echo '<a class="thickbox" href="' . $get_options['default'] . '" target="_blank"><img src="' .$get_options['default']. '"/></a>';
			} else {
				$filename = substr($get_options['default'], 0, strrpos($get_options['default'], '.'));
				$extension = substr($get_options['default'], strrpos($get_options['default'], '.') + 1);
				echo '<a class="thickbox" href="' . $get_options['default'] . '" target="_blank"><img src="' . $filename . '-150x150.'.$extension.'"/></a>';
			}
		}	
		echo '</div>';	
		echo '<input type="text" id="' . $get_options['id'] . '" name="' . $get_options['id'] . '" size="50" class="upload-value"  value="';
		echo wt_check_input($get_options['default']);
		echo '" />';
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		global $wp_version;
		if(version_compare($wp_version, "3.5", '<')){
			echo '<div class="theme-upload-buttons"><a class="thickbox button theme-upload-button button-primary" id="' . $get_options['id'] . '_button" href="media-upload.php?&target=' . $get_options['id'] . '&option_image_upload=1&TB_iframe=1&width=640&height=529">' . $button . '</a>';
		} else {
			echo '<div class="theme-upload-buttons"><a href="#" class="button theme-upload-button button-primary" data-target="' .  $get_options['id']  . '" data-uploader_title="'.$button.'" data-uploader_button_text="'.$button.'" title="' . $button . '">' .$button . '</a>';
		}

		echo '<a class="button-secondary theme-upload-media-button theme-upload-remove" id="' . $get_options['id'] . '_remove">' . $removebutton . '</a>';
		echo '</div></div>';
		
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}		
	
	/**
	 * displays a range input
	 */
	 
	function wt_range($get_options) {		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr>'.$row_class .'<th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
		
		echo '<div class="my_theme_options">';
		
		echo '<div class="range-input-wrap"><input name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" type="range" value="';
		if (isset($this->saved_options[$get_options['id']])) {
			echo stripslashes($this->saved_options[$get_options['id']]);
		} else {
			echo esc_attr( $get_options['default'] );
		}
		if (isset($get_options['min'])) {
			echo '" min="' . $get_options['min'];
		}
		if (isset($get_options['max'])) {
			echo '" max="' . $get_options['max'];
		}
		if (isset($get_options['step'])) {
			echo '" step="' . $get_options['step'];
		}
		echo '" />';
		if (isset($get_options['unit'])) {
			echo '<span>' . $get_options['unit'] . '</span>';
		}		
		echo '</div>';
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top: -7px;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div>';
		}
		
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	/**
	 * displays a color input
	 */
	function wt_color($get_options) {		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		$value = '';
		if (isset($this->saved_options[$get_options['id']])) {
			$value =  wt_check_input($this->saved_options[$get_options['id']]);
		} else if (isset($get_options['default'])) {
			$value =  $get_options['default'];
		}
		if(empty($value)){
			$transparent = true;
		}else{
			$transparent = false;
		}
		
		// color input format
		if (isset($get_options['format']) && $get_options['format']=="hex") {
			$format = 'hex';
		} else if (isset($get_options['format']) && $get_options['format']=="rgba") {
			$format = 'rgba';
		} else {
			$format = 'rgba';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
		echo '<div class="my_theme_options">';
		
		echo '<div class="color-input-wrap"><input name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" type="text" '.($transparent?'data-transparent="true" ':'').'data-color-format="'.$format.'" value="' . $value . '" /></div>';
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top:7px; left:232px; position:absolute;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';	
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	/**
	 * displays a toggle checkbox
	 */
	function wt_toggle($get_options) {
		$checked = '';
		if (isset($this->saved_options[$get_options['id']])) {
			if ($this->saved_options[$get_options['id']] == true) {
				$checked = 'checked="checked"';
			}
		} elseif ($get_options['default'] == true) {
			$checked = 'checked="checked"';
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
		
		echo '<div class="my_theme_options">';
		
		echo '<input type="checkbox" class="toggle-button" name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" value="true" ' . $checked . ' />';
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top:3px; left:110px; position:absolute;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	/**
	 * displays a toggle checkbox
	 */
	function wt_tritoggle($get_options) {
		if (isset($this->saved_options[$get_options['id']])) {
			$get_options['default']=$this->saved_options[$get_options['id']];
		} 
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr><th scope="row"><h4>' . $get_options['name'] . '</h4>';
		} else {
			echo '<tr><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
		}
			
		echo '<div class="my_theme_options">';
		
		echo '<select class="tri-toggle-button" name="' . $get_options['id'] . '" id="' . $get_options['id'] . '">';
		echo '<option value="true"'.selected($get_options['default'],true).'>On</option>';
		echo '<option value="false"'.selected($get_options['default'],false).'>Off</option>';
		echo '<option value="default"'.selected($get_options['default'],'default').'>default</option>';
		echo '</select>';
		
		if(isset($get_options['desc'])){		
			echo '<div class="option_help" style="top:3px; left:140px; position:absolute;"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	/**
	 * displays a validator input
	 */
	function wt_validator($get_options) {
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		echo '<tr><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		if(isset($get_options['desc'])){
			echo '<p class="description">' . $get_options['desc'] . '</p>';
		}
		echo '<div class="validator-wrap"><input name="' . $get_options['id'] . '" id="' . $get_options['id'] . '" type="'. $get_options['format'].'" value="';
		if (isset($this->saved_options[$get_options['id']])) {
			echo stripslashes($this->saved_options[$get_options['id']]);
		} else {
			echo esc_attr( $get_options['default'] );
		}
		if (isset($get_options['max'])) {
			echo '" max="' . $get_options['max'];
		}
		if (isset($get_options['min'])) {
			echo '" min="' . $get_options['min'];
		}
		if (isset($get_options['pattern'])) {
			echo '" pattern="' . $get_options['pattern'];
		}
		if (isset($get_options['required'])) {
			echo '" required="required"';
		}
		if (isset($get_options['maxlength'])) {
			echo '" maxlength="' . $get_options['maxlength'];
		}
		if (isset($get_options['minlength'])) {
			echo '" minlength="' . $get_options['minlength'];
		}
		if (isset($get_options['error'])) {
			echo '" data-message="' . $get_options['error'];
		}
		echo '" /><span class="validator-error"></span></div>';
		echo '</td></tr>';
	}
	
	/**
	 * displays a editor
	 */
	function wt_editor($get_options) {
		$rows = isset($get_options['rows']) ? $get_options['rows'] : '7';
		if (isset($this->saved_options[$get_options['id']])) {
			$get_options['default'] = stripslashes($this->saved_options[$get_options['id']]);
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		// how many columns
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '<tr><th scope="row">';
		} else {
			echo '<tr'.$row_class .'><th scope="row"><h4><label for="'.$get_options['id'].'">' . $get_options['name'] . '</label></h4></th><td>';
		}
		
		echo '<div class="my_theme_options">';
				
		echo '<div id="poststuff"><div id="post-body"><div id="post-body-content"><div class="postarea" id="postdivrich">';
		wp_editor($get_options['default'],$get_options['id']);
		
		echo '<table id="post-status-info" cellspacing="0">';
		echo '<tbody><tr>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '</tr></tbody>';
		echo '</table>';
		echo '</div></div></div></div>';
		echo '</td></tr>';
		if(isset($get_options['desc'])){		
			echo '<div class="option_help"><a class="desc_help"><img src="'.THEME_ADMIN_ASSETS_URI.'/images/help_description.png"  alt="Description Info" /></a>';
			echo '<div class="tooltip">' . $get_options['desc'] . '</div></div></br>';
		}
		echo '</div>';
		if (isset($get_options['one_col'])=="true" || preg_match("/sc_/", $get_options['id'])) {
			echo '</th></tr>';
		} else {
			echo '</td></tr>';
		}
	}
	
	
	/**
	 * displays a custom field
	 */
	function wt_custom($get_options) {
		if (isset($this->saved_options[$get_options['id']])) {
			$default = $this->saved_options[$get_options['id']];
		} else {
			$default = $get_options['default'];
		}
		
		if(isset($get_options['row_class'])){
			$row_class = ' class="'.$get_options['row_class'].'"';
		} else {
			$row_class = '';
		}
		
		if(isset($get_options['layout']) && $get_options['layout']==false){
			if (isset($get_options['function']) && function_exists($get_options['function'])) {
				$get_options['function']($get_options, $default);
			} else {
				echo balanceTags( $get_options['html'] );
			}
		}else{
			echo '<tr><th scope="row"><h4>' . $get_options['name'] . '</h4></th><td>';
			if(isset($get_options['desc'])){
				echo '<p class="description">' . $get_options['desc'] . '</p>';
			}
			if (isset($get_options['function']) && function_exists($get_options['function'])) {
				$get_options['function']($get_options, $default);
			} else {
				echo balanceTags( $get_options['html'] );
			}
			echo '</td></tr>';
		}
	}
	
	function wt_get_select_target_options($type) {
        $options = array();
		switch($type){
			case 'page':
				$entries = get_pages('title_li=&orderby=name');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'cat':
				$entries = get_categories('orderby=name&hide_empty=0');
				foreach($entries as $key => $entry) {
					$options[$entry->term_id] = $entry->name;
				}
				break;
			case 'author':
				global $wpdb;
				$meta_key = 'wp_user_level';
				$order = 'user_id';
				$user_ids = $wpdb->get_col($wpdb->prepare("SELECT $wpdb->usermeta.user_id FROM $wpdb->usermeta where meta_key=%s and meta_value>=1 ORDER BY %s ASC",$meta_key,$order));
				foreach($user_ids as $user_id) :
					$user = get_userdata($user_id);
					$options[$user_id] = $user->display_name;
				endforeach;
				break;
			case 'post':
				$entries = get_posts('orderby=title&numberposts=-1&order=ASC&suppress_filters=0');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'wt_portfolio':
				$entries = get_posts('post_type=wt_portfolio&orderby=title&numberposts=-1&order=ASC&suppress_filters=0');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'wt_portfolio_category':
				$entries = get_terms('wt_portfolio_category','orderby=name&hide_empty=0&suppress_filters=0');
				foreach($entries as $key => $entry) {
					$options[$entry->slug] = $entry->name;
				}
				break;
			case 'post_types':
				foreach( get_post_types( array( 'show_ui' => true), 'objects' ) as $post_type ) {
					$options[$post_type->name] = esc_html($post_type->labels->name).' ('.esc_html($post_type->name).')';
				}
		}
		return $options;
	}
}