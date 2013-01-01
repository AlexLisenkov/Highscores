<?php
Class Template {
	
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