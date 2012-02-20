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
		$this->load->library('carabiner');
		
		// load view
		$this->_data['title'] = 'Home | Bookymark';
		$this->_data['content'] = $this->load->view('home_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login function.
	 *
	 * shows login form, handles validaton, 
	 * 
	 * @access public
	 * @return void
	 */
	public function login()
	{
		// load resources
		$this->load->database();
		$this->load->model('authentication_model', 'auth_model');
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library(array('form_validation', 'authentication', 'carabiner'));
		$this->authentication->remember_me();
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|callback__email_address_check');
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
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login_new_password function.
	 *
	 * shows login_new_password form, handles validaton, 
	 * 
	 * @access public
	 * @return void
	 */
	public function login_new_password()
	{
		// load resources
		$this->load->database();
		$this->load->model('authentication_model', 'auth_model');
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library(array('form_validation', 'authentication', 'carabiner'));
		$this->authentication->remember_me();
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|callback__email_address_check');
		$this->form_validation->set_rules('temp_password', 'Temporary Password', 'required|callback__password_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Login | Bookymark';
			$this->_data['content'] = $this->load->view('login_new_password_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->authentication->do_login();
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
	 * @param mixed $email_address
	 * @return void
	 */
	public function _email_address_check($email_address)
	{
		if (!$this->auth_model->username_check($email_address))
		{
			$this->form_validation->set_message('_email_address_check', 'Email address not found. <a href="' . base_url() . 'home/register">Want to Register?</a>');
			return false;
		}
		else
		{
			// if there's a confirm string, fail
			$q = $this->auth_model->get_user_by_username($email_address);
			$r = $q->row();
			// if (!$this->auth_model->confirm_string_check($email_address))
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
	 * @param mixed $password
	 * @return void
	 */
	public function _password_check($password)
	{
		$chk = $this->auth_model->password_check($this->input->post('email_address'), $password);
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
	 * displays register form, handles validation, runs authentication library 
	 * method on success.
	 * 
	 * @access public
	 * @return void
	 */
	public function register()
	{
		$this->load->database();
		$this->load->helper(array('form', 'cookie', 'url'));
		$this->load->library(array('form_validation', 'authentication', 'carabiner'));
		
		// form validation
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[users.email_address]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Register | Bookymark';
			$this->_data['content'] = $this->load->view('register_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// redirect to configured home page
			$this->authentication->do_register();
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * resend_register_email function.
	 * 
	 * @access public
	 * @param mixed $confirm_string
	 * @return void
	 */
	public function resend_register_email($confirm_string)
	{
		$this->load->library('authentication');
		$this->authentication->resend_register_email($confirm_string);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * register_success function.
	 *
	 * shows register success view.
	 * 
	 * @access public
	 * @return void
	 */
	public function register_success()
	{
		$this->load->helper('url');
		$this->load->library('carabiner');
		
		// load view
		$this->_data['title'] = 'Almost done! | Bookymark';
		$this->_data['content'] = $this->load->view('register_success_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_register function.
	 *
	 * runs confirm_register method of authentication library.
	 * 
	 * @access public
	 * @param mixed $confirm_string
	 * @return void
	 */
	public function confirm_register($confirm_string)
	{
		$this->load->library('authentication');
		$this->authentication->do_confirm_register($confirm_string);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * request_reset_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function request_reset_password()
	{
		$email_address = $this->input->get('email_address');
		$this->load->library('authentication');
		$this->authentication->do_request_reset_password($email_address);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * request_reset_success function.
	 * 
	 * @access public
	 * @return void
	 */
	public function request_reset_success()
	{
		$this->load->helper('url');
		$this->load->library('carabiner');
		
		// load view
		$this->_data['title'] = 'Almost done! | Bookymark';
		$this->_data['content'] = $this->load->view('request_reset_success_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_reset_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function confirm_reset_password()
	{
		$this->load->library('authentication');
		$this->authentication->do_confirm_reset_password();
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