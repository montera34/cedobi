<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
		echo ' | ' . sprintf( __( 'Page %s','cedobi' ), max( $paged, $page ) );

	?>
</title>

<?php // metatags generation
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
<meta content="<?php echo CEDOBI_BLOGNAME ?>" name="author" />
<meta content="<?php echo CEDOBI_BLOGDESC ?>" name="description" />
<meta content="<?php _e('international brigades, spanish civil war, international brigadiers','cedobi'); ?>" name="keywords" />
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
		<div id="pre-margeni" class="col-md-3 col-sm-3">
			<a href="<?php echo CEDOBI_BLOGURL ?>" title="<?php echo CEDOBI_BLOGDESC ?>"><img src="<?php echo CEDOBI_BLOGTHEME. "/images/cedobi-imago.png"; ?>" alt="<?php echo CEDOBI_BLOGNAME ?>" /></a>
		</div><!-- #pre-margeni -->
		<div id="pre-main" class="col-md-18 col-sm-17 col-xs-16">
			<div class="row">
				<?php echo "<div id='logo' class='col-lg-4 col-md-5'>" .CEDOBI_BLOGNAME. "</div>
					<div id='tagline' class='col-lg-20 col-md-19'>" .CEDOBI_BLOGDESC. "</div>"; ?>
			</div>

			<div class="row">
				<div class="col-sm-24">
				<nav id="pre-nav" class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cedobi-pre-nav-collapse">
								<span class="sr-only"><?php _e('Toggle menu','cedobi'); ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="cedobi-pre-nav-collapse">
							<?php
							$menu_args = array(
								'theme_location'  => 'pre-nav',
								'container'       => false,
								'menu_class'      => 'nav navbar-nav',
								'menu_id'         => 'navbar-main',
								'walker'          => ''
							);
							wp_nav_menu( $menu_args );
							?>
						</div>
					</div>
				</nav>
				</div>

			</div>

		</div><!-- #pre-main -->
		<div id="pre-margend" class="col-md-3 col-sm-4 col-xs-8">
			<ul id="cedobi-social" class="list-inline">
				<li id="cedobi-fb"><a title="Facebook" href="https://facebook.com/cedobi">Facebook</a></li>
				<li id="cedobi-fk"><a title="Flickr" href="http://flickr.com/photos/iea__cedobi">Flickr</a></li>
				<li id="cedobi-rss"><a title="Feed RSS" href="<?php echo CEDOBI_BLOGURL. "feed"; ?>">RSS</a></li>
			</ul>
			<?php do_action('icl_language_selector');
			//$languages = icl_get_languages('skip_missing=0&orderby=name&order=asc&link_empty_to=str');
			?>
		</div><!-- #pre-margeni -->

	</div><!-- .row -->
</div><!-- #pre .container -->
