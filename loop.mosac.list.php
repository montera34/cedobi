<?php
// post vars
$item_pt =  get_post_type();
$item_name = get_the_title();
$item_perma = get_permalink();
$item_desc = get_the_excerpt();

// if list
if ( $view == 'list' ) {
	$item_classes = "list-item row";
	$item_img_size = "small";

	if ( has_post_thumbnail() ) { // image
		$item_img_out = "<div class='item-img col-md-6'><a href='" .$item_perma. "' title='" .$item_name. "' rel='bookmark'>" .get_the_post_thumbnail($post->ID,$item_img_size,array('class' => 'img-responsive')). "</a></div>";
		$item_text_out = "<div class='item-text col-md-18'><h2 class='item-tit'>" .$item_name. "</h2><div class='item-desc'>" .$item_desc. "</div></div>";
	} else {
		$item_img_out = "";
		$item_text_out = "<div class='item-text col-md-24'><h2 class='item-tit'>" .$item_name. "</h2><div class='item-desc'>" .$item_desc. "</div></div>";
	} // end image

	$item_fondo_out = "";


// if mosac
} else {
	$item_classes = "mosac-item col-md-3";
	$item_img_size = "thumbnail";

	$item_text_out = "<div class='item-text mosac-popup'><h2 class='item-tit'>" .$item_name. "</h2><div class='item-desc'>" .$item_desc. "</div></div>";
	$item_fondo_out = "<div class='item-fondo'><a href='" .$item_perma. "' title='" .$item_name. "' rel='bookmark'><img src='" .CEDOBI_BLOGTHEME. "/images/icon-" .$item_pt. ".png' alt='Icono " .$item_pt. "' /></a></div>";

	if ( has_post_thumbnail() ) { // image
		$item_img_out = "<div class='item-img'><a href='" .$item_perma. "' title='" .$item_name. "' rel='bookmark'>" .get_the_post_thumbnail($post->ID,$item_img_size,array('class' => 'img-responsive')). "</a></div>";
	} else {
		$item_img_out = "";
	} // end image

} // end if list or mosac
?>

<article class="<?php echo $item_classes ?>">
	<?php echo $item_img_out ?>
	<?php echo $item_fondo_out ?>
	<?php echo $item_text_out ?>
</article>
