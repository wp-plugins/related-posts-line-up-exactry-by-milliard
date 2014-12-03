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
		}
	}
}

$ss_rp_admin = & new SS_RP_AdminLib();
?>
