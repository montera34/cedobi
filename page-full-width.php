<?php
/* Template name: Pantalla completa */

get_header();
?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3 col-sm-24">
	<h1><?php the_title() ?></h1>
	</header>
</div><!-- .row -->

<div class="row">
	<section id="main" class="col-sd-24">

	<?php if ( have_posts() ) {
		while ( have_posts() ) : the_post();

			the_content();

		endwhile;
	} // end if posts
	?>

	</section><!-- #main -->

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
