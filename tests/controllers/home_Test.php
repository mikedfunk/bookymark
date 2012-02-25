<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home_Test
 * 
 * tests all methods in controllers/home.php.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		home_Test.php
 * @version		1.0
 * @date		02/14/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * home_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class home_Test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * the codeigniter super object
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * setUp function.
	 * 
	 * @access public
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		
		// Set the tested controller
		$this->_ci = set_controller('home');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_index function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_index()
	{
		// test
		$this->_ci->index();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_login()
	{
		// test
		$this->_ci->login();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_register function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_register()
	{
		// test
		$this->_ci->register();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_register_validation function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_register_validation()
	{
		// setup user
		$email_address = 'test'.uniqid().'@test.com';
		$_POST = array(
			'email_address' => $email_address,
			'password' => 'TEST',
			'confirm_password' => 'TEST'
		);
		
		// test
		$this->_ci->register();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		
		// check the db
		$q = $this->_ci->db->get_where('users', array('email_address' => $email_address));
		$this->assertGreaterThan(0, $q->num_rows());
		
		// delete user
		$this->_ci->db->where('email_address', $email_address);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login_validation function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_login_validation()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = $_POST = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		$_POST['password'] = 'TEST';
		
		// test
		$this->_ci->login();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login_new_password function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_login_new_password()
	{
		// test
		$this->_ci->login_new_password();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login_new_password_validation function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_login_new_password_validation()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = $_POST = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		$_POST['password'] = $_POST['confirm_password'] = 'dork';
		$_POST['temp_password'] = 'TEST';
		
		// test
		$this->_ci->login_new_password();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login_validation_not_confirmed function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_login_validation_not_confirmed()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = $_POST = array(
			'confirm_string' => 'test',
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		$_POST['password'] = 'TEST';
		
		// test
		$this->_ci->login();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(1, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_logout function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_logout()
	{
		// test
		$this->_ci->logout();
		$out = output();
		print_r($this->_ci->session->all_userdata());
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home_Test.php */
/* Location: ./bookymark/tests/controllers/home_Test.php */