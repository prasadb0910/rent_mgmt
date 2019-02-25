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
		<style>
			.panel-body .form-group{ padding-right:10px;}
			@media screen and (max-width: 767px) { 
				.custom-padding .col-md-11{ width:100%!important;} 
			 	.custom-padding .col-md-1{ width:100%!important; text-align:left;}
			}
			input[readonly]{
				/*background-color: #fff!important;*/
				color: #0aab4b!important;
			}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details - Individual</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">					
					<div class="main-container"> 
					 <div class="box-shadow custom-padding">  
						
                      
						 
							<div class="" id="individual">
								<form id="form_individual" role="form" class="form-horizontal" method="post" action="<?php if(isset($indi)) { echo base_url().'index.php/owners/updateindividualrecord/'.$o_id; } else {echo base_url().'index.php/owners/saveindividualrecord'; } ?>">
								     <div class="box-shadow-inside">
								  <div class="col-md-12" style="padding:0;">
					   	<div class="panel panel-default border-none">
									<div class="panel-body">
										<div class="form-group" style="border-top: 1px dotted #ddd;">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Owner Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" id="individual_client" name="individual_client" data-error="#individual_client_error" class="form-control" value="<?php if (set_value('individual_client')!=null) { echo set_value('individual_client'); } else if(isset($indi[0]->ow_ind_id)){ echo $indi[0]->ow_ind_id; } else { echo ''; }?>" />
                                                		<input type="text" id="individual_client_name" name="individual_client_name"  class="form-control auto_client_for_owner" value="<?php if (set_value('individual_client_name')!=null) { echo set_value('individual_client_name'); } else if(isset($editcontact[0]->c_name)){ echo $editcontact[0]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
														<div id="individual_client_error"></div>
													</div>
												</div>
											</div>
											<!-- <div class="col-md-6">
												<div class="col-md-4">
													<button type="button" class="btn btn-info mb-control sch" data-box="#message-box-info"> +</button>
												</div>
												<div class="col-md-8">
													&nbsp;
												</div>
											</div> -->
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Gender</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_gender" id="ind_gender" placeholder="Gender" value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_gender; } ?>" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Designation</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_designation" id="ind_designation" placeholder="Designation"  value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_designation; } ?>" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Email ID1</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_email_id1" id="ind_email_id1" placeholder="Email ID1"  value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Email ID2</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_email_id2" id="ind_email_id2" placeholder="Email ID2"  value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_emailid2; } ?>" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Mobile No1</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_mobile_no1" id="ind_mobile_no1" placeholder="Mobile No1" value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?>" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Mobile No2</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_mobile_no2" id="ind_mobile_no2" placeholder="Mobile No2" value="<?php if(isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?>" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<div class="">
													<label class="col-md-1 control-label"style="width:12.2%" >Remark</label>
													<div class="col-md-11" style="width:87.8%" >
														<textarea class="form-control" name="ow_maker_remark" id="ow_maker_remark" rows="2" placeholder="Remark"><?php if(isset($ow_maker_remark)) { echo $ow_maker_remark; } ?></textarea>
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
	            						<a href="<?php echo base_url(); ?>index.php/owners" class="btn btn-danger" >Cancel</a>
	                                    <input type="submit" class="btn btn-success pull-right" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>"  />
	                                    <input type="submit" class="btn btn-success pull-right save-form"  name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
	                                </div>
									
									<!-- <div class="panel-footer">
										<a href="<?php //echo base_url(); ?>index.php/owners" class="btn btn-default">Cancel</a>
										<button class="btn btn-primary pull-right">Save</button>
									</div> -->
								</form>

								<!-- start contact popup -->
	                            <form id="contact_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
									<div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
		                                <div class="mb-container" style="background:#fff;">
		                                    <div class="mb-middle">
												<div class="mb-title" style="color:#000;text-align:center;">Add Contact</div>
												<div class="mb-content">
													<div class="form-group" style="border-top: 1px dotted #ddd;">
														<label class="col-md-2 control-label" style="width: 12.5%;color: black;padding-left: 0px;">Full Name</label>
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
													<div class="form-group">
														<div class="col-md-12">
															<label class="col-md-2 control-label" style="width: 12.5%;color: black;">Email ID</label>
															<div class="col-md-4">
																	<input type="text" id="con_email_id1" class="form-control" name="con_email_id1" placeholder="Email ID"/>
															</div>
															<label class="col-md-2 control-label" style="width: 12.5%;color: black;padding-left: 0px;">Mobile No</label>
															<div class="col-md-5">
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

        <script type="text/javascript">
        	function loadclientdetail(){
        		var clientid = document.getElementById("individual_client").value;
        		var xmlhttp=new XMLHttpRequest();
        		xmlhttp.onreadystatechange = function() {
        			if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
        				var data = JSON.parse(xmlhttp.responseText);
        				document.getElementById('ind_gender').value = data['gender'];
        				document.getElementById('ind_designation').value = data['designation'];
        				document.getElementById('ind_email_id1').value = data['email1'];
        				document.getElementById('ind_email_id2').value = data['email2'];
        				document.getElementById('ind_mobile_no1').value = data['mobile1'];
        				document.getElementById('ind_mobile_no2').value = data['mobile2'];
        			}
        		};
        		xmlhttp.open("POST", "<?php echo base_url().'index.php/owners/loadselectedindividual/'; ?>" + clientid, true);
        		xmlhttp.send();
        	}
        </script>
        
        <script>
            $(function() {
                //autocomplete
                $(".auto_client_for_owner").autocomplete({

                        source: "<?php echo base_url() . 'index.php/owners/loadcontacts';?>",
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#individual_client").val(ui.item.value);
                                $("#ind_gender").val(ui.item.gender);
                                $("#ind_designation").val(ui.item.designation);
                                $("#ind_email_id1").val(ui.item.email1);
                                $("#ind_email_id2").val(ui.item.email2);
                                $("#ind_mobile_no1").val(ui.item.mobile1);
                                $("#ind_mobile_no2").val(ui.item.mobile2);

                        },
					    change: function(event, ui) {
					            var id = this.id;
					            $("#individual_client").val('');
					            $("#ind_gender").val('');
					            $("#ind_designation").val('');
					            $("#ind_email_id1").val('');
					            $("#ind_email_id2").val('');
					            $("#ind_mobile_no1").val('');
					            $("#ind_mobile_no2").val('');
					            var con_name = $(this).val();
								$(".save-form").prop("disabled",false);
					            if (con_name!="" && con_name!=null) {
					              $.ajax({
					                method:"GET",
					                url:"<?php echo base_url() . 'index.php/owners/loadcontacts';?>",
					                data:{term : con_name},
					                dataType:"json",
					                success:function(responsdata){
					                	$("#"+id).val(responsdata[0].label);
					                	$("#individual_client").val(responsdata[0].value);
		                                $("#ind_gender").val(responsdata[0].gender);
		                                $("#ind_designation").val(responsdata[0].designation);
		                                $("#ind_email_id1").val(responsdata[0].email1);
		                                $("#ind_email_id2").val(responsdata[0].email2);
		                                $("#ind_mobile_no1").val(responsdata[0].mobile1);
		                                $("#ind_mobile_no2").val(responsdata[0].mobile2);
					                }   
					              });
					            }
					    },
                        minLength: 1
                });
            });
    </script>
    
    <script>
		$("#save_contact").click(function(){
		    if ($("#contact_popup_form").valid()) {
		        var $result = 0;
		//            alert("success");
		        $.ajax({
		            url: BASE_URL+'index.php/contacts/saveContact',
		            data: $("#contact_popup_form").serialize(),
		            cache: false,
		            type: "POST",
		            dataType: 'html',
		            global: false,
		            async: false,
		            success: function (data) {
		//                    alert(data);
		                if ($.isNumeric($.trim(data))) {
		                    $result = 1;
		                } else {
		                    $result = 0;
		                }

		            },
		            error: function (data) {
		//                    alert(data);
		                $result = 0;
		            }
		        });

		        if ($result) {
		            $(this).parents(".message-box").removeClass("open");
		            $('#con_first_name').val('');
		            $('#con_middle_name').val('');
		            $('#con_last_name').val('');
		            $('#con_email_id1').val('');
		            $('#con_mobile_no1').val('');
		            $('#con_first_name, #con_middle_name, #con_last_name, #con_email_id1, #con_mobile_no1').removeClass('valid');
		            return false;
		        }
		        else {
		            return false;
		        }
		    }
		});
    </script>

    <!-- END SCRIPTS -->
    </body>
</html>