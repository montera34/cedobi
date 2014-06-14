<?php
// post vars
$item_pt =  get_post_type();
$item_name = get_the_title();
$item_perma = get_permalink();
$item_desc = get_the_excerpt();

$item_classes = "class='mosac-item col-md-6 col-sm-6'";
$item_img_size = "small";

if ( has_post_thumbnail() ) { // image
	$item_out = "
		<div class='inside'>
			<a href='" .$item_perma. "'>
				<img class='mosac-item-type' src='" .CEDOBI_BLOGTHEME. "/images/cedobi-pt-" .$item_pt. ".png' alt='Icono " .$item_pt. "' /> 
				" .get_the_post_thumbnail( $post->ID, $item_img_size, array('class' => 'img-responsive') ). "
				<span class='mosac-item-text'><strong>" .$item_name. "</strong></span>	
			</a>
		</div>
	";
?>
<article <?php echo $item_classes ?>>
	<?php echo $item_out ?>
</article>
<?php } // end image
?>
