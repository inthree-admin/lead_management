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

	public function pincode(){
		$pincode = (isset($_GET['q'])) ? trim($_GET['q']) : '';
		if(!is_numeric($pincode)){
			echo json_encode(array('pincode'=>'','district'=>'','state'=>'','country'=>''));
		}else{
			$this->load->library('Commonlib'); 
			$result = $this->commonlib->pincode($pincode);  
			if($result) echo json_encode($result);
			else echo json_encode(array('pincode'=>'','district'=>'','state'=>'','country'=>''));
		} 
	}
	public function city(){
		$city = (isset($_GET['q'])) ? strtolower(trim($_GET['q'])) : '';
		$state = (isset($_GET['state'])) ? strtolower(trim($_GET['state'])) : '';
		if(empty($city)){
			echo json_encode(array('city'=>'','state'=>'','country'=>''));
			return true;
		}
		$this->load->library('Commonlib'); 
		if($city == 'all') {
			$result = $this->commonlib->city('',$state);  
			echo json_encode($result);
		}else{			
			$result = $this->commonlib->city($city,$state);  
			if($result) echo json_encode($result);
			else echo json_encode(array('city'=>'','state'=>'','country'=>''));
		} 
	} 
	public function state(){
		$state = (isset($_GET['q'])) ? strtolower(trim($_GET['q'])) : '';
		$country = (isset($_GET['country'])) ? strtolower(trim($_GET['country'])) : '';
		if(empty($state)){
			echo json_encode(array('state'=>'','country'=>''));
			return true;
		}
		$this->load->library('Commonlib'); 
		if($state == 'all') {
			$result = $this->commonlib->state('',$country);  
			echo json_encode($result);
		}else{			
			$result = $this->commonlib->state($state,$country);  
			if($result) echo json_encode($result);
			else echo json_encode(array('state'=>'','country'=>''));
		} 
	} 

}
