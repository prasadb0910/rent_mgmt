<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Allocation extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->model('purchase_model');
        $this->load->database();
    }

    public function index(){
        $this->checkstatus('All');
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid' and txn_status='Approved'");
            $result=$query->result();
            $data['property']=$result;
            
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('allocation/allocation_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $pid=$this->input->post('property');
        if($this->input->post('submit')=='Submit For Approval') {
            $txn_status='Pending';
        } else if($this->input->post('submit')=='Submit') {
            $txn_status='Approved';
        } else  {
            $txn_status='In Process';
        }

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');
            $subproperty=$this->input->post('sub_property[]');
            $type=$this->input->post('sub_type[]');
            $carpet=$this->input->post('carpet[]');
            $carpetunit=$this->input->post('carpet_unit[]');
            $builtup=$this->input->post('builtup[]');
            $builtupunit=$this->input->post('builtup_area[]');
            $sellable=$this->input->post('sellable[]');
            $sellableunit=$this->input->post('sellable_area[]');
            $allocatedcost=$this->input->post('allocated_cost[]');
            $allocatedmaintainance=$this->input->post('allocated_maintainance[]');
            $allocatedexpenses=$this->input->post('allocated_expenses[]');
            $data = array(
                'property_id' => $pid
            );
            $this->db->insert('sub_property_id', $data);
            $sp_id=$this->db->insert_id();

            for ($i=0; $i < count($subproperty) ; $i++) { 
                if($subproperty[$i]!='' && $subproperty[$i]!='0') {
                    $data = array(
                        'property_id' => $pid,
                        'sp_id' => $sp_id,
                        'sp_name' => $subproperty[$i],
                        'sp_type' => $type[$i],
                        'sp_carpet_area' => format_number($carpet[$i],2),
                        'sp_carpet_area_unit' => $carpetunit[$i],
                        'sp_builtup_area' => format_number($builtup[$i],2),
                        'sp_builtup_area_unit' => $builtupunit[$i],
                        'sp_sellable_area' => format_number($sellable[$i],2),
                        'sp_sellable_area_unit' => $sellableunit[$i],
                        'allocated_cost' => format_number($allocatedcost[$i],2),
                        'allocated_maintainance' => format_number($allocatedmaintainance[$i],2),
                        'allocated_expenses' => format_number($allocatedexpenses[$i],2),
                        'txn_status' => $txn_status,
                        'create_date' => $now,
                        'created_by' => $curusr,
                        'modified_date' => $now,
                        'modified_by' => $curusr,
                        'gp_id' => $gid,
                        'maker_remark' => $this->input->post('maker_remark')
                     );
                    
                    $this->db->insert('sub_property_allocation', $data);

                    $this->insertImage($pid);

                    $logarray['table_id']=$this->db->insert_id();
                    $logarray['module_name']='Property Allocation';
                    $logarray['cnt_name']='Allocation';
                    $logarray['action']='Allocation Record Insert';
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                }
            }

            // $pending_activity=$this->input->post('pending_activity[]');
            // for ($i=0; $i <  count($pending_activity); $i++) {
            //     if($pending_activity[$i]!="") {
            //         $data = array(
            //             'type' => 'allocation',
            //             'ref_id' => $sp_id,
            //             'pending_activity' => $pending_activity[$i]
            //             );
            //         $this->db->insert('pending_activity', $data);
            //     }
            // }

            $this->send_allocation_intimation($pid, $txn_status);

            redirect(base_url().'index.php/Allocation');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($pid, $txn_status) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 or $result[0]->r_view == 1) {
                $data['access']=$result;

                $data['allocationby']=$this->session->userdata('session_id');

                $data['p_id']=$pid;

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid'");
                $result=$query->result();
                $data['property']=$result;
                
                if($txn_status=="InProcess"){
                    $txn_status="In Process";
                }

                // $sql_owner="select  A.purchase_id ,A.pr_client_id ,case when B.ow_type = '0' then 
                //             (select  concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                //                 where c_id = B.ow_ind_id) 
                //             when B.ow_type = '1' then B.ow_huf_name 
                //             when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //             when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //             when B.ow_type = '4' then B.ow_llp_comapny_name 
                //             when B.ow_type = '5' then B.ow_prt_comapny_name 
                //             when B.ow_type = '6' then B.ow_aop_comapny_name 
                //             when B.ow_type = '7' then B.ow_trs_comapny_name 
                //             else B.ow_proprietorship_comapny_name end as owner_name 
                //             from purchase_ownership_details A, owner_master B where B.ow_id = A.pr_client_id and A.purchase_id = '$pid' ";

                $sql_owner = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                        (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A where A.purchase_id = '$pid') A 
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
                        on (A.pr_client_id=B.c_id) order by pr_client_id";

                $result_owner=$this->db->query($sql_owner);
                $data['owner']=$result_owner->result();

                $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$pid' AND txn_status = '$txn_status'");
                $result=$query->result();
                $data['sub_property']=$result;

                // if (count($result)>0) {
                //     $sp_id = $result[0]->sp_id;

                //     $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$sp_id' and type = 'allocation'");
                //     $result=$query->result();
                //     if(count($result)>0){
                //         $data['pending_activity']=$result;
                //     }
                // }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('allocation/allocation_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($pid, $txn_status){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1){
                $data['p_id']=$pid;

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid'");
                $result=$query->result();
                $data['property']=$result;
                
                if ($txn_status=="In%20Process") {
                    $txn_status="In Process";
                }
                
                $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE fk_property_id = '$pid'");
                $result=$query->result();
                if (count($result)>0){
                    $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE fk_property_id = '$pid'");
                    $result=$query->result();
                    $data['sub_property']=$result;

                    // if (count($result)>0) {
                    //     $sp_id = $result[0]->sp_id;

                    //     $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$sp_id' and type = 'allocation'");
                    //     $result=$query->result();
                    //     if(count($result)>0){
                    //         $data['pending_activity']=$result;
                    //     }
                    // }
                } else {
                    $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$pid' AND txn_status = '$txn_status'");
                    $result=$query->result();
                    $data['sub_property']=$result;

                    // if (count($result)>0) {
                    //     $sp_id = $result[0]->sp_id;

                    //     $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$sp_id' and type = 'allocation'");
                    //     $result=$query->result();
                    //     if(count($result)>0){
                    //         $data['pending_activity']=$result;
                    //     }
                    // }
                }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('allocation/allocation_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($pid, $txn_status) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approverecord($pid, $txn_status);
        } else  {
            $this->updaterecord($pid, $txn_status);
        }
    }

    public function updaterecord($pid, $txn_status){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        if($txn_status=='In%20Process'){
            $txn_status = 'In Process';
        }
        
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$pid' and txn_status = '$txn_status'");
            $res=$query->result();
            if(count($res)>0) {
                $txn_id = $res[0]->txn_id;
                $rec_status = $res[0]->txn_status;
                $fk_property_id = $res[0]->fk_property_id;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
                $sp_id = $res[0]->sp_id;
            } else {
                $txn_id = '';
                $rec_status = 'In Process';
                $fk_property_id = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
                $sp_id = '';
            }

            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }
            
            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update sub_property_allocation set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE fk_property_id = '$pid'");
                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Property Allocation';
                            $logarray['cnt_name']='Allocation';
                            $logarray['action']='Allocation Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE fk_property_id = '$pid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $this->db->query("Update sub_property_allocation set txn_status='$txn_status', txn_remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE fk_property_id = '$pid'");
                                $logarray['table_id']=$txn_id;
                                $logarray['module_name']='Property Allocation';
                                $logarray['cnt_name']='Allocation';
                                $logarray['action']='Allocation Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into sub_property_id (property_id) values ('$pid')");
                                $new_sp_id=$this->db->insert_id();

                                $this->db->query("Insert into sub_property_allocation (property_id, sp_id, sp_name, sp_type, 
                                                sp_carpet_area, sp_carpet_area_unit, sp_builtup_area, sp_builtup_area_unit, 
                                                sp_sellable_area, sp_sellable_area_unit, allocated_cost, allocated_maintainance, 
                                                allocated_expenses, created_by, create_date, modified_by, modified_date, 
                                                approved_by, approved_date, txn_status, txn_remarks, fk_property_id, fk_txn_id, 
                                                gp_id, rejected_by, rejected_date, maker_remark, image, image_name) 
                                                Select '$pid', '$new_sp_id', sp_name, sp_type, 
                                                sp_carpet_area, sp_carpet_area_unit, sp_builtup_area, sp_builtup_area_unit, 
                                                sp_sellable_area, sp_sellable_area_unit, allocated_cost, allocated_maintainance, 
                                                allocated_expenses, '$created_by', '$create_date', '$curusr', '$modnow', 
                                                approved_by, approved_date, '$txn_status', '$txnremarks', '$pid', txn_id, '$gp_id', 
                                                rejected_by, rejected_date, maker_remark, image, image_name 
                                                FROM sub_property_allocation WHERE property_id = '$pid'");
                                // $new_pid=$this->db->insert_id();
                                $logarray['table_id']=$this->db->insert_id();
                                $logarray['module_name']='Property Allocation';
                                $logarray['cnt_name']='Allocation';
                                $logarray['action']='Allocation Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                
                                // $this->db->query("Insert into pending_activity (ref_id, type, pending_activity) 
                                //                  Select '$new_sp_id', type, pending_activity FROM pending_activity WHERE ref_id = '$sp_id' and type = 'allocation'");
                            }
                        }
                    } else {
                        $this->db->query("delete from sub_property_id WHERE id = '$sp_id'");
                        $this->db->query("delete from sub_property_allocation WHERE fk_property_id = '$pid'");
                        // $this->db->query("delete from pending_activity WHERE ref_id = '$sp_id'");
                        $logarray['table_id']=$txn_id;
                        $logarray['module_name']='Property Allocation';
                        $logarray['cnt_name']='Allocation';
                        $logarray['action']='Delete Allocation Record ';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Allocation');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $now = date('Y-m-d H:i:s');
                    
                    $pid=$this->input->post('property');
                    $subpropertyid=$this->input->post('sub_property_id[]');
                    $subproperty=$this->input->post('sub_property[]');
                    $type=$this->input->post('sub_type[]');
                    $carpet=$this->input->post('carpet[]');
                    $carpetunit=$this->input->post('carpet_unit[]');
                    $builtup=$this->input->post('builtup[]');
                    $builtupunit=$this->input->post('builtup_area[]');
                    $sellable=$this->input->post('sellable[]');
                    $sellableunit=$this->input->post('sellable_area[]');
                    $allocatedcost=$this->input->post('allocated_cost[]');
                    $allocatedmaintainance=$this->input->post('allocated_maintainance[]');
                    $allocatedexpenses=$this->input->post('allocated_expenses[]');

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $data = array(
                            'property_id' => $pid
                        );
                        $this->db->insert('sub_property_id', $data);
                        $sp_id=$this->db->insert_id();
                    }

                    for ($i=0; $i < count($subproperty) ; $i++) { 
                        if($subproperty[$i]!='' && $subproperty[$i]!='0') {
                            $data = array(
                                'property_id' => $pid,
                                'sp_id' => $sp_id,
                                'sp_name' => $subproperty[$i],
                                'sp_type' => $type[$i],
                                'sp_carpet_area' => format_number($carpet[$i],2),
                                'sp_carpet_area_unit' => $carpetunit[$i],
                                'sp_builtup_area' => format_number($builtup[$i],2),
                                'sp_builtup_area_unit' => $builtupunit[$i],
                                'sp_sellable_area' => format_number($sellable[$i],2),
                                'sp_sellable_area_unit' => $sellableunit[$i],
                                'allocated_cost' => format_number($allocatedcost[$i],2),
                                'allocated_maintainance' => format_number($allocatedmaintainance[$i],2),
                                'allocated_expenses' => format_number($allocatedexpenses[$i],2),
                                'txn_status' => $txn_status,
                                'create_date' => $create_date,
                                'created_by' => $created_by,
                                'modified_date' => $modnow,
                                'modified_by' => $curusr,
                                'gp_id' => $gp_id,
                                'maker_remark' => $this->input->post('maker_remark')
                            );

                            if ($rec_status=="Approved" && $maker_checker=='yes') {
                                $data['fk_property_id'] = $pid;
                                $data['fk_txn_id'] = $subpropertyid[$i];

                                $data['modified_date']=$modnow;
                                $data['modified_by']=$curusr;
                                $this->db->insert('sub_property_allocation', $data);

                                $this->insertImage($pid);

                                $logarray['table_id']=$subpropertyid[$i];
                                $logarray['module_name']='Property Allocation';
                                $logarray['cnt_name']='Allocation';
                                $logarray['action']='Allocation Approved Record Modified';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray); 
                            } else {
                                if ($subpropertyid[$i]=='' || $subpropertyid[$i]==null) {
                                    // $data['create_date']=$now;
                                    // $data['created_by']=$curusr;
                                    $this->db->insert('sub_property_allocation', $data);

                                    $this->insertImage($pid);

                                    $logarray['table_id']=$this->db->insert_id();
                                    $logarray['module_name']='Property Allocation';
                                    $logarray['cnt_name']='Allocation';
                                    $logarray['action']='Allocation Record Inserted';
                                    $logarray['gp_id']=$gid;
                                    $this->user_access_log_model->insertAccessLog($logarray); 
                                } else {
                                    $data['modified_date']=$modnow;
                                    $data['modified_by']=$curusr;
                                    $this->db->where('txn_id',$subpropertyid[$i]);
                                    $this->db->update('sub_property_allocation', $data);

                                    $this->insertImage($pid);

                                    $logarray['table_id']=$subpropertyid[$i];
                                    $logarray['module_name']='Property Allocation';
                                    $logarray['cnt_name']='Allocation';
                                    $logarray['action']='Allocation Record Modified';
                                    $logarray['gp_id']=$gid;
                                    $this->user_access_log_model->insertAccessLog($logarray);
                                }
                            }
                        }
                    }

                    // if ($rec_status!="Approved" || $maker_checker!='yes') {
                    //     $this->db->where('ref_id', $sp_id);
                    //     $this->db->where('type', 'Allocation');
                    //     $this->db->delete('pending_activity');
                    // }

                    // $pending_activity=$this->input->post('pending_activity[]');
                    // for ($i=0; $i <  count($pending_activity); $i++) {
                    //     if($pending_activity[$i]!="") {
                    //         $data = array(
                    //             'type' => 'allocation',
                    //             'ref_id' => $sp_id,
                    //             'pending_activity' => $pending_activity[$i]
                    //             );
                    //         $this->db->insert('pending_activity', $data);
                    //     }
                    // }

                    redirect(base_url().'index.php/Allocation');
                } else {
                    echo "Unauthorized access.";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approverecord($pid, $txn_status) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$pid' and txn_status = '$txn_status'");
                $res=$query->result();
                if(count($res)>0) {
                    $txn_id = $res[0]->txn_id;
                    $rec_status = $res[0]->txn_status;
                    $fk_property_id = $res[0]->fk_property_id;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $txn_id = '';
                    $rec_status = '';
                    $fk_property_id = '';
                    $gp_id = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else {
                    $txn_status='Rejected';
                }
                $txn_remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    if ($fk_property_id=='' || $fk_property_id==null) {
                        $this->db->query("update sub_property_allocation set txn_status='Rejected', txn_remarks='$txn_remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE property_id = '$pid' and txn_status = '$rec_status'");
                    } else {
                        $this->db->query("update sub_property_allocation set txn_status='Rejected', txn_remarks='$txn_remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE fk_property_id = '$fk_property_id'");
                    }
                } else {
                    if ($fk_property_id=='' || $fk_property_id==null) {
                        $this->db->query("update sub_property_allocation set txn_status='Approved', txn_remarks='$txn_remarks', approved_by='$curusr', approved_date='$modnow' WHERE property_id = '$pid' and txn_status = '$rec_status'");
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }

                        $query=$this->db->query("select * from sub_property_allocation WHERE property_id = '$pid' and txn_status = 'Approved'");
                        $result=$query->result();
                        if(count($result)>0) {
                            $sp_id=$result[0]->sp_id;
                        } else {
                            $sp_id='';
                        }

                        $this->db->query("update sub_property_allocation A, sub_property_allocation B 
                                         set A.property_id=B.property_id, A.sp_id=B.sp_id, A.sp_name=B.sp_name, A.sp_type=B.sp_type, 
                                         A.sp_carpet_area=B.sp_carpet_area, A.sp_carpet_area_unit=B.sp_carpet_area_unit, 
                                         A.sp_builtup_area=B.sp_builtup_area, A.sp_builtup_area_unit=B.sp_builtup_area_unit, 
                                         A.sp_sellable_area=B.sp_sellable_area, A.sp_sellable_area_unit=B.sp_sellable_area_unit, 
                                         A.allocated_cost=B.allocated_cost, A.allocated_maintainance=B.allocated_maintainance, 
                                         A.allocated_expenses=B.allocated_expenses, A.created_by=B.created_by, 
                                         A.create_date=B.create_date, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.txn_status='$txn_status', A.txn_remarks='$txn_remarks', A.gp_id=B.gp_id, 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, 
                                         A.image=B.image, A.image_name=B.image_name 
                                         where B.property_id = '$pid' and A.property_id = B.fk_property_id and 
                                         A.txn_id = B.fk_txn_id");
                        
                        $this->db->query("update sub_property_allocation set txn_status='$txn_status', txn_remarks='$txn_remarks', fk_property_id=null, fk_txn_id=null, approved_by='$curusr', approved_date='$modnow' WHERE property_id = '$pid' and txn_status = '$rec_status' and fk_property_id is not null and (fk_txn_id is null or fk_txn_id = 0)");

                        $this->db->where('ref_id', $sp_id);
                        $this->db->where('type', 'allocation');
                        // $this->db->delete('pending_activity');
                        
                        $this->db->query("delete from sub_property_allocation WHERE property_id = '$pid' and fk_property_id is not null");
                    }
                }

                $logarray['table_id']=$txn_id;
                $logarray['module_name']='Property Allocation';
                $logarray['cnt_name']='Allocation';
                $logarray['action']='Allocation Record ' . $txn_status;
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
            }
        }

        redirect(base_url().'index.php/Allocation');
    }

    public function checkstatus($status='', $property_id=''){
        if($status=='All'){
            $cond="";
        } else if($status=='InProcess'){
            $status='In Process';
            $cond=" and txn_status='In Process'";
        } else if($status=='Pending'){
            $cond=" and (txn_status='Pending' or txn_status='Delete')";
        } else {
            $cond=" and txn_status='$status'";
        }

        if($property_id!=''){
            $cond2 = " and property_id = '$property_id'";
        } else {
            $cond2 = '';
        }

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Allocation' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            
            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $sql = "select C.*, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
                        (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                        B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                        B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink , B.prop_status from 
                        (select property_id, txn_status, created_by, modified_by, image, 
                        sum(allocated_cost) as tot_allocated_cost, 
                        sum(allocated_maintainance) as tot_allocated_maintainance, 
                        sum(allocated_expenses) as tot_allocated_expenses from sub_property_allocation 
                        where gp_id = '$gid' and property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id')) " . $cond . $cond2 . " 
                        group by property_id, txn_status, created_by, modified_by, image) A 
                        left join 
                        (select A.*, B.purchase_price from 
                        (select C.*, case when C.property_status='Vacant' then case when D.property_id is null then 'Vacant' else 'Occupied' end 
                                    else C.property_status end as prop_status, D.termination_date from 
                        (select A.*, case when B.property_id is null then 'Vacant' else 'Sold' end as property_status, B.date_of_sale from 
                        (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                        from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) where A.gp_id='$gid') A 
                        left join 
                        (select property_id, max(date_of_sale) as date_of_sale from sales_txn 
                            where txn_status='Approved' and gp_id='$gid' group by property_id) B 
                        on (A.txn_id=B.property_id)) C 
                        left join 
                        (select property_id, max(termination_date) as termination_date from rent_txn 
                            where txn_status='Approved' and gp_id='$gid' and DATE(NOW()) <= DATE(termination_date) group by property_id) D 
                        on (C.txn_id=D.property_id)) A 
                        left join 
                        (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                        on A.txn_id = B.purchase_id) B 
                        on A.property_id=B.txn_id) C 
                        left join 
                        (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                        (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                            where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                            pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
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
                        on (A.pr_client_id=B.c_id)) D 
                        on C.property_id = D.purchase_id";

                $count_data=$this->db->query("select property_id, txn_status, created_by, modified_by, 
                                                sum(allocated_cost) as tot_allocated_cost, 
                                                sum(allocated_maintainance) as tot_allocated_maintainance, 
                                                sum(allocated_expenses) as tot_allocated_expenses from sub_property_allocation 
                                                where gp_id = '$gid' and property_id in (select distinct purchase_id from purchase_ownership_details 
                                                where pr_client_id in (select distinct owner_id from user_role_owners 
                                                    where user_id = '$session_id')) " . $cond2 . " 
                                                group by property_id, txn_status, created_by, modified_by")->result();
            } else {
                $sql = "select C.*, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
                        (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                        B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                        B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink, B.prop_status from 
                        (select property_id, txn_status, created_by, modified_by, image, 
                        sum(allocated_cost) as tot_allocated_cost, 
                        sum(allocated_maintainance) as tot_allocated_maintainance, 
                        sum(allocated_expenses) as tot_allocated_expenses from sub_property_allocation 
                        where gp_id = '$gid' " . $cond . $cond2 . " 
                        group by property_id, txn_status, created_by, modified_by, image) A 
                        left join 
                        (select A.*, B.purchase_price from 
                        (select C.*, case when C.property_status='Vacant' then case when D.property_id is null then 'Vacant' else 'Occupied' end 
                                    else C.property_status end as prop_status, D.termination_date from 
                        (select A.*, case when B.property_id is null then 'Vacant' else 'Sold' end as property_status, B.date_of_sale from 
                        (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                        from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) where A.gp_id='$gid') A 
                        left join 
                        (select property_id, max(date_of_sale) as date_of_sale from sales_txn 
                            where txn_status='Approved' and gp_id='$gid' group by property_id) B 
                        on (A.txn_id=B.property_id)) C 
                        left join 
                        (select property_id, max(termination_date) as termination_date from rent_txn 
                            where txn_status='Approved' and gp_id='$gid' and DATE(NOW()) <= DATE(termination_date) group by property_id) D 
                        on (C.txn_id=D.property_id)) A 
                        left join 
                        (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                        on A.txn_id = B.purchase_id) B 
                        on A.property_id=B.txn_id) C 
                        left join 
                        (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                        (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                            where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
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
                        on (A.pr_client_id=B.c_id)) D 
                        on C.property_id = D.purchase_id";


                $count_data=$this->db->query("select property_id, txn_status, created_by, modified_by, 
                                                sum(allocated_cost) as tot_allocated_cost, 
                                                sum(allocated_maintainance) as tot_allocated_maintainance, 
                                                sum(allocated_expenses) as tot_allocated_expenses from sub_property_allocation 
                                                where gp_id = '$gid' " . $cond2 . " 
                                                group by property_id, txn_status, created_by, modified_by")->result();
            }

            $query=$this->db->query($sql);
            $result=$query->result();
            $data['property']=$result;

            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($count_data)>0){
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

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['checkstatus'] = $status;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('allocation/allocation_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function insertImage($pid){
        $file_nm='image';
        if(isset($_FILES[$file_nm])) {
            $filePath='assets/uploads/sub_property/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $filePath='assets/uploads/sub_property/property_'.$pid.'/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $confi['upload_path']=$upload_path;
            $confi['allowed_types']='*';
            $this->load->library('upload', $confi);
            $this->upload->initialize($confi);
            $extension="";

            if(!empty($_FILES[$file_nm]['name'])) {
                if($this->upload->do_upload($file_nm)) {
                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];
                        
                    $data = array(
                        'image' => $filePath.$fileName,
                        'image_name' => $fileName
                    );
                    $this->db->where('property_id', $pid);
                    $this->db->update('sub_property_allocation',$data);

                    // echo "Uploaded <br>";

                } else {
                    // echo "Failed<br>";
                    // echo $this->upload->data();
                }
            }
        }
    }

    public function send_allocation_intimation($property_id, $txn_status){
        $gid=$this->session->userdata('groupid');

        $group_owners=$this->purchase_model->get_group_owners($gid);
        $property_owners=$this->purchase_model->get_property_owners($property_id);
        $prop_owners="";

        $table=$this->get_allocation_list_table($property_id, $txn_status);

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';
                $this->send_allocation_intimation_to_owner($table, $owner_name, $to_email);
            }

            if(strpos($prop_owners, ', ')>0){
                $prop_owners=substr($prop_owners,0,strripos($prop_owners, ', '));
            }

            // echo $prop_owners;
        }

        if(count($group_owners)>0){
            for($i=0;$i<count($group_owners);$i++){
                $owner_name="";
                if(isset($group_owners[$i]->c_name)){
                    $owner_name=$group_owners[$i]->c_name;
                }
                if(isset($group_owners[$i]->c_last_name)){
                    $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
                }
                $to_email=$group_owners[$i]->c_emailid1;

                $this->send_allocation_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
            }
        }
    }

    public function get_allocation_list_table($property_id, $txn_status) {
        $gid=$this->session->userdata('groupid');
        $query=$this->db->query("select property_id, sum(allocated_cost) as tot_allocated_cost, 
                                sum(allocated_maintainance) as tot_allocated_maintainance, 
                                sum(allocated_expenses) as tot_allocated_expenses 
                                from sub_property_allocation where property_id = '$property_id' and gp_id = '$gid' 
                                group by property_id ORDER BY property_id desc");
        $result=$query->result();
        $subproperty=$result;

        for ($i=0; $i < count($result) ; $i++) { 
            $pid=$result[$i]->property_id;
            $query=$this->db->query("select C.property_id, C.sp_name, C.txn_status, C.tot_allocated_cost, C.tot_allocated_maintainance, 
                                    C.tot_allocated_expenses, C.p_property_name, C.p_display_name, C.p_purchase_date, 
                                    D.tot_property_cost from 
                                    (select A.property_id, A.sp_name, A.txn_status, A.tot_allocated_cost, A.tot_allocated_maintainance, 
                                    A.tot_allocated_expenses, B.p_property_name, B.p_display_name, B.p_purchase_date from 
                                    (select property_id, sp_name, txn_status, allocated_cost as tot_allocated_cost, 
                                    allocated_maintainance as tot_allocated_maintainance, 
                                    allocated_expenses as tot_allocated_expenses from sub_property_allocation 
                                    where property_id = '$pid' and txn_status = '$txn_status') A 
                                    left join 
                                    (select txn_id, p_property_name, p_display_name, p_purchase_date from purchase_txn 
                                    where txn_id = '$pid') B 
                                    on A.property_id = B.txn_id) C 
                                    left join 
                                    (select purchase_id, sum(net_amount) as tot_property_cost from purchase_schedule 
                                    where purchase_id = '$pid' and sch_status = '1' group by purchase_id) D 
                                    on C.property_id = D.purchase_id");
            $res=$query->result();
            $purchase[$i]=$res;

            $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id ='$pid'");
            $res=$query->result();
            $oid=$res[0]->pr_client_id;
            

            // $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            // $re=$query->result();
            
            // $owner[$i]['id']=$oid;
            // if($re[0]->ow_type==0) {
            //     $cid=$re[0]->ow_ind_id;
            //     $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
            //     $re1=$quer->result();
            //     $owner[$i]['name']=$re1[0]->c_name;
            // } else if($re[0]->ow_type==1) {
            //     $owner[$i]['name']=$re[0]->ow_huf_name;
            // } else if($re[0]->ow_type==2) {
            //     $owner[$i]['name']=$re[0]->ow_pvtltd_comapny_name;
            // } else if($re[0]->ow_type==3) {
            //     $owner[$i]['name']=$re[0]->ow_ltd_comapny_name;
            // } else if($re[0]->ow_type==4) {
            //     $owner[$i]['name']=$re[0]->ow_llp_comapny_name;
            // } else if($re[0]->ow_type==5) {
            //     $owner[$i]['name']=$re[0]->ow_prt_comapny_name;
            // } else if($re[0]->ow_type==6) {
            //     $owner[$i]['name']=$re[0]->ow_aop_comapny_name;
            // } else if($re[0]->ow_type==7) {
            //     $owner[$i]['name']=$re[0]->ow_trs_comapny_name;
            // } else if($re[0]->ow_type==8) {
            //     $owner[$i]['name']=$re[0]->ow_proprietorship_comapny_name;
            // }

            $sql = "select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                        case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_id='$oid' and A.c_status='Approved' and A.c_gid='$gid'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result>0)){
                $owner[$i]['name']=$result[0]->owner_name;
            }
        }

        $table='';

        if(count($subproperty)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Sub Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Owner Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Purchased Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Property Cost (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Total Allocated Cost (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Total Allocated Maintenance (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Total Allocated Expenses (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="10">Status</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($purchase); $i++ ) {
                $table=$table.'<tr>
                                    <td style="padding:5px; border: 1px solid black;">'.$purchase[$i][0]->p_property_name.'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.$purchase[$i][0]->sp_name.'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.$owner[$i]['name'].'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.$purchase[$i][0]->p_purchase_date.'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.format_money($purchase[$i][0]->tot_property_cost,2).'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.format_money($purchase[$i][0]->tot_allocated_cost,2).'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.format_money($purchase[$i][0]->tot_allocated_maintainance,2).'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.format_money($purchase[$i][0]->tot_allocated_expenses,2).'</td>
                                    <td style="padding:5px; border: 1px solid black;">'.$subproperty[$i]->status.'</td>
                                </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    public function send_allocation_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Sub Property Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Sub-Property Entry has been created for '.$prop_owners.'. 
                    The Sub-Property details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Sub-Property details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    public function send_allocation_intimation_to_owner($table, $owner_name, $to_email) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Sub Property Intimation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Sub-Property Entry has been mapped to you. 
                    The Sub-Property details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Sub-Property is not yours please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

}
?>