<?php

class Dashboard_model extends CI_Model
{

     public function get_data_from_tbl_lead($condition = array())
     {

          $this->db->select('count(*) as total_count');
          $this->db->from(' tbl_lead');
          if (isset($condition['status']) and !empty($condition['status'])) {
               $this->db->where_in('approval_status', $condition['status']);
          }

          if ($this->session->userdata('lm_role') == 2) {
               $this->db->where('created_by', $this->session->userdata('lm_admin_id'));
          }

          $query = $this->db->get();
          return $result = $query->row_array();
     }

     public function total_order($condition = array())
     {
          $q = 'SELECT COUNT(*) AS total_count FROM tbl_lead WHERE payment_type IN (1,2) AND IF(payment_type = 1, payment_status = 1, payment_status IN (0,1))';
          $query = $this->db->query($q);
          return $result = $query->row_array();
     }

     public function total_sales($condition = array())
     {
          $q = 'SELECT SUM(order_total) AS total_sales FROM tbl_lead WHERE payment_type IN (1,2) AND IF(payment_type = 1, payment_status = 1, payment_status IN (0,1))';
          $query = $this->db->query($q);
          return $result = $query->row_array();
     }
     public function total_customer($condition = array())
     {
          $this->db->select(' COUNT(DISTINCT(cust_phone)) AS total_customer');
          $this->db->from(' tbl_lead');
          if (isset($condition['status']) and !empty($condition['status'])) {
               $this->db->where_in('status', $condition['status']);
          }
          $query = $this->db->get();
          return $result = $query->row_array();
     }
}
