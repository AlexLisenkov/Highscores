<?php
Class Installation {
	/*
		1. Kontaktejas ar serveri un pazino, par instalaciju
		2. Lietotajam izveleeites DB, username, password
		3.
	**/

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
		echo '<form method="post" action="' . base_url('install.php?step=2') . '">';
		echo '<label>Database host: <input type="text" name="db_host" value="localhost" /></label>';
		echo '<label>Database username: <input type="text" name="db_username" value="root" /></label>';
		echo '<label>Database password: <input type="text" name="db_password" value="" /></label>';
		echo '<label>Database name: <input type="text" name="db_database" value="" /></label>';
		echo '<label>User table name (table will be created): <input type="text" name="db_table" value="hs_users" /></label>';
		echo '<hr>';
		echo '<label>Site name: <input type="text" name="site_name" value="Highscores" /></label>';
		echo '<label>Site description: <input type="text" name="site_description" value="" /></label>';
		echo '<label>Site homepage: <input type="text" name="site_homepage" value="' . $_SERVER['HTTP_HOST'] . '" /></label>';
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
		  `overall_xp` bigint(20) NOT NULL,
		  `attack_xp` int(11) NOT NULL,
		  `defence_xp` int(11) NOT NULL,
		  `strength_xp` int(11) NOT NULL,
		  `constitution_xp` int(11) NOT NULL,
		  `ranged_xp` int(11) NOT NULL,
		  `prayer_xp` int(11) NOT NULL,
		  `magic_xp` int(11) NOT NULL,
		  `cooking_xp` int(11) NOT NULL,
		  `woodcutting_xp` int(11) NOT NULL,
		  `fletching_xp` int(11) NOT NULL,
		  `fishing_xp` int(11) NOT NULL,
		  `firemaking_xp` int(11) NOT NULL,
		  `crafting_xp` int(11) NOT NULL,
		  `smithing_xp` int(11) NOT NULL,
		  `mining_xp` int(11) NOT NULL,
		  `herblore_xp` int(11) NOT NULL,
		  `agility_xp` int(11) NOT NULL,
		  `thieving_xp` int(11) NOT NULL,
		  `slayer_xp` int(11) NOT NULL,
		  `farming_xp` int(11) NOT NULL,
		  `runecrafting_xp` int(11) NOT NULL,
		  `hunter_xp` int(11) NOT NULL,
		  `construction_xp` int(11) NOT NULL,
		  `summoning_xp` int(11) NOT NULL,
		  `dungeoneering_xp` int(11) NOT NULL,
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
		fclose($fh);

		// Tell the global server that we intalled this
		// This is purely for the statistics
		file_get_contents('http://www.mja.lv/index.php/highscores?site=' . urlencode($_POST['site_homepage']));

		echo 'Installation successfull';
	}
}

new Installation;