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
	<form id="form_huf" role="form" method="post" action="<?php if(isset($huf_record)) { echo base_url().'index.php/owners/updatehufrecord/'.$o_id; } else { echo base_url().'index.php/owners/savehufrecord'; } ?>" enctype="multipart/form-data" autocomplete="off">
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
							<div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="<?php if (isset($editcontact)) { echo "background-image: url('" . base_url().$editcontact[0]->c_image . "')"; } ?>">
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
										<input type="hidden" class="form-control" id="o_id" name="o_id" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_id; } ?>"/>
										<div class="form-group form-group-default required">
											<label>HUF Name</label>
											<input type="text" class="form-control" name="huf_name" placeholder="HUF Name" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_name; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default ">
											<label>Registration No</label>
											<input type="text" class="form-control" name="ow_reg_no" placeholder="Registration No" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_reg_no; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Date of Incorporation</label>
											<input type="text" class="form-control date"  name="huf_doi" placeholder="Date of Incorporation" value="<?php if(isset($huf_record)) { if($huf_record[0]->ow_huf_incorpdate!='' && $huf_record[0]->ow_huf_incorpdate!=null) echo date('d/m/Y', strtotime($huf_record[0]->ow_huf_incorpdate)); } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2 required">
											<label>Karta Name</label>
											<select id="huf_karta_id" name="huf_karta_id" class="form-control full-width" data-placeholder="Select Owner" data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($huf_record)) { if($contact[$k]->c_id==$huf_record[0]->ow_huf_karta_id) { echo 'selected'; } } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Address</label>
											<input type="text" class="form-control"  name="huf_address" placeholder="Address" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_address; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Landmark </label>
											<input type="text" class="form-control"  name="huf_addr_landmark" placeholder="Landmark" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_landmark; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>City </label>
											<input type="text" class="form-control"  name="huf_addr_city" id ="huf_addr_city" placeholder="City" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_city; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Pincode </label>
											<input type="text" class="form-control"  name="huf_addr_pincode" id="huf_addr_pincode" placeholder="Pincode" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_pincode; } ?>"/>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>State</label>
											<input type="text" class="form-control"  name="huf_addr_state" id="huf_addr_state" placeholder="State" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_state; } ?>"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Country </label>
											<input type="text" class="form-control"  name="huf_addr_country" id="huf_addr_country" placeholder="Country" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_country; } ?>"/>
										</div>
									</div>
								</div>
							</div>
	                        <div class="a" id="nominee-section">
	                            <p class="m-t-20"><b>Family Details<b></p>
	                                <div id="family_details">

	                                    <?php $l=0;
	                                    if(isset($huf_family)) {
	                                    for($l=0; $l<count($huf_family); $l++) { ?>

	                                    <div id="repeat_huf_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-2">
	                                            <div class="form-group form-group-default">
	                                                <label>Sr No.</label>
	                                                <input type="text" class="form-control" value="<?php echo ($l+1); ?>" readonly>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label class="">Select Contact</label>
	                                                <select id="family_details_<?php echo $l+1; ?>_id" name="family_details[]" class="form-control family_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#family_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($contact) ; $k++) { ?>
	                                                        <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$huf_family[$l]->huf_ow_family_detail) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="family_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Relation</label>
	                                                <input type="text" class="form-control" name="relation[]" placeholder="Relation"  value="<?php echo $huf_family[$l]->huf_ow_relation; ?>" />
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_huf_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } } else { ?>
	                                    
	                                    <div id="repeat_huf_<?php echo $l+1; ?>" class="row clearfix">
	                                        <div class="col-md-2">
	                                            <div class="form-group form-group-default">
	                                                <label>Sr No.</label>
	                                                <input type="text" class="form-control" value="<?php echo ($l+1); ?>" readonly>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default form-group-default-select2 required">
	                                                <label>Select Contact</label>
	                                                <select id="family_details_<?php echo $l+1; ?>_id" name="family_details[]" class="form-control family_details full-width" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#family_details_<?php echo $l; ?>_error">
	                                                    <option value="">Select</option>
	                                                    <?php for ($k=0; $k < count($contact) ; $k++) { ?>
	                                                        <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
	                                                    <?php } ?>
	                                                </select>
                        							<span id="family_details_<?php echo $l; ?>_error"></span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group form-group-default required">
	                                                <label>Relation</label>
	                                                <input type="text" class="form-control"  name="relation[]" placeholder="Relation"/>
	                                            </div>
	                                        </div>
	                                        <div class="delete delete_row" id="repeat_huf_<?php echo $l+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
	                                    </div>

	                                    <?php } ?>

	                                </div>
	                            <div class="optionBox" id="optionBox">
	                                <div class="block" id="block">
	                                    <span class="add" id="repeat-huf">+ Add Nominee Details</span>
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

							<!-- <p><b>Remark</b></p>
							<div class="a">
								<div class="row clearfix">
									<div class="col-md-12">
										<div class="form-group form-group-default">
											<label>Remark</label>
											<input type="text" class="form-control" id="ow_maker_remark" name="ow_maker_remark" value="<?php //if(isset($huf_record)){ echo $huf_record[0]->ow_maker_remark;}?>">
										</div>
									</div>
								</div>
							</div> -->

							<div class="form-footer" style="padding-bottom: 60px;">
								<input type="hidden" id="submitVal" value="1" />
								<a href="<?php echo base_url(); ?>index.php/owners" class="btn btn-default-danger pull-left" >Cancel</a>
								<input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
								<input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($huf_record)) echo 'display:none'; ?>" />
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
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

<script type="text/javascript">
jQuery(function(){
    $('#repeat-huf').click(function(event){
        var counter = $('select.family_details').length+1;
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_huf_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-2">' + 
                                    '<div class="form-group form-group-default">' + 
                                        '<label>Sr No.</label>' + 
                                        '<input type="text" class="form-control" value="'+counter+'" readonly>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Select Contact</label>' + 
                                        '<select id="family_details_'+counter+'_id" name="family_details[]" class="form-control family_details full-width select2" data-placeholder="Select Contact" data-init-plugin="select2" data-error="#family_details_'+counter+'_error">'+contact_details+'</select>' + 
            							'<span id="family_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default required">' + 
                                        '<label>Relation</label>' + 
                                        '<input type="text" name="relation[]" class="form-control" placeholder="Relation" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_huf_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#family_details').append(newRow);
        $('.select2', newRow).select2();
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $('form :input').change(function() {
            $('.save-form').prop("disabled",false);
        });
    });
});
</script>
</body>
</html>