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
	    define('CEDOBI_BLOGURL', trailingslashit(get_bloginfo('url')));

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

	// create year custom field based in tax to sort post
	//add_action('wp_insert_post', 'cedobi_write_cf_year', 9999 );
	add_action('updated_post_meta', 'cedobi_write_cf_year', 9999 );

	// set up wp_query args
	add_filter( 'pre_get_posts', 'cedobi_filter_loop' );

	// load language files
	load_theme_textdomain( 'cedobi', get_template_directory() . '/lang' );

	// build feed with custom post types
	add_filter('request', 'cedobi_build_feed');

	// add capabilities to some WordPress roles when this theme is activated
	add_action( 'after_switch_theme', 'cedobi_add_caps_to_roles', 10 ); 
	// remove capabilities given by this theme
	add_action( 'switch_theme', 'cedobi_remove_caps_to_roles', 10 );

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
	add_image_size( 'bigicon', '48', '0', false );
	add_image_size( 'small', '192', '0', false );
	//add_image_size( 'extralarge', '819', '0', false );

	/* set up image sizes*/
	update_option('thumbnail_size_w', 96);
	update_option('thumbnail_size_h', 96);
	update_option('thumbnail_crop', 1);
	update_option('medium_size_w', 478);
	update_option('medium_size_h', 0);
	update_option('large_size_w', 800);
	update_option('large_size_h', 0);

} // end set up media options

function cedobi_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'icon' => __('Icon','cedobi'),
		'bigicon' => __('Big icon','cedobi'),
		'small' => __('Small','cedobi'),
//		'extralarge' => __('Extra Large'),
	) );
}


// register custom menus
function cedobi_register_menus() {
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
		array(
			'pre-nav' => __('Header menu','cedobi'),
			'epi-nav' => __('Footer menu','cedobi'),
		)
		);
	}
} // end register custom menus

// load js scripts to avoid conflicts
function cedobi_load_scripts() {
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/bootstrap/css/bootstrap-theme.min.css' );
	wp_enqueue_style( 'fontsquirrel-css', get_template_directory_uri() . '/fonts/junction.css' );
	if ( array_key_exists('view', $_GET) && sanitize_text_field( $_GET['view'] ) == 'mosaico'
		|| !array_key_exists('view', $_GET) && is_home()
	) {
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
	wp_enqueue_script(
		'mosac-js',
		get_template_directory_uri() . '/js/mosac.js',
		array( 'bootstrap-js' ),
		'0.1',
		FALSE
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
	wp_enqueue_script(
		'search-js',
		get_template_directory_uri() . '/js/search.js',
		array( 'bootstrap-js' ),
		'0.1',
		FALSE
	);
	wp_enqueue_script(
		'dropdown-hover-js',
		get_template_directory_uri() . '/js/dropdown.hover.js',
		array( 'jquery' ),
		'0.1',
		FALSE
	);

	// brigadistas en albacete map
	if ( is_page('384')) {
	wp_enqueue_script(
		'gmaps-api-js',
		//'http://maps.googleapis.com/maps/api/js',
		'https://maps.google.com/maps/api/js?v=3.exp&libraries=places&signed_in=true',
		array(),
		null,
		true
	);
	wp_enqueue_script(
		'map-brigadas-controls-js',
		get_template_directory_uri() . '/js/map.brigadas.js',
		array(),
		'0.1',
		true
	);

	}

} // end load js scripts to avoid conflicts

// register post types
function cedobi_create_post_type() {
	// Brigadistas custom post type
	register_post_type( 'brigadista', array(
		'labels' => array(
			'name' => __( 'Brigadiers archive','cedobi' ),
			'singular_name' => __( 'Brigadier','cedobi' ),
			'add_new_item' => __( 'Add a brigadier','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this brigadier','cedobi' ),
			'new_item' => __( 'New brigadier','cedobi' ),
			'view' => __( 'View brigadier','cedobi' ),
			'view_item' => __( 'View this brigadier','cedobi' ),
			'search_items' => __( 'Search brigadier','cedobi' ),
			'not_found' => __( 'No brigadiers found','cedobi' ),
			'not_found_in_trash' => __( 'No brigadiers in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-brigadista.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'brigadista','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
	// Fotografia custom post type
	register_post_type( 'fotografia', array(
		'labels' => array(
			'name' => __( 'Photos Archives','cedobi' ),
			'singular_name' => __( 'Photo','cedobi' ),
			'add_new_item' => __( 'Add a photo','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this photo','cedobi' ),
			'new_item' => __( 'New photo','cedobi' ),
			'view' => __( 'View photo','cedobi' ),
			'view_item' => __( 'View this photo','cedobi' ),
			'search_items' => __( 'Search photos','cedobi' ),
			'not_found' => __( 'No photos found','cedobi' ),
			'not_found_in_trash' => __( 'No photos in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-fotografia.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'fotografia','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
	// Recursos digitales custom post type
	register_post_type( 'documento', array(
		'labels' => array(
			'name' => __( 'Digital resources','cedobi' ),
			'singular_name' => __( 'Digital resource','cedobi' ),
			'add_new_item' => __( 'Add a digital resource','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this digital resource','cedobi' ),
			'new_item' => __( 'New digital resource','cedobi' ),
			'view' => __( 'View digital resource','cedobi' ),
			'view_item' => __( 'View this digital resource','cedobi' ),
			'search_items' => __( 'Search digital resource','cedobi' ),
			'not_found' => __( 'No digital resources found','cedobi' ),
			'not_found_in_trash' => __( 'No digital resources in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-documento.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'documento','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
	// Noticias custom post type
	register_post_type( 'noticia', array(
		'labels' => array(
			'name' => __( 'News','cedobi' ),
			'singular_name' => __( 'New','cedobi' ),
			'add_new_item' => __( 'Add a new','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this new','cedobi' ),
			'new_item' => __( 'New new','cedobi' ),
			'view' => __( 'View new','cedobi' ),
			'view_item' => __( 'View this new','cedobi' ),
			'search_items' => __( 'Search news','cedobi' ),
			'not_found' => __( 'No news found','cedobi' ),
			'not_found_in_trash' => __( 'No news in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-noticia.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'noticia','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
	// Convocatorias custom post type
	register_post_type( 'convocatoria', array(
		'labels' => array(
			'name' => __( 'Calls','cedobi' ),
			'singular_name' => __( 'Call','cedobi' ),
			'add_new_item' => __( 'Add a call','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this call','cedobi' ),
			'new_item' => __( 'New call','cedobi' ),
			'view' => __( 'View call','cedobi' ),
			'view_item' => __( 'View this call','cedobi' ),
			'search_items' => __( 'Search calls','cedobi' ),
			'not_found' => __( 'No calls found','cedobi' ),
			'not_found_in_trash' => __( 'No calls in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-convocatoria.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'convocatoria','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
	// Publicaciones custom post type
	register_post_type( 'publicacion', array(
		'labels' => array(
			'name' => __( 'Publications','cedobi' ),
			'singular_name' => __( 'Publication','cedobi' ),
			'add_new_item' => __( 'Add a publication','cedobi' ),
			'edit' => __( 'Edit','cedobi' ),
			'edit_item' => __( 'Edit this publication','cedobi' ),
			'new_item' => __( 'New publication','cedobi' ),
			'view' => __( 'View publication','cedobi' ),
			'view_item' => __( 'View this publication','cedobi' ),
			'search_items' => __( 'Search publications','cedobi' ),
			'not_found' => __( 'No publications found','cedobi' ),
			'not_found_in_trash' => __( 'No publications in trash','cedobi' ),
			'parent' => __( 'Parent','cedobi' )
		),
		'description' => '',
		'has_archive' => true,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cedobi-dashboard-pt-publicacion.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','author','comments','trackbacks','thumbnail' ),
		'rewrite' => array('slug'=>'publicacion','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'show_in_rest' => true
	));
} // end register post types

// register taxonomies
function cedobi_build_taxonomies() {
	// Fecha taxonomy
	register_taxonomy( 'fecha', array('fotografia','documento','publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Year','cedobi' ),
		'name' => __( 'Years','cedobi' ),
		'query_var' => 'fecha',
		'rewrite' => array( 'slug' => 'fecha', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	// Origen taxonomies
	register_taxonomy( 'ciudad', array('brigadista'), array(
		'hierarchical' => true,
		'label' => __( 'City','cedobi' ),
		'name' => __( 'Cities','cedobi' ),
		'query_var' => 'ciudad',
		'rewrite' => array( 'slug' => 'ciudad', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	register_taxonomy( 'region', array('brigadista'), array(
		'hierarchical' => true,
		'label' => __( 'State','cedobi' ),
		'name' => __( 'States','cedobi' ),
		'query_var' => 'region',
		'rewrite' => array( 'slug' => 'region', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	register_taxonomy( 'pais', array('brigadista'), array(
		'hierarchical' => true,
		'label' => __( 'Contry','cedobi' ),
		'name' => __( 'Countries','cedobi' ),
		'query_var' => 'pais',
		'rewrite' => array( 'slug' => 'pais', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	// Editorial and Colección taxonomies
	register_taxonomy( 'coleccion', array('publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Collection','cedobi' ),
		'name' => __( 'Collections','cedobi' ),
		'query_var' => 'coleccion',
		'rewrite' => array( 'slug' => 'coleccion', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	register_taxonomy( 'editorial', array('publicacion'), array(
		'hierarchical' => false,
		'label' => __( 'Editorial','cedobi' ),
		'name' => __( 'Editorials','cedobi' ),
		'query_var' => 'editorial',
		'rewrite' => array( 'slug' => 'editorial', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	register_taxonomy( 'editor', array('publicacion'), array(
		'hierarchical' => true,
		'label' => __( 'Publisher','cedobi' ),
		'name' => __( 'Publishers','cedobi' ),
		'query_var' => 'editor',
		'rewrite' => array( 'slug' => 'editor', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );

	// Fondo taxonomy
	register_taxonomy( 'fondo', array('fotografia'), array(
		'hierarchical' => false,
		'label' => __( 'Archive','cedobi' ),
		'name' => __( 'Archives','cedobi' ),
		'query_var' => 'fondo',
		'rewrite' => array( 'slug' => 'fondo', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	// Tipo taxonomy
	register_taxonomy( 'formato', array('documento'), array(
		'hierarchical' => true,
		'label' => __( 'Format','cedobi' ),
		'name' => __( 'Formats','cedobi' ),
		'query_var' => 'formato',
		'rewrite' => array( 'slug' => 'formato', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );
	// Genero taxonomy
	register_taxonomy( 'genero', array('documento'), array(
		'hierarchical' => true,
		'label' => __( 'Type','cedobi' ),
		'name' => __( 'Types','cedobi' ),
		'query_var' => 'genero',
		'rewrite' => array( 'slug' => 'genero', 'with_front' => false ),
		'show_admin_column' => true,
		'show_in_rest' => true
	) );

} // end register taxonomies

//Add metaboxes to several post types edit screen
function cedobi_metaboxes( $meta_boxes ) {
	$prefix = '_cedobi_'; // Prefix for all fields

	// CUSTOM FIELDS FOR BRIGADISTAS
	$meta_boxes[] = array(
		'id' => 'cedobi_brigadista',
		'title' => __('Extra information','cedobi'),
		'pages' => array('brigadista'), // post type
		'context' => 'normal', //  'normal', 'advanced', or 'side'
		'priority' => 'high',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('First name','cedobi'),
				'id'   => $prefix . 'brigadista_firstname',
				'type' => 'text',
			),
			array(
				'name' => __('Last name','cedobi'),
				'id'   => $prefix . 'brigadista_lastname',
				'type' => 'text',
			),
			array(
				'name' => __('URL to interview audio file','cedobi'),
				'id'   => $prefix . 'brigadista_audio',
				'type' => 'text_url',
			)
		),
	);
	// CUSTOM FIELDS FOR FOTOGRAFÍAS, PUBLICACIONES, MATERIAL
	$meta_boxes[] = array(
		'id' => 'cedobi_authors',
		'title' => __('Authors','cedobi'),
		'pages' => array('fotografia','documento','publicacion'), // post type
		'context' => 'normal', //  'normal', 'advanced', or 'side'
		'priority' => 'high',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Author 1: firstname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author1_firstname',
				'type' => 'text',
			),
			array(
				'name' => __('Author 1: lastname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author1_lastname',
				'type' => 'text',
			),
			array(
				'name' => __('Author 2: firsname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author2_firstname',
				'type' => 'text',
			),
			array(
				'name' => __('Author 2: lastname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author2_lastname',
				'type' => 'text',
			),
			array(
				'name' => __('Author 3: firstname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author3_firstname',
				'type' => 'text',
			),
			array(
				'name' => __('Author 3: lastname','cedobi'),
				'desc' => '',
				'id' => $prefix . 'author3_lastname',
				'type' => 'text',
			),
		),
	);
	// CUSTOM FIELDS FOR CONVOCATORIAS
	$meta_boxes[] = array(
		'id' => 'cedobi_current',
		'title' => __('Dates','cedobi'),
		'pages' => array('convocatoria'), // post type
		'context' => 'side', //  'normal', 'advanced', or 'side'
		'priority' => 'default',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Begining date','cedobi'),
				'id'   => $prefix . 'date_ini',
				'type' => 'text_date_timestamp',
				'repeatable' => false,
			),
			array(
				'name' => __('Ending date','cedobi'),
				'id'   => $prefix . 'date_end',
				'type' => 'text_date_timestamp',
				'repeatable' => false,
			),
		),
	);
	// CUSTOM FIELDS FOR PUBLICACIONES
	$meta_boxes[] = array(
		'id' => 'cedobi_libro',
		'title' => __('Book data','cedobi'),
		'pages' => array('publicacion'), // post type
		'context' => 'side', //  'normal', 'advanced', or 'side'
		'priority' => 'default',  //  'high', 'core', 'default' or 'low'
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Number of pages','cedobi'),
				'id'   => $prefix . 'publica_pags',
				'type' => 'text',
			),
			array(
				'name' => __('ISBN','cedobi'),
				'id'   => $prefix . 'publica_ISBN',
				'type' => 'text',
			),
			array(
				'name' => __('Downloadable file','cedobi'),
				'id'   => $prefix . 'publica_file',
				'type' => 'file',
				'allow' => array( 'url', 'attachment' )
			),
		),
	);
	// CUSTOM FIELDS FOR ANY POST TYPE
	$meta_boxes[] = array(
		'id' => 'cedobi_not_include_in_home',
		'title' => __('Not include in home','cedobi'),
		'pages' => array('brigadista','fotografia','documento','noticia','publicacion','convocatoria'), // post type
		'context' => 'side', //  'normal', 'advanced', or 'side'
		'priority' => 'high',  //  'high', 'core', 'default' or 'low'
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'desc' => __('Check to not show in home page','cedobi'),
				'id'   => $prefix . 'not_include_in_home',
				'type' => 'checkbox',
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

// create year custom field based in tax to sort post
function cedobi_write_cf_year() {

	global $post;
	if ( $post ) {

	// If this is just a revision, don't continue
	if ( wp_is_post_revision( $post->ID ) )
		return;

	if ( $post->post_type == 'fotografia' && $post->post_status == 'publish' ||
	 $post->post_type == 'documento' && $post->post_status == 'publish' ||
	 $post->post_type == 'publicacion' && $post->post_status == 'publish' ) {

		$post_terms = get_the_terms($post->ID,'fecha');
		foreach ( $post_terms as $term ) {
			update_post_meta($post->ID, '_cedobi_tax_fecha', $term->slug);
		
		}
	}

	} // end if $post

} // create year custom field based in tax to sort post

// set up wp_query args
function cedobi_filter_loop( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		if ( array_key_exists('view', $_GET) && sanitize_text_field( $_GET['view'] ) == 'lista' ) {
			$pts = array('brigadista','fotografia','documento');
		} else {
			$pts = array('brigadista','fotografia','documento','noticia','publicacion','convocatoria');
		}
		$query->set( 'post_type', $pts );
		$args = array(
			'post_type' => array('brigadista','fotografia','documento','noticia','publicacion','convocatoria'),
			'meta_key' => '_cedobi_not_include_in_home',
			'meta_value' => 'on',
			'nopaging' => true
		);
		$not_include_posts = get_posts($args);
		$not_include = array();
		foreach ( $not_include_posts as $p ) { $not_include[] = $p->ID; }
		if ( count($not_include) >= 1 ) { $query->set( 'post__not_in', $not_include ); }

//		$query->set( 'posts_per_page', '12' );

	}
	elseif ( is_post_type_archive('publicacion') && !is_admin() && $query->is_main_query() ||
		is_tax('editor') && !is_admin() && $query->is_main_query() ) {
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', '_cedobi_tax_fecha' );
		$query->set( 'order', 'DESC' );

	}
	elseif ( is_post_type_archive('noticia') && !is_admin() && $query->is_main_query() ) {
		$pts = array('noticia','convocatoria');
		$query->set( 'post_type', $pts );

	}
	elseif ( is_search() && $query->is_main_query() && !array_key_exists('post_type', $_GET) ||
	is_search() && $query->is_main_query() && array_key_exists('post_type', $_GET) && sanitize_text_field( $_GET['post_type'] ) == '' ) {
		$pts = array('brigadista','fotografia','documento','noticia','convocatoria','publicacion');
		$query->set( 'post_type', $pts );

	}
	elseif ( is_post_type_archive( 'brigadista' ) && !is_admin() && $query->is_main_query() ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_cedobi_brigadista_lastname' );
		$query->set( 'order', 'ASC' );
	}

	return $query;
} // end set up wp_query args

// load language files
function cedobi_load_languages(){
	load_theme_textdomain('cedobi', get_template_directory() );
}

// build feed with custom post types
function cedobi_build_feed($qv) {
	if ( isset($qv['feed']) )
		$qv['post_type'] = get_post_types();
	return $qv;
}

// add capabilities to some WordPress roles when this theme is activated
function cedobi_add_caps_to_roles() {
	// Makes sure $wp_roles is initialized
	get_role( 'editor' );

	global $wp_roles;
	// Dont use get_role() wrapper, it doesn't work as a one off.
	// (get_role does not properly return as reference)
	$wp_roles->role_objects['editor']->add_cap( 'edit_theme_options' );
}

// remove capabilities given by humanidad_add_caps_to_roles
function cedobi_remove_caps_to_roles() {
 	get_role( 'editor' );
	global $wp_roles;
	// Could use the get_role() wrapper here since this function is never
	// called as a one off.  It is always called to alter the role as
	// stored in the DB.
	$wp_roles->role_objects['editor']->remove_cap( 'edit_theme_options' );
}

?>
