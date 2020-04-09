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
		if ($this->session->has_userdata('role')) {
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
					'password' => $this->input->post('password')
				);
				$result = $this->auth_model->login($data);
				if ($result == TRUE) {
					$admin_data = array(
						'admin_id' => $result['id'],
						'name' => $result['username'],
						'role' => $result['role'],
						'owner_name' => $result['owner_name'],
						'username' => $result['username'],
						'profile_pic' => $result['profile_pic'],

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

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth/login'), 'refresh');
	}
}
