<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class City_master extends CI_controller{

	 function __construct(){
		parent :: __construct();
        $this->load->helper('common_functions');
		$this->load->model('city_master_model');
	}

	function index(){
		$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $result[0]->r_export=1;
                $data['access']=$result;
    			$data['city_details']=$this->city_master_model->getCityDetails();
    			load_view('city_master/city_master_list',$data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

	function  city_edit(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $data['state_list']=$this->city_master_model->getStateList();

                // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
                // $result=$query->result();
                // if(count($result)>0) {
                //     if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                //         $data['access']=$result;

        				$city_id=$this->uri->segment(3);
        				if($city_id !=''){
        				$data['city_details']=$this->city_master_model->getCityDetails($city_id);
        				}
        				$data['action']='edit_insert';
        				//print_r($data);
        				load_view('city_master/city_master_list',$data);
                //     // } else {
                //     //     echo "Unauthorized access";
                //     // }
                // } else {
                //     echo 'You donot have access to this page';
                // }
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

	function city_view(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
                // $result=$query->result();
                // if(count($result)>0) {
                //     if($result[0]->r_view==1 ) {
                //         $data['access']=$result;

                        $city_id=$this->uri->segment(3);
                        $data['city_details']=$this->city_master_model->getCityDetails($city_id);
        				
        				$data['action']='view';

        				load_view('city_master/city_master_view',$data);
                //     } else {
                //         echo "Unauthorized access";
                //     }
                // } else {
                //     echo 'You donot have access to this page';
                // }
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

	function insertUpdateRecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
        		$response=$this->city_master_model->insertUpdateRecord();
        	
		load_view('city_master/city_master_list',$data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

    function delete_record(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $response=$this->city_master_model->delete_record();
                redirect('city_master','refresh');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    function checkTaxNameAvailability() {
        $tax_id = html_escape($this->input->post('tax_id'));
        $tax_name = html_escape($this->input->post('tax_name'));

        $query = $this->db->query("SELECT * FROM tax_master WHERE tax_id != '$tax_id' AND tax_name = '$tax_name'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }


}
?>