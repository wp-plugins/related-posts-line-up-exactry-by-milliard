<?php 	
	$dir = dirname(__FILE__);
	include_once($dir."/admin_lib.php");
	if (isset($_POST['update_options'])) {
		$this->error = null;
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
	$host = defined("SS_HOST") ? SS_HOST : "www.shisuh.com";
	$isFinished = false; 
	$pages = $ss_rp_admin->get_static_pages();

?>
<link rel="stylesheet" type="text/css" href="//<?php echo $host; ?>/css/ssRelatedPageAdmin.css"></link>
<script type="text/javascript" src="//<?php echo $host; ?>/djs/ssRelatedPageAdmin/?requireLoader=1"></script>
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
				<th scope="row">固定で表示するページ</th>
				<td>
					<div class="field ssPageContainer" >
						<?php 
						$p_count = count($pages);
						if($p_count > 0){
							foreach($pages as $key => $page){ 
?>
							<div class="ssPage" id="page_<?php echo $key; ?>">
								<div class="sspageUrlContainer"><span class="label">URL:</span><span class="inputContainer"><input class="input sspageUrl" value="<?php echo $page["url"] ?>" name="sspage_url_<?php echo $key; ?>" type="text" placeholder="URLを入力してください"></span></div>
								<div class="sspageTitleContainer"><span class="label">タイトル:</span><span class="inputContainer"><input class="input sspageTitle" value="<?php echo $page["title"] ?>" name="sspage_title_<?php echo $key; ?>" type="text" placeholder="タイトルを入力して下さい"></span></div>
								<div class="sspageImageContainer"><span class="label">画像:</span><span class="inputContainer"><input class="input sspageImage" value="<?php echo $page["thumbnailUrl"] ?>" name="sspage_image_<?php echo $key; ?>" type="text" placeholder="画像のURLを入力して下さい"></span></div>
								<div><button class="ssDeleteStaticPageButton">削除</button></div>
							</div>

							<?php }
						}else{ ?>
						<div class="ssPage" id="page_0">
							<div class="sspageUrlContainer"><span class="label">URL:</span><span class="inputContainer"><input class="input sspageUrl" name="sspage_url_0" type="text" placeholder="URLを入力してください"></span></div>
							<div class="sspageTitleContainer"><span class="label">タイトル:</span><span class="inputContainer"><input class="input sspageTitle" name="sspage_title_0" type="text" placeholder="タイトルを入力して下さい"></span></div>
							<div class="sspageImageContainer"><span class="label">画像:</span><span class="inputContainer"><input class="input sspageImage" name="sspage_image_0" type="text" placeholder="画像のURLを入力して下さい"></span></div>
							<div><button class="ssDeleteStaticPageButton">削除</button></div>
						</div>
						<?php } ?>
					</div>
					<div class="field">
						<button id="ssAddStaticPageButton">追加</button>
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
					<div><a target="_blank" href="http://corp.shisuh.com/milliard%e9%96%a2%e9%80%a3%e3%83%9a%e3%83%bc%e3%82%b8%e3%83%97%e3%83%a9%e3%82%b0%e3%82%a4%e3%83%b3%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6/">「よくあるご質問」はこちらを参照下さい</a></div>
				</th>
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

<div class="ssPage" id="ssStaticPageTmp" style="display:none;">
	<div class="sspageUrlContainer"><span class="label">URL:</span><span class="inputContainer"><input class="input sspageUrl" type="text" placeholder="URLを入力してください"></span></div>
	<div class="sspageTitleContainer"><span class="label">タイトル:</span><span class="inputContainer"><input class="input sspageTitle"  type="text" placeholder="タイトルを入力して下さい"></span></div>
	<div class="sspageImageContainer"><span class="label">画像:</span><span class="inputContainer"><input class="input sspageImage" type="text" placeholder="画像のURLを入力して下さい"></span></div>
	<div><button class="ssDeleteStaticPageButton">削除</button></div>
</div>
