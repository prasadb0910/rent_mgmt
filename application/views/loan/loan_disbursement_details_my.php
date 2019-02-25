<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .a {
            border-bottom: 2px solid #edf0f5;
            margin-bottom: 25px;
            padding-bottom: 25px;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("assets/img/demo/preview.jpg") ;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
        #image-label {
            color:white;
            padding-left:6px;
        }
        #image-label_field{
            background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
        }
        #image-label_field:hover{
            background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add{
            color:#41a541;
            cursor:pointer;
            font-size:14px;
            font-weight:500;
        }
        .remove{
            color:#d63b3b;
            text-align:right;
            cursor:pointer;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1{
            padding: 5px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .delete{
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:pointer;
            margin-top: 15px;
            font-size:20px;
            font-weight:500;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            font-weight:400;
        }
        .blue-btn:hover,
        .blue-btn:active,
        .blue-btn:focus,
        .blue-btn {
            background: transparent;
            border: dotted 1px #27a9e0;
            border-radius: 3px;
            color: #27a9e0;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none !important;
            padding: 10px 20px;
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
            height: 43px;
            margin-top: 0;
        }
        .fileUpload input.uploadlogo {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 42px;
        }
        input::-webkit-file-upload-button {
            cursor: pointer !important;
            height: 42px;
            width: 100%;
        }
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
        }
        .addschedule td{
            border:1px solid;
            padding:0px !important;
        }
        .addschedule th{
            border:1px solid;
        }
        .addtax td{
            border:1px solid;
            /*padding:0px !important;*/
        }
        .addtax th{
            border:1px solid;
        }
        .modal-content{
            width: 1000px;
        }
        #schedule_table td{
            background:#ffffff;
        }
        .modal-footer{
            display: block;
        }
        /*.select2-container {
            z-index:9999!important;
        }*/
        /*.modal.fade {
            z-index:9999!important;
        }*/
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_loan_disbursement" role="form" method ="post" action="<?php if(isset($editloan)) { echo base_url().'index.php/loan_disbursement/updaterecord/'.$l_id;} else { echo base_url().'index.php/loan_disbursement/saverecord'; } ?>" enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Loan_disbursement/checkstatus/All">Loan Disbursement List</a></li>
            <li class="breadcrumb-item"><a href="<?php if (isset($l_id)) echo base_url().'index.php/Loan_disbursement/view/'.$l_id; ?>">Loan Disbursement View</a></li>
            <li class="breadcrumb-item active">Loan Disbursement Details</li>
            <input type="hidden" id="l_id" name="l_id" value="<?php if(isset($editloan)) echo $l_id; ?>" />
        </ol>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-12">
                    <div class="card card-default" style="background:#e6ebf1">
                        <div class="card-header " style="background:#f6f9fc">
                            <div class="card-title">
                                Drag n' drop uploader
                            </div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span>
                        </div>
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($editloan)) echo base_url().$editloan[0]->image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        <div id="image-label_field">
                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class=" container-fluid container-fixed-lg bg-white">
                    <div class="card card-transparent">
                        <div class="a" id="loan_details">
                            <p class="m-t-20"><b>Loan Details</b></p>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Loan Ref Id </label>
                                        <select  class="form-control full-width" id="loan_ref_name" name="loan_id" data-placeholder="Select Loan Ref Id" data-init-plugin="select2">
                                            <option value=""> Select Loan </option>
                                            <?php if(isset($loan_txn)) { if(isset($editloan[0]->loan_id)) { 
                                                for($i=0; $i<count($loan_txn); $i++) { ?>
                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>" <?php if($editloan[0]->loan_id == $loan_txn[$i]->txn_id) { echo 'selected';} ?> ><?php echo $loan_txn[$i]->ref_id; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($loan_txn); $i++) { ?>
                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>"><?php echo $loan_txn[$i]->ref_id; ?></option>
                                            <?php } } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Loan Ref Name </label>
                                        <input type="text" class="form-control " id="loan_ref_id" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_ref_id;} ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Loan Type</label>
                                        <input type="text" class="form-control " id="loan_type" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_type;} ?>" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Amount</label>
                                        <input type="text" class="form-control " id="loan_amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default  ">
                                        <label>Loan Start Date</label>
                                        <input id="start_date" type="text" class="form-control " name="loan_start_date" id="loan_start_date" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Loan Due Day</label>
                                        <input type="text" class="form-control" name="loan_due_day" id="loan_due_day" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?>" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Term (In months) </label>
                                        <input type="text" class="form-control " id="loan_term" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Interest Type</label>
                                        <input type="text" class="form-control " id="loan_interest_type" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_interest_type;} ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Interest Rate (In %) </label>
                                        <input type="text" class="form-control " id="loan_interest_rate" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Financial Institution</label>
                                        <input type="text" class="form-control " id="financial_institution" value="<?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?>"  readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Repayment </label>
                                        <input type="text" class="form-control " id="repayment" value="<?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Purpose </label>
                                        <input type="text" class="form-control " id="purpose" value="<?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?>" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="a">
                            <p class=""><b>Loan Disbursement<b></p>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label> Ref Id </label>
                                        <input type="text" class="form-control" name="ref_id" placeholder="Ref Id" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label> Ref Name</label>
                                        <input type="text" class="form-control" name="ref_name" placeholder="Ref Name" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Disbursement Amount </label>
                                        <input type="text" class="form-control format_number" name="disbursement_amount" id="disbursement_amount" placeholder="Disbursement Amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->disbursement_amount,2);} ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required ">
                                        <label>Disbursement Date</label>
                                        <input type="text" class="form-control datepicker" name="disbursement_date" id="disbursement_date" placeholder="Disbursement Date" value="<?php if(isset($editloan)) { if($editloan[0]->disbursement_date!=null && $editloan[0]->disbursement_date!='') echo date('d/m/Y',strtotime($editloan[0]->disbursement_date));} ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>EMI </label>
                                        <input type="text" class="form-control format_number" name="emi" id="emi" placeholder="EMI" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->emi,2);} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Issuer Bank A/C  </label>
                                        <select class="form-control full-width" id="issuer_bank_acc" name="issuer_bank_id" data-placeholder="Select Issuer Bank A/C" data-init-plugin="select2">
                                            <option value=""> Select Issuer Bank A/C </option>
                                            <?php if(isset($bank)) { if(isset($editloan[0]->issuer_bank)) { 
                                                for($i=0; $i<count($bank); $i++) { ?>
                                                    <option value="<?php echo $bank[$i]->b_id; ?>" <?php if($editloan[0]->issuer_bank == $bank[$i]->b_id) { echo 'selected';} ?> ><?php echo $bank[$i]->b_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($bank); $i++) { ?>
                                                    <option value="<?php echo $bank[$i]->b_id; ?>"><?php echo $bank[$i]->b_name; ?></option>
                                            <?php } } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Receiver Bank A/C</label>
                                        <select class="form-control full-width" id="receiver_bank_acc" name="receiver_bank_id" data-placeholder="Select Receiver Bank A/C" data-init-plugin="select2">
                                            <option value=""> Select Receiver Bank A/C </option>
                                            <?php if(isset($bank)) { if(isset($editloan[0]->receiver_bank)) { 
                                                for($i=0; $i<count($bank); $i++) { ?>
                                                    <option value="<?php echo $bank[$i]->b_id; ?>" <?php if($editloan[0]->receiver_bank == $bank[$i]->b_id) { echo 'selected';} ?> ><?php echo $bank[$i]->b_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($bank); $i++) { ?>
                                                    <option value="<?php echo $bank[$i]->b_id; ?>"><?php echo $bank[$i]->b_name; ?></option>
                                            <?php } } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Payment Mode </label>
                                        <select class="form-control full-width" id="payment_mode" name="payment_mode" data-placeholder="Select Payment Mode" data-init-plugin="select2">
                                            <option value="">Select</option>
                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cheque') echo 'selected';}?>>Cheque</option>
                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cash') echo 'selected';}?>>Cash</option>
                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT') echo 'selected';}?>>NEFT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="payment_id_details" style="<?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT' || $editloan[0]->payment_mode=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
                                    <div class="form-group form-group-default required">
                                        <label id="payment_id_type"><?php if(isset($editloan[0]->payment_mode)) {if($editloan[0]->payment_mode=='NEFT') echo 'Ref No'; else echo 'Cheque No';} else echo 'Cheque No';?></label>
                                        <input type="text" class="form-control" id="cheq_no" name="cheq_no" value="<?php if (isset($editloan[0]->cheque_no)) echo $editloan[0]->cheque_no;?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="a">
                            <p class="m-t-20"><b> Loan Consideration<b></p>
                            <div id="temp_schedule_div"></div>
                            <?php if(isset($p_schedule)) { ?>
                            <div class="row clearfix" id="actual_schedule_div">
                                <div class="col-md-12">
                                    <table class="view_table addsummary">
                                        <thead>
                                            <tr>
                                                <th width="55">Sr. No.</th>
                                                <th width="120">Type</th>
                                                <th width="120">Total Cost (In &#x20B9;)</th>

                                                <?php //print_r($tax_name);
                                                    if(isset($tax_name)){
                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
                                                        $key=0;
                                                        foreach($tax_name as $row){
                                                            echo '<th style="text-align: center;vertical-align: middle;">'.$row->tax_type.' (In &#x20B9;)</th>';
                                                            $tax_array[$key]=$row->tax_type;
                                                            $key++;
                                                        } 
                                                       //echo '</tr></table></th>';
                                                      // print_r($tax_array);
                                                    }
                                                ?>

                                                <th width="120">Net Cost (In &#x20B9;)</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php //print_r($p_schedule);?>
                                            <?php 
                                                $j=0;
                                                $total_basic_cost=0;
                                                $total_net_amount=0;
                                                $total_tax_array=array();
                                                foreach($p_schedule as $row_tax) {
                                                    echo '<tr>
                                                    <td >'.($j+1).'</td>
                                                    <td>'.$row_tax["event_type"].'</td>
                                                    <td >'.format_money($row_tax["basic_cost"],2).'</td>';
                                                    $total_basic_cost=$total_basic_cost+$row_tax["basic_cost"];
                                                    $next_count=0;
                                                    $td_count=0;
                                                    // print_r($p_schedule);
                                                    if(isset($row_tax['tax_type'])) {
                                                        // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                        //echo "<br>hi";
                                                        // echo $key;
                                                        for($tcnt=0;$tcnt<$key;$tcnt++){
                                                            //echo "step1--";
                                                            for($nc=0;$nc<count($row_tax['tax_type']);$nc++){
                                                                $tax_amount='';
                                                                if($row_tax['tax_type'][$nc]==$tax_array[$tcnt]){
                                                                    $tax_amount=$row_tax['tax_amount'][$nc];
                                                                    $nc=count($row_tax['tax_type']);
                                                                    //$tcnt=$key;
                                                                    //}
                                                                }
                                                            }
                                                            if($tax_amount !=''){
                                                                echo '<td >'.format_money($tax_amount,2).'</td>';
                                                                $td_count++;
                                                            }
                                                            else{
                                                                //if($next_count )
                                                                echo '<td >'.format_money($tax_amount,2).'</td>';
                                                                $td_count++;
                                                            }
                                                            // $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
                                                            //  $total_tax_array[$tcnt]= $tax_amount;
                                                            // print_r($total_tax_array);
                                                        }
                                                    }
                                                    $inserttd=$key-$td_count;
                                                    if($inserttd !=0){
                                                        for($tdint=0;$tdint<$inserttd;$tdint++){
                                                            echo "<td></td>";
                                                        }
                                                    }

                                                    echo '<td >'.format_money($row_tax["net_amount"],2).'</td></tr>';
                                                    $total_net_amount=$total_net_amount+$row_tax["net_amount"];
                                                    //print_r($p_schedule[$j]['event_type']);
                                                    $j++;
                                                }
                                             ?>

                                            <tr>
                                                <td colspan="2" style="text-align:left;"><b>Grand Total  (In &#x20B9;) </b></td>
                                                <td style="text-align:right;"><?php echo format_money($total_basic_cost,2);?></td>
                                                <?php  $k=0;if(isset($total_tax_amount)) {
                                                foreach($total_tax_amount as $row){
                                                    echo '<td style="text-align:right;">'.format_money($total_tax_amount[$k],2).'</td>';
                                                    $k++;
                                                } } ?>
                                               <td style="text-align:right;"><?php echo format_money($total_net_amount,2); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                            <br>

                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="opentable(); return false;">Schedule</button>

                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Schedule</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row clearfix" >
                                            <label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
                                            <div class="fileUpload blue-btn btn width100">
                                                <span><i class="fa fa-cloud-upload"></i> Upload Schedule</span>
                                                <input type="file" class="uploadlogo" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()" />
                                            </div>
                                            <label class="control-label" style="color:#000;"><a href="<?php echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a></label>
                                            <!-- <input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()"/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="<?php //echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a> -->
                                            <!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-12" id="import_schedule">
                                                <table class="view_table addschedule">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;" width="60">Sr. No.</th>
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Type</th>
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Event</th>
                                                            <!-- <th style="text-align: center;vertical-align: middle;">Payment Type</th>
                                                            <th style="text-align: center;vertical-align: middle;">Agreement Value</th> -->
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Date</th>

                                                            <th style="text-align: center;vertical-align: middle;" width="130">Cost (In &#x20B9;)</th>
                                                            <?php for ($i=0; $i < count($tax) ; $i++) { 
                                                                //echo '<th style="text-align: center;vertical-align: middle;">'.$tax[$i]->tax_name.'</th>';
                                                            }
                                                            ?>
                                                            <th style="text-align: center;vertical-align: middle;" width="70">Tax(%)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="schedule_table">
                                                        <?php 
                                                            $i=0; $schedule_id=1;
                                                            if(isset($p_schedule)){
                                        
                                                            foreach($p_schedule1 as $row){
                                                            $sch_id=$p_schedule1[$i]['schedule_id'];
                                                            $event_type=$p_schedule1[$i]['event_type'];
                                                            $event_name=$p_schedule1[$i]['event_name'];
                                                            $basic_cost=$p_schedule1[$i]['basic_cost'];
                                                            $event_date=date('d/m/Y',strtotime($p_schedule1[$i]['event_date']));
                                                            $tax_master=array();
                                                            $j=0;
                                                            if(isset($p_schedule1[$i]['tax_type'])){
                                                                for($j=0;$j<count($p_schedule1[$i]['tax_type']);$j++ ){
                                                                    //$p_schedule1[$i]['tax_master'][$j];
                                                                    $tax_master[]=$p_schedule1[$i]['tax_master_id'][$j];
                                                                }
                                                            }
                                                        ?>

                                                        <tr id="repeat_schedule_<?php echo $i+1; ?>">
                                                            <td style="color:#000;background:#F9F9F9; text-align:center; "   ><?php echo $i+1; ?></td>
                                                            <input type="hidden"  name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>

                                                            <td><input type="text"  name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
                                                            <td><input type="text"  name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
                                                            <td><input type="text"  name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none;"/></td>
                                                            <td><input type="text"   name="sch_basiccost[]" value="<?php echo format_money($basic_cost,2);?>" class="form-control format_number" style="border:none; "/></td>
                                                            <td><select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="select" style="display: none;">
                                                                <?php $schedule_id++;
                                                                    if(isset($tax)){
                                                                        //print_r($tax_id);
                                                                        foreach($tax as $row){
                                                                            if(in_array($row->tax_id, $tax_master)){
                                                                                //echo "hi";
                                                                                $selected="selected='selected'";
                                                                            }
                                                                            else{
                                                                                $selected='';
                                                                            }
                                                                            echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                        }
                                                                    };?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; }} ?>
                                                    </tbody>
                                                    <!-- <tbody id="schedule_box" >
                                                        <tr class="block" id="schedule_block">
                                                            <td class="add" id="add_schedule">+ Add</td>
                                                        </tr>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                                        <button type="button" class="btn btn-default-danger" data-dismiss="modal">Close</button> -->

                                        <button class="btn btn-success repeat-schedule" id="schedule_btn" style=" ">+</button>
                                        <button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
                                        <button class="btn btn-default-danger pull-right mb-control-close" data-dismiss="modal" onclick="closetemp(); return false;">Close</button>
                                        <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="rowdisplaycount" value="<?php echo $i;?>">
                            <input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id;?>">
                        </div>
                    </div>

                    <p class="div_heading">Remark</p>
                    <br>
                    <div class="a">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Remark</label>
                                    <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($editloan)){ echo $editloan[0]->maker_remark;}?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer" style="padding-bottom: 60px;">
                        <input type="hidden" id="submitVal" value="1" />
                        <a href="<?php echo base_url(); ?>index.php/loan_disbursement" class="btn btn-default-danger pull-left" >Cancel</a>
                        <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($editloan)) echo 'display:none'; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php $this->load->view('templates/footer');?>
</div>
</div>

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';

    <?php
        $property_details = '<option value="">Select</option>';
        if(isset($property)) {
            for($i=0; $i<count($property); $i++) {
                $property_details = $property_details . '<option value="'.$property[$i]->txn_id.'">'.str_replace("'","",$property[$i]->p_property_name).'</option>';
            }
        }
    ?>
    var property_details = '<?php echo $property_details; ?>';

    var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
    var tax = new Array();
    var taxname=new Array();
    var taxpurpose=new Array();
    window.cntrinst=0;

    <?php for ($i=0; $i < count($tax) ; $i++) { ?>
        tax.push('<?php echo $tax[$i]->tax_percent; ?>');
        taxname.push('<?php echo $tax[$i]->tax_name; ?>');
        taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
    <?php } ?>

    <?php 
        $tax_list_details = '<option value="">Select</option>';
        if(isset($tax_details)){
            foreach($tax_details as $row){
                $tax_list_details = $tax_list_details . '<option value="'.$row->tax_id.'">'.str_replace("'","",$row->tax_name).'-'.$row->tax_percent.'</option>';
            }
        }
    ?>
    var tax_list_details = '<?php echo $tax_list_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/loan.js"></script>

</body>
</html>