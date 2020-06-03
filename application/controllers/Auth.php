<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('auth_model', 'auth_model');
	}
	public function index()
	{
		$this->session->sess_destroy();
		if ($this->session->has_userdata('lm_role')) {
			redirect('lead');
		} else {
			$this->load->view('auth/login');
		}
	}
	public function login()
	{

		if ($this->input->post('signin')) {
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('auth/login');
			} else {
				$data = array(
					'username' => $this->input->post('username'),
					'password' => md5(trim($this->input->post('password')))
				);

				$result = $this->auth_model->login($data);  
				if ($result == TRUE) {
					$admin_data = array(
						'lm_admin_id' 		=> $result['lm_id'],
						'lm_name' 			=> ucfirst($result['lmu_username']),
						'lm_role' 			=> $result['lmu_role_id'],
						'lm_owner_name' 	=> ucfirst($result['lmu_username']),
						'lm_username' 		=> ucfirst($result['lmu_username']),
						'lm_profile_pic' 	=> base_url().'img/user.jpg',
					);

					$this->session->set_userdata($admin_data);
					redirect(base_url('home'), 'refresh');
				} else {

					$data['msg'] = 'Invalid Credential!';
					$this->load->view('auth/login', $data);
				}
			}
		} else {

			$url_user_name = $this->uri->segment(3);

			if($url_user_name!='') {

				$result_exist = $this->auth_model->check_already_exist(array('lmu_username'=>$url_user_name));

				if($result_exist) {					
					//Not exist & create a new entry
					$ins_arr = array( 
						'lmu_first_name'=> $url_user_name,
						'lmu_last_name'=> $url_user_name,
						'lmu_email'=> $url_user_name,
						'lmu_username'=> $url_user_name,
						'lmu_password'=>  md5(trim($url_user_name)),
						'lmu_created_on' => date('Y-m-d G:i:s'), 
						'lmu_status' => 1, 
						'lmu_role_id' => 2
					);
					$result = $this->auth_model->insert_new_user($ins_arr);
				} 

				$result = $this->auth_model->get_user_details(array('username' =>$url_user_name));

				$admin_data = array(
					'lm_admin_id' 		=> $result['lm_id'],
					'lm_name' 			=> ucfirst($result['lmu_username']),
					'lm_role' 			=> $result['lmu_role_id'],
					'lm_owner_name' 	=> ucfirst($result['lmu_username']),
					'lm_username' 		=> ucfirst($result['lmu_username']),
					'lm_profile_pic' 	=> base_url().'img/user.jpg',
				);

				$this->session->set_userdata($admin_data);
				redirect(base_url('lead'), 'refresh');

			} else {
				$this->load->view('auth/login');
			}

			
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth/login'), 'refresh');
	}

	public function login_old()
	{

		if ($this->input->post('signin')) {
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('auth/login');
			} else {
				$data = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password')
				);
				$result = $this->auth_model->login($data);
				if ($result == TRUE) {
					$admin_data = array(
						'lm_admin_id' => $result['id'],
						'lm_name' => $result['username'],
						'lm_role' => $result['role'],
						'lm_owner_name' => $result['owner_name'],
						'lm_username' => $result['username'],
						'lm_profile_pic' => $result['profile_pic'],

					);


					$this->session->set_userdata($admin_data);
					redirect(base_url('home'), 'refresh');
				} else {

					$data['msg'] = 'Invalid Credential!';
					$this->load->view('auth/login', $data);
				}
			}
		} else {
			$this->load->view('auth/login');
		}
	}
}
