<?php

/*
Plugin Name: Milliard Related Page
Description: Related Post Plugin which insert and line extactly related posts bottom of <body> and content. 
Author: Shisuh.inc
Version: 0.0.11
*/
class ShisuhRelatedPage { 

	function __construct() {
		define("SS_RP_PLUGIN_DIR",dirname(__FILE__));
		$this->host = defined("SS_HOST") ? SS_HOST : "www.shisuh.com";
		if ( is_admin() ) {
			$match = preg_match("/plugins.php/i",$_SERVER["PHP_SELF"]);
			$rp_init = get_option("SS_RP_INIT");
			$rp_confirm = get_option("SS_RP_CONFIRM");
			if(!empty($rp_init) && $match){
				$queries;
				parse_str($_SERVER["QUERY_STRING"],$queries);
				add_action('admin_head',array($this,"init_script"));
				add_action('admin_head',array($this,"confirm_script"));
				delete_option("SS_RP_INIT");
			}
			if(empty($rp_confirm)){
				//if($_GET["ssConfirmScript"] == 1){
				//	update_option("SS_RP_CONFIRM",1);
				//	echo "confirmed";
				//	exit;
				//}
				//
			}
			if($_GET["ssDebugInfo"]){
				$this->echo_debug_info();
			}
			$plugin = plugin_basename( __FILE__);
			add_filter('plugin_action_links_' . $plugin, array($this, 'add_action_link') );
			add_action('admin_menu', array($this, 'add_menu'));
		}else{		
			add_filter('request', array($this, 'filter_request'), 1 );
			if(!defined("SS_RP_INVALIDATE") || !SS_RP_INVALIDATE){
				add_filter('the_content', array($this,'add_content_end'));
			}
		}
		if(function_exists("add_shortcode")){
			add_shortcode('milliard',array($this,'echo_shortcode'));
		}
	}
	public function echo_debug_info(){

		$load_paths = array("wp-settings.php","wp-admin/admin.php","wp-admin/includes/admin.php",WPINC."/pluggable.php");
		foreach($load_paths as $load_path){
			require_once(ABSPATH.$load_path);
		}
		if ( ! current_user_can('activate_plugins') ){
			wp_die( __( 'You do not have sufficient permissions to manage plugins for this site.' ) );
		}
		$items;
		if(function_exists("_get_list_table")){
			$_REQUEST["plugin_status"] = "active";
			$wp_list_table = _get_list_table('WP_Plugins_List_Table');
			$wp_list_table->prepare_items();
			$items = $wp_list_table->items;
		}else{ 
			$items = get_plugins();
		}
		$home_url_str = (function_exists("home_url")) ? home_url() : get_bloginfo( 'url' );
		echo "===SITEURL===\n";
		echo $home_url_str."/\n";
		echo "\n===PLUGIN===\n";
		foreach($items as $item){
			echo $item["Name"].",".$item["Version"]."\n";
		}
		echo "\n===PHPINFO===\n";
		echo "v:".phpversion()."\n";
		exit;
	}
	public function init_script(){
		delete_option("SS_RP_INIT");
		$script = $this->gen_script(); 
		echo $script; 
	}
	public function confirm_script(){
		$home_url_str = (function_exists("home_url")) ? home_url() : get_bloginfo( 'url' );
		$script = '<script type="text/javascript">//<![CDATA[
			window.Shisuh = (window.Shisuh) ? window.Shisuh : {};Shisuh.topUrl="'.$home_url_str.'/";Shisuh.type="Wordpress";
		//]]>
		</script><script id="ssConfirmRelatedPageScript" type="text/javascript" src="https://'.$this->host.'/djs/confirmRelatedPageScript/?requireLoader=1"></script>';
		echo $script;
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
		if(!is_feed() && !is_home() && is_single()) {
			$script = $this->gen_script(); 
			$content .= $script;
		}
		return $content;
	}
	public function gen_script(){
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
		$off_scroll = get_option("SS_RP_OFF_SCROLL");
		if(!empty($off_scroll)){
			$off_scroll = "Shisuh.offScroll = ".$off_scroll.";"; 
		}else{
			$off_scroll = "";
		}
		$off_scroll_count = get_option("SS_RP_OFF_SCROLL_COUNT");
		if(!empty($off_scroll) && !empty($off_scroll_count)){
			$off_scroll_count = "Shisuh.offScrollCount = ".$off_scroll_count.";";
		}else{
			$off_scroll_count = "";
		}
		$script = '<script type="text/javascript">//<![CDATA[
			window.Shisuh = (window.Shisuh) ? window.Shisuh : {};Shisuh.topUrl="'.$home_url_str.'/";Shisuh.type="Wordpress";Shisuh.alg="'.$alg.'";Shisuh.showBottom="'.$show_bottom.'";Shisuh.showInsert="'.$show_insert.'";'.$headerText.$footerTextColor.$off_scroll.$off_scroll_count.'
		//]]>
		</script><script id="ssRelatedPageSdk" type="text/javascript" src="https://'.$this->host.'/djs/relatedPageFeed/"></script>';
		return $script;
	}
	public function add_menu() {
		add_options_page(
			'Milliard関連ページ設定画面', 
			'Milliard関連ページ', 
			8, 
			__FILE__, 
			array($this, 'options_page') 
		);
	} 
	public function options_page(){
		$p = SS_RP_PLUGIN_DIR."/includes/admin_setting.php"; 
		include_once($p); 
	}
	/*public function template($template){
		global $request;
		if (ShisuhRelatedPage::isFeed($request)) {
			return $template;
		}else{
			return $template;
		}
	}*/
	public static function isFeed($request){
		return ((isset($request['feed']) && $request['feed'] == 'shisuhRelatedPage') || (isset($_GET['shisuhRelatedPage']) && $_GET['shisuhRelatedPage'] == '1') || (preg_match("/^\/shisuhRelatedPage\/([0-9a-z]+)\//i",$_SERVER["REQUEST_URI"]))); 
	}
	public function load_template_index(){
		nocache_headers();
		require_once SS_RP_PLUGIN_DIR."/includes/feed-rss2.php";  
		exit;
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
			//$request["feed"] = "";
			//unset($request["category_name"]);
			//unset($request["page"]);
			//unset($request["name"]);
			//add_action('do_feed_shisuhRelatedPage', array($this, 'load_template_index'), 10, 0);
			//unset($request["feed"]);
			//add_action( 'send_headers',array($this, 'send_nocache'));
			//add_filter('the_permalink_rss',array($this,'rss_url'),10000,10000);
			//add_action('template_redirect', array($this, 'load_template_index'), 10, 1);
			add_action('post_limits', array($this, 'noLimit'),10,2);
			$this->load_template_index();
		}else{
		}
		return $request;
	}
	public function filter_feed($query){
		//$query = new WP_Query("post_status=publish"); 
		//wp_reset_query();
		//$query->set('post_status','publish');
		//var_dump($query);
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
	public function echo_shortcode(){
		return '<ins id="ssRelatedPageBase"></ins>';
	}
} 

$srp = & new ShisuhRelatedPage();
function initSSRP(){
	update_option("SS_RP_INIT",1);
}
function invalidateSSRP(){
	delete_option("SS_RP_INIT");
	delete_option("SS_RP_CONFIRM");
}
register_activation_hook(__FILE__,"initSSRP");
register_deactivation_hook(__FILE__,"invalidateSSRP");
