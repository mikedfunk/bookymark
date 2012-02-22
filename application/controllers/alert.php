<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * alert
 * 
 * shows a 404 error with all ci object stuff available.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		error.php
 * @version		1.0
 * @date		02/18/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * alert class.
 * 
 * @extends CI_Controller
 */
class alert extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// load resources
		$this->load->library(array('carabiner', 'session', 'alerts');
		$this->load->helper('url');
		$this->load->library();
		
		// load content and view
		$this->_data['title'] = 'Alert | Bookymark';
		$data['content'] = $this->load->view('alert_view', '', TRUE);
		$this->load->view('template');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * error_404 function.
	 *
	 * show a 404 error.
	 * 
	 * @access public
	 * @return void
	 */
	public function error_404()
	{
		$this->load->library('uri');
		$this->load->helper('url');
		show_404($this->uri->uri_string());
	}
	
	// --------------------------------------------------------------------------
}
/* End of file alert.php */
/* Location: ./bookymark/application/controllers/alert.php */