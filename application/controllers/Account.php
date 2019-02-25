<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller 
{
	public function __construct() {
	    parent::__construct();
	    // Load the Library
	    $this->load->library("excel");
	    // Load the Model
	    $this->load->helper('common_functions');
	    $this->load->model("export_model");
	    $this->load->model("export_model_owner_level");
	    $this->load->model("export_model_asset_level");
	    $this->load->model("Account_model");
//this->session->set_userdata('groupid','64');
	    
    }
	public function index()
	{
		// $this->excel->setActiveSheetIndex(0);
        // // Gets all the data using MY_Model.php
        // $data = $this->export_model->get_all();

        // $this->excel->stream('contact_details.xls', $data);



        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Users list');
 
        // load database
        // $this->load->database();
 
        // load model
        // $this->load->model('userModel');
 
        // get all users in array formate
        // $users = $this->userModel->get_users();
        $users = $this->export_model->get_all();
 
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($users);
 
        $filename='just_some_random_name.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}

	public function set_report_criteria($rep_id)
	{		
		$gid=$this->session->userdata('groupid');
         $roleid=$this->session->userdata('role_id');
        if(isset($roleid))
        {
           $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $data = array();
                if($rep_id==21)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'Income';
			            $data['sample_report_name'] = 'Income.xlsx';
				  }
				  else if($rep_id==22)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'Expense';
			            $data['sample_report_name'] = 'Expense.xlsx';
				  }
				  else if($rep_id==23)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'Lease';
			            $data['sample_report_name'] = 'Lease_Report.xlsx';
				  }	
				  else if($rep_id==24)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'Bank Statement';
			            $data['sample_report_name'] = 'Bank_Statement.xlsx';
				  }
				  else if($rep_id==25)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'Tds';
			            $data['sample_report_name'] = 'TDS_report.xlsx';
				  }
				  else if($rep_id==26)
				  {
					  	$data['report_type'] = 'Account';
			            $data['report_name'] = 'GST';
			            $data['sample_report_name'] = 'GST_report.xlsx';
				  }
			  $data['report_id'] = $rep_id;
			  $data['purchase_data'] = $this->Account_model->getProperty();
			  $data['owner'] = $this->Account_model->get_owners();
			  load_view('reports/download_account_report',$data);
            }
            else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        }
        else
        {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
		  
	}

	public function generate_report($rep_id)
	{
		 if($rep_id==21)
		 {
		 	$this->Account_model->income();
		 }
		 if($rep_id==22)
		 {
		 	$this->Account_model->expense();
		 }
		 if($rep_id==23)
		 {
		 	$this->Account_model->get_lease();
		 }

		 if($rep_id==24)
		 {
		 	$this->Account_model->bank_statement();
		 }

		  if($rep_id==25)
		 {
		 	$this->Account_model->tds_statement();
		 }

		  if($rep_id==26)
		 {
		 	$this->Account_model->gst_statement();
		 }

		 $this->set_report_criteria($rep_id);

		 
	}


    public function get_sub_property()
    {
	    $property_id = html_escape($this->input->post('property_id'));
	    $txn_id = html_escape($this->input->post('txn_id'));

	    $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_id='$txn_id'");
	    $result=$query->result();
	    if (count($result)>0) {
	        $sub_property_id = $result[0]->sub_property_id;
	    } else {
	        $sub_property_id = '0';
	    }

	    $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
	    $result=$query->result();

	    $result= $this->Account_model->getSubPropertyDetails($txn_id, $property_id);

	    if(count($result)>0)
	    {
	      $result1['sub_property']=$result;
	      $result1['sub_property_id']=  $sub_property_id;
	      echo json_encode($result1);
	    }
	    else
	    {
	        echo 0;
	    }

	}

	public function get_owner()
	{
	   $result= $this->Account_model->get_owners();
	   if(count($result)>0)
	   			echo json_encode($result);
	   		else
	   			echo 0;		
	}

}