<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home_model
 * 
 * Description
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		home_model.php
 * @version		1.0
 * @date		02/15/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * home_model class.
 * 
 * @extends CI_Model
 */
class home_model extends CI_Model
{
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * getting started...
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	// --------------------------------------------------------------------------
	
	/**
	 * login_check function.
	 *
	 * checks whether a user is logged in
	 * 
	 * @access public
	 * @param object $session
	 * @return bool
	 */
	public function login_check($session)
	{
		$this->db->where('email_address', $session->userdata('email_address'));
		$this->db->where('password', $session->userdata('password'));
		$q = $this->db->get('users');
		if ($q->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home_model.php */
/* Location: ./bookymark/application/models/home_model.php */