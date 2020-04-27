<?php
	class Order_history_model extends CI_Model{

        public function get_hstry_transaction($id) {
            $this->db->query("SET SESSION sql_mode=''");
            $loginname = $this->session->userdata('lm_name');
            $role = $this->session->userdata('lm_role');
            $this->db->select('*,DATE_FORMAT(tran.created_at,"%d-%m-%Y") as created_at,DATE_FORMAT(tran.received_at,"%d-%m-%Y") as received_at,DATE_FORMAT(tran.assigned_at,"%d-%m-%Y") as assigned_at,ld.owner_name as lmdp,
            if(tran.received_at="0000-00-00 00:00:00",tran.created_at,tran.received_at) as received_date,
            SUM(titem.qty),SUM(qty_received),SUM(qty_delivered),SUM(qty_returned),titem.open_order_status,tran.status as tran_status,delivery_to,client_branch_name,client_branch_code,tran.delivery_status');
            $this->db->from('transaction tran');
            $this->db->join('transaction_item titem', ' tran.id =titem.transaction_id', 'left');
            $this->db->join('runner_details rd', ' tran.runner_id =rd.ci_id', 'left');
            $this->db->join('lp_details ld', 'ld.employee_code = tran.lmdp', 'left');
            $this->db->where('tran.orderid', $id);
            if ($role == 2)
            $this->db->where('tran.lmdp', $loginname);
            $this->db->group_by('tran.id');
            $query = $this->db->get();
            //echo ($this->db->last_query()); 
            return $result = $query->result_array();
        } 
        
        public function get_deli_confirm_transaction($id) {
            $this->db->query("SET SESSION sql_mode=''");
            $this->db->select('id');
            $this->db->from('delivery_confirm dc');
            $this->db->where('reference', $id);
            $query = $this->db->get();
            //echo ($this->db->last_query()); 
            return $result = $query->result_array();
        }
        
        public function get_hstry_tranitm($id) {
            $this->db->select('*');
            $this->db->from('transaction_item');
            $this->db->where('transaction_id', $id);
            $query = $this->db->get();
            // echo ($this->db->last_query()); 
            return $result = $query->result_array();
        }  

        public function getHoldOrderValidate($trn_id) {

            $this->db->select('SUM(qty_hold) as hold_status');
            $this->db->from('transaction_item');
            $this->db->where('transaction_id', $trn_id);
            $query = $this->db->get();
            //echo ($this->db->last_query()); die;
            return $result = $query->row_array();
        }	
        public function get_hstry_rto_is_avail($id) {
            $this->db->select('*');
            $this->db->from('rto_details');
            $this->db->where('transaction_id', $id);

            $query = $this->db->get();
            // echo ($this->db->last_query()); 
            return $result = $query->result_array();
        }

        public function get_hstry_delivry($id) {
            $this->db->query("SET SESSION sql_mode=''");
            $this->db->select('dc.*,DATE_FORMAT(dc.created_at,"%d-%m-%Y") as created_at,tran.delivery_status,tran.attempt');
            $this->db->from('transaction tran');
            $this->db->join('delivery_confirm dc', 'tran.reference =dc.reference', 'inner');
            $this->db->where('tran.id', $id);
            $query = $this->db->get();
            //echo ($this->db->last_query()); die;
            return $result = $query->result_array();
        }

        public function get_hstry_undelivry($id) {
            $this->db->query("SET SESSION sql_mode=''");
            $this->db->select('dc.*,DATE_FORMAT(dc.created_at,"%d-%m-%Y %T") as created_at,tran.delivery_status,tran.attempt');
            $this->db->from('transaction tran');
            $this->db->join('undelivery_confirm dc', 'tran.shipmentid =dc.shipment_number', 'inner');
            $this->db->where('tran.id', $id);
            $this->db->group_by('dc.created_at');
            $query = $this->db->get();
            //echo ($this->db->last_query()); die;
            return $result = $query->result_array();
        }
        
        public function get_hstry_runner($id) {
            $this->db->query("SET SESSION sql_mode=''");
            $this->db->select("mt.*,rd.`deliver_boy_name` FROM (SELECT parent_id,info,`comment`, REPLACE(REPLACE(`comment`,'This Transaction is assigned to the Runner : ',''),'This Transaction is Reassigned to the Runner : ','') AS runner_id FROM `transaction_history` WHERE info = 'assign_runner' OR info = 'reassign_runner') AS mt");
            $this->db->join('runner_details rd', 'mt.runner_id = rd.ci_id', 'inner');
            $this->db->where('mt.parent_id', $id);
            $query = $this->db->get();
            //echo ($this->db->last_query()); die;
            return $result = $query->result_array();
        }

        public function get_order_history($id) {
            $sql = "SELECT DISTINCT info,SUBSTRING_INDEX(GROUP_CONCAT(COMMENT ORDER BY id DESC ),',','1') as comment,
                    SUBSTRING_INDEX(GROUP_CONCAT(created_at ORDER BY id DESC ),',','1') as created_at FROM `transaction_history` 
                    WHERE `parent_id` = '".$id."' GROUP BY  `info` ORDER BY created_at ASC";
            $query = $this->db->query($sql);
            //echo $this->db->last_query();
            return $result = $query->result_array();


        }   

        
	}

?>