<?php
global $wp_post_types;
global $base;
$select_out = "";
$search_pts = array("brigadista","fotografia","documento","noticia","convocatoria","publicacion");
foreach ( $search_pts as $pt ) {
	$select_out .= "
	<option value='" .$pt. "'>" .$wp_post_types[$pt]->labels->name. "</option>
	";
}
$s_query = get_search_query();
if ( $s_query != '' ) { $search_active = " active"; }
?>
<form id="archivo-search" action="<?php echo $base ?>" method="get" role="form">
	<div id="search-basic" class="form-group has-feedback<?php echo $search_active ?>">
		<label class="sr-only" for="s"><?php _e('Search','cedobi'); ?></label>
		<input type="text" class="form-control" id="s" name="s" placeholder="<?php echo $s_query ?>" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</div>

	<div id="search-advanced-btn" class="form-group">
		<a href="#"><?php _e('Advanced','cedobi'); ?> <span class="caret"></span></a>
	</div>

	<div id="search-advanced">
	<div class="form-group">
		<select class="form-control" name="post_type">
			<option value=""><?php _e('Complete archive','cedobi'); ?></option>
			<?php echo $select_out ?>
		</select>
	</div>
	<div class="form-group">
		<input class="btn" type="submit" class="form-control" id="submit" value="<?php _e('Search','cedobi') ?>" />
	</div>
	</div>
</form><!-- #archivo-search -->
