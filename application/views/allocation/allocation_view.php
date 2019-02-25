<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
      #image-preview {
    min-width: auto;
    min-height: 250px;
    width: 100%;
    height: auto;
    position: relative;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    color: #ecf0f1;
    margin: auto;
}
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
			margin-left:0px!important;
		}
		.print {
			color:#fe970a!important;
			display:none!important;
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
			margin-left:12px;
			margin-right:12px;
		}
		p {
			font-weight: 200px!important;
			margin-left:12px;
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
			<form id="form_allocation_view" role="form" method ="post" action="<?php echo base_url().'index.php/Allocation/update/'.$p_id.'/'.$sub_property[0]->txn_status; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Allocation/checkstatus/All">Allocation List</a></li>
					<li class="breadcrumb-item active">Allocation View</li>
				</ol>
				<div class="container">
					<div class="row">
					<div class="col-md-12">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Allocation'; ?>">
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
											<a href="<?php echo base_url().'index.php/Allocation/edit/'.$p_id . '/' . $sub_property[0]->txn_status; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($sub_property)) { ?>
										<?php if($sub_property[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } else if($sub_property[0]->modified_by != '' && $sub_property[0]->modified_by != null) { if($sub_property[0]->modified_by!=$allocationby) { if($sub_property[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($sub_property[0]->created_by != '' && $sub_property[0]->created_by != null) { if($sub_property[0]->created_by!=$allocationby && $sub_property[0]->txn_status != 'In Process') { if($sub_property[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
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
						</div>
						<!--<div class="col-md-3">
							<div class="col-lg-12">
			                    <div class="card card-default" style="background:#e6ebf1">
			                        <div class="card-header " style="background:#f6f9fc">
			                            <div class="card-title">
			                                Sub Property Image
			                            </div><!-- <span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span> --
			                        </div>
			                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php //if (isset($sub_property)) echo base_url().$sub_property[0]->image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
			                            <!-- <input type="file" name="image" id="image-upload" /> -->
			                            <!-- <img src="<?php //echo base_url().$sub_property[0]->c_image; ?>"> --
			                        </div>-->
			                        <!-- <div id="image-label_field">
			                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
			                        </div>
			                    </div>
			                </div>
						</div>-->
						
							<div class="col-md-3" style="background: linear-gradient(45deg, #39414d 0%, #39414d 25%, #444c59 51%, #4c5561 78%, #4e5663 100%); padding-right: 15px;padding-left: 15px;">
							  <div class="p-t-20">
			                     
			                         <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($sub_property[0]->image)) echo base_url().$sub_property[0]->image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
			                            <!-- <input type="file" name="image" id="image-upload" /> -->
			                            <!-- <img src="<?php //echo base_url().$sub_property[0]->c_image; ?>"> -->
			                        </div>
			                        <!-- <div id="image-label_field">
			                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
			                        </div> -->
			                    </div>
					
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2);">
								<div class="row" style="">
									<div class="col-md-6 rent">
										<b style="font-size:22px;">1</b><br>
										Tenant
									</div>
									<div class="col-md-6 rent" style="border-right:none;">
										<b style="font-size:22px;" >2</b><br>
										Maintenance 
									</div>
								
								</div>
							</div>
						
						</div>
						
						
						<div class="col-md-9">
							<div class=" container-fluid container-fixed-lg bg-white">
			                    <div class="card card-transparent">
			                        <div class="a">
			                            <p class="m-t-20"><b>Sub Property Details<b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default form-group-default-select2 ">
			                                        <label class="">Select Property</label>
			                                        <select class="form-control full-width Select-Property" name="property" data-placeholder="Select Property" data-init-plugin="select2" disabled>
			                                            <option value="">Select Property </option>
			                                            <?php for ($i=0; $i < count($property) ; $i++) { ?>
			                                                <option value="<?php echo $property[$i]->txn_id; ?>" <?php if(isset($sub_property)) { if($sub_property[0]->property_id==$property[$i]->txn_id) { echo "selected"; } } ?>><?php echo $property[$i]->p_property_name; ?></option>
			                                            <?php } ?>
			                                        </select>
			                                    </div>
			                                </div>
			                            </div>

			                            <div id="repeatsubproperty">
			                                <?php $i=0; if(isset($sub_property)) { for ($i=0; $i < count($sub_property) ; $i++) { ?>
			                                <div class="block1" id="repeat_sub_property_<?php echo $i+1; ?>">
			                                    
			                                    <div class="row clearfix">
			                                        <!-- <div class="col-md-4">
			                                            <div class="form-group form-group-default required">
			                                                <label>Sr. No.</label>
			                                                <input type="text" class="form-control" name="sr_no[]" value="<?php //echo $i+1; ?>" readonly >
			                                            </div>
			                                        </div> -->
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default ">
			                                                <label>Sub Property Name.</label>
			                                                <input type="hidden" name="sub_property_id[]" class="form-control" value="<?php echo $sub_property[$i]->txn_id; ?>">
			                                                <input type="text" name="sub_property[]" class="form-control sub_property" value="<?php echo $sub_property[$i]->sp_name; ?>" readonly>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default form-group-default-select2 ">
			                                                <label class="">Select Sub Property Type</label>
			                                                <select class="full-width select2" name="sub_type[]" data-placeholder="Type" data-init-plugin="select2" disabled>
			                                                    <option value="">Select</option>
		                                                        <option value="Shop" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Shop') { echo "selected"; }} ?>>Shop</option>
			                                                    <option value="Flat" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Flat') { echo "selected"; }} ?>>Flat</option>
			                                                    <option value="Floor" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Floor') { echo "selected"; }} ?>>Floor</option>
			                                                </select>
			                                            </div>
			                                        </div>
			                                    </div>
			                                    <div class="row clearfix">
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default input-group">
			                                                <div class="form-input-group">
			                                                    <label>Carpet Area</label>
			                                                    <input type="text" name="carpet[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_carpet_area,2); ?>" readonly>
			                                                </div>
			                                                <div class="input-group-addon bg-transparent h-c-50">
			                                                    <select class="full-width select2" name="carpet_unit[]" data-placeholder="Carpet" data-init-plugin="select2" disabled>
			                                                        <option value="">Select</option>
			                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
			                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
			                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
			                                                    </select>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default input-group">
			                                                <div class="form-input-group">
			                                                    <label>Built Up Area</label>
			                                                    <input type="text" name="builtup[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_builtup_area,2); ?>" readonly>
			                                                </div>
			                                                <div class="input-group-addon bg-transparent h-c-50">
			                                                    <select class="full-width select2" name="builtup_area[]" data-placeholder="Built Up" data-init-plugin="select2" disabled>
			                                                        <option value="">Select</option>
			                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
			                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
			                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
			                                                    </select>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default input-group">
			                                                <div class="form-input-group">
			                                                    <label>Saleable Area</label>
			                                                    <input type="text" name="sellable[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_sellable_area,2); ?>" readonly>
			                                                </div>
			                                                <div class="input-group-addon bg-transparent h-c-50">
			                                                    <select class="full-width select2" name="sellable_area[]" data-placeholder="Saleable" data-init-plugin="select2" disabled>
			                                                        <option value="">Select</option>
			                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
			                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
			                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
			                                                    </select>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
			                                    <div class="row clearfix">
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default ">
			                                                <label>Allocated Cost(₹)</label>
			                                                <input type="text" name="allocated_cost[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_cost,2); ?>" readonly>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default ">
			                                                <label>Allocated Maintenance(₹)</label>
			                                                <input type="text" name="allocated_maintainance[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_maintainance,2); ?>" readonly>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-4">
			                                            <div class="form-group form-group-default ">
			                                                <label>Allocated Expense(₹)</label>
			                                                <input type="text" name="allocated_expenses[]" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_expenses,2); ?>" readonly>
			                                            </div>
			                                        </div>
			                                    </div>
			                                </div>
			                                <?php } } ?>
			                            </div>
			                        </div>

			                        <p class=""><b>Remark<b></p>
									<div class="row clearfix" style="padding-bottom: 25px;">
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Maker Remarks </label>
												<input type="text" class="form-control "  value="<?php if (isset($sub_property)) { echo $sub_property[0]->maker_remark; } ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Checker Remarks </label>
												<input type="text" class="form-control "  value="<?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?>" readonly>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-group-default " style="border:1px solid rgba(0,0,0,0.07)!important; ">
												<label>Remark</label>
												<input type="text" class="form-control " id="txtstatus" name="status_remarks" value="<?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?>">
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