<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home_Test
 * 
 * tests all methods in controllers/home.php.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		home_Test.php
 * @version		1.3.0
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------

/**
 * home_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class home_Test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * the codeigniter super object
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * setUp function.
	 * 
	 * @access public
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		
		// Set the tested controller
		$this->_ci = set_controller('home');
		$this->_ci->load->library(array('ci_authentication', 'ci_alerts'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_index function.
	 * 
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_index()
	{
		// test
		$this->_ci->index();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertSame(0, preg_match('/A PHP Error has occurred/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home_Test.php */
/* Location: ./bookymark/tests/controllers/home_Test.php */