<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home
 * 
 * Where everything goes that doesn't require login.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		home.php
 * @version		1.0
 * @date		02/14/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * home class.
 * 
 * @extends CI_Controller
 */
class home extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * _data
	 *
	 * holds all data for views
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_data;
	
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
		
		// load resources
		$this->output->enable_profiler(TRUE);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login()
	{
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library(array('form_validation', 'authentication', 'carabiner'));
		$this->authentication->remember_me();
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|callback__email_address_check');
		$this->form_validation->set_rules('password', 'Password', 'required|callback__password_check');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Login | Bookymark';
			$this->_data['content'] = $this->load->view('login_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->authentication->do_login();
			redirect($this->session->userdata('home_page'));
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * _email_address_check function.
	 * 
	 * @access public
	 * @param mixed $input
	 * @return void
	 */
	public function _email_address_check($input)
	{
		$this->load->model('authentication_model', 'auth_model');
		
		// if there's a user by this name return true
		$this->form_validation->set_message('_email_address_check', 'User not found.');
		return $this->auth_model->username_check($input);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * _password_check function.
	 * 
	 * @access public
	 * @param mixed $input
	 * @return void
	 */
	public function _password_check($input)
	{
		$this->load->model('authentication_model', 'auth_model');
		
		// if there's a user with this password return true
		$this->form_validation->set_message('_password_check', 'Incorrect password.');
		return $this->auth_model->password_check($input, $this->input->post('password'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->load->library('authentication');
		$this->authentication->do_logout();
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home.php */
/* Location: ./bookymark/application/controllers/home.php */