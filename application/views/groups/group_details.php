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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/software-details.css'; ?>"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		

		

        <style type="text/css">
  #document_details { padding: 10px;}  

.delete-btn a{ font-size:25px;  color: #333;  }
.delete-btn a:hover { color: #e90404; }

.delete_row  {font-size:25px; color: #333;   }
.delete_row:hover { color: #e90404;  }

.download-btn a{     font-size:25px;  color: #333;  }
.download-btn a:hover { color: #1caf9a; }
.btn-margin { padding: 10px 0px!important;    }
.table {  width: 100%;   max-width: 100%;  margin-bottom:0px;}
 @media only screen and  (min-width:250px)  and (max-width:500px) { .custom-padding .col-md-6{ padding-top:10px;} }
</style>

    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
           <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>                    
                      <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/groups'; ?>" > Group Master List</a>  &nbsp; &#10095; &nbsp; Add Group</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
                    <div class="main-container">           
                         <div class="box-shadow" style="padding-top:10px;">  
					
					
                     
                            <form id="form_group" role="form" method="post" class="form-horizontal" action="<?php if(isset($redirect)) { echo base_url().'index.php/Groups/save_Group/'.$redirect; } else { if(isset($group_id)){echo base_url().'index.php/Groups/saveEdit/'.$group_id;} else {echo base_url().'index.php/Groups/save_Group';} }?>">
                              <!--   <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align: center;float: initial"><strong><?php if(isset($group)) { ?>Edit Group<?php } else { ?>Add Group<?php } ?></strong></h3>
                                    
                                </div> -->
                                 <div class="box-shadow-inside">
                                   <div class="col-md-12 custom-padding">
					         	<div class="panel panel-default">
	                                <div class="panel-body">
											<div class="form-group" style="background:none; border:none;">
												<div class="col-md-6"  >
													<label class="col-md-3 control-label">Group Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" class="form-control" id="group_id" name="group_id" value="<?php if(isset($group_id)){ echo $group_id;} ?>"/>
														<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter Group Name" value="<?php if(isset($group)){ echo $group[0]->group_name;} ?>"/>
													</div>
												</div>
												<?php if(isset($group)) { ?>
												<div class="col-md-6">
													
														<label class="col-md-3 control-label">Status <span class="asterisk_sign">*</span></label>
														<div class="col-md-9">
														<select class="form-control" name="group_status">
														
														<option value="Active" <?php if(isset($group)){ if($group[0]->group_status=='Active') echo 'selected';} ?>>Active</option>
														<option value="InActive" <?php if(isset($group)){ if($group[0]->group_status=='InActive') echo 'selected';} ?>>InActive</option>
														</select>
															
														</div>
													
												</div>
										<?php	} ?>
											</div>
	                                </div>
								
								<!-- START DATATABLE -->
								<div class="panel-heading">
									 <h3 class="panel-title"> <span class="fa fa-pencil "> </span>  User-Owner (shall have Admin right)</h3> 
								</div>
									<div class="panel-body" >
										<div class="row">
											<div class="panel-body">
												<div class="table-responsive">
													<table id="contacts" class="table group table-bordered">
														<thead>
															<tr>
																<th width="54" align="center">Sr. No.</th>
																<th>First Name <span class="asterisk_sign">*</span></th>
																<th>Last Name <span class="asterisk_sign">*</span></th>
																<th>Designation</th>
																<th>Mobile <span class="asterisk_sign">*</span></th>
																<th>Email ID <span class="asterisk_sign">*</span></th>
																<th style="text-align:center; width:50px" >Delete</th>
															</tr>
														</thead>
														<tbody>
														    <?php $gusr=0;?>
														    <?php if(isset($group)){ $abc=0; for ($i=0; $i < count($contact) ; $i++) { ?>
																<tr align="center"id="repeat_group_admin_<?php echo $i+1; ?>">
																	<td style="text-align:center;" ><?php if(isset($group)){ echo ($i+1) ;} else {echo '1';} ?></td>
																	<td><input type="hidden" name="groupuserid[]" id="groupuserid_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_id;} ?>"/>
																		<input type="text" name="groupusername[]" id="groupusername_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_name;} ?>"/></td>
																	<td><input type="text" name="groupuserlastname[]" id="groupuserlastname_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_last_name;} ?>"/></td>
																	<td><input type="text" name="groupdesignation[]" id="groupdesignation_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_designation;} ?>"/></td>
																	<td><input type="text" name="groupmobile[]" id="groupmobile_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_mobile1;} ?>"/></td>
																	<td><input type="hidden" id="groupemailactual_<?php echo $i+1; ?>" class="form-control" value="<?php if(isset($group)){ echo $contact[$i]->c_emailid1;} ?>" />
																		<input type="text" name="groupemail[]" id="groupemail_<?php echo $i+1; ?>" class="form-control useremail" value="<?php if(isset($group)){ echo $contact[$i]->c_emailid1;} ?>" /></td>
																	<td style="text-align:center;"><a href="#" title="Delete" id="repeat_group_admin_<?php echo $i+1; ?>_delete" class="delete_row" > <i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
																</tr>
															<?php }} else { ?>
																<tr id="repeat_group_admin_1">
																	<td align="center">1</td>
																	<td><input type="hidden" name="groupuserid[]" id="groupuserid_1" class="form-control"/>
																		<input type="text" name="groupusername[]" id="groupusername_1" class="form-control"/></td>
																	<td><input type="text" name="groupuserlastname[]" id="groupuserlastname_1" class="form-control"/></td>
																	<td><input type="text" name="groupdesignation[]" id="groupdesignation_1" class="form-control" /></td>
																	<td><input type="text" name="groupmobile[]" id="groupmobile_1" class="form-control" /></td>
																	<td><input type="hidden" id="groupemailactual_1" class="form-control" />
																		<input type="text" name="groupemail[]" id="groupemail_1" class="form-control useremail" /></td>
																	<td style="text-align:center;" ><a class="delete_row"  title="Delete" id="repeat_group_admin_1_delete"  href="#"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												
													<div class="row btn-margin">
														<input type="button" class="btn btn-success repeat"  value="+" onclick="" />
			                                          <button type="button" class="btn btn-success reverse-group-admin" style="margin-left: 10px;">-</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								<!-- END DEFAULT DATATABLE -->
								
								
									<div class="panel-heading">
										<h3 class="panel-title">  <span class="fa fa-pencil "> </span> User-Contact</h3>
									</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table group1 table-bordered">
											<thead>
												<tr>
													<th width="54" align="center">Sr. No.</th>
													<th>Name <span class="asterisk_sign">*</span></th>
													<th>Role <span class="asterisk_sign">*</span></th>
													<th style="text-align:center; width:50px;">Delete</th>
												</tr>
											</thead>
											<tbody>
												<?php $gusr=0;?>
											    <?php if(isset($group_users)){ $abc=0; for ($j=0; $j < count($group_users) ; $j++) { ?>
													<tr id="repeat_group_user_<?php echo $j+1; ?>">
														<td><?php if(isset($group)){ echo ($j+1) ;} else {echo '1';} ?></td>
														<td>
														<input type="hidden" name="gu_id[]" id="guid_<?php echo $j+1; ?>" value="<?php echo $group_users[$j]->gu_id; ?>" />
														<select class="form-control selusername" name="userid[]" id="userid_<?php echo $j+1; ?>">
															<option value="">Select</option>
															<?php for($i=0; $i<count($contacts); $i++) { ?>
																<option value="<?php echo $contacts[$i]->c_id; ?>" <?php if ($group_users[$j]->gu_cid==$contacts[$i]->c_id) {echo 'selected';}; ?>><?php echo $contacts[$i]->c_name . ' ' . $contacts[$i]->c_last_name . ' - ' . $contacts[$i]->c_emailid1 . ' - ' . $contacts[$i]->c_mobile1; ?></option>
															<?php } ?>
														</select></td>
														<td><select class="form-control seluserrole" name="userroleid[]" id="userroleid_<?php echo $j+1; ?>">
															<option value="">Select</option>
															<?php for($i=0; $i<count($roles); $i++) { ?>
																<option value="<?php echo $roles[$i]->rl_id; ?>" <?php if ($group_users[$j]->assigned_role==$roles[$i]->rl_id) {echo 'selected';}; ?>><?php echo $roles[$i]->role_name; ?></option>
															<?php } ?>
														</select></td>
														<td style="text-align:center"><a href="#" id="repeat_group_user_<?php echo $j+1; ?>_delete" class="delete_row" >
														<i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
													</tr>
												<?php }} else { ?>
													<tr id="repeat_group_user_1">
														<td align="center">1</td>
														<td><input type="hidden" name="gu_id[]" id="guid_1" value="" />
															<select class="form-control selusername" name="userid[]" id="userid_1">
															<option value="">Select</option>
															<?php for($i=0; $i<count($contacts); $i++) { ?>
																<option value="<?php echo $contacts[$i]->c_id; ?>"><?php echo $contacts[$i]->c_name . ' ' . $contacts[$i]->c_last_name . ' - ' . $contacts[$i]->c_emailid1 . ' - ' . $contacts[$i]->c_mobile1; ?></option>
															<?php } ?>
														</select></td>
														<td><select class="form-control seluserrole" name="userroleid[]" id="userroleid_1">
															<option value="">Select</option>
															<?php for($i=0; $i<count($roles); $i++) { ?>
																<option value="<?php echo $roles[$i]->rl_id; ?>"><?php echo $roles[$i]->role_name; ?></option>
															<?php } ?>
														</select></td>
														<td style="text-align:center;" ><a id="repeat_group_user_1_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
										<div class="row btn-margin">
											<button type="button" class="btn btn-success repeat1" style="">+</button>
                                            <button type="button" class="btn btn-success reverse-group-user" style="margin-left: 10px;">-</button>
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
								<div class="row">
                                    <input type="submit" class="btn btn-success pull-right" value="Save" />
                                    <a class="btn btn-danger" id="reset" href="<?php echo base_url(); ?>index.php/groups" style="margin-right: 10px;">Cancel</a>
								</div>
								</div>
							</form>


							<!-- start contact popup -->
                            <form id="otp_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
                                <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
                                    <div class="mb-container" style="background:#fff;">
                                        <div class="mb-middle">
                                            <div class="mb-title" style="color:#000;text-align:center;">Enter OTP</div>
                                            <div class="mb-content">
                                                <div class="form-group" style="border: 1px dotted #ddd;">
                                                    <label class="col-md-2 control-label" style="width: 12.5%;color: black;padding-left: 0px;">OTP</label>
                                                    <div class="col-md-4">
                                                    	<input type="hidden" id="otp_email_id" name="otp_email_id" value="" />
                                                    	<input type="hidden" id="otp_check" name="otp_check" value="True" />
                                                        <input type="text" id="otp" class="form-control" name="otp" placeholder="Enter OTP" />
                                                    </div>
                                                    <button id="resend_otp" type="button" class="col-md-2 btn btn-primary" style="margin-right: 10px;">Resend OTP</button>
                                                    <label id="resend_otp_status" class="col-md-2 control-label" style=""></label>
                                                </div>
                                            </div>

                                            <div class="mb-footer">
                                                <button class="btn btn-danger mb-control-close">Cancel</button>
                                                <button id="check_otp" type="button" class="btn btn-primary pull-right">Check</button>
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
	    <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
		
		<script>
			function delete_row(elem){
				var id = elem.attr('id');
            	id = '#'+id.substr(0,id.lastIndexOf('_'));
                if($(id).length>0){
                    $(id).remove();
                }
			}

			jQuery(function(){
	            $('.delete_row').click(function(event){
	            	delete_row($(this));
	            });
			});

			jQuery(function(){
			    var counter = $('.useremail').length;
			    $('.repeat').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<tr id="repeat_group_admin_'+counter+'"><td align="center">'+counter+'</td> <td><input type="hidden" name="groupuserid[]" id="groupuserid_'+counter+'" class="form-control"/><input type="text" name="groupusername[]" id="groupusername_'+counter+'" class="form-control"/></td> <td><input type="text" name="groupuserlastname[]" id="groupuserlastname_'+counter+'" class="form-control"/></td> <td><input type="text" name="groupdesignation[]" id="groupdesignation_'+counter+'" class="form-control" /></td> <td><input type="text" name="groupmobile[]" id="groupmobile_'+counter+'" class="form-control" /></td> <td><input type="hidden" id="groupemailactual_'+counter+'" class="form-control" /><input type="text" name="groupemail[]" id="groupemail_'+counter+'" class="form-control useremail" /></td> <td style="text-align:center"><a id="repeat_group_admin_'+counter+'_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td> </tr>');
			        $('table.group').append(newRow);

		            $('.delete_row').click(function(event){
		            	delete_row($(this));
		            });
			    });
	            $('.reverse-group-admin').click(function(event){
	                while(counter>0){
	                	var id="#repeat_group_admin_"+(counter).toString();
		                if($(id).length>0){
		                    $(id).remove();
		                    counter--;
		                    break;
		                }
	                }
	            });
			});

			jQuery(function(){
			    var counter1 = $('.selusername').length;
			    $('.repeat1').click(function(event){
			        event.preventDefault();
			        counter1++;
			        var newRow = jQuery('<tr id="repeat_group_user_'+counter1+'"> <td align="center">' + counter1 + '</td> ' + 
			    							  '<td><input type="hidden" name="gu_id[]" id="guid_' + counter1 + '" value="" /> ' + 
			    							  '<select class="form-control selusername" name="userid[]" id="userid_'+counter1+'"> <option value="">Select</option> ' + 
			    							  '<?php for($i=0; $i<count($contacts); $i++) { ?> ' + 
			    							  	'<option value="<?php echo $contacts[$i]->c_id; ?>"><?php echo $contacts[$i]->c_name . " " . $contacts[$i]->c_last_name . ' - ' . $contacts[$i]->c_emailid1 . ' - ' . $contacts[$i]->c_mobile1; ?></option> ' +  
									  		  '<?php } ?> </select></td> ' +  
			    							  	'<td><select class="form-control seluserrole" name="userroleid[]" id="userroleid_'+counter1+'"> <option value="">Select</option> ' +  
										  	  '<?php for($i=0; $i<count($roles); $i++) { ?> <option value="<?php echo $roles[$i]->rl_id; ?>"> ' + 
			    							  	'<?php echo $roles[$i]->role_name; ?></option> ' +  
										  	  '<?php } ?> </select></td> ' + 
										  	  '<td style="text-align:center"><a id="repeat_group_user_'+counter1+'_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>');
			        $('table.group1').append(newRow);

		            $('.delete_row').click(function(event){
		            	delete_row($(this));
		            });
			    });

	            $('.reverse-group-user').click(function(event){
	                var id="#repeat_group_user_"+(counter1).toString();
	                if($(id).length>0){
	                    $(id).remove();
	                    counter1--;
	                }
	            });
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function() {
				addMultiInputNamingRules('#form_group', 'input[name="groupusername[]"]', { required: true, lettersonly: true });
				addMultiInputNamingRules('#form_group', 'input[name="groupuserlastname[]"]', { required: true, lettersonly: true });
				addMultiInputNamingRules('#form_group', 'input[name="groupmobile[]"]', { required: true, numbersonly: true });
				addMultiInputNamingRules('#form_group', 'input[name="groupemail[]"]', { required: true, checkemail: true });
			    addMultiInputNamingRules('#form_group', 'select[name="userid[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_group', 'select[name="userroleid[]"]', { required: true }, "");
				$('.selusername').each(function() {
                    var id = $(this).attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    $(this).rules("add", { required: function(element) {
                                                        return ($('#userroleid_'+index).val()!="" && $('#userroleid_'+index).val()!=null);
                                                    }
                                    });
                });
				$('.seluserrole').each(function() {
                    var id = $(this).attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    $(this).rules("add", { required: function(element) {
                                                        return ($('#userid_'+index).val()!="" && $('#userid_'+index).val()!=null);
                                                    }
                                    });
                });
			});
		</script>
    	<!-- END SCRIPTS -->      
    </body>
</html>