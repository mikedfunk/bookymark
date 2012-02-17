<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_model
 * 
 * Description
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
	 * bookmarks_table function.
	 * 
	 * @access public
	 * @param string $limit (default: '')
	 * @param string $page (default: '')
	 * @param string $sort_by (default: '')
	 * @param string $sort_dir (default: 'asc')
	 * @param string $filter (default: '')
	 * @param bool $ids_only (default: false)
	 * @return void
	 */
	public function bookmarks_table($limit = '', $page = '', $sort_by = '', $sort_dir = 'asc', $filter = '', $ids_only = false)
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
			$this->db->select('url, description');
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
}
/* End of file bookmarks_model.php */
/* Location: ./bookymark/application/models/bookmarks_model.php */