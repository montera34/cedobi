<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title>
<?php
	/* From twentyeleven theme
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	echo CEDOBI_BLOGNAME;

	// Add the blog description for the home/front page.
	if ( CEDOBI_BLOGDESC && ( is_home() || is_front_page() ) )
		echo " | " . CEDOBI_BLOGDESC;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );

	?>
</title>

<?php
// metatags generation
if ( is_single() || is_page() ) {
	$metadesc = $post->post_excerpt;
	if ( $metadesc == '' ) { $metadesc = $post->post_content; }
	$metadesc = wp_strip_all_tags($post->post_content);
	$metadesc = strip_shortcodes( $metadesc );
	$metadesc_fb = substr( $metadesc, 0, 297 );
	$metadesc_tw = substr( $metadesc, 0, 200 );
	$metadesc = substr( $metadesc, 0, 154 );
	$metatit = $post->post_title;
	$metatype = "article";
	$img_id = get_post_thumbnail_id();
	if ( $img_id != '' ) {
		$img_array = wp_get_attachment_image_src($img_id,'extralarge', true);
		$metaimg = $img_array[0];
	} else {
		$metaimg = get_bloginfo('stylesheet_url'). "/images/cedobi-logo.png";
	}
	$metaperma = get_permalink();

} else {
	$metadesc = CEDOBI_BLOGDESC;
	$metadesc_tw = CEDOBI_BLOGDESC;
	$metadesc_fb = CEDOBI_BLOGDESC;
	$metatit = CEDOBI_BLOGNAME;
	$metatype = "website";
	$metaimg = CEDOBI_BLOGTHEME. "/images/cedobi-logo.png";
	$metaperma = CEDOBI_BLOGURL;
}
?>

<!-- generic meta -->
<meta content="Centro de Estudios de las Brigadas Internacionales" name="author" />
<meta content="<?php echo CEDOBI_BLOGDESC ?>" name="description" />
<meta content="" />
<!-- facebook meta -->
<meta property="og:title" content="<?php echo $metatit ?>" />
<meta property="og:type" content="<?php echo $metatype ?>" />
<meta property="og:description" content="<?php echo $metadesc_fb ?>" />
<meta property="og:url" content="<?php echo $metaperma ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="alternate" type="application/rss+xml" title="<?php echo CEDOBI_BLOGNAME; ?> RSS Feed suscription" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php echo CEDOBI_BLOGNAME; ?> Atom Feed suscription" href="<?php bloginfo('atom_url'); ?>" /> 
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
//if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

</head>

<?php // better to use body tag as the main container ?>
<body <?php body_class(); ?>>

<div id="pre" class="container">
	<div class="row">
		<div id="pre-margeni" class="col-md-2">
			<a href="<?php echo CEDOBI_BLOGURL ?>" title="<?php echo CEDOBI_BLOGDESC ?>"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-imago.png"; ?>" alt="<?php echo CEDOBI_BLOGNAME ?>" /></a>
		</div><!-- #pre-margeni -->
		<div id="pre-main" class="col-md-6">
				<div>
				<?php echo "<span id='logo'>" .CEDOBI_BLOGNAME. "</span> <span id='tagline'>" .CEDOBI_BLOGDESC. "</span>"; ?>
				</div>
				<nav id="pre-nav" class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cedobi-pre-nav-collapse">
								<span class="sr-only">Desplagar/Replegar menú</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="cedobi-pre-nav-collapse">
							<ul id="navbar-main" class="nav navbar-nav">
								<li><a class="active" href="">Inicio</a></li>
								<li><a href="">El CEDOBI</a></li>
								<li><a href="">Archivo</a></li>
								<li><a href="">Actualidad</a></li>
								<li><a href="">Publicaciones</a></li>
							</ul>
						</div>
					</div>
				</nav>
		</div><!-- #pre-main -->
	</div><!-- .row -->
</div><!-- #pre .container -->

<div id="content" class="container">
<div class="row">
