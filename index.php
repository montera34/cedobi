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
    <input type="radio" name="view" id="mosaico" value="mosaico" /> Option 1
  </label>
  <label class="btn btn-default">
    <input type="radio" name="view" id="lista" value="lista" /> Option 2
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
	<section class="col-md-16 col-md-push-3 <?php echo $view ?>">
	<div class="row">

	<?php if ( have_posts() ) {
	$desktop_count = 0;
	while ( have_posts() ) : the_post();

		$item_pt =  get_post_type();
		$item_name = get_the_title();
		$item_perma = get_permalink();
		$item_desc = get_the_excerpt();
		$item_text_out = "<div class='item-text mosac-popup'><h2 class='item-tit'>" .$item_name. "</h2><div class='item-desc'>" .$item_desc. "</div></div>";
		$item_fondo_out = "<div class='item-fondo'><a href='" .$item_perma. "' title='" .$item_name. "' rel='bookmark'><img src='" .CEDOBI_BLOGTHEME. "/images/icon-" .$item_pt. ".png' alt='' /></a></div>";
		$item_img_size = "thumbnail";
		if ( has_post_thumbnail() ) {
			$item_img_out = "<div class='item-img'><a href='" .$item_perma. "' title='" .$item_name. "' rel='bookmark'>" .get_the_post_thumbnail($post->ID,$item_img_size,array('class' => 'img-responsive')). "</a></div>";
		} else {
			$item_img_out = "";
		}
				if ( $desktop_count == 8 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
		?>
		<article class="mosac-item col-md-3">
			<?php echo $item_img_out ?>
			<?php echo $item_fondo_out ?>
			<?php echo $item_text_out ?>
		</article>
	<?php endwhile;
	} // end if posts
	?>

	</div><!-- .row -->
	</section><!-- .<?php echo $view ?> -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
