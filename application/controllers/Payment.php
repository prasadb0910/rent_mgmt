<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Payment extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->helper("file");
        $this->load->helper('cookie');
        $this->load->helper('string');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('payment_model');
    }

    public function index(){ 
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_view=='1' || $result[0]->r_insert=='1' || $result[0]->r_edit=='1' || $result[0]->r_delete=='1' || $result[0]->r_approvals=='1' || $result[0]->r_export=='1') {
                $data['access']=$result;

                $this->set_payment_details();

                $sql = "select A.*, B.name as user_name from user_payment_details A left join group_users B on (A.user_id = B.gu_id)";
                $data['payments'] = $this->db->query($sql)->result();

                load_view('payment/index', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function pay_now($id){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_edit=='1') {
                $data['access']=$result;

                $sql = "select A.*, B.name as user_name from user_payment_details A left join group_users B on (A.user_id = B.gu_id) where A.id = '$id'";
                $data['data'] = $this->db->query($sql)->result();

                load_view('payment/payment_details', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function calculateFiscalYearForDate($inputDate){
        $year=substr($inputDate, 0, strpos($inputDate, "-"));
        $month=substr($inputDate, strpos($inputDate, "-")+1, strrpos($inputDate, "-")-1);

        $year=intval($year);
        $month=intval($month);

        if($month<4){
            $fyStart=$year-1;
            $fyEnd=$year;
        } else {
            $fyStart=$year;
            $fyEnd=$year+1;
        }

        $fyStart=substr(strval($fyStart),2);
        $fyEnd=substr(strval($fyEnd),2);

        $financial_year=$fyStart.'-'.$fyEnd;

        return $financial_year;
    }
    
    public function generate_invoice_no($order_date){
        $sql="select * from series_master where type='Tax_Invoice'";
        $result=$this->db->query($sql)->result();
        if(count($result)>0){
            $series=intval($result[0]->series)+1;

            $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
            $this->db->query($sql);
        } else {
            $series=1;

            $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
            $this->db->query($sql);
        }

        if (isset($order_date)){
            if($order_date==''){
                $financial_year="";
            } else {
                $financial_year=$this->calculateFiscalYearForDate($order_date);
            }
        } else {
            $financial_year="";
        }
        
        $invoice_no = 'PECAN/'.$financial_year.'/'.strval($series);

        return $invoice_no;
    }

    public function set_payment_details(){
        $sql = "select max(payment_id) as payment_id from user_payment_details";
        $data = $this->db->query($sql)->result();
        $payment_id = 0;
        if(count($data)>0){
            if(isset($data[0]->payment_id)){
                $payment_id = intval($data[0]->payment_id);
            }
        }

        $sql = "select * from payment_transactions where id > " . $payment_id . " order by id";
        $data = $this->db->query($sql)->result();
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->status=='Success'){
                    $payment_id = $data[$i]->id;
                    $user_id = $data[$i]->user_id;
                    $sub_id = $data[$i]->sub_id;
                    $trans_id = $data[$i]->trans_id;
                    $transaction_amount = $data[$i]->amount;
                    $order_date = $data[$i]->order_date;
                    $pay_mode = $data[$i]->pay_mode;
                    $sub_start_date = $data[$i]->sub_start_date;
                    $sub_end_date = $data[$i]->sub_end_date;

                    $num_of_prop = 0;
                    $plan_name = '';
                    $invoice_no = '';

                    if(isset($sub_id)){
                        if($sub_id!=0){
                            $sql = "select * from subscription where id = " . $sub_id;
                            $data2 = $this->db->query($sql)->result();
                            $num_of_prop = 0;
                            $plan_name = '';
                            if(count($data2)>0){
                                $num_of_prop = $data2[0]->num_of_prop;
                                $plan_name = $data2[0]->package_name;
                            }

                            $invoice_no = $this->generate_invoice_no($order_date);

                            $data3['user_id'] = $user_id;
                            $data3['payment_id'] = $payment_id;
                            $data3['payment_date'] = $order_date;
                            $data3['plan_name'] = $plan_name;
                            $data3['invoice_no'] = $invoice_no;
                            $data3['invoice_date'] = $order_date;
                            $data3['no_of_properties'] = $num_of_prop;
                            $data3['payment_method'] = $pay_mode;
                            $data3['transaction_amount'] = $transaction_amount;
                            // $data3['payment_due_date'] = $sub_end_date;
                            $data3['payment_status'] = 'paid';
                            $data3['status'] = 'approved';
                            $data3['created_by'] = '1';
                            $data3['updated_by'] = '1';

                            $value = floatval($transaction_amount);
                            $amount = round($value/1.18,2);
                            $discount = 0;
                            $price = round($amount - $discount,2);
                            $cgst_rate = 9;
                            $sgst_rate = 9;
                            $igst_rate = 0;
                            $cgst = round($amount * $cgst_rate / 100,2);
                            $sgst = round($amount * $sgst_rate / 100,2);
                            $igst = round($amount * $igst_rate / 100,2);
                            $gst = round($cgst + $sgst + $igst,2);
                            $total_amount = round($amount + $gst,2);
                            $round_off_amount = round($value - $total_amount,2);

                            $data3['amount'] = $amount;
                            $data3['discount'] = $discount;
                            $data3['price'] = $price;
                            $data3['cgst_rate'] = $cgst_rate;
                            $data3['sgst_rate'] = $sgst_rate;
                            $data3['igst_rate'] = $igst_rate;
                            $data3['cgst'] = $cgst;
                            $data3['sgst'] = $sgst;
                            $data3['igst'] = $igst;
                            $data3['gst'] = $gst;
                            $data3['total_amount'] = $total_amount;
                            $data3['round_off_amount'] = $round_off_amount;

                            $this->db->insert('user_payment_details', $data3);

                            $data4['user_id'] = $user_id;
                            $data4['plan_name'] = $plan_name;
                            $data4['no_of_properties'] = $num_of_prop;
                            $data4['plan_expires_on'] = $sub_end_date;
                            $data4['status'] = 'approved';
                            $data4['created_by'] = '1';
                            $data4['updated_by'] = '1';

                            $sql = "select * from user_plan_details where user_id = " . $user_id;
                            $data2 = $this->db->query($sql)->result();
                            if(count($data2)>0){
                                $id = $data2[0]->id;

                                $this->db->where('id', $id);
                                $this->db->update('user_plan_details',$data4);
                            } else {
                                $this->db->insert('user_plan_details', $data4);
                            }

                            // echo json_encode($data4);
                            // echo '<br/>';
                        }
                    }
                    
                    if(isset($trans_id)){
                        if($trans_id!=0){
                            $sql = "select * from user_payment_details where id = " . $trans_id;
                            $data2 = $this->db->query($sql)->result();
                            if(count($data2)>0){
                                $data3['payment_id'] = $payment_id;
                                $data3['payment_date'] = $order_date;
                                $data3['payment_method'] = $pay_mode;
                                $data3['payment_status'] = 'paid';
                                $data3['updated_by'] = '1';

                                $id = $data2[0]->id;
                                $this->db->where('id', $id);
                                $this->db->update('user_payment_details',$data3);

                                // echo json_encode($data3);
                                // echo '<br/>';
                            }
                        }
                    }
                }
            }
        }
    }

    public function set_monthly_payment_details(){
        $sql = "select distinct created_by from group_master where group_status = 'Active' and created_by!='0' order by created_by";
        $data = $this->db->query($sql)->result();
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                $user_id = $data[$i]->created_by;
                $now = date('Y-m-d');
                $prop_num = 0;
                $transaction_amount = 0;

                // $start_date = date("Y-m-1", strtotime("-1 month"));
                // $end_date = date("Y-m-t", strtotime("-1 month"));

                $start_date = date("Y-m-d", strtotime("-1 month"));
                $end_date = date("Y-m-d");

                // echo $user_id;
                // echo '<br/>';
                // echo $start_date;
                // echo '<br/>';
                // echo $end_date;
                // echo '<br/>';

                $sql = "select * from user_plan_details where user_id = '$user_id'";
                $data2 = $this->db->query($sql)->result();
                if(count($data2)>0){
                    $plan_name = $data2[0]->plan_name;
                    $no_of_properties = intval($data2[0]->no_of_properties);
                    $plan_expires_on = new DateTime($data2[0]->plan_expires_on);
                } else {
                    $plan_name = '';
                    $no_of_properties = 0;
                    $plan_expires_on = '';
                }

                // echo $plan_name;
                // echo '<br/>';
                // echo $no_of_properties;
                // echo '<br/>';

                // $plan_expires_on = new DateTime('2017-10-25');

                $start_date = new DateTime($start_date);
                $end_date = new DateTime($end_date);
                $balance_days = 0;

                if($plan_expires_on != ''){
                    if($plan_expires_on>=$start_date && $plan_expires_on<=$end_date){
                        $diff = date_diff($plan_expires_on, $end_date);
                        $balance_days = intval($diff->format("%a"));
                    } else {
                        $balance_days = 0;
                    }
                }
                
                // echo $balance_days;
                // echo '<br/>';

                $sql = "select count(txn_id) as no_of_prop from purchase_txn where txn_status = 'Approved' and 
                            gp_id in (select distinct g_id from group_master where group_status = 'Active' and created_by = '$user_id')";
                $data2 = $this->db->query($sql)->result();
                if(count($data2)>0){
                    $no_of_prop = intval($data2[0]->no_of_prop);
                } else {
                    $no_of_prop = 0;
                }

                // echo $sql;
                // echo '<br/>';
                // echo $no_of_properties;
                // echo '<br/>';
                // echo $no_of_prop;
                // echo '<br/>';

                $invoice_date = null;
                $sql = "select max(invoice_date) as invoice_date from user_payment_details where status = 'approved' and user_id = '$user_id' and plan_name = 'Monthly'";
                $data2 = $this->db->query($sql)->result();
                if(count($data2)>0){
                    if(isset($data2[0]->invoice_date)){
                        $invoice_date = new DateTime($data2[0]->invoice_date);
                    }
                }

                if($no_of_properties<$no_of_prop){
                    $prop_num = $no_of_prop - $no_of_properties;

                    $sql = "select * from 
                            (select * from purchase_txn where txn_status = 'Approved' and 
                            gp_id in (select distinct g_id from group_master where group_status = 'Active' and created_by = '$user_id')) A limit " . $prop_num;
                    $data2 = $this->db->query($sql)->result();

                    // echo $sql;
                    // echo '<br/>';

                    if(count($data2)>0){
                        for($j=0; $j<count($data2); $j++){
                            $created_at = $data2[$j]->create_date;
                            $date = new DateTime($created_at);
                            $date = new DateTime($date->format('Y-m-d'));

                            if(isset($invoice_date)){
                                if($invoice_date>$date){
                                    $date = $invoice_date;
                                }
                            }

                            // echo $created_at;
                            // echo '<br/>';
                            // echo $invoice_date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $start_date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $end_date->format('Y-m-d H:i:s');
                            // echo '<br/>';

                            if($date>=$start_date && $date<=$end_date){
                                $diff = date_diff($date, $end_date);
                                $days = intval($diff->format("%a"));

                                // echo $created_at;
                                // echo '<br/>';
                                // echo $days;
                                // echo '<br/>';
                                // echo $balance_days;
                                // echo '<br/>';

                                // if($days>$balance_days){
                                //     $transaction_amount = $transaction_amount + ($balance_days*200)/30;
                                // } else {
                                //     $transaction_amount = $transaction_amount + ($days*200)/30;
                                // }

                                if($balance_days!=0){
                                    $transaction_amount = $transaction_amount + ($balance_days*200)/30;
                                } else {
                                    $transaction_amount = $transaction_amount + ($days*200)/30;
                                }

                            }
                        }
                    }
                }

                if($transaction_amount>0){
                    // echo $transaction_amount;
                    // echo '<br/>';

                    $invoice_no = $this->generate_invoice_no($end_date->format('Y-m-d'));

                    // echo $invoice_no;
                    // echo '<br/>';

                    // echo $end_date->format('Y-m-d');
                    // echo '<br/>';

                    $end_date->modify("+15 days");

                    // echo $end_date->format('Y-m-d');
                    // echo '<br/>';

                    $data3['user_id'] = $user_id;
                    // $data3['payment_id'] = $payment_id;
                    // $data3['payment_date'] = $order_date;
                    $data3['plan_name'] = 'Monthly';
                    $data3['invoice_no'] = $invoice_no;
                    $data3['invoice_date'] = date('Y-m-d');
                    $data3['no_of_properties'] = $prop_num;
                    // $data3['payment_method'] = $pay_mode;
                    $data3['transaction_amount'] = round($transaction_amount,0);
                    $data3['payment_due_date'] = $end_date->format('Y-m-d');
                    $data3['payment_status'] = 'pending';
                    $data3['status'] = 'approved';
                    $data3['created_by'] = '1';
                    $data3['updated_by'] = '1';

                    $value = round($transaction_amount,0);
                    $amount = round($value/1.18,2);
                    $discount = 0;
                    $price = round($amount - $discount,2);
                    $cgst_rate = 9;
                    $sgst_rate = 9;
                    $igst_rate = 0;
                    $cgst = round($amount * $cgst_rate / 100,2);
                    $sgst = round($amount * $sgst_rate / 100,2);
                    $igst = round($amount * $igst_rate / 100,2);
                    $gst = round($cgst + $sgst + $igst,2);
                    $total_amount = round($amount + $gst,2);
                    $round_off_amount = round($value - $total_amount,2);

                    // echo $amount;
                    // echo '<br/>';
                    // echo $gst;
                    // echo '<br/>';
                    // echo $value;
                    // echo '<br/>';
                    // echo $total_amount;
                    // echo '<br/>';
                    // echo $round_off_amount;
                    // echo '<br/>';

                    $data3['amount'] = $amount;
                    $data3['discount'] = $discount;
                    $data3['price'] = $price;
                    $data3['cgst_rate'] = $cgst_rate;
                    $data3['sgst_rate'] = $sgst_rate;
                    $data3['igst_rate'] = $igst_rate;
                    $data3['cgst'] = $cgst;
                    $data3['sgst'] = $sgst;
                    $data3['igst'] = $igst;
                    $data3['gst'] = $gst;
                    $data3['total_amount'] = $total_amount;
                    $data3['round_off_amount'] = $round_off_amount;

                    // echo json_encode($data3);
                    // echo '<br/>';

                    $this->db->insert('user_payment_details', $data3);
                }
            }
        }
    }

    public function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    public function save(Request $request){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_insert=='1' || $result[0]->r_edit=='1' || $result[0]->r_delete=='1' || $result[0]->r_approvals=='1') {
                $data['access']=$result;
                
                $data['id'] = $request->get('id');
                $data['payment_method'] = $request->get('payment_method');
                $data['payment_date'] = $this->FormatDate($request->get('payment_date'));
                $data['payment_ref'] = $request->get('payment_ref');
                $data['payment_status'] = 'paid';

                if($data['payment_method']=='Cheque'){
                    $data['bank_name'] = $request->get('bank_name');
                    $data['branch'] = $request->get('branch');
                    $data['cheque_date'] = $this->FormatDate($request->get('cheque_date'));
                } else {
                    $data['bank_name'] = null;
                    $data['branch'] = null;
                    $data['cheque_date'] = null;
                }
                
                $user_id = $this->session->userdata('session_id');
                $data['updated_by'] = $user_id;
                $id = $data['id'];
                $this->db->where('id', $id);
                $this->db->update('user_payment_details',$data);

                redirect(base_url().'index.php/Payment');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function list1(){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_view=='1' || $result[0]->r_insert=='1' || $result[0]->r_edit=='1' || $result[0]->r_delete=='1' || $result[0]->r_approvals=='1' || $result[0]->r_export=='1') {
                $data['access']=$result;

                $user_id = $this->session->userdata('session_id');

                $this->set_payment_details();

                $this->checkstatus('payments_done');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function convert_number_to_words($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => ' ', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
         $divider = ($i == 2) ? 10 : 100;
         $number = floor($no % $divider);
         $no = floor($no / $divider);
         $i += ($divider == 10) ? 1 : 2;
         if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
         } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? (" and " . $words[$point / 10] . " " .  $words[$point = $point % 10]) : '';

        if($points==""){
            $result = $result . "Rupees ";
        } else {
            $result = $result . "Rupees " . $points . " Paise";
        }
        return $result;
    }

    function format_money($number, $decimal=2){
        if(!isset($number)) $number=0;

        $negative=false;
        if(strpos($number, '-')!==false){
            $negative=true;
            $number = str_replace('-', '', $number);
        }

        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);

        $decimal="";
        
        if(strpos($number, '.')!==false){
            $decimal = substr($number, strpos($number, '.'));
            $number = substr($number, 0, strpos($number, '.'));
        }
        
        // echo $decimal . '<br/>';
        // echo $number . '<br/>';

        $len = strlen($number);
        $m = '';
        $number = strrev($number);
        for($i=0;$i<$len;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                $m .=',';
            }
            $m .=$number[$i];
        }

        $number = strrev($m);
        $number = $number . $decimal;

        if($negative==true){
            $number = '-' . $number;
        }

        return $number;
    }

    public function get_invoice($id){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_view=='1' || $result[0]->r_insert=='1' || $result[0]->r_edit=='1' || $result[0]->r_delete=='1' || $result[0]->r_approvals=='1' || $result[0]->r_export=='1') {
                $data['access']=$result;

                $user_id = $this->session->userdata('session_id');

                $sql = "select A.*, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country 
                        from user_payment_details A left join contact_master B on (A.user_id = B.c_id) where A.id = '$id'";
                $result = $this->db->query($sql)->result();

                if(count($result)>0){
                    $data['name'] = $result[0]->c_name . ' ' . $result[0]->c_last_name;
                    $data['address'] = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, '', $result[0]->c_country);
                    // $data['state'] = $result[0]->c_state;
                    $data['invoice_no'] = $result[0]->invoice_no;
                    $data['invoice_date'] = $result[0]->invoice_date;
                    $data['plan_name'] = $result[0]->plan_name;


                    // $value = floatval($result[0]->transaction_amount);
                    // $amount = $value/1.18;
                    // $discount = 0;
                    // $price = $amount - $discount;
                    // $cgst_rate = 9;
                    // $sgst_rate = 9;
                    // $igst_rate = 0;
                    // $cgst = $amount * $cgst_rate / 100;
                    // $sgst = $amount * $sgst_rate / 100;
                    // $igst = $amount * $igst_rate / 100;
                    // $gst = $cgst + $sgst + $igst;

                    // $data['value'] = $this->format_money($value,2);
                    // $data['amount'] = $this->format_money($amount,2);
                    // $data['discount'] = $this->format_money($discount,2);
                    // $data['price'] = $this->format_money($price,2);
                    // $data['cgst_rate'] = $cgst_rate;
                    // $data['sgst_rate'] = $sgst_rate;
                    // $data['igst_rate'] = $igst_rate;
                    // $data['cgst'] = $this->format_money($cgst,2);
                    // $data['sgst'] = $this->format_money($sgst,2);
                    // $data['igst'] = $this->format_money($igst,2);
                    // $data['gst'] = $this->format_money($gst,2);

                    $data['value'] = $this->format_money($result[0]->transaction_amount,2);
                    $data['amount'] = $this->format_money($result[0]->amount,2);
                    $data['discount'] = $this->format_money($result[0]->discount,2);
                    $data['price'] = $this->format_money($result[0]->price,2);
                    $data['cgst_rate'] = $result[0]->cgst_rate;
                    $data['sgst_rate'] = $result[0]->sgst_rate;
                    $data['igst_rate'] = $result[0]->igst_rate;
                    $data['cgst'] = $this->format_money($result[0]->cgst,2);
                    $data['sgst'] = $this->format_money($result[0]->sgst,2);
                    $data['igst'] = $this->format_money($result[0]->igst,2);
                    $data['gst'] = $this->format_money($result[0]->gst,2);
                    $data['total_amount'] = $this->format_money($result[0]->total_amount,2);
                    $data['round_off_amount'] = $this->format_money($result[0]->round_off_amount,2);

                    $data['total_amount_in_words']=$this->convert_number_to_words($result[0]->transaction_amount) . ' Only';

                    $data['data'] = $data;

                    load_view('payment/invoice', $data);
                } else {
                    echo '<script>alert("No data found.");</script>';
                    $this->load->view('login/main_page');
                }
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function payment_response($response_message, $order_status){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            if($result[0]->r_insert=='1' || $result[0]->r_edit=='1' || $result[0]->r_delete=='1' || $result[0]->r_approvals=='1') {
                $data['access']=$result;

                // $response_message = $request->get('response_message');
                // $order_status = $request->get('order_status');

                $this->set_payment_details();

                $data['order_status'] = $order_status;
                $data['response_message'] = $response_message;

                load_view('payment/payment_response', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($payment_status=''){
        $result=$this->payment_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->payment_model->getData($payment_status);

            $count_data=$this->payment_model->getData();
            $payments_done=0;
            $payments_pending=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->payment_status))=="PAID")
                        $payments_done=$payments_done+1;
                    else if (strtoupper(trim($count_data[$i]->payment_status))=="PENDING")
                        $payments_pending=$payments_pending+1;
                }
            }

            $data['payments_done']=$payments_done;
            $data['payments_pending']=$payments_pending;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $data['payment_status'] = $payment_status;

            load_view('payment/payment_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>