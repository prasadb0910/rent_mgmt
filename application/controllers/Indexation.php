<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Indexation extends CI_Controller
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Indexation' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM indexation_master order by i_id desc");
                $result=$query->result();
                $data['indexation']=$result;

                load_view('sale/indexation_master', $data);
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Indexation' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d');
                $data = array(
                    'i_financial_year' => $this->input->post('financial_year'),
                    'i_cost_inflation_index' => $this->input->post('cost_inflation_index'),
                    'i_add_date' => $now,
                );

                $this->db->insert('indexation_master',$data);
        		$logarray['table_id']=$this->db->insert_id();
        		$logarray['module_name']='Indexation';
        		$logarray['cnt_name']='Indexation';
        		$logarray['action']='Indexation Record Inserted';
        		$logarray['gp_id']='0';
        		$this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Indexation');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function deleteRecord($iid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Indexation' AND role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $this->db->where('i_id',$iid);
                $this->db->delete('indexation_master');
        		$logarray['table_id']=$iid;
        		$logarray['module_name']='Indexation';
        		$logarray['cnt_name']='Indexation';
        		$logarray['action']='Indexation Record Deleted';
        		$logarray['gp_id']='0';
        		$this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Indexation/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($iid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Indexation' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM indexation_master WHERE i_id='$iid'");
                $result=$query->result();
                $data['editindexation']=$result;

                $query=$this->db->query("SELECT * FROM indexation_master order by i_id desc");
                $result=$query->result();
                $data['indexation']=$result;

                $data['i_id']=$iid;
                load_view('sale/indexation_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function updateRecord($iid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Indexation' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d');
                $data = array(
                    'i_financial_year' => $this->input->post('financial_year'),
                    'i_cost_inflation_index' => $this->input->post('cost_inflation_index'),
                    'i_add_date' => $now,
                );
                
                $this->db->where('i_id',$iid);
                $this->db->update('indexation_master',$data);
        		$logarray['table_id']=$iid;
        		$logarray['module_name']='Indexation';
        		$logarray['cnt_name']='Indexation';
        		$logarray['action']='Indexation Record Updated';
        		$logarray['gp_id']='0';
        		$this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Indexation/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        
    }

    function checkIndexYearAvailability() {
        $i_id = html_escape($this->input->post('i_id'));
        $financial_year = html_escape($this->input->post('financial_year'));

        $query = $this->db->query("SELECT * FROM indexation_master WHERE i_id != '$i_id' AND i_financial_year = '$financial_year'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
?>