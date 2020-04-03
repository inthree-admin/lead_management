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


}
