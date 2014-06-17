<?php get_header();

// custom post types info
global $wp_post_types;
// get post type
if ( is_home() ) { $pt_current = "archivo"; }
else { $pt_current = get_post_type(); }

// build filters buttons and page main title
$base = CEDOBI_BLOGURL;

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
			if ( $pt_current == "archivo" ) { $tit = "Archivo digital de las Brigadas Internacionales"; }
			else { $tit = $wp_post_types[$pt]->labels->name; }

		} else { $active_class = ""; }
		if ( $pt == 'archivo' ) {
			$filters_out .= "<div class='col-md-6 col-sm-6 col-xs-12 filter-" .$pt. "'><a" .$active_class. " href='" .$base. "?view=" .$view_current. "'>Archivo completo</a></div>";
		} else {
			$pt_tit = $wp_post_types[$pt]->labels->name;
			$filters_out .= "<div class='col-md-6 col-sm-6 col-xs-12 filter-" .$pt. "'><a" .$active_class. " href='" .$base. "/" .$pt. "?view=" .$view_current. "'>" .$pt_tit. "</a></div>";
		}

	}

	// build views buttons
	$views = array("mosaico","lista");
	$views_out = "";
	foreach ( $views as $view ) {
		if ( $view == $view_current ) { $active_class = " class='active'"; }
		else { $active_class = ""; }
		if ( $pt_current == 'archivo' || array_key_exists('s', $_GET) ) {
			$views_out .= "<div class='col-lg-4 col-md-6 col-sm-5 col-xs-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .$base. "?view=" .$view. "'>" .$view. "</a></div>";
		} else {
			$views_out .= "<div class='col-lg-4 col-md-6 col-sm-5 col-xs-4 vista-" .$view. "'><a" .$active_class. " title='" .$view. "' href='" .$base. "/" .$pt_current. "?view=" .$view. "'>" .$view. "</a></div>";
		}
	}

	// complete controls output
	$controls_out = "
	<div id='filters' class='row bair'>
		<div class='col-lg-12 col-lg-offset-3 col-md-13 col-md-offset-3 col-sm-18'>
			<div class='filters-tit'>Mostrar</div>
			<div class='filters-btn row'>
				" .$filters_out. "
			</div>
		</div><!-- .col-* .col-offset-* -->
		<div class='col-lg-4 col-md-3 col-sm-6'>
			<div class='filters-tit'>Vista</div>
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
	if ( $s_query == '' ) { $tit = "Resultados de la búsqueda"; }
	else { $tit = "Resultados de la búsqueda '" .$s_query. "'";}
	$view_current = "lista";


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
				echo "<th>Imagen</th><th>Nombre</th><th>Tipo</th><th>Descripción</th>";
			} else {
				echo "<th>Imagen</th><th>Nombre</th><th>Descripción</th>";
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
		echo "<div class='alert alert-danger'><p>No hemos encontrado ningún contenido que responda a tus criterios de búsqueda.</p><p>Inténtalo otra vez.</p></div>";
	} // end if posts
	?>

	<div class="row"><div class="col-sm-24">
	<?php include "pagination.php"; ?>
	</div></div>

	</section><!-- #main -->

	<?php get_sidebar(); ?>

</div><!-- .row -->

</div><!-- #content .container -->

<?php get_footer(); ?>
