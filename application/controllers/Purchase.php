<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Purchase extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
        $this->load->model('rent_model');
        $this->load->model('sales_model');
        $this->load->model('transaction_model');
        $this->load->model('document_model');
        $this->load->model('accounting_model');
        $this->load->library('excel');
        $this->load->model('City_master_model','city_model');
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function loadpurchasedocuments($ptype) {
        if($ptype=='Building'){
            $pcolname="d_type_building";
        } else if($ptype=='Apartment'){
            $pcolname="d_type_apartment";
        } else if($ptype=='Bunglow'){
            $pcolname="d_type_bunglow";
        } else if($ptype=='Commercial'){
            $pcolname="d_type_commercial";
        } else if($ptype=='Retail'){
            $pcolname="d_type_retail";
        } else if($ptype=='Industrial'){
            $pcolname="d_type_industry";
        } else if($ptype=='Land-Agriculture'){
            $pcolname="d_type_landagriculture";
        } else if($ptype=='Land-NonAgriculture'){
            $pcolname="d_type_landnonagricultural";
        } 

        $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                '' as doc_documentname, '' as d_show_expiry_date, 
                                '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                '' as doc_doe, '' as doc_document, '' as document_name 
                                from document_type_master");
        $result=$query->result();
        $data['documents']=$result;

        for($i=0; $i<count($result); $i++){
            $d_type_id = $result[$i]->d_type_id;

            $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                    (select * from document_types where d_type_id='$d_type_id') A 
                                    left join 
                                    (select * from document_master where d_t_type like '%purchase%' and $pcolname='Yes') B 
                                    on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            $data['docs'][$d_type_id]=$query->result();
        }

        $document_data=$this->load->view('templates/document_dynamic',$data,true);
        $returnarray=array('status'=>true,"data"=>$document_data);
        echo json_encode($returnarray);
    }

    public function addnew() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%purchase%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%purchase%'");
            // $result=$query->result();
            // $data['docs']=$result;

            // $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
            //                         '' as doc_documentname, '' as d_show_expiry_date, 
            //                         '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
            //                         '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
            //                         from document_type_master");
            // $result=$query->result();
            // $data['documents']=$result;

            // for($i=0; $i<count($result); $i++){
            //     $d_type_id = $result[$i]->d_type_id;

            //     $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
            //                             (select * from document_types where d_type_id='$d_type_id') A 
            //                             left join 
            //                             (select * from document_master where d_t_type like '%purchase%') B 
            //                             on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            //     $data['docs'][$d_type_id]=$query->result();
            // }

            // $query=$this->db->query("select * from document_type_master");
            // $result=$query->result();
            // $data['doc_types']=$result;

            // $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
            // $result=$query->result();
            // $data['contact_type']=$result;

            $docs=$this->document_model->add_new_doc('', 'purchase');
            $data=array_merge($data, $docs);

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['owner']=$result;

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $query=$this->db->query("SELECT * FROM amenity_master order by amenity");
            $result=$query->result();
            $data['amenity']=$result;

            $data['tax_details']=$this->purchase_model->getAllTaxes($txn_type=false);

            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['city'] = $this->city_model->get_city();

            load_view('purchase/purchase_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $result=$this->purchase_model->getAccess();

        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $purdt=$this->input->post('date_of_purchase');
            if($purdt==''){
                $purdt=NULL;
            } else {
                $purdt=formatdate($purdt);
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else {
                $txn_status='In Process';
            }
            $pid=$this->purchase_model->insertRecord($purdt, $txn_status);

            $this->purchase_model->insertImage($pid);

            $this->purchase_model->propertyDescription($pid);
            
            $response_purchase_consideration=$this->purchase_model->insertSchedule($pid, $txn_status);
                           
            $purchase_ownership_details=$this->purchase_model->insertOwnershipDetails($pid);

            // $this->transaction_model->insertRPDetails($pid, 'purchase');
            // $this->transaction_model->insertPendingActivity($pid, 'purchase');

            $this->purchase_model->insertAmenityDetails($pid);

            $capdate=$this->input->post('capture_date[]');
            $capdesc=$this->input->post('capture_description[]');

            $do_type = 'property_purchase';

            $filePath='assets/uploads/property_purchase/'.$do_type.'_'.$pid.'/property_purchase_images/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $confi['upload_path']=$upload_path;
            $confi['allowed_types']='*';
            $this->load->library('upload', $confi);
            
            for ($k=0; $k < count($capdate); $k++) {
                if($capdate[$k]=="") {
                    $cadt = NULL;
                } else {
                    $cadt = formatdate($capdate[$k]);
                }

                $file_nm='propertydoc_'.$k;
                $extension="";

                $this->upload->initialize(array(
                    "upload_path"       => $upload_path,
                    "encrypt_name"      => FALSE,
                    "remove_spaces"     => TRUE,    
                    "allowed_types"     => '*',
                    "file_name"         => $file_nm,
                    "max_size"          => '20000000'
                ));

                if(!empty($_FILES[$file_nm]['name'])) {
                    if($this->upload->do_upload($file_nm)) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];
					$full_path = $upload_data['full_path'];

                    // check EXIF and autorotate if needed
					$this->load->library('image_autorotate', array('filepath' => $full_path));

                    if($capdate[$k]=='') {
                        $dttx = NULL;
                    } else {
                        $dttx = formatdate($capdate[$k]);
                    }
                    echo 'gdg'.$dttx.'123';
                    $data = array(
                        'purchase_id' => $pid,
                        'file_path' => $filePath.$fileName,
                        'file_name' => $fileName,
                        'file_date' => $dttx,
                        'file_description' => $capdesc[$k],
                    );
                    $this->db->insert('purchase_property_description_images', $data);
                    echo "Main<br>";
                } else {
                    if($capdate[$k]=='') {
                        $dttx = NULL;
                    } else {
                        $dttx = formatdate($capdate[$k]);
                    }
                    echo "Other<br>";
                    $data = array(
                        'purchase_id' => $pid,
                        'file_path' => '',
                        'file_name' => '',
                        'file_date' => $dttx,
                        'file_description' => $capdesc[$k],
                    );
                    $this->db->insert('purchase_property_description_images', $data);
                }
            }

            $this->document_model->insert_doc($pid, 'Property_Purchase');


            redirect(base_url().'index.php/Purchase');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($pid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $result=$this->purchase_model->getAccess();
        $data['tax_details']=$this->purchase_model->getAllTaxes($txn_type=false);

        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1) {
                $data['access']=$result;
                $ptype = '';

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_fkid = '$pid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $pid = $result1[0]->txn_id;
                    $ptype = $result1[0]->p_type;
                }

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%Purchase%' AND status = '1' AND tax_action='1'");
                $result=$query->result();
                $data['tax']=$result;
                
                // $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid'");
                // $result=$query->result();
                // $data['owner']=$result;
                
                // for ($i=0; $i < count($result) ; $i++) { 
                //     if($result[$i]->ow_type==0) {
                //         $cd=$result[$i]->ow_ind_id;
                //         $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cd'");
                //         $res=$quer->result();
                //         $data['ownerdetails'][$i]=$res[0]->c_name;
                //     } else if($result[$i]->ow_type==1) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_huf_name;
                //     } else if($result[$i]->ow_type==2) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_pvtltd_comapny_name;
                //     } else if($result[$i]->ow_type==3) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_ltd_comapny_name;
                //     } else if($result[$i]->ow_type==4) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_llp_comapny_name;
                //     } else if($result[$i]->ow_type==5) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_prt_comapny_name;
                //     } else if($result[$i]->ow_type==6) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_aop_comapny_name;
                //     } else if($result[$i]->ow_type==7) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_trs_comapny_name;
                //     } else if($result[$i]->ow_type==8) {
                //         $data['ownerdetails'][$i]=$result[$i]->ow_proprietorship_comapny_name;
                //     }
                // }
                // $query=$this->db->query("SELECT * FROM contact_master WHERE c_type='Others'");
                // $result=$query->result();
                // $data['contact_other']=$result;

                // $query=$this->db->query("SELECT A.*, B.seller_name FROM (SELECT * FROM purchase_txn WHERE txn_id = '$pid') A 
                //                         LEFT JOIN 
                //                         (select concat('c_',c_id) as c_id, contact_name as seller_name from 
                //                         (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) as contact_name from 
                //                         (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                //                         left join 
                //                         (select * from contact_type_master where g_id='$gid') B 
                //                         on (A.c_contact_type = B.id)) C 
                //                         union all 
                //                         select concat('o_',ow_id) as c_id, owner_name as seller_name from 
                //                         (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                //                             when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                //                             when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                //                             when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                //                             when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                //                             from (select ow_gid, ow_id, ow_type, 
                //                                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                //                                     where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                //                                 ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                //                                 ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                //                         where ow_status='Approved' and ow_gid='$gid') A) B 
                //                         where ow_gid='$gid') B 
                //                         ON (A.p_builder_name=B.c_id)");
                

                $query=$this->db->query("SELECT A.*, B.owner_name as seller_name FROM 
                                        (SELECT * FROM purchase_txn WHERE txn_id = '$pid') A 
                                        LEFT JOIN 
                                        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                            case when A.c_owner_type='individual' 
                                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                        where A.c_status='Approved' and A.c_gid='$gid') B 
                                        ON (A.p_builder_name=B.c_id)");
                $result=$query->result();
                if(count($result)>0) {
                    $data['p_txn']=$result;
                    $ptype=$result[0]->p_type;

                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                } else {
                    $txn_status=3;
                    $ptype='';
                }

                $distict_tax=$this->purchase_model->getDistinctTaxDetail($pid, $txn_status);
                $data['tax_name']=$distict_tax;
                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;

                $sql="SELECT event_type, sum(basic_cost) as basic_cost, sum(net_amount) as net_amount FROM purchase_schedule 
                    WHERE purchase_id = '".$pid."' and status = '$txn_status' GROUP BY event_type";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();
               
                $k=0;

                if(count($result)>0) {
                    foreach($result as $row){                     
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        // $data['p_schedule1'][$k]['sch_pay_type']=$row->sch_pay_type;
                        // $data['p_schedule1'][$k]['sch_agree_value']=$row->sch_agree_value;

                        $query=$this->db->query("SELECT tax_type, sum(tax_amount) as tax_amount FROM purchase_schedule_taxation 
                                                WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $j++;
                            }
                        }
                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM purchase_schedule_taxation 
                                        WHERE pur_id = '".$pid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $query=$this->db->query("SELECT * FROM purchase_schedule WHERE purchase_id = '$pid' and status = '$txn_status' ");
                $result=$query->result();
                $data['p_schedule']=array();

                $distict_tax=$this->purchase_model->getDistinctTaxDetail($pid, $txn_status);
                $data['tax_name']=$distict_tax;
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){
                        $data['p_schedule'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$row->event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule'][$k]['event_date']=$row->event_date;
                        //  $data['p_schedule'][$k]['sch_pay_type']=$row->sch_pay_type;
                        // $data['p_schedule'][$k]['sch_agree_value']=$row->sch_agree_value;

                        $query=$this->db->query("SELECT * FROM purchase_schedule_taxation WHERE pur_id = '$pid' and sch_id = '$row->sch_id' and status = '$txn_status' order by tax_master_id Asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            //print_r($result_tax);
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                                $data['p_schedule'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                
                                $j++;
                            }
                        }

                        $k++;
                    }
                } 

                // $query=$this->db->query("SELECT A.pr_client_id, 
                //                         case when B.ow_type = '0' then 
                //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = B.ow_ind_id) 
                //                         when B.ow_type = '1' then B.ow_huf_name 
                //                         when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                //                         when B.ow_type = '3' then B.ow_ltd_comapny_name 
                //                         when B.ow_type = '4' then B.ow_llp_comapny_name 
                //                         when B.ow_type = '5' then B.ow_prt_comapny_name 
                //                         when B.ow_type = '6' then B.ow_aop_comapny_name 
                //                         when B.ow_type = '7' then B.ow_trs_comapny_name 
                //                         else B.ow_proprietorship_comapny_name end as c_name, 
                //                         A.pr_ownership_percent, A.pr_ownership_allocatedcost 
                //                         FROM purchase_ownership_details A, owner_master B 
                //                         WHERE A.purchase_id = '$pid' and A.pr_client_id=B.ow_id");
                // $result=$query->result();
                // $data['p_ownership']=$result;

                $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id = '$pid'");
                $result=$query->result();
                $data['p_ownership']=$result;

                $query=$this->db->query("SELECT * FROM purchase_property_description WHERE purchase_id = '$pid'");
                $result=$query->result();
                $data['p_description']=$result;

                $query=$this->db->query("SELECT * FROM purchase_property_description_images WHERE purchase_id = '$pid'");
                $result=$query->result();
                if(count($result)>0){
                    $data['p_description_img']=$result;
                }

                if($ptype=='Building'){
                    $pcolname="d_type_building";
                } else if($ptype=='Apartment'){
                    $pcolname="d_type_apartment";
                } else if($ptype=='Bunglow'){
                    $pcolname="d_type_bunglow";
                } else if($ptype=='Commercial'){
                    $pcolname="d_type_commercial";
                } else if($ptype=='Retail'){
                    $pcolname="d_type_retail";
                } else if($ptype=='Industrial'){
                    $pcolname="d_type_industry";
                } else if($ptype=='Land-Agriculture'){
                    $pcolname="d_type_landagriculture";
                } else if($ptype=='Land-NonAgriculture'){
                    $pcolname="d_type_landnonagricultural";
                } else {
                    $pcolname="";
                }

                $docs=$this->document_model->edit_view_doc($pcolname, $pid, 'Property_Purchase', 'purchase');
                $data=array_merge($data, $docs);

                // $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                // $result=$query->result();
                // $data['contact_type']=$result;

                // $sql = "select A.*, B.contact_name, B.c_contact_type, B.contact_type from
                //         (select * from related_party_details where ref_id = '$pid' and type = 'purchase') A 
                //         left join 
                //         (select * from 
                //         (select A.c_id, A.c_contact_type, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',
                //             ifnull(A.c_emailid1,''),' - ',ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',
                //             ifnull(B.contact_type,'')) as contact_name from 
                //         (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                //         left join 
                //         (select * from contact_type_master where g_id='$gid') B 
                //         on A.c_contact_type = B.id) C) B 
                //         on A.contact_id = B.c_id";
                // $query=$this->db->query($sql);
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['related_party']=$result;
                // }

                // $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$pid' and type = 'purchase'");
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['pending_activity']=$result;
                // }

                // $query=$this->db->query("SELECT * FROM purchase_amenity_details WHERE purchase_id = '$pid'");
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['p_amenity']=$result;
                // }

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['owner']=$result;

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $sql = "select A.*, B.amenity_id from 
                        (select * from amenity_master) A 
                        left join 
                        (select * from purchase_amenity_details where purchase_id='$pid') B 
                        on (A.id = B.amenity_id) 
                        order by A.amenity";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['amenity']=$result;

                $data['p_id']=$pid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');
                $data['city'] = $this->city_model->get_city();

                // echo json_encode($data);

                load_view('purchase/purchase_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($pid, $details=false){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $result=$this->purchase_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 or $result[0]->r_approvals == 1 or $result[0]->r_view == 1) {
                $data['access']=$result;
                $ptype = '';

                $data['purchaseby']=$this->session->userdata('session_id');

                $result = $this->purchase_model->purchaseData('All', $pid);
                if(count($result)>0) {
                    $data['p_txn']=$result;
                    $ptype=$result[0]->p_type;

                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                } else {
                    $txn_status=3;
                    $ptype='';
                }

                $query=$this->db->query("SELECT * FROM purchase_consideration WHERE purchase_id = '$pid'");
                $result=$query->result();
                if(count($result)>0){
                    $data['p_considerations']=$result;
                }

                $distict_tax=$this->purchase_model->getDistinctTaxDetail($pid, $txn_status);
                $data['tax_name']=$distict_tax;
                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM purchase_schedule 
                    WHERE purchase_id = '".$pid."' and status = '$txn_status' GROUP BY event_type";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule']=array();

                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;

                        $query=$this->db->query("SELECT tax_type, sum(tax_amount) as tax_amount FROM purchase_schedule_taxation 
                                                WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $j++;
                            }
                        }
                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM purchase_schedule_taxation 
                                            WHERE pur_id = '".$pid."'  and status = '$txn_status' 
                                                group by tax_type order by tax_type asc");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id = '$pid'");
                $result=$query->result();
                $data['p_ownership']=$result;

                $query=$this->db->query("SELECT * FROM purchase_property_description WHERE purchase_id = '$pid'");
                $result=$query->result();
                if(count($result)>0){
                    $data['p_description']=$result;
                }

                $query=$this->db->query("SELECT * FROM purchase_property_description_images WHERE purchase_id = '$pid'");
                $result=$query->result();
                if(count($result)>0){
                    $data['p_description_img']=$result;
                }

                if($ptype=='Building'){
                    $pcolname="d_type_building";
                } else if($ptype=='Apartment'){
                    $pcolname="d_type_apartment";
                } else if($ptype=='Bunglow'){
                    $pcolname="d_type_bunglow";
                } else if($ptype=='Commercial'){
                    $pcolname="d_type_commercial";
                } else if($ptype=='Retail'){
                    $pcolname="d_type_retail";
                } else if($ptype=='Industrial'){
                    $pcolname="d_type_industry";
                } else if($ptype=='Land-Agriculture'){
                    $pcolname="d_type_landagriculture";
                } else if($ptype=='Land-NonAgriculture'){
                    $pcolname="d_type_landnonagricultural";
                } else {
                    $pcolname="";
                }

                // $docs=$this->document_model->edit_view_doc($pcolname, $pid, 'Property_Purchase', 'purchase');
                $docs=$this->document_model->view_doc($pcolname, $pid, 'Property_Purchase');
                $data=array_merge($data, $docs);


                // $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                // $result=$query->result();
                // $data['contact_type']=$result;

                // $sql = "select A.*, B.contact_name, B.c_contact_type, B.contact_type from
                //         (select * from related_party_details where ref_id = '$pid' and type = 'purchase') A 
                //         left join 
                //         (select * from 
                //         (select A.c_id, A.c_contact_type, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',
                //             ifnull(A.c_emailid1,''),' - ',ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',
                //             ifnull(B.contact_type,'')) as contact_name from 
                //         (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                //         left join 
                //         (select * from contact_type_master where g_id='$gid') B 
                //         on A.c_contact_type = B.id) C) B 
                //         on A.contact_id = B.c_id";
                // $query=$this->db->query($sql);
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['related_party']=$result;
                // }
                
                // $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$pid' and type = 'purchase'");
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['pending_activity']=$result;
                // }

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['owner']=$result;

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("SELECT A.*, B.amenity_id FROM amenity_master A left join purchase_amenity_details B on (A.id = B.amenity_id) where B.purchase_id='$pid' or B.purchase_id is null order by amenity");
                $result=$query->result();
                $data['amenity']=$result;

                $data['r_txn']=$this->rent_model->rentData('Approved', $pid);

                $data['bankentry']=$this->accounting_model->bankentryData('Approved', $pid);
                $data['pendingbankentry']=$this->accounting_model->getPendingBankEntry('Approved', $pid);

                $sql = "select (H.total_cnt-H.sale_cnt-H.rent_cnt) as vacant_cnt, total_cnt, sale_cnt, rent_cnt from 
                        (select count(txn_id) as total_cnt, count(sale_id) as sale_cnt, count(rent_id) as rent_cnt from 
                        (select E.*, F.txn_id as sale_id from 
                        (select C.*, D.txn_id as rent_id from 
                        (select A.txn_id, case when B.txn_id is null then 0 else B.txn_id end as sp_id from 
                        (select txn_id from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
                        left join 
                        (select txn_id, property_id from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
                        on (A.txn_id=B.property_id) where B.txn_id is not null) C 
                        left join 
                        (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                            from rent_txn where gp_id='$gid' and txn_status = 'Approved') D 
                        on (C.txn_id = D.property_id and C.sp_id = D.sub_property_id)) E 
                        left join 
                        (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                            from sales_txn where gp_id='$gid' and txn_status = 'Approved') F 
                        on (E.txn_id = F.property_id and E.sp_id = F.sub_property_id)) G) H";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['property_cnt']=$result;

                $sql = "select C.*, D.tot_principal, D.tot_outstanding from 
                        (select A.*, B.disbursement_amount, B.emi from 
                        (select * from loan_txn where txn_id in (select distinct loan_id from loan_property_details where property_id = '$pid')) A 
                        left join 
                        (select * from loan_disbursement) B 
                        on (A.txn_id = B.loan_id)) C 
                        left join 
                        (select table_type, fk_txn_id, sum(principal) as tot_principal, sum(tot_outstanding) as tot_outstanding 
                            from actual_schedule where txn_status = 'Approved' and table_type = 'loan' group by table_type, fk_txn_id) D 
                        on (C.txn_id = D.fk_txn_id)";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['l_txn']=$result;

                $sql = "select A.*, B.* from 
                        (select * from sales_txn where property_id = '$pid') A 
                        left join 
                        (SELECT A.*, B.* FROM 
                        (SELECT * FROM sales_buyer_details) A 
                        LEFT JOIN 
                        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                            case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') B 
                        ON (A.buyer_id=B.c_id)) B 
                        on A.txn_id=B.sale_id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['s_txn']=$result;

                $data['p_id']=$pid;
                $maintenance_count = $this->db->query("SELECT count(id) as `count` from user_task_detail where property_id=$pid")->result_array();
                $tenant_count = $this->db->query("SELECT count(rt.txn_id) as count from rent_txn rt join rent_tenant_details rtd on  rt.txn_id=rtd.rent_id
                    WHERE rt.property_id=$pid")->result_array();

                $data['maker_checker'] = $this->session->userdata('maker_checker');
                $data['maintenance_count'] = $maintenance_count[0]['count'];
                $data['tenant_count'] = $tenant_count[0]['count'];

                if($details==true){
                    load_view('purchase/purchase_view_details',$data);
                } else {
                    load_view('purchase/purchase_view',$data);
                }
                
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($pid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($pid);
        } else  {
            $this->updaterecord($pid);
        }
    }

    public function updaterecord($pid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
                if($this->input->post('submit')=='Delete') {
                    $txn_status='Delete';
                } elseif($this->input->post('submit')=='Submit For Approval') {
                    $txn_status='Pending';
                } else if($this->input->post('submit')=='Submit') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='In Process';
                }

            $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id = '$pid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update purchase_txn set txn_status='$txn_status', remarks='$remarks', 
                                            modified_by='$curusr', modified_date='$modnow' WHERE txn_id = '$pid'");

                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Purchase';
                            $logarray['cnt_name']='Purchase';
                            $logarray['action']='Purchase Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_fkid = '$pid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $pid = $result[0]->txn_id;

                                $this->db->query("Update purchase_txn set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$pid'");
                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Purchase';
                                $logarray['cnt_name']='Purchase';
                                $logarray['action']='Purchase Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into purchase_txn (gp_id, p_property_name, p_display_name, 
                                                p_purchase_date, p_purchase_mode, p_type, p_status, p_builder_name, p_usage, 
                                                p_apartment, p_flatno, p_floor, p_wing, p_address, p_state, p_city, p_pincode, p_country,
                                                p_googlemaplink, p_propertydescription, txn_status, create_date, created_by, 
                                                modified_date, modified_by, approved_by, approved_date, rejected_by, rejected_date, 
                                                remarks, p_landmark, txn_fkid, maker_remark, p_image, p_image_name) 
                                                Select '$gp_id', p_property_name, p_display_name, 
                                                p_purchase_date, p_purchase_mode, p_type, p_status, p_builder_name, p_usage, 
                                                p_apartment, p_flatno, p_floor, p_wing, p_address, p_state, p_city, p_pincode, p_country,
                                                p_googlemaplink, p_propertydescription, '$txn_status', '$create_date', '$created_by', 
                                                '$modnow', '$curusr', approved_by, approved_date, rejected_by, rejected_date, 
                                                '$txnremarks', p_landmark, '$pid', maker_remark, p_image, p_image_name 
                                                FROM purchase_txn WHERE txn_id = '$pid'");
                                $new_pid=$this->db->insert_id();
                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Purchase';
                                $logarray['cnt_name']='Purchase';
                                $logarray['action']='Purchase Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into purchase_ownership_details (purchase_id, pr_client_id, pr_ownership_percent, pr_ownership_allocatedcost) 
                                                 Select '$new_pid', pr_client_id, pr_ownership_percent, pr_ownership_allocatedcost 
                                                 FROM purchase_ownership_details WHERE purchase_id = '$pid'");

                                $this->db->query("Insert into purchase_property_description (purchase_id, pr_description, pr_agreement_area, 
                                                 pr_agreement_unit, pr_land_area, pr_land_unit, pr_carpet_area, pr_carpet_unit, pr_builtup_area, 
                                                 pr_builtup_unit, pr_sellable_area, pr_sellable_unit, pr_bunglow_area, pr_bunglow_unit, 
                                                 pr_bathroom, pr_open_parking, pr_covered_parking, pr_no_of_floors, pr_no_of_flats, pr_no_of_shops) 
                                                 Select '$new_pid', pr_description, pr_agreement_area, 
                                                 pr_agreement_unit, pr_land_area, pr_land_unit, pr_carpet_area, pr_carpet_unit, pr_builtup_area, 
                                                 pr_builtup_unit, pr_sellable_area, pr_sellable_unit, pr_bunglow_area, pr_bunglow_unit, 
                                                 pr_bathroom, pr_open_parking, pr_covered_parking, pr_no_of_floors, pr_no_of_flats, pr_no_of_shops 
                                                 FROM purchase_property_description WHERE purchase_id = '$pid'");

                                $this->db->query("Insert into purchase_property_description_images (purchase_id, file_path, 
                                                 file_name, file_date, file_description) 
                                                 Select '$new_pid', file_path, file_name, file_date, file_description 
                                                 FROM purchase_property_description_images WHERE purchase_id = '$pid'");

                                // $this->db->query("Insert into purchase_document_details (pr_doc_purchaseid, pr_doc_name, pr_doc_description, 
                                //                  pr_doc_ref_no, pr_doc_doi, pr_doc_doe, pr_document, pr_document_name, fk_d_id) 
                                //                  Select '$new_pid', pr_doc_name, pr_doc_description, 
                                //                  pr_doc_ref_no, pr_doc_doi, pr_doc_doe, pr_document, pr_document_name, fk_d_id 
                                //                  FROM purchase_document_details WHERE pr_doc_purchaseid = '$pid'");


                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_pid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$pid' and doc_ref_type = 'Property_Purchase'");

                                $query=$this->db->query("SELECT * FROM purchase_schedule WHERE purchase_id = '$pid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into purchase_schedule (purchase_id, event_name, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, event_type, status) 
                                                         Select '$new_pid', event_name, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$cursur', event_type, status 
                                                         FROM purchase_schedule WHERE purchase_id = '$pid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into purchase_schedule_taxation (sch_id, tax_type, tax_percent, 
                                                         tax_amount, pur_id, event_type, tax_master_id, status) 
                                                         Select '$new_sch_id', tax_type, tax_percent, tax_amount, '$new_pid', event_type, tax_master_id, status 
                                                         FROM purchase_schedule_taxation WHERE pur_id = '$pid' and sch_id = '$sch_id'");
                                    }
                                }

                                $this->db->query("Insert into purchase_amenity_details (purchase_id, amenity_id) 
                                                 Select '$new_pid', amenity_id FROM purchase_amenity_details WHERE purchase_id = '$pid'");

                                // $this->db->query("Insert into related_party_details (ref_id, type, contact_id, remarks) 
                                //                  Select '$new_pid', type, contact_id, remarks FROM related_party_details 
                                //                  WHERE ref_id = '$pid' and type = 'purchase'");

                                // $this->db->query("Insert into pending_activity (ref_id, type, pending_activity) 
                                //                  Select '$new_pid', type, pending_activity FROM pending_activity 
                                //                  WHERE ref_id = '$pid' and type = 'purchase'");
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $pid);
                        $this->db->delete('purchase_txn');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_ownership_details');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_property_description');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_property_description_images');

                        // $this->db->where('pr_doc_purchaseid', $pid);
                        // $this->db->delete('purchase_document_details');

                        $this->db->where('doc_ref_id', $pid);
                        $this->db->where('doc_ref_type', 'Property_Purchase');
                        $this->db->delete('document_details');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_schedule');

                        $this->db->where('pur_id', $pid);
                        $this->db->delete('purchase_schedule_taxation');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_amenity_details');

                        // $this->db->where('ref_id', $pid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('related_party_details');

                        // $this->db->where('ref_id', $pid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('pending_activity');

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Purchase');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $purdt=$this->input->post('date_of_purchase');
                    if($purdt==''){
                        $purdt=NULL;
                    } else {
                        $purdt=formatdate($purdt);
                    }
                    $data = array(
                        'p_property_name' => $this->input->post('property_name'),
                        'p_display_name' => $this->input->post('property_name'),
                        'p_purchase_date' => $purdt,
                        'p_purchase_mode' => $this->input->post('purchase_mode'),
                        'p_type' => $this->input->post('property_type'),
                        'p_status' => $this->input->post('property_status'),
                        'p_builder_name' => $this->input->post('builder_name'),
                        'p_usage' => $this->input->post('property_usage'),
                        'p_apartment' => $this->input->post('apartment_name'),
                        'p_flatno' => $this->input->post('flat_no'),
                        'p_floor' => $this->input->post('floor'),
                        'p_wing' => $this->input->post('wing'),
                        'p_address' => $this->input->post('address'),
                        'p_landmark' => $this->input->post('landmark'),
                        'p_state' => $this->input->post('state'),
                        'p_city' => $this->input->post('city'),
                        'p_pincode' => $this->input->post('pincode'),
                        'p_country' => $this->input->post('country'),
                        'p_googlemaplink' => $this->input->post('googlemaplink'),
                        'p_propertydescription' => $this->input->post('property_description'),
                        'gp_id' => $gp_id,
                        'txn_status' => $txn_status,
                        'maker_remark'=>$this->input->post('maker_remark')
                    );
                       
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $pid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('purchase_txn',$data);
                        $pid=$this->db->insert_id();

                        $sql = "update purchase_txn A, purchase_txn B set A.p_image = B.p_image, A.p_image_name = B.p_image_name 
                                where A.txn_id = '$pid' and B.txn_id = '$txn_fkid'";
                        $this->db->query($sql);
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->query("Insert into purchase_property_description_images (purchase_id, file_path, 
                                         file_name, file_date, file_description) 
                                         Select '$pid', file_path, file_name, file_date, file_description 
                                         FROM purchase_property_description_images 
                                         WHERE purchase_id = '$txn_fkid'");

                        // $this->db->query("Insert into purchase_document_details (pr_doc_purchaseid, pr_doc_name, 
                        //                  pr_doc_description, pr_doc_ref_no, pr_doc_doi, pr_doc_doe, pr_document, 
                        //                  pr_document_name, fk_d_id) 
                        //                  Select '$pid', pr_doc_name, pr_doc_description, pr_doc_ref_no, pr_doc_doi, 
                        //                  pr_doc_doe, pr_document, pr_document_name, fk_d_id FROM purchase_document_details 
                        //                  WHERE pr_doc_purchaseid = '$txn_fkid'");
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $pid);
                        $this->db->update('purchase_txn',$data);

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_property_description');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_ownership_details');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_schedule');
                        
                        $this->db->where('pur_id', $pid);
                        $this->db->delete('purchase_schedule_taxation');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_amenity_details');

                        // $this->db->where('ref_id', $pid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('related_party_details');
                        
                        // $this->db->where('ref_id', $pid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('pending_activity');
                    }

                    $purchase_ownership_details=$this->purchase_model->insertOwnershipDetails($pid);

                    $this->purchase_model->propertyDescription($pid);

                    $this->purchase_model->insertImage($pid);

                    $this->purchase_model->insertSchedule($pid, $txn_status);

                    // $this->transaction_model->insertRPDetails($pid, 'purchase');
                    // $this->transaction_model->insertPendingActivity($pid, 'purchase');

                    $query=$this->db->query("SELECT * FROM purchase_property_description_images WHERE purchase_id = '$pid'");
                    $result=$query->result();
                    $file_path_db=NULL;
                    $file_path_count=0;

                    for ($i=0; $i < count($result) ; $i++) { 
                        $file_path_db[$i]['filepath']=$result[$i]->file_path;
                        $file_path_db[$i]['filename']=$result[$i]->file_name;
                        $file_path_db[$i]['filedate']=$result[$i]->file_date;
                        $file_path_db[$i]['filedesc']=$result[$i]->file_description;
                        $file_path_count=$i;
                    }

                    // if ($rec_status!="Approved") {
                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_property_description_images');
                    // }

                    $capdate=$this->input->post('capture_date[]');
                    $capdesc=$this->input->post('capture_description[]');

                    $do_type = 'property_purchase';

                    $filePath='assets/uploads/property_purchase/'.$do_type.'_'.$pid.'/property_purchase_images/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $confi['upload_path']=$upload_path;
                    $confi['allowed_types']='*';
                    $this->load->library('upload', $confi);

                    for ($k=0; $k <  count($capdate); $k++) { 
                        if($capdate[$k]=="") {
                            $cadt = NULL;
                        } else {
                            $cadt = formatdate($capdate[$k]);
                        }

                        $extension="";

                        $file_nm='propertydoc_'.$k;
                        $this->upload->initialize(array(
                        "upload_path"       => $upload_path,
                        "encrypt_name"      => FALSE,
                        "remove_spaces"     => TRUE,    
                        "allowed_types"     => '*',
                        "file_name"         => $file_nm,
                        "max_size"          => '20000000'
                         ));

                        if(!empty($_FILES[$file_nm]['name'])) {
                            if($this->upload->do_upload($file_nm)) {
                                echo "Uploaded <br>";
                            } else {
                                echo "Failed<br>";
                                echo $this->upload->data();
                            }   

                            $upload_data=$this->upload->data();
                            $fileName=$upload_data['file_name'];
                            $extension=$upload_data['file_ext'];
							$full_path = $upload_data['full_path'];

                            // check EXIF and autorotate if needed
				            $this->load->library('image_autorotate', array('filepath' => $full_path));

                            if($capdate[$k]=='') {
                                $dttx = NULL;
                            } else {
                                $dttx = formatdate($capdate[$k]);
                            }
                            echo 'gdg'.$dttx.'123';
                            $data = array(
                                'purchase_id' => $pid,
                                'file_path' => $filePath.$fileName,
                                'file_name' => $fileName,
                                'file_date' => $dttx,
                                'file_description' => $capdesc[$k],
                            );
                            $this->db->insert('purchase_property_description_images', $data);
                            echo "Main<br>";
                        } else {
                            if($capdate[$k]=='') {
                                $dttx = NULL;
                            } else {
                                $dttx = formatdate($capdate[$k]);
                            }

                            if($file_path_count>=$k) {
                                $path=$file_path_db[$k]['filepath'];
                                $flnm=$file_path_db[$k]['filename'];
                            } else {
                                $path="";
                                $flnm="";
                            }
                            echo "Other<br>";
                            $data = array(
                                'purchase_id' => $pid,
                                'file_path' => $path,
                                'file_name' => $flnm,
                                'file_date' => $dttx,
                                'file_description' => $capdesc[$k],
                            );
                            $this->db->insert('purchase_property_description_images', $data);
                        }
                    }


                    $this->document_model->insert_doc($pid, 'Property_Purchase');
                    
                    $this->purchase_model->insertAmenityDetails($pid);

                    redirect(base_url().'index.php/Purchase');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($pid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id = '$pid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update purchase_txn set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$pid'");

                    $logarray['table_id']=$pid;
                    $logarray['module_name']='Purchase';
                    $logarray['cnt_name']='Purchase';
                    $logarray['action']='Purchase Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update purchase_txn set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$pid'");
                        $this->db->query("update purchase_schedule set sch_status = '1', status='1' WHERE purchase_id = '$pid'");
                        $this->db->query("update purchase_schedule_taxation set status='1' WHERE pur_id = '$pid'");

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update purchase_txn A, purchase_txn B set A.gp_id=B.gp_id, 
                                         A.p_property_name=B.p_property_name, A.p_display_name=B.p_display_name, 
                                         A.p_purchase_date=B.p_purchase_date, A.p_purchase_mode=B.p_purchase_mode, 
                                         A.p_type=B.p_type, A.p_status=B.p_status, A.p_builder_name=B.p_builder_name, 
                                         A.p_usage=B.p_usage, A.p_apartment=B.p_apartment, A.p_flatno=B.p_flatno, 
                                         A.p_floor=B.p_floor, A.p_wing=B.p_wing, A.p_address=B.p_address, A.p_state=B.p_state, 
                                         A.p_city=B.p_city, A.p_pincode=B.p_pincode, A.p_country=B.p_country, A.p_googlemaplink=B.p_googlemaplink, 
                                         A.p_propertydescription=B.p_propertydescription, A.txn_status='$txn_status', 
                                         A.create_date=B.create_date, A.created_by=B.created_by, A.modified_date=B.modified_date, 
                                         A.modified_by=B.modified_by, A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.remarks='$remarks', A.p_landmark=B.p_landmark, 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark, A.p_image=B.p_image, A.p_image_name=B.p_image_name 
                                         WHERE B.txn_id = '$pid' and A.txn_id=B.txn_fkid");
                        
                        $this->db->where('purchase_id', $txn_fkid);
                        $this->db->delete('purchase_ownership_details');
                        $this->db->query("update purchase_ownership_details set purchase_id = '$txn_fkid' WHERE purchase_id = '$pid'");

                        $this->db->where('purchase_id', $txn_fkid);
                        $this->db->delete('purchase_property_description');
                        $this->db->query("update purchase_property_description set purchase_id = '$txn_fkid' WHERE purchase_id = '$pid'");

                        $this->db->where('purchase_id', $txn_fkid);
                        $this->db->delete('purchase_property_description_images');
                        $this->db->query("update purchase_property_description_images set purchase_id = '$txn_fkid' WHERE purchase_id = '$pid'");

                        // $this->db->where('pr_doc_purchaseid', $txn_fkid);
                        // $this->db->delete('purchase_document_details');
                        // $this->db->query("update purchase_document_details set pr_doc_purchaseid = '$txn_fkid' WHERE pr_doc_purchaseid = '$pid'");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Purchase');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$pid' and doc_ref_type = 'Property_Purchase'");

                        $this->db->query("update purchase_schedule set sch_status = '2', status='2' WHERE purchase_id = '$txn_fkid'");
                        $this->db->query("update purchase_schedule set purchase_id = '$txn_fkid', sch_status = '1', status='1' WHERE purchase_id = '$pid'");

                        $this->db->query("update purchase_schedule_taxation set status='2' WHERE pur_id = '$txn_fkid'");
                        $this->db->query("update purchase_schedule_taxation set pur_id = '$txn_fkid', status='1' WHERE pur_id = '$pid'");

                        $this->db->where('purchase_id', $txn_fkid);
                        $this->db->delete('purchase_amenity_details');
                        $this->db->query("update purchase_amenity_details set purchase_id = '$txn_fkid' WHERE purchase_id = '$pid'");

                        // $this->db->where('ref_id', $txn_fkid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('related_party_details');
                        // $this->db->query("update related_party_details set ref_id = '$txn_fkid' WHERE ref_id = '$pid' and type = 'purchase'");

                        // $this->db->where('ref_id', $txn_fkid);
                        // $this->db->where('type', 'purchase');
                        // $this->db->delete('pending_activity');
                        // $this->db->query("update pending_activity set ref_id = '$txn_fkid' WHERE ref_id = '$pid' and type = 'purchase'");

                        $this->db->query("delete from purchase_txn WHERE txn_id = '$pid'");
                            
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Purchase');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->purchase_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['property']=$this->purchase_model->purchaseData($status);

            $count_data=$this->purchase_model->getAllCountData();
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

            load_view('purchase/purchase_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveTempBulkUpload() {
        $upload_txn_type=$this->input->post('upload_txn_type');
        // $_FILES['data_file']['name'];
        $data_array=array();
        $file=explode(".", $_FILES['data_file']['name']);
        //echo $file[1];
        $file_name="excel"."_".$file[0]."_".date('dmy').".xls";
        $upload_path = './assets/uploads/schedule_bulk_upload/';

        $this->load->library('upload');
        $this->upload->initialize(array(
            "upload_path"       => $upload_path,
            "encrypt_name"      => FALSE,
            "remove_spaces"     => TRUE,    
            "allowed_types"     => '*',
            "file_name"         => $file_name,
            "max_size"          => '20000000'
        ));

        if (!$this->upload->do_upload("data_file")){
            //echo "Not uploaded";
            $error = array('error' => $this->upload->display_errors());
            // var_dump($error);
        }else{
            //echo "uploaded";
            $data = array('upload_data' => $this->upload->data());
        }

        // echo json_encode($data);
        
        $excel=PHPExcel_IOFactory::load($data['upload_data']['full_path']);
        $sheet=$excel->setActiveSheetIndex(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $mistake=0;
        $tax_available='';
        $errormsg='';
        for ($row = 2; $row <= $highestRow; ++$row) {
            if($sheet->getCellByColumnAndRow(1, $row)->getValue()==''){
                $event_type.=$row.",";
                $mistake++;
            }                
            // if($sheet->getCellByColumnAndRow(4, $row)->getValue()==''){
            //     $basic_cost.=$row.",";
            //     $mistake++;
            // }
            $tax_available=$tax_available.','.addslashes($sheet->getCellByColumnAndRow(5, $row)->getValue());
        }

        //echo $mistake;
        //echo $tax_available;
        
        $getAllTaxes=$this->purchase_model->getAllTaxes($upload_txn_type);
        $alltaxes=array();
        foreach($getAllTaxes as $row){
            $alltaxes[]=$row->tax_name;
        }
        $tax_available=explode(',',$tax_available);
       // print_r($alltaxes);
       // print_r($tax_available);
        $tax_available=array_filter($tax_available);
        $result_array=array_diff($tax_available,$alltaxes);
        //print_r($result_array);
        if(count($result_array) > 0 ){
            $mistake++;
            $tax_not_available="following taxes are not availbale please update in Tax master.\n".implode(',',$result_array);
            $errormsg=$errormsg.$tax_not_available;
        }

        if($mistake > 0 ){
            $response=array("status"=>false,"errormsg"=>$errormsg);
        } else {
            for ($row = 2; $row <= $highestRow; ++$row) {
                $InvDate=$sheet->getCellByColumnAndRow(3,$row)->getValue();
                $event_date= date($format = "d/m/Y", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                $data['p_schedule'][$row]['event_type']=addslashes($sheet->getCellByColumnAndRow(1, $row)->getValue());
                $data['p_schedule'][$row]['event_name']=addslashes($sheet->getCellByColumnAndRow(2,$row)->getValue());
                // $data['p_schedule'][$row]['sch_pay_type']=addslashes($sheet->getCellByColumnAndRow(3,$row)->getValue());
                // $data['p_schedule'][$row]['sch_agree_value']=addslashes($sheet->getCellByColumnAndRow(4,$row)->getValue());

                $data['p_schedule'][$row]['event_date']=$event_date;
                $data['p_schedule'][$row]['basic_cost']=addslashes($sheet->getCellByColumnAndRow(4,$row)->getValue());
                $tax_apply=explode(',',addslashes($sheet->getCellByColumnAndRow(5,$row)->getValue()));
                for($i=0;$i<count($tax_apply);$i++){
                    $data['p_schedule'][$row]['tax_type'][$i]=$tax_apply[$i];
                }
            }
            $rowcounter=$highestRow;
            $data['tax_details']=$this->purchase_model->getAllTaxes($upload_txn_type);                
            $bulkuploaddata=$this->load->view('purchase/bulk_upload_view',$data,true);
            $response=array("status"=>true,"data"=>$bulkuploaddata,"rowcounter"=>$rowcounter);
        }

        echo json_encode($response);
    }

    function check_availablity() {
        $gid=$this->session->userdata('groupid');
        $p_id = html_escape($this->input->post('p_id'));
        $p_name = html_escape($this->input->post('p_name'));

        // $gid='6';
        // $p_id = '56';
        // $p_name = 'qwer';

        $result = $this->purchase_model->check_availablity($gid, $p_id, $p_name);
        echo $result;
    }

    public function send_mail_test(){
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Purchase Intimation';

        $message = '<html><head></head><body>Dear aaaa<br /><br />
                    We would like to bring to your notice that a New Purchase Entry has been created for bbbb. 
                    The Property details are as follows.<br /><br />ttttt<br /><br />
                    If the above Property is not yours please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email_new($from_email,  $from_email_sender, 'prasad.bhisale@otbconsulting.co.in', $subject, $message);
    }

}
?>