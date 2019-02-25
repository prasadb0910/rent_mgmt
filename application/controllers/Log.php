<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Log extends CI_Controller
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Log' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $sql = "select AA.*, BB.cnt_name, BB.ref_id, BB.ref_name from 

                        (select C.*, case when user_id = '0' then 'Software Developer' else D.c_emailid1 end as gu_email from 
                        (select A.*, case when gp_id = '0' then 'Software Developer' else B.group_name end as group_name from 
                        (select * from user_access_log) A 
                        left join 
                        (select * from group_master) B 
                        on (A.gp_id = B.g_id)) C 
                        left join 
                        (select * from contact_master) D 
                        on (C.user_id = D.c_id)) AA 

                        left join

                        (select 'Contact' as module_name, 'contacts' as cnt_name, c_id as ref_id, concat(ifnull(c_name,''), ' ', ifnull(c_last_name,'')) as ref_name, c_gid as group_id from contact_master 
                        union all 
                        select 'Owner' as module_name, 'Owners' as cnt_name, ow_id as ref_id, 
                                case when ow_type = '0' then (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = ow_ind_id) 
                                    when ow_type = '1' then ow_huf_name 
                                    when ow_type = '2' then ow_pvtltd_comapny_name 
                                    when ow_type = '3' then ow_ltd_comapny_name 
                                    when ow_type = '4' then ow_llp_comapny_name 
                                    when ow_type = '5' then ow_prt_comapny_name 
                                    when ow_type = '6' then ow_aop_comapny_name 
                                    when ow_type = '7' then ow_trs_comapny_name 
                                    else ow_proprietorship_comapny_name end as ref_name, ow_gid as group_id 
                        from owner_master 
                        union all 
                        select 'Bank' as module_name, 'Bank' as cnt_name, b_id as ref_id, concat(ifnull(b_name,''), ' ', ifnull(b_branch,'')) as ref_name, b_gid as group_id from bank_master 
                        union all 
                        select 'Related Party Type' as module_name, 'contact_type' as cnt_name, id as ref_id, contact_type as ref_name, g_id as group_id from contact_type_master 
                        union all 
                        select 'Expense Category' as module_name, 'Expense_category' as cnt_name, id as ref_id, expense_category as ref_name, g_id as group_id from expense_category_master 
                        union all 
                        select 'City' as module_name, 'City' as cnt_name, id as ref_id, city_name as ref_name, g_id as group_id from city_master 
                        union all 
                        select 'Purchase' as module_name, 'Purchase' as cnt_name, txn_id as ref_id, p_property_name as ref_name, gp_id as group_id from purchase_txn 
                        union all 
                        select 'Sale' as module_name, 'Sale' as cnt_name, txn_id as ref_id, concat(ifnull(p_property_name,''), ifnull(sp_name,'')) as ref_name, gp_id as group_id from 
                        (select C.*, case when D.sp_name is null then '' else concat(' - ', D.sp_name) end as sp_name  from 
                        (select A.*, B.p_property_name from 
                        (select * from sales_txn) A 
                        left join 
                        (select * from purchase_txn) B 
                        on(A.property_id=B.txn_id)) C 
                        left join 
                        (select * from sub_property_allocation) D 
                        on(C.sub_property_id=D.txn_id)) E 
                        union all 
                        select 'Rent' as module_name, 'Rent' as cnt_name, txn_id as ref_id, concat(ifnull(p_property_name,''), ifnull(sp_name,'')) as ref_name, gp_id as group_id from 
                        (select C.*, case when D.sp_name is null then '' else concat(' - ', D.sp_name) end as sp_name  from 
                        (select A.*, B.p_property_name from 
                        (select * from rent_txn) A 
                        left join 
                        (select * from purchase_txn) B 
                        on(A.property_id=B.txn_id)) C 
                        left join 
                        (select * from sub_property_allocation) D 
                        on(C.sub_property_id=D.txn_id)) E 
                        union all 
                        select 'Loan' as module_name, 'Loan' as cnt_name, txn_id as ref_id, ref_id as ref_name, gp_id as group_id from loan_txn 
                        union all 
                        select 'Loan Disbursement' as module_name, 'Loan_disbursement' as cnt_name, txn_id as ref_id, ref_id as ref_name, gp_id as group_id from loan_disbursement 
                        union all 
                        select 'Expense' as module_name, 'Expense' as cnt_name, txn_id as ref_id, expense_category as ref_name, gp_id as group_id from 
                        (select A.*, B.expense_category from 
                        (select * from expense_txn) A 
                        left join 
                        (select * from expense_category_master) B 
                        on (A.category = B.id)) C 
                        union all 
                        select 'Maintenance' as module_name, 'Maintenance' as cnt_name, txn_id as ref_id, concat(ifnull(p_property_name,''), ifnull(sp_name,'')) as ref_name, gp_id as group_id from 
                        (select C.*, case when D.sp_name is null then '' else concat(' - ', D.sp_name) end as sp_name  from 
                        (select A.*, B.p_property_name from 
                        (select * from maintenance_txn) A 
                        left join 
                        (select * from purchase_txn) B 
                        on(A.property_id=B.txn_id)) C 
                        left join 
                        (select * from sub_property_allocation) D 
                        on(C.sub_property_id=D.txn_id)) E 
                        union all 
                        select 'Bank Entry' as module_name, table_type as cnt_name, created_on as ref_id, table_type as ref_name, gp_id as group_id from actual_schedule 
                        union all 
                        select 'Bank Entry' as module_name, table_type as cnt_name, created_on as ref_id, table_type as ref_name, gp_id as group_id from actual_schedule_taxes 
                        union all 
                        select 'Bank Entry Expense' as module_name, 'Expense' as cnt_name, id as ref_id, 'expense' as ref_name, gp_id as group_id from actual_other_expense 
                        union all 
                        select 'Bank Entry Schedule' as module_name, 'Schedule' as cnt_name, id as ref_id, 'Other Bank Entry' as ref_name, gp_id as group_id from actual_other_schedule 
                        union all 
                        select 'Task' as module_name, 'Task' as cnt_name, id as ref_id, subject_detail as ref_name, gp_id as group_id from user_task_detail 
                        union all
        				select 'Indexation' as module_name, 'Indexation' as cnt_name, i_id as ref_id, i_financial_year as ref_name, 'Software Developer' as group_id from indexation_master 
                        union all				
                        select 'Users' as module_name, 'Users' as cnt_name, gu_cid as ref_id, gu_email as ref_name, gu_gid as group_id from group_users 
                        union all 
                        select 'User Assign' as module_name, 'Manage' as cnt_name, rl_id as ref_id, role_name as ref_name, g_id as group_id from user_role_master 
                        union all 
                        select 'Property Projection' as module_name, 'Property_projection_model' as cnt_name, A.id as ref_id, B.p_property_name as ref_name, A.gp_id as group_id from 
                        (select * from property_projection_details) A 
                        left join 
                        (select * from purchase_txn) B 
                        on(A.purchase_id=B.txn_id)
                        union all 
                        select 'Property Allocation' as module_name, 'Allocation' as cnt_name, txn_id as ref_id, concat(ifnull(p_property_name,''), ifnull(sp_name,'')) as ref_name, gp_id as group_id from 
                        (select A.txn_id, A.gp_id, case when A.sp_name is null then '' else concat(' - ', A.sp_name) end as sp_name, B.p_property_name from 
                        (select * from sub_property_allocation) A 
                        left join 
                        (select * from purchase_txn) B 
                        on(A.property_id=B.txn_id)) C 
                        union all 
                        select 'Reports' as module_name, 'Reports' as cnt_name, c_id as ref_id, concat(ifnull(c_name,''), ' ', ifnull(c_last_name,'')) as ref_name, c_gid as group_id from contact_master) BB 

                        on(AA.module_name = BB.module_name and AA.controller_name = BB.cnt_name and AA.table_id = BB.ref_id and AA.gp_id = BB.group_id) order by AA.date desc";

                $query=$this->db->query($sql);
                $result=$query->result();
                $data['log']=$result;

                $query=$this->db->query("SELECT * FROM user_role_options");
                $result=$query->result();
                if(count($result)>0) {
                    $result[0]->r_export=1;
                    $data['access']=$result;
                }
                
                load_view('log/log_master', $data);
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