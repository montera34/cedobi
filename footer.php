<footer id="epi" class="container tair">
	<div class="row">
	<div id="epi-main" class="col-md-16 col-md-offset-3">
		<div class="row">
		<div class="col-sm-20">
			<div><?php echo CEDOBI_BLOGNAME. ". ".CEDOBI_BLOGDESC ?></div>
			<?php
			$menu_args = array(
				'theme_location'  => 'epi-nav',
				'container'       => false,
				'menu_class'      => 'list-inline',
				'menu_id'         => 'navbar-epi',
				'walker'          => ''
			);
			wp_nav_menu( $menu_args );
			?>
		</div><!-- .col-md-20 -->
		<div class="col-sm-4">
			<div><?php _e('Promoted by:','cedobi'); ?></div>
			<ul class="list-inline">
				<li><a href="http://uclm.es" title="Universidad de Castilla- La Mancha"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-patrocina-uclm.png" ?>" alt="Universidad de Castilla- La Mancha" /></a></li>
				<li><a href="http://iealbacetenses.com" title="Instituto de Estudios Albacetenses Don Juan Manuel"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-patrocina-iea.png" ?>" alt="Instituto de Estudios Albacetenses Don Juan Manuel" /></a></li>
			</ul>
		</div><!-- .col-md-4 -->
		</div><!-- .row -->
		<div id="epi-credit" class="row">
			<div class="col-xs-24">
				<?php _e('Designed and developed by <a href="http://montera34.com">m34</a> using <a href="/creditos">free software</a>.','cedobi'); ?>
			</div>
		</div>

	</div>
</footer><!-- #epi .container -->
<?php
// get number of queries
//echo "<div style='display: none;'>".get_num_queries()."</div>";
wp_footer(); ?>

</body><!-- end body as main container -->
</html>
