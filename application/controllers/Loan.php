<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Loan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("loan_model");
        $this->load->model("document_model");
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function loaddocuments($pid) {
        $document_details=null;

        $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id = '$pid'");
        $result=$query->result();

        if (count($result)>0) {
            $pcolname="";
            $ptype=$result[0]->p_type;

            if($ptype=='Building'){
                $pcolname="d_type_building";
            } else if($ptype=='Apartment'){
                $pcolname="d_type_apartment";
            } else if($ptype=='Bunglow'){
                $pcolname="d_type_bunglow";
            } else if($ptype=='Commercial'){
                $pcolname="d_type_commercial";
            } else if($ptype=='Retail'){
                $pcolname="d_type_retail";
            } else if($ptype=='Industrial'){
                $pcolname="d_type_industry";
            } else if($ptype=='Land-Agriculture'){
                $pcolname="d_type_landagriculture";
            } else if($ptype=='Land-Non Agriculture'){
                $pcolname="d_type_landnonagricultural";
            } 

            if ($pcolname!="") {
                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%loan%' and " . $pcolname . " = 'Yes'");
                // $result=$query->result();
                // $i=0;
                
                // foreach ($result as $row) {
                //     $document_details[$i] = array("d_documentname"=> $row->d_documentname, "d_description"=> $row->d_description);
                //     $i=$i+1;
                // }

                $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                                        (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                                        (select * from document_details where doc_ref_id='$pid' and doc_ref_type='Property_Purchase') A 
                                        left join 
                                        (select * from document_type_master) B 
                                        on (A.doc_type_id=B.d_type_id)) C 
                                        left join 
                                        (select * from document_master) D 
                                        on (C.doc_doc_id=D.d_id)");
                $result=$query->result();
                $data['documents']=$result;

                for($i=0; $i<count($result); $i++){
                    $d_type_id = $result[$i]->d_type_id;

                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master where d_t_type like '%loan%' and $pcolname='Yes') B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                    $data['docs'][$d_type_id]=$query->result();
                }
            }
        }

        // echo json_encode($document_details);
        $document_data=$this->load->view('templates/document_dynamic',$data,true);
        $returnarray=array('status'=>true,"data"=>$document_data);
        echo json_encode($returnarray);
    }
    
    public function loadproperty() {
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');
        $result=$this->loan_model->getPropertyDetails($term);
        
        foreach($result as $row) {
            $abc[] = array('value' => $row->txn_id , 'label' => $row->p_property_name);
        }
        
        echo json_encode($abc);
    }
    
    public function get_sub_property($txn_id, $loan_property_id, $property_id) {
        // $property_id = html_escape($this->input->post('property_id'));
        // $txn_id = html_escape($this->input->post('txn_id'));

        // $property_id = 42;
        // $txn_id = 0;

        $query=$this->db->query("SELECT * FROM loan_property_details WHERE id='$loan_property_id' and loan_id='$txn_id' and property_id='$property_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property_id = $result[0]->sub_property_id;
        } else {
            $sub_property_id = '0';
        }

        $result= $this->loan_model->getSubPropertyDetails($property_id);

        $sub_property_list = '<option value="0" Selected>Select </option>';

        foreach ($result as $row) {
            if ($sub_property_id == $row->sp_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '">' . $row->sp_name . '</option>';
            }
        }

        if($sub_property_list == '<option value="0" Selected>Select </option>'){
            $sub_property_list="";
        }

        echo $sub_property_list;
    }

    public function addnew($prop=NULL){
		$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%loan%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%loan%'");
            // $result=$query->result();
            // $data['docs']=$result;
            
            // $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
            //                         '' as doc_documentname, '' as d_show_expiry_date, 
            //                         '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
            //                         '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
            //                         from document_type_master");
            // $result=$query->result();
            // $data['documents']=$result;

            // for($i=0; $i<count($result); $i++){
            //     $d_type_id = $result[$i]->d_type_id;

            //     $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
            //                             (select * from document_types where d_type_id='$d_type_id') A 
            //                             left join 
            //                             (select * from document_master where d_t_type like '%loan%') B 
            //                             on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            //     $data['docs'][$d_type_id]=$query->result();
            // }

            // $query=$this->db->query("select * from document_type_master");
            // $result=$query->result();
            // $data['doc_types']=$result;

            $docs=$this->document_model->add_new_doc('', 'loan');
            $data=array_merge($data, $docs);

            $data['property']= $this->loan_model->getPropertyDetails();

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            // $data['property']= $this->loan_model->getPropertyDetails();

            load_view('loan/loan_details',$data);
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

            if($this->input->post('loan_start_date')!=''){
                $loandt=FormatDate($this->input->post('loan_start_date'));
            } else {
                $loandt=NULL;
            }
            
            $data = array(
                'ref_id' => $this->input->post('ref_id'),
                'ref_name' => $this->input->post('ref_name'),
                'loan_type' => $this->input->post('loan_type'),
                'loan_amount' => format_number($this->input->post('amount'),2),
                'loan_startdate' => $loandt,
                'loan_due_day' => $this->input->post('loan_due_day'),
                'loan_term' => format_number($this->input->post('term'),2),
                'loan_interest_rate' => format_number($this->input->post('interest_rate'),2),
                'interest_type' => $this->input->post('interest_type'),
                'financial_institution' => $this->input->post('financial_institution'),
                'repayment' => $this->input->post('repayment'),
                'purpose'=>$this->input->post('purpose'),
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'gp_id' => $gid,
                'maker_remark'=>$this->input->post('maker_remark')
            );
            $this->db->insert('loan_txn', $data);
            $lid=$this->db->insert_id();

            $logarray['table_id']=$lid;
            $logarray['module_name']='Loan';
            $logarray['cnt_name']='Loan';
            $logarray['action']='Loan Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);
            
            $borower=$this->input->post('borrower[]');
            for ($i=0; $i < count($borower); $i++) { 
                $data = array('loan_id' => $lid , 'brower_id' => $borower[$i], );
                $this->db->insert('loan_borrower_details', $data);
            }

            // $pending_activity=$this->input->post('pending_activity[]');
            // for ($i=0; $i <  count($pending_activity); $i++) {
            //     if($pending_activity[$i]!="") {
            //         $data = array(
            //             'type' => 'loan',
            //             'ref_id' => $lid,
            //             'pending_activity' => $pending_activity[$i]
            //             );
            //         $this->db->insert('pending_activity', $data);
            //     }
            // }

            // $property=$this->input->post('property[]');
            $property_id=$this->input->post('property_id[]');
            $sub_property=$this->input->post('sub_property[]');
            for ($i=0; $i < count($property_id); $i++) {
                // $prop = isset($property[$i])?$property[$i]:null;
                $prop_id = isset($property_id[$i])?$property_id[$i]:null;
                $sub_prop_id = isset($sub_property[$i])?$sub_property[$i]:'0';
                if($prop_id!=''){
                    // $data = array('loan_id' => $lid, 'property_id' => $prop_id, 'sub_property_id' => $sub_prop_id, 'property' => $prop);
                    $data = array('loan_id' => $lid, 'property_id' => $prop_id, 'sub_property_id' => $sub_prop_id);
                    $this->db->insert('loan_property_details', $data);
                }
            }

            $this->document_model->insert_doc($lid, 'Property_Loan');

            $this->loan_model->insertImage($lid);

            $this->loan_model->send_loan_intimation($lid);

            redirect(base_url().'index.php/Loan');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($lid){
        $this->get_record($lid, 'loan/loan_view');
    }

    public function edit($lid){
        $this->get_record($lid, 'loan/loan_details');
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
            $ptype = "";

            $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_fkid = '$lid'");
            $result1=$query->result();
            if (count($result1)>0){
                $lid = $result1[0]->txn_id;
            }

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%loan%'");
            // $result=$query->result();
            // $data['docs']=$result;
            
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%loan%' AND status = '1' AND tax_action='1'"); 
            $result=$query->result();
            $data['tax']=$result;

            $data['property']= $this->loan_model->getPropertyDetails($lid);

            $sql="select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name from 
                (select * from 
                (select C.*, D.loan_id, D.brower_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                (select * from loan_txn where gp_id='$gid' and txn_id='$lid') C 
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
                on F.txn_id = G.loan_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $data['editloan']=$result;
                $ptype = $result[0]->p_type;

                if ($result[0]->txn_status=="Approved") {
                    $txn_status=1;
                } else {
                    $txn_status=3;
                }
                // $property_id=$result[0]->property_id;
            } else {
                $txn_status=3;
                // $property_id='0';
            }

            // $query=$this->db->query("SELECT A.brower_id, case when B.ow_type = '0' then (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = B.ow_ind_id) when B.ow_type = '1' then B.ow_huf_name when B.ow_type = '2' then B.ow_pvtltd_comapny_name when B.ow_type = '3' then B.ow_ltd_comapny_name when B.ow_type = '4' then B.ow_llp_comapny_name when B.ow_type = '5' then B.ow_prt_comapny_name when B.ow_type = '6' then B.ow_aop_comapny_name when B.ow_type = '7' then B.ow_trs_comapny_name else B.ow_proprietorship_comapny_name end as c_name FROM loan_borrower_details A, owner_master B  WHERE A.loan_id='$lid' and A.brower_id=B.ow_id");
            // $result=$query->result();
            // $data['editborower']=$result;

            $query=$this->db->query("select * from loan_borrower_details where loan_id='$lid'");
            $result=$query->result();
            $data['editborower']=$result;

            $query=$this->db->query("select C.id, C.loan_id, C.property_id, C.sub_property_id, C.property, C.p_property_name, C.p_display_name, D.sp_name from 
                                    (select A.id, A.loan_id, A.property_id, A.sub_property_id, A.property, B.p_property_name, B.p_display_name from 
                                    (select * from loan_property_details A where A.loan_id = '$lid') A 
                                    left join 
                                    (select * from purchase_txn where gp_id='$gid') B 
                                    on A.property_id = B.txn_id) C 
                                    left join 
                                    (select * from sub_property_allocation where gp_id='$gid') D 
                                    on C.sub_property_id=D.txn_id and C.property_id = D.property_id");
            $result=$query->result();
            $data['editproperty']=$result;

            if($ptype=='Building'){
                $pcolname="d_type_building";
            } else if($ptype=='Apartment'){
                $pcolname="d_type_apartment";
            } else if($ptype=='Bunglow'){
                $pcolname="d_type_bunglow";
            } else if($ptype=='Commercial'){
                $pcolname="d_type_commercial";
            } else if($ptype=='Retail'){
                $pcolname="d_type_retail";
            } else if($ptype=='Industrial'){
                $pcolname="d_type_industry";
            } else if($ptype=='Land-Agriculture'){
                $pcolname="d_type_landagriculture";
            } else if($ptype=='Land-NonAgriculture'){
                $pcolname="d_type_landnonagricultural";
            } else {
                $pcolname="";
            }

            $docs=$this->document_model->edit_view_doc($pcolname, $lid, 'Property_Loan', 'loan');
            $data=array_merge($data, $docs);

            // $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$lid' and type='loan'");
            // $result=$query->result();
            // if(count($result)>0){
            //     $data['pending_activity']=$result;
            // }

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;
            $data['l_id']=$lid;
            $data['maker_checker'] = $this->session->userdata('maker_checker');
            

            if($data['editproperty']){
                $pid = $data['editproperty'][0]->property_id;
                $maintenance_count = $this->db->query("SELECT count(id) as `count` from user_task_detail where property_id=$pid")->result_array();
               $tenant_count = $this->db->query("SELECT count(rt.txn_id) as count from rent_txn rt join rent_tenant_details rtd on  rt.txn_id=rtd.rent_id
                WHERE rt.property_id=$pid")->result_array();

               $data['maintenance_count'] = $maintenance_count[0]['count'];
               $data['tenant_count'] = $tenant_count[0]['count'];
            }else
            {
                $data['maintenance_count'] = 0;
                $data['tenant_count'] = 0;
            }
            
            

            load_view($view, $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloadloandocs($lid, $docid) {
    //     $query=$this->db->query("SELECT * FROM loan_document_details WHERE ln_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = 'localhost';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';$ftp_config['port'] = 21;
    //     $ftp_config['debug'] = FALSE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->ln_document;
    //     if(!is_dir('./downloads/loan/'.$lid.'/')) {
    //         mkdir('./downloads/loan/'.$lid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/loan/'.$lid.'/'.$result[0]->ln_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }
    
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

            $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_id = '$lid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update loan_txn set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                            modified_by='$curusr', modified_date='$modnow' WHERE txn_id = '$lid'");

                            $logarray['table_id']=$lid;
                            $logarray['module_name']='Loan';
                            $logarray['cnt_name']='Loan';
                            $logarray['action']='Loan Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_fkid = '$lid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $lid = $result[0]->txn_id;

                                $this->db->query("Update loan_txn set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$lid'");
                                $logarray['table_id']=$lid;
                                $logarray['module_name']='Loan';
                                $logarray['cnt_name']='Loan';
                                $logarray['action']='Loan Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into loan_txn (gp_id, ref_id, ref_name, loan_type, loan_amount, 
                                                 loan_startdate, loan_due_day, loan_term, loan_interest_rate, interest_type, 
                                                 financial_institution, repayment, purpose, txn_status, create_date, created_by, 
                                                 modified_date, modified_by, approved_by, approved_date, txn_remarks, txn_fkid, 
                                                 rejected_by, rejected_date, maker_remark, image, image_name) 
                                                 Select '$gp_id', ref_id, ref_name, loan_type, loan_amount, 
                                                 loan_startdate, loan_due_day, loan_term, loan_interest_rate, interest_type, 
                                                 financial_institution, repayment, purpose, '$txn_status', '$create_date', '$created_by', 
                                                 '$modnow', '$curusr', approved_by, approved_date, '$txnremarks', '$lid', 
                                                 rejected_by, rejected_date, maker_remark, image, image_name 
                                                 FROM loan_txn WHERE txn_id = '$lid'");
                                $new_lid=$this->db->insert_id();

                                $this->db->query("Insert into loan_borrower_details (loan_id, brower_id) 
                                                 Select '$new_lid', brower_id 
                                                 FROM loan_borrower_details WHERE loan_id = '$lid'");

                                $this->db->query("Insert into loan_property_details (loan_id, property_id, sub_property_id, property) 
                                                 Select '$new_lid', property_id, sub_property_id, property 
                                                 FROM loan_property_details WHERE loan_id = '$lid'");

                                // $this->db->query("Insert into loan_document_details (ln_doc_loanid, ln_doc_name, ln_doc_description, 
                                //                  ln_doc_ref_no, ln_doc_doi, ln_doc_doe, ln_document, ln_document_name) 
                                //                  Select '$new_lid', ln_doc_name, ln_doc_description, 
                                //                  ln_doc_ref_no, ln_doc_doi, ln_doc_doe, ln_document, ln_document_name 
                                //                  FROM loan_document_details WHERE ln_doc_loanid = '$lid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_lid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$lid' and doc_ref_type = 'Property_Loan'");

                                $this->db->query("Insert into pending_activity (ref_id, type, pending_activity) 
                                                 Select '$new_lid', type, pending_activity FROM pending_activity WHERE ref_id = '$lid' and type = 'loan'");

                                $logarray['table_id']=$lid;
                                $logarray['module_name']='Loan';
                                $logarray['cnt_name']='Loan';
                                $logarray['action']='Loan Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $lid);
                        $this->db->delete('loan_txn');

                        $this->db->where('loan_id', $lid);
                        $this->db->delete('loan_borrower_details');

                        $this->db->where('loan_id', $lid);
                        $this->db->delete('loan_property_details');

                        // $this->db->where('ln_doc_loanid', $lid);
                        // $this->db->delete('loan_document_details');

                        $this->db->where('doc_ref_id', $lid);
                        $this->db->where('doc_ref_type', 'Property_Loan');
                        $this->db->delete('document_details');

                        // $this->db->where('ref_id', $lid);
                        // $this->db->where('type', 'loan');
                        // $this->db->delete('pending_activity');

                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan';
                        $logarray['cnt_name']='Loan';
                        $logarray['action']='Loan Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Loan');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $now=date('Y-m-d H:i:s');
                    $modinow=date('Y-m-d H:i:s');

                    if($this->input->post('loan_start_date')!=''){
                        $loandt=FormatDate($this->input->post('loan_start_date'));
                    } else {
                        $loandt=NULL;
                    }
                    
                    $data = array(
                        'ref_id' => $this->input->post('ref_id'),
                        'ref_name' => $this->input->post('ref_name'),
                        'loan_type' => $this->input->post('loan_type'),
                        'loan_amount' => format_number($this->input->post('amount'),2),
                        'loan_startdate' => $loandt,
                        'loan_due_day' => $this->input->post('loan_due_day'),
                        'loan_term' => format_number($this->input->post('term'),2),
                        'loan_interest_rate' => format_number($this->input->post('interest_rate'),2),
                        'interest_type' => $this->input->post('interest_type'),
                        'financial_institution' => $this->input->post('financial_institution'),
                        'repayment' => $this->input->post('repayment'),
                        'purpose'=>$this->input->post('purpose'),
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

                        $this->db->insert('loan_txn',$data);
                        $lid=$this->db->insert_id();

                        $sql = "update loan_txn A, loan_txn B set A.image = B.image, A.image_name = B.image_name 
                                where A.txn_id = '$lid' and B.txn_id = '$txn_fkid'";
                        $this->db->query($sql);
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Loan';
                        $logarray['cnt_name']='Loan';
                        $logarray['action']='Loan Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into loan_document_details (ln_doc_loanid, ln_doc_name, 
                        //                  ln_doc_description, ln_doc_ref_no, ln_doc_doi, ln_doc_doe, ln_document, 
                        //                  ln_document_name) 
                        //                  Select '$lid', ln_doc_name, ln_doc_description, ln_doc_ref_no, ln_doc_doi, 
                        //                  ln_doc_doe, ln_document, ln_document_name FROM loan_document_details 
                        //                  WHERE ln_doc_loanid = '$txn_fkid'");
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $lid);
                        $this->db->update('loan_txn',$data);

                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan';
                        $logarray['cnt_name']='Loan';
                        $logarray['action']='Loan Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('loan_id', $lid);
                        $this->db->delete('loan_borrower_details');
                        
                        $this->db->where('loan_id', $lid);
                        $this->db->delete('loan_property_details');

                        // $this->db->where('ref_id', $lid);
                        // $this->db->where('type', 'loan');
                        // $this->db->delete('pending_activity');
                    }

                    // if ($txn_status!="Delete" || $rec_status=="Approved") {
                        $borower=$this->input->post('borrower[]');
                        for ($i=0; $i < count($borower); $i++) { 
                            $data = array('loan_id' => $lid , 'brower_id' => $borower[$i], );
                            $this->db->insert('loan_borrower_details', $data);
                        }

                        // $pending_activity=$this->input->post('pending_activity[]');
                        // for ($i=0; $i <  count($pending_activity); $i++) {
                        //     if($pending_activity[$i]!="") {
                        //         $data = array(
                        //             'type' => 'loan',
                        //             'ref_id' => $lid,
                        //             'pending_activity' => $pending_activity[$i]
                        //             );
                        //         $this->db->insert('pending_activity', $data);
                        //     }
                        // }

                        // $property=$this->input->post('property[]');
                        // $sub_property=$this->input->post('sub_property[]');
                        // for ($i=0; $i < count($property); $i++) {
                        //     $property_id = isset($property[$i])?$property[$i]:null;
                        //     $sub_property_id = isset($sub_property[$i])?$sub_property[$i]:null;
                        //     $data = array('loan_id' => $lid, 'property_id' => $property_id, 'sub_property_id' => $sub_property_id);
                        //     $this->db->insert('loan_property_details', $data);
                        // }

                        // $property=$this->input->post('property[]');
                        $property_id=$this->input->post('property_id[]');
                        $sub_property=$this->input->post('sub_property[]');
                        for ($i=0; $i < count($property_id); $i++) {
                            // $prop = isset($property[$i])?$property[$i]:null;
                            $prop_id = isset($property_id[$i])?$property_id[$i]:null;
                            $sub_prop_id = isset($sub_property[$i])?$sub_property[$i]:'0';
                            if($prop_id!=''){
                                // $data = array('loan_id' => $lid, 'property_id' => $prop_id, 'sub_property_id' => $sub_prop_id, 'property' => $prop);
                                $data = array('loan_id' => $lid, 'property_id' => $prop_id, 'sub_property_id' => $sub_prop_id);
                                $this->db->insert('loan_property_details', $data);
                            }
                        }

                        $this->document_model->insert_doc($lid, 'Property_Loan');

                        $this->loan_model->insertImage($lid);

                    // }

                    redirect(base_url().'index.php/Loan');

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
                $query=$this->db->query("SELECT * FROM loan_txn WHERE txn_id = '$lid'");
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
                    $this->db->query("update loan_txn set txn_status='Rejected', txn_remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$lid'");

                    $logarray['table_id']=$lid;
                    $logarray['module_name']='Loan';
                    $logarray['cnt_name']='Loan';
                    $logarray['action']='Loan Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update loan_txn set txn_status='Approved', txn_remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$lid'");
                        
                        $logarray['table_id']=$lid;
                        $logarray['module_name']='Loan';
                        $logarray['cnt_name']='Loan';
                        $logarray['action']='Loan Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update loan_txn A, loan_txn B set A.gp_id=B.gp_id, A.ref_id=B.ref_id, A.ref_name=B.ref_name, 
                                         A.loan_type=B.loan_type, A.loan_amount=B.loan_amount, A.loan_startdate=B.loan_startdate, 
                                         A.loan_due_day=B.loan_due_day, A.loan_term=B.loan_term, A.loan_interest_rate=B.loan_interest_rate, 
                                         A.interest_type=B.interest_type, A.financial_institution=B.financial_institution, 
                                         A.repayment=B.repayment, A.purpose=B.purpose, 
                                         A.txn_status='$txn_status', A.create_date=B.create_date, A.created_by=B.created_by, 
                                         A.modified_date=B.modified_date, A.modified_by=B.modified_by, 
                                         A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.txn_remarks='$remarks', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, A.image=B.image, A.image_name=B.image_name 
                                         WHERE B.txn_id = '$lid' and A.txn_id=B.txn_fkid");

                        $this->db->where('loan_id', $txn_fkid);
                        $this->db->delete('loan_borrower_details');
                        $this->db->query("update loan_borrower_details set loan_id = '$txn_fkid' WHERE loan_id = '$lid'");

                        $this->db->where('loan_id', $txn_fkid);
                        $this->db->delete('loan_property_details');
                        $this->db->query("update loan_property_details set loan_id = '$txn_fkid' WHERE loan_id = '$lid'");

                        // $this->db->where('ln_doc_loanid', $txn_fkid);
                        // $this->db->delete('loan_document_details');
                        // $this->db->query("update loan_document_details set ln_doc_loanid = '$txn_fkid' WHERE ln_doc_loanid = '$lid'");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Loan');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$lid' and doc_ref_type = 'Property_Loan'");

                        // $this->db->where('ref_id', $txn_fkid);
                        // $this->db->where('type', 'loan');
                        // $this->db->delete('pending_activity');
                        // $this->db->query("update pending_activity set ref_id = '$txn_fkid' WHERE ref_id = '$lid' and type = 'loan'");

                        $this->db->query("delete from loan_txn WHERE txn_id = '$lid'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Loan';
                        $logarray['cnt_name']='Loan';
                        $logarray['action']='Loan Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Loan');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status='',$property_id='') {
        $result=$this->loan_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['loan']=$this->loan_model->loanData($status,$property_id);

            $count_data=$this->loan_model->getAllCountData();
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

            load_view('loan/loan_list', $data);

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

        $result = $this->loan_model->check_availablity($gid, $l_id, $l_ref_id);
        echo $result;
    }

    function send_loan_intimation($lid){
        $this->loan_model->send_loan_intimation($lid);
    }
}
?>