<?php
Class Template {

	/**
	 * Build a single file
	 */
	public function build($filename, $params = array())
	{
		$file = 'template/'. config('site.active_template') .'/' . $filename . '.php';

		if (file_exists($file))
		{
			$template = new Template;
			extract($params);
			require($file);
		}
	}

	/**
	 * Load the full view
	 */
	public function load($filename, $params = array())
	{
		$template = new Template;
		extract($params);

		ob_start();
		$this->build($filename, $params);
		$view = ob_get_contents();
		ob_end_clean();


		require('template/'. config('site.active_template') .'/main.php');
	}
}