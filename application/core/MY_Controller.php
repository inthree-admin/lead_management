<?php
	class MY_Controller extends CI_Controller
	{
		function __construct()
		{

			parent::__construct(); 
			$this->load->library('session');
			if(!$this->session->has_userdata('lm_role'))
			{
				redirect('auth/login');
			}
			  
		}
	}
?>

    