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

		$data = $this->db->query('SELECT * FROM `' . config('db_table') . '` ORDER BY `'. $this->skill_name($skill) .'_xp` DESC LIMIT ' . ($page * $this->per_page) . ', ' . $this->per_page, $this->model_name);

		$this->load('index', array(
			'data' => $data,
			'plus' => $page * $this->per_page,
			'skill' => $this->skill_name($skill)
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
}