<?php 	
	if (isset($_POST['update_options'])) {
		$this->error = null;
		$dir = dirname(__FILE__);
		include_once($dir."/admin_lib.php");
		$ss_rp_admin->update_options();
	}	
	$alg = get_option("SS_RP_ALG");
	if(!$alg){
		$alg = "Related"; 
	}
	$show_bottom = get_option("SS_RP_SHOW_BOTTOM");
	$show_insert = get_option("SS_RP_SHOW_INSERT");
?>
<div class="wrap">
      <div id="icon-options-general" class="icon32"><br></div>
      <h2>シスウ関連ページ設定</h2>
      <form action="" method="post">
	<input type="hidden" value="1" value="update_options" />
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="blogname">並び順</label></th>
				<td>
					<div >
						<div><input type="radio" name="alg" value="Related" <?php if($alg == "Related"){ echo "checked";} ?> ><label class="radioLabel">関連度順</label></div>
						<div><input type="radio" name="alg" value="Latest" <?php if($alg == "Latest"){ echo "checked";} ?> ><label class="radioLabel">更新日時</label></div>
						<div><input type="radio" name="alg" value="Random" <?php if($alg == "Random"){ echo "checked";} ?> ><label class="radioLabel">ランダム</label></div>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="blogname">表示場所</label></th>
				<td>
					<div class="field">
						<input type="checkbox" name="showBottom" value="1" <?php  if(empty($show_bottom)) {  echo "checked"; } ?>><label class="checkLabel">フッターの下</label>
						<input type="checkbox" name="showInsert" value="1" <?php  if(empty($show_insert)) {  echo "checked"; } ?>><label class="checkLabel">挿入箇所</label>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	<input type="submit" name="update_options" class="button-primary" value="<?php _e('Save Changes'); ?>">
	</form>
</div>
<?php ?>
