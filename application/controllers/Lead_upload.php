<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead_upload extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_model');
	}

	public function index()
	{
		$this->load->view('lead_upload');
	}

	/**
	 * Updates the list items for uploaded items 
	 * @method post 
	 * @search none
	 * @author IPL TEAM
	 * @since v1.0 
	 * @version 1.0
	 * @return json 
	 */
	public function bulk_upload_items_request()
	{

		// echo '<pre>';
		// print_r($_FILES);
		// exit;

		if (is_array($_FILES) && isset($_FILES['upload']['name']) && $_FILES['upload']['name'] != '') {


			// Define actual cell header 
			$cell_header = array('customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_pincode', 'product_name', 'qty', 'lmp', 'branch', 'bb_order_id');

			// Get the input files
			$input_file_name = $_FILES['upload']['tmp_name'];

			// Load the excel library
			$this->load->library('Excel');

			// Read file data
			$input_file_type = PHPExcel_IOFactory::identify($input_file_name);
			$objReader = PHPExcel_IOFactory::createReader($input_file_type);
			$objPHPExcel = $objReader->load($input_file_name);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

			// Assign defaults
			$upd_xl_header = array();
			$item_valid = 0;
			$item_invalid = 0;
			$validation_array = [];
			$item_duplicate_array = [];
			$err_status = 0;
			$err_message = 'success';

			// Check atleast one row of data is available
			if ($highestRow > 1) {

				// Row loop 
				for ($inc = 0, $row = 2; $row <= $highestRow; $row++, $inc++) {

					//Column loop
					for ($col = 0; $col <= ($highestColumnIndex - 1); $col++) {

						if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue()) {
							// Bind row values
							$cell_value = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
							$rows[$inc][$cell_value] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
							$rows[$inc]['row_no'] = $row;

							// uploaded excel header
							if ($inc == 0)
								$upd_xl_header[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
						}
					}
				}


				if (is_array($rows) && count($rows) > 0) {

					for ($inc = 0; $inc < count($rows); $inc++) {

						// Check the xl header with actual header to find the file is valid
						$arr_match1 = count(array_diff($cell_header, $upd_xl_header));
						$arr_match2 = count(array_diff($upd_xl_header, $cell_header));


						/** If both header match then perform following checking
						 *  1. Check all mandatory fields
						 *  2. Check the itemcode duplicate
						 *  3. Check the combination of segment-0, segment-1, segment-2, segment-3 are exists in item_category
						 *  4. Check non empty values for state and item assign if any field entered
						 */
						if ($arr_match1 == 0 && $arr_match2 == 0) {

							//Check all mandatory fields and trim the array elements
							$rows[$inc] = array_map('trim', $rows[$inc]);
							$arr_rows = $rows[$inc];
							$validation_status = $this->check_bulk_upload_validation($arr_rows);

							if ($validation_status['status_flag'] == "0") {

								/* Check the products exists in tbl_lead_products */
								$prod_response = $this->Lead_model->check_product(trim($rows[$inc]['product_name']));

								if (count($prod_response) > 0) {

									/* Check lmp firm name */
									$lmp_reponse = $this->Lead_model->check_lmp(trim($rows[$inc]['lmp']));

									/* get the branch code from brnach name*/
									$branch_code = '';
									$branch_reponse = $this->Lead_model->check_branch(trim($rows[$inc]['branch']));
									if(is_array($branch_reponse) && count($branch_reponse)>0)
										$branch_code = $branch_reponse[0]['branchcode'];
									

									if (count($lmp_reponse) > 0) {

										$lead_status 		= 1; // Open
										$payment_type		= 1; // Prepaid order
										$login_id 			= $this->session->userdata('lm_admin_id');
										

										$cust_name 			= trim($rows[$inc]['customer_name']);
										$cust_phone 		= trim($rows[$inc]['customer_phone']);
										$billing_address	= trim($rows[$inc]['customer_address']);
										$billing_city		= trim($rows[$inc]['customer_city']);
										$billing_pincode	= trim($rows[$inc]['customer_pincode']);
										$shipping_address	= trim($rows[$inc]['customer_address']);
										$shipping_city		= trim($rows[$inc]['customer_city']);
										$shipping_pincode	= trim($rows[$inc]['customer_pincode']);
										$lmp_id 			=  $lmp_reponse[0]['ci_id'];
										$branch_code		=  $branch_code;
										$bb_order_id		=  trim($rows[$inc]['bb_order_id']);

										// Prepre lead data for insert
										$insert_arr = array(
											'cust_name' 		=> $cust_name,
											'cust_phone' 		=> $cust_phone,
											'created_on' 		=> date('Y-m-d G:i:s'),
											'created_by' 		=> $login_id,
											'branch_code'		=> $branch_code,
											'billing_address'	=> $billing_address,
											'billing_city'		=> $billing_city,
											'billing_pincode'	=> $billing_pincode,
											'shipping_address'	=> $shipping_address,
											'shipping_city'		=> $shipping_city,
											'shipping_pincode'	=> $shipping_pincode,
											'lmp_id' 		    => $lmp_id,
											'bb_order_id' 		=> $bb_order_id,
											'payment_type' 		=> $payment_type,
											'status'			=> $lead_status
										);

										// Save lead
										$lead_id = $this->Lead_model->insert_new_lead($insert_arr);
										if ($lead_id) {

											$qty = trim($rows[$inc]['qty']);;
											$price =  $prod_response[0]['prod_price'];
											$total_amount = $qty * $price;

											$item_arr = array(
												'lead_id' 			=> $lead_id,
												'item_name' 		=> $prod_response[0]['prod_name'],
												'item_id' 			=> $prod_response[0]['prod_id'],
												'item_unit_price' 	=> $price,
												'item_qty' 			=> $qty,
												'item_price' 		=> $total_amount
											);

											// Save lead item
											$this->Lead_model->insert_lead_item($item_arr);

											// Generate lead number and update to lead table
											$lead_no =  '1' . sprintf("%'.06d", $lead_id);
											$receipt = 'BB' . $lead_no;
											$up_arr = array('lead_no' => $lead_no, 'receipt_no' => $receipt, 'order_total' => $total_amount);
											$this->Lead_model->update_lead($up_arr, $lead_id);

											$err_status = 0;
											$err_message = 'success';

										} else {
											$err_status = 1;
											$err_message = 'Lead creation failed';
										}
									} else {
										$err_status = 1;
										$err_message = 'Invalid lmp name';
									}
								} else {
									$err_status = 1;
									$err_message = 'Invalid product name';
								}
							} else { //Mandatory validation failed
								$err_status = 1;
								$err_message = $validation_status['validation_message'];
							}

							$rows[$inc]['status'] = $err_status;
							$rows[$inc]['message'] = $err_message;

							if ($err_status == 0) {
								$item_valid++;
							} else {
								$item_invalid++;
							}
						} else {
							echo json_encode(array('result' => 'fail', 'message' => 'Invalid file'));
							exit;
						}
					} // end of for loop
				}

				echo json_encode(array('result' => 'success', 'valid' => $item_valid, 'invalid' => $item_invalid, 'data' => $rows));
			} else {
				echo json_encode(array('result' => 'fail', 'message' => 'No data'));
			}
		} else {
			echo json_encode(array('result' => 'fail', 'message' => 'Invalid file post'));
		}
	}

	/**
	 * Check the validation of mandatory fields in item request bulk upload
	 * @method post 
	 * @search none
	 * @author IPL TEAM
	 * @since v1.0 
	 * @version 1.0
	 * @return json 
	 */
	public function check_bulk_upload_validation($row)
	{
		$status_flag = 0;
		$response_array = [];
		$validation_message = '';

		$mandatory_arr = array('customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_pincode', 'product_name', 'qty', 'lmp');
		foreach ($mandatory_arr as $item) {

			if (array_key_exists($item, $row)) {
				if (!isset($row[$item]) || $row[$item] == '' || $row[$item] == ' ' || $row[$item] == NULL) {
					$status_flag = 1;
					$validation_message = ($validation_message != '') ? ($validation_message . ', ') : $validation_message;
					$validation_message = $validation_message . $item . ' is empty';
				}
			} else {
				$status_flag = 1;
				$validation_message = ($validation_message != '') ? ($validation_message . ', ') : $validation_message;
				$validation_message = $validation_message . $item . ' - column not exists';
			}
		}

		if (!is_numeric($row['qty'])) {
			$status_flag = 1;
			$validation_message = 'Qty is not numeric';
		}

		$status_arr = ['status_flag' => $status_flag, 'validation_message' => $validation_message];

		// echo '<pre>';
		// print_r($status_arr);
		// exit;

		return $status_arr;
	}
}
