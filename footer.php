<?php // build links list
$links = get_bookmarks();
if ( count($links) >= 1 ) {
	$links_out = "<div>".__('More interesting sites about the Brigades around the internet','cedobi')."</div><ul id='links-list' class='list-unstyled'>";
	foreach ( $links as $l ) {
		$links_out .= "<li><a href='".$l->link_url."'>".$l->link_name."</a> ".$l->link_description."</li>";
	}
	$links_out .= "</ul>";
} else { $links_out = ""; }
?>

<footer id="epi" class="container tair">
	<div class="row">
	<div id="epi-main" class="col-md-24">
		<div class="row">
			<?php if ( $links_out != '' ) { echo '<div class="col-sm-9">';
			} else { echo '<div class="col-sm-19">'; } ?>
				<div><?php echo CEDOBI_BLOGNAME. ". ".CEDOBI_BLOGDESC ?></div>
				<?php
				$menu_args = array(
					'theme_location'  => 'epi-nav',
					'container'       => false,
					'menu_class'      => 'list-inline',
					'menu_id'         => 'navbar-epi',
					'walker'          => ''
				);
				wp_nav_menu( $menu_args ); ?>
			</div><!-- .col-md-*0 -->
			<?php if ( $links_out != '' ) {
				echo '<div class="col-sm-8 col-sm-offset-1">'.$links_out.'</div><!-- .col-md-8 -->';
			} ?>

			<div class="col-sm-4 col-sm-offset-1">
				<div><?php _e('Promoted by:','cedobi'); ?></div>
				<ul class="list-inline">
					<li><a href="http://uclm.es" title="Universidad de Castilla- La Mancha"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-patrocina-uclm.png" ?>" alt="Universidad de Castilla- La Mancha" /></a></li>
					<li><a href="http://iealbacetenses.com" title="Instituto de Estudios Albacetenses Don Juan Manuel"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-patrocina-iea.png" ?>" alt="Instituto de Estudios Albacetenses Don Juan Manuel" /></a></li>
				</ul>
				<div id="epi-credit">
					<?php _e('Designed and developed by <a href="https://montera34.com">m34</a> using <a href="/creditos">free software</a>.','cedobi'); ?>
				</div>
			</div><!-- .col-md-4 -->
		</div><!-- .row -->

	</div>
</footer><!-- #epi .container -->
<?php
// get number of queries
//echo "<div style='display: none;'>".get_num_queries()."</div>";
wp_footer(); ?>

</body><!-- end body as main container -->
</html>
