<?php get_header();
// custom post types info
global $wp_post_types;

// build title
$tit = get_the_title();
$base = CEDOBI_BLOGURL;
$pt_current = get_post_type();

// build tax and custom fields filters buttons
if ( $pt_current == 'brigadista' ) {
	$fields = array(
		'origen' => 'tax'
	);
} elseif ( $pt_current == 'fotografia' ) {
	$fields = array(
		'fondo' => 'tax',
		'fecha' => 'tax',
	);

} elseif ( $pt_current == 'documento' ) {
	$fields = array(
		'formato' => 'tax',
		'fecha' => 'tax',
	);

}
$filters_out = "";
foreach ( $fields as $key => $value ) {
	if ( $value == 'tax' ) {
		$terms_out = get_the_term_list( $post->ID, $key, '', ', ', '' );
	}
	$filters_out .= "
	<div class='row'>
		<div class='col-md-6'>
			<div class='filters-tit'>" .$key. "</div>
			<div class='tax-btn'>" .$terms_out. "</div>
		</div>
	</div>
	";
}

// build views buttons
$views = array("mosaico","lista");
$views_out = "";
foreach ( $views as $view ) {
	if ( $view == $view_current ) { $active_class = " class='active'"; }
	else { $active_class = ""; }
	$views_out .= "<div class='col-md-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .$base. "?post_type=" .$pt_current. "&view=" .$view. "'>" .$view. "</a></div>";

}
?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3">
	<h1><?php echo $tit ?></h1>
	</header>
</div><!-- .row -->

<div id="filters" class="row">
	<div class="col-md-16 col-md-offset-3">
		<?php echo $filters_out ?>
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
		<h2 class="related-tit">Contenido relacionado</h2>
	</section><!-- .<?php #related ?> -->

	<?php include "sidebar-single.php"; ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
