<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Document_type_master extends CI_Controller
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $result[0]->r_export=1;
                $data['access']=$result;
                $query=$this->db->query("SELECT * FROM document_type_master order by d_type_add_date desc");
                $result=$query->result();
                $data['document_type']=$result;
                load_view('document_type_master/document_type_list', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function addDocumentType() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                load_view_without_data('document_type_master/document_type_master');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function viewDocumentType($d_type_id) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM document_type_master WHERE d_type_id='$d_type_id'");
                $result=$query->result();
                $data['document_type']=$result;

                load_view('document_type_master/document_type_view',$data);
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d H:i:s');

                $data = array(
                    'd_type' => $this->input->post('d_type'),
                    'd_m_status' => $this->input->post('d_m_status'),
                    'd_type_add_date' => $now,
                    'd_type_gid' => $this->session->userdata('groupid')
                );

                $this->db->insert('document_type_master',$data);
                redirect(base_url().'index.php/document_type_master');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($d_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM document_type_master WHERE d_type_id='$d_type_id'");
                $result=$query->result();
                $data['document_type']=$result;

                $data['d_type_id']=$d_type_id;
                load_view('document_type_master/document_type_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateRecord($d_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d H:i:s');

                $data = array(
                    'd_type' => $this->input->post('d_type'),
                    'd_m_status' => $this->input->post('d_m_status'),
                    'd_type_add_date' => $now,
                    'd_type_gid' => $this->session->userdata('groupid')
                );

                $this->db->where('d_type_id',$d_type_id);
                $this->db->update('document_type_master',$data);
                redirect(base_url().'index.php/document_type_master');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function checkDocumentAvailability() {
        $d_type_id = html_escape($this->input->post('d_type_id'));
        $d_type = html_escape($this->input->post('d_type'));

        $query = $this->db->query("SELECT * FROM document_type_master WHERE d_type_id != '$d_type_id' AND d_type = '$d_type'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteRecord($d_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'DocumentTypeMaster' AND role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $this->db->where('d_type_id',$d_type_id);
                $this->db->delete('document_type_master');
                redirect(base_url().'index.php/document_type_master');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
}
?>