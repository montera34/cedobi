<?php 
global $wp_rewrite;			
//$post_type = get_post_type();
$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
$total = $wp_query->max_num_pages;

$pag_args = array(
	'total' => $total,
	'current' => $current,
	'mid_size' => 3,
	'prev_text' => __('&laquo;'),
	'next_text' => __('&raquo;'),
	'type' => 'array',
);

if( $wp_rewrite->using_permalinks() ) { // if pretty permalinks

	if ( array_key_exists('s', $_GET) ) { // if search results
		$url_raw = "http://" .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$url_raw = preg_replace('/\/page\/[0-9]*/','',$url_raw);
		$pt_current = sanitize_text_field( $_GET['post_type'] );
//	$pag_args['base'] = $url_clean. "page/%#%/", 'paged'). "?s=" .get_query_var('s'). "&post_type=" .$_GET['post_type'];
		$pag_args['base'] = user_trailingslashit( trailingslashit( remove_query_arg(array('s','post_type'),$url_raw)). "page/%#%/", 'paged'). "?s=" .get_query_var('s'). "&post_type=" .$pt_current;
	}

	elseif ( array_key_exists('view', $_GET) ) { // if view query arg is set
		$view_current = sanitize_text_field( $_GET['view'] );
		$pag_args['base'] = user_trailingslashit( trailingslashit( remove_query_arg('view',get_pagenum_link(1)) ) . "page/%#%/", 'paged') . "?view=" .$view_current;
	}

	else {
		$url_raw = "http://" .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$url_raw = preg_replace('/\/page\/[0-9]*/','',$url_raw);
		//$pag_args['base'] = user_trailingslashit( trailingslashit( remove_query_arg(get_pagenum_link(1))). "page/%#%/", 'paged');
		$pag_args['base'] = user_trailingslashit( trailingslashit( $url_raw ). "page/%#%/", 'paged' );

	}
} // end if pretty permalink

$pags = paginate_links($pag_args);
if ( $pags != '' ) { // if pags has pages
	$pag_list = "";
	foreach ( paginate_links($pag_args) as $pag ) {
		if ( preg_match('/current/',$pag) == 1 ) { $pags_list .= "<li class='active'>" .$pag. "</li>"; }
		elseif ( preg_match('/dots/',$pag) == 1 ) { $pags_list .= "<li class='disabled'>" .$pag. "</li>"; }
		else { $pags_list .= "<li>" .$pag. "</li>"; }
	}
	// output
	$pag_out =
	"<ul class='pagination'>"
		.$pags_list.
	"</ul>
	";

	echo $pag_out;

} // end if pags has pages
?>
