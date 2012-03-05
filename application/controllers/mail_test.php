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
		
		// --------------------------------------------------------------------------
		
		$to      = 'mikedfunk@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: admin@bookymark.com' . "\r\n" .
		    'Reply-To: admin@bookymark.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		
		if (mail($to, $subject, $message, $headers))
		{
			echo "mail test 2 successful \n\n";
		}
		else
		{
			echo "ERROR sending mail 2 \n\n";
		}
		
		// --------------------------------------------------------------------------
		
		// multiple recipients
		$to  = 'mikedfunk@gmail.com';
		
		// subject
		$subject = 'Birthday Reminders for August';
		
		// message
		$message = '
		<html>
		<head>
		  <title>Birthday Reminders for August</title>
		</head>
		<body>
		  <p>Here are the birthdays upcoming in August!</p>
		  <table>
		    <tr>
		      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
		    </tr>
		    <tr>
		      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
		    </tr>
		    <tr>
		      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
		    </tr>
		  </table>
		</body>
		</html>
		';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: Bookymark <admin@bookymark.com>' . "\r\n";
		
		// Mail it
		mail($to, $subject, $message, $headers);
	}
	
	// --------------------------------------------------------------------------
}

/* End of file mail_test.php */
/* Location: ./bookymark/application/controllers/mail_test.php */