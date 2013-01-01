<?php
// Error logging
function log_message($type, $message)
{
	$fh = fopen("logs/". date('Y-m-d') .".txt", 'a');
	fwrite($fh, $message . "\n");
	fclose($fh);
}

// Config things...
function set_config($p)
{
	global $config;
	$config = $p;
}
function config($var)
{
	global $config;

	if (isset($config[$var]))
	{
		return $config[$var];
	}

	return FALSE;
}

// Path stuff..
function set_path($p)
{
	global $path;
	$path = $p;
}
function path($i)
{
	global $path;

	if (isset($path[$i]))
	{
		return $path[$i];
	}

	return '';
}

// Sites base URL
function base_url($url = FALSE)
{
	$dir = explode('/', $_SERVER['PHP_SELF']);
	unset($dir[count($dir)-1]);
	$directory = implode('/', $dir);
	return 'http://'. $_SERVER['HTTP_HOST'] . $directory .'/' . $url;
}

// Anchor building
function anchor($url, $name, $attrs = FALSE)
{
	$full_url = (filter_var($url, FILTER_VALIDATE_URL) === FALSE ? base_url() : '') . $url;
	return '<a href="'. $full_url .'"' . ($attrs ? ' ' . $attrs : '') . '>' . $name . '</a>';
}

// (ordered) Valid skill list
function valid_skills() {
	return array(
			'overall', 'attack', 'defence', 'strength', 'constitution', 'ranged', 'prayer',  'magic',
			'cooking', 'woodcutting', 'fletching', 'fishing', 'firemaking', 'crafting', 'smithing', 'mining',
			'herblore', 'agility', 'thieving', 'slayer', 'farming', 'runecrafting', 'hunter', 'construction', 
			'summoning', 'dungeoneering'
		);
}