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

<div class="row">
	<header class="col-md-16 col-md-offset-3">
	<h1>Archivo digital de las Brigadas Internacionales</h1>
	</header>

	<div id="views" class="col-md-16 col-md-offset-3">
		<form id="content-filter" class="form-inline" method="get" action="<?php echo $form_action ?>" role="form">
			<div id="view" class="form-group">
				<label>Ver como</label>
				<button type="button" value="mosaico"> <span class="glyphicon glyphicon-th"></span> Mosaico</button>
				<button type="button" name="vie" value="lista"> <span class="glyphicon glyphicon-th-list"></span> Lista</button>
			</div>

<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default">
    <input type="checkbox" name="pt1" id="brigadista" value="brigadista" /> Option 1
  </label>
  <label class="btn btn-default">
    <input type="checkbox" name="pt2" id="fotografia" value="fotografia" /> Option 2
  </label>
</div>

<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default">
    <input type="radio" name="view" id="mosaico" value="mosac" /> Option 1
  </label>
  <label class="btn btn-default">
    <input type="radio" name="view" id="lista" value="list" /> Option 2
  </label>
</div>

			<input type="submit" value="Filtrar" />
		</form>
		<div class="view-tit">Mostrar</div>
		<div class="view-options">
			<span class="glyphicon glyphicon-th view-active"></span>
			<a href="?view=list"><span class="glyphicon glyphicon-th-list"></span></a>
			<a href="?view=comprim"><span class="glyphicon glyphicon-align-justify"></span></a>
		</div>
	</div><!-- #views -->
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
