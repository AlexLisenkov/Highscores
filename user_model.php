<?php
Class User_model {
	public $id;
	public $username;
	public $password; // You may want to use this in the future for web login
	public $is_member;

	public $overall_xp;
	public $attack_xp;
	public $strength_xp;
	public $defense_xp;
	public $constitution_xp;
	public $ranged_xp;
	public $prayer_xp;
	public $magic_xp;
	public $cooking_xp;
	public $woodcutting_xp;
	public $fletching_xp;
	public $fishing_xp;
	public $firemaking_xp;
	public $crafting_xp;
	public $smithing_xp;
	public $mining_xp;
	public $herblore_xp;
	public $agility_xp;
	public $thieving_xp;
	public $slayer_xp;
	public $farming_xp;
	public $runecrafting_xp;
	public $hunter_xp;
	public $construction_xp;
	public $summoning_xp;
	public $dungeoneering_xp;

	/**
	 * Get the current level of a skill
	 *
	 * @param str $skill_name Skills name
	 * @return int
	 */
	public function level($skill_name)
	{
		$skill_name = strtolower($skill_name);
		$skill = $skill_name . '_xp';

		// Is the skill set?
		if (isset($this->$skill) === FALSE || $skill_name === 'overall') return FALSE;

		$xp = $this->$skill;
		$max = ($skill_name === 'dungeoneering' ? 120 : 99);

		// Find the appropriate level
		for ($lvl = 1; $lvl < $max; $lvl++)
		{
			if ($xp < $this->experience($lvl))
			{
				// Level found
				$lvl -= 1;
				break;
			}
		}

		return $lvl;
	}

	/**
	 * Find experience required for a specific level.
	 *
	 * @param int $lvl
	 * @return int
	 */
	public function experience($lvl)
	{
		$xp = 0;
		for($x = 1; $x < $lvl; $x++)
		{
			$xp += floor($x + 300 * pow(2, ($x / 7)));
		}
		return floor($xp / 4);
	}

	/**
	 * Return the formated xp number.
	 *
	 * @param str $name Skills name
	 * @return str
	 */
	public function xp($name)
	{
		$name = strtolower($name);
		$skill = $name . '_xp';

		// Is the skill set?
		if (isset($this->$skill) === FALSE) return FALSE;

		return number_format($this->$skill);
	}

	public function rank($name)
	{
		return '#';
	}
}