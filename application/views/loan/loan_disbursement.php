<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			
			.message-box .mb-container {
                position: absolute;
                left: 15px;
                top: 1%;
            	border-radius:10px;
                background: rgba(0, 0, 0, 0.9);
                padding: 20px;
                width: 98%;
            }
            .message-box .mb-container .mb-middle {
                width: 100%;
                left: 0%;
                position: relative;
                color: #FFF;
            }
            .addschedule td{
            	border:1px solid;
            	padding:0px !important;
            }
            .addschedule th{
            	border:1px solid;
            }
		</style>
		
    </head>
    <body onload="loadsubproperties();">								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
                            <form id="form_loan_disbursement" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($editloan)) { echo base_url().'index.php/loan_disbursement/updaterecord/'.$l_id;} else { echo base_url().'index.php/loan_disbursement/saverecord'; } ?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align: center; float: initial;"><strong>Loan Disbursement Details</strong></h3>
                                </div>
								
                                <div class="panel-body faq">
                                <div class="panel-body panel-group accordion">

                                <div class="panel  panel-primary"> 
                                    <a href="#accOneColOne">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Loan Details    </h4>
                                        </div>  
                                    </a>
                                    <div class="panel-body" id="accOneColOne">
                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label">Loan Ref Name</label>
                                                    <div class="col-md-7">
                                                        <!-- <input type="text" class="form-control" name="ref_name" placeholder="Loan Ref Name" value="<?php //if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" /> -->
                                                        <select  class="form-control" id="loan_ref_name" name="loan_id">
                                                            <option value=""> Select Loan </option>
                                                            <?php if(isset($loan_txn)) { if(isset($editloan[0]->loan_id)) { 
                                                                for($i=0; $i<count($loan_txn); $i++) { ?>
                                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>" <?php if($editloan[0]->loan_id == $loan_txn[$i]->txn_id) { echo 'selected';} ?> ><?php echo $loan_txn[$i]->loan_ref_name; ?></option>
                                                            <?php } } else { ?>
                                                                    <?php for($i=0; $i<count($loan_txn); $i++) { ?>
                                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>"><?php echo $loan_txn[$i]->ref_name; ?></option>
                                                            <?php } } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label">Loan Ref Id:</label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_ref_id" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_ref_id;} ?></label>
                                                        <!-- <input type="text" class="form-control" id="loan_ref_id" name="loan_ref_id" placeholder="Loan Ref Id" value="<?php //if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" /> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Loan Type: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_type" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_type;} ?></label>
                                                        <!-- <select class="form-control" id="loan_type" name="loan_type">
                                                            <option>Select</option>
                                                            <option value="LAP" <?php //if(isset($editloan)) { if($editloan[0]->loan_type=='LAP') { echo "selected";} } ?>> LAP </option>
                                                            <option value="Overdraft" <?php //if(isset($editloan)) { if($editloan[0]->loan_type=='Overdraft') { echo "selected";} }?>> Overdraft </option>
                                                            <option value="Normal" <?php //if(isset($editloan)) { if($editloan[0]->loan_type=='Normal') { echo "selected";} } ?>> Normal </option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Loan Amount: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_amount" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?></label>
                                                        <!-- <input type="text" class="form-control format_number" name="loan_amount" id="loan_amount" placeholder="Amount" value="<?php //if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>"/> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" style="padding-left: 0;" > Loan Start Date: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_start_date_text" style="text-align:left;"><?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?></label>
                                                        <input type="hidden" class="form-control datepicker" name="loan_start_date" id="loan_start_date" placeholder="Loan Start Date" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" style="padding-left: 0;" > Loan Due Day: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_due_day_text" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?></label>
                                                        <input type="hidden" class="form-control" name="loan_due_day" id="loan_due_day" placeholder="Loan Due Day" value="<?php //if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Term (In months): </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_term_text" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?></label>
                                                        <input type="hidden" class="form-control format_number" id="loan_term" placeholder="Term" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Interest Rate: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_interest_rate" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>%</label>
                                                        <!-- <input type="text" class="form-control format_number" name="interest_rate" placeholder="Interest Rate" value="<?php //if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>" style="width:80%; float:left;"/><label  style="padding:10px 5px;"  > % </label> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Interest Type: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="loan_interest_type" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_interest_type;} ?></label>
                                                        <!-- <select class="form-control" name="interest_type">
                                                            <option>Select</option>
                                                            <option value="Fixed" <?php //if(isset($editloan)) { if($editloan[0]->interest_type=='Fixed') { echo "selected";} } ?>> Fixed </option>
                                                            <option value="Float" <?php //if(isset($editloan)) { if($editloan[0]->interest_type=='Float') { echo "selected";} }?>> Float </option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Repayment: </label>
                                                    <div class="col-md-7">
                                                        <label class="col-md-12 control-label" id="repayment" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?></label>
                                                        <!-- <input type="text" class="form-control" name="repayment" placeholder="Repayment" value="<?php //if(isset($editloan)) { echo $editloan[0]->repayment;} ?>"/> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="">                                        
                                                    <label class="col-md-2 control-label"> Purpose: </label>
                                                    <div class="col-md-10">
                                                        <label class="col-md-12 control-label" id="purpose" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?></label>
                                                        <!-- <input type="text" class="form-control" name="purpose" placeholder="Purpose" value="<?php //if(isset($editloan)) { echo $editloan[0]->purpose;} ?>"/> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="panel  panel-primary"> 
                                    <a href="#accOneColTwo">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Loan Disbursement    </h4>
                                        </div>  
                                    </a>
                                    <div class="panel-body" id="accOneColTwo">
                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label"> Ref Id</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="ref_id" placeholder="Ref Id" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label"> Ref Name</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="ref_name" placeholder="Ref Name" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Disbursement Amount </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control format_number" name="disbursement_amount" id="disbursement_amount" placeholder="Disbursement Amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->disbursement_amount,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" style="padding-left: 0;" > Disbursement Date </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control datepicker" name="disbursement_date" id="disbursement_date" placeholder="Disbursement Date" value="<?php if(isset($editloan)) { if($editloan[0]->disbursement_date!=null && $editloan[0]->disbursement_date!='') echo date('d/m/Y',strtotime($editloan[0]->disbursement_date));} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> EMI </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control format_number" name="emi" id="emi" placeholder="EMI" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->emi,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Issuer Bank A/C </label>
                                                    <div class="col-md-7">
                                                        <input type="hidden" id="issuer_bank_acc_id" name="issuer_bank_id" class="form-control" value="<?php if (isset($editloan)) echo $editloan[0]->issuer_bank;?>" />
                                                        <input type="text" id="issuer_bank_acc" class="form-control auto_bank" name="issuer_bank_name" placeholder="Issuer Bank A/C" value="<?php if (isset($editloan)) echo $editloan[0]->issuer_bank_name;?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Receiver Bank A/C </label>
                                                    <div class="col-md-7">
                                                        <input type="hidden" id="receiver_bank_acc_id" name="receiver_bank_id" class="form-control" value="<?php if (isset($editloan)) echo $editloan[0]->receiver_bank;?>" />
                                                        <input type="text" id="receiver_bank_acc" class="form-control auto_bank" name="receiver_bank_name" placeholder="Receiver Bank A/C" value="<?php if (isset($editloan)) echo $editloan[0]->receiver_bank_name;?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label"> Payment Mode </label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" id="payment_mode" name="payment_mode">
                                                            <option value="">Select</option>
                                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cheque') echo 'selected';}?>>Cheque</option>
                                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cash') echo 'selected';}?>>Cash</option>
                                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT') echo 'selected';}?>>NEFT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="payment_id_details" style="<?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT' || $editloan[0]->payment_mode=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
                                                <div class="">
                                                    <label class="col-md-5 control-label" id="payment_id_type"><?php if(isset($editloan[0]->payment_mode)) {if($editloan[0]->payment_mode=='NEFT') echo 'Ref No'; else echo 'Cheque No';} else echo 'Cheque No';?></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control " id="cheq_no" name="cheq_no" value="<?php if (isset($editloan[0]->cheque_no)) echo $editloan[0]->cheque_no;?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel  panel-primary"> 
                                    <a href="#accOneColThree">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Loan Consideration    </h4>
                                        </div>  
                                    </a>  
                                    <div class="panel-body" id="accOneColThree" style="width:100%; ">
                                        <div id="temp_schedule_div"></div>
                                        <?php if(isset($p_schedule)) { ?>
                                        <div class="row">
                                        <div class="table-responsive" id="actual_schedule_div" style="overflow: visible;">
                                        <table id="contacts" class="table table-bordered" style="border-top:;">
                                            <thead>
                                                <tr>
                                                    <th width="9%"> Sr. No. </th>
                                                    <th width="23%"> Type  </th>
                                                    <th width="15%">Total Cost (In &#x20B9;) </th>
                                                    <?php if(isset($tax_name)){
                                                                $key=0;
                                                                foreach($tax_name as $row){
                                                                    echo '<th width="15%">'.$row->tax_type.'</th>';
                                                                    $tax_array[$key]=$row->tax_type;
                                                                    $key++;
                                                                }
                                                            }
                                                    ?>
                                                    <th width="18%"> Net Cost (In &#x20B9;) </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $j=0;
                                                    $total_basic_cost=0;
                                                    $total_net_amount=0;
                                                    $total_tax_array=array();
                                                    
                                                    foreach($p_schedule as $row_tax) {
                                                        echo '<tr>
                                                        <td>'.($j+1).'</td>
                                                        <td>'.$row_tax["event_type"].'</td>
                                                        <td style="text-align: right;">'.format_money($row_tax["basic_cost"],2).'</td>';
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
                                                                    echo '<td style="text-align: right;">'.format_money($tax_amount,2).'</td>';
                                                                    $td_count++;
                                                                }
                                                                else{
                                                                    //if($next_count )
                                                                    echo '<td style="text-align: right;">'.format_money($tax_amount,2).'</td>';
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

                                                        echo '<td style="text-align: right;">'.format_money($row_tax["net_amount"],2).'</td></tr>';
                                                        $total_net_amount=$total_net_amount+$row_tax["net_amount"];
                                                        //print_r($p_schedule[$j]['event_type']);
                                                        $j++;
                                                    }
                                                ?>

                                                <tr>
                                                    <td colspan="2"><b>Grand Total</b></td>
                                                    <td style="text-align: right;"><?php echo (isset($total_basic_cost))?format_money($total_basic_cost):0;?></td>
                                                    <?php  $k=0;
                                                        if (isset($total_tax_amount)) {
                                                            foreach($total_tax_amount as $row){
                                                                echo '<td style="text-align: right;">'.format_money($total_tax_amount[$k],2).'</td>';
                                                                $k++;
                                                            }
                                                        }
                                                    ?>
                                                   <td style="text-align: right;"><?php echo isset($total_net_amount)?format_money($total_net_amount,2):0;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        </div>
                                        <?php } ?>
                         
                                        <div class="">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <a href="<?php if(isset($editloan)) { if($editloan[0]->loan_type!='LAP') echo '#accOneColFive'; else echo '#accOneColFour'; } else echo '#accOneColFive'; ?>" id="next_panel"><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
                                                    <button type="button" class="btn btn-info mb-control" data-box="#message-box-info" onclick="opentable(); return false;">Schedule</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end info -->
                                        
                                        <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
                                            <div class="mb-container" style="background:#fff;">
                                                <div class="mb-middle">
                                                    <div class="mb-title" style="color:#000;text-align:center;">Schedule</div>
                                                    <div class="mb-content">
                                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                                            <label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
                                                            <input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" title="Browse file" onchange="saveTempBulkUpload()"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a>
                                                            <!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
                                                        </div>
                                                        <div class="table-stripped">
                                                            <table id="contacts" class="table group addschedule">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align: center;vertical-align: middle;">Sr. No.</th>
                                                                        <th style="text-align: center;vertical-align: middle;">Event Type</th>
                                                                        <th style="text-align: center;vertical-align: middle;">Event Name</th>
                                                                        <th style="text-align: center;vertical-align: middle;">Date &nbsp;&nbsp;(if applicable)</th>
                                                                        <th style="text-align: center;vertical-align: middle;">Basic Cost (In &#x20B9;)</th>                                                                      
                                                                        <th style="text-align: center;vertical-align: middle;">Tax Appilcable</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="schedule_table">
                                                                <?php $i=0; $schedule_id=1;
                                                                    if(isset($p_schedule1)){
                                                                    //print_r($p_schedule1);
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

                                                                    <tr><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle"><?php echo $i+1; ?></td>
                                                                    <input type="hidden"  name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>

                                                                    <td><input type="text"  name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
                                                                    <td><input type="text"  name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
                                                                    <td><input type="text"  name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none;"/></td>
                                                                    <td><input type="text"   name="sch_basiccost[]" value="<?php echo format_money($basic_cost,2);?>" class="form-control format_number" style="border:none; text-align: right;"/></td>
                                                                    <td><select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="form-control select" style="display: none;">
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
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-footer">
                                                        <button class="btn btn-success repeat-schedule" style="margin-left: 10px;">+</button>
                                                        <button class="btn btn-danger btn-lg pull-right mb-control-close" onclick="closetemp(); return false;">Close</button>
                                                        <button class="btn btn-success btn-lg pull-right" style="margin-right: 10px;" id="savebtn" onclick="savetemp(); return false;">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="rowdisplaycount" value="<?php echo $i;?>">
                                        <input type="hidden" id="schedule_id" value="<?php echo $schedule_id;?>">
                                    </div>
                                </div>


                                <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                    <a href="#accOneColfour"> 
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                        </div>
                                    </a>                                 
                                    <div class="panel-body" id="accOneColfour">
                                            <div class="form-group" style="background: none;border:none">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($editloan)){ echo $editloan[0]->maker_remark;}?></textarea>
                                                    <!-- <label style="margin-top: 5px;">Remark </label> -->
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                </div>
                                </div>
                                
                                <div class="panel-footer">
                                    <input type="hidden" id="submitVal" value="1" />
                                    <a href="<?php echo base_url(); ?>index.php/loan" class="btn btn-default" >Cancel</a>
                                    <input type="submit" class="btn btn-primary pull-right submit-form" name="submit" value="Submit For Approval" style="margin-right: 10px;" />
                                    <input type="submit" class="btn btn-primary pull-right save-form" name="submit" value="Save" style="margin-right: 10px;" />
                                </div>
                            </form>
                        </div>
						</div>
						
						<div class="col-md-1">&nbsp;</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

        <script type="text/javascript">
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

            function opentable(){
                document.getElementById('message-box-info').style.display = "block";
            }

            function calculatetaxes(arg){
                var bsid = arg.getAttribute('id');
                var tyu=bsid.charAt(2);
                
                for (var i = 0; i < tax.length; i++) {
                    tax[i]
                };
                var basic=document.getElementById()
            }

            function savetemp() {
                var formdata = {};
                var formdata={
                    sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
                    sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
                    sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
                    sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get()
                    //sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get()
                }

                var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
                //console.log(sch_type.length);
                var j=1;
                for(var i=0;i<sch_type.length;++i){
                    //console.log("step1");
                    formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
                    j++;
                }
                console.log(formdata);
                $.ajax({
                    url:"<?php echo base_url().'index.php/sale/insertTempSchedule';?>",
                    data:formdata,
                    dataType:"json",
                    type:"POST",
                    success:function(responsemydata){
                        if(responsemydata.status==1){
                            $("#temp_schedule_div").html(responsemydata.data);
                            $("#actual_schedule_div").hide();

                        }
                    },
                    error:function(responsemydata,status,error) {
                        var err=eval("("+responsemydata.responseText+")");
                        alert(err.Message);
                    
                        //alert(responsemydata.data);
                    },
                });
            
                //var bl=parseInt(document.getElementById('sch_bal').value);
                /*if(bl!=0) {
                    alert("Balance should be 0. Kindly check the same.")
                } else {*/
                    document.getElementById('message-box-info').style.display = "none";
                    //$("#actual_schedule_div").removeClass('show').addClass('hide');
                //}
            }

            function closetemp() {
                document.getElementById('message-box-info').style.display = "none";
            }

            function instchange(){
                flag=false;
            }


        </script>

        <script type="text/javascript">
            // function loadschedule(){
            //     var emi=0;
            //     if(document.getElementById('emi').value=='') {
            //         emi=0;
            //     } else {
            //         emi=parseInt(document.getElementById('emi').value);
            //     }

            //     var term=0;
            //     if(document.getElementById('term').value=='') {
            //         term=0;
            //     } else {
            //         term=parseInt(document.getElementById('term').value);
            //     }
                
            //     var amount=0;
            //     if(document.getElementById('amount').value=='') {
            //         amount=0;
            //     } else {
            //         amount=parseInt(document.getElementById('amount').value);
            //     }
                
            //     var outstand=amount;
            //     var rows='';
            //     for (var i = 0; i < term; i++) {
            //         outstand=outstand-emi;
            //         rows=rows+'<div class="form-group"><div class="col-md-4"><div class="form-group"><label class="col-md-3 control-label"> Date</label><div class="col-md-9"><input type="text" class="form-control datepicker" name="sch_date[]" placeholder="Select Date"></div></div></div><div class="col-md-4" style="padding: 0px;"><div class="form-group"><label class="col-md-4 control-label" style="padding-left: 0px;"> Amount</label><div class="col-md-8"><input type="text" class="form-control" name="sch_amount[]" id="emi_'+i+'" value="'+ emi + '" placeholder="Amount"/></div></div></div><div class="col-md-4" style="padding: 0px;"><div class="form-group"><label class="col-md-5 control-label">Outstanding Loan</label><div class="col-md-7"><input type="text" class="form-control" name="sch_outstanding[]" id="outstd_'+ i +'" value="'+ outstand + '" placeholder="Outstanding Loan"/></div></div></div></div>';
            //     };
            //     document.getElementById('pay_schedule').innerHTML=rows;
            // }

            // function calculateoutstanding(arg){

            // }

            function saveTempBulkUpload(){
                            // alert("hi");
                //          var file_data = $("#schedule_upload").prop("file")[0];   // Getting the properties of file from file field
                // var form_data = new FormData();                  // Creating object of FormData class
                // form_data.append("file", file_data)   ;           // Appending parameter named file with properties of file_field to form_data
                // form_data.append("user_id", 123)                 // Adding extra parameters to form_data
                //          $.ajax({
                //              url:"<?php echo base_url().'index.php/purchase/saveTempBulkUpload'?>",                  
                //              type:"post",
                //              contentType:false,
                //              cache:false,
                //              data:{file_data:file_data},
                //              dataType:"json",
                //              success:function(responsedata){
                //                  alert(responsedata);

                //              }

                //          })



                    var input = ($("#schedule_upload"))[0];
                    var upload_txn_type = 'loan';
                    file = input.files[0];
                    if(file != undefined){
                        formData= new FormData();            
                                formData.append("data_file", file);
                                formData.append("upload_txn_type",upload_txn_type);
                                $.ajax({
                                    url: "<?php echo base_url() . 'index.php/purchase/saveTempBulkUpload' ?>",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: "json",
                                    success: function(data){
                                        if(data.status==0){
                                            alert(data.errormsg);
                                        }
                                        else{
                                            var counter=data.rowcounter;
                                            var tst=data.rowcounter;
                                            $("#rowdisplaycount").val(parseInt(data.rowcounter)-1);
                                            $("#message-box-info").html(data.data);
                                            $('.select').selectpicker();
                                            $('.datepicker').datepicker();
                                            $('#schedule_upload').bootstrapFileInput();
                                            //$('.repeat-schedule').trigger('click');
                                            $('.repeat-schedule').click(function(event){
                                                event.preventDefault();
                                                //alert(window.cntrinst);
                                                scheduleRepeat(counter,tst);
                                            });
                                            $('.sch_basiccost').each(function(){
                                                format_number(this);
                                            });
                                            $('.format_number').keyup(function(){
                                                format_number(this);
                                            });
                                            $("form :input").change(function() {
                                                $(".save-form").prop("disabled",false);
                                            });
                                        }
                                         }
                                });
            //                
                    }else{
                        $("#file_photo_error").html('Input something!');
            //                alert('Input something!');
                    }
            }
        </script>

        <script type="text/javascript">
            function loadsubproperty(elem){
                // var property_id = elem.value;
                // var prop_elem_id = elem.id;
                var property_id = elem.val();
                var prop_elem_id = elem.attr('id');
                var index = prop_elem_id.substr(prop_elem_id.lastIndexOf('_')+1);
                var sub_prop_elem_id = "sub_property_" + index;
                var sub_prop_div_elem_id = "sub_property_div_" + index;
                var loan_prope_id_elem_id = "loan_property_id_" + index;
                var loan_property_id = document.getElementById(loan_prope_id_elem_id).value;

                loan_property_id = (loan_property_id==null || loan_property_id=="")?0:loan_property_id;

                if(property_id>0) {
                    index=parseInt(index)-1;
                    var xmlhttp=new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                            var data = xmlhttp.responseText;
                            document.getElementById(sub_prop_elem_id).innerHTML = data;

                            if(data==""){
                                document.getElementById(sub_prop_div_elem_id).style.display='none';
                            } else {
                                document.getElementById(sub_prop_div_elem_id).style.display='block';
                            }
                        }
                    };
                    xmlhttp.open("POST", "<?php echo base_url().'index.php/Loan/get_sub_property/'; ?>" + <?php if(isset($l_id)) echo $l_id; else echo '0';?>  + "/" + loan_property_id + "/" + property_id, true);
                    xmlhttp.send();
                } else {
                    document.getElementById(sub_prop_elem_id).innerHTML = "";
                }
            }

            function loadsubproperties(){
                $('select[name="property[]"]').each(function(index){
                    loadsubproperty($(this));
                });
            }
        </script>
        
		<script>
            jQuery(function(){
				var counter = <?php if(isset($editborower)) { echo count($editborower); } else { echo 1; } ?>;
				$('.repeat-owner').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group"> <div class="col-md-6"> <div class=""> <label class="col-md-5 control-label" style="padding-left: 0;" >' + ((counter==1)? "Name Of Applicant": "Name Of Co Applicant") + '</label> <div class="col-md-7"> <input type="hidden" id="borrower_' + counter + '_id" name="borrower[]" class="form-control" /> <input type="text" id="borrower_' + counter + '" name="borrower_name[]" class="form-control auto_owner" placeholder="Type to choose owner from database..." /> </div> </div> </div> </div>');
					$('.auto_owner', newRow).autocomplete(autocomp_opt);
                    $('.repeatowner').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
				});
			});

			jQuery(function(){
				var counter = 1;
				$('.repeat-PaymentSchedule').click(function(event){
					event.preventDefault();
					counter++;
                var newRow = jQuery('<div class="form-group"><div class="col-md-4"><div class=""><label class="col-md-5 control-label"> Date</label><div class="col-md-7"><input type="text" class="form-control datepicker" name="sch_date[]" placeholder="Select Date"></div></div></div><div class="col-md-4" 7><div class=""><label class="col-md-5 control-label" > Amount</label><div class="col-md-7"><input type="text" class="form-control" name="sch_amount[]" placeholder="Amount"/></div></div></div><div class="col-md-4" ><div class=""><label class="col-md-5 control-label" style="padding-left:0; padding-right:0;">Outstanding Loan</label><div class="col-md-7"><input type="text" class="form-control" name="sch_outstanding[]" placeholder="Outstanding Loan"/></div></div></div></div>');
					$('.PaymentSchedule').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
				});
			});
			
			jQuery(function(){
				var counter = 1;
				$('.repeat-img').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group"><div class="col-md-4"> <div class="form-group" style="margin-left: 28px;"> <label class="col-md-4 control-label">Upload Image</label> <div class="col-md-8"> <a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" title="Browse file" style="left: -157.313px; top: -3px;"></a> </div> </div> </div> <div class="col-md-4"> <div class="form-group"> <label class="col-md-4 control-label">Captured Date</label> <div class="col-md-8"> <input type="text" class="form-control" name="nominee2" placeholder="Captured Date"/> </div> </div> </div> <div class="col-md-4"> <div class="form-group"> <label class="col-md-3 control-label">Description</label> <div class="col-md-9"> <input type="text" class="form-control" name="nominee2" placeholder="Description"/> </div> </div> </div></div>');
					$('.repeatimg').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
				});
			});
			
			jQuery(function(){
				
				$('.sch').click(function(event){
					event.preventDefault();
					alert('hi');
				});
			});
			
			// jQuery(function(){
   //              var counter = $('input.doc_file').length;
   //              // var counter = <?php if(isset($editdocs)) { echo count($editdocs); } else { ?>$(".doc_file").length<?php } ?>;
   //              $('.repeat-doc').click(function(event){
   //                  event.preventDefault();
   //                  var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="doc_name[]" placeholder="Document Name" value="" /></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description"  value="" /></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div></div></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '" data-error="#doc_'+counter+'_error" /></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');
   //                  $('.adddoc').append(newRow);
   //                  $('.datepicker').datepicker();
   //                  $('.delete_row').click(function(event){
   //                      delete_row($(this));
   //                  });
   //                  $("form :input").change(function() {
   //                      $(".save-form").prop("disabled",false);
   //                  });
   //                  counter++;
                    
   //              });
   //          });
            
            jQuery(function(){

            $('.repeat-schedule').click(function(event){
                    event.preventDefault();
                    scheduleRepeat();
                });
            });

            function scheduleRepeat(){
                var counter = $("#rowdisplaycount").val();
                //alert(counter);
                counter++;
                var rows='';
                //collen=tax.length;
                //alert(collen);
                // if(counter%2==0)
                // {
                //  var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
                //  $('.addschedule').append(newRow);
                // }
                // else
                // {
                //  var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
                // }
                rows=rows+ "<tr> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ counter +"</td> <td><input type='text'  name='sch_type[]' class='form-control' value='' style='border:none;'/></td><td><input type='text'  name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text'  name='sch_date[]' value=''  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' name='sch_basiccost[]' value='' class='form-control format_number' style='border:none; text-align:right;'/></td><td><select class='form-control select' multiple name='sch_tax_"+counter+"[]'>";
                    <?php 
                    if(isset($tax)){
                        foreach($tax as $row){ ?>
                            //alert("step"+i);
                        rows=rows+"<option value='<?php echo $row->tax_id;?>'><?php echo $row->tax_name."-".$row->tax_percent ; ?></option>";
                        <?php } } ?>                    
                     rows=rows+ "</select></td></tr>";
                     // counter++;
                $('.addschedule').append(rows); $("#rowdisplaycount").val(counter);
                $('.datepicker').datepicker();
                $('.select').selectpicker();
                $('.format_number').keyup(function(){
                    format_number(this);
                });
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            }
            
			// jQuery(function(){
			// var counter = 1;
			// $('.repeat-schedule').click(function(event){
			// 		event.preventDefault();
			// 		counter++;
			// 		if(counter%2==0)
			// 		{
			// 			var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
			// 			$('.addschedule').append(newRow);
			// 		}
			// 		else
			// 		{
			// 			var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
			// 			$('.addschedule').append(newRow);
			// 		}
			// 	});
			// });
			
			$(document).ready(function(){
				$('#loan_type').change(function(){
					if(this.value=="LAP") {
						$('#security').show();
                        $('#next_panel').attr("href", "#accOneColFour");
					} else {
						$('#security').hide();
                        $('#next_panel').attr("href", "#accOneColFive");
					}
				});
			});
		</script>

        <script>
            $( "#loan_ref_name" ).change(function() {
                var loan_txn_id = $("#loan_ref_name").val();
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/loan_disbursement/get_loan_details/' ?>" + loan_txn_id,
                    data: $("#form_loan_disbursement").serialize(),
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(data!=null) {
                            <?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>
                            $("#loan_ref_id").html(data.loan_ref_id);
                            $("#loan_type").html(data.loan_type);
                            $("#loan_amount").html(data.loan_amount);
                            $("#loan_start_date_text").html(data.loan_startdate);
                            $("#loan_due_day_text").html(data.loan_due_day);
                            $("#loan_term_text").html(data.loan_term);
                            $("#loan_start_date").val(data.loan_startdate);
                            $("#loan_due_day").val(data.loan_due_day);
                            $("#loan_term").val(data.loan_term);
                            $("#loan_interest_rate").html(data.loan_interest_rate + '%');
                            $("#loan_interest_type").html(data.loan_interest_type);
                            $("#repayment").html(data.repayment);
                            $("#purpose").html(data.purpose);
                        } else {
                            $("#loan_ref_id").html('');
                            $("#loan_ref_name").html('');
                            $("#loan_type").html('');
                            $("#loan_amount").html('');
                            $("#loan_start_date_text").html('');
                            $("#loan_due_day_text").html('');
                            $("#loan_term_text").html('');
                            $("#loan_start_date").val('');
                            $("#loan_due_day").val('');
                            $("#loan_term").val('');
                            $("#loan_interest_rate").html('');
                            $("#loan_interest_type").html('');
                            $("#repayment").html('');
                            $("#purpose").html('');
                        }
                    },
                    error: function (xhr, status, error) {
                            //alert(xhr.responseText);
                    }
                });
            });

            $( "#payment_mode" ).change(function() {
                checkMode();
            });

            function checkMode(){
                if($( "#payment_mode" ).val()=="Cheque"){
                    $("#payment_id_details").show();
                    $("#payment_id_type").html("Cheque No");
                    $("#cheq_no").val("");
                } else if($( "#payment_mode" ).val()=="NEFT"){
                    $("#payment_id_details").show();
                    $("#payment_id_type").html("Ref No");
                    $("#cheq_no").val("");
                } else {
                    $("#payment_id_details").hide();
                }
            }

            function getdocuments() {
                <?php if(isset($p_txn)) {  } else {  ?>
                    var counter = 0;
                    var propid = document.getElementById("property").value;
                    $('#adddoc').empty();

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php/Rent/loaddocuments/' ?>" + propid,
                        data: $("#form_rent").serialize(),
                        cache: false,
                        type: "POST",
                        dataType: 'json',
                        global: false,
                        async: false,
                        success: function (data) {
                            // if(data!=null) {
                            //      //alert(data);
                            //     $.each(data, function(key,value) {
                            //         // alert(value.d_documentname + ' ' + value.d_description);
                            //         var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="doc_name[]" placeholder="Document Name" value="'+ value.d_documentname +'" /></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description"  value="'+ value.d_description +'" /></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div></div></div><div class="col-md-2"><div class=""><div class="col-md-12"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div></div></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '" data-error="#doc_'+counter+'_error"/></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');
                            //         $('.adddoc').append(newRow);
                            //         $('.datepicker').datepicker();
                            //         $('.delete_row').click(function(event){
                            //             delete_row($(this));
                            //         });
                            //         $("form :input").change(function() {
                            //             $(".save-form").prop("disabled",false);
                            //         });
                            //         counter = counter+1;
                            //     });
                            // }

                            if(data.status==1){
                                $('#adddoc').html("");
                                $('#adddoc').html(data.data);
                                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                                $('.datepicker').datepicker();
                                $('.delete_row').click(function(event){
                                    delete_row($(this));
                                });
                                $("form :input").change(function() {
                                    $(".save-form").prop("disabled",false);
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                                //alert(xhr.responseText);
                        }
                    });
                <?php } ?>
            }
        </script>

        <script>
            jQuery(function(){
                var counter = <?php if(isset($pending_activity)) { echo count($pending_activity); } else { echo '1'; } ?>;
                $('.repeat-pending_activity').click(function(event){
                    event.preventDefault();
                    counter++;
                    var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" style="border-top: 1px dotted #ddd;"><div class="col-md-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div><div class="col-md-11"><input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
                    $('#pending_activity').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
                });
                $('.reverse-pending_activity').click(function(event){
                    var id="#pending_activity_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                });
            });
        </script>
    <!-- END SCRIPTS -->
    </body>
</html>