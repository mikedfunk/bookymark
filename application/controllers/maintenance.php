<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * maintenance
 * 
 * Description
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		maintenance.php
 * @version		1.3.1
 * @date		03/12/2012
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
		// load resources
		$this->load->spark(array('access/0.0.4', 'carabiner/1.5.4'));
		$this->load->helper('url');
		$this->load->library('migration');
		
		// limit access
		$this->access->prompt();
		
		$data['content'] = '<section><div class="container">';
		
		// succeed
		
		// "current" goes to the version in config/migration.php
		// if ($this->migration->current())
		
		// "latest" disregards config and upgrades to the hightest version in
		// migrations/. I imagine this is what will be used 90% of the time.
		if ($this->migration->latest())
		{
			$data['content'] .= '<div class="alert alert-success">';
			$data['content'] .= 'Migration to latest version successful.';
		}
		// fail
		else
		{
			$data['content'] .= '<div class="alert alert-error">';
			$data['content'] .= 'Migration failed.';
		}
		
		// load view
		$data['content'] .= '</div></div></section>';
		$this->load->view('template_view', $data);
	}
	
	// --------------------------------------------------------------------------
}

/* End of file maintenance.php */
/* Location: ./bookymark/application/controllers/maintenance.php */