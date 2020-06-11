<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leadlibrary { 

	protected $CI;
	protected $lead_id;

    function __construct($params) {

		$this->lead_id = $params['lead_id'];

        //This Context not available here so create new instance below
        $this->CI = & get_instance(); 
        $this->CI->load->model('Lead_model');
		$this->CI->load->model('Lead_order_model');
    } 

    public function push_order(){
		$id = $this->lead_id;
		$order_list = $this->CI->Lead_order_model->get_lead($id);
		$vendor_id = '3';
		$delivery_to = 2; //Customer
		$payment_mode = '';
		$time = date('Y-m-d h:m:s');
		$otp = '';
		$urn = '';
		$loanrefno = '';
		$data = array();
		$res_arr = array();

		foreach($order_list as $ord ){
			
			$leadid= $ord['lead_id'];
			$hsty['ad_id'] = $vendor_id;
			$hsty['status_from']="3pl";
			$payment_mode = ($ord['payment_type']==1)?'Prepaid':'COD';

			$lmp_id = $ord['lmp_id'];
			$orderid= $ord['lead_no'];
			$shipmentid= $ord['receipt_no'];
			$referenceNumber= $orderid.'-'.$shipmentid;

			$lmdp = $this->CI->Lead_order_model->get_lmp($lmp_id);
			$trans_check = $this->CI->Lead_order_model->chk_transaction($referenceNumber);
			if(empty($trans_check)){
			   $data = array(
							'id' => '',
							'reference' => $referenceNumber,
							'ad_id' => $vendor_id,
							'orderid' => $orderid,
							'otp' => $otp,
							'urn' => $urn,
							'loanrefno' => $loanrefno,
							'shipmentid' => $shipmentid,
							'processDefinitionCode' => '3pl',
							'customer_name' => $ord['cust_name'],
							'customer_contact_number' => $ord['cust_phone'],
							'alternate_contact_number' => $ord['cust_phone'],
							'invoice_no' => $leadid,
							'invoice_date' => $ord['created_on'],
							'billing_address' => $ord['billing_address'],
							'billing_city' => $ord['billing_city'],
							'billing_pincode' => $ord['billing_pincode'],
							'billing_telephone' => $ord['billing_contact_no'],
							'shipping_address' => $ord['shipping_address'],
							'shipping_city' => $ord['shipping_city'],
							'shipping_pincode' => $ord['shipping_pincode'],
							'shipping_telephone' => $ord['shipping_contact_no'],
							'delivery_to' => $delivery_to,
							'amount' => $ord['order_total'],
							'payment_mode' => $payment_mode,
							'lmdp' => $lmdp,
							'created_at' => $time
					);

				$data = $this->CI->security->xss_clean($data);

				$trans_id = $this->CI->Lead_order_model->add_transaction($data);
				
				if($trans_id){
					$item_list   = $this->CI->Lead_order_model->get_lead_item($leadid);
					foreach($item_list as $item){
						$amount=$item['item_unit_price'];
						$item_total=$item['item_price'];
						$quantity=$item['item_qty'];
						$itemdata = array(
								'id' => '',
								'transaction_id' => $trans_id,
								'sku' => $item['item_id'],
								'name' => $item['item_name'],
								'qty' =>$quantity ,
								'order_item_id' => $item['lead_item_id'],
								'price' => $amount,
								'row_total' => $item_total,
								'created' => $time,
								);
						 $trans_item_id = $this->CI->Lead_order_model->add_transaction_item($itemdata);
					}
					
				}

				$hsty['status']="Success";
				$hsty['response_json'] = '{"successList":["'.$referenceNumber.'"],"failureList":[],"successCount":1,"code":1,"remarks":"Success"}';
				$hsty['remarks']="Success";
				$hsty['code']="1";
				$this->CI->Lead_order_model->add_receive_history($hsty);
				$res_arr = '{"successList":["'.$referenceNumber.'"],"failureList":[],"successCount":1,"code":1,"remarks":"Success"}';
			}
			else{
				$hsty['status']="Failure";
				$hsty['response_json'] = '{"successList":[""],"failureList":["'.$referenceNumber.'"],"successCount":0,"code":0,"remarks":"Duplicate Entry"}';
				$hsty['remarks']="Duplicate Entry";
				$hsty['code']="0";
				$this->CI->Lead_order_model->add_receive_history($hsty);
				$res_arr = '{"successList":[""],"failureList":["'.$referenceNumber.'"],"successCount":0,"code":0,"remarks":"Duplicate Entry"}';
			}
		}
		
		return $res_arr;
		
	}

	public function push_seller_portal(){
		$id = $this->lead_id;
		$order_list = $this->CI->Lead_order_model->get_lead($id)[0];		
		$item_list   = $this->CI->Lead_order_model->get_lead_item($id);
		$json_data = array('store_code'=>'SVSTPR');
		$json_data['order_value'] = $order_list['order_total'];
		$json_data['billing'] = array(
									'billing_first_name'  => $order_list['cust_name'],
									'billing_middle_name'  => '',
									'billing_last_name'  => $order_list['cust_name'],
									'billing_street_1'  => $order_list['billing_address'],
									'billing_street_2'  => '',
									'billing_city'  => $order_list['billing_city'],
									'billing_state'  => 'Tamil Nadu',
									'billing_country'  => 'India',
									'billing_postalcode'  => $order_list['billing_pincode'],
									'billing_phone'  => $order_list['billing_contact_no'],
									'billing_alt_phone'  => '');
		$json_data['shipping'] = array(
									'shipping_first_name' => $order_list['cust_name'],
									'shipping_middle_name' => '',
									'shipping_last_name' => $order_list['cust_name'],
									'shipping_street_1' => $order_list['shipping_address'],
									'shipping_street_2' => '',
									'shipping_city' => $order_list['shipping_city'],
									'shipping_state' => 'Tamil Nadu',
									'shipping_country' => 'India',
									'shipping_postalcode' => $order_list['shipping_pincode'],
									'shipping_phone' => $order_list['shipping_contact_no'],
									'shipping_alt_phone' => '');
		$json_data['payment_mode'] = 'Online';
		$json_data['payment_details'][0] = array(
									'paid_date' => '',
									'transaction_id' => '',
									'paid_amount' => '');

		foreach ($item_list as $key => $item_data) {
		$json_data['item_details'][$key] = array(
									'brand_name' => $item_data['item_name'],
									'product_sku' => $item_data['item_id'],
									'product_type' => 'simple',
									'product_name' => $item_data['item_name'],
									'qty' => $item_data['item_qty'],
									'unit_price' => $item_data['item_unit_price'],
									'total_price' => $item_data['item_price'],
									'tax_price' => 0);
		}
		 
		$json_data['note'] = '';

		//Save log 
		$post_data = json_encode($json_data);
		$log_data = array('curl_name' => 'push_order_to_seller_portal','send_data'=> $post_data,'started_at'=> date('Y-m-d h:m:s'));
		$log_id = $this->CI->Lead_order_model->add_log($log_data);

		//Send data 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json","token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkb21haW4iOiJsYXN0bWlsZS5jb20iLCJjbGllbnRuYW1lIjoibGFzdG1pbGUiLCJwbGF0Zm9ybSI6ImFwaSIsInRva2VuX2NyZWF0ZWQiOiIyMDIwLTA0LTA3IDEyOjQ2OjMzIn0.TkOxjKimN_UFR7P2bwjlivkVRSNSjX_wEop1-EqA01o"));
		curl_setopt($curl, CURLOPT_URL, 'http://dev.in3access.in/in3pos/client/newOrder');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$result = curl_exec($curl);

		if(!$result){ $result = "Connection Failure"; }
		curl_close($curl);		

		//Update end time in log table
		$this->CI->Lead_order_model->update_log(array('response_data'=> $result,'end_at'=> date('Y-m-d h:m:s')),$log_id);

		if($result) {
			// update order id
			$res_arr = json_decode($result);
			$seller_order_id = $res_arr->order_id;
		
			$this->CI->Lead_model->update_lead(array('seller_order_id'=>$seller_order_id),$id);

		}

		return true;
		

	}
    
	public function push_abayomi_portal(){
		$id = $this->lead_id;
		$order_list = $this->CI->Lead_order_model->get_lead($id)[0];		
		$item_list   = $this->CI->Lead_order_model->get_lead_item($id);
		$json_data = array();
		$json_data['order_id'] 					= $order_list['lead_no'];
		$json_data['order_date'] 				= $order_list['created_on'];
		$json_data['approved_date'] 			= $order_list['modified_on'];
		$json_data['approved_by'] 				= $order_list['modified_by'];
		$json_data['order_status'] 				= $order_list['status'];
		$json_data['order_store'] 				= '-';
		$json_data['order_value'] 				= $order_list['order_total'];
		$json_data['payment_mode'] 				= ($order_list['payment_type'] == 1) ? 'Prepaid':'cashondelivery';
		$json_data['delivery_to'] 				= 'Customer';
		$json_data['is_precalling_required'] 	= 0;
		$json_data['is_datacorrection_required']= 0;
		$json_data['is_deliveryconfirmation_required'] = 0;
		$json_data['is_democonfirmation_required'] = 0;
		$json_data['oh_details'][] = array('oh_msg'=>'Order Placed','oh_action_at'=> $order_list['created_on']); 
		$json_data['billing'] = array(
									'billing_first_name'  => $order_list['cust_name'],
									'billing_middle_name'  => '',
									'billing_last_name'  => '-',
									'billing_street_1'  => $order_list['billing_address'],
									'billing_street_2'  => '',
									'billing_city'  => $order_list['billing_city'],
									'billing_state'  => 'Tamil Nadu',
									'billing_country'  => 'India',
									'billing_postalcode'  => $order_list['billing_pincode'],
									'billing_phone'  => $order_list['billing_contact_no'],
									'billing_alt_phone'  => $order_list['billing_contact_no']);
		$json_data['shipping'] = array(
									'shipping_first_name' => $order_list['cust_name'],
									'shipping_middle_name' => '',
									'shipping_last_name' => '-',
									'shipping_street_1' => $order_list['shipping_address'],
									'shipping_street_2' => '',
									'shipping_city' => $order_list['shipping_city'],
									'shipping_state' => 'Tamil Nadu',
									'shipping_country' => 'India',
									'shipping_postalcode' => $order_list['shipping_pincode'],
									'shipping_phone' => $order_list['shipping_contact_no'],
									'shipping_alt_phone' => $order_list['shipping_contact_no']);
		//branch details
		if(isset($order_list['branch_code']) AND !empty($order_list['branch_code'])){
			$branch_info = $this->CI->Lead_order_model->get_branch($order_list['branch_code']); 
			$json_data['branch'] = array('branch_code' => $branch_info['code'],
									'branch_name' => $branch_info['name'],
									'branch_contact_no' => $branch_info['contactno'],
									'branch_contact_alt' => $branch_info['contactno'],
									'poc_name' => 'NA',
									'poc_contact_no' => $branch_info['contactno'],
									'poc_contact_alt' => $branch_info['contactno']);	
		}else{
			$json_data['branch'] = array('branch_code' => '',
									'branch_name' => '',
									'branch_contact_no' => '',
									'branch_contact_alt' => '',
									'poc_name' => '',
									'poc_contact_no' => '',
									'poc_contact_alt' => '');	
		}

		//LMP details
		if(isset($order_list['lmp_id']) AND !empty($order_list['lmp_id'])){
			$lmp_info = $this->CI->Lead_order_model->get_lmp_info($order_list['lmp_id']); 
			$json_data['LMP']	= array('lmp_firm_name'=> $lmp_info['firm_name'],
								   	'lmp_owner_name'=> $lmp_info['owner_name'],
								    'lmp_owner_number'=> $lmp_info['owner_mbl'],
								    'lmp_owner_email'=> $lmp_info['email'],
								    'lmp_address'=> $lmp_info['address'],
								    'lmp_city'=> $lmp_info['lp_city'],
								    'lp_state'=> $lmp_info['lp_state'],
								    'lmp_pincode'=> $lmp_info['lp_postalcode'],
								    'lmp_spoc_name'=> $lmp_info['spoc_name'],
								    'lmp_spoc_contact_number'=> $lmp_info['spoc_mbl'],
								    'lmp_landline'=> $lmp_info['land_line']);
		}else{
			$json_data['LMP']	= array('lmp_firm_name'=> '',
								   	'lmp_owner_name'=> '',
								    'lmp_owner_number'=> '',
								    'lmp_owner_email'=> '',
								    'lmp_address'=> '',
								    'lmp_city'=> '',
								    'lp_state'=> '',
								    'lmp_pincode'=> '',
								    'lmp_spoc_name'=> '',
								    'lmp_spoc_contact_number'=> '',
								    'lmp_landline'=> '');
		}
		
		foreach ($item_list as $key => $item_data) {
		$json_data['item_details'][$key] = array(
									'brand_name' => $item_data['item_name'],
									'model_number' => '',
									'product_sku' => $item_data['item_id'],									
									'product_name' => $item_data['item_name'],
									'product_type' => 'simple',
									'qty' => $item_data['item_qty'],
									'unit_price' => $item_data['item_unit_price'],
									'total_price' => $item_data['item_price'],
									'tax_price' => 0,
									'item_status' => '',
									'is_gift' => '0',
									'is_demo' => '1',
									'imei_number' => ''	); 

		}
		$post_data['data'] = $json_data; 
		//Save log 
		$post_data = json_encode($post_data);
		$log_data = array('curl_name' => 'push_order_to_abayomi_portal','send_data'=> $post_data,'started_at'=> date('Y-m-d h:m:s'));
		$log_id = $this->CI->Lead_order_model->add_log($log_data); 

		//Send data 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($curl, CURLOPT_URL, 'http://dev.in3access.in/in3crm/boonbox/api/Order?key=M0TyL1LO7H2o1rJyDamFZAowazlO4Ck8');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$result = curl_exec($curl);

		if(!$result){ $result = "Connection Failure"; }
		curl_close($curl);		

		//Update end time in log table
		$this->CI->Lead_order_model->update_log(array('response_data'=> $result,'end_at'=> date('Y-m-d h:m:s')),$log_id);
		 
	}


}
