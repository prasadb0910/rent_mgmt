<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Loan_disbursement extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("loan_disbursement_model");
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function get_loan_details($lid) {
        $data=array();
        $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_id = '$lid'");
        $result=$query->result();

        if (count($result)>0) {
            $data['loan_ref_id']=$result[0]->ref_id;
            $data['loan_ref_name']=$result[0]->ref_name;
            $data['loan_type']=$result[0]->loan_type;
            $data['loan_amount']=format_money($result[0]->loan_amount,2);
            $data['loan_startdate']=$result[0]->loan_startdate;
            $data['loan_due_day']=$result[0]->loan_due_day;
            $data['loan_term']=$result[0]->loan_term;
            $data['loan_interest_rate']=$result[0]->loan_interest_rate;
            $data['loan_interest_type']=$result[0]->interest_type;
            $data['repayment']=$result[0]->repayment;
            $data['purpose']=$result[0]->purpose;
            $data['financial_institution']=$result[0]->financial_institution;
        }

        echo json_encode($data);
    }
    
    public function addnew($lid=''){
		$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%loan%' AND status = '1' and tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;

            $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_status = 'Approved' AND gp_id='$gid'");
            $result=$query->result();
            $data['loan_txn']=$result;

            $data['tax_details']=$this->loan_disbursement_model->getAllTaxes($txn_type=false);

            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $query=$this->db->query("select * from 
                                        (select b_id, concat(b_name, ' - ', b_accountnumber) as b_name from bank_master 
                                            where b_status='Approved' and b_gid='$gid' and 
                                            b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A");
                $result=$query->result();
                $data['bank']=$result;
            } else {
                $query=$this->db->query("select * from 
                                        (select b_id, concat(b_name, ' - ', b_accountnumber) as b_name from bank_master 
                                            where b_status='Approved' and b_gid='$gid') A");
                $result=$query->result();
                $data['bank']=$result;
            }

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            // echo json_encode($data);

            $query=$this->db->query("SELECT ref_id as loan_ref_id, ref_name as loan_ref_name, loan_type, loan_amount, 
                    loan_startdate, loan_due_day, loan_term, loan_interest_rate,interest_type as loan_interest_type,
                    repayment, purpose, financial_institution FROM loan_txn WHERE txn_id = '$lid'");
            $result1=$query->result();
            $data['loanD'] = $result1;
            load_view('loan/loan_disbursement_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modinow=date('Y-m-d H:i:s');

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $loan_id = $this->input->post('loan_id');
            if($this->input->post('disbursement_date')!=''){
                $disbursement_date=FormatDate($this->input->post('disbursement_date'));
            } else {
                $disbursement_date=NULL;
            }
            $disbursement_amount=format_number($this->input->post('disbursement_amount'),2);

            $data = array(
                'loan_id' => $loan_id,
                'ref_id' => $this->input->post('ref_id'),
                'ref_name' => $this->input->post('ref_name'),
                'disbursement_amount' => $disbursement_amount,
                'disbursement_date' => $disbursement_date,
                'emi' => format_number($this->input->post('emi'),2),
                'issuer_bank' => $this->input->post('issuer_bank_id'),
                'receiver_bank' => $this->input->post('receiver_bank_id'),
                'payment_mode' => $this->input->post('payment_mode'),
                'cheque_no' => $this->input->post('cheq_no'),
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'gp_id' => $gid,
                'maker_remark'=>$this->input->post('maker_remark')
            );
            $this->db->insert('loan_disbursement', $data);
            $lid=$this->db->insert_id();

            $logarray['table_id']=$lid;
            $logarray['module_name']='Loan Disbursement';
            $logarray['cnt_name']='Loan_disbursement';
            $logarray['action']='Loan Disbursement Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);
            
            $this->loan_disbursement_model->insertSchedule($loan_id, $lid, $txn_status);

            $this->loan_disbursement_model->insertImage($lid);

            $this->loan_disbursement_model->send_loan_disbursement_intimation($lid, $loan_id, $disbursement_amount);
            redirect(base_url().'index.php/loan');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($lid){
        $this->get_record($lid, 'loan/loan_disbursement_view');
    }

    public function edit($lid){
        $this->get_record($lid, 'loan/loan_disbursement_details');
    }

    public function get_record($lid, $view){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $data['loanby']=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;

            $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_status = 'Approved' AND gp_id='$gid'");
            $result=$query->result();
            $data['loan_txn']=$result;

            $query=$this->db->query("SELECT * FROM loan_disbursement WHERE txn_fkid = '$lid'");
            $result1=$query->result();
            if (count($result1)>0){
                $lid = $result1[0]->txn_id;
            }

            $query=$this->db->query("SELECT * FROM loan_disbursement WHERE txn_id = '$lid'");
            $result1=$query->result();
            if (count($result1)>0){
                $loan_id = $result1[0]->loan_id;
            } else {
                $loan_id = 0;
            }

            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%loan%' AND status = '1' and tax_action='1'"); 
            $result=$query->result();
            $data['tax']=$result;

            $sql = "select E.*, F.ref_id as loan_ref_id, F.ref_name as loan_ref_name, F.loan_type, F.loan_amount, 
                    F.loan_startdate, F.loan_due_day, F.loan_term, F.loan_interest_rate, F.interest_type as loan_interest_type,
                    F.repayment, F.purpose, F.financial_institution, F.c_name, F.c_last_name, F.c_emailid1, F.owner_name, 
                    F.property_id, F.sub_property_id, F.property, F.p_property_name, F.p_display_name, F.p_type, F.sp_name from 
                    (select C.*, concat(D.b_name,' - ',D.b_accountnumber) as receiver_bank_name from 
                    (select A.*, concat(B.b_name,' - ',B.b_accountnumber) as issuer_bank_name from 
                    (select * from loan_disbursement where txn_id = '$lid') A 
                    left join 
                    (select * from bank_master where b_status='Approved') B 
                    on A.issuer_bank=B.b_id) C 
                    left join 
                    (select * from bank_master where b_status='Approved') D 
                    on C.receiver_bank=D.b_id) E 
                    left join 
                    (select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name from 
                    (select * from 
                    (select C.*, D.loan_id, D.brower_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                    (select * from loan_txn where gp_id='$gid' and txn_id='$loan_id') C 
                    left join 
                    (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                    (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id)) A 
                    left join 
                    (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') B 
                    on (A.brower_id=B.c_id)) D 
                    on C.txn_id=D.loan_id) E 
                    where E.owner_name is not null and E.owner_name<>'') F
                    left join 
                    (select C.loan_id, C.property_id, C.sub_property_id, C.property, C.p_property_name, C.p_display_name, C.p_type, D.sp_name from 
                    (select A.loan_id, A.property_id, A.sub_property_id, A.property, B.p_property_name, B.p_display_name, B.p_type from 
                    (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                    left join 
                    (select * from purchase_txn where gp_id='$gid') B 
                    on A.property_id = B.txn_id) C 
                    left join 
                    (select * from sub_property_allocation where gp_id='$gid') D 
                    on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                    on F.txn_id = G.loan_id) F 
                    on E.loan_id=F.txn_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $data['editloan']=$result;
                if ($result[0]->txn_status=="Approved") {
                    $txn_status=1;
                } else {
                    $txn_status=3;
                }
            } else {
                $txn_status=3;
            }

            $distict_tax=$this->loan_disbursement_model->getDistinctTaxDetail($lid, $txn_status);
            $data['tax_name']=$distict_tax;
            // print_r($distict_tax);
            // $data['tax_name']=$distict_tax;
            $event_type='';
            $event_name='';
            $basic_amount=0;
            $net_amount=0;
            $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM loan_schedule  WHERE loan_disbursement_id = '".$lid."' and status = '$txn_status' GROUP BY event_type";
            //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$lid."' and status = '1' ");
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['p_schedule']=array();
            //echo $lid;
           
            $k=0;
            if(count($result)>0) {
                foreach($result as $row){                     

                    $data['p_schedule'][$k]['event_type']=$row->event_type;
                    $data['p_schedule'][$k]['event_name']=$event_name;
                    $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                    $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                        //distint tax name
                    $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM loan_schedule_taxation WHERE loan_disbursement_id = '".$lid."' and event_type = '".$row->event_type."' and status = '$txn_status' group by tax_type order by tax_type asc ");
                    $result_tax=$query->result();
                    $j=0;
                    if(count($result_tax) > 0){
                        foreach($result_tax as $taxrow){
                            $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                            $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                            //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                            $j++;
                        }
                    }

                    $k++;
                }
            }

            $query=$this->db->query("SELECT sum(tax_amount) as total_tax_amount FROM loan_schedule_taxation WHERE loan_disbursement_id = '".$lid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
            $result_tax=$query->result();
            //echo $this->db->last_query();
            $k=0;
            foreach($result_tax as $row){
                $data['total_tax_amount'][$k]=$row->total_tax_amount;
                $k++;
            }


            //for edit
           $sql="SELECT * FROM loan_schedule  WHERE loan_disbursement_id = '".$lid."' and status = '$txn_status' ";
            //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$lid."' and status = '1' ");
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['p_schedule1']=array();
            //echo $lid;
           
            $k=0;
            if(count($result)>0) {
                foreach($result as $row) {
                    $data['p_schedule1'][$k]['schedule_id']=$row->sch_id;
                    $data['p_schedule1'][$k]['event_type']=$row->event_type;
                    $data['p_schedule1'][$k]['event_name']=$row->event_name;
                    $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                    $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                    $data['p_schedule1'][$k]['event_date']=$row->event_date;

                    //distint tax name
                    $query=$this->db->query("SELECT * FROM loan_schedule_taxation WHERE loan_disbursement_id = '".$lid."' and event_type = '".$row->event_type."' and status = '$txn_status' order by tax_master_id Asc ");
                    $result_tax=$query->result();
                    $j=0;
                    if(count($result_tax) > 0){
                        foreach($result_tax as $taxrow){
                            $data['p_schedule1'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                            $data['p_schedule1'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                            $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                            $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                            $data['p_schedule1'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                            $j++;
                        }
                    }

                    //$data['p_schtxn']=$result;
                    $k++;
                }
            }

            $data['tax_details']=$this->loan_disbursement_model->getAllTaxes($txn_type=false);

            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $query=$this->db->query("select * from 
                                        (select b_id, concat(b_name, ' - ', b_accountnumber) as b_name from bank_master 
                                            where b_status='Approved' and b_gid='$gid' and 
                                            b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A");
                $result=$query->result();
                $data['bank']=$result;
            } else {
                $query=$this->db->query("select * from 
                                        (select b_id, concat(b_name, ' - ', b_accountnumber) as b_name from bank_master 
                                            where b_status='Approved' and b_gid='$gid') A");
                $result=$query->result();
                $data['bank']=$result;
            }

            $data['l_id']=$lid;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view($view, $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($lid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($lid);
        } else  {
            $this->updaterecord($lid);
        }
    }

    public function updaterecord($lid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid'");
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

            $query=$this->db->query("SELECT * FROM loan_disbursement WHERE txn_id = '$lid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
                $loan_id = $res[0]->loan_id;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
                $loan_id = '';
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update loan_disbursement set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                            modified_by='$curusr', modified_date='$modnow' WHERE txn_id = '$lid'");

                            $logarray['table_id']=$lid;
                            $logarray['module_name']='Loan Disbursement';
                            $logarray['cnt_name']='Loan_disbursement';
                            $logarray['action']='Loan Disbursement Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM loan_disbursement WHERE txn_fkid = '$lid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $lid = $result[0]->txn_id;

                                $this->db->query("Update loan_disbursement set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$lid'");

                                $logarray['table_id']=$lid;
                                $logarray['module_name']='Loan Disbursement';
                                $logarray['cnt_name']='Loan_disbursement';
                                $logarray['action']='Loan Disbursement Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into loan_disbursement (gp_id, loan_id, ref_id, ref_name, disbursement_amount, 
                                                 disbursement_date, emi, issuer_bank, receiver_bank, payment_mode, cheque_no, 
                                                 txn_status, create_date, created_by, 
                                                 modified_date, modified_by, approved_by, approved_date, txn_remarks, txn_fkid, 
                                                 rejected_by, rejected_date, maker_remark, image, image_name) 
                                                 Select '$gp_id', loan_id, ref_id, ref_name, disbursement_amount, 
                                                 disbursement_date, emi, issuer_bank, receiver_bank, payment_mode, cheque_no, 
                                                 '$txn_status', '$create_date', '$created_by', 
                                                 '$modnow', '$curusr', approved_by, approved_date, '$txnremarks', '$lid', 
                                                 rejected_by, rejected_date, maker_remark, image, image_name 
                                                 FROM loan_disbursement WHERE txn_id = '$lid'");
                                $new_lid=$this->db->insert_id();

                                $logarray['table_id']=$lid;
                                $logarray['module_name']='Loan Disbursement';
                                $logarray['cnt_name']='Loan_disbursement';
                                $logarray['action']='Loan Disbursement Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $query=$this->db->query("SELECT * FROM loan_schedule WHERE loan_disbursement_id = '$lid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into loan_schedule (loan_id, loan_disbursement_id, event_name, 
                                                         event_type, event_date, basic_cost, net_amount, sch_status, create_date, 
                                                         create_by, modified_date, modified_by, status) 
                                                         Select '$loan_id', '$new_lid', event_name, event_type, event_date, 
                                                         basic_cost, net_amount, '3', '$sch_create_date', '$sch_create_by', 
                                                         '$modnow', '$curusr', '3' FROM loan_schedule 
                                                         WHERE loan_disbursement_id = '$lid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into loan_schedule_taxation (sch_id, tax_master_id, tax_type, 
                                                         tax_percent, tax_amount, loan_id, loan_disbursement_id, event_type, status) 
                                                         Select '$new_sch_id', tax_master_id, tax_type, tax_percent, tax_amount, 
                                                         '$new_lid', '$loan_id', event_type, '3' 
                                                         FROM loan_schedule_taxation 
                                                         WHERE loan_disbursement_id = '$lid' and sch_id = '$sch_id'");
                                    }
                                }
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $lid);
                        $this->db->delete('loan_disbursement');

                        $this->db->where('loan_disbursement_id', $lid);
                        $this->db->delete('loan_schedule');

                        $this->db->where('loan_disbursement_id', $lid);
                        $this->db->delete('loan_schedule_taxation');

                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan Disbursement';
                        $logarray['cnt_name']='Loan_disbursement';
                        $logarray['action']='Loan Disbursement Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Loan_disbursement');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $now=date('Y-m-d H:i:s');
                    $modnow=date('Y-m-d H:i:s');

                    $loan_id = $this->input->post('loan_id');
                    if($this->input->post('disbursement_date')!=''){
                        $disbursement_date=FormatDate($this->input->post('disbursement_date'));
                    } else {
                        $disbursement_date=NULL;
                    }
                    
                    $data = array(
                        'loan_id' => $loan_id,
                        'ref_id' => $this->input->post('ref_id'),
                        'ref_name' => $this->input->post('ref_name'),
                        'disbursement_amount' => format_number($this->input->post('disbursement_amount'),2),
                        'disbursement_date' => $disbursement_date,
                        'emi' => format_number($this->input->post('emi'),2),
                        'issuer_bank' => $this->input->post('issuer_bank_id'),
                        'receiver_bank' => $this->input->post('receiver_bank_id'),
                        'payment_mode' => $this->input->post('payment_mode'),
                        'cheque_no' => $this->input->post('cheq_no'),
                        'create_date' => $now,
                        'created_by' => $curusr,
                        'modified_date' => $now,
                        'modified_by' => $curusr,
                        'txn_status' => $txn_status,
                        'gp_id' => $gid,
                        'maker_remark'=>$this->input->post('maker_remark')
                    );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $lid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('loan_disbursement',$data);
                        $lid=$this->db->insert_id();

                        $sql = "update loan_disbursement A, loan_disbursement B set A.image = B.image, A.image_name = B.image_name 
                                where A.txn_id = '$lid' and B.txn_id = '$txn_fkid'";
                        $this->db->query($sql);

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Loan Disbursement';
                        $logarray['cnt_name']='Loan_disbursement';
                        $logarray['action']='Loan Disbursement Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $lid);
                        $this->db->update('loan_disbursement',$data);
                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan Disbursement';
                        $logarray['cnt_name']='Loan_disbursement';
                        $logarray['action']='Loan Disbursement Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('loan_disbursement_id', $lid);
                        $this->db->delete('loan_schedule');
                        
                        $this->db->where('loan_disbursement_id', $lid);
                        $this->db->delete('loan_schedule_taxation');
                    }

                    // if ($txn_status!="Delete" || $rec_status=="Approved") {

                        $this->loan_disbursement_model->insertSchedule($loan_id, $lid, $txn_status);

                        $this->loan_disbursement_model->insertImage($lid);

                    // }

                    redirect(base_url().'index.php/Loan_disbursement');

                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($lid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM loan_disbursement WHERE txn_id = '$lid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update loan_disbursement set txn_status='Rejected', txn_remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$lid'");

                    $logarray['table_id']=$lid;
                    $logarray['module_name']='Loan Disbursement';
                    $logarray['cnt_name']='Loan_disbursement';
                    $logarray['action']='Loan Disbursement Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update loan_disbursement set txn_status='Approved', txn_remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$lid'");
                        $this->db->query("update loan_schedule set sch_status = '1', status='1' WHERE loan_disbursement_id = '$lid'");
                        $this->db->query("update loan_schedule_taxation set status='1' WHERE loan_disbursement_id = '$lid'");

                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan Disbursement';
                        $logarray['cnt_name']='Loan_disbursement';
                        $logarray['action']='Loan Disbursement Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update loan_disbursement A, loan_disbursement B set A.gp_id=B.gp_id, 
                                         A.loan_id=B.loan_id, A.ref_id=B.ref_id, A.ref_name=B.ref_name, 
                                         A.disbursement_amount=B.disbursement_amount, A.disbursement_date=B.disbursement_date, 
                                         A.emi=B.emi, A.issuer_bank=B.issuer_bank, A.receiver_bank=B.receiver_bank, 
                                         A.payment_mode=B.payment_mode, A.cheque_no=B.cheque_no, 
                                         A.txn_status='$txn_status', A.create_date=B.create_date, 
                                         A.created_by=B.created_by, A.modified_date=B.modified_date, A.modified_by=B.modified_by, 
                                         A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.txn_remarks='$remarks', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, A.image=B.image, A.image_name=B.image_name 
                                         WHERE B.txn_id = '$lid' and A.txn_id=B.txn_fkid");

                        $this->db->query("update loan_schedule set sch_status = '2', status='2' WHERE loan_disbursement_id = '$txn_fkid'");
                        $this->db->query("update loan_schedule set loan_disbursement_id = '$txn_fkid', sch_status = '1', status='1' WHERE loan_disbursement_id = '$lid'");

                        $this->db->query("update loan_schedule_taxation set status='2' WHERE loan_disbursement_id = '$txn_fkid'");
                        $this->db->query("update loan_schedule_taxation set loan_disbursement_id = '$txn_fkid', status='1' WHERE loan_disbursement_id = '$lid'");

                        $this->db->query("delete from loan_disbursement WHERE txn_id = '$lid'");
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Loan Disbursement';
                        $logarray['cnt_name']='Loan_disbursement';
                        $logarray['action']='Loan Disbursement Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/loan_disbursement');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status='', $lid='') {
        $result=$this->loan_disbursement_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['loan']=$this->loan_disbursement_model->loanData($status, '', '', $lid);

            $count_data=$this->loan_disbursement_model->loanData('', '', '', $lid);
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;
            $all=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->txn_status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="PENDING" || strtoupper(trim($count_data[$i]->txn_status))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                    
                    if (strtoupper(trim($count_data[$i]->txn_status))=="IN PROCESS" || strtoupper(trim($count_data[$i]->txn_status))=="APPROVED" || strtoupper(trim($count_data[$i]->txn_status))=="PENDING" || strtoupper(trim($count_data[$i]->txn_status))=="REJECTED")
                        $all=$all+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=$all;

            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['lid'] = $lid;
            load_view('loan/loan_disbursement_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    function check_availablity() {
        $gid=$this->session->userdata('groupid');
        $l_id = html_escape($this->input->post('l_id'));
        $l_ref_id = html_escape($this->input->post('l_ref_id'));

        // $gid='6';
        // $l_id = '56';
        // $l_ref_id = 'qwer';

        $result = $this->loan_disbursement_model->check_availablity($gid, $l_id, $l_ref_id);
        echo $result;
    }
}
?>