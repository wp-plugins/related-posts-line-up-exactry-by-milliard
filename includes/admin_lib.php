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
		}
	}
}

$ss_rp_admin = & new SS_RP_AdminLib();
?>
