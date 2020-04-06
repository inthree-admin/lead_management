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
		$discription = 'Boonbox Product';
		$order_data = array();
		foreach ($post['product'] as $key => $pid) {
			if(!empty($pid)) {
				if(isset($order_data[$pid])) 
				 	$order_data[$pid] += $post['quantity'][$key];
				 else 
					$order_data[$pid] = $post['quantity'][$key]; 
			} 
		}
		 
		$product_info = $this->Lead_model->get_product_info(array_keys($order_data)); 
		$total_amount = 0;
		$insert_item_arr = array();
		foreach ($product_info as $key => $pdata) {
			  $qty = $order_data[$pdata['prod_id']];
			  $price =  $pdata['prod_price'];
			  $subtotal = $qty * $price;
			  $total_amount = $total_amount + $subtotal;
			  $item_arr = array(
				'lead_id' 			=> 10,	// $lead_id,
				'item_name' 		=> $pdata['prod_name'],
				'item_id' 			=> $pdata['prod_id'],
				'item_unit_price' 	=> $price,
				'item_qty' 			=> $qty,
				'item_price' 		=> $subtotal
			);
			array_push($insert_item_arr, $item_arr);  
		} 
		 
		$cust_name 			= (isset($post['cust_name'])) ? trim($post['cust_name']) : '';
		$cust_email 		= (isset($post['email'])) ? trim($post['email']) : '';
		$cust_phone 		= (isset($post['mobile'])) ? trim($post['mobile']) : ''; 
		$alter_mobile		= (isset($post['alter_mobile'])) ? trim($post['alter_mobile']) : '';
		$billing_address	= (isset($post['billing_address'])) ? trim($post['billing_address']) : '';
		$billing_city		= (isset($post['billing_city'])) ? trim($post['billing_city']) : '';
		$billing_pincode	= (isset($post['billing_pincode'])) ? trim($post['billing_pincode']) : '';
		$billing_contact_no	= (isset($post['billing_contact_no'])) ? trim($post['billing_contact_no']) : '';
		$shipping_address	= (isset($post['shipping_address'])) ? trim($post['shipping_address']) : '';
		$shipping_city		= (isset($post['shipping_city'])) ? trim($post['shipping_city']) : '';
		$shipping_pincode	= (isset($post['shipping_pincode'])) ? trim($post['shipping_pincode']) : '';
		$shipping_contact_no = (isset($post['shipping_contact_no'])) ? trim($post['shipping_contact_no']) : ''; 
		$login_id 			= $this->session->userdata('admin_id'); 
		$receipt = 'BB' . time();
		$fields_string = '{"customer": {
						"name": "' . $cust_name . '",
						"email": "' . $cust_email . '",
						"contact": "' . $cust_phone . '"
						},
						"type": "link",
						"view_less": 1,
						"amount": ' . $total_amount. ',
						"currency": "INR",
						"description": "' . $discription . '",
						"receipt": "' . $receipt . '",
						"reminder_enable": true,
						"sms_notify": 1,
						"email_notify": 1,
						"expire_by": "",
						"callback_url": "http://dev.in3access.in/lead_management/lead_order/verify",
						"callback_method": "get" }';

		/*-------------- Save Lead -------------*/
		$insert_arr = array(
			'cust_name' 		=> $cust_name,
			'cust_email' 		=> $cust_email,
			'cust_phone' 		=> $cust_phone,
			'order_total' 		=> $total_amount,
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
			/*-------------- Save Lead Item -------------*/
			$lead_item_id = $this->Lead_model->insert_new_lead_items($insert_item_arr);
		} 
		if ($lead_id) {

			$msg = 'Lead generated';

			// Send Payment Link
			$url = 'https://api.razorpay.com/v1/invoices/';
			$key_id = 'rzp_test_WIy9t4y8B55ivj';
			$key_secret = 'zYx0UxiPQ9DdTYH0VWTvCWPj';
			$receipt = 'BB' . time();

			//Prepare CURL Request for payment link
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt(
				$ch,
				CURLOPT_HTTPHEADER,
				array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($fields_string)
				)
			);
			$result = curl_exec($ch);

			if ($result) {
				$res_arr = json_decode($result);

				if (isset($res_arr->id)) {
					$payment_link_status = 1;
					$rpay_order_id = $res_arr->order_id;
					$msg .= ' and payment link sent successfully';
				} else {
					$payment_link_status = 2;
					$rpay_order_id = '';
					$msg .= ' and payment link failed';
				}

				$up_arr = array(
					'payment_link_status' => $payment_link_status,
					'payment_link_response' => $result,
					'rpay_order_id' => $rpay_order_id
				);
			} else {

				$up_arr = array(
					'payment_link_status' => 2,
					'payment_link_response' => 'Empty Response',
					'rpay_order_id' => ''
				);

				$msg .= ' and payment link failed';
			}

			$this->Lead_model->update_lead($up_arr, $lead_id);


			echo json_encode(array('success' => true, 'msg' => $msg));
		} else {
			echo json_encode(array('success' => false, 'msg' => 'Lead generation failed'));
		}
	}
	public function list()
	{
		$this->load->view('lead_list');
	}

	public function lead_list()
	{
		$start  = (isset($_GET['start'])) ? $_GET['start'] : '';
		$length  = (isset($_GET['length'])) ? $_GET['length'] : '';
		$searchKey = (isset($_GET['search']['value'])) ? trim($_GET['search']['value']) : '';
		$ordercolumn =  (isset($_GET['order'][0]['column'])) ? $_GET['order'][0]['column'] : 1;
		$ordertype = (isset($_GET['order'][0]['dir'])) ? $_GET['order'][0]['dir'] : ''; //asc or desc  
		$columnArray = array(0 => 'receipt_no', 1 => 'cust_name', 2 => 'cust_email', 3 => 'cust_phone', 4 => 'payment_link_status', 5 => 'payment_status', 6 => 'order_total', 7 => 'created_on');
		$filter_arr = array('start' => $start, 'length' => $length, 'searchKey' => $searchKey, 'ordercolumn' => $columnArray[$ordercolumn], 'ordertype' => $ordertype);
		$result = $this->Lead_model->lead_list($filter_arr);
		$lead_total = $this->Lead_model->lead_total_count(array('searchKey' => $searchKey));
		$returnData = array();
		$returnData['data'] = [];
		foreach ($result as $key => $data) {
			$returnData['data'][$key][0] = $data['receipt_no'];
			$returnData['data'][$key][1] = $data['cust_name'];
			$returnData['data'][$key][2] = $data['cust_email'];
			$returnData['data'][$key][3] = $data['cust_phone'];
			$returnData['data'][$key][4] = $data['payment_link_status'];
			$returnData['data'][$key][5] = $data['payment_status'];
			$returnData['data'][$key][6] = $data['order_total'];
			$returnData['data'][$key][7] = $data['created_on'];
		}
		$returnData['recordsTotal'] = count($result);
		$returnData['recordsFiltered'] = $lead_total['total_lead'];
		echo json_encode($returnData);
	}

	public function load_products(){  
		$product_info = $this->Lead_model->get_product_info('all');
		echo json_encode($product_info);
	}
}
