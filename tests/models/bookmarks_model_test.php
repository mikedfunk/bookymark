<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_model_Test
 * 
 * tests all methods in models/bookmarks_model.php.
 * 
 * @license		Copyright Mike Funk. All Rights Reserved.
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmarks_model_Test.php
 * @version		1.2.0
 * @date		03/11/2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_model_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class bookmarks_model_Test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * Codeigniter superobject.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * extra variables are required for testing, even if blank.
	 * 
	 * @access public
	 * @param mixed $name (default: NULL)
	 * @param array $data (default: array())
	 * @param string $dataName (default: '')
	 * @return void
	 */
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
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
		
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->load->model('bookmarks_model');
		$this->_ci->db->cache_off();
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
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_list_items function.
	 * 
	 * @group models
	 * @access public
	 * @return void
	 */
	public function test_list_items()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$opts = array(
			'ids_only' => true,
			'sort_by' => 'id'
		);
		$q = $this->_ci->bookmarks_model->list_items($opts);
		$this->assertGreaterThan(0, $q->num_rows());
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_get_item function.
	 * 
	 * @group models
	 * @access public
	 * @return void
	 */
	public function test_get_item()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$q = $this->_ci->bookmarks_model->get_item($bookmark_id);
		$this->assertGreaterThan(0, $q->num_rows());
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_edit_item function.
	 * 
	 * @group models
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
		$new_data = array(
			'id' => $bookmark_id,
			'description' => 'new'
		);
		$this->assertTrue($this->_ci->bookmarks_model->edit_item($new_data));
		
		// get item, test
		$this->_ci->db->where('id', $bookmark_id);
		$q = $this->_ci->db->get('bookmarks');
		$r = $q->row();
		$this->assertEquals($r->description, 'new');
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_add_item function.
	 * 
	 * @group models
	 * @access public
	 * @return void
	 */
	public function test_add_item()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->bookmarks_model->add_item($data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// get item, test
		$this->_ci->db->where('id', $bookmark_id);
		$q = $this->_ci->db->get('bookmarks');
		$this->assertEquals($q->num_rows(), 1);
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_delete_item function.
	 * 
	 * @group models
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
		$this->assertTrue($this->_ci->bookmarks_model->delete_item($bookmark_id));
		
		// get item, test
		$this->_ci->db->where('id', $bookmark_id);
		$q = $this->_ci->db->get('bookmarks');
		$this->assertEquals($q->num_rows(), 0);
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_model_Test.php */
/* Location: ./bookymark/tests/models/bookmarks_model_Test.php */