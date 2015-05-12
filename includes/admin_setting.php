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
	$original_template_large = stripslashes(get_option("SS_RP_ORIGINAL_TEMPLATE_LARGE"));
	$original_template_small = stripslashes(get_option("SS_RP_ORIGINAL_TEMPLATE_SMALL"));
	$is_original_template_off_scroll = (get_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL") == "off");
	$original_template_off_scroll_count = get_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT");
	$is_original_template_off_scroll_mobile = (get_option("SS_RP_ORIGINAL_TEMPLATE_SCROLL_MOBILE") == "off");
	$original_template_off_scroll_count_mobile = get_option("SS_RP_ORIGINAL_TEMPLATE_OFF_SCROLL_COUNT_MOBILE");
	$original_template_alt_img = get_option("SS_RP_ORIGINAL_TEMPLATE_ALT_IMG");
	$design_setting = get_option("SS_RP_DESIGN_SETTING");
	$design_type = get_option("SS_RP_DESIGN_TYPE");
	$responsive_wide_template = stripslashes(get_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE"));
	$responsive_wide_template_type = get_option("SS_RP_RESPONSIVE_WIDE_TEMPLATE_TYPE");
	$responsive_narrow_template = stripslashes(get_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE"));
	$responsive_narrow_template_type = get_option("SS_RP_RESPONSIVE_NARROW_TEMPLATE_TYPE");
	$responsive_wide_off_scroll = get_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL");
	$responsive_wide_off_scroll_count = get_option("SS_RP_RESPONSIVE_WIDE_OFF_SCROLL_COUNT");
?>
<link rel="stylesheet" type="text/css" href="//<?php echo $host; ?>/css/ssRelatedPageAdmin.css"></link>
<script type="text/javascript" src="//<?php echo $host; ?>/djs/ssRelatedPageAdmin/?requireLoader=1"></script>
<div class="wrap">
      <div id="icon-options-general" class="icon32"><br></div>
      <h2>Milliard関連ページ設定</h2>
      <form action="" method="post">
	<input type="hidden" value="1" value="update_options" />
	<table id="ssRelatedPageAdmin" class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="blogname">並び順</label></th>
				<td>
					<div >
						<div><input id="algRadioRelated" type="radio" name="alg" value="Related" <?php if($alg == "Related"){ echo "checked";} ?> ><label class="radioLabel" for="algRadioRelated">関連度順</label></div>
						<div><input id="algRadioLatest" type="radio" name="alg" value="Latest" <?php if($alg == "Latest"){ echo "checked";} ?> ><label for="algRadioLatest" class="radioLabel">更新日時</label></div>
						<div><input id="algRadioRandom" type="radio" name="alg" value="Random" <?php if($alg == "Random"){ echo "checked";} ?> ><label class="radioLabel" for="algRadioRandom">ランダム</label></div>
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
		</tbody>
	</table>
	<input type="hidden" name="designSetting" value="<?php if(empty($design_setting) || $design_setting == "simple"){ ?>simple<?php }else{ ?>detail<?php } ?>" />
	<div id="loadTable" class="form-table">ロード中...</div>
	<div style="text-align:right;"><a id="designSettingSwitch"><?php if(empty($design_setting) || $design_setting == "simple"){ ?>▼デザイン詳細設定<?php }else{ ?>×詳細を閉じる<?php } ?></a></div>
	<table id="ssSimpleContainer" class="form-table">	
		<tr id="responsiveWide" class="wide simple responsive">
			<th>PC / タブレット<br>（640px以上)</th>
			<td>
				<div class="field">
					<div class="templateType">
						<input id="responsiveWideTemplateTypeRadioPanel" type="radio" name="responsiveWideTemplateType" value="panel" <?php if(empty($responsive_wide_template_type) || $responsive_wide_template_type == "panel"){ ?>checked<?php } ?>><label class="radioLabel" for="responsiveWideTemplateTypeRadioPanel">パネル</label>
						<input id="responsiveWideTemplateTypeRadioList" type="radio" name="responsiveWideTemplateType" value="list" <?php if($responsive_wide_template_type == "list"){ ?>checked<?php } ?>><label class="radioLabel" for="responsiveWideTemplateTypeRadioList">リスト</label>

						<span class="showDetailOnly"><input id="responsiveWideTemplateTypeRadioOriginal" type="radio" name="responsiveWideTemplateType" value="original" <?php if($responsive_wide_template_type == "original"){ ?>checked<?php } ?>  ><label for="responsiveWideTemplateTypeRadioOriginal" class="radioLabel">独自テンプレート</label></span>
					</div>
					<div class="templateValue">
						<div class="templateTypeTab" id="responsiveWideTemplateType.list">

							<input type="checkbox" name="responsiveWideOffScroll" value="1" <?php if(!empty($responsive_wide_off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
							<input class="offScrollCountResponsiveList offScrollCount" type="text" name="responsiveWideOffScrollCount" value="<?php if(!empty($responsive_wide_off_scroll_count)){ echo $responsive_wide_off_scroll_count; } ?>">件表示(デフォルト5件)
						</div>
						<div class="templateTypeTab" id="responsiveWideTemplateType.original">

							<input type="checkbox" name="responsiveWideOffScroll" value="1" <?php if(!empty($responsive_wide_off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
							<input class="offScrollCountResponsiveList offScrollCount" type="text" name="responsiveWideOffScrollCount" value="<?php if(!empty($responsive_wide_off_scroll_count)){ echo $responsive_wide_off_scroll_count; } ?>">件表示(デフォルト5件)
							<div id="ssResponsiveOriginalTemplateLabelLarge">HTML（<a target="_blank" href="http://corp.shisuh.com/milliard%e9%96%a2%e9%80%a3%e3%83%9a%e3%83%bc%e3%82%b8%e3%81%ae%e3%82%88%e3%81%8f%e3%81%82%e3%82%8b%e3%82%ab%e3%82%b9%e3%82%bf%e3%83%9e%e3%82%a4%e3%82%ba%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6wordpress/#customize">⇒カスタマイズ例はこちら</a>）</div>
							<textarea  placeholder="HTMLを入力してください。" name="responsiveWideTemplate" style="width:100%;" rows=10 ><?php if(!empty($responsive_wide_template)){ echo $responsive_wide_template; } ?></textarea>
							</div>
						</div>

					</div>
				</div>
			</td>
		</tr>
		<tr id="responsiveNarrow" class="narrow simple responsive">
			<th>スマホ / タブレット<br>（640px以下)</th>
			<td>
				<div class="field">
					<div class="templateType">
						<input id="responsiveNarrowTemplateTypeRadioPanel" type="radio" name="responsiveNarrowTemplateType" value="panel" <?php if(empty($responsive_narrow_template_type) || $responsive_narrow_template_type == "panel"){ ?>checked<?php } ?>><label class="radioLabel" for="responsiveNarrowTemplateTypeRadioPanel">パネル</label>
						<input id="responsiveNarrowTemplateTypeRadioList" type="radio" name="responsiveNarrowTemplateType" value="list" <?php if($responsive_narrow_template_type == "list"){ ?>checked<?php } ?>><label class="radioLabel" for="responsiveNarrowTemplateTypeRadioList">リスト</label>

						<span class="showDetailOnly"><input id="responsiveNarrowTemplateTypeRadioOriginal" class="showDetailOnly" type="radio" name="responsiveNarrowTemplateType" value="original" <?php if($responsive_narrow_template_type == "original"){ ?>checked<?php } ?> ><label for="responsiveNarrowTemplateTypeRadioOriginal" class="radioLabel">独自テンプレート</label></span>
					</div>
					<div class="templateValue">
						<div class="templateTypeTab" id="responsiveNarrowTemplateType.panel">
							<input type="checkbox" name="offScroll" value="1" <?php if(!empty($off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
							<input type="text" name="offScrollCount" class="offScrollCount" value="<?php if(isset($off_scroll_count)){ echo $off_scroll_count; } ?>">件表示(デフォルト5件)
						</div>
						<div class="templateTypeTab" id="responsiveNarrowTemplateType.list">

							<input type="checkbox" name="offScroll" value="1" <?php if(!empty($off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
							<input class="offScrollCountResponsiveList offScrollCount" type="text" name="offScrollCount"  value="<?php if(isset($off_scroll_count)){ echo $off_scroll_count; } ?>">件表示(デフォルト5件)
						</div>
						<div class="templateTypeTab" id="responsiveNarrowTemplateType.original">

							<input type="checkbox" name="offScroll" value="1" <?php if(!empty($off_scroll)){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
							<input class="offScrollCount" type="text" name="offScrollCount" value="">件表示(デフォルト5件)
							<div id="ssResponsiveOriginalTemplateLabelNarrow">HTML（<a target="_blank" href="http://corp.shisuh.com/milliard%e9%96%a2%e9%80%a3%e3%83%9a%e3%83%bc%e3%82%b8%e3%81%ae%e3%82%88%e3%81%8f%e3%81%82%e3%82%8b%e3%82%ab%e3%82%b9%e3%82%bf%e3%83%9e%e3%82%a4%e3%82%ba%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6wordpress/#customize">⇒カスタマイズ例はこちら</a>）</div>
							<textarea  placeholder="HTMLを入力してください。" name="responsiveNarrowTemplate" style="width:100%;" rows=10><?php if(!empty($responsive_narrow_template)){ echo $responsive_narrow_template; } ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<table id="ssDetailContainer" class="form-table">
		<tr id="detailType" class="detail">
			<th scope="row" >デザインタイプ</th>
			<td>
				<div class="field">
					<input id="desinTypeRadioResponsive" type="radio" name="designType" value="responsive"<?php if(empty($design_type) || $design_type == "responsive"){ ?>checked<?php } ?>><label class="radioLabel" for="desinTypeRadio">レスポンシブ</label>
					<input id="desinTypeRadioWpIsMobile" type="radio" name="designType" value="wp_is_mobile" <?php if($design_type == "wp_is_mobile"){ ?>checked<?php } ?>><label class="radioLabel" for="desinTypeRadioWpIsMobile">デバイス毎(wp_is_mobile)</label>
				</div>
			</td>
		</tr>
		<tr id="responsiveWide" class="wide detail responsive">
		
		</tr>
		<tr id="responsiveNarrow" class="narrow detail responsive">
			
		</tr>
		<tr class="detail wpIsMobile">
			<th scope="row">PC</th>
			<td>
				<div class="field">

					<div class="child"><input type="checkbox" name="ssOriginalTemplateScroll" value="off" <?php if($is_original_template_off_scroll){ ?>checked<?php } ?>>挿入箇所のスクロールを無効にする
					<input type="" name="ssOriginalTemplateOffScrollCount" style="width:40px;margin-left:20px;" value="<?php if(isset($original_template_off_scroll_count)){ echo $original_template_off_scroll_count; } ?>">件表示(デフォルト5件)</div>
					<div class="child">
						<div id="ssOriginalTemplateLabelLarge"><a target="_blank" href="http://corp.shisuh.com/milliard%e9%96%a2%e9%80%a3%e3%83%9a%e3%83%bc%e3%82%b8%e3%81%ae%e3%82%88%e3%81%8f%e3%81%82%e3%82%8b%e3%82%ab%e3%82%b9%e3%82%bf%e3%83%9e%e3%82%a4%e3%82%ba%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6wordpress/#customize">⇒カスタマイズ例はこちら</a></div>
						<textarea placeholder="HTMLを入力してください。" name="ssOriginalTemplateLarge" style="width:100%;" rows=10><?php echo $original_template_large; ?></textarea>
					</div>
			</td>
		</tr>
		<tr class="detail wpIsMobile">
			<th scope = "row">スマートフォン・タブレット</th>
			<td>
				<div class="field">
					<div class="child">
					<input id="ssOriginalTemplateScrollMobileCheckbox" type="checkbox" name="ssOriginalTemplateScrollMobile" value="off" <?php if($is_original_template_off_scroll_mobile){ ?>checked<?php } ?>><label for="ssOriginalTemplateScrollMobileCheckbox" >挿入箇所のスクロールを無効にする</label>
					<input type="" name="ssOriginalTemplateOffScrollCountMobile" style="width:40px;margin-left:20px;" value="<?php if(isset($original_template_off_scroll_count_mobile)){ echo $original_template_off_scroll_count_mobile; } ?>">件表示(デフォルト5件)</div>

						<div id="ssOriginalTemplateLabelSmall"><a target="_blank" href="http://corp.shisuh.com/milliard%e9%96%a2%e9%80%a3%e3%83%9a%e3%83%bc%e3%82%b8%e3%81%ae%e3%82%88%e3%81%8f%e3%81%82%e3%82%8b%e3%82%ab%e3%82%b9%e3%82%bf%e3%83%9e%e3%82%a4%e3%82%ba%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6wordpress/#customize">⇒カスタマイズ例はこちら</a></div>
						<textarea placeholder="HTMLを入力してください。" name="ssOriginalTemplateSmall" style="width:100%;" rows=10><?php echo $original_template_small; ?></textarea>
					</div>
				</div>
			</td>
		</tr>
		<tr class="detail wpIsMobile">
			<th>その他設定</th>
			<td>
					<div class="child">
						<div>エラー時の代替画像</div>
						<div><input type="text" value="<?php if(!empty($original_template_alt_img)){ echo $original_template_alt_img; } ?>" name="ssOriginalTemplateAltImg" style="width:100%;" placeholder="画像のURLを入力してください。"></input></div>
					</div>
			</td>
		</tr>
	</table>
	<table class="form-table">
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
