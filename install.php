<?php
Class Installation {

	protected $version = 1.2;

	function __construct()
	{
		if (file_exists('config.php'))
		{
			die('Installation already complete..');
		}

		require('sys/functions.php');
		if (isset($_GET['step']) === FALSE) $_GET['step'] = 1;

		switch ($_GET['step'])
		{
			default:
			case 1:
				$this->step_one();
				break;

			case 2:
				$this->step_two();
				break;
		}
	}

	/**
	 * Form input fields
	 */
	function step_one()
	{
		echo '<style type="text/css">label {display:block}</style>';
		echo '<form method="post" action="' . base_url() . 'install.php?step=2">';
		echo '<label>Database host: <input type="text" name="db_host" value="localhost" /></label>';
		echo '<label>Database username: <input type="text" name="db_username" value="root" /></label>';
		echo '<label>Database password: <input type="text" name="db_password" value="" /></label>';
		echo '<label>Database name: <input type="text" name="db_database" value="" /></label>';
		echo '<label>User table name (table will be created): <input type="text" name="db_table" value="hs_users" /></label>';
		echo '<hr>';
		echo '<label>Site name: <input type="text" name="site_name" value="Highscores" /></label>';
		echo '<label>Site description: <input type="text" name="site_description" value="" /></label>';
		echo '<label>Site homepage: <input type="text" name="site_homepage" value="'. $this->full_url() .'" /></label>';
		echo '<label>use .htaccess (mod rewrite): <select name="use_htaccess"><option value="0">No</option><option value="1">Yes</option></select></label>';
		echo '<input type="submit" value="               Go!               " />';
		echo '</form>';
	}

	/**
	 * Save stuff...
	 */
	function step_two()
	{
		require('sys/db.php');
		$db = new Db(FALSE);

		// Connect
		$db->connect($_POST['db_username'], $_POST['db_password'], $_POST['db_database'], $_POST['db_host']);

		// Create table
		$db->simple_query("
		CREATE TABLE IF NOT EXISTS `hs_users` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `password` varchar(80) COLLATE utf8_bin NOT NULL,
		  `is_member` int(1) NOT NULL DEFAULT '0' COMMENT '1 = member, 0 = regular user',
		  `overall_xp` bigint(20) NOT NULL DEFAULT '0',
		  `attack_xp` int(11) NOT NULL DEFAULT '0',
		  `defence_xp` int(11) NOT NULL DEFAULT '0',
		  `strength_xp` int(11) NOT NULL DEFAULT '0',
		  `constitution_xp` int(11) NOT NULL DEFAULT '0',
		  `ranged_xp` int(11) NOT NULL DEFAULT '0',
		  `prayer_xp` int(11) NOT NULL DEFAULT '0',
		  `magic_xp` int(11) NOT NULL DEFAULT '0',
		  `cooking_xp` int(11) NOT NULL DEFAULT '0',
		  `woodcutting_xp` int(11) NOT NULL DEFAULT '0',
		  `fletching_xp` int(11) NOT NULL DEFAULT '0',
		  `fishing_xp` int(11) NOT NULL DEFAULT '0',
		  `firemaking_xp` int(11) NOT NULL DEFAULT '0',
		  `crafting_xp` int(11) NOT NULL DEFAULT '0',
		  `smithing_xp` int(11) NOT NULL DEFAULT '0',
		  `mining_xp` int(11) NOT NULL DEFAULT '0',
		  `herblore_xp` int(11) NOT NULL DEFAULT '0',
		  `agility_xp` int(11) NOT NULL DEFAULT '0',
		  `thieving_xp` int(11) NOT NULL DEFAULT '0',
		  `slayer_xp` int(11) NOT NULL DEFAULT '0',
		  `farming_xp` int(11) NOT NULL DEFAULT '0',
		  `runecrafting_xp` int(11) NOT NULL DEFAULT '0',
		  `hunter_xp` int(11) NOT NULL DEFAULT '0',
		  `construction_xp` int(11) NOT NULL DEFAULT '0',
		  `summoning_xp` int(11) NOT NULL DEFAULT '0',
		  `dungeoneering_xp` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
			");

		// Create config file
		$fh = fopen('config.php', 'w') or die("Couldn't create config file");
		fwrite($fh, "<?php\n");
		fwrite($fh, "\$config = array();\n");
		fwrite($fh, "\$config['db_host'] = '" . $_POST['db_host'] . "';\n");
		fwrite($fh, "\$config['db_username'] = '" . $_POST['db_username'] . "';\n");
		fwrite($fh, "\$config['db_password'] = '" . $_POST['db_password'] . "';\n");
		fwrite($fh, "\$config['db_database'] = '" . $_POST['db_database'] . "';\n");
		fwrite($fh, "\$config['db_table'] = '" . $_POST['db_table'] . "';\n");
		fwrite($fh, "\$config['site.title'] = '" . $_POST['site_name'] . "';\n");
		fwrite($fh, "\$config['site.description'] = '" . $_POST['site_description'] . "';\n");
		fwrite($fh, "\$config['site.homepage'] = '" . $_POST['site_homepage'] . "';\n");
		fwrite($fh, "\$config['site.active_template'] = 'bootstrap';\n");
		fwrite($fh, "\$config['use_htaccess'] = " . ($_POST['use_htaccess'] == '1' ? 'TRUE' : 'FALSE') . ";\n");
		fclose($fh);

		// Create .htaccess file
		if ($_POST['use_htaccess'] == '1' && file_exists('.htaccess') === FALSE)
		{
			$fh = fopen('.htaccess', 'w') or die("Couldn't create .htaccess file");
			fwrite($fh, "Options +FollowSymLinks -Indexes\n");
			fwrite($fh, "RewriteEngine on\n");
			fwrite($fh, "RewriteBase " . path_directory() . "/\n");
			fwrite($fh, "RewriteCond %{REQUEST_FILENAME} !-f\n");
			fwrite($fh, "RewriteCond %{REQUEST_FILENAME} !-d\n");
			fwrite($fh, "RewriteRule ^(.*)$ index.php?path=$1 [L]\n");
			fclose($fh);
		}

		// Tell the global server that we intalled this
		// This is purely for the statistics
		file_get_contents('http://www.mja.lv/index.php/highscores?site=' . base64_encode($_POST['site_homepage']) . '&installation=' . base64_encode($this->full_url()) . '&version=' . urlencode($this->version));

		echo 'Installation successfull';
	}

	function full_url()
	{
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
		$protocol = substr($sp, 0, strpos($sp, "/")) . $s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
}

new Installation;