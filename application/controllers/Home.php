<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model', 'dashboard_model');
	}

	public function index()
	{

		/*$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 1));
		$data['lead_open_count']    = (isset($result['total_count'])) ? $result['total_count'] : 0;
		$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 2));
		$data['lead_cancel_count']    = (isset($result['total_count'])) ? $result['total_count'] : 0;
		$result = $this->dashboard_model->total_order();
		$data['order_total']  = (isset($result['total_count'])) ? $result['total_count'] : 0;
		$result = $this->dashboard_model->total_sales();
		$amount = (isset($result['total_sales'])) ? $result['total_sales'] : 0;
		$data['sales_total']  =  $this->CurrencyFormat($amount);*/


		$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 1));
		$data['lead_open_count'] = (isset($result['total_count'])) ? $result['total_count'] : 0;

		$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 2));
		$data['lead_approved_count']    = (isset($result['total_count'])) ? $result['total_count'] : 0;

		$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 3));
		$data['lead_cancel_count']    = (isset($result['total_count'])) ? $result['total_count'] : 0;

		$result = $this->dashboard_model->get_data_from_tbl_lead(array('status' => 4));
		$data['lead_delivered_count']    = (isset($result['total_count'])) ? $result['total_count'] : 0;


		// $result = $this->dashboard_model->total_order();
		// $data['order_total']  = (isset($result['total_count'])) ? $result['total_count'] : 0;

		// $result = $this->dashboard_model->total_sales();
		// $amount = (isset($result['total_sales'])) ? $result['total_sales'] : 0;
		// $data['sales_total']  =  $this->CurrencyFormat($amount);


		// $result = $this->dashboard_model->total_customer();
		// $data['customer_count']  = (isset($result['total_customer'])) ? $result['total_customer'] : 0;
		$data['view']      			= 'index';
		$this->load->view('index', $data);
	}

	public function home()
	{

		$this->load->view('home');
	}

	public function blank()
	{
		$this->load->view('blank');
	}
	public function CurrencyFormat($num)
	{
		if ($num < 100000) return round(($num / 1000), 1) . ' K';
		if ($num >= 100000 and $num < 10000000) return round(($num / 100000), 1) . ' L';
		if ($num >= 10000000) return round(($num / 10000000), 1) . ' Cr';
	}
}
