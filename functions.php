<?php
// theme setup main function
add_action( 'after_setup_theme', 'cedobi_theme_setup' );
function cedobi_theme_setup() {

	// theme global vars
	if (!defined('CEDOBI_BLOGNAME'))
	    define('CEDOBI_BLOGNAME', get_bloginfo('name'));

	if (!defined('CEDOBI_BLOGDESC'))
	    define('CEDOBI_BLOGDESC', get_bloginfo('description','display'));

	if (!defined('CEDOBI_BLOGURL'))
	    define('CEDOBI_BLOGURL', get_bloginfo('url'));

	if (!defined('CEDOBI_BLOGTHEME'))
	    define('CEDOBI_BLOGTHEME', get_bloginfo('template_directory'));

	/* Set up media options: sizes, featured images... */
	add_action( 'init', 'cedobi_media_options' );
//	add_filter( 'image_size_names_choose', 'cedobi_custom_sizes' );

	/* Add your nav menus function to the 'init' action hook. */
	add_action( 'init', 'cedobi_register_menus' );

	/* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
	add_action( 'wp_enqueue_scripts', 'cedobi_load_scripts' );

	// Custom post types
	add_action( 'init', 'cedobi_create_post_type', 0 );

	// Custom Taxonomies
	add_action( 'init', 'cedobi_build_taxonomies', 0 );

	// Extra meta boxes in editor
	//add_filter( 'cmb_meta_boxes', 'montera34_metaboxes' );
	// Initialize the metabox class
	//add_action( 'init', 'montera34_init_metaboxes', 9999 );

	// excerpt support in pages
	add_post_type_support( 'page', 'excerpt' );

	// remove unused items from dashboard
	add_action( 'admin_menu', 'cedobi_remove_dashboard_item' );

} // end montera34 theme setup function

// remove item from wordpress dashboard
function cedobi_remove_dashboard_item() {
	remove_menu_page('edit.php');	
}

// set up media options
function cedobi_media_options() {
	/* Add theme support for post thumbnails (featured images). */
	add_theme_support( 'post-thumbnails', array( 'page','brigadista','fotografia','documento','actualidad','publicacion' ) );
	//set_post_thumbnail_size( 231, 0 ); // default Post Thumbnail dimensions

	// add icon and extra sizes
	//add_image_size( 'icon', '32', '32', true );
	//add_image_size( 'bigicon', '48', '48', true );
	//add_image_size( 'small', '234', '0', false );
	//add_image_size( 'extralarge', '819', '0', false );

	/* set up image sizes*/
	update_option('thumbnail_size_w', 117);
	update_option('thumbnail_size_h', 0);
	update_option('medium_size_w', 351);
	update_option('medium_size_h', 0);
	update_option('large_size_w', 468);
	update_option('large_size_h', 0);

} // end set up media options

//function cedobi_custom_sizes( $sizes ) {
//	return array_merge( $sizes, array(
//		'icon' => __('Icon'),
//		'small' => __('Small'),
//		'extralarge' => __('Extra Large'),
//	) );
//}


// register custom menus
function cedobi_register_menus() {
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
		array(
			'pre-nav' => 'Menú de cabecera',
		)
		);
	}
} // end register custom menus

// load js scripts to avoid conflicts
function cedobi_load_scripts() {
	wp_enqueue_script('jquery');

} // end load js scripts to avoid conflicts

// register post types
function cedobi_create_post_type() {
	// Brigadistas custom post type
	register_post_type( 'brigadista', array(
		'labels' => array(
			'name' => __( 'Brigadistas' ),
			'singular_name' => __( 'Brigadista' ),
			'add_new_item' => __( 'Add a brigadista' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this brigadista' ),
			'new_item' => __( 'New brigadista' ),
			'view' => __( 'View brigadista' ),
			'view_item' => __( 'View this brigadista' ),
			'search_items' => __( 'Search brigadista' ),
			'not_found' => __( 'No brigadista found' ),
			'not_found_in_trash' => __( 'No brigadistas in trash' ),
			'parent' => __( 'Parent' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks' ),
		'rewrite' => array('slug'=>'brigadista','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Fotografia custom post type
	register_post_type( 'fotografia', array(
		'labels' => array(
			'name' => __( 'Fotografías' ),
			'singular_name' => __( 'Fotografía' ),
			'add_new_item' => __( 'Add a fotografía' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this fotografía' ),
			'new_item' => __( 'New fotografía' ),
			'view' => __( 'View fotografía' ),
			'view_item' => __( 'View this fotografía' ),
			'search_items' => __( 'Search fotografía' ),
			'not_found' => __( 'No fotografía found' ),
			'not_found_in_trash' => __( 'No fotografías in trash' ),
			'parent' => __( 'Parent' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks' ),
		'rewrite' => array('slug'=>'fotografia','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Recursos digitales custom post type
	register_post_type( 'documento', array(
		'labels' => array(
			'name' => __( 'Recursos digitales' ),
			'singular_name' => __( 'Recurso digital' ),
			'add_new_item' => __( 'Add a documento' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this documento' ),
			'new_item' => __( 'New documento' ),
			'view' => __( 'View documento' ),
			'view_item' => __( 'View this documento' ),
			'search_items' => __( 'Search documento' ),
			'not_found' => __( 'No documento found' ),
			'not_found_in_trash' => __( 'No documentos in trash' ),
			'parent' => __( 'Parent' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks' ),
		'rewrite' => array('slug'=>'documento','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Actualidad custom post type
	register_post_type( 'actualidad', array(
		'labels' => array(
			'name' => __( 'Noticias y convocatorias' ),
			'singular_name' => __( 'Noticia / Convocatoria' ),
			'add_new_item' => __( 'Add a noticia o convocatoria' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this noticia o convocatoria' ),
			'new_item' => __( 'New noticia o convocatoria' ),
			'view' => __( 'View noticia o convocatoria' ),
			'view_item' => __( 'View this noticia o convocatoria' ),
			'search_items' => __( 'Search noticia o convocatoria' ),
			'not_found' => __( 'No noticia o convocatoria found' ),
			'not_found_in_trash' => __( 'No noticias or convocatorias in trash' ),
			'parent' => __( 'Parent' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks' ),
		'rewrite' => array('slug'=>'actualidad','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Publicaciones custom post type
	register_post_type( 'publicacion', array(
		'labels' => array(
			'name' => __( 'Publicaciones' ),
			'singular_name' => __( 'Publicación' ),
			'add_new_item' => __( 'Add a publicación' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this publicación' ),
			'new_item' => __( 'New publicación' ),
			'view' => __( 'View publicación' ),
			'view_item' => __( 'View this publicación' ),
			'search_items' => __( 'Search publicación' ),
			'not_found' => __( 'No publicación found' ),
			'not_found_in_trash' => __( 'No publicaciones in trash' ),
			'parent' => __( 'Parent' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks' ),
		'rewrite' => array('slug'=>'publicacion','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
} // end register post types

// register taxonomies
function cedobi_build_taxonomies() {
	// Fecha taxonomy
	register_taxonomy( 'fecha', array('fotografia','documento','publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Año' ),
		'name' => __( 'Años' ),
		'query_var' => 'fecha',
		'rewrite' => array( 'slug' => 'fecha', 'with_front' => false ),
		'show_admin_column' => true
	) );
	// Origen taxonomy
	register_taxonomy( 'origen', array('brigadistas'), array(
		'hierarchical' => true,
		'label' => __( 'Origen' ),
		'name' => __( 'Origen' ),
		'query_var' => 'origen',
		'rewrite' => array( 'slug' => 'origen', 'with_front' => false ),
		'show_admin_column' => true
	) );

} // end register taxonomies

?>
