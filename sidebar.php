<?php // related loops
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
foreach ( $rels as $key => $rel ) {

	$noticias = get_posts($rel['args']);
	foreach ( $rel as $item ) {
		$rel_tit = $item->post_title;
		$rel_perma = get_permalink($item->ID);
		if ( has_post_thumbnail($item->ID) ) { $rel_img = get_the_post_thumbnail($item->ID,$rel['img_size'],array('class' => 'img-responsive')); } else { $rel_img = ""; }
	}
}
?>


<div id="margeni" class="col-md-3 col-md-pull-16">
	<?php get_search_form(); ?>
</div><!-- #margeni -->

<div id="margend" class="col-md-5">
	<?php  ?>
</div><!-- #margeni -->
