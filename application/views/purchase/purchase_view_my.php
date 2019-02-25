<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
		}
		.print {
			color:#fe970a!important;
		}
		.a {
			border-bottom: 2px solid #edf0f5;
			margin-bottom: 25px;
			padding-bottom: 25px;
		}
		.prop_img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}
		.markup {
			border-radius:20px;
		}
		#contact1 {
			width: 150px;
			height: 150px;
			text-align: center;
			float: none;
			margin: 15px auto;
			display: block;
			color:#fff!important;
		}
		.info {
			text-align:center;

		}
		.invoice {
			margin: 10px;
			padding: 0 27px;
			border-radius: 30px;
			font-size: 13px;
		}
		.btn-group-justified {
			margin-left:2px;
		}
		.email {
			font-size:13px!important;
			color:#fff!important;
		}
		.title_1 {
			font-size: 1.14286rem!important;
			font-family: inherit!important;
			font-weight: 500!important;
			letter-spacing: 0.02em!important;
			text-transform: capitalize!important;
			color:#fff!important;
		}
		.contact_card {
			border-radius:5px!important;
		}
		.rent {
			color:#fff!important;
			border-right:2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-color: rgba(255,255,255,0.1) !important;	
		}
		.rent:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.leases {
			color:#fff!important;
			border-top: 2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-right:2px solid #edf0f5;
			border-color: rgba(255,255,255,0.1) !important;
		}
		.leases:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.badge-notify {
			background: #899be7;
			position: relative;
			top: -88px;

			left: 188px;
			width: 28px;
			height: 28px;
			color: #fff;

			border: 2px solid #ffffff;
			position: absolute;
			top: 30px;

			width: 28px;
			height: 28px;
			border-radius: 50%;
			background-color: #41c997;
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;

			-webkit-box-align: center;
			-webkit-align-items: center;
			-ms-flex-align: center;
			align-items: center;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-ms-flex-pack: center;
			justify-content: center;
			border: 2px solid #ffffff;
			-webkit-transition: background-color 0.2s linear;
			transition: background-color 0.2s linear;
		}
		#money.fa {
			font-size:22px!important;
		}
		.user-roommates:after {
			content: '';
			position: absolute;
			left: 50%;
			top: 161px;
			width: 22px;
			height: 1px;
			margin-left: -11px;
			background-color: #e6ebf1;
		}
		.user-roommates.empty>p {
			text-align:center;
			font-size: 12px;
			color: #d1d3d8;
		}
		.form-group-default {
			border:none!important;
		}
		.form-group-default label {
			font-weight:1000!important;
		}
		.thumbnail-wrapper.d32>* {
			line-height: 110px!important;
		}
		#pricing_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		#invoice_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		.block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		p {
			font-weight: 200px!important;
		}
		.created_date {
			text-align:center;
		}
		.dropdown-item input {
			display: inline; 
			padding-left: 0px;
			cursor: pointer;
			font-size: 13px;
		}
		.select2-selection, .select2-selection__rendered{
			background: white!important;
			color: rgba(0, 0, 0, 0.36)!important;
			font-weight: normal;
		}
		.select2-selection__arrow {
			display: none;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
	<?php $this->load->view('templates/main_header');?>
	<div class="page-content-wrapper ">
		<div class="content ">
			<form id="form_purchase_view" role="form" method ="post" action="<?php echo base_url().'index.php/Purchase/update/'.$p_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Purchase/checkstatus/All">Purchase List</a></li>
					<li class="breadcrumb-item active">Purchase View</li>
				</ol>
				<div class="container">
					<div class="row m-t-20">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Purchase'; ?>">
									<div class="fileUpload blue-btn btn width100 pull-left">
										<span><i class="fa fa-arrow-left"></i></span> 
									</div>
								</a>
								<div class="dropdown pull-right hidden-md-down">
									<button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="fileUpload blue-btn btn width100">
											<span><i class="fa fa-ellipsis-h"></i></span> 
										</div>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
										<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
											<a href="<?php echo base_url().'index.php/Purchase/edit/'.$p_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($p_txn)) { ?>
										<?php if($p_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } else if($p_txn[0]->modified_by != '' && $p_txn[0]->modified_by != null) { if($p_txn[0]->modified_by!=$purchaseby) { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($p_txn[0]->created_by != '' && $p_txn[0]->created_by != null) { if($p_txn[0]->created_by!=$purchaseby && $p_txn[0]->txn_status != 'In Process') { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } ?>

										<a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="background:#a5b1de;">
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-20" style="background:rgba(0,0,0,0.2);">
								<div class="row">
									<div class=" col-md-12">
										<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
											<div class="bg-master text-center text-white" style=" background: #41c997;text-align: center; size:28px;align-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span><?php echo (strlen($p_txn[0]->c_name)>0?substr($p_txn[0]->c_name, 0, 1):'') . (strlen($p_txn[0]->c_last_name)>0?substr($p_txn[0]->c_last_name, 0, 1):''); ?></span>
											</div>  
										</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>
										<div class="info">
											<H5 class="title_1"><?php echo $p_txn[0]->c_name . ' ' . $p_txn[0]->c_last_name; ?></H5>
											<p class="email"><?php echo $p_txn[0]->c_emailid1; ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="invoice_box" style="background:rgba(0,0,0,0.2);">
								<div class=" col-md-12">
									<span class="invoice"><a href="input_form.html"><button class="btn btn-success  btn-xs invoice" type="submit"><span>New Invoice </span></button></a></span>
								</div>
							</div>
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2);">
								<div class="row" style="padding-left:15px;padding-right:15px;">
									<div class="col-md-6 rent">
										<i style="font-size:22px;" class="fa fa-th-list"></i><br>
										New Invoice
									</div>
									<div class="col-md-6 rent" style="border-right:none;">
										<i style="font-size:22px;" class="fa fa-money"></i><br>
										Accounting
									</div>
									<div class=" col-md-6 leases">
										<i style="font-size:22px;" class="fa fa-comments "></i><br>
										Chat
									</div>
									<div class=" col-md-6 leases" style="border-right:none;">
										<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
										Leases
									</div>
								</div>
							</div>
							<p class="created_date">Created on <?php if(isset($p_txn)) { echo ($p_txn[0]->p_purchase_date!=null && $p_txn[0]->p_purchase_date!='')?date('d/m/Y',strtotime($p_txn[0]->p_purchase_date)):''; } ?></p>
						</div>
						<div class="col-md-9">
							<div class=" container-fluid container-fixed-lg bg-white">
			                    <div class="card card-transparent">
			                        <div class="a" id="ownership-section">
			                            <p class="m-t-20"><b>Ownership<b></p>
			                            <div id="repeatowner">

			                                <?php $j=0; if(isset($p_ownership)) { 
			                                    for ($j=0; $j < count($p_ownership) ; $j++) { ?>

			                                <div id="repeat_owner_<?php echo $j+1; ?>" class="row clearfix">
			                                    <div class="col-md-5">
			                                        <div class="form-group form-group-default form-group-default-select2">
			                                            <label class="">Select Owner</label>
			                                            <select id="owner_name_<?php echo $j+1; ?>" name="clientname[]" class="form-control ownership full-width" data-error="#err_owner_name_<?php echo $j+1; ?>" data-placeholder="Select Owner" data-init-plugin="select2" disabled>
			                                                <option value="">Select</option>
			                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
			                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$p_ownership[$j]->pr_client_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
			                                                <?php } ?>
			                                            </select>
			                                            <div id="err_owner_name_<?php echo $j+1; ?>"></div>
			                                        </div>
			                                    </div>
			                                    <div class="col-md-5">
			                                        <div class="form-group form-group-default">
			                                            <label>% of Ownership</label>
			                                            <input type="text" id="owner_percent_<?php echo $j+1; ?>" name="ownership[]" class="form-control" placeholder="% of Ownership" value="<?php if(isset($p_ownership[$j]->pr_ownership_percent)){ echo format_money($p_ownership[$j]->pr_ownership_percent,2); } else { echo ''; }?>" readonly />
			                                        </div>
			                                    </div>
			                                </div>

			                                <?php }} ?>

			                            </div>
			                        </div>

			                        <p class="m-t-20"><b>General Information</b></p>
			                        <div class="a">
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Property Name</label>
			                                        <input type="text" class="form-control" id="property_name" name="property_name" placeholder="Property Name" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_property_name; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Display Name</label>
			                                        <input type="text" class="form-control" name="display_name" placeholder="Display Name" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_display_name; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Date Of Purchase</label>
			                                        <input type="text" class="form-control" name="date_of_purchase" placeholder="Date Of Purchase" value="<?php if(isset($p_txn)) { echo ($p_txn[0]->p_purchase_date!=null && $p_txn[0]->p_purchase_date!='')?date('d/m/Y',strtotime($p_txn[0]->p_purchase_date)):''; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Mode </label>
			                                        <select class="form-control full-width" name="purchase_mode" data-error="#err_purchase_mode" data-placeholder="Select Mode" data-init-plugin="select2" disabled>
			                                            <option value="">Select</option>
			                                            <option value="Purchased" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="Purchased") {echo 'selected'; } } ?>>Purchased</option>
			                                            <option value="Inheritance" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="Inheritance") { echo 'selected'; } } ?>>Inheritance</option>
			                                            <option value="JV" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="JV") {echo 'selected'; } } ?>>JV</option>
			                                            <option value="JDA" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="JDA") { echo 'selected'; } } ?>>JDA</option>
			                                        </select>
			                                        <div id="err_purchase_mode"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Property Type </label>
			                                        <select class="form-control full-width" id="ptype" name="property_type" data-error="#err_property_type" data-placeholder="Select Property Type" data-init-plugin="select2" disabled>
			                                            <option value="">Select</option>
			                                            <option value="Building" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Building") {echo 'selected'; } }?>>Building</option>
			                                            <option value="Apartment" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Apartment") {echo 'selected'; }} ?>>Apartment</option>
			                                            <option value="Bunglow" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Bunglow") {echo 'selected'; }} ?>>Bunglow</option>
			                                            <option value="Commercial" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Commercial") {echo 'selected'; }} ?>>Commercial</option>
			                                            <option value="Retail" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Retail") {echo 'selected'; } }?>>Retail</option>
			                                            <option value="Industrial" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Industrial") {echo 'selected';} } ?>>Industrial</option>
			                                            <option value="Land-Agriculture" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Land-Agriculture") {echo 'selected'; }} ?>>Land - Agriculture</option>
			                                            <option value="Land-NonAgriculture" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Land-NonAgriculture") {echo 'selected';} } ?>>Land - Non Agriculture</option>
			                                        </select>
			                                        <div id="err_property_type"></div>
			                                    </div>
			                                </div>
			                                <div class="col-md-6 p_status">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Property Status </label>
			                                        <select class="form-control full-width" name="property_status" id="property_status" data-error="#err_property_status" data-placeholder="Select Property Status" data-init-plugin="select2" disabled>
			                                            <option value="">Select</option>
			                                            <option value="Under Construction" <?php if(isset($p_txn)) { if($p_txn[0]->p_status=="Under Construction") {echo 'selected'; }} ?>>Under Construction</option>
			                                            <option value="Completed" <?php if(isset($p_txn)) { if($p_txn[0]->p_status=="Completed") {echo 'selected'; }} ?>>Completed</option>
			                                        </select>
			                                        <div id="err_property_status"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Seller</label>
			                                        <select id="builder" name="builder_name" class="form-control full-width" data-error="#err_builder_name" data-placeholder="Select Seller" data-init-plugin="select2" disabled>
			                                            <option value="">Select</option>
			                                            <?php for ($k=0; $k < count($contact) ; $k++) { ?>
			                                                <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($p_txn)) { if($contact[$k]->c_id==$p_txn[0]->p_builder_name) { echo 'selected'; } } ?><?php  ?>><?php echo $contact[$k]->contact_name; ?></option>
			                                            <?php } ?>
			                                        </select>
			                                        <div id="err_builder_name"></div>
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Usage of Property </label>
			                                        <select class="form-control full-width" name="property_usage" data-error="#err_property_usage" data-placeholder="Select Usage of Property" data-init-plugin="select2" disabled>
			                                            <option value="">Select</option>
			                                            <option value="Self Occupation" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Self Occupation") {echo 'selected'; } }?>>Self Occupation</option>
			                                            <option value="Investment" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Investment") {echo 'selected'; } } ?>>Investment</option>
			                                            <option value="Trading" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Trading") {echo 'selected'; } } ?>>Trading</option>
			                                        </select>
			                                        <div id="err_property_usage"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-12">
			                                    <div class="form-group form-group-default">
			                                        <label>Property Description</label>
			                                        <input type="text" class="form-control" name="property_description" placeholder="Property Description" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_propertydescription; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="a" id="">
			                            <p class="m-t-20"><b>Address Details<b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Building Name</label>
			                                        <input type="text" class="form-control" name="apartment_name" placeholder="Building Name"  value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_apartment; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Unit No</label>
			                                        <input type="text" class="form-control" name="flat_no" placeholder="Unit No" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_flatno; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Floor</label>
			                                        <input type="text" class="form-control" name="floor" placeholder="Floor" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_floor; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Wing</label>
			                                        <input type="text" class="form-control" name="wing" placeholder="Wing" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_wing; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-8">
			                                    <div class="form-group form-group-default">
			                                        <label>Address</label>
			                                        <input type="text" class="form-control" name="address" placeholder="Address" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_address; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Landmark </label>
			                                        <input type="text" class="form-control" name="landmark" placeholder="Landmark" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_landmark; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>City </label>
			                                        <input type="text" class="form-control" name="city" id ="pur_add_city" placeholder="City" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_city; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Pincode </label>
			                                        <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_pincode; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>State</label>
			                                        <input type="text" class="form-control" name="state" id="pur_add_state" placeholder="State" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_state; } ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Country </label>
			                                        <input type="text" class="form-control" name="country" id="pur_add_country" placeholder="Country" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_country; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-9">
			                                    <div class="form-group form-group-default">
			                                        <label>Map Address</label>
			                                        <input type="text" id="googlemaplink" class="form-control" name="googlemaplink" placeholder="Map Address" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_googlemaplink; } ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="a" id="">
			                            <p class="m-t-20"><b>Property Description<b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Agreement Area </label>
			                                        <input type="text" id="agreement_area" class="form-control format_number" name="agreement_area" placeholder="Agreement Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_agreement_area,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select id="ddlagreementarea" class="form-control full-width" name="agreement_unit" data-error="#err_agreement_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description))  { if(count($p_description)>0) { if($p_description[0]->pr_agreement_unit=="Sq m") { echo "selected"; }}} ?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_agreement_unit=="Sq ft") { echo "selected"; }}} ?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0)  { if($p_description[0]->pr_agreement_unit=="Sq yard") { echo "selected"; }}} ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_agreement_unit"></div>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Land Area </label>
			                                        <input type="text" class="form-control format_number" name="land_area" placeholder="Land Area" value="<?php if(isset($p_description)) { if(count($p_description) > 0) { echo format_money($p_description[0]->pr_land_area,2); } }?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select class="form-control full-width" name="land_unit" data-error="#err_land_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq yard") { echo "selected"; }}} ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_land_unit"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Carpet  Area </label>
			                                        <input type="text" class="form-control format_number" name="carpet_area" placeholder="Carpet Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_carpet_area,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select class="form-control full-width" name="carpet_unit" data-error="#err_carpet_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq m") { echo "selected"; } }} ?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_carpet_unit"></div>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Built Up Area </label>
			                                        <input type="text" class="form-control format_number" name="built_area" placeholder="Built Up Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_builtup_area,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select  class="form-control full-width" name="built_unit" data-error="#err_built_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq ft") { echo "selected"; } } }?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq yard") { echo "selected"; } } } ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_built_unit"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Saleable Area </label>
			                                        <input type="text" class="form-control format_number" name="sell_area" placeholder="Saleable Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_sellable_area,2); } }?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select class="form-control full-width" name="sell_unit" data-error="#err_sell_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq m") { echo "selected"; } }} ?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_sell_unit"></div>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Bunglow  Area </label>
			                                        <input type="text" class="form-control format_number" name="bunglow_area" placeholder="Bunglow Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_bunglow_area,2); } }?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-2">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Select Unit</label>
			                                        <select class="form-control full-width" name="bunglow_unit" data-error="#err_bunglow_unit" data-placeholder="Select Unit" data-init-plugin="select2" disabled>
			                                            <option value="">Select Unit</option>
			                                            <option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
			                                            <option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
			                                            <option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
			                                        </select>
			                                        <div id="err_bunglow_unit"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>No Of Floors</label>
			                                        <input type="text" class="form-control format_number" name="no_of_floors" placeholder="No Of Floors" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_floors,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>No Of Flats</label>
			                                        <input type="text" class="form-control format_number" name="no_of_flats" placeholder="No Of Flats" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_flats,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>No Of Shops</label>
			                                        <input type="text" class="form-control format_number" name="no_of_shops" placeholder="No Of Shops" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_shops,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>No Of Open Parking </label>
			                                        <input type="text" class="form-control format_number" name="open_parking" placeholder="Open Parking" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_open_parking,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>No Of Covered Parking </label>
			                                        <input type="text" class="form-control format_number" name="covered_parking" placeholder="Covered Parking" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_covered_parking,2); }} ?>" readonly />
			                                    </div>
			                                </div>
			                            </div>

			                            <div id="repeatimg">
			                                <?php 
			                                    $i=0; if(isset($p_description_img)) {
			                                        for ($i=0; $i < count($p_description_img) ; $i++) { 
			                                ?>
			                                <div id="repeat_img_<?php echo $i+1; ?>" class="row clearfix">
			                                    <div class="col-md-4">
			                                        <div class="form-group form-group-default ">
			                                            <label>Captured Date</label>
			                                            <input type="text" class="form-control date prop_description" name="capture_date[]" placeholder="Captured Date" value="<?php echo ($p_description_img[$i]->file_date!=null && $p_description_img[$i]->file_date!='')?date('d/m/Y',strtotime($p_description_img[$i]->file_date)):''; ?>" readonly />
			                                        </div>
			                                    </div>
			                                    <div class="col-md-4">
			                                        <div class="form-group form-group-default ">
			                                            <label>Description</label>
			                                            <input type="text" class="form-control" name="capture_description[]" placeholder="Description" value="<?php echo $p_description_img[$i]->file_description; ?>" readonly />
			                                        </div>
			                                    </div>
			                                    <div class="col-md-3"> 
			                                        <?php if($p_description_img[$i]->file_path!= '') { ?><a target="_blank" href="<?php echo base_url().$p_description_img[$i]->file_path; ?>">Download</a><?php } ?>
			                                    </div>
			                                </div>
			                                <?php }} ?>
			                            </div>
			                            <div class="optionBox" id="prop_img_box">
			                                <div class="block" id="prop_img_block">
			                                    <span class="add" id="repeat-img">+ Add Image</span>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="a">
			                            <p class="m-t-20"><b> Purchase Consideration<b></p>
			                            <div class="row clearfix" id="actual_schedule_div">
			                                <div class="col-md-12">
			                                    <table class="view_table addsummary" style="text-align:right; vertical-align:middle;">
													<thead>
														<tr>
															<!-- <th width="9%"> Sr. No.	</th>
															<th width="23%"> Cost Head	 </th>
															<th width="14%"> Area </th>
															<th width="15%"> Rate (in ₹) </th>
															<th width="18%"> Total Cost (in ₹)	 </th>
															<th width="21%"> No of Installment</th>
															-->
															<th  width="80" align="center" style="text-align:center"> Sr. No. </th>
															<th width="20%" > Type  </th>
															<th   style="text-align:right;">Cost  (In &#x20B9;)</th>
															<?php //print_r($tax_name);
															if(isset($tax_name)){
															// echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
															$key=0;
															foreach($tax_name as $row){
															echo '<th  style="text-align:right; text-transform: capitalize;">'.$row->tax_type.'</th>';
															$tax_array[$key]=$row->tax_type;
															$key++;
															} 
															//echo '</tr></table></th>';
															}
															?>
															<th   style="text-align:right;" > Net Cost  (In &#x20B9;)</th>
														</tr>
													</thead>
													<tbody>
														<?php //print_r($p_schedule);?>
														<?php 
														$j=0;
														$total_basic_cost=0;
														$total_net_amount=0;
														$total_tax_array=array();
														foreach($p_schedule as $row_tax){
														echo '<tr>
														<td align="center">'.($j+1).'</td>
														<td>'.$p_schedule[$j]["event_type"].'</td>

														<td style="text-align:right;">'.format_money($p_schedule[$j]["basic_cost"],2).'</td>';
														//echo count($p_schedule[$j]['tax_type']);
														/* if(isset($p_schedule[$j]['tax_type'])){
														for($tcnt=0;$tcnt<$key;$tcnt++){
														// print_r($p_schedule[$j]['tax_type']);
														$tax_amount='';
														if(count($p_schedule[$j]['tax_type'])>=($tcnt+1)){

														if($p_schedule[$j]['tax_type'][$tcnt]==$tax_array[$tcnt]){
														$tax_amount=$p_schedule[$j]['tax_amount'][$tcnt];
														}
														}
														echo '<td>'.$tax_amount.'</td>';
														}
														}*/
														//echo $key;
														$total_basic_cost=$total_basic_cost+$p_schedule[$j]["basic_cost"];

														$next_count=0;
														$td_count=0;
														// print_r($p_schedule);
														if(isset($p_schedule[$j]['tax_type'])) {
														// for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
														//echo "<br>hi";
														// echo $key;
														for($tcnt=0;$tcnt<$key;$tcnt++){

														//echo "step1--";
														for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++){
														$tax_amount='';
														if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt])
														{
														$tax_amount=$p_schedule[$j]['tax_amount'][$nc];
														$nc=count($p_schedule[$j]['tax_type']);
														//$tcnt=$key;
														//}
														}
														}
														if($tax_amount !=''){
														echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
														$td_count++;

														}
														else{
														//if($next_count )
														echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
														$td_count++;
														}
														// $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
														//  $total_tax_array[$tcnt]= $tax_amount;
														// print_r($total_tax_array);




														}

														// }
														}
														$inserttd=$key-$td_count;
														if($inserttd !=0){
														for($tdint=0;$tdint<$inserttd;$tdint++){
														echo "<td></td>";
														}
														}


														echo'<td style="text-align:right;">'.format_money($p_schedule[$j]["net_amount"],2).'</td>
														</tr>';
														$total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
														//print_r($p_schedule[$j]['event_type']);
														$j++;


														}?>

														<tr>
															<td colspan="2"><b>Grand Total  (In &#x20B9;)</b></td>
															<td style="text-align:right;"><?php echo (isset($total_basic_cost))?format_money($total_basic_cost,2):0;?></td>
															<?php
															if (isset($total_tax_amount)) {
															foreach($total_tax_amount as $row){
															echo '<td style="text-align:right;">'.format_money($row,2).'</td>';
															}
															}
															?>
															<td style="text-align:right;"><?php echo isset($total_net_amount)?format_money($total_net_amount,2):0;?></td>
														</tr>
													</tbody>
			                                    </table>
			                                </div>
			                            </div>
			                        </div>
			                    </div>

			                    <?php $this->load->view('templates/document_view');?>

			                    <div class="a">
			                        <p class="m-t-20"><b>Property Amenities</b></p>
			                        <div class="checkbox check-success">
			                            <div class="row">
			                                <div class="col-md-12">
			                                    <?php 
			                                        for ($k=0; $k < count($amenity) ; $k++) { ?>
			                                            <div id="repeat_amenity_<?php echo $k+1; ?>" class="row clearfix">
			                                                <div class="col-md-4">
			                                                    <input type="checkbox" name="amenity[]" <?php if(isset($amenity[$k]->amenity_id)) echo 'checked'; ?> value="<?php echo $amenity[$k]->id; ?>" id="checkbox_<?php echo $k+1; ?>" disabled >
			                                                    <label for="checkbox_<?php echo $k+1; ?>"><?php echo $amenity[$k]->amenity; ?></label>
			                                                </div>
			                                            </div>
			                                    <?php } ?>
			                                </div>
			                            </div>
			                        </div>
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

<?php $this->load->view('templates/script');?>
</body>
</html>