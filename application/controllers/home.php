<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home
 * 
 * Description
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
		
		// for testing to work
		$this->_data['fcpath'] = $fcpath = str_replace('application/third_party/CIUnit/', '', FCPATH);
		$this->_data['apppath'] = $apppath = str_replace($fcpath, '', APPPATH);
		
		// load resources
		require_once($fcpath.$apppath.'libraries/less_css/lessc.inc.php');
		$this->load->add_package_path($fcpath.$apppath.'third_party/carabiner');
		$this->load->library('carabiner');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login function.
	 * 
	 * @access public
	 * @param string $message (default: '')
	 * @return void
	 */
	public function login($message = '')
	{
		$this->load->helper('form');
		$this->load->helper('cookie');
		$this->_data['message'] = $message;
		$this->_data['header'] = $this->load->view('header_only_view', $this->_data, TRUE);
		$this->_data['content'] = $this->load->view('login_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login_validation function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login_validation()
	{
		$this->load->library('form_validation');
	}
	// --------------------------------------------------------------------------
}
/* End of file home.php */
/* Location: ./bookymark/application/controllers/home.php */