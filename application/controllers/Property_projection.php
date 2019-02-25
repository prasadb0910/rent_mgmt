<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Property_projection extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('common_functions');
        $this->load->model('property_projection_model');
        $this->load->model('sales_model');
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function addnew() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Valuation' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();

        if(count($result)>0) {
            $data['tax_details']=$this->property_projection_model->getAllTaxes();
            $data['property']= $this->sales_model->getPropertyDetails();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('property_projection/property_projection_view',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $result=$this->property_projection_model->getAccess();

        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $projection_date=$this->input->post('projection_date');
            if($projection_date==''){
                $projection_date=NULL;
            }
            else{
                $projection_date=formatdate($projection_date);
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $status='Approved';
            } else  {
                $status='In Process';
            }
            $id=$this->property_projection_model->insertRecord($projection_date, $status);

            redirect(base_url().'index.php/property_projection');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $result=$this->property_projection_model->getAccess();
        $data['tax_details']=$this->property_projection_model->getAllTaxes();

        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1) {
                $data['access']=$result;
                
                $query=$this->db->query("SELECT * FROM property_projection_details WHERE fk_id = '$id'");
                $result1=$query->result();
                if (count($result1)>0){
                    $id = $result1[0]->id;
                }

                $data['property']= $this->sales_model->getPropertyDetails();
                $data['projection_detail']=$this->property_projection_model->getDetails($id);

                if(count($data['projection_detail'])>0){
                    $property_id = $data['projection_detail'][0]->purchase_id;
                    $data['sub_property']= $this->sales_model->getSubPropertyDetails('', $property_id);
                } else {
                    $data['sub_property']= array();
                }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('property_projection/property_projection_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $result=$this->property_projection_model->getAccess();
        $data['tax_details']=$this->property_projection_model->getAllTaxes();

        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1) {
                $data['access']=$result;
                $data['Property_projectionby']=$this->session->userdata('session_id');

                $data['property']= $this->sales_model->getPropertyDetails();
                $data['projection_detail']=$this->property_projection_model->projectionData('All', $id);

                if(count($data['projection_detail'])>0){
                    $property_id = $data['projection_detail'][0]->purchase_id;
                    $data['sub_property']= $this->sales_model->getSubPropertyDetails('', $property_id);
                } else {
                    $data['sub_property']= array();
                }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('property_projection/projection_detail_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updaterecord($id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Valuation' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $status='Approved';
            } else  {
                $status='In Process';
            }

            $query=$this->db->query("SELECT * FROM property_projection_details WHERE id = '$id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->status;
                $fk_id = $res[0]->fk_id;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
            } else {
                $rec_status = 'In Process';
                $fk_id = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $created_on = $now;
            }

            if($status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $checker_remark = $this->input->post('status_remarks');

                        if($maker_checker!='yes'){
                            $status = 'Inactive';

                            $this->db->query("update property_projection_details set status='$status', checker_remark='$checker_remark', updated_by='$curusr', 
                                            updated_on='$modnow' WHERE id = '$id'");

                            $logarray['table_id']=$id;
                            $logarray['module_name']='Property Projection';
                            $logarray['cnt_name']='Property_projection';
                            $logarray['action']='Property Projection Record ' . $status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM property_projection_details WHERE fk_id = '$id'");
                            $result=$query->result();
                            if (count($result)>0){
                                $id = $result[0]->id;

                                $this->db->query("Update property_projection_details set status='$status', checker_remark='$checker_remark', 
                                                 updated_on='$modnow', updated_by='$curusr' 
                                                 WHERE id = '$id'");
                                $logarray['table_id']=$id;
                                $logarray['module_name']='Property Projection';
                                $logarray['cnt_name']='Property_projection';
                                $logarray['action']='Property Projection Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into property_projection_details (gp_id, purchase_id, sub_property_id, 
                                                req_rate_return, rrv_value, cost_of_aqua, market_rate, market_value, tax_applicable, 
                                                profit_loss, projection_date, status_id, status, created_on, created_by, 
                                                updated_on, updated_by, approved_by, approved_date, rejected_by, rejected_date, 
                                                checker_remark, fk_id, maker_remark) 
                                                Select '$gp_id', purchase_id, sub_property_id, 
                                                req_rate_return, rrv_value, cost_of_aqua, market_rate, market_value, tax_applicable, 
                                                profit_loss, projection_date, status_id, '$status', '$created_on', '$created_by', 
                                                '$modnow', '$curusr', approved_by, approved_date, rejected_by, rejected_date, 
                                                '$checker_remark', '$id', maker_remark 
                                                FROM property_projection_details WHERE id = '$id'");
                                $new_id=$this->db->insert_id();
                                $logarray['table_id']=$id;
                                $logarray['module_name']='Property Projection';
                                $logarray['cnt_name']='Property_projection';
                                $logarray['action']='Property Projection Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('id', $id);
                        $this->db->delete('property_projection_details');

                        $logarray['table_id']=$id;
                        $logarray['module_name']='Property Projection';
                        $logarray['cnt_name']='Property_projection';
                        $logarray['action']='Property Projection Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                    }

                    redirect(base_url().'index.php/property_projection');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $projection_date=$this->input->post('projection_date');
                    if($projection_date==''){
                        $projection_date=NULL;
                    } else {
                        $projection_date=formatdate($projection_date);
                    }
                    $data = array(
                        'purchase_id'=>$this->input->post('property'),
                        'sub_property_id'=>$this->input->post('sub_property'),
                        'req_rate_return'=>format_number($this->input->post('req_rate_return'),2),
                        'rrv_value'=>format_number($this->input->post('rrv_value'),2),
                        'cost_of_aqua'=>format_number($this->input->post('index_cost_value'),2),
                        'market_rate'=>format_number($this->input->post('market_rate'),2),
                        'market_value'=>format_number($this->input->post('market_value'),2),
                        'tax_applicable'=>($this->input->post('tax_app')==''?'0':$this->input->post('tax_app')),
                        'profit_loss'=>format_number($this->input->post('profit_loss'),2),
                        'maker_remark'=>$this->input->post('maker_remark'),
                        'projection_date'=>$projection_date,
                        'gp_id'=>$gid,
                        'status' => $status
                    );
                       
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $fk_id = $id;
                        $data['fk_id'] = $fk_id;
                        $data['created_on'] = $created_on;
                        $data['created_by'] = $created_by;
                        $data['updated_on'] = $modnow;
                        $data['updated_by'] = $curusr;

                        $this->db->insert('property_projection_details',$data);
                        $id=$this->db->insert_id();

                        $logarray['table_id']=$fk_id;
                        $logarray['module_name']='Property Projection';
                        $logarray['cnt_name']='Property_projection';
                        $logarray['action']='Property Projection Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $data['updated_on'] = $modnow;
                        $data['updated_by'] = $curusr;

                        $this->db->where('id', $id);
                        $this->db->update('property_projection_details',$data);

                        $logarray['table_id']=$id;
                        $logarray['module_name']='Property Projection';
                        $logarray['cnt_name']='Property_projection';
                        $logarray['action']='Property Projection Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/property_projection');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($id) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Valuation' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM property_projection_details WHERE id = '$id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->status;
                    $fk_id = $res[0]->fk_id;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $fk_id = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $status='Approved';
                } else  {
                    $status='Rejected';
                }
                $checker_remark = $this->input->post('status_remarks');

                if ($status=='Rejected') {
                    $this->db->query("update property_projection_details set status='Rejected', checker_remark='$checker_remark', rejected_by='$curusr', rejected_date='$modnow' WHERE id = '$id'");

                    $logarray['table_id']=$id;
                    $logarray['module_name']='Property Projection';
                    $logarray['cnt_name']='Property_projection';
                    $logarray['action']='Property Projection Record ' . $status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($fk_id=='' || $fk_id==null) {
                        $this->db->query("update property_projection_details set status='Approved', checker_remark='$checker_remark', approved_by='$curusr', approved_date='$modnow' WHERE id = '$id'");

                        $logarray['table_id']=$id;
                        $logarray['module_name']='Property Projection';
                        $logarray['cnt_name']='Property_projection';
                        $logarray['action']='Property Projection Record ' . $status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                    } else {
                        if ($rec_status=='Delete') {
                            $status='Inactive';
                        }
                        $this->db->query("update property_projection_details A, property_projection_details B set A.gp_id=B.gp_id, 
                                         A.purchase_id=B.purchase_id, A.sub_property_id=B.sub_property_id, 
                                         A.req_rate_return=B.req_rate_return, A.rrv_value=B.rrv_value, 
                                         A.cost_of_aqua=B.cost_of_aqua, A.market_rate=B.market_rate, A.market_value=B.market_value, 
                                         A.tax_applicable=B.tax_applicable, A.profit_loss=B.profit_loss, A.projection_date=B.projection_date, 
                                         A.status_id = B.status_id, A.status='$status', 
                                         A.created_on=B.created_on, A.created_by=B.created_by, A.updated_on=B.updated_on, 
                                         A.updated_by=B.updated_by, A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.checker_remark='$checker_remark', A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark 
                                         WHERE B.id = '$id' and A.id=B.fk_id");

                        $this->db->query("delete from property_projection_details WHERE id = '$id'");
                            
                        $logarray['table_id']=$fk_id;
                        $logarray['module_name']='Property Projection';
                        $logarray['cnt_name']='Property_projection';
                        $logarray['action']='Property Projection Record ' . $status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Property_Projection');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->property_projection_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['prt_details']=$this->property_projection_model->projectionData($status);

            $count_data=$this->property_projection_model->projectionData('All');
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('property_projection/property_projection_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getAgreementArea(){
        $property_id=$this->input->post('property_id');
        $response=$this->property_projection_model->getAgreementArea($property_id);
        echo json_encode($response);
    }

    function getindex($date){
        $index = 0;
        // $date=$this->input->post('curr_date');
        if($date !=''){
            $date=date('d/m/Y');
        }
        if ($this->validateDate($date)) {
            $date=FormatDate($date);

            $year = substr($date, 0, 4);
            $month = date("m", strtotime($date));
            if ($month<=3) {
                $end_year = $year;
                $start_year = intval($year) - 1;
            } else {
                $start_year = $year;
                $end_year = intval($year) + 1;
            }

            $financial_year = $start_year . '-' . substr($end_year,2);
            // echo $financial_year;

            $query=$this->db->query("SELECT * FROM indexation_master WHERE i_financial_year = '$financial_year'");
            $result=$query->result();

            if (count($result)>0) {
                $index = $result[0]->i_cost_inflation_index;
                $index = str_replace(",", "", $index);
            } else {
                $index = 0;
            }
        }
        return $index;
    }

    function getCostOfIndexation(){
        $pid=$this->input->post('property_id');
        $projection_date=$this->input->post('projection_date');

        // $pid='45';
        // $projection_date='01/10/2016';

        $date=date('d/m/Y');
        $slindex = $this->getindex($date);
        if (is_numeric ($slindex)) {
            $slindex = floatval($slindex);
        } else {
            $slindex = 0;
        }
        $query=$this->db->query("SELECT sum(net_amount) as cost_of_purchase FROM purchase_schedule WHERE purchase_id = '$pid' and status = '1'");
        $result=$query->result();
        if (count($result)>0) {
            $cost_of_purchase=$result[0]->cost_of_purchase;
            if (is_numeric ($cost_of_purchase)) {
                $cost_of_purchase = floatval($cost_of_purchase);
            } else {
                $cost_of_purchase = 0;
            }
        } else {
            $cost_of_purchase = 0;
        }

        // $query=$this->db->query("SELECT txn_id, DATE_FORMAT(p_purchase_date,'%d/%m/%Y') as p_purchase_date FROM purchase_txn WHERE txn_id = '$pid'");
        // $result=$query->result();
        // if (count($result)>0) {
        //     $p_purchase_date=$result[0]->p_purchase_date;
        //     $prindex = $this->getindex($p_purchase_date);
        //     if (is_numeric ($prindex)) {
        //         $prindex = floatval($prindex);
        //     } else {
        //         $prindex = 0;
        //     }
        // } else {
        //     $prindex = 0;
        // }
        $prindex = $this->getindex($projection_date);
        if (is_numeric ($prindex)) {
            $prindex = floatval($prindex);
        } else {
            $prindex = 0;
        }

        $prindex = ($prindex==0)?1:$prindex;
        $cost_of_acqisition = $cost_of_purchase * ($slindex/$prindex);

        echo $cost_of_acqisition;
    }

    public function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
?>