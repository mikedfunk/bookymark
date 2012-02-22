<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Session
 * 
 * Adds all_flashdata
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		MY_Session.php
 * @version		1.0
 * @date		02/22/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * MY_Session class.
 * 
 * @extends CI_Session
 */
class MY_Session extends CI_Session
{
	// --------------------------------------------------------------------------
	
	/**
	 * all_flashdata function.
	 * 
	 * @access public
	 * @return void
	 */
	public function all_flashdata()
	{
		// loop through all userdata
		$out = array();
		foreach ($this->all_userdata() as $key => $val)
		{	
			// if it contains flashdata, add it
			if (strpos($key, 'flash:old:') !== FALSE)
			{
				$out[$key] = $val;
			}
		}
		return $out;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file MY_Session.php */
/* Location: ./bookymark/application/libraries/MY_Session.php */