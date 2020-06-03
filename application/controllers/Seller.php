<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_model');
		$this->load->model('Lead_order_model');
	}

	public function isJSON($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}
	public function update_order_starus()
	{
		$raw_data = file_get_contents("php://input");
		// Insert log table
		$log_data = array('curl_name' => 'change_order_status_from_seller_portal', 'send_data' => $raw_data, 'started_at' => date('Y-m-d h:m:s'));
		$log_id = $this->Lead_order_model->add_log($log_data);

		$response_data = array();
		if (!$this->isJSON($raw_data)) {
			$response_data = array('success' => false, 'message' => 'Invalid JSON');
		} else {
			$data = json_decode($raw_data);
			$seller_order_id = $data->order_id;
			$seller_order_status = $data->order_status;
			$seller_order_history = json_encode($data->order_history);
			$result = $this->Lead_model->getLead(array('seller_order_id' => $seller_order_id));
			if (!($result)) {
				$response_data = array('success' => false, 'message' => 'Invalid order id');
			} else {
				$lead_id = $result->lead_id;
				$up_arr = array(
					'seller_order_status' => $seller_order_status,
					'seller_order_history' => $seller_order_history
				);
				//Update lead table
				$this->Lead_model->update_lead($up_arr, $lead_id);
				$response_data = array('success' => true, 'message' => 'Order status updated successfully');
			}
		}
		// Update log table
		$this->Lead_order_model->update_log(array('response_data' => json_encode($response_data), 'end_at' => date('Y-m-d h:m:s')), $log_id);
		echo json_encode($response_data);
		die;
	}

	public function push_ifmr_order()
	{
		$raw_data = file_get_contents("php://input");
		$log_data = array('curl_name' => 'Order_from_ifmr_app', 'send_data' => $raw_data, 'started_at' => date('Y-m-d h:m:s'));
		$log_id = $this->Lead_order_model->add_log($log_data);

		$resp_data = array();
		if ($this->isJSON($raw_data)) {

			$post = json_decode($raw_data, true);

			if (is_array($post) && count($post) > 0) {

				// Get the form values
				$cust_id 		 	 =	(isset($post['customer']['id'])) ? trim($post['customer']['id']) : '';
				$cust_fname 		 =	(isset($post['customer']['firstname'])) ? trim($post['customer']['firstname']) : '';
				$cust_lname 		 =	(isset($post['customer']['lastname'])) ? trim($post['customer']['lastname']) : '';
				$cust_name			 =	$cust_fname . ' ' . $cust_lname;

				$cust_phone 		 =	(isset($post['customer']['mobileno'])) ? trim($post['customer']['mobileno']) : '';

				$cust_badd1			 =	(isset($post['customer']['address1'])) ? trim($post['customer']['address1']) : '';
				$cust_badd2			 =	(isset($post['customer']['address2'])) ? trim($post['customer']['address2']) : '';
				$billing_address	 = 	$cust_badd1 . ' ' . $cust_badd2;
				$billing_city		 = 	(isset($post['customer']['city'])) ? trim($post['customer']['city']) : '';
				$billing_pincode	 = 	(isset($post['customer']['pincode'])) ? trim($post['customer']['pincode']) : '';
				$billing_contact_no	 = 	(isset($post['customer']['alter_mob'])) ? trim($post['customer']['alter_mob']) : '';

				$cust_sadd1			 =	(isset($post['customer']['ship_address1'])) ? trim($post['customer']['ship_address1']) : '';
				$cust_sadd2			 =	(isset($post['customer']['ship_address2'])) ? trim($post['customer']['ship_address2']) : '';
				$shipping_address	 =	$cust_sadd1 . ' ' . $cust_sadd2;
				$shipping_city		 =	(isset($post['customer']['ship_city'])) ? trim($post['customer']['ship_city']) : '';
				$shipping_pincode	 =	(isset($post['customer']['ship_pincode'])) ? trim($post['customer']['ship_pincode']) : '';
				$shipping_contact_no = 	$cust_phone;
				$payment_type 		 =  2;
				$lead_status 		 =  1;
				$login_id 			 =  1; // !!!!
				$receipt 			 =  'BB' . time();

				if (is_array($post['orders']) && count($post['orders']) > 0) {

					// Build product array
					$products = array();
					foreach ($post['orders'] as $k => $v) {
						$products[$k] = $v['id'];
					}

					// Check all products from the same LMP
					$prod_list = implode(',', $products);
					$lmp_info = $this->Lead_model->get_lmp_info($prod_list);

					if (count($lmp_info) == 1) {

						// Prepre lead data for insert
						$insert_arr = array(
							'cust_name' 		=> $cust_name,
							'cust_phone' 		=> $cust_phone,
							'receipt_no' 		=> $receipt,
							'created_on' 		=> date('Y-m-d G:i:s'),
							'created_by' 		=> $login_id,
							'billing_address'	=> $billing_address,
							'billing_city'		=> $billing_city,
							'billing_pincode'	=> $billing_pincode,
							'billing_contact_no' => $billing_contact_no,
							'cust_id' 			=> $cust_id,
							'shipping_address'	=> $shipping_address,
							'shipping_city'		=> $shipping_city,
							'shipping_pincode'	=> $shipping_pincode,
							'shipping_contact_no' => $shipping_contact_no,
							'lmp_id' 		    => $lmp_info[0]['lmp_id'],
							'payment_type' 		=> $payment_type,
							'status'			=> $lead_status
						);

						// Save lead
						$lead_id = $this->Lead_model->insert_new_lead($insert_arr);
						if ($lead_id) {

							$order_data = array();
							foreach ($post['orders'] as $k => $v) {
								$order_data[$v['id']] = $v['qty'];
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
									'lead_id' 			=> $lead_id,
									'item_name' 		=> $pdata['prod_name'],
									'item_id' 			=> $pdata['prod_id'],
									'item_unit_price' 	=> $price,
									'item_qty' 			=> $qty,
									'item_price' 		=> $subtotal
								);
								array_push($insert_item_arr, $item_arr);
							}

							// Save lead item
							$this->Lead_model->insert_new_lead_items($insert_item_arr);

							// Generate lead number and update to lead table
							$lead_no =  '1' . sprintf("%'.06d", $lead_id);
							$up_arr = array('lead_no' => $lead_no, 'order_total' => $total_amount);
							$this->Lead_model->update_lead($up_arr, $lead_id);

							// Lead generation completed
							$msg = 'Order ID ' . $lead_no . ' generated.';

							$resp_data = array('success' => true, 'msg' => $msg);

						} else {
							$resp_data = array('success' => false, 'msg' => 'Order generation failed');
						}
					} else {
						if (count($lmp_info) == 0) {
							$resp_data = array('success' => false, 'msg' => 'Invalid product. LMP mapping failed');
						}

						if (count($lmp_info) > 1) {
							$resp_data = array('success' => false, 'msg' => 'You cannot select products from multiple LMP');
						}
					}
				} else {
					$resp_data = array('success' => false, 'msg' => 'No product posted');
				}
			} else {
				$resp_data = array('success' => false, 'msg' => 'post data is empty');
			}
		} else {
			$resp_data = array('success' => false, 'message' => 'Invalid JSON data post');
		}

		$this->Lead_order_model->update_log(array('response_data' => json_encode($resp_data), 'end_at' => date('Y-m-d h:m:s')), $log_id);
		echo json_encode($resp_data);
		exit;
		
	}



}
