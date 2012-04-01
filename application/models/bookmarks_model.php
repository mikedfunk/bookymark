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
 * @version		1.3.1
 * @date		03/12/2012
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
	 * show all items with optional parameters.
	 * 
	 * @access public
	 * @param string $limit (default: '')
	 * @param string $page (default: '')
	 * @param string $sort_by (default: '')
	 * @param string $sort_dir (default: 'asc')
	 * @param string $filter (default: '')
	 * @param bool $ids_only (default: false)
	 * @return object
	 */
	public function list_items($limit = '', $page = '', $sort_by = '', $sort_dir = 'asc', $filter = '', $ids_only = false)
	{
		// options can be passed as array	
		if (is_array($limit))
		{
			$arr = $limit;
			foreach ($arr as $key => $value)
			{
				$$key = $value;
			}
			if (!isset($arr['limit']))
			{
				$limit = FALSE;
			}
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
		
		// filter
		if ($filter != '') 
		{
			// trim spaces, convert entities
			$filter = trim($filter);
			$filter = htmlentities($filter, ENT_QUOTES, "UTF-8");
			
			$where = "(`bookmarks`.`url` LIKE '%".$filter."%'
			OR `bookmarks`.`description` LIKE '%".$filter."%')";
			$this->db->where($where);
		}
		
		return $this->db->get('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_item function.
	 *
	 * get a specific item by id.
	 * 
	 * @access public
	 * @param int $id
	 * @return object
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
	 * edits an item based on a post array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_item($post)
	{
		$this->db->where('id', $post['id']);
		$return = $this->db->update('bookmarks', $post);
		$this->db->cache_delete('bookmarks/list_items');
		$this->db->cache_delete('bookmarks/edit_item');
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add_item function.
	 *
	 * adds an item based on a post array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function add_item($post)
	{
		$return = $this->db->insert('bookmarks', $post);
		$this->db->cache_delete('bookmarks/list_items');
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * delete_item function.
	 *
	 * deletes an item based on a passed id.
	 * 
	 * @access public
	 * @param int $id
	 * @return bool
	 */
	public function delete_item($id)
	{
		$this->db->where('id', $id);
		$return = $this->db->delete('bookmarks');
		$this->db->cache_delete('bookmarks/list_items');
		$this->db->cache_delete('bookmarks/edit_item');
		return $return;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_model.php */
/* Location: ./bookymark/application/models/bookmarks_model.php */