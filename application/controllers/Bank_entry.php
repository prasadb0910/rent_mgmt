<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Bank_entry extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
        $this->load->model('rent_model');
        $this->load->model('sales_model');
        $this->load->model('loan_model');
        $this->load->model('expense_model');
        $this->load->model('maintenance_model');
        $this->load->model('bank_entry_model');
    }

    public function index(){
        $this->checkstatus('All');
    }

    function getBankEntry(){
        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));
        $sub_property_id = html_escape($this->input->post('sub_property_id'));

        // $status = 'expense';
        // $property_id = '19';
        // $sub_property_id = '28';

        if($sub_property_id=="" || $sub_property_id==null) {
            $sub_property_id=0;
        }

        $txn_id="";
        $sch_id="";
        if ($status=="purchase") {
            $txn_id=$property_id;

            $query=$this->db->query("select * from purchase_schedule where purchase_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="p_" . $txn_id;
            $sch_id="p_" . $sch_id;
        } else if ($status=="loan") {
            if($sub_property_id==0){
                $cond="(loan_subproperty_id is null or loan_subproperty_id='' or loan_subproperty_id='0')";
            } else {
                $cond="loan_subproperty_id='$sub_property_id'";
            }

            $query=$this->db->query("select * from loan_txn where loan_property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from loan_schedule where loan_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="l_" . $txn_id;
            $sch_id="l_" . $sch_id;
        } else if ($status=="rent") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }

            $query=$this->db->query("select * from rent_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from rent_schedule where rent_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="r_" . $txn_id;
            $sch_id="r_" . $sch_id;
        } else if ($status=="sale") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from sales_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from sales_schedule where sale_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="s_" . $txn_id;
            $sch_id="s_" . $sch_id;
        } else if ($status=="expense") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from expense_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from expense_schedule where expense_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="e_" . $txn_id;
            $sch_id="e_" . $sch_id;
        } else if ($status=="maintenance") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from maintenance_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from maintenance_schedule where m_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="m_" . $txn_id;
            $sch_id="m_" . $sch_id;
        } else {
            $txn_id="";
            $sch_id="";
        }

        // echo $sch_id . " " . $txn_id;

        // $this->bankEntry($sch_id, $txn_id);

        $data['sch_id']=$sch_id;
        $data['txn_id']=$txn_id;

        echo json_encode($data);

        // echo "<script>window.open(\"" . base_url() . "/index.php/bank_entry/bankEntry/" . $sch_id . "/" . $txn_id . "\",\"_parent\",\"true\")</script>";
        // redirect('bank_entry/bankEntry/' . $sch_id . '/' . $txn_id);
    }
    
    function bankEntryView(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data['access']=$result;

                $fk_txn_id=$this->uri->segment(3);
                $bank_entry_id=$this->uri->segment(4);
                $entry_type=$this->uri->segment(5);

                $fk_txn_id=explode("_",$fk_txn_id);
                if($fk_txn_id[0]=='o'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getOtherExpenseDetail($fk_txn_id, $bank_entry_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();

                    $sql="select * from expense_category_master where g_id='$gid'";
                    $query=$this->db->query($sql);
                    $data['expense_category']=$query->result();
                } else if($fk_txn_id[0]=='t'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getOtherScheduleDetail($fk_txn_id, $bank_entry_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();
                } else {
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getAllPropertyDetail($fk_txn_id, $bank_entry_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['sub_property']=array();

                    if(isset($data['property_details']['purchase'])){
                        if($data['property_details']['purchase']=='selected'){
                            $data['property']=$this->purchase_model->purchaseData("Approved");
                        }
                    }
                    if(isset($data['property_details']['sale'])){
                        if($data['property_details']['sale']=='selected'){
                            $data['property']=$this->sales_model->salesData("Approved");
                            $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['rent'])){
                        if($data['property_details']['rent']=='selected') {
                            $data['property']=$this->rent_model->rentData("Approved");
                            $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['loan'])){
                        if($data['property_details']['loan']=='selected') {
                            $query=$this->db->query("select * from loan_txn");
                            $data['loan_txn']=$query->result();
                        }
                    } 
                    if(isset($data['property_details']['expense'])){
                        if($data['property_details']['expense']=='selected'){
                            $data['property']=$this->expense_model->expenseData("Approved");
                            $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['maintenance'])){
                        if($data['property_details']['maintenance']=='selected'){
                            $data['property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
                            $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
                        }
                    }
                }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('bank_entry/bank_entry_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function edit(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1){
                $data['access']=$result;

                $fk_txn_id=$this->uri->segment(3);
                $bank_entry_id=$this->uri->segment(4);
                $entry_type=$this->uri->segment(5);

                $fk_txn_id=explode("_",$fk_txn_id);
                if($fk_txn_id[0]=='o'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getOtherExpenseDetail($fk_txn_id, $bank_entry_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();

                    $sql="select * from expense_category_master where g_id='$gid'";
                    $query=$this->db->query($sql);
                    $data['expense_category']=$query->result();
                } else if($fk_txn_id[0]=='t'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getOtherScheduleDetail($fk_txn_id, $bank_entry_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();
                } else {
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->bank_entry_model->getAllPropertyDetail($fk_txn_id, $bank_entry_id, $entry_type);
                    $property_id=$data['property_details']['property_id'];
                    $data['sub_property']=array();

                    if(isset($data['property_details']['purchase'])){
                        if($data['property_details']['purchase']=='selected'){
                            $data['property']=$this->purchase_model->purchaseData("Approved");
                        }
                    }
                    if(isset($data['property_details']['sale'])){
                        if($data['property_details']['sale']=='selected'){
                            $data['property']=$this->sales_model->salesData("Approved");
                            $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['rent'])){
                        if($data['property_details']['rent']=='selected') {
                            $data['property']=$this->rent_model->rentData("Approved");
                            $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['expense'])){
                        if($data['property_details']['expense']=='selected'){
                            $data['property']=$this->expense_model->expenseData("Approved");
                            $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['maintenance'])){
                        if($data['property_details']['maintenance']=='selected'){
                            $data['property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
                            $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
                        }
                    }
                }
                
                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('bank_entry/bank_entry_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function bankEntry(){
        $result=$this->bank_entry_model->getAccess();

        if(count($result)>0) {
            $fk_txn_id=$this->uri->segment(3);
            $data['property_details']=$this->bank_entry_model->getAllPropertyDetail($fk_txn_id);
            $property_id=$data['property_details']['property_id'];
            $data['sub_property']=array();

            if(isset($data['property_details']['sale'])){
                if($data['property_details']['sale']=='selected'){
                    $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['rent'])){
                if($data['property_details']['rent']=='selected') {
                    $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['expense'])){
                if($data['property_details']['expense']=='selected'){
                    $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['maintenance'])){
                if($data['property_details']['maintenance']=='selected'){
                    $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
                }
            }
            
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('bank_entry/bank_entry_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveActualBankEntry(){
        $result=$this->bank_entry_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->bank_entry_model->saveActualBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/bank_entry');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveOtherExpenseBankEntry(){
        $result=$this->bank_entry_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->bank_entry_model->saveOtherExpenseBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/bank_entry');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveOtherScheduleBankEntry(){
        $result=$this->bank_entry_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->bank_entry_model->saveOtherScheduleBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/bank_entry');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updaterecord($bank_entry_id, $entry_type){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section='BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            if($entry_type=='tax') {
                $table_name = "actual_schedule_taxes";
            } else {
                $table_name = "actual_schedule";
            }

            $query=$this->db->query("SELECT * FROM ".$table_name." WHERE id = '$bank_entry_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
                $table_type = $res[0]->table_type;
                $fk_txn_id = $res[0]->fk_txn_id;
                $fk_created_on = $res[0]->fk_created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $created_by = '';
                $created_on = '';
                $table_type = '';
                $fk_txn_id = '';
                $fk_created_on = null;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $this->db->query("update actual_schedule_taxes set status='1', txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Bank Entry';
                            $logarray['cnt_name']=$table_type;
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM ".$table_name." WHERE fk_created_on='$created_on' and 
                                                    table_type='$table_type' and fk_txn_id='$fk_txn_id'");
                            $result=$query->result();
                            if (count($result)>0) {
                                $rec_status = $result[0]->txn_status;
                                $txn_fkid = $result[0]->txn_fkid;
                                $created_by = $result[0]->created_by;
                                $created_on = $result[0]->created_on;
                                $table_type = $result[0]->table_type;
                                $fk_txn_id = $result[0]->fk_txn_id;
                                $fk_created_on = $result[0]->fk_created_on;

                                $this->db->query("Update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                                $this->db->query("Update actual_schedule_taxes set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into actual_schedule (table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, remarks, rejected_by, rejected_date, maker_remark, fk_created_on, gp_id) 
                                                 Select table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, '$txnremarks', rejected_by, rejected_date, 
                                                 maker_remark, created_on, gp_id FROM actual_schedule 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into actual_schedule_taxes (table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, status, 
                                                 txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, rejected_by, rejected_date, remarks, maker_remark, fk_created_on, gp_id) 
                                                 Select table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, '3', 
                                                 '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, rejected_by, rejected_date, '$txnremarks', 
                                                 maker_remark, created_on, gp_id FROM actual_schedule_taxes 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                            }
                        }
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveActualBankEntry($form_data, $txn_status, $created_on);

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');

                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveActualBankEntry($form_data, $txn_status, $fk_created_on);
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($bank_entry_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid = $this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                if($entry_type=='tax') {
                    $table_name = "actual_schedule_taxes";
                } else {
                    $table_name = "actual_schedule";
                }

                $query=$this->db->query("SELECT * FROM ".$table_name." WHERE id = '$bank_entry_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $created_on = $res[0]->created_on;
                    $table_type = $res[0]->table_type;
                    $fk_txn_id = $res[0]->fk_txn_id;
                    $fk_created_on = $res[0]->fk_created_on;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $created_on = '';
                    $table_type = '';
                    $fk_txn_id = '';
                    $fk_created_on = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_schedule set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    $this->db->query("update actual_schedule_taxes set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                } else {
                    if ($fk_created_on=='' || $fk_created_on==null) {
                        $this->db->query("update actual_schedule set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                        $this->db->query("update actual_schedule_taxes set status='1', txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                            $status='2';
                        } else {
                            $status='1';
                        }

                        $this->db->query("delete from actual_schedule WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("delete from actual_schedule_taxes WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("update actual_schedule set txn_status='$txn_status', approved_by='$curusr', 
                                         approved_date='$modnow', remarks='$remarks', txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");

                        $this->db->query("update actual_schedule_taxes set status='$status', txn_status='$txn_status', 
                                         approved_by='$curusr', approved_date='$modnow', remarks='$remarks', 
                                         txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");
                    }
                }

                $logarray['table_id']=$created_on;
                $logarray['module_name']='Bank Entry';
                $logarray['cnt_name']=$table_type;
                $logarray['action']='Bank Entry Record ' . $txn_status;
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                redirect(base_url().'index.php/Bank_entry');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo "You donot have access to this page";
        }
    }

    public function updateOtherExpense($bank_entry_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM actual_other_expense WHERE id = '$bank_entry_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gid = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = null;
                $gid = $gid;
                $created_by = $curusr;
                $created_on = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_other_expense set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE id = '$bank_entry_id'");
                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Bank Entry Expense';
                            $logarray['cnt_name']='Expense';
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM actual_other_expense WHERE txn_fkid = '$bank_entry_id'");
                            $result=$query->result();
                            if (count($result)>0){
                                $bank_entry_id = $result[0]->id;
                                $txn_fkid = $result[0]->txn_fkid;

                                $this->db->query("Update actual_other_expense set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE id = '$bank_entry_id'");

                                $logarray['table_id']=$bank_entry_id;
                                $logarray['module_name']='Bank Entry Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into actual_other_expense (expense_category, property_id, sub_property_id, 
                                                 expense_description, expense_date, expense_amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, gp_id, txn_status, created_by, created_on, modified_by, 
                                                 modified_date, approved_by, approved_date, remarks, txn_fkid, rejected_by, 
                                                 rejected_date, maker_remark) 
                                                 Select expense_category, property_id, sub_property_id, 
                                                 expense_description, expense_date, expense_amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, '$gid', '$txn_status', '$created_by', '$created_on', 
                                                 '$curusr', '$modnow', approved_by, approved_date, '$txnremarks', '$bank_entry_id', 
                                                 rejected_by, rejected_date, maker_remark 
                                                 FROM actual_other_expense WHERE id = '$bank_entry_id'");

                                $logarray['table_id']=$bank_entry_id;
                                $logarray['module_name']='Bank Entry Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('id', $bank_entry_id);
                        $this->db->delete('actual_other_expense');

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveOtherExpenseBankEntry($form_data, $txn_status, $bank_entry_id);

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('id', $bank_entry_id);
                        $this->db->delete('actual_other_expense');

                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveOtherExpenseBankEntry($form_data, $txn_status, $txn_fkid);

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveOtherExpense($bank_entry_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM actual_other_expense WHERE id = '$bank_entry_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gid = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = null;
                    $gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_other_expense set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE id = '$bank_entry_id'");

                    $logarray['table_id']=$bank_entry_id;
                    $logarray['module_name']='Bank Entry Expense';
                    $logarray['cnt_name']='Expense';
                    $logarray['action']='Bank Entry Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update actual_other_expense set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE id = '$bank_entry_id'");

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update actual_other_expense A, actual_other_expense B set 
                                         A.expense_category=B.expense_category, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.expense_description=B.expense_description, 
                                         A.expense_date=B.expense_date, A.expense_amount=B.expense_amount, 
                                         A.payment_mode=B.payment_mode, A.account_number=B.account_number, 
                                         A.payment_date=B.payment_date, A.cheque_no=B.cheque_no, 
                                         A.gp_id=B.gp_id, A.txn_status='$txn_status', A.created_by=B.created_by, 
                                         A.created_on=B.created_on, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', 
                                         A.approved_date='$modnow', A.remarks='$remarks', 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark 
                                         WHERE B.id = '$bank_entry_id' and A.id=B.txn_fkid");

                        $this->db->query("delete from actual_other_expense WHERE id = '$bank_entry_id'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Bank_entry');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateOtherSchedule($bank_entry_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE id = '$bank_entry_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gid = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = null;
                $gid = $gid;
                $created_by = $curusr;
                $created_on = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_other_schedule set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE id = '$bank_entry_id'");
                            $logarray['table_id']=$bank_entry_id;
                            $logarray['module_name']='Bank Entry Schedule';
                            $logarray['cnt_name']='Schedule';
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE txn_fkid = '$bank_entry_id'");
                            $result=$query->result();
                            if (count($result)>0){
                                $bank_entry_id = $result[0]->id;
                                $txn_fkid = $result[0]->txn_fkid;

                                $this->db->query("Update actual_other_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE id = '$bank_entry_id'");

                                $logarray['table_id']=$bank_entry_id;
                                $logarray['module_name']='Bank Entry Schedule';
                                $logarray['cnt_name']='Schedule';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into actual_other_schedule (type, property_id, sub_property_id, 
                                                 description, sch_date, amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, gp_id, txn_status, created_by, created_on, modified_by, 
                                                 modified_date, approved_by, approved_date, remarks, txn_fkid, rejected_by, 
                                                 rejected_date, maker_remark) 
                                                 Select type, property_id, sub_property_id, 
                                                 description, sch_date, amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, '$gid', '$txn_status', '$created_by', '$created_on', 
                                                 '$curusr', '$modnow', approved_by, approved_date, '$txnremarks', '$bank_entry_id', 
                                                 rejected_by, rejected_date, maker_remark 
                                                 FROM actual_other_schedule WHERE id = '$bank_entry_id'");

                                $logarray['table_id']=$bank_entry_id;
                                $logarray['module_name']='Bank Entry Schedule';
                                $logarray['cnt_name']='Schedule';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('id', $bank_entry_id);
                        $this->db->delete('actual_other_schedule');

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Schedule';
                        $logarray['cnt_name']='Schedule';
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveOtherScheduleBankEntry($form_data, $txn_status, $bank_entry_id);

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Schedule';
                        $logarray['cnt_name']='Schedule';
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('id', $bank_entry_id);
                        $this->db->delete('actual_other_schedule');

                        $form_data=$this->input->post(null,true);
                        $this->bank_entry_model->saveOtherScheduleBankEntry($form_data, $txn_status, $txn_fkid);

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Schedule';
                        $logarray['cnt_name']='Schedule';
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Bank_entry');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveOtherSchedule($bank_entry_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE id = '$bank_entry_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gid = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = null;
                    $gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_other_schedule set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE id = '$bank_entry_id'");

                    $logarray['table_id']=$bank_entry_id;
                    $logarray['module_name']='Bank Entry Schedule';
                    $logarray['cnt_name']='Schedule';
                    $logarray['action']='Bank Entry Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update actual_other_schedule set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE id = '$bank_entry_id'");

                        $logarray['table_id']=$bank_entry_id;
                        $logarray['module_name']='Bank Entry Schedule';
                        $logarray['cnt_name']='Schedule';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update actual_other_schedule A, actual_other_schedule B set 
                                         A.type=B.type, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.description=B.description, 
                                         A.sch_date=B.sch_date, A.amount=B.amount, 
                                         A.payment_mode=B.payment_mode, A.account_number=B.account_number, 
                                         A.payment_date=B.payment_date, A.cheque_no=B.cheque_no, 
                                         A.gp_id=B.gp_id, A.txn_status='$txn_status', A.created_by=B.created_by, 
                                         A.created_on=B.created_on, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', 
                                         A.approved_date='$modnow', A.remarks='$remarks', 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark 
                                         WHERE B.id = '$bank_entry_id' and A.id=B.txn_fkid");

                        $this->db->query("delete from actual_other_schedule WHERE id = '$bank_entry_id'");
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Schedule';
                        $logarray['cnt_name']='Schedule';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Bank_entry');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getServiceTax(){
        $event_type=$this->input->post("event_type");
        $event_name=$this->input->post("event_name");
        $event_date=$this->input->post("event_date");
        $actual_amount=$this->input->post("actual_amount");
        $fk_txn_id=$this->input->post("fk_txn_id");
        $response=$this->bank_entry_model->getServiceTax($event_type,$event_name,$event_date,$actual_amount,$fk_txn_id);
        echo json_encode($response);
    }

    function getPaidDetails(){
        $event_type=$this->input->post("event_type");
        $event_name=$this->input->post("event_name");
        $event_date=$this->input->post("event_date");
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->bank_entry_model->getPaidDetails($event_type,$event_name,$event_date,$fk_txn_id);
        echo json_encode($response);
    }

    function getTaxPaidDetails(){
        $tax_applied=$this->input->post("tax_applied");
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->bank_entry_model->getTaxPaidDetails($tax_applied,$fk_txn_id);
        echo json_encode($response);
    }

    function getOtherSchedule(){
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->bank_entry_model->getOtherSchedule($fk_txn_id);
        echo json_encode($response);
    }

    function getTaxDetailsView(){
        $form_data=$this->input->post(null,true);
        $response=$this->bank_entry_model->getTaxDetailsView($form_data);
        echo json_encode($response);
    }

    function getTaxDetails(){
        $form_data=$this->input->post(null,true);
        $response=$this->bank_entry_model->getTaxDetails($form_data);
        echo json_encode($response);
    }

    function saveOtherSchDetails(){
        $form_data=$this->input->post(null,true);
        $response=$this->bank_entry_model->saveOtherSchDetails($form_data);
        echo json_encode($response);
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $type=$this->uri->segment(3);
        $status=$this->uri->segment(4);
        
        $dataarray = array();

        if($type=="payment"){
            $dataarray['payment']='selected';
            $dataarray['receipt']='';
        } else if($type=="receipt"){
            $dataarray['payment']='';
            $dataarray['receipt']='selected';
        }

        if($status=="purchase"){
            $dataarray['purchase']='selected';
            $dataarray['txn_type']='purchase';
        } else if($status=="loan"){
            $dataarray['loan']='selected';
            $dataarray['txn_type']='loan';
        } else if($status=="sale"){
            $dataarray['sale']='selected';
            $dataarray['txn_type']='sales';
        } else if($status=="rent"){
            $dataarray['rent']='selected';
            $dataarray['txn_type']='rent';
        } else if($status=="expense"){
            $dataarray['expense']='selected';
            $dataarray['txn_type']='expense';
        } else if($status=="maintenance"){
            $dataarray['maintenance']='selected';
            $dataarray['txn_type']='maintenance';
        } else {
            $dataarray['txn_type']='';
        }

        if($type=="Select"){
            if($status=="purchase"){
                $dataarray['payment']='selected';
            } else if($status=="loan"){
                $dataarray['payment']='selected';
            } else if($status=="sale"){
                $dataarray['receipt']='selected';
            } else if($status=="rent"){
                $dataarray['receipt']='selected';
            } else if($status=="expense"){
                $dataarray['payment']='selected';
            } else if($status=="maintenance"){
                $dataarray['payment']='selected';
            }
        }

        $result=$this->bank_entry_model->getAccess();
        if(count($result)>0) {

            $data['property_details']= $dataarray;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('bank_entry/bank_entry_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function loadpropertydet($pid) {
        $query=$this->db->query("select sum(net_amount) as cost_of_purchase from purchase_schedule where purchase_id = '$pid' and status = '1'");
        $result=$query->result();

        echo $result[0]->cost_of_purchase;
    }

    public function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function get_loan_txn(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $txn_id = html_escape($this->input->post('txn_id'));

        $loan_list = "";
    
        $result=$this->loan_model->loanData("Approved");
        $schedule_table="loan_schedule";
        $sch_type_id='loan_id';

        if (count($result)>0) {
            
            $loan_list = '<option value="0">Select Loan Reference</option>';

            foreach ($result as $row) {
                if($schedule_table!=""){
                    $loan_id=$row->txn_id;
                    $query=$this->db->query("select * from ".$schedule_table." where ".$sch_type_id." = '$loan_id' and status = '1'");
                    $result2=$query->result();

                    if (count($result2)>0) {
                        $loan_txn_id = $row->txn_id;
                        $loan_ref_name = $row->ref_name;

                        if ($txn_id == $loan_txn_id) {
                            $loan_list = $loan_list . '<option value="' . $loan_txn_id . '" selected>' . $loan_ref_name . '</option>';
                        } else {
                            $loan_list = $loan_list . '<option value="' . $loan_txn_id . '">' . $loan_ref_name . '</option>';
                        }
                    }
                }
            }
        }

        echo $loan_list;
    }

    public function get_expense_category() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $expense_category_id = html_escape($this->input->post('expense_category_id'));

        $expense_category_list = "";
        
        $query=$this->db->query("SELECT * FROM expense_category_master WHERE g_id = '$gid'");
        $result=$query->result();

        if (count($result)>0) {
            $expense_category_list = '<option value="">Select Category</option>';

            foreach ($result as $row) {
                $expense_cat_id=$row->id;
                $expense_cat=$row->expense_category;

                if ($expense_category_id == $expense_cat_id) {
                    $expense_category_list = $expense_category_list . '<option value="' . $expense_cat_id . '" selected>' . $expense_cat . '</option>';
                } else {
                    $expense_category_list = $expense_category_list . '<option value="' . $expense_cat_id . '">' . $expense_cat . '</option>';
                }
            }
        }

        echo $expense_category_list;
    }

    public function get_property() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));

        $property_list = "";
    
        if ($status=="purchase" || $status=="other") {
            $result=$this->purchase_model->purchaseData("Approved");
            $schedule_table="purchase_schedule";
            $sch_type_id='purchase_id';
        } else if ($status=="loan") {
            $result=array();
            $schedule_table="";
            $sch_type_id='';
        } else if ($status=="rent") {
            $result=$this->rent_model->rentData("Approved");
            $schedule_table="rent_schedule";
            $sch_type_id='rent_id';
        } else if ($status=="sale") {
            $result=$this->sales_model->salesData("Approved");
            $schedule_table="sales_schedule";
            $sch_type_id='sale_id';
        } else if ($status=="expense") {
            $result=$this->expense_model->expenseData("Approved");
            $schedule_table="expense_schedule";
            $sch_type_id='expense_id';
        } else if ($status=="maintenance") {
            $result=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
            $schedule_table="maintenance_schedule";
            $sch_type_id='m_id';
        } else {
            $result=array();
        }

        if (count($result)>0) {
            
            $property_list = '<option value="0">Select Property</option>';

            foreach ($result as $row) {
                if($schedule_table!=""){
                    $txn_id=$row->txn_id;
                    $query=$this->db->query("select * from ".$schedule_table." where ".$sch_type_id." = '$txn_id' and status = '1'");
                    $result2=$query->result();

                    if (count($result2)>0) {
                        if ($status=="purchase") {
                            $prop_id = $row->txn_id;
                            $prop_name = $row->p_property_name;
                        } else {
                            $prop_id = $row->property_id;
                            $prop_name = $row->p_property_name;
                        }

                        if ($property_id == $prop_id) {
                            $property_list = $property_list . '<option value="' . $prop_id . '" selected>' . $prop_name . '</option>';
                        } else {
                            $property_list = $property_list . '<option value="' . $prop_id . '">' . $prop_name . '</option>';
                        }
                    }
                }
            }
        }

        echo $property_list;
    }

    public function get_sub_property() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));
        $sub_property_id = html_escape($this->input->post('sub_property_id'));

        // $status = "sale";
        // $property_id = "45";
        // $sub_property_id = "0";

        $sub_property_list="";

        if ($status=="purchase") {
            $result=array();
        } else if ($status=="loan") {
            $result=array();
        } else if ($status=="rent") {
            $result=$this->rent_model->rentData("Approved");
        } else if ($status=="sale") {
            $result=$this->sales_model->salesData("Approved");
        } else if ($status=="expense") {
            $result=$this->expense_model->expenseData("Approved");
        } else if ($status=="maintenance") {
            $result=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
        } else {
            $result=array();
        }

        // $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
        // $result=$query->result();

        // $result= $this->sales_model->getSubPropertyDetails($txn_id, $property_id);

        if (count($result)>0) {
            $sub_property_list = '<option value="0">Select Sub Property</option>';

            foreach ($result as $row) {
                if ($property_id == $row->property_id) {
                    if($row->sub_property_id!="0" && $row->sub_property_id!="" && $row->sub_property_id!=null){
                        if ($sub_property_id == $row->sub_property_id) {
                            $sub_property_list = $sub_property_list . '<option value="' . $row->sub_property_id . '" selected>' . $row->sp_name . '</option>';
                        } else {
                            $sub_property_list = $sub_property_list . '<option value="' . $row->sub_property_id . '">' . $row->sp_name . '</option>';
                        }
                    }
                }
            }
        }

        if($sub_property_list == '<option value="0">Select Sub Property</option>'){
            $sub_property_list="";
        }

        echo $sub_property_list;
    }

    public function checkstatus($status=''){
        $result=$this->bank_entry_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['bankentry']=$this->bank_entry_model->bankentryData($status);

            // $count_data=$this->bank_entry_model->getAllCountData();

            $count_data=$this->bank_entry_model->bankentryData('All');
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['pendingbankentry']=$this->bank_entry_model->getPendingBankEntry();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('bank_entry/bank_entry_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>