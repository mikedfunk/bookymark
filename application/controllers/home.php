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
 * @version		1.1.0
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
	 * holds all data for views.
	 * 
	 * @var array
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
		$this->load->spark(array('ci_authentication/1.1.8', 'ci_alerts/1.1.4', 'carabiner/1.5.4'));
		if (ENVIRONMENT == 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * the home page.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// load resources
		$this->load->helper('url');
		
		// load view
		$this->_data['title'] = 'Home | Bookymark';
		$this->_data['content'] = $this->load->view('home/home_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login function.
	 *
	 * shows login form, handles validation.
	 * 
	 * @access public
	 * @return void
	 */
	public function login()
	{
		// load resources
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library('form_validation');
		$this->ci_authentication->remember_me();
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|callback__email_address_check');
		$this->form_validation->set_rules('password', 'Password', 'required|callback__password_check');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Login | Bookymark';
			$this->_data['content'] = $this->load->view('home/login_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->ci_authentication->do_login();
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login_new_password function.
	 *
	 * shows login_new_password form, handles validation.
	 * 
	 * @access public
	 * @return void
	 */
	public function login_new_password()
	{
		// load resources
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library('form_validation');
		$this->ci_authentication->remember_me();
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|callback__email_address_check');
		$this->form_validation->set_rules('temp_password', 'Temporary Password', 'required|callback__password_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Login | Bookymark';
			$this->_data['content'] = $this->load->view('home/login_new_password_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->ci_authentication->do_login();
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * _email_address_check function.
	 *
	 * checks for an email in the db and checks to make sure registration link
	 * has been clicked.
	 * 
	 * @access public
	 * @param string $email_address
	 * @return bool
	 */
	public function _email_address_check($email_address)
	{
		if (!$this->ci_authentication_model->username_check($email_address))
		{
			$this->form_validation->set_message('_email_address_check', 'Email address not found. <a href="' . base_url() . 'home/register">Want to Register?</a>');
			return false;
		}
		else
		{
			// if there's a confirm string, fail
			$q = $this->ci_authentication_model->get_user_by_username($email_address);
			$r = $q->row();
			// if (!$this->ci_authentication_model->confirm_string_check($email_address))
			if ($r->confirm_string != '')
			{
				$this->form_validation->set_message('_email_address_check', 'Please click the registration link sent to your email. <a href="'.base_url().'home/resend_register_email/'.$r->confirm_string.'">Or resend it</a>.');
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
	 * _password_check function.
	 *
	 * checks to ensure password matches username in db.
	 * 
	 * @access public
	 * @param string $password
	 * @return bool
	 */
	public function _password_check($password)
	{
		$chk = $this->ci_authentication_model->password_check($this->input->post('email_address'), $password);
		if (!$chk)
		{
			$this->form_validation->set_message('_password_check', 'Incorrect password. <a href="'.base_url().'home/request_reset_password/?email_address='.$this->input->post('email_address').'">Forgot your password?</a>');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * register function.
	 *
	 * displays register form, handles validation, runs ci_authentication library 
	 * method on success.
	 * 
	 * @access public
	 * @return void
	 */
	public function register()
	{
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library('form_validation');
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[users.email_address]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Register | Bookymark';
			$this->_data['content'] = $this->load->view('home/register_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->ci_authentication->do_register();
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * resend_register_email function.
	 *
	 * resends register email based on confirm_string, redirects to configured page.
	 * 
	 * @access public
	 * @param string $confirm_string
	 * @return void
	 */
	public function resend_register_email($confirm_string)
	{
		$this->ci_authentication->resend_register_email($confirm_string);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_register function.
	 *
	 * verifies confirm link, clears confirm_string column for that user, sets
	 *  flashdata for success notice, redirects to login page.
	 * 
	 * @access public
	 * @param string $confirm_string
	 * @return void
	 */
	public function confirm_register($confirm_string)
	{
		$this->ci_authentication->do_confirm_register($confirm_string);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * request_reset_password function.
	 *
	 * send email confirmation to user, redirects to configured page.
	 * 
	 * @access public
	 * @return void
	 */
	public function request_reset_password()
	{
		$email_address = $this->input->get('email_address');
		$this->ci_authentication->do_request_reset_password($email_address);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_reset_password function.
	 *
	 * validates whether encryption of passed email and encrypted string match,
	 * emails temp password and redirects to configured page (login new password)
	 * 
	 * @access public
	 * @return void
	 */
	public function confirm_reset_password()
	{
		$this->ci_authentication->do_confirm_reset_password();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * logout function.
	 *
	 * destroys the session, unsets userdata, sets flashdata, redirects to 
	 * configured page (login page).
	 * 
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->ci_authentication->do_logout();
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home.php */
/* Location: ./bookymark/application/controllers/home.php */