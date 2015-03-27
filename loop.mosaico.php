<?php
global $ref;
if ( $ref == 'mosaico' ) { $item_cols = "4"; } else { $item_cols = "6"; }
// post vars
$item_pt =  get_post_type();
$item_name = get_the_title();
$item_perma = get_permalink();

if ( has_post_thumbnail() ) { // image
	$item_classes = "class='mosac-item mosac-hover col-sm-".$item_cols." col-xs-8'";
	$item_img_size = "small";
	$item_out = "
		<div class='inside'>
			<a href='" .$item_perma. "'>
				<img class='mosac-item-type' src='" .CEDOBI_BLOGTHEME. "/images/cedobi-pt-" .$item_pt. ".png' alt='" .__('Icon','cedobi') . $item_pt. "' /> 
				" .get_the_post_thumbnail( $post->ID, $item_img_size, array('class' => 'img-responsive') ). "
				<span class='mosac-item-text'><strong class='mosac-item-tit'>" .$item_name. "</strong></span>	
			</a>
		</div>
	";
} else {
	$item_desc = get_the_excerpt();
	$item_classes = "class='mosac-item mosac-simple col-sm-".$item_cols." col-xs-8'";
	$item_out = "
		<div class='inside'>
			<a href='" .$item_perma. "'>
				<span class='mosac-item-text'><strong class='mosac-item-tit'>" .$item_name. "</strong>. " .$item_desc. "</span>	
				<img class='mosac-item-type' src='" .CEDOBI_BLOGTHEME. "/images/cedobi-pt-" .$item_pt. ".png' alt='" .__('Icon','cedobi') . $item_pt. "' /> 
			</a>
		</div>
	";
} ?>
<article <?php echo $item_classes ?>>
	<?php echo $item_out ?>
</article>
