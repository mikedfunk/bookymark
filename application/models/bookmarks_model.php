<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_model
 * 
 * All queries for bookmarks
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmarks_model.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_model class.
 * 
 * @extends CI_Model
 */
class bookmarks_model extends CI_Model
{
	// --------------------------------------------------------------------------
	
	/**
	 * list_items function.
	 * 
	 * @access public
	 * @param string $limit (default: '')
	 * @param string $page (default: '')
	 * @param string $sort_by (default: '')
	 * @param string $sort_dir (default: 'asc')
	 * @param string $filter (default: '')
	 * @param bool $ids_only (default: false)
	 * @return bool
	 */
	public function list_items($limit = '', $page = '', $sort_by = '', $sort_dir = 'asc', $filter = '', $ids_only = false)
	{
		// options can be passed as array	
		if (is_array($limit))
		{
			$arr = $limit;
			$limit = (isset($arr['limit']) ? $arr['limit'] : '');
			$page = (isset($arr['page']) ? $arr['page'] : '');
			$sort_by = (isset($arr['sort_by']) ? $arr['sort_by'] : '');
			$sort_dir = (isset($arr['sort_dir']) ? $arr['sort_dir'] : 'asc');
			$filter = (isset($arr['filter']) ? $arr['filter'] : '');
			$ids_only = (isset($arr['ids_only']) ? $arr['ids_only'] : false);
		}
		
		// select
		if ($ids_only)
		{
			$this->db->select('id');
		}
		else
		{
			$this->db->select('id, url, description');
		}
		
		// sort
		if ($sort_by != '' && $sort_by != false)
		{
			$this->db->order_by($sort_by, $sort_dir);
		} 
		else 
		{
			$this->db->order_by('id', 'desc');
		}
		
		// limit and offset
		if ($page != '' || $limit != '')
		{
			$this->db->limit($limit, $page);
		}
		
		return $this->db->get('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_item function.
	 * 
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function get_item($id)
	{
		$this->db->select('id, url, description');
		$this->db->where('id', $id);
		return $this->db->get('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * edit_item function.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_item($post)
	{
		$this->db->where('id', $post['id']);
		return $this->db->update('bookmarks', $post);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add_item function.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function add_item($post)
	{
		return $this->db->insert('bookmarks', $post);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_model.php */
/* Location: ./bookymark/application/models/bookmarks_model.php */