<?php
global $wp_post_types; // custom post types info
global $base;
// build archivo sections buttons
$pts = array("brigadista","fotografia","documento");
$filters_out = "";
foreach ( $pts as $pt ) {
	if ( $pt == $pt_current ) { $active_class = " class='active'"; }
	else { $active_class = ""; }

	$pt_tit = $wp_post_types[$pt]->labels->name;
	$filters_out .= "<div class='col-md-24 col-sm-6 col-xs-12 filter-" .$pt. "'><a" .$active_class. " href='" .$base . $pt. "'>" .$pt_tit. "</a></div>";
}

?>


<div id="margend" class="col-md-4 col-md-offset-1">
	<div class="filters-tit"><?php _e('Archive sections','cedobi'); ?></div>
	<div class="filters-btn row">
		<?php echo $filters_out ?>
	</div>
</div><!-- #margeni -->
