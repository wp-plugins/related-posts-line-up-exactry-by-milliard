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
			}else{
				delete_option('SS_RP_OFF_SCROLL');
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

$ss_rp_admin = & new SS_RP_AdminLib();
?>
