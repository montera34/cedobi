<?php get_header(); ?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3 col-sm-24">
	<h1><?php the_title() ?></h1>
	</header>
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

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
