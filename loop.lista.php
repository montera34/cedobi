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
		'_cedobi_author1_firstname',
		'_cedobi_author1_lastname',
		'_cedobi_author2_firstname',
		'_cedobi_author2_lastname',
		'_cedobi_author3_firstname',
		'_cedobi_author3_lastname'
	);
	$cf_count = 0;
	$item_author_out = "";
	foreach ( $author_fields as $field ) {
		$check_field = 0;
		$cf_count++;
		$term[$cf_count] = get_post_meta( $post->ID, $field, true );
		if ( count($term) == 2 ) {
			if ( $term[1] != '' || $term[2] != '' ) {
				$item_author_out .= $term[1]. " " .$term[2]. ", ";
				$check_field = 1;
			}
			$cf_count = 0;
			$term = "";
		}
		if ( $check_field == 0 ) { $item_author_out .= ""; }
	}
	$item_author_out = substr($item_author_out,0,-2);
	$item_out = "
	<tr " .$item_classes. ">
		<td class='list-item-img'>" .$item_img_out. "</td>
		<td class='list-item-year'>" .$item_year_out. "</td>
		<td class='list-item-tit'>" .$item_tit_out. "</td>
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


