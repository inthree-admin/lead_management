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

	public function save_lead()
	{
		$post = $this->input->post();

		if ($post['email'] && $post['phone']) {

			$cust_name = $post['cust_name'];
			$cust_email = $post['email'];
			$cust_phone = $post['phone'];
			$product = $post['product'];
			$prod_price = $post['prod_price']*100;

			$url = 'https://api.razorpay.com/v1/invoices/';
			$key_id = 'rzp_test_WIy9t4y8B55ivj';
			$key_secret = 'zYx0UxiPQ9DdTYH0VWTvCWPj';
			$receipt = 'BB' . time();

			$fields_string = '{
								"customer": {
								"name": "' . $cust_name . '",
								"email": "' . $cust_email . '",
								"contact": "' . $cust_phone . '"
								},
								"type": "link",
								"view_less": 1,
								"amount": '.$prod_price.',
								"currency": "INR",
								"description": "' . $product . '",
								"receipt": "' . $receipt . '",
								"reminder_enable": true,
								"sms_notify": 1,
								"email_notify": 1,
								"expire_by": "",
								"callback_url": "http://testcloud.in3access.in/razorpay/verify.php",
								"callback_method": "get"
							}';

			// Insert into lead table
			$insert_arr = array(
				'cust_name' => $cust_name,
				'cust_email' => $cust_email,
				'cust_phone' => $cust_phone,
				'order_total' => $prod_price,
				'created_on' => date('Y-m-d G:i:s'),
				'created_by' => $this->session->userdata('username'),
				'payment_link_req' => $fields_string,
				'receipt_no' => $receipt
			);

			// echo '<pre>';
			// print_r($insert_arr);
			// exit;

			$this->load->model('Lead_model');
			$lead_id = $this->Lead_model->insert_new_lead($insert_arr);

			//Prepare CURL Request for payment link
			/*$ch = curl_init();
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
				$payment_link_response = $result;
				$res_arr = json_decode($payment_link_response);

				if (isset($res_arr->id)) {
					$payment_link_status = 1;
					$rpay_order_id = $res_arr->order_id;
				} else {
					$payment_link_status = 2;
					$rpay_order_id = '';
				}

				$up_arr = array(
					'payment_link_status' => $payment_link_status,
					'payment_link_response' => $payment_link_response,
					'rpay_order_id' => $rpay_order_id
				);

				$this->Lead_model->update_lead($up_arr, $lead_id);
			}

			if (isset($payment_link_status) && $payment_link_status == 1) {
				$msg = 'Lead generated and Payment Link Send Successfully <br>';
			} else {
				$msg = 'Lead generated and Payment Link failed <br>';
			}*/

			echo 'Lead generated successfully';
			exit;
		}
	}
}
