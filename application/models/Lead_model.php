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
            $this->db->where('status', 1);
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

    public function get_lmp_info($prod_ids)
    {
        $this->db->select('lmp_id');
        $this->db->from('tbl_lead_products');
        $this->db->where("prod_id IN (" . $prod_ids . ")", NULL, false);
        $this->db->group_by('lmp_id');
        return $this->db->get()->result_array();
    }

    public function get_lead_by_receipt($receipt_no)
    {
        $this->db->select('*');
        $this->db->from('tbl_lead');
        $this->db->where('receipt_no', $receipt_no);
        return $this->db->get()->result_array();
    }

    public function get_lead_by_lead_id($lead_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_lead');
        $this->db->where('lead_id', $lead_id);
        return $this->db->get()->result_array();
    }

    public function insert_payment_details($ins_arr)
    {
        $this->db->insert('tbl_lead_payments', $ins_arr);
        return $this->db->insert_id();
    }

    public function lead_list($filter)
    {
        $this->db->select('lead_id,cust_name,cust_email,cust_phone,cust_id,lead_no,order_total,receipt_no,lmu_username,created_by,
        CASE
            WHEN payment_link_status = 0 THEN "Not Sent"
            WHEN payment_link_status = 1 THEN "Sent"
            WHEN payment_link_status = 3 THEN "Cancelled"
            ELSE "Failed"
        END AS payment_link_status,
        CASE
            WHEN payment_status = 0 THEN "Not Paid"
            WHEN payment_status = 1 THEN "Paid"
            ELSE "Failed"
        END AS payment_status,
        DATE_FORMAT(created_on, "%d-%m-%Y %h:%i %p") AS created_on,
        CASE
            WHEN approval_status = 1 THEN "Waiting For Approval"
            WHEN approval_status = 2 THEN "Approved"
            WHEN approval_status = 3 THEN "Cancelled"
            WHEN approval_status = 4 THEN "Delivered"
            ELSE "-"
        END AS status,
        ', FALSE);
        $this->db->from(' tbl_lead');
        $this->db->join(' tbl_lead_users', 'tbl_lead.created_by = tbl_lead_users.lm_id', 'LEFT');
        if (isset($filter['created_by']) and !empty($filter['created_by'])) {
            $this->db->where('created_by', $filter['created_by']);
        }
        if (isset($filter['searchKey']) and !empty($filter['searchKey'])) {
            $this->db->where("(
            cust_name LIKE '%" . $filter['searchKey'] . "%' 
            OR lead_no LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_email LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_phone  LIKE '%" . $filter['searchKey'] . "%'  
            OR cust_id  LIKE '%" . $filter['searchKey'] . "%'  
			OR receipt_no LIKE '%" . $filter['searchKey'] . "%')
        ");
        }
        if (isset($filter['from_date']) and isset($filter['to_date'])) {
            $this->db->where(" ( DATE(created_on)  >= '" . $filter['from_date'] . "' AND DATE(created_on)  <= '" . $filter['to_date'] . "') ");
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
        if (isset($filter['created_by']) and !empty($filter['created_by']))
            $this->db->where('created_by', $filter['created_by']);
        if (isset($filter['searchKey']) and !empty($filter['searchKey'])) {
            $this->db->where("(
            cust_name LIKE '%" . $filter['searchKey'] . "%' 
            OR lead_no LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_email LIKE '%" . $filter['searchKey'] . "%' 
            OR cust_phone  LIKE '%" . $filter['searchKey'] . "%'  
            OR cust_id  LIKE '%" . $filter['searchKey'] . "%'  
            OR receipt_no LIKE '%" . $filter['searchKey'] . "%')
        ");
        }
        if (isset($filter['from_date']) and isset($filter['to_date'])) {
            $this->db->where(" ( DATE(created_on)  >= '" . $filter['from_date'] . "' AND DATE(created_on)  <= '" . $filter['to_date'] . "') ");
        }

        return $this->db->get()->row_array();
    }

    public function lead_info($lead_no = false)
    {
        $return = array();
        if ($lead_no) {
            $this->db->select('*,
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
            $this->db->from('tbl_lead');
            $this->db->where('lead_no', $lead_no);
            $result = $this->db->get()->row_array();
            if ($result) {
                $return['lead'] = $result;
                $this->db->select('*');
                $this->db->from('tbl_lead_items');
                $this->db->where('lead_id', $result['lead_id']);
                $result = $this->db->get()->result_array();
                $return['lead_item'] = $result;
            } else {
                $return['lead'] = [];
                $return['lead_item'] = [];
            }
            return $return;
        } else {
            $return['lead'] = [];
            $return['lead_item'] = [];
            return $return;
        }
    }

    public function getLead($filter = array())
    {
        $this->db->select('*');
        $this->db->from('tbl_lead');
        if (isset($filter['seller_order_id']) and !empty($filter['seller_order_id']))
            $this->db->where('seller_order_id', $filter['seller_order_id']);
        return $this->db->get()->row();
    }
}
