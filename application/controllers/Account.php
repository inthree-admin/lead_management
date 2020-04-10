<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model','auth_modal'); 
	}
	
	public function signup()
	{
		$this->load->view('account/register');
	}

	public function lockscreen()
	{
		$this->load->view('account/lockscreen');
	}

	public function forgotpass()
	{
		$this->load->view('account/forgot_password');
	}

	public function resetpass()
	{
		$this->load->view('account/reset_password');
	}

	public function register(){
		$post = $this->input->post();
		if (is_array($post) && count($post) > 0) {
			
			$ins_arr = array( 
				'lmu_first_name'=> isset($post['first_name']) ? trim($post['first_name']) : '',
				'lmu_last_name'=> isset($post['last_name']) ? trim($post['last_name']) : '',
				'lmu_email'=> isset($post['email']) ? trim($post['email']) : '',
				'lmu_username'=> isset($post['username']) ? trim($post['username']) : '',
				'lmu_password'=> isset($post['password']) ? md5(trim($post['password'])) : '',
				'lmu_created_on' => date('Y-m-d G:i:s'), 
				'lmu_status' => 1, 
			);
			$result = $this->auth_modal->insert_new_user($ins_arr);
			if($result){
				echo json_encode(array('success' => true, 'msg' => 'Your account created successfully!'));
			}else{
				echo json_encode(array('success' => false, 'msg' => 'Failed to add!'));
			}
		}else{
			echo json_encode(array('success' => false, 'msg' => 'Failed to add!'));
		}
		
	 
	}
	public function verify(){
		$email = (isset($_GET['email'])) ? trim($_GET['email']) : '';
		$username = (isset($_GET['username'])) ? trim($_GET['username']) : '';
		if($email){ 
			echo $this->auth_modal->check_already_exist(array('lmu_email'=>$email));
		}
		if($username){ 
			echo $this->auth_modal->check_already_exist(array('lmu_username'=>$username));
		}
	}

}
