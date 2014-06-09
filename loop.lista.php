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
$item_img_size = "bigicon";

if ( has_post_thumbnail() ) { // image
	$item_img_out = get_the_post_thumbnail( $post->ID,$item_img_size );
} else {
	$item_img_out = "<img src='" .CEDOBI_BLOGTHEME. "/images/cedobi-pt-" .$item_pt. ".png' alt='Icono " .$item_pt. "' />";
} // end image

$item_tit_out = "<a href='" .$item_perma. "' title='$item_name'>" .$item_name. "</a>";
$item_type_out = "<div>" .$wp_post_types[$item_pt]->labels->name. "</div>";
//$item_type_out = "<img src='" .CEDOBI_BLOGTHEME. "/images/cedobi-pt-" .$item_pt. ".png' alt='Icono " .$item_pt. "' />";
$item_desc_out = $item_desc;
?>

<tr <?php echo $item_classes ?>>
	<td class="list-item-img"><?php echo $item_img_out ?></td>
	<td class="list-item-tit"><?php echo $item_tit_out ?></td>
	<td class="list-item-type list-item-type-<?php echo $item_type_class ?>"><?php echo $item_type_out ?></td>
	<td class="list-item-desc"><?php echo $item_desc_out ?></td>
</tr>
