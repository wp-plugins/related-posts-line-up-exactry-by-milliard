<?php
class SS_RP_AdminLib{

	function __construct() {
	}
	function update_options() {

		if($_POST["update_options"]){
			// 確認コード
			if (isset($_POST["alg"])) {
				update_option('SS_RP_ALG', $_POST['alg']);
			}
			if ($_POST["showBottom"] != "1") {
				update_option('SS_RP_SHOW_BOTTOM',"-1");
			}else{
				delete_option('SS_RP_SHOW_BOTTOM');
			}
			if ($_POST["showInsert"] != "1") {
				update_option('SS_RP_SHOW_INSERT',"-1");
			}else{
				delete_option('SS_RP_SHOW_INSERT');
			}
			if(!empty($_POST["headerText"])){
				update_option('SS_RP_HEADER_TEXT',$_POST["headerText"]);
			}else{
				delete_option('SS_RP_HEADER_TEXT');
			}
			if(!empty($_POST["footerTextColor"])){
				update_option('SS_RP_FOOTER_TEXT_COLOR',$_POST["footerTextColor"]);
			}else{
				delete_option('SS_RP_FOOTER_TEXT_COLOR');
			}
			if(!empty($_POST["offScroll"])){
				update_option('SS_RP_OFF_SCROLL',$_POST["offScroll"]);
				delete_option("SS_RP_ON_SCROLL","1");
			}else{
				delete_option('SS_RP_OFF_SCROLL');
				update_option("SS_RP_ON_SCROLL","1");
			}
			if(!empty($_POST["offScrollCount"])){
				update_option('SS_RP_OFF_SCROLL_COUNT',$_POST["offScrollCount"]);
			}else{
				delete_option('SS_RP_OFF_SCROLL_COUNT');
			}
			$this->delete_static_pages();
			$mStrings = array("sspage_url_","sspage_title_","sspage_image_");
			foreach ($_POST as $key => $value){
				$isMatched = false;
				foreach($mStrings as $match){
					$strlen =strlen($match);
					$head = substr($key,0,$strlen); 
					if($head == $match){
						$isMatched = true;
					}
				}
				if($isMatched){
					if(!empty($_POST[$key])){
						update_option($key,$value);
					}else{
						delete_option($key);
					}
				}
			}
			if(!empty($_POST["ssOriginalTemplateLarge"])){
				update_option("SS_RP_ORIGINAL_TEMPLATE_LARGE",$_POST["ssOriginalTemplateLarge"]);
			}else{
				delete_option("SS_RP_ORIGINAL_TEMPLATE_LARGE");
			}
			if(!empty($_POST["ssOriginalTemplateSmall"])){
				update_option("SS_RP_ORIGINAL_TEMPLATE_SMALL",$_POST["ssOriginalTemplateSmall"]);
			}else{
				delete_option("SS_RP_ORIGINAL_TEMPLATE_SMALL");
			}
			if($_POST["ssOriginalTemplateScroll"] == "off"){
				update_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL","off");
			}else{
				update_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL","on");
			}
			if($_POST["ssOriginalTemplateScrollMobile"] == "off"){
				update_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL_MOBILE","off");
			}else{
				update_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL_MOBILE","on");
			}
			if(!empty($_POST["ssOriginalTemplateOffScrollCount"])){
				update_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT",$_POST["ssOriginalTemplateOffScrollCount"]);
			}else{
				delete_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT");
			}
			if(!empty($_POST["ssOriginalTemplateOffScrollCountMobile"])){
				update_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT_MOBILE",$_POST["ssOriginalTemplateOffScrollCountMobile"]);
			}else{
				delete_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT_MOBILE");
			}
			if(!empty($_POST["ssOriginalTemplateAltImg"])){
				update_option("SS_RP_ORIGINAL_TEMPLATE_ALT_IMG",$_POST["ssOriginalTemplateAltImg"]);
			}else{
				delete_option("SS_RP_ORIGINAL_TEMPLATE_ALT_IMG");
			}
			//desginSetting
			if(!empty($_POST["designSetting"])){
				update_option("SS_RP_DESIGN_SETTING",$_POST["designSetting"]);
			}else{
				delete_option("SS_RP_DESIGN_SETTING");
			}
			//desginType
			if(!empty($_POST["designType"])){
				update_option("SS_RP_DESIGN_TYPE",$_POST["designType"]);
			}else{
				delete_option("SS_RP_DESIGN_TYPE");
			}
			if(!empty($_POST["responsiveWideTemplateType"])){
				update_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE_TYPE",$_POST["responsiveWideTemplateType"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE_TYPE");
			}
			if(!empty($_POST["responsiveNarrowTemplateType"])){
				update_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE_TYPE",$_POST["responsiveNarrowTemplateType"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE_TYPE");
			}
			if(!empty($_POST["responsiveWideTemplate"])){
				update_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE",$_POST["responsiveWideTemplate"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE");
			}
			if(!empty($_POST["responsiveNarrowTemplate"])){
				update_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE",$_POST["responsiveNarrowTemplate"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE");
			}
			if(!empty($_POST["responsiveWideOffScroll"])){
				update_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL",$_POST["responsiveWideOffScroll"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL");
			}
			if(!empty($_POST["responsiveWideOffScrollCount"])){
				update_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL_COUNT",$_POST["responsiveWideOffScrollCount"]);
			}else{
				delete_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL_COUNT");
			}
		}
	}
	public function delete_static_pages(){
		$index = 0;
		$prefix = "sspage";
		while(!$isFinished){
			$name = $prefix."_url_".$index;
			$url = get_option($name);
			if(empty($url)){
				$isFinished = true;
			}else{
				delete_option($name);
				delete_option($prefix."_title_".$index);
				delete_option($prefix."_image_".$index);
				$index = $index+1;
			}
		}
	}
	public function get_static_pages(){
		$index = 0;
		$pages = array();
		$prefix = "sspage";
		while(!$isFinished){
			$name = $prefix."_url_".$index;
			$url = get_option($name);
			if(empty($url)){
				$isFinished = true;
			}else{
				$page = array();
				$page["url"] = $url;
				$page["title"] = get_option($prefix."_title_".$index);
				$img = get_option($prefix."_image_".$index);
				if(!empty($img)){
					$page["thumbnailUrl"] = $img;
				} 
				$page["static"] = 1;
				array_push($pages,$page);
				$index = $index+1;
			}
		}
		return $pages;
	}
}

$ss_rp_admin = new SS_RP_AdminLib();
?>
