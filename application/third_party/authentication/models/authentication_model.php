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
		// check for existing email
		if (!$this->email_address_check($email_address))
		{
			return false;
		}
		// if it exists, *then* check for matching password
		else
		{
			// set up values
			$r = $q->row();
			$salt = substr($r->password, 0, 64);
			$this->load->helper('encrypt_helper');
			$password = encrypt_this($password, $salt);
			
			// check password and return match
			$this->db->where('password', $password);
			$q = $this->db->get('users');
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
	 * email_address_check function.
	 * 
	 * @access public
	 * @param mixed $email_address
	 * @return void
	 */
	public function email_address_check($email_address)
	{
		$this->db->where('email_address', $email_address);
		$q = $this->db->get('users');
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
}
/* End of file authentication_model.php */
/* Location: ./bookymark/application/third_party/authentication/models/authentication_model.php */