<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Expense extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('expense_model');
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function checkstatus($status=''){
        $result=$this->expense_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;

            $gid=$this->session->userdata('groupid');
            $roleid=$this->session->userdata('role_id');

            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            $sql = "select G.*, H.expense_category from 
                    (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
                    (select C.*, D.sp_name from 
                    (select A.*, B.p_property_name from 
                    (select A.*, B.b_name as bank_name_name from 
                    (select * from expense_txn where gp_id='$gid') A 
                    left join 
                    (select * from bank_master where b_gid='$gid') B 
                    on (A.bank_name=B.b_id)) A 
                    left join 
                    (select * from purchase_txn where txn_status='Approved' and gp_id='$gid') B 
                    on A.property_id=B.txn_id) C 
                    left join 
                    (select * from sub_property_allocation where txn_status='Approved' and gp_id='$gid') D 
                    on C.sub_property_id=D.txn_id) E 
                    left join 
                    (select * from contact_master where c_status='Approved' and c_gid='$gid') F 
                    on E.vendor_id=F.c_id) G 
                    left join 
                    (select * from expense_category_master where g_id='$gid') H 
                    on G.category=H.id
                    ORDER BY G.modified_date DESC";
            $query=$this->db->query($sql);
            $result=$query->result();

            if (count($result)>0){
                $j=0;

                for($i=0;$i<count($result);$i++){
                    if (strtoupper(trim($result[$i]->txn_status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($result[$i]->txn_status))=="PENDING" || strtoupper(trim($result[$i]->txn_status))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($result[$i]->txn_status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($result[$i]->txn_status))=="IN PROCESS")
                        $inprocess=$inprocess+1;

                    if($status=='All'){
                        $data['expense'][$j]=$result[$i];
                        $j=$j+1;
                    } else if($status=='Approved' && strtoupper(trim($result[$i]->txn_status))=="APPROVED") { 
                        $data['expense'][$j]=$result[$i];
                        $j=$j+1;
                    } else if($status=='Pending' && (strtoupper(trim($result[$i]->txn_status))=="PENDING" || strtoupper(trim($result[$i]->txn_status))=="DELETE")) { 
                        $data['expense'][$j]=$result[$i];
                        $j=$j+1;
                    } else if($status=='InProcess' && strtoupper(trim($result[$i]->txn_status))=="IN PROCESS") { 
                        $data['expense'][$j]=$result[$i];
                        $j=$j+1;
                    } else if($status=='Rejected' && strtoupper(trim($result[$i]->txn_status))=="REJECTED") { 
                        $data['expense'][$j]=$result[$i];
                        $j=$j+1;
                    }
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($result);

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('expense/expenses_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid' and txn_status = 'Approved'");
            $result=$query->result();
            $data['property']=$result;
            
            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid' and ow_status = 'Approved'");
            $result=$query->result();
            $data['owner']=NULL;
            for ($i=0; $i < count($result) ; $i++) { 
               if($result[$i]->ow_type==0) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $cid=$result[$i]->ow_ind_id;
                    $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                    $res1=$quer->result();
                    $data['owner'][$i]['name']=$res1[0]->c_name;
                } else if($result[$i]->ow_type==1) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_huf_name;
                } else if($result[$i]->ow_type==2) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_pvtltd_comapny_name;
                } else if($result[$i]->ow_type==3) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_ltd_comapny_name;
                } else if($result[$i]->ow_type==4) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_llp_comapny_name;
                } else if($result[$i]->ow_type==5) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_prt_comapny_name;
                } else if($result[$i]->ow_type==6) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_aop_comapny_name;
                } else if($result[$i]->ow_type==7) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_trs_comapny_name;
                } else if($result[$i]->ow_type==8) {
                    $data['owner'][$i]['id']=$result[$i]->ow_id;
                    $data['owner'][$i]['name']=$result[$i]->ow_proprietorship_comapny_name;
                }
            }
            
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid' and c_status = 'Approved'");
            $result=$query->result();
            $data['contacts']=$result;
            
            $query=$this->db->query("SELECT * FROM expense_category_master WHERE g_id = '$gid' order by expense_category");
            $result=$query->result();
            $data['expense_category']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('expense/expenses_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function loadsubproperty($pid, $eid=NULL){
         $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$pid' and txn_status = 'Approved'");
         $result=$query->result();
         $data='<option value="">Select Sub Property</option>';
         for ($i=0; $i < count($result) ; $i++) { 
            $data=$data.'<option value="'.$result[$i]->txn_id.'"';
            if($eid!=NULL) {
                $que=$this->db->query("SELECT * FROM expense_txn WHERE txn_id = '$eid'");
                $res=$que->result();
                if($res[0]->sub_property_id==$result[$i]->txn_id) {
                    $data=$data." selected ";
                }
            }
            $data=$data.'>'.$result[$i]->sp_name.'</option>';
         }
         echo $data;
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');
            
            $payment_time = $this->input->post('payment_time');
            $payment_mode = $this->input->post('payment_mode');
            $category = $this->input->post('category');
            $property_id = $this->input->post('property');
            $sub_property_id = $this->input->post('sub_property');
            $description = $this->input->post('description');
            if($this->input->post('expense_date')==''){
                $expense_date=NULL;
            } else {
                $expense_date=FormatDate($this->input->post('expense_date'));
            }

            if($payment_time=='later'){
                $from_time=$this->input->post('from_time');
                $to_time=$this->input->post('to_time');
                $repeat=$this->input->post('repeat');
                $interval2=$this->input->post('monthly_interval2');

                if($this->input->post('repeat')=='Weekly'){
                    $interval=implode(',',$this->input->post('weekly_interval'));
                }elseif($this->input->post('repeat')=='Periodically'){
                    $interval=$this->input->post('periodic_interval');
                }elseif($this->input->post('repeat')=='Monthly'){
                    $interval=$this->input->post('monthly_interval');
                }else{
                    $interval='';
                }

                $from_date = FormatDate($this->input->post('from_date'));
                $to_date = FormatDate($this->input->post('to_date'));
                $due_date = FormatDate($this->input->post('from_date'));
                $cur_date = date('Y-m-d');
            } else {
                $from_time=NULL;
                $to_time=NULL;
                $repeat=NULL;
                $interval2=NULL;
                $property=NULL;
                $owner_name=NULL;
                $interval=NULL;
                $from_date = NULL;
                $to_date = NULL;
                $due_date = NULL;
                $cur_date = NULL;
            }

            if($payment_time=='now' and $payment_mode=='Cheque') {
                $cheque_no = $this->input->post('cheque_no');
                if($this->input->post('cheque_date')==''){
                    $chqdt=NULL;
                } else {
                    $chqdt=FormatDate($this->input->post('cheque_date'));
                }
                $bank_name = $this->input->post('bank_name');
                $cheque_amount = format_number($this->input->post('cheque_amount'),2);
                $micr_code = $this->input->post('micr_code');
            } else {
                $cheque_no = NULL;
                $chqdt = NULL;
                $bank_name = NULL;
                $cheque_amount = NULL;
                $micr_code = NULL;
            }

            if($payment_time=='now' and $payment_mode=='NEFT') {
                $ref_no = $this->input->post('ref_no');
            } else {
                $ref_no = NULL;
            }

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            if($txn_status=='Approved'){
                $sch_status = '1';
            } else {
                $sch_status = '3';
            }

            if($this->input->post('sub_property')!=null){
                $sub_property = $this->input->post('sub_property');
            } else {
                $sub_property = '0';
            }

            $data = array(
                'property_id' => $property_id,
                'sub_property_id' => $sub_property,
                'vendor_id' => $this->input->post('vendor'),
                'expense_description' => $description,
                'escalation' => format_number($this->input->post('escalations'),2),
                'expense_date' => $expense_date,
                'expense_amount' => format_number($this->input->post('expense_amount'),2),
                'category' => $category,
                'payment_time' => $payment_time,
                'payment_mode' => $payment_mode,
                'cheque_number' => $cheque_no,
                'cheque_date' => $chqdt,
                'bank_name' => $bank_name,
                'cheque_amount' => $cheque_amount,
                'micr_code' => $micr_code,
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'gp_id' => $gid,
                'from_date' => $from_date,
                'from_time' => $from_time,
                'to_date' => $to_date,
                'to_time' => $to_time,
                'due_date' => $due_date,
                'repeat_status' => $repeat,
                'period_interval'=>$interval,
                'monthly_repeat'=>$interval2,
                'status'=>'1',
                'maker_remark' => $this->input->post('maker_remark'),
                'ref_no' => $ref_no,
                'mail_sent' => '0'
            );
    
            $this->db->insert('expense_txn', $data);
            $eid = $this->db->insert_id();

            $logarray['table_id']=$eid;
            $logarray['module_name']='Expense';
            $logarray['cnt_name']='Expense';
            $logarray['action']='Expense Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            if($payment_time=='later'){
                $week_index=0;
                $task_status='Pending';
                $weekly_interval=$this->input->post('weekly_interval');

                $query=$this->db->query("SELECT * FROM expense_category_master WHERE id = '$category'");
                $result2=$query->result();
                if(count($result2)>0) {
                    $event_type = $result2[0]->expense_category;
                } else {
                    $event_type = '';
                }

                while($due_date<=$to_date) {
                    if($due_date>=$cur_date) {

                        if($this->input->post('sub_property')!=null){
                            $sub_property = $this->input->post('sub_property');
                        } else {
                            $sub_property = '0';
                        }

                        $insertArray=array(
                                        'expense_id' =>$eid,
                                        'category' => $category,
                                        'event_type' => $event_type,
                                        'event_name' => $description,
                                        'basic_cost' => format_number($this->input->post('expense_amount'),2),
                                        'net_amount' => format_number($this->input->post('expense_amount'),2),
                                        'task_status' => $task_status,
                                        'from_date' => $from_date,
                                        'from_time' => $from_time,
                                        'to_date' => $to_date,
                                        'to_time' => $to_time,
                                        'event_date' => $due_date,
                                        'repeat_status' => $repeat,
                                        'period_interval'=>$interval,
                                        'monthly_repeat'=>$interval2,
                                        'sch_status'=>$sch_status,
                                        'status'=>$sch_status,
                                        'property_id'=>$property_id,
                                        'sub_property_id'=>$sub_property
                                    );

                        $query=$this->db->query("select * from expense_schedule where expense_id='$eid' and event_date='$due_date' and status='$sch_status'");
                        if($query->num_rows()==0){
                            $insertExtra=array(
                                    'create_by' => $this->session->userdata('session_id')
                                );
                            $newArray=array_merge($insertArray,$insertExtra);
                            $this->db->insert('expense_schedule',$newArray);
                        }
                    }

                    if($repeat=="Daily") {
                        $due_date = date ("Y-m-d", strtotime ($due_date ."+1 days"));
                    } else if($repeat=="Periodically") {
                        $due_date = date ("Y-m-d", strtotime ($due_date ."+".$interval." days"));
                    } else if($repeat=="Weekly") {
                        $week_day="";

                        if (isset($weekly_interval[$week_index])) {
                            $week_day=$weekly_interval[$week_index];
                            $week_index=$week_index+1;
                            if (! isset($weekly_interval[$week_index])) {
                                $week_index=0;
                            }
                        }

                        if($week_day=="Mon") $week_day="monday";
                        else if($week_day=="Tue") $week_day="tuesday";
                        else if($week_day=="Wed") $week_day="wednesday";
                        else if($week_day=="Thu") $week_day="thursday";
                        else if($week_day=="Fri") $week_day="friday";
                        else if($week_day=="Sat") $week_day="saturday";
                        else if($week_day=="Sun") $week_day="sunday";

                        if($week_day!=''){
                            $date = new DateTime($due_date);
                            $date->modify('next ' . $week_day);
                            $due_date = $date->format('Y-m-d');
                        }
                    } else if($repeat=="Monthly") {
                        $date = explode('-',$due_date);
                        $due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
                        $d = DateTime::createFromFormat("Y-m-d", $due_date);
                        $due_date = strval($d->format('Y-m-d'));
                    } else if($repeat=="Yearly") {
                        $due_date = date ("Y-m-d", strtotime ($due_date ."+1 years"));
                    }
                }
            }

            redirect(base_url().'index.php/Expense');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($eid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1){
                $data['access']=$result;

                $data['e_id']=$eid;

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid' and txn_status = 'Approved'");
                $result=$query->result();
                $data['property']=$result;
                
                $sql = "select G.*, H.expense_category from 
                        (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
                        (select C.*, D.sp_name from 
                        (select A.*, B.p_property_name from 
                        (select A.*, B.b_name as bank_name_name from 
                        (select * from expense_txn where gp_id='$gid' and txn_id='$eid') A 
                        left join 
                        (select * from bank_master where b_gid='$gid') B 
                        on (A.bank_name=B.b_id)) A 
                        left join 
                        (select * from purchase_txn where txn_status='Approved' and gp_id='$gid') B 
                        on A.property_id=B.txn_id) C 
                        left join 
                        (select * from sub_property_allocation where txn_status='Approved' and gp_id='$gid') D 
                        on C.sub_property_id=D.txn_id) E 
                        left join 
                        (select * from contact_master where c_status='Approved' and c_gid='$gid') F 
                        on E.vendor_id=F.c_id) G 
                        left join 
                        (select * from expense_category_master where g_id='$gid') H 
                        on G.category=H.id
                        ORDER BY G.modified_date DESC";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['expense']=$result;
                    
                $query=$this->db->query("SELECT * FROM expense_category_master WHERE g_id = '$gid' order by expense_category");
                $result=$query->result();
                $data['expense_category']=$result;

                    
                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('expense/expenses_details',$data);
            
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo "Unauthorized access";
        }
    }

    public function view($eid){
        $result=$this->expense_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;

            $data['e_id']=$eid;

            $gid=$this->session->userdata('groupid');
            $roleid=$this->session->userdata('role_id');
            $data['expenseby']=$this->session->userdata('session_id');

            $sql = "select G.*, H.expense_category from 
                    (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
                    (select C.*, D.sp_name from 
                    (select A.*, B.p_property_name from 
                    (select A.*, B.b_name as bank_name_name from 
                    (select * from expense_txn where gp_id='$gid' and txn_id='$eid') A 
                    left join 
                    (select * from bank_master where b_gid='$gid') B 
                    on (A.bank_name=B.b_id)) A 
                    left join 
                    (select * from purchase_txn where txn_status='Approved' and gp_id='$gid') B 
                    on A.property_id=B.txn_id) C 
                    left join 
                    (select * from sub_property_allocation where txn_status='Approved' and gp_id='$gid') D 
                    on C.sub_property_id=D.txn_id) E 
                    left join 
                    (select * from contact_master where c_status='Approved' and c_gid='$gid') F 
                    on E.vendor_id=F.c_id) G 
                    left join 
                    (select * from expense_category_master where g_id='$gid') H 
                    on G.category=H.id
                    ORDER BY G.modified_date DESC";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['expense']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('expense/expenses_view', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updaterecord($eid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid'");
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

            if($txn_status=='Approved'){
                $sch_status = '1';
            } else {
                $sch_status = '3';
            }

            $query=$this->db->query("SELECT * FROM expense_txn WHERE txn_id = '$eid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
                $mail_sent = $res[0]->mail_sent;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
                $mail_sent = '0';
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update expense_txn set txn_status='$txn_status', txn_remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$eid'");
                            $logarray['table_id']=$eid;
                            $logarray['module_name']='Expense';
                            $logarray['cnt_name']='Expense';
                            $logarray['action']='Expense Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM expense_txn WHERE txn_fkid = '$eid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $eid = $result[0]->txn_id;

                                $this->db->query("Update expense_txn set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$eid'");
                                $logarray['table_id']=$eid;
                                $logarray['module_name']='Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Expense Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into expense_txn (client_id, property_id, sub_property_id, 
                                                vendor_id, expense_description, escalation, expense_date, expense_amount, category, 
                                                payment_time, payment_mode, cheque_number, cheque_date, bank_name, cheque_amount, 
                                                micr_code, created_by, create_date, modified_by, modified_date, approved_by, 
                                                approved_date, rejected_by, rejected_date, txn_status, txn_remarks, gp_id, 
                                                from_date, from_time, to_date, to_time, due_date, repeat_status, period_interval, 
                                                monthly_repeat, status, maker_remark, txn_fkid, ref_no, mail_sent) 
                                                Select client_id, property_id, sub_property_id, 
                                                vendor_id, expense_description, escalation, expense_date, expense_amount, category, 
                                                payment_time, payment_mode, cheque_number, cheque_date, bank_name, cheque_amount, 
                                                micr_code, '$created_by', '$create_date', '$curusr', '$modnow', approved_by, 
                                                approved_date, rejected_by, rejected_date, '$txn_status', '$txnremarks', '$gp_id', 
                                                from_date, from_time, to_date, to_time, due_date, repeat_status, period_interval, 
                                                monthly_repeat, status, maker_remark, '$eid', ref_no, mail_sent 
                                                FROM expense_txn WHERE txn_id = '$eid'");
                                $new_eid=$this->db->insert_id();
                                $logarray['table_id']=$eid;
                                $logarray['module_name']='Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Expense Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $query=$this->db->query("SELECT * FROM expense_schedule WHERE expense_id = '$eid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into expense_schedule (expense_id, category, event_type, event_name, event_date, basic_cost, 
                                                         net_amount, from_date, from_time, to_date, to_time, repeat_status, period_interval, monthly_repeat, 
                                                         sch_status, status, task_status, create_date, create_by, modified_date, modified_by, property_id, 
                                                         sub_property_id, remarks) 
                                                         Select '$new_eid', category, event_type, event_name, event_date, basic_cost, net_amount, 
                                                         from_date, from_time, to_date, to_time, repeat_status, period_interval, monthly_repeat, 
                                                         '3', '3', task_status, '$sch_create_date', '$sch_create_by', '$modnow', '$cursur', property_id, 
                                                         sub_property_id, remarks 
                                                         FROM expense_schedule WHERE expense_id = '$eid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into expense_schedule_taxation (sch_id, tax_type, tax_percent, 
                                                         tax_amount, expense_id, event_type, tax_master_id, status) 
                                                         Select '$new_sch_id', tax_type, tax_percent, tax_amount, '$new_eid', 
                                                         event_type, tax_master_id, status FROM expense_schedule_taxation 
                                                         WHERE expense_id = '$eid' and sch_id = '$sch_id'");
                                    }
                                }
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $eid);
                        $this->db->delete('expense_txn');

                        $this->db->where('expense_id', $eid);
                        $this->db->delete('expense_schedule');

                        $this->db->where('expense_id', $eid);
                        $this->db->delete('expense_schedule_taxation');

                        $logarray['table_id']=$eid;
                        $logarray['module_name']='Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Expense Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Expense');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $payment_time = $this->input->post('payment_time');
                    $payment_mode = $this->input->post('payment_mode');
                    $category = $this->input->post('category');
                    $property_id = $this->input->post('property');
                    $sub_property_id = $this->input->post('sub_property');
                    $description = $this->input->post('description');
                    if($this->input->post('expense_date')==''){
                        $expense_date=NULL;
                    } else {
                        $expense_date=FormatDate($this->input->post('expense_date'));
                    }

                    if($payment_time=='later'){
                        $from_time=$this->input->post('from_time');
                        $to_time=$this->input->post('to_time');
                        $repeat=$this->input->post('repeat');
                        $interval2=$this->input->post('monthly_interval2');

                        if($this->input->post('repeat')=='Weekly'){
                            $interval=implode(',',$this->input->post('weekly_interval'));
                        }elseif($this->input->post('repeat')=='Periodically'){
                            $interval=$this->input->post('periodic_interval');
                        }elseif($this->input->post('repeat')=='Monthly'){
                            $interval=$this->input->post('monthly_interval');
                        }else{
                            $interval='';
                        }

                        $from_date = FormatDate($this->input->post('from_date'));
                        $to_date = FormatDate($this->input->post('to_date'));
                        $due_date = FormatDate($this->input->post('from_date'));
                        $cur_date = date('Y-m-d');
                    } else {
                        $from_time=NULL;
                        $to_time=NULL;
                        $repeat=NULL;
                        $interval2=NULL;
                        $property=NULL;
                        $owner_name=NULL;
                        $interval=NULL;
                        $from_date = NULL;
                        $to_date = NULL;
                        $due_date = NULL;
                        $cur_date = NULL;
                    }

                    if($payment_time=='now' and $payment_mode=='Cheque') {
                        $cheque_no = $this->input->post('cheque_no');
                        if($this->input->post('cheque_date')==''){
                            $chqdt=NULL;
                        } else {
                            $chqdt=FormatDate($this->input->post('cheque_date'));
                        }
                        $bank_name = $this->input->post('bank_name');
                        $cheque_amount = format_number($this->input->post('cheque_amount'),2);
                        $micr_code = $this->input->post('micr_code');
                    } else {
                        $cheque_no = NULL;
                        $chqdt = NULL;
                        $bank_name = NULL;
                        $cheque_amount = NULL;
                        $micr_code = NULL;
                    }

                    if($payment_time=='now' and $payment_mode=='NEFT') {
                        $ref_no = $this->input->post('ref_no');
                    } else {
                        $ref_no = NULL;
                    }

                    if($this->input->post('sub_property')!=null){
                        $sub_property = $this->input->post('sub_property');
                    } else {
                        $sub_property = '0';
                    }

                    $data = array(
                        'property_id' => $property_id,
                        'sub_property_id' => $sub_property,
                        'vendor_id' => $this->input->post('vendor'),
                        'expense_description' => $description,
                        'escalation' => format_number($this->input->post('escalations'),2),
                        'expense_date' => $expense_date,
                        'expense_amount' => format_number($this->input->post('expense_amount'),2),
                        'category' => $category,
                        'payment_time' => $payment_time,
                        'payment_mode' => $payment_mode,
                        'cheque_number' => $cheque_no,
                        'cheque_date' => $chqdt,
                        'bank_name' => $bank_name,
                        'cheque_amount' => $cheque_amount,
                        'micr_code' => $micr_code,
                        'txn_status' => $txn_status,
                        'gp_id' => $gid,
                        'from_date' => $from_date,
                        'from_time' => $from_time,
                        'to_date' => $to_date,
                        'to_time' => $to_time,
                        'due_date' => $due_date,
                        'repeat_status' => $repeat,
                        'period_interval'=>$interval,
                        'monthly_repeat'=>$interval2,
                        'status'=>'1',
                        'maker_remark' => $this->input->post('maker_remark'),
                        'modified_date' => $modnow,
                        'modified_by' => $curusr,
                        'ref_no' => $ref_no,
                        'mail_sent' => $mail_sent
                    );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $eid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;

                        $this->db->insert('expense_txn',$data);
                        $eid=$this->db->insert_id();
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Expense Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('txn_id', $eid);
                        $this->db->update('expense_txn',$data);
                        $logarray['table_id']=$eid;
                        $logarray['module_name']='Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Expense Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('expense_id', $eid);
                        $this->db->delete('expense_schedule');
                        
                        $this->db->where('expense_id', $eid);
                        $this->db->delete('expense_schedule_taxation');
                    }

                    if($payment_time=='later'){
                        $week_index=0;
                        $task_status='Pending';
                        $weekly_interval=$this->input->post('weekly_interval');

                        $query=$this->db->query("SELECT * FROM expense_category_master WHERE id = '$category'");
                        $result2=$query->result();
                        if(count($result2)>0) {
                            $event_type = $result2[0]->expense_category;
                        } else {
                            $event_type = '';
                        }

                        while($due_date<=$to_date) {
                            if($due_date>=$cur_date) {

                                if($this->input->post('sub_property')!=null){
                                    $sub_property = $this->input->post('sub_property');
                                } else {
                                    $sub_property = '0';
                                }

                                $insertArray=array(
                                                'expense_id' =>$eid,
                                                'category' => $category,
                                                'event_type' => $event_type,
                                                'event_name' => $description,
                                                'basic_cost' => format_number($this->input->post('expense_amount'),2),
                                                'net_amount' => format_number($this->input->post('expense_amount'),2),
                                                'task_status' => $task_status,
                                                'from_date' => $from_date,
                                                'from_time' => $from_time,
                                                'to_date' => $to_date,
                                                'to_time' => $to_time,
                                                'event_date' => $due_date,
                                                'repeat_status' => $repeat,
                                                'period_interval'=>$interval,
                                                'monthly_repeat'=>$interval2,
                                                'sch_status'=>$sch_status,
                                                'status'=>$sch_status,
                                                'property_id'=>$property_id,
                                                'sub_property_id'=>$sub_property
                                            );

                                $query=$this->db->query("select * from expense_schedule where expense_id='$eid' and event_date='$due_date' and status='$sch_status'");
                                if($query->num_rows()==0){
                                    $insertExtra=array(
                                            'create_by' => $this->session->userdata('session_id')
                                        );
                                    $newArray=array_merge($insertArray,$insertExtra);
                                    $this->db->insert('expense_schedule',$newArray);
                                }
                            }

                            if($repeat=="Daily") {
                                $due_date = date ("Y-m-d", strtotime ($due_date ."+1 days"));
                            } else if($repeat=="Periodically") {
                                $due_date = date ("Y-m-d", strtotime ($due_date ."+".$interval." days"));
                            } else if($repeat=="Weekly") {
                                $week_day="";

                                if (isset($weekly_interval[$week_index])) {
                                    $week_day=$weekly_interval[$week_index];
                                    $week_index=$week_index+1;
                                    if (! isset($weekly_interval[$week_index])) {
                                        $week_index=0;
                                    }
                                }

                                if($week_day=="Mon") $week_day="monday";
                                else if($week_day=="Tue") $week_day="tuesday";
                                else if($week_day=="Wed") $week_day="wednesday";
                                else if($week_day=="Thu") $week_day="thursday";
                                else if($week_day=="Fri") $week_day="friday";
                                else if($week_day=="Sat") $week_day="saturday";
                                else if($week_day=="Sun") $week_day="sunday";

                                if($week_day!=''){
                                    $date = new DateTime($due_date);
                                    $date->modify('next ' . $week_day);
                                    $due_date = $date->format('Y-m-d');
                                }
                            } else if($repeat=="Monthly") {
                                $date = explode('-',$due_date);
                                $due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
                                $d = DateTime::createFromFormat("Y-m-d", $due_date);
                                $due_date = strval($d->format('Y-m-d'));
                            } else if($repeat=="Yearly") {
                                $due_date = date ("Y-m-d", strtotime ($due_date ."+1 years"));
                            }
                        }
                    }

                    redirect(base_url().'index.php/Expense');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($eid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM expense_txn WHERE txn_id = '$eid'");
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
                    $this->db->query("update expense_txn set txn_status='Rejected', txn_remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$eid'");

                    $logarray['table_id']=$eid;
                    $logarray['module_name']='Expense';
                    $logarray['cnt_name']='Expense';
                    $logarray['action']='Expense Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update expense_txn set txn_status='Approved', txn_remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$eid'");
                        $this->db->query("update expense_schedule set sch_status = '1', status='1' WHERE expense_id = '$eid'");
                        $this->db->query("update expense_schedule_taxation set status='1' WHERE expense_id = '$eid'");

                        $logarray['table_id']=$eid;
                        $logarray['module_name']='Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Expense Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update expense_txn A, expense_txn B set A.client_id=B.client_id, 
                                         A.property_id=B.property_id, A.sub_property_id=B.sub_property_id, 
                                         A.vendor_id=B.vendor_id, A.expense_description=B.expense_description, 
                                         A.escalation=B.escalation, A.expense_date=B.expense_date, 
                                         A.expense_amount=B.expense_amount, A.category=B.category, 
                                         A.payment_time=B.payment_time, A.payment_mode=B.payment_mode, 
                                         A.cheque_number=B.cheque_number, A.cheque_date=B.cheque_date, 
                                         A.bank_name=B.bank_name, A.cheque_amount=B.cheque_amount, A.micr_code=B.micr_code, 
                                         A.created_by=B.created_by, A.create_date=B.create_date, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', 
                                         A.approved_date='$modnow', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.txn_status='$txn_status', 
                                         A.txn_remarks='$remarks', A.gp_id=B.gp_id, A.from_date=B.from_date, 
                                         A.from_time=B.from_time, A.to_date=B.to_date, A.to_time=B.to_time, 
                                         A.due_date=B.due_date, A.repeat_status=B.repeat_status, 
                                         A.period_interval=B.period_interval, A.monthly_repeat=B.monthly_repeat, 
                                         A.status=B.status, A.maker_remark=B.maker_remark, A.txn_fkid=B.txn_fkid, 
                                         A.ref_no=B.ref_no, A.mail_sent=B.mail_sent 
                                         WHERE B.txn_id = '$eid' and A.txn_id=B.txn_fkid");
                        
                        $this->db->query("update expense_schedule set sch_status = '2', status='2' WHERE expense_id = '$txn_fkid'");
                        $this->db->query("update expense_schedule set expense_id = '$txn_fkid', sch_status = '1', status='1' WHERE expense_id = '$eid'");

                        $this->db->query("update expense_schedule_taxation set status='2' WHERE expense_id = '$txn_fkid'");
                        $this->db->query("update expense_schedule_taxation set expense_id = '$txn_fkid', status='1' WHERE expense_id = '$eid'");

                        $this->db->query("delete from expense_txn WHERE txn_id = '$eid'");
                            
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Expense Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                }

                redirect(base_url().'index.php/Expense');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function send_expense_intimation(){
        $this->expense_model->send_expense_intimation();
    }
}
?>