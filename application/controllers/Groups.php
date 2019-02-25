<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Groups extends CI_Controller 
{

    public function __construct()
    {
        // parent::MY_Controller();
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('group_model');
        $this->load->model('contact_model');
        $this->load->helper('string');
        
        // $this->load->database();
    }

    //index function
    public function index(){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $query=$this->db->query("SELECT * FROM group_master ORDER BY modified_date DESC");
            $result=$query->result();
            $data['group']=$result;
            $data['users']=NULL;
            for ($i=0; $i < count($result); $i++) { 
                $gid=$result[$i]->g_id;
                $query=$this->db->query("SELECT concat(B.c_name, ' ', B.c_last_name) as gu_name FROM group_users A, contact_master B 
                                        WHERE A.gu_gid='$gid' AND A.assigned_role='1' AND A.gu_cid=B.c_id AND A.created_by='0' order by A.gu_id asc");
                $result1=$query->result();
                if(count($result1)>0) {
                    $data['owners'][$i]=$result1[0]->gu_name;
                } else {
                    $data['owners'][$i]='';
                }
            }

            load_view("groups/group_list", $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function add_Group(){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='0' and c_status='Approved' order by c_name asc");
            $result=$query->result();
            $data['contacts']=$result;
            
            $query=$this->db->query("SELECT * FROM user_role_master WHERE g_id='0' and r_status='Active' order by role_name");
            $result=$query->result();
            $data['roles']=$result;
            
            load_view("groups/group_details", $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function usertest(){
        $admincnt=$this->input->post('groupadmin[]');
        $usrname=$this->input->post('groupusername[]');
        $designation=$this->input->post('groupdesignation[]');
        $mobile=$this->input->post('groupmobile[]');
        $email=$this->input->post('groupemail[]');

        echo "Count of input: ".count($usrname)."<br>";
        echo "Count of checks: ".count($admincnt)."<br>";
        print_r($admincnt);
        $ac=0;
        $tyu=NULL;
        $flg=false;
        echo count($tyu).'Bleh';
        for ($j=0; $j < count($usrname) ; $j++) { 
            $urole="User";
            if($admincnt[$ac]==$j) {
                if($flg==false) {
                    $urole="Admin";
                    $tyu[$ac]='As';
                    if(count($admincnt)==count($tyu)){
                        $flg==true;
                    } else {
                        $ac++;
                    }
                }
            }
            
            echo $urole;
        }
        print_r($tyu);
        echo count($tyu);

    }

    public function save_Group(){
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $now=date('Y-m-d H:i:s');

            $g_name = $this->input->post('group_name');

            $data = array(
                    'group_name' => $this->input->post('group_name') ,
                    'group_status' => 'Active' ,
                    'create_date' => $now,
                    'created_by' => $curusr,
                    'modified_date' => $now,
                );

            $this->db->insert('group_master', $data);
            $gid=$this->db->insert_id();
            
            $usrname=$this->input->post('groupusername[]');
            $usrlastname=$this->input->post('groupuserlastname[]');
            $designation=$this->input->post('groupdesignation[]');
            $mobile=$this->input->post('groupmobile[]');
            $email=$this->input->post('groupemail[]');

            $admcntr=0;
            $ac=0;
            $tyu=NULL;
            $flg=false;
            $assigned_role=null;

           for ($i=0; $i < count($usrname); $i++) {
                $data = array(
                    'c_name' => $usrname[$i] ,
                    'c_last_name' => $usrlastname[$i] ,
                    'c_gid' => $gid,
                    'c_designation' => $designation[$i],
                    'c_emailid1' => $email[$i],
                    'c_mobile1' => $mobile[$i],
                    'c_createdate' => $now,
                    'c_createdby' => $curusr,
                    'c_status' => 'Approved',
                    'c_modifieddate' => $now
                );

                $this->db->insert('contact_master', $data);
                $cid=$this->db->insert_id();

                $query = $this->db->query("select * from group_users where gu_email = '" . $email[$i] . "' and gu_gid = '" . $gid . "'");
                if ($query->num_rows()==0) {
                    $urole="Admin";
                    $assigned_role=1;
                    $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));

                    $data = array (
                        'gu_gid' => $gid ,
                        // 'gu_name' => $usrname[$i],
                        // 'gu_designation' => $designation[$i],
                        // 'gu_mobile' => $mobile[$i],
                        'gu_email' => $email[$i],
                        // 'gu_password' => md5('Pass@123'),
                        'gu_password' => $password,
                        'gu_role' => $urole,
                        'add_date' => $now,
                        'gu_cid' => $cid,
                        'assigned_status' => 'Approved',
                        'assigned_role' => $assigned_role,
                        'created_at' => $now,
                        'created_by' => $curusr,
                        'updated_at' => $now,
                        'updated_by' => $curusr,
                        'user_type' => 'owner',
                        'name' => $usrname[$i]
                    );

                    $this->db->insert('group_users', $data);
                    $this->group_model->send_password($g_name, $email[$i], 'Pass@123');
                }
            }


            $userid=$this->input->post('userid[]');
            $userroleid=$this->input->post('userroleid[]');

            for ($i=0; $i < count($userid); $i++) {
                if($userid[$i]!='') {
                    $password='';

                    $query=$this->db->query("SELECT * FROM group_users WHERE gu_cid = '" . $userid[$i] . "'");
                    $result=$query->result();
                    if (count($result)>0) {
                        $password = $result[0]->gu_password;
                    } else {
                        // $password = md5('Pass@123');
                        $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                    }
                    
                    $sql = "select * from user_role_master where rl_id = '" . $userroleid[$i] . "' and r_status = 'Active'";
                    $query = $this->db->query($sql);
                    $result=$query->result();
            
                    if (count($result)>0) {
                        $gu_role = $result[0]->role_name;
                        $assigned_role = $result[0]->rl_id;
                    } else {
                        $gu_role = '';
                        $assigned_role = '';
                    }

                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '" . $userid[$i] . "'");
                    $result=$query->result();

                    if (count($result)>0) {
                        $email_id = $result[0]->c_emailid1;

                        $query = $this->db->query("select * from group_users where gu_email = '" . $email_id . "' and gu_gid = '" . $gid . "'");
                        if ($query->num_rows()==0) {
                            $data = array (
                                'gu_gid' => $gid ,
                                // 'gu_name' => $result[0]->c_name,
                                // 'gu_designation' => $result[0]->c_designation,
                                // 'gu_mobile' => $result[0]->c_mobile1,
                                'gu_email' => $result[0]->c_emailid1,
                                'gu_password' => $password,
                                'gu_role' => $gu_role,
                                'add_date' => $now,
                                'gu_cid' => $result[0]->c_id,
                                'assigned_status' => 'Approved',
                                'assigned_role' => $assigned_role,
                                'created_at' => $now,
                                'created_by' => $curusr,
                                'updated_at' => $now,
                                'updated_by' => $curusr,
                                'user_type' => 'user',
                                'name' => $result[0]->c_name
                            );

                            $this->db->insert('group_users', $data);

                            $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                            $this->group_model->send_assign_group_email($g_name, $result[0]->c_emailid1, $password, $gu_role);
                        }
                    }
                }
            }
           redirect(base_url().'index.php/Groups');
       } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
       }
    }

    public function view($gid) {
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            
            $query=$this->db->query("SELECT * FROM group_master WHERE g_id='$gid'");
            $result=$query->result();
            $data['group']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='$gid' and c_createdby='0' and c_status = 'Approved'");
            $result=$query->result();
            $data['contact']=$result;

            $data['groupUsr']=NULL;
            $incrcntr=0;
            for ($i=0; $i < count($result); $i++) { 
                $contid=$result[$i]->c_id;
                $query=$this->db->query("SELECT * FROM group_users WHERE gu_cid='$contid' and assigned_status != 'Inactive'");
                $result1=$query->result();
                if ($query->num_rows()>0) {
                    $data['groupUsr'][$incrcntr]=$contid;  
                    $incrcntr++;
                }
            }
            
            // $query=$this->db->query("select A.gu_id, A.gu_cid, A.assigned_role, B.c_name, B.c_last_name, A.gu_role, B.c_emailid1, B.c_mobile1,B.c_gid from group_users A, contact_master B where A.gu_gid = '$gid' and A.gu_cid = B.c_id and A.assigned_role != '1' ");
            // $result=$query->result();
            // $data['group_users']=$result;

            $query=$this->db->query("select A.gu_id, A.gu_cid, A.assigned_role, B.c_name, B.c_last_name, A.gu_role, B.c_emailid1, B.c_mobile1,B.c_gid from group_users A, contact_master B where A.gu_gid = '$gid' and A.gu_cid = B.c_id and B.c_gid = '0' and B.c_createdby='0' and A.assigned_status != 'Inactive'");
            $result=$query->result();
            $data['software_developer_users']=$result;

            $query=$this->db->query("select A.gu_id, A.gu_cid, A.assigned_role, B.c_name, B.c_last_name, A.gu_role, B.c_emailid1, B.c_mobile1,B.c_gid from group_users A, contact_master B where A.gu_gid = '$gid' and A.gu_cid = B.c_id and B.c_gid = '$gid' and B.c_createdby != '0' and A.assigned_status = 'Inactive'");
            $result=$query->result();
            $data['group_admin_users']=$result;

            $query=$this->db->query("SELECT *  FROM contact_master where c_status != 'Inactive' order by c_name asc");//WHERE c_gid='0'
            $result=$query->result();
            $data['contacts']=$result;
            
            $query=$this->db->query("SELECT * FROM user_role_master WHERE g_id='0' and r_status='Active'");
            $result=$query->result();
            $data['roles']=$result;
            
            $data['group_id']=$gid;
            
            load_view("groups/group_view", $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($gid){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $data['access']=$result;
            
                $query=$this->db->query("SELECT * FROM group_master WHERE g_id='$gid'");
                $result=$query->result();
                $data['group']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='$gid' and c_createdby='0' and c_status = 'Approved'");
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("SELECT * FROM group_users WHERE gu_gid='$gid' and assigned_role='1' and assigned_status != 'Inactive'");
                $result1=$query->result();
                if(count($result1)>0) {
                    $data['groupUsr']=$result1;
                }
                
                $query=$this->db->query("select A.gu_id, A.gu_cid, A.assigned_role, B.c_name, B.c_last_name, A.gu_role, B.c_emailid1, B.c_mobile1 from group_users A, contact_master B where A.gu_gid = '$gid' and A.gu_cid = B.c_id and B.c_gid = '0' and A.created_by='0' and A.assigned_status != 'Inactive'");
                $result=$query->result();
                $data['group_users']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='0' and c_status != 'Inactive' order by c_name asc");
                $result=$query->result();
                $data['contacts']=$result;
                
                $query=$this->db->query("SELECT * FROM user_role_master WHERE g_id='0' and r_status='Active' order by role_name");
                $result=$query->result();
                $data['roles']=$result;
                
                $data['group_id']=$gid;

                load_view('groups/group_details',$data);
            } else { 
                echo 'Unauthorized access'; 
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saveEdit($gid){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1) {
                
                if($this->updateGroup($gid, $result)){
                    redirect(base_url().'index.php/Groups');
                }
                
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo 'You donot have access to this page.';
        }
    }

    public function editGroup($gid){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Groups' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1) {
                
                if($this->updateGroup($gid, $result)){
                    echo 1;
                }
                
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateGroup($gid, $result) {
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $g_name = $this->input->post('group_name');

        $data['access']=$result;
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $data = array(
                    'group_name' => $this->input->post('group_name') ,
                    'group_status' => $this->input->post('group_status') ,
                    // 'txn_remarks' => $this->input->post('txn_remarks') ,
                    'modified_date' => $modnow,
                    'modified_by' => $curusr,
                );
        $this->db->where('g_id',$gid);
        $this->db->update('group_master', $data);
        
        $usrid=$this->input->post('groupuserid[]');
        $usrname=$this->input->post('groupusername[]');
        $usrlastname=$this->input->post('groupuserlastname[]');
        $designation=$this->input->post('groupdesignation[]');
        $mobile=$this->input->post('groupmobile[]');
        $email=$this->input->post('groupemail[]');

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='$gid' and c_createdby='0'");
        $result=$query->result();
        if(count($result)>0){
            for ($i=0; $i < count($result) ; $i++) {
                $user_exist = false;
                $c_id = $result[$i]->c_id;
                for ($j=0; $j < count($usrname) ; $j++) {
                    if($c_id==$usrid[$j]){
                        $user_exist = true;
                    }
                }
                if($user_exist == false){
                    $sql="update contact_master set c_status = 'Inactive' where c_gid = '$gid' and c_id = '$c_id'";
                    $this->db->query($sql);
                    $sql="update group_users set assigned_status = 'Inactive' where gu_gid = '$gid' and gu_cid = '$c_id'";
                    $this->db->query($sql);
                }
            }
        }

        for ($i=0; $i < count($usrname) ; $i++) { 
            $data = array(
                        'c_id' => $usrid[$i] ,
                        'c_name' => $usrname[$i] ,
                        'c_last_name' => $usrlastname[$i] ,
                        'c_gid' => $gid,
                        'c_designation' => $designation[$i],
                        'c_emailid1' => $email[$i],
                        'c_mobile1' => $mobile[$i],
                        'c_status' => 'Approved'
                    );

            if($usrid[$i]!="") {
                $data['c_modifieddate'] = $now;
                $data['c_modifiedby'] = $curusr;

                $this->db->where('c_id',$usrid[$i]);
                $this->db->update('contact_master', $data);
                $cid=$usrid[$i];
            } else {
                $data['c_createdate'] = $now;
                $data['c_createdby'] = $curusr;
                $data['c_modifieddate'] = $now;
                $data['c_modifiedby'] = $curusr;

                $this->db->insert('contact_master', $data);
                $cid=$this->db->insert_id();
            }

            $urole="Admin";
            $assigned_role=1;
            $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));

            $data = array(
                        'gu_gid' => $gid ,
                        // 'gu_name' => $usrname[$i],
                        // 'gu_designation' => $designation[$i],
                        // 'gu_mobile' => $mobile[$i],
                        'gu_email' => $email[$i],
                        // 'gu_password' => md5('Pass@123'),
                        'gu_password' => $password,
                        'gu_role' => $urole,
                        'add_date' => $now,
                        'gu_cid' => $cid,
                        'assigned_status' => 'Approved',
                        'assigned_role' => $assigned_role,
                        'user_type' => 'owner',
                        'name' => $usrname[$i]
                    );

            if($usrid[$i]!="") {
                $data['updated_at'] = $now;
                $data['updated_by'] = $curusr;

                $this->db->where('gu_cid',$cid);
                $this->db->where('gu_gid',$gid);
                $this->db->update('group_users', $data);
            } else {
                $data['created_at'] = $now;
                $data['created_by'] = $curusr;
                $data['updated_at'] = $now;
                $data['updated_by'] = $curusr;

                $this->db->insert('group_users', $data);
                $this->group_model->send_password($g_name, $email[$i], 'Pass@123');
            }

            // $query = $this->db->query("select * from group_users where gu_email = '" . $email[$i] . "' and gu_gid = '" . $gid . "'");
            // if ($query->num_rows()==0) {
            //     $urole="Admin";
            //     $assigned_role=1;

            //     $data = array(
            //                 'gu_gid' => $gid ,
            //                 // 'gu_name' => $usrname[$i],
            //                 // 'gu_designation' => $designation[$i],
            //                 // 'gu_mobile' => $mobile[$i],
            //                 'gu_email' => $email[$i],
            //                 'gu_password' => 'Pass@123',
            //                 'gu_role' => $urole,
            //                 'add_date' => $now,
            //                 'gu_cid' => $cid,
            //                 'assigned_status' => 'Approved',
            //                 'assigned_role' => $assigned_role,
            //                 'created_at' => $now,
            //                 'created_by' => $curusr,
            //                 'updated_at' => $now,
            //                 'updated_by' => $curusr
            //             );

            //     $this->db->insert('group_users', $data);
            //     $this->group_model->send_password($usrname[$i], $email[$i], 'Pass@123');
            // }
        }

        $gu_id=$this->input->post('gu_id[]');
        $userid=$this->input->post('userid[]');
        $userroleid=$this->input->post('userroleid[]');

        $query=$this->db->query("select A.gu_id, A.gu_cid, A.assigned_role, B.c_name, B.c_last_name, A.gu_role, B.c_emailid1, B.c_mobile1 from group_users A, contact_master B where A.gu_gid = '$gid' and A.gu_cid = B.c_id and B.c_gid = '0' and A.created_by='0'");
        $result=$query->result();
        if(count($result)>0){
            for ($i=0; $i < count($result) ; $i++) {
                $user_exist = false;
                $user_id = $result[$i]->gu_id;
                for ($j=0; $j < count($gu_id) ; $j++) {
                    if($user_id==$gu_id[$j]){
                        $user_exist = true;
                    }
                }
                if($user_exist == false){
                    $sql="update group_users set assigned_status = 'Inactive' where gu_id = '$user_id'";
                    $this->db->query($sql);
                }
            }
        }

        for ($i=0; $i < count($userid); $i++) {
            if($userid[$i]!='') {
                if($gu_id[$i]=="") {
                    $password='';

                    $query=$this->db->query("SELECT * FROM group_users WHERE gu_cid = '" . $userid[$i] . "'");
                    $result=$query->result();
                    if (count($result)>0) {
                        $password = $result[0]->gu_password;
                    } else {
                        // $password = md5('Pass@123');
                        $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                    }
                    
                    $sql = "select * from user_role_master where rl_id = '" . $userroleid[$i] . "' and r_status = 'Active'";
                    $query = $this->db->query($sql);
                    $result=$query->result();
            
                    if (count($result)>0) {
                        $gu_role = $result[0]->role_name;
                        $assigned_role = $result[0]->rl_id;
                    } else {
                        $gu_role = '';
                        $assigned_role = '';
                    }

                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '" . $userid[$i] . "'");
                    $result=$query->result();

                    if (count($result)>0) {
                        $data = array (
                            'gu_gid' => $gid ,
                            // 'gu_name' => $result[0]->c_name,
                            // 'gu_designation' => $result[0]->c_designation,
                            // 'gu_mobile' => $result[0]->c_mobile1,
                            'gu_email' => $result[0]->c_emailid1,
                            'gu_password' => $password,
                            'gu_role' => $gu_role,
                            'add_date' => $now,
                            'gu_cid' => $result[0]->c_id,
                            'assigned_status' => 'Approved',
                            'assigned_role' => $assigned_role,
                            'created_at' => $now,
                            'created_by' => $curusr,
                            'updated_at' => $now,
                            'updated_by' => $curusr,
                            'user_type' => 'user',
                            'name' => $result[0]->c_name
                        );
                    }

                    $this->db->insert('group_users', $data);

                    $this->group_model->send_assign_group_email($g_name, $result[0]->c_emailid1, 'Pass@123', $gu_role);
                } else {
                    $password='';

                    $query=$this->db->query("SELECT * FROM group_users WHERE gu_id = '" . $gu_id[$i] . "'");
                    $result=$query->result();
                    if (count($result)>0) {
                        $gu_email = $result[0]->gu_email;
                        $password = $result[0]->gu_password;
                    } else {
                        $gu_email = '';
                        // $password = md5('Pass@123');
                        $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                    }
                    
                    $sql = "select * from user_role_master where rl_id = '" . $userroleid[$i] . "' and r_status = 'Active'";
                    $query = $this->db->query($sql);
                    $result=$query->result();
            
                    if (count($result)>0) {
                        $gu_role = $result[0]->role_name;
                        $assigned_role = $result[0]->rl_id;
                    } else {
                        $gu_role = '';
                        $assigned_role = '';
                    }

                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '" . $userid[$i] . "'");
                    $result=$query->result();

                    if (count($result)>0) {
                        $data = array (
                            'gu_gid' => $gid ,
                            // 'gu_name' => $result[0]->c_name,
                            // 'gu_designation' => $result[0]->c_designation,
                            // 'gu_mobile' => $result[0]->c_mobile1,
                            'gu_email' => $result[0]->c_emailid1,
                            'gu_password' => $password,
                            'gu_role' => $gu_role,
                            'add_date' => $now,
                            'gu_cid' => $result[0]->c_id,
                            'assigned_status' => 'Approved',
                            'assigned_role' => $assigned_role,
                            'updated_by' => $curusr,
                            'updated_at' => $now,
                            'user_type' => 'user',
                            'name' => $result[0]->c_name
                        );
                    }

                    $this->db->where('gu_id', $gu_id[$i]);
                    $this->db->update('group_users', $data);

                    if ($gu_email!=$result[0]->c_emailid1) {
                        $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                        $this->group_model->send_assign_group_email($g_name, $result[0]->c_emailid1, $password, $gu_role);
                    }
                }
            }
        }

        return 1;
    }


    public function approverecord($gid) {
            $curusr=$this->session->userdata('session_id');
           $modnow=date('Y-m-d H:i:s');
           $data = array(
                    'txn_status' => $this->input->post('txn_status'),
                    'txn_remarks' => $this->input->post('status_remarks'),
                    'approved_by' => $curusr,
                    'approved_date' => $modnow,
                 );
                $this->db->where('g_id',$gid);
                $this->db->update('group_master', $data);
               redirect(base_url().'index.php/Groups');
    }
    
    public function checkstatus($status=''){
        if($status=='InProcess'){
            $status='In Process';
            $cond="contact_master.c_status='In Process'";
        } else if($status=='Pending'){
            $cond="(contact_master.c_status='Pending' or contact_master.c_status='Delete')";
        } else {
            $cond="contact_master.c_status='$status'";
        }
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $gid=$this->session->userdata('groupid');

            if($status!='All')
            {
                $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and " . $cond . " ORDER BY contact_master.c_modifieddate DESC");
            }
            else {
                $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and contact_master.c_status!='Inactive' ORDER BY contact_master.c_modifieddate DESC");
            }
            $result=$query->result();
            $data['contacts']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='In Process' AND c_gid='$gid'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Approved' AND c_gid='$gid'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE (c_status='Pending' or c_status='Delete') AND c_gid='$gid'");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Rejected' AND c_gid='$gid'");
            $result=$query->result();
            $data['rejected']=$result;

            load_view('contacts/contact_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function check_contact_availablity() {
        $gid = html_escape($this->input->post('groupid'));
        $groupuserid = html_escape($this->input->post('groupuserid'));
        $groupusername = html_escape($this->input->post('groupusername'));
        $groupuserlastname = html_escape($this->input->post('groupuserlastname'));
        $groupemail = html_escape($this->input->post('groupemail'));
        $groupmobile = html_escape($this->input->post('groupmobile'));

        $result = $this->group_model->check_contact_availablity($gid, $groupuserid, $groupusername, $groupuserlastname, $groupemail, $groupmobile);
        echo $result;
    }

    function check_email_availablity() {
        $gid = html_escape($this->input->post('groupid'));
        $groupemail = html_escape($this->input->post('groupemail'));

        // $gid = '6';
        // $groupemail = 'email@email.com';

        $result = $this->group_model->check_email_availablity($gid, $groupemail);
        echo $result;
    }

    function check_group_user_availablity() {
        $gid = html_escape($this->input->post('groupid'));
        $guid = html_escape($this->input->post('guid'));
        $emailid = html_escape($this->input->post('emailid'));

        // $gid = '19';
        // $guid = '123';
        // $emailid = 'swapnil.darekar1@otbconsulting.co';

        $result = $this->group_model->check_group_user_availablity($gid, $guid, $emailid);

        // $data['result'] = $result;
        // echo json_encode($data);

        echo $result;
    }

    function check_user_availablity() {
        $gid = html_escape($this->input->post('groupid'));
        $guid = html_escape($this->input->post('guid'));
        $userid = html_escape($this->input->post('userid'));

        // $gid = '';
        // $guid = '';
        // $userid = '34';

        $this->db->select('*');
        $this->db->where('c_id', $userid);
        $this->db->from('contact_master');
        $query = $this->db->get();
        $result = $query->result();
        if( count($result) > 0 ){
            $c_emailid1 = $result[0]->c_emailid1;
        }else{
            $c_emailid1 = '';
        }

        $result = $this->group_model->check_user_availablity($gid, $guid, $c_emailid1);

        $data['email_id'] = $c_emailid1;
        $data['result'] = $result;

        echo json_encode($data);
    }

    function check_group_availablity() {
        $g_id = html_escape($this->input->post('g_id'));
        $group_name = html_escape($this->input->post('group_name'));

        // $group_name = "Swapnil";

        $result = $this->group_model->check_group_availablity($g_id, $group_name);
        echo $result;
    }

    public function send_otp() {
        $email_id = html_escape($this->input->post('email_id'));
        $otp = random_string('numeric', 6);
        $now=date('Y-m-d H:i:s');

        $this->db->query("Insert into otp_details (email_id, otp, created_date) values ('$email_id', '$otp', '$now')");

        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $to_email = 'siddarth@pecanadvisors.com';
        $subject = 'OTP for property management';
        $message = '<html><head></head><body>Hi,<br /><br />' .
                    'OTP: ' . $otp .
                    '<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        echo $mailSent;
    }

    public function checkOTP(){
        $email_id = html_escape($this->input->post('otp_email_id'));
        $otp = html_escape($this->input->post('otp'));

        $sql = "select * from otp_details where email_id = '" . $email_id . "' and " . 
               "created_date > DATE_SUB(now(),INTERVAL '5' MINUTE) and otp = '" . $otp . "' and " . 
               "id = (select max(id) from otp_details where email_id = '" . $email_id . "')";
        $query = $this->db->query($sql);
        if( $query->num_rows() > 0 ){
            echo 1;
        }else{
            echo 0;
        }
    }
}
?>