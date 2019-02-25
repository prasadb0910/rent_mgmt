<!DOCTYPE html>
<html>
<?php 
	$bl_other_schedue = false;

	if (isset($property_details['other_schedule'])) {
		if($property_details['other_schedule']=='true') {
			$bl_other_schedue = true;
		}
	} 
?>

<?php 
	$action = "";
	if(isset($property_details['accounting_id']) && $property_details['accounting_id']!='') { 
		if ($bl_other_schedue=='true') {
			$action = base_url().'index.php/accounting/updateOther/'.$property_details['accounting_id'].'/'.$property_details['entry_type']; 
		} else {
			$action = base_url().'index.php/accounting/update/'.$property_details['accounting_id'].'/'.$property_details['entry_type'];
		}
	}

	$type = isset($property_details['type'])?$property_details['type']:'';
?>

<head>
	<?php $this->load->view('templates/header');?>

	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" >
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
	<link href="<?php echo base_url(); ?>assets/css/accounting.css" rel="stylesheet" type="text/css" media="screen">

	<style>
	.form-group-default 
	{
		padding-right: 0px!important
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
		input {
			color: #626262!important;
		}
		.total_amt {
		    text-align: center;
		    display:inline-flex;
		    padding: 0px 40px;
		    margin-bottom: 20px;
		    background-color: #f6f9fc;
		    border: 1px solid #edf0f5;
		}
		.total_amt>h5
		{
			    padding-right: 10px;
				    font-size: 14px;
		    font-weight: 600;
		}
		.pay_now {
			<?php if($bl_other_schedue==true) { echo 'display: none;'; } ?>
		}
		.select2-container .select2-selection{
			border: none!important;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
	<div class="content">
		

		<form id="accounting_details" role="form" method ="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
			<!-- <input type="hidden" name="fk_txn_id" id="fk_txn_id" value="<?php //if (isset($property_details['fk_txn_id'])) echo $property_details['fk_txn_id'];?>"> -->
            <input type="hidden" name="accounting_id" id="accounting_id" value="<?php if (isset($property_details['accounting_id'])) echo $property_details['accounting_id'];?>">
            <input type="hidden" name="entry_type" id="entry_type" value="<?php if (isset($property_details['entry_type'])) echo $property_details['entry_type'];?>">
            <input type="hidden" name="created_on" id="created_on" value="<?php if (isset($property_details['created_on'])) echo $property_details['created_on'];?>">
            <input type="hidden" name="fk_created_on" id="fk_created_on" value="<?php if (isset($property_details['fk_created_on'])) echo $property_details['fk_created_on'];?>">
            <input type="hidden" name="txn_status" id="txn_status" value="<?php if (isset($property_details['txn_status'])) echo $property_details['txn_status'];?>">
            <input type="hidden" name="txn_fkid" id="txn_fkid" value="<?php if (isset($property_details['txn_fkid'])) echo $property_details['txn_fkid'];?>">
            <input type="hidden" name="other_expense" id="other_expense" value="<?php if(isset($property_details['other_expense'])) echo $property_details['other_expense']; else echo 'false';?>" />
            <!-- <input type="hidden" name="type" id="type" value="<?php //if (isset($property_details['payment'])) {if($property_details['payment']=='selected') echo 'payment';} if (isset($property_details['receipt'])) {if($property_details['receipt']=='selected') echo 'receipt';}?>"> -->
            <input type="hidden" name="type" id="type" value="<?php echo (($type=='receipt' || $type=='income')?'receipt':'payment'); ?>" />
            <input type="hidden" name="other_schedule" id="other_schedule" value="<?php if(isset($property_details['other_schedule'])) echo $property_details['other_schedule']; else echo 'false';?>" />

			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/accounting/checkstatus/All">Accounting List</a></li>
					<li class="breadcrumb-item active"><?php echo $type; ?></li>
				</ol>
				<div class="container">
					<div class="row">
						<div class="card card-transparent  bg-white" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/accounting'; ?>">
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
											<!-- <a href="<?php //echo base_url().'index.php/accounting/edit/'.$property_details['fk_txn_id'].'/'.$property_details['accounting_id'].'/'.$property_details['entry_type']; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a> -->
											<?php if ($bl_other_schedue=='true') { ?>
												<a href="<?php echo base_url().'index.php/accounting/editOtherSchedule/'.(($property_details['type']=='income' || $property_details['type']=='receipt')?'receipt':'payment').'/'.$property_details['txn_status'].'/'.$property_details['payer_id'].'/'.$property_details['txn_type'].'/'.(($property_details['property_id']=='')?'0':$property_details['property_id']).'/'.(($property_details['sub_property_id']=='')?'0':$property_details['sub_property_id']).'/'.(($property_details['accounting_id']=='')?'0':$property_details['accounting_id']); ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
											<?php } else { ?>
												<a href="<?php echo base_url().'index.php/accounting/edit/'.$property_details['type'].'/'.$property_details['txn_status'].'/'.$property_details['payer_id'].'/'.$property_details['transaction'].'/'.(($property_details['property_id']=='')?'0':$property_details['property_id']).'/'.(($property_details['sub_property_id']=='')?'0':$property_details['sub_property_id']).'/'.(($property_details['accounting_id']=='')?'0':$property_details['accounting_id']); ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($property_details['txn_status'])) { ?>
										<?php if($property_details['txn_status'] == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } else if($property_details['modified_by'] != '' && $property_details['modified_by'] != null) { if($property_details['modified_by']!=$bankEntryBy) { if($property_details['txn_status'] != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($property_details['created_by'] != '' && $property_details['created_by'] != null) { if($property_details['created_by']!=$bankEntryBy && $property_details['txn_status'] != 'In Process') { if($property_details['txn_status'] != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } ?>

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12" style="padding-left: 0;">
							<div class=" container-fluid p-t-20 container-fixed-lg bg-white">
								<div class="card card-transparent">
									<div class="a">
										<div class="row clearfix">
											<div class="col-md-4">
												<div class="form-group form-group-default form-group-default-select2" style="background-color: #f6f9fc;">
		                                            <label class=""><?php if($type=='receipt' || $type=='income') echo 'PAYER'; else echo 'PAYEE'; ?></label>
		                                            <select id="payer_id" name="payer_id" class="form-control full-width" data-error="#err_payer_id" data-placeholder="Select Payer/Payee" data-init-plugin="select2">
		                                                <option value="">Select</option>
		                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
		                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if (isset($property_details['payer_id'])) {if($contact[$k]->c_id==$property_details['payer_id']) { echo 'selected'; }} ?>><?php echo $contact[$k]->contact_name; ?></option>
		                                                <?php } ?>
		                                            </select>
		                                            <div id="err_payer_id"></div>
		                                        </div>
											</div>
											<div class="col-md-4">
												<div class="form-group form-group-default">
													<label>Transaction Date</label>
													<input type="text" class="form-control" name="payment_date" id="payment_date" value="<?php if (isset($property_details['payment_date'])) {if($property_details['payment_date']!='') echo date("d/m/Y",strtotime($property_details['payment_date'])); else echo date('d/m/Y');} else echo date('d/m/Y');?>" placeholder=""/>
												</div>
											</div>
											<div class="col-md-4" style="<?php if ($bl_other_schedue=='true') echo 'display: none;'; ?>">
												<div class="form-group form-group-default form-group-default-select2" style="background-color: #f6f9fc;">
		                                            <label class="">Transaction</label>
		                                            <select name="status" id="status" class="form-control full-width" data-error="#err_status" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
		                                                <option value="">Select</option>
														<?php if ($type=='income' || $type=='expense') { ?>
			                                                <option value="other" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='other') { echo 'selected'; }} ?> >Other</option>
														<?php } else if ($type=='payment') { ?>
			                                                <option value="purchase" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='purchase') { echo 'selected'; }} ?> >Property Purchase</option>
			                                                <option value="other" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='other') { echo 'selected'; }} ?> >Expense</option>
															<!-- <option value="loan" <?php //if (isset($property_details['transaction'])) {if($property_details['transaction']=='loan') { echo 'selected'; }} ?> >Loan EMI</option> -->
															<!-- <option value="expense" <?php //if (isset($property_details['expense'])) echo $property_details['expense'];?> >Property Expense</option>
															<option value="maintenance" <?php //if (isset($property_details['maintenance'])) echo $property_details['maintenance'];?> >Property Maintenance</option> -->
														<?php } else if ($type=='receipt') { ?>
															<option value="sale" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='sale') { echo 'selected'; }} ?> >Property Sale</option>
															<option value="rent" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='rent') { echo 'selected'; }} ?> >Rent</option>
															<option value="other" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='other') { echo 'selected'; }} ?> >Income</option>
															<option value="adhoc" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='adhoc') { echo 'selected'; }} ?> >Adhoc</option>
														<?php } else { ?>
															<option value="other" <?php if (isset($property_details['transaction'])) {if($property_details['transaction']=='other') { echo 'selected'; }} ?> >Other</option>
														<?php } ?>
		                                            </select>
		                                            <div id="err_status"></div>
		                                        </div>
											</div>
										</div>
										<div class="row clearfix" id="loan_ref_name_div" style="<?php if (isset($property_details['loan'])) {if($property_details['loan']=='selected') echo ''; else echo 'display: none;';} else echo 'display: none;';?>">
											<div class="col-md-4">
												<div class="form-group form-group-default form-group-default-select2" style="background-color: #f6f9fc;">
		                                            <label class="">Property/Loan Ref Name</label>
		                                            <select id="loan_ref_name" name="loan_ref_name" class="form-control full-width" data-error="#err_loan_ref_name" data-placeholder="Select Property/Loan Ref Name" data-init-plugin="select2">
		                                                <option value="">Select</option>
		                                                <?php if(isset($loan_txn)) { if(isset($property_details['loan_txn_id'])) { 
															for($i=0; $i<count($loan_txn); $i++) { ?>
																<option value="<?php echo $loan_txn[$i]->txn_id; ?>" <?php if($property_details['loan_txn_id'] == $loan_txn[$i]->txn_id) { echo 'selected';} ?> ><?php echo $loan_txn[$i]->ref_name; ?></option>
														<?php } } else { ?>
																<?php for($i=0; $i<count($loan_txn); $i++) { ?>
																<option value="<?php echo $loan_txn[$i]->txn_id; ?>"><?php echo $loan_txn[$i]->ref_name; ?></option>
														<?php } } } ?>
		                                            </select>
		                                            <div id="err_loan_ref_name"></div>
		                                        </div>
											</div>
										</div>
										<div class="row clearfix" id="property_div" style="<?php if (isset($property_details['loan'])) {if($property_details['loan']=='selected') echo 'display: none;';}?>">
											<div class="col-md-4">
												<div class="form-group form-group-default form-group-default-select2" style="background-color: #f6f9fc;">
		                                            <label class="">Property</label>
		                                            <select id="property" name="prop_name" class="form-control full-width" data-error="#err_property" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
		                                                <option value="">Select</option>
		                                                <?php if(isset($property)) { for ($k=0; $k < count($property) ; $k++) { ?>
		                                                    <option value="<?php echo $property[$k]->txn_id; ?>" <?php if (isset($property_details['property_id'])) {if($property[$k]->txn_id==$property_details['property_id']) { echo 'selected'; }} ?>><?php echo $property[$k]->p_property_name; ?></option>
		                                                <?php }} ?>
		                                            </select>
		                                            <div id="err_property"></div>
		                                        </div>
											</div>
											<div class="col-md-4" id="sub_property_div" style="<?php if($property_details['transaction']=='purchase') { echo 'display: none;'; } else if(isset($sub_property)) {if(count($sub_property)>0) echo ''; else echo 'display: none;'; } else echo 'display: none;'; //if(isset($sub_property)) {if(count($sub_property)==1) {if($sub_property[0]->sub_property_id==null || $sub_property[0]->sub_property_id=="" || $sub_property[0]->sub_property_id=="0") echo 'display: none;';}} else echo 'display: none;';?>">
												<div class="form-group form-group-default form-group-default-select2" style="background-color: #f6f9fc;">
		                                            <label class="">Sub Property</label>
		                                            <select id="sub_property" name="sub_property" class="form-control full-width" data-error="#err_sub_property" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
		                                                <option value="">Select</option>
		                                                <?php if(isset($sub_property)) { for ($k=0; $k < count($sub_property) ; $k++) { ?>
		                                                    <option value="<?php echo $sub_property[$k]->txn_id; ?>" <?php if (isset($property_details['sub_property_id'])) {if($sub_property[$k]->txn_id==$property_details['sub_property_id']) { echo 'selected'; }} ?>><?php echo $sub_property[$k]->sp_name; ?></option>
		                                                <?php }} ?>
		                                            </select>
		                                            <div id="err_sub_property"></div>
		                                        </div>
											</div>
										</div>
									</div>
									<div class="row clearfix">
										<table class="view_table">
											<thead>
												<tr>
													<th style="width: 100px;">Transaction</th>
													<th style="display: none;">Event Type</th>
													<th style="display: none;">Event Name</th>
													<th style="width: 100px;">Due On</th>

													<th style="width: 100px; <?php if($bl_other_schedue=='true') { echo 'display: none;'; } ?>">Invoice no</th>

													<th style="display: none;">Late Fee </th>

													<?php if($bl_other_schedue=="true") { ?>
															<th style="width: 100px;">Category</th>
													<?php } ?>
													
													<th style="width: 100px;">Amount</th>

													<?php if($bl_other_schedue=="true") { ?>
															<th style="width: 50px;">GST %</th>
													<?php } ?>

													<th style="width: 75px;">GST</th>
													<th style="width: 100px;">Total Amount</th>

													<?php if($bl_other_schedue=="true") { ?>
															<th style="width: 25px;">Pay Now</th>
													<?php } ?>

													<th class="pay_now" style="width: 100px;"><?php if($type=='receipt' || $type=='income') echo 'Received'; else echo 'Paid'; ?> Gross Amount</th>
													<th class="pay_now" style="width: 100px;">TDS Amount Received Till Date</th>
													<th style="display: none;">Pending</th>
													<th class="pay_now" style="width: 100px;">Less: TDS</th>
													<th class="pay_now" style="width: 100px;"><?php if($type=='receipt' || $type=='income') echo 'Received'; else echo 'Payment'; ?> Amount</th>

													<?php if(isset($property_details['txn_type'])) {
														if($property_details['txn_type']=="loan") { ?>
															<th>Int Type</th>
															<th>Int Rate %</th>
															<th>Interest %</th>
															<th>Principal</th>
															<th>Total Outstanding</th>
													<?php }} ?>

													<th class="pay_now" style="width: 100px;">Outstanding</th>
												</tr>
											</thead>
											<tbody class="income_dtl" id="payment_summary">
												<?php 

												$i=0;

												if(isset($property_details['schedule_detail'])){
													foreach ($property_details['schedule_detail'] as $row) {
														if($property_details['schedule_detail'][$i]['amount_paid'] == $property_details['schedule_detail'][$i]['net_amount'] ){
															if(isset($property_details['schedule_detail'][$i]['amount_paid']) && $property_details['schedule_detail'][$i]['amount_paid']!='') {
																$disabled='';
															} else {
																$disabled='disabled';
															}
														} else {
															$disabled='';
														}

														// $tax_applied=$property_details['schedule_detail'][$i]['tax_applied'];
														$tax_applied='';
														$tds_amount_till_date = $property_details['schedule_detail'][$i]['tds_paid_till_date'];

														if($property_details['schedule_detail'][$i]['amount_paid']>0 && $property_details['accounting_id']=="")
														{
															$property_details['schedule_detail'][$i]['tds_amount_paid'] = 0;
														}

														echo '<tr class="table_head2 sch_cnt">
																<td>
																	<div class="form-group form-group-default">
																		<input type="hidden" name="fk_txn_id[]" id ="fk_txn_id_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['prop_id'].'">
																		<input type="hidden" name="transaction[]" id ="transaction_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['particulars'].'">
																		'.$property_details['schedule_detail'][$i]['event_particulars'].'
																	</div>
																</td>
																<td style="display: none;">
																	<div class="form-group form-group-default">
																		<input type="hidden" name="event_type[]" id ="event_type_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_type'].'">
																		'.$property_details['schedule_detail'][$i]['event_type'].'
																	</div>
																</td>
																<td style="display: none;">
																	<div class="form-group form-group-default">
																		<input type="hidden" name="event_name[]" id ="event_name_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_name'].'">
																		'.$property_details['schedule_detail'][$i]['event_name'].'
																	</div>
																</td>';

														if($bl_other_schedue=="true") {
															echo '<td>
																	<div class="form-group form-group-default">
																		<input type="text" name="event_date[]" class="form-control" id ="event_date_'.($i+1).'" value="'.date("d/m/Y",strtotime($property_details['schedule_detail'][$i]['event_date'])).'">
																	</div>
																</td>';
														} else {
															echo '<td>
																	<div class="form-group form-group-default">
																		<input type="hidden" name="event_date[]" id ="event_date_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_date'].'">
																		'.date("d/m/Y",strtotime($property_details['schedule_detail'][$i]['event_date'])).'
																	</div>
																</td>';
														}

														echo '<td style="'.(($bl_other_schedue=='true')?'display: none;':'').'">
																<div class="form-group form-group-default">
																	<input type="hidden" name="invoice_no[]" id ="invoice_no_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['invoice_no'].'">
																	'.$property_details['schedule_detail'][$i]['invoice_no'].'
																</div>
															</td>
															<td style="display: none;">
																<input type="checkbox" name="late_fee[]" id ="late_fee_'.($i+1).'" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />
															</td>';


														if($bl_other_schedue=="true") {
															echo '<td> 	
																<div class="form-group form-group-default">
																	<select id="category_'.($i+1).'" name="category[]" class="full-width" data-error="#category_err_'.($i+1).'" data-placeholder="Select Category" data-init-plugin="select2">
																	<option value="">Select Category</option>';

															if(isset($expense_category)) {
																foreach($expense_category as $row) {
																	if($property_details['schedule_detail'][$i]['category']==$row->id) {
																		echo '<option value="'.$row->id.'" selected>'.$row->expense_category.'</option>';	
																	} else {
																		echo '<option value="'.$row->id.'" >'.$row->expense_category.'</option>';
																	}
																} 	
															}

															echo '</select>
																	<div id="category_err_'.($i+1).'"></div>
																</div>
															</td>';

															echo '<td>
																	<div class="form-group form-group-default text-right">
																		<input type="text" name="basic_amount[]" class="form-control format_number text-right" id="basic_amount_'.($i+1).'" value="'.format_money($property_details['schedule_detail'][$i]['basic_amount'],2).'" onblur="setTotalAmount(this);">
																	</div>
																</td>';

															echo '<td>
																<div class="form-group form-group-default">
																	<input type="text" id="gst_rate_'.($i+1).'" name="gst_rate[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getTotOutstanding();" value="'.$property_details['schedule_detail'][$i]['gst_rate'].'" onblur="setTotalAmount(this);" />
																</div>
															</td>';
														} else {
															echo '<td>
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" name="basic_amount[]" id="basic_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['basic_amount'].'">
																		'.format_money($property_details['schedule_detail'][$i]['basic_amount'],2).'
																	</div>
																</td>';
														}

														echo '<td>
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" name="tax_amount[]" id="tax_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['tax_amount'].'">
																		<span id="tax_amount_text_'.($i+1).'">'.format_money($property_details['schedule_detail'][$i]['tax_amount'],2).'</span>
																	</div>
																</td>
																<td>
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" name="net_amount[]" id="net_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['net_amount'].'">
																		<span id="net_amount_text_'.($i+1).'">'.format_money($property_details['schedule_detail'][$i]['net_amount'],2).'</span>
																	</div>
																</td>';
                                                    
			                                            if($bl_other_schedue=="true") {
			                                                echo '<td>
			                                                    <div class="form-group form-group-default">
			                                                        <input type="checkbox" class="toggle" id="pay_now_'.($i+1).'" name="pay_now[]" onChange="setPayNow(this);" value="1" '.($property_details['schedule_detail'][$i]['net_amount']=="1"?"checked":"").' disabled />
			                                                    </div>
			                                                </td>';
			                                            }

			                                            echo '<td class="pay_now">
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" id="paid_till_date_'.($i+1).'" name="paid_amount[]" value="'.$property_details['schedule_detail'][$i]['amount_paid'].'">
																		<input type="hidden" id="paid_till_date_actual_'.($i+1).'" name="paid_amount_actual[]" value="'.$property_details['schedule_detail'][$i]['amount_paid'].'">
																		<!-- <a href="#" id="paid_till_date_link_'.($i+1).'" onclick="getAllpaidDetails(\''.$property_details['schedule_detail'][$i]['event_type'].'\',\''.$property_details['schedule_detail'][$i]['event_name'].'\',\''.$property_details['schedule_detail'][$i]['event_date'].'\')"> -->
																			'.format_money($property_details['schedule_detail'][$i]['amount_paid'],2).' 
																		<!-- </a> -->
																	</div>

																<td style="display: none;">
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" name="bal_amount[]" id="bal_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['balance_amount'].'">
																		'.format_money($property_details['schedule_detail'][$i]['balance_amount'],2).'
																	</div>
																</td>
																<td class="pay_now" style="text-align:right;">
																	<div class="form-group form-group-default ">
																	 <input type="hidden" id="tds_amount_till_date_'.($i+1).'" name="tds_amount_till_date[]" value="'.$tds_amount_till_date.'" style="text-align:right;">
																			'.format_money($tds_amount_till_date,2).'
																		<!-- </a> -->
																	</div>
																</td>								<td class="pay_now">
																	<div class="form-group form-group-default text-right">
																		<select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple style="display: none;">';
																		if(isset($property_details['allTaxes'])) {
																			foreach($property_details['allTaxes'] as $row) {
																				$tax=$row->tax_id.'_'.$row->tax_percent;
																				if(strpos($tax_applied, $tax)!==false) {
																					echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" selected>'.$row->tax_name.'-'.$row->tax_percent.'</option>';	
																				} else {
																					echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';
																				}
																			} 	
																		}
																		echo '</select>
																		<input type="text" id="tds_amount_'.($i+1).'" name="tds_amount[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getDifferneceAmt();" value="'.format_money($property_details['schedule_detail'][$i]['tds_amount_paid'],2).'" '.$disabled.'/>
																	</div>
																</td>
																<td class="pay_now">
																	<div class="form-group form-group-default text-right">
																		<input type="text" id="actual_amount_'.($i+1).'" name="actual_amount[]" class="form-control format_number" style="border:none; text-align:right;" onblur="getDifferneceAmt();" value="'.format_money($property_details['schedule_detail'][$i]['amount_paid_pending'],2).'" '.$disabled.'/>
																	</div>
																</td>';

														if(isset($property_details['txn_type'])) {
															if($property_details['txn_type']=="loan") {
																echo '<td>
																	<div class="form-group form-group-default">
																		<select id="int_type_'.($i+1).'" name="int_type[]" onblur="setIntRate($(this));" '.$disabled.'>
																			<option value="">Select</option>
																			<option value="Fixed" '.(($property_details['schedule_detail'][$i]['int_type']=="Fixed")?"selected":"").'>Fixed</option>
																			<option value="Floating" '.(($property_details['schedule_detail'][$i]['int_type']=="Floating")?"selected":"").'>Floating</option>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="form-group form-group-default">
																		<input type="text" id="int_rate_'.($i+1).'" name="int_rate[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getTotOutstanding();" value="'.$property_details['schedule_detail'][$i]['int_rate'].'" '.$disabled.'/>
																	</div>
																</td>
																<td>
																	<div class="form-group form-group-default">
																		<input type="hidden" id="interest_'.($i+1).'" name="interest[]" class="form-control" style="border: none;" />
																		<span id="interest_text_'.($i+1).'"></span>
																	</div>
																</td>
																<td>
																	<div class="form-group form-group-default">
																		<input type="hidden" id="principal_'.($i+1).'" name="principal[]" class="form-control" style="border: none;" />
																		<span id="principal_text_'.($i+1).'"></span>
																	</div>
																</td>
																<td>
																	<div class="form-group form-group-default">
																		<input type="hidden" id="tot_outstanding_'.($i+1).'" name="tot_outstanding[]" class="form-control" style="border: none;" />
																		<span id="tot_outstanding_text_'.($i+1).'"></span>
																	</div>
																</td>';
															}
														}

														echo '<td class="pay_now">
																	<div class="form-group form-group-default text-right">
																		<input type="hidden" name="balance[]" id="balance_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['balance_amount'].'">
																		<span id="difference_'.($i+1).'">'.format_money($property_details['schedule_detail'][$i]['balance_amount'],2).'</span>
																	</div>
																</td>
															</tr>';

														$i++;
													}
												} else {
													$disabled='';

													$tax_applied='';

													echo '<tr class="table_head2 sch_cnt">
															<td>
																<div class="form-group form-group-default">
																	<input type="hidden" name="fk_txn_id[]" id ="fk_txn_id_'.($i+1).'" value="">
																	<input type="hidden" name="transaction[]" id ="transaction_'.($i+1).'" value="'.(($type=='receipt' || $type=='income')?"receipt":"payment").'">
																	'.(($type=="receipt" || $type=="income")?"Income":"Expense").'
																</div>
															</td>
															<td style="display: none;">
																<div class="form-group form-group-default">
																	<input type="hidden" name="event_type[]" id ="event_type_'.($i+1).'" value="">
																</div>
															</td>
															<td style="display: none;">
																<div class="form-group form-group-default">
																	<input type="hidden" name="event_name[]" id ="event_name_'.($i+1).'" value="">
																</div>
															</td>
															<td>
																<div class="form-group form-group-default">
																	<input type="text" class="form-control" name="event_date[]" id ="event_date_'.($i+1).'" value="">
																</div>
															</td>
															<td style="'.(($bl_other_schedue=='true')?'display: none;':'').'">
																<div class="form-group form-group-default">
																	<input type="hidden" name="invoice_no[]" id ="invoice_no_'.($i+1).'" value="">
																</div>
															</td>
															<td style="display: none;">
																<input type="checkbox" name="late_fee[]" id ="late_fee_'.($i+1).'" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />
															</td>';


													if($bl_other_schedue=="true") {
														echo '<td> 	
															<div class="form-group form-group-default form-group-default-select2">
																<select id="category_'.($i+1).'" name="category[]" class="full-width" data-error="#category_err_'.($i+1).'" data-placeholder="Select Category" data-init-plugin="select2">
																<option value="">Select Category</option>';

															if(isset($expense_category)) {
																foreach($expense_category as $row) {
																	echo '<option value="'.$row->id.'" >'.$row->expense_category.'</option>';
																}
															}

														echo '</select>
																<div id="category_err_'.($i+1).'"></div>
															</div>
														</td>';
													}


													echo '<td>
																<div class="form-group form-group-default text-right">
																	<input type="text" name="basic_amount[]" id="basic_amount_'.($i+1).'" class="form-control format_number" value="" onblur="setTotalAmount(this);">
																</div>
															</td>';
															
													if($bl_other_schedue=="true") {
														echo '<td>
															<div class="form-group form-group-default">
																<input type="text" id="gst_rate_'.($i+1).'" name="gst_rate[]" class="form-control format_number" style="border: none; text-align:right;" onblur="setTotalAmount(this);" value="" />
															</div>
														</td>';
													}

													echo '<td>
																<div class="form-group form-group-default text-right">
																	<input type="hidden" name="tax_amount[]" id="tax_amount_'.($i+1).'" value="">
																	<span id="tax_amount_text_'.($i+1).'">0</span>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default text-right">
																	<input type="hidden" name="net_amount[]" id="net_amount_'.($i+1).'" value="">
																	<span id="net_amount_text_'.($i+1).'">0</span>
																</div>
															</td>';
													
													if($bl_other_schedue=="true") {
														echo '<td>
															<div class="form-group form-group-default">
																<input type="checkbox" class="toggle" id="pay_now_'.($i+1).'" name="pay_now[]" onChange="setPayNow(this);" value="1" />
															</div>
														</td>';
													}

													echo '<td>
																<div class="form-group form-group-default text-right">
																	<input type="hidden" id="paid_till_date_'.($i+1).'" name="paid_amount[]" value="0">
																	<input type="hidden" id="paid_till_date_actual_'.($i+1).'" name="paid_amount_actual[]" value="0">
																	0
																</div>
															</td>
															<td style="display: none;">
																<div class="form-group form-group-default text-right">
																	<input type="hidden" name="bal_amount[]" id="bal_amount_'.($i+1).'" value="">
																	<span id="bal_amount_text_'.($i+1).'">0</span>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default text-right">
																	<select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple style="display: none;">';
																	if(isset($property_details['allTaxes'])) {
																		foreach($property_details['allTaxes'] as $row) {
																			echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';
																		} 	
																	}
																	echo '</select>
																	<input type="text" id="tds_amount_'.($i+1).'" name="tds_amount[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getDifferneceAmt();" value="" '.$disabled.'/>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default text-right">
																	<input type="text" id="actual_amount_'.($i+1).'" name="actual_amount[]" class="form-control format_number" style="border:none; text-align:right;" onblur="getDifferneceAmt();" value="" '.$disabled.'/>
																</div>
															</td>';

													if(isset($property_details['txn_type'])) {
														if($property_details['txn_type']=="loan") {
															echo '<td>
																<div class="form-group form-group-default">
																	<select id="int_type_'.($i+1).'" name="int_type[]" onblur="setIntRate($(this));" '.$disabled.'>
																		<option value="">Select</option>
																		<option value="Fixed">Fixed</option>
																		<option value="Floating">Floating</option>
																	</select>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default">
																	<input type="text" id="int_rate_'.($i+1).'" name="int_rate[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getTotOutstanding();" value="" '.$disabled.'/>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default">
																	<input type="hidden" id="interest_'.($i+1).'" name="interest[]" class="form-control" style="border: none;" />
																	<span id="interest_text_'.($i+1).'"></span>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default">
																	<input type="hidden" id="principal_'.($i+1).'" name="principal[]" class="form-control" style="border: none;" />
																	<span id="principal_text_'.($i+1).'"></span>
																</div>
															</td>
															<td>
																<div class="form-group form-group-default">
																	<input type="hidden" id="tot_outstanding_'.($i+1).'" name="tot_outstanding[]" class="form-control" style="border: none;" />
																	<span id="tot_outstanding_text_'.($i+1).'"></span>
																</div>
															</td>';
														}
													}

													echo '<td>
																<div class="form-group form-group-default text-right">
																	<input type="hidden" name="balance[]" id="balance_'.($i+1).'" value="">
																	<span id="difference_'.($i+1).'">0</span>
																</div>
															</td>
														</tr>';
												}
												?>
												
											</tbody>
											<tfoot>
												<tr>
													<td style="padding: 5px !important; text-align:left;">Total Amount</td>
													<td style="display: none;"></td>
													<td style="display: none;"></td>
													<td></td>
													<td style="<?php echo (($bl_other_schedue=='true')?'display: none;':''); ?>"></td>
													<td style="display: none;"></td>

													<?php if($bl_other_schedue=="true") { ?>
															<td></td>
													<?php } ?>

													<td id="tot_amount" class="text-right"></td>

													<?php if($bl_other_schedue=="true") { ?>
															<td></td>
													<?php } ?>

													<td id="tot_tax" class="text-right"></td>
													<td id="tot_budget" class="text-right"></td>
													<td id="tot_pending" class="text-right" style="display: none;"></td>

													<?php if($bl_other_schedue=="true") { ?>
															<td></td>
													<?php } ?>

													<td id="tot_paid" class="text-right pay_now"></td>
													<td id="tot_tds_paid" class="pay_now"></td>
													<td id="tot_tds" class="text-right pay_now"></td>
													<td id="tot_received" class="text-right pay_now"></td>

													<?php if(isset($property_details['txn_type'])) {
														if($property_details['txn_type']=="loan") { ?>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
													<?php }} ?>

													<td id="tot_outstanding" class="text-right pay_now"></td>
												</tr>
											</tfoot>
										</table>
									</div>

									<div class="row clearfix p-t-20" id="schedule_tax_detail" style="display: none;">
									
									</div>

									<div class="add_dtl m-t-20">
										<div class="row clearfix ">
											<div class="col-md-4 m-t-20 pay_now">
												<div class="form-group form-group-default form-group-default-select2 ">
													<label class=""> Method</label>
													<select class="full-width" id="payment_mode" name="payment_mode" onchange="checkMode();" data-error="#err_payment_mode" data-placeholder="Select Method" data-init-plugin="select2">
														<option value="">Select</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='Cheque') echo 'selected';}?>>Cheque</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='Cash') echo 'selected';}?>>Cash</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT') echo 'selected';}?>>NEFT</option>
													</select>
		                                            <div id="err_payment_mode"></div>
												</div>
											</div>
											<div class="col-md-4 m-t-20 pay_now">
												<div class="form-group form-group-default form-group-default-select2 ">
													<label class=""> Bank A/C</label>
													<select class="full-width auto_bank" id="bank_acc" name="account_number" data-error="#err_account_number" data-placeholder="Select Bank" data-init-plugin="select2">
														<option value="">Select</option>
		                                                <?php for ($k=0; $k < count($banks) ; $k++) { ?>
		                                                    <option value="<?php echo $banks[$k]->b_id; ?>" <?php if (isset($property_details['account_number'])) {if($banks[$k]->b_id==$property_details['account_number']) { echo 'selected'; }} ?>><?php echo $banks[$k]->bank_detail; ?></option>
		                                                <?php } ?>
													</select>
		                                            <div id="err_account_number"></div>
												</div>
											</div>
											<div class="col-md-4 m-t-20" id="payment_id_details" style="<?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT' || $property_details['payment_mode']=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
												<div class="form-group form-group-default ">
													<label><?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT') echo 'Ref No'; else echo 'Cheque No';} else echo 'Cheque No';?></label>
													<input type="text" class="form-control " id="cheq_no" name="cheq_no" value="<?php if (isset($property_details['cheque_no'])) echo $property_details['cheque_no'];?>"/>
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label class=""> Narration</label>
													<input type="text" class="form-control" value="<?php if(isset($property_details['maker_remark'])){ echo $property_details['maker_remark'];}?>" readonly />
												</div>
											</div>
											<div class="col-md-6" style="<?php if($maker_checker!='yes') echo 'display: none;'; ?>">
												<div class="form-group form-group-default">
													<label class=""> Checker Narration</label>
													<input type="text" class="form-control" value="<?php if(isset($property_details['remarks'])){ echo $property_details['remarks'];}?>" readonly />
												</div>
											</div>
										</div>
										<div class="row clearfix" style="<?php if($maker_checker!='yes') echo 'display: none;'; ?>">
											<div class="col-md-8">
												<div class="form-group form-group-default">
													<label class=""> Checker Narration</label>
													<input type="text" id="status_remarks" name="status_remarks" class="form-control" value="<?php if(isset($property_details['status_remarks'])){ echo $property_details['status_remarks'];}?>" />
												</div>
											</div>
											<div class="col-md-4"></div>
										</div>
									</div>
								</div>
								<div class="row clearfix pay_now">
									<div class="col-md-8">
									</div>
									<div class="col-md-4">
										<div class="total_amt">
											<h5>Total</h5>
											<h1> &#x20a8 <span id="tot_actual_amount">18,000</span></h1>
										</div>
									</div>
								</div>
								<div class="form-footer" style="padding-bottom: 60px; display: none;">
									<input type="hidden" id="submitVal" value="1" />
		                        	<a href="<?php echo base_url();?>index.php/accounting" class="btn btn-danger" >Cancel</a>
		                            <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
		                            <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($editrent)) echo 'display:none'; ?>" />
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

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

	var tot_sch=parseInt(<?php echo isset($property_details['schedule_detail'])?count($property_details['schedule_detail']):0;?>);
	var int_rate_elem_val=parseInt(<?php echo isset($property_details['int_rate'])?format_number($property_details['int_rate'],2):0;?>);
	var tot_outstanding=parseInt('<?php echo isset($property_details['tot_outstanding'])?format_number($property_details['tot_outstanding'],2):0;?>');
	var last_paid_date_val='<?php echo isset($property_details['last_paid_date'])?date("d/m/Y",strtotime($property_details['last_paid_date'])):0;?>';
    var loan_dataString = 'txn_id=' + <?php echo isset($property_details['loan_txn_id'])?$property_details['loan_txn_id']:0; ?>;
    var expense_dataString = 'expense_category_id=' + <?php echo isset($property_details['expense_category_id'])?$property_details['expense_category_id']:0; ?>;
	var property_id = '<?php echo isset($property_details['property_id'])?$property_details['property_id']:0; ?>';
    var sub_property_id = '<?php echo isset($property_details['sub_property_id'])?$property_details['sub_property_id']:0; ?>';
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/accounting.js"></script>

<script type="text/javascript">
	$("input").attr("readonly", true);
	$("#status_remarks").attr("readonly", false);
    $("select").attr("disabled", true);
    $("#txtstatus").attr("readonly", false);
</script>

</body>
</html>