<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Export_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_all(){
    $query=$this->db->query("select * from contact_master");
    $result=$query->result_array();
    return $result;
}

public function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function getindex($date) {
    $index = 0;

    if ($this->validateDate($date)) {
        // $date=FormatDate($date);

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

function get_property_owner_wise($from_date, $to_date) {
    $gid=$this->session->userdata('groupid');
    if($from_date!='' && $to_date!='')
        $and = "and A.p_purchase_date>='$from_date' and A.p_purchase_date<='$to_date'";
    else
        $and = "";

    if($from_date!='' && $to_date!='')
        $and2 = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and2 = "";

     $sql = "select * from 
            (select C.*, D.owner_name, D.pr_client_id, D.pr_ownership_percent from 
            (select A.*, null as sp_id, null as sp_name, null as sp_type, null as sp_carpet_area, null as sp_carpet_area_unit, 
                null as sp_builtup_area, null as sp_builtup_area_unit, null as sp_sellable_area, null as sp_sellable_area_unit from purchase_txn A 
                where A.gp_id='$gid' and A.txn_status = 'Approved' $and
            union all 
            select A.*, B.txn_id as sp_id, B.sp_name, B.sp_type, B.sp_carpet_area, B.sp_carpet_area_unit, 
                B.sp_builtup_area, B.sp_builtup_area_unit, B.sp_sellable_area, B.sp_sellable_area_unit from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and2) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            left join 
            (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A) A 
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
            on C.txn_id=D.purchase_id) E 
            order by pr_client_id, txn_id";


    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_group_level_asset_alloc_owner_wise_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_property_owner_wise($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Asset_Allocation_Owner_Wise.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Asset_Allocation_Owner_Wise.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $prev_owner_id="";
        $owner_id="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";

        $tot_J_col = "";
        $tot_W_col = "";
        $tot_X_col = "";
        $tot_Y_col = "";
        $tot_Z_col = "";
        $tot_AB_col = "";
        $tot_AC_col = "";
        $tot_AD_col = "";
        $tot_AE_col = "";
        $tot_AG_col = "";
        $tot_AH_col = "";
        $tot_AI_col = "";
        $tot_AJ_col = "";
        $tot_AK_col = "";
        $tot_AL_col = "";
        $tot_AM_col = "";
        $tot_AO_col = "";
        $tot_AP_col = "";
        $tot_AQ_col = "";
        $tot_AS_col = "";
        $tot_AV_col = "";
        $tot_AX_col = "";
        $tot_AY_col = "";
        $tot_AZ_col = "";
        $tot_BB_col = "";
        $tot_BC_col = "";
        $tot_BE_col = "";
        $tot_BG_col = "";
        $tot_BH_col = "";

        for($i=0; $i<count($data); $i++) {
            $owner_id=$data[$i]->pr_client_id;
            $property_id=$data[$i]->txn_id;

            if($prev_owner_id!=$owner_id) {
                if($row!=6){
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, 'Total');
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=sum(J'.$s_row.':J'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=sum(W'.$s_row.':W'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=sum(X'.$s_row.':X'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=sum(Y'.$s_row.':Y'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '=sum(Z'.$s_row.':Z'.strval($row-1).')');
                    //$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '=sum(AB'.$s_row.':AB'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, '=sum(AC'.$s_row.':AC'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, '=sum(AD'.$s_row.':AD'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, '=sum(AE'.$s_row.':AE'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, '=sum(AG'.$s_row.':AG'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, '=sum(AH'.$s_row.':AH'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, '=sum(AI'.$s_row.':AI'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '=sum(AJ'.$s_row.':AJ'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '=sum(AK'.$s_row.':AK'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '=sum(AL'.$s_row.':AL'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '=sum(AM'.$s_row.':AM'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '=sum(AO'.$s_row.':AO'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, '=sum(AP'.$s_row.':AP'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, '=sum(AQ'.$s_row.':AQ'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, '=sum(AS'.$s_row.':AS'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, '=sum(AV'.$s_row.':AV'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, '=sum(AX'.$s_row.':AX'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, '=sum(AY'.$s_row.':AY'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, '=sum(AZ'.$s_row.':AZ'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, '=sum(BB'.$s_row.':BB'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, '=sum(BC'.$s_row.':BC'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, '=sum(BE'.$s_row.':BE'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('BG'.$row, '=sum(BG'.$s_row.':BG'.strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, '=average(BH'.$s_row.':BH'.strval($row-1).')');

                    $tot_J_col = $tot_J_col . 'J'.$row . ',';
                    $tot_W_col = $tot_W_col . 'W'.$row . ',';
                    $tot_X_col = $tot_X_col . 'X'.$row . ',';
                    $tot_Y_col = $tot_Y_col . 'Y'.$row . ',';
                    $tot_Z_col = $tot_Z_col . 'Z'.$row . ',';
                    $tot_AB_col = $tot_AB_col . 'AB'.$row . ',';
                    $tot_AC_col = $tot_AC_col . 'AC'.$row . ',';
                    $tot_AD_col = $tot_AD_col . 'AD'.$row . ',';
                    $tot_AE_col = $tot_AE_col . 'AE'.$row . ',';
                    $tot_AG_col = $tot_AG_col . 'AG'.$row . ',';
                    $tot_AH_col = $tot_AH_col . 'AH'.$row . ',';
                    $tot_AI_col = $tot_AI_col . 'AI'.$row . ',';
                    $tot_AJ_col = $tot_AJ_col . 'AJ'.$row . ',';
                    $tot_AK_col = $tot_AK_col . 'AK'.$row . ',';
                    $tot_AL_col = $tot_AL_col . 'AL'.$row . ',';
                    $tot_AM_col = $tot_AM_col . 'AM'.$row . ',';
                    $tot_AO_col = $tot_AO_col . 'AO'.$row . ',';
                    $tot_AP_col = $tot_AP_col . 'AP'.$row . ',';
                    $tot_AQ_col = $tot_AQ_col . 'AQ'.$row . ',';
                    $tot_AS_col = $tot_AS_col . 'AS'.$row . ',';
                    $tot_AV_col = $tot_AV_col . 'AV'.$row . ',';
                    $tot_AX_col = $tot_AX_col . 'AX'.$row . ',';
                    $tot_AY_col = $tot_AY_col . 'AY'.$row . ',';
                    $tot_AZ_col = $tot_AZ_col . 'AZ'.$row . ',';
                    $tot_BB_col = $tot_BB_col . 'BB'.$row . ',';
                    $tot_BC_col = $tot_BC_col . 'BC'.$row . ',';
                    $tot_BE_col = $tot_BE_col . 'BE'.$row . ',';
                    $tot_BG_col = $tot_BG_col . 'BG'.$row . ',';
                    $tot_BH_col = $tot_BH_col . 'BH'.$row . ',';

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->owner_name);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'F2F2F2'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $row=$row+1;
                $sr_no=1;
                $prev_owner_id=$owner_id;
                $prev_property_id="";
            }

            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
            if($sub_property_id==0){
                $cond = "and (sub_property_id is null or sub_property_id = '0')";
            } else {
                $cond = "and sub_property_id = '$sub_property_id'";
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data[$i]->p_property_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->pr_ownership_percent);
                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $address);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->p_status);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->p_type);
                $agreement_area = 0;
                $pending_activity = "";

                if($data[$i]->p_type=='Building' || $data[$i]->p_type=='Apartment' || $data[$i]->p_type=='Bunglow') {
                    $p_asset_type = 'Residential';
                } else {
                    $p_asset_type = 'Commercial';
                }

                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $p_asset_type);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->p_usage);

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
                    $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
                    $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);

                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $no_of_parking);
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $agreement_area);
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $carpet_area);
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $builtup_area);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $sellable_area);
                }

                $p_builder_name = $data[$i]->p_builder_name;
                $c_id = $p_builder_name;

                // $c_id=explode("_", $p_builder_name);
                // if(count($c_id)==2){
                //     $p_builder_name = $c_id[1];
                //     if ($c_id[0]=="o"){
                //         $sql = "select * from 
                //                 (select A.ow_id, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country, B.c_mobile1, B.c_emailid1, B.kyc_doc_ref from 
                //                 (select * from owner_master where ow_type = '0' and ow_status='Approved' and ow_gid='$gid') A 
                //                 left join 
                //                 (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //                 (select * from contact_master where c_status='Approved') A 
                //                 left join 
                //                 (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
                //                 on (A.c_id = B.kyc_cid)) B 
                //                 on (A.ow_ind_id=B.c_id) 
                //                 union all 
                //                 select ow_id, ow_huf_name as c_name, '' as c_last_name, ow_huf_address as c_address, ow_huf_landmark as c_landmark, ow_huf_city as c_city, ow_huf_pincode as c_pincode, ow_huf_state as c_state, ow_huf_country as c_country, '' as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '1' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_pvtltd_comapny_name as c_name, '' as c_last_name, ow_pvtltd_address as c_address, ow_pvtltd_landmark as c_landmark, ow_pvtltd_city as c_city, ow_pvtltd_pincode as c_pincode, ow_pvtltd_state as c_state, ow_pvtltd_country as c_country, ow_pvtltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '2' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_ltd_comapny_name as c_name, '' as c_last_name, ow_ltd_address as c_address, ow_ltd_landmark as c_landmark, ow_ltd_city as c_city, ow_ltd_pincode as c_pincode, ow_ltd_state as c_state, ow_ltd_country as c_country, ow_ltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '3' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_llp_comapny_name as c_name, '' as c_last_name, ow_llp_address as c_address, ow_llp_landmark as c_landmark, ow_llp_city as c_city, ow_llp_pincode as c_pincode, ow_llp_state as c_state, ow_llp_country as c_country, ow_llp_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '4' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_prt_comapny_name as c_name, '' as c_last_name, ow_prt_address as c_address, ow_prt_landmark as c_landmark, ow_prt_city as c_city, ow_prt_pincode as c_pincode, ow_prt_state as c_state, ow_prt_country as c_country, ow_prt_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '5' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_aop_comapny_name as c_name, '' as c_last_name, ow_aop_address as c_address, ow_aop_landmark as c_landmark, ow_aop_city as c_city, ow_aop_pincode as c_pincode, ow_aop_state as c_state, ow_aop_country as c_country, ow_aop_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '6' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_trs_comapny_name as c_name, '' as c_last_name, ow_trs_address as c_address, ow_trs_landmark as c_landmark, ow_trs_city as c_city, ow_trs_pincode as c_pincode, ow_trs_state as c_state, ow_trs_country as c_country, ow_trs_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '7' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_proprietorship_comapny_name as c_name, '' as c_last_name, ow_proprietorship_address as c_address, ow_proprietorship_landmark as c_landmark, ow_proprietorship_city as c_city, ow_proprietorship_pincode as c_pincode, ow_proprietorship_state as c_state, ow_proprietorship_country as c_country, ow_proprietorship_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '8' and ow_status='Approved' and ow_gid='$gid') C 
                //                 where ow_id = '$p_builder_name'";
                //     } else {
                //         $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //                 (select * from contact_master where c_id='$p_builder_name') A 
                //                 left join 
                //                 (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
                //                 on (A.c_id = B.kyc_cid)";
                //     }
                // } else {
                //     $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //             (select * from contact_master where c_id='$p_builder_name') A 
                //             left join 
                //             (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
                //             on (A.c_id = B.kyc_cid)";
                // }

                $sql = "select A.*, B.doc_ref_no as kyc_doc_ref from 
                        (select A.c_id, A.c_address, A.c_landmark, A.c_city, A.c_pincode, A.c_state, A.c_country,
                            case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                            case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$p_builder_name') A 
                        left join 
                        (select * from document_details where doc_ref_id = '$p_builder_name' and doc_ref_type = 'Contacts' and doc_doc_id = '1') B 
                        on (A.c_id = B.doc_ref_id)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $result[0]->c_name . ' ' . $result[0]->c_last_name);
                    $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $address);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $result[0]->c_mobile1);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $result[0]->c_emailid1);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $result[0]->kyc_doc_ref);
                }

                // $sql = "select A.*, B.* from 
                //         (select bro_contactid from purchase_brokerage_details where purchase_id = '$property_id') A 
                //         left join 
                //         (select * from contact_master where c_gid = '$gid') B 
                //         on (A.bro_contactid = B.c_id)";
                $sql = "select C.*, D.contact_type from 
                        (select A.*, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, 
                            B.c_country, B.c_mobile1, B.c_emailid1, B.c_contact_type from 
                        (select * from related_party_details where type='purchase' and ref_id='$property_id') A 
                        left join 
                        (select * from contact_master where c_gid = '$gid') B 
                        on (A.contact_id=B.c_id)) C 
                        left join 
                        (select * from contact_type_master) D 
                        on (C.c_contact_type = D.id) 
                        where D.contact_type = 'Broker'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $result[0]->c_name . ' ' . $result[0]->c_last_name);
                    $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $address);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $result[0]->c_mobile1);
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $result[0]->c_emailid1);
                }

                $sql = "select sum(net_amount) as agreement_value from purchase_schedule where purchase_id = '$property_id' and status = '1' and event_type = 'Agreement Value'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_value = $result[0]->agreement_value;
                    if($agreement_area!=0){
                        $agreement_rate = $agreement_value/$agreement_area;
                    } else {
                        $agreement_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $agreement_rate);
                }

                $sql = "select * from property_projection_details where purchase_id = '$property_id'".$cond." and 
                        id = (select max(id) from property_projection_details where purchase_id = '$property_id'".$cond.")";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $result[0]->market_rate);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $result[0]->req_rate_return);

                    $current_index = $this->getindex(date('Y-m-d'));
                    $purchase_index = $this->getindex($data[$i]->p_purchase_date);

                    if($purchase_index!=0) {
                        $indexed_rate = $agreement_rate*$current_index/$purchase_index;
                    } else {
                        $indexed_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $indexed_rate);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, '=(W'.$row.'*AB'.$row.')');

                $sql = "select event_name, sum(net_amount) as tot_net_amount from 
                        (select case when event_name='Registration' then 'Stamp Duty' else event_name end as event_name, 
                        net_amount from purchase_schedule 
                        where purchase_id = '$property_id' and status = '1' and 
                        event_type = 'Non agreement value') A 
                        group by event_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $other_charges=0;
                    for($j=0; $j<count($result); $j++) {
                        $tot_net_amount=is_numeric($result[$j]->tot_net_amount)?$result[$j]->tot_net_amount:0;
                        if(strtoupper(trim($result[$j]->event_name))=='VAT ON BASIC') {
                            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='STAMP DUTY') {
                            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='BROKERAGE') {
                            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '='.$tot_net_amount);
                        } else {
                            $other_charges = $other_charges + $tot_net_amount;
                        }
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '='.$other_charges);
                }

                $sql = "select sum(tax_amount) as tot_service_tax from purchase_schedule_taxation 
                        where pur_id = '$property_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_service_tax=is_numeric($result[0]->tot_service_tax)?$result[0]->tot_service_tax:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '='.$tot_service_tax);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '=SUM(AG'.$row.':AL'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '=W'.$row.'*AC'.$row);
                $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, '=W'.$row.'*AD'.$row);
                $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, '=W'.$row.'*AE'.$row);

                $sql = "select sum(tax_amount) as tot_tds from actual_schedule_taxes 
                        where id in (select id from (select tax_applied, max(id) as id from actual_schedule_taxes 
                        where table_type = 'purchase' and fk_txn_id = '$property_id' and status = '1' group by tax_applied) A)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_tds=isset($result[0]->tot_tds)?$result[0]->tot_tds:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, '='.$tot_tds);
                }

                $sql = "select * from pending_activity where ref_id = '$property_id' and type='purchase'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$row, $pending_activity);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('BL'.$row, $data[$i]->remarks);
            }

            if($data[$i]->sp_name!=""){
                $sp_carpet_area = convert_to_feet($data[$i]->sp_carpet_area, $data[$i]->sp_carpet_area_unit);
                $sp_builtup_area = convert_to_feet($data[$i]->sp_builtup_area, $data[$i]->sp_builtup_area_unit);
                $sp_sellable_area = convert_to_feet($data[$i]->sp_sellable_area, $data[$i]->sp_sellable_area_unit);

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data[$i]->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->sp_type);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $sp_carpet_area);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $sp_builtup_area);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $sp_sellable_area);
            }
            
            $pending_activity = "";

            if($sub_property_id!=0){
                $sql = "select * from pending_activity where ref_id = '$sub_property_id' and type='allocation'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$row, $pending_activity);
                }
            }

            $sql = "select A.loan_id, B.* from 
                    (select * from loan_property_details where property_id = '$property_id' and 
                        loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                    left join 
                    (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                    on A.loan_id = B.txn_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_id=$result[0]->loan_id;

                $bank_name=$result[0]->financial_institution;
                $objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $bank_name);

                $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
                $loan_emi=0;
                $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

                $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
                }

                $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                        where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                    $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
                }

                $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                } else {
                    $loan_outstanding = 0;
                }

                $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

                $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                } else {
                    $tot_paid_amount = 0;
                }

                $loan_outstanding = $loan_outstanding - $tot_paid_amount;
                
                $objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, '='.$loan_outstanding);
                $objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, '='.$loan_interest_rate);
                $objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, '='.$loan_emi);
                $objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, '='.$outstanding_agreement_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, '='.($outstanding_agreement_amount+$loan_outstanding));
            }

            $sql = "select * from rent_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $rent_amount=isset($result[0]->rent_amount)?$result[0]->rent_amount:0;
                $objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, '=('.$rent_amount.'*12)');

                $maintenance_by = isset($result[0]->maintenance_by)?$result[0]->maintenance_by:'Owner';
                $property_tax_by = isset($result[0]->property_tax_by)?$result[0]->property_tax_by:'Owner';
            } else {
                $maintenance_by = 'Owner';
                $property_tax_by = 'Owner';
            }

            $sql = "select * from maintenance_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $m_id=isset($result[0]->txn_id)?$result[0]->txn_id:0;

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and (particular = 'CAMP (Rs. PSF)' or particular = 'Maintenance')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, '='.$cost);
                }

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and particular = 'Property Tax'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, '='.$cost);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('BD'.$row, $maintenance_by);
                $objPHPExcel->getActiveSheet()->setCellValue('BF'.$row, $property_tax_by);
                $objPHPExcel->getActiveSheet()->setCellValue('BG'.$row, '=BB'.$row.'-(IF(BD'.$row.'="Owner",BC'.$row.',0)+IF(BF'.$row.'="Owner",BE'.$row.',0))');
                $objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, '=if(AG'.$row.'=0,0,BG'.$row.'/AG'.$row.')');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, 0);
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=sum(J'.$s_row.':J'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=sum(W'.$s_row.':W'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=sum(X'.$s_row.':X'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=sum(Y'.$s_row.':Y'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '=sum(Z'.$s_row.':Z'.strval($row-1).')');
        //$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '=sum(AB'.$s_row.':AB'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, '=sum(AC'.$s_row.':AC'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, '=sum(AD'.$s_row.':AD'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, '=sum(AE'.$s_row.':AE'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, '=sum(AG'.$s_row.':AG'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, '=sum(AH'.$s_row.':AH'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, '=sum(AI'.$s_row.':AI'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '=sum(AJ'.$s_row.':AJ'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '=sum(AK'.$s_row.':AK'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '=sum(AL'.$s_row.':AL'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '=sum(AM'.$s_row.':AM'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '=sum(AO'.$s_row.':AO'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, '=sum(AP'.$s_row.':AP'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, '=sum(AQ'.$s_row.':AQ'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, '=sum(AS'.$s_row.':AS'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, '=sum(AV'.$s_row.':AV'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, '=sum(AX'.$s_row.':AX'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, '=sum(AY'.$s_row.':AY'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, '=sum(AZ'.$s_row.':AZ'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, '=sum(BB'.$s_row.':BB'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, '=sum(BC'.$s_row.':BC'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, '=sum(BE'.$s_row.':BE'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('BG'.$row, '=sum(BG'.$s_row.':BG'.strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, '=average(BH'.$s_row.':BH'.strval($row-1).')');

        $tot_J_col = $tot_J_col . 'J'.$row . ',';
        $tot_W_col = $tot_W_col . 'W'.$row . ',';
        $tot_X_col = $tot_X_col . 'X'.$row . ',';
        $tot_Y_col = $tot_Y_col . 'Y'.$row . ',';
        $tot_Z_col = $tot_Z_col . 'Z'.$row . ',';
        $tot_AB_col = $tot_AB_col . 'AB'.$row . ',';
        $tot_AC_col = $tot_AC_col . 'AC'.$row . ',';
        $tot_AD_col = $tot_AD_col . 'AD'.$row . ',';
        $tot_AE_col = $tot_AE_col . 'AE'.$row . ',';
        $tot_AG_col = $tot_AG_col . 'AG'.$row . ',';
        $tot_AH_col = $tot_AH_col . 'AH'.$row . ',';
        $tot_AI_col = $tot_AI_col . 'AI'.$row . ',';
        $tot_AJ_col = $tot_AJ_col . 'AJ'.$row . ',';
        $tot_AK_col = $tot_AK_col . 'AK'.$row . ',';
        $tot_AL_col = $tot_AL_col . 'AL'.$row . ',';
        $tot_AM_col = $tot_AM_col . 'AM'.$row . ',';
        $tot_AO_col = $tot_AO_col . 'AO'.$row . ',';
        $tot_AP_col = $tot_AP_col . 'AP'.$row . ',';
        $tot_AQ_col = $tot_AQ_col . 'AQ'.$row . ',';
        $tot_AS_col = $tot_AS_col . 'AS'.$row . ',';
        $tot_AV_col = $tot_AV_col . 'AV'.$row . ',';
        $tot_AX_col = $tot_AX_col . 'AX'.$row . ',';
        $tot_AY_col = $tot_AY_col . 'AY'.$row . ',';
        $tot_AZ_col = $tot_AZ_col . 'AZ'.$row . ',';
        $tot_BB_col = $tot_BB_col . 'BB'.$row . ',';
        $tot_BC_col = $tot_BC_col . 'BC'.$row . ',';
        $tot_BE_col = $tot_BE_col . 'BE'.$row . ',';
        $tot_BG_col = $tot_BG_col . 'BG'.$row . ',';
        $tot_BH_col = $tot_BH_col . 'BH'.$row . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, 'Grand Total');

        $tot_J_col = substr($tot_J_col, 0, strlen($tot_J_col)-1);
        $tot_W_col = substr($tot_W_col, 0, strlen($tot_W_col)-1);
        $tot_X_col = substr($tot_X_col, 0, strlen($tot_X_col)-1);
        $tot_Y_col = substr($tot_Y_col, 0, strlen($tot_Y_col)-1);
        $tot_Z_col = substr($tot_Z_col, 0, strlen($tot_Z_col)-1);
        //$tot_AB_col = substr($tot_AB_col, 0, strlen($tot_AB_col)-1);
        $tot_AC_col = substr($tot_AC_col, 0, strlen($tot_AC_col)-1);
        $tot_AD_col = substr($tot_AD_col, 0, strlen($tot_AD_col)-1);
        $tot_AE_col = substr($tot_AE_col, 0, strlen($tot_AE_col)-1);
        $tot_AG_col = substr($tot_AG_col, 0, strlen($tot_AG_col)-1);
        $tot_AH_col = substr($tot_AH_col, 0, strlen($tot_AH_col)-1);
        $tot_AI_col = substr($tot_AI_col, 0, strlen($tot_AI_col)-1);
        $tot_AJ_col = substr($tot_AJ_col, 0, strlen($tot_AJ_col)-1);
        $tot_AK_col = substr($tot_AK_col, 0, strlen($tot_AK_col)-1);
        $tot_AL_col = substr($tot_AL_col, 0, strlen($tot_AL_col)-1);
        $tot_AM_col = substr($tot_AM_col, 0, strlen($tot_AM_col)-1);
        $tot_AO_col = substr($tot_AO_col, 0, strlen($tot_AO_col)-1);
        $tot_AP_col = substr($tot_AP_col, 0, strlen($tot_AP_col)-1);
        $tot_AQ_col = substr($tot_AQ_col, 0, strlen($tot_AQ_col)-1);
        $tot_AS_col = substr($tot_AS_col, 0, strlen($tot_AS_col)-1);
        $tot_AV_col = substr($tot_AV_col, 0, strlen($tot_AV_col)-1);
        $tot_AX_col = substr($tot_AX_col, 0, strlen($tot_AX_col)-1);
        $tot_AY_col = substr($tot_AY_col, 0, strlen($tot_AY_col)-1);
        $tot_AZ_col = substr($tot_AZ_col, 0, strlen($tot_AZ_col)-1);
        $tot_BB_col = substr($tot_BB_col, 0, strlen($tot_BB_col)-1);
        $tot_BC_col = substr($tot_BC_col, 0, strlen($tot_BC_col)-1);
        $tot_BE_col = substr($tot_BE_col, 0, strlen($tot_BE_col)-1);
        $tot_BG_col = substr($tot_BG_col, 0, strlen($tot_BG_col)-1);
        $tot_BH_col = substr($tot_BH_col, 0, strlen($tot_BH_col)-1);

        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=sum('.$tot_J_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=sum('.$tot_W_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=sum('.$tot_X_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=sum('.$tot_Y_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '=sum('.$tot_Z_col.')');
        //$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '=sum('.$tot_AB_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, '=sum('.$tot_AC_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, '=sum('.$tot_AD_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, '=sum('.$tot_AE_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, '=sum('.$tot_AG_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, '=sum('.$tot_AH_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, '=sum('.$tot_AI_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '=sum('.$tot_AJ_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '=sum('.$tot_AK_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '=sum('.$tot_AL_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '=sum('.$tot_AM_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '=sum('.$tot_AO_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, '=sum('.$tot_AP_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, '=sum('.$tot_AQ_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, '=sum('.$tot_AS_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, '=sum('.$tot_AV_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, '=sum('.$tot_AX_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, '=sum('.$tot_AY_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, '=sum('.$tot_AZ_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, '=sum('.$tot_BB_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, '=sum('.$tot_BC_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, '=sum('.$tot_BE_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('BG'.$row, '=sum('.$tot_BG_col.')');
        $objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, '=average('.$tot_BH_col.')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':BL'.$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:BL'.$row)->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('K6:K'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('Q6:Q'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('V6:V'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('AA6:AA'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('AF6:AF'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('AN6:AN'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('AR6:AR'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('AT6:AT'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('BA6:BA'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('BI6:BI'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('BK6:BK'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));

        $filename='Group_Level_Asset_Allocation_Owner_Wise_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Asset Allocation-Owner wise report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}


function get_property_usage_wise($from_date, $to_date){
    $gid=$this->session->userdata('groupid');
      if($from_date!='' && $to_date!='')
        $and = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and = "";

    $sql = "select * from 
            (select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    null as sp_id, null as sp_name, null as sp_type, null as sp_carpet_area, null as sp_carpet_area_unit, 
                null as sp_builtup_area, null as sp_builtup_area_unit, null as sp_sellable_area, null as sp_sellable_area_unit from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and) A 
            union all
            select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    B.txn_id as sp_id, B.sp_name, B.sp_type, B.sp_carpet_area, B.sp_carpet_area_unit, 
                    B.sp_builtup_area, B.sp_builtup_area_unit, B.sp_sellable_area, B.sp_sellable_area_unit from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            order by asset_type, p_usage, txn_id, sp_id";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_max_property_owner_cnt($from_date, $to_date){
    $gid=$this->session->userdata('groupid');

    // $sql = "select max(cnt_pr_client_id) as max_cnt_pr_client_id from 
    //         (select purchase_id, count(pr_client_id) as cnt_pr_client_id from 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id) C 
    //         group by purchase_id) D";

    $sql = "select max(cnt_pr_client_id) as max_cnt_pr_client_id from 
            (select purchase_id, count(pr_client_id) as cnt_pr_client_id from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A 
                where A.purchase_id in (select distinct txn_id from purchase_txn where gp_id = '$gid')) C 
            group by purchase_id) D";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_property_owners($p_id){
    $gid=$this->session->userdata('groupid');

    // $sql = "select * from 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id and A.purchase_id = '$p_id') C 
    //         order by pr_client_id";

    $sql = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A where A.purchase_id = '$p_id') A 
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
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_group_level_asset_alloc_usage_wise_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_max_property_owner_cnt($from_date, $to_date);

    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_property_usage_wise($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Asset_Allocation_Usage_Wise.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Asset_Allocation_Usage_Wise.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        // $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('D', $owner_cnt);
            $col=3;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $col=$col+2;
            }
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].'1', $this->session->userdata('groupname'));

        $tot_col = array();
        // $tot_col['tot_'.PHPExcel_Cell::stringFromColumnIndex(9+$owner_cnt).'_col'] = "";
        $tot_col[8+$owner_cnt] = "";
        $tot_col[21+$owner_cnt] = "";
        $tot_col[22+$owner_cnt] = "";
        $tot_col[23+$owner_cnt] = "";
        $tot_col[24+$owner_cnt] = "";
        $tot_col[26+$owner_cnt] = "";
        $tot_col[27+$owner_cnt] = "";
        $tot_col[28+$owner_cnt] = "";
        $tot_col[29+$owner_cnt] = "";
        $tot_col[31+$owner_cnt] = "";
        $tot_col[32+$owner_cnt] = "";
        $tot_col[33+$owner_cnt] = "";
        $tot_col[34+$owner_cnt] = "";
        $tot_col[35+$owner_cnt] = "";
        $tot_col[36+$owner_cnt] = "";
        $tot_col[37+$owner_cnt] = "";
        $tot_col[39+$owner_cnt] = "";
        $tot_col[40+$owner_cnt] = "";
        $tot_col[41+$owner_cnt] = "";
        $tot_col[43+$owner_cnt] = "";
        $tot_col[46+$owner_cnt] = "";
        $tot_col[48+$owner_cnt] = "";
        $tot_col[49+$owner_cnt] = "";
        $tot_col[50+$owner_cnt] = "";
        $tot_col[52+$owner_cnt] = "";
        $tot_col[53+$owner_cnt] = "";
        $tot_col[55+$owner_cnt] = "";
        $tot_col[57+$owner_cnt] = "";
        $tot_col[58+$owner_cnt] = "";

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if($prev_p_usage!=$p_usage) {
                if($row!=6){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Total');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), '=sum('.$col_name[21+$owner_cnt].strval($s_row).':'.$col_name[21+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), '=sum('.$col_name[24+$owner_cnt].strval($s_row).':'.$col_name[24+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$col_name[26+$owner_cnt].strval($s_row).':'.$col_name[26+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$col_name[27+$owner_cnt].strval($s_row).':'.$col_name[27+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$col_name[28+$owner_cnt].strval($s_row).':'.$col_name[28+$owner_cnt].strval($row-1).')');
                    //$objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$owner_cnt].strval($row), '=sum('.$col_name[29+$owner_cnt].strval($s_row).':'.$col_name[29+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$col_name[31+$owner_cnt].strval($s_row).':'.$col_name[31+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$col_name[32+$owner_cnt].strval($s_row).':'.$col_name[32+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$col_name[33+$owner_cnt].strval($s_row).':'.$col_name[33+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$col_name[34+$owner_cnt].strval($s_row).':'.$col_name[34+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$col_name[35+$owner_cnt].strval($s_row).':'.$col_name[35+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[36+$owner_cnt].strval($row), '=sum('.$col_name[36+$owner_cnt].strval($s_row).':'.$col_name[36+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), '=sum('.$col_name[37+$owner_cnt].strval($s_row).':'.$col_name[37+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=sum('.$col_name[39+$owner_cnt].strval($s_row).':'.$col_name[39+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$col_name[40+$owner_cnt].strval($s_row).':'.$col_name[40+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$col_name[41+$owner_cnt].strval($s_row).':'.$col_name[41+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$col_name[43+$owner_cnt].strval($s_row).':'.$col_name[43+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[46+$owner_cnt].strval($row), '=sum('.$col_name[46+$owner_cnt].strval($s_row).':'.$col_name[46+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '=sum('.$col_name[48+$owner_cnt].strval($s_row).':'.$col_name[48+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '=sum('.$col_name[49+$owner_cnt].strval($s_row).':'.$col_name[49+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '=sum('.$col_name[50+$owner_cnt].strval($s_row).':'.$col_name[50+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[52+$owner_cnt].strval($row), '=sum('.$col_name[52+$owner_cnt].strval($s_row).':'.$col_name[52+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[53+$owner_cnt].strval($row), '=sum('.$col_name[53+$owner_cnt].strval($s_row).':'.$col_name[53+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '=sum('.$col_name[55+$owner_cnt].strval($s_row).':'.$col_name[55+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '=sum('.$col_name[57+$owner_cnt].strval($s_row).':'.$col_name[57+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[58+$owner_cnt].strval($row), '=average('.$col_name[58+$owner_cnt].strval($s_row).':'.$col_name[58+$owner_cnt].strval($row-1).')');

                    $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
                    $tot_col[21+$owner_cnt] = $tot_col[21+$owner_cnt] . $col_name[21+$owner_cnt].strval($row) . ',';
                    $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
                    $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
                    $tot_col[24+$owner_cnt] = $tot_col[24+$owner_cnt] . $col_name[24+$owner_cnt].strval($row) . ',';
                    $tot_col[26+$owner_cnt] = $tot_col[26+$owner_cnt] . $col_name[26+$owner_cnt].strval($row) . ',';
                    $tot_col[27+$owner_cnt] = $tot_col[27+$owner_cnt] . $col_name[27+$owner_cnt].strval($row) . ',';
                    $tot_col[28+$owner_cnt] = $tot_col[28+$owner_cnt] . $col_name[28+$owner_cnt].strval($row) . ',';
                    //$tot_col[29+$owner_cnt] = $tot_col[29+$owner_cnt] . $col_name[29+$owner_cnt].strval($row) . ',';
                    $tot_col[31+$owner_cnt] = $tot_col[31+$owner_cnt] . $col_name[31+$owner_cnt].strval($row) . ',';
                    $tot_col[32+$owner_cnt] = $tot_col[32+$owner_cnt] . $col_name[32+$owner_cnt].strval($row) . ',';
                    $tot_col[33+$owner_cnt] = $tot_col[33+$owner_cnt] . $col_name[33+$owner_cnt].strval($row) . ',';
                    $tot_col[34+$owner_cnt] = $tot_col[34+$owner_cnt] . $col_name[34+$owner_cnt].strval($row) . ',';
                    $tot_col[35+$owner_cnt] = $tot_col[35+$owner_cnt] . $col_name[35+$owner_cnt].strval($row) . ',';
                    $tot_col[36+$owner_cnt] = $tot_col[36+$owner_cnt] . $col_name[36+$owner_cnt].strval($row) . ',';
                    $tot_col[37+$owner_cnt] = $tot_col[37+$owner_cnt] . $col_name[37+$owner_cnt].strval($row) . ',';
                    $tot_col[39+$owner_cnt] = $tot_col[39+$owner_cnt] . $col_name[39+$owner_cnt].strval($row) . ',';
                    $tot_col[40+$owner_cnt] = $tot_col[40+$owner_cnt] . $col_name[40+$owner_cnt].strval($row) . ',';
                    $tot_col[41+$owner_cnt] = $tot_col[41+$owner_cnt] . $col_name[41+$owner_cnt].strval($row) . ',';
                    $tot_col[43+$owner_cnt] = $tot_col[43+$owner_cnt] . $col_name[43+$owner_cnt].strval($row) . ',';
                    $tot_col[46+$owner_cnt] = $tot_col[46+$owner_cnt] . $col_name[46+$owner_cnt].strval($row) . ',';
                    $tot_col[48+$owner_cnt] = $tot_col[48+$owner_cnt] . $col_name[48+$owner_cnt].strval($row) . ',';
                    $tot_col[49+$owner_cnt] = $tot_col[49+$owner_cnt] . $col_name[49+$owner_cnt].strval($row) . ',';
                    $tot_col[50+$owner_cnt] = $tot_col[50+$owner_cnt] . $col_name[50+$owner_cnt].strval($row) . ',';
                    $tot_col[52+$owner_cnt] = $tot_col[52+$owner_cnt] . $col_name[52+$owner_cnt].strval($row) . ',';
                    $tot_col[53+$owner_cnt] = $tot_col[53+$owner_cnt] . $col_name[53+$owner_cnt].strval($row) . ',';
                    $tot_col[55+$owner_cnt] = $tot_col[55+$owner_cnt] . $col_name[55+$owner_cnt].strval($row) . ',';
                    $tot_col[57+$owner_cnt] = $tot_col[57+$owner_cnt] . $col_name[57+$owner_cnt].strval($row) . ',';
                    $tot_col[58+$owner_cnt] = $tot_col[58+$owner_cnt] . $col_name[58+$owner_cnt].strval($row) . ',';

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }
            }

            if($prev_asset_type!=$asset_type) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $asset_type);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'D9D9D9'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $row=$row+1;

                $prev_asset_type=$asset_type;
            }

            if($prev_p_usage!=$p_usage) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $p_usage);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'F2F2F2'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $row=$row+1;
                $sr_no=1;
                $prev_p_usage=$p_usage;
                $prev_property_id="";
            }

            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
            if($sub_property_id==0){
                $cond = "and (sub_property_id is null or sub_property_id = '0')";
            } else {
                $cond = "and sub_property_id = '$sub_property_id'";
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=3;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), $address);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$owner_cnt].strval($row), $data[$i]->p_status);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $data[$i]->p_type);
                $agreement_area = 0;
                $pending_activity = "";

                if($data[$i]->p_type=='Building' || $data[$i]->p_type=='Apartment' || $data[$i]->p_type=='Bunglow') {
                    $p_asset_type = 'Residential';
                } else {
                    $p_asset_type = 'Commercial';
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $p_asset_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), $data[$i]->p_usage);

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
                    $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
                    $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), $no_of_parking);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), $agreement_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), $carpet_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), $builtup_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), $sellable_area);
                }

                $p_builder_name = $data[$i]->p_builder_name;
                $c_id = $p_builder_name;

                // $c_id=explode("_", $p_builder_name);
                // if(count($c_id)==2){
                //     $p_builder_name = $c_id[1];
                //     if ($c_id[0]=="o"){
                //         $sql = "select * from 
                //                 (select A.ow_id, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country, B.c_mobile1, B.c_emailid1, B.kyc_doc_ref from 
                //                 (select * from owner_master where ow_type = '0' and ow_status='Approved' and ow_gid='$gid') A 
                //                 left join 
                //                 (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //                 (select * from contact_master where c_status='Approved') A 
                //                 left join 
                //                 (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
                //                 on (A.c_id = B.kyc_cid)) B 
                //                 on (A.ow_ind_id=B.c_id) 
                //                 union all 
                //                 select ow_id, ow_huf_name as c_name, '' as c_last_name, ow_huf_address as c_address, ow_huf_landmark as c_landmark, ow_huf_city as c_city, ow_huf_pincode as c_pincode, ow_huf_state as c_state, ow_huf_country as c_country, '' as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '1' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_pvtltd_comapny_name as c_name, '' as c_last_name, ow_pvtltd_address as c_address, ow_pvtltd_landmark as c_landmark, ow_pvtltd_city as c_city, ow_pvtltd_pincode as c_pincode, ow_pvtltd_state as c_state, ow_pvtltd_country as c_country, ow_pvtltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '2' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_ltd_comapny_name as c_name, '' as c_last_name, ow_ltd_address as c_address, ow_ltd_landmark as c_landmark, ow_ltd_city as c_city, ow_ltd_pincode as c_pincode, ow_ltd_state as c_state, ow_ltd_country as c_country, ow_ltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '3' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_llp_comapny_name as c_name, '' as c_last_name, ow_llp_address as c_address, ow_llp_landmark as c_landmark, ow_llp_city as c_city, ow_llp_pincode as c_pincode, ow_llp_state as c_state, ow_llp_country as c_country, ow_llp_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '4' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_prt_comapny_name as c_name, '' as c_last_name, ow_prt_address as c_address, ow_prt_landmark as c_landmark, ow_prt_city as c_city, ow_prt_pincode as c_pincode, ow_prt_state as c_state, ow_prt_country as c_country, ow_prt_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '5' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_aop_comapny_name as c_name, '' as c_last_name, ow_aop_address as c_address, ow_aop_landmark as c_landmark, ow_aop_city as c_city, ow_aop_pincode as c_pincode, ow_aop_state as c_state, ow_aop_country as c_country, ow_aop_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '6' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_trs_comapny_name as c_name, '' as c_last_name, ow_trs_address as c_address, ow_trs_landmark as c_landmark, ow_trs_city as c_city, ow_trs_pincode as c_pincode, ow_trs_state as c_state, ow_trs_country as c_country, ow_trs_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '7' and ow_status='Approved' and ow_gid='$gid' 
                //                 union all 
                //                 select ow_id, ow_proprietorship_comapny_name as c_name, '' as c_last_name, ow_proprietorship_address as c_address, ow_proprietorship_landmark as c_landmark, ow_proprietorship_city as c_city, ow_proprietorship_pincode as c_pincode, ow_proprietorship_state as c_state, ow_proprietorship_country as c_country, ow_proprietorship_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '8' and ow_status='Approved' and ow_gid='$gid') C 
                //                 where ow_id = '$p_builder_name'";
                //     } else {
                //         $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //                 (select * from contact_master where c_id='$p_builder_name') A 
                //                 left join 
                //                 (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
                //                 on (A.c_id = B.kyc_cid)";
                //     }
                // } else {
                //     $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                //             (select * from contact_master where c_id='$p_builder_name') A 
                //             left join 
                //             (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
                //             on (A.c_id = B.kyc_cid)";
                // }


                $sql = "select A.*, B.doc_ref_no as kyc_doc_ref from 
                        (select A.c_id, A.c_address, A.c_landmark, A.c_city, A.c_pincode, A.c_state, A.c_country,
                            case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                            case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$p_builder_name') A 
                        left join 
                        (select * from document_details where doc_ref_id = '$p_builder_name' and doc_ref_type = 'Contacts' and doc_doc_id = '1') B 
                        on (A.c_id = B.doc_ref_id)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $result[0]->c_name . ' ' . $result[0]->c_last_name);
                    $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), $address);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), $result[0]->c_mobile1);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), $result[0]->c_emailid1);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), $result[0]->kyc_doc_ref);
                }

                // $sql = "select A.*, B.* from 
                //         (select bro_contactid from purchase_brokerage_details where purchase_id = '$property_id') A 
                //         left join 
                //         (select * from contact_master where c_gid = '$gid') B 
                //         on (A.bro_contactid = B.c_id)";
                $sql = "select C.*, D.contact_type from 
                        (select A.*, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, 
                            B.c_country, B.c_mobile1, B.c_emailid1, B.c_contact_type from 
                        (select * from related_party_details where type='purchase' and ref_id='$property_id') A 
                        left join 
                        (select * from contact_master where c_gid = '$gid') B 
                        on (A.contact_id=B.c_id)) C 
                        left join 
                        (select * from contact_type_master) D 
                        on (C.c_contact_type = D.id) 
                        where D.contact_type = 'Broker'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), $result[0]->c_name . ' ' . $result[0]->c_last_name);
                    $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), $address);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), $result[0]->c_mobile1);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), $result[0]->c_emailid1);
                }

                $sql = "select sum(net_amount) as agreement_value from purchase_schedule where purchase_id = '$property_id' and status = '1' and event_type = 'Agreement Value'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_value = $result[0]->agreement_value;
                    if($agreement_area!=0){
                        $agreement_rate = $agreement_value/$agreement_area;
                    } else {
                        $agreement_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), $agreement_rate);
                }

                $sql = "select * from property_projection_details where purchase_id = '$property_id'".$cond." and 
                        id = (select max(id) from property_projection_details where purchase_id = '$property_id'".$cond.")";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), $result[0]->market_rate);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), $result[0]->req_rate_return);

                    $current_index = $this->getindex(date('Y-m-d'));
                    $purchase_index = $this->getindex($data[$i]->p_purchase_date);

                    if($purchase_index!=0) {
                        $indexed_rate = $agreement_rate*$current_index/$purchase_index;
                    } else {
                        $indexed_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$owner_cnt].strval($row), $indexed_rate);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=('.$col_name[21+$owner_cnt].strval($row).'*'.$col_name[26+$owner_cnt].strval($row).')');

                $sql = "select * from (select case when event_name='Registration' then 'Stamp Duty' else event_name end as event_name, 
                        sum(net_amount) as tot_net_amount from purchase_schedule 
                        where purchase_id = '$property_id' and status = '1' and 
                        event_type = 'Non agreement value') A 
                        group by event_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $other_charges=0;
                    for($j=0; $j<count($result); $j++) {
                        $tot_net_amount=is_numeric($result[$j]->tot_net_amount)?$result[$j]->tot_net_amount:0;
                        if(strtoupper(trim($result[$j]->event_name))=='VAT ON BASIC') {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='STAMP DUTY') {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='BROKERAGE') {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else {
                            $other_charges = $other_charges + $tot_net_amount;
                        }
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[36+$owner_cnt].strval($row), '='.$other_charges);
                }

                $sql = "select sum(tax_amount) as tot_service_tax from purchase_schedule_taxation where pur_id = '$property_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_service_tax=is_numeric($result[0]->tot_service_tax)?$result[0]->tot_service_tax:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '='.$tot_service_tax);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), '=SUM('.$col_name[31+$owner_cnt].strval($row).':'.$col_name[36+$owner_cnt].strval($row).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '='.$col_name[21+$owner_cnt].strval($row).'*'.$col_name[27+$owner_cnt].strval($row));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '='.$col_name[21+$owner_cnt].strval($row).'*'.$col_name[28+$owner_cnt].strval($row));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '='.$col_name[21+$owner_cnt].strval($row).'*'.$col_name[29+$owner_cnt].strval($row));

                $sql = "select sum(tax_amount) as tot_tds from actual_schedule_taxes 
                        where id in (select id from (select tax_applied, max(id) as id from actual_schedule_taxes 
                        where table_type = 'purchase' and fk_txn_id = '$property_id' and status = '1' group by tax_applied) A)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_tds=isset($result[0]->tot_tds)?$result[0]->tot_tds:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '='.$tot_tds);
                }

                $sql = "select * from pending_activity where ref_id = '$property_id' and type='purchase'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[60+$owner_cnt].strval($row), $pending_activity);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[62+$owner_cnt].strval($row), $data[$i]->remarks);
            }


            if($data[$i]->sp_name!=""){
                $sp_carpet_area = convert_to_feet($data[$i]->sp_carpet_area, $data[$i]->sp_carpet_area_unit);
                $sp_builtup_area = convert_to_feet($data[$i]->sp_builtup_area, $data[$i]->sp_builtup_area_unit);
                $sp_sellable_area = convert_to_feet($data[$i]->sp_sellable_area, $data[$i]->sp_sellable_area_unit);

                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $data[$i]->sp_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), $sp_carpet_area);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), $sp_builtup_area);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), $sp_sellable_area);
            }

            $pending_activity = "";

            if($sub_property_id!=0){
                $sql = "select * from pending_activity where ref_id = '$sub_property_id' and type='allocation'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[60+$owner_cnt].strval($row), $pending_activity);
                }
            }

            $sql = "select A.loan_id, B.* from 
                    (select * from loan_property_details where property_id = '$property_id' and 
                        loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                    left join 
                    (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                    on A.loan_id = B.txn_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_id=$result[0]->loan_id;
                $bank_name=$result[0]->financial_institution;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[45+$owner_cnt].strval($row), $bank_name);

                $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
                $loan_emi=0;
                $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

                $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
                }

                $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                        where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                    $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
                }

                $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                } else {
                    $loan_outstanding = 0;
                }

                $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

                $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                } else {
                    $tot_paid_amount = 0;
                }

                $loan_outstanding = $loan_outstanding - $tot_paid_amount;

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[46+$owner_cnt].strval($row), '='.$loan_outstanding);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[47+$owner_cnt].strval($row), '='.$loan_interest_rate);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '='.$loan_emi);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '='.$outstanding_agreement_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '='.($outstanding_agreement_amount+$loan_outstanding));
            }


            $sql = "select * from rent_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $rent_amount=isset($result[0]->rent_amount)?$result[0]->rent_amount:0;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[52+$owner_cnt].strval($row), '=('.$rent_amount.'*12)');

                $maintenance_by = isset($result[0]->maintenance_by)?$result[0]->maintenance_by:'Owner';
                $property_tax_by = isset($result[0]->property_tax_by)?$result[0]->property_tax_by:'Owner';
            } else {
                $maintenance_by = 'Owner';
                $property_tax_by = 'Owner';
            }

            $sql = "select * from maintenance_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $m_id=isset($result[0]->txn_id)?$result[0]->txn_id:0;

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and (particular = 'CAMP (Rs. PSF)' or particular = 'Maintenance')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[53+$owner_cnt].strval($row), '='.$cost);
                }

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and particular = 'Property Tax'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '='.$cost);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[54+$owner_cnt].strval($row), $maintenance_by);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[56+$owner_cnt].strval($row), $property_tax_by);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '='.$col_name[52+$owner_cnt].strval($row).'-(IF('.$col_name[54+$owner_cnt].strval($row).'="Owner",'.$col_name[53+$owner_cnt].strval($row).',0)+IF('.$col_name[56+$owner_cnt].strval($row).'="Owner",'.$col_name[55+$owner_cnt].strval($row).',0))');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[58+$owner_cnt].strval($row), '=if('.$col_name[31+$owner_cnt].strval($row).'=0,0,'.$col_name[60+$owner_cnt].strval($row).'/'.$col_name[31+$owner_cnt].strval($row).')');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[58+$owner_cnt].strval($row), 0);
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), '=sum('.$col_name[21+$owner_cnt].strval($s_row).':'.$col_name[21+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), '=sum('.$col_name[24+$owner_cnt].strval($s_row).':'.$col_name[24+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$col_name[26+$owner_cnt].strval($s_row).':'.$col_name[26+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$col_name[27+$owner_cnt].strval($s_row).':'.$col_name[27+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$col_name[28+$owner_cnt].strval($s_row).':'.$col_name[28+$owner_cnt].strval($row-1).')');
        //$objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$owner_cnt].strval($row), '=sum('.$col_name[29+$owner_cnt].strval($s_row).':'.$col_name[29+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$col_name[31+$owner_cnt].strval($s_row).':'.$col_name[31+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$col_name[32+$owner_cnt].strval($s_row).':'.$col_name[32+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$col_name[33+$owner_cnt].strval($s_row).':'.$col_name[33+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$col_name[34+$owner_cnt].strval($s_row).':'.$col_name[34+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$col_name[35+$owner_cnt].strval($s_row).':'.$col_name[35+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[36+$owner_cnt].strval($row), '=sum('.$col_name[36+$owner_cnt].strval($s_row).':'.$col_name[36+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), '=sum('.$col_name[37+$owner_cnt].strval($s_row).':'.$col_name[37+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=sum('.$col_name[39+$owner_cnt].strval($s_row).':'.$col_name[39+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$col_name[40+$owner_cnt].strval($s_row).':'.$col_name[40+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$col_name[41+$owner_cnt].strval($s_row).':'.$col_name[41+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$col_name[43+$owner_cnt].strval($s_row).':'.$col_name[43+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[46+$owner_cnt].strval($row), '=sum('.$col_name[46+$owner_cnt].strval($s_row).':'.$col_name[46+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '=sum('.$col_name[48+$owner_cnt].strval($s_row).':'.$col_name[48+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '=sum('.$col_name[49+$owner_cnt].strval($s_row).':'.$col_name[49+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '=sum('.$col_name[50+$owner_cnt].strval($s_row).':'.$col_name[50+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[52+$owner_cnt].strval($row), '=sum('.$col_name[52+$owner_cnt].strval($s_row).':'.$col_name[52+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[53+$owner_cnt].strval($row), '=sum('.$col_name[53+$owner_cnt].strval($s_row).':'.$col_name[53+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '=sum('.$col_name[55+$owner_cnt].strval($s_row).':'.$col_name[55+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '=sum('.$col_name[57+$owner_cnt].strval($s_row).':'.$col_name[57+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[58+$owner_cnt].strval($row), '=average('.$col_name[58+$owner_cnt].strval($s_row).':'.$col_name[58+$owner_cnt].strval($row-1).')');

        $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
        $tot_col[21+$owner_cnt] = $tot_col[21+$owner_cnt] . $col_name[21+$owner_cnt].strval($row) . ',';
        $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
        $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
        $tot_col[24+$owner_cnt] = $tot_col[24+$owner_cnt] . $col_name[24+$owner_cnt].strval($row) . ',';
        $tot_col[26+$owner_cnt] = $tot_col[26+$owner_cnt] . $col_name[26+$owner_cnt].strval($row) . ',';
        $tot_col[27+$owner_cnt] = $tot_col[27+$owner_cnt] . $col_name[27+$owner_cnt].strval($row) . ',';
        $tot_col[28+$owner_cnt] = $tot_col[28+$owner_cnt] . $col_name[28+$owner_cnt].strval($row) . ',';
        //$tot_col[29+$owner_cnt] = $tot_col[29+$owner_cnt] . $col_name[29+$owner_cnt].strval($row) . ',';
        $tot_col[31+$owner_cnt] = $tot_col[31+$owner_cnt] . $col_name[31+$owner_cnt].strval($row) . ',';
        $tot_col[32+$owner_cnt] = $tot_col[32+$owner_cnt] . $col_name[32+$owner_cnt].strval($row) . ',';
        $tot_col[33+$owner_cnt] = $tot_col[33+$owner_cnt] . $col_name[33+$owner_cnt].strval($row) . ',';
        $tot_col[34+$owner_cnt] = $tot_col[34+$owner_cnt] . $col_name[34+$owner_cnt].strval($row) . ',';
        $tot_col[35+$owner_cnt] = $tot_col[35+$owner_cnt] . $col_name[35+$owner_cnt].strval($row) . ',';
        $tot_col[36+$owner_cnt] = $tot_col[36+$owner_cnt] . $col_name[36+$owner_cnt].strval($row) . ',';
        $tot_col[37+$owner_cnt] = $tot_col[37+$owner_cnt] . $col_name[37+$owner_cnt].strval($row) . ',';
        $tot_col[39+$owner_cnt] = $tot_col[39+$owner_cnt] . $col_name[39+$owner_cnt].strval($row) . ',';
        $tot_col[40+$owner_cnt] = $tot_col[40+$owner_cnt] . $col_name[40+$owner_cnt].strval($row) . ',';
        $tot_col[41+$owner_cnt] = $tot_col[41+$owner_cnt] . $col_name[41+$owner_cnt].strval($row) . ',';
        $tot_col[43+$owner_cnt] = $tot_col[43+$owner_cnt] . $col_name[43+$owner_cnt].strval($row) . ',';
        $tot_col[46+$owner_cnt] = $tot_col[46+$owner_cnt] . $col_name[46+$owner_cnt].strval($row) . ',';
        $tot_col[48+$owner_cnt] = $tot_col[48+$owner_cnt] . $col_name[48+$owner_cnt].strval($row) . ',';
        $tot_col[49+$owner_cnt] = $tot_col[49+$owner_cnt] . $col_name[49+$owner_cnt].strval($row) . ',';
        $tot_col[50+$owner_cnt] = $tot_col[50+$owner_cnt] . $col_name[50+$owner_cnt].strval($row) . ',';
        $tot_col[52+$owner_cnt] = $tot_col[52+$owner_cnt] . $col_name[52+$owner_cnt].strval($row) . ',';
        $tot_col[53+$owner_cnt] = $tot_col[53+$owner_cnt] . $col_name[53+$owner_cnt].strval($row) . ',';
        $tot_col[55+$owner_cnt] = $tot_col[55+$owner_cnt] . $col_name[55+$owner_cnt].strval($row) . ',';
        $tot_col[57+$owner_cnt] = $tot_col[57+$owner_cnt] . $col_name[57+$owner_cnt].strval($row) . ',';
        $tot_col[58+$owner_cnt] = $tot_col[58+$owner_cnt] . $col_name[58+$owner_cnt].strval($row) . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Grand Total');

        $tot_col[8+$owner_cnt] = substr($tot_col[8+$owner_cnt], 0, strlen($tot_col[8+$owner_cnt])-1);
        $tot_col[21+$owner_cnt] = substr($tot_col[21+$owner_cnt], 0, strlen($tot_col[21+$owner_cnt])-1);
        $tot_col[22+$owner_cnt] = substr($tot_col[22+$owner_cnt], 0, strlen($tot_col[22+$owner_cnt])-1);
        $tot_col[23+$owner_cnt] = substr($tot_col[23+$owner_cnt], 0, strlen($tot_col[23+$owner_cnt])-1);
        $tot_col[24+$owner_cnt] = substr($tot_col[24+$owner_cnt], 0, strlen($tot_col[24+$owner_cnt])-1);
        $tot_col[26+$owner_cnt] = substr($tot_col[26+$owner_cnt], 0, strlen($tot_col[26+$owner_cnt])-1);
        $tot_col[27+$owner_cnt] = substr($tot_col[27+$owner_cnt], 0, strlen($tot_col[27+$owner_cnt])-1);
        $tot_col[28+$owner_cnt] = substr($tot_col[28+$owner_cnt], 0, strlen($tot_col[28+$owner_cnt])-1);
        //$tot_col[29+$owner_cnt] = substr($tot_col[29+$owner_cnt], 0, strlen($tot_col[29+$owner_cnt])-1);
        $tot_col[31+$owner_cnt] = substr($tot_col[31+$owner_cnt], 0, strlen($tot_col[31+$owner_cnt])-1);
        $tot_col[32+$owner_cnt] = substr($tot_col[32+$owner_cnt], 0, strlen($tot_col[32+$owner_cnt])-1);
        $tot_col[33+$owner_cnt] = substr($tot_col[33+$owner_cnt], 0, strlen($tot_col[33+$owner_cnt])-1);
        $tot_col[34+$owner_cnt] = substr($tot_col[34+$owner_cnt], 0, strlen($tot_col[34+$owner_cnt])-1);
        $tot_col[35+$owner_cnt] = substr($tot_col[35+$owner_cnt], 0, strlen($tot_col[35+$owner_cnt])-1);
        $tot_col[36+$owner_cnt] = substr($tot_col[36+$owner_cnt], 0, strlen($tot_col[36+$owner_cnt])-1);
        $tot_col[37+$owner_cnt] = substr($tot_col[37+$owner_cnt], 0, strlen($tot_col[37+$owner_cnt])-1);
        $tot_col[39+$owner_cnt] = substr($tot_col[39+$owner_cnt], 0, strlen($tot_col[39+$owner_cnt])-1);
        $tot_col[40+$owner_cnt] = substr($tot_col[40+$owner_cnt], 0, strlen($tot_col[40+$owner_cnt])-1);
        $tot_col[41+$owner_cnt] = substr($tot_col[41+$owner_cnt], 0, strlen($tot_col[41+$owner_cnt])-1);
        $tot_col[43+$owner_cnt] = substr($tot_col[43+$owner_cnt], 0, strlen($tot_col[43+$owner_cnt])-1);
        $tot_col[46+$owner_cnt] = substr($tot_col[46+$owner_cnt], 0, strlen($tot_col[46+$owner_cnt])-1);
        $tot_col[48+$owner_cnt] = substr($tot_col[48+$owner_cnt], 0, strlen($tot_col[48+$owner_cnt])-1);
        $tot_col[49+$owner_cnt] = substr($tot_col[49+$owner_cnt], 0, strlen($tot_col[49+$owner_cnt])-1);
        $tot_col[50+$owner_cnt] = substr($tot_col[50+$owner_cnt], 0, strlen($tot_col[50+$owner_cnt])-1);
        $tot_col[52+$owner_cnt] = substr($tot_col[52+$owner_cnt], 0, strlen($tot_col[52+$owner_cnt])-1);
        $tot_col[53+$owner_cnt] = substr($tot_col[53+$owner_cnt], 0, strlen($tot_col[53+$owner_cnt])-1);
        $tot_col[55+$owner_cnt] = substr($tot_col[55+$owner_cnt], 0, strlen($tot_col[55+$owner_cnt])-1);
        $tot_col[57+$owner_cnt] = substr($tot_col[57+$owner_cnt], 0, strlen($tot_col[57+$owner_cnt])-1);
        $tot_col[58+$owner_cnt] = substr($tot_col[58+$owner_cnt], 0, strlen($tot_col[58+$owner_cnt])-1);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$tot_col[8+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), '=sum('.$tot_col[21+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$tot_col[22+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$tot_col[23+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), '=sum('.$tot_col[24+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$tot_col[26+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$tot_col[27+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$tot_col[28+$owner_cnt].')');
        //$objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$owner_cnt].strval($row), '=sum('.$tot_col[29+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$tot_col[31+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$tot_col[32+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$tot_col[33+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$tot_col[34+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$tot_col[35+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[36+$owner_cnt].strval($row), '=sum('.$tot_col[36+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), '=sum('.$tot_col[37+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=sum('.$tot_col[39+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$tot_col[40+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$tot_col[41+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$tot_col[43+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[46+$owner_cnt].strval($row), '=sum('.$tot_col[46+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '=sum('.$tot_col[48+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '=sum('.$tot_col[49+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '=sum('.$tot_col[50+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[52+$owner_cnt].strval($row), '=sum('.$tot_col[52+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[53+$owner_cnt].strval($row), '=sum('.$tot_col[53+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '=sum('.$tot_col[55+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '=sum('.$tot_col[57+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[58+$owner_cnt].strval($row), '=average('.$tot_col[58+$owner_cnt].')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[62+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[9+$owner_cnt].'6:'.$col_name[9+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[15+$owner_cnt].'6:'.$col_name[15+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[20+$owner_cnt].'6:'.$col_name[20+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[25+$owner_cnt].'6:'.$col_name[25+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[30+$owner_cnt].'6:'.$col_name[30+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[38+$owner_cnt].'6:'.$col_name[38+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[42+$owner_cnt].'6:'.$col_name[42+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[44+$owner_cnt].'6:'.$col_name[44+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[51+$owner_cnt].'6:'.$col_name[51+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[59+$owner_cnt].'6:'.$col_name[59+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[61+$owner_cnt].'6:'.$col_name[61+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));

        $objPHPExcel->getActiveSheet()->removeColumn($col_name[6+$owner_cnt], 2);

        $filename='Group_Level_Asset_Allocation_Usage_Wise_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Asset Allocation-Usage wise report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function get_property_usage_wise_related_parties($from_date, $to_date){
    $gid=$this->session->userdata('groupid');
    if($from_date!='' && $to_date!='')
        $and = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and = "";

    $sql = "select AA.*, BB.contact_id, BB.c_name, BB.c_last_name, BB.c_address, BB.c_landmark, BB.c_city, BB.c_pincode, BB.c_state, BB.c_country, BB.c_mobile1, BB.c_emailid1, BB.kyc_doc_ref, BB.contact_type from 
            (select * from 
            (select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    null as sp_id, null as sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and) A 
            union all
            select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    B.txn_id as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            order by asset_type, p_usage, txn_id, sp_id) AA 
            left join 
            (select E.*, F.contact_type from 
            (select C.*, D.c_name, D.c_last_name, D.c_address, D.c_landmark, D.c_city, D.c_pincode, D.c_state, D.c_country, D.c_mobile1, D.c_emailid1, D.c_contact_type, 
            D.kyc_doc_ref from 
            (select ref_id, ref_id as property_id, null as sub_property_id, contact_id from related_party_details where type = 'purchase' 
            union all 
            select A.ref_id, B.property_id, B.sub_property_id, A.contact_id from 
            (select ref_id, contact_id from related_party_details where type = 'sale') A 
            left join 
            (select * from sales_txn where gp_id='$gid' and txn_status='Approved') B 
            on (A.ref_id = B.txn_id) 
            union all 
            select A.ref_id, B.property_id, B.sub_property_id, A.contact_id from 
            (select ref_id, contact_id from related_party_details where type = 'rent') A 
            left join 
            (select * from rent_txn where gp_id='$gid' and txn_status='Approved') B 
            on (A.ref_id = B.txn_id)) C 
            left join 
            (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
            (select * from contact_master where c_gid='$gid' and c_status='Approved') A 
            left join 
            (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
            on (A.c_id = B.kyc_cid)) D 
            on (C.contact_id=D.c_id)) E 
            left join 
            (select * from contact_type_master) F 
            on (E.c_contact_type = F.id) where F.contact_type is not null) BB 
            on (ifnull(AA.txn_id,0) = ifnull(BB.property_id,0) and ifnull(AA.sp_id,0) = ifnull(BB.sub_property_id,0))
            order by AA.asset_type, AA.p_usage, AA.txn_id, AA.sp_id";

    $query=$this->db->query($sql);
    // echo $this->db->last_query();
    $result=$query->result();
    return $result;
}

function generate_group_level_related_party_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_max_property_owner_cnt($from_date, $to_date);
    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_property_usage_wise_related_parties($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Related_Party.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Related_Party.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        // $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('D', $owner_cnt);
            $col=3;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('969696');
                $col=$col+2;
            }
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].'1', $this->session->userdata('groupname'));

        $tot_col = array();
        // $tot_col['tot_'.PHPExcel_Cell::stringFromColumnIndex(9+$owner_cnt).'_col'] = "";
        // $tot_col[8+$owner_cnt] = "";

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if ($prev_property_id!=$property_id){
                if($row!=6){
                   // $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Total');
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
                    // $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }
            }
            
            if($prev_asset_type!=$asset_type) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $asset_type);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'D9D9D9'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $row=$row+1;

                if($prev_p_usage!=$p_usage) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $p_usage);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'F2F2F2'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $row=$row+1;
                    $sr_no=1;
                    $prev_p_usage=$p_usage;
                    $prev_property_id="";
                }

                $prev_asset_type=$asset_type;
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=3;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), $address);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$owner_cnt].strval($row), $data[$i]->p_status);
                $agreement_area = 0;
                $pending_activity = "";

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), $data[$i]->remarks);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $data[$i]->contact_type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), $data[$i]->c_name . ' ' . $data[$i]->c_last_name);
            $address = get_address($data[$i]->c_address, $data[$i]->c_landmark, $data[$i]->c_city, $data[$i]->c_pincode, $data[$i]->c_state, $data[$i]->c_country);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), $address);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), $data[$i]->c_mobile1);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $data[$i]->c_emailid1);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), $data[$i]->kyc_doc_ref);

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        //$objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Total');
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
        // $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

       // $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Grand Total');
        // $tot_col[8+$owner_cnt] = substr($tot_col[8+$owner_cnt], 0, strlen($tot_col[8+$owner_cnt])-1);
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$tot_col[8+$owner_cnt].')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[13+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[5+$owner_cnt].'6:'.$col_name[5+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[12+$owner_cnt].'6:'.$col_name[12+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[13+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[13+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $filename='Group_Level_Related_Party_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Related Party report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}

function generate_group_level_maintenance_property_tax_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_max_property_owner_cnt($from_date, $to_date);
    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_property_usage_wise($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Maintenance_Property_Tax.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Maintenance_Property_Tax.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', $owner_cnt);
            $col=4;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('969696');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A4:'.$col_name[3+$owner_cnt].'4');
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));

        $tot_col = array();
        $tot_col[5+$owner_cnt] = "";
        $tot_col[6+$owner_cnt] = "";
        $tot_col[8+$owner_cnt] = "";
        $tot_col[9+$owner_cnt] = "";
        $tot_col[11+$owner_cnt] = "";
        $tot_col[13+$owner_cnt] = "";
        $tot_col[14+$owner_cnt] = "";
        $tot_col[15+$owner_cnt] = "";
        $tot_col[16+$owner_cnt] = "";
        $tot_col[18+$owner_cnt] = "";
        $tot_col[20+$owner_cnt] = "";
        $tot_col[22+$owner_cnt] = "";
        $tot_col[23+$owner_cnt] = "";

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if ($prev_property_id!=$property_id){
                if($row!=6){
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Total');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$col_name[5+$owner_cnt].strval($s_row).':'.$col_name[5+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$col_name[6+$owner_cnt].strval($s_row).':'.$col_name[6+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$col_name[9+$owner_cnt].strval($s_row).':'.$col_name[9+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$col_name[11+$owner_cnt].strval($s_row).':'.$col_name[11+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$col_name[13+$owner_cnt].strval($s_row).':'.$col_name[13+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '=sum('.$col_name[14+$owner_cnt].strval($s_row).':'.$col_name[14+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$col_name[15+$owner_cnt].strval($s_row).':'.$col_name[15+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$col_name[16+$owner_cnt].strval($s_row).':'.$col_name[16+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$col_name[20+$owner_cnt].strval($s_row).':'.$col_name[20+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
                    
                    $tot_col[5+$owner_cnt] = $tot_col[5+$owner_cnt] . $col_name[5+$owner_cnt].strval($row) . ',';
                    $tot_col[6+$owner_cnt] = $tot_col[6+$owner_cnt] . $col_name[6+$owner_cnt].strval($row) . ',';
                    $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
                    $tot_col[9+$owner_cnt] = $tot_col[9+$owner_cnt] . $col_name[9+$owner_cnt].strval($row) . ',';
                    $tot_col[11+$owner_cnt] = $tot_col[11+$owner_cnt] . $col_name[11+$owner_cnt].strval($row) . ',';
                    $tot_col[13+$owner_cnt] = $tot_col[13+$owner_cnt] . $col_name[13+$owner_cnt].strval($row) . ',';
                    $tot_col[14+$owner_cnt] = $tot_col[14+$owner_cnt] . $col_name[14+$owner_cnt].strval($row) . ',';
                    $tot_col[15+$owner_cnt] = $tot_col[15+$owner_cnt] . $col_name[15+$owner_cnt].strval($row) . ',';
                    $tot_col[16+$owner_cnt] = $tot_col[16+$owner_cnt] . $col_name[16+$owner_cnt].strval($row) . ',';
                    $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
                    $tot_col[20+$owner_cnt] = $tot_col[20+$owner_cnt] . $col_name[20+$owner_cnt].strval($row) . ',';
                    $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
                    $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }
            }
            
            if($prev_asset_type!=$asset_type) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $asset_type);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'D9D9D9'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $row=$row+1;

                if($prev_p_usage!=$p_usage) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $p_usage);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'F2F2F2'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $row=$row+1;
                    $sr_no=1;
                    $prev_p_usage=$p_usage;
                    $prev_property_id="";
                }

                $prev_asset_type=$asset_type;
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=4;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), $address);
                $agreement_area = 0;
                $pending_activity = "";

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $agreement_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $carpet_area);
                }

                $sql = "select * from pending_activity where ref_id = '$property_id' and type='purchase'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), $pending_activity);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), $data[$i]->remarks);
            }

            if($data[$i]->sp_name!=""){
                $sp_carpet_area = convert_to_feet($data[$i]->sp_carpet_area, $data[$i]->sp_carpet_area_unit);

                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $sp_carpet_area);
            }

            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
            $pending_activity = "";

            if($sub_property_id!=0){
                $sql = "select * from pending_activity where ref_id = '$sub_property_id' and type='allocation'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), $pending_activity);
                }
            }

            if($sub_property_id==0){
                $cond = "and (sub_property_id is null or sub_property_id = '0')";
            } else {
                $cond = "and sub_property_id = '$sub_property_id'";
            }

            $sql = "select * from rent_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $maintenance_by = isset($result[0]->maintenance_by)?$result[0]->maintenance_by:'Owner';
                $property_tax_by = isset($result[0]->property_tax_by)?$result[0]->property_tax_by:'Owner';
            } else {
                $maintenance_by = 'Owner';
                $property_tax_by = 'Owner';
            }

            $sql = "select * from maintenance_txn where property_id = '$property_id' and txn_status = 'Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $m_id=isset($result[0]->txn_id)?$result[0]->txn_id:0;

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and (particular = 'CAMP (Rs. PSF)' or particular = 'Maintenance')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '='.$cost);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=if('.$col_name[5+$owner_cnt].strval($row).'=0,0,'.$col_name[11+$owner_cnt].$row.'/'.$col_name[5+$owner_cnt].$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $maintenance_by);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '=IF('.$col_name[10+$owner_cnt].$row.'="Owner",'.$col_name[11+$owner_cnt].$row.',0)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '='.$col_name[12+$owner_cnt].$row.'*12');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '='.$col_name[15+$owner_cnt].$row.'*'.$col_name[11+$owner_cnt].$row);

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and particular = 'Property Tax'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=isset($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '='.$cost);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=if('.$col_name[5+$owner_cnt].strval($row).'=0,0,'.$col_name[20+$owner_cnt].$row.'/'.$col_name[5+$owner_cnt].$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), $property_tax_by);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), '=IF('.$col_name[19+$owner_cnt].$row.'="Owner",'.$col_name[20+$owner_cnt].$row.',0)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '='.$col_name[21+$owner_cnt].$row.'*12');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '');
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$col_name[5+$owner_cnt].strval($s_row).':'.$col_name[5+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$col_name[6+$owner_cnt].strval($s_row).':'.$col_name[6+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$col_name[9+$owner_cnt].strval($s_row).':'.$col_name[9+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$col_name[11+$owner_cnt].strval($s_row).':'.$col_name[11+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$col_name[13+$owner_cnt].strval($s_row).':'.$col_name[13+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '=sum('.$col_name[14+$owner_cnt].strval($s_row).':'.$col_name[14+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$col_name[15+$owner_cnt].strval($s_row).':'.$col_name[15+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$col_name[16+$owner_cnt].strval($s_row).':'.$col_name[16+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$col_name[20+$owner_cnt].strval($s_row).':'.$col_name[20+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');

        $tot_col[5+$owner_cnt] = $tot_col[5+$owner_cnt] . $col_name[5+$owner_cnt].strval($row) . ',';
        $tot_col[6+$owner_cnt] = $tot_col[6+$owner_cnt] . $col_name[6+$owner_cnt].strval($row) . ',';
        $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
        $tot_col[9+$owner_cnt] = $tot_col[9+$owner_cnt] . $col_name[9+$owner_cnt].strval($row) . ',';
        $tot_col[11+$owner_cnt] = $tot_col[11+$owner_cnt] . $col_name[11+$owner_cnt].strval($row) . ',';
        $tot_col[13+$owner_cnt] = $tot_col[13+$owner_cnt] . $col_name[13+$owner_cnt].strval($row) . ',';
        $tot_col[14+$owner_cnt] = $tot_col[14+$owner_cnt] . $col_name[14+$owner_cnt].strval($row) . ',';
        $tot_col[15+$owner_cnt] = $tot_col[15+$owner_cnt] . $col_name[15+$owner_cnt].strval($row) . ',';
        $tot_col[16+$owner_cnt] = $tot_col[16+$owner_cnt] . $col_name[16+$owner_cnt].strval($row) . ',';
        $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
        $tot_col[20+$owner_cnt] = $tot_col[20+$owner_cnt] . $col_name[20+$owner_cnt].strval($row) . ',';
        $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
        $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Grand Total');

        $tot_col[5+$owner_cnt] = substr($tot_col[5+$owner_cnt], 0, strlen($tot_col[5+$owner_cnt])-1);
        $tot_col[6+$owner_cnt] = substr($tot_col[6+$owner_cnt], 0, strlen($tot_col[6+$owner_cnt])-1);
        $tot_col[8+$owner_cnt] = substr($tot_col[8+$owner_cnt], 0, strlen($tot_col[8+$owner_cnt])-1);
        $tot_col[9+$owner_cnt] = substr($tot_col[9+$owner_cnt], 0, strlen($tot_col[9+$owner_cnt])-1);
        $tot_col[11+$owner_cnt] = substr($tot_col[11+$owner_cnt], 0, strlen($tot_col[11+$owner_cnt])-1);
        $tot_col[13+$owner_cnt] = substr($tot_col[13+$owner_cnt], 0, strlen($tot_col[13+$owner_cnt])-1);
        $tot_col[14+$owner_cnt] = substr($tot_col[14+$owner_cnt], 0, strlen($tot_col[14+$owner_cnt])-1);
        $tot_col[15+$owner_cnt] = substr($tot_col[15+$owner_cnt], 0, strlen($tot_col[15+$owner_cnt])-1);
        $tot_col[16+$owner_cnt] = substr($tot_col[16+$owner_cnt], 0, strlen($tot_col[16+$owner_cnt])-1);
        $tot_col[18+$owner_cnt] = substr($tot_col[18+$owner_cnt], 0, strlen($tot_col[18+$owner_cnt])-1);
        $tot_col[20+$owner_cnt] = substr($tot_col[20+$owner_cnt], 0, strlen($tot_col[20+$owner_cnt])-1);
        $tot_col[22+$owner_cnt] = substr($tot_col[22+$owner_cnt], 0, strlen($tot_col[22+$owner_cnt])-1);
        $tot_col[23+$owner_cnt] = substr($tot_col[23+$owner_cnt], 0, strlen($tot_col[23+$owner_cnt])-1);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$tot_col[5+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$tot_col[6+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$tot_col[8+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$tot_col[9+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$tot_col[11+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$tot_col[13+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '=sum('.$tot_col[14+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$tot_col[15+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$tot_col[16+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$tot_col[18+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$tot_col[20+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$tot_col[22+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$tot_col[23+$owner_cnt].')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[4+$owner_cnt].'6:'.$col_name[4+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[7+$owner_cnt].'6:'.$col_name[7+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[17+$owner_cnt].'6:'.$col_name[17+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[24+$owner_cnt].'6:'.$col_name[24+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[26+$owner_cnt].'6:'.$col_name[26+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[27+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[27+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $filename='Group_Level_Maintenance_Property_Tax_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Maintenance Property Tax report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}


function get_loan_properties($from_date, $to_date) {
    $gid=$this->session->userdata('groupid');
    if($from_date!='' && $to_date!='')
        $and = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and = "";

    $sql = "select * from 
            (select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    null as sp_id, null as sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and and 
                txn_id in(select distinct property_id from loan_property_details 
                    where loan_id in(select distinct txn_id from loan_txn where txn_status='Approved'))) A 
            union all 
            select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    B.txn_id as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and  and 
                txn_id in(select distinct property_id from loan_property_details 
                    where loan_id in(select distinct txn_id from loan_txn where gp_id='$gid' and txn_status='Approved'))) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            order by asset_type, p_usage, txn_id, sp_id";

    $query=$this->db->query($sql);
    // echo $this->db->last_query();
    $result=$query->result();
    return $result;
}

function generate_group_level_loan_details_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_max_property_owner_cnt($from_date, $to_date);
    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_loan_properties($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Loan_Details.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Loan_Details.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', $owner_cnt);
            $col=4;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('969696');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A4:'.$col_name[3+$owner_cnt].'4');
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));

        $tot_col = array();
        $tot_col[5+$owner_cnt] = "";
        $tot_col[6+$owner_cnt] = "";
        $tot_col[7+$owner_cnt] = "";
        $tot_col[8+$owner_cnt] = "";
        $tot_col[17+$owner_cnt] = "";
        $tot_col[18+$owner_cnt] = "";
        $tot_col[19+$owner_cnt] = "";
        $tot_col[20+$owner_cnt] = "";
        $tot_col[23+$owner_cnt] = "";

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if ($prev_property_id!=$property_id){
                if($row!=6){
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Total');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$col_name[5+$owner_cnt].strval($s_row).':'.$col_name[5+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$col_name[6+$owner_cnt].strval($s_row).':'.$col_name[6+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), '=sum('.$col_name[7+$owner_cnt].strval($s_row).':'.$col_name[7+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$col_name[17+$owner_cnt].strval($s_row).':'.$col_name[17+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$col_name[19+$owner_cnt].strval($s_row).':'.$col_name[19+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$col_name[20+$owner_cnt].strval($s_row).':'.$col_name[20+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
                    
                    $tot_col[5+$owner_cnt] = $tot_col[5+$owner_cnt] . $col_name[5+$owner_cnt].strval($row) . ',';
                    $tot_col[6+$owner_cnt] = $tot_col[6+$owner_cnt] . $col_name[6+$owner_cnt].strval($row) . ',';
                    $tot_col[7+$owner_cnt] = $tot_col[7+$owner_cnt] . $col_name[7+$owner_cnt].strval($row) . ',';
                    $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
                    $tot_col[17+$owner_cnt] = $tot_col[17+$owner_cnt] . $col_name[17+$owner_cnt].strval($row) . ',';
                    $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
                    $tot_col[19+$owner_cnt] = $tot_col[19+$owner_cnt] . $col_name[19+$owner_cnt].strval($row) . ',';
                    $tot_col[20+$owner_cnt] = $tot_col[20+$owner_cnt] . $col_name[20+$owner_cnt].strval($row) . ',';
                    $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }
            }
            
            if($prev_asset_type!=$asset_type) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $asset_type);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'D9D9D9'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $row=$row+1;

                if($prev_p_usage!=$p_usage) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $p_usage);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'F2F2F2'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $row=$row+1;
                    $sr_no=1;
                    $prev_p_usage=$p_usage;
                    $prev_property_id="";
                }

                $prev_asset_type=$asset_type;
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=4;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), $address);
                $agreement_area = 0;
                $pending_activity = "";

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $agreement_area);
                }

                $sql = "select sum(net_amount) as agreement_value from purchase_schedule where purchase_id = '$property_id' and status = '1' and event_type = 'Agreement Value'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_value = $result[0]->agreement_value;
                    if($agreement_area!=0){
                        $agreement_rate = $agreement_value/$agreement_area;
                    } else {
                        $agreement_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $agreement_rate);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), '=('.$col_name[5+$owner_cnt].$row.'*'.$col_name[6+$owner_cnt].$row.')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '='.$col_name[7+$owner_cnt].$row);
                }

                $sql = "select * from pending_activity where ref_id = '$property_id' and type='purchase'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), $pending_activity);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), $data[$i]->remarks);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
            $pending_activity = "";

            if($sub_property_id!=0){
                $sql = "select * from pending_activity where ref_id = '$sub_property_id' and type='allocation'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), $pending_activity);
                }
            }

            if($sub_property_id==0){
                $cond = "and (sub_property_id is null or sub_property_id = '0')";
            } else {
                $cond = "and sub_property_id = '$sub_property_id'";
            }

            $sql = "select A.loan_id, B.* from 
                    (select * from loan_property_details where property_id = '$property_id' and loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                    left join 
                    (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                    on A.loan_id = B.txn_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_id=$result[0]->loan_id;
                $bank_name=$result[0]->financial_institution;
                $loan_term=$result[0]->loan_term;
                $loan_startdate=$result[0]->loan_startdate;
                $loan_due_day=$result[0]->loan_due_day;
                if(is_numeric($loan_term)){
                    $loan_enddate = date('Y-m-d', strtotime("+" . $loan_term . " months", strtotime($loan_startdate)));
                } else {
                    $loan_enddate = $loan_startdate;
                }

                $loan_startdate = date('d-m-Y', strtotime($loan_startdate));
                $loan_enddate = date('d-m-Y', strtotime($loan_enddate));

                $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
                $loan_emi=0;
                $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

                $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
                }

                $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                        where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                    $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
                }

                $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                } else {
                    $loan_outstanding = 0;
                }

                $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

                $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount, sum(tds_amount) as tot_tds_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                    $tot_tds_amount = isset($result[0]->tot_tds_amount)?$result[0]->tot_tds_amount:0;
                } else {
                    $tot_paid_amount = 0;
                    $tot_tds_amount = 0;
                }

                $loan_outstanding = $loan_outstanding - $tot_paid_amount;

                $sql = "select sum(disbursement_amount) as tot_disbursement_amount from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_disbursement_amount = isset($result[0]->tot_disbursement_amount)?$result[0]->tot_disbursement_amount:0;
                } else {
                    $tot_disbursement_amount = 0;
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $bank_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), $loan_term);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), $loan_startdate);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), $loan_enddate);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), $loan_interest_rate/100);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '='.$loan_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '='.$tot_disbursement_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '='.$loan_outstanding);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '='.$outstanding_agreement_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '='.$col_name[17+$owner_cnt].$row.'+'.$col_name[18+$owner_cnt].$row);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '='.$loan_emi);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), $loan_due_day);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '='.$tot_tds_amount);
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$col_name[5+$owner_cnt].strval($s_row).':'.$col_name[5+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$col_name[6+$owner_cnt].strval($s_row).':'.$col_name[6+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), '=sum('.$col_name[7+$owner_cnt].strval($s_row).':'.$col_name[7+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$col_name[17+$owner_cnt].strval($s_row).':'.$col_name[17+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$col_name[19+$owner_cnt].strval($s_row).':'.$col_name[19+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$col_name[20+$owner_cnt].strval($s_row).':'.$col_name[20+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');

        $tot_col[5+$owner_cnt] = $tot_col[5+$owner_cnt] . $col_name[5+$owner_cnt].strval($row) . ',';
        $tot_col[6+$owner_cnt] = $tot_col[6+$owner_cnt] . $col_name[6+$owner_cnt].strval($row) . ',';
        $tot_col[7+$owner_cnt] = $tot_col[7+$owner_cnt] . $col_name[7+$owner_cnt].strval($row) . ',';
        $tot_col[8+$owner_cnt] = $tot_col[8+$owner_cnt] . $col_name[8+$owner_cnt].strval($row) . ',';
        $tot_col[17+$owner_cnt] = $tot_col[17+$owner_cnt] . $col_name[17+$owner_cnt].strval($row) . ',';
        $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
        $tot_col[19+$owner_cnt] = $tot_col[19+$owner_cnt] . $col_name[19+$owner_cnt].strval($row) . ',';
        $tot_col[20+$owner_cnt] = $tot_col[20+$owner_cnt] . $col_name[20+$owner_cnt].strval($row) . ',';
        $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), 'Grand Total');

        $tot_col[5+$owner_cnt] = substr($tot_col[5+$owner_cnt], 0, strlen($tot_col[5+$owner_cnt])-1);
        $tot_col[6+$owner_cnt] = substr($tot_col[6+$owner_cnt], 0, strlen($tot_col[6+$owner_cnt])-1);
        $tot_col[7+$owner_cnt] = substr($tot_col[7+$owner_cnt], 0, strlen($tot_col[7+$owner_cnt])-1);
        $tot_col[8+$owner_cnt] = substr($tot_col[8+$owner_cnt], 0, strlen($tot_col[8+$owner_cnt])-1);
        $tot_col[17+$owner_cnt] = substr($tot_col[17+$owner_cnt], 0, strlen($tot_col[17+$owner_cnt])-1);
        $tot_col[18+$owner_cnt] = substr($tot_col[18+$owner_cnt], 0, strlen($tot_col[18+$owner_cnt])-1);
        $tot_col[19+$owner_cnt] = substr($tot_col[19+$owner_cnt], 0, strlen($tot_col[19+$owner_cnt])-1);
        $tot_col[20+$owner_cnt] = substr($tot_col[20+$owner_cnt], 0, strlen($tot_col[20+$owner_cnt])-1);
        $tot_col[23+$owner_cnt] = substr($tot_col[23+$owner_cnt], 0, strlen($tot_col[23+$owner_cnt])-1);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), '=sum('.$tot_col[5+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$tot_col[6+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), '=sum('.$tot_col[7+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$tot_col[8+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$tot_col[17+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$tot_col[18+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$tot_col[19+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), '=sum('.$tot_col[20+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$tot_col[23+$owner_cnt].')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[27+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[4+$owner_cnt].'6:'.$col_name[4+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[9+$owner_cnt].'6:'.$col_name[9+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[22+$owner_cnt].'6:'.$col_name[22+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[24+$owner_cnt].'6:'.$col_name[24+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[26+$owner_cnt].'6:'.$col_name[26+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[27+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[27+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $filename='Group_Level_Loan_Details.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Loan Details report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}


function get_rent_properties($from_date, $to_date) {
    $gid=$this->session->userdata('groupid');
    // $sql = "select * from 
    //         (select C.*, D.owner_name, D.pr_client_id, D.pr_ownership_percent from 
    //         (select A.*, null as sp_id, null as sp_name from 
    //         (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' and 
    //             p_purchase_date>='$from_date' and p_purchase_date<='$to_date' and 
    //             txn_id in(select distinct property_id from rent_txn where txn_status = 'Approved')) A 
    //         union all 
    //         select A.*, B.txn_id as sp_id, B.sp_name from 
    //         (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' and 
    //             p_purchase_date>='$from_date' and p_purchase_date<='$to_date' and 
    //             txn_id in(select distinct property_id from rent_txn where txn_status = 'Approved')) A 
    //         left join 
    //         (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
    //         on (A.txn_id=B.property_id) where B.txn_id is not null) C 
    //         left join 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id) D 
    //         on C.txn_id=D.purchase_id) E 
    //         order by pr_client_id, txn_id";
     if($from_date!='' && $to_date!='')
        $and = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and = "";

    $sql = "select * from 
            (select C.*, D.owner_name, D.pr_client_id, D.pr_ownership_percent from 
            (select A.*, null as sp_id, null as sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and and 
                txn_id in(select distinct property_id from rent_txn where txn_status = 'Approved')) A 
            union all 
            select A.*, B.txn_id as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and and 
                txn_id in(select distinct property_id from rent_txn where txn_status = 'Approved')) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            left join 
            (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A) A 
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
            on C.txn_id=D.purchase_id) E 
            order by pr_client_id, txn_id";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_group_level_rent_summary_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $owner_cnt = 0;
    $data = $this->get_rent_properties($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Rent_Summary.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Rent_Summary.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        $col_name[]=array();
        $tot_col = 68+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $prev_sp_id="prev_sp_id";
        $sp_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue('C1', $this->session->userdata('groupname'));

        for($i=0; $i<count($data); $i++) {
            $property_id=$data[$i]->txn_id;
            $sp_id=$data[$i]->sp_id;

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $prev_sp_id="prev_sp_id";
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);
            }

            if($prev_sp_id!=$sp_id) {
                $prev_sp_id=$sp_id;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
                $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
                $pending_activity = "";

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[68+$owner_cnt].strval($row), $data[$i]->remarks);

                if($sub_property_id!=0){
                    $sql = "select * from sub_property_allocation where txn_id = '$sub_property_id' and txn_status='approved'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[68+$owner_cnt].strval($row), $result[0]->txn_remarks);
                    }
                }

                if($sub_property_id==0){
                    $cond = "and (sub_property_id is null or sub_property_id = '0')";
                } else {
                    $cond = "and sub_property_id = '$sub_property_id'";
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), $address);

                if($data[$i]->p_type=='Building' || $data[$i]->p_type=='Apartment' || $data[$i]->p_type=='Bunglow') {
                    $p_asset_type = 'Residential';
                } else {
                    $p_asset_type = 'Commercial';
                }

                $agreement_area = 0;
                $pending_activity = "";

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $p_asset_type);

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
                    $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
                    $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $agreement_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), $carpet_area);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), $no_of_parking);
                }

                $sql = "select sum(net_amount) as agreement_value from purchase_schedule where purchase_id = '$property_id' and status = '1' and event_type = 'Agreement Value'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_value = $result[0]->agreement_value;
                    if($agreement_area!=0){
                        $agreement_rate = $agreement_value/$agreement_area;
                    } else {
                        $agreement_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $agreement_rate);
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '='.$col_name[10+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row));

                $sql = "select * from (select case when event_name='Registration' then 'Stamp Duty' else event_name end as event_name, 
                        sum(net_amount) as tot_net_amount from purchase_schedule 
                        where purchase_id = '$property_id' and status = '1' and 
                        event_type = 'Non agreement value' group by event_name) A";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $other_charges=0;
                    for($j=0; $j<count($result); $j++) {
                        $tot_net_amount=is_numeric($result[$j]->tot_net_amount)?$result[$j]->tot_net_amount:0;
                        if(strtoupper(trim($result[$j]->event_name))=='VAT ON BASIC') {
                            // $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='STAMP DUTY') {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else if(strtoupper(trim($result[$j]->event_name))=='BROKERAGE') {
                            // $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '='.$tot_net_amount);
                        } else {
                            $other_charges = $other_charges + $tot_net_amount;
                        }
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '='.$other_charges);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '='.$col_name[11+$owner_cnt].strval($row).'+'.$col_name[12+$owner_cnt].strval($row).'+'.$col_name[13+$owner_cnt].strval($row));

                $sql = "select * from rent_txn where property_id = '$property_id' and txn_status = 'Approved' " . $cond;
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $deposit_amount=is_numeric($result[0]->deposit_amount)?$result[0]->deposit_amount:0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '='.$deposit_amount);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '='.$col_name[14+$owner_cnt].strval($row).'-'.$col_name[15+$owner_cnt].strval($row));
                    
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), $result[0]->possession_date);
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), $result[0]->termination_date);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), date('d-m-Y', strtotime($result[0]->possession_date)));
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), date('d-m-Y', strtotime($result[0]->termination_date)));

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[20+$owner_cnt].strval($row), $result[0]->rent_due_day);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), '');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=IF(((YEAR('.$col_name[19+$owner_cnt].strval($row).')-YEAR($A$1))*12)+(MONTH('.$col_name[19+$owner_cnt].strval($row).')-MONTH($A$1))<0,0,((YEAR('.$col_name[19+$owner_cnt].strval($row).')-YEAR($A$1))*12)+(MONTH('.$col_name[19+$owner_cnt].strval($row).')-MONTH($A$1)))');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=IF(((YEAR('.$col_name[21+$owner_cnt].strval($row).')-YEAR($A$1))*12)+(MONTH('.$col_name[21+$owner_cnt].strval($row).')-MONTH($A$1))<0,0,((YEAR('.$col_name[21+$owner_cnt].strval($row).')-YEAR($A$1))*12)+(MONTH('.$col_name[21+$owner_cnt].strval($row).')-MONTH($A$1)))');

                    $rent_id = $result[0]->txn_id;
                    $tenant_id = $result[0]->tenant_id;
                    $bl_esc = false;
                    $rent_amount=is_numeric($result[0]->rent_amount)?$result[0]->rent_amount:0;

                    $cur_date = new DateTime('now');
                    $possession_date = new DateTime($result[0]->possession_date);
                    $termination_date = new DateTime($result[0]->termination_date);

                    if($cur_date<$possession_date) {
                        $start_date = $possession_date;
                        $end_date = $possession_date;
                        $end_date->modify('+11 month');
                        if($end_date>$termination_date){
                            $end_date=$termination_date;
                        }
                        $possession_date = $start_date;
                        $termination_date = $end_date;
                    } else if($cur_date>$termination_date) {
                        $start_date = $termination_date;
                        $start_date->modify('-11 month');
                        if($start_date<$possession_date){
                            $start_date=$possession_date;
                        }
                        $end_date = $termination_date;
                        $possession_date = $start_date;
                        $termination_date = $end_date;
                    } else {
                        $start_date = $possession_date;
                        $end_date = $possession_date;
                        $end_date->modify('+11 month');
                        if($end_date>$termination_date){
                            $end_date=$termination_date;
                        }

                        while ($start_date<$end_date) {
                            if($cur_date>$start_date && $cur_date<$end_date){
                                $possession_date = $start_date;
                                $termination_date = $end_date;
                            }
                            $start_date->modify('+11 month');
                        }
                    }

                    $maintenance_by = $result[0]->maintenance_by;
                    $property_tax_by = $result[0]->property_tax_by;

                    $sql = "select * from rent_tenant_details where rent_id='$rent_id'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $tenant_id = $result[0]->contact_id;
                    }

                    // $sql = "select max(net_amount) as max_net_amount from rent_schedule where sch_status='2' and 
                    //         rent_id='$rent_id' and create_date = (select max(create_date) as max_create_date 
                    //             from rent_schedule where sch_status='2' and rent_id='$rent_id') ";
                    // $query=$this->db->query($sql);
                    // $result=$query->result();
                    // if(count($result)>0) {
                    //     $bl_esc = true;
                    //     $rent_amount=isset($result[0]->max_net_amount)?$result[0]->max_net_amount:0;
                    //     if(is_numeric($rent_amount)) {
                    //         $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    //     }
                    // }

                    $sql = "select min(net_amount) as min_net_amount from rent_schedule where sch_status='1' and 
                            rent_id='$rent_id' and event_name='Rent' and status='1' and 
                            event_date=(select min(event_date) as min_event_date from rent_schedule 
                            where sch_status='1' and rent_id='$rent_id' and event_name='Rent' and status='1' and 
                            date(event_date)>=date('".$possession_date->format('Y-m-d')."') and 
                            date(event_date)<=date('".$termination_date->format('Y-m-d')."'))";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        if(isset($result[0]->min_net_amount)){
                            if($result[0]->min_net_amount>0){
                                $rent_amount=isset($result[0]->min_net_amount)?$result[0]->min_net_amount:0;
                            }
                        }
                        
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    }

                    // $sql = "select create_date, max(net_amount) as max_net_amount from rent_schedule 
                    //         where sch_status='1' and rent_id='$rent_id' and event_name='Rent' and create_date = 
                    //         (select max(create_date) as max_create_date from rent_schedule 
                    //             where sch_status='1' and rent_id='$rent_id') group by create_date";
                    // $query=$this->db->query($sql);
                    // $result=$query->result();
                    // if(count($result)>0) {
                    //     $esc_rent_amount=isset($result[0]->max_net_amount)?$result[0]->max_net_amount:0;
                    //     if(is_numeric($esc_rent_amount)) {
                    //         if($bl_esc == true) {
                    //             if($esc_rent_amount==$rent_amount) {
                    //                 $bl_esc = false;
                    //             }
                    //         } else {
                    //             $rent_amount=isset($result[0]->max_net_amount)?$result[0]->max_net_amount:0;
                    //         }

                    //         if($bl_esc == false){
                    //             $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    //         } else {
                    //             $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$esc_rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    //             $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), date('d-m-Y', strtotime($result[0]->create_date)));
                    //             $objPHPExcel->getActiveSheet()->setCellValue($col_name[38+$owner_cnt].strval($row), '=if('.$col_name[25+$owner_cnt].strval($row).'=0,0,('.$col_name[39+$owner_cnt].strval($row).'-'.$col_name[25+$owner_cnt].strval($row).')/'.$col_name[25+$owner_cnt].strval($row).')');
                    //             $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$esc_rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    //         }
                    //     }
                    // }

                    $bl_esc = false;
                    $sql = "select * from rent_escalation_details where rent_id='$rent_id' and 
                            esc_date = (select min(esc_date) as min_esc_date 
                            from rent_escalation_details where rent_id='$rent_id' and 
                            date(esc_date)>=date('".$possession_date->format('Y-m-d')."') and 
                            date(esc_date)<=date('".$termination_date->format('Y-m-d')."'))";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $bl_esc = true;
                        $esc_date = $result[0]->esc_date;
                        $escalation = $result[0]->escalation;

                        $esc_rent_amount=0;
                        $sql = "select min(net_amount) as min_net_amount from rent_schedule where sch_status='1' and 
                                rent_id='$rent_id' and event_name='Rent' and status='1' and 
                                date(event_date)>=date('".$esc_date."')";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0) {
                            $esc_rent_amount=isset($result[0]->min_net_amount)?$result[0]->min_net_amount:0;
                            if(is_numeric($esc_rent_amount)) {
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$esc_rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[37+$owner_cnt].strval($row), date('d-m-Y', strtotime($esc_date)));
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[38+$owner_cnt].strval($row), $escalation);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$esc_rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                            }
                        } else {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                        }
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,'.$rent_amount.'/'.$col_name[6+$owner_cnt].strval($row).')');
                    }

                    $sql = "select * from maintenance_txn where property_id = '$property_id' and txn_status = 'Approved' " . $cond;
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $m_id=isset($result[0]->txn_id)?$result[0]->txn_id:0;

                        $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                                from maintenance_cost_details where m_id = '$m_id' and (particular = 'CAMP (Rs. PSF)' or particular = 'Maintenance')";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0) {
                            $cost=is_numeric($result[0]->cost)?$result[0]->cost:0;
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=('.$cost.'*12)');
                        }

                        $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                                from maintenance_cost_details where m_id = '$m_id' and particular = 'Property Tax'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0) {
                            $cost=is_numeric($result[0]->cost)?$result[0]->cost:0;
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=('.$cost.'*12)');
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,('.$col_name[33+$owner_cnt].strval($row).')/('.$col_name[6+$owner_cnt].strval($row).'*12))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), $maintenance_by);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,('.$col_name[34+$owner_cnt].strval($row).')/('.$col_name[6+$owner_cnt].strval($row).'*12))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$owner_cnt].strval($row), $property_tax_by);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '='.$col_name[25+$owner_cnt].strval($row).'-(IF('.$col_name[27+$owner_cnt].strval($row).'="Owner",'.$col_name[26+$owner_cnt].strval($row).',0)+IF('.$col_name[29+$owner_cnt].strval($row).'="Owner",'.$col_name[28+$owner_cnt].strval($row).',0))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=('.$col_name[30+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=(('.$col_name[25+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')*12)');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '='.$col_name[32+$owner_cnt].strval($row).'-'.$col_name[34+$owner_cnt].strval($row));
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '='.$col_name[25+$owner_cnt].strval($row).'-(IF('.$col_name[27+$owner_cnt].strval($row).'="Owner",'.$col_name[26+$owner_cnt].strval($row).',0)+IF('.$col_name[29+$owner_cnt].strval($row).'="Owner",'.$col_name[28+$owner_cnt].strval($row).',0))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=('.$col_name[30+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=(('.$col_name[25+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')*12)');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '='.$col_name[32+$owner_cnt].strval($row).'-'.$col_name[34+$owner_cnt].strval($row));
                    }

                    if($bl_esc == true){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,('.$col_name[48+$owner_cnt].strval($row).')/('.$col_name[6+$owner_cnt].strval($row).'*12))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), $maintenance_by);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '=if('.$col_name[6+$owner_cnt].strval($row).'=0,0,('.$col_name[49+$owner_cnt].strval($row).')/('.$col_name[6+$owner_cnt].strval($row).'*12))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), $property_tax_by);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[44+$owner_cnt].strval($row), '='.$col_name[39+$owner_cnt].strval($row).'-(IF('.$col_name[41+$owner_cnt].strval($row).'="Owner",'.$col_name[40+$owner_cnt].strval($row).',0)+IF('.$col_name[43+$owner_cnt].strval($row).'="Owner",'.$col_name[42+$owner_cnt].strval($row).',0))');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[45+$owner_cnt].strval($row), '=('.$col_name[44+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')');
                    }
                    
                    $tot_net_amount = 0;
                    $sql = "select sum(net_amount) as tot_net_amount from rent_schedule where sch_status='1' and 
                            rent_id='$rent_id' and event_name='Rent' and status='1' and 
                            date(event_date)>=date('".$possession_date->format('Y-m-d')."') and 
                            date(event_date)<=date('".$termination_date->format('Y-m-d')."')";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $tot_net_amount = $result[0]->tot_net_amount;
                    }

                    if($tot_net_amount != 0){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[47+$owner_cnt].strval($row), $tot_net_amount);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[47+$owner_cnt].strval($row), '=(('.$col_name[25+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')*12)');
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '='.$col_name[33+$owner_cnt].strval($row));
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '='.$col_name[34+$owner_cnt].strval($row));
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '=(('.$col_name[44+$owner_cnt].strval($row).'*'.$col_name[6+$owner_cnt].strval($row).')*12)');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[52+$owner_cnt].strval($row), '=if('.$col_name[14+$owner_cnt].strval($row).'=0,0,'.$col_name[32+$owner_cnt].strval($row).'/'.$col_name[14+$owner_cnt].strval($row).')*100');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[53+$owner_cnt].strval($row), '=if('.$col_name[16+$owner_cnt].strval($row).'=0,0,'.$col_name[32+$owner_cnt].strval($row).'/'.$col_name[16+$owner_cnt].strval($row).')*100');

                    $sql = "select * from rent_schedule where sch_status='1' and rent_id='$rent_id' and date_format(event_date,'%Y%m') = date_format(curdate(),'%Y%m')";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $event_type = $result[0]->event_type;
                        $event_name = $result[0]->event_name;
                        $event_date = $result[0]->event_date;
                        $net_amount = is_numeric($result[0]->net_amount)?$result[0]->net_amount:0;

                        $sql = "select sum(paid_amount) as tot_paid_amount from actual_schedule where table_type = 'rent' and 
                                fk_txn_id = '$rent_id' and event_type = '$event_type' and event_name = '$event_name' and 
                                event_date = '$event_date' and txn_status = 'Approved'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0) {
                            $tot_paid_amount = is_numeric($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                        } else {
                            $tot_paid_amount = 0;
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '='.strval($net_amount-$tot_paid_amount));
                    }

                    $sql = "select count(*) as tot_months from 
                            (select sch_id, net_amount-tot_paid_amount as bal_amount from 
                            (select sch_id, case when A.net_amount is null then 0 else A.net_amount end as net_amount, 
                                case when B.tot_paid_amount is null then 0 else B.tot_paid_amount end as tot_paid_amount from 
                            (select * from rent_schedule where sch_status='1' and rent_id='$rent_id') A 
                            left join 
                            (select event_type, event_name, event_date, sum(paid_amount) as tot_paid_amount 
                                from actual_schedule where table_type = 'rent' and fk_txn_id = '$rent_id' and 
                                txn_status = 'Approved' group by event_type, event_name, event_date) B 
                            on (A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                            where bal_amount!=0";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[56+$owner_cnt].strval($row), $result[0]->tot_months);
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '='.$col_name[56+$owner_cnt].strval($row).'*'.$col_name[55+$owner_cnt].strval($row));

                    $sql = "select sum(tax_amount) as tot_tds from actual_schedule_taxes 
                            where id in (select id from (select tax_applied, max(id) as id from actual_schedule_taxes 
                            where table_type = 'rent' and fk_txn_id = '$rent_id' and status = '1' group by tax_applied) A)";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $tot_tds=isset($result[0]->tot_tds)?$result[0]->tot_tds:0;
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[59+$owner_cnt].strval($row), '='.$tot_tds);
                    }

                    $c_id=$tenant_id;

                    // $c_id=explode("_", $tenant_id);
                    // if(count($c_id)==2){
                    //     $tenant_id = $c_id[1];
                    //     if ($c_id[0]=="o"){
                    //         $sql = "select * from 
                    //                 (select A.ow_id, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country, B.c_mobile1, B.c_emailid1, B.kyc_doc_ref from 
                    //                 (select * from owner_master where ow_type = '0' and ow_status='Approved' and ow_gid='$gid') A 
                    //                 left join 
                    //                 (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                    //                 (select * from contact_master where c_status='Approved') A 
                    //                 left join 
                    //                 (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
                    //                 on (A.c_id = B.kyc_cid)) B 
                    //                 on (A.ow_ind_id=B.c_id) 
                    //                 union all 
                    //                 select ow_id, ow_huf_name as c_name, '' as c_last_name, ow_huf_address as c_address, ow_huf_landmark as c_landmark, ow_huf_city as c_city, ow_huf_pincode as c_pincode, ow_huf_state as c_state, ow_huf_country as c_country, '' as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '1' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_pvtltd_comapny_name as c_name, '' as c_last_name, ow_pvtltd_address as c_address, ow_pvtltd_landmark as c_landmark, ow_pvtltd_city as c_city, ow_pvtltd_pincode as c_pincode, ow_pvtltd_state as c_state, ow_pvtltd_country as c_country, ow_pvtltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '2' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_ltd_comapny_name as c_name, '' as c_last_name, ow_ltd_address as c_address, ow_ltd_landmark as c_landmark, ow_ltd_city as c_city, ow_ltd_pincode as c_pincode, ow_ltd_state as c_state, ow_ltd_country as c_country, ow_ltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '3' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_llp_comapny_name as c_name, '' as c_last_name, ow_llp_address as c_address, ow_llp_landmark as c_landmark, ow_llp_city as c_city, ow_llp_pincode as c_pincode, ow_llp_state as c_state, ow_llp_country as c_country, ow_llp_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '4' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_prt_comapny_name as c_name, '' as c_last_name, ow_prt_address as c_address, ow_prt_landmark as c_landmark, ow_prt_city as c_city, ow_prt_pincode as c_pincode, ow_prt_state as c_state, ow_prt_country as c_country, ow_prt_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '5' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_aop_comapny_name as c_name, '' as c_last_name, ow_aop_address as c_address, ow_aop_landmark as c_landmark, ow_aop_city as c_city, ow_aop_pincode as c_pincode, ow_aop_state as c_state, ow_aop_country as c_country, ow_aop_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '6' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_trs_comapny_name as c_name, '' as c_last_name, ow_trs_address as c_address, ow_trs_landmark as c_landmark, ow_trs_city as c_city, ow_trs_pincode as c_pincode, ow_trs_state as c_state, ow_trs_country as c_country, ow_trs_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '7' and ow_status='Approved' and ow_gid='$gid' 
                    //                 union all 
                    //                 select ow_id, ow_proprietorship_comapny_name as c_name, '' as c_last_name, ow_proprietorship_address as c_address, ow_proprietorship_landmark as c_landmark, ow_proprietorship_city as c_city, ow_proprietorship_pincode as c_pincode, ow_proprietorship_state as c_state, ow_proprietorship_country as c_country, ow_proprietorship_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '8' and ow_status='Approved' and ow_gid='$gid') C 
                    //                 where ow_id = '$tenant_id'";
                    //     } else {
                    //         $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                    //                 (select * from contact_master where c_id='$tenant_id') A 
                    //                 left join 
                    //                 (select * from contact_kyc_details where kyc_cid='$tenant_id' and kyc_doc_name='PAN Card') B 
                    //                 on (A.c_id = B.kyc_cid)";
                    //     }
                    // } else {
                    //     $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
                    //             (select * from contact_master where c_id='$tenant_id') A 
                    //             left join 
                    //             (select * from contact_kyc_details where kyc_cid='$tenant_id' and kyc_doc_name='PAN Card') B 
                    //             on (A.c_id = B.kyc_cid)";
                    // }


                    $sql = "select A.*, B.doc_ref_no as kyc_doc_ref from 
                            (select A.c_id, A.c_address, A.c_landmark, A.c_city, A.c_pincode, A.c_state, A.c_country,
                                case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                case when A.c_owner_type='individual' 
                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                            where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$tenant_id') A 
                            left join 
                            (select * from document_details where doc_ref_id = '$tenant_id' and doc_ref_type = 'Contacts' and doc_doc_id = '1') B 
                            on (A.c_id = B.doc_ref_id)";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[61+$owner_cnt].strval($row), $result[0]->c_name . ' ' . $result[0]->c_last_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[62+$owner_cnt].strval($row), '');
                        $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[63+$owner_cnt].strval($row), $address);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[64+$owner_cnt].strval($row), $result[0]->c_mobile1);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[65+$owner_cnt].strval($row), $result[0]->c_emailid1);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[66+$owner_cnt].strval($row), $result[0]->kyc_doc_ref);
                    }
                }
            }

            $objPHPExcel->getActiveSheet()->setCellValue('E'.strval($row), $data[$i]->owner_name);

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[68+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$owner_cnt].strval($row), 'Grand Total');
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), '=sum('.$col_name[6+$owner_cnt].strval($s_row).':'.$col_name[6+$owner_cnt].strval($row-1).')');
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), '=sum('.$col_name[8+$owner_cnt].strval($s_row).':'.$col_name[8+$owner_cnt].strval($row-1).')');
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), '=sum('.$col_name[10+$owner_cnt].strval($s_row).':'.$col_name[10+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$col_name[11+$owner_cnt].strval($s_row).':'.$col_name[11+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '=sum('.$col_name[12+$owner_cnt].strval($s_row).':'.$col_name[12+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$col_name[13+$owner_cnt].strval($s_row).':'.$col_name[13+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$owner_cnt].strval($row), '=sum('.$col_name[14+$owner_cnt].strval($s_row).':'.$col_name[14+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$col_name[15+$owner_cnt].strval($s_row).':'.$col_name[15+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$col_name[16+$owner_cnt].strval($s_row).':'.$col_name[16+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=sum('.$col_name[25+$owner_cnt].strval($s_row).':'.$col_name[25+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$col_name[26+$owner_cnt].strval($s_row).':'.$col_name[26+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$col_name[28+$owner_cnt].strval($s_row).':'.$col_name[28+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '=sum('.$col_name[30+$owner_cnt].strval($s_row).':'.$col_name[30+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$col_name[31+$owner_cnt].strval($s_row).':'.$col_name[31+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$col_name[32+$owner_cnt].strval($s_row).':'.$col_name[32+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$col_name[33+$owner_cnt].strval($s_row).':'.$col_name[33+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$col_name[34+$owner_cnt].strval($s_row).':'.$col_name[34+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$col_name[35+$owner_cnt].strval($s_row).':'.$col_name[35+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[39+$owner_cnt].strval($row), '=sum('.$col_name[39+$owner_cnt].strval($s_row).':'.$col_name[39+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$col_name[40+$owner_cnt].strval($s_row).':'.$col_name[40+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '=sum('.$col_name[42+$owner_cnt].strval($s_row).':'.$col_name[42+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[44+$owner_cnt].strval($row), '=sum('.$col_name[44+$owner_cnt].strval($s_row).':'.$col_name[44+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[45+$owner_cnt].strval($row), '=sum('.$col_name[45+$owner_cnt].strval($s_row).':'.$col_name[45+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[47+$owner_cnt].strval($row), '=sum('.$col_name[47+$owner_cnt].strval($s_row).':'.$col_name[47+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[48+$owner_cnt].strval($row), '=sum('.$col_name[48+$owner_cnt].strval($s_row).':'.$col_name[48+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[49+$owner_cnt].strval($row), '=sum('.$col_name[49+$owner_cnt].strval($s_row).':'.$col_name[49+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[50+$owner_cnt].strval($row), '=sum('.$col_name[50+$owner_cnt].strval($s_row).':'.$col_name[50+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[55+$owner_cnt].strval($row), '=sum('.$col_name[55+$owner_cnt].strval($s_row).':'.$col_name[55+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[56+$owner_cnt].strval($row), '=sum('.$col_name[56+$owner_cnt].strval($s_row).':'.$col_name[56+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[57+$owner_cnt].strval($row), '=sum('.$col_name[57+$owner_cnt].strval($s_row).':'.$col_name[57+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[59+$owner_cnt].strval($row), '=sum('.$col_name[59+$owner_cnt].strval($s_row).':'.$col_name[59+$owner_cnt].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[68+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[68+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[68+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[68+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[9+$owner_cnt].'6:'.$col_name[9+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[17+$owner_cnt].'6:'.$col_name[17+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[24+$owner_cnt].'6:'.$col_name[24+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[36+$owner_cnt].'6:'.$col_name[36+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[46+$owner_cnt].'6:'.$col_name[46+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[51+$owner_cnt].'6:'.$col_name[51+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[54+$owner_cnt].'6:'.$col_name[54+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[58+$owner_cnt].'6:'.$col_name[58+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[60+$owner_cnt].'6:'.$col_name[60+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[67+$owner_cnt].'6:'.$col_name[67+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        
        $filename='Group_Level_Rent_Summary_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Rent Summary report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    } 
}

function get_sell_properties($from_date, $to_date){
    $gid=$this->session->userdata('groupid');

    // $sql = "select * from 
    //         (select C.*, case when C.p_type='Building' or C.p_type='Apartment' or C.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
    //             D.owner_name, D.pr_client_id, D.pr_ownership_percent from 
    //         (select A.*, null as sp_id, null as sp_name, null as sp_type, null as sp_carpet_area, null as sp_carpet_area_unit, 
    //             null as sp_builtup_area, null as sp_builtup_area_unit, null as sp_sellable_area, null as sp_sellable_area_unit from 
    //         (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' and 
    //             p_purchase_date>='$from_date' and p_purchase_date<='$to_date' and 
    //             txn_id in(select distinct property_id from sales_txn where txn_status = 'Approved')) A 
    //         union all 
    //         select A.*, B.txn_id as sp_id, B.sp_name, B.sp_type, B.sp_carpet_area, B.sp_carpet_area_unit, 
    //             B.sp_builtup_area, B.sp_builtup_area_unit, B.sp_sellable_area, B.sp_sellable_area_unit from 
    //         (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' and 
    //             p_purchase_date>='$from_date' and p_purchase_date<='$to_date' and 
    //             txn_id in(select distinct property_id from sales_txn where txn_status = 'Approved')) A 
    //         left join 
    //         (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
    //         on (A.txn_id=B.property_id) where B.txn_id is not null) C 
    //         left join 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id) D 
    //         on C.txn_id=D.purchase_id) E 
    //         order by asset_type, p_usage, txn_id, sp_id";
    if($from_date!='' && $to_date!='')
        $and = "and p_purchase_date>='$from_date' and p_purchase_date<='$to_date'";
    else
        $and = "";
    $sql = "select * from 
            (select C.*, case when C.p_type='Building' or C.p_type='Apartment' or C.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                D.owner_name, D.pr_client_id, D.pr_ownership_percent from 
            (select A.*, null as sp_id, null as sp_name, null as sp_type, null as sp_carpet_area, null as sp_carpet_area_unit, 
                null as sp_builtup_area, null as sp_builtup_area_unit, null as sp_sellable_area, null as sp_sellable_area_unit from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and and 
                txn_id in(select distinct property_id from sales_txn where txn_status = 'Approved')) A 
            union all 
            select A.*, B.txn_id as sp_id, B.sp_name, B.sp_type, B.sp_carpet_area, B.sp_carpet_area_unit, 
                B.sp_builtup_area, B.sp_builtup_area_unit, B.sp_sellable_area, B.sp_sellable_area_unit from 
            (select * from purchase_txn where gp_id='$gid' and txn_status = 'Approved' $and and 
                txn_id in(select distinct property_id from sales_txn where txn_status = 'Approved')) A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            left join 
            (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A) A 
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
            on C.txn_id=D.purchase_id) E 
            order by asset_type, p_usage, txn_id, sp_id";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_group_level_sale_details_report(){
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_max_property_owner_cnt($from_date, $to_date);
    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_sell_properties($from_date, $to_date);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Group_Level_Asset_Allocation_Usage_Wise.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Group_Level_Sale_Details.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        // $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('D', $owner_cnt);
            $col=3;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('969696');
                $col=$col+2;
            }
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";
        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].'1', $this->session->userdata('groupname'));

        $tot_col = array();
        // $tot_col['tot_'.PHPExcel_Cell::stringFromColumnIndex(9+$owner_cnt).'_col'] = "";
        $tot_col[9+$owner_cnt] = "";
        $tot_col[10+$owner_cnt] = "";
        $tot_col[11+$owner_cnt] = "";
        $tot_col[12+$owner_cnt] = "";
        $tot_col[13+$owner_cnt] = "";
        $tot_col[15+$owner_cnt] = "";
        $tot_col[16+$owner_cnt] = "";
        $tot_col[17+$owner_cnt] = "";
        $tot_col[18+$owner_cnt] = "";
        $tot_col[19+$owner_cnt] = "";
        $tot_col[21+$owner_cnt] = "";
        $tot_col[22+$owner_cnt] = "";
        $tot_col[23+$owner_cnt] = "";
        $tot_col[25+$owner_cnt] = "";
        $tot_col[26+$owner_cnt] = "";
        $tot_col[27+$owner_cnt] = "";
        $tot_col[28+$owner_cnt] = "";
        $tot_col[30+$owner_cnt] = "";
        $tot_col[31+$owner_cnt] = "";
        $tot_col[32+$owner_cnt] = "";
        $tot_col[33+$owner_cnt] = "";
        $tot_col[34+$owner_cnt] = "";
        $tot_col[35+$owner_cnt] = "";
        $tot_col[38+$owner_cnt] = "";
        $tot_col[40+$owner_cnt] = "";
        $tot_col[41+$owner_cnt] = "";
        $tot_col[42+$owner_cnt] = "";
        $tot_col[43+$owner_cnt] = "";

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if ($prev_property_id!=$property_id){
                if($row!=6){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[1+$owner_cnt].strval($row), 'Total');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$col_name[9+$owner_cnt].strval($s_row).':'.$col_name[9+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), '=sum('.$col_name[10+$owner_cnt].strval($s_row).':'.$col_name[10+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$col_name[11+$owner_cnt].strval($s_row).':'.$col_name[11+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '=sum('.$col_name[12+$owner_cnt].strval($s_row).':'.$col_name[12+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$col_name[13+$owner_cnt].strval($s_row).':'.$col_name[13+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$col_name[15+$owner_cnt].strval($s_row).':'.$col_name[15+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$col_name[16+$owner_cnt].strval($s_row).':'.$col_name[16+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$col_name[17+$owner_cnt].strval($s_row).':'.$col_name[17+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$col_name[19+$owner_cnt].strval($s_row).':'.$col_name[19+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=sum('.$col_name[25+$owner_cnt].strval($s_row).':'.$col_name[25+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$col_name[26+$owner_cnt].strval($s_row).':'.$col_name[26+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$col_name[27+$owner_cnt].strval($s_row).':'.$col_name[27+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$col_name[28+$owner_cnt].strval($s_row).':'.$col_name[28+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '=sum('.$col_name[30+$owner_cnt].strval($s_row).':'.$col_name[30+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$col_name[31+$owner_cnt].strval($s_row).':'.$col_name[31+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$col_name[32+$owner_cnt].strval($s_row).':'.$col_name[32+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$col_name[33+$owner_cnt].strval($s_row).':'.$col_name[33+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$col_name[34+$owner_cnt].strval($s_row).':'.$col_name[34+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$col_name[35+$owner_cnt].strval($s_row).':'.$col_name[35+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[38+$owner_cnt].strval($row), '=sum('.$col_name[38+$owner_cnt].strval($s_row).':'.$col_name[38+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$col_name[40+$owner_cnt].strval($s_row).':'.$col_name[40+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$col_name[41+$owner_cnt].strval($s_row).':'.$col_name[41+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '=sum('.$col_name[42+$owner_cnt].strval($s_row).':'.$col_name[42+$owner_cnt].strval($row-1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$col_name[43+$owner_cnt].strval($s_row).':'.$col_name[43+$owner_cnt].strval($row-1).')');

                    $tot_col[9+$owner_cnt] = $tot_col[9+$owner_cnt] . $col_name[9+$owner_cnt].strval($row) . ',';
                    $tot_col[10+$owner_cnt] = $tot_col[10+$owner_cnt] . $col_name[10+$owner_cnt].strval($row) . ',';
                    $tot_col[11+$owner_cnt] = $tot_col[11+$owner_cnt] . $col_name[11+$owner_cnt].strval($row) . ',';
                    $tot_col[12+$owner_cnt] = $tot_col[12+$owner_cnt] . $col_name[12+$owner_cnt].strval($row) . ',';
                    $tot_col[13+$owner_cnt] = $tot_col[13+$owner_cnt] . $col_name[13+$owner_cnt].strval($row) . ',';
                    $tot_col[15+$owner_cnt] = $tot_col[15+$owner_cnt] . $col_name[15+$owner_cnt].strval($row) . ',';
                    $tot_col[16+$owner_cnt] = $tot_col[16+$owner_cnt] . $col_name[16+$owner_cnt].strval($row) . ',';
                    $tot_col[17+$owner_cnt] = $tot_col[17+$owner_cnt] . $col_name[17+$owner_cnt].strval($row) . ',';
                    $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
                    $tot_col[19+$owner_cnt] = $tot_col[19+$owner_cnt] . $col_name[19+$owner_cnt].strval($row) . ',';
                    $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
                    $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
                    $tot_col[25+$owner_cnt] = $tot_col[25+$owner_cnt] . $col_name[25+$owner_cnt].strval($row) . ',';
                    $tot_col[26+$owner_cnt] = $tot_col[26+$owner_cnt] . $col_name[26+$owner_cnt].strval($row) . ',';
                    $tot_col[27+$owner_cnt] = $tot_col[27+$owner_cnt] . $col_name[27+$owner_cnt].strval($row) . ',';
                    $tot_col[28+$owner_cnt] = $tot_col[28+$owner_cnt] . $col_name[28+$owner_cnt].strval($row) . ',';
                    $tot_col[30+$owner_cnt] = $tot_col[30+$owner_cnt] . $col_name[30+$owner_cnt].strval($row) . ',';
                    $tot_col[31+$owner_cnt] = $tot_col[31+$owner_cnt] . $col_name[31+$owner_cnt].strval($row) . ',';
                    $tot_col[32+$owner_cnt] = $tot_col[32+$owner_cnt] . $col_name[32+$owner_cnt].strval($row) . ',';
                    $tot_col[33+$owner_cnt] = $tot_col[33+$owner_cnt] . $col_name[33+$owner_cnt].strval($row) . ',';
                    $tot_col[34+$owner_cnt] = $tot_col[34+$owner_cnt] . $col_name[34+$owner_cnt].strval($row) . ',';
                    $tot_col[35+$owner_cnt] = $tot_col[35+$owner_cnt] . $col_name[35+$owner_cnt].strval($row) . ',';
                    $tot_col[38+$owner_cnt] = $tot_col[38+$owner_cnt] . $col_name[38+$owner_cnt].strval($row) . ',';
                    $tot_col[40+$owner_cnt] = $tot_col[40+$owner_cnt] . $col_name[40+$owner_cnt].strval($row) . ',';
                    $tot_col[41+$owner_cnt] = $tot_col[41+$owner_cnt] . $col_name[41+$owner_cnt].strval($row) . ',';
                    $tot_col[42+$owner_cnt] = $tot_col[42+$owner_cnt] . $col_name[42+$owner_cnt].strval($row) . ',';
                    $tot_col[43+$owner_cnt] = $tot_col[43+$owner_cnt] . $col_name[43+$owner_cnt].strval($row) . ',';

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                            
                    $row=$row+1;
                    $s_row=$row;
                }
            }
            
            if($prev_asset_type!=$asset_type) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $asset_type);

                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'D9D9D9'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $row=$row+1;

                if($prev_p_usage!=$p_usage) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $p_usage);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'F2F2F2'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $row=$row+1;
                    $sr_no=1;
                    $prev_p_usage=$p_usage;
                    $prev_property_id="";
                }

                $prev_asset_type=$asset_type;
            }


            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;
            if($sub_property_id==0){
                $cond = "and (sub_property_id is null or sub_property_id = '0')";
            } else {
                $cond = "and sub_property_id = '$sub_property_id'";
            }

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=3;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), $address);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$owner_cnt].strval($row), $data[$i]->p_type);
                $agreement_area = 0;
                $pending_activity = "";
                $no_of_parking = 0;
                $carpet_area = 0;
                $builtup_area = 0;
                $sellable_area = 0;

                if($data[$i]->p_type=='Building' || $data[$i]->p_type=='Apartment' || $data[$i]->p_type=='Bunglow') {
                    $p_asset_type = 'Residential';
                } else {
                    $p_asset_type = 'Commercial';
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $p_asset_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $data[$i]->p_usage);

                $sql = "select * from purchase_property_description where purchase_id='$property_id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
                    $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
                    $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
                    $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
                    $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);
                }

                $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$property_id' and status='1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    $purchase_cost = $result[0]->tot_net_amount;
                } else {
                    $purchase_cost = 0;
                }

                if($sub_property_id!=0 and $sub_property_id!=''){
                    $sql = "select * from sub_property_allocation where txn_id = '$sub_property_id'";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    if(count($result)>0){
                        $agreement_area = $result[0]->sp_sellable_area;
                        $purchase_cost = $result[0]->allocated_cost;
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$owner_cnt].strval($row), $no_of_parking);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), $agreement_area);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $sellable_area);

                $sql = "select sum(net_amount) as agreement_value from purchase_schedule where purchase_id = '$property_id' and status = '1' and event_type = 'Agreement Value'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $agreement_value = $result[0]->agreement_value;
                    if($agreement_area!=0){
                        $agreement_rate = $agreement_value/$agreement_area;
                    } else {
                        $agreement_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), $agreement_rate);
                }

                $sql = "select * from property_projection_details where purchase_id = '$property_id'".$cond." and 
                        id = (select max(id) from property_projection_details where purchase_id = '$property_id'".$cond.")";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), $result[0]->market_rate);
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), $result[0]->req_rate_return);

                    $current_index = $this->getindex(date('Y-m-d'));
                    $purchase_index = $this->getindex($data[$i]->p_purchase_date);

                    if($purchase_index!=0) {
                        $indexed_rate = $agreement_rate*$current_index/$purchase_index;
                    } else {
                        $indexed_rate = 0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), $indexed_rate);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=('.$col_name[9+$owner_cnt].strval($row).'*'.$col_name[11+$owner_cnt].strval($row).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=('.$col_name[10+$owner_cnt].strval($row).'*'.$col_name[12+$owner_cnt].strval($row).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=('.$col_name[9+$owner_cnt].strval($row).'*'.$col_name[13+$owner_cnt].strval($row).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=(('.$col_name[15+$owner_cnt].strval($row).'*0.05)+30000)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '='.$col_name[15+$owner_cnt].strval($row).'+'.$col_name[18+$owner_cnt].strval($row));

                $sql = "select * from pending_activity where ref_id = '$property_id' and type='purchase'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[45+$owner_cnt].strval($row), $pending_activity);
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[47+$owner_cnt].strval($row), $data[$i]->remarks);
            }

            if($data[$i]->sp_name!=""){
                $sp_sellable_area = convert_to_feet($data[$i]->sp_sellable_area, $data[$i]->sp_sellable_area_unit);

                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $sp_sellable_area);
            }

            $pending_activity = "";

            if($sub_property_id!=0){
                $sql = "select * from pending_activity where ref_id = '$sub_property_id' and type='allocation'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    for($j=0; $j<count($result); $j++) {
                        $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[45+$owner_cnt].strval($row), $pending_activity);
                }
            }

            $loan_outstanding = 0;
            $sql = "select A.loan_id, B.* from 
                    (select * from loan_property_details where property_id = '$property_id' and 
                        loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                    left join 
                    (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                    on A.loan_id = B.txn_id";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_id=$result[0]->loan_id;
                $bank_name=$result[0]->financial_institution;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$owner_cnt].strval($row), $bank_name);

                $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
                $loan_emi=0;
                $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

                $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
                }

                $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                        where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                    $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
                }

                $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                } else {
                    $loan_outstanding = 0;
                }

                $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

                $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                } else {
                    $tot_paid_amount = 0;
                }

                $loan_outstanding = $loan_outstanding - $tot_paid_amount;

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '='.$loan_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$owner_cnt].strval($row), '='.$loan_interest_rate);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '='.$outstanding_agreement_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '='.($outstanding_agreement_amount+$loan_outstanding));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '='.$loan_emi);
            }

            $sql = "select * from sales_txn where property_id='$property_id' and txn_status='Approved'" . $cond;
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0) {
                $s_id = $result[0]->txn_id;
                // $cost_of_acqisition = $result[0]->cost_of_acquisition;
                // if(!is_numeric($cost_of_acqisition)){
                //     $cost_of_acqisition = 0;
                // }
                $indexed_cost = $result[0]->indexed_cost;
                if(!is_numeric($indexed_cost)){
                    $indexed_cost = 0;
                }

                $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    $tot_net_amount = $result[0]->tot_net_amount;
                } else {
                    $tot_net_amount = 0;
                }
                if($agreement_area!=0){
                    $sale_consideration = $tot_net_amount/$agreement_area;
                } else {
                    $sale_consideration = 0;
                }
                if(!is_numeric($sale_consideration)){
                    $sale_consideration = 0;
                }

                // $capital_gain = $sale_consideration-$cost_of_acqisition;
                $capital_gain = $sale_consideration-$indexed_cost;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '='.$tot_net_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '='.$sale_consideration);
                // $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '='.$cost_of_acqisition);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '='.$indexed_cost);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '='.$capital_gain);

                $sql = "select * from property_projection_details where purchase_id = '$property_id'".$cond." and 
                        id = (select max(id) from property_projection_details where purchase_id = '$property_id'".$cond.")";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $capital_gain_tax = $result[0]->tax_applicable;
                } else {
                    $capital_gain_tax = 0;
                }
                if(!is_numeric($capital_gain_tax)){
                    $capital_gain_tax = 0;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '='.$capital_gain_tax);

                $net_profit = $purchase_cost-$capital_gain-$capital_gain_tax;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '='.$net_profit);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '='.$sale_consideration);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '='.$loan_outstanding);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '='.$capital_gain_tax);


                $free_cashflow = $sale_consideration-$loan_outstanding-$capital_gain_tax;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '='.$free_cashflow);
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[1+$owner_cnt].strval($row), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$col_name[9+$owner_cnt].strval($s_row).':'.$col_name[9+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), '=sum('.$col_name[10+$owner_cnt].strval($s_row).':'.$col_name[10+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$col_name[11+$owner_cnt].strval($s_row).':'.$col_name[11+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '=sum('.$col_name[12+$owner_cnt].strval($s_row).':'.$col_name[12+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$col_name[13+$owner_cnt].strval($s_row).':'.$col_name[13+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$col_name[15+$owner_cnt].strval($s_row).':'.$col_name[15+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$col_name[16+$owner_cnt].strval($s_row).':'.$col_name[16+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$col_name[17+$owner_cnt].strval($s_row).':'.$col_name[17+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$col_name[18+$owner_cnt].strval($s_row).':'.$col_name[18+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$col_name[19+$owner_cnt].strval($s_row).':'.$col_name[19+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$col_name[22+$owner_cnt].strval($s_row).':'.$col_name[22+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$col_name[23+$owner_cnt].strval($s_row).':'.$col_name[23+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=sum('.$col_name[25+$owner_cnt].strval($s_row).':'.$col_name[25+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$col_name[26+$owner_cnt].strval($s_row).':'.$col_name[26+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$col_name[27+$owner_cnt].strval($s_row).':'.$col_name[27+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$col_name[28+$owner_cnt].strval($s_row).':'.$col_name[28+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '=sum('.$col_name[30+$owner_cnt].strval($s_row).':'.$col_name[30+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$col_name[31+$owner_cnt].strval($s_row).':'.$col_name[31+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$col_name[32+$owner_cnt].strval($s_row).':'.$col_name[32+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$col_name[33+$owner_cnt].strval($s_row).':'.$col_name[33+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$col_name[34+$owner_cnt].strval($s_row).':'.$col_name[34+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$col_name[35+$owner_cnt].strval($s_row).':'.$col_name[35+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[38+$owner_cnt].strval($row), '=sum('.$col_name[38+$owner_cnt].strval($s_row).':'.$col_name[38+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$col_name[40+$owner_cnt].strval($s_row).':'.$col_name[40+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$col_name[41+$owner_cnt].strval($s_row).':'.$col_name[41+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '=sum('.$col_name[42+$owner_cnt].strval($s_row).':'.$col_name[42+$owner_cnt].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$col_name[43+$owner_cnt].strval($s_row).':'.$col_name[43+$owner_cnt].strval($row-1).')');

        $tot_col[9+$owner_cnt] = $tot_col[9+$owner_cnt] . $col_name[9+$owner_cnt].strval($row) . ',';
        $tot_col[10+$owner_cnt] = $tot_col[10+$owner_cnt] . $col_name[10+$owner_cnt].strval($row) . ',';
        $tot_col[11+$owner_cnt] = $tot_col[11+$owner_cnt] . $col_name[11+$owner_cnt].strval($row) . ',';
        $tot_col[12+$owner_cnt] = $tot_col[12+$owner_cnt] . $col_name[12+$owner_cnt].strval($row) . ',';
        $tot_col[13+$owner_cnt] = $tot_col[13+$owner_cnt] . $col_name[13+$owner_cnt].strval($row) . ',';
        $tot_col[15+$owner_cnt] = $tot_col[15+$owner_cnt] . $col_name[15+$owner_cnt].strval($row) . ',';
        $tot_col[16+$owner_cnt] = $tot_col[16+$owner_cnt] . $col_name[16+$owner_cnt].strval($row) . ',';
        $tot_col[17+$owner_cnt] = $tot_col[17+$owner_cnt] . $col_name[17+$owner_cnt].strval($row) . ',';
        $tot_col[18+$owner_cnt] = $tot_col[18+$owner_cnt] . $col_name[18+$owner_cnt].strval($row) . ',';
        $tot_col[19+$owner_cnt] = $tot_col[19+$owner_cnt] . $col_name[19+$owner_cnt].strval($row) . ',';
        $tot_col[22+$owner_cnt] = $tot_col[22+$owner_cnt] . $col_name[22+$owner_cnt].strval($row) . ',';
        $tot_col[23+$owner_cnt] = $tot_col[23+$owner_cnt] . $col_name[23+$owner_cnt].strval($row) . ',';
        $tot_col[25+$owner_cnt] = $tot_col[25+$owner_cnt] . $col_name[25+$owner_cnt].strval($row) . ',';
        $tot_col[26+$owner_cnt] = $tot_col[26+$owner_cnt] . $col_name[26+$owner_cnt].strval($row) . ',';
        $tot_col[27+$owner_cnt] = $tot_col[27+$owner_cnt] . $col_name[27+$owner_cnt].strval($row) . ',';
        $tot_col[28+$owner_cnt] = $tot_col[28+$owner_cnt] . $col_name[28+$owner_cnt].strval($row) . ',';
        $tot_col[30+$owner_cnt] = $tot_col[30+$owner_cnt] . $col_name[30+$owner_cnt].strval($row) . ',';
        $tot_col[31+$owner_cnt] = $tot_col[31+$owner_cnt] . $col_name[31+$owner_cnt].strval($row) . ',';
        $tot_col[32+$owner_cnt] = $tot_col[32+$owner_cnt] . $col_name[32+$owner_cnt].strval($row) . ',';
        $tot_col[33+$owner_cnt] = $tot_col[33+$owner_cnt] . $col_name[33+$owner_cnt].strval($row) . ',';
        $tot_col[34+$owner_cnt] = $tot_col[34+$owner_cnt] . $col_name[34+$owner_cnt].strval($row) . ',';
        $tot_col[35+$owner_cnt] = $tot_col[35+$owner_cnt] . $col_name[35+$owner_cnt].strval($row) . ',';
        $tot_col[38+$owner_cnt] = $tot_col[38+$owner_cnt] . $col_name[38+$owner_cnt].strval($row) . ',';
        $tot_col[40+$owner_cnt] = $tot_col[40+$owner_cnt] . $col_name[40+$owner_cnt].strval($row) . ',';
        $tot_col[41+$owner_cnt] = $tot_col[41+$owner_cnt] . $col_name[41+$owner_cnt].strval($row) . ',';
        $tot_col[42+$owner_cnt] = $tot_col[42+$owner_cnt] . $col_name[42+$owner_cnt].strval($row) . ',';
        $tot_col[43+$owner_cnt] = $tot_col[43+$owner_cnt] . $col_name[43+$owner_cnt].strval($row) . ',';

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), 'Grand Total');

        $tot_col[9+$owner_cnt] = substr($tot_col[9+$owner_cnt], 0, strlen($tot_col[9+$owner_cnt])-1);
        $tot_col[10+$owner_cnt] = substr($tot_col[10+$owner_cnt], 0, strlen($tot_col[10+$owner_cnt])-1);
        $tot_col[11+$owner_cnt] = substr($tot_col[11+$owner_cnt], 0, strlen($tot_col[11+$owner_cnt])-1);
        $tot_col[12+$owner_cnt] = substr($tot_col[12+$owner_cnt], 0, strlen($tot_col[12+$owner_cnt])-1);
        $tot_col[13+$owner_cnt] = substr($tot_col[13+$owner_cnt], 0, strlen($tot_col[13+$owner_cnt])-1);
        $tot_col[15+$owner_cnt] = substr($tot_col[15+$owner_cnt], 0, strlen($tot_col[15+$owner_cnt])-1);
        $tot_col[16+$owner_cnt] = substr($tot_col[16+$owner_cnt], 0, strlen($tot_col[16+$owner_cnt])-1);
        $tot_col[17+$owner_cnt] = substr($tot_col[17+$owner_cnt], 0, strlen($tot_col[17+$owner_cnt])-1);
        $tot_col[18+$owner_cnt] = substr($tot_col[18+$owner_cnt], 0, strlen($tot_col[18+$owner_cnt])-1);
        $tot_col[19+$owner_cnt] = substr($tot_col[19+$owner_cnt], 0, strlen($tot_col[19+$owner_cnt])-1);
        $tot_col[22+$owner_cnt] = substr($tot_col[22+$owner_cnt], 0, strlen($tot_col[22+$owner_cnt])-1);
        $tot_col[23+$owner_cnt] = substr($tot_col[23+$owner_cnt], 0, strlen($tot_col[23+$owner_cnt])-1);
        $tot_col[25+$owner_cnt] = substr($tot_col[25+$owner_cnt], 0, strlen($tot_col[25+$owner_cnt])-1);
        $tot_col[26+$owner_cnt] = substr($tot_col[26+$owner_cnt], 0, strlen($tot_col[26+$owner_cnt])-1);
        $tot_col[27+$owner_cnt] = substr($tot_col[27+$owner_cnt], 0, strlen($tot_col[27+$owner_cnt])-1);
        $tot_col[28+$owner_cnt] = substr($tot_col[28+$owner_cnt], 0, strlen($tot_col[28+$owner_cnt])-1);
        $tot_col[30+$owner_cnt] = substr($tot_col[30+$owner_cnt], 0, strlen($tot_col[30+$owner_cnt])-1);
        $tot_col[31+$owner_cnt] = substr($tot_col[31+$owner_cnt], 0, strlen($tot_col[31+$owner_cnt])-1);
        $tot_col[32+$owner_cnt] = substr($tot_col[32+$owner_cnt], 0, strlen($tot_col[32+$owner_cnt])-1);
        $tot_col[33+$owner_cnt] = substr($tot_col[33+$owner_cnt], 0, strlen($tot_col[33+$owner_cnt])-1);
        $tot_col[34+$owner_cnt] = substr($tot_col[34+$owner_cnt], 0, strlen($tot_col[34+$owner_cnt])-1);
        $tot_col[35+$owner_cnt] = substr($tot_col[35+$owner_cnt], 0, strlen($tot_col[35+$owner_cnt])-1);
        $tot_col[38+$owner_cnt] = substr($tot_col[38+$owner_cnt], 0, strlen($tot_col[38+$owner_cnt])-1);
        $tot_col[40+$owner_cnt] = substr($tot_col[40+$owner_cnt], 0, strlen($tot_col[40+$owner_cnt])-1);
        $tot_col[41+$owner_cnt] = substr($tot_col[41+$owner_cnt], 0, strlen($tot_col[41+$owner_cnt])-1);
        $tot_col[42+$owner_cnt] = substr($tot_col[42+$owner_cnt], 0, strlen($tot_col[42+$owner_cnt])-1);
        $tot_col[43+$owner_cnt] = substr($tot_col[43+$owner_cnt], 0, strlen($tot_col[43+$owner_cnt])-1);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), '=sum('.$tot_col[9+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), '=sum('.$tot_col[10+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), '=sum('.$tot_col[11+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), '=sum('.$tot_col[12+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), '=sum('.$tot_col[13+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), '=sum('.$tot_col[15+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$owner_cnt].strval($row), '=sum('.$tot_col[16+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$owner_cnt].strval($row), '=sum('.$tot_col[17+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$owner_cnt].strval($row), '=sum('.$tot_col[18+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$owner_cnt].strval($row), '=sum('.$tot_col[19+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$owner_cnt].strval($row), '=sum('.$tot_col[22+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$owner_cnt].strval($row), '=sum('.$tot_col[23+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$owner_cnt].strval($row), '=sum('.$tot_col[25+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$owner_cnt].strval($row), '=sum('.$tot_col[26+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$owner_cnt].strval($row), '=sum('.$tot_col[27+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[28+$owner_cnt].strval($row), '=sum('.$tot_col[28+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[30+$owner_cnt].strval($row), '=sum('.$tot_col[30+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[31+$owner_cnt].strval($row), '=sum('.$tot_col[31+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[32+$owner_cnt].strval($row), '=sum('.$tot_col[32+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[33+$owner_cnt].strval($row), '=sum('.$tot_col[33+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[34+$owner_cnt].strval($row), '=sum('.$tot_col[34+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[35+$owner_cnt].strval($row), '=sum('.$tot_col[35+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[38+$owner_cnt].strval($row), '=sum('.$tot_col[38+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[40+$owner_cnt].strval($row), '=sum('.$tot_col[40+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[41+$owner_cnt].strval($row), '=sum('.$tot_col[41+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[42+$owner_cnt].strval($row), '=sum('.$tot_col[42+$owner_cnt].')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[43+$owner_cnt].strval($row), '=sum('.$tot_col[43+$owner_cnt].')');

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[47+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[8+$owner_cnt].'6:'.$col_name[8+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[14+$owner_cnt].'6:'.$col_name[14+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[20+$owner_cnt].'6:'.$col_name[20+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[29+$owner_cnt].'6:'.$col_name[29+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[36+$owner_cnt].'6:'.$col_name[36+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[39+$owner_cnt].'6:'.$col_name[39+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[44+$owner_cnt].'6:'.$col_name[44+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[46+$owner_cnt].'6:'.$col_name[46+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[47+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[47+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        // $objPHPExcel->getActiveSheet()->removeColumn($col_name[6+$owner_cnt], 2);

        $filename='Group_Level_Sale_Details.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Group Level Sale Details report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

}
?>