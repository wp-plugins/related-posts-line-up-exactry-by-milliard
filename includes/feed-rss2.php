<?php
header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
$more = 1;

?>
<?php echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
>

<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></pubDate>
	<?php 
		$ss_rp_query = new WP_Query("post_status=publish");
	while( $ss_rp_query->have_posts()) : $ss_rp_query->the_post(); ?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<dc:creator><?php the_author() ?></dc:creator>
		<?php the_category_rss("rss2") ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
<?php rss_enclosure(); ?>
        <?php        if(function_exists("has_post_thumbnail") && function_exists("the_post_thumbnail") && has_post_thumbnail() && function_exists("get_post_thumbnail_id") && function_exists("wp_get_attachment_image_src")){
			//$thumbs = the_post_thumbnail();
			//wp_get_attachment_image_src
			$image_id = get_post_thumbnail_id();
			$thumbs = wp_get_attachment_image_src($image_id, "large"); 
                        if(count($thumbs) > 0 && !empty($thumbs[0])){
                                echo('<media:thumbnail xmlns:media="http://search.yahoo.com/mrss/" url="'.$thumbs[0].'"/>');
                        }
                }
	?>
	</item>
	<?php endwhile; ?>
</channel>
</rss>
