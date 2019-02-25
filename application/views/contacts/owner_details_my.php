<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
	    .a{
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
	    	cursor:default;
	    	font-size:14px;
	    	font-weight:500;
	    }
	    .remove{
	    	color:#d63b3b;
	    	text-align:right;
	    	cursor:default;
	    	margin-bottom: 10px;
	    	font-size:14px;
	    	font-weight:500;
	    }
	    .block1{
	    	padding: 20px 20px;
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
	    	cursor:default;
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
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content ">
	<form id="form_owner" role="form" method ="post" action="<?php if(isset($editcontact)) { echo base_url().'index.php/contacts/updateRecord/'.$c_id; } else { echo base_url().'index.php/contacts/saveRecord'; } ?>" enctype="multipart/form-data">
		<div class=" container-fluid container-fixed-lg">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Contacts/checkstatus/<?php if (isset($contact_type)) echo $contact_type; else if (isset($editcontact[0]->c_type)) echo $editcontact[0]->c_type; ?>/All">Contact List</a></li>
				<li class="breadcrumb-item active">HUF</li>
			</ol>
			<div class="row">
				<div class="col-md-4">
					<div class="col-lg-12">
						<div class="card card-default" style="background:#e6ebf1">
							<div class="card-header " style="background:#f6f9fc">
								<div class="card-title">
									Drag n' drop uploader
								</div><span><a href="#"><i class=" fa fa-trash pull-right" style="color:#d63b3b;font-size:18px;"></i></a></span>
							</div>
							<div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($editcontact)) echo base_url().$editcontact[0]->c_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
								<input type="file" name="image" id="image-upload" />
							</div>
							<div id="image-label_field">
								<label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class=" container-fluid  p-t-20 container-fixed-lg bg-white">
						<div class="card card-transparent">
							<div class="a">
								<div class="row clearfix">
									<div class="col-md-6">
										<input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if (isset($c_id)) { echo $c_id; } ?>">
                                    	<input type="hidden" class="form-control" name="type" id="type" value="<?php if (isset($contact_type)) echo $contact_type; else if (isset($editcontact[0]->c_type)) echo $editcontact[0]->c_type; ?>">
										<input type="hidden" class="form-control" name="owner_type" id="owner_type" value="<?php if (isset($owner_type)) echo $owner_type; else if (isset($editcontact[0]->c_owner_type)) echo $editcontact[0]->c_owner_type; ?>">
										<div class="form-group form-group-default required">
											<label>Company Name</label>
											<input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_company_name; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default ">
											<label>Registration No</label>
											<input type="text" class="form-control" name="reg_no" placeholder="Registration No" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_reg_no; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Date of Incorporation</label>
											<input type="text" class="form-control date" name="incop_date" placeholder="Date of Incorporation" value="<?php if(isset($editcontact)) { if($editcontact[0]->c_incop_date!='' && $editcontact[0]->c_incop_date!=null) echo date('d/m/Y', strtotime($editcontact[0]->c_incop_date)); } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2 required">
											<label>Contact Person</label>
											<select id="contact_id" name="contact_id" class="form-control full-width" data-placeholder="Select Contact Person" data-init-plugin="select2" data-error="#contact_id_error">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($editcontact)) { if($contact[$k]->c_id==$editcontact[0]->c_contact_id) { echo 'selected'; } } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="contact_id_error"></span>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Address</label>
											<input type="text" class="form-control" name="address" placeholder="Address" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_address; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Landmark </label>
											<input type="text" class="form-control" name="landmark" placeholder="Landmark" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_landmark; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>City </label>
											<input type="text" class="form-control" name="city" id ="con_add_city" placeholder="City" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_city; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Pincode </label>
											<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_pincode; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>State</label>
											<input type="text" class="form-control" name="state" id="con_add_state" placeholder="State" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_state; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Country </label>
											<input type="text" class="form-control" name="country" id="con_add_country" placeholder="Country" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_country; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Branch Address</label>
											<input type="text" class="form-control" name="branch_address" placeholder="Branch Address" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_branch; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Telephone No.</label>
											<input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_telephone; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Mobile No.</label>
											<input type="text" class="form-control" name="mob_number" placeholder="Mobile Number" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_mobile; } ?>"/>
										</div>
									</div>
								</div>
							</div>
							
	                        <div class="a" id="family-section" style="<?php if($owner_type!='huf') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Family Details<b></p>
	                                <div id="family_details">

	                                    <?php $l=0;
	                                    if(isset($editcontfam)) {
	                                    for($l=0; $l<count($editcontfam); $l++) { ?>

	                                    <div id="repeat_family_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Select Contact</label>
	                                                <select id="family_details_<?php echo $l+1; ?>" name="family[]" class="form-control family_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#family_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontfam[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="family_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Relation</label>
	                                                <input type="text" class="form-control" name="relation[]" placeholder="Relation"  value="<?php echo $editcontfam[$l]->relation; ?>" />
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_family_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_family_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Select Contact</label>
	                                                <select id="family_details_<?php echo $l+1; ?>_id" name="family[]" class="form-control family_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#family_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="family_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Relation</label>
	                                                <input type="text" class="form-control" name="relation[]" placeholder="Relation"/>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_family_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-family">+ Add Family</span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="director-section" style="<?php if($owner_type!='pvtltd' && $owner_type!='ltd') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Director Details<b></p>
	                                <div id="director_details">

	                                    <?php $l=0;
	                                    if(isset($editcontdir)) {
	                                    for($l=0; $l<count($editcontdir); $l++) { ?>

	                                    <div id="repeat_director_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Director <?php echo $l+1; ?></label>
	                                                <select id="director_details_<?php echo $l+1; ?>" name="director[]" class="form-control director_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#director_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontdir[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="director_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_director_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_director_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Director <?php echo $l+1; ?></label>
	                                                <select id="director_details_<?php echo $l+1; ?>" name="director[]" class="form-control director_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#director_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="director_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_director_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-director">+ Add Director </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="shareholder-section" style="<?php if($owner_type!='pvtltd' && $owner_type!='ltd') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Shareholder Details<b></p>
	                                <div id="shareholder_details">

	                                    <?php $l=0;
	                                    if(isset($editcontshr)) {
	                                    for($l=0; $l<count($editcontshr); $l++) { ?>

	                                    <div id="repeat_shareholder_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Share Holder <?php echo $l+1; ?></label>
	                                                <select id="shareholder_details_<?php echo $l+1; ?>" name="shareholder[]" class="form-control shareholder_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#shareholder_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontshr[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="shareholder_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Shareholder %</label>
	                                                <input type="text" class="form-control" id="shareholder_percent_<?php echo $l+1; ?>" name="shareholder_percent[]" placeholder="Shareholder %"  value="<?php echo $editcontshr[$l]->percent; ?>" />
	                                            </div>
	                                        </div>
	                                        <div class="col-md-3">
	                                            <div class="form-group form-group-default required">
	                                                <label>No Of Shares</label>
	                                                <input type="text" class="form-control" name="no_of_shares[]" placeholder="No Of Shares"  value="<?php echo $editcontshr[$l]->no_of_shares; ?>" />
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_shareholder_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_shareholder_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Share Holder <?php echo $l+1; ?></label>
	                                                <select id="shareholder_details_<?php echo $l+1; ?>" name="shareholder[]" class="form-control shareholder_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#shareholder_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="shareholder_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Shareholder %</label>
	                                                <input type="text" class="form-control" id="shareholder_percent_<?php echo $l+1; ?>" name="shareholder_percent[]" placeholder="Shareholder %"/>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-3">
	                                            <div class="form-group form-group-default required">
	                                                <label>No Of Shares</label>
	                                                <input type="text" class="form-control" name="no_of_shares[]" placeholder="No Of Shares"/>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_shareholder_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-shareholder">+ Add Shareholder</span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="partnership-section" style="<?php if($owner_type!='llp' && $owner_type!='partnership' && $owner_type!='aop') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Partnership Details<b></p>
                                <div id="partnership_details">

                                    <?php $l=0;
                                    if(isset($editcontprt)) {
                                    for($l=0; $l<count($editcontprt); $l++) { ?>

                                    <div id="repeat_partnership_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Partner <?php echo $l+1; ?></label>
                                                <select id="partnership_details_<?php echo $l+1; ?>" name="partnership[]" class="form-control partnership_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#partnership_details_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontprt[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="partnership_details_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Partnership %</label>
                                                <input type="text" class="form-control" id="partnership_percent_<?php echo $l+1; ?>" name="partnership_percent[]" placeholder="Partnership %"  value="<?php echo $editcontprt[$l]->percent; ?>" />
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_partnership_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } } else { ?>
                                    
                                    <div id="repeat_partnership_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label>Partner <?php echo $l+1; ?></label>
                                                <select id="partnership_details_<?php echo $l+1; ?>" name="partnership[]" class="form-control partnership_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#partnership_details_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="partnership_details_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Partnership %</label>
                                                <input type="text" class="form-control" id="partnership_percent_<?php echo $l+1; ?>" name="partnership_percent[]" placeholder="Partnership %"/>
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_partnership_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } ?>

                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-partnership">+ Add Partnership</span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="trustee-section" style="<?php if($owner_type!='trust') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Trustee Details<b></p>
	                                <div id="trustee_details">

	                                    <?php $l=0;
	                                    if(isset($editconttrs)) {
	                                    for($l=0; $l<count($editconttrs); $l++) { ?>

	                                    <div id="repeat_trustee_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Trustee <?php echo $l+1; ?></label>
	                                                <select id="trustee_details_<?php echo $l+1; ?>" name="trustee[]" class="form-control trustee_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#trustee_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editconttrs[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="trustee_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_trustee_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_trustee_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Trustee <?php echo $l+1; ?></label>
	                                                <select id="trustee_details_<?php echo $l+1; ?>" name="trustee[]" class="form-control trustee_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#trustee_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="trustee_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_trustee_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-trustee">+ Add Trustee </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="beneficiary-section" style="<?php if($owner_type!='trust') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Beneficiary Details<b></p>
                                <div id="beneficiary_details">

                                    <?php $l=0;
                                    if(isset($editcontben)) {
                                    for($l=0; $l<count($editcontben); $l++) { ?>

                                    <div id="repeat_beneficiary_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Beneficiary <?php echo $l+1; ?></label>
                                                <select id="beneficiary_details_<?php echo $l+1; ?>" name="beneficiary[]" class="form-control beneficiary_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#beneficiary_details_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontben[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="beneficiary_details_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Shareholder %</label>
                                                <input type="text" class="form-control" id="beneficiary_percent_<?php echo $l+1; ?>" name="beneficiary_percent[]" placeholder="Shareholder %"  value="<?php echo $editcontben[$l]->percent; ?>" />
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_beneficiary_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } } else { ?>
                                    
                                    <div id="repeat_beneficiary_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label>Beneficiary <?php echo $l+1; ?></label>
                                                <select id="beneficiary_details_<?php echo $l+1; ?>" name="beneficiary[]" class="form-control beneficiary_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#beneficiary_details_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="beneficiary_details_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>beneficiary %</label>
                                                <input type="text" class="form-control" id="beneficiary_percent_<?php echo $l+1; ?>" name="beneficiary_percent[]" placeholder="beneficiary %"/>
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_beneficiary_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } ?>

                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-beneficiary">+ Add Beneficiary</span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="owner-section" style="<?php if($owner_type!='proprietorship') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Owner Details<b></p>
	                                <div id="owner_details">

	                                    <?php $l=0;
	                                    if(isset($editcontown)) {
	                                    for($l=0; $l<count($editcontown); $l++) { ?>

	                                    <div id="repeat_owner_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Owner <?php echo $l+1; ?></label>
	                                                <select id="owner_details_<?php echo $l+1; ?>" name="owner[]" class="form-control owner_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#owner_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontown[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="owner_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_owner_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_owner_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Owner <?php echo $l+1; ?></label>
	                                                <select id="owner_details_<?php echo $l+1; ?>" name="owner[]" class="form-control owner_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#owner_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
	                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="owner_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_owner_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-owner">+ Add Owner </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a">
	                            <p class="m-t-20"><b>Documents<b></p>
	                            <?php $this->load->view('templates/document');?>
	                            <div class="optionBox" id="optionBox1">
	                                <div class="block" id="block2">
	                                    <span class="add" id="repeat-documents">+ Add Documents</span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="a" id="authsignatory-section" style="<?php if($owner_type=='huf') echo 'display: none;'; ?>">
	                            <p class="m-t-20"><b>Authorised Signatory Details<b></p>
                                <div id="authsignatory_details">

                                    <?php $l=0;
                                    if(isset($editcontauth)) {
                                    for($l=0; $l<count($editcontauth); $l++) { ?>

                                    <div id="repeat_authsignatory_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Authorised Signatory <?php echo ($l+1); ?></label>
                                                <select id="authsignatory_<?php echo $l+1; ?>" name="authsignatory[]" class="form-control authsignatory_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#authsignatory_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontauth[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="authsignatory_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Purpose Of AS</label>
                                                <input type="text" class="form-control" name="purpose[]" placeholder="Purpose Of AS"  value="<?php echo $editcontauth[$l]->purpose; ?>" />
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_authsignatory_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } } else { ?>
                                    
                                    <div id="repeat_authsignatory_<?php echo $l+1; ?>" class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label>Authorised Signatory <?php echo ($l+1); ?></label>
                                                <select id="authsignatory_details_<?php echo $l+1; ?>" name="authsignatory[]" class="form-control authsignatory_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#authsignatory_<?php echo $l; ?>_error">
                                                    <option value="">Select</option>
                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                        <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
                                                    <?php } ?>
                                                </select>
                    							<span id="authsignatory_<?php echo $l; ?>_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Purpose Of AS</label>
                                                <input type="text" class="form-control" name="purpose[]" placeholder="Purpose Of AS"/>
                                            </div>
                                        </div>
                                        <div class="delete delete_row" id="repeat_authsignatory_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                    </div>

                                    <?php } ?>

                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-authsignatory">+ Add Authorised Signatory</span>
	                                </div>
	                            </div>
	                        </div>

							<!-- <p><b>Remark</b></p>
							<div class="a">
								<div class="row clearfix">
									<div class="col-md-12">
										<div class="form-group form-group-default">
											<label>Remark</label>
											<input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php //if(isset($editcontact)){ echo $editcontact[0]->c_maker_remark;}?>">
										</div>
									</div>
								</div>
							</div> -->

							<div class="form-footer" style="padding-bottom: 60px;">
								<input type="hidden" id="submitVal" value="1" />
	                            <a href="<?php echo base_url(); ?>index.php/contacts" class="btn btn-default-danger pull-left" >Cancel</a>
	                            <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                            	<input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
							</div>
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
    var BASE_URL="<?php echo base_url()?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($owner)) {
            for($i=0; $i<count($owner); $i++) {
                $contact_details = $contact_details . '<option value="'.$owner[$i]->c_id.'">'.$owner[$i]->contact_name.'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/owner.js"></script>

</body>
</html>