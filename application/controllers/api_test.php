<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * test the api interaction
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file api_test.php
 */

class api_test extends MY_Controller
{
	public $api_base_url = 'http://bookymark.dev/';
	public $api_access_token = '4395dd07a3cfe84d9655bb2542907f3acd0024fe';
	public $api_shared_secret = '3c697e1314808f56bd44bc5ccb4765607b433715';
		
	public function index()
	{
		$this->view = false;
		$data = array('description' => 'TESTTEST123123');
		var_dump($this->request('POST', 'bookmarks', $data));
	}
	
	protected function request($method, $path, $params = array())
	{
		// start up and set stuff
		$path = 'api/v1/' . $path;
		$this->load->spark('restclient/2.1.0');
		$this->rest->initialize(array('server' => $this->api_base_url));
		
		// set required headers
		$this->rest->http_header('User-Agent', 'Bookymark Application');
		$this->rest->http_header('X-Access-Token', $this->api_access_token);
		$this->rest->format('application/json; version=v1');
		$timestamp = time();
		$this->rest->http_header('X-Request-Timestamp', $timestamp);

		// build signature and set header
		$hash = $path . http_build_query($params);
		$hash .= $timestamp . $this->api_shared_secret;
		$signature = sha1($hash);
		$this->rest->http_header('X-Request-Signature', $signature);
		
		// get result, put with info, return
		$result = $this->rest->post($path, $params);
		$info = $this->rest->info();
		$return = array(
			'info' => $info,
			'body' => $result
		);
		return $return;
	}
	
// 	protected function request_OLD($method, $path, $params = array())
// 	{
// 		$path = 'api/v1/' . $path;
// 		
// 		// set curl handler and options
// 		$curl = curl_init($this->api_base_url . $path);
// 		
// 		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
// 		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
// 		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
// 
// 		// set required headers
// 		$headers = array();
// 		$headers[] = 'User-Agent: Bookymark Application';
// 		$headers[] = 'Accept: application/json; version=v1';
// 		$headers[] = 'X-Access-Token: ' . $this->api_access_token;
// 
// 		$timestamp = time();
// 		$headers[] = 'X-Request-Timestamp: ' . $timestamp;
// 
// 		// build signature and set header
// 		$hash = $path . http_build_query($params);
// 		$hash .= $timestamp . $this->api_shared_secret;
// 		$signature = sha1($hash);
// 		$headers[] = 'X-Request-Signature: ' . $signature;
// 
// 		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
// 		// execute and return
// 		$result = curl_exec($curl);
// 		$info = curl_getinfo($curl);
// 		
// 		$return = array(
// 			'info' => $info,
// 			'body' => json_decode($result)
// 		);
// 		
// 		return $return;
// 	}
}
/* End of file api_test.php */
/* Location: ./application/controllers/api_test.php */