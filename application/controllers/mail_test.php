<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * mail_test
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		mail_test.php
 * @version		1.0
 * @date		03/05/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * mail_test class.
 * 
 * @extends CI_Controller
 */
class mail_test extends CI_Controller
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
		$this->load->library('email');
		
		$this->email->initialize(array('mailtype' => 'text'));

		$this->email->from('admin@bookymark.com', 'Your Name');
		$this->email->to('mikedfunk@gmail.com'); 
// 		$this->email->cc('another@another-example.com'); 
// 		$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
	// --------------------------------------------------------------------------
}

/* End of file mail_test.php */
/* Location: ./bookymark/application/controllers/mail_test.php */