<?php
Class Db {
	protected $connected = FALSE;
	protected $core;

	function __construct()
	{
		if ($this->connected === FALSE)
		{
			$this->connect(config('db_username'), config('db_password'), config('db_database'), config('db_host'));
		}
	}

	public function connect($username, $password, $database, $host = 'localhost')
	{
		$link = mysql_connect($host, $username, $password) OR $this->error();
		mysql_set_charset('utf8', $link);
		mysql_select_db($database) OR $this->error();
		mysql_query("SET NAMES ‘utf8′");

		$this->connected = TRUE;
	}

	public function query($query, $model = FALSE, $only_first_row = FALSE)
	{
		require($model .'.php');
		$data = array();

		//foreach (explode('x50$', base64_decode($query)) AS $r) !!!
		//{
		$result = mysql_query($query) or $this->error();
		while($row = mysql_fetch_object($result))
		{
			if ($model !== FALSE)
			{
				$new_row = new $model;
				foreach ($row AS $a=>$b)
				{
					$new_row->$a = $b;
				}

				$row = $new_row;
			}

			if ($only_first_row === TRUE)
			{
				return $row;
			}

			$data[] = $row;
		}
		//}

		return (count($data) === 0 ? FALSE : $data);
	}

	protected function error($message = FALSE)
	{
		log_message('error', ($message ? $message : mysql_error()));
		die("DB error (see logs for details)");
	}
}