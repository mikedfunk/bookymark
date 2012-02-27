<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks 
 * 
 * All methods for bookmarks. All methods are restricted via __construct().
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
	 * holds all data for views.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_data;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * loads common resources.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// restrict access
		$this->load->library('authentication');
		
		// load resources
		if (ENVIRONMENT == 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * shortcut to list_items.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->list_items();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * list_items function.
	 *
	 * shows all items with pagination and links to edit and delete if permissions
	 * allow.
	 * 
	 * @access public
	 * @return void
	 */
	public function list_items()
	{	
		$this->authentication->restrict_access('can_list_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->library(array('pagination', 'carabiner', 'table'));
		$this->load->helper(array('url', 'authentication_helper'));
		$this->config->load('pagination');
		
		// pagination
		$opts = $this->input->get();
		unset($opts['page']);
		$q = $this->bookmarks_model->list_items($opts);
		$config['base_url'] = 'list_items?';
		$config['total_rows'] = $this->data['total_rows'] = $q->num_rows();
		$this->pagination->initialize($config);
		
		// get bookmarks
		$get = (is_array($this->input->get()) ? $this->input->get() : array());
		$opts = array_merge($get, array('limit' => $this->config->item('per_page')));
		$this->_data['bookmarks'] = $this->bookmarks_model->list_items($opts);
		
		// load view
		$this->_data['title'] = 'My Bookymarks | Bookymark';
		$this->_data['content'] = $this->load->view('bookmarks/list_bookmarks_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add_item function.
	 *
	 * shows add item form, handles validation, adds item and redirects.
	 * 
	 * @access public
	 * @return void
	 */
	public function add_item()
	{
		$this->authentication->restrict_access('can_add_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->library(array('carabiner', 'form_validation'));
		$this->load->helper(array('url', 'authentication_helper', 'form'));
		
		// form validation
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$this->_data['title'] = 'Add Bookymark | Bookymark';
			$this->_data['content'] = $this->load->view('bookmarks/bookmark_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// add and redirect
			$this->load->library('alerts');
			$this->alerts->set('success', 'Bookmark added.');
			$this->bookmarks_model->add_item($this->input->post());
			redirect('bookmarks/list_items');
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * edit_item function.
	 *
	 * shows edit item form, handles validation, edits item and redirects.
	 * 
	 * @access public
	 * @param int $id
	 * @return void
	 */
	public function edit_item($id)
	{
		$this->authentication->restrict_access('can_edit_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->library(array('carabiner', 'form_validation', 'alerts'));
		$this->load->helper(array('url', 'authentication_helper', 'form'));
		
		// form validation
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			// load view
			$q = $this->bookmarks_model->get_item($id);
			if ($q->num_rows() == 0) 
			{
				$this->alerts->set('error', 'Item not found.');
				redirect('alert');
			}
			$this->_data['item'] = $q->row();
			$this->_data['title'] = 'Edit Bookymark | Bookymark';
			$this->_data['content'] = $this->load->view('bookmarks/bookmark_view', $this->_data, TRUE);
			$this->load->view('template_view', $this->_data);
		}
		else
		{
			// edit and redirect
			$this->alerts->set('success', 'Bookmark edited.');
			$this->bookmarks_model->edit_item($this->input->post());
			redirect('bookmarks/list_items');
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * delete_item function.
	 *
	 * deletes item by passed id, redirects.
	 * 
	 * @access public
	 * @param int $id
	 * @return void
	 */
	public function delete_item($id)
	{
		$this->authentication->restrict_access('can_delete_bookmarks');
		
		// load resources
		$this->load->database();
		$this->load->model('bookmarks_model');
		$this->load->helper('url');
		
		// delete item and redirect
		$this->load->library('alerts');
		$this->alerts->set('success', 'Bookmark deleted.');
		$this->bookmarks_model->delete_item($id);
		redirect('bookmarks/list_items');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./bookymark/application/controllers/bookmarks.php */