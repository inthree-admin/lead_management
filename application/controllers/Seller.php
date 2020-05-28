<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

    public function __construct() {
      	parent::__construct();
      	$this->load->model('Lead_model');
      	$this->load->model('Lead_order_model');
    } 

 	public function isJSON($string){
	    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}
    public function update_order_starus(){
    		$raw_data = file_get_contents("php://input"); 
    		// Insert log table
    		$log_data = array('curl_name' => 'change_order_status_from_seller_portal','send_data'=> $raw_data,'started_at'=> date('Y-m-d h:m:s'));
    		$log_id = $this->Lead_order_model->add_log($log_data); 
			$response_data = array();
			if(!$this->isJSON($raw_data)){
			 	 $response_data = array('success' => false, 'message'=> 'Invalid JSON' );
			 }else{
			 	 $data = json_decode($raw_data);
			 	 $seller_order_id = $data->order_id;
			 	 $seller_order_status = $data->order_status;
			 	 $seller_order_history = json_encode($data->order_history); 
			 	 $result = $this->Lead_model->getLead(array('seller_order_id'=>$seller_order_id));
			 	 if(!($result)) {
			 	 	$response_data = array('success' => false, 'message'=> 'Invalid order id' );
			 	 }else{
			 	 	$lead_id = $result->lead_id;
			 	 	$up_arr = array(
			 	 		'seller_order_status' => $seller_order_status,
			 	 		'seller_order_history' => $seller_order_history
			 	 	);
			 	 	//Update lead table
			 	 	$this->Lead_model->update_lead($up_arr, $lead_id);  
			 	 	$response_data = array('success' => true, 'message'=> 'Order status updated successfully' );
			 	 }
			 	 	
			 }
		// Update log table
		$this->Lead_order_model->update_log(array('response_data'=> json_encode($response_data),'end_at'=> date('Y-m-d h:m:s')),$log_id);
		echo json_encode($response_data); die;
    }

    
         
    }
