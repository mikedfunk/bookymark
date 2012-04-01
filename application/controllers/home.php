<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home
 * 
 * Where everything goes that doesn't require login.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		home.php
 * @version		1.3.1
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------

/**
 * home class.
 * 
 * @extends CI_Controller
 */
class home extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * _data
	 *
	 * holds all data for views.
	 * 
	 * @var array
	 * @access private
	 */
	private $_data;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// load resources
		$this->load->spark('carabiner/1.5.4');
		if (ENVIRONMENT == 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * the home page.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// load resources
		$this->load->helper('url');
		
		// load view
		$this->_data['title'] = 'Home | Bookymark';
		$this->_data['content'] = $this->load->view('home/home_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home.php */
/* Location: ./bookymark/application/controllers/home.php */