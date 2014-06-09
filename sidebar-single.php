<?php
// build archivo sections buttons
$pts = array("brigadista","fotografia","documento");
$filters_out = "";
foreach ( $pts as $pt ) {
	if ( $pt == $pt_current ) { $active_class = " class='active'"; }
	else { $active_class = ""; }

	$pt_tit = $wp_post_types[$pt]->labels->name;
	$filters_out .= "<div class='filter-" .$pt. "'><a" .$active_class. " href='" .$base. "/" .$pt. "'>" .$pt_tit. "</a></div>";
}

global $wp_post_types; // custom post types info
?>


<div id="margeni" class="col-md-3 col-md-pull-16">
	<?php get_search_form(); ?>
</div><!-- #margeni -->

<div id="margend" class="col-md-4 col-md-offset-1">
	<div class="filters-tit">Secciones del archivo</div>
	<div class="filters-btn">
		<?php echo $filters_out ?>
	</div>
</div><!-- #margeni -->
