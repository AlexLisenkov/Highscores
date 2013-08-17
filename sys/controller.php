<?php
require('template.php');
Class Controller extends Template {
	protected $core;
	protected $db;

	protected $per_page = 20;
	protected $model_name = 'user_model';

	/**
	 * Constructor
	 */
	function __construct(& $core)
	{
		$this->core = $core;
		$this->db =& $this->core->db;
	}

	/**
	 * Index - rank method
	 *
	 * @access public
	 * @param str $skill Skill name
	 */
	public function index($skill = 'overall', $page = 1)
	{
		// Set pagination`s page
		$page = ((int) $page) - 1;
		$page = ($page < 0 ? 0 : $page);

		if ($skill === 'overall')
			$data = $this->overall_hs($page);
		else
			$data = $this->db->query('SELECT * FROM `' . config('db_table') . '` ORDER BY `'. $this->skill_name($skill) .'_xp` DESC LIMIT ' . ($page * $this->per_page) . ', ' . $this->per_page, $this->model_name);

		$total = mysql_num_rows($this->db->simple_query('SELECT * FROM `' . config('db_table') . '`'));

		$this->load('index', array(
			'data' => $data,
			'plus' => $page * $this->per_page,
			'skill' => $this->skill_name($skill),
			'items_per_page' => $this->per_page,
			'total_items' => $total,
			));
	}

	/**
	 * User stats method
	 *
	 * @access public
	 * @param str $username Users name
	 */
	public function user($username = '')
	{
		$username = urldecode($username);

		$data = $this->db->query('SELECT * FROM `' . config('db_table') . '` WHERE `username`="' . $username .'" LIMIT 1', $this->model_name, TRUE);

		$this->load('user', array(
			'data' => $data,
			'user' => preg_replace('/[^a-z_\-0-9\/\s]/i', '', $username)
			));
	}

	/**
	 * View users hiscores.
	 * Redirect to the proper page
	 */
	public function view()
	{
		$page = (isset($_POST['username']) ? 'user/' . urlencode($_POST['username']) : '');
		$page = preg_replace('/[^a-z_\-0-9\/\s+]/i', '', $page);
		header('Location: ' . base_url($page));
	}

	/**
	 * Goto a certain page
	 * @return void
	 */
	public function gotopage()
	{
		$num = (int) (isset($_POST['pagetogo']) ? $_POST['pagetogo'] : 0);
		$skill = (isset($_POST['current_skill']) ? $_POST['current_skill'] : NULL);

		if ($num <= 0)
			$num = 1;

		$page = 'index/' . $this->skill_name($skill) . '/' . $num;

		header('Location: ' . base_url($page));
	}

	/**
	 * Validate skills name and return the
	 * proper DB row name.
	 *
	 * @access protected
	 * @param str $name
	 * @return str
	 */
	protected function skill_name($name)
	{
		// Validation
		if (in_array($name, valid_skills()))
		{
			return $name;
		}

		// Default
		return 'overall';
	}

	/**
	 * Get overall highscores
	 * @param  int $page
	 * @return object
	 */
	protected function overall_hs($page)
	{
		$all = $this->db->query('SELECT * FROM `' . config('db_table') . '`', $this->model_name);

		$data = array();
		$return = array();
		$i = 0;

		// Set total level as the key
		foreach ($all AS $row)
			$data[ $row->level('overall') . '.' . $row->id ] = $row;

		krsort($data);
		$data = array_values($data);

		// Calc max index
		$max = ($page * $this->per_page) + $this->per_page;
		$max = ($max >= count($data) ? count($data) : $max);

		for ($i = $page * $this->per_page; $i < $max; $i++)
			$return[] = $data[$i];

		return $return;
	}
}