<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Commonlib { 
      protected $CI;
    function __construct() {
        //This Context not available here so create new instance below
        $this->CI = & get_instance(); 
    } 
      public function pincode($pincode=false){
        $this->CI->db->select("t1.pincode,t1.district,t2.default_name AS state,t2.country_id as country");
        $this->CI->db->from('directory_pincode AS t1'); 
        $this->CI->db->join('directory_country_region AS t2', 't1.region_id = t2.region_id', 'left');
        if(!empty($pincode)) $this->CI->db->where('t1.pincode',$pincode);
        $this->CI->db->order_by('t1.pincode ASC');
        $query = $this->CI->db->get();      
        $result = $query->result_array(); 
        return $result;
    }

    public function city($city=false,$state=false){
        $this->CI->db->select("DISTINCT(t1.district),t2.default_name AS state,t2.country_id as country");
        $this->CI->db->from('directory_pincode AS t1'); 
        $this->CI->db->join('directory_country_region AS t2', 't1.region_id = t2.region_id', 'left');
        if(!empty($city)) $this->CI->db->where('t1.district',$city);
        if(!empty($state)) $this->CI->db->where('t2.default_name',$state);
        $this->CI->db->order_by('t1.district ASC');
        $query = $this->CI->db->get();      
        $result = $query->result_array();  
        return $result;
    }

    public function state($state=false,$country=false){
        $this->CI->db->select("default_name as state,country_id as country");
        $this->CI->db->from('directory_country_region');  
        if(!empty($state)) $this->CI->db->where('default_name',$state);
        if(!empty($country)) $this->CI->db->where('country_id',$country);
         $this->CI->db->order_by('default_name ASC');
        $query = $this->CI->db->get();      
        $result = $query->result_array(); 
        return $result;
    }
}

?>