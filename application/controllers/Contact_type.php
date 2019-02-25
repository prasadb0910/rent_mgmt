<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Contact_type extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->database();
    }

    //index function
    public function index(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;

                load_view('contacts/contact_type_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function saveRecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $curusr=$this->session->userdata('session_id');
                $now=date('Y-m-d');
                $data = array(
                    'contact_type' => $this->input->post('contact_type'),
                    'g_id' => $gid,
                    'created_by' => $curusr,
                    'created_date' => $now
                );

                $this->db->insert('contact_type_master',$data);

                $logarray['table_id']=$this->db->insert_id();
                $logarray['module_name']='Related Party Type';
                $logarray['cnt_name']='contact_type';
                $logarray['action']='Related Party Type Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Contact_type');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function deleteRecord($contact_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $this->db->where('id',$contact_type_id);
                $this->db->delete('contact_type_master');

                $logarray['table_id']=$contact_type_id;
                $logarray['module_name']='Related Party Type';
                $logarray['cnt_name']='contact_type';
                $logarray['action']='Related Party Record Deleted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                redirect(base_url().'index.php/Contact_type/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($contact_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM contact_type_master WHERE id='$contact_type_id'");
                $result=$query->result();
                $data['edit_contact_type']=$result;

                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;

                $data['contact_type_id']=$contact_type_id;
                load_view('contacts/contact_type_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function updateRecord($contact_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $gid=$this->session->userdata('groupid');
                $curusr=$this->session->userdata('session_id');
                $now=date('Y-m-d');
                $data = array(
                    'contact_type' => $this->input->post('contact_type'),
                    'g_id' => $gid,
                    'modified_by' => $curusr,
                    'modified_date' => $now
                );
                
                $this->db->where('id',$contact_type_id);
                $this->db->update('contact_type_master',$data);

                $logarray['table_id']=$contact_type_id;
                $logarray['module_name']='Related Party Type';
                $logarray['cnt_name']='contact_type';
                $logarray['action']='Related Party Record Updated';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                redirect(base_url().'index.php/Contact_type/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function checkContactTypeAvailability() {
        $gid=$this->session->userdata('groupid');
        $id = html_escape($this->input->post('contact_type_id'));
        $contact_type = html_escape($this->input->post('contact_type'));

        $query = $this->db->query("SELECT * FROM contact_type_master WHERE id != '$id' AND g_id = '$gid' AND contact_type = '$contact_type'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
?>