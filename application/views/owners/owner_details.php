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
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			.hide_panel {display:none;}
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top wrapper">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
							<div class="panel-heading">
								<h3 class="panel-title" ><strong>Owner Details</strong></h3>
								
							</div>
							
							<div class="panel-body">
								<div class="form-group">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-3 control-label">Category</label>
											<div class="col-md-9">
												<select class="form-control select" id="category" name="category">
												<option value="#select">Select</option>
												<option value="#individual">Individual</option>
												<option value="#huf">HUF</option>
												<option value="#private_limited">Private Limited</option>
												<option value="#limited">Limited</option>
												<option value="#llp">LLP</option>
												<option value="#partnership">Partnership</option>
												<option value="#aop">AOP</option>
												<option value="#trust">Trust</option>
												<option value="#proprietorship">Proprietorship</option>
												</select>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							
							<hr/>
							
							<div class="hide_panel" id="individual">
								<form id="form_individual" role="form" class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/owners/saveindividualrecord">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Client Name</label>
													<div class="col-md-9">                                                        
														<select class="form-control select" name="individual_client" onchange="loadclientdetail();" id="individual_client">
															<option>Select</option>
															<?php for ($i=0; $i < count($contact) ; $i++) { 
																echo "<option value=".$contact[$i]->c_id.">".$contact[$i]->c_Name."</option>";
															}?>
															
														</select>   
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Gender</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_gender" id="ind_gender" placeholder="Gender" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Designation</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_designation" id="ind_designation" placeholder="Designation" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Email ID1</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_email_id1" id="ind_email_id1" placeholder="Email ID1" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Email ID2</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_email_id2" id="ind_email_id2" placeholder="Email ID2" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Mobile No1</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_mobile_no1" id="ind_mobile_no1" placeholder="Mobile No1" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Mobile No2</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_mobile_no2" id="ind_mobile_no2" placeholder="Mobile No2" readonly/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">PAN</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_pan" id="ind_pan" placeholder="PAN" readonly/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Professional Tax No.</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="ind_prof_tax" id="ind_prof_tax" placeholder="Professional Tax No" readonly/>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-footer">
										<input class="btn btn-default" type="reset" id="reset" value="Clear Form">
										<button class="btn btn-primary pull-right">Submit</button>
									</div>
								</form>
							</div>
							
							<div class="hide_panel" id="huf">
								<form id="form_huf" role="form" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>index.php/owners/savehufrecord">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">HUF Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="huf_name" placeholder="HUF Name"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Date of Incorp</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="huf_doi" placeholder="Date of Incorporation"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="huf_address" placeholder="Address"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Karta Name</label>
													<div class="col-md-9">                                                        
														<select class="form-control" name="huf_karta_name">
															<option>Select</option>
															<?php for ($i=0; $i < count($contact) ; $i++) { 
																echo "<option value='". $contact[$i]->c_id."''>".$contact[$i]->c_Name."</option>";
															}?>
															
														</select>   
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-4">
													<a class="btn btn-success btn-block" href="<?php echo base_url().'index.php/contacts/addnew/owners_huf'; ?>">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
												<div class="col-md-8">
													&nbsp;
												</div>
											</div>
										</div>
										<div class="huf">
											<div class="form-group">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Family Details</label>
														<div class="col-md-9">                                                        
															<select class="form-control" name="family_details[]">
																<option>Select</option>
																<?php for ($i=0; $i < count($contact) ; $i++) { 
																	echo "<option value='". $contact[$i]->c_id."''>".$contact[$i]->c_Name."</option>";
																}?>
															</select>   
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Relation</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="relation[]" placeholder="Relation"/>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<div class="col-md-3">&nbsp;</div>
													<div class="col-md-9">                                                        
														<br><button class="btn btn-success repeat-huf" style="margin-left: 10px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="addkyc">
										<?php 
											for($i=0; $i < count($hufdocs); $i++) {
										?>
										<div class="form-group">
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="huf_doc_name[]" placeholder=""  value="<?php if(isset($editcontact)){ echo $editcontact[$i]->kyc_doc_name; } else { echo $hufdocs[$i]->d_documentName; } ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="huf_doc_desc[]" placeholder=""  value="<?php if(isset($editcontact)){ echo $editcontact[$i]->kyc_doc_name; } else { echo $hufdocs[$i]->d_description; } ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="huf_ref_no[]" placeholder="Reference No" value="<?php if(isset($editcontdoc)) {echo $editcontdoc[$i]->kyc_doc_ref;} ?>"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="huf_date_issue[]" placeholder="Date of Issue" value="<?php if(isset($editcontdoc)) {echo $editcontdoc[$i]->kyc_doc_issuedate;} ?>"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="huf_date_expiry[]" placeholder="Date of Expiry" value="<?php if(isset($editcontdoc)) {echo $editcontdoc[$i]->kyc_doc_expirydate;} ?>"/>
													</div>
												</div>
											</div>
											<div class="col-md-1">
												<div class="form-group">
													<div class="col-md-12">
														<input type="file" class="fileinput btn-primary" name="doc_<?php echo $i; ?>" id="photograph" title="Browse file"/>
													</div>
													<?php if(isset($editcontdoc)) {
														echo "<a href='".base_url()."downloads/client/". $c_id."/".$i."'/>Download</a>";
													} ?>
												</div>
											</div>
										</div>
										<?php } ?>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-9">                                                        
														<br><button class="btn btn-success repeat-huf-doc" style="margin-left: 10px;" name="addhufbtn">+</button>
													</div>
													<div class="col-md-3">&nbsp;</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
									</div>
									
									<div class="panel-footer">
										<input class="btn btn-default" type="reset" id="reset" value="Clear Form">
										<button class="btn btn-primary pull-right">Submit</button>
									</div>
								</form>
							</div>
							
							<div class="hide_panel" id="private_limited">
								<form id="form_private_limited" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Company Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="company_name" placeholder="Company Name"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Date of Incorp</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="date_of_incorporation" placeholder="Date of Incorporation"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Registered Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_address" placeholder="Registered Address"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Branch Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="branch_address" placeholder="Branch Address"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Telephone Number</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Contact Person</label>
													<div class="col-md-9">                                                        
														<select class="form-control">
															<option>Select</option>
															<option>Dmitry Ivaniuk</option>
															<option>Nadia Ali</option>
															<option>John Doe</option>
															<option>Darth Vader</option>
															<option>Brad Pitt</option>
														</select>   
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-4">
													<a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
												<div class="col-md-8">
													&nbsp;
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Director Details</h3>
											
										</div>
										<div class="panel-body">
										<div class="pvtltd">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Director 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-6">                                                        
														<br><button class="btn btn-success repeat-pvtltd" style="margin-left: 80px;" name="addhufbtn">+</button>
													</div>
													
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Shareholder Details</h3>
											
										</div>
										<div class="panel-body">
										<div class="sharepvtltd">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Share Holder 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-pvtltd-share" style="margin-left: 54px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Documents</h3>
											
										</div>
										<div class="panel-body">
										<div class="pvtltddoc">
										<div class="form-group">
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="" value="PAN" />
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<select id="category" class="form-control select" >
														<option>ID Proof</option>
														<option>Address Proof</option>
														<option>Others</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Reference No"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Issue"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file"/>
													</div>
												</div>
											</div>
										</div>
										</div>
										
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-pvtltd-doc" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Authorised Signatory</h3>
											
										</div>
										<div class="panel-body">
										<div class="pvtltdsign">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Authorised Signatory 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
												
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-pvtltd-sign" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-footer">
										<input class="btn btn-default" type="reset" id="reset" value="Clear Form">
										<button class="btn btn-primary pull-right">Submit</button>
									</div>
								</form>
							</div>
							
							
							<div class="hide_panel" id="llp">
								<form id="form_llp" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Organisation Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="organisation_name" placeholder="Organisation Name"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Date of Incorp</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="date_of_incorporation" placeholder="Date of Incorporation"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Registered Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_address" placeholder="Registered Address"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Branch Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="branch_address" placeholder="Branch Address"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Telephone Number</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Contact Person</label>
													<div class="col-md-9">                                                        
														<select class="form-control">
															<option>Select</option>
															<option>Dmitry Ivaniuk</option>
															<option>Nadia Ali</option>
															<option>John Doe</option>
															<option>Darth Vader</option>
															<option>Brad Pitt</option>
														</select>   
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-4">
													<a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
												<div class="col-md-8">
													&nbsp;
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Partnership Details</h3>
											
										</div>
										<div class="panel-body">
										<div class="llppartner">
											<div class="form-group">
												<div class="col-md-1" style="padding-right: 0px;">
													<label class="col-md-12 control-label">Partner 1</label>
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Partnership %"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-llp-partner" style="margin-left: 7px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
										</div>
										
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Documents</h3>
											
										</div>
										<div class="panel-body">
										<div class="llpdoc">
										<div class="form-group">
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="" value="PAN" />
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<select id="category" class="form-control select" >
														<option>ID Proof</option>
														<option>Address Proof</option>
														<option>Others</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Reference No"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Issue"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file"/>
													</div>
												</div>
											</div>
										</div>
										</div>
										
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-llp-doc" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										</div>
										
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Authorised Signatory</h3>
											
										</div>
										<div class="panel-body">
										<div class="llpsign">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Authorised Signatory 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
												
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-llp-sign" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-footer">
										<input class="btn btn-default" type="reset" id="reset" value="Clear Form">
										<button class="btn btn-primary pull-right">Submit</button>
									</div>
								</form>
							</div>
							
							
							<div class="hide_panel" id="trust">
								<form id="form_private_limited" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Trust Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="trust_name" placeholder="Trust Name"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Date of Incorp</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="date_of_incorporation" placeholder="Date of Incorporation"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Registered Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_address" placeholder="Registered Address"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Branch Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="branch_address" placeholder="Branch Address"/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Telephone Number</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number"/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Contact Person</label>
													<div class="col-md-9">                                                        
														<select class="form-control">
															<option>Select</option>
															<option>Dmitry Ivaniuk</option>
															<option>Nadia Ali</option>
															<option>John Doe</option>
															<option>Darth Vader</option>
															<option>Brad Pitt</option>
														</select>   
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-4">
													<a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
												<div class="col-md-8">
													&nbsp;
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Trustee Details</h3>
											
										</div>
										<div class="panel-body">
										<div class="trustdetails">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Trustee 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-trust" style="margin-left: 80px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
										</div>
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Beneficiary Details</h3>
											
										</div>
										<div class="panel-body">
										<div class="trustshare">
											<div class="form-group">
												<div class="col-md-1" style="padding-left:0px">
													<label class="col-md-12 control-label" style="padding-left: 0px;padding-right: 0px;">Beneficiary 1</label>
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-trust-share" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
										</div>
										
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Documents</h3>
											
										</div>
										<div class="panel-body">
										<div class="trustdoc">
										<div class="form-group">
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="" value="PAN" />
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<select id="category" class="form-control select" >
														<option>ID Proof</option>
														<option>Address Proof</option>
														<option>Others</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Reference No"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Issue"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<div class="col-md-12">
														<input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file"/>
													</div>
												</div>
											</div>
										</div>
										</div>
										
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
													
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-trust-doc" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										</div>
										
										
										<div class="panel-heading" style="padding-bottom:0px;padding-top:0px;">
											<h3 class="panel-title">Authorised Signatory</h3>
											
										</div>
										<div class="panel-body">
										<div class="trustsign">
											<div class="form-group">
												<div class="col-md-2">
													<label class="col-md-12 control-label">Authorised Signatory 1</label>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="dname" placeholder="Name"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dmobile" placeholder="Mobile"/>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" name="demail" placeholder="Email ID"/>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="form-group">
												
													<div class="col-md-12">                                                        
														<br><button class="btn btn-success repeat-trust-sign" style="margin-left: 0px;" name="addhufbtn">+</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-8">
													&nbsp;
												</div>
												<div class="col-md-4">
													<br><a class="btn btn-success btn-block" href="contact_details.html">
														<span class="fa fa-plus"></span> Add Contact
													</a>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-footer">
										<input class="btn btn-default" type="reset" id="reset" value="Clear Form">
										<button class="btn btn-primary pull-right">Submit</button>
									</div>
								</form>
							</div>
							
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
						
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="<?php echo base_url(); ?>audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="<?php echo base_url(); ?>audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->                

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/highlight/jquery.highlight-4.js"></script>
		
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="js/settings.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/faq.js"></script>
        <!-- END TEMPLATE -->
		
		<script>
			jQuery(function(){
    var counter = 1;
    $('.repeat-huf').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-6"><div class="form-group"><label class="col-md-3 control-label">Family Details</label><div class="col-md-9"><select class="form-control" name="family_details[]"><option>Select</option><?php for ($i=0; $i < count($contact) ; $i++) { echo '<option value="'. $contact[$i]->c_id.'">'.$contact[$i]->c_Name.'</option>';}?></select></div></div></div><div class="col-md-6"><div class="form-group"><label class="col-md-3 control-label">Relation</label><div class="col-md-9"><input type="text" class="form-control" name="relation[]" placeholder="Relation"/></div></div></div></div>');
        $('.huf').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-huf-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_doc_name[]" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_doc_desc[]" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_ref_no[]" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_date_issue[]" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_date_expiry[]" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="doc_'+counter+'" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.addkyc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Director '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-3"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div></div>');
        $('.pvtltd').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-share').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Share Holder '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/></div></div>');
        $('.sharepvtltd').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.pvtltddoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.pvtltdsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-partner').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-1" style="padding-right: 0px;"><label class="col-md-12 control-label">Partner '+counter+'</label></div><div class="col-md-4"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Partnership %"/></div></div>');
        $('.llppartner').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.llpdoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.llpsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Trustee '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-3"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div></div>');
        $('.trustdetails').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-share').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-1" style="padding-left: 0px;"><label class="col-md-12 control-label" style="padding-left: 0px;padding-right: 0px;">Beneficiary '+counter+'</label></div><div class="col-md-4"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/></div></div>');
        $('.trustshare').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.trustdoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.trustsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});
		</script>
		
		<script type="text/javascript">
            /*var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        group_name: {
                                required: true
                        },
						status: {
                                required: true
                        },
						contact: {
                                required: true
                        },
						designation: {
                                required: true
                        }
                    }                                        
                });
			$('#reset').click(function(){
				$('#jvalidate')[0].reset();
			 });*/
			$("#category").change(function() {
				$('#individual').slideUp();
				$('#huf').slideUp();
				$('#private_limited').slideUp();
				
				$('#llp').slideUp();
				$('#partnership').slideUp();
				$('#aop').slideUp();
				$('#trust').slideUp();
				var panelId = $('#category').val();
				if(panelId=="#limited") {
					panelId="#private_limited";
				}
				if(panelId=="#partnership" || panelId=="#aop") {
					panelId="#llp";
				}
				if(panelId=="#select"){
					$('#category').hide();
				}
				$(panelId).delay(10).fadeIn();
			});
        </script>

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
    <!-- END SCRIPTS -->      
    </body>
</html>