<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {

	public function __construct(){
			parent::__construct(); 
	}
	
	public function verify()
	{ 
		echo '<pre>';
		print_r($_GET);
	}

	
}
