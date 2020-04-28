<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proof extends MY_Controller {

    public function __construct() {
         parent::__construct();  
         $this->load->model('General_model', 'common_model');
    } 

    public function index(){
			if($this->session->userdata('role') == 1){
                $this->load->view('delivery_proof');    
            }else{
                redirect('home');
            }
			
    }

   
     public function delivery_proof_list(){
        $role = $this->session->userdata('lm_role');
        $user_id = $this->session->userdata('lm_admin_id');
        $start  = (isset($_GET['start'])) ? $_GET['start'] : '';
        $length  = (isset($_GET['length'])) ? $_GET['length'] : '';
        $searchKey = (isset($_GET['search']['value'])) ? trim($_GET['search']['value']) : '';
        $ordercolumn =  (isset($_GET['order'][0]['column'])) ? $_GET['order'][0]['column'] : 1;
        $ordertype = (isset($_GET['order'][0]['dir'])) ? $_GET['order'][0]['dir'] : ''; //asc or desc 
        $filter_arr = array('start' => $start, 'length' => $length, 'searchKey' => $searchKey,  'ordertype' => $ordertype);
        if($role != 1 )  $filter_arr['created_by'] = $user_id; 
       
        // Get the post values from form
        $search_key =(isset($_POST['search'])) ? $_POST['search'] :'';
        $from_date = (isset($_POST['from_date'])) ? $_POST['from_date'] : '';
        $to_date = (isset($_POST['to_date'])) ? $_POST['to_date'] : '';

        // Get the user session values
        $logintype = $this->session->userdata('lm_admin_id');
        $loginname = $this->session->userdata('lm_name');
        $role = $this->session->userdata('lm_role');   

        // Default Load
       if($from_date =='' && $to_date =='')
        {
    		$today      = date('Y-m-d');
    		$datetime   = new DateTime($today);
    		$datetime->modify('-300 day');
    		$from_date   = $datetime->format('Y-m-d'); 
            $to_date     = $today; 
        }
      
        $filter_arr['from_date'] = $from_date;
        $filter_arr['to_date'] = $to_date;
        $filter_arr['search_key']= $search_key;
        $this->getImages($filter_arr);
        
    }

    public function getImages($filter_arr)
    { 
            $data = $this->common_model->delivery_proof_list($filter_arr);
            $proof = base_url() . 'assets/img/no_image.png';
            foreach ($data as $key => $value) {  
                $delivery_proof = (!empty($value['delivery_proof'])) ? $value['delivery_proof'] : $proof;
                $invoice_proof = (!empty($value['invoice_proof'])) ? $value['invoice_proof'] : $proof;
                $address_proof = (!empty($value['address_proof'])) ? $value['address_proof'] : $proof;
                $sign_proof = (!empty($value['sign_proof'])) ? $value['sign_proof'] : $proof;
                $value['delivery_proof'] = '<img src="'.$delivery_proof.'" class="img-thumbnail" alt="" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);">'; 

                $value['invoice_proof'] = '<img src="'.$invoice_proof.'" class="img-thumbnail" alt="" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);">';

                $value['address_proof'] = '<img src="'.$address_proof.'" class="img-thumbnail" alt="" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);">';

                $value['sign_proof'] = '<img src="'.$sign_proof.'" class="img-thumbnail" alt="" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);">';

                $data[$key]= $value;
            }

            // Total 
            $ListTotal = $this->common_model->delivery_proof_list_total_count($filter_arr); 

            $returnData['recordsTotal'] = count($data);
            $returnData['recordsFiltered'] =  $ListTotal['total_count'];
            $returnData['data'] = $data;
            echo json_encode($returnData);
        }

        public function replace_proof_image(){

                $img = explode("media/", $_POST['selected_img']);
                $proof_name  = $img[1];
                $t=time(); 
              //
                $folderpath = str_replace("system","media",BASEPATH);
                //rename($folderpath.$proof_name ,$folderpath."copy_".$t."_".$proof_name);
                
                 $config['upload_path']         =   $folderpath;
                $config['allowed_types']        =   'gif|jpg|png';
                $config['file_name']            =   $proof_name; 
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768; 
                $this->load->library('upload', $config); 
                if ( ! $this->upload->do_upload('file'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        echo json_encode($error); 
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        echo json_encode($data); 
                }
            
        }

         
    }
