<?php get_header();

$form_action = CEDOBI_BLOGURL;
// views
if ( array_key_exists('view', $_GET) ) {
	$view = sanitize_text_field( $_GET['view'] );
} else {
	$view = "mosac";
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
			<div class="col-md-6 filter-brigadista"><a href="/brigadista">Archivo de brigadistas</a></div>
			<div class="col-md-6 filter-fotografia"><a href="/fotofrafia">Fondos fotográficos</a></div>
			<div class="col-md-6 filter-documento"><a href="/documento">Recursos digitales</a></div>
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
	<section id="main" class="col-md-16 col-md-push-3 <?php echo $view ?>">

	<?php if ( have_posts() ) {

		if ( $view == 'mosac' ) { $desktop_count = 0; $view_cols_desktop = 8; echo "<div class='row'>"; }
		if ( $view == 'list' ) { echo "<div id='list' class='row'>"; }

		while ( have_posts() ) : the_post();

			if ( $view == 'mosac' ) {
				if ( $desktop_count == $view_cols_desktop ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
			}
			include "loop.mosac.list.php";

		endwhile;
		if ( $view == 'mosac' ) { echo "</div><!-- .row -->"; }
		if ( $view == 'list' ) { echo "</div><!-- .row -->"; }

	} // end if posts
	?>
	
	</section><!-- .<?php echo $view ?> -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
