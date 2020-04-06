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
			$payment_mode = ($ord['order_type']==1)?'Prepaid':'COD';

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
      

}

?>