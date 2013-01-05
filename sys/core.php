<?php
Class Core {
	public $db;
	protected $controller;

	function __construct()
	{
		if (file_exists('config.php') === FALSE)
		{
			die('Please install the system. Go to the `install.php` file in your browser');
		}

		// Load function file
		require('sys/functions.php');

		// Load config file
		require('config.php');
		set_config($config);

		// Load DB class
		require('sys/db.php');
		$this->db = new Db;

		// Load the controller
		require('sys/controller.php');
		$this->controller = new Controller($this);

		$this->run();
	}

	/**
	 * Run the system
	 */
	protected function run()
	{
		$this->set_path();

		$method = (isset($this->path[0]) && method_exists($this->controller, $this->path[0]) ? $this->path[0] : 'index');

		$params = $this->path;
		array_shift($params);

		call_user_func_array(array($this->controller, $method), $params);
	}

	/**
	 * Set the path variable.
	 * Get rid of those nasty SQL injections and other attacks
	 */
	protected function set_path()
	{
		if (isset($_GET['path']) === FALSE)
		{
			$_GET['path'] = '';
		}

		$_GET['path'] = preg_replace('/[^a-z_\-0-9\/\s]/i', '', $_GET['path']);
		$this->path = explode('/', $_GET['path']);
		set_path($this->path);
	}
}