<?php

class Lead_model extends CI_Model
{

    public function insert_new_lead($ins_arr)
    {
        $this->db->insert('tbl_lead', $ins_arr);
        return $this->db->insert_id();
    }

    public function update_lead($up_arr, $id)
    {
        $this->db->where('lead_id', $id);
        return $this->db->update('tbl_lead', $up_arr);
    }

    public function insert_new_lead_items($ins_arr)
    {
        $this->db->insert_batch('tbl_lead_items', $ins_arr); 
        return $this->db->insert_id();
    }

    public function get_product_info($prod_id = '')
    {
        if ($prod_id == '') return false;
        $this->db->select('*');
        $this->db->from('tbl_lead_products');
        if ($prod_id == 'all') {
            $query = $this->db->get();
            return $result = $query->result_array();
        }
        if (is_array($prod_id) and count($prod_id) > 0) {
            $this->db->where_in('prod_id', $prod_id);
            $query = $this->db->get();
            return $result = $query->result_array();
        }
        if (!is_array($prod_id) and $prod_id != 0) {
            $this->db->where('prod_id', $prod_id);
            $query = $this->db->get();
            return $result = $query->row_array();
        }
    }

    public function get_lead_by_receipt($receipt_no)
    {
        $this->db->select('*');
        $this->db->from('tbl_lead');
        $this->db->where('receipt_no', $receipt_no);
        return $this->db->get()->result_array();
    }

    public function insert_payment_details($ins_arr)
    {
        $this->db->insert('tbl_lead_payments', $ins_arr);
        return $this->db->insert_id();
    }

    public function lead_list($filter)
    {
         $this->db->select('lead_id,cust_name,cust_email,cust_phone,lead_no,order_total,receipt_no,
        CASE
            WHEN payment_link_status = 0 THEN "Not Send"
            WHEN payment_link_status = 1 THEN "Send"
            ELSE "Failed"
        END AS payment_link_status,
        CASE
            WHEN payment_status = 0 THEN "Not Paid"
            WHEN payment_status = 1 THEN "Paid"
            ELSE "Failed"
        END AS payment_status,
        DATE_FORMAT(created_on, "%d-%m-%Y %h:%i %p") AS created_on,
        CASE
            WHEN status = 1 THEN "Open"
            WHEN status = 2 THEN "Cancelled"
            ELSE "-"
        END AS status,
        CASE
            WHEN payment_type = 1 THEN "Prepaid"
            WHEN payment_type = 2 THEN "COD"
            ELSE "-"
        END AS payment_type
        ', FALSE);
        $this->db->from(' tbl_lead');
        if (isset($filter['searchKey']) and !empty($filter['searchKey'])) {
            $this->db->where("
            cust_name LIKE '%" . $filter['searchKey'] . "%' 
            OR lead_no LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_email LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_phone  LIKE '%" . $filter['searchKey'] . "%'  
			OR receipt_no LIKE '%" . $filter['searchKey'] . "%'
        ");
        }
        if (!empty($filter['ordercolumn']))
            $this->db->order_by($filter['ordercolumn'], $filter['ordertype']);
        if (!empty($filter['length']))
            $this->db->limit($filter['length'], $filter['start']);
        return $this->db->get()->result_array();
    }
    public function lead_total_count($filter)
    {
        $this->db->select('count(*) total_lead');
        $this->db->from(' tbl_lead');
        if (isset($filter['searchKey']) and !empty($filter['searchKey'])) {
            $this->db->where("
            cust_name LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_email LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_phone  LIKE '%" . $filter['searchKey'] . "%'  
			OR receipt_no LIKE '%" . $filter['searchKey'] . "%'
        ");
        }
        return $this->db->get()->row_array();
    }
}
