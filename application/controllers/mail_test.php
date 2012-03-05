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
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Bookymark</title>
</head>
<body>
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
	<tr>
		<td valign="top"> 
		<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
		<table cellpadding="5" cellspacing="0" border="0" align="center">
			<tr>
				<td width="800" valign="top">
					<h1>Bookymark Registration</h1>
<p>Thank you for registering for Bookymark. To complete your registration, please click this <a href="http://bookymark.com/home/confirm_register/JeAGuuy8ARt8mXJDjqg5" target="_blank">registration link</a>.</p>
				</td>
			</tr>
		</table>
		<!-- End example table -->

		</td>
	</tr>
</table>  
<!-- End of wrapper table -->
</body>
</html>';

		// subject, msg, send
		$this->load->library('email');
		$this->email->from('admin@bookymark.com');
		$this->email->to('mikedfunk@gmail.com');
		$this->email->subject('subject');
		$this->email->message($msg);
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
	// --------------------------------------------------------------------------
}

/* End of file mail_test.php */
/* Location: ./bookymark/application/controllers/mail_test.php */