<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead_order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_model');
		$this->load->model('Lead_order_model');
	}

	public function verify()
	{
		$res_arr = $_GET;
		if (is_array($res_arr) && count($res_arr) > 0) {

			$rz_payment_id = $res_arr['razorpay_payment_id'];
			$rz_invoice_id = $res_arr['razorpay_invoice_id'];
			$rz_invoice_status = $res_arr['razorpay_invoice_status'];
			$rz_invoice_receipt = $res_arr['razorpay_invoice_receipt'];
			$rz_signature = $res_arr['razorpay_signature'];

			// Get the lead info based on receipt no
			$lead_info = $this->Lead_model->get_lead_by_receipt($rz_invoice_receipt);
			if (is_array($lead_info) && count($lead_info) > 0) {

				$lead_id = $lead_info[0]['lead_id'];

				// Update lead table
				$up_arr = array('payment_status' => 1);
				$this->Lead_model->update_lead($up_arr, $lead_id);

				// Insert payment details
				$insert_arr = array(
					'lead_id' => $lead_id,
					'rzpy_payment_id' => $rz_payment_id,
					'rzpy_invoice_id' => $rz_invoice_id,
					'rzpy_invoice_status' => $rz_invoice_status,
					'rzpy_invoice_receipt' => $rz_invoice_receipt,
					'rzpy_signature' => $rz_signature,
					'created_on' => date('Y-m-d G:i:s'),
				);
				$payment_id = $this->Lead_model->insert_payment_details($insert_arr);

				if ($payment_id) {

					// Push lead to lastmile
					$this->push_order($lead_id);

					// Show success screen
					//$this->load->view('success');
				}
			}
		}
	}

	public function push_order($lead_id){
		$id = $lead_id;
		$order_list = $this->Lead_order_model->get_lead($id);
		$vendor_id='3';
		$delivery_to=2; //Customer
		$payment_mode='Prepaid';
		$time = date('Y-m-d h:m:s');
		$lmdp="bb_monish";
		$otp = '';
		$urn = '';
		$loanrefno='';
		$data=array();

		foreach($order_list as $ord ){
			$leadid= $ord['lead_id'];
			$orderid= $ord['rpay_order_id'];
			$shipmentid= $ord['receipt_no'];
			$hsty['ad_id'] = $vendor_id;
			$hsty['status_from']="3pl";
			$lmp_id = $ord['lmp_id'];
			$referenceNumber= $orderid.'-'.$shipmentid;
			$lmdp = $this->Lead_order_model->get_lmp($lmp_id);
			$trans_check = $this->Lead_order_model->chk_transaction($referenceNumber);
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
							//'to_be_delivered_by' => $ord['to_be_delivered_by'],
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
				$data = $this->security->xss_clean($data);
				$trans_id = $this->Lead_order_model->add_transaction($data);
				
				if($trans_id){
					$item_list   = $this->Lead_order_model->get_lead_item($leadid);
					//print_r($item_list);
					foreach($item_list as $item){
						$amount=$item['item_price'];
						$quantity=$item['item_qty'];
						$itemdata = array(
								'id' => '',
								'transaction_id' => $trans_id,
								'sku' => $item['item_id'],
								'name' => $item['item_name'],
								'qty' =>$quantity ,
								'order_item_id' => $item['lead_item_id'],
								'price' => $amount,
								'row_total' => $amount * $quantity,
								'created' => $time,
								);
						 $trans_item_id = $this->Lead_order_model->add_transaction_item($itemdata);
					}
					
				}
				$hsty['status']="Success";
				$hsty['response_json'] = '{"successList":["'.$referenceNumber.'"],"failureList":[],"successCount":1,"code":1,"remarks":"Success"}';
				$hsty['remarks']="Success";
				$hsty['code']="1";
				$this->Lead_order_model->add_receive_history($hsty);
				//echo "Transaction unsuccessful" .$trans_success;
				echo '{"successList":["'.$referenceNumber.'"],"failureList":[],"successCount":1,"code":1,"remarks":"Success"}';
			}
			else{
				$hsty['status']="Failure";
				$hsty['response_json'] = '{"successList":[""],"failureList":["'.$referenceNumber.'"],"successCount":0,"code":0,"remarks":"Duplicate Entry"}';
				$hsty['remarks']="Duplicate Entry";
				$hsty['code']="0";
				$this->Lead_order_model->add_receive_history($hsty);
				//echo "Transaction unsuccessful" .$trans_success;
				echo '{"successList":[""],"failureList":["'.$referenceNumber.'"],"successCount":0,"code":0,"remarks":"Duplicate Entry"}';
			}
		}
		
		//print_r($data); 
		
	}



}
