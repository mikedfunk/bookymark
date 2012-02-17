<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * authentication_model
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		authentication_model.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * authentication_model class.
 * 
 * @extends CI_Model
 */
class authentication_model extends CI_Model
{	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('authentication_config');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * password_check function.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public function password_check($username, $password)
	{	
		// check for blanks
		if ($username == '' || $password == '') { return false; }
		
		// check for existing email
		$q = $this->get_user_by_username($username);
		
		if ($q->num_rows() == 0)
		{
			return false;
		}
		// if it exists, *then* check for matching password
		else
		{
			// set up values
			$r = $q->row();
			$salt = substr($r->password, 0, config_item('salt_length'));
			$this->load->helper('encrypt_helper');
			$password = encrypt_this($password, $salt);
			// $username = $password = 'test';
			
			// check password and return match
			$this->db->where('password', $password);
			$q = $this->db->get(config_item('users_table'));
			if ($q->num_rows() == 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * username_check function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return void
	 */
	public function username_check($username)
	{
		$q = $this->get_user_by_username($username);
		if ($q->num_rows() == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $join (default: true)
	 * @return void
	 */
	public function get_user_by_username($username, $join = true)
	{
		$ut = config_item('users_table');
		$rt = config_item('roles_table');
		
		// join in roles
		if ($join)
		{
			$this->db->select(
				$ut . '.' . config_item('username_field') . ',' .
				$ut . '.' . config_item('password_field') . ',' .
				$rt . '.*,'
			);
			$this->db->join($rt, $rt . '.id = ' . $ut . '.' . config_item('role_id_field'), 'left');
		}
		
		$this->db->where(config_item('username_field'), $username);
		return $this->db->get($ut);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * edit_user function.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_user($post)
	{
		$this->db->where('id', $post['id']);
		return $this->db->update(config_item('users_table'), $post);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file authentication_model.php */
/* Location: ./bookymark/application/third_party/authentication/models/authentication_model.php */