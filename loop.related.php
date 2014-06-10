<?php
$pt_name = $pt_current. "s";
$related_out = "";
foreach ( $taxes as $tax ) {
$related_terms = get_the_terms($post->ID, $tax);
if ( $related_terms ) {
	$exclude = array($post->ID);
	$related_term = array_shift(array_values($related_terms));
	$args = array(
		'post_type' => $pt_current,
		$tax => $related_term->slug,
		'post__not_in' => $exclude
	);
	$related_posts = get_posts($args);
	if ( count($related_posts) > 0 ) {
		$related_tit = "Más " .$pt_name. " de " .$related_term->name;
		$related_out .= "<h2 class='related-tit'>" .$related_tit. "</h2>";
	
		foreach ( $related_posts as $rel_item ) {
			$rel_item_tit = $rel_item->post_title;
			$rel_item_perma = get_permalink($rel_item->ID);
			$rel_item_desc = $rel_item->post_excerpt;
			if ( has_post_thumbnail($rel_item->ID) ) {
				$rel_item_img = get_the_post_thumbnail($rel_item->ID,'bigicon',array('class' => 'img-responsive'));
				$related_out .= "
				<div class='rel-item row'>
					<div class='rel-item-img col-md-6'>" .$rel_item_img. "</div>
					<div class='rel-item-text col-md-18'>
						<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
						<div class='rel-item-desc'>" .$rel_item_desc. "</div>
					</div>
				</div>
				";
			} else {
				$related_out .= "
				<div class='rel-item row'>
					<div class='rel-item-text col-md-24'>
						<h3 class='rel-item-tit'><a href='" .$rel_item_perma. "'>" .$rel_item_tit. "</a></h3>
						<div class='rel-item-desc'>" .$rel_item_desc. "</div>
					</div>
				</div>
				";

	 		} // end if related post has thumbnail
		} // end loop related posts
	} // end if there are related posts
} // end if post has a term of $tax
} // end loop $taxes
?>
