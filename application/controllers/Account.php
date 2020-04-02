<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function signup()
	{
		$this->load->view('account/register');
	}

	public function lockscreen()
	{
		$this->load->view('account/lockscreen');
	}

	public function forgotpass()
	{
		$this->load->view('account/forgot_password');
	}

	public function resetpass()
	{
		$this->load->view('account/reset_password');
	}

}
