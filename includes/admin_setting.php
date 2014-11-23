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
	$header_text = get_option("SS_RP_HEADER_TEXT"); 
	$footer_text_color = get_option("SS_RP_FOOTER_TEXT_COLOR"); 
	$off_scroll = get_option("SS_RP_OFF_SCROLL"); 
	$off_scroll_count = get_option("SS_RP_OFF_SCROLL_COUNT"); 
?>
<div class="wrap">
      <div id="icon-options-general" class="icon32"><br></div>
      <h2>Milliard関連ページ設定</h2>
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
			<tr>
				<th scope="row"><label for="blogname">紹介文(HTML不可)</label></th>
				<td>
					<div class="field">
						<input type="text" placeholder="何も設定しない場合、こんな記事も書いてますが表示されます" value="<?php echo $header_text; ?>" style="width:90%" name="headerText"/>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">ツール名文字色</th>
				<td>
					<div class="field">
						<input type="text" placeholder="例：#6e6e6e" value="<?php echo $footer_text_color; ?>"  name="footerTextColor"/>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">スマホでの表示</th>
				<td>
					<div class="field">
						<input type="checkbox" name="offScroll" value="1" <?php if(!empty($off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
						<?php if(!empty($off_scroll)){?><input type="" name="offScrollCount" style="width:40px;margin-left:20px;" value="<?php if(isset($off_scroll_count)){ echo $off_scroll_count; } ?>">件表示(デフォルト5件)<?php } ?>
					</div>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<input type="submit" name="update_options" class="button-primary" value="<?php _e('Save Changes'); ?>">
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<div><a target="_blank" href="http://corp.shisuh.com/?p=497">よくあるカスタマイズ方法はこちらを参照下さい</a></div>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<div><a target="_blank" href="http://corp.shisuh.com/milliard%E9%96%A2%E9%80%A3%E3%83%9A%E3%83%BC%E3%82%B8%E3%81%8C%E8%A1%A8%E7%A4%BA%E3%81%95%E3%82%8C%E3%81%AA%E3%81%84%E5%A0%B4%E5%90%88%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6/">表示されない場合の対処法はこちら</a></div>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<div><a target="_blank" href="http://www.shisuh.com/statics/relatedPageSetting/">どうしても表示されない場合は、こちらのページで生成したコードをsingle.phpの表示する場所に貼付けてください</a></div>
				</th>
			</tr>
		</tbody>
	</table>

	</form>
</div>
<?php ?>
