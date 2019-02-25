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
			<form id="form_loan_view" role="form" method ="post" action="<?php echo base_url().'index.php/Loan/update/'.$l_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Loan/checkstatus/All">Loan List</a></li>
					<li class="breadcrumb-item active">Loan View</li>
				</ol>
				<div class="container">
					<div class="row m-t-20">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Loan'; ?>">
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
											<a href="<?php echo base_url().'index.php/Loan/edit/'.$l_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($editloan)) { ?>
										<?php if($editloan[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } else if($editloan[0]->modified_by != '' && $editloan[0]->modified_by != null) { if($editloan[0]->modified_by!=$loanby) { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($editloan[0]->created_by != '' && $editloan[0]->created_by != null) { if($editloan[0]->created_by!=$loanby && $editloan[0]->txn_status != 'In Process') { if($editloan[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
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
											<div class="bg-master text-center text-white" style=" background: #41c997;text-align: center; size:28px;align-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span><?php echo (strlen($editloan[0]->c_name)>0?substr($editloan[0]->c_name, 0, 1):'') . (strlen($editloan[0]->c_last_name)>0?substr($editloan[0]->c_last_name, 0, 1):''); ?></span>
											</div>  
										</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>
										<div class="info">
											<H5 class="title_1"><?php echo $editloan[0]->c_name . ' ' . $editloan[0]->c_last_name; ?></H5>
											<p class="email"><?php echo $editloan[0]->c_emailid1; ?></p>
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
							<p class="created_date">Created on <?php if(isset($editloan)) { echo ($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='')?date('d/m/Y',strtotime($editloan[0]->loan_startdate)):''; } ?></p>
						</div>
						<div class="col-md-9">
							<div class=" container-fluid container-fixed-lg bg-white">
			                    <div class="card card-transparent">
			                        <div class="a">
			                            <p class="m-t-20"><b>Owner Details<b></p>
			                            <br>
			                            <div id="repeatborrower">

			                                <?php $j=0; if(isset($editborower)) { 
			                                    for ($j=0; $j < count($editborower) ; $j++) { ?>

			                                <div id="repeat_borrower_<?php echo $j+1; ?>" class="row clearfix">
			                                    <div class="col-md-5">
			                                        <div class="form-group form-group-default form-group-default-select2">
			                                            <label class="">Owner</label>
			                                            <select id="borrower_<?php echo $j+1; ?>" name="borrower[]" class="form-control borrower full-width select2" data-error="#err_borrower_<?php echo $j+1; ?>" data-placeholder="Select Owner" data-init-plugin="select2">
			                                                <option value="">Select</option>
			                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
			                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$editborower[$j]->brower_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
			                                                <?php } ?>
			                                            </select>
			                                            <div id="err_borrower_<?php echo $j+1; ?>"></div>
			                                        </div>
			                                    </div>
			                                </div>

			                                <?php } } ?>

			                            </div>
			                        </div>
			                        <div class="a">
			                            <p class=""><b>Loan Details<b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Loan Ref Id </label>
			                                        <input type="text" class="form-control" id="ref_id" name="ref_id" placeholder="Loan Ref Id" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Loan Ref Name</label>
			                                        <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder="Loan Ref Name" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Loan Type </label>
			                                        <select class="form-control full-width" id="loan_type" name="loan_type" data-placeholder="Select Loan Type" data-init-plugin="select2">
			                                            <option value="">Select</option>
			                                            <option value="LAP" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='LAP') { echo "selected";} } ?>> LAP </option>
			                                            <option value="Overdraft" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Overdraft') { echo "selected";} }?>> Overdraft </option>
			                                            <option value="Normal" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Normal') { echo "selected";} } ?>> Normal </option>
			                                        </select>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Amount</label>
			                                        <input type="text" class="form-control format_number" name="amount" id="amount" placeholder="Amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>"/>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Loan Start Date</label>
			                                        <input type="text" class="form-control datepicker" name="loan_start_date" id="loan_start_date" placeholder="Loan Start Date" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>">
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Loan Due Day</label>
			                                        <select class="form-control full-width" name="loan_due_day" id="loan_due_day" data-placeholder="Select Loan Due Day" data-init-plugin="select2">
			                                            <option value="">Select</option>
			                                            <?php if(isset($editloan) && count($editloan)>0) {
			                                                    for($i=1; $i<=31; $i++) { 
			                                                        if($editloan[0]->loan_due_day==$i) echo '<option selected>'.$i.'</option>'; 
			                                                        else echo '<option>'.$i.'</option>';}} 
			                                            else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
			                                        </select>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Term (In months) </label>
			                                        <input type="text" class="form-control format_number" name="term" id="term" placeholder="Term" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>"/>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Interest Type</label>
			                                        <select class="form-control full-width" name="interest_type" data-placeholder="Select Interest Type" data-init-plugin="select2">
			                                            <option value="">Select</option>
			                                            <option value="Fixed" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Fixed') { echo "selected";} } ?>> Fixed </option>
			                                            <option value="Float" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Float') { echo "selected";} }?>> Float </option>
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Interest Rate (In %) </label>
			                                        <input type="text" class="form-control" name="interest_rate" placeholder="Interest Rate" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>"/>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Financial Institution</label>
			                                        <input type="text" class="form-control" name="financial_institution" placeholder="Financial Institution" value="<?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?>"/>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Repayment </label>
			                                        <input type="text" class="form-control" name="repayment" placeholder="Repayment" value="<?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?>"/>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Purpose </label>
			                                        <input type="text" class="form-control" name="purpose" placeholder="Purpose" value="<?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?>"/>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="a">
			                            <p class="m-t-20"><b>Security<b></p>
			                            <div id="repeatproperty">

			                                <?php $j=0; if(isset($editproperty)) { 
			                                    for ($j=0; $j < count($editproperty) ; $j++) { ?>

			                                <div id="repeat_property_<?php echo $j+1; ?>" class="row clearfix">
			                                    <div class="col-md-5">
			                                        <div class="form-group form-group-default form-group-default-select2">
			                                            <label class="">Select Property</label>
			                                            <input type="hidden" id="loan_property_id_<?php echo $j+1;?>" name="loan_property_id[]" value="<?php if(isset($editproperty[$j])) echo $editproperty[$j]->id; ?>" />
			                                            <select id="property_<?php echo $j+1; ?>" name="property_id[]" class="form-control property full-width select2" data-error="#err_property_<?php echo $j+1; ?>" data-placeholder="Select Property" data-init-plugin="select2">
			                                                <option value="">Select Property</option>
			                                                <?php for($i=0; $i<count($property); $i++) { ?>
			                                                        <option value="<?php echo $property[$i]->txn_id; ?>" <?php if($editproperty[$j]->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
			                                                <?php } ?>
			                                            </select>
			                                            <div id="err_property_<?php echo $j+1; ?>"></div>
			                                        </div>
			                                    </div>
			                                    <div class="col-md-5" id="sub_property_div_<?php echo $j+1;?>" style="display: none;">
			                                        <div class="form-group form-group-default form-group-default-select2">
			                                            <label class="">Select Sub Property</label>
			                                            <select id="sub_property_<?php echo $j+1; ?>" name="sub_property[]" class="form-control full-width select2" data-error="#err_sub_property_<?php echo $j+1; ?>" data-placeholder="Select Sub Property" data-init-plugin="select2">
			                                                <option value="">Select Sub Property</option>
			                                            </select>
			                                            <div id="err_sub_property_<?php echo $j+1; ?>"></div>
			                                        </div>
			                                    </div>
			                                </div>

			                                <?php }} ?>

			                            </div>
			                        </div>
			                    </div>

			                    <?php $this->load->view('templates/document_view');?>

								<p class="m-t-20"><b>Remark<b></p>
								<div class="row clearfix" style="padding-bottom: 25px;">
									<div class="col-md-6">
										<div class="form-group form-group-default ">
											<label> Maker Remarks </label>
											<input type="text" class="form-control "  value="<?php if (isset($editloan)) { echo $editloan[0]->maker_remark; } ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default ">
											<label> Checker Remarks </label>
											<input type="text" class="form-control "  value="<?php if (isset($editloan)) { echo $editloan[0]->txn_remarks; } ?>" readonly>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group form-group-default " style="border:1px solid rgba(0,0,0,0.07)!important; ">
											<label>Remark</label>
											<input type="text" class="form-control " id="txtstatus" name="status_remarks" value="<?php if(isset($editloan[0])){ echo $editloan[0]->txn_remarks; } else { echo ''; }?>">
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

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';

    <?php
        $property_details = '<option value="">Select</option>';
        if(isset($property)) {
            for($i=0; $i<count($property); $i++) {
                $property_details = $property_details . '<option value="'.$property[$i]->txn_id.'">'.str_replace("'","",$property[$i]->p_property_name).'</option>';
            }
        }
    ?>
    var property_details = '<?php echo $property_details; ?>';

    var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
    var tax = new Array();
    var taxname=new Array();
    var taxpurpose=new Array();
    window.cntrinst=0;

    <?php for ($i=0; $i < count($tax) ; $i++) { ?>
        tax.push('<?php echo $tax[$i]->tax_percent; ?>');
        taxname.push('<?php echo $tax[$i]->tax_name; ?>');
        taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
    <?php } ?>

    <?php 
        $tax_list_details = '<option value="">Select</option>';
        if(isset($tax_details)){
            foreach($tax_details as $row){
                $tax_list_details = $tax_list_details . '<option value="'.$row->tax_id.'">'.str_replace("'","",$row->tax_name).'-'.$row->tax_percent.'</option>';
            }
        }
    ?>
    var tax_list_details = '<?php echo $tax_list_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/loan.js"></script>

<script type="text/javascript">
	$("input").attr("readonly", true);
    $("select").attr("disabled", true);
    $("#txtstatus").attr("readonly", false);
</script>
</body>
</html>