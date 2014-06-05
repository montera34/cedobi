<?php get_header();

// views
if ( array_key_exists('view', $_GET) ) {
	$view = sanitize_text_field( $_GET['view'] );
} else {
	$view = "mosac";
} ?>

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
			<div class="col-md-6 filter-brigadista"><a href="?post_type=brigadista">Archivo de brigadistas</a></div>
			<div class="col-md-6 filter-fotografia"><a href="?post_type=fotografia">Fondos fotográficos</a></div>
			<div class="col-md-6 filter-documento"><a href="?post_type=documento">Recursos digitales</a></div>
			<div class="col-md-6 filter-archivo"><a href="/">Archivo completo</a></div>
		</div>
	</div><!-- .col-md-8 -->
	<div class="col-md-4">
		<div class="filters-tit"><strong>Vista</strong></div>
		<div class="filters-btn vista-btn row">
			<div class="col-md-12 vista-mosac"><a href="?view=mosac">Mosaico</a></div>
			<div class="col-md-12 vista-list"><a href="?view=list">Lista</a></div>
		</div>
	</div><!-- .col-md-8 -->
</div><!-- .row -->

<div class="row">
	<section id="main" class="col-md-16 col-md-push-3">

	<?php if ( have_posts() ) {

		if ( $view == 'mosac' ) { $desktop_count = 0; $view_cols_desktop = 4; echo "<div id='" .$view. "' class='row'>"; }
		if ( $view == 'list' ) {
			echo "<table id='" .$view. "' class='table table-hover table-condensed table-responsive'>
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

			if ( $view == 'mosac' ) {
				if ( $desktop_count == $view_cols_desktop ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
			}
			include "loop." .$view. ".php";

		endwhile;
		if ( $view == 'mosac' ) { echo "</div><!-- #" .$view. " -->"; }
		if ( $view == 'list' ) { echo "</tbody></table><!-- #" .$view. " -->"; }

	} // end if posts
	?>
	
	</section><!-- .<?php echo $view ?> -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
