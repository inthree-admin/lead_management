<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_history extends MY_Controller {

	public function __construct(){
			parent::__construct(); 
            $this->load->model('order_history_model', 'history_model');
	}
	
	public function get_history()
	{ 
        $id =$_GET['id'];
        if(isset($id))
        {
            $data['history_tran'] =  $this->history_model->get_hstry_transaction($id);
            if(count($data['history_tran'])==0){
                    $this->load->model('lead_model', 'lead_model');
                    $data['lead_info'] =  $this->lead_model->lead_info($id);
                    $data['view']      = 'lead_show';                    
                    $this->load->view('lead_show',$data);

            }else{
                $shipmentid=$data['history_tran'][0]['shipmentid'];
			    $data['partial_deli_confirm'] =  $this->history_model->get_deli_confirm_transaction($data['history_tran'][0]['reference']);  //partial delivery details
                $t_id=$data['history_tran'][0]['transaction_id'];
				$data['prdthistory'] =  $this->history_model->get_hstry_tranitm($t_id);
                $data['getHoldStatus']= $this->history_model->getHoldOrderValidate($id);
				$data['delhistory'] =  $this->history_model->get_hstry_delivry($t_id);
				$data['undelhistory'] =  $this->history_model->get_hstry_undelivry($t_id);
				$data['runnerhistory'] =  $this->history_model->get_hstry_runner($t_id);
                $data['fullhistory'] =  $this->history_model->get_order_history($t_id);
                $data['is_avail_rto_his'] =  $this->history_model->get_hstry_rto_is_avail($id);
                 $data['view']           = 'order_view';
             $this->load->view('order_view', $data);
            }
           
					

            
        }
	}

	
}
