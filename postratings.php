<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

if(	!isset($_POST['id']) || !is_numeric($_POST['id'])
		|| !isset($_POST['fen']) || !is_numeric($_POST['fen'])
		|| isset($_COOKIE["ludou_simple_vote_" . $_POST['id']])
	)
	exit;

$id = $_POST['id'];
$id_exist = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d AND post_type = 'post';", $id));

if($id_exist != $id)
	exit;

$rate = get_post_meta($id, "ludou_ratings_score", true);

if( $rate != '') {
	$rate = $rate + $_POST['fen'];
	update_post_meta($id, "ludou_ratings_score", $rate);
	setcookie("ludou_simple_vote_" . $id, $rate, time() + 3000000, COOKIEPATH);
}
else {
	add_post_meta($id, "ludou_ratings_score", $_POST['fen'], true);
	setcookie("ludou_simple_vote_" . $id, $_POST['fen'], time() + 3000000, COOKIEPATH);
}

?>
