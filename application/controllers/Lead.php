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
		$this->load->view('lead_create');
	}

	public function save_lead()
	{
		$post = $this->input->post();

		if (is_array($post) && count($post) > 0) {

			// Get the form values
			$cust_name 			= (isset($post['cust_name'])) ? trim($post['cust_name']) : '';
			$cust_email 		= (isset($post['email'])) ? trim($post['email']) : '';
			$cust_phone 		= (isset($post['mobile'])) ? trim($post['mobile']) : '';
			$billing_address	= (isset($post['billing_address'])) ? trim($post['billing_address']) : '';
			$billing_city		= (isset($post['billing_city'])) ? trim($post['billing_city']) : '';
			$billing_pincode	= (isset($post['billing_pincode'])) ? trim($post['billing_pincode']) : '';
			$billing_contact_no	= (isset($post['billing_contact_no'])) ? trim($post['billing_contact_no']) : '';
			$cust_id			= (isset($post['customer_id'])) ? trim($post['customer_id']) : '';
			$lrn_no				= (isset($post['lrn'])) ? trim($post['lrn']) : '';
			$shipping_address	= (isset($post['shipping_address'])) ? trim($post['shipping_address']) : '';
			$shipping_city		= (isset($post['shipping_city'])) ? trim($post['shipping_city']) : '';
			$shipping_pincode	= (isset($post['shipping_pincode'])) ? trim($post['shipping_pincode']) : '';
			$shipping_contact_no = (isset($post['shipping_contact_no'])) ? trim($post['shipping_contact_no']) : '';
			$payment_type 		= (isset($post['payment_type'])) ? trim($post['payment_type']) : '';
			$lmp_id 			= (isset($post['lmp_id']) && $post['lmp_id']!='') ? $post['lmp_id'] : '';
			$lead_status 		= 1; //($payment_type == 2)?3:1;
			$login_id 			= $this->session->userdata('lm_admin_id');
			$branch_code 		= $this->session->userdata('lm_branch');
			$receipt 			= 'BB' . time();

			// Check all products from the same LMP
			$prod_list = rtrim(implode(',', $post['product']), ',');
			$lmp_info = $this->Lead_model->get_lmp_info($prod_list);

			if (count($lmp_info) == 1) {

				$lmp_id = ($lmp_id)?$lmp_id:$lmp_info[0]['lmp_id'];

				// Prepre lead data for insert
				$insert_arr = array(
					'cust_name' 		=> $cust_name,
					'cust_email' 		=> $cust_email,
					'cust_phone' 		=> $cust_phone,
					'receipt_no' 		=> $receipt,
					'created_on' 		=> date('Y-m-d G:i:s'),
					'created_by' 		=> $login_id,
					'branch_code'		=> $branch_code,
					'billing_address'	=> $billing_address,
					'billing_city'		=> $billing_city,
					'billing_pincode'	=> $billing_pincode,
					'billing_contact_no' => $billing_contact_no,
					'cust_id' 			=> $cust_id,
					'lrn' 				=> $lrn_no,
					'shipping_address'	=> $shipping_address,
					'shipping_city'		=> $shipping_city,
					'shipping_pincode'	=> $shipping_pincode,
					'shipping_contact_no' => $shipping_contact_no,
					'lmp_id' 		    => $lmp_id,
					'payment_type' 		=> $payment_type,
					'status'			=> $lead_status
				);

				// Save lead
				$lead_id = $this->Lead_model->insert_new_lead($insert_arr);
				if ($lead_id) {

					// Group order items 
					$order_data = array();
					foreach ($post['product'] as $key => $pid) {
						if (!empty($pid)) {
							if (isset($order_data[$pid]))
								$order_data[$pid] += $post['quantity'][$key];
							else
								$order_data[$pid] = $post['quantity'][$key];
						}
					}

					// Prepare order item 
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
					$msg = 'Lead ID '.$lead_no.' generated.';

					// Send details to payment gateway for prepaid orders
					/*if ($payment_type == 1) {

					$tot_amount_paisa = $total_amount * 100;
					$discription = 'Boonbox Product';

					$fields_string = '{"customer": {
					"name": "' . $cust_name . '",
					"email": "' . $cust_email . '",
					"contact": "' . $cust_phone . '"
					},
					"type": "link",
					"view_less": 1,
					"amount": ' . $tot_amount_paisa . ',
					"currency": "INR",
					"description": "' . $discription . '",
					"receipt": "' . $receipt . '",
					"reminder_enable": true,
					"sms_notify": 1,
					"email_notify": 1,
					"expire_by": "",
					"callback_url": "http://dev.in3access.in/lead_management/lead_order/verify",
					"callback_method": "get" }';

					// Send Payment Link
					$url = 'https://api.razorpay.com/v1/invoices/';
					$key_id = 'rzp_test_WIy9t4y8B55ivj';
					$key_secret = 'zYx0UxiPQ9DdTYH0VWTvCWPj';

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

					// Check the curl response
					if ($result) {
						$res_arr = json_decode($result);

						if (isset($res_arr->id)) {
							$payment_link_status = 1;
							$rpay_inv_id = $res_arr->id;
							$msg .= ' and payment link sent successfully';
						} else {
							$payment_link_status = 2;
							$rpay_inv_id = '';
							$msg .= ' and payment link failed';
						}

						$up_arr = array(
							'payment_link_req' => $fields_string,
							'payment_link_status' => $payment_link_status,
							'payment_link_response' => $result,
							'rpay_inv_id' => $rpay_inv_id
						);
					} else {

						$up_arr = array(
							'payment_link_req' => $fields_string,
							'payment_link_status' => 2,
							'payment_link_response' => 'Empty Response',
							'rpay_inv_id' => ''
						);

						$msg .= ' and payment link failed';
					}

					$this->Lead_model->update_lead($up_arr, $lead_id);
				}


				// Push orders to lastmile for COD Orders
				if ($payment_type == 2) {
					$params = array('lead_id' => $lead_id);
					$this->load->library('leadlibrary', $params);
					$this->leadlibrary->push_order();
					$msg .= " and order pushed to lastmile";
				}*/

					echo json_encode(array('success' => true, 'msg' => $msg));
				} else {

					echo json_encode(array('success' => false, 'msg' => 'Lead generation failed'));
				}
			} else {

				echo json_encode(array('success' => false, 'msg' => 'You cannot select products from multiple LMP'));
			}
		}
	}

	public function list()
	{
		$this->load->view('lead_list');
	}

	public function lead_list()
	{
	
		$role = $this->session->userdata('lm_role');
		$user_id = $this->session->userdata('lm_admin_id');
		$start  = (isset($_GET['start'])) ? $_GET['start'] : '';
		$length  = (isset($_GET['length'])) ? $_GET['length'] : '';
		$searchKey = (isset($_GET['search']['value'])) ? trim($_GET['search']['value']) : '';
		$ordercolumn =  (isset($_GET['order'][0]['column'])) ? $_GET['order'][0]['column'] : 1;
		$ordertype = (isset($_GET['order'][0]['dir'])) ? $_GET['order'][0]['dir'] : ''; //asc or desc  
		$fltr_status = ($_GET['fltr_status'])?$_GET['fltr_status']:'';
		$from_date = (isset($_GET['from_date']) AND !empty($_GET['from_date'])) ? $_GET['from_date'] : date('Y-m-d');
		$to_date = (isset($_GET['to_date']) AND !empty($_GET['to_date'])) ? $_GET['to_date'] : date('Y-m-d'); 


		$columnArray = array(
			0 => 'lead_no', 1 => 'cust_name',  2 => 'cust_phone',
			3 => 'firm_name', 4 => 'branchname', 5 => 'order_total',
			6 => 'created_on', 7 => 'lmu_username', 8 => 'approved_on', 9 => 'delivered_on', 10 => 'status'
		);

		$filter_arr = array('start' => $start, 'length' => $length, 'searchKey' => $searchKey, 'ordercolumn' => $columnArray[$ordercolumn], 
		'ordertype' => $ordertype,'from_date' => $from_date,'to_date' => $to_date, 'fltr_status' => $fltr_status);
		if ($role != 1)  $filter_arr['created_by'] = $user_id;

		$result = $this->Lead_model->lead_list($filter_arr);
		$lead_total = $this->Lead_model->lead_total_count($filter_arr);
		$returnData = array();
		$returnData['data'] = [];
		foreach ($result as $key => $data) {
			$returnData['data'][$key][0] = '<a href="' . base_url() . 'order_history/get_history?id=' . $data['lead_no'] . '">' . $data['lead_no'] . '</a>';
			$returnData['data'][$key][1] = $data['cust_name'];
			$returnData['data'][$key][2] = $data['cust_phone'];
			$returnData['data'][$key][3] = $data['firm_name'];
			$returnData['data'][$key][4] = $data['branchname'];
			$returnData['data'][$key][5] = $data['order_total'];
			$returnData['data'][$key][6] = $data['created_on'];
			$returnData['data'][$key][7] = ucfirst($data['lmu_username']);
			$returnData['data'][$key][8] = $data['approved_on'];
			$returnData['data'][$key][9] = $data['delivered_on'];
			$returnData['data'][$key][10] = $data['status'];

			$actionbtn = '-';
			if ($data['status'] == 'Waiting For Approval')
				$actionbtn = '<i class="fa fa-fw fa-thumbs-o-up fa-lg actions_icon" title="Approve" onclick="approveLead(' . $data['lead_id'] . ')"></i>&nbsp&nbsp<i class="fa fa-fw ti-close text-danger actions_icon" title="Cancel" onclick="cancelLead(' . $data['lead_id'] . ')"></i>';
			//$actionbtn = '<button class="btn btn-primary btn-xs" onclick="cancelLead('.$data['lead_id'].')">Cancel</button>';
			if ($role == 1) $returnData['data'][$key][11] = $actionbtn;
		}
		$returnData['recordsTotal'] = count($result);
		$returnData['recordsFiltered'] = $lead_total['total_lead'];

		// echo '<pre>';
		// print_r($returnData);
		// exit;

		echo json_encode($returnData);
	}

	public function load_products()
	{
		$product_info = $this->Lead_model->get_product_info('all');
		echo json_encode($product_info);
	}

	/*public function change_status()
	{
		$post = $this->input->post();
		$lead_id = (isset($post['lead_id'])) ? $post['lead_id'] : 0;
		$status = (isset($post['status'])) ? $post['status'] : 0;
		if (empty($lead_id) or empty($status)) {
			echo json_encode(array('success' => false, 'msg' => 'Something went wrong'));
		}
		if (!empty($lead_id) and !empty($status)) {

			$lead_info = $this->Lead_model->get_lead_by_lead_id($lead_id);
			if (is_array($lead_info) && count($lead_info) > 0) {

				$payment_type = $lead_info[0]['payment_type'];
				$paid_status = $lead_info[0]['payment_status'];
			
				if ($payment_type == 1) { // only prepaid

					if ($paid_status == 0) { // only paid 

						$rpay_inv_id = $lead_info[0]['rpay_inv_id'];

						// Cancel Payment Link
						$url = 'https://api.razorpay.com/v1/invoices/' . $rpay_inv_id . '/cancel';
						$key_id = 'rzp_test_WIy9t4y8B55ivj';
						$key_secret = 'zYx0UxiPQ9DdTYH0VWTvCWPj';
						$fields_string = '';

						//Prepare CURL Request for cancel payment link
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

						$username = $this->session->userdata('lm_username');
						$up_arr = array('status' => 2, 'payment_link_status' => 3, 'modified_on' => date('Y-m-d G:i:s'), 'modified_by' => $username);
						$result = $this->Lead_model->update_lead($up_arr, $lead_id);
						if ($result) {
							echo json_encode(array('success' => true, 'msg' => 'Lead Canceled Successfully'));
							return true;
						} else {
							echo json_encode(array('success' => false, 'msg' => 'Failed to Lead Cancel'));
							return true;
						}
					} else {
						echo json_encode(array('success' => false, 'msg' => 'Order cancellation failed. Customer already paid'));
						return true;
					}
				} else {
					echo json_encode(array('success' => false, 'msg' => 'Order cancellation failed. Its a COD order and already pushed to lastmile.'));
					return true;
				}
			}
		}
	}*/

	public function approve_lead()
	{
		$post = $this->input->post();
		$lead_id = (isset($post['lead_id'])) ? $post['lead_id'] : 0;
		$status = (isset($post['status'])) ? $post['status'] : 0;
		$reason = (isset($post['reason'])) ? $post['reason'] : '';
		if (empty($lead_id) or empty($status)) {
			echo json_encode(array('success' => false, 'msg' => 'Something went wrong'));
		}
		if (!empty($lead_id) and !empty($status)) {

			$lead_info = $this->Lead_model->get_lead_by_lead_id($lead_id);
			if (is_array($lead_info) && count($lead_info) > 0) {

				$approval_status = $lead_info[0]['approval_status'];

				if ($approval_status == 1) { // waiting for approval

					$username = $this->session->userdata('lm_username');
					$up_arr = array('approval_status' => $status, 'modified_on' => date('Y-m-d G:i:s'), 'modified_by' => $username);
					if(!empty($reason)) $up_arr['cancel_reason'] = $reason;
					$result = $this->Lead_model->update_lead($up_arr, $lead_id);
					if ($result) {

						if ($status == 2) {
							// Push orders to lastmile
							$params = array('lead_id' => $lead_id);
							$this->load->library('leadlibrary', $params);
							$this->leadlibrary->push_order();

							// Push order to Seller portal
							// $params = array('lead_id' => $lead_id);
							// $this->load->library('leadlibrary', $params);
							// $this->leadlibrary->push_seller_portal();
							$msg = 'Lead Approved Successfully';
						}

						if ($status == 3) {
							$msg = 'Lead Cancelled Successfully';
						}

						echo json_encode(array('success' => true, 'msg' => $msg));
						return true;
					} else {
						echo json_encode(array('success' => false, 'msg' => 'Action Failed'));
						return true;
					}
				} else {
					echo json_encode(array('success' => false, 'msg' => 'Lead already approved.'));
					return true;
				}
			}
		}
	}


	public function download()
	{
		$role = $this->session->userdata('lm_role');
		$user_id = $this->session->userdata('lm_admin_id');
		$q = (isset($_GET['q'])) ? $_GET['q'] : '';
		$from_date = (isset($_GET['from_date'])) ? $_GET['from_date'] : '';
		$to_date = (isset($_GET['to_date'])) ? $_GET['to_date'] : '';
		$fltr_status = (isset($_GET['fltr_status'])) ? $_GET['fltr_status'] : '';
		$filter_arr = array('searchKey' => $q, 'ordercolumn' => 'created_on', 'from_date' => $from_date,'to_date' => $to_date,'fltr_status'=>$fltr_status,'ordertype' => 'DESC');
		if ($role != 1)  $filter_arr['created_by'] = $user_id;
		$result = $this->Lead_model->lead_list($filter_arr);
		header("Content-Disposition: attachment; filename=\"lead_list_" . time() . ".xls\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		$handle = fopen("php://output", 'w');
		$header =  array(
			0 => 'Order#',
			1 => 'Name',
			2 => 'Phone',
			3 => 'LMP',
			4 => 'Branch',
			5 => 'Amount',
			6 => 'Created On',
			7 => 'Created By',
			8 => 'Approved On',
			9 => 'Delivered On',
			10 => 'Status'
		);
		fputcsv($handle,  $header, "\t");
		foreach ($result as $key => $info) {
			$data =  array(
				0 => $info['lead_no'],
				1 => $info['cust_name'],
				2 => $info['cust_phone'],
				3 => $info['firm_name'],
				4 => $info['branchname'],
				5 => $info['order_total'],
				6 => $info['created_on'],
				7 => $info['lmu_username'],
				8 => $info['approved_on'],
				9 => $info['delivered_on'],
				10 => $info['status']
			);
			fputcsv($handle, $data, "\t");
		}
		fclose($handle);
	}
	
}
