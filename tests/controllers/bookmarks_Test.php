<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_Test
 * 
 * tests the bookmarks class.
 * 
 * @license		Copyright Mike Funk. All Rights Reserved.
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmarks_Test.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class bookmarks_Test extends CIUnit_TestCase
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
	 * _user_id
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_user_id;
	
	// --------------------------------------------------------------------------
	
	/**
	 * _role_id
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_role_id;
	
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
		$this->_ci = set_controller('bookmarks');
		$this->_ci->load->library('session');
		$this->_ci->load->database();
		
		// create role that can edit books
		$role['title'] = 'test';
		$role['can_edit_bookmarks'] = 1;
		$role['can_add_bookmarks'] = 1;
		$role['can_delete_bookmarks'] = 1;
		$role['can_list_bookmarks'] = 1;
		$this->assertTrue($this->_ci->db->insert('roles', $role));
		$role_id = $this->_role_id = $this->_ci->db->insert_id();
		
		// create a user
		$user['email_address'] = 'test';
		$user['password'] = uniqid();
		$user['role_id'] = $role_id;
		$this->assertTrue($this->_ci->db->insert('users', $user));
		$user_id = $this->_user_id = $this->_ci->db->insert_id();
		
		// add user to session (for login test)
		$user['id'] = $user_id;
		$user = array_merge($role, $user);
		$this->_ci->session->set_userdata($user);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * tearDown function.
	 * 
	 * @access public
	 * @return void
	 */
	public function tearDown()
	{
		parent::tearDown();
		
		// remove role
 		$this->_ci->db->where('id', $this->_role_id);
 		$this->assertTrue($this->_ci->db->delete('roles'));
 		$this->assertEquals($this->_ci->db->affected_rows(), 1);
 		
 		// remove user and unset userdata
 		$this->_ci->db->where('id', $this->_user_id);
 		$this->assertTrue($this->_ci->db->delete('users'));
 		$this->assertEquals($this->_ci->db->affected_rows(), 1);
 		// $this->_ci->session->unset_userdata(array('email_address', 'password', 'id'));
 		$this->_ci->session->sess_destroy();
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
		$this->_ci->load->database();
		
		// insert user
		$email_address = 'test'.uniqid();
		$password = 'test'.uniqid();
		$data = array(
			'email_address' => $email_address,
			'password' => $password
		);
		
		$this->assertTrue($this->_ci->db->insert('users', $data));
		$user_id = $this->_ci->db->insert_id();
		
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// set userdata
		$this->_ci->load->library('session');
		$this->_ci->session->set_userdata($data);
		
		// test
		$this->_ci->index();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertNotEquals('', $out);
		
		// delete user
		$this->_ci->db->where('id', $user_id);
		$this->_ci->db->delete('users');
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->assertTrue($this->_ci->db->delete('bookmarks'));
		
		$this->_ci->session->sess_destroy();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_list_items function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_list_items()
	{
		// test
		$this->_ci->list_items();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertNotEquals('', $out);
		
		// add a record and try again
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->list_items();
		$out = output();
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->assertTrue($this->_ci->db->delete('bookmarks'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_add_item function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_add_item()
	{
		// test
		$this->_ci->add_item();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_add_item_validated function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_add_item_validated()
	{
		$_POST = array(
			'url' => 'test',
			'description' => 'test'
		);
		
		// test
		$this->_ci->add_item();
		$out = output();
		
		// notification success, no php errors
		$this->assertEquals($this->_ci->session->userdata('flash:new:success'), 'a:1:{i:0;s:15:"Bookmark added.";}');
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_edit_item function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_edit_item()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->edit_item($bookmark_id);
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertNotEquals('', $out);
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->assertTrue($this->_ci->db->delete('bookmarks'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_edit_item_validated function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_edit_item_validated()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// set update post
		$new_url = 'test'.uniqid();
		$_POST = array(
			'id' => $bookmark_id,
			'url' => $new_url,
			'description' => 'test'
		);
		
		// test
		$this->_ci->edit_item($bookmark_id);
		$out = output();
		
		// notification success, no php errors
		$this->assertEquals($this->_ci->session->userdata('flash:new:success'), 'a:1:{i:0;s:16:"Bookmark edited.";}');
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$q = $this->_ci->db->get_where('bookmarks', array('id' => $bookmark_id));
		$this->assertGreaterThan(0, $q->num_rows());
		$r = $q->row();
		$this->assertEquals($r->url, $new_url);
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->assertTrue($this->_ci->db->delete('bookmarks'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_delete_item function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_delete_item()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->delete_item($bookmark_id);
		$out = output();
		
		// Check if the content is OK. It should be empty.
		$this->assertSame(0, preg_match('/A PHP Error was encountered/i', $out));
		$this->assertEquals('', $out);
		
		// ensure item is deleted
		$this->_ci->db->where('id', $bookmark_id);
		$q = $this->_ci->db->get('bookmarks');
		$this->assertEquals(0, $q->num_rows());
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_Test.php */
/* Location: ./bookymark/tests/controllers/bookmarks_Test.php */