<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * alert
 * 
 * shows alerts such as 404 errors or flashdata alerts.
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
	 * _data
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_data;
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * shows alert from flashdata.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// load resources
		$this->load->library(array('carabiner', 'session', 'alerts'));
		$this->load->helper('url');
		
		// load content and view
		$this->_data['content'] = $this->load->view('alert_view', $this->_data, TRUE);
		$this->_data['title'] = 'Alert | Bookymark';
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file alert.php */
/* Location: ./bookymark/application/controllers/alert.php */