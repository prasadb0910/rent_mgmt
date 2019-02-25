<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Owners extends CI_Controller
{
    public function __construct(){
        parent::__construct();

        $this->load->helper('common_functions');
        $this->load->model('owners_model');
        $this->load->model('document_model');
    }

    public function index(){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $gid=$this->session->userdata('groupid');

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid' ORDER BY ow_modified_date DESC");
            $result=$query->result();
            $data['owners']=$result;

            $data['ownergroup']=NULL;
            $data['ownername']=NULL;
            $data['editaction']=NULL;
            $test=NULL;

            for ($i=0; $i < count($result); $i++) { 
                if($result[$i]->ow_type==0) {
                    $data['ownergroup'][$i]='Individual';
                    $contid=$result[$i]->ow_ind_id;
                    $que=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$contid'");
                    $res=$que->result();
                    if(count($res)>0){
                        $data['ownername'][$i]=$res[0]->c_name;
                    } else {
                        $data['ownername'][$i]='';
                    }
                    $data['editaction'][$i]='view_individual';
                } else if ($result[$i]->ow_type == 1) {
                    $data['ownergroup'][$i]='HUF';
                    $data['ownername'][$i]=$result[$i]->ow_huf_name;
                    $data['editaction'][$i]='view_huf';
                } else if ($result[$i]->ow_type == 2) {
                    $data['ownergroup'][$i]='Pvt Ltd';
                    $data['ownername'][$i]=$result[$i]->ow_pvtltd_comapny_name;
                    $data['editaction'][$i]='view_pvtltd';
                } else if ($result[$i]->ow_type == 3) {
                    $data['ownergroup'][$i]='Ltd';
                    $data['ownername'][$i]=$result[$i]->ow_ltd_comapny_name;
                    $data['editaction'][$i]='view_ltd';
                } else if ($result[$i]->ow_type == 4) {
                    $data['ownergroup'][$i]='LLP';
                    $data['ownername'][$i]=$result[$i]->ow_llp_comapny_name;
                    $data['editaction'][$i]='view_llp';
                } else if ($result[$i]->ow_type == 5) {
                    $data['ownergroup'][$i]='Partnership';
                    $data['ownername'][$i]=$result[$i]->ow_prt_comapny_name;
                    $data['editaction'][$i]='view_partnership';
                } else if ($result[$i]->ow_type == 6) {
                    $data['ownergroup'][$i]='AOP';
                    $data['ownername'][$i]=$result[$i]->ow_aop_comapny_name;
                    $data['editaction'][$i]='view_aop';
                } else if ($result[$i]->ow_type == 7) {
                    $data['ownergroup'][$i]='Trust';
                    $data['ownername'][$i]=$result[$i]->ow_trs_comapny_name;
                    $data['editaction'][$i]='view_trust';
                } else if ($result[$i]->ow_type == 8) {
                    $data['ownergroup'][$i]='Proprietorship';
                    $data['ownername'][$i]=$result[$i]->ow_proprietorship_comapny_name;
                    $data['editaction'][$i]='view_proprietorship';
                } else {
                    
                }
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid' And ow_status!='Inactive'");
            $result=$query->result();
            $data['all']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='In Process' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='Approved' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE (ow_status='Pending' or ow_status='Delete') AND ow_gid = '$gid'");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='Rejected' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function deleteRecord($oid, $ow_status, $modnow, $curusr) {
        $roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_delete == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if ($rec_status=="Approved") {
                    $ow_txnremarks = $this->input->post('status_remarks');

                    if($maker_checker!='yes'){
                        $ow_status = 'Inactive';

                        $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                        ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                        $result=$query->result();
                        if (count($result)>0){
                            $oid = $result[0]->ow_id;

                            $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                             ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                             WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record Delete (sent approval)';
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                            $new_oid=$this->db->insert_id();
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record Delete (sent approval)';
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        }
                    }
                } else {
                    $this->db->where('ow_id', $oid);
                    $this->db->delete('owner_master');
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function updateRecord($oid, $data) {
        $gid=$this->session->userdata('groupid');
        $now = date('Y-m-d H:i:s');
        $roleid=$this->session->userdata('role_id');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();

                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                    $ow_create_by = $res[0]->ow_create_by;
                    $ow_create_date = $res[0]->ow_create_date;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                    $ow_create_by = $curusr;
                    $ow_create_date = $now;
                }

                if ($rec_status=="Approved" && $maker_checker=='yes') {
                    $ow_fkid = $oid;
                    $data['ow_fkid'] = $oid;
                    $data['ow_create_by'] = $ow_create_by;
                    $data['ow_create_date'] = $ow_create_date;
                    $data['ow_modified_date'] = $now;

                    $this->db->insert('owner_master',$data);
                    $oid=$this->db->insert_id();
                    $logarray['table_id']=$ow_fkid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Approved Record Updated';
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    $this->db->where('ow_id', $oid);
                    $this->db->update('owner_master',$data);
                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record Updated';
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approverecord($oid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }
            }
        }

       redirect(base_url().'index.php/Owners');
    }

#################################INDIVIDUAL###############################################3
    public function add_new_individual(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type = 'Common' AND d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['hufdocs']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_individual',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function loadselectedindividual($cid) {
        $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid';");
        $result=$query->result();
        if(count($result)>0){
            $abc = array('gender' => $result[0]->c_gender , 'designation' => $result[0]->c_designation, 'email1' => $result[0]->c_emailid1, 'email2' => $result[0]->c_emailid2, 'mobile1' => $result[0]->c_mobile1, 'mobile2' => $result[0]->c_mobile2 );
        } else {
            $abc = array();
        }
        
        echo json_encode($abc);
    }

    public function loadowners() {
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');
        // $query=$this->db->query("select ow_id, ow_type, case when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name from owner_master where ow_gid='" . $gid . "' and (ow_huf_name like '%" . $term . "%' || ow_pvtltd_comapny_name like '%" . $term . "%' || ow_ltd_comapny_name like '%" . $term . "%' || ow_llp_comapny_name like '%" . $term . "%' || ow_prt_comapny_name like '%" . $term . "%' || ow_aop_comapny_name like '%" . $term . "%' || ow_trs_comapny_name like '%" . $term . "%' || ow_proprietorship_comapny_name like '%" . $term . "%');");
        $query=$this->db->query("select ow_gid, ow_id, ow_type, owner_name from 
                                (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                    when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                    when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                    when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                    when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                    from (select ow_gid, ow_id, ow_type, 
                                        (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                        ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                        ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                where ow_status='Approved' and ow_gid='" . $gid . "') A) B where ow_gid='" . $gid . "' and (owner_name like '%" . $term . "%') 
                                order by case when owner_name = '" . $term . "' then 1 
                                when owner_name like '%" . $term . "%' then 2 end;");
        $result=$query->result();
        
        foreach($result as $row) {
            $abc[] = array('value' => $row->ow_id , 'label' => $row->owner_name);
        }
        
        echo json_encode($abc);
    }
    
    public function loadcontacts() {
        $term = "";
        $type = "";

        // $term = "t";
        // $type = "broker";

        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        if (isset($_GET['type'])){
            $type = html_escape($_GET['type']);
        }
        
        $gid=$this->session->userdata('groupid');

        if ($type=="") {
            $sql = "select * from 
                    (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                        ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                    (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                    left join 
                    (select * from contact_type_master where g_id='$gid') B 
                    on A.c_contact_type = B.id) C 
                    where contact_name like '%" . $term . "%' order by case when contact_name = '" . $term . "' then 1 
                                when contact_name like '%" . $term . "%' then 2 end;";
        } else {
            $sql = "select * from 
                    (select A.*, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                        ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                    (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                    left join 
                    (select * from contact_type_master where g_id='$gid') B 
                    on A.c_contact_type = B.id) C 
                    where c_contact_type='$type' and contact_name like '%" . $term . "%' order by case when contact_name = '" . $term . "' then 1 
                                when contact_name like '%" . $term . "%' then 2 end;";
        }
        
        $query=$this->db->query($sql);
        $result=$query->result();
        $abc=array();
        foreach($result as $row) {
            $abc[] = array('value'=>$row->c_id, 'label'=>$row->contact_name, 'gender'=>$row->c_gender, 'designation'=>$row->c_designation, 
                            'email1'=>$row->c_emailid1, 'email2'=>$row->c_emailid2, 'mobile1'=>$row->c_mobile1, 'mobile2'=>$row->c_mobile2);
        }

        echo json_encode($abc);
    }
    
    public function loadcontact_owners() {
        $term = "a";

        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');

        $sql = "select concat('c_',c_id) as c_id, contact_name from 
                (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                    ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                left join 
                (select * from contact_type_master where g_id='$gid') B 
                on A.c_contact_type = B.id) C 
                where contact_name like '%" . $term . "%'
                union all 
                select concat('o_',ow_id) as c_id, owner_name as contact_name from 
                (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                    when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                    when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                    when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                    when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                    from (select ow_gid, ow_id, ow_type, 
                        (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                            where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                        ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                        ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                where ow_status='Approved' and ow_gid='" . $gid . "') A) B 
                where ow_gid='" . $gid . "' and (owner_name like '%" . $term . "%') 
                    order by case when contact_name = '" . $term . "' then 1 
                                when contact_name like '%" . $term . "%' then 2 end;";
        
        $query=$this->db->query($sql);
        $result=$query->result();
        $abc=array();
        foreach($result as $row) {
            $abc[] = array('value' => $row->c_id, 'label' => $row->contact_name);
        }

        echo json_encode($abc);
    }
    
    public function load_non_legal_contact_owners() {
        $term = "a";

        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');

        $sql = "select concat('c_',c_id) as c_id, contact_name from 
                (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                    ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                (select * from contact_master where c_status='Approved' and c_gid='$gid' and c_type='Others') A 
                left join 
                (select * from contact_type_master where g_id='$gid') B 
                on A.c_contact_type = B.id) C 
                where contact_name like '%" . $term . "%'
                union all 
                select concat('o_',ow_id) as c_id, owner_name as contact_name from 
                (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                    when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                    when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                    when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                    when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                    from (select ow_gid, ow_id, ow_type, 
                        (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                            where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                        ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                        ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                where ow_status='Approved' and ow_gid='" . $gid . "') A) B 
                where ow_gid='" . $gid . "' and (owner_name like '%" . $term . "%') 
                    order by case when contact_name = '" . $term . "' then 1 
                                when contact_name like '%" . $term . "%' then 2 end;";
        
        $query=$this->db->query($sql);
        $result=$query->result();
        $abc=array();
        foreach($result as $row) {
            $abc[] = array('value' => $row->c_id, 'label' => $row->contact_name);
        }

        echo json_encode($abc);
    }
    
    public function saveindividualrecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $data = array(
                        'ow_type' => '0',
                        'ow_ind_id' => $this->input->post('individual_client'),
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_status' => $ow_status,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);

            $logarray['table_id']=$this->db->insert_id();
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            redirect(base_url().'index.php/Owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view_individual($oid) {
        $gid=$this->session->userdata('groupid');
		$data['ownerby']=$this->session->userdata('session_id');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {
                $data['access']=$result;
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id='$oid'");
                $result=$query->result();
                $data['indi']=$result;
                $data['ow_maker_remark']=$result[0]->ow_maker_remark;

                $cid=$result[0]->ow_ind_id;
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                $result=$query->result();
                $data['editcontact']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_individual_view', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit_individual($oid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1) {
                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result=$query->result();
                if (count($result)>0){
                    $oid = $result[0]->ow_id;
                }

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id='$oid'");
                $result=$query->result();
                $data['indi']=$result;
                $data['ow_maker_remark']=$result[0]->ow_maker_remark;

                $cid=$result[0]->ow_ind_id;
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                $result=$query->result();
                $data['editcontact']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_individual', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateindividualrecord($oid){
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $gid=$this->session->userdata('groupid');
        $curusr=$this->session->userdata('session_id');
        $roleid=$this->session->userdata('role_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            if($ow_status=='Delete') {
                $this->deleteRecord($oid, $ow_status, $modnow, $curusr);
            } else {
                $data = array(
                    'ow_type' => '0',
                    'ow_ind_id' => $this->input->post('individual_client'),
                    'ow_modified_by' => $curusr,
                    'ow_modified_date' => $now,
                    'ow_status' => $ow_status,
                    'ow_gid' => $gid,
                    'ow_maker_remark' => $this->input->post('ow_maker_remark')
                );

                $this->updateRecord($oid, $data);
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

#######################HUF RECORDS##############################################
    public function add_new_huf($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            
            // $data=$this->add_new_doc('d_cat_huf');
            $data=$this->document_model->add_new_doc('d_cat_huf');

            $sql = "select * from 
                    (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                        ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                    (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                    left join 
                    (select * from contact_type_master where g_id='$gid') B 
                    on A.c_contact_type = B.id) C 
                    order by contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['contact_type'] = $contact_type;

            load_view('owners/owner_huf',$data);
        }else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function savehufrecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            if($this->input->post('huf_doi')!='') {
                $huf_doi=FormatDate($this->input->post('huf_doi'));
            } else {
                $huf_doi=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $data = array(
                        'ow_type' => '1',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_huf_name' => $this->input->post('huf_name'),
                        'ow_huf_incorpdate' => $huf_doi,
                        'ow_huf_address' => $this->input->post('huf_address'),
                        'ow_huf_landmark' => $this->input->post('huf_addr_landmark'),
                        'ow_huf_city'=>$this->input->post('huf_addr_city'),
                        'ow_huf_state'=>$this->input->post('huf_addr_state'),
                        'ow_huf_country'=>$this->input->post('huf_addr_country'),
                        'ow_huf_pincode'=>$this->input->post('huf_addr_pincode'),
                        'ow_huf_karta_id' => $this->input->post('huf_karta_name'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$this->db->insert_id();
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $huf_kartaname=$this->input->post('family_details[]');
            $huf_ow_relation=$this->input->post('relation[]');
            for ($i=0; $i <  count($huf_kartaname); $i++) {
                if($huf_kartaname[$i]!="") {
                    $data = array(
                        'huf_ow_id' => $oid,
                        'huf_ow_family_detail' => $huf_kartaname[$i],
                        'huf_ow_relation' => $huf_ow_relation[$i],
                        );
                    $this->db->insert('huf_family_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_huf');
            $this->document_model->insert_doc($oid, 'Owner_HUF');

            redirect(base_url().'index.php/Owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view_huf($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {

                // $data=$this->edit_view_doc($oid,'d_cat_huf');
                $data=$this->document_model->view_doc('d_cat_huf', $oid, 'Owner_HUF');

                $data['access']=$result;

                $data['ownerby']=$this->session->userdata('session_id');

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_huf_name, A.ow_reg_no, A.ow_huf_incorpdate,concat_ws(' ', A.ow_huf_address,A.ow_huf_landmark,A.ow_huf_city,A.ow_huf_state,A.ow_huf_country,A.ow_huf_pincode) as address, A.ow_huf_karta_id, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name,A.ow_status,A.ow_txnremarks,A.ow_modified_by,A.ow_create_by,A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_huf_karta_id = B.c_id and A.ow_id = '$oid'");
                // $result=$query->result();
                // if(count($result)>0) $data['huf_record']=$result;

                // $query=$this->db->query("SELECT A.huf_ow_family_detail, A.huf_ow_relation, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM huf_family_details A, contact_master B WHERE A.huf_ow_family_detail = B.c_id and A.huf_ow_id = '$oid'");
                // $result=$query->result();
                // if(count($result)>0) $data['huf_family']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as owner_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_huf_karta_id=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['huf_record']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as owner_name from 
                                        (select * from huf_family_details where huf_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.huf_ow_family_detail=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['huf_family']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_huf_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit_huf($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_huf');
                $data=$this->document_model->edit_view_doc('d_cat_huf', $oid, 'Owner_HUF');

                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_huf_name, A.ow_reg_no, A.ow_huf_incorpdate, A.ow_huf_address,A.ow_huf_landmark,A.ow_huf_city,A.ow_huf_state,A.ow_huf_pincode,A.ow_huf_country, A.ow_huf_karta_id, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_huf_karta_id = B.c_id and A.ow_id = '$oid'");
                // $result=$query->result();
                // if(count($result)>0) $data['huf_record']=$result;

                // $query=$this->db->query("SELECT A.huf_ow_family_detail, A.huf_ow_relation, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM huf_family_details A, contact_master B WHERE A.huf_ow_family_detail = B.c_id and A.huf_ow_id = '$oid'");
                // $result=$query->result();
                // if(count($result)>0) $data['huf_family']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as owner_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_huf_karta_id=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['huf_record']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as owner_name from 
                                        (select * from huf_family_details where huf_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.huf_ow_family_detail=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['huf_family']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_huf',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloaddocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM huf_document_details WHERE huf_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');

    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->huf_document;
    //     if(!is_dir('./downloads/huf/'.$oid)) {
    //         mkdir('./downloads/huf/'.$oid, 0777, TRUE);
    //     }
    //     $destination='./downloads/huf/'.$oid.'/'.$result[0]->huf_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function updatehufrecord($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');

                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");
                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into huf_family_details (huf_ow_id, huf_ow_family_detail, 
                                                 huf_ow_relation) 
                                                 Select '$new_oid', huf_ow_family_detail, huf_ow_relation 
                                                 FROM huf_family_details WHERE huf_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_HUF'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('huf_ow_id', $oid);
                        $this->db->delete('huf_family_details');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_HUF');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    if($this->input->post('huf_doi')!='') {
                        $huf_doi=FormatDate($this->input->post('huf_doi'));
                    } else {
                        $huf_doi=NULL;
                    }

                    $data = array(
                        'ow_type' => '1',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_huf_name' => $this->input->post('huf_name'),
                        'ow_huf_incorpdate' => $huf_doi,
                        'ow_huf_address' => $this->input->post('huf_address'),
                        'ow_huf_landmark' => $this->input->post('huf_addr_landmark'),
                        'ow_huf_city'=>$this->input->post('huf_addr_city'),
                        'ow_huf_state'=>$this->input->post('huf_addr_state'),
                        'ow_huf_country'=>$this->input->post('huf_addr_country'),
                        'ow_huf_pincode'=>$this->input->post('huf_addr_pincode'),
                        'ow_huf_karta_id' => $this->input->post('huf_karta_name'),
                        'ow_gid' => $ow_gid,
                        'ow_status' => $ow_status,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();
                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Inserted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('huf_ow_id', $oid);
                        $this->db->delete('huf_family_details');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $huf_kartaname=$this->input->post('family_details[]');
                        $huf_ow_relation=$this->input->post('relation[]');

                        for ($i=0; $i <  count($huf_kartaname); $i++) {
                            if($huf_kartaname[$i]!="") {
                                $data = array(
                                    'huf_ow_id' => $oid,
                                    'huf_ow_family_detail' => $huf_kartaname[$i],
                                    'huf_ow_relation' => $huf_ow_relation[$i],
                                    );
                                $this->db->insert('huf_family_details', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_huf',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_HUF');

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            }
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approvehuf($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('huf_ow_id', $ow_fkid);
                        $this->db->delete('huf_family_details');
                        $this->db->query("update huf_family_details set huf_ow_id = '$ow_fkid' WHERE huf_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_HUF');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_HUF'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

##############################PRIVATE LTD####################################
    public function add_new_pvtltd($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            
            // $data=$this->add_new_doc('d_cat_privateltd');
            $data=$this->document_model->add_new_doc('d_cat_privateltd');

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['pvtdocs']=NULL;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_pvtltd',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function savepvtltd(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
        
            $gid=$this->session->userdata('groupid');
            $now=date('Y-m-d H:i:s');
            if($this->input->post('date_of_incorporation')!='') {
                $date_of_incorporation=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $date_of_incorporation=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }
            
            $data = array(
                        'ow_type' => '2',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_pvtltd_comapny_name' => $this->input->post('company_name'),
                        'ow_pvtltd_incopdate' => $date_of_incorporation,
                        'ow_pvtltd_address' => $this->input->post('pvtltd_address'),
                        'ow_pvtltd_landmark' => $this->input->post('pvtltd_addr_landmark'),
                        'ow_pvtltd_city'=>$this->input->post('pvtltd_addr_city'),
                        'ow_pvtltd_state'=>$this->input->post('pvtltd_addr_state'),
                        'ow_pvtltd_country'=>$this->input->post('pvtltd_addr_country'),
                        'ow_pvtltd_pincode'=>$this->input->post('pvtltd_addr_pincode'),
                        'ow_pvtltd_branch' => $this->input->post('branch_address'),
                        'ow_pvtltd_tel' => $this->input->post('telephone_number'),
                        'ow_pvtltd_mob' => $this->input->post('mob_number'),
                        'ow_pvtltd_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();
            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);


            $pvt_dirname=$this->input->post('director_name[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'dir_ow_id' => $oid,
                        'dir_contactid' => $pvt_dirname[$i],
                        );
                    $this->db->insert('pvtltd_director_details', $data);
                }
            }

            $pvt_shrname=$this->input->post('shareholder_name[]');
            $pvt_shrprcnt=$this->input->post('shareholder_percent[]');
            $pvt_noofshr=$this->input->post('no_of_shares[]');

            for ($j=0; $j <  count($pvt_shrname); $j++) { 
                if($pvt_shrname[$j]!="") {
                    $data = array(
                        'shr_ow_id' => $oid,
                        'shr_contactid' => $pvt_shrname[$j],
                        'shr_percent' => $pvt_shrprcnt[$j],
                        'no_of_shares' => $pvt_noofshr[$j]
                        );
                    $this->db->insert('pvtltd_shareholder_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_privateltd');
            $this->document_model->insert_doc($oid, 'Owner_PrivateLtd');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');

            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'ath_ow_id' => $oid,
                        'ath_contactid' => $authname[$m],
                        'ath_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('pvtltd_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/Owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloadpvtdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM pvtltd_document_details WHERE pvt_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');

    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->pvt_document;
    //     if(!is_dir('./downloads/pvt/'.$oid.'/')) {
    //         mkdir('./downloads/pvt/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/pvt/'.$oid.'/'.$result[0]->pvt_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_pvtltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_privateltd');
                $data=$this->document_model->edit_view_doc('d_cat_privateltd', $oid, 'Owner_PrivateLtd');

                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_pvtltd_comapny_name, A.ow_reg_no, A.ow_pvtltd_incopdate, A.ow_pvtltd_address,A.ow_pvtltd_landmark,A.ow_pvtltd_city,A.ow_pvtltd_country,A.ow_pvtltd_pincode,A.ow_pvtltd_state, A.ow_pvtltd_branch, A.ow_pvtltd_tel, A.ow_pvtltd_mob, A.ow_pvtltd_contact, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_pvtltd_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("SELECT A.dir_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM pvtltd_director_details A, contact_master B WHERE dir_ow_id = '$oid' and A.dir_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_direct']=$result;

                // $query=$this->db->query("SELECT A.shr_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.shr_percent, A.no_of_shares FROM pvtltd_shareholder_details A, contact_master B WHERE shr_ow_id = '$oid' and A.shr_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_share']=$result;

                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM pvtltd_authorizedsignatory A, contact_master B WHERE ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_signatory']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_pvtltd_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("select A.*, 
                //                         case when B.ow_type = '0' then 
                //                                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                //                                     from contact_master where c_id = B.ow_ind_id) 
                //                             when B.ow_type = '1' then B.ow_huf_name 
                //                             when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //                             when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //                             when B.ow_type = '4' then B.ow_llp_comapny_name 
                //                             when B.ow_type = '5' then B.ow_prt_comapny_name 
                //                             when B.ow_type = '6' then B.ow_aop_comapny_name 
                //                             when B.ow_type = '7' then B.ow_trs_comapny_name 
                //                             else B.ow_proprietorship_comapny_name end as c_name from 
                //                         (select * from pvtltd_director_details where dir_ow_id='$oid') A 
                //                         left join 
                //                         (select * from owner_master) B 
                //                         on (A.dir_contactid=B.ow_id)");
                $query=$this->db->query("select A.*, B.c_name from 
                                        (select * from pvtltd_director_details where dir_ow_id='$oid') A 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') B 
                                        on (A.dir_contactid=B.c_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_direct']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from pvtltd_shareholder_details where shr_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.shr_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_share']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from pvtltd_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_signatory']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_pvtltd',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_pvtltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
		
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {

                // $data=$this->edit_view_doc($oid,'d_cat_privateltd');
                $data=$this->document_model->view_doc('d_cat_privateltd', $oid, 'Owner_PrivateLtd');

                $data['access']=$result;

                $data['ownerby']=$this->session->userdata('session_id');

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_pvtltd_comapny_name, A.ow_reg_no, A.ow_pvtltd_incopdate, concat_ws(' ',A.ow_pvtltd_address,A.ow_pvtltd_landmark,A.ow_pvtltd_city,A.ow_pvtltd_state,A.ow_pvtltd_country,A.ow_pvtltd_pincode) as address, A.ow_pvtltd_branch, A.ow_pvtltd_tel, A.ow_pvtltd_mob, A.ow_pvtltd_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_pvtltd_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("SELECT A.dir_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM pvtltd_director_details A, contact_master B WHERE dir_ow_id = '$oid' and A.dir_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_direct']=$result;

                // $query=$this->db->query("SELECT A.shr_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.shr_percent, A.no_of_shares FROM pvtltd_shareholder_details A, contact_master B WHERE shr_ow_id = '$oid' and A.shr_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_share']=$result;

                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM pvtltd_authorizedsignatory A, contact_master B WHERE ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_signatory']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_pvtltd_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("select A.*, 
                //                         case when B.ow_type = '0' then 
                //                                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                //                                     from contact_master where c_id = B.ow_ind_id) 
                //                             when B.ow_type = '1' then B.ow_huf_name 
                //                             when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //                             when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //                             when B.ow_type = '4' then B.ow_llp_comapny_name 
                //                             when B.ow_type = '5' then B.ow_prt_comapny_name 
                //                             when B.ow_type = '6' then B.ow_aop_comapny_name 
                //                             when B.ow_type = '7' then B.ow_trs_comapny_name 
                //                             else B.ow_proprietorship_comapny_name end as c_name from 
                //                         (select * from pvtltd_director_details where dir_ow_id='$oid') A 
                //                         left join 
                //                         (select * from owner_master) B 
                //                         on (A.dir_contactid=B.ow_id)");
                $query=$this->db->query("select A.*, B.c_name from 
                                        (select * from pvtltd_director_details where dir_ow_id='$oid') A 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') B 
                                        on (A.dir_contactid=B.c_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_direct']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from pvtltd_shareholder_details where shr_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.shr_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_share']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from pvtltd_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_signatory']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_pvtltd_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updatepvtltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
                $ow_modified_by = $curusr;
                $ow_modified_date = $now;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
                $ow_modified_by = $curusr;
                $ow_modified_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");
                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into pvtltd_shareholder_details (shr_ow_id, shr_contactid, shr_percent, 
                                                 no_of_shares) 
                                                 Select '$new_oid', shr_contactid, shr_percent, no_of_shares 
                                                 FROM pvtltd_shareholder_details WHERE shr_ow_id = '$oid'");

                                $this->db->query("Insert into pvtltd_director_details (dir_ow_id, dir_contactid) 
                                                 Select '$new_oid', dir_contactid 
                                                 FROM pvtltd_director_details WHERE dir_ow_id = '$oid'");

                                $this->db->query("Insert into pvtltd_authorizedsignatory (ath_ow_id, ath_contactid, ath_purpose) 
                                                 Select '$new_oid', ath_contactid, ath_purpose 
                                                 FROM pvtltd_authorizedsignatory WHERE ath_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_PrivateLtd'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('shr_ow_id', $oid);
                        $this->db->delete('pvtltd_shareholder_details');

                        $this->db->where('dir_ow_id', $oid);
                        $this->db->delete('pvtltd_director_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('pvtltd_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_PrivateLtd');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $now=date('Y-m-d H:i:s');
                    if($this->input->post('date_of_incorporation')!='') {
                        $date_of_incorporation=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $date_of_incorporation=NULL;
                    }

                    $data = array(
                            'ow_type' => '2',
                            'ow_reg_no' => $this->input->post('ow_reg_no'),
                            'ow_pvtltd_comapny_name' => $this->input->post('company_name'),
                            'ow_pvtltd_incopdate' => $date_of_incorporation,
                            'ow_pvtltd_address' => $this->input->post('pvtltd_address'),
                            'ow_pvtltd_landmark' => $this->input->post('pvtltd_addr_landmark'),
                            'ow_pvtltd_city'=>$this->input->post('pvtltd_addr_city'),
                            'ow_pvtltd_state'=>$this->input->post('pvtltd_addr_state'),
                            'ow_pvtltd_country'=>$this->input->post('pvtltd_addr_country'),
                            'ow_pvtltd_pincode'=>$this->input->post('pvtltd_addr_pincode'),
                            'ow_pvtltd_branch' => $this->input->post('branch_address'),
                            'ow_pvtltd_tel' => $this->input->post('telephone_number'),
                            'ow_pvtltd_mob' => $this->input->post('mob_number'),
                            'ow_pvtltd_contact' => $this->input->post('contact_person'),
                            'ow_gid' => $ow_gid,
                            'ow_status' => $ow_status,
                            'ow_maker_remark' => $this->input->post('ow_maker_remark')
                        );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('shr_ow_id', $oid);
                        $this->db->delete('pvtltd_shareholder_details');

                        $this->db->where('dir_ow_id', $oid);
                        $this->db->delete('pvtltd_director_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('pvtltd_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $pvt_dirname=$this->input->post('director_name[]');
                        for ($i=0; $i <  count($pvt_dirname); $i++) { 
                            if($pvt_dirname[$i]!="") {
                                $data = array(
                                    'dir_ow_id' => $oid,
                                    'dir_contactid' => $pvt_dirname[$i],
                                    );
                                $this->db->insert('pvtltd_director_details', $data);
                            }
                        }

                        $pvt_shrname=$this->input->post('shareholder_name[]');
                        $pvt_shrprcnt=$this->input->post('shareholder_percent[]');
                        $pvt_noofshr=$this->input->post('no_of_shares[]');
                        for ($j=0; $j <  count($pvt_shrname); $j++) { 
                            if($pvt_shrname[$j]!="") {
                                $data = array(
                                    'shr_ow_id' => $oid,
                                    'shr_contactid' => $pvt_shrname[$j],
                                    'shr_percent' => $pvt_shrprcnt[$j],
                                    'no_of_shares' => $pvt_noofshr[$j]
                                    );
                                $this->db->insert('pvtltd_shareholder_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');
                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'ath_ow_id' => $oid,
                                    'ath_contactid' => $authname[$m],
                                    'ath_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('pvtltd_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_privateltd',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_PrivateLtd');

                    redirect(base_url().'index.php/owners');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approvepvt($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact  
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('shr_ow_id', $ow_fkid);
                        $this->db->delete('pvtltd_shareholder_details');
                        $this->db->query("update pvtltd_shareholder_details set shr_ow_id = '$ow_fkid' WHERE shr_ow_id = '$oid'");

                        $this->db->where('dir_ow_id', $ow_fkid);
                        $this->db->delete('pvtltd_director_details');
                        $this->db->query("update pvtltd_director_details set dir_ow_id = '$ow_fkid' WHERE dir_ow_id = '$oid'");

                        $this->db->where('ath_ow_id', $ow_fkid);
                        $this->db->delete('pvtltd_authorizedsignatory');
                        $this->db->query("update pvtltd_authorizedsignatory set ath_ow_id = '$ow_fkid' WHERE ath_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_PrivateLtd');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_PrivateLtd'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
##############################LTD############################################
    public function add_new_ltd($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            
            // $data=$this->add_new_doc('d_cat_limited');
            $data=$this->document_model->add_new_doc('d_cat_limited');

            $gid=$this->session->userdata('groupid');
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['pvtdocs']=NULL;
            $data['dir_cnt']=0;
            $data['shr_hld_cnt']=0;
            $data['aut_sig_cnt']=0;

            $data['maker_checker'] = $this->session->userdata('maker_checker');
            
            load_view('owners/owner_ltd',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saveltd(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
        
            $gid=$this->session->userdata('groupid');
            $now=date('Y-m-d H:i:s');
            
            if($this->input->post('date_of_incorporation')!='') {
                $date_of_incorporation=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $date_of_incorporation=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }
            
            $data = array(
                        'ow_type' => '3',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_ltd_comapny_name' => $this->input->post('company_name'),
                        'ow_ltd_incopdate' => $date_of_incorporation,
                        'ow_ltd_address' => $this->input->post('registered_address'),                
                        'ow_ltd_landmark' => $this->input->post('ltd_addr_landmark'),
                        'ow_ltd_city'=>$this->input->post('ltd_addr_city'),
                        'ow_ltd_state'=>$this->input->post('ltd_addr_state'),
                        'ow_ltd_country'=>$this->input->post('ltd_addr_country'),
                        'ow_ltd_pincode'=>$this->input->post('ltd_addr_pincode'),
                        'ow_ltd_branch' => $this->input->post('branch_address'),
                        'ow_ltd_tel' => $this->input->post('telephone_number'),
                        'ow_ltd_mob' => $this->input->post('mob_number'),
                        'ow_ltd_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);


            $pvt_dirname=$this->input->post('director_name[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'dir_ow_id' => $oid,
                        'dir_contactid' => $pvt_dirname[$i],
                        );
                    $this->db->insert('ltd_director_details', $data);
                }
            }

            $pvt_shrname=$this->input->post('shareholder_name[]');
            $pvt_shrprcnt=$this->input->post('shareholder_percent[]');
            $pvt_noofshr=$this->input->post('no_of_shares[]');

            for ($j=0; $j <  count($pvt_shrname); $j++) { 
                if($pvt_shrname[$j]!="") {
                    $data = array(
                        'shr_ow_id' => $oid,
                        'shr_contactid' => $pvt_shrname[$j],
                        'shr_percent' => $pvt_shrprcnt[$j],
                        'no_of_shares' => $pvt_noofshr[$j]
                        );
                    $this->db->insert('ltd_shareholder_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_limited');
            $this->document_model->insert_doc($oid, 'Owner_Limited');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');

            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'ath_ow_id' => $oid,
                        'ath_contactid' => $authname[$m],
                        'ath_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('ltd_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/Owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    //  public function downloadltddocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM ltd_document_details WHERE ltd_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');

    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->ltd_document;
    //     if(!is_dir('./downloads/ltd/'.$oid.'/')) {
    //         mkdir('./downloads/ltd/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/ltd/'.$oid.'/'.$result[0]->ltd_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_ltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_limited');
                $data=$this->document_model->edit_view_doc('d_cat_limited', $oid, 'Owner_Limited');

                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_ltd_comapny_name, A.ow_reg_no, A.ow_ltd_incopdate, A.ow_ltd_address, A.ow_ltd_country, A.ow_ltd_pincode, A.ow_ltd_state, A.ow_ltd_city, A.ow_ltd_landmark, A.ow_ltd_branch, A.ow_ltd_tel, A.ow_ltd_mob, A.ow_ltd_contact, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_ltd_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("SELECT A.dir_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM ltd_director_details A, contact_master B WHERE A.dir_ow_id = '$oid' and A.dir_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_direct']=$result;

                // $query=$this->db->query("SELECT A.shr_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.shr_percent, A.no_of_shares FROM ltd_shareholder_details A, contact_master B WHERE A.shr_ow_id = '$oid' and A.shr_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_share']=$result;

                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM ltd_authorizedsignatory A, contact_master B WHERE A.ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_signatory']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_ltd_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("select A.*, 
                //                         case when B.ow_type = '0' then 
                //                                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                //                                     from contact_master where c_id = B.ow_ind_id) 
                //                             when B.ow_type = '1' then B.ow_huf_name 
                //                             when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //                             when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //                             when B.ow_type = '4' then B.ow_llp_comapny_name 
                //                             when B.ow_type = '5' then B.ow_prt_comapny_name 
                //                             when B.ow_type = '6' then B.ow_aop_comapny_name 
                //                             when B.ow_type = '7' then B.ow_trs_comapny_name 
                //                             else B.ow_proprietorship_comapny_name end as c_name from 
                //                         (select * from ltd_director_details where dir_ow_id='$oid') A 
                //                         left join 
                //                         (select * from owner_master) B 
                //                         on (A.dir_contactid=B.ow_id)");
                $query=$this->db->query("select A.*, B.c_name from 
                                        (select * from ltd_director_details where dir_ow_id='$oid') A 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') B 
                                        on (A.dir_contactid=B.c_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_direct']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from ltd_shareholder_details where shr_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.shr_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_share']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from ltd_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_signatory']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_ltd',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_ltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {
                // $data=$this->edit_view_doc($oid,'d_cat_limited');
                $data=$this->document_model->view_doc('d_cat_limited', $oid, 'Owner_Limited');

                $data['access']=$result;

                $data['ownerby']=$this->session->userdata('session_id');
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_ltd_comapny_name, A.ow_reg_no, A.ow_ltd_incopdate, concat_ws(' ',A.ow_ltd_address,A.ow_ltd_landmark,A.ow_ltd_city,A.ow_ltd_state,A.ow_ltd_country,A.ow_ltd_pincode)as address, A.ow_ltd_branch, A.ow_ltd_tel, A.ow_ltd_mob, A.ow_ltd_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_modified_by, A.ow_create_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_ltd_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("SELECT A.dir_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM ltd_director_details A, contact_master B WHERE A.dir_ow_id = '$oid' and A.dir_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_direct']=$result;

                // $query=$this->db->query("SELECT A.shr_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.shr_percent, A.no_of_shares FROM ltd_shareholder_details A, contact_master B WHERE A.shr_ow_id = '$oid' and A.shr_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_share']=$result;

                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM ltd_authorizedsignatory A, contact_master B WHERE A.ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['pvt_signatory']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_ltd_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_details']=$result;

                // $query=$this->db->query("select A.*, 
                //                         case when B.ow_type = '0' then 
                //                                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                //                                     from contact_master where c_id = B.ow_ind_id) 
                //                             when B.ow_type = '1' then B.ow_huf_name 
                //                             when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //                             when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //                             when B.ow_type = '4' then B.ow_llp_comapny_name 
                //                             when B.ow_type = '5' then B.ow_prt_comapny_name 
                //                             when B.ow_type = '6' then B.ow_aop_comapny_name 
                //                             when B.ow_type = '7' then B.ow_trs_comapny_name 
                //                             else B.ow_proprietorship_comapny_name end as c_name from 
                //                         (select * from ltd_director_details where dir_ow_id='$oid') A 
                //                         left join 
                //                         (select * from owner_master) B 
                //                         on (A.dir_contactid=B.ow_id)");
                $query=$this->db->query("select A.*, B.c_name from 
                                        (select * from ltd_director_details where dir_ow_id='$oid') A 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') B 
                                        on (A.dir_contactid=B.c_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_direct']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from ltd_shareholder_details where shr_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.shr_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_share']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from ltd_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['pvt_signatory']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_ltd_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateltd($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");
                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into ltd_shareholder_details (shr_ow_id, shr_contactid, shr_percent, 
                                                 no_of_shares) 
                                                 Select '$new_oid', shr_contactid, shr_percent, no_of_shares 
                                                 FROM ltd_shareholder_details WHERE shr_ow_id = '$oid'");

                                $this->db->query("Insert into ltd_director_details (dir_ow_id, dir_contactid) 
                                                 Select '$new_oid', dir_contactid 
                                                 FROM ltd_director_details WHERE dir_ow_id = '$oid'");

                                $this->db->query("Insert into ltd_authorizedsignatory (ath_ow_id, ath_contactid, ath_purpose) 
                                                 Select '$new_oid', ath_contactid, ath_purpose 
                                                 FROM ltd_authorizedsignatory WHERE ath_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Limited'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('shr_ow_id', $oid);
                        $this->db->delete('ltd_shareholder_details');

                        $this->db->where('dir_ow_id', $oid);
                        $this->db->delete('ltd_director_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('ltd_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_Limited');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
    				$now=date('Y-m-d');
                    if($this->input->post('date_of_incorporation')!='') {
                        $date_of_incorporation=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $date_of_incorporation=NULL;
                    }

                    $data = array(
                            'ow_type' => '3',
                            'ow_reg_no' => $this->input->post('ow_reg_no'),
                            'ow_ltd_comapny_name' => $this->input->post('company_name'),
                            'ow_ltd_incopdate' => $date_of_incorporation,
                            'ow_ltd_address' => $this->input->post('registered_address'),                    
                            'ow_ltd_landmark' => $this->input->post('ltd_addr_landmark'),
                            'ow_ltd_city'=>$this->input->post('ltd_addr_city'),
                            'ow_ltd_state'=>$this->input->post('ltd_addr_state'),
                            'ow_ltd_country'=>$this->input->post('ltd_addr_country'),
                            'ow_ltd_pincode'=>$this->input->post('ltd_addr_pincode'),
                            'ow_ltd_branch' => $this->input->post('branch_address'),
                            'ow_ltd_tel' => $this->input->post('telephone_number'),
                            'ow_ltd_mob' => $this->input->post('mob_number'),
                            'ow_ltd_contact' => $this->input->post('contact_person'),
                            'ow_gid' => $ow_gid,
                            'ow_status' => $ow_status,
                            'ow_maker_remark' => $this->input->post('ow_maker_remark')
                        );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('shr_ow_id', $oid);
                        $this->db->delete('ltd_shareholder_details');

                        $this->db->where('dir_ow_id', $oid);
                        $this->db->delete('ltd_director_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('ltd_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $pvt_dirname=$this->input->post('director_name[]');
                        for ($i=0; $i <  count($pvt_dirname); $i++) { 
                            if($pvt_dirname[$i]!="") {
                                $data = array(
                                    'dir_ow_id' => $oid,
                                    'dir_contactid' => $pvt_dirname[$i],
                                    );
                                $this->db->insert('ltd_director_details', $data);
                            }
                        }

                        $pvt_shrname=$this->input->post('shareholder_name[]');
                        $pvt_shrprcnt=$this->input->post('shareholder_percent[]');
                        $pvt_noofshr=$this->input->post('no_of_shares[]');
                        for ($j=0; $j <  count($pvt_shrname); $j++) { 
                            if($pvt_shrname[$j]!="") {
                                $data = array(
                                    'shr_ow_id' => $oid,
                                    'shr_contactid' => $pvt_shrname[$j],
                                    'shr_percent' => $pvt_shrprcnt[$j],
                                    'no_of_shares' => $pvt_noofshr[$j]
                                    );
                                $this->db->insert('ltd_shareholder_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');
                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'ath_ow_id' => $oid,
                                    'ath_contactid' => $authname[$m],
                                    'ath_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('ltd_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_limited',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_Limited');

                    redirect(base_url().'index.php/owners');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveltd($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('shr_ow_id', $ow_fkid);
                        $this->db->delete('ltd_shareholder_details');
                        $this->db->query("update ltd_shareholder_details set shr_ow_id = '$ow_fkid' WHERE shr_ow_id = '$oid'");

                        $this->db->where('dir_ow_id', $ow_fkid);
                        $this->db->delete('ltd_director_details');
                        $this->db->query("update ltd_director_details set dir_ow_id = '$ow_fkid' WHERE dir_ow_id = '$oid'");

                        $this->db->where('ath_ow_id', $ow_fkid);
                        $this->db->delete('ltd_authorizedsignatory');
                        $this->db->query("update ltd_authorizedsignatory set ath_ow_id = '$ow_fkid' WHERE ath_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_Limited');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Limited'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
##############################LLP###########################################
    public function add_new_llp($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
        
            // $data=$this->add_new_doc('d_cat_lpp');
            $data=$this->document_model->add_new_doc('d_cat_lpp');
            
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_llp',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function savellp(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
			if($this->input->post('date_of_incorporation')!='') {
                $llp_doi=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $llp_doi=NULL;
            }
			if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $data = array(
                        'ow_type' => '4',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_llp_comapny_name' => $this->input->post('organisation_name'),
                        'ow_llp_incopdate' => $llp_doi,
                        'ow_llp_address' => $this->input->post('registered_address'),                
                        'ow_llp_landmark' => $this->input->post('llp_addr_landmark'),
                        'ow_llp_city'=>$this->input->post('llp_addr_city'),
                        'ow_llp_state'=>$this->input->post('llp_addr_state'),
                        'ow_llp_country'=>$this->input->post('llp_addr_country'),
                        'ow_llp_pincode'=>$this->input->post('llp_addr_pincode'),
                        'ow_llp_branch' => $this->input->post('branch_address'),
                        'ow_llp_tel' => $this->input->post('telephone_number'),
                        'ow_llp_mob' => $this->input->post('mob_number'),
                        'ow_llp_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);


            $pvt_dirname=$this->input->post('partner_name[]');
            $pvt_percent=$this->input->post('partner_percent[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'llp_ow_id' => $oid,
                        'llp_partnerid' => $pvt_dirname[$i],
                        'llp_percent' => $pvt_percent[$i],
                        );
                    $this->db->insert('llp_partnership_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_lpp');
            $this->document_model->insert_doc($oid, 'Owner_LLP');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');
            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'llp_ow_id' => $oid,
                        'llp_contactid' => $authname[$m],
                        'llp_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('llp_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    //  public function downloadllpdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM llp_document_details WHERE llp_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->llp_document;
    //     if(!is_dir('./downloads/llp/'.$oid.'/')) {
    //         mkdir('./downloads/llp/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/llp/'.$oid.'/'.$result[0]->llp_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_llp($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_lpp');
                $data=$this->document_model->edit_view_doc('d_cat_lpp', $oid, 'Owner_LLP');

                $data['access']=$result;
				
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_llp_comapny_name, A.ow_reg_no, A.ow_llp_incopdate, A.ow_llp_address,A.ow_llp_landmark,A.ow_llp_city,A.ow_llp_state,A.ow_llp_pincode,A.ow_llp_country, A.ow_llp_branch, A.ow_llp_tel,A.ow_llp_mob, A.ow_llp_contact, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_llp_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                //  $query=$this->db->query("SELECT A.llp_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.llp_percent FROM llp_partnership_details A, contact_master B WHERE A.llp_ow_id='$oid' and A.llp_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                // $query=$this->db->query("SELECT A.llp_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.llp_purpose FROM llp_authorizedsignatory A, contact_master B WHERE A.llp_ow_id='$oid' and A.llp_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_llp_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from llp_partnership_details where llp_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.llp_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from llp_authorizedsignatory where llp_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.llp_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_llp',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_llp($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {
                
                // $data=$this->edit_view_doc($oid,'d_cat_lpp');
                $data=$this->document_model->view_doc('d_cat_lpp', $oid, 'Owner_LLP');

                $data['ownerby']=$this->session->userdata('session_id');
                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_llp_comapny_name, A.ow_reg_no, A.ow_llp_incopdate, concat_ws(' ',A.ow_llp_address,A.ow_llp_landmark,A.ow_llp_city,A.ow_llp_state,A.ow_llp_country,A.ow_llp_pincode) as address, A.ow_llp_branch, A.ow_llp_tel, A.ow_llp_mob, A.ow_llp_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_llp_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                // $query=$this->db->query("SELECT A.llp_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.llp_percent FROM llp_partnership_details A, contact_master B WHERE A.llp_ow_id='$oid' and A.llp_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                
                // $query=$this->db->query("SELECT A.llp_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.llp_purpose FROM llp_authorizedsignatory A, contact_master B WHERE A.llp_ow_id='$oid' and A.llp_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_llp_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from llp_partnership_details where llp_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.llp_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from llp_authorizedsignatory where llp_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.llp_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_llp_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updatellp($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into llp_partnership_details (llp_ow_id, llp_partnerid, llp_percent) 
                                                 Select '$new_oid', llp_partnerid, llp_percent 
                                                 FROM llp_partnership_details WHERE llp_ow_id = '$oid'");

                                $this->db->query("Insert into llp_authorizedsignatory (llp_ow_id, llp_contactid, llp_purpose) 
                                                 Select '$new_oid', llp_contactid, llp_purpose 
                                                 FROM llp_authorizedsignatory WHERE llp_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name) 
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_LLP'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('llp_ow_id', $oid);
                        $this->db->delete('llp_partnership_details');

                        $this->db->where('llp_ow_id', $oid);
                        $this->db->delete('llp_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_LLP');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if($this->input->post('date_of_incorporation')!='') {
                        $llp_doi=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $llp_doi=NULL;
                    }

                    $data = array(
                            'ow_type' => '4',
                            'ow_reg_no' => $this->input->post('ow_reg_no'),
                            'ow_llp_comapny_name' => $this->input->post('organisation_name'),
                            'ow_llp_incopdate' => $llp_doi,
                            'ow_llp_address' => $this->input->post('registered_address'),                    
                            'ow_llp_landmark' => $this->input->post('llp_addr_landmark'),
                            'ow_llp_city'=>$this->input->post('llp_addr_city'),
                            'ow_llp_state'=>$this->input->post('llp_addr_state'),
                            'ow_llp_country'=>$this->input->post('llp_addr_country'),
                            'ow_llp_pincode'=>$this->input->post('llp_addr_pincode'),
                            'ow_llp_branch' => $this->input->post('branch_address'),
                            'ow_llp_tel' => $this->input->post('telephone_number'),
                            'ow_llp_mob' => $this->input->post('mob_number'),
                            'ow_llp_contact' => $this->input->post('contact_person'),
                            'ow_gid' => $ow_gid,
                            'ow_status' => $ow_status,
                            'ow_maker_remark' => $this->input->post('ow_maker_remark')
                        );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('llp_ow_id', $oid);
                        $this->db->delete('llp_partnership_details');

                        $this->db->where('llp_ow_id', $oid);
                        $this->db->delete('llp_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $prtname=$this->input->post('partner_name[]');
                        $prtpercent=$this->input->post('partner_percent[]');

                        for ($i=0; $i <  count($prtname); $i++) { 
                            if($prtname[$i]!="") {
                                $data = array(
                                    'llp_ow_id' => $oid,
                                    'llp_partnerid' => $prtname[$i],
                                    'llp_percent' => $prtpercent[$i],
                                    );
                                $this->db->insert('llp_partnership_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');

                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'llp_ow_id' => $oid,
                                    'llp_contactid' => $authname[$m],
                                    'llp_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('llp_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_lpp',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_LLP');

                    redirect(base_url().'index.php/owners');
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approvellp($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('llp_ow_id', $ow_fkid);
                        $this->db->delete('llp_partnership_details');
                        $this->db->query("update llp_partnership_details set llp_ow_id = '$ow_fkid' WHERE llp_ow_id = '$oid'");

                        $this->db->where('llp_ow_id', $ow_fkid);
                        $this->db->delete('llp_authorizedsignatory');
                        $this->db->query("update llp_authorizedsignatory set llp_ow_id = '$ow_fkid' WHERE llp_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_LLP');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_LLP'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
##############################PARTNERSHIP####################################
public function add_new_partnership($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {

            // $data=$this->add_new_doc('d_cat_partnership');
            $data=$this->document_model->add_new_doc('d_cat_partnership');
        
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_partnership',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function savepartnership(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('date_of_incorporation')!='') {
                $partnership_doi=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $partnership_doi=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }
			
            $data = array(
                        'ow_type' => '5',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_prt_comapny_name' => $this->input->post('organisation_name'),
                        'ow_prt_incopdate' => $partnership_doi,
                        'ow_prt_address' => $this->input->post('registered_address'),
                        'ow_prt_landmark' => $this->input->post('prt_addr_landmark'),
                        'ow_prt_city'=>$this->input->post('prt_addr_city'),
                        'ow_prt_state'=>$this->input->post('prt_addr_state'),
                        'ow_prt_country'=>$this->input->post('prt_addr_country'),
                        'ow_prt_pincode'=>$this->input->post('prt_addr_pincode'),
                        'ow_prt_branch' => $this->input->post('branch_address'),
                        'ow_prt_tel' => $this->input->post('telephone_number'),
                        'ow_prt_mob' => $this->input->post('mob_number'),
                        'ow_prt_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $pvt_dirname=$this->input->post('partner_name[]');
            $pvt_percent=$this->input->post('partner_percent[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'prt_ow_id' => $oid,
                        'prt_partnerid' => $pvt_dirname[$i],
                        'prt_percent' => $pvt_percent[$i],
                        );
                    $this->db->insert('prt_partnership_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_partnership');
            $this->document_model->insert_doc($oid, 'Owner_Partnership');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');

            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'prt_ow_id' => $oid,
                        'prt_contactid' => $authname[$m],
                        'prt_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('prt_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    //  public function downloadprtdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM prt_document_details WHERE prt_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->prt_document;
    //     if(!is_dir('./downloads/prt/'.$oid.'/')) {
    //         mkdir('./downloads/prt/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/prt/'.$oid.'/'.$result[0]->prt_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_partnership($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1){

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_partnership');
                $data=$this->document_model->edit_view_doc('d_cat_partnership', $oid, 'Owner_Partnership');

                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_prt_comapny_name, A.ow_reg_no, A.ow_prt_incopdate, A.ow_prt_address,A.ow_prt_landmark,A.ow_prt_city,A.ow_prt_state,A.ow_prt_country,A.ow_prt_pincode,A.ow_prt_branch, A.ow_prt_tel, A.ow_prt_mob, A.ow_prt_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_prt_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                //  $query=$this->db->query("SELECT A.prt_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.prt_percent FROM prt_partnership_details A, contact_master B WHERE A.prt_ow_id='$oid' and A.prt_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                // $query=$this->db->query("SELECT A.prt_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.prt_purpose FROM prt_authorizedsignatory A, contact_master B WHERE A.prt_ow_id='$oid' and A.prt_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_prt_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from prt_partnership_details where prt_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.prt_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from prt_authorizedsignatory where prt_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.prt_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_partnership',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_partnership($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==0 or $result[0]->r_delete){

                // $data=$this->edit_view_doc($oid,'d_cat_partnership');
                $data=$this->document_model->view_doc('d_cat_partnership', $oid, 'Owner_Partnership');

                $data['access']=$result;
                $data["ownerby"]=$this->session->userdata('session_id');
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_prt_comapny_name, A.ow_reg_no, A.ow_prt_incopdate, concat_ws(' ',A.ow_prt_address,A.ow_prt_landmark,A.ow_prt_city,A.ow_prt_state,A.ow_prt_country,A.ow_prt_pincode) as address, A.ow_prt_branch, A.ow_prt_tel, A.ow_prt_mob, A.ow_prt_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_prt_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                // $query=$this->db->query("SELECT A.prt_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.prt_percent FROM prt_partnership_details A, contact_master B WHERE A.prt_ow_id='$oid' and A.prt_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                // $query=$this->db->query("SELECT A.prt_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.prt_purpose FROM prt_authorizedsignatory A, contact_master B WHERE A.prt_ow_id='$oid' and A.prt_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_prt_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from prt_partnership_details where prt_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.prt_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from prt_authorizedsignatory where prt_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.prt_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_partnership_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updatepartnership($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into prt_partnership_details (prt_ow_id, prt_partnerid, prt_percent) 
                                                 Select '$new_oid', prt_partnerid, prt_percent 
                                                 FROM prt_partnership_details WHERE prt_ow_id = '$oid'");

                                $this->db->query("Insert into prt_authorizedsignatory (prt_ow_id, prt_contactid, prt_purpose) 
                                                 Select '$new_oid', prt_contactid, prt_purpose 
                                                 FROM prt_authorizedsignatory WHERE prt_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name) 
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Partnership'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('prt_ow_id', $oid);
                        $this->db->delete('prt_partnership_details');

                        $this->db->where('prt_ow_id', $oid);
                        $this->db->delete('prt_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_Partnership');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {

                if($result[0]->r_edit==1) {
    				if($this->input->post('date_of_incorporation')!='') {
                        $partner_doi=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $partner_doi=NULL;
                    }
    				
                    $data = array(
                                'ow_type' => '5',
                                'ow_reg_no' => $this->input->post('ow_reg_no'),
                                'ow_prt_comapny_name' => $this->input->post('organisation_name'),
                                'ow_prt_incopdate' => $partner_doi,
                                'ow_prt_address' => $this->input->post('registered_address'),
                                'ow_prt_landmark' => $this->input->post('prt_addr_landmark'),
                                'ow_prt_city'=>$this->input->post('prt_addr_city'),
                                'ow_prt_state'=>$this->input->post('prt_addr_state'),
                                'ow_prt_country'=>$this->input->post('prt_addr_country'),
                                'ow_prt_pincode'=>$this->input->post('prt_addr_pincode'),
                                'ow_prt_branch' => $this->input->post('branch_address'),
                                'ow_prt_tel' => $this->input->post('telephone_number'),
                                'ow_prt_mob' => $this->input->post('mob_number'),
                                'ow_prt_contact' => $this->input->post('contact_person'),
                                'ow_gid' => $ow_gid,
                                'ow_status' => $ow_status,
                                'ow_maker_remark' => $this->input->post('ow_maker_remark')
                            );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);
                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('prt_ow_id', $oid);
                        $this->db->delete('prt_partnership_details');

                        $this->db->where('prt_ow_id', $oid);
                        $this->db->delete('prt_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $prtname=$this->input->post('partner_name[]');
                        $prtpercent=$this->input->post('partner_percent[]');

                        for ($i=0; $i <  count($prtname); $i++) { 
                            if($prtname[$i]!="") {
                                $data = array(
                                    'prt_ow_id' => $oid,
                                    'prt_partnerid' => $prtname[$i],
                                    'prt_percent' => $prtpercent[$i],
                                    );
                                $this->db->insert('prt_partnership_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');

                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'prt_ow_id' => $oid,
                                    'prt_contactid' => $authname[$m],
                                    'prt_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('prt_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_partnership',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_Partnership');

                    redirect(base_url().'index.php/owners');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approvepartner($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('prt_ow_id', $ow_fkid);
                        $this->db->delete('prt_partnership_details');
                        $this->db->query("update prt_partnership_details set prt_ow_id = '$ow_fkid' WHERE prt_ow_id = '$oid'");

                        $this->db->where('prt_ow_id', $ow_fkid);
                        $this->db->delete('prt_authorizedsignatory');
                        $this->db->query("update prt_authorizedsignatory set prt_ow_id = '$ow_fkid' WHERE prt_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_Partnership');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Partnership'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


##############################AOP############################################
    public function add_new_aop($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
        
            // $data=$this->add_new_doc('d_cat_aop');
            $data=$this->document_model->add_new_doc('d_cat_aop');

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_aop',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function saveaop(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
			if($this->input->post('date_of_incorporation')!='') {
                $aop_doi=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $aop_doi=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $data = array(
                        'ow_type' => '6',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_aop_comapny_name' => $this->input->post('organisation_name'),
                        'ow_aop_incopdate' => $aop_doi,
                        'ow_aop_address' => $this->input->post('registered_address'),
                        'ow_aop_landmark' => $this->input->post('aop_addr_landmark'),
                        'ow_aop_city'=>$this->input->post('aop_addr_city'),
                        'ow_aop_state'=>$this->input->post('aop_addr_state'),
                        'ow_aop_country'=>$this->input->post('aop_addr_country'),
                        'ow_aop_pincode'=>$this->input->post('aop_addr_pincode'),
                        'ow_aop_branch' => $this->input->post('branch_address'),
                        'ow_aop_tel' => $this->input->post('telephone_number'),
                        'ow_aop_mob' => $this->input->post('mob_number'),
                        'ow_aop_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $pvt_dirname=$this->input->post('partner_name[]');
            $pvt_percent=$this->input->post('partner_percent[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'aop_ow_id' => $oid,
                        'aop_partnerid' => $pvt_dirname[$i],
                        'aop_percent' => $pvt_percent[$i],
                        );
                    $this->db->insert('aop_partnership_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_aop');
            $this->document_model->insert_doc($oid, 'Owner_AOP');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');

            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'aop_ow_id' => $oid,
                        'aop_contactid' => $authname[$m],
                        'aop_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('aop_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/owners');
        } else { 
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    //  public function downloadaopdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM aop_document_details WHERE aop_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->aop_document;
    //     if(!is_dir('./downloads/aop/'.$oid.'/')) {
    //         mkdir('./downloads/aop/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/aop/'.$oid.'/'.$result[0]->aop_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_aop($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_aop');
                $data=$this->document_model->edit_view_doc('d_cat_aop', $oid, 'Owner_AOP');

                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_aop_comapny_name, A.ow_reg_no, A.ow_aop_incopdate, A.ow_aop_address,A.ow_aop_landmark,A.ow_aop_city,A.ow_aop_state,A.ow_aop_country,A.ow_aop_pincode,A.ow_aop_branch, A.ow_aop_tel, A.ow_aop_mob, A.ow_aop_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_aop_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                // $query=$this->db->query("SELECT A.aop_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.aop_percent FROM aop_partnership_details A, contact_master B WHERE A.aop_ow_id='$oid' and A.aop_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                // $query=$this->db->query("SELECT A.aop_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.aop_purpose FROM aop_authorizedsignatory A, contact_master B WHERE A.aop_ow_id='$oid' and A.aop_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_aop_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from aop_partnership_details where aop_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.aop_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from aop_authorizedsignatory where aop_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.aop_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_aop',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_aop($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {

                // $data=$this->edit_view_doc($oid,'d_cat_aop');
                $data=$this->document_model->view_doc('d_cat_aop', $oid, 'Owner_AOP');

                $data['access']=$result;
                $data["ownerby"]=$this->session->userdata('session_id');

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_aop_comapny_name, A.ow_reg_no, A.ow_aop_incopdate, concat_ws(' ', A.ow_aop_address,A.ow_aop_landmark,A.ow_aop_city,A.ow_aop_state,A.ow_aop_country,A.ow_aop_pincode) as address, A.ow_aop_branch, A.ow_aop_tel, A.ow_aop_mob, A.ow_aop_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_aop_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_detail']=$result;

                // $query=$this->db->query("SELECT A.aop_partnerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.aop_percent FROM aop_partnership_details A, contact_master B WHERE A.aop_ow_id='$oid' and A.aop_partnerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_partner']=$result;

                // $query=$this->db->query("SELECT A.aop_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.aop_purpose FROM aop_authorizedsignatory A, contact_master B WHERE A.aop_ow_id='$oid' and A.aop_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['llp_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_aop_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from aop_partnership_details where aop_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.aop_partnerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_partner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from aop_authorizedsignatory where aop_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.aop_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['llp_auth']=$result;
                
                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_aop_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateaop($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for Approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for Approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into aop_partnership_details (aop_ow_id, aop_partnerid, aop_percent) 
                                                 Select '$new_oid', aop_partnerid, aop_percent 
                                                 FROM aop_partnership_details WHERE aop_ow_id = '$oid'");

                                $this->db->query("Insert into aop_authorizedsignatory (aop_ow_id, aop_contactid, aop_purpose) 
                                                 Select '$new_oid', aop_contactid, aop_purpose 
                                                 FROM aop_authorizedsignatory WHERE aop_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_AOP'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('aop_ow_id', $oid);
                        $this->db->delete('aop_partnership_details');

                        $this->db->where('aop_ow_id', $oid);
                        $this->db->delete('aop_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_AOP');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if($this->input->post('date_of_incorporation')!='') {
                        $aop_doi=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $aop_doi=NULL;
                    }

                    $data = array(
                                'ow_type' => '6',
                                'ow_reg_no' => $this->input->post('ow_reg_no'),
                                'ow_aop_comapny_name' => $this->input->post('organisation_name'),
                                'ow_aop_incopdate' => $aop_doi,
                                'ow_aop_address' => $this->input->post('registered_address'),                    
                                'ow_aop_landmark' => $this->input->post('aop_addr_landmark'),
                                'ow_aop_city'=>$this->input->post('aop_addr_city'),
                                'ow_aop_state'=>$this->input->post('aop_addr_state'),
                                'ow_aop_country'=>$this->input->post('aop_addr_country'),
                                'ow_aop_pincode'=>$this->input->post('aop_addr_pincode'),
                                'ow_aop_branch' => $this->input->post('branch_address'),
                                'ow_aop_tel' => $this->input->post('telephone_number'),
                                'ow_aop_mob' => $this->input->post('mob_number'),
                                'ow_aop_contact' => $this->input->post('contact_person'),
                                'ow_gid' => $ow_gid,
                                'ow_status' => $ow_status,
                                'ow_maker_remark' => $this->input->post('ow_maker_remark')
                            );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }


                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('aop_ow_id', $oid);
                        $this->db->delete('aop_partnership_details');

                        $this->db->where('aop_ow_id', $oid);
                        $this->db->delete('aop_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $prtname=$this->input->post('partner_name[]');
                        $prtpercent=$this->input->post('partner_percent[]');

                        for ($i=0; $i <  count($prtname); $i++) { 
                            if($prtname[$i]!="") {
                                $data = array(
                                    'aop_ow_id' => $oid,
                                    'aop_partnerid' => $prtname[$i],
                                    'aop_percent' => $prtpercent[$i],
                                    );
                                $this->db->insert('aop_partnership_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');

                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'aop_ow_id' => $oid,
                                    'aop_contactid' => $authname[$m],
                                    'aop_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('aop_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_aop',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_AOP');

                    redirect(base_url().'index.php/owners');
                    
                }else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveaop($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('aop_ow_id', $ow_fkid);
                        $this->db->delete('aop_partnership_details');
                        $this->db->query("update aop_partnership_details set aop_ow_id = '$ow_fkid' WHERE aop_ow_id = '$oid'");

                        $this->db->where('aop_ow_id', $ow_fkid);
                        $this->db->delete('aop_authorizedsignatory');
                        $this->db->query("update aop_authorizedsignatory set aop_ow_id = '$ow_fkid' WHERE aop_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_AOP');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_AOP'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


##############################TRUST###########################################
    public function add_new_trust($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {

            // $data=$this->add_new_doc('d_cat_trust');
            $data=$this->document_model->add_new_doc('d_cat_trust');
        
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_trust',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function savetrust(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('date_of_incorporation')!='') {
                $trust_doi=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $trust_doi=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }
			
            $data = array(
                        'ow_type' => '7',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_trs_comapny_name' => $this->input->post('trust_name'),
                        'ow_trs_incopdate' => $trust_doi,
                        'ow_trs_address' => $this->input->post('registered_address'),
                        'ow_trs_landmark' => $this->input->post('trs_addr_landmark'),
                        'ow_trs_city'=>$this->input->post('trs_addr_city'),
                        'ow_trs_state'=>$this->input->post('trs_addr_state'),
                        'ow_trs_country'=>$this->input->post('trs_addr_country'),
                        'ow_trs_pincode'=>$this->input->post('trs_addr_pincode'),
                        'ow_trs_branch' => $this->input->post('branch_address'),
                        'ow_trs_tel' => $this->input->post('telephone_number'),
                        'ow_trs_mob' => $this->input->post('mob_number'),
                        'ow_trs_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);


            $trstname=$this->input->post('trustee_name[]');
            for ($i=0; $i <  count($trstname); $i++) { 
                if($trstname[$i]!="") {
                    $data = array(
                        'trst_ow_id' => $oid,
                        'trst_contactid' => $trstname[$i],
                        );
                    $this->db->insert('trust_trustee_details', $data);
                }
            }

            $beneficiaryname=$this->input->post('beneficiary_name[]');
            $beneficiaryprcnt=$this->input->post('beneficiary_percent[]');

            for ($j=0; $j <  count($beneficiaryname); $j++) { 
                if($beneficiaryname[$j]!="") {
                    $data = array(
                        'trst_ow_id' => $oid,
                        'trst_contactid' => $beneficiaryname[$j],
                        'trst_percent' => $beneficiaryprcnt[$j],
                        );
                    $this->db->insert('trust_beneficiary_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_trust');
            $this->document_model->insert_doc($oid, 'Owner_Trust');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');

            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!="") {
                    $data = array(
                        'ath_ow_id' => $oid,
                        'ath_contactid' => $authname[$m],
                        'ath_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('trust_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit_trust($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1){

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_trust');
                $data=$this->document_model->edit_view_doc('d_cat_trust', $oid, 'Owner_Trust');

                $data['access']=$result;
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_trs_comapny_name, A.ow_reg_no, A.ow_trs_incopdate, A.ow_trs_address,A.ow_trs_landmark,A.ow_trs_city,A.ow_trs_state,A.ow_trs_country,A.ow_trs_pincode,A.ow_trs_branch, A.ow_trs_tel, A.ow_trs_contact, A.ow_trs_mob, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_id = '$oid' and A.ow_trs_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_detail']=$result;

                // $query=$this->db->query("SELECT A.trst_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM trust_trustee_details A, contact_master B WHERE A.trst_ow_id = '$oid' and A.trst_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_trustee']=$result;

                // $query=$this->db->query("SELECT A.trst_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.trst_percent FROM trust_beneficiary_details A, contact_master B WHERE A.trst_ow_id = '$oid' and A.trst_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_beneficiary']=$result;

                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM trust_authorizedsignatory A, contact_master B WHERE A.ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_ath']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_trs_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_trustee_details where trst_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.trst_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_trustee']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_beneficiary_details where trst_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.trst_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_beneficiary']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_ath']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_trust',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function view_trust($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1){

                // $data=$this->edit_view_doc($oid,'d_cat_trust');
                $data=$this->document_model->view_doc('d_cat_trust', $oid, 'Owner_Trust');

                $data['ownerby']=$this->session->userdata('session_id');
                $data['access']=$result;
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_trs_comapny_name, A.ow_reg_no, A.ow_trs_incopdate, concat_ws(' ',A.ow_trs_address,A.ow_trs_landmark,A.ow_trs_city,A.ow_trs_state,A.ow_trs_country,A.ow_trs_pincode) as address, A.ow_trs_branch, A.ow_trs_tel, A.ow_trs_contact, A.ow_trs_mob, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id = '$oid' and A.ow_trs_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_detail']=$result;

                // $query=$this->db->query("SELECT A.trst_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM trust_trustee_details A, contact_master B WHERE A.trst_ow_id = '$oid' and A.trst_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_trustee']=$result;

                // $query=$this->db->query("SELECT A.trst_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.trst_percent FROM trust_beneficiary_details A, contact_master B WHERE A.trst_ow_id = '$oid' and A.trst_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_beneficiary']=$result;
                
                // $query=$this->db->query("SELECT A.ath_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ath_purpose FROM trust_authorizedsignatory A, contact_master B WHERE A.ath_ow_id = '$oid' and A.ath_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['trust_ath']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_trs_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_trustee_details where trst_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.trst_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_trustee']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_beneficiary_details where trst_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.trst_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_beneficiary']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from trust_authorizedsignatory where ath_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ath_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['trust_ath']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_trust_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloadtrstdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM trust_document_details WHERE trst_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->trst_document;
    //     if(!is_dir('./downloads/trust/'.$oid.'/')) {
    //         mkdir('./downloads/trust/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/trust/'.$oid.'/'.$result[0]->trst_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function updatetrust($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into trust_trustee_details (trst_ow_id, trst_contactid) 
                                                 Select '$new_oid', trst_contactid 
                                                 FROM trust_trustee_details WHERE trst_ow_id = '$oid'");

                                $this->db->query("Insert into trust_beneficiary_details (trst_ow_id, trst_contactid, trst_percent) 
                                                 Select '$new_oid', trst_contactid, trst_percent 
                                                 FROM trust_beneficiary_details WHERE trst_ow_id = '$oid'");

                                $this->db->query("Insert into trust_authorizedsignatory (ath_ow_id, ath_contactid, ath_purpose) 
                                                 Select '$new_oid', ath_contactid, ath_purpose 
                                                 FROM trust_authorizedsignatory WHERE ath_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name) 
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Trust'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('trst_ow_id', $oid);
                        $this->db->delete('trust_trustee_details');

                        $this->db->where('trst_ow_id', $oid);
                        $this->db->delete('trust_beneficiary_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('trust_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_Trust');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if($this->input->post('date_of_incorporation')!='') {
                        $trust_doi=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $trust_doi=NULL;
                    }

                    $data = array(
                                'ow_type' => '7',
                                'ow_reg_no' => $this->input->post('ow_reg_no'),
                                'ow_trs_comapny_name' => $this->input->post('trust_name'),
                                'ow_trs_incopdate' => $trust_doi,
                                'ow_trs_address' => $this->input->post('registered_address'),
                                'ow_trs_landmark' => $this->input->post('trs_addr_landmark'),
                                'ow_trs_city'=>$this->input->post('trs_addr_city'),
                                'ow_trs_state'=>$this->input->post('trs_addr_state'),
                                'ow_trs_country'=>$this->input->post('trs_addr_country'),
                                'ow_trs_pincode'=>$this->input->post('trs_addr_pincode'),
                                'ow_trs_branch' => $this->input->post('branch_address'),
                                'ow_trs_tel' => $this->input->post('telephone_number'),
                                'ow_trs_mob' => $this->input->post('mob_number'),
                                'ow_trs_contact' => $this->input->post('contact_person'),
                                'ow_gid' => $ow_gid,
                                'ow_status' => $ow_status,
                                'ow_maker_remark' => $this->input->post('ow_maker_remark')
                        );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }


                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('trst_ow_id', $oid);
                        $this->db->delete('trust_trustee_details');

                        $this->db->where('trst_ow_id', $oid);
                        $this->db->delete('trust_beneficiary_details');

                        $this->db->where('ath_ow_id', $oid);
                        $this->db->delete('trust_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $trstname=$this->input->post('trustee_name[]');
                        
                        for ($i=0; $i <  count($trstname); $i++) { 
                            if($trstname[$i]!="") {
                                $data = array(
                                    'trst_ow_id' => $oid,
                                    'trst_contactid' => $trstname[$i],
                                    );
                                $this->db->insert('trust_trustee_details', $data);
                            }
                        }

                        $beneficiaryname=$this->input->post('beneficiary_name[]');
                        $beneficiaryprcnt=$this->input->post('beneficiary_percent[]');

                        for ($j=0; $j <  count($beneficiaryname); $j++) { 
                            if($beneficiaryname[$j]!="") {
                                $data = array(
                                    'trst_ow_id' => $oid,
                                    'trst_contactid' => $beneficiaryname[$j],
                                    'trst_percent' => $beneficiaryprcnt[$j],
                                    );
                                $this->db->insert('trust_beneficiary_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');

                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!="") {
                                $data = array(
                                    'ath_ow_id' => $oid,
                                    'ath_contactid' => $authname[$m],
                                    'ath_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('trust_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_trust',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_Trust');

                    redirect(base_url().'index.php/owners');
                } else {
                    echo '<script>alert("You donot have access to this page.");</script>';
                    $this->load->view('login/main_page');
                }
            }
        }
    }

    public function approvetrust($oid) {
		$roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('trst_ow_id', $ow_fkid);
                        $this->db->delete('trust_trustee_details');
                        $this->db->query("update trust_trustee_details set trst_ow_id = '$ow_fkid' WHERE trst_ow_id = '$oid'");

                        $this->db->where('trst_ow_id', $ow_fkid);
                        $this->db->delete('trust_beneficiary_details');
                        $this->db->query("update trust_beneficiary_details set trst_ow_id = '$ow_fkid' WHERE trst_ow_id = '$oid'");
                        
                        $this->db->where('ath_ow_id', $ow_fkid);
                        $this->db->delete('trust_authorizedsignatory');
                        $this->db->query("update trust_authorizedsignatory set ath_ow_id = '$ow_fkid' WHERE ath_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_Trust');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Trust'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


##############################Proprietorship###########################################
    public function add_new_proprietorship($contact_type=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
        
            // $data=$this->add_new_doc('d_cat_proprietorship');
            $data=$this->document_model->add_new_doc('d_cat_proprietorship');
            
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_proprietorship',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function saveproprietorship(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('date_of_incorporation')!='') {
                $proprietorship_doi=FormatDate($this->input->post('date_of_incorporation'));
            } else {
                $proprietorship_doi=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $data = array(
                        'ow_type' => '8',
                        'ow_reg_no' => $this->input->post('ow_reg_no'),
                        'ow_proprietorship_comapny_name' => $this->input->post('organisation_name'),
                        'ow_proprietorship_incopdate' => $proprietorship_doi,
                        'ow_proprietorship_address' => $this->input->post('registered_address'),                
                        'ow_proprietorship_landmark' => $this->input->post('proprietorship_addr_landmark'),
                        'ow_proprietorship_city'=>$this->input->post('proprietorship_addr_city'),
                        'ow_proprietorship_state'=>$this->input->post('proprietorship_addr_state'),
                        'ow_proprietorship_country'=>$this->input->post('proprietorship_addr_country'),
                        'ow_proprietorship_pincode'=>$this->input->post('proprietorship_addr_pincode'),
                        'ow_proprietorship_branch' => $this->input->post('branch_address'),
                        'ow_proprietorship_tel' => $this->input->post('telephone_number'),
                        'ow_proprietorship_mob' => $this->input->post('mob_number'),
                        'ow_proprietorship_contact' => $this->input->post('contact_person'),
                        'ow_status' => $ow_status,
                        'ow_create_date' => $now,
                        'ow_create_by' => $curusr,
                        'ow_modified_date' => $now,
                        'ow_modified_by' => $curusr,
                        'ow_gid' => $gid,
                        'ow_maker_remark' => $this->input->post('ow_maker_remark')
                    );
            $this->db->insert('owner_master', $data);
            $oid=$this->db->insert_id();

            $logarray['table_id']=$oid;
            $logarray['module_name']='Owners';
            $logarray['cnt_name']='Owners';
            $logarray['action']='Owners Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);


            $pvt_dirname=$this->input->post('owner_name[]');
            // $pvt_percent=$this->input->post('owner_percent[]');
            for ($i=0; $i <  count($pvt_dirname); $i++) { 
                if($pvt_dirname[$i]!="") {
                    $data = array(
                        'proprietorship_ow_id' => $oid,
                        'proprietorship_ownerid' => $pvt_dirname[$i]
                        // ,
                        // 'proprietorship_percent' => $pvt_percent[$i],
                        );
                    $this->db->insert('proprietorship_ownership_details', $data);
                }
            }

            // $this->insert_doc($oid,'d_cat_proprietorship');
            $this->document_model->insert_doc($oid, 'Owner_Proprietorship');

            $authname=$this->input->post('auth_name[]');
            $authpurpose=$this->input->post('auth_purpose[]');
            for ($m=0; $m <  count($authname); $m++) { 
                if($authname[$m]!=""){
                    $data = array(
                        'proprietorship_ow_id' => $oid,
                        'proprietorship_contactid' => $authname[$m],
                        'proprietorship_purpose' => $authpurpose[$m],
                        );
                    $this->db->insert('proprietorship_authorizedsignatory', $data);
                }
            }

            redirect(base_url().'index.php/owners');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    //  public function downloadproprietorshipdocs($oid, $docid) {
    //     $query=$this->db->query("SELECT * FROM proprietorship_document_details WHERE proprietorship_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->proprietorship_document;
    //     if(!is_dir('./downloads/proprietorship/'.$oid.'/')) {
    //         mkdir('./downloads/proprietorship/'.$oid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/proprietorship/'.$oid.'/'.$result[0]->proprietorship_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function edit_proprietorship($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $oid = $result1[0]->ow_id;
                }

                // $data=$this->edit_view_doc($oid,'d_cat_proprietorship');
                $data=$this->document_model->edit_view_doc('d_cat_proprietorship', $oid, 'Owner_Proprietorship');

                $data['access']=$result;
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_proprietorship_comapny_name, A.ow_reg_no, A.ow_proprietorship_incopdate, A.ow_proprietorship_address,A.ow_proprietorship_landmark,A.ow_proprietorship_city,A.ow_proprietorship_state,A.ow_proprietorship_pincode,A.ow_proprietorship_country, A.ow_proprietorship_branch, A.ow_proprietorship_tel,A.ow_proprietorship_mob, A.ow_proprietorship_contact, A.ow_maker_remark, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_proprietorship_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_detail']=$result;

                //  $query=$this->db->query("SELECT A.proprietorship_ownerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.proprietorship_percent FROM proprietorship_ownership_details A, contact_master B WHERE A.proprietorship_ow_id='$oid' and A.proprietorship_ownerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_owner']=$result;

                // $query=$this->db->query("SELECT A.proprietorship_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.proprietorship_purpose FROM proprietorship_authorizedsignatory A, contact_master B WHERE A.proprietorship_ow_id='$oid' and A.proprietorship_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_proprietorship_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from proprietorship_ownership_details where proprietorship_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.proprietorship_ownerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_owner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from proprietorship_authorizedsignatory where proprietorship_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.proprietorship_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_auth']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_proprietorship',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function view_proprietorship($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1 or $result[0]->r_view==1 or $result[0]->r_delete==1) {
                
                // $data=$this->edit_view_doc($oid,'d_cat_proprietorship');
                $data=$this->document_model->view_doc('d_cat_proprietorship', $oid, 'Owner_Proprietorship');

                $data['ownerby']=$this->session->userdata('session_id');
                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contact']=$result;

                // $query=$this->db->query("SELECT A.ow_proprietorship_comapny_name, A.ow_reg_no, A.ow_proprietorship_incopdate, concat_ws(' ',A.ow_proprietorship_address,A.ow_proprietorship_landmark,A.ow_proprietorship_city,A.ow_proprietorship_state,A.ow_proprietorship_country,A.ow_proprietorship_pincode) as address, A.ow_proprietorship_branch, A.ow_proprietorship_tel, A.ow_proprietorship_mob, A.ow_proprietorship_contact, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.ow_status, A.ow_txnremarks, A.ow_create_by, A.ow_modified_by, A.ow_maker_remark FROM owner_master A, contact_master B WHERE A.ow_id='$oid' and A.ow_proprietorship_contact=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_detail']=$result;

                // $query=$this->db->query("SELECT A.proprietorship_ownerid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.proprietorship_percent FROM proprietorship_ownership_details A, contact_master B WHERE A.proprietorship_ow_id='$oid' and A.proprietorship_ownerid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_owner']=$result;

                // $query=$this->db->query("SELECT A.proprietorship_contactid, concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) as c_name, A.proprietorship_purpose FROM proprietorship_authorizedsignatory A, contact_master B WHERE A.proprietorship_ow_id='$oid' and A.proprietorship_contactid=B.c_id");
                // $result=$query->result();
                // if(count($result)>0) $data['proprietorship_auth']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from owner_master where ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.ow_proprietorship_contact=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_detail']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from proprietorship_ownership_details where proprietorship_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.proprietorship_ownerid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_owner']=$result;

                $query=$this->db->query("select A.*, 
                                        case when B.ow_type = '0' then 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                    from contact_master where c_id = B.ow_ind_id) 
                                            when B.ow_type = '1' then B.ow_huf_name 
                                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                                            else B.ow_proprietorship_comapny_name end as c_name from 
                                        (select * from proprietorship_authorizedsignatory where proprietorship_ow_id='$oid') A 
                                        left join 
                                        (select * from owner_master) B 
                                        on (A.proprietorship_contactid=B.ow_id)");
                $result=$query->result();
                if(count($result)>0) $data['proprietorship_auth']=$result;

                $data['o_id']=$oid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('owners/owner_proprietorship_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateproprietorship($oid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $ow_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $ow_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $ow_status='Approved';
            } else  {
                $ow_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->ow_status;
                $ow_fkid = $res[0]->ow_fkid;
                $ow_gid = $res[0]->ow_gid;
                $ow_create_by = $res[0]->ow_create_by;
                $ow_create_date = $res[0]->ow_create_date;
            } else {
                $rec_status = 'In Process';
                $ow_fkid = '';
                $ow_gid = $this->session->userdata('groupid');
                $ow_create_by = $curusr;
                $ow_create_date = $now;
            }

            if($ow_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $ow_txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $ow_status = 'Inactive';

                            $this->db->query("update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', ow_modified_by='$curusr', 
                                            ow_modified_date='$modnow' WHERE ow_id = '$oid'");
                            $logarray['table_id']=$oid;
                            $logarray['module_name']='Owners';
                            $logarray['cnt_name']='Owners';
                            $logarray['action']='Owners Record ' . $ow_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_fkid = '$oid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $oid = $result[0]->ow_id;

                                $this->db->query("Update owner_master set ow_status='$ow_status', ow_txnremarks='$ow_txnremarks', 
                                                 ow_modified_date='$modnow', ow_modified_by='$curusr' 
                                                 WHERE ow_id = '$oid'");

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into owner_master (ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, ow_status, ow_create_date, ow_create_by, 
                                            ow_modified_date, ow_modified_by, ow_txnremarks, ow_approveddate, ow_approvedby, 
                                            ow_gid, ow_fkid, ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact) 
                                            Select ow_type, ow_reg_no, ow_ind_id, ow_huf_name, ow_huf_incorpdate, 
                                            ow_huf_address, ow_huf_country, ow_huf_pincode, ow_huf_state, ow_huf_city, 
                                            ow_huf_landmark, ow_huf_karta_id, ow_pvtltd_comapny_name, ow_pvtltd_incopdate, 
                                            ow_pvtltd_address, ow_pvtltd_country, ow_pvtltd_pincode, ow_pvtltd_state, 
                                            ow_pvtltd_city, ow_pvtltd_landmark, ow_pvtltd_branch, ow_pvtltd_tel, ow_pvtltd_mob, 
                                            ow_pvtltd_contact, ow_ltd_comapny_name, ow_ltd_incopdate, ow_ltd_address, 
                                            ow_ltd_country, ow_ltd_pincode, ow_ltd_state, ow_ltd_city, ow_ltd_landmark, 
                                            ow_ltd_branch, ow_ltd_tel, ow_ltd_mob, ow_ltd_contact, ow_llp_comapny_name, 
                                            ow_llp_incopdate, ow_llp_address, ow_llp_country, ow_llp_pincode, ow_llp_state, 
                                            ow_llp_city, ow_llp_landmark, ow_llp_branch, ow_llp_tel, ow_llp_mob, ow_llp_contact, 
                                            ow_prt_comapny_name, ow_prt_incopdate, ow_prt_address, ow_prt_country, ow_prt_pincode, 
                                            ow_prt_state, ow_prt_city, ow_prt_landmark, ow_prt_branch, ow_prt_tel, ow_prt_mob, 
                                            ow_prt_contact, ow_aop_comapny_name, ow_aop_incopdate, ow_aop_address, ow_aop_country, 
                                            ow_aop_pincode, ow_aop_state, ow_aop_city, ow_aop_landmark, ow_aop_branch, ow_aop_tel, 
                                            ow_aop_mob, ow_aop_contact, ow_trs_comapny_name, ow_trs_incopdate, ow_trs_address, 
                                            ow_trs_country, ow_trs_pincode, ow_trs_state, ow_trs_city, ow_trs_landmark, ow_trs_branch, 
                                            ow_trs_tel, ow_trs_mob, ow_trs_contact, '$ow_status', ow_create_date, ow_create_by, 
                                            '$modnow', '$curusr', '$ow_txnremarks', ow_approveddate, ow_approvedby, 
                                            ow_gid, '$oid', ow_rejectedby, ow_rejecteddate, ow_maker_remark, 
                                            ow_proprietorship_comapny_name, ow_proprietorship_incopdate, ow_proprietorship_address, 
                                            ow_proprietorship_country, ow_proprietorship_pincode, ow_proprietorship_state, 
                                            ow_proprietorship_city, ow_proprietorship_landmark, ow_proprietorship_branch, 
                                            ow_proprietorship_tel, ow_proprietorship_mob, ow_proprietorship_contact 
                                            FROM owner_master WHERE ow_id = '$oid'");
                                $new_oid=$this->db->insert_id();

                                $logarray['table_id']=$oid;
                                $logarray['module_name']='Owners';
                                $logarray['cnt_name']='Owners';
                                $logarray['action']='Owners Record Delete (sent for Approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into proprietorship_ownership_details (proprietorship_ow_id, proprietorship_ownerid, proprietorship_percent) 
                                                 Select '$new_oid', proprietorship_ownerid, proprietorship_percent 
                                                 FROM proprietorship_ownership_details WHERE proprietorship_ow_id = '$oid'");

                                $this->db->query("Insert into proprietorship_authorizedsignatory (proprietorship_ow_id, proprietorship_contactid, proprietorship_purpose) 
                                                 Select '$new_oid', proprietorship_contactid, proprietorship_purpose 
                                                 FROM proprietorship_authorizedsignatory WHERE proprietorship_ow_id = '$oid'");

                                // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type) 
                                //                  Select '$new_oid', doc_type, doc_name, 
                                //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                                //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$oid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name) 
                                                 Select '$new_oid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Proprietorship'");
                            }
                        }
                    } else {
                        $this->db->where('ow_id', $oid);
                        $this->db->delete('owner_master');

                        $this->db->where('proprietorship_ow_id', $oid);
                        $this->db->delete('proprietorship_ownership_details');

                        $this->db->where('proprietorship_ow_id', $oid);
                        $this->db->delete('proprietorship_authorizedsignatory');

                        // $this->db->where('doc_ow_id', $oid);
                        // $this->db->delete('owner_document_details');

                        $this->db->where('doc_ref_id', $oid);
                        $this->db->where('doc_ref_type', 'Owner_Proprietorship');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Owners');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if($this->input->post('date_of_incorporation')!='') {
                        $proprietorship_doi=FormatDate($this->input->post('date_of_incorporation'));
                    } else {
                        $proprietorship_doi=NULL;
                    }

                    $data = array(
                            'ow_type' => '8',
                            'ow_reg_no' => $this->input->post('ow_reg_no'),
                            'ow_proprietorship_comapny_name' => $this->input->post('organisation_name'),
                            'ow_proprietorship_incopdate' => $proprietorship_doi,
                            'ow_proprietorship_address' => $this->input->post('registered_address'),                    
                            'ow_proprietorship_landmark' => $this->input->post('proprietorship_addr_landmark'),
                            'ow_proprietorship_city'=>$this->input->post('proprietorship_addr_city'),
                            'ow_proprietorship_state'=>$this->input->post('proprietorship_addr_state'),
                            'ow_proprietorship_country'=>$this->input->post('proprietorship_addr_country'),
                            'ow_proprietorship_pincode'=>$this->input->post('proprietorship_addr_pincode'),
                            'ow_proprietorship_branch' => $this->input->post('branch_address'),
                            'ow_proprietorship_tel' => $this->input->post('telephone_number'),
                            'ow_proprietorship_mob' => $this->input->post('mob_number'),
                            'ow_proprietorship_contact' => $this->input->post('contact_person'),
                            'ow_gid' => $ow_gid,
                            'ow_status' => $ow_status,
                            'ow_maker_remark' => $this->input->post('ow_maker_remark')
                        );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $ow_fkid = $oid;
                        $data['ow_fkid'] = $ow_fkid;
                        $data['ow_create_date'] = $ow_create_date;
                        $data['ow_create_by'] = $ow_create_by;
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->insert('owner_master',$data);
                        $oid=$this->db->insert_id();

                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into owner_document_details (doc_ow_id, doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type) 
                        //                  Select '$oid', doc_type, doc_name, 
                        //                  doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name, 
                        //                  doc_ow_type FROM owner_document_details WHERE doc_ow_id = '$ow_fkid'");
                    } else {
                        $data['ow_modified_date'] = $modnow;
                        $data['ow_modified_by'] = $curusr;

                        $this->db->where('ow_id', $oid);
                        $this->db->update('owner_master',$data);

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('proprietorship_ow_id', $oid);
                        $this->db->delete('proprietorship_ownership_details');

                        $this->db->where('proprietorship_ow_id', $oid);
                        $this->db->delete('proprietorship_authorizedsignatory');
                    }

                    // if ($ow_status!="Delete" || $rec_status=="Approved") {
                        $prtname=$this->input->post('owner_name[]');
                        $prtpercent=$this->input->post('owner_percent[]');

                        for ($i=0; $i <  count($prtname); $i++) { 
                            if($prtname[$i]!="") {
                                $data = array(
                                    'proprietorship_ow_id' => $oid,
                                    'proprietorship_ownerid' => $prtname[$i],
                                    'proprietorship_percent' => $prtpercent[$i],
                                    );
                                $this->db->insert('proprietorship_ownership_details', $data);
                            }
                        }

                        $authname=$this->input->post('auth_name[]');
                        $authpurpose=$this->input->post('auth_purpose[]');

                        for ($m=0; $m <  count($authname); $m++) { 
                            if($authname[$m]!=""){
                                $data = array(
                                    'proprietorship_ow_id' => $oid,
                                    'proprietorship_contactid' => $authname[$m],
                                    'proprietorship_purpose' => $authpurpose[$m],
                                    );
                                $this->db->insert('proprietorship_authorizedsignatory', $data);
                            }
                        }
                    // }

                    // $rec_status = $ow_status;
                    // $this->insert_doc($oid,'d_cat_proprietorship',$rec_status,$ow_status);
                    $this->document_model->insert_doc($oid, 'Owner_Proprietorship');

                    redirect(base_url().'index.php/owners');
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveproprietorship($oid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->ow_status;
                    $ow_fkid = $res[0]->ow_fkid;
                    $ow_gid = $res[0]->ow_gid;
                } else {
                    $rec_status = 'In Process';
                    $ow_fkid = '';
                    $ow_gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $ow_status='Approved';
                } else  {
                    $ow_status='Rejected';
                }
                $ow_txnremarks = $this->input->post('status_remarks');

                if ($ow_status=='Rejected') {
                    $this->db->query("update owner_master set ow_status='Rejected', ow_txnremarks='$ow_txnremarks', ow_rejectedby='$curusr', ow_rejecteddate='$modnow' WHERE ow_id = '$oid'");

                    $logarray['table_id']=$oid;
                    $logarray['module_name']='Owners';
                    $logarray['cnt_name']='Owners';
                    $logarray['action']='Owners Record ' . $ow_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($ow_fkid=='' || $ow_fkid==null) {
                        $this->db->query("update owner_master set ow_status='Approved', ow_txnremarks='$ow_txnremarks', ow_approvedby='$curusr', ow_approveddate='$modnow' WHERE ow_id = '$oid'");

                        $logarray['table_id']=$oid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $ow_status='Inactive';
                        }
                        $this->db->query("update owner_master A, owner_master B set A.ow_type=B.ow_type, A.ow_reg_no=B.ow_reg_no, A.ow_ind_id=B.ow_ind_id, 
                                        A.ow_huf_name=B.ow_huf_name, A.ow_huf_incorpdate=B.ow_huf_incorpdate, 
                                        A.ow_huf_address=B.ow_huf_address, A.ow_huf_country=B.ow_huf_country, 
                                        A.ow_huf_pincode=B.ow_huf_pincode, A.ow_huf_state=B.ow_huf_state, 
                                        A.ow_huf_city=B.ow_huf_city, A.ow_huf_landmark=B.ow_huf_landmark, 
                                        A.ow_huf_karta_id=B.ow_huf_karta_id, A.ow_pvtltd_comapny_name=B.ow_pvtltd_comapny_name, 
                                        A.ow_pvtltd_incopdate=B.ow_pvtltd_incopdate, A.ow_pvtltd_address=B.ow_pvtltd_address, 
                                        A.ow_pvtltd_country=B.ow_pvtltd_country, A.ow_pvtltd_pincode=B.ow_pvtltd_pincode, 
                                        A.ow_pvtltd_state=B.ow_pvtltd_state, A.ow_pvtltd_city=B.ow_pvtltd_city, 
                                        A.ow_pvtltd_landmark=B.ow_pvtltd_landmark, A.ow_pvtltd_branch=B.ow_pvtltd_branch, 
                                        A.ow_pvtltd_tel=B.ow_pvtltd_tel, A.ow_pvtltd_mob=B.ow_pvtltd_mob, 
                                        A.ow_pvtltd_contact=B.ow_pvtltd_contact, A.ow_ltd_comapny_name=B.ow_ltd_comapny_name, 
                                        A.ow_ltd_incopdate=B.ow_ltd_incopdate, A.ow_ltd_address=B.ow_ltd_address, 
                                        A.ow_ltd_country=B.ow_ltd_country, A.ow_ltd_pincode=B.ow_ltd_pincode, 
                                        A.ow_ltd_state=B.ow_ltd_state, A.ow_ltd_city=B.ow_ltd_city, 
                                        A.ow_ltd_landmark=B.ow_ltd_landmark, A.ow_ltd_branch=B.ow_ltd_branch, 
                                        A.ow_ltd_tel=B.ow_ltd_tel, A.ow_ltd_mob=B.ow_ltd_mob, A.ow_ltd_contact=B.ow_ltd_contact, 
                                        A.ow_llp_comapny_name=B.ow_llp_comapny_name, A.ow_llp_incopdate=B.ow_llp_incopdate, 
                                        A.ow_llp_address=B.ow_llp_address, A.ow_llp_country=B.ow_llp_country, 
                                        A.ow_llp_pincode=B.ow_llp_pincode, A.ow_llp_state=B.ow_llp_state, 
                                        A.ow_llp_city=B.ow_llp_city, A.ow_llp_landmark=B.ow_llp_landmark, 
                                        A.ow_llp_branch=B.ow_llp_branch, A.ow_llp_tel=B.ow_llp_tel, A.ow_llp_mob=B.ow_llp_mob, 
                                        A.ow_llp_contact=B.ow_llp_contact, A.ow_prt_comapny_name=B.ow_prt_comapny_name, 
                                        A.ow_prt_incopdate=B.ow_prt_incopdate, A.ow_prt_address=B.ow_prt_address, 
                                        A.ow_prt_country=B.ow_prt_country, A.ow_prt_pincode=B.ow_prt_pincode, 
                                        A.ow_prt_state=B.ow_prt_state, A.ow_prt_city=B.ow_prt_city, 
                                        A.ow_prt_landmark=B.ow_prt_landmark, A.ow_prt_branch=B.ow_prt_branch, 
                                        A.ow_prt_tel=B.ow_prt_tel, A.ow_prt_mob=B.ow_prt_mob, A.ow_prt_contact=B.ow_prt_contact, 
                                        A.ow_aop_comapny_name=B.ow_aop_comapny_name, A.ow_aop_incopdate=B.ow_aop_incopdate, 
                                        A.ow_aop_address=B.ow_aop_address, A.ow_aop_country=B.ow_aop_country, 
                                        A.ow_aop_pincode=B.ow_aop_pincode, A.ow_aop_state=B.ow_aop_state, 
                                        A.ow_aop_city=B.ow_aop_city, A.ow_aop_landmark=B.ow_aop_landmark, 
                                        A.ow_aop_branch=B.ow_aop_branch, A.ow_aop_tel=B.ow_aop_tel, A.ow_aop_mob=B.ow_aop_mob, 
                                        A.ow_aop_contact=B.ow_aop_contact, A.ow_trs_comapny_name=B.ow_trs_comapny_name, 
                                        A.ow_trs_incopdate=B.ow_trs_incopdate, A.ow_trs_address=B.ow_trs_address, 
                                        A.ow_trs_country=B.ow_trs_country, A.ow_trs_pincode=B.ow_trs_pincode, 
                                        A.ow_trs_state=B.ow_trs_state, A.ow_trs_city=B.ow_trs_city, 
                                        A.ow_trs_landmark=B.ow_trs_landmark, A.ow_trs_branch=B.ow_trs_branch, 
                                        A.ow_trs_tel=B.ow_trs_tel, A.ow_trs_mob=B.ow_trs_mob, A.ow_trs_contact=B.ow_trs_contact, 
                                        A.ow_status='$ow_status', A.ow_create_date=B.ow_create_date, A.ow_create_by=B.ow_create_by, 
                                        A.ow_modified_date=B.ow_modified_date, A.ow_modified_by=B.ow_modified_by, 
                                        A.ow_txnremarks='$ow_txnremarks', A.ow_approveddate='$modnow', 
                                        A.ow_approvedby='$curusr', A.ow_gid=B.ow_gid, 
                                        A.ow_rejectedby=B.ow_rejectedby, A.ow_rejecteddate=B.ow_rejecteddate, 
                                        A.ow_maker_remark=B.ow_maker_remark, 
                                        A.ow_proprietorship_comapny_name=B.ow_proprietorship_comapny_name, 
                                        A.ow_proprietorship_incopdate=B.ow_proprietorship_incopdate, 
                                        A.ow_proprietorship_address=B.ow_proprietorship_address, 
                                        A.ow_proprietorship_country=B.ow_proprietorship_country, 
                                        A.ow_proprietorship_pincode=B.ow_proprietorship_pincode, 
                                        A.ow_proprietorship_state=B.ow_proprietorship_state, 
                                        A.ow_proprietorship_city=B.ow_proprietorship_city, 
                                        A.ow_proprietorship_landmark=B.ow_proprietorship_landmark, 
                                        A.ow_proprietorship_branch=B.ow_proprietorship_branch, 
                                        A.ow_proprietorship_tel=B.ow_proprietorship_tel, 
                                        A.ow_proprietorship_mob=B.ow_proprietorship_mob, 
                                        A.ow_proprietorship_contact=B.ow_proprietorship_contact 
                                        WHERE B.ow_id = '$oid' and A.ow_id=B.ow_fkid");

                        $this->db->where('proprietorship_ow_id', $ow_fkid);
                        $this->db->delete('proprietorship_ownership_details');
                        $this->db->query("update proprietorship_ownership_details set proprietorship_ow_id = '$ow_fkid' WHERE proprietorship_ow_id = '$oid'");

                        $this->db->where('proprietorship_ow_id', $ow_fkid);
                        $this->db->delete('proprietorship_authorizedsignatory');
                        $this->db->query("update proprietorship_authorizedsignatory set proprietorship_ow_id = '$ow_fkid' WHERE proprietorship_ow_id = '$oid'");

                        // $this->db->where('doc_ow_id', $ow_fkid);
                        // $this->db->delete('owner_document_details');
                        // $this->db->query("update owner_document_details set doc_ow_id = '$ow_fkid' WHERE doc_ow_id = '$oid'");

                        $this->db->where('doc_ref_id', $ow_fkid);
                        $this->db->where('doc_ref_type', 'Owner_Proprietorship');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$ow_fkid' WHERE doc_ref_id = '$oid' and doc_ref_type = 'Owner_Proprietorship'");

                        $this->db->query("delete from owner_master WHERE ow_id = '$oid'");
                            
                        $logarray['table_id']=$ow_fkid;
                        $logarray['module_name']='Owners';
                        $logarray['cnt_name']='Owners';
                        $logarray['action']='Owners Record ' . $ow_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Owners');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    // public function add_new_doc($type='')
    // {
    //     $query=$this->db->query("select d_type, d_documentname as doc_name, d_description as doc_description, '' as doc_ref_no, 
    //                             '' as doc_doi, '' as doc_doe,'' as doc_document,'' as document_name, d_m_status from document_master 
    //                             where $type='Yes'");
    //     $result=$query->result();
    //     if(count($result)>0){
    //        $data['editcontdoc']=$result;
    //     }

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%ID Proof%' AND $type='Yes'");
    //     $result=$query->result();
    //     $data['id_proof_doc']=$result;

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Address Proof%' AND $type='Yes'");
    //     $result=$query->result();
    //     $data['address_proof_doc']=$result;

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Others%' AND $type='Yes'");
    //     $result=$query->result();
    //     $data['other_doc']=$result;

    //     return $data;
    // }

    // public function edit_view_doc($oid='',$type=''){
    //     $query=$this->db->query("select A.doc_id, A.d_type, A.d_documentname, A.d_description, A.doc_name, A.doc_description, A.doc_type, 
    //                             A.doc_ref_no, A.doc_doi, A.doc_doe, A.doc_document, B.d_m_status from 
    //                             (select doc_id, doc_type as d_type, doc_name as d_documentname, doc_description as d_description, doc_name, 
    //                             doc_description, doc_type, doc_ref_no, doc_doi, doc_doe, doc_document, 
    //                             document_name from owner_document_details where doc_ow_id='$oid' and doc_ow_type='$type' order by doc_id) A 
    //                             left join 
    //                             (SELECT * FROM document_master WHERE $type='Yes') B 
    //                             on(B.d_type like concat('%',A.doc_type,'%') and A.d_documentname = B.d_documentname)");
    //     $result=$query->result();
    //     if(count($result)>0) {
    //         $data['editcontdoc']=$result;
    //     } else {
    //         $query=$this->db->query("select d_type, d_documentname as doc_name, d_description as doc_description, '' as doc_ref_no, 
    //                                 '' as doc_doi, '' as doc_doe,'' as doc_document,'' as document_name, d_m_status from document_master 
    //                                 where $type='Yes'");

    //         // $query=$this->db->query("select A.d_type, A.d_documentname, A.d_description, A.d_m_status, B.doc_name, B.doc_description, B.doc_type, B.doc_ref_no, B.doc_doi, B.doc_doe, B.doc_document, B.document_name from 
    //         //                         (select d_type, d_documentname, d_description, d_m_status from document_master where $type='Yes' 
    //         //                         union all 
    //         //                         (select '' as d_type, '' as d_documentname, '' as d_description, '' as d_m_status from document_master limit 1)) A 
    //         //                         left join 
    //         //                         (select doc_name, doc_description, doc_type, doc_ref_no, doc_doi, doc_doe, doc_document, document_name from owner_document_details where doc_ow_id='$oid' and doc_ow_type='$type') B 
    //         //                         on A.d_type like concat('%',B.doc_type,'%')");
            
    //         $result=$query->result();
    //         if(count($result)>0) {
    //             $data['editcontdoc']=$result;
    //         }
    //     }

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%ID Proof%' and $type='Yes'");
    //     $result=$query->result();
    //     $data['id_proof_doc']=$result;

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Address Proof%' and $type='Yes'");
    //     $result=$query->result();
    //     $data['address_proof_doc']=$result;

    //     $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Others%' and $type='Yes'");
    //     $result=$query->result();
    //     $data['other_doc']=$result;

    //     return $data;
    // }

    // public function insert_doc($oid='', $type='', $rec_status='', $ow_status='') {
    //     // if ($ow_status!="Delete" || $rec_status=="Approved") {
    //         $query=$this->db->query("SELECT * FROM owner_document_details WHERE doc_ow_id = '$oid' and doc_ow_type = '$type'");
    //         $result=$query->result();
    //         $file_path_db=NULL;
    //         $file_path_count=0;

    //         for ($i=0; $i < count($result) ; $i++) { 
    //             $file_path_db[$i]['docname']=$result[$i]->doc_name;
    //             $file_path_db[$i]['docdesc']=$result[$i]->doc_description;
    //             $file_path_db[$i]['docrefno']=$result[$i]->doc_ref_no;
    //             $file_path_db[$i]['docdoi']=$result[$i]->doc_doi;
    //             $file_path_db[$i]['docdoe']=$result[$i]->doc_doe;
    //             $file_path_db[$i]['doctype']=$result[$i]->doc_type;
    //             $file_path_db[$i]['docpath']=$result[$i]->doc_document;
    //             $file_path_db[$i]['docfilename']=$result[$i]->document_name;
    //             $file_path_count=$i;
    //         }

    //         // print_r($file_path_db);

    //         // if ($rec_status!="Approved") {
    //             $this->db->where('doc_ow_id', $oid);
    //             $this->db->delete('owner_document_details');
    //         // }

    //         $docname=$this->input->post('doc_name[]');
    //         $doctype=$this->input->post('doc_type[]');
    //         $docdesc=$this->input->post('doc_desc[]');
    //         $docref=$this->input->post('ref_no[]');
    //         $docdoi=$this->input->post('date_issue[]');
    //         $docdoe=$this->input->post('date_expiry[]');

    //         $doccnt=0;

    //         for ($k=0; $k<count($docname); $k++) {
    //             if(isset($docname[$k]) and $docname[$k]!="") {
    //                 // $docname=str_replace('/', '_', $docname);
    //                 $docname[$k]=str_replace('/', '_', $docname[$k]);

    //                 if($docdoe[$k]=="") {
    //                     $doe = NULL;
    //                 } else {
    //                     $doe = FormatDate($docdoe[$k]);
    //                 }
                    
    //                 if($docdoi[$k]=="") {
    //                     $doi = NULL;
    //                 } else {
    //                     $doi = FormatDate($docdoi[$k]);
    //                 }
                    
    //                 $filePath='uploads/owners/';
    //                 $upload_path = './' . $filePath;
    //                 if(!is_dir($upload_path)) {
    //                     mkdir($upload_path, 0777, TRUE);
    //                 }

    //                 $do_type = substr($type, 6);

    //                 $filePath='uploads/owners/'.$do_type.'_'.$oid.'/';
    //                 $upload_path = './' . $filePath;
    //                 if(!is_dir($upload_path)) {
    //                     mkdir($upload_path, 0777, TRUE);
    //                 }

    //                 $confi['upload_path']=$upload_path;
    //                 $confi['allowed_types']='*';
    //                 $this->load->library('upload', $confi);
    //                 $extension="";

    //                 // $file_nm='doc_'.$k;
    //                 $file_nm='doc_'.$doccnt;

    //                 while (!isset($_FILES[$file_nm])) {
    //                     $doccnt = $doccnt + 1;
    //                     $file_nm = 'doc_'.$doccnt;
    //                 }

    //                 if(!empty($_FILES[$file_nm]['name'])) {
    //                     if($this->upload->do_upload($file_nm)) {
    //                         echo "Uploaded <br>";
    //                     } else {
    //                         echo "Failed<br>";
    //                         echo $this->upload->data();
    //                     }   

    //                     $upload_data=$this->upload->data();
    //                     $fileName=$upload_data['file_name'];
    //                     $extension=$upload_data['file_ext'];
                            
    //                     $data = array(
    //                         'doc_ow_id' => $oid,
    //                         'doc_type' => $doctype[$k],
    //                         'doc_name' => $docname[$k],
    //                         'doc_description' => $docdesc[$k],
    //                         'doc_ref_no' => $docref[$k],
    //                         'doc_doi' => $doi,
    //                         'doc_doe' => $doe,
    //                         'doc_document' => $filePath.$fileName,
    //                         'document_name' => $fileName,
    //                         'doc_ow_type' => $type,
    //                     );
    //                     $this->db->insert('owner_document_details', $data);
    //                     // echo '<script>alert("Main");</script>';
    //                     // echo "Main<br>";
    //                 } else {
    //                     if($file_path_count>=$k) {
    //                         $path=$file_path_db[$k]['docpath'];
    //                         $flnm=$file_path_db[$k]['docfilename'];
    //                     } else {
    //                         $path="";
    //                         $flnm="";
    //                     }
    //                     // echo '<script>alert("Other");</script>';
    //                     // echo "Other<br>";
    //                     $data = array(
    //                         'doc_ow_id' => $oid,
    //                         'doc_type' => $doctype[$k],
    //                         'doc_name' => $docname[$k],
    //                         'doc_description' => $docdesc[$k],
    //                         'doc_ref_no' => $docref[$k],
    //                         'doc_doi' => $doi,
    //                         'doc_doe' => $doe,
    //                         'doc_document' => $path,
    //                         'document_name' => $flnm,
    //                         'doc_ow_type' => $type,
    //                     );
    //                     $this->db->insert('owner_document_details', $data);
    //                 }
    //             }

    //             $doccnt = $doccnt + 1;
    //         }
    //         $file_path_db=NULL;
    //     // }

    //     return true;
    // }
	
	public function checkstatus($status=''){
        if($status=='InProcess'){
            $status='In Process';
            $cond="owner_master.ow_status='In Process'";
        } else if($status=='Pending'){
            $cond="(owner_master.ow_status='Pending' or owner_master.ow_status='Delete')";
        } else {
            $cond="owner_master.ow_status='$status'";
        }
        
		$roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Owner' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $gid=$this->session->userdata('groupid');
            if($status!='All'){
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid' and " . $cond . " ORDER BY ow_modified_date DESC, ow_id DESC");
            }
            else{
                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid' and ow_status!='Inactive' ORDER BY ow_modified_date DESC, ow_id DESC");
            }
            $result=$query->result();
            $data['owners']=$result;

            $data['ownergroup']=NULL;
            $data['ownername']=NULL;
            $data['editaction']=NULL;
            $test=NULL;
            for ($i=0; $i < count($result); $i++) { 
                if($result[$i]->ow_type==0) {
                    $data['ownergroup'][$i]='Individual';
                    $contid=$result[$i]->ow_ind_id;
                    $que=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$contid'");
                    $res=$que->result();
                    if(count($res)>0){
                        $data['ownername'][$i]=$res[0]->c_name;
                    } else {
                        $data['ownername'][$i]='';
                    }
                    $data['editaction'][$i]='view_individual';
                } else if ($result[$i]->ow_type == 1) {
                    $data['ownergroup'][$i]='HUF';
                    $data['ownername'][$i]=$result[$i]->ow_huf_name;
                    $data['editaction'][$i]='view_huf';
                } else if ($result[$i]->ow_type == 2) {
                    $data['ownergroup'][$i]='Pvt Ltd';
                    $data['ownername'][$i]=$result[$i]->ow_pvtltd_comapny_name;
                    $data['editaction'][$i]='view_pvtltd';
                } else if ($result[$i]->ow_type == 3) {
                    $data['ownergroup'][$i]='Ltd';
                    $data['ownername'][$i]=$result[$i]->ow_ltd_comapny_name;
                    $data['editaction'][$i]='view_ltd';
                } else if ($result[$i]->ow_type == 4) {
                    $data['ownergroup'][$i]='LLP';
                    $data['ownername'][$i]=$result[$i]->ow_llp_comapny_name;
                    $data['editaction'][$i]='view_llp';
                } else if ($result[$i]->ow_type == 5) {
                    $data['ownergroup'][$i]='Partnership';
                    $data['ownername'][$i]=$result[$i]->ow_prt_comapny_name;
                    $data['editaction'][$i]='view_partnership';
                } else if ($result[$i]->ow_type == 6) {
                    $data['ownergroup'][$i]='AOP';
                    $data['ownername'][$i]=$result[$i]->ow_aop_comapny_name;
                    $data['editaction'][$i]='view_aop';
                } else if ($result[$i]->ow_type == 7) {
                    $data['ownergroup'][$i]='Trust';
                    $data['ownername'][$i]=$result[$i]->ow_trs_comapny_name;
                    $data['editaction'][$i]='view_trust';
                } else if ($result[$i]->ow_type == 8) {
                    $data['ownergroup'][$i]='Proprietorship';
                    $data['ownername'][$i]=$result[$i]->ow_proprietorship_comapny_name;
                    $data['editaction'][$i]='view_proprietorship';
                } else {
                    
                }
            }

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid' And ow_status!='Inactive'");
            $result=$query->result();
            $data['all']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='In Process' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='Approved' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE (ow_status='Pending' or ow_status='Delete') AND ow_gid = '$gid'");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM owner_master WHERE ow_status='Rejected' AND ow_gid = '$gid'");
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('owners/owner_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

    function loadcity(){
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        $response=$this->owners_model->getCityList($term);
        echo json_encode($response);

    }
####load  autocomplete dropdown functions####
    function getStateCountryByCity(){
        $city_id=$this->input->post('state_id');
        $response=$this->owners_model->getStateCountryByCity($city_id);
        echo json_encode($response);
    }

    function loadcountry(){
        $text='t';
        $text=html_escape($this->input->get('term'));
        $response=$this->owners_model->loadcountry($text);
        echo json_encode($response);
    }

  function loadState(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->owners_model->loadState($text);
        echo json_encode($response);
    }

##########################################################################################################################
    
}
?>