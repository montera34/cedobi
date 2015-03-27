<?php get_header();

// referrer
if ( array_key_exists('view', $_GET) ) { $ref = sanitize_text_field($_GET['view']); } else { $ref = ""; }

// custom post types info
global $wp_post_types;
// get post type
if ( is_home() ) {
	$pt_current = "archivo";
	if ( $ref == '' ) { $ref = "mosaico"; }

} else {
	$pt_current = get_post_type();

}

// build filters buttons and page main title
if ( $pt_current == 'archivo' && !array_key_exists('s', $_GET)
	|| $pt_current == 'brigadista' && !array_key_exists('s', $_GET)
	|| $pt_current == 'fotografia' && !array_key_exists('s', $_GET)
	|| $pt_current == 'documento' && !array_key_exists('s', $_GET)
	|| $pt_current == 'noticia' && !array_key_exists('s', $_GET)
	|| $pt_current == 'publicacion' && !array_key_exists('s', $_GET)
	|| $pt_current == 'convocatoria' && !array_key_exists('s', $_GET) ) {
	// if archivo

	if ( $ref == 'mosaico' ) { $pts = array("archivo","brigadista","fotografia","documento","noticia","publicacion","convocatoria"); }
	elseif ( $ref == 'lista' ) { $pts = array("archivo","brigadista","fotografia","documento"); }

	if ( $ref != '' ) {
		// build filters buttons
		$filters_out = "";
		foreach ( $pts as $pt ) {
			if ( $pt == $pt_current ) {
				$active_class = " class='active'";
				if ( $pt_current == "archivo" && $ref == 'mosaico' ) { $tit = __('Last published content','cedobi'); }
				elseif ( $pt_current == "archivo" ) { $tit = __('International Brigades Digital Archive','cedobi'); }
				elseif ( $pt_current != 'archivo' && $ref == 'mosaico' ) { $tit = sprintf( __( 'Last content published in %s','cedobi' ), str_replace(' ','<br>',$wp_post_types[$pt]->labels->name) ); }
				else { $tit = str_replace(' ','<br>',$wp_post_types[$pt]->labels->name); }

			} else { $active_class = ""; }

			if ( $pt == 'archivo' ) {
				$filters_out .= "<li class='filter-" .$pt. "'><a" .$active_class. " href='" .CEDOBI_BLOGURL. "?view=" .$ref. "'>" .__('All<br>contents','cedobi'). "</a></li>";
			} else {
				$pt_tit = str_replace(' ','<br>',$wp_post_types[$pt]->labels->name);
				$filters_out .= "<li class='filter-" .$pt. "'><a" .$active_class. " href='" .CEDOBI_BLOGURL . $pt. "?view=" .$ref. "'>" .$pt_tit. "</a></li>";
			}

		}

		// complete controls output
		$controls_out = "
		<div id='filters' class='row'>
			<div class='col-lg-21 col-lg-offset-3 col-md-21 col-md-offset-3 col-sm-24'>
				<ul class='filters-btn list-inline'>
					" .$filters_out. "
				</ul>
			</div><!-- .col-* .col-offset-* -->
		</div><!-- .row -->
		";
		$header_class = "";

	} else {
		$controls_out = "";
		$tit = $wp_post_types[$pt_current]->labels->name;
		$header_class = " bair";
		$ref = "lista";

	}
	if ( $ref == 'mosaico' ) { $cols = '21'; } else { $cols = '16'; }

} elseif ( array_key_exists('s', $_GET) )  {
// if search, also if empty search
	$s_query = get_search_query();
	if ( $s_query == '' ) { $tit = __('Search results','cedobi'); }
	else { $tit = sprintf( __( 'Search results: <em>%s</em>','cedobi' ), $s_query ); }
	$ref = "lista";
	$controls_out = "";
	$header_class = " bair";
	$cols = '21';

} // end if archivo

// if tax archive, to complet page title
if ( is_tax() ) {
	$tit .= ": " .single_term_title( '',false );
}
?>

<div id="content" class="container">

<div id="header" class="row<?php echo $header_class ?>">
	<header class="col-md-21 col-md-offset-3 col-sm-24">
	<h1><?php echo $tit ?></h1>
	</header>
</div><!-- .row -->

<?php echo $controls_out; ?>

<div class="row">
	<section id="main" class="col-md-<?php echo $cols ?> col-md-push-3">

	<?php if ( have_posts() ) {

		if ( $ref == 'mosaico' ) { $desktop_count = 0; $view_cols_desktop = 6; echo "<div id='" .$ref. "' class='row'>"; }
		if ( $ref == 'lista' ) {
			echo "<table id='" .$ref. "' class='table table-hover table-responsive'>
				<thead>
				<tr>
			";
			if ( $pt_current == 'archivo' || $pt_current == 'brigadista' || $pt_current == 'fotografia' || $pt_current == 'documento' || array_key_exists('s', $_GET) ) {
				$th_name = __('Name','cedobi');
				$th_type = __('Type','cedobi');
				$th_desc = __('Description','cedobi');
				echo "<th></th><th>" .$th_name. "</th><th>" .$th_type. "</th><th>" .$th_desc. "</th>";

			} elseif ( $pt_current == 'publicacion' ) {
				$th_year = __('Year','cedobi');
				$th_name = __('Title','cedobi');
				$th_author = __('Authors','cedobi');
				$th_desc = __('Extract','cedobi');
				echo "<th></th><th>" .$th_year. "</th><th>" .$th_name. "</th><th>" .$th_author. "</th><th>" .$th_desc. "</th>";

			} elseif ( $pt_current == 'noticia' ) {
				$th_year = __('Date','cedobi');
				$th_name = __('Title','cedobi');
				$th_desc = __('Extract','cedobi');
				echo "<th></th><th>" .$th_year. "</th><th>" .$th_name. "</th><th>" .$th_desc. "</th>";

			} elseif ( $pt_current == 'convocatoria' ) {
				$th_year = __('Validity','cedobi');
				$th_name = __('Call','cedobi');
				$th_desc = __('Extract','cedobi');
				echo "<th></th><th>" .$th_year. "</th><th>" .$th_name. "</th><th>" .$th_desc. "</th>";

			}
			echo "
				</tr>
				</thead>
				<tbody>
			";
		}

		while ( have_posts() ) : the_post();

			if ( $ref == 'mosaico' ) {
				if ( $desktop_count == $view_cols_desktop ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
			}
			include "loop." .$ref. ".php";

		endwhile;
		if ( $ref == 'mosaico' ) { echo "</div><!-- #" .$ref. " -->"; }
		if ( $ref == 'lista' ) { echo "</tbody></table><!-- #" .$ref. " -->"; }

	} else {
		echo "<div class='alert alert-danger'>" .__('<p>We did not find anything related with your search criteria.</p><p>You can try again!</p>','cedobi'). "</div>";
	} // end if posts
	?>

	<div class="row"><div class="col-sm-24">
	<?php if ( $pt_current == 'fotografia' ) {
		echo "<div class='foto-mas'><a href='http://www.flickr.com/photos/iea__cedobi/'>" .__('Photo archives in flickr','cedobi'). "</a>.</div>";
	}
	include "pagination.php"; ?>
	</div></div>

	</section><!-- #main -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
