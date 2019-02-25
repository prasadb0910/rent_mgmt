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
		  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
	 
	        <style type="text/css">
 
.box-padding .col-md-6 { padding-left:10px;  padding-right:8px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
        </style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
				   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details -  Limited</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                	<div class="page-content-wrap">
                     <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding"> 
													
							<form id="form_limited" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($pvt_details)) {echo base_url().'index.php/owners/updateltd/'.$o_id; } else { echo base_url().'index.php/owners/saveltd'; } ?>">
							 <div class="box-shadow-inside">
									<div class="col-md-12" style="padding:0;" >
										   <div class="panel panel-default ">
								    	     <div class="panel-body  box-padding">
										<div class="form-group" style="border-top: 1px dotted #ddd;">
											<div class="col-md-6">
											
													<label class="col-md-3 control-label">Company Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" class="form-control" id="o_id" name="o_id" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_id; } ?>"/>
														<input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?php if(isset($pvt_details)) { echo $pvt_details[0]->ow_ltd_comapny_name; } ?>"/>
													</div>
											</div>
												<div class="col-md-6">
                                                    <label class="col-md-3 control-label">Registration No</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="ow_reg_no" placeholder="Registration No" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_reg_no; } ?>"/>
                                                    </div>
												</div>
											
										</div>
										<div class="form-group">
											<div class="col-md-6">											
													<label class="col-md-3 control-label">Date of Incorp <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker1" name="date_of_incorporation" placeholder="Date of Incorporation" value="<?php if(isset($pvt_details)) { if($pvt_details[0]->ow_ltd_incopdate!='' && $pvt_details[0]->ow_ltd_incopdate!=null) echo date('d/m/Y', strtotime($pvt_details[0]->ow_ltd_incopdate)); } ?>"/>
													</div>
												</div>	
												<div class="col-md-6">
													<label class="col-md-3 control-label">Contact Person <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">                                                        
														<input type="hidden" id="contact_person_id" name="contact_person" class="form-control" value="<?php if (set_value('contact_person')!=null) { echo set_value('contact_person'); } else if(isset($pvt_details[0]->ow_ltd_contact)){ echo $pvt_details[0]->ow_ltd_contact; } else { echo ''; }?>" />
                                                        <input type="text" id="contact_person" name="contact_person_name" class="form-control auto_owner" value="<?php if (set_value('contact_person_name')!=null) { echo set_value('contact_person_name'); } else if(isset($pvt_details[0]->c_name)){ echo $pvt_details[0]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                                        <!-- <button type="button" class="btn btn-info mb-control sch" data-box="#message-box-info">+</button> -->
													</div>												 
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">												
													<label class="col-md-3 control-label">Registered Address <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
															<input type="text" class="form-control" name="registered_address" placeholder="Address" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_address; } ?>"/>
													</div>
												</div>
											<div class="col-md-6">
													<label class="col-md-3 control-label">Landmark</label>
													<div class="col-md-9">
															<input type="text" class="form-control" name="ltd_addr_landmark" placeholder="Landmark" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_landmark; } ?>"/>
													</div>
												</div>
											
										</div>
										<div class="form-group">
											<div class="col-md-6">											
													<label class="col-md-3 control-label"> City <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" name="ltd_addr_city_id" id="ltd_addr_city_id" />
														<input type="text" class="form-control autocompleteCity" name="ltd_addr_city" id ="ltd_addr_city" placeholder="Address City" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_city; } ?>"/>
													</div>
												</div>
												<div class="col-md-6">
													<label class="col-md-3 control-label"> Pincode <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
															<input type="text" class="form-control" name="ltd_addr_pincode" id="ltd_addr_pincode" placeholder="Pincode" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_pincode; } ?>"/>
													</div>
												</div>
																					
										</div>
										<div class="form-group">
											<div class="col-md-6">												
													<label class="col-md-3 control-label">State <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" name="ltd_addr_state_id" id="ltd_addr_state_id" />
														<input type="text" class="form-control loadstatedropdown" name="ltd_addr_state" id="ltd_addr_state" placeholder="State" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_state; } ?>"/>
													</div>
											</div>
											<div class="col-md-6">
													<label class="col-md-3 control-label">Country</label>
													<div class="col-md-9">
														<input type="hidden" name="ltd_addr_country_id" id="ltd_addr_country_id">
															<input type="text" class="form-control loadcountrydropdown" name="ltd_addr_country" id="ltd_addr_country" placeholder="Country" value="<?php if(isset($pvt_details)) { echo  $pvt_details[0]->ow_ltd_country; } ?>"/>
													</div>
												</div>
										</div>
									
										<div class="form-group">
											<div class="col-md-6">
											
													<label class="col-md-3 control-label">Branch Address </label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="branch_address" placeholder="Branch Address" value="<?php if(isset($pvt_details)) { echo $pvt_details[0]->ow_ltd_branch; } ?>"/>
													</div>
												</div>	
												<div class="col-md-6">
													<label class="col-md-3 control-label">Telephone No</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number" value="<?php if(isset($pvt_details)) { echo $pvt_details[0]->ow_ltd_tel; } ?>"/>
													</div>
												</div>
											
										</div>
										<div class="form-group">
											<div class="col-md-6">
													<label class="col-md-3 control-label">Mobile No <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="mob_number" placeholder="Mobile Number" value="<?php if(isset($pvt_details)) { echo $pvt_details[0]->ow_ltd_mob; } ?>"/>
													</div>
										</div>
										</div>
									</div>

										     <div class="panel-heading"  >
											<h3 class="panel-title">Director Details</h3>
											
										</div>
										    <div class="panel-body">
										<div class="pvtltd">
											<?php $dir_cnt=0; if(isset($pvt_direct)) { 
												for($j=0;$j<count($pvt_direct); $j++) {
												?>

											<div class="form-group" id="repeat_pvtltd_<?php echo ($dir_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
											<div class="col-md-6">
												<div class="col-md-3">
													<label class="col-md-12 control-label" style="padding-left:0; margin:0;">Director <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>

												</div>

												<div class="col-md-9">

                                                  	<input type="hidden" id="director_details_<?php echo ($dir_cnt+1).'_id'; ?>" name="director_name[]" class="form-control" value="<?php if(isset($pvt_direct[$dir_cnt]->dir_contactid)){ echo $pvt_direct[$dir_cnt]->dir_contactid; } else { echo ''; }?>" />
                                               		<input type="text" id="director_details_<?php echo ($dir_cnt+1); ?>" name="director_details[]" class="form-control auto_contact_owner" value="<?php if(isset($pvt_direct[$dir_cnt]->c_name)){ echo $pvt_direct[$dir_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact or owner from database..." />

												</div>

											</div>


											</div> 
											<?php $dir_cnt = $dir_cnt + 1;}} else { ?> 

											<div class="form-group" id="repeat_pvtltd_<?php echo ($dir_cnt+1); ?>" style="border-top: 1px dotted #ddd;">

											<div class="col-md-6">
												<div class="col-md-3">
													<label class="col-md-12 control-label" style="padding-left:0; margin:0;">Director 1 <span class="asterisk_sign">*</span></label>
												</div>
												<div class="col-md-9">
                                                  <input type="hidden" id="director_details_<?php echo ($dir_cnt+1) . '_id'; ?>" name="director_name[]" class="form-control" value="" />
                                                 <input type="text" id="director_details_<?php echo ($dir_cnt+1); ?>" name="director_details[]" class="form-control auto_contact_owner" value="" placeholder="Type to choose contact or owner from database..." />


												</div>
												</div>

											</div>
											<?php } ?>
										</div>
										
										<div class="col-md-12 btn-margin">                                                        
											<button type="button" class="btn btn-success repeat-pvtltd"   name="addhufbtn">+</button>
											<button type="button" class="btn btn-success reverse-pvtltd" style="margin-left: 10px;">-</button>
										</div>
									 
										</div>
										
										    <div class="panel-heading" >
											<h3 class="panel-title">Shareholder Details</h3>
											
										</div>
										        <div class="panel-body">
										<div class="sharepvtltd">
										<?php 
											$shr_hld_cnt=0; if(isset($pvt_share)) {
												for($j=0;$j<count($pvt_share);$j++) {
										?>

											<div class="form-group" id="repeat_pvtltd_share_<?php echo ($shr_hld_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
											<div class="col-md-6">
												<div class="col-md-3">

													<label class="col-md-12 control-label" style="padding-left:0; margin:0;">Share Holder <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>
												</div>

												<div class="col-md-9">
	                                                <input type="hidden" id="shareholder_details_<?php echo ($shr_hld_cnt+1).'_id'; ?>" name="shareholder_name[]" class="form-control" value="<?php if(isset($pvt_share[$shr_hld_cnt]->shr_contactid)){ echo $pvt_share[$shr_hld_cnt]->shr_contactid; } else { echo ''; }?>" />
	                                                <input type="text" id="shareholder_details_<?php echo ($shr_hld_cnt+1); ?>" name="shareholder_details[]" class="form-control auto_owner shareholder" value="<?php if(isset($pvt_share[$shr_hld_cnt]->c_name)){ echo $pvt_share[$shr_hld_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />

													</div>
												</div>
										


												<div class="col-md-6">
													<input type="text" class="form-control" id="shareholder_percent_<?php echo ($shr_hld_cnt+1); ?>" name="shareholder_percent[]" placeholder="Shareholder %" value="<?php echo $pvt_share[$j]->shr_percent; ?>" style="width:90%; float:left;" />  <label  style="padding:10px 5px;"  > % </label> 

												</div>
											</div>
										<?php $shr_hld_cnt = $shr_hld_cnt + 1;} } else { ?>

												

											<div class="form-group" id="repeat_pvtltd_share_<?php echo ($shr_hld_cnt+1); ?>" style="border-top: 1px dotted #ddd;">
												<div class="col-md-6">
													<div class="col-md-3">

														<label class="col-md-12 control-label" style="padding-left:0; margin:0;">Share Holder 1 <span class="asterisk_sign">*</span></label>
													</div>
													<div class="col-md-9">
	                                                   <input type="hidden" id="shareholder_details_<?php echo ($shr_hld_cnt+1) . '_id'; ?>" name="shareholder_name[]" class="form-control" value="" />
	                                                   <input type="text" id="shareholder_details_<?php echo ($shr_hld_cnt+1); ?>" name="shareholder_details[]" class="form-control auto_owner shareholder" value="" placeholder="Type to choose owner from database..." />

													</div>
												</div>

												<div class="col-md-6">

													<input type="text" class="form-control" id="shareholder_percent_<?php echo ($shr_hld_cnt+1); ?>" name="shareholder_percent[]" placeholder="Shareholder %" style="width:90%; float:left;" />  <label  style="padding:10px 5px;"  > % </label> 

												</div>
											</div>
										<?php } ?>
										</div>
											</div>
													<div class="col-md-12 btn-margin" >                                                        
														<button type="button" class="btn btn-success repeat-pvtltd-share"  name="addhufbtn">+</button>
                                            		  	<button type="button" class="btn btn-success reverse-pvtltd-share" style="margin-left: 10px;">-</button>
													</div>
												 
											 
										 
									 
										 
										
										<div class="panel-heading"  >
											<h3 class="panel-title">Documents</h3>
											
										</div>
										<div class="panel-body">
										<!-- <div class="pvtltddoc">
										<?php //$this->load->view('owners/owner_document');?>
										</div>
										<br> -->

										<?php $this->load->view('templates/document');?>
										 
												<div class="col-md-12 btn-margin">													
												                                                       
													<!-- <button type="button" class="btn btn-success repeat-pvtltd-doc" style="margin-left: 80px;" name="addhufbtn">+</button>
	                                    		  	<button type="button" class="btn btn-success reverse-pvtltd-doc" style="margin-left: 10px;">-</button> -->
													<button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
	                                                <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
												</div>											 
										</div>
										
										<div class="panel-heading"  >
											<h3 class="panel-title">Authorised Signatory</h3>
											
										</div>
										<div class="panel-body box-padding">
										<div class="pvtltdsign">
											<?php 
												$aut_sig_cnt=0; if(isset($pvt_signatory)) {
													for($j=0;$j<count($pvt_signatory); $j++) {
											?>

											<div class="form-group" id="repeat_pvtltd_sign_<?php echo ($aut_sig_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
											<div class="col-md-6">
												<div class="col-md-3" style="padding-right: 0;padding-left:0;">
													<label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right:0;">Authorised Signatory <?php echo ($j+1); ?></label>
												</div>
												<div class="col-md-9">

                                                   <input  type="hidden" id="auth_details_<?php echo ($aut_sig_cnt+1) . '_id'; ?>" name="auth_name[]" class="form-control" value="<?php if(isset($pvt_signatory[$aut_sig_cnt]->ath_contactid)){ echo $pvt_signatory[$aut_sig_cnt]->ath_contactid; } else { echo ''; }?>" />
                                                    <input type="text" id="auth_details_<?php echo ($aut_sig_cnt+1); ?>" name="auth_details[]" class="form-control auto_owner" value="<?php if(isset($pvt_signatory[$aut_sig_cnt]->c_name)){ echo $pvt_signatory[$aut_sig_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
												</div>

											</div>
	

												<div class="col-md-6">

													<input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php echo $pvt_signatory[$j]->ath_purpose; ?>" />
												</div>
											</div>
											<?php $aut_sig_cnt = $aut_sig_cnt + 1;}} else { ?>

											<div class="form-group" id="repeat_pvtltd_sign_<?php echo ($aut_sig_cnt+1); ?>" style="border-top: 1px dotted #ddd;">
											<div class="col-md-6">
												<div class="col-md-3" style="padding-right: 0;padding-left:0;">
													<label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right:0;">Authorised Signatory 1</label>

												</div>

												<div class="col-md-9">
                                                     <input type="hidden" id="auth_details_<?php echo ($aut_sig_cnt+1) . '_id'; ?>" name="auth_name[]" class="form-control" value="" />
                                                      <input type="text" id="auth_details_<?php echo ($aut_sig_cnt+1); ?>" name="auth_details[]" class="form-control auto_client" value="" placeholder="Type to choose contact from database..." />

												</div>
											</div>
												<div class="col-md-6">
													<input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS"/>
												</div>
											</div>
											<?php } ?>
										</div>  
										 
												
											<div class="col-md-12 btn-margin">                                                        
												<button type="button" class="btn btn-success repeat-pvtltd-sign"   name="addhufbtn">+</button>
												<button type="button" class="btn btn-success reverse-pvtltd-sign" style="margin-left: 10px;">-</button>
											</div>
										</div>


										<div class="panel-heading" >
											<h3 class="panel-title">Remark</h3>
										</div>
										<div class="panel-body">
										 <div class="remark-container">
                                             <div class="form-group" style="background: none;border:none; padding-right:0px">
											<div class="col-md-12">
												<!--<label class="col-md-1 control-label">Remark</label>-->
												<div class="col-md-12">
													<textarea class="form-control" id="ow_maker_remark" name="ow_maker_remark" rows="2" placeholder="Remark"><?php if(isset($pvt_details)){ echo $pvt_details[0]->ow_maker_remark;}?></textarea>
												</div>
											</div>
										</div>
										 </div>  
										</div>
										 </div>                    
									</div>
									 <br clear="all"/>	
									</div>

									<div class="panel-footer">
										<input type="hidden" id="submitVal" value="1" />
										<a href="<?php echo base_url(); ?>index.php/owners" class="btn btn-danger" >Cancel</a>
	                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>"  />
	                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
								    </div>
								</form>

								<!-- start contact popup -->
                                <form id="contact_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
                                    <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
	                                    <div class="mb-container" style="background:#fff;">
	                                        <div class="mb-middle">
												
													<div class="mb-title" style="color:#000;text-align:center;">Add Contact</div>
													<div class="mb-content">
														<div class="form-group" style="border-top: 1px dotted #ddd;">
															<label class="col-md-2 control-label" >Full Name <span class="asterisk_sign">*</span></label>
															<div class="col-md-4">
																	<input type="text" id="con_first_name" class="form-control" name="con_first_name" placeholder="First Name"/>
															</div>
															<div class="col-md-3">
																	<input type="text" id="con_middle_name" class="form-control" name="con_middle_name" placeholder="Middle Name"/>
															</div>
															<div class="col-md-3">
																	<input type="text" id="con_last_name" class="form-control" name="con_last_name" placeholder="Last Name"/>
															</div>
														</div>
														<div class="form-group" style="border-top: 1px dotted #ddd;">
															<div class="col-md-12">
																<label class="col-md-2 control-label" >Email ID <span class="asterisk_sign">*</span></label>
																<div class="col-md-4">
																		<input type="text" id="con_email_id1" class="form-control" name="con_email_id1" placeholder="Email ID"/>
																</div>
																<label class="col-md-2 control-label" >Mobile No <span class="asterisk_sign">*</span></label>
																<div class="col-md-4">
																		<input type="text" id="con_mobile_no1" class="form-control" name="con_mobile_no1" placeholder="Mobile No"/>
																</div>
															</div>
														</div>
													</div>

													<div class="mb-footer">
														<button class="btn btn-danger mb-control-close">Cancel</button>
											<button id="save_contact" type="button" class="btn btn-success pull-right" style="margin-right: 10px;">Save</button>
													</div>
												
	                                        </div>
	                                    </div>
	                                </div>
								</form>
                                <!-- End contact popup -->
								
                   
                <!-- END PAGE CONTENT WRAPPER -->
				</div>    
			</div>  
		  </div>    
            <!-- END PAGE CONTENT -->
        </div>
			</div>
		</div>
		<!-- END PAGE CONTAINER -->
						
        
        <?php $this->load->view('templates/footer');?>
		<script type="text/javascript">
		var BASE_URL="<?php echo base_url()?>";
		</script>
	
		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
		
		<script type="text/javascript">
			$(function() {
			  $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
        changeYear: true });
			});
    	</script>

	<script>
		jQuery(function(){
		    var counter = <?php if(isset($pvt_direct)) { echo count($pvt_direct); } else { echo '1'; } ?>;
		    $('.repeat-pvtltd').click(function(event){
		        event.preventDefault();
		        counter++;

		        var newRow = jQuery('<div class="form-group" id="repeat_pvtltd_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"> <div class="col-md-6"> <div class="col-md-3"><label class="col-md-12 control-label" style="padding-left:0; margin:0;" >Director '+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-9"><input type="hidden" id="director_details_'+counter+'_id" name="director_name[]" class="form-control" value="" /><input type="text" id="director_details_'+counter+'" name="director_details[]" class="form-control auto_contact_owner" value="" placeholder="Type to choose contact or owner from database..." /></div></div></div>');
		       $('.auto_contact_owner', newRow).autocomplete(autocomp_opt_contact_owner);
		       $('.pvtltd').append(newRow);
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
		    });
            $('.reverse-pvtltd').click(function(event){
            	if(counter!=1){
	                var id="#repeat_pvtltd_"+(counter).toString();
	                if($(id).length>0){
	                    $(id).remove();
	                    counter--;
	                }
	            }
            });
		});

		jQuery(function(){
		    var counter = <?php if(isset($pvt_share)) { echo count($pvt_share); } else { echo '1'; } ?>;
		    $('.repeat-pvtltd-share').click(function(event){
		        event.preventDefault();
		        counter++;

		        var newRow = jQuery('<div class="form-group" id="repeat_pvtltd_share_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3"><label class="col-md-12 control-label" style="padding-left:0; margin:0;"  >Share Holder '+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-9"><input type="hidden" id="shareholder_details_'+counter+'_id" name="shareholder_name[]" class="form-control" value="" /><input type="text" id="shareholder_details_'+counter+'" name="shareholder_details[]" class="form-control auto_owner shareholder" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><input type="text" class="form-control" id="shareholder_percent_'+counter+'" name="shareholder_percent[]" placeholder="Shareholder %" style="width:90%; float:left;"/>  <label  style="padding:10px 5px;"  > % </label> </div></div>');
		        $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

		        $('.sharepvtltd').append(newRow);
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
		    });
            $('.reverse-pvtltd-share').click(function(event){
            	if(counter!=1){
	                var id="#repeat_pvtltd_share_"+(counter).toString();
	                if($(id).length>0){
	                    $(id).remove();
	                    counter--;
	                }
            	}
            });
		});

		// jQuery(function(){
		//     var counter = $('input.doc_file').length;
		//     $('.repeat-pvtltd-doc').click(function(event){
		//         event.preventDefault();
  //               var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
  //                                       '<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" value="Others" />' + 
  //                                               '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" />' + 
  //                                               '<label style="float: left;margin-top: 5px;">Others <span class="asterisk_sign">*</span></label>' + 
  //                                           '</div>' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" style="float: left;" placeholder="Document Name"/>' + 
  //                                           '</div>' + 
  //                                       '</div>' + 
  //                                       '<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description" value="" />' + 
  //                                           '</div>' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
  //                                           '</div>' + 
  //                                       '</div>' + 
  //                                       '<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
  //                                           '</div>' + 
  //                                           '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
  //                                           '</div>' + 
  //                                       '</div>' + 
  //                                       '<div class="col-md-2" style="padding-left:1px; padding-right:1px;">' + 
  //                                           '<div class="col-md-8" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<a class="file-input-wrapper btn btn-default  fileinput btn-primary">' + 
  //                                                   '<span>Browse</span>' + 
  //                                                   '<input type="file" class="fileinput btn-primary doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
  //                                               '</a>' + 
  //                                               '<div id="doc_'+counter+'_error"></div>' + 
  //                                           '</div>' + 
  //                                           '<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
  //                                               '<a id="repeat_doc_'+counter+'_delete" class="delete_row" href="#">Delete</a>' + 
  //                                           '</div>' + 
  //                                       '</div>' + 
  //                                   '</div>');
  //           	$('.pvtltddoc').append(newRow);
		//         $('.datepicker').datepicker();
		//         $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
  //               $('.delete_row').click(function(event){
  //                   delete_row($(this));
  //               });
		//         $('input.doc_file').each(function() {
  //               var id = $(this).attr('id');
  //               var index = id.substr(id.lastIndexOf('_')+1);
  //               if($('#d_m_status_'+index).val()=="Yes") {
  //                       $(this).rules("add", { required: function(element) {
  //                                                               if($("#submitVal").val()=="0"){
		// 									                            return true;
		// 									                        } else {
		// 									                            return false;
		// 									                        }
	 //                                                            }
  //                                           }, "Document");
  //                   }
  //               });
		//         $("form :input").change(function() {
	 //                $(".save-form").prop("disabled",false);
	 //            });
		//         counter++;
		//     });
  //           $('.reverse-pvtltd-doc').click(function(event){
  //               var id="#repeat_doc_"+(counter-1).toString();
  //               if($(id).length>0){
  //                   $(id).remove();
  //                   counter--;
  //               }
  //           });
		// });

		jQuery(function(){
		    var counter = <?php if(isset($pvt_signatory)) { echo count($pvt_signatory); } else { echo '1'; } ?>;
		    $('.repeat-pvtltd-sign').click(function(event){
		        event.preventDefault();
		        counter++;

		        var newRow = jQuery('<div class="form-group" id="repeat_pvtltd_sign_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3" style="padding-right: 0;padding-left:0;"><label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right:0;">Authorised Signatory '+counter+'</label></div><div class="col-md-9"><input type="hidden" id="auth_details_'+counter+'_id" name="auth_name[]" class="form-control" value="" /><input type="text" id="auth_details_'+counter+'" name="auth_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS"/></div></div>');
		        $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);
		        $('.pvtltdsign').append(newRow);
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
		    });
            $('.reverse-pvtltd-sign').click(function(event){
            	if(counter!=1){
	                var id="#repeat_pvtltd_sign_"+(counter).toString();
	                if($(id).length>0){
	                    $(id).remove();
	                    counter--;
	                }
	            }
            });
		});
	</script>
	<script>
        $(document).ready(function() {
            addMultiInputNamingRules('#form_private_limited', '.doc_name', { required:function(element) {
		                                                                                    if($("#submitVal").val()=="0"){
		                                                                                        return true;
		                                                                                    } else {
		                                                                                        return false;
		                                                                                    }
		                                                                                }
		                                                            }, "Document");
		    $('input.doc_file').each(function() {
		        $(this).rules("remove");
		    });
		    $('input.doc_file').each(function() {
		        var id = $(this).attr('id');
		        var index = id.substr(id.lastIndexOf('_')+1);
		        if($('#d_m_status_'+index).val()=="Yes") {
		            if($('#doc_file_download_'+index).length==0) {
		                $(this).rules("add", { required: function(element) {
		                                                    if($("#submitVal").val()=="0"){
		                                                        return true;
		                                                    } else {
		                                                        return false;
		                                                    }
		                                                }
		                                });
		            }
		        }
		    });

		    addMultiInputNamingRules('#form_private_limited', 'input[name="director_details[]"]', { required: function(element) {
		                                                    if($("#submitVal").val()=="0"){
		                                                        return true;
		                                                    } else {
		                                                        return false;
		                                                    }
		                                                }, 
		                                            messages: {required: "Select correct owner from list"}
		                                }, "");
		    addMultiInputNamingRules('#form_private_limited', 'input[name="shareholder_details[]"]', { required: function(element) {
		                                                    if($("#submitVal").val()=="0"){
		                                                        return true;
		                                                    } else {
		                                                        return false;
		                                                    }
		                                                }, 
		                                            messages: {required: "Select correct owner from list"}
		                                }, "");
		    addMultiInputNamingRules('#form_private_limited', 'input[name="shareholder_percent[]"]', { required: function(element) {
		                                                    if($("#submitVal").val()=="0"){
		                                                        return true;
		                                                    } else {
		                                                        return false;
		                                                    }
		                                                },
		                                                numbersonly: true
		                                }, "");
		    addMultiInputNamingRules('#form_private_limited', 'input[name="no_of_shares[]"]', {numbersonly: true}, "");
        });
    </script>
    <!-- END SCRIPTS -->
    </body>
</html>