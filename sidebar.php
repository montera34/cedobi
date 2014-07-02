<?php // related loops
$base = trailingslashit( home_url() );

global $wp_post_types; // custom post types info
global $pt_current;
$current = time();
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
			'posts_per_page' => -1,
			'orderby' => 'meta_value_num',
			'meta_key' => '_cedobi_date_ini',
			'order' => 'ASC',
			'meta_query' => array(
//				'relation' => 'AND',
//				array(
//					'key' => '_cedobi_date_ini',
//					'value' => $current,
//					'compare' => '<'
//				),
				array(
					'key' => '_cedobi_date_end',
					'value' => $current,
					'compare' => '>'
				)
			)
		),
		'img_size' => 'small',
		'cols' => 3
	),
);

if ( is_single() || is_post_type_archive($pt_current) ) {
// if single, remove current post type of the related content array
	unset($rels[$pt_current]);
}

$related_out = "";
foreach ( $rels as $key => $rel ) {
	$related_tit = $wp_post_types[$key]->labels->name;
	$related_posts = get_posts($rel['args']);
	if ( count($related_posts) != 0 ) {
		$related_out .= "
		<section id='related-" .$key. "' class='related col-md-24 col-sm-8'>
			<h2 class='related-tit'><a href='" .$base . $key. "' title='" .sprintf( __( '%s archive','cedobi' ), $related_tit ). "'>" .$related_tit. "</a></h2>
		";
		foreach ( $related_posts as $item ) {
			$rel_tit = $item->post_title;
			$rel_perma = get_permalink($item->ID);
			$rel_desc = $item->post_excerpt;
			// if ( has_post_thumbnail($item->ID) ) { $rel_img = get_the_post_thumbnail($item->ID,$rel['img_size'],array('class' => 'img-responsive')); } else { $rel_img = ""; }
			if ( $key == 'convocatoria' ) {
				$rel_date_ini = get_post_meta( $item->ID, "_cedobi_date_ini", true );
				$rel_date_end = get_post_meta( $item->ID, "_cedobi_date_end", true );
				$rel_date_ini_human = date('d \/ m \/ Y',$rel_date_ini);
				$rel_date_end_human = date('d \/ m \/ Y',$rel_date_end);
				if ( $rel_date_ini_human == $rel_date_end_human ) {
					$rel_date_out = $rel_date_ini_human;
				} else {
					$rel_date_out = "<div class='rel-item-date'>" .$rel_date_ini_human. " &mdash; " .$rel_date_end_human. "</div>";
				}
			} elseif ($key == 'noticia' ) {
				$rel_date = get_the_time('Y-m-d',$item->ID);
				$rel_date_human = get_the_time('d \d\e F \d\e Y',$item->ID);
				$rel_date_out = "<div class='cfield'><time datetime='" .$rel_date. "'>" .$rel_date_human. "</time></div>";
			} else { $rel_date_out = ""; }
			$related_out .= "
			<article class='rel-item row'>
				<div class='rel-tit-text col-md-24 col-sm-23'>
					<header>
						<h3 class='rel-item-tit'><a href='" .$rel_perma. "' title='" .$rel_tit. "' rel='bookmark'>" .$rel_tit. "</a></h3>
						" .$rel_date_out. "
					</header>
					<div class='rel-item-desc'>" .$rel_desc. "</div>
				</div>
			</article><!-- .rel-item -->
			";
		}
			
		$related_out .= "</section>";
	}
}
?>

<?php if ( !is_single() ) { ?>
<div id="margeni" class="col-md-3 col-md-pull-16">
	<?php get_search_form(); ?>
</div><!-- #margeni -->
<?php } ?>

<div id="margend" class="col-md-4 col-md-offset-1">
	<div class="row">
	<?php echo $related_out ?>
	</div>
</div><!-- #margeni -->
