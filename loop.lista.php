<?php
// custom post types info
global $wp_post_types;
// post vars
$item_pt =  get_post_type();
$item_name = get_the_title();
$item_perma = get_permalink();
$item_desc = get_the_excerpt();

$item_classes = "class='list-item'";
$item_type_class = $item_pt;

if ( has_post_thumbnail() ) { // image
	$item_img_size = "bigicon";
	$item_img_out = get_the_post_thumbnail( $post->ID,$item_img_size );
} else {
	$item_img_out = "<div class='hideout'>" .__('No image','cedobi'). "</div>";
} // end image
// title and extract
$item_tit_out = "<a href='" .$item_perma. "' title='$item_name'>" .$item_name. "</a>";
$item_desc_out = $item_desc;

// if one of archive post types
if ( $pt_current == 'archivo' || $pt_current == 'brigadista' || $pt_current == 'fotografia' || $pt_current == 'documento' || array_key_exists('s', $_GET) ) {
	$item_type_out = "<td class='list-item-type list-item-type-" .$item_type_class. "'><div>" .$wp_post_types[$item_pt]->labels->name. "</div></td>";
	$item_out = "
	<tr " .$item_classes. ">
		<td class='list-item-img'>" .$item_img_out. "</td>
		<td class='list-item-tit'>" .$item_tit_out. "</td>
		" .$item_type_out. "
		<td class='list-item-desc'>" .$item_desc_out. "</td>
	</tr>
	";

} elseif ( $pt_current == 'publicacion' ) { // if publicacion post type
	$item_year_out = get_the_term_list( $post->ID, 'fecha', '<div class="fecha-terms">', '', '</div>' );
	$author_fields = array(
		array(
			get_post_meta( $post->ID, '_cedobi_author1_firstname', true ),
			get_post_meta( $post->ID, '_cedobi_author1_lastname', true )
		),
		array(
			get_post_meta( $post->ID, '_cedobi_author2_firstname', true ),
			get_post_meta( $post->ID, '_cedobi_author2_lastname', true )
		),
		array(
			get_post_meta( $post->ID, '_cedobi_author3_firstname', true ),
			get_post_meta( $post->ID, '_cedobi_author3_lastname', true )
		)
	);
	$authors_list = "";
	foreach ( $author_fields as $f ) {
		if ( $f[0] != '' || $f[1] != '' ) {
			$authors_list .= "<li>";
			if ( $f[0] != '' ) { $authors_list .= $f[0]; }
			if ( $f[1] != '' ) { $authors_list .= " <strong>" .$f[1]. "</strong>"; }
			$authors_list .= "</li>";
		}
	}
	if ( $authors_list != '' ) { $item_author_out = "<ul class='list-inline'>".$authors_list."</ul>"; }
	else { $item_author_out = ""; }

	$item_file =  get_post_meta( $post->ID, '_cedobi_publica_file', true );
	if ( $item_file != '' ) {
		$item_file_url = $item_file;
		$item_file_mime = "PDF";
		$item_file_out = "<div class='list-actions'><a class='btn-list' href='".$item_file_url."'><span class='glyphicon glyphicon-download-alt'></span> ".$item_file_mime."</a></div>";

	} else { $item_file_out = "";}
	$item_out = "
	<tr " .$item_classes. ">
		<td class='list-item-img'>" .$item_img_out. "</td>
		<td class='list-item-year'>" .$item_year_out. "</td>
		<td class='list-item-tit'>" .$item_tit_out.$item_file_out. "</td>
		<td class='list-item-author'>" .$item_author_out. "</td>
		<td class='list-item-desc'>" .$item_desc_out. "</td>
	</tr>
	";

} elseif ( $pt_current == 'noticia' ) { // if noticia post type
	$item_date_out = get_the_date();
	$item_out = "
	<tr " .$item_classes. ">
		<td class='list-item-img'>" .$item_img_out. "</td>
		<td class='list-item-date'>" .$item_date_out. "</td>
		<td class='list-item-tit'>" .$item_tit_out. "</td>
		<td class='list-item-desc'>" .$item_desc_out. "</td>
	</tr>
	";

} elseif ( $pt_current == 'convocatoria' ) { // if convocatoria post type
	$rel_date_ini = get_post_meta( $post->ID, '_cedobi_date_ini', true );
	$rel_date_end = get_post_meta( $post->ID, '_cedobi_date_end', true );
	$rel_date_ini_human = date('d\/m\/Y',$rel_date_ini);
	$rel_date_end_human = date('d\/m\/Y',$rel_date_end);
	if ( $rel_date_ini_human == $rel_date_end_human ) {
		$item_date_out = $rel_date_ini_human;
	} else {
		$item_date_out = $rel_date_ini_human. "&mdash;" .$rel_date_end_human;
	}

	$item_out = "
	<tr " .$item_classes. ">
		<td class='list-item-img'>" .$item_img_out. "</td>
		<td class='list-item-date'>" .$item_date_out. "</td>
		<td class='list-item-tit'>" .$item_tit_out. "</td>
		<td class='list-item-desc'>" .$item_desc_out. "</td>
	</tr>
	";

}

echo $item_out; ?>


