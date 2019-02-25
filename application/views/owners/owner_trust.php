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
		
	 <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
	 
 <style type="text/css"> 
.llpsign .form-group{ padding-right:7px;}
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
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
						 <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details -  Trust</div>
                 <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding"> 	
						  <div class="box-shadow-inside">
                            <form id="form_trust" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($trust_detail)) { echo base_url().'index.php/owners/updatetrust/'.$o_id; } else { echo base_url().'index.php/owners/savetrust'; } ?>">
                                    		 
									<div class="col-md-12" style="padding:0;" >
										   <div class="panel panel-default ">
                                               <div class="panel-body box-padding">
                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-6">                                                
                                                    <label class="col-md-3 control-label">Trust Name <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="trust_name" placeholder="Trust Name" value="<?php if(isset($trust_detail)) { echo $trust_detail[0]->ow_trs_comapny_name; } ?>"/>
                                                    </div>
												</div>
											  <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Registration No</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="ow_reg_no" placeholder="Registration No" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_reg_no; } ?>"/>
                                                    </div>
                                                </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                               
                                                    <label class="col-md-3 control-label">Date of Incorp <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control datepicker1" name="date_of_incorporation" placeholder="Date of Incorporation" value="<?php if(isset($trust_detail)) { if($trust_detail[0]->ow_trs_incopdate!='' && $trust_detail[0]->ow_trs_incopdate!=null) echo date('d/m/Y', strtotime($trust_detail[0]->ow_trs_incopdate)); } ?>"/>
                                                    </div>
													</div>													
											    <div class="col-md-6">     
                                                    <label class="col-md-3 control-label">Contact Person <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" id="contact_person_id" name="contact_person" class="form-control" value="<?php if (set_value('contact_person')!=null) { echo set_value('contact_person'); } else if(isset($trust_detail[0]->ow_trs_contact)){ echo $trust_detail[0]->ow_trs_contact; } else { echo ''; }?>" />
                                                        <input  type="text" id="contact_person" name="contact_person_name" class="form-control auto_owner" value="<?php if (set_value('contact_person_name')!=null) { echo set_value('contact_person_name'); } else if(isset($trust_detail[0]->c_name)){ echo $trust_detail[0]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                                        <!-- <button type="button" class="btn btn-info mb-control sch" data-box="#message-box-info">+</button> -->
                                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                                
                                                    <label class="col-md-3 control-label"> Registered Address <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="registered_address" placeholder="Address" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_address; } ?>"/>
                                                    </div>
													</div>
													   <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Landmark</label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="trs_addr_landmark" placeholder="Landmark" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_landmark; } ?>"/>
                                                    </div>
                                               
                                            </div>
                                        
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                               
                                                    <label class="col-md-3 control-label"> City <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="trs_addr_city_id" id="trs_addr_city_id" />
                                                        <input type="text" class="form-control autocompleteCity" name="trs_addr_city" id ="trs_addr_city" placeholder="Address City" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_city; } ?>"/>
                                                    </div>
												 </div>
											<div class="col-md-6">
                                                    <label class="col-md-3 control-label"> Pincode <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="trs_addr_pincode" id="trs_addr_pincode" placeholder="Address Pincode" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_pincode; } ?>"/>
                                                    </div>
                                               
                                            </div>
                                         </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                              
                                                    <label class="col-md-3 control-label">State <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="trs_addr_state_id" id="trs_addr_state_id" />
                                                            <input type="text" class="form-control loadstatedropdown" name="trs_addr_state" id="trs_addr_state" placeholder="Address State" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_state; } ?>"/>
                                                    </div>
												   </div>	
													 <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Country</label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="trs_addr_country_id" id="trs_addr_country_id">
                                                            <input type="text" class="form-control loadcountrydropdown" name="trs_addr_country" id="trs_addr_country" placeholder="Country" value="<?php if(isset($trust_detail)) { echo  $trust_detail[0]->ow_trs_country; } ?>"/>
                                                    </div>
                                                
                                            </div>
                                        
                                        </div>
                                    
                                        <div class="form-group">
                                            
                                            <div class="col-md-6">
                                                
                                                    <label class="col-md-3 control-label">Branch Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="branch_address" placeholder="Branch Address" value="<?php if(isset($trust_detail)) { echo $trust_detail[0]->ow_trs_branch; } ?>"/>
                                                    </div>
												</div>	
													 <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Telephone No</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number" value="<?php if(isset($trust_detail)) { echo $trust_detail[0]->ow_trs_tel; } ?>"/>
                                                    </div>
                                                
                                            </div>
                                          
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                               
                                                    <label class="col-md-3 control-label">Mobile No <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mob_number" placeholder="Mobile Number" value="<?php if(isset($trust_detail)) { echo $trust_detail[0]->ow_trs_mob; } ?>"/>
                                                    </div>
                                                 
                                            </div>
                                        </div>
                                    </div>
                                        

									          <div class="panel-heading" >
									<h3 class="panel-title">Trustee Details</h3>
									
								</div>
										      <div class="panel-body">
								<div class="trustdetails">
									<?php $dir_cnt = 0; if(isset($trust_trustee)) {
										for($j=0;$j<count($trust_trustee); $j++) {
									?>

									<div class="form-group" id="repeat_trust_<?php echo ($dir_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
									<div class="col-md-6">
										<div class="col-md-3">

											<label class="col-md-12 control-label" style="margin:0; padding-left: 0;" >Trustee <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>
										</div>
										<div class="col-md-9">
											<input type="hidden" id="trustee_details_<?php echo ($dir_cnt+1) . '_id'; ?>" name="trustee_name[]" class="form-control" value="<?php if(isset($trust_trustee[$dir_cnt]->trst_contactid)){ echo $trust_trustee[$dir_cnt]->trst_contactid; } else { echo ''; }?>" />
											<input type="text" id="trustee_details_<?php echo ($dir_cnt+1); ?>" name="trustee_details[]" class="form-control auto_owner" value="<?php if(isset($trust_trustee[$dir_cnt]->c_name)){ echo $trust_trustee[$dir_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
											</div>
										</div>
									</div>
									<?php $dir_cnt++; } } else { ?>

									<div class="form-group" id="repeat_trust_<?php echo ($dir_cnt+1); ?>" style="border-top: 1px dotted #ddd;">
									 <div class="col-md-6">
										<div class="col-md-3">
											<label class="col-md-12 control-label" style="margin:0; padding-left: 0;" >Trustee 1  <span class="asterisk_sign">*</span></label>

										</div>
										  <div class="col-md-9">
											<input type="hidden" id="trustee_details_<?php echo ($dir_cnt+1).'_id'; ?>" name="trustee_name[]" class="form-control" value="" />
											<input type="text" id="trustee_details_<?php echo ($dir_cnt+1); ?>" name="trustee_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." />
											</div>
										</div>
										</div>
									</div>
									<?php } ?>
									<div class="col-md-12 btn-margin">
                                                                                   
                                                        <button type="button" class="btn btn-success repeat-trust" name="addhufbtn">+</button>
                                                        <button type="button" class="btn btn-success reverse-trust" style="margin-left: 10px;">-</button>
                                                
                                            </div>
								</div> 
										     <div class=" ">  
                                                <div class="panel-heading"  >
                                            <h3 class="panel-title">Beneficiary Details</h3>
                                            
                                        </div>
                                                <div class="panel-body">
                                         <div class="trustshare">
                                        <?php $shr_hld_cnt=0; if(isset($trust_beneficiary)) {
                                            for($j=0; $j<count($trust_beneficiary); $j++) {
                                        ?>

                                            <div class="form-group" id="repeat_trust_share_<?php echo ($shr_hld_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
												<div class="col-md-6">
                                                <div class="col-md-3" style="padding-left:0px">

                                                    <label class="col-md-12 control-label"   >Beneficiary <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="trust_beneficiary_<?php echo ($shr_hld_cnt+1).'_id'; ?>" name="beneficiary_name[]" class="form-control" value="<?php if(isset($trust_beneficiary[$shr_hld_cnt]->trst_contactid)){ echo $trust_beneficiary[$shr_hld_cnt]->trst_contactid; } else { echo ''; }?>" />
                                                    <input type="text" id="trust_beneficiary_<?php echo ($shr_hld_cnt+1); ?>" name="beneficiary_details[]" class="form-control auto_owner beneficiary" value="<?php if(isset($trust_beneficiary[$shr_hld_cnt]->c_name)){ echo $trust_beneficiary[$shr_hld_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
													 </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                 <label  style="padding:10px 5px;"> % </label>
                                                    <input type="text" class="form-control" id="beneficiary_percent_<?php echo ($shr_hld_cnt+1); ?>" name="beneficiary_percent[]" placeholder="Shareholder %" value="<?php echo $trust_beneficiary[$j]->trst_percent; ?>" style="width:90%; float:left;"/> 

                                                </div>
                                            </div>
                                            <?php $shr_hld_cnt++; }} else { ?>

                                            <div class="form-group" id="repeat_trust_share_<?php echo ($shr_hld_cnt+1); ?>" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <label class="col-md-12 control-label" style="margin:0; padding-left: 0;" >Beneficiary 1 <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="trust_beneficiary_<?php echo ($shr_hld_cnt+1).'_id'; ?>" name="beneficiary_name[]" class="form-control" value="" />
                                                    <input type="text" id="trust_beneficiary_<?php echo ($shr_hld_cnt+1); ?>" name="beneficiary_details[]" class="form-control auto_owner beneficiary" value="" placeholder="Type to choose owner from database..." /> 
													</div>
                                                </div>
                                           
                                                <div class="col-md-6">
												 <label  style="padding:10px 5px;"> % </label>
												<input type="text" class="form-control" id="beneficiary_percent_<?php echo ($shr_hld_cnt+1); ?>" name="beneficiary_percent[]" placeholder="Shareholder %"  style="width:90%; float:left;"/>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div> 
										 <div class="col-md-12 btn-margin">
                                                
                                                        <button type="button" class="btn btn-success repeat-trust-share"  name="addhufbtn">+</button>
                                                        <button type="button" class="btn btn-success reverse-trust-share" style="margin-left: 10px;">-</button>
                                             
                                            </div>
                                        </div>
                                                <div class="panel-heading"  >
                                           
										   <h3 class="panel-title">Documents</h3>
                                            
                                        </div>
                                                <div class="panel-body">
                                        <!-- <div class="trustdoc">
                                        <?php //$this->load->view('owners/owner_document');?>
                                        </div>
                                        <br> -->

                                        <?php $this->load->view('templates/document');?>


                                    
                                            <div class="col-md-12 btn-margin">
                                                    <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                                                                             

                                        </div>
                                        </div>
                                        
                                                <div class="panel-heading"  >
                                            <h3 class="panel-title">Authorised Signatory</h3>
                                            
                                        </div>
                                                <div class="panel-body box-padding">
                                        <div class="trustsign">
                                            <?php $aut_sig_cnt=0; if(isset($trust_ath)) {
                                                for($j=0; $j<count($trust_ath); $j++) {
                                            ?>

                                            <div class="form-group" id="repeat_trust_sign_<?php echo ($aut_sig_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
                                            <div class="col-md-6">
                                                <div class="col-md-3" style="padding-right: 0;padding-left:0;">
                                                    <label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right: 0;">Authorised Signatory <?php echo ($j+1); ?></label>

                                                </div>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="auth_details_<?php echo ($aut_sig_cnt+1).'_id'; ?>" name="auth_name[]" class="form-control" value="<?php if(isset($trust_ath[$aut_sig_cnt]->ath_contactid)){ echo $trust_ath[$aut_sig_cnt]->ath_contactid; } else { echo ''; }?>" />
                                                    <input  type="text" id="auth_details_<?php echo ($aut_sig_cnt+1); ?>" name="auth_details[]" class="form-control auto_owner" value="<?php if(isset($trust_ath[$aut_sig_cnt]->c_name)){ echo $trust_ath[$aut_sig_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
												 </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input  type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php echo $trust_ath[$j]->ath_purpose; ?>" />
                                                </div>
                                            </div>

                                            <?php $aut_sig_cnt++; }} else { ?>


                                            <div class="form-group" id="repeat_trust_sign_<?php echo ($aut_sig_cnt+1); ?>" style="border-top: 1px dotted #ddd;" >
                                            <div class="col-md-6">
                                                <div class="col-md-3" style="padding-right: 0;padding-left:0;">
                                                    <label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right: 0;">Authorised Signatory 1</label>

                                                </div>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="auth_details_<?php echo ($aut_sig_cnt+1).'_id'; ?>" name="auth_name[]" class="form-control" value="" />
                                                    <input type="text" id="auth_details_<?php echo ($aut_sig_cnt+1); ?>" name="auth_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." />
												</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS"/>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div> 
                                            <div class="col-md-12 btn-margin">                                               
                                                    <button type="button" class="btn btn-success repeat-trust-sign"  name="addhufbtn">+</button>
                                                    <button type="button" class="btn btn-success reverse-trust-sign" style="margin-left: 10px;">-</button>   
												</div>
                                    </div>
                                    
                                               <div class="panel-heading"  >
                                        <h3 class="panel-title">Remark</h3>
                                    </div>
                                              <div class="panel-body">
										<div class="remark-container">
                                             <div class="form-group" style="background: none;border:none">
                                        <div class="col-md-12">
                                            <!--<label class="col-md-1 control-label">Remark</label>-->
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="ow_maker_remark" name="ow_maker_remark" rows="2" placeholder="Remark"><?php if(isset($trust_detail)){ echo $trust_detail[0]->ow_maker_remark;}?></textarea>
                                            </div>
                                        </div>
                                    </div>
									</div>
									</div>
									 </div>
									     </div>
									
									
									</div>
                                  
 	 
                                    <div class="panel-footer">
                                        <input type="hidden" id="submitVal" value="1" />
                                        <a href="<?php echo base_url(); ?>index.php/owners" class="btn btn-danger" >Cancel</a>
                                        <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>"  />
                                        <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                                    </div>
									
                            </form>
							 </div>
				         </div>
							<!-- END PAGE CONTENT WRAPPER -->
						</div>            
				<!-- END PAGE CONTENT -->
					</div>
			   		 </div>
				 <!-- END PAGE CONTAINER -->
		     </div>
		 </div>
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
            var counter = <?php if(isset($trust_trustee)) { echo count($trust_trustee); } else { echo '1'; } ?>;
            $('.repeat-trust').click(function(event){
                event.preventDefault();
                counter++;

                var newRow = jQuery('<div class="form-group" id="repeat_trust_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3"><label class="col-md-12 control-label" style="margin:0; padding-left: 0;" >Trustee '+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-9"><input type="hidden" id="trustee_details_'+counter+'_id" name="trustee_name[]" class="form-control" value="" /><input type="text" id="trustee_details_'+counter+'" name="trustee_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." /></div></div></div>');
                $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

                $('.trustdetails').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-trust').click(function(event){
                if(counter!=1){
                    var id="#repeat_trust_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                }
            });
        });

        jQuery(function(){
            var counter = <?php if(isset($trust_beneficiary)) { echo count($trust_beneficiary); } else { echo '1'; } ?>;
            $('.repeat-trust-share').click(function(event){
                event.preventDefault();
                counter++;

                var newRow = jQuery('<div class="form-group" id="repeat_trust_share_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3" ><label class="col-md-12 control-label" style="margin:0; padding-left: 0;"  >Beneficiary '+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-9"><input type="hidden" id="trust_beneficiary_'+counter+'_id" name="beneficiary_name[]" class="form-control" value="" /><input type="text" id="trust_beneficiary_'+counter+'" name="beneficiary_details[]" class="form-control auto_owner beneficiary" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><label  style="padding:5px 5px;"> % </label><input type="text" class="form-control" id="beneficiary_percent_'+counter+'" name="beneficiary_percent[]" placeholder="Shareholder %" style="width:90%; float:left;"/>  </div></div>');
                $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

                $('.trustshare').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-trust-share').click(function(event){
                if(counter!=1){
                    var id="#repeat_trust_share_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                }
            });
        });

        // jQuery(function(){
        //     var counter = $('input.doc_file').length;
        //     $('.repeat-trust-doc').click(function(event){
        //         event.preventDefault();
        //         var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
        //                                 '<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" value="Others" />' + 
        //                                         '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" />' + 
        //                                         '<label style="float: left;margin-top: 5px;">Others <span class="asterisk_sign">*</span></label>' + 
        //                                     '</div>' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" style="float: left;" placeholder="Document Name"/>' + 
        //                                     '</div>' + 
        //                                 '</div>' + 
        //                                 '<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description" value="" />' + 
        //                                     '</div>' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
        //                                     '</div>' + 
        //                                 '</div>' + 
        //                                 '<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
        //                                     '</div>' + 
        //                                     '<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
        //                                     '</div>' + 
        //                                 '</div>' + 
        //                                 '<div class="col-md-2" style="padding-left:1px; padding-right:1px;">' + 
        //                                     '<div class="col-md-8" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<a class="file-input-wrapper btn btn-default  fileinput btn-primary">' + 
        //                                             '<span>Browse</span>' + 
        //                                             '<input type="file" class="fileinput btn-primary doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
        //                                         '</a>' + 
        //                                         '<div id="doc_'+counter+'_error"></div>' + 
        //                                     '</div>' + 
        //                                     '<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
        //                                         '<a id="repeat_doc_'+counter+'_delete" class="delete_row" href="#">Delete</a>' + 
        //                                     '</div>' + 
        //                                 '</div>' + 
        //                             '</div>');
        //         $('.trustdoc').append(newRow);
        //         $('.datepicker').datepicker();
        //         $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
        //         $('.delete_row').click(function(event){
        //             delete_row($(this));
        //         });
                
        //         $('input.doc_file').each(function() {
        //         var id = $(this).attr('id');
        //         var index = id.substr(id.lastIndexOf('_')+1);
        //         if($('#d_m_status_'+index).val()=="Yes") {
        //                 $(this).rules("add", { required: function(element) {
        //                                                         if($("#submitVal").val()=="0"){
        //                                                                 return true;
        //                                                             } else {
        //                                                                 return false;
        //                                                             }
        //                                                         }
        //                                     }, "Document");
        //             }
        //         });
        //         $("form :input").change(function() {
        //             $(".save-form").prop("disabled",false);
        //         });
        //         counter++;
        //     });
        //     $('.reverse-trust-doc').click(function(event){
        //         var id="#repeat_doc_"+(counter-1).toString();
        //         if($(id).length>0){
        //             $(id).remove();
        //             counter--;
        //         }
        //     });
        // });

        jQuery(function(){
            var counter = <?php if(isset($trust_ath)) { echo count($trust_ath); } else { echo '1'; } ?>;;
            $('.repeat-trust-sign').click(function(event){
                event.preventDefault();
                counter++;

                var newRow = jQuery('<div class="form-group" id="repeat_trust_sign_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3" style="padding-right: 0;padding-left:0;"><label class="col-md-12 control-label" style="padding-left:0; margin:0; padding-right: 0;">Authorised Signatory '+counter+'</label></div><div class="col-md-9"><input type="hidden" id="auth_details_'+counter+'_id" name="auth_name[]" class="form-control" value="" /><input type="text" id="auth_details_'+counter+'" name="auth_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS"/></div></div>');
                $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

                $('.trustsign').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-trust-sign').click(function(event){
                if(counter!=1){
                    var id="#repeat_trust_sign_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                }
            });
        });
	</script>
		
    <script>
//         $("#save_contact").click(function(){
//             var $result = 0;
// //            alert("success");
//             $.ajax({
//                 url: "<?php //echo base_url() . 'index.php/Contacts/saveContact' ?>",
//                 data: $("#form_private_limited").serialize(),
//                 cache: false,
//                 type: "POST",
//                 dataType: 'html',
//                 global: false,
//                 async: false,
//                 success: function (data) {
// //                    alert(data);
//                     if ($.isNumeric($.trim(data))) {
//                         $result = 1;
//                     } else {
//                         $result = 0;
//                     }
					
// 					$('#con_first_name').val('');
// 					$('#con_middle_name').val('');
// 					$('#con_last_name').val('');
// 					$('#con_email_id1').val('');
// 					$('#con_mobile_no1').val('');
// 					$('#con_first_name, #con_middle_name, #con_last_name, #con_email_id1, #con_mobile_no1').removeClass('valid');

//                 },
//                 error: function (data) {
// //                    alert(data);
//                     $result = 0;
//                 }
//             });

//             if ($result) {
//                 $(this).parents(".message-box").removeClass("open");
//                 return false;
//             }
//             else {
//                 return false;
//             }
//         });
    </script>
    
    </body>
</html>