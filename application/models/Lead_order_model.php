<?php
	class Lead_order_model extends CI_Model{

        public function get_lead($id){
            $this->db->select('*');
            $this->db->from('tbl_lead');
            $this->db->where('lead_id',$id);
            $query = $this->db->get();
            return $result = $query->result_array(); 
        }
        
        public function get_lmp($lmpid)
        {
            $this->db->select('employee_code');
            $this->db->from('lp_details');
            $this->db->where('ci_id',$lmpid);
            $query = $this->db->get();
             $result= $query->row_array();
            return $result['employee_code'] ;
            
        }
        
        public function add_transaction($data){
            $this->db->insert('transaction', $data);
            return $insert_id = $this->db->insert_id();
        }
        
        public function get_lead_item($id)
        {
           
            $this->db->select('*');
            $this->db->from('tbl_lead_items');
            $this->db->where('lead_id',$id);
            $query = $this->db->get();
            return $result = $query->result_array();
        }

        public function chk_transaction($ref)
        {
            $this->db->select('*');
			$this->db->from('`transaction`');
			$this->db->where('reference = ',$ref);
			$query  = $this->db->get();
            // print $this->db->last_query();die;
			return $query->row_array();
        }

        public function add_transaction_item($data){
			$this->db->insert('transaction_item', $data);
			return  $insert_id = $this->db->insert_id();
        }
        
        public function add_receive_history($data){
			$this->db->insert('order_receive_history', $data);
			return true;
		}

        public function add_log($data){
            $this->db->insert('tbl_lead_curl_log', $data);
            return  $insert_id = $this->db->insert_id();
        }

        public function update_log($up_arr, $id)
        {
            $this->db->where('log_id', $id);
            return $this->db->update('tbl_lead_curl_log', $up_arr);
        }

	}

?>