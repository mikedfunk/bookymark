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
	 * password_check function.
	 * 
	 * @access public
	 * @param string $email_address
	 * @param string $password
	 * @return bool
	 */
	public function password_check($email_address, $password)
	{
		$q = $this->get_user_by_email_address($email_address);
		if ($q->num_rows() == 0)
		{
			return false;
		}
		else
		{	
			if ($q->num_rows() == 1)
			{
				$r = $q->row();
				$salt = substr($r->password, 0, 64);
			}
			$this->load->helper('encrypt_helper');
			$password = encrypt_this($password, $salt);
			
			$this->db->where('password', $password);
			$return = $this->db->get('users');
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_email_address function.
	 * 
	 * @access public
	 * @param mixed $email_address
	 * @return object
	 */
	public function get_user_by_email_address($email_address)
	{
		$this->db->where('email_address', $email_address);
		return $this->db->get('users');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file authentication_model.php */
/* Location: ./bookymark/application/third_party/authentication/models/authentication_model.php */