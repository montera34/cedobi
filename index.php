<?php get_header();

// custom post types info
global $wp_post_types;
// get post type
if ( is_home() ) { $pt_current = "archivo"; }
else { $pt_current = get_post_type(); }

// build filters buttons and page main title
if ( $pt_current == 'archivo' && !array_key_exists('s', $_GET)
	|| $pt_current == 'brigadista' && !array_key_exists('s', $_GET)
	|| $pt_current == 'fotografia' && !array_key_exists('s', $_GET)
	|| $pt_current == 'documento' && !array_key_exists('s', $_GET) ) {
// if archivo

	// get view
	if ( array_key_exists('view', $_GET) ) {
		$view_current = sanitize_text_field( $_GET['view'] );
	} elseif ( !array_key_exists('view', $_GET) && is_home() ) {
		$view_current = "mosaico";
	} else {
		$view_current = "lista";
	}

	// build filters buttons
	$pts = array("brigadista","fotografia","documento","archivo");
	$filters_out = "";
	foreach ( $pts as $pt ) {
		if ( $pt == $pt_current ) {
			$active_class = " class='active'";
			if ( $pt_current == "archivo" ) { $tit = __('International Brigades Digital Archive','cedobi'); }
			else { $tit = $wp_post_types[$pt]->labels->name; }

		} else { $active_class = ""; }
		if ( $pt == 'archivo' ) {
			$filters_out .= "<div class='col-md-6 col-sm-6 col-xs-12 filter-" .$pt. "'><a" .$active_class. " href='" .CEDOBI_BLOGURL. "?view=" .$view_current. "'>" .__('Complete archive','cedobi'). "</a></div>";
		} else {
			$pt_tit = $wp_post_types[$pt]->labels->name;
			$filters_out .= "<div class='col-md-6 col-sm-6 col-xs-12 filter-" .$pt. "'><a" .$active_class. " href='" .CEDOBI_BLOGURL . $pt. "?view=" .$view_current. "'>" .$pt_tit. "</a></div>";
		}

	}

	// build views buttons
	$views = array("mosaico","lista");
	$views_out = "";
	foreach ( $views as $view ) {
		if ( $view == $view_current ) { $active_class = " class='active'"; }
		else { $active_class = ""; }
		if ( $pt_current == 'archivo' || array_key_exists('s', $_GET) ) {
			$views_out .= "<div class='col-lg-4 col-md-6 col-sm-5 col-xs-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .CEDOBI_BLOGURL. "?view=" .$view. "'>" .$view. "</a></div>";
		} else {
			$views_out .= "<div class='col-lg-4 col-md-6 col-sm-5 col-xs-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .CEDOBI_BLOGURL.$pt_current. "?view=" .$view. "'>" .$view. "</a></div>";
		}
	}

	// complete controls output
	$controls_out = "
	<div id='filters' class='row bair'>
		<div class='col-lg-12 col-lg-offset-3 col-md-13 col-md-offset-3 col-sm-18'>
			<div class='filters-tit'>" .__('Filter','cedobi'). "</div>
			<div class='filters-btn row'>
				" .$filters_out. "
			</div>
		</div><!-- .col-* .col-offset-* -->
		<div class='col-lg-4 col-md-3 col-sm-6'>
			<div class='filters-tit'>" .__('View','cedobi'). "</div>
			<div class='filters-btn vista-btn row'>
				" .$views_out. "
			</div>
		</div><!-- .col-md-8 -->
	</div><!-- .row -->
	";
	$header_class = "";

} elseif ( array_key_exists('s', $_GET) )  {
// if search, also if empty search
	$s_query = get_search_query();
	if ( $s_query == '' ) { $tit = __('Search results','cedobi'); }
	else { $tit = sprintf( __( 'Search results: <em>%s</em>','cedobi' ), $s_query ); }
	$view_current = "lista";
	$controls_out = "";


} else {
// if convoca, noticias, publica
	$tit = $wp_post_types[$pt_current]->labels->name;
	$view_current = "lista";
	$controls_out = "";
	$header_class = " bair";
} // end if archivo

// if tax archive, to complet page title
if ( is_tax() ) {
	$tit .= ": " .single_term_title( '',false );
}
?>

<div id="content" class="container">

<div id="header" class="row<?php echo $header_class ?>">
	<header class="col-md-16 col-md-offset-3 col-sm-24">
	<h1><?php echo $tit ?></h1>
	</header>
</div><!-- .row -->

<?php echo $controls_out; ?>

<div class="row">
	<section id="main" class="col-md-16 col-md-push-3">

	<?php if ( have_posts() ) {

		if ( $view_current == 'mosaico' ) { $desktop_count = 0; $view_cols_desktop = 4; echo "<div id='" .$view_current. "' class='row'>"; }
		if ( $view_current == 'lista' ) {
			echo "<table id='" .$view_current. "' class='table table-hover table-responsive'>
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

			if ( $view_current == 'mosaico' ) {
				if ( $desktop_count == $view_cols_desktop ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$desktop_count++;
			}
			include "loop." .$view_current. ".php";

		endwhile;
		if ( $view_current == 'mosaico' ) { echo "</div><!-- #" .$view_current. " -->"; }
		if ( $view_current == 'lista' ) { echo "</tbody></table><!-- #" .$view_current. " -->"; }

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

<div class="row">
	<section id="map" class="col-sm-24">
		<h2>Mapa de las Brigadas Internacionales en Albacete</h2>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="360" id="umapper_embed"><param name="FlashVars" value="kmlPath=http://umapper.s3.amazonaws.com/maps/kml/268723.kml" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="movie" value="http://umapper.s3.amazonaws.com/templates/swf/embed.swf" /><param name="quality" value="high" /><embed src="http://umapper.s3.amazonaws.com/templates/swf/embed.swf" FlashVars="kmlPath=http://umapper.s3.amazonaws.com/maps/kml/268723.kml" allowScriptAccess="always" allowFullScreen="true" quality="high" width="100%" height="360" name="umapper_embed" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
	</section>
</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
