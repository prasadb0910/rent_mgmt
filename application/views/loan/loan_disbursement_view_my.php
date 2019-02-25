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
			<form id="form_loan_disbursement_view" role="form" method ="post" action="<?php echo base_url().'index.php/Loan_disbursement/update/'.$l_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Loan_disbursement/checkstatus/All">Loan_disbursement List</a></li>
					<li class="breadcrumb-item active">Loan_disbursement View</li>
				</ol>
				<div class="container">
					<div class="row m-t-20">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Loan_disbursement'; ?>">
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
											<a href="<?php echo base_url().'index.php/Loan_disbursement/edit/'.$l_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
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
			                        <div class="a" id="loan_details">
			                            <p class="m-t-20"><b>Loan Details</b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Loan Ref Id </label>
			                                        <select  class="form-control full-width" id="loan_ref_name" name="loan_id" data-placeholder="Select Loan Ref Id" data-init-plugin="select2">
			                                            <option value=""> Select Loan </option>
			                                            <?php if(isset($loan_txn)) { if(isset($editloan[0]->loan_id)) { 
			                                                for($i=0; $i<count($loan_txn); $i++) { ?>
			                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>" <?php if($editloan[0]->loan_id == $loan_txn[$i]->txn_id) { echo 'selected';} ?> ><?php echo $loan_txn[$i]->ref_id; ?></option>
			                                            <?php } } else { ?>
			                                                    <?php for($i=0; $i<count($loan_txn); $i++) { ?>
			                                                    <option value="<?php echo $loan_txn[$i]->txn_id; ?>"><?php echo $loan_txn[$i]->ref_id; ?></option>
			                                            <?php } } } ?>
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Loan Ref Name </label>
			                                        <input type="text" class="form-control " id="loan_ref_id" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_ref_id;} ?>" readonly>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Loan Type</label>
			                                        <input type="text" class="form-control " id="loan_type" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_type;} ?>" readonly >
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Amount</label>
			                                        <input type="text" class="form-control " id="loan_amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>" readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default  ">
			                                        <label>Loan Start Date</label>
			                                        <input id="start_date" type="text" class="form-control " name="loan_start_date" id="loan_start_date" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>" readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Loan Due Day</label>
			                                        <input type="text" class="form-control" name="loan_due_day" id="loan_due_day" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?>" readonly >
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Term (In months) </label>
			                                        <input type="text" class="form-control " id="loan_term" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>" readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Interest Type</label>
			                                        <input type="text" class="form-control " id="loan_interest_type" value="<?php if(isset($editloan)) { echo $editloan[0]->loan_interest_type;} ?>" readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Interest Rate (In %) </label>
			                                        <input type="text" class="form-control " id="loan_interest_rate" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>" readonly >
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Financial Institution</label>
			                                        <input type="text" class="form-control " id="financial_institution" value="<?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?>"  readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Repayment </label>
			                                        <input type="text" class="form-control " id="repayment" value="<?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?>" readonly >
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Purpose </label>
			                                        <input type="text" class="form-control " id="purpose" value="<?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?>" readonly >
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="a">
			                            <p class=""><b>Loan Disbursement<b></p>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label> Ref Id </label>
			                                        <input type="text" class="form-control" name="ref_id" placeholder="Ref Id" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label> Ref Name</label>
			                                        <input type="text" class="form-control" name="ref_name" placeholder="Ref Name" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>Disbursement Amount </label>
			                                        <input type="text" class="form-control format_number" name="disbursement_amount" id="disbursement_amount" placeholder="Disbursement Amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->disbursement_amount,2);} ?>"/>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default ">
			                                        <label>Disbursement Date</label>
			                                        <input type="text" class="form-control datepicker" name="disbursement_date" id="disbursement_date" placeholder="Disbursement Date" value="<?php if(isset($editloan)) { if($editloan[0]->disbursement_date!=null && $editloan[0]->disbursement_date!='') echo date('d/m/Y',strtotime($editloan[0]->disbursement_date));} ?>">
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default">
			                                        <label>EMI </label>
			                                        <input type="text" class="form-control format_number" name="emi" id="emi" placeholder="EMI" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->emi,2);} ?>"/>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label>Issuer Bank A/C  </label>
			                                        <select class="form-control full-width" id="issuer_bank_acc" name="issuer_bank_id" data-placeholder="Select Issuer Bank A/C" data-init-plugin="select2">
			                                            <option value=""> Select Issuer Bank A/C </option>
			                                            <?php if(isset($bank)) { if(isset($editloan[0]->issuer_bank)) { 
			                                                for($i=0; $i<count($bank); $i++) { ?>
			                                                    <option value="<?php echo $bank[$i]->b_id; ?>" <?php if($editloan[0]->issuer_bank == $bank[$i]->b_id) { echo 'selected';} ?> ><?php echo $bank[$i]->b_name; ?></option>
			                                            <?php } } else { ?>
			                                                    <?php for($i=0; $i<count($bank); $i++) { ?>
			                                                    <option value="<?php echo $bank[$i]->b_id; ?>"><?php echo $bank[$i]->b_name; ?></option>
			                                            <?php } } } ?>
			                                        </select>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row clearfix">
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label>Receiver Bank A/C</label>
			                                        <select class="form-control full-width" id="receiver_bank_acc" name="receiver_bank_id" data-placeholder="Select Receiver Bank A/C" data-init-plugin="select2">
			                                            <option value=""> Select Receiver Bank A/C </option>
			                                            <?php if(isset($bank)) { if(isset($editloan[0]->receiver_bank)) { 
			                                                for($i=0; $i<count($bank); $i++) { ?>
			                                                    <option value="<?php echo $bank[$i]->b_id; ?>" <?php if($editloan[0]->receiver_bank == $bank[$i]->b_id) { echo 'selected';} ?> ><?php echo $bank[$i]->b_name; ?></option>
			                                            <?php } } else { ?>
			                                                    <?php for($i=0; $i<count($bank); $i++) { ?>
			                                                    <option value="<?php echo $bank[$i]->b_id; ?>"><?php echo $bank[$i]->b_name; ?></option>
			                                            <?php } } } ?>
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="col-md-4">
			                                    <div class="form-group form-group-default form-group-default-select2">
			                                        <label class="">Payment Mode </label>
			                                        <select class="form-control full-width" id="payment_mode" name="payment_mode" data-placeholder="Select Payment Mode" data-init-plugin="select2">
			                                            <option value="">Select</option>
			                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cheque') echo 'selected';}?>>Cheque</option>
			                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='Cash') echo 'selected';}?>>Cash</option>
			                                            <option <?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT') echo 'selected';}?>>NEFT</option>
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="col-md-4" id="payment_id_details" style="<?php if(isset($editloan)) {if($editloan[0]->payment_mode=='NEFT' || $editloan[0]->payment_mode=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
			                                    <div class="form-group form-group-default">
			                                        <label id="payment_id_type"><?php if(isset($editloan[0]->payment_mode)) {if($editloan[0]->payment_mode=='NEFT') echo 'Ref No'; else echo 'Cheque No';} else echo 'Cheque No';?></label>
			                                        <input type="text" class="form-control" id="cheq_no" name="cheq_no" value="<?php if (isset($editloan[0]->cheque_no)) echo $editloan[0]->cheque_no;?>" />
			                                    </div>
			                                </div>
			                            </div>
			                        </div>

			                        <div class="a">
			                            <p class="m-t-20"><b> Loan Consideration<b></p>
			                            <div id="temp_schedule_div"></div>
			                            <?php if(isset($p_schedule)) { ?>
			                            <div class="row clearfix" id="actual_schedule_div">
			                                <div class="col-md-12">
			                                    <table class="view_table addsummary">
			                                        <thead>
			                                            <tr>
			                                                <th width="55">Sr. No.</th>
			                                                <th width="120">Type</th>
			                                                <th width="120">Total Cost (In &#x20B9;)</th>

			                                                <?php //print_r($tax_name);
			                                                    if(isset($tax_name)){
			                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
			                                                        $key=0;
			                                                        foreach($tax_name as $row){
			                                                            echo '<th style="text-align: center;vertical-align: middle;">'.$row->tax_type.' (In &#x20B9;)</th>';
			                                                            $tax_array[$key]=$row->tax_type;
			                                                            $key++;
			                                                        } 
			                                                       //echo '</tr></table></th>';
			                                                      // print_r($tax_array);
			                                                    }
			                                                ?>

			                                                <th width="120">Net Cost (In &#x20B9;)</th>

			                                            </tr>
			                                        </thead>
			                                        <tbody>
			                                            <?php //print_r($p_schedule);?>
			                                            <?php 
			                                                $j=0;
			                                                $total_basic_cost=0;
			                                                $total_net_amount=0;
			                                                $total_tax_array=array();
			                                                foreach($p_schedule as $row_tax) {
			                                                    echo '<tr>
			                                                    <td >'.($j+1).'</td>
			                                                    <td>'.$row_tax["event_type"].'</td>
			                                                    <td >'.format_money($row_tax["basic_cost"],2).'</td>';
			                                                    $total_basic_cost=$total_basic_cost+$row_tax["basic_cost"];
			                                                    $next_count=0;
			                                                    $td_count=0;
			                                                    // print_r($p_schedule);
			                                                    if(isset($row_tax['tax_type'])) {
			                                                        // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
			                                                        //echo "<br>hi";
			                                                        // echo $key;
			                                                        for($tcnt=0;$tcnt<$key;$tcnt++){
			                                                            //echo "step1--";
			                                                            for($nc=0;$nc<count($row_tax['tax_type']);$nc++){
			                                                                $tax_amount='';
			                                                                if($row_tax['tax_type'][$nc]==$tax_array[$tcnt]){
			                                                                    $tax_amount=$row_tax['tax_amount'][$nc];
			                                                                    $nc=count($row_tax['tax_type']);
			                                                                    //$tcnt=$key;
			                                                                    //}
			                                                                }
			                                                            }
			                                                            if($tax_amount !=''){
			                                                                echo '<td >'.format_money($tax_amount,2).'</td>';
			                                                                $td_count++;
			                                                            }
			                                                            else{
			                                                                //if($next_count )
			                                                                echo '<td >'.format_money($tax_amount,2).'</td>';
			                                                                $td_count++;
			                                                            }
			                                                            // $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
			                                                            //  $total_tax_array[$tcnt]= $tax_amount;
			                                                            // print_r($total_tax_array);
			                                                        }
			                                                    }
			                                                    $inserttd=$key-$td_count;
			                                                    if($inserttd !=0){
			                                                        for($tdint=0;$tdint<$inserttd;$tdint++){
			                                                            echo "<td></td>";
			                                                        }
			                                                    }

			                                                    echo '<td >'.format_money($row_tax["net_amount"],2).'</td></tr>';
			                                                    $total_net_amount=$total_net_amount+$row_tax["net_amount"];
			                                                    //print_r($p_schedule[$j]['event_type']);
			                                                    $j++;
			                                                }
			                                             ?>

			                                            <tr>
			                                                <td colspan="2" style="text-align:left;"><b>Grand Total  (In &#x20B9;) </b></td>
			                                                <td style="text-align:right;"><?php echo format_money($total_basic_cost,2);?></td>
			                                                <?php  $k=0;if(isset($total_tax_amount)) {
			                                                foreach($total_tax_amount as $row){
			                                                    echo '<td style="text-align:right;">'.format_money($total_tax_amount[$k],2).'</td>';
			                                                    $k++;
			                                                } } ?>
			                                               <td style="text-align:right;"><?php echo format_money($total_net_amount,2); ?></td>
			                                            </tr>
			                                        </tbody>
			                                    </table>
			                                </div>
			                            </div>
			                            <?php } ?>
			                        </div>
			                    </div>

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