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
		log_message('debug', 'Authentication: library initialized.');
		$this->_ci->config->load('authentication_config');
		log_message('debug', 'Authentication: config loaded.');
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
			$this->_ci->session->userdata(config_item('username_field')), 
			$this->_ci->session->userdata(config_item('password_field'))
		);
		
		if (!$chk)
		{
			redirect(config_item('logged_out_url'));
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * remember_me function.
	 * 
	 * @access public
	 * @return void
	 */
	public function remember_me()
	{
		// set remember_me to 0 if not checked
		if (!$this->_ci->input->post(config_item('remember_me_field')))
		{
			$_POST[config_item('remember_me_field')] = 0;
		}
		
		// set remember_me cookie
		$this->_ci->input->set_cookie(
			config_item('remember_me_field'), 
			$this->_ci->input->post(config_item('remember_me_field')), 
			(config_item('remember_me_timeout'))
		);
		
		// if remember_me, remember, remember the 5th of November
		if ($this->_ci->input->post(config_item('remember_me_field')))
		{
			// set username cookie
			$this->_ci->input->set_cookie(
				config_item('username_field'), 
				$this->_ci->input->post(config_item('username_field')), 
				0
			);
			
			// set password cookie
			$this->_ci->input->set_cookie(
				config_item('password_field'), 
				$this->_ci->input->post(config_item('password_field')), 
				0
			);
		}
		// otherwise fuggedaboutit
		else
		{
			$this->_ci->input->set_cookie(config_item('username_field'), '', time() -1);
			$this->_ci->input->set_cookie(config_item('password_field'), '', time() -1);
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_login function.
	 * 
	 * @access public
	 * @return bool
	 */
	public function do_login()
	{
		$this->_ci->load->model('authentication_model', 'auth_model');
		$this->_ci->load->helper('encrypt_helper');
		$this->_ci->load->helper('string');
		$this->_ci->load->library('session');
		$this->_ci->load->helper('url');
		
		// set session vars, redirect to admin home
		$q = $this->_ci->auth_model->get_user_by_username($this->_ci->input->post(config_item('username_field')));
		$user = $q->row_array();
		
		$q = $this->_ci->auth_model->get_user_by_username($this->_ci->input->post(config_item('username_field')), FALSE);
		$user_only = $q->row_array();
		
		// set a new salt, re-encrypt the password
		$salt = random_string('alnum', config_item('salt_length'));
		$user[config_item('password_field')] = encrypt_this($this->_ci->input->post(config_item('password_field')), $salt);
		
		// edit the user and set new userdata
		$check = $this->_ci->auth_model->edit_user($user_only);
		$this->_ci->session->set_userdata($user);
		
		// log errors
		if (!$check) {log_message('error', 'Authentication: error editing user during login.');}
		
		redirect($this->_ci->session->userdata(config_item('home_page_field')));
	}

	// --------------------------------------------------------------------------

	/**
	 * do_logout
	 *
	 * Destroys the session
	 *
	 * @access public
	 * @return bool
	 */
	public function do_logout()
	{
		$this->_ci->load->library('session');
		$this->_ci->load->helper('url');
		
		$this->_ci->session->sess_destroy();
		redirect(config_item('logout_success_url'));
	}
	
	// --------------------------------------------------------------------------
}
/* End of file authentication.php */
/* Location: ./bookymark/application/third_party/authentication/libraries/authentication.php */