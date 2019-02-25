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
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
        <!-- EOF CSS INCLUDE -->
					<style type="text/css">
     .address-remark{width: 17.5%;}
.address-container1{width:82.5%; display:flex;}       
 
.purpose-view { width:20.3%;}
.purpose-details { width:79.7%;}

  
 @media screen and (max-width: 780px) 
	{
.custom-padding .col-md-6 {
    padding:0px!important;
} 
.form-horizontal .control-label { padding:0 3px!important; }
 
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}

}

@media screen and (min-width: 781px) and (max-width:991px){ 

.custom-padding .control-label { padding:0 2px!important; }
.custom-padding .col-md-2 { padding:0 10px!important;}
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}
 
}
        </style>	
    </head>
    <body >
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        				<!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
				  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/loan_disbursement'; ?>" > Loan Disbursement List</a>  &nbsp; &#10095; &nbsp;    Loan Disbursement View</div>
                  <div class="pull-right btn-top-margin responsive-margin">				 
						<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>  
						 <a  class="btn-margin"  href="<?php echo base_url().'index.php/loan_disbursement/edit/'.$l_id; ?>"> <span class="btn btn-success pull-right btn-font"> Edit </span> </a> 
						<?php } }  ?>
					<a class="btn-margin"  href="<?php echo base_url()?>index.php/loan_disbursement"> <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                  </div>
                <!-- END X-NAVIGATION VERTICAL -->
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
				    <div class="row main-wrapper">
					  <div class="main-container">           
					      <div class="box-shadow">   
					         <div class="box-shadow-inside">	
					           <div class="col-md-12" style="padding:0;">	
					               <div class="full-width custom-padding" >
						              <div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
							
							
							
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Loan Details</strong></h3>                                 
                                     
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label">Loan Ref Id :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_ref_id;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label">Loan Ref Name :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_ref_name;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Loan Type : </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_type;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">                                        
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label"> Amount (In &#x20B9;) :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" style="padding-left: 0;" > Loan Start Date : </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" style="padding-left: 0;" > Loan Due Day  :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">                                        
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label"> Term (In months):</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_term;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Interest Rate :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_interest_rate;} ?> % </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Interest Type : </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_interest_type;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Financial Institution :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Repayment :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Purpose : </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Loan Disbursement Details</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label">Ref Id :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label">Ref Name :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">                                        
                                                <label class="col-md-6 col-sm-5 col-xs-12 control-label"  > Disbursement Amount (In &#x20B9;) :</label>
                                                <div class="col-md-6 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->disbursement_amount,2);} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" style="padding-left: 0;" > Disbursement Date : </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { if($editloan[0]->disbursement_date!=null && $editloan[0]->disbursement_date!='') echo date('d/m/Y',strtotime($editloan[0]->disbursement_date));} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" style="padding-left: 0;" > EMI :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->emi;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-6 col-sm-5 col-xs-12 control-label" style="padding-left: 0;" > Issuer Bank A/C :</label>
                                                <div class="col-md-6 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->issuer_bank_name;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">                                        
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label"> Receiver Bank A/C :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->receiver_bank_name;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" >
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > Payment Mode :</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->payment_mode;} ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12" id="payment_id_details" style="<?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT' || $editloan[0]->payment_mode=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
                                            <div class="">
                                                <label class="col-md-5  col-sm-5 col-xs-12 control-label" > <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT') echo 'Ref No:'; else echo 'Cheque No:';} else echo 'Cheque No:';?> </label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->cheque_no;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Loan Consideration</strong></h3>                                    
                                </div>
                                <div class="panel-body">
                                  <div class="row">
										              <div class="table-responsive">
										                <table id="contacts" class="table table-bordered" style="border-top:;">
                                      <thead>
											                  <tr>
                                          <th width="5%"> Sr. No. </th>
                                          <th  > Type  </th>                                                   
                                          <th width="15%">Cost (In &#x20B9;)</th>
                                          <?php
                                            if(isset($tax_name)){
                                              $key=0;
                                              foreach($tax_name as $row){
                                                echo '<th width="15%">'.$row->tax_type.'</th>';
                                                $tax_array[$key]=$row->tax_type;
                                                $key++;
                                              }
                                            }
                                          ?>
                                          <th width="15%"> Net Cost (In &#x20B9;)</th>
                                        </tr>
										                  </thead>
										                  <tbody>
                                        <?php 
                                          $j=0;
                                          $total_basic_cost=0;
                                          $total_net_amount=0;
                                          $total_tax_array=array();
                                          foreach($p_schedule as $row_tax){
                                              echo '<tr>
                                                    <td>'.($j+1).'</td>
                                                    <td>'.$p_schedule[$j]["event_type"].'</td>
                                                    <td >'.format_money($p_schedule[$j]["basic_cost"],2).'</td>';
                                                    $total_basic_cost=$total_basic_cost+$p_schedule[$j]["basic_cost"];
                                                    $next_count=0;
                                                    $td_count=0;
														                  if(isset($p_schedule[$j]['tax_type'])) {
                                                  for($tcnt=0;$tcnt<$key;$tcnt++){
                                                      for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++){
                                                          $tax_amount='';
                                                          if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt]){
                                                              $tax_amount=$p_schedule[$j]['tax_amount'][$nc];
                                                              $nc=count($p_schedule[$j]['tax_type']);
                                                          }
                                                      }
                                                      if($tax_amount !=''){
                                                          echo '<td  >'.format_money($tax_amount,2).'</td>';
                                                                $td_count++;
                                                      } else {
                                                          echo '<td  >'.format_money($tax_amount,2).'</td>';
                                                          $td_count++;
                                                      }
                                                  }
														                  }
                                              $inserttd=$key-$td_count;
                                              if($inserttd !=0){
                                                  for($tdint=0;$tdint<$inserttd;$tdint++){
                                                      echo "<td></td>";
                                                  }
                                              }

                                              echo'<td  >'.format_money($p_schedule[$j]["net_amount"],2).'</td>
                                                  </tr>';
                                                  $total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
                                              $j++;
                                          }
                                        ?>
												                <tr>
                                          <td colspan="2"><b>Grand Total (In &#x20B9;)</b></td>
                                          <td  ><?php echo format_money($total_basic_cost,2);?></td>
                                          <?php $k=0; if(isset($total_tax_amount)) {
                                            foreach($total_tax_amount as $row){
                                                echo '<td >'.format_money($row,2).'</td>';
                                            $k++;
								                          } } ?>
                                          <td  ><?php echo format_money($total_net_amount,2);?></td>
                                        </tr>
										                  </tbody>
										                </table>
								                  </div>
								                  </div>
                                </div>
								    
                                                <div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
                                                    <h3 class="panel-title"><strong> Remarks</strong></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group row" style="border-top:0px dotted #ddd;">
                                                        <label class="col-md-2 control-label"><strong>Maker Remarks:</strong></label>
                                                        <div class="col-md-10">
                                                              <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editloan)) { echo $editloan[0]->maker_remark; } ?></label> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 control-label"><strong>Checker Remarks:</strong></label>
                                                        <div class="col-md-10">
                                                              <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editloan)) { echo $editloan[0]->txn_remarks; } ?></label> 
                                                        </div>
                                                    </div>
                                                </div>

                            </form>

                            <?php if(isset($editloan)) { ?>
                            <?php if($editloan[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Loan_disbursement/updaterecord/'.$l_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                        <div class="row">
										 <div class="col-md-2   sr" id=""> <label >Remarks</label> </div> 
                                            <div class="col-md-10 ">
                                                <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Loan_disbursement" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } else if($editloan[0]->modified_by != '' && $editloan[0]->modified_by != null) { if($editloan[0]->modified_by!=$loanby) { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Loan_disbursement/approve/'.$l_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                        <div class="row">
										  <div class="col-md-2  sr" id=""> <label >Remarks</label> </div>  
                                            <div class="col-md-10">
                                                <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
                                            </div>
                                          
                                        </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Loan_disbursement" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    </div> 
                                </form>

                            <?php } } } } else { ?>

                                <form id="" method="post" action="<?php echo base_url().'index.php/Loan_disbursement/updaterecord/'.$l_id; ?>">
                                     <div class="panel-body" style="margin-top:10px;">
                                        <div class="row">
										  <div class="col-md-2  sr" id=""> <label >Remarks</label> </div>  
                                            <div class="col-md-10 ">
                                                <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
                                            </div>
                                          
                                        </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Loan_disbursement" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete"  onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } else if($editloan[0]->created_by != '' && $editloan[0]->created_by != null) { if($editloan[0]->created_by!=$loanby && $editloan[0]->txn_status != 'In Process') { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Loan_disbursement/approve/'.$l_id; ?>">
                                     <div class="panel-body" style="margin-top:10px;">
                                        <div class="row">
										 <div class="col-md-2 sr " id=""> <label >Remarks</label> </div>
                                            <div class="col-md-10 ">
                                                <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Loan_disbursement" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    </div> 
                                </form>

                            <?php } } } } else { ?>
                                
                                <form id="" method="post" action="<?php echo base_url().'index.php/Loan_disbursement/updaterecord/'.$l_id; ?>">
                                      <div class="panel-body" style="margin-top:10px;">
                                        <div class="row">
										  <div class="col-md-2 sr" id=""> <label >Remarks</label> </div>  
                                            <div class="col-md-10">
                                                <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
                                            </div>
                                          
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Loan_disbursement" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } ?>

					                </div>
						            </div>
						          </div>
								</div>
							</div>
						</div>
					</div>
				</div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        <?php $this->load->view('templates/footer');?>
    <!-- END SCRIPTS -->      
    </body>
</html>