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
	// build related contents list
	include "loop.related.php";

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
	// build related contents list
	include "loop.related.php";

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
	// build related contents list
	include "loop.related.php";

} elseif ( $pt_current == 'noticia' ) {
	$fields = array(
		'Fecha de publicación' => array(
			'date' => 'dt',
		),
	);
	// taxonomies for related content
	// no taxonomies, just latest noticias
	// build related contents list
	include "loop.last.php";

} elseif ( $pt_current == 'convocatoria' ) {
	$fields = array(
		'Vigencia' => array(
			'_cedobi_date_ini' => 'cf',
			'_cedobi_date_end' => 'cf',
		),
		'Lugar' => array(
			'_cedobi_lugar' => 'cf',
		)
	);
	// taxonomies for related content
	// no taxonomies, just all current convocatorias
	// build related contents list
	include "loop.current.php";
	
} elseif ( $pt_current == 'publicacion' ) {
	$fields = array(
		'Colección' => array(
			'coleccion' => 'tax',
		),
		'Año de publicación' => array(
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
	$taxes = array("coleccion");
	// build related contents list
	include "loop.related.php";

} // end post types fields

$filters_out = "";
foreach ( $fields as $filter_tit => $field ) {
	$filters_out .= "
		<div class='filter-single col-md-6 col-sm-6'>
			<div class='filters-tit'>" .$filter_tit. "</div>
	";
	$terms_out = "";
	$cf_count = 0;
	foreach ( $field as $name => $type ) {
		if ( $type == 'dt' ) {
			$date = get_the_time('Y-m-d');
			$date_human = get_the_time('d \d\e F \d\e Y');
			$terms_out .= "<div class='cfield'><time datetime='" .$date. "'>" .$date_human. "</time></div>";

		} elseif ( $type == 'cf' ) {
			if ( $filter_tit == 'Autor' ) {
				$cf_count++;
				$term[$cf_count] = get_post_meta( $post->ID, $name, true );
				if ( count($term) == 2 ) {
					$terms_out .= "<div class='cfield'>" .$term[1]. " " .$term[2]. "</div>";
					$cf_count = 0;
					$term = "";
				}
			} elseif ( $filter_tit == 'Vigencia' ) {
				$term = date('d \/ m \/ Y',get_post_meta( $post->ID, $name, true ) );
				$terms_out .= "<div class='cfield'>" .$term. "</div>";

			}

		} else {
			$terms_out .= get_the_term_list( $post->ID, $name, '<div class="' .$name. '-terms">', '', '</div>' );
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
	$views_out .= "<div class='col-lg-4 col-md-6 col-sm-5 col-xs-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .$base. "?view=" .$view. "'>" .$view. "</a></div>";

}

?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3 col-sm-24">
	<h1><?php echo $tit ?></h1>
	</header>
</div><!-- .row -->

<div id="filters" class="row">
	<div class="col-lg-12 col-lg-offset-3 col-md-16 col-md-offset-3 col-sm-19">
	<div class='row'>
		<?php echo $filters_out ?>
	</div>
	</div><!-- .col-md-16 -->
	<div class="col-lg-offset-5 col-md-4 col-md-offset-1 col-sm-5">
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

	<div id="related" class="col-md-4 col-md-offset-2 col-md-push-3">

		<?php echo $related_out ?>
		
	</div><!-- .<?php #related ?> -->

	<?php include "sidebar-single.php"; ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
