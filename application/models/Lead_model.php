<?php

class Lead_model extends CI_Model {

    public function insert_new_lead($ins_arr) {
        $this->db->insert('tbl_lead', $ins_arr);
        return $this->db->insert_id();
    }

    public function update_lead($up_arr, $id) {
        $this->db->where('lead_id', $id);
        return $this->db->update('tbl_lead',$up_arr);
    }
    
    public function insert_new_lead_items($ins_arr) {
        $this->db->insert('tbl_lead_items', $ins_arr);
        return $this->db->insert_id();
    }

    public function get_product_info($prod_id) {
        $this->db->select('*');
        $this->db->from('tbl_lead_products');
        $this->db->where('prod_id', $prod_id);
        $query = $this->db->get();  
        return $result = $query->row_array();
    }

    public function get_lead_by_receipt($receipt_no) {
        $this->db->select('*');
        $this->db->from('tbl_lead');
        $this->db->where('receipt_no', $receipt_no);
        return $this->db->get()->result_array();
    }

    public function insert_payment_details($ins_arr) {
        $this->db->insert('tbl_lead_payments', $ins_arr);
        return $this->db->insert_id();
    }


}
