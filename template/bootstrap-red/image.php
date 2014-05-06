<?php
header("Content-Type: image/png");

// Path to font
$font = 'image/font/berkshire-swash-400-normal.ttf';

// Create base image
$im = @imagecreate(400, 210)
    or die("Cannot Initialize new GD image stream");

// Set main background color
$background_color = imagecolorallocate($im, 0xFF, 0xF8, 0xDC);
// Set main text color
$text_color = imagecolorallocate($im, 0x54, 0x31, 0x6F);
$color_99 = imagecolorallocate($im, 0xA6, 0x93, 0x48);
$color_1 = imagecolorallocate($im, 0x9F, 0x9B, 0xB0); //9F 9B B0
$color_50 = imagecolorallocate($im, 0x7A, 0x78, 0x84); //7A 78 84
$color_98 = imagecolorallocate($im, 0x3D, 0x32, 0x73); //3D 32 73

// Set username
ImageTTFText ($im, 20, 0, 20, 35, $color_98, $font, $data->rank('overall') . '. ' . $data->username);

// Start setting stats
$top = 60;
$left = 50;
$i = 0;
foreach (valid_skills() AS $row){
	$i++;
	if( $data->level($row) == 1 ){
		$color = $color_1;
	}
	if( $data->level($row) >= 2 ){
		$color = $color_98;
	}
	if( $data->level($row) == 99 ){
		$color = $color_99;
	}
	ImageTTFText ($im, ( $data->level($row) == 99 ) ? 16 : 15, 0, $left, $top, $color , $font, $data->level($row));
	$path = 'image/img/'. $row .'.gif';
	$img = imagecreatefromgif($path);
	imagecopyresampled($im, $img, $left-30, $top-16, 0, 0, 25, 25, 25, 25);
	$top += 27;
	if( $i == 6 ){
		$i = 0;
		$top = 60;
		$left += 75;
	}
}



// Output image
imagepng($im);
imagedestroy($im);

// End
exit;