<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * form_value_helper
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		form_value_helper.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * edit_value function.
 * 
 * @access public
 * @param string $column the column name. Used as the result column and the
 * form error name.
 * @param mixed $r a database result. Can be either an object or an array.
 * @param string $default (default: '')
 * @return void
 */
function edit_value($column, $r = false, $default = '')
{
	// load resources
	$_ci =& get_instance();
	$_ci->load->library('form_validation');
	
	// set output
	if (form_error($column) !== false)
	{
		$output = form_error($column);
	}
	else if (is_object($r))
	{
		if (isset($r->$column))
		{
			$output = $r->$column;
		}
	}
	else if (is_array($r))
	{
		if (isset($r[$column]))
		{
			$output = $r[$column];
		}
	}
	else
	{
		$output = $default;
	}
}
/* End of file form_value_helper.php */
/* Location: ./bookymark/application/helpers/form_value_helper.php */