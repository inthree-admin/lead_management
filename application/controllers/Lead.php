<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		 $this->load->view('lead_view');
	}

	 

}
