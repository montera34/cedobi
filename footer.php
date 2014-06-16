<footer id="epi" class="container tair">
	<div class="row">
		<div id="epi-main" class="col-md-16 col-md-offset-3">
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
			<div id="epi-credit">
				Diseñado y desarrollado por <a href="http://montera34.com">m34</a> usando <a href="/creditos">software libre</a>.
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
