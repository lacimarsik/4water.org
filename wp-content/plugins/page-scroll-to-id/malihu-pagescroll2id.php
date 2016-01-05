<?php
/*
Plugin Name: Page scroll to id
Plugin URI: http://manos.malihu.gr/page-scroll-to-id
Description: Page scroll to id is an easy-to-use jQuery plugin that enables animated page scrolling to specific id within the document. 
Version: 1.6.0
Author: malihu
Author URI: http://manos.malihu.gr
License: MIT License (MIT)
Text Domain: page-scroll-to-id
Domain Path: /languages
*/

/*
Copyright 2013  malihu  (email: manos@malihu.gr)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

if(!defined('WPINC')){ die; } // Abort if file is called directly

if(!class_exists('malihuPageScroll2id')){ // --edit--
	
	/*
	Plugin uses the following db options: 
	db_prefix_version (holds plugin version) 
	db_prefix_instances (holds all plugin instances and their settings in a single array) 
	*/
	
	/* to setup, search for: --edit-- */
	
	class malihuPageScroll2id{ // --edit--
		
		protected $version='1.6.0'; // Plugin version --edit--
		protected $update_option=null;
		
		protected $plugin_name='Page scroll to id'; // Plugin name --edit--
		protected $plugin_slug='page-scroll-to-id'; // Plugin slug --edit--
		protected $db_prefix='page_scroll_to_id_'; // Database field plugin prefix --edit--
		protected $pl_pfx='mPS2id_'; // Plugin prefix --edit--
		protected $sc_pfx='ps2id'; // Shortcode prefix --edit--
		
		protected static $instance=null;
		protected $plugin_screen_hook_suffix=null;
		
		protected $index=0;
		protected $default;
		
		protected $plugin_script='jquery.malihu.PageScroll2id.js'; // Plugin public script (main js plugin file) --edit--
		protected $plugin_init_script='jquery.malihu.PageScroll2id-init.js'; // Plugin public initialization script --edit--
		
		private function __construct(){
			// Plugin requires PHP version 5.2 or higher
			if(version_compare(PHP_VERSION, '5.2', '<')){
				add_action('admin_notices', array($this, 'admin_notice_php_version'));
				return;
			}
			// Plugin requires WP version 3.3 or higher
			if(version_compare(get_bloginfo('version'), '3.3', '<')){
				add_action('admin_notices', array($this, 'admin_notice_wp_version'));
				return;
			}
			// Plugin default params
			$this->default=array(
				$this->pl_pfx.'instance_'.$this->index => $this->plugin_options_array('defaults',$this->index,null,null)
			);
			// Add textdomain
			add_action('plugins_loaded', array($this, 'init_localization'));
			// Add the options page and menu item.
			add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
			// Upgrade plugin
			add_action('admin_init', array($this, 'upgrade_plugin'));
			// Add/save plugin settings.
			add_action('admin_init', array($this, 'add_plugin_settings'));
			// Load admin stylesheet and javaScript.
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
			// load public stylesheet and javaScript.
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
			// Add plugin settings link
			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'add_plugin_action_links'));
			// Add contextual help for the plugin
			add_action('contextual_help', array($this, 'plugin_contextual_help'), 10, 3);
		}
		
		public static function get_instance(){
			if(null==self::$instance){
				self::$instance=new self;
			}
			
			return self::$instance;
		}
		
		// PHP version notice
		public function admin_notice_php_version(){
			_e('<div class="error"><p><strong>'.$this->plugin_name.'</strong> requires PHP version <strong>5.2</strong> or higher.</p></div>', $this->plugin_slug);
		}
		
		// WP version notice
		public function admin_notice_wp_version(){
			_e('<div class="error"><p><strong>'.$this->plugin_name.'</strong> requires WordPress version <strong>3.3</strong> or higher. Deactivate the plugin and reactivate when WordPress is updated.</p></div>', $this->plugin_slug);
		}
		
		// Plugin localization (load plugin textdomain)
		public function init_localization(){
			if(!load_plugin_textdomain($this->plugin_slug, false, WP_LANG_DIR)){
				load_plugin_textdomain($this->plugin_slug, false, dirname(plugin_basename(__FILE__)).'/languages/'); 
			}
		}
		
		// Admin styles
		public function enqueue_admin_styles(){
			if(!isset($this->plugin_screen_hook_suffix)){
				return;
			}
			$screen=get_current_screen();
			// If this is the plugin's settings page, load admin styles
			if($screen->id==$this->plugin_screen_hook_suffix){ 
				wp_enqueue_style($this->plugin_slug.'-admin-styles', plugins_url('css/admin.css', __FILE__), $this->version);
			}
		}
		
		// Admin scripts
		public function enqueue_admin_scripts(){
			if(!isset($this->plugin_screen_hook_suffix)){
				return;
			}
			$screen=get_current_screen();
			// If this is the plugin's settings page, load admin scripts
			if($screen->id==$this->plugin_screen_hook_suffix){ 
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script($this->plugin_slug.'-admin-script', plugins_url('js/admin.js', __FILE__), array('jquery', 'jquery-ui-sortable'), $this->version, 1);
				$params=array(
			  		'id' => $this->pl_pfx.'form',
					'db_prefix' => $this->db_prefix,
					'sc_prefix' => $this->sc_pfx
				);
				wp_localize_script($this->plugin_slug.'-admin-script', '_adminParams', $params);
			}
		}
		
		// front-end plugin scripts
		public function enqueue_scripts(){
			wp_enqueue_script('jquery');
			wp_register_script($this->plugin_slug.'-plugin-script', plugins_url('js/'.$this->plugin_script, __FILE__), array('jquery'), $this->version, 1);
			wp_enqueue_script($this->plugin_slug.'-plugin-script');
			wp_register_script($this->plugin_slug.'-plugin-init-script', plugins_url('js/'.$this->plugin_init_script, __FILE__), array('jquery', $this->plugin_slug.'-plugin-script'), $this->version, 1);
			wp_enqueue_script($this->plugin_slug.'-plugin-init-script');
			$this->plugin_fn_call();
			$this->add_plugin_shortcode(); // Remove/comment for plugin without any shortcodes --edit-- 
		}
		
		public function add_plugin_admin_menu(){
			$this->plugin_screen_hook_suffix=add_options_page(
				__($this->plugin_name, $this->plugin_slug),
				__($this->plugin_name, $this->plugin_slug),
				'manage_options',
				$this->plugin_slug,
				array($this, 'display_plugin_admin_page')
			);
		}
		
		public function add_plugin_settings(){
			// All plugin settings are saved as array in a single option
			register_setting($this->plugin_slug, $this->db_prefix.'instances', $this->validate_plugin_settings());
			// Get plugin options array
			$pl_instances=get_option($this->db_prefix.'instances', $this->default);
			// Loop the array to generate instances, fields etc.
			// Add settings section for each plugin instance
			while(list($var, $val)=each($pl_instances)){
				add_settings_section(
					$this->db_prefix.'settings_section'.$this->index,
					null,
					'__return_false', // instead of null to avoid wp <3.4.1 warnings (https://core.trac.wordpress.org/ticket/21630)
					$this->plugin_slug
				);
				// Add settings fields for each section
				while(list($var2, $val2)=each($val)){
					while(list($var3, $val3)=each($val2)){
						switch($var3){
						    case 'value':
						        $i_val=$val3;
						        break;
						    case 'values':
						        $i_vals=$val3;
						        break;
							case 'id':
						         $i_id=$val3;
						        break;
						    case 'field_type':
						         $i_field_type=$val3;
						        break;
							case 'label':
						         $i_label=$val3;
						        break;
							case 'checkbox_label':
						         $i_checkbox_label=$val3;
						        break;
							case 'radio_labels':
						         $i_radio_labels=$val3;
						        break;
							case 'field_info':
						         $i_field_info=$val3;
						        break;
							case 'description':
						         $i_description=$val3;
						        break;
							case 'wrapper':
						         $i_wrapper=$val3;
						        break;
						}
					}
					add_settings_field(
						$i_id,
						$i_label,
						array($this, 'instance_field_callback'),
						$this->plugin_slug,
						$this->db_prefix.'settings_section'.$this->index,
						array(
							'value' => $i_val,
							'values' => $i_vals,
							'id' => $i_id,
							'field_type' => $i_field_type,
							'label_for' => ($i_field_type!=='checkbox' && $i_field_type!=='radio') ? $i_id : null,
							'checkbox_label' => $i_checkbox_label,
							'radio_labels' => $i_radio_labels,
							'field_info' => $i_field_info,
							'description' => $i_description,
							'wrapper' => $i_wrapper
						)
				    );
				}
				$this->index++;
			}
		}
		
		public function instance_field_callback($args){
			$html=(!empty($args['wrapper'])) ? '<'.$args['wrapper'].'>' : '';
			if($args['field_type']=='text'){ // Text field
				$html.='<input type="text" id="'.$args['id'].'" name="'.$args['id'].'" value="'.$args['value'].'" class="regular-text code" /> ';
			}else if($args['field_type']=='text-integer'){ // Text field - integer
				$html.='<input type="text" id="'.$args['id'].'" name="'.$args['id'].'" value="'.$args['value'].'" class="small-text" /> ';
			}else if($args['field_type']=='checkbox'){ // Checkbox
				(!empty($args['checkbox_label'])) ? $html.='<label for="'.$args['id'].'">' : $html.='';
				$html.='<input type="checkbox" id="'.$args['id'].'" name="'.$args['id'].'" value="true" '.checked('true', $args['value'], false).' /> ';
				(!empty($args['checkbox_label'])) ? $html.=$args['checkbox_label'].'</label> ' : $html.='';
			}else if($args['field_type']=='select'){ // Select/dropdown
				$html.='<select id="'.$args['id'].'" name="'.$args['id'].'">';
				$select_options=explode(',', $args['values']);
				foreach($select_options as $select_option){
					$html.='<option value="'.$select_option.'" '.selected($select_option, $args['value'], false).'>'.$select_option.'</option>';
				}
				$html.= '</select> ';
			}else if($args['field_type']=='radio'){ // Radio buttons
				$radio_buttons=explode(',', $args['values']);
				$radio_labels=explode('|', $args['radio_labels']);
				$i=0;
				foreach($radio_buttons as $radio_button){
					$html.='<label title="'.$radio_button.'"><input type="radio" name="'.$args['id'].'" value="'.$radio_button.'" '.checked($radio_button, $args['value'], false).' /> <span>'.$radio_labels[$i].'</span> </label> ';
					$html.=($radio_button===end($radio_buttons)) ? '' : '<br />';
					$i++;
				}
			}else if($args['field_type']=='textarea'){ // Textarea
				$html.='<textarea id="'.$args['id'].'" name="'.$args['id'].'" rows="10" cols="50" class="large-text code">'.$args['value'].'</textarea> ';
			}else if($args['field_type']=='hidden'){ // Hidden field
				$html.='<input type="hidden" id="'.$args['id'].'" name="'.$args['id'].'" value="'.$args['value'].'" /> ';
			}
			$html.=(!empty($args['wrapper'])) ? '</'.$args['wrapper'].'>' : '';
			(!empty($args['field_info'])) ? $html.='<span>'.$args['field_info'].'</span> ' : $html.='';
			(!empty($args['description'])) ? $html.='<p class="description">'.$args['description'].'</p>' : $html.='';
			echo $html;
		}
		
		public function display_plugin_admin_page(){
			include_once(plugin_dir_path( __FILE__ ).'includes/admin.php');
		}
		
		public function add_plugin_action_links($links){
			$settings_link='<a href="options-general.php?page='.$this->plugin_slug.'">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
		
		public function plugin_fn_call(){
			$instances=get_option($this->db_prefix.'instances');
			$params=array(
				'instances' => $instances,
				'total_instances' => count($instances),
				'shortcode_class' => '_'.$this->sc_pfx
			);
			wp_localize_script($this->plugin_slug.'-plugin-init-script', $this->pl_pfx.'params', $params);
		}
		
		public function add_plugin_shortcode(){
			$pl_shortcodes=array();
			$pl_shortcodes_b=array();
			$instances=get_option($this->db_prefix.'instances');
			for($i=1; $i<=count($instances); $i++){
				$pl_shortcodes[]='pl_shortcode_fn_'.$i;
				$pl_shortcodes_b[]='pl_shortcode_fn_'.$i;
				// --edit--
				$tag=$shortcode_class=$this->sc_pfx; // Shortcode without suffix 
				$tag_b=$this->sc_pfx.'_wrap'; // Shortcode without suffix 
				//$tag=$shortcode_class=$this->sc_pfx.'_'.$i; // Shortcode with suffix 
				$pl_shortcodes[$i]=create_function('$atts,$content=null','
					extract(shortcode_atts(array( 
						"i" => "'.$i.'",
						"shortcode_class" => "_'.$shortcode_class.'",
						"url" => "",
						"offset" => "",
						"id" => "",
						"target" => "",
					), $atts));
					if($id!==""){
						if($content){
							return "<div id=\"".$id."\" data-ps2id-target=\"".sanitize_text_field($target)."\">".do_shortcode($content)."</div>";
						}else{
							return "<a id=\"".$id."\" data-ps2id-target=\"".sanitize_text_field($target)."\">".do_shortcode($content)."</a>";
						}
					}else{
						return "<a href=\"".$url."\" class=\"".$shortcode_class."\" data-ps2id-offset=\"".esc_attr($offset)."\">".do_shortcode($content)."</a>";
					}
				');
				add_shortcode($tag, $pl_shortcodes[$i]);
				$pl_shortcodes_b[$i]=create_function('$atts,$content=null','
					extract(shortcode_atts(array( 
						"i" => "'.$i.'",
						"id" => "",
						"target" => "",
					), $atts));
					if($id!==""){
						return "<div id=\"".$id."\" data-ps2id-target=\"".sanitize_text_field($target)."\">".do_shortcode($content)."</div>";
					}
				');
				add_shortcode($tag_b, $pl_shortcodes_b[$i]);
			}
		}
		
		public function validate_plugin_settings(){
			if(!empty($_POST)){
				if(isset($_POST[$this->db_prefix.'reset']) && $_POST[$this->db_prefix.'reset']==='true'){ 
					// Reset all to default
					$_POST[$this->db_prefix.'instances']=$this->default; 
				}else{ 
					// Update settings array
					if(isset($_POST[$this->db_prefix.'total_instances'])){
						$instances=$_POST[$this->db_prefix.'total_instances'];
						for($i=0; $i<$instances; $i++){
							$instance=$this->plugin_options_array('validate',$i,null,null);
							$update[$this->pl_pfx.'instance_'.$i]=$instance;
						}
						$_POST[$this->db_prefix.'instances']=$update; // Save array to plugin option
					}
				}
			}
		}
		
		public function sanitize_input($type, $val, $def){
			switch($type){
				case 'text': // General
					$val=(empty($val)) ? $def : sanitize_text_field($val);
					break;
				case 'number': // Positive number
					$val=(int) preg_replace('/\D/', '', $val);
					break;
				case 'integer': // Positive or negative number
					$s=strpos($val, '-');
					$n=(int) preg_replace('/\D/', '', $val);
					$val=($s===false) ? $n : '-'.$n;
					break;
				case 'class': // Class name
					$val=sanitize_html_class($val, $def);
					break;
			}
			return $val;
		}
		
		public function upgrade_plugin(){
			// Get/set plugin version
			$current_version=get_option($this->db_prefix.'version');
			if(!$current_version){
				add_option($this->db_prefix.'version', $this->version);
				$old_db_options=$this->get_plugin_old_db_options(); // Get old/deprecated plugin db options --edit--
				$this->delete_plugin_old_db_options(); // Delete old/deprecated plugin db options --edit--
			}else{
				$old_db_options=null; // Old/deprecated plugin db options --edit--
			}
			if($this->version!==$current_version){
				// Update plugin options to new version ones
				$pl_instances=get_option($this->db_prefix.'instances');
				for($i=0; $i<count($pl_instances); $i++){
					$j=$pl_instances[$this->pl_pfx.'instance_'.$i];
					$instance=$this->plugin_options_array('upgrade',$i,$j,$old_db_options); // --edit--
					$update[$this->pl_pfx.'instance_'.$i]=$instance;
				}
				$this->update_option=update_option($this->db_prefix.'instances', $update); // Update options
				update_option($this->db_prefix.'version', $this->version); // Update version
			}
		}
		
		// --edit--
		public function get_plugin_old_db_options(){
			$old_db_opt1=get_option('malihu_pagescroll2id_sel');
			$old_db_opt2=get_option('malihu_pagescroll2id_scrollSpeed');
			$old_db_opt3=get_option('malihu_pagescroll2id_autoScrollSpeed');
			$old_db_opt4=get_option('malihu_pagescroll2id_scrollEasing');
			$old_db_opt5=get_option('malihu_pagescroll2id_scrollingEasing');
			$old_db_opt6=get_option('malihu_pagescroll2id_pageEndSmoothScroll');
			$old_db_opt7=get_option('malihu_pagescroll2id_layout');
			return array(  
				($old_db_opt1) ? $old_db_opt1 : 'a[rel=\'m_PageScroll2id\']',
				($old_db_opt2) ? $old_db_opt2 : 1300,
				($old_db_opt3) ? $old_db_opt3 : 'true',
				($old_db_opt4) ? $old_db_opt4 : 'easeInOutExpo',
				($old_db_opt5) ? $old_db_opt5 : 'easeInOutCirc',
				($old_db_opt6) ? $old_db_opt6 : 'true',
				($old_db_opt7) ? $old_db_opt7 : 'vertical'
			);
		}
		
		// --edit--
		public function delete_plugin_old_db_options(){
			delete_option('malihu_pagescroll2id_sel');
			delete_option('malihu_pagescroll2id_scrollSpeed');
			delete_option('malihu_pagescroll2id_autoScrollSpeed');
			delete_option('malihu_pagescroll2id_scrollEasing');
			delete_option('malihu_pagescroll2id_scrollingEasing');
			delete_option('malihu_pagescroll2id_pageEndSmoothScroll');
			delete_option('malihu_pagescroll2id_layout');
		}
		
		private function debug_to_console($data){
			/* 
			This is just a helper function that sends debug code to the Javascript console 
			Usage: $this->debug_to_console('hello world'); 
			*/
			echo('<script>var _debugData_='.json_encode($data).'; console.log("PHP: "+_debugData_);</script>');
		}
		
		public function plugin_contextual_help($contextual_help, $screen_id, $screen){
			 if(strcmp($screen->id, $this->plugin_screen_hook_suffix)==0){
				if(get_bloginfo('version') >= '3.6'){
					// --edit--
					// Multiple contextual help files/tabs
					ob_start();
					include_once(plugin_dir_path( __FILE__ ).'includes/help/overview.inc');
					$help_overview=ob_get_contents();
					ob_end_clean();
					ob_start();
					include_once(plugin_dir_path( __FILE__ ).'includes/help/get-started.inc');
					$help_get_started=ob_get_contents();
					ob_end_clean();
					ob_start();
					include_once(plugin_dir_path( __FILE__ ).'includes/help/plugin-settings.inc');
					$help_plugin_settings=ob_get_contents();
					ob_end_clean();
					ob_start();
					include_once(plugin_dir_path( __FILE__ ).'includes/help/shortcodes.inc');
					$help_plugin_shortcodes=ob_get_contents();
					ob_end_clean();
					ob_start();
					include_once(plugin_dir_path( __FILE__ ).'includes/help/sidebar.inc');
					$help_sidebar=ob_get_contents();
					ob_end_clean();
					if(method_exists($screen, 'add_help_tab')){
						$screen->add_help_tab(array(
							'id' => $this->plugin_slug.'overview',
							'title' => 'Overview',
							'content' => $help_overview,
						));
						$screen->add_help_tab(array(
							'id' => $this->plugin_slug.'get-started',
							'title' => 'Get started',
							'content' => $help_get_started,
						));
						$screen->add_help_tab(array(
							'id' => $this->plugin_slug.'plugin-settings',
							'title' => 'Plugin settings',
							'content' => $help_plugin_settings,
						));
						$screen->add_help_tab(array(
							'id' => $this->plugin_slug.'shortcodes',
							'title' => 'Shortcodes',
							'content' => $help_plugin_shortcodes,
						));
						$screen->set_help_sidebar($help_sidebar);
					}
					return $contextual_help;
				}
			 }
			 return $contextual_help;
		}
		
		public function plugin_options_array($action, $i, $j, $old){
			// --edit--
			// Defaults
			$d0='a[rel=\'m_PageScroll2id\']';
			$d1=1300;
			$d2='true';
			$d3='easeInOutExpo';
			$d4='easeInOutCirc';
			$d5='true';
			$d6='vertical';
			$d7=0;
			$d8='';
			$d9='mPS2id-clicked';
			$d10='mPS2id-target';
			$d11='mPS2id-highlight';
			$d12='false';
			$d14='false';
			$d16='false';
			$d13='false';
			$d17='false';
			$d18=0;
			$d15=0;
			// Values
			switch($action){
				case 'validate':
					$v0=$this->sanitize_input('text', $_POST[$this->db_prefix.$i.'_selector'], $d0);
					$v1=$this->sanitize_input('number', $_POST[$this->db_prefix.$i.'_scrollSpeed'], $d1);
					$v2=(isset($_POST[$this->db_prefix.$i.'_autoScrollSpeed'])) ? 'true' : 'false';
					$v3=$_POST[$this->db_prefix.$i.'_scrollEasing'];
					$v4=$_POST[$this->db_prefix.$i.'_scrollingEasing'];
					$v5=(isset($_POST[$this->db_prefix.$i.'_pageEndSmoothScroll'])) ? 'true' : 'false';
					$v6=$_POST[$this->db_prefix.$i.'_layout'];
					$v7=$this->sanitize_input('text', $_POST[$this->db_prefix.$i.'_offset'], $d7);
					$v8=(empty($_POST[$this->db_prefix.$i.'_highlightSelector'])) ? $d8 : $this->sanitize_input('text', $_POST[$this->db_prefix.$i.'_highlightSelector'], $d8);
					$v9=$this->sanitize_input('class', $_POST[$this->db_prefix.$i.'_clickedClass'], $d9);
					$v10=$this->sanitize_input('class', $_POST[$this->db_prefix.$i.'_targetClass'], $d10);
					$v11=$this->sanitize_input('class', $_POST[$this->db_prefix.$i.'_highlightClass'], $d11);
					$v12=(isset($_POST[$this->db_prefix.$i.'_forceSingleHighlight'])) ? 'true' : 'false';
					$v14=(isset($_POST[$this->db_prefix.$i.'_keepHighlightUntilNext'])) ? 'true' : 'false';
					$v16=(isset($_POST[$this->db_prefix.$i.'_highlightByNextTarget'])) ? 'true' : 'false';
					$v13=(isset($_POST[$this->db_prefix.$i.'_scrollToHash'])) ? 'true' : 'false';
					$v17=(isset($_POST[$this->db_prefix.$i.'_scrollToHashForAll'])) ? 'true' : 'false';
					$v18=$this->sanitize_input('number', $_POST[$this->db_prefix.$i.'_scrollToHashDelay'], $d18);
					$v15=$this->sanitize_input('text', $_POST[$this->db_prefix.$i.'_disablePluginBelow'], $d15);
					break;
				case 'upgrade':
					if(isset($old)){
						$v0=$old[0];
						$v1=$old[1];
						$v2=$old[2];
						$v3=$old[3];
						$v4=$old[4];
						$v5=$old[5];
						$v6=$old[6];
					}else{
						$v0=(isset($j['selector'])) ? $j['selector']['value'] : $d0;
						$v1=(isset($j['scrollSpeed'])) ? $j['scrollSpeed']['value'] : $d1;
						$v2=(isset($j['autoScrollSpeed'])) ? $j['autoScrollSpeed']['value'] : $d2;
						$v3=(isset($j['scrollEasing'])) ? $j['scrollEasing']['value'] : $d3;
						$v4=(isset($j['scrollingEasing'])) ? $j['scrollingEasing']['value'] : $d4;
						$v5=(isset($j['pageEndSmoothScroll'])) ? $j['pageEndSmoothScroll']['value'] : $d5;
						$v6=(isset($j['layout'])) ? $j['layout']['value'] : $d6;
					}
					$v7=(isset($j['offset'])) ? $j['offset']['value'] : $d7;
					$v8=(isset($j['highlightSelector'])) ? $j['highlightSelector']['value'] : $d8;
					$v9=(isset($j['clickedClass'])) ? $j['clickedClass']['value'] : $d9;
					$v10=(isset($j['targetClass'])) ? $j['targetClass']['value'] : $d10;
					$v11=(isset($j['highlightClass'])) ? $j['highlightClass']['value'] : $d11;
					$v12=(isset($j['forceSingleHighlight'])) ? $j['forceSingleHighlight']['value'] : $d12;
					$v14=(isset($j['keepHighlightUntilNext'])) ? $j['keepHighlightUntilNext']['value'] : $d14;
					$v16=(isset($j['highlightByNextTarget'])) ? $j['highlightByNextTarget']['value'] : $d16;
					$v13=(isset($j['scrollToHash'])) ? $j['scrollToHash']['value'] : $d13;
					$v17=(isset($j['scrollToHashForAll'])) ? $j['scrollToHashForAll']['value'] : $d17;
					$v18=(isset($j['scrollToHashDelay'])) ? $j['scrollToHashDelay']['value'] : $d18;
					$v15=(isset($j['disablePluginBelow'])) ? $j['disablePluginBelow']['value'] : $d15;
					break;
				default:
					$v0=$d0;
					$v1=$d1;
					$v2=$d2;
					$v3=$d3;
					$v4=$d4;
					$v5=$d5;
					$v6=$d6;
					$v7=$d7;
					$v8=$d8;
					$v9=$d9;
					$v10=$d10;
					$v11=$d11;
					$v12=$d12;
					$v14=$d14;
					$v16=$d16;
					$v13=$d13;
					$v17=$d17;
					$v18=$d18;
					$v15=$d15;
			}
			// Options array
			/*
			option name
				option value 
				option values (for dropdowns, radio buttons) 
				field id 
				field type (e.g. text, checkbox etc.) 
				option setting title (also label for non checkboxes and radio buttons) 
				label for checkbox 
				labels for radio buttons 
				small information text (as span next to field/fieldset) 
				option setting description (as paragraph below the field/fieldset) 
				fields wrapper element (e.g. fieldset) 
			*/
			return array(
				'selector' => array(
					'value' => $v0,
					'values' => null,
					'id' => $this->db_prefix.$i.'_selector',
					'field_type' => 'text',
					'label' => 'Selector(s)',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'The link(s) that will scroll the page when clicked. Defaults to all links with <code>m_PageScroll2id</code> rel attribute value',
					'wrapper' => null
				),
				'scrollSpeed' => array(
					'value' => $v1,
					'values' => null,
					'id' => $this->db_prefix.$i.'_scrollSpeed',
					'field_type' => 'text-integer',
					'label' => 'Scroll animation speed',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'milliseconds',
					'description' => 'Scroll animation speed in milliseconds (1000 milliseconds equals 1 second)',
					'wrapper' => null
				),
				'autoScrollSpeed' => array(
					'value' => $v2,
					'values' => null,
					'id' => $this->db_prefix.$i.'_autoScrollSpeed',
					'field_type' => 'checkbox',
					'label' => '',
					'checkbox_label' => 'Auto-adjust animation speed',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Auto-adjust animation speed according to target element position and window scroll',
					'wrapper' => 'fieldset'
				),
				'scrollEasing' => array(
					'value' => $v3,
					'values' => 'linear,swing,easeInQuad,easeOutQuad,easeInOutQuad,easeInCubic,easeOutCubic,easeInOutCubic,easeInQuart,easeOutQuart,easeInOutQuart,easeInQuint,easeOutQuint,easeInOutQuint,easeInExpo,easeOutExpo,easeInOutExpo,easeInSine,easeOutSine,easeInOutSine,easeInCirc,easeOutCirc,easeInOutCirc,easeInElastic,easeOutElastic,easeInOutElastic,easeInBack,easeOutBack,easeInOutBack,easeInBounce,easeOutBounce,easeInOutBounce',
					'id' => $this->db_prefix.$i.'_scrollEasing',
					'field_type' => 'select',
					'label' => 'Scroll animation easing',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Animation easing when page is idle',
					'wrapper' => null
				),
				'scrollingEasing' => array(
					'value' => $v4,
					'values' => 'linear,swing,easeInQuad,easeOutQuad,easeInOutQuad,easeInCubic,easeOutCubic,easeInOutCubic,easeInQuart,easeOutQuart,easeInOutQuart,easeInQuint,easeOutQuint,easeInOutQuint,easeInExpo,easeOutExpo,easeInOutExpo,easeInSine,easeOutSine,easeInOutSine,easeInCirc,easeOutCirc,easeInOutCirc,easeInElastic,easeOutElastic,easeInOutElastic,easeInBack,easeOutBack,easeInOutBack,easeInBounce,easeOutBounce,easeInOutBounce',
					'id' => $this->db_prefix.$i.'_scrollingEasing',
					'field_type' => 'select',
					'label' => '',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Animation easing while page is animating',
					'wrapper' => null
				),
				'pageEndSmoothScroll' => array(
					'value' => $v5,
					'values' => null,
					'id' => $this->db_prefix.$i.'_pageEndSmoothScroll',
					'field_type' => 'checkbox',
					'label' => 'Scroll-to position',
					'checkbox_label' => 'Auto-adjust',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Auto-adjust the scroll-to position so it does not exceed document length',
					'wrapper' => 'fieldset'
				),
				'layout' => array(
					'value' => $v6,
					'values' => 'vertical,horizontal,auto',
					'id' => $this->db_prefix.$i.'_layout',
					'field_type' => 'radio',
					'label' => 'Page layout',
					'checkbox_label' => null,
					'radio_labels' => 'vertical|horizontal|auto',
					'field_info' => null,
					'description' => 'Restrict page scrolling to top-bottom (vertical) or left-right (horizontal) accordingly. For both vertical and horizontal scrolling select <code>auto</code>',
					'wrapper' => 'fieldset'
				),
				'offset' => array(
					'value' => $v7,
					'values' => null,
					'id' => $this->db_prefix.$i.'_offset',
					'field_type' => 'text',
					'label' => 'Offset',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'pixels',
					'description' => 'Offset scroll-to position by x amount of pixels (positive or negative) or by selector (e.g. <code>#navigation-menu</code>)',
					'wrapper' => null
				),
				'highlightSelector' => array(
					'value' => $v8,
					'values' => null,
					'id' => $this->db_prefix.$i.'_highlightSelector',
					'field_type' => 'text',
					'label' => 'Highlight selector(s)',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'The link(s) that are highlighted. Leave empty to highlight all or enter your specific selector(s)',
					'wrapper' => null
				),
				'clickedClass' => array(
					'value' => $v9,
					'values' => null,
					'id' => $this->db_prefix.$i.'_clickedClass',
					'field_type' => 'text',
					'label' => 'Classes',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'class name',
					'description' => 'Class of the clicked link',
					'wrapper' => null
				),
				'targetClass' => array(
					'value' => $v10,
					'values' => null,
					'id' => $this->db_prefix.$i.'_targetClass',
					'field_type' => 'text',
					'label' => '',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'class name',
					'description' => 'Class of the (current) target element. First (current) target element class suffix: <code>-first</code> (e.g. <code>.mPS2id-target-first</code>). Last (current) target element class suffix: <code>-last</code> (e.g. <code>.mPS2id-target-last</code>)',
					'wrapper' => null
				),
				'highlightClass' => array(
					'value' => $v11,
					'values' => null,
					'id' => $this->db_prefix.$i.'_highlightClass',
					'field_type' => 'text',
					'label' => '',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'class name',
					'description' => 'Class of the (current) highlighted element. First (current) highlighted element class suffix: <code>-first</code> (e.g. <code>.mPS2id-highlight-first</code>). Last (current) highlighted element class suffix: <code>-last</code> (e.g. <code>.mPS2id-highlight-last</code>)',
					'wrapper' => null
				),
				'forceSingleHighlight' => array(
					'value' => $v12,
					'values' => null,
					'id' => $this->db_prefix.$i.'_forceSingleHighlight',
					'field_type' => 'checkbox',
					'label' => '',
					'checkbox_label' => 'Force single highlight',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Allow only one highlighted element at a time',
					'wrapper' => 'fieldset'
				),
				'keepHighlightUntilNext' => array(
					'value' => $v14,
					'values' => null,
					'id' => $this->db_prefix.$i.'_keepHighlightUntilNext',
					'field_type' => 'checkbox',
					'label' => '',
					'checkbox_label' => 'Keep highlight until next',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Keep the current element highlighted until the next one comes into view',
					'wrapper' => 'fieldset'
				),
				'highlightByNextTarget' => array(
					'value' => $v16,
					'values' => null,
					'id' => $this->db_prefix.$i.'_highlightByNextTarget',
					'field_type' => 'checkbox',
					'label' => '',
					'checkbox_label' => 'Highlight by next target',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Set targets length according to their next adjacent target position (useful when target elements have zero dimensions)',
					'wrapper' => 'fieldset'
				),
				'scrollToHash' => array(
					'value' => $v13,
					'values' => null,
					'id' => $this->db_prefix.$i.'_scrollToHash',
					'field_type' => 'checkbox',
					'label' => 'Scroll to location hash',
					'checkbox_label' => 'Enable',
					'radio_labels' => null,
					'field_info' => null,
					'description' => 'Scroll to target id (e.g. <code>&lt;div id="id" /&gt;</code>) based on location hash (e.g. <code>mysite.com/mypage#id</code>) on page load',
					'wrapper' => 'fieldset'
				),
				'scrollToHashForAll' => array(
					'value' => $v17,
					'values' => null,
					'id' => $this->db_prefix.$i.'_scrollToHashForAll',
					'field_type' => 'checkbox',
					'label' => '',
					'checkbox_label' => 'Enable for all targets (even for elements that are not handled by the plugin)',
					'radio_labels' => null,
					'field_info' => null,
					'description' => null,
					'wrapper' => 'fieldset'
				),
				'scrollToHashDelay' => array(
					'value' => $v18,
					'values' => null,
					'id' => $this->db_prefix.$i.'_scrollToHashDelay',
					'field_type' => 'text-integer',
					'label' => '',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'Delay (milliseconds)',
					'description' => 'Scroll to location hash animation delay in milliseconds (1000 milliseconds equals 1 second)',
					'wrapper' => null
				),
				'disablePluginBelow' => array(
					'value' => $v15,
					'values' => null,
					'id' => $this->db_prefix.$i.'_disablePluginBelow',
					'field_type' => 'text',
					'label' => 'Disable plugin below',
					'checkbox_label' => null,
					'radio_labels' => null,
					'field_info' => 'screen-size',
					'description' => 'Set the width,height screen-size (in pixels), below which the plugin will be disabled (e.g. <code>1024</code>, <code>1024,600</code>)',
					'wrapper' => null
				)
			);
		}
		
	}

}

if(class_exists('malihuPageScroll2id')){ // --edit--

	malihuPageScroll2id::get_instance(); // --edit--

}
?>