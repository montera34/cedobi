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
	add_filter( 'image_size_names_choose', 'cedobi_custom_sizes' );

	/* Add your nav menus function to the 'init' action hook. */
	add_action( 'init', 'cedobi_register_menus' );

	/* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
	add_action( 'wp_enqueue_scripts', 'cedobi_load_scripts' );

	// Custom post types
	add_action( 'init', 'cedobi_create_post_type', 0 );

	// Custom Taxonomies
	add_action( 'init', 'cedobi_build_taxonomies', 0 );

	// Extra meta boxes in editor
	add_filter( 'cmb_meta_boxes', 'cedobi_metaboxes' );
	// Initialize the metabox class
	add_action( 'init', 'cedobi_init_metaboxes', 9999 );

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
	add_theme_support( 'post-thumbnails', array( 'page','brigadista','fotografia','documento','noticia','convocatoria','publicacion' ) );
	//set_post_thumbnail_size( 231, 0 ); // default Post Thumbnail dimensions

	// add icon and extra sizes
	add_image_size( 'icon', '32', '32', true );
	//add_image_size( 'bigicon', '48', '48', true );
	add_image_size( 'small', '192', '0', false );
	//add_image_size( 'extralarge', '819', '0', false );

	/* set up image sizes*/
	update_option('thumbnail_size_w', 96);
	update_option('thumbnail_size_h', 96);
	update_option('thumbnail_crop', 1);
	update_option('medium_size_w', 288);
	update_option('medium_size_h', 0);
	update_option('large_size_w', 576);
	update_option('large_size_h', 0);

} // end set up media options

function cedobi_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'icon' => __('Icon'),
		'small' => __('Small'),
//		'extralarge' => __('Extra Large'),
	) );
}


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
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/bootstrap/css/bootstrap-theme.min.css' );
	wp_enqueue_style( 'fontsquirrel-css', get_template_directory_uri() . '/fonts/junction.css' );
	if ( is_home() ) {
	wp_enqueue_script(
		'imagesloaded-js',
		get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js',
		array(),
		'3.1.7',
		TRUE
	);
	wp_enqueue_script(
		'masonry-js',
		get_template_directory_uri() . '/js/masonry.pkgd.min.js',
		array('imagesloaded-js'),
		'3.1.5',
		TRUE
	);
	wp_enqueue_script(
		'masonry-options-js',
		get_template_directory_uri() . '/js/masonry.options.js',
		array('masonry-js'),
		'0.1',
		TRUE
	);
	}
	wp_enqueue_script('jquery');
	wp_enqueue_script(
		'bootstrap-js',
		get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js',
		array( 'jquery' ),
		'3.1.1',
		FALSE
	);
	if ( is_home() ) {
	wp_enqueue_script(
		'mosac-js',
		get_template_directory_uri() . '/js/mosac.js',
		array( 'bootstrap-js' ),
		'0.1',
		FALSE
	);
	}

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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'documento','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Noticias custom post type
	register_post_type( 'noticia', array(
		'labels' => array(
			'name' => __( 'Noticias' ),
			'singular_name' => __( 'Noticia' ),
			'add_new_item' => __( 'Add a noticia' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this noticia' ),
			'new_item' => __( 'New noticia' ),
			'view' => __( 'View noticia' ),
			'view_item' => __( 'View this noticia' ),
			'search_items' => __( 'Search noticias' ),
			'not_found' => __( 'No noticia found' ),
			'not_found_in_trash' => __( 'No noticias in trash' ),
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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'noticia','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
	// Convocatorias custom post type
	register_post_type( 'convocatoria', array(
		'labels' => array(
			'name' => __( 'Convocatorias' ),
			'singular_name' => __( 'Convocatoria' ),
			'add_new_item' => __( 'Add a convocatoria' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this convocatoria' ),
			'new_item' => __( 'New convocatoria' ),
			'view' => __( 'View convocatoria' ),
			'view_item' => __( 'View this convocatoria' ),
			'search_items' => __( 'Search convocatorias' ),
			'not_found' => __( 'No convocatoria found' ),
			'not_found_in_trash' => __( 'No convocatorias in trash' ),
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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'convocatoria','with_front'=>false),
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
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
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
	// Fecha taxonomy
	register_taxonomy( 'autor', array('fotografia','documento','publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Autor' ),
		'name' => __( 'Autores' ),
		'query_var' => 'autor',
		'rewrite' => array( 'slug' => 'autor', 'with_front' => false ),
		'show_admin_column' => true
	) );
	// Origen taxonomy
	register_taxonomy( 'origen', array('brigadista'), array(
		'hierarchical' => true,
		'label' => __( 'Origen' ),
		'name' => __( 'Origen' ),
		'query_var' => 'origen',
		'rewrite' => array( 'slug' => 'origen', 'with_front' => false ),
		'show_admin_column' => true
	) );
	// Colección taxonomy
	register_taxonomy( 'coleccion', array('publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Colección' ),
		'name' => __( 'Colecciones' ),
		'query_var' => 'coleccion',
		'rewrite' => array( 'slug' => 'coleccion', 'with_front' => false ),
		'show_admin_column' => true
	) );
	// Fondo taxonomy
	register_taxonomy( 'fondo', array('fotografia'), array(
		'hierarchical' => false,
		'label' => __( 'Fondo' ),
		'name' => __( 'Fondos' ),
		'query_var' => 'fondo',
		'rewrite' => array( 'slug' => 'fondo', 'with_front' => false ),
		'show_admin_column' => true
	) );
} // end register taxonomies

//Add metaboxes to several post types edit screen
function cedobi_metaboxes( $meta_boxes ) {
	$prefix = '_cedobi_'; // Prefix for all fields

	// CUSTOM FIELDS FOR BRIGADISTAS
	$meta_boxes[] = array(
		'id' => 'cedobi_dates',
		'title' => 'Fechas',
		'pages' => array('brigadista'), // post type
		'context' => 'side', //  'normal', 'advanced', or 'side'
		'priority' => 'default',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Fecha de nacimiento',
				'desc' => 'Formato: dd/mm/aa',
				'id'   => $prefix . 'date_birth',
				'type' => 'text_date',
				'repeatable' => false,
			),
			array(
				'name' => 'Fecha de defunción',
				'desc' => 'Formato: dd/mm/aa',
				'id'   => $prefix . 'date_dead',
				'type' => 'text_date',
				'repeatable' => false,
			),
		),
	);
	// CUSTOM FIELDS FOR FOTOGRAFÍAS, PUBLICACIONES, MATERIAL
//	$meta_boxes[] = array(
//		'id' => 'cedobi_author',
//		'title' => 'Autor',
//		'pages' => array('fotografia','documento','publicacion'), // post type
//		'context' => 'normal', //  'normal', 'advanced', or 'side'
//		'priority' => 'high',  //  'high', 'core', 'default' or 'low'
//		'show_names' => true, // Show field names on the left
//		'fields' => array(
//			array(
//				'name' => 'Nombre',
//				'desc' => '',
//				'id' => $prefix . 'author_firstname',
//				'type' => 'text',
//			),
//			array(
//				'name' => 'Apellidos',
//				'desc' => '',
//				'id' => $prefix . 'author_lastname',
//				'type' => 'text',
//			),
//		),
//	);
	// CUSTOM FIELDS FOR CONVOCATORIAS
	$meta_boxes[] = array(
		'id' => 'cedobi_current',
		'title' => 'Fechas',
		'pages' => array('convocatoria'), // post type
		'context' => 'side', //  'normal', 'advanced', or 'side'
		'priority' => 'default',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Fecha de inicio',
				'id'   => $prefix . 'date_ini',
				'type' => 'text_date_timestamp',
				'repeatable' => false,
			),
			array(
				'name' => 'Fecha de fin',
				'id'   => $prefix . 'date_end',
				'type' => 'text_date_timestamp',
				'repeatable' => false,
			),
		),
	);
	return $meta_boxes;
} // end Add metaboxes

// Initialize the metabox class
function cedobi_init_metaboxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metabox/init.php' );
	}
} // end Init metaboxes


add_filter( 'pre_get_posts', 'cedobi_filter_loop' );
function cedobi_filter_loop( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		//if ( array_key_exists('pt', $_POST) ) {
		//} else {
		$pts = array('brigadista','fotografia','documento');
		//}
		$query->set( 'post_type', $pts );
	}
	return $query;
}

?>
