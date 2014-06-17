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
	$item_img_out = "<div class='hideout'>Sin imagen</div>";
} // end image

if ( $pt_current == 'archivo' || $pt_current == 'brigadista' || $pt_current == 'fotografia' || $pt_current == 'documento' || array_key_exists('s', $_GET) ) {
	$item_type_out = "<td class='list-item-type list-item-type-" .$item_type_class. "'><div>" .$wp_post_types[$item_pt]->labels->name. "</div></td>";
} else { $item_type_out = ""; }

$item_tit_out = "<a href='" .$item_perma. "' title='$item_name'>" .$item_name. "</a>";
$item_desc_out = $item_desc;
?>

<tr <?php echo $item_classes ?>>
	<td class="list-item-img"><?php echo $item_img_out ?></td>
	<td class="list-item-tit"><?php echo $item_tit_out ?></td>
	<?php echo $item_type_out ?>
	<td class="list-item-desc"><?php echo $item_desc_out ?></td>
</tr>
