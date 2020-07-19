<?php
    class General_model extends CI_Model{

        public function delivery_proof_list($filter_arr){  
                $response_data = array();
                $this->db->select('t1.reference,t1.delivery_proof,t1.invoice_proof,t1.address_proof,t1.sign_proof,t1.other_proof,DATE_FORMAT(t1.created_at, "%d-%m-%Y")  as created_at ,t2.orderid, t2.customer_name, t2.customer_contact_number');
                $this->db->from('delivery_confirm t1');
                $this->db->join('transaction t2', 't1.reference = t2.reference', 'left'); 
                $this->db->where('t2.ad_id', 3); 
                
                // New Code
                if (is_array($filter_arr) && count($filter_arr) > 0) {

                    if (isset($filter_arr['searchKey']) && $filter_arr['searchKey'] != '') {
                        $this->db->where("(`t1`.`reference` LIKE '%".$filter_arr['searchKey']."%' OR `t2`.`orderid` LIKE '%".$filter_arr['searchKey']."%' OR `t2`.`customer_name` LIKE '%".$filter_arr['searchKey']."%' OR `t2`.`customer_contact_number` LIKE '%".$filter_arr['searchKey']."%')"); 
                    } 
                    $this->db->where("DATE(t1.created_at) BETWEEN '".$filter_arr['from_date']."' AND '".$filter_arr['to_date']."'"); 
                } 
                if (!empty($filter_arr['length'])){
                    $this->db->limit($filter_arr['length'], $filter_arr['start']);
                }
                $this->db->order_by("t1.id", "desc"); 
                $query = $this->db->get();
                $response_data = $query->result_array(); 
             
               return $response_data; 

        }
        
         public function delivery_proof_list_total_count($filter_arr=array()){  
                $response_data = array();
                $this->db->select('count(*) as total_count');
                $this->db->from('delivery_confirm t1');
                $this->db->join('transaction t2', 't1.reference = t2.reference', 'left');
                $this->db->where('t2.ad_id', 3);  
                // New Code
                if (is_array($filter_arr) && count($filter_arr) > 0) {
                    if (isset($filter_arr['searchKey']) && $filter_arr['searchKey'] != '') {
                        $this->db->where("(`t1`.`reference` LIKE '%".$filter_arr['searchKey']."%' OR `t2`.`orderid` LIKE '%".$filter_arr['searchKey']."%')"); 
                    } 
                    $this->db->where("DATE(t1.created_at) BETWEEN '".$filter_arr['from_date']."' AND '".$filter_arr['to_date']."'"); 
                }  
                $query = $this->db->get();
                $response_data = $query->row_array(); 
               return $response_data; 

        }
    }

?>