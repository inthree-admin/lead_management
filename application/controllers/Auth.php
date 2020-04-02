<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$this->load->view('login');
	}

	public function logout()
	{
		$this->load->view('logout');
	}
	
}
