<?php // related loops

global $wp_post_types; // custom post types info
$rels = array(
	'noticia' => array(
		'args' => array(
			'post_type' => 'noticia',
			'posts_per_page' => 3
		),
		'img_size' => 'small',
		'cols' => 3
	),
	'publicacion' => array(
		'args' => array(
			'post_type' => 'publicacion',
			'posts_per_page' => 2
		),
		'img_size' => 'small',
		'cols' => 2
	),

	'convocatoria' => array(
		'args' => array(
			'post_type' => 'convocatoria',
			'posts_per_page' => 3
		),
		'img_size' => 'small',
		'cols' => 3
	),
);
$related_out = "";
foreach ( $rels as $key => $rel ) {
	$related_tit = $wp_post_types[$key]->labels->name;
	$related_posts = get_posts($rel['args']);
	if ( count($related_posts) != 0 ) {
		$related_out .= "<section id='related-" .$key. "' class='related'><h2 class='related-tit'>" .$related_tit. "</h2>";
		foreach ( $related_posts as $item ) {
			$rel_tit = $item->post_title;
			$rel_perma = get_permalink($item->ID);
			$rel_desc = $item->post_excerpt;
			// if ( has_post_thumbnail($item->ID) ) { $rel_img = get_the_post_thumbnail($item->ID,$rel['img_size'],array('class' => 'img-responsive')); } else { $rel_img = ""; }
			$related_out .= "
			<article class='rel-item row'>
				<div class='rel-tit-text col-md-24'>
					<header><h3 class='rel-item-tit'><a href='" .$rel_perma. "' title='" .$rel_tit. "' rel='bookmark'>" .$rel_tit. "</a></h3></header>
					<div class='rel-item-desc'>" .$rel_desc. "</div>
				</div>
			</article><!-- .rel-item -->
			";
		}
		$related_out .= "</section>";
	}
}
?>


<div id="margeni" class="col-md-3 col-md-pull-16">
	<?php get_search_form(); ?>
</div><!-- #margeni -->

<div id="margend" class="col-md-4 col-md-offset-1">
	<?php echo $related_out ?>
</div><!-- #margeni -->
