<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks
 * 
 * All methods for bookmarks. All methods are restricted via _remap().
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmarks.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks class.
 * 
 * @extends CI_Controller
 */
class bookmarks extends CI_Controller
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
	 * loads common resources
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// load resources
		$this->output->enable_profiler(TRUE);
		
		// restrict access
		$this->load->library('authentication');
		$this->authentication->restrict_access();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * shortcut to list bookmarks
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->list();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * table function.
	 * 
	 * @access public
	 * @return void
	 */
	public function table()
	{	
		$this->authentication->restrict_access('can_list_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->library(array('pagination', 'carabiner'));
		$this->load->helper(array('url', 'authentication_helper'));
		$this->config->load('pagination');
		
		// pagination
		$opts = $this->input->get();
		unset($opts['page']);
		$q = $this->bookmarks_model->bookmarks_table($opts);
		$config['base_url'] = 'table?';
		$config['total_rows'] = $this->data['total_rows'] = $q->num_rows();
		$this->pagination->initialize($config);
		
		// get bookmarks
		$get = (is_array($this->input->get()) ? $this->input->get() : array());
		$opts = array_merge($get, array('limit' => $this->config->item('per_page')));
		$this->_data['bookmarks'] = $this->bookmarks_model->bookmarks_table($opts);
		
		// load view
		$this->_data['title'] = 'My Bookymarks | Bookymark';
		$this->_data['content'] = $this->load->view('bookmarks/list_bookmarks_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add function.
	 * 
	 * @access public
	 * @return void
	 */
	public function add()
	{
		$this->authentication->restrict_access('can_add_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->library('carabiner');
		$this->load->helper(array('url', 'authentication_helper'));
		
		// set data and load view
		$this->_data['title'] = 'Add Bookymark | Bookymark';
		$this->_data['content'] = $this->load->view('bookmarks/bookmark_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./bookymark/application/controllers/bookmarks.php */