<?php

/*
Plugin Name: シスウ関連ページ
Description: Related Post Plugin which insert and line extactly related posts bottom of <body> and content. 
Author: Shisuh.inc
Version: 0.0.2
*/
class ShisuhRelatedPage { 

	function __construct() {
		define("SS_RP_PLUGIN_DIR",dirname(__FILE__));
		$this->host = defined("SS_HOST") ? SS_HOST : "www.shisuh.com";
		add_filter('template', array($this, 'template'), 0);
		add_filter('request', array($this, 'filter_request'), 1 );
		if ( is_admin() ) {

			$plugin = plugin_basename( __FILE__);
			add_filter('plugin_action_links_' . $plugin, array($this, 'add_action_link') );
			add_action('admin_menu', array($this, 'add_menu'));
		}		
		add_filter('the_content', array($this,'add_content_end'));
		add_action('rss2_item', array($this,'add_post_thumbnail'));
		if(function_exists("add_shortcode")){
			add_shortcode('milliard',array($this,'add_content_end'));
		}
	}

	public function rss_url($link){
		global $post;
		$link = get_permalink($post->ID);
		return $link;
	}

	public function add_action_link( $links ) {
		$plugin_name = plugin_basename(__FILE__);
		$setting_url = 'options-general.php?page='.$plugin_name;
		$settings_link = '<a href="' . admin_url($setting_url).'">' . translate('Settings') . '</a>';
		array_unshift( $links, $settings_link); 
		return $links;
	}
	public function add_content_end($content){
		if(!is_feed() && !is_home() && is_single() && empty($this->isCalled)) {
			$this->isCalled = true;
			$alg = get_option("SS_RP_ALG");
			if(!$alg){
				$alg = "Related"; 
			}
			$show_bottom = get_option("SS_RP_SHOW_BOTTOM");
			if(empty($show_bottom)){
				$show_bottom = "1";
			}
			$show_insert = get_option("SS_RP_SHOW_INSERT"); 
			if(empty($show_insert)){
				$show_insert = "1";
			}
			$htOpt = get_option("SS_RP_HEADER_TEXT"); 
			$headerText = (empty($htOpt)) ? "" : 'Shisuh.headerText = \''.$htOpt.'\';';
			$fOpt = get_option("SS_RP_FOOTER_TEXT_COLOR");
			$footerTextColor = (empty($fOpt)) ? "" :'Shisuh.footerTextColor=\''.$fOpt.'\';';
			$home_url_str = (function_exists("home_url")) ? home_url() : get_bloginfo( 'url' );
			$script = '<script type="text/javascript">//<![CDATA[
				window.Shisuh = (window.Shisuh) ? window.Shisuh : {};Shisuh.topUrl="'.$home_url_str.'/";Shisuh.type="Wordpress";Shisuh.alg="'.$alg.'";Shisuh.showBottom="'.$show_bottom.'";Shisuh.showInsert="'.$show_insert.'";'.$headerText.$footerTextColor.'
			//]]>
			</script><script id="ssRelatedPageSdk" type="text/javascript" src="https://'.$this->host.'/djs/relatedPageFeed/"></script>';
			$content .= $script;
		}
		return $content;
	}
	public function add_menu() {
		add_options_page(
			'シスウ関連ページ設定画面', 
			'シスウ関連ページ', 
			8, 
			__FILE__, 
			array($this, 'options_page') 
		);
	} 
	public function options_page(){
		$p = SS_RP_PLUGIN_DIR."/includes/admin_setting.php"; 
		include_once($p); 
	}
	public function template($template){
		global $request;
		if (ShisuhRelatedPage::isFeed($request)) {
			return '';
		}else{
			return $template;
		}
	}
	public static function isFeed($request){
		return (isset($request['feed']) && $request['feed'] == 'shisuhRelatedPage'); 
	}
	public function load_template_index(){
		do_feed_rss2(false);

	}
	public function noLimit($limits){
		$startIndex= $_GET["startIndex"];
		$count = $_GET["count"];
		$limit = "LIMIT ";
		if(intval($startIndex) > 0){
			$limit = $limit.$startIndex.", ";
		}else{
			$limit = $limit."0, ";
		}
		if(intval($count) >= 0){
			$limit = $limit.$count;
		}else{
			$limit = $limit."10";
		}
		return $limit;
	}
	public function filter_request($request){
		$this->request = $request;
		if (ShisuhRelatedPage::isFeed($request)) {
			add_action( 'pre_get_posts',array($this,'filter_feed'));
			add_action( 'send_headers',array($this, 'send_nocache'));
			add_action('do_feed_shisuhRelatedPage', array($this, 'load_template_index'), 10, 1);
			add_action('post_limits', array($this, 'noLimit'),10,2);
			add_filter('the_permalink_rss',array($this,'rss_url'),10000,10000);
		}else{
		}
		return $request;
	}
	public function filter_feed($query){
		$query->set('post_status','publish');
	}
	public function send_nocache(){
		nocache_headers();
	}
	public function add_post_thumbnail($content) {
		global $post;
		if(function_exists("has_post_thumbnail") && function_exists("wp_get_attachment_image_src") && function_exists("get_post_thumbnail_id") && has_post_thumbnail($post->ID)){
			$thumbs = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),"medium");
			if(count($thumbs) > 0 && !empty($thumbs[0])){
				echo('<media:thumbnail xmlns:media="http://search.yahoo.com/mrss/" url="'.$thumbs[0].'"/>');
			}
		}
	}
} 

$srp = & new ShisuhRelatedPage();
