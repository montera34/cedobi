<?php get_header();

// subpages menu
$args =	array(
	'post_type' => 'page',
	'post_parent' => $post->ID,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$children = get_posts($args);

if ( $post->post_parent != '0' ||  count($children) > 0 ) {

	if ( $post->post_parent != '0' ) {
		$parent_perma = get_permalink($post->post_parent);
		$parent_tit = get_the_title($post->post_parent);
		$args =	array(
			'post_type' => 'page',
			'post_parent' => $post->post_parent,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$pags = get_posts($args);
		$filters = "<li><a href='" .$parent_perma. "' title='" .$parent_tit. "' rel='bookmark'>" .$parent_tit. "</a></li>";

	} elseif ( count($children) > 0 ) {
		$parent_perma = get_permalink();
		$parent_tit = get_the_title();
		$args =	array(
			'post_type' => 'page',
			'post_parent' => $post->ID,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$pags = get_posts($args);
		$filters = "<li>" .$parent_tit. "</li>";
	}
	$filter_tit = "Secciones";
	foreach ( $pags as $pag ) {
		$pag_perma = get_permalink($pag->ID);
		if ( $pag->ID == $post->ID ) {
			$filters .= "<li class='active'>" .$pag->post_title. "</li>";
		} else {
			$filters .= "<li><a href='" .$pag_perma. "' title='" .$pag->post_title. "' rel='bookmark'>" .$pag->post_title. "</a></li>";
		}
	}

	$filters_out = "
	<div id='filters' class='row'>
		<div class='col-lg-12 col-lg-offset-3 col-md-16 col-md-offset-3 col-sm-19 filter-single'>

			<div class='filters-tit'>" .$filter_tit. "</div>
				<ul class='list-inline'>
				" .$filters. "
				</ul>
		</div><!-- .col-md-12 -->
	</div><!-- .row -->
	";

} else {

}
?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3 col-sm-24">
	<h1><?php the_title() ?></h1>
	</header>
</div><!-- .row -->

	<?php echo $filters_out ?>


<div class="row">
	<section id="main" class="col-md-10 col-md-push-3">

	<?php if ( have_posts() ) {
		while ( have_posts() ) : the_post();

			if ( has_post_thumbnail() && $pt_current != 'documento' ) { // image
				$single_img_size = "large";
				echo "
				<figure class='single-img'>
				" .get_the_post_thumbnail( $post->ID, $single_img_size, array('class' => 'img-responsive') ). "
				</figure>	
				";
			}
			the_content();

		endwhile;
	} // end if posts
	?>

	</section><!-- #main -->

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
