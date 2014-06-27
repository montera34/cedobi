<?php get_header(); ?>

<div id="content" class="container">

<div id="header" class="row">
	<header class="col-md-16 col-md-offset-3">
	<h1><?php _e('Error 404: content not found','cedobi'); ?></h1>
	</header>
</div><!-- .row -->

<div class="row">
	<section id="main" class="col-md-16 col-md-push-3">
		<?php _e('<p>This content has not been found. You can check the URL or go to <a href="/">home page</a> to start from the begining. If you prefer, you can search anything about the International Brigades or about CEDOBI using our search engine.</p>
		<p>If you look for a particular content that you cannot find, or you have any information about combatant volunteers or the International Brigades, <a href="/contacto">contact us</a> please.</p>','cedobi'); ?>
	</section>
	<div id="margeni" class="col-md-3 col-md-pull-16">
		<?php get_search_form(); ?>
	</div><!-- #margeni -->
</div><!-- .row -->

</div><!-- #content .container -->
<?php get_footer(); ?>
