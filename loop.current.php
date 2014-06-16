<?php
$pt_name = $pt_current. "s";
$related_out = "";

$exclude = array($post->ID);
$current = time();
$args = array(
	'post_type' => $pt_current,
	'post__not_in' => $exclude,
	'posts_per_page' => -1,
	'orderby' => 'meta_value_num',
	'meta_key' => '_cedobi_date_ini',
	'order' => 'ASC',
	'meta_query' => array(
		array(
			'key' => '_cedobi_date_end',
			'value' => $current,
			'compare' => '>'
		)
	)
);
$related_posts = get_posts($args);
if ( count($related_posts) > 0 ) {
	$related_tit = "Otras " .$pt_name. " vigentes";
	$related_out .= "
		<section class='row'>
		<header class='col-sm-24'><h2 class='related-tit'>" .$related_tit. "</h2></header>";
	
	foreach ( $related_posts as $rel_item ) {
		$rel_item_tit = $rel_item->post_title;
		$rel_item_perma = get_permalink($rel_item->ID);
		$rel_item_desc = $rel_item->post_excerpt;
		$rel_date_ini = get_post_meta( $rel_item->ID, "_cedobi_date_ini", true );
		$rel_date_end = get_post_meta( $rel_item->ID, "_cedobi_date_end", true );
		$rel_date_ini_human = date('d \/ m \/ Y',$rel_date_ini);
		$rel_date_end_human = date('d \/ m \/ Y',$rel_date_end);
		if ( $rel_date_ini_human == $rel_date_end_human ) {
			$rel_date_out = "<div class='rel-item-date'>" .$rel_date_ini_human. "</div>";
		} else {
			$rel_date_out = "<div class='rel-item-date'>" .$rel_date_ini_human. " &mdash; " .$rel_date_end_human. "</div>";
		}

		if ( has_post_thumbnail($rel_item->ID) ) {
			$rel_item_img = get_the_post_thumbnail($rel_item->ID,'bigicon',array('class' => 'img-responsive'));
			$related_out .= "
			<div class='rel-item col-md-24 col-sm-8'><div class='row'>
				<div class='rel-item-img col-sm-6'>" .$rel_item_img. "</div>
				<div class='rel-item-text col-sm-18'>
					<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
					" .$rel_date_out. "
					<div class='rel-item-desc'>" .$rel_item_desc. "</div>
				</div>
			</div></div>
			";
		} else {
			$related_out .= "
			<div class='rel-item col-md-24'>
				<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
				" .$rel_date_out. "
				<div class='rel-item-desc'>" .$rel_item_desc. "</div>
			</div>
			";

 		} // end if related post has thumbnail
	} // end loop related posts
	$related_out .= "</section>";

} // end if there are related posts
?>
