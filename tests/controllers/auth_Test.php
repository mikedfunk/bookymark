<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * auth_Test
 * 
 * Test all auth controller methods
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		auth_Test.php
 * @version		1.3.0
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------

/**
 * auth_Test class.
 * 
 * @extends CIUnitTestCase
 */
class auth_Test extends CIUnit_TestCase
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
		$this->_ci = set_controller('auth');
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
		// for some reason I have to load this here. Not sure why, everything seems
		// to autoload everywhere else.
		$this->_ci->load->library('ci_authentication');
		
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
	 * test__email_address_check function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test__email_address_check()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$chk = $this->_ci->_email_address_check($email_address);
		$this->assertTrue($chk);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test__email_address_check_fail function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test__email_address_check_fail()
	{	
		// test
		$chk = $this->_ci->_email_address_check(uniqid());
		$this->assertFalse($chk);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test__password_check function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test__password_check()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$_POST['email_address'] = $email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$chk = $this->_ci->_password_check('TEST');
		$this->assertTrue($chk);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test__password_check_fail function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test__password_check_fail()
	{	
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$_POST['email_address'] = $email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$chk = $this->_ci->_password_check(uniqid());
		$this->assertFalse($chk);
		
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
		
		// check flashdata
		$this->assertEquals(serialize($this->_ci->session->userdata('flash:new:success')), 'a:1:{i:0;s:25:"You have been logged out.";}');
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_resend_register_email function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_resend_register_email()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$confirm_string = uniqid();
		$post = array(
			'email_address' => $email_address,
			'password' => $password,
			'confirm_string' => $confirm_string
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->resend_register_email($confirm_string);
		$out = output();
		
		// check flashdata
		$this->assertEquals(
			serialize($this->_ci->session->userdata('flash:new:success')), 
			'a:1:{i:0;s:92:"A confirmation has been sent to your email address. Please click the link there to continue.";}'
		);
		
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
	 * test_confirm_register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_confirm_register()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$confirm_string = uniqid();
		$post = array(
			'email_address' => $email_address,
			'password' => $password,
			'confirm_string' => $confirm_string
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->confirm_register($confirm_string);
		$out = output();
		
		// check flashdata
		$this->assertEquals(
			serialize($this->_ci->session->userdata('flash:new:success')), 
			'a:1:{i:0;s:37:"Registration confirmed. Please login.";}'
		);
		
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
	 * test_request_reset_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_request_reset_password()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$_GET['email_address'] = $email_address = 'test'.random_string('alnum', 5).'@test.com';
		$password = encrypt_this('TEST', $salt);
		$post = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->request_reset_password();
		$out = output();
		
		// check flashdata
		$this->assertEquals(
			serialize($this->_ci->session->userdata('flash:new:success')), 
			'a:1:{i:0;s:103:"A confirmation has been sent to your email address. Please click the link there to reset your password.";}'
		);
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
		unset($_GET);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_confirm_reset_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_confirm_reset_password()
	{
		// insert user
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		$salt = random_string('alnum', 64);
		$_GET['email_address'] = $email_address = 'test'.random_string('alnum', 5).'@test.com';
		$_GET['string'] = encrypt_this($email_address, $email_address[0]);
		$password = encrypt_this('TEST', $salt);
		$post = array(
			'email_address' => $email_address,
			'password' => $password
		);
		$this->_ci->db->insert('users', $post);
		$user_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->confirm_reset_password();
		$out = output();
		
		// check flashdata
		$this->assertEquals(
			serialize($this->_ci->session->userdata('flash:new:success')), 
			'a:1:{i:0;s:88:"Password reset. Your new password has been emailed to you. Please retrieve it and login.";}'
		);
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->assertTrue($this->_ci->db->delete('users'));
		unset($_POST);
		unset($_GET);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file auth_Test.php */
/* Location: ./bookymark/tests/controllers/auth_Test.php */