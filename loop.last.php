<?php
$pt_name = $pt_current. "s";
$related_out = "";
$args = array(
	'post_type' => $pt_current,
	'order' => 'DESC',
	'orderby' => 'date',
	'posts_per_page' => 5
);
$related_posts = get_posts($args);
if ( count($related_posts) > 0 ) {
	$related_tit = "Últimas " .$pt_name;
	$related_out .= "
		<section class='row'>
		<header class='col-sm-24'><h2 class='related-tit'>" .$related_tit. "</h2></header>";
	
	foreach ( $related_posts as $rel_item ) {
		$rel_item_tit = $rel_item->post_title;
		$rel_item_perma = get_permalink($rel_item->ID);
		$rel_item_desc = $rel_item->post_excerpt;
		$rel_item_date = get_the_time('Y-m-d',$rel_item->ID);
		$rel_item_date_human = get_the_time('d \d\e F \d\e Y',$rel_item->ID);
		
		if ( has_post_thumbnail($rel_item->ID) ) {
			$rel_item_img = get_the_post_thumbnail($rel_item->ID,'bigicon',array('class' => 'img-responsive'));
			$related_out .= "
			<div class='rel-item col-md-24 col-sm-8'><div class='row'>
				<div class='rel-item-img col-sm-6'>" .$rel_item_img. "</div>
				<div class='rel-item-text col-sm-18'>
					<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
					<div class='rel-item-date'><time datetime='" .$date. "'>" .$date_human. "</time></div>	
					<div class='rel-item-desc'>" .$rel_item_desc. "</div>
				</div>
			</div></div>
			";
		} else {
			$related_out .= "
				<div class='rel-item col-md-24'>
					<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
					<div class='rel-item-date'><time datetime='" .$rel_item_date. "'>" .$rel_item_date_human. "</time></div>	
					<div class='rel-item-desc'>" .$rel_item_desc. "</div>
				</div>
			";

 		} // end if related post has thumbnail
	} // end loop related posts
	$related_out .= "</section>";

} // end if there are related posts
?>
