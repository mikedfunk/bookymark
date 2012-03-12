<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * maintenance
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		maintenance.php
 * @version		1.0
 * @date		03/11/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * maintenance class.
 * 
 * @extends CI_Controller
 */
class maintenance extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * migrate function.
	 * 
	 * @access public
	 * @return void
	 */
	public function migrate()
	{
		// limit access
		$this->load->spark('access/0.0.4');
		$this->access->prompt();
		
		$this->load->library('migration');
		
		// succeed
		if ($this->migration->current())
		{
			$data['content'] = '<div class="alert alert-success">';
			$data['content'] .= 'Migration to latest version successful.';
		}
		// fail
		else
		{
			$data['content'] = '<div class="alert alert-error">';
			$data['content'] .= 'Migration failed.';
		}
		
		$data['content'] .= '</div>';
		$this->load->view('template_view', $data);
	}
	
	// --------------------------------------------------------------------------
}

/* End of file maintenance.php */
/* Location: ./bookymark/application/controllers/maintenance.php */