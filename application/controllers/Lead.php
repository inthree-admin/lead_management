<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_model');
	}

	public function index()
	{
		$this->load->view('lead_view');
	}

	public function save_lead()
	{
		$post = $this->input->post();
		$cust_name 			= (isset($post['cust_name'])) ? trim($post['cust_name']) : '';
		$cust_email 		= (isset($post['email'])) ? trim($post['email']) : '';
		$cust_phone 		= (isset($post['mobile'])) ? trim($post['mobile']) : '';
		$product_id			= (isset($post['product'])) ? trim($post['product']) : '';
		$alter_mobile		= (isset($post['alter_mobile'])) ? trim($post['alter_mobile']) : '';
		$billing_address	= (isset($post['billing_address'])) ? trim($post['billing_address']) : '';
		$billing_city		= (isset($post['billing_city'])) ? trim($post['billing_city']) : '';
		$billing_pincode	= (isset($post['billing_pincode'])) ? trim($post['billing_pincode']) : '';
		$billing_contact_no	= (isset($post['billing_contact_no'])) ? trim($post['billing_contact_no']) : '';
		$shipping_address	= (isset($post['shipping_address'])) ? trim($post['shipping_address']) : '';
		$shipping_city		= (isset($post['shipping_city'])) ? trim($post['shipping_city']) : '';
		$shipping_pincode	= (isset($post['shipping_pincode'])) ? trim($post['shipping_pincode']) : '';
		$shipping_contact_no = (isset($post['shipping_contact_no'])) ? trim($post['shipping_contact_no']) : '';
		$quantity			= (isset($post['quantity'])) ? trim($post['quantity']) : '';
		$login_id 			= $this->session->userdata('admin_id');
		 
		//-------------- Get Product Info-------------//
		$product_info = $this->Lead_model->get_product_info($product_id);
		$item_id = $product_info['prod_id'];
		$item_name = $product_info['prod_name'];
		$item_unit_price = $product_info['prod_price'];
		$prod_price = $item_unit_price * (int) $quantity;

		$receipt = 'BB' . time();
		$fields_string = '{"customer": {
						"name": "' . $cust_name . '",
						"email": "' . $cust_email . '",
						"contact": "' . $cust_phone . '"
						},
						"type": "link",
						"view_less": 1,
						"amount": ' . $prod_price . ',
						"currency": "INR",
						"description": "' . $item_name . '",
						"receipt": "' . $receipt . '",
						"reminder_enable": true,
						"sms_notify": 1,
						"email_notify": 1,
						"expire_by": "",
						"callback_url": "http://testcloud.in3access.in/razorpay/verify.php",
						"callback_method": "get" }';
		//-------------- Save Lead -------------//
		$insert_arr = array(
			'cust_name' 		=> $cust_name,
			'cust_email' 		=> $cust_email,
			'cust_phone' 		=> $cust_phone,
			'order_total' 		=> $prod_price,
			'created_on' 		=> date('Y-m-d G:i:s'),
			'created_by' 		=> $this->session->userdata('username'),
			'payment_link_req' 	=> $fields_string,
			'receipt_no' 		=> $receipt,
			'billing_address'	=> $billing_address,
			'billing_city'		=> $billing_city,
			'billing_pincode'	=> $billing_pincode,
			'billing_contact_no' => $billing_contact_no,
			'shipping_address'	=> $shipping_address,
			'shipping_city'		=> $shipping_city,
			'shipping_pincode'	=> $shipping_pincode,
			'shipping_contact_no' => $shipping_contact_no,
			'lmp_id' 		    => $login_id,
		);
		$lead_id = $this->Lead_model->insert_new_lead($insert_arr);
		if ($lead_id) {
			$insert_item_arr = array(
				'lead_id' 			=> $lead_id,
				'item_name' 		=> $item_name,
				'item_id' 			=> $item_id,
				'item_unit_price' 	=> $item_unit_price,
				'item_qty' 			=> $quantity,
				'item_price' 		=> $prod_price
			);
			$lead_item_id = $this->Lead_model->insert_new_lead_items($insert_item_arr);
		}
		if($lead_id){
			echo json_encode(array('success'=>true,'msg'=>'Lead generated successfully'));
		}else{
			echo json_encode(array('success'=>false,'msg'=>'Failed to generate lead'));
		}
	}
}
