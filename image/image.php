<?php
/**
 * Generate GD image for the MatissJA/Highscores project (GD image library required)
 * Feel free to edit this file
 *
 * PHP version 5
 *
 *
 * @author     Alex Lisenkov <contact@alexej.nl>
 * @copyright  2014 Alex Lisenkov
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.01
 * @git        https://github.com/MatissJA/Highscores
 */

 
/**
 * CONFIG
 * Edit some settings here
 */
$config = array();

/**
 * RANK
 * Show overall rank in front of username (bool)
 */
$config['rank'] = false;
 
/**
 * SIZE
 * Define width and height of the image
 */
$config['size'] = array(
	'width'		=> 400,
	'height'	=> 210
);

/**
 * BACKGROUND
 * Define the background color as RGB (if you want hex put 0x in front of it, e.g. 0x3b) or just 0-255
 */
$config['background'] = array(
	'red'	=>	0xFF,
	'green'	=>	0xF8,
	'blue'	=>	0xDC
);

/**
 * FONT
 * Define font file (located in 'image/font/' dir from highscore root, must be ttf)
 * Define font colors as RGB (if you want hex put 0x in front of it, e.g. 0x3b) or just 0-255
 */
	// Font file & colors
$config['font'] = array(

		'font' => 'berkshire-swash-400-normal.ttf',
		
		// Color for username and lvls > 1 and < 99
		'main_color' => array(
			'red'	=>	0x3D,
			'green'	=>	0x32,
			'blue'	=>	0x73
		),
		
		// Color for lvl 1
		'level1_color' => array(
			'red'	=>	0x9F,
			'green'	=>	0x9B,
			'blue'	=>	0xB0
		),
		
		// Color for lvl 99
		'level99_color' => array(
			'red'	=>	0xA6,
			'green'	=>	0x93,
			'blue'	=>	0x48
		),
);

 
 
 
 // -------------------------------------------- END OF CONFIG START OF SCRIPT -------------------------------------------- \\
 
header("Content-Type: image/png");

// Path to font
$font = 'image/font/'. $config['font']['font'];

// Create base image
$im = @imagecreate($config['size']['width'], $config['size']['height'])
	or die("Cannot Initialize new GD image stream");

// Set main background color
$background_color = imagecolorallocate(
						$im, 
						$config['background']['red'], 
						$config['background']['green'], 
						$config['background']['blue']
					);
// Set main text color
$text_color = imagecolorallocate($im, $config['font']['main_color']['red'], $config['font']['main_color']['green'], $config['font']['main_color']['blue']);
$color_99 = imagecolorallocate($im, $config['font']['level99_color']['red'], $config['font']['level99_color']['green'], $config['font']['level99_color']['blue']);
$color_1 = imagecolorallocate($im, $config['font']['level1_color']['red'], $config['font']['level1_color']['green'], $config['font']['level1_color']['blue']);
$color_98 = imagecolorallocate($im, $config['font']['main_color']['red'], $config['font']['main_color']['green'], $config['font']['main_color']['blue']);

// Set username
if( $config['rank'] )	{	ImageTTFText ($im, 20, 0, 20, 35, $text_color, $font, $data->rank('overall') . '. ' . $data->username);	}
				else	{	ImageTTFText ($im, 20, 0, 20, 35, $text_color, $font, $data->username);	}


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