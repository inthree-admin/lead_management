<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
			parent::__construct(); 
	}
	
	public function index()
	{ 
		$this->load->view('index');
	}

	public function home()
	{ 
		$this->load->view('home');
	}

	public function blank()
	{ 
		$this->load->view('blank');
	}
	
}
