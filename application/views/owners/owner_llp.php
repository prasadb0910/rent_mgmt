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
				  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details -  LLP</div>
                
                <!-- PAGE CONTENT WRAPPER -->
               <div class="page-content-wrap">
                     <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding"> 							

                            <div class="" id="llp">
                                <form id="form_llp" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($llp_detail)) { echo base_url().'index.php/owners/updatellp/'.$o_id; }else { echo base_url().'index.php/owners/savellp'; } ?>">
									 <div class="box-shadow-inside">
									<div class="col-md-12" style="padding:0;" >
										   <div class="panel panel-default ">
                                    <div class="panel-body box-padding">
                                        <div class="form-group" style="border-top:1px dotted #ddd;">
                                            <div class="col-md-6">
                                              
                                                    <label class="col-md-3 control-label">Organisation Name <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="organisation_name" placeholder="Organisation Name" value="<?php if(isset($llp_detail)) { echo $llp_detail[0]->ow_llp_comapny_name; } ?>" />
                                                    </div>
												 </div>
											  <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Registration No</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="ow_reg_no" placeholder="Registration No" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_reg_no; } ?>"/>
                                                    </div>
                                                </div>                                           
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                              
                                                    <label class="col-md-3 control-label">Date of Incorp <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control datepicker1" name="date_of_incorporation" placeholder="Date of Incorporation" value="<?php if(isset($llp_detail)) { if($llp_detail[0]->ow_llp_incopdate!='' && $llp_detail[0]->ow_llp_incopdate!=null) echo date('d/m/Y', strtotime($llp_detail[0]->ow_llp_incopdate)); } ?>"/>
                                                    </div>
											</div>
											  <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Contact Person <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" id="contact_person_id" name="contact_person" class="form-control" value="<?php if (set_value('contact_person')!=null) { echo set_value('contact_person'); } else if(isset($llp_detail[0]->ow_llp_contact)){ echo $llp_detail[0]->ow_llp_contact; } else { echo ''; }?>" />
                                                        <input type="text" id="contact_person" name="contact_person_name" class="form-control auto_owner" value="<?php if (set_value('contact_person_name')!=null) { echo set_value('contact_person_name'); } else if(isset($llp_detail[0]->c_name)){ echo $llp_detail[0]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                                        <!-- <button type="button" class="btn btn-info mb-control sch" data-box="#message-box-info">+</button> -->
                                                    </div>
                                                </div>
                                           
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                                
                                                    <label class="col-md-3 control-label"> Registered Address <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="registered_address" placeholder="Address" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_address; } ?>"/>
                                                    </div>
													</div>
											  <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Landmark</label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="llp_addr_landmark" placeholder="Landmark" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_landmark; } ?>"/>
                                                    </div>
                                                </div> 
                                        </div>
										
                                        <div class="form-group">
                                            <div class="col-md-6">                                             
                                                    <label class="col-md-3 control-label"> City <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="llp_addr_city_id" id="llp_addr_city_id" />
                                                        <input type="text" class="form-control autocompleteCity" name="llp_addr_city" id ="llp_addr_city" placeholder="Address City" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_city; } ?>"/>
                                                    </div>
													</div>
											 <div class="col-md-6">  
                                                    <label class="col-md-3 control-label"> Pincode <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                            <input type="text" class="form-control" name="llp_addr_pincode" id="llp_addr_pincode" placeholder="Pincode" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_pincode; } ?>"/>
                                                    </div>
                                                </div>                                         
                                        
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                              
                                                    <label class="col-md-3 control-label">State <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="llp_addr_state_id" id="llp_addr_state_id" />
                                                            <input type="text" class="form-control loadstatedropdown" name="llp_addr_state" id="llp_addr_state" placeholder="Address State" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_state; } ?>"/>
                                                    </div>
												 </div>
												  <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Country</label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="llp_addr_country_id" id="llp_addr_country_id">
                                                        <input type="text" class="form-control loadcountrydropdown" name="llp_addr_country" id="llp_addr_country" placeh	older="Country" value="<?php if(isset($llp_detail)) { echo  $llp_detail[0]->ow_llp_country; } ?>"/>
                                                    </div>                                               
                                              </div>                                        
                                        </div>
                                     <div class="form-group">
                                            <div class="col-md-6">                                              
                                                    <label class="col-md-3 control-label">Branch Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="branch_address" placeholder="Branch Address" value="<?php if(isset($llp_detail)) { echo $llp_detail[0]->ow_llp_branch; } ?>"/>
                                                    </div>
												   </div>
												   <div class="col-md-6">
                                                    <label class="col-md-3 control-label">Telephone No</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number" value="<?php if(isset($llp_detail)) { echo $llp_detail[0]->ow_llp_tel; } ?>"/>
                                                    </div>                                                
                                            </div>                                          
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">                                             
                                                    <label class="col-md-3 control-label">Mobile No <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mob_number" placeholder="Mobile Number" value="<?php if(isset($llp_detail)) { echo $llp_detail[0]->ow_llp_mob; } ?>"/>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>

                                    <div class="panel-heading"  >
                                        <h3 class="panel-title">Partnership Details</h3>
                                    </div>
                                    <div class="panel-body">
                                    <div class="llppartner">
                                        <?php $dir_cnt=0; if(isset($llp_partner)) {
                                            
                                            for($j=0; $j < count($llp_partner); $j++) {
                                        ?>

                                        <div class="form-group" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
										<div class="col-md-6">
                                            <div class="col-md-3"  >

                                                <label class="col-md-12 control-label">Partner <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" id="partner_details_<?php echo ($dir_cnt+1).'_id'; ?>" name="partner_name[]" class="form-control" value="<?php if(isset($llp_partner[$dir_cnt]->llp_partnerid)){ echo $llp_partner[$dir_cnt]->llp_partnerid; } else { echo ''; }?>" />
                                                <input type="text" id="partner_details_<?php echo ($dir_cnt+1); ?>" name="partner_details[]" class="form-control auto_owner partnership" value="<?php if(isset($llp_partner[$dir_cnt]->c_name)){ echo $llp_partner[$dir_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
											</div>
                                            </div>
                                            <div class="col-md-6">
											 <label  style="padding:10px 5px;"  > % </label> 
                                                <input type="text" class="form-control" id="partner_percent_<?php echo ($dir_cnt+1); ?>" name="partner_percent[]" placeholder="Partnership %" value="<?php echo $llp_partner[$j]->llp_percent; ?>" style="width:90%; float:left;"/> 
                                            </div>
                                        </div>
                                        <?php $dir_cnt++; } } else { ?>

                                        <div class="form-group" id="llp_partner_<?php echo ($dir_cnt+1); ?>" style="border-top:0px dotted #ddd;">
										 <div class="col-md-6">
                                            <div class="col-md-3"  >
                                                <label class="col-md-12 control-label"   >Partner 1 <span class="asterisk_sign">*</span></label>

                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" id="partner_details_<?php echo ($dir_cnt+1) . '_id'; ?>" name="partner_name[]" class="form-control" value="" />
                                                <input type="text" id="partner_details_<?php echo ($dir_cnt+1); ?>" name="partner_details[]" class="form-control auto_owner partnership" value="" placeholder="Type to choose owner from database..." />
											 </div>
                                            </div>
                                            <div class="col-md-6">
											 <label  style="padding:10px 5px;"  > % </label> 
                                                <input type="text" class="form-control" id="partner_percent_<?php echo ($dir_cnt+1); ?>" name="partner_percent[]" placeholder="Partnership %" style="width:90%; float:left;"/> 
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                 
                                      
                                            <div class="col-md-12 btn-margin">
                                                <div class="6">                                                        
                                                    <button type="button" class="btn btn-success repeat-llp-partner"  name="addhufbtn">+</button>
                                                    <button type="button" class="btn btn-success reverse-llp-partner" style="margin-left: 10px;">-</button>
                                                </div>
                                            </div>
                                    
                                    </div>
                                        
                                        
                                    <div class="panel-heading"  >
                                        <h3 class="panel-title">Documents</h3>
                                        
                                    </div>
                                    <div class="panel-body">
                                    <!-- <div class="llpdoc">
                                    <?php //$this->load->view('owners/owner_document');?>
                                    </div>
                                    <br> -->
                                    <?php $this->load->view('templates/document');?>
                                                
                                                <div class="col-md-12 btn-margin">                                                        
                                                    <!-- <button type="button" class="btn btn-success repeat-llp-doc" style="margin-left: 80px;" name="addhufbtn">+</button>
                                                    <button type="button" class="btn btn-success reverse-llp-doc" style="margin-left: 10px;">-</button> -->
                                                    <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                                    <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
                                                </div>
                                     
                                    </div>
                                        
                                        
                                    <div class="panel-heading"  >
                                        <h3 class="panel-title">Authorised Signatory</h3>
                                        
                                    </div>
                                    <div class="panel-body box-padding">
                                        <div class="llpsign">
                                            <?php $aut_sig_cnt=0; if(isset($llp_auth)) { 
                                                for($j=0; $j < count($llp_auth); $j++ ) {
                                                    ?>

                                            <div class="form-group" id="llp_sign_<?php echo ($aut_sig_cnt+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
                                            <div class="col-md-6">
                                                <div class="col-md-4"  >
                                                    <label class="col-md-12 control-label">Authorised Signatory  <?php echo ($j+1); ?></label>

                                                </div>
                                                <div class="col-md-8">
                                                    <input type="hidden" id="auth_details_<?php echo ($aut_sig_cnt+1).'_id'; ?>" name="auth_name[]" class="form-control" value="<?php if(isset($llp_auth[$aut_sig_cnt]->llp_contactid)){ echo $llp_auth[$aut_sig_cnt]->llp_contactid; } else { echo ''; }?>" />
                                                    <input type="text" id="auth_details_<?php echo ($aut_sig_cnt+1); ?>" name="auth_details[]" class="form-control auto_owner" value="<?php if(isset($llp_auth[$aut_sig_cnt]->c_name)){ echo $llp_auth[$aut_sig_cnt]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
												</div>
                                            </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php echo $llp_auth[$j]->llp_purpose; ?>" />
                                                </div>
                                            </div>

                                            <?php $aut_sig_cnt++; }} else { ?>

                                             <div class="form-group" id="llp_sign_<?php echo ($aut_sig_cnt+1); ?>" style="border-top: 1px dotted #ddd;">
                                                 <div class="col-md-6">
                                                    <div class="col-md-4">
                                                        <label class="col-md-12 control-label">Authorised Signatory 1</label>

                                                    </div>
                                                    <div class="col-md-8">
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
                                                        <button type="button" class="btn btn-success repeat-llp-sign"   name="addhufbtn">+</button>
                                                        <button type="button" class="btn btn-success reverse-llp-sign" style="margin-left: 10px;">-</button>
                                                    </div>
                                        
                                    </div>
                                        

                                    <div class="panel-heading"  >
                                        <h3 class="panel-title">Remark</h3>
                                    </div>
                                    <div class="panel-body">
									<div class="remark-container">
                                             <div class="form-group" style="background: none;border:none">
                                        <div class="col-md-12">
                                          <!--  <label class="col-md-1 control-label">Remark</label>-->
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="ow_maker_remark" name="ow_maker_remark" rows="2" placeholder="Remark"><?php if(isset($llp_detail)){ echo $llp_detail[0]->ow_maker_remark;}?></textarea>
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
                                        <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
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
                                                                <label class="col-md-2 control-label">Email ID <span class="asterisk_sign">*</span></label>
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
            var counter = <?php if(isset($llp_partner)) { echo count($llp_partner); } else { echo '1'; } ?>;
            $('.repeat-llp-partner').click(function(event){
                event.preventDefault();
                counter++;

                var newRow = jQuery('<div class="form-group" id="llp_partner_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-3"><label class="col-md-12 control-label">Partner '+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-9"><input type="hidden" id="partner_details_'+counter+'_id" name="partner_name[]" class="form-control" value="" /><input type="text" id="partner_details_'+counter+'" name="partner_details[]" class="form-control auto_owner partnership" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><label  style="padding:5px;"  > % </label> <input type="text" class="form-control" id="partner_percent_'+counter+'" name="partner_percent[]" placeholder="Partnership %" style="width:90%; float:left;"/>  </div></div>');
                $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

                $('.llppartner').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-llp-partner').click(function(event){
                if(counter!=1){
                    var id="#llp_partner_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                }
            });
        });

        // jQuery(function(){
        //     var counter = $('input.doc_file').length;
        //     $('.repeat-llp-doc').click(function(event){
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
        //         $('.llpdoc').append(newRow);
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
        //     $('.reverse-llp-doc').click(function(event){
        //         var id="#repeat_doc_"+(counter-1).toString();
        //         if($(id).length>0){
        //             $(id).remove();
        //             counter--;
        //         }
        //     });
        // });

        jQuery(function(){
            var counter = <?php if(isset($llp_auth)) { echo count($llp_auth); } else { echo '1'; } ?>;
            $('.repeat-llp-sign').click(function(event){
                event.preventDefault();
                counter++;

                var newRow = jQuery('<div class="form-group" id="llp_sign_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class="col-md-4" style="padding-right: 0;padding-left:0;"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-8"><input type="hidden" id="auth_details_'+counter+'_id" name="auth_name[]" class="form-control" value="" /><input type="text" id="auth_details_'+counter+'" name="auth_details[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." /></div></div><div class="col-md-6"><input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS"/></div></div>');
                $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);

                $('.llpsign').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-llp-sign').click(function(event){
                if(counter!=1){
                    var id="#llp_sign_"+(counter).toString();
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
            addMultiInputNamingRules('#form_llp', '.doc_name', { required:function(element) {
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

            addMultiInputNamingRules('#form_llp', 'input[name="partner_details[]"]', { required: function(element) {
                                                            if($("#submitVal").val()=="0"){
                                                                return true;
                                                            } else {
                                                                return false;
                                                            }
                                                        }, 
                                                    messages: {required: "Select correct owner from list"}
                                        }, "");
            addMultiInputNamingRules('#form_llp', 'input[name="partner_percent[]"]', { required: function(element) {
                                                            if($("#submitVal").val()=="0"){
                                                                return true;
                                                            } else {
                                                                return false;
                                                            }
                                                        },
                                                        numbersonly: true
                                        }, "");
        });
    </script>
    </body>
</html>