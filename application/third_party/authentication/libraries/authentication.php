<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * authentication
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		authentication.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * authentication class.
 */
class authentication
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->load->database();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * restrict_access function.
	 * 
	 * @access public
	 * @return void
	 */
	public function restrict_access()
	{
		// load resources
		$this->_ci->load->model('authentication_model', 'auth_model');
		$this->_ci->load->library('session');
		$this->_ci->load->helper('url');
		
		// check for password match, else redirect
		$chk = $this->_ci->auth_model->password_check(
			$this->_ci->session->userdata('email_address'), 
			$this->_ci->session->userdata('password')
		);
		if (!$chk)
		{
			redirect('home/login/logged_out');
		}
	}
	
	// --------------------------------------------------------------------------
}
/* End of file authentication.php */
/* Location: ./bookymark/application/third_party/authentication/libraries/authentication.php */