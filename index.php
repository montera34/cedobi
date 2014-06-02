<?php get_header();

// views
if ( array_key_exists('view', $_GET) ) {
	$view = sanitize_text_field( $_GET['view'] );
} else {
	$view = "mosac";
}

?>

<div id="main" class="col-md-6 col-md-push-2">
	<header class="row">
		<h1 class="col-md-9">Archivo digital de las Brigadas Internacionales</h1>
		<div id="views" class="col-md-3">
			<span class="glyphicon glyphicon-th view-active"></span>
			<a href="?view=list"><span class="glyphicon glyphicon-th-list"></span></a>
			<a href="?view=comprim"><span class="glyphicon glyphicon-align-justify"></span></a>
		</div>
	</header>
	<section class="row <?php echo $view ?>">

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
				if ( $desktop_count == 6 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
		?>
		<article class="mosac-item col-md-2">
			<?php echo $item_img_out ?>
			<?php echo $item_fondo_out ?>
			<?php echo $item_text_out ?>
		</article>
	<?php endwhile;
	} // end if posts
	?>
	</section><!-- .row -->
</div><!-- #main -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
