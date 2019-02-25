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
.form-horizontal .control-label { padding:0 2px!important; }
.custom-padding .financial_institution { padding:0!important;  }
.financial_institution .control-label { padding:0!important; }
.sr{ text-align:left;}
.custom-padding .Makerr {  padding:0px!important; }
.Makerr .control-label { padding:0 2px!important; }
.custom-padding .col-md-11 { padding:0 10px 0 10px;  }

}

@media screen and (min-width: 781px) and (max-width:991px){.custom-padding .financial_institution { padding:0!important;  }
.financial_institution .control-label { padding:0!important; }
.sr{ text-align:left;}
.Makerr{ padding:0!important; }
.Makerr .control-label { padding:0!important; }
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
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/loan'; ?>" > Loan List</a>  &nbsp; &#10095; &nbsp;    Loan View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				  <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>  <a class="btn-margin" href="<?php echo base_url().'index.php/loan/edit/'.$l_id; ?>"> 
				  <span class="btn btn-success pull-right btn-font"> Edit </span> </a> <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/loan" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
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
											   
												<div id="pdiv" >    
												<div class="panel-body">
													<!-- <div class="row">
													<h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;"> Borrower Details </h3>                                    
														</div> -->
												
													<div class="row">
														<div class="table-responsive">
															<table id="contacts" class="table table-bordered print-width-srno" style="border-top:;">
																<thead>
																	<tr>
																		<th width="5%" align="center">Sr. No. </th>
																		<th width="95%">Borrower Name </th>
																	</tr>
																</thead>
																<tbody>
																	<?php if(isset($editborower)) { 
																		for ($j=0; $j < count($editborower); $j++) { ?>
																		<tr>
																		  <td align="center" class="Contact_name"><?php echo $j+1; ?></td>
																			<td><?php if(isset($editborower[$j]->c_name)){ echo $editborower[$j]->c_name; } else { echo ''; }?></td>
																		</tr>
																	<?php } } ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												
												<div class="panel-heading">
												  <h3 class="panel-title"><strong>Loan Details</strong></h3>
												</div>
												<div class="panel-body">
												  <!-- <div class="row">
													<h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;"> Loan Details </h3>                                    
												  </div> -->

									<div class="row">
  										<div class="table-responsive">
    										<table id="contacts" class="table table-bordered print-width-srno" style="border-top:;">
    											<thead>
    												<tr>
                                                        <th width="5%" align="center">Sr. No. </th>
    													<th width="95%">Borrower Name </th>
    												</tr>
    											</thead>
    											<tbody>
    												<?php if(isset($editborower)) { 
    													for ($j=0; $j < count($editborower); $j++) { ?>
        												<tr>
        												  <td align="center" class="Contact_name"><?php echo $j+1; ?></td>
        													<td><?php if(isset($editborower[$j]->c_name)){ echo $editborower[$j]->c_name; } else { echo ''; }?></td>
        												</tr>
    												<?php } } ?>
    											</tbody>
    										</table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Loan Details</strong></h3>
                                </div>
                                <div class="panel-body">
                                  <!-- <div class="row">
                                    <h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;"> Loan Details </h3>                                    
                                  </div> -->
                
                                <div class="row">
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12 position-name-1 control-label">Loan Ref Id :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12  position-name-11">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  position-name-2 control-label">Loan Ref Name :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12  position-name-22">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  position-name-3 control-label" > Loan Type : </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12  position-name-33">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_type;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class=""> 
                                                <label class="col-md-6 col-sm-6 col-xs-12  control-label"> Amount (In &#x20B9;) :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12 ">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 " >
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  control-label" style="padding-left: 0;" > Loan Start Date : </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12 ">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 " >
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12 control-label" style="padding-left: 0;" > Loan Due Day  :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12 ">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  position-name-10 control-label"> Term :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12  position-name-100">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  position-name-333 control-label" > Interest Type : </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12  position-name-3333">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->interest_type;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-6 col-sm-6 col-xs-12  position-name-222 control-label" > Interest Rate :</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12 position-name-2222">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?> % </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="">
                                                <label class="col-md-2 control-label" > Financial Institution : </label>
                                                <div class="col-md-10 financial_institution">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
									
									<div class="form-group">
										 <div class="col-md-12" >
                                            <div class="">
                                                <label class="col-md-2 control-label" > Repayment :</label>
                                                <div class="col-md-10 financial_institution">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?></label>
                                                </div>
                                            </div>
                                        </div>

									</div>
                                    <div class="form-group print-form-group print-border">
                                        <div class="col-md-12">
                                            <div class="">
                                                <label class="col-md-2 control-label" > Purpose : </label>
                                                <div class="col-md-10 financial_institution">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>



                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Security</strong></h3>
                                </div>
                                <div class="panel-body">
                                  <!-- <div class="row">
                                    <h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;"> Secuirty </h3>                                    
                                  </div> -->
                
                                  <div class="row">
                                  <div class="table-responsive">
                                    <table id="contacts" class="table table-bordered print-security" style="border-top:;">
                                      <thead>
                                        <tr>
                                          <th width="5%" align="center">Sr. No.</th>
                                          <th width="45%">Property Name </th>
                                          <th width="50%">Sub Property Name </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php if(isset($editproperty)) { 
                                          for ($j=0; $j < count($editproperty); $j++) { ?>
                                            <tr>
                                              <td  align="center" class="Contact_name"><?php echo $j+1; ?></td>
                                              <td><?php if(isset($editproperty[$j]->p_property_name)) {if($editproperty[$j]->p_property_name!="") echo $editproperty[$j]->p_property_name; else echo $editproperty[$j]->property;} else echo $editproperty[$j]->property; ?></td>
                                              <td><?php echo $editproperty[$j]->sp_name; ?></td>
                                            </tr>
                                        <?php } } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                  </div>
                                </div>


																<!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5;   ">
																	<h3 class="panel-title" style="padding:0px; "><strong>Document </strong></h3>
															  </div>
																<div class="panel-body">
																	<div class="row">
																		<div class="table-responsive">
																		<table id="contacts" class="table table-bordered">
																			<thead>
																				<tr>
																				  <th width="19%">Document Name</th>
																					<th width="16%">ID Proof</th>
																					<th width="16%">Reference No.</th>
																					<th width="15%">Date of Issue</th>
																					<th width="20%">Date of Expiry</th>
																					<th width="14%" class="th">Download</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php //if(isset($editdocs)) { 
																				//for($i=0; $i<count($editdocs); $i++) { ?>
																				<tr>
																				  <td class="Contact_name"><?php //echo $editdocs[$i]->ln_doc_name; ?></td>
																					<td class="Contact_name"><?php //echo $editdocs[$i]->ln_doc_description; ?></td>
																					<td><?php //echo $editdocs[$i]->ln_doc_ref_no; ?></td>
																					<td><?php //echo date('d/m/Y',strtotime($editdocs[$i]->ln_doc_doi)); ?></td>
																					<td><?php //echo date('d/m/Y',strtotime($editdocs[$i]->ln_doc_doe)); ?></td>
																					<?php //if($editdocs[$i]->ln_document!='' && $editdocs[$i]->ln_document!=null) { ?>
																						<td align=""  class="td">
																							<?php //if($editdocs[$i]->ln_document!= '') { ?><a href="<?php //echo base_url().$editdocs[$i]->ln_document; ?>" class="btn btn-primary">
																							<i class="glyphicon glyphicon-download"> </i> Download </a><?php //} ?>
																						</td>
																					<?php //} else { ?>
																						<td align="" class="td"></td>
																					<?php //} ?>
																				</tr>
																				<?php //} } ?>
																			</tbody>
																		</table>
																	  </div>
																	</div>
																</div> -->

																<?php $this->load->view('templates/document_view');?>
																
																<?php $this->load->view('templates/pending_activity_view');?>

																<div class="panel-heading" style="border-top:1px solid #E5E5E5; margin-top:10px; ">
																	<h3 class="panel-title"><strong> Remarks</strong></h3>
																</div>
																<div class="panel-body">
																	<div class="form-group print-form-group" style="border-top:0px dotted #ddd;">
																		<div class="col-md-12">
																		<label class="col-md-1 control-label"><strong>Maker Remark:</strong></label>
																		<div class="col-md-11 Makerr">
																			  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editloan)) { echo $editloan[0]->maker_remark; } ?></label> 
																		</div>
																		</div>
																	</div>
																	<div class="form-group print-form-group print-border">
																		<div class="col-md-12">
																		<label class="col-md-1 control-label"><strong>Checker Remark:</strong></label>
																		<div class="col-md-11 Makerr">
																			  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editloan)) { echo $editloan[0]->txn_remarks; } ?></label> 
																		</div>
																		</div>
																	</div>
																</div>
				  </div>
											</form>

											<?php if(isset($editloan)) { ?>
											<?php if($editloan[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											  
												<form id="" method="post" action="<?php echo base_url().'index.php/Loan/updaterecord/'.$l_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
														<div class="row">
														
															<div class="col-md-1 sr" id=""> <label >Remarks</label> </div>  
															<div class="col-md-11 ">
																<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
															</div>
														
														</div>
													</div>
														 
													<div class="panel-footer">
														<a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-danger">Cancel</a>
														<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
													</div> 
												</form>

											<?php } } } else if($editloan[0]->modified_by != '' && $editloan[0]->modified_by != null) { if($editloan[0]->modified_by!=$loanby) { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											  
												<form id="" method="post" action="<?php echo base_url().'index.php/Loan/approve/'.$l_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
														<div class="row">
														<div class="col-md-1  sr" id=""> <label >Remarks</label> </div>  
															<div class="col-md-11  ">
																<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
															</div>
															
														</div>
													</div>
														 
													<div class="panel-footer">
														<a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-danger">Cancel</a>
														<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
														<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
													</div> 
												</form>

											<?php } } } } else { ?>

												<form id="" method="post" action="<?php echo base_url().'index.php/Loan/updaterecord/'.$l_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
														<div class="row">
														<div class="col-md-1   sr" id=""> <label >Remarks</label> </div>  
															<div class="col-md-11">
																<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
															</div>
															
														</div>
													</div>
														 
													<div class="panel-footer">
														<a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-danger">Cancel</a>
														<input type="submit" class="btn btn-success pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
													</div> 
												</form>

											<?php } } else if($editloan[0]->created_by != '' && $editloan[0]->created_by != null) { if($editloan[0]->created_by!=$loanby && $editloan[0]->txn_status != 'In Process') { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											  
												<form id="" method="post" action="<?php echo base_url().'index.php/Loan/approve/'.$l_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
														<div class="row">
															<div class="col-md-1 sr " id=""> <label >Remarks</label> </div>
															<div class="col-md-11">
																<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
															</div>
														
														</div>
													</div>
													
													<div class="panel-footer">
														<a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-danger">Cancel</a>
														<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
														<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
													</div> 
												</form>

											<?php } } } } else { ?>
												
												<form id="" method="post" action="<?php echo base_url().'index.php/Loan/updaterecord/'.$l_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
														<div class="row">
														
														 <div class="col-md-1   sr" id=""> <label >Remarks</label> </div>  
															<div class="col-md-11 ">
																<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?></textarea>
															</div>
															
														</div>
													</div>

													<div class="panel-footer">
														<a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-danger">Cancel</a>
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
     <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>

       $('.printdiv').click(function(){

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
              
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;}   table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;} table tr th:first-child{ width:2%; text-align:cenetr!important;} table tr th:last-child{width:20%;}.print-security tr th:first-child{width:8%!important; text-align:cenetr!important;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:55%;}.print-related{ width:33.3%;}.col-md-6 { }</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>