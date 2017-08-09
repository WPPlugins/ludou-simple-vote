<?php
/* 
Plugin Name: Ludou Simple Vote
Plugin URI: http://www.ludou.org/wordpress-simple-vote.html
Version: 1.1
Author: 露兜
Description: 在WordPress中实现简单的支持/反对投票插件
Author URI: http://www.ludou.org/
*/

function ludou_simplevote_content($content) {
	global $post;

	$rate = get_post_meta($post->ID, "ludou_ratings_score", true);
	$rate = ($rate == '') ? 0 : $rate;
	
	$content .= '<div id="useraction">
				<div id="ajax_recommendlink">
					<div title="主题评价指数" id="recommendv">'.$rate.'</div>
					<ul class="recommend_act">
						<li><a onclick="ludou_simple_vote(this, \''.get_bloginfo("wpurl").'\',' . $post->ID . ', 1);" href="javascript:void(0);" id="recommend_add" title="点击支持本文">支持</a></li>
						<li><a onclick="ludou_simple_vote(this, \''.get_bloginfo("wpurl").'\',' . $post->ID.', -1);" href="javascript:void(0);" id="recommend_subtract" title="点击反对本文">反对</a></li>
					</ul>
				</div>
			</div>';
			
	return $content;
}

function ludou_simplevote_head() {
	$css_html = '<link rel="stylesheet" href="' . get_bloginfo("wpurl") . '/wp-content/plugins/ludou-simple-vote/ludou_simplevote.css' . '" type="text/css" media="screen" />';
	$script_html = '<script type="text/javascript" src="' . get_bloginfo('wpurl') . '/wp-content/plugins/ludou-simple-vote/ludou_simplevote.js"></script>';
	
	echo "\n" . $css_html . "\n" . $script_html. "\n";
}
 
function load_simgplevote() {
	if(is_single()) {
		// 在主题中头部插入css/jss
		add_action("wp_head", "ludou_simplevote_head");
		// 在文章内容部分插入投票代码
		add_filter("the_content", "ludou_simplevote_content");
	}
}

add_action("wp", "load_simgplevote");


// 停用插件时，删除插件创建的自定义栏目
function ludou_simplevote_deactivation() {
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = 'ludou_ratings_score'");
}
register_deactivation_hook( __FILE__, 'ludou_simplevote_deactivation' );

?>