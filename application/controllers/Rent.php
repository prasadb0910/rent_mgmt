<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent extends CI_Controller
{
    public function __construct() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");
        $this->load->model('transaction_model');
        $this->load->model('document_model');
        $this->load->library('excel');
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
                $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                        '' as doc_documentname, '' as d_show_expiry_date, 
                                        '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                        '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
                                        from document_type_master");
                $result=$query->result();
                $data['documents']=$result;

                for($i=0; $i<count($result); $i++){
                    $d_type_id = $result[$i]->d_type_id;

                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master where d_t_type like '%rent%' and $pcolname='Yes') B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                    $data['docs'][$d_type_id]=$query->result();
                }
            }
        }

        $document_data=$this->load->view('templates/document_dynamic',$data,true);
        $returnarray=array('status'=>true,"data"=>$document_data);
        echo json_encode($returnarray);
    }
    
    public function addnew($prop=NULL){
		$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%rent%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;

            $data['selid']=$prop;
            
            $docs=$this->document_model->add_new_doc('', 'rent');
            $data=array_merge($data, $docs);

            $data['property']= $this->rent_model->getPropertyDetails();

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Tenants') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            // $data['tax_details']=$this->purchase_model->getAllTaxes($txn_type=false);
            $data['tax_details']=$this->rent_model->getAllTaxes('rent');

            $query=$this->db->query("select * from notification_master");
            $result=$query->result();
            $data['notification']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('rent/tenant_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_sub_property() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        // $property_id = 138;
        // $txn_id = 0;

        $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id='$txn_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property_id = $result[0]->sub_property_id;
        } else {
            $sub_property_id = '0';
        }

        if($property_id=='0'){
            $property_id = '';
        }

        $result= $this->rent_model->getSubPropertyDetails($txn_id, $property_id);

        $sub_property_list = '<option value="0">Select Sub Property</option>';

        foreach ($result as $row) {
            if ($sub_property_id == $row->sp_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '">' . $row->sp_name . '</option>';
            }
        }

        echo $sub_property_list;
    }

    public function get_property_owners() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        // $property_id = 138;
        // $txn_id = 0;

        $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id='$txn_id'");
        $result=$query->result();
        if (count($result)>0) {
            $invoice_issuer = $result[0]->invoice_issuer;
        } else {
            $invoice_issuer = '0';
        }

        $result= $this->rent_model->getPropertyOwners($property_id);

        $owner_list = '<option value="">Select Owner</option>';

        foreach ($result as $row) {
            if ($invoice_issuer == $row->c_id) {
                $owner_list = $owner_list . '<option value="' . $row->c_id . '" selected>' . $row->owner_name . '</option>';
            } else {
                $owner_list = $owner_list . '<option value="' . $row->c_id . '">' . $row->owner_name . '</option>';
            }
        }

        echo $owner_list;
    }

    public function get_property_utilities() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        // $property_id = 138;
        // $txn_id = 0;

        $result= $this->rent_model->getPropertyUtilities($txn_id, $property_id);

        $k = 0;
        $prop_utilities = '';

        foreach ($result as $row) {
            $prop_utilities = $prop_utilities . '<tr class="">
                                    <td>
                                        <input type="hidden" id="utility_'.($k+1).'" name="utility[]" value="'.$row->id.'">'.$row->amenity.'
                                    </td>
                                    <td>
                                        <div class="checkbox check-success">
                                            <input type="checkbox" id="landlord_'.($k+1).'" name="landlord[]" value="'.$row->id.'" '.(($row->landlord=='1')?"checked":"").' onchange="set_utilities(this);" />
                                            <label for="landlord_'.($k+1).'"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox check-success">
                                            <input type="checkbox" id="tenant_'.($k+1).'" name="u_tenant[]" value="'.$row->id.'" '.(($row->tenant=='1')?"checked":"").' onchange="set_utilities(this);" />
                                            <label for="tenant_'.($k+1).'"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox check-success">
                                            <input type="checkbox" id="na_'.($k+1).'" name="na[]" value="'.$row->id.'" '.(($row->na=='1')?"checked":"").' onchange="set_utilities(this);" />
                                            <label for="na_'.($k+1).'"></label>
                                        </div>
                                    </td>
                                </tr>';
            $k++;
        }

        echo $prop_utilities;
    }

    public function check_date() {
        $property_id = html_escape($this->input->post('property_id'));
        $possession_date = html_escape($this->input->post('possession_date'));

        // $property_id = "142";
        // $possession_date = "01/01/2019";
        // $possession_date = "02/01/2019";

        $result = $this->rent_model->check_date($property_id, $possession_date);
        echo $result;
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $deposit_paid_date=$this->input->post('deposit_paid_date');
            if(validateDate($deposit_paid_date)) {
                $deposit_paid_date=FormatDate($deposit_paid_date);
            } else {
                $deposit_paid_date=null;
            }

            $possession_date=$this->input->post('possession_date');
            if(validateDate($possession_date)) {
                $possession_date=FormatDate($possession_date);
            } else {
                $possession_date=null;
            }

            $termination_date=$this->input->post('termination_date');
            if(validateDate($termination_date)) {
                $termination_date=FormatDate($termination_date);
            } else {
                $termination_date=null;
            }

            $invoice_date=$this->input->post('invoice_date');
            if(validateDate($invoice_date)) {
                $invoice_date=FormatDate($invoice_date);
            } else {
                $invoice_date=null;
            }

            $sub_property_id = $this->input->post('sub_property');
            if($sub_property_id==''){
                $sub_property_id = null;
            }
            $data = array(
                'gp_id' => $gid,
                'property_id' => $this->input->post('property'),
                'sub_property_id' => $sub_property_id,
                'tenant_id' => $this->input->post('owners'),
                'attorney_id'=>$this->input->post('attorney'),
                'rent_amount' => format_number($this->input->post('rent_amount'),2),
                'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                'deposit_paid_date' => $deposit_paid_date,
                'possession_date' => $possession_date,
                'lockin_period' => format_number($this->input->post('lockin_period'),2),
                'lease_period' => format_number($this->input->post('lease_period'),2),
                'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                'termination_date' => $termination_date,
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'maker_remark' => $this->input->post('maker_remark'),
                'maintenance_by' => $this->input->post('maintenance_by'),
                'property_tax_by' => $this->input->post('property_tax_by'),
                'notice_period' => $this->input->post('notice_period'),
                'category' => $this->input->post('category'),
                'schedule' => $this->input->post('schedule'),
                'invoice_date' => $invoice_date,
                'gst' => ($this->input->post('gst')=='yes'?'1':'0'),
                'gst_rate' => format_number($this->input->post('gst_rate'),2),
                'tds' => ($this->input->post('tds')=='yes'?'1':'0'),
                'tds_rate' => format_number($this->input->post('tds_rate'),2),
                'pdc' => ($this->input->post('pdc')=='yes'?'1':'0'),
                'deposit_category' => $this->input->post('deposit_category'),
                'invoice_issuer' => $this->input->post('invoice_issuer')
                 );
            $this->db->insert('rent_txn', $data);
            $rid=$this->db->insert_id();

            $logarray['table_id']=$rid;
            $logarray['module_name']='Rent';
            $logarray['cnt_name']='Rent';
            $logarray['action']='Rent Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            // $response_purchase_consideration=$this->rent_model->insertSchedule($rid, $txn_status);

            $this->rent_model->insertTenantDetails($rid);
            $this->rent_model->insertEscalationDetails($rid);
            $this->rent_model->insertPDCDetails($rid);
            $this->rent_model->insertUtilityDetails($rid);
            $this->rent_model->insertNotificationDetails($rid);

            $this->rent_model->insertOtherAmtDetails($rid);

            $this->document_model->insert_doc($rid, 'Property_Rent');

            $this->rent_model->setSchedule($rid, $txn_status);

            $this->rent_model->setOtherSchedule($rid, $txn_status);

            $this->rent_model->send_rent_intimation($rid);

            redirect(base_url().'index.php/Rent');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($rid){
        $this->get_record($rid, 'rent/tenant_details');
    }

    public function view($rid) {
        $this->get_record($rid, 'rent/tenant_view');
    }

    public function end_lease($rid){
        $this->get_record($rid, 'rent/end_lease');
    }

    public function get_record($rid, $view){
        $data['tax_details']=$this->rent_model->getAllTaxes('rent');

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $data['access']=$result;
                $ptype = '';

                $data['rentby']=$this->session->userdata('session_id');

                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $rid = $result1[0]->txn_id;
                }

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%Rent%' AND status = '1' AND tax_action='1'"); 
                $result=$query->result();
                $data['tax']=$result;

                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $txn_fkid = $result1[0]->txn_fkid;
                }

                if($txn_fkid!=''){
                    $data['property'] = $this->rent_model->getPropertyDetails($txn_fkid);
                } else {
                    $data['property'] = $this->rent_model->getPropertyDetails($rid);
                }
                

                $result = $this->rent_model->rentData('All', '', $rid);
                if(count($result)>0) {
                    $ptype = $result[0]->p_type;

                    $data['editrent']=$result;
                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                    $property_id=$result[0]->property_id;
                } else {
                    $txn_status=3;
                    $property_id='0';
                }

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

                $docs=$this->document_model->edit_view_doc($pcolname, $rid, 'Property_Rent', 'rent');
                $data=array_merge($data, $docs);

                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;

                $data['sub_property']= $this->rent_model->getSubPropertyDetails($rid, $property_id);

                $distict_tax=$this->rent_model->getDistinctTaxDetail($rid, $txn_status);
                $data['tax_name']=$distict_tax;

                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM rent_schedule 
                        WHERE rent_id = '".$rid."' and status = '$txn_status' GROUP BY event_type";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule']=array();

                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){                     
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;

                        $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM rent_schedule_taxation 
                                                WHERE rent_id = '".$rid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $j++;
                            }
                        }

                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM rent_schedule_taxation 
                                        WHERE rent_id = '".$rid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $sql="SELECT * FROM rent_schedule  WHERE rent_id = '".$rid."' and status = '$txn_status' ";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row) {
                        $data['p_schedule1'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$row->event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule1'][$k]['event_date']=$row->event_date;

                        $query=$this->db->query("SELECT * FROM rent_schedule_taxation WHERE rent_id = '".$rid."' and sch_id = '".$row->sch_id."' and status = '$txn_status' order by tax_master_id Asc ");
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
                        $k++;
                    }
                }

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Tenants') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $sql = "select A.*, B.* from 
                        (select * from rent_tenant_details where rent_id = '$rid') A 
                        left join 
                        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                            case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Tenants') B 
                        on (A.contact_id = B.c_id) order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['tenants']=$result;

                $sql = "select A.* from rent_escalation_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['escalations']=$result;

                $sql = "select A.* from rent_pdc_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['pdcs']=$result;

                $data['prop_owners']= $this->rent_model->getPropertyOwners($property_id);

                $sql = "select A.* from rent_other_amt_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['other_amt_details']=$result;

                $data['utility'] = $this->rent_model->getPropertyUtilities($rid, $property_id);

                $sql = "select A.*, B.notification_id, B.owner, B.tenant from 
                        (select * from notification_master) A 
                        left join 
                        (select * from rent_notification_details where rent_id = '$rid') B 
                        on (A.id = B.notification_id) order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['notification']=$result;

                $sql = "select sum(paid_amount) as paid_amount from actual_schedule where table_type='rent' and event_type='Deposit' and fk_txn_id='$rid' and txn_status='Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['deposit_paid_details']=$result;

                $data['r_id']=$rid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view($view,$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($rid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($rid);
        } else  {
            $this->updaterecord($rid);
        }
    }

    public function updaterecord($rid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
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

            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
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

                            $this->db->query("update rent_txn set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$rid'");
                            $logarray['table_id']=$rid;
                            $logarray['module_name']='Rent';
                            $logarray['cnt_name']='Rent';
                            $logarray['action']='Rent Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $rid = $result[0]->txn_id;

                                $this->db->query("Update rent_txn set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$rid'");
                                
                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into rent_txn (gp_id, property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lockin_period, 
                                                 lease_period, rent_due_day, termination_date, txn_status, create_date, created_by, 
                                                 modified_date, modified_by, approved_by, approved_date, remarks, txn_fkid, 
                                                 rejected_by, rejected_date, attorney_id, maker_remark, maintenance_by, property_tax_by, 
                                                 notice_period, category, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                 pdc, deposit_category, invoice_issuer) 
                                                 Select '$gp_id', property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lockin_period, 
                                                 lease_period, rent_due_day, termination_date, '$txn_status', '$create_date', '$created_by', 
                                                 '$modnow', '$curusr', approved_by, approved_date, '$txnremarks', '$rid', 
                                                 rejected_by, rejected_date, attorney_id, maker_remark, maintenance_by, property_tax_by, 
                                                 notice_period, category, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                 pdc, deposit_category, invoice_issuer 
                                                 FROM rent_txn WHERE txn_id = '$rid'");
                                $new_rid=$this->db->insert_id();

                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_rid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                                $query=$this->db->query("SELECT * FROM rent_schedule WHERE rent_id = '$rid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into rent_schedule (rent_id, event_name, event_type, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, status, 
                                                         invoice_no, invoice_date, tax_amount, tds_amount) 
                                                         Select '$new_rid', event_name, event_type, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$curusr', '3', 
                                                         invoice_no, invoice_date, tax_amount, tds_amount 
                                                         FROM rent_schedule WHERE rent_id = '$rid' and sch_id = '$sch_id' and 
                                                         (invoice_no is null or invoice_no='')");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into rent_schedule_taxation (sch_id, tax_master_id, tax_type, tax_percent, 
                                                         tax_amount, rent_id, event_type, status) 
                                                         Select '$new_sch_id', tax_master_id, tax_type, tax_percent, tax_amount, '$new_rid', 
                                                         event_type, '3' 
                                                         FROM rent_schedule_taxation WHERE rent_id = '$rid' and sch_id = '$sch_id'");
                                    }
                                }

                                $this->db->query("Insert into rent_tenant_details (rent_id, contact_id) 
                                                 Select '$new_rid', contact_id FROM rent_tenant_details WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_escalation_details (rent_id, esc_date, escalation) 
                                                 Select '$new_rid', esc_date, escalation FROM rent_escalation_details WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_pdc_details (rent_id, pdc_date, pdc_particular, pdc_amt, pdc_gst, 
                                                    pdc_tds, pdc_net_amt, pdc_chq_no, pdc_bank) 
                                                 Select '$new_rid', pdc_date, pdc_particular, pdc_amt, pdc_gst, 
                                                    pdc_tds, pdc_net_amt, pdc_chq_no, pdc_bank FROM rent_pdc_details 
                                                 WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_other_amt_details (rent_id, amount, due_day, schedule, 
                                                    invoice_date, gst, gst_rate, tds, tds_rate, invoice_issuer, event_name) 
                                                 Select '$new_rid', amount, due_day, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                    invoice_issuer, event_name FROM rent_other_amt_details 
                                                    WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_utility_details (rent_id, utility_id, landlord, tenant, na) 
                                                 Select '$new_rid', utility_id, landlord, tenant, na FROM rent_utility_details 
                                                 WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_notification_details (rent_id, notification_id, owner, tenant) 
                                                 Select '$new_rid', notification_id, owner, tenant FROM rent_notification_details 
                                                 WHERE rent_id = '$rid'");
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $rid);
                        $this->db->delete('rent_txn');

                        $this->db->where('doc_ref_id', $rid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_tenant_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_escalation_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_pdc_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_other_amt_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_utility_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_notification_details');

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Rent');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $deposit_paid_date=$this->input->post('deposit_paid_date');
                    if(validateDate($deposit_paid_date)) {
                        $deposit_paid_date=FormatDate($deposit_paid_date);
                    } else {
                        $deposit_paid_date=null;
                    }

                    $possession_date=$this->input->post('possession_date');
                    if(validateDate($possession_date)) {
                        $possession_date=FormatDate($possession_date);
                    } else {
                        $possession_date=null;
                    }

                    $termination_date=$this->input->post('termination_date');
                    if(validateDate($termination_date)) {
                        $termination_date=FormatDate($termination_date);
                    } else {
                        $termination_date=null;
                    }

                    $invoice_date=$this->input->post('invoice_date');
                    if(validateDate($invoice_date)) {
                        $invoice_date=FormatDate($invoice_date);
                    } else {
                        $invoice_date=null;
                    }

                    $sub_property_id = $this->input->post('sub_property');
                    if($sub_property_id==''){
                        $sub_property_id = null;
                    }
                    
                    $data = array(
                        'gp_id' => $gp_id,
                        'property_id' => $this->input->post('property'),
                        'sub_property_id' => $sub_property_id,
                        'tenant_id' => $this->input->post('owners'),
                        'rent_amount' => format_number($this->input->post('rent_amount'),2),
                        'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                        'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                        'deposit_paid_date' => $deposit_paid_date,
                        'possession_date' => $possession_date,
                        'lockin_period' => format_number($this->input->post('lockin_period'),2),
                        'lease_period' => format_number($this->input->post('lease_period'),2),
                        'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                        'termination_date' => $termination_date,
                        'txn_status' => $txn_status,
                        'maker_remark'=>$this->input->post('maker_remark'),
                        'maintenance_by' => $this->input->post('maintenance_by'),
                        'property_tax_by' => $this->input->post('property_tax_by'),
                        'notice_period' => $this->input->post('notice_period'),
                        'category' => $this->input->post('category'),
                        'schedule' => $this->input->post('schedule'),
                        'invoice_date' => $invoice_date,
                        'gst' => ($this->input->post('gst')=='yes'?'1':'0'),
                        'gst_rate' => format_number($this->input->post('gst_rate'),2),
                        'tds' => ($this->input->post('tds')=='yes'?'1':'0'),
                        'tds_rate' => format_number($this->input->post('tds_rate'),2),
                        'pdc' => ($this->input->post('pdc')=='yes'?'1':'0'),
                        'deposit_category' => $this->input->post('deposit_category'),
                        'invoice_issuer' => $this->input->post('invoice_issuer')
                        );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $rid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('rent_txn',$data);
                        $rid=$this->db->insert_id();

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $rid);
                        $this->db->update('rent_txn',$data);

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');
                        
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_tenant_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_escalation_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_pdc_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_other_amt_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_utility_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_notification_details');
                    }

                    // $this->rent_model->insertSchedule($rid, $txn_status);

                    $this->rent_model->insertTenantDetails($rid);
                    $this->rent_model->insertEscalationDetails($rid);
                    $this->rent_model->insertPDCDetails($rid);
                    $this->rent_model->insertUtilityDetails($rid);
                    $this->rent_model->insertNotificationDetails($rid);

                    $this->rent_model->insertOtherAmtDetails($rid);
                    
                    $this->document_model->insert_doc($rid, 'Property_Rent');

                    $this->rent_model->setSchedule($rid, $txn_status);

                    $this->rent_model->setOtherSchedule($rid, $txn_status);

                    redirect(base_url().'index.php/Rent');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function test(){
        $this->rent_model->setSchedule(55, 'Pending');
        $this->rent_model->setOtherSchedule(55, 'Pending');
    }

    public function approve($rid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
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
                    $this->db->query("update rent_txn set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$rid'");

                    $logarray['table_id']=$rid;
                    $logarray['module_name']='Rent';
                    $logarray['cnt_name']='Rent';
                    $logarray['action']='Rent Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update rent_txn set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$rid'");
                        $this->db->query("update rent_schedule set sch_status = '1', status='1' WHERE rent_id = '$rid'");
                        $this->db->query("update rent_schedule_taxation set status='1' WHERE rent_id = '$rid'");

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update rent_txn A, rent_txn B set A.gp_id=B.gp_id, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.tenant_id=B.tenant_id, 
                                         A.rent_amount=B.rent_amount, A.free_rent_period=B.free_rent_period, 
                                         A.deposit_amount=B.deposit_amount, A.deposit_paid_date=B.deposit_paid_date, 
                                         A.possession_date=B.possession_date, A.lockin_period=B.lockin_period, 
                                         A.lease_period=B.lease_period, 
                                         A.rent_due_day=B.rent_due_day, A.termination_date=B.termination_date, 
                                         A.txn_status='$txn_status', A.create_date=B.create_date, A.created_by=B.created_by, 
                                         A.modified_date=B.modified_date, A.modified_by=B.modified_by, 
                                         A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.remarks='$remarks', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, 
                                         A.maintenance_by=B.maintenance_by, A.property_tax_by=B.property_tax_by, 
                                         A.notice_period=B.notice_period, A.category=B.category, A.schedule=B.schedule, A.invoice_date=B.invoice_date, 
                                         A.gst=B.gst, A.gst_rate=B.gst_rate, A.tds=B.tds, A.tds_rate=B.tds_rate, A.pdc=B.pdc, 
                                         A.deposit_category=B.deposit_category, A.invoice_issuer=B.invoice_issuer 
                                         WHERE B.txn_id = '$rid' and A.txn_id=B.txn_fkid");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                        $this->db->query("update rent_schedule set sch_status = '2', status='2' WHERE rent_id = '$txn_fkid' and (invoice_no is null || invoice_no='')");
                        $this->db->query("update rent_schedule set rent_id = '$txn_fkid', sch_status = '1', status='1' WHERE rent_id = '$rid'");

                        $this->db->query("update rent_schedule_taxation set status='2' WHERE rent_id = '$txn_fkid'");
                        $this->db->query("update rent_schedule_taxation set rent_id = '$txn_fkid', status='1' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_tenant_details');
                        $this->db->query("update rent_tenant_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_escalation_details');
                        $this->db->query("update rent_escalation_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_pdc_details');
                        $this->db->query("update rent_pdc_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_other_amt_details');
                        $this->db->query("update rent_other_amt_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_utility_details');
                        $this->db->query("update rent_utility_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_notification_details');
                        $this->db->query("update rent_notification_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->query("delete from rent_txn WHERE txn_id = '$rid'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Rent');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function getConRent($status='', $contact_id=''){
        $this->checkstatus($status, '', $contact_id);
    }

    public function checkstatus($status='', $property_id='', $contact_id=''){
        $result=$this->rent_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['rent']=$this->rent_model->rentData($status, $property_id, '', $contact_id);

            $count_data=$this->rent_model->getAllCountData($contact_id);
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

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
                }
            }

            $data['contact_id']=$contact_id;
            
            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['checkstatus'] = $status;
            $data['propertynorent']=$this->rent_model->getPropertyNotOnRent();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('rent/tenant_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveTempBulkUpload() {
        $upload_txn_type=$this->input->post('upload_txn_type');
        $_FILES['data_file']['name'];
        $data_array=array();
        $file=explode(".", $_FILES['data_file']['name']);
        //echo $file[1];
        $file_name="excel"."_".$file[0]."_".date('dmy').".xls";
        $upload_path = './uploads/schedule_bulk_upload/';
            
        $this->load->library('upload');
        $this->upload->initialize(array(
            "upload_path"       => $upload_path,
            "encrypt_name"      => FALSE,
            "remove_spaces"     => TRUE,    
            "allowed_types"     => '*',
            "file_name"         => $file_name,
            "max_size"          => '20000000'
        ));

        if (!$this->upload->do_upload("data_file")){
            //echo "Not uploaded";
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }else{
            //echo "uploaded";
            $data = array('upload_data' => $this->upload->data());
        }
        $excel=PHPExcel_IOFactory::load($data['upload_data']['full_path']);
        $sheet=$excel->setActiveSheetIndex(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $mistake=0;
        $tax_available='';
        $errormsg='';
        for ($row = 2; $row <= $highestRow; ++$row) {
            if($sheet->getCellByColumnAndRow(1, $row)->getValue()==''){
                $event_type.=$row.",";
                $mistake++;
            }                
            // if($sheet->getCellByColumnAndRow(3, $row)->getValue()==''){
            //     $basic_cost.=$row.",";
            //     $mistake++;
            // }
            $tax_available=$tax_available.','.addslashes($sheet->getCellByColumnAndRow(4, $row)->getValue());
        }

        //echo $mistake;
        //echo $tax_available;
        
        $getAllTaxes=$this->rent_model->getAllTaxes($upload_txn_type);
        $alltaxes=array();
        foreach($getAllTaxes as $row){
            $alltaxes[]=$row->tax_name;
        }
        $tax_available=explode(',',$tax_available);
       // print_r($alltaxes);
       // print_r($tax_available);
        $tax_available=array_filter($tax_available);
        $result_array=array_diff($tax_available,$alltaxes);
        //print_r($result_array);
        if(count($result_array) > 0 ){
            $mistake++;
            $tax_not_available="following taxes are not availbale please update in Tax master.\n".implode(',',$result_array);
            $errormsg=$errormsg.$tax_not_available;
        }

        if($mistake > 0 ){
            $response=array("status"=>false,"errormsg"=>$errormsg);
        }
        else{
            for ($row = 2; $row <= $highestRow; ++$row) {
                $InvDate=$sheet->getCellByColumnAndRow(4,$row)->getValue();
                $event_date= date($format = "d/m/Y", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                $data['p_schedule'][$row]['event_type']=addslashes($sheet->getCellByColumnAndRow(1, $row)->getValue());
                $data['p_schedule'][$row]['event_name']=addslashes($sheet->getCellByColumnAndRow(1,$row)->getValue());
                // $data['p_schedule'][$row]['sch_pay_type']=addslashes($sheet->getCellByColumnAndRow(2,$row)->getValue());
                // $data['p_schedule'][$row]['sch_agree_value']=addslashes($sheet->getCellByColumnAndRow(3,$row)->getValue());

                $data['p_schedule'][$row]['event_date']=$event_date;
                $data['p_schedule'][$row]['basic_cost']=addslashes($sheet->getCellByColumnAndRow(3,$row)->getValue());
                $tax_apply=explode(',',addslashes($sheet->getCellByColumnAndRow(4,$row)->getValue()));
                for($i=0;$i<count($tax_apply);$i++){
                    $data['p_schedule'][$row]['tax_type'][$i]=$tax_apply[$i];
                }
            }
            $rowcounter=$highestRow;
            $data['tax_details']=$this->rent_model->getAllTaxes($upload_txn_type);                
            $bulkuploaddata=$this->load->view('rent/bulk_upload_view',$data,true);
            $response=array("status"=>true,"data"=>$bulkuploaddata,"rowcounter"=>$rowcounter);
        }

        echo json_encode($response);
    }

    ##################################RENT RECEIVE################################

    public function recieve_new($schid=NULL){
        $query=$this->db->query("SELECT * FROM rent_schedule WHERE sch_id = '$schid'");
        $result=$query->result();
        $data['rec']=$result;

        if(count($result) >0 ) {
            $rtid=$result[0]->rent_id;

            $query=$this->db->query("SELECT * FROM rent_txn LEFT JOIN purchase_txn ON rent_txn.property_id=purchase_txn.txn_id WHERE rent_txn.txn_id ='$rtid'");
            $result=$query->result();
            $data['rent_txn']=$result;

            $query=$this->db->query("SELECT * FROM rent_payment_notes WHERE sch_id='$schid'");
            $result=$query->result();
            $data['rent_note']=$result;
        }

        $data['sch_id']=$schid;
        load_view('rent/rent_payment_receive', $data);
    }

    public function savepayment($schid){
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM rent_schedule WHERE sch_id='$schid'");
        $result=$query->result();

        $netamt=$result[0]->net_amount;
        $paid=format_number($this->input->post('payment_amount'),2);
        $balance=$netamt-$paid;

        $status='Pending';

        if($balance==0){
            $status='Paid';
        }

                $confi['upload_path']='./uploads/';
                $confi['allowed_types']='*';
                $this->load->library('upload', $confi);
                $extension="";

                if(!empty($_FILES['attach']['name'])) {
                    if($this->upload->do_upload('attach')) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    
                    $source='./uploads/'.$fileName;
                    $extension=$upload_data['file_ext'];

                    echo $fileName;
                    echo "<br>".$extension."<br>";

                    $this->load->library('ftp');

                    $ftp_config['hostname'] = 'localhost';
                    $ftp_config['username'] = 'user1';
                    $ftp_config['password'] = 'password';
                    $ftp_config['port'] = 21;
                    $ftp_config['debug'] = FALSE;

                    $dir='test/rent/schedule/';
                    $this->ftp->connect($ftp_config);
            
                    $dirlst=$this->ftp->list_files($dir.'sch_'.$schid);
                    
                    $existsdir=false;

                    for($l=0;$l<count($dirlst); $l++) {
                        if ($dirlst[$l]==$dir) {
                            $existsdir=true;
                        }
                    }

                    if ($existsdir==true) {
                        $destination=$dir.'sch_'.$schid.$extension;
                        $this->ftp->upload($source, $destination, 0777);
                    } else {
                        echo "Yo!!!<br>";
                        $this->ftp->mkdir($dir.'sch_'.$schid);
                        $destination=$dir.'sch_'.$extension;
                        $this->ftp->upload($source, $destination, 0777);
                    }
                    $this->ftp->close();
                    
                    @unlink($source);
                    
                    $data = array
                    (
                        'sch_status' => $status,
                        'pay_rec_date' => $this->input->post('rec_date'),
                        'pay_amount' => $paid,
                        'pay_balance' => $balance,
                        'pay_method' => $this->input->post('method'),
                        'pay_filepath' => $destination,
                        'pay_filename' => 'sch_'.$schid.$extension,
                        'modified_date' => $modnow,
                    );

                    $this->db->where('sch_id', $schid);
                    $this->db->update('rent_schedule', $data);
                    echo "Main<br>";
                } else {
                    echo "Other<br>";
                    $data = array
                    (
                        'sch_status' => $status,
                        'pay_rec_date' => $this->input->post('rec_date'),
                        'pay_amount' => $paid,
                        'pay_balance' => $balance,
                        'pay_method' => $this->input->post('method'),
                        'pay_filepath' => '',
                        'pay_filename' => '',
                        'modified_date' => $modnow,
                    );
                    $this->db->where('sch_id', $schid);
                    $this->db->update('rent_schedule', $data);
                }

                $this->db->where('sch_id', $schid);
                $this->db->delete('rent_payment_notes');

                $account=$this->input->post('account[]');
                $bal=$this->input->post('balance[]');
                $amt=$this->input->post('amount[]');

                for ($i=0; $i < count($account) ; $i++) { 
                    $data = array
                    (
                        'sch_id' => $schid,
                        'account_number' => $account[$i],
                        'balance' => format_number($bal[$i],2),
                        'amount' => format_number($amt[$i],2),
                    );
                    $this->db->insert('rent_payment_notes', $data);   
                }
    }

    function send_mail_test(){
        $this->rent_model->send_rent_intimation('24');
    }

    public function schedule_test(){
        $this->rent_model->setSchedule('55', 'Approved');
    }

}
?>