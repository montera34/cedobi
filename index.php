<?php get_header();

// custom post types info
global $wp_post_types;
// get view
if ( array_key_exists('view', $_GET) ) {
	$view_current = sanitize_text_field( $_GET['view'] );
} else {
	$view_current = "mosaico";
}
// get post type
if ( array_key_exists('post_type', $_GET) ) {
	$pt_current = sanitize_text_field( $_GET['post_type'] );
} else {
	$pt_current = "archivo";
}
// build filters
$base = CEDOBI_BLOGURL;
$pts = array("brigadista","fotografia","documento","archivo");
$filters_out = "";
foreach ( $pts as $pt ) {
	if ( $pt == $pt_current ) { $active_class = " class='active'"; }
	else { $active_class = ""; }
	if ( $pt == 'archivo' ) {
		$filters_out .= "<div class='col-md-6 filter-" .$pt. "'><a" .$active_class. " href='" .$base. "?view=" .$view_current. "'>Archivo completo</a></div>";
	} else {
		$pt_tit = $wp_post_types[$pt]->labels->name;
		$filters_out .= "<div class='col-md-6 filter-" .$pt. "'><a" .$active_class. " href='" .$base. "?post_type=" .$pt. "&view=" .$view_current. "'>" .$pt_tit. "</a></div>";
	}

}
// build views
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
	<h1>Archivo digital de las Brigadas Internacionales</h1>
	</header>
</div><!-- .row -->

<div id="filters" class="row">
	<div class="col-md-12 col-md-offset-3">
		<div class="filters-tit"><strong>Mostrar</strong></div>
		<div class="filters-btn row">
			<?php echo $filters_out ?>
		</div>
	</div><!-- .col-md-8 -->
	<div class="col-md-4">
		<div class="filters-tit"><strong>Vista</strong></div>
		<div class="filters-btn vista-btn row">
			<?php echo $views_out ?>
		</div>
	</div><!-- .col-md-8 -->
</div><!-- .row -->

<div class="row">
	<section id="main" class="col-md-16 col-md-push-3">

	<?php if ( have_posts() ) {

		if ( $view_current == 'mosaico' ) { $desktop_count = 0; $view_cols_desktop = 4; echo "<div id='" .$view_current. "' class='row'>"; }
		if ( $view_current == 'lista' ) {
			echo "<table id='" .$view_current. "' class='table table-hover table-condensed table-responsive'>
				<thead>
				<tr>
					<td>Imagen</td>
					<td>Nombre</td>
					<td>Tipo</td>
					<td>Descripción</td>
				</tr>
				</thead>
				<tbody>
			";
		}

		while ( have_posts() ) : the_post();

			if ( $view_current == 'mosaico' ) {
				if ( $desktop_count == $view_cols_desktop ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
			}
			include "loop." .$view_current. ".php";

		endwhile;
		if ( $view_current == 'mosaico' ) { echo "</div><!-- #" .$view_current. " -->"; }
		if ( $view_current == 'lista' ) { echo "</tbody></table><!-- #" .$view_current. " -->"; }

	} // end if posts
	?>
	
	</section><!-- .<?php echo $view_current ?> -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
