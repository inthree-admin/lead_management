<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead_order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_model');
	}

	public function verify()
	{
		$res_arr = $_GET;
		$data = array();

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
				$lead_no = $lead_info[0]['lead_no'];

				// Update lead table
				$up_arr = array('payment_status' => 1, 'status' => 3);
				$this->Lead_model->update_lead($up_arr, $lead_id);

				// Insert payment details
				$insert_arr = array(
					'lead_id' => $lead_id,
					'rzpy_payment_id' => $rz_payment_id,
					'rzpy_invoice_id' => $rz_invoice_id,
					'rzpy_invoice_status' => $rz_invoice_status,
					'rzpy_invoice_receipt' => $rz_invoice_receipt,
					'rzpy_signature' => $rz_signature,
					'created_on' => date('Y-m-d G:i:s')
				);
				$payment_id = $this->Lead_model->insert_payment_details($insert_arr);

				if ($payment_id) {

					// Push lead to lastmile
					$params = array('lead_id' => $lead_id);
					$this->load->library('leadlibrary', $params);
					$this->leadlibrary->push_order();

					// Show success screen
					$data['ref_no'] = $lead_no;
					$this->load->view('success', $data);
				}
			}
		}
	}


}
