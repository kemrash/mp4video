<?php

namespace kemrash\mp4video\migrations;

class v_0_0_4 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['mp4video_version']) && version_compare($this->config['mp4video_version'], '0.0.4', '>=');
	}
	
	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mp4video_version', '0.0.4')),
			array('custom', array(array($this, 'install_bbcode_mp3'))),
			array('custom', array(array($this, 'install_bbcode_mp4video'))),
		);
	}

	public function install_bbcode_mp3()
	{
		// Load the acp_bbcode class
		if (!class_exists('acp_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
		}
		$bbcode_tool = new \acp_bbcodes();

		$bbcode_name = 'post';
		$bbcode_array = array(
			'bbcode_helpline'	=> '{L_MP3_HELPLINE}',
			'bbcode_match'		=> '[mp3]{URL}[/mp3]',
			'bbcode_tpl'		=> '<audio id="player" controls><source src="{URL}" type="audio/mp3" /></audio>',
			'display_on_posting'=> 1,
		);

		// Build the BBCodes
		$data = $bbcode_tool->build_regexp($bbcode_array['bbcode_match'], $bbcode_array['bbcode_tpl']);

		$bbcode_array += array(
			'bbcode_tag'			=> $data['bbcode_tag'],
			'first_pass_match'		=> $data['first_pass_match'],
			'first_pass_replace'	=> $data['first_pass_replace'],
			'second_pass_match'		=> $data['second_pass_match'],
			'second_pass_replace'	=> $data['second_pass_replace']
		);

		$sql = 'SELECT bbcode_id
			FROM ' . $this->table_prefix . "bbcodes
			WHERE LOWER(bbcode_tag) = '" . strtolower($bbcode_name) . "'
			OR LOWER(bbcode_tag) = '" . strtolower($bbcode_array['bbcode_tag']) . "'";
		$result = $this->db->sql_query($sql);
		$row_exists = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row_exists)
		{
			// Update exisiting BBCode
			$bbcode_id = $row_exists['bbcode_id'];

			$sql = 'UPDATE ' . $this->table_prefix . 'bbcodes
				SET ' . $this->db->sql_build_array('UPDATE', $bbcode_array) . '
				WHERE bbcode_id = ' . $bbcode_id;
			$this->db->sql_query($sql);
		}
		else
		{
			// Create new BBCode
			$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id
				FROM ' . $this->table_prefix . 'bbcodes';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				$bbcode_id = $row['max_bbcode_id'] + 1;

				// Make sure it is greater than the core BBCode ids...
				if ($bbcode_id <= NUM_CORE_BBCODES)
				{
					$bbcode_id = NUM_CORE_BBCODES + 1;
				}
			}
			else
			{
				$bbcode_id = NUM_CORE_BBCODES + 1;
			}

			if ($bbcode_id <= BBCODE_LIMIT)
			{
				$bbcode_array['bbcode_id'] = (int) $bbcode_id;
				$bbcode_array['display_on_posting'] = 1;

				$this->db->sql_query('INSERT INTO ' . $this->table_prefix . 'bbcodes ' . $this->db->sql_build_array('INSERT', $bbcode_array));
			}
		}
	}
	
	public function install_bbcode_mp4video()
	{
		// Load the acp_bbcode class
		if (!class_exists('acp_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
		}
		$bbcode_tool = new \acp_bbcodes();

		$bbcode_name = 'post';
		$bbcode_array = array(
			'bbcode_helpline'	=> '{L_MP4_HELPLINE}',
			'bbcode_match'		=> '[mp4video={URL2;optional}]{URL1}[/mp4video]',
			'bbcode_tpl'		=> '<div style="max-width: 640px;"><video poster="{URL2}" id="player" playsinline controls style="max-width: 100%; height: auto;"><source src="{URL1}" type="video/mp4" /><source src="{URL1}" type="video/webm" /></video></div>',
			'display_on_posting'=> 1,
		);

		// Build the BBCodes
		$data = $bbcode_tool->build_regexp($bbcode_array['bbcode_match'], $bbcode_array['bbcode_tpl']);

		$bbcode_array += array(
			'bbcode_tag'			=> $data['bbcode_tag'],
			'first_pass_match'		=> $data['first_pass_match'],
			'first_pass_replace'	=> $data['first_pass_replace'],
			'second_pass_match'		=> $data['second_pass_match'],
			'second_pass_replace'	=> $data['second_pass_replace']
		);

		$sql = 'SELECT bbcode_id
			FROM ' . $this->table_prefix . "bbcodes
			WHERE LOWER(bbcode_tag) = '" . strtolower($bbcode_name) . "'
			OR LOWER(bbcode_tag) = '" . strtolower($bbcode_array['bbcode_tag']) . "'";
		$result = $this->db->sql_query($sql);
		$row_exists = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row_exists)
		{
			// Update exisiting BBCode
			$bbcode_id = $row_exists['bbcode_id'];

			$sql = 'UPDATE ' . $this->table_prefix . 'bbcodes
				SET ' . $this->db->sql_build_array('UPDATE', $bbcode_array) . '
				WHERE bbcode_id = ' . $bbcode_id;
			$this->db->sql_query($sql);
		}
		else
		{
			// Create new BBCode
			$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id
				FROM ' . $this->table_prefix . 'bbcodes';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				$bbcode_id = $row['max_bbcode_id'] + 1;

				// Make sure it is greater than the core BBCode ids...
				if ($bbcode_id <= NUM_CORE_BBCODES)
				{
					$bbcode_id = NUM_CORE_BBCODES + 1;
				}
			}
			else
			{
				$bbcode_id = NUM_CORE_BBCODES + 1;
			}

			if ($bbcode_id <= BBCODE_LIMIT)
			{
				$bbcode_array['bbcode_id'] = (int) $bbcode_id;
				$bbcode_array['display_on_posting'] = 1;

				$this->db->sql_query('INSERT INTO ' . $this->table_prefix . 'bbcodes ' . $this->db->sql_build_array('INSERT', $bbcode_array));
			}
		}
	}
}