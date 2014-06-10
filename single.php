<?php get_header();
// custom post types info
global $wp_post_types;

// build title
$tit = get_the_title();
$base = CEDOBI_BLOGURL;
$pt_current = get_post_type();

// build tax and custom fields filters buttons
// build related lists
if ( $pt_current == 'brigadista' ) {
	$fields = array(
		'Origen' => array(
			'ciudad' => 'tax',
			'region' => 'tax',
			'pais' => 'tax'
		)
	);

	// taxonomies for related content
	$taxes = array("pais");

} elseif ( $pt_current == 'fotografia' ) {
	$fields = array(
		'Fondo' => array(
			'fondo' => 'tax'
		),
		'Fecha' => array(
			'fecha' => 'tax',
		),
		'Autor' => array(
			'_cedobi_author1_firstname' => 'cf',
			'_cedobi_author1_lastname' => 'cf',
			'_cedobi_author2_firstname' => 'cf',
			'_cedobi_author2_lastname' => 'cf',
			'_cedobi_author3_firstname' => 'cf',
			'_cedobi_author3_lastname' => 'cf'
		)
	);
	// taxonomies for related content
	$taxes = array("fondo","fecha");

} elseif ( $pt_current == 'documento' ) {
	$fields = array(
		'Formato/Género' => array(
			'formato' => 'tax',
			'genero' => 'tax'
		),
		'Fecha' => array(
			'fecha' => 'tax',
		),
		'Autor' => array(
			'_cedobi_author1_firstname' => 'cf',
			'_cedobi_author1_lastname' => 'cf',
			'_cedobi_author2_firstname' => 'cf',
			'_cedobi_author2_lastname' => 'cf',
			'_cedobi_author3_firstname' => 'cf',
			'_cedobi_author3_lastname' => 'cf'
		)
	);
	// taxonomies for related content
	$taxes = array("formato","fecha");
}
$filters_out = "";
foreach ( $fields as $filter_tit => $field ) {
	$filters_out .= "
		<div class='col-md-6'>
			<div class='filters-tit'>" .$filter_tit. "</div>
	";
	$terms_out = "";
	foreach ( $field as $name => $type ) {
		if ( $type == 'tax' ) {
			$terms_out .= get_the_term_list( $post->ID, $name, '<div class="' .$name. '-terms">', '', '</div>' );
		} else {
			$term = get_post_meta( $post->ID, $name, true );
			if ( $term != '' ) {
				$terms_out .= "<div class='cfield'>" .$term. "</div>";
			}
		}
	}
		$filters_out .= "
			<div class='tax-btn'>" .$terms_out. "</div>
		";
	$filters_out .= "
		</div>
	";
}
// build views buttons
$views = array("mosaico","lista");
$views_out = "";
foreach ( $views as $view ) {
	if ( $view == $view_current ) { $active_class = " class='active'"; }
	else { $active_class = ""; }
	$views_out .= "<div class='col-md-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .$base. "?view=" .$view. "'>" .$view. "</a></div>";

}

// build related contents list
include "loop.related.php";
?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3">
	<h1><?php echo $tit ?></h1>
	</header>
</div><!-- .row -->

<div id="filters" class="row">
	<div class="col-md-16 col-md-offset-3">
	<div class='row'>
		<?php echo $filters_out ?>
	</div>
	</div><!-- .col-md-16 -->
	<div class="col-md-4 col-md-offset-1">
		<div class="filters-tit">Archivo completo</div>
		<div class="filters-btn vista-btn row">
			<?php echo $views_out ?>
		</div>
	</div><!-- .col-md-8 -->
</div><!-- .row -->

<div class="row">
	<section id="main" class="col-md-10 col-md-push-3">

	<?php if ( have_posts() ) {
		while ( have_posts() ) : the_post();

			the_content();

		endwhile;
	} // end if posts
	?>

	</section><!-- #main -->

	<section id="related" class="col-md-4 col-md-offset-2 col-md-push-3">

		<?php echo $related_out ?>
		
	</section><!-- .<?php #related ?> -->

	<?php include "sidebar-single.php"; ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
