<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		<style>
		.addschedule td{
			border:1px solid;
			padding:0px !important;
			    vertical-align: middle !important;
		}
		.addschedule th{
			border:1px solid;
		}
		.addsummary td{
			border:1px solid;
			    vertical-align: middle;
			padding:0px !important;
		}
		.addsummary th{
			border:1px solid;
		}
		.addtax td{
			border:1px solid;
			
			padding:0px !important;
		}
		.addtax th{
			border:1px solid;
		}
		</style>
		<style type="text/css">
			.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
			.file-input-wrapper .fileinput { overflow:hidden;}
			.padding-height {padding:6px 10px; overflow:hidden;}
			.table { margin-bottom:0;}
			#schedule_tax_detail .table th { border:1px solid #ddd!important;}
			#schedule_tax_detail .table tr { border:1px solid #ddd!important;}
			#schedule_tax_detail .table td { border:1px solid #ddd!important;}

			.table tr td { padding:0 5px!important;}
			@media only screen and  (min-width:280px)  and (max-width:1020px) { 
			.addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-'] 
			{ padding:0;  }
			#ptype { margin:0!important;}
			.datepicker{ margin:0!important;}
			.custom-padding .col-md-7 { padding:0!important;}
			.custom-padding .col-md-3 { padding:4px!important;}
			.custom-padding .abs { margin:0!important;}
			.custom-padding .repeatimg .abs { margin:0!important;}
			.custom-padding .btn-container { margin:10px!important;}
			#actual_schedule_div { overflow-x:scroll;}
			#temp_schedule_div { overflow-x:scroll;}
			}	
	    </style>
    </head>

    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
				    <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/bank_entry'; ?>" > Bank Entry List</a>  &nbsp; &#10095; &nbsp; Bank Entry Details </div>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                     <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding">  	
							<?php 
								$action = "";
								if(isset($property_details['bank_entry_id']) && $property_details['bank_entry_id']!='') { 
									if (isset($property_details['other_expense'])) {
										if($property_details['other_expense']=='true') {
											$action = base_url().'index.php/bank_entry/updateOtherExpense/'.$property_details['bank_entry_id'].'/'.$property_details['entry_type']; 
										} else {
											$action = base_url().'index.php/bank_entry/updaterecord/'.$property_details['bank_entry_id'].'/'.$property_details['entry_type'];
										}
									} else if (isset($property_details['other_schedule'])) {
										if($property_details['other_schedule']=='true') {
											$action = base_url().'index.php/bank_entry/updateOtherSchedule/'.$property_details['bank_entry_id'].'/'.$property_details['entry_type']; 
										} else {
											$action = base_url().'index.php/bank_entry/updaterecord/'.$property_details['bank_entry_id'].'/'.$property_details['entry_type'];
										}
									} else {
										$action = base_url().'index.php/bank_entry/updaterecord/'.$property_details['bank_entry_id'].'/'.$property_details['entry_type'];
									}
								} else {
									$action = base_url().'index.php/bank_entry/saveActualBankEntry';
								} 
							?>

                            <form id="bank_entry_details" role="form" class="form-horizontal" action="<?php echo $action; ?>" method="post">
                            	<input type="hidden" name="fk_txn_id" id="fk_txn_id" value="<?php if (isset($property_details['fk_txn_id'])) echo $property_details['fk_txn_id'];?>">
                                <input type="hidden" name="bank_entry_id" id="bank_entry_id" value="<?php if (isset($property_details['bank_entry_id'])) echo $property_details['bank_entry_id'];?>">
                                <input type="hidden" name="entry_type" id="entry_type" value="<?php if (isset($property_details['entry_type'])) echo $property_details['entry_type'];?>">
                                <input type="hidden" name="created_on" id="created_on" value="<?php if (isset($property_details['created_on'])) echo $property_details['created_on'];?>">
                                <input type="hidden" name="fk_created_on" id="fk_created_on" value="<?php if (isset($property_details['fk_created_on'])) echo $property_details['fk_created_on'];?>">
                                <input type="hidden" name="txn_status" id="txn_status" value="<?php if (isset($property_details['txn_status'])) echo $property_details['txn_status'];?>">
                                <input type="hidden" name="txn_fkid" id="txn_fkid" value="<?php if (isset($property_details['txn_fkid'])) echo $property_details['txn_fkid'];?>">
                            

                            <div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
								<div class="panel-body box-padding" >
								<div class="panel-body">
									<div class="form-group" style="border-top:0px dotted #ddd">
										<div class="col-md-12">
											<div class="col-md-6">
												<label class="col-md-4 control-label">Bank A/C <span  class="asterisk_sign" > * </span> </label>
												<div class="col-md-8">
													<input type="hidden" id="bank_acc_id" name="account_number" class="form-control" value="<?php if (isset($property_details['account_number'])) echo $property_details['account_number'];?>" />
                                                    <input type="text" id="bank_acc" class="form-control auto_bank" name="bank_name" value="<?php if (isset($property_details['b_name'])) echo $property_details['b_name'];?>"/>
												</div>
											</div>
										</div>
										
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label">Mode <span  class="asterisk_sign" > * </span> </label>
												<div class="col-md-8">
													<select class="form-control" id="payment_mode" name="payment_mode">
														<option value="">Select</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='Cheque') echo 'selected';}?>>Cheque</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='Cash') echo 'selected';}?>>Cash</option>
														<option <?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT') echo 'selected';}?>>NEFT</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label">Transaction Date <span  class="asterisk_sign" > * </span> </label>
												<div class="col-md-8">
													<input type="text" class="form-control datepicker" name="payment_date" id="payment_date" value="<?php if (isset($property_details['payment_date'])) {if($property_details['payment_date']!='') echo date("d/m/Y",strtotime($property_details['payment_date'])); else echo date('d/m/Y');} else echo date('d/m/Y');?>" placeholder=""/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group" id="payment_id_details" style="<?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT' || $property_details['payment_mode']=='Cheque') echo ''; else echo 'display:none;';} else echo 'display:none;';?>">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label" id="payment_id_type"><?php if(isset($property_details['payment_mode'])) {if($property_details['payment_mode']=='NEFT') echo 'Ref No<span  class="asterisk_sign" > * </span>'; else echo 'Cheque No<span  class="asterisk_sign" > * </span>';} else echo 'Cheque No<span  class="asterisk_sign" > * </span>';?></label>
												<div class="col-md-8">
													<input type="text" class="form-control " id="cheq_no" name="cheq_no" value="<?php if (isset($property_details['cheque_no'])) echo $property_details['cheque_no'];?>"/>
												</div>
											</div>
										</div>
									</div>
								</div>
				          	<!-- START DATATABLE -->
								<div class="panel-heading">
									<h3 class="panel-title">Bank Entry</h3>
								</div>
								<div class="panel-body">
								 
									<div>
										<div class="form-group" style="border-top:0px dotted #ddd">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label">Type <span  class="asterisk_sign" > * </span> </label>
													<div class="col-md-8">
														<select name="type" id="type" class="form-control">
															<option value="">Select</option>
															<option <?php if (isset($property_details['payment'])) echo $property_details['payment'];?> value="payment" >Payment</option>
															<option <?php if (isset($property_details['receipt'])) echo $property_details['receipt'];?> value="receipt" >Receipt</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label">Transaction <span  class="asterisk_sign" > * </span> </label>
													<div class="col-md-8">
													<select name="status" id="status" class="form-control">
														<?php if ($property_details['payment']=='selected') {?>
																	<option value="">Select</option>
																	<option value="purchase" <?php if (isset($property_details['purchase'])) echo $property_details['purchase'];?> >Property Purchase</option>
																	<option value="loan" <?php if (isset($property_details['loan'])) echo $property_details['loan'];?> >Loan EMI</option>
																	<option value="expense" <?php if (isset($property_details['expense'])) echo $property_details['expense'];?> >Property Expense</option>
																	<option value="maintenance" <?php if (isset($property_details['maintenance'])) echo $property_details['maintenance'];?> >Property Maintenance</option>
																	<option value="other" <?php if (isset($property_details['other'])) echo $property_details['other'];?> >Other</option>
														<?php } else if ($property_details['receipt']=='selected') {?>
																	<option value="">Select</option>
																	<option value="rent" <?php if (isset($property_details['rent'])) echo $property_details['rent'];?> >Rent</option>
																	<option value="sale" <?php if (isset($property_details['sale'])) echo $property_details['sale'];?> >Property Sale</option>
																	<option value="other" <?php if (isset($property_details['other'])) echo $property_details['other'];?> >Other</option>
														<?php } ?>
													</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group col-md-12" id="loan_ref_name_div" style="<?php if (isset($property_details['loan'])) {if($property_details['loan']=='selected') echo ''; else echo 'display: none;';} else echo 'display: none;';?>">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label" style="padding: 10px 0;">Property Name/Loan Ref Name <span  class="asterisk_sign" > * </span></label>
												<div class="col-md-8">
													<select  class="form-control" id="loan_ref_name" name="loan_ref_name">
														<!-- <option value="0">Select Property</option> -->
														<?php if(isset($loan_txn)) { if(isset($property_details['loan_txn_id'])) { 
															for($i=0; $i<count($loan_txn); $i++) { ?>
																<option value="<?php echo $loan_txn[$i]->txn_id; ?>" <?php if($property_details['loan_txn_id'] == $loan_txn[$i]->txn_id) { echo 'selected';} ?> ><?php echo $loan_txn[$i]->ref_name; ?></option>
														<?php } } else { ?>
																<?php for($i=0; $i<count($loan_txn); $i++) { ?>
																<option value="<?php echo $loan_txn[$i]->txn_id; ?>"><?php echo $loan_txn[$i]->ref_name; ?></option>
														<?php } } } ?>
													</select>
												</div>
											</div>
										</div>
										</div>
										<div class="form-group col-md-12" id="expense_category_div" style="<?php if (isset($property_details['other_expense'])) {if($property_details['other_expense']=='true') echo ''; else echo 'display: none;';} else echo 'display: none;';?>">
											<div class="col-md-6">
												<label class="col-md-4 control-label" style="padding: 10px 0;">Expense Category <span  class="asterisk_sign" > * </span></label>
												<div class="col-md-8">
													<select  class="form-control" id="expense_category" name="expense_category">
                                                        <option value="">Select Category</option>    
                                                        <?php if(isset($expense_category)) { for ($i=0; $i < count($expense_category); $i++) { ?>
                                                            <option value="<?php echo $expense_category[$i]->id; ?>" <?php if(isset($property_details['expense_category'])) { if($expense_category[$i]->id == $property_details['expense_category']) { echo "selected";}} ?>><?php echo $expense_category[$i]->expense_category; ?></option>
                                                        <?php }} ?> 
                                                    </select>
												</div>
											</div>
										</div>
										<div class="form-group col-md-12" id="property_div" style="<?php if (isset($property_details['loan'])) {if($property_details['loan']=='selected') echo 'display: none;';}?>">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label" style="padding: 10px 0;">Property Name <span  class="asterisk_sign prop_other_name" style="display:none;"> * </span></label>
												<div class="col-md-8">

											 

													<select  class="form-control" id="property" name="prop_name">
														<option value="">Select Property</option>
														<?php if(isset($property_details['property_id'])) { 
															for($i=0; $i<count($property); $i++) { ?>
																<option value="<?php echo $property[$i]->property_id; ?>" <?php if($property_details['property_id'] == $property[$i]->property_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
														<?php } } else { ?>
																<?php for($i=0; $i<count($property); $i++) { ?>
																<option value="<?php echo $property[$i]->property_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
														<?php } } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6" id="sub_property_div" style="<?php if(isset($sub_property)) {if(count($sub_property)==1) {if($sub_property[0]->sub_property_id==null || $sub_property[0]->sub_property_id=="" || $sub_property[0]->sub_property_id=="0") echo 'display: none;';}} else echo 'display: none;';?>">
											<div class="">
												<?php //if(count($sub_property)>0) { if(count($sub_property)!=1 || ($sub_property[0]->sub_property_id!=null && $sub_property[0]->sub_property_id!="" && $sub_property[0]->sub_property_id!="0")) { ?>
												<label id="sub_property_label" class="col-md-4 control-label">Sub Property Name</label>
												<div class="col-md-8">
													<!-- <input type="text" class="form-control" name="sub_prop_name" placeholder=""/> -->
													<select id="sub_property" class="form-control" name="sub_property">
														<option value="">Select Sub Property</option>
														<?php if(isset($property_details['sub_property_id'])) { 
															for($i=0; $i<count($sub_property); $i++) { ?>
																<option value="<?php echo $sub_property[$i]->sub_property_id; ?>" <?php if($property_details['sub_property_id'] == $sub_property[$i]->sub_property_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
														<?php } } else { ?>
																<?php for($i=0; $i<count($sub_property); $i++) { ?>
																<option value="<?php echo $sub_property[$i]->sub_property_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
														<?php } } ?>
													</select>
												</div>
												<?php //}} ?>
											</div>
										</div>
										</div>
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->
								

								<div id="expense_summary_div" style="<?php if (isset($property_details['other_expense'])) {if($property_details['other_expense']=='true') echo ''; else echo 'display: none;';} else echo 'display: none;';?>">
								<div class="panel-heading">
									<h3 class="panel-title">Expense Summary</h3>
									<input type="hidden" name="other_expense" id="other_expense" value="<?php if(isset($property_details['other_expense'])) echo $property_details['other_expense']; else echo 'false';?>" />
								</div>
								<div class="panel-body">
									<div class="table-responsive"  >
										<table id="contacts" class="table group1 addschedule">
											<thead>
												<tr>
													<th>Expense Description <span  class="asterisk_sign" > * </span></th>
													<th>Expense Date <span  class="asterisk_sign" > * </span></th>
													<th>Expense Amount (In  &#8377;) <span  class="asterisk_sign" > * </span></th>
												</tr>
											</thead>
											<tbody id="expense_summary">

												<?php 
													echo '<tr>
															<td><input type="text" name="expense_description" id ="expense_description" class="form-control" style="border:none;" value="'.(isset($property_details['expense_description'])?$property_details['expense_description']:'').'"></td>
															<td><input type="text" name="expense_date" id ="expense_date" class="form-control datepicker" style="border:none;" value="'.(isset($property_details['expense_date'])?date("d/m/Y",strtotime($property_details['expense_date'])):'').'"></td>
															<td><input type="text" id="expense_amount" name="expense_amount" class="form-control format_number" style="border:none; text-align:right;" value="'.(isset($property_details['expense_amount'])?format_money($property_details['expense_amount'],2):'').'" /></td>
														  </tr>';
												?>

											</tbody>
										</table>
									</div>
								</div>
								</div>


								<div id="other_schedule_div" style="<?php if (isset($property_details['other_schedule'])) {if($property_details['other_schedule']=='true') echo ''; else echo 'display: none;';} else echo 'display: none;';?>">
								<div class="panel-heading">
									<h3 class="panel-title">Other Summary</h3>
									<input type="hidden" name="other_schedule" id="other_schedule" value="<?php if(isset($property_details['other_schedule'])) echo $property_details['other_schedule']; else echo 'false';?>" />
								</div>
								<div class="panel-body">
									<div class="table-responsive"  >
										<table id="contacts" class="table group1 addschedule">
											<thead>
												<tr>
													<th>Description <span  class="asterisk_sign" > * </span></th>
													<th>Date <span  class="asterisk_sign" > * </span></th>
													<th>Amount (In  &#8377;) <span  class="asterisk_sign" > * </span></th>
												</tr>
											</thead>
											<tbody id="expense_summary">

												<?php 
													echo '<tr>
															<td><input type="text" name="description" id ="description" class="form-control" style="border:none;" value="'.(isset($property_details['description'])?$property_details['description']:'').'"></td>
															<td><input type="text" name="sch_date" id ="sch_date" class="form-control datepicker" style="border:none;" value="'.(isset($property_details['sch_date'])?date("d/m/Y",strtotime($property_details['sch_date'])):'').'"></td>
															<td><input type="text" id="amount" name="amount" class="form-control format_number" style="border:none; text-align:right;" value="'.(isset($property_details['amount'])?format_money($property_details['amount'],2):'').'" /></td>
														  </tr>';
												?>

											</tbody>
										</table>
									</div>
								</div>
								</div>


								<div id="payment_summary_div" style="<?php if (isset($property_details['other_expense'])) {if($property_details['other_expense']=='true') echo 'display: none;';} 
																			else if (isset($property_details['other_schedule'])) {if($property_details['other_schedule']=='true') echo 'display: none;';} ?>">
								<div class="panel-heading">
									<h3 class="panel-title">Payment Summary</h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive"  >
										<table id="contacts" class="table group1 table-bordered addschedule">
											<thead>
												<tr>
													<th  >Event Type <span  class="asterisk_sign" > * </span></th>
													<th  >Event Name <span  class="asterisk_sign" > * </span></th>
													<th>Event Date <span  class="asterisk_sign" > * </span></th>
													<th    >Budget (In  &#8377;) <span  class="asterisk_sign" > * </span></th>
                                                      <?php if(isset($property_details['txn_type'])) {
														if($property_details['txn_type']=="purchase") {
															echo '<th  >Paid Till Date (In  &#8377;)</th>
																<th  >Pay Today (In  &#8377;)</th>
																<th>Tax Applicable</th>';
														} else if($property_details['txn_type']=="loan") {
															echo '<th  >Paid Till Date (In  &#8377;)</th>
																<th >Pay Today (In  &#8377;)</th>
																<th>Int Type</th>
																<th>Int Rate %</th>
																<th>Interest %</th>
																<th>Principal</th>
																<th >Tot Outstanding (In  &#8377;)</th>';
														} else if($property_details['txn_type']=="expense") {
															echo '<th >Paid Till Date (In  &#8377;)</th>
																<th>Pay Today (In  &#8377;)</th>';
														} else if($property_details['txn_type']=="maintenance") {
															echo '<th >Paid Till Date (In  &#8377;)</th>
																<th >Pay Today (In  &#8377;)</th>';
														} else {
															echo '<th >Received Till Date (In  &#8377;) (In  &#8377;)</th>
																<th >Received Today (In  &#8377;)</th>
																<th >TDS Amount (In  &#8377;)</th>';
													}}?>
													<th >Outstanding (In  &#8377;)</th>
													
												</tr>
											</thead>
											<tbody id="payment_summary">

												<?php if(isset($property_details['schedule_detail'])){
													$i=0;
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

														echo '<tr>
																<td>
																	<input type="hidden" name="event_type[]" id ="event_type_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_type'].'">
																	'.$property_details['schedule_detail'][$i]['event_type'].'
																</td>
																<td>
																	<input type="hidden" name="event_name[]" id ="event_name_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_name'].'">
																	'.$property_details['schedule_detail'][$i]['event_name'].'
																</td>
																<td>
																	<input type="hidden" name="event_date[]" id ="event_date_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['event_date'].'">
																	'.date("d/m/Y",strtotime($property_details['schedule_detail'][$i]['event_date'])).'
																</td>
																<td >
																	<input type="hidden" name="net_amount[]" id="net_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['net_amount'].'">
																	'.format_money($property_details['schedule_detail'][$i]['net_amount'],2).'
																</td>
																<td >
																	<input type="hidden" id="paid_till_date_'.($i+1).'" name="paid_amount[]" value="'.$property_details['schedule_detail'][$i]['amount_paid'].'">
																	<input type="hidden" id="paid_till_date_actual_'.($i+1).'" name="paid_amount_actual[]" value="'.$property_details['schedule_detail'][$i]['amount_paid'].'">
																	<a href="#" id="paid_till_date_link_'.($i+1).'" onclick="getAllpaidDetails(\''.$property_details['schedule_detail'][$i]['event_type'].'\',\''.$property_details['schedule_detail'][$i]['event_name'].'\',\''.$property_details['schedule_detail'][$i]['event_date'].'\')">
																		'.format_money($property_details['schedule_detail'][$i]['amount_paid'],2).' 
																	</a>
																</td>
																<td >
																	<input type="text" id="actual_amount_'.($i+1).'" name="actual_amount[]" class="form-control format_number" style="border:none; text-align:right;" onblur="getDifferneceAmt();" value="'.format_money($property_details['schedule_detail'][$i]['amount_paid_pending'],2).'" '.$disabled.'/>
																</td>';
														
														if(isset($property_details['txn_type'])) {
															if($property_details['txn_type']=="purchase") {
																$tax_applied=$property_details['schedule_detail'][$i]['tax_applied'];
																
																echo '<td><select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple >';
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
																echo '</select></td>';
															} else if($property_details['txn_type']=="loan") {
																echo '<td>
																		<select id="int_type_'.($i+1).'" name="int_type[]" onblur="setIntRate($(this));" '.$disabled.'>
																			<option value="">Select</option>
																			<option value="Fixed" '.(($property_details['schedule_detail'][$i]['int_type']=="Fixed")?"selected":"").'>Fixed</option>
																			<option value="Floating" '.(($property_details['schedule_detail'][$i]['int_type']=="Floating")?"selected":"").'>Floating</option>
																		</select>
																	</td>
																	<td >
																		<input type="text" id="int_rate_'.($i+1).'" name="int_rate[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getTotOutstanding();" value="'.$property_details['schedule_detail'][$i]['int_rate'].'" '.$disabled.'/>
																	</td>
																	<td >
																		<input type="hidden" id="interest_'.($i+1).'" name="interest[]" class="form-control" style="border: none;" />
																		<span id="interest_text_'.($i+1).'"></span>
																	</td>
																	<td >
																		<input type="hidden" id="principal_'.($i+1).'" name="principal[]" class="form-control" style="border: none;" />
																		<span id="principal_text_'.($i+1).'"></span>
																	</td>
																	<td >
																		<input type="hidden" id="tot_outstanding_'.($i+1).'" name="tot_outstanding[]" class="form-control" style="border: none;" />
																		<span id="tot_outstanding_text_'.($i+1).'"></span>
																	</td>';
															} else if($property_details['txn_type']=="expense") {
																// echo '<td><select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple >';
																// if(isset($property_details['allTaxes']))
																// {
																// 	//print_r($tax_id);
																// 	foreach($property_details['allTaxes'] as $row)
																// 	{
																// 		echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';	
																// 	} 	
																// }
																// echo '</select></td>';
															} else if($property_details['txn_type']=="maintenance") {
																// echo '<td><select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple >';
																// if(isset($property_details['allTaxes']))
																// {
																// 	//print_r($tax_id);
																// 	foreach($property_details['allTaxes'] as $row)
																// 	{
																// 		echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';	
																// 	} 	
																// }
																// echo '</select></td>';
															} else {
																echo '<td >
																		<input type="text" id="tds_amount_'.($i+1).'" name="tds_amount[]" class="form-control format_number" style="border: none; text-align:right;" onblur="getDifferneceAmt();" value="'.format_money($property_details['schedule_detail'][$i]['tds_amount_paid'],2).'" '.$disabled.'/>
																	</td>';
															}
														}

														echo '<td >
																<input type="hidden" name="balance[]" id="balance_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['balance_amount'].'">
																<span id="difference_'.($i+1).'">'.format_money($property_details['schedule_detail'][$i]['balance_amount'],2).'</span>
															</td></tr>';
														$i++;
													}
												} ?>

											</tbody>
											<tfoot>
												<?php if (isset($property_details['others'])) { ?>
													<tr>
														<td colspan="3" style="padding: 5px !important; text-align:left;"><a href="#" onclick="getOtherSchedule()"><?php echo $property_details['others'];?></a></td>
														<td id="others_net_amount"><?php echo format_money($property_details['others_net_amount'],2);?></td>
														<td id="others_paid_amount"><?php echo format_money($property_details['others_paid_amount'],2);?></td>
														<td colspan="<?php if($property_details['txn_type']=="loan") echo '6'; else echo '2';?>"></td>
														<td id="others_balance"><?php echo format_money($property_details['others_balance'],2);?></td>
													</tr>
												<?php } ?>
												<tr>
													<td colspan="3" style="padding: 5px !important; text-align:left;">Total Amount (In  &#8377;)</td>
													<td id="tot_budget" ></td>
													<td id="tot_paid" ></td>
													<?php if($property_details['txn_type']=="loan") {
															echo '<td colspan="6"></td>';
														} else if($property_details['txn_type']=="expense") {
															echo '<td></td>';
														} else if($property_details['txn_type']=="maintenance") {
															echo '<td></td>';
														} else { 
															echo '<td colspan="2"></td>';
														}
													?>
													<td id="tot_outstanding" ></td>
												</tr>
											</tfoot>
										</table>
										<div class="row " style="margin-top:15px;"  >

											<div class="col-md-6"  style="padding:0;"><button type="button"  class="btn btn-primary" id="<?php echo ($i+1);?>" onclick="getActualAmount(this.id)"><?php if(isset($property_details['txn_type'])) {if($property_details['txn_type']=="purchase" || $property_details['txn_type']=="loan" || $property_details['txn_type']=="expense" || $property_details['txn_type']=="maintenance") echo 'Get Amount To Be Paid'; else echo 'Get Amount To Be Received'; }?></button></div>
											<div class="col-md-2" style="padding:0;"><?php if(isset($property_details['txn_type'])) {if($property_details['txn_type']=="purchase" || $property_details['txn_type']=="loan" || $property_details['txn_type']=="expense" || $property_details['txn_type']=="maintenance") echo 'Amount Paid Today (In  &#8377;)'; else echo 'Amount Received Today (In  &#8377;)' ; }?></div><div class="col-md-3" id="actual_amount_to_pay"> </div></div>
											<div class="row">
											&nbsp;
										</div>
										<div id="schedule_tax_detail">
										
										</div>
										 
									</div>
									 
								</div>
								</div>

								<div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;" >
									<div class="mb-container" style="background:#fff;">
										<div class="mb-middle">
											<div class="mb-title" style="color:#000;text-align:center;">Payment Details</div>
											<div class="mb-content" id="paid_detail_view"></div>
										</div>
										<div class="mb-footer">
                                    		<button class="btn btn-danger btn-lg pull-right mb-control-close" onclick="closeTemp();">Close</button>
                                		</div>
									</div>
								</div>

								<div class="message-box message-box-info animated fadeIn" id="message-box-info2" style="overflow:auto;" >
									<div class="mb-container" style="background:#fff;">
										<div class="mb-middle">
											<div class="mb-title" style="color:#000;text-align:center;">Select Other Schedule Details</div>
											<div class="mb-content" id="schedule_select_other_detail_view"></div>
										</div>
										<div class="mb-footer">
                                    		<button class="btn btn-danger btn-lg pull-right mb-control-close" onclick="closeTemp2();">Close</button>
                                    		<input type="button" class="btn btn-primary btn-lg pull-right" onclick="saveOtherSch();" style="margin-right:10px;" value="Save" />
                                    		<!-- <button class="btn btn-primary btn-lg pull-right" onclick="saveOtherSch();" style="margin-right:10px;">Save</button> -->
                                		</div>
									</div>
								</div>

								<div class="panel-heading">
                                    <h4 class="panel-title"> Remark </h4>
                                </div>
                                <div class="panel-body">
								 <div class=" remark-container">
                                        <div class="form-group" style="background: none;border:none">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                            	<?php //print_r($property_details);?>
                                                <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($property_details['maker_remark'])){ echo $property_details['maker_remark'];}?></textarea>
                                                <!-- <label style="margin-top: 5px;">Remark </label> -->
                                            </div>
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
                                    <input type="hidden" id="submitVal" value="1" />
                                	<a href="<?php echo base_url();?>index.php/bank_entry" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($editrent)) echo 'display:none'; ?>" />
                                </div>
							</form>
						  </div>
						</div>    
						
                    </div>
                 </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <!-- MESSAGE BOX-->
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <!-- END TEMPLATE -->
		
		<script type="text/javascript">
			function getActualAmount(ids){
				var totalPayAmount=0;

				for(var i=1;i<ids;i++){
					var actual_amount=get_number($("#actual_amount_"+i).val(),2);
					if(actual_amount != ''){
						var total_actual_amount=actual_amount;
						var selectedTaxes=$('select[name="extra_taxes_'+i+'[]"]').map(function(){return $(this).val();}).get();
						for(var j=0;j<selectedTaxes.length;j++){					
							var  percenttax=selectedTaxes[j];
							var percent1=percenttax.split("_");
							var exact_percent=0;
							exact_percent=percent1[1];
							var percentAmount=0;
							percentAmount=parseInt(exact_percent)*parseInt(actual_amount)/parseInt(100);
							total_actual_amount=parseInt(total_actual_amount) - parseInt(percentAmount);
						}
						totalPayAmount=parseInt(totalPayAmount)+parseInt(total_actual_amount);
						total_actual_amount=0;
					}
				}
				$("#actual_amount_to_pay").html(format_money(totalPayAmount,2));
				setTax();
			}

			function getDifferneceAmt(){
				var tot_sch=parseInt(<?php echo isset($property_details['schedule_detail'])?count($property_details['schedule_detail']):0;?>);
				var tot_budget=0, tot_paid=0, tot_outstanding=0;

				for(var i=1;i<=tot_sch;i++){
					var netamt_ids='net_amount_'+i;
					var netAmount=parseInt(get_number($("#"+netamt_ids).val(),2));

					var paid_ids='paid_till_date_actual_'+i;
					var paid_amount=parseInt(get_number($("#"+paid_ids).val(),2));
					
					tot_budget=tot_budget+netAmount;
					tot_paid=tot_paid+paid_amount;
					tot_outstanding=tot_outstanding+netAmount-paid_amount;

					if($("#actual_amount_"+i).val()!="" && $("#actual_amount_"+i).val()!=null){
						var actual_amount=parseInt(($("#actual_amount_"+i).val()=="")?0:get_number($("#actual_amount_"+i).val(),2));
						
						if($("#tds_amount_"+i).length>0){
							var tds_amount=parseInt(($("#tds_amount_"+i).val()=="")?0:get_number($("#tds_amount_"+i).val(),2));
						} else {
							var tds_amount=0;
						}
						
						var tot_paid_amount=actual_amount+paid_amount+tds_amount;
						var difference=netAmount-tot_paid_amount;

						// tot_paid=tot_paid+actual_amount;
						tot_outstanding=tot_outstanding-actual_amount-tds_amount;

						$("#paid_till_date_"+i).val(tot_paid_amount);
						// $("#paid_till_date_link_"+i).html(tot_paid_amount);
						$("#balance_"+i).val(difference);
						$("#difference_"+i).html(format_money(difference,2));

						if(difference<0){
							alert("Outstanding cannot be negative.");
							$("#actual_amount_"+i).focus();
						}
					} else {
						$("#paid_till_date_"+i).val(paid_amount);
						// $("#paid_till_date_link_"+i).html(paid_amount);
						$("#balance_"+i).val(netAmount-paid_amount);
						$("#difference_"+i).html(format_money(netAmount-paid_amount,2));
					}
				}

				if($('#others_net_amount').length>0){
					tot_budget=tot_budget+parseInt(get_number($('#others_net_amount').html(),2));
				}
				if($('#others_paid_amount').length>0){
					tot_paid=tot_paid+parseInt(get_number($('#others_paid_amount').html(),2));
				}
				if($('#others_balance').length>0){
					tot_outstanding=tot_outstanding+parseInt(get_number($('#others_balance').html(),2));
				}

				$("#tot_budget").html(format_money(tot_budget,2));
				$("#tot_paid").html(format_money(tot_paid,2));
				$("#tot_outstanding").html(format_money(tot_outstanding,2));

				setTax();
				
				getTotOutstanding();
			}

			function setTax(){
				$.ajax({
					url:"<?php echo base_url()?>index.php/bank_entry/getTaxDetails",
					type:"post",
					dataType:"JSON",
	               	async: false,
					data:$("#bank_entry_details").serialize(),
					success:function(data){
						$("#schedule_tax_detail").html(data.htmldata);
				        $("form :input").change(function() {
			                $(".save-form").prop("disabled",false);
			            });
					},
					error: function(xhr, status, error) {
						  var err = eval("(" + xhr.responseText + ")");
						  alert(err.Message);
					}

				});
			}

			function getDifferneceTaxAmt(){
				var tot_sch=parseInt($('.tax_num').length);

				for(var i=1;i<=tot_sch;i++){
					var netamt_ids='tax_amount_'+i;
					var netAmount=parseInt(get_number($("#"+netamt_ids).val(),2));

					var paid_ids='tax_paid_till_date_actual_'+i;
					var paid_amount=parseInt(get_number($("#"+paid_ids).val(),2));

					// tot_budget=tot_budget+netAmount;
					// tot_paid=tot_paid+paid_amount;
					// tot_outstanding=tot_outstanding+netAmount-paid_amount;

					if($("#tax_actual_amount_"+i).val()!="" && $("#tax_actual_amount_"+i).val()!=null){
						var actual_amount=parseInt(($("#tax_actual_amount_"+i).val()=="")?0:get_number($("#tax_actual_amount_"+i).val(),2));

						var tot_paid_amount=actual_amount+paid_amount;
						var difference=netAmount-tot_paid_amount;

						tot_paid=tot_paid+actual_amount;
						tot_outstanding=tot_outstanding-actual_amount;

						$("#tax_paid_till_date_"+i).val(tot_paid_amount);
						// $("#tax_paid_till_date_link_"+i).html(tot_paid_amount);
						$("#tax_balance_"+i).val(difference);
						$("#tax_difference_"+i).html(format_money(difference,2));

						if(difference<0){
							alert("Outstanding cannot be negative.");
							$("#tax_actual_amount_"+i).focus();
						}
					} else {
						$("#tax_paid_till_date_"+i).val(paid_amount);
						// $("#tax_paid_till_date_link_"+i).html(paid_amount);
						$("#tax_balance_"+i).val(netAmount-paid_amount);
						$("#tax_difference_"+i).html(format_money(netAmount-paid_amount,2));
					}
				}

				// $("#tot_budget").html(tot_budget);
				// $("#tot_paid").html(tot_paid);
				// $("#tot_outstanding").html(tot_outstanding);
			}

			function setIntRate(elem){
				var elem_id=elem.attr("id");
				var index=elem_id.substr(elem_id.lastIndexOf('_')+1);
				var int_rate_elem_id="#int_rate_"+index;

				if(elem.val()=="Fixed") {
					$(int_rate_elem_id).prop('disabled', true);
				} else {
					$(int_rate_elem_id).prop('disabled', false);
				}

				if($(int_rate_elem_id).val()==null || $(int_rate_elem_id).val()==""){
					$(int_rate_elem_id).val('<?php echo isset($property_details['int_rate'])?format_number($property_details['int_rate'],2):0;?>');
				}

				getTotOutstanding();
			}

			function parseDate(str) {
			    var mdy = str.split('/');
			    return new Date(mdy[2], mdy[1], mdy[0]);
			}

			function getTotOutstanding(){
				var tot_sch=parseInt(<?php echo isset($property_details['schedule_detail'])?count($property_details['schedule_detail']):0;?>);
				var tot_outstanding=parseInt('<?php echo isset($property_details['tot_outstanding'])?format_number($property_details['tot_outstanding'],2):0;?>');
				var last_paid_date='<?php echo isset($property_details['last_paid_date'])?date("d/m/Y",strtotime($property_details['last_paid_date'])):0;?>';
				var payment_date=$("#payment_date").val();
				payment_date=parseDate(payment_date);
				last_paid_date=parseDate(last_paid_date);

				var interest=0, principal=0, no_of_days=0, int_rate=0, actual_amount=0;

				for(var i=1;i<=tot_sch;i++) {
					if($("#actual_amount_"+i).val()!="" && $("#actual_amount_"+i).val()!=null) {
						actual_amount=parseInt(($("#actual_amount_"+i).val()=="")?0:get_number($("#actual_amount_"+i).val(),2));
						int_rate=parseInt(($("#int_rate_"+i).val()=="")?0:get_number($("#int_rate_"+i).val(),2));
						
						if(interest==0) {
							no_of_days=Math.round((payment_date-last_paid_date)/(1000*60*60*24));

							interest=Math.round(tot_outstanding*int_rate/100/360*no_of_days);
							principal=Math.round(actual_amount-interest);
							tot_outstanding=Math.round(tot_outstanding-principal);
							$("#interest_"+i).val(interest);
							$("#interest_text_"+i).html(format_money(interest,2));
							$("#principal_"+i).val(principal);
							$("#principal_text_"+i).html(format_money(principal,2));
							$("#tot_outstanding_"+i).val(tot_outstanding);
							$("#tot_outstanding_text_"+i).html(format_money(tot_outstanding,2));
						} else {
							principal=actual_amount;
							tot_outstanding=Math.round(tot_outstanding-principal);
							$("#interest_"+i).val(0);
							$("#interest_text_"+i).val(0);
							$("#principal_"+i).val(principal);
							$("#principal_text_"+i).html(format_money(principal,2));
							$("#tot_outstanding_"+i).val(tot_outstanding);
							$("#tot_outstanding_text_"+i).html(format_money(tot_outstanding,2));
						}
					}
				}
			}

			function getAllpaidDetails(event_type,event_name,event_date){
				var fk_txn_id=$("#fk_txn_id").val();
				var formdata={event_type:event_type,event_name:event_name,event_date:event_date,fk_txn_id:fk_txn_id};
				$.ajax({
					url:"<?php echo base_url()?>index.php/bank_entry/getPaidDetails",
					data:formdata,
					type:"post",
					dataType:"json",
	               	async: false,
					success:function(data){
						// alert(data.htmldata);
						$("#paid_detail_view").html(data.htmldata);
						document.getElementById('message-box-info').style.display = "block";
					},
					error: function(xhr, status, error) {
						  var err = eval("(" + xhr.responseText + ")");
						  alert(err.Message);
					}
				})
			}

			function getAllTaxpaidDetails(tax_applied){
				var fk_txn_id=$("#fk_txn_id").val();
				var formdata={tax_applied:tax_applied,fk_txn_id:fk_txn_id};
				$.ajax({
					url:"<?php echo base_url()?>index.php/bank_entry/getTaxPaidDetails",
					data:formdata,
					type:"post",
					dataType:"json",
	               	async: false,
					success:function(data){
						// alert(data.htmldata);
						$("#paid_detail_view").html(data.htmldata);
						document.getElementById('message-box-info').style.display = "block";
					},
					error: function(xhr, status, error) {
						  var err = eval("(" + xhr.responseText + ")");
						  alert(err.Message);
					}
				})
			}

			function getOtherSchedule(){
				var fk_txn_id=$("#fk_txn_id").val();
				var formdata={fk_txn_id:fk_txn_id};
				$.ajax({
					url:"<?php echo base_url()?>index.php/bank_entry/getOtherSchedule",
					data:formdata,
					type:"post",
					dataType:"json",
	               	async: false,
					success:function(data){
						// alert(data.htmldata);
						$("#schedule_select_other_detail_view").html(data.htmldata);
						document.getElementById('message-box-info2').style.display = "block";
					},
					error: function(xhr, status, error) {
						  var err = eval("(" + xhr.responseText + ")");
						  alert(err.Message);
					}
				})
			}

			function closeTemp() {
			    document.getElementById('message-box-info').style.display = "none";
			    flag=false;
		   	}

			function saveOtherSch(){
				$.ajax({
					url:"<?php echo base_url()?>index.php/bank_entry/saveOtherSchDetails",
					type:"post",
					dataType:"JSON",
	               	async: false,
					data:$("#bank_entry_details").serialize(),
					success:function(data){
						document.getElementById('message-box-info2').style.display = "none";
	    				flag=false;
	    				window.open("<?php echo base_url();?>index.php/bank_entry/bankEntry/" + $('#fk_txn_id').val(),"_parent","true");
						
					},
					error: function(xhr, status, error) {
						  var err = eval("(" + xhr.responseText + ")");
						  alert(err.Message);
					}

				});

				document.getElementById('message-box-info2').style.display = "none";
	    		flag=false;
			}

			function closeTemp2() {
			    document.getElementById('message-box-info2').style.display = "none";
			    flag=false;
		   	}
        </script>

        <script>
        	$( "#type" ).change(function() {
        		var type=$("#type").val();
        		$("#status").html('');

        		if(type=="payment") {
        			$('<option>', {value: '', text: 'Select'}).appendTo("#status");
        			$('<option>', {value: 'purchase', text: 'Property Purchase'}).appendTo("#status");
        			$('<option>', {value: 'loan', text: 'Loan EMI'}).appendTo("#status");
        			$('<option>', {value: 'expense', text: 'Property Expense'}).appendTo("#status");
        			$('<option>', {value: 'maintenance', text: 'Property Maintenance'}).appendTo("#status");
        			$('<option>', {value: 'other', text: 'Other'}).appendTo("#status");
        		} else if (type=="receipt") {
        			$('<option>', {value: '', text: 'Select'}).appendTo("#status");
        			$('<option>', {value: 'rent', text: 'Rent'}).appendTo("#status");
        			$('<option>', {value: 'sale', text: 'Property Sale'}).appendTo("#status");
        			$('<option>', {value: 'other', text: 'Other'}).appendTo("#status");
        		}

        		$("#property").val('0');
        		$("#sub_property").val('0');
        		$("#property").html('');
        		$("#sub_property").html('');
        		$("#payment_summary").html('');
				$("#schedule_tax_detail").html('');
				$("#tot_budget").html('0');
				$("#tot_paid").html('0');
				$("#tot_outstanding").html('0');
	        });

	        $( "#status" ).change(function() {
	            var type=$("#type").val();
	            var status=$("#status").val();

        		$("#sub_property").val('0');
	            $("#loan_ref_name").html('');
	            $("#property").html('');
        		$("#sub_property").html('');
        		$("#payment_summary").html('');
				$("#schedule_tax_detail").html('');
				$("#tot_budget").html('0');
				$("#tot_paid").html('0');
				$("#tot_outstanding").html('0');
	            $("#sub_property_div").hide();

	            if (status=="loan") {
		            getLoanTxn();
	            	$("#loan_ref_name_div").show();
	            	$("#expense_summary_div").hide();
	            	$("#expense_category_div").hide();
	            	$("#other_schedule_div").hide();
	            	$("#payment_summary_div").show();
	            	$("#property_div").hide();
	            	$("#other_expense").val('false');
	            	$("#other_schedule").val('false');
					$(".prop_other_name").hide();
	            } else if (status=="expense") {
	            	getExpenseCategory();
		            getProperties();
	            	$("#loan_ref_name_div").hide();
	            	$("#expense_summary_div").show();
	            	$("#expense_category_div").show();
	            	$("#other_schedule_div").hide();
	            	$("#payment_summary_div").hide();
	            	$("#property_div").show();
	            	$("#other_expense").val('true');
	            	$("#other_schedule").val('false');
	            	$("#bank_entry_details").attr("action", "<?php echo base_url().'index.php/bank_entry/saveOtherExpenseBankEntry'; ?>");
					$(".prop_other_name").hide();
	            } else if (status=="other") {
		            getProperties();
	            	$("#loan_ref_name_div").hide();
	            	$("#expense_summary_div").hide();
	            	$("#expense_category_div").hide();
	            	$("#other_schedule_div").show();
	            	$("#payment_summary_div").hide();
	            	$("#property_div").show();
	            	$("#other_expense").val('false');
	            	$("#other_schedule").val('true');
	            	$("#bank_entry_details").attr("action", "<?php echo base_url().'index.php/bank_entry/saveOtherScheduleBankEntry'; ?>");
					$(".prop_other_name").hide();
	            } else {
		            getProperties();
	            	$("#loan_ref_name_div").hide();
	            	$("#expense_summary_div").hide();
	            	$("#expense_category_div").hide();
	            	$("#payment_summary_div").show();
	            	$("#property_div").show();
	            	$("#other_expense").val('false');
	            	$("#other_schedule").val('false');
					$(".prop_other_name").hide();
	            }

	            $("#property").val('0');
	            $("#loan_ref_name").val('0');

	            // window.open("<?php echo base_url();?>index.php/bank_entry/addnew/" + type + "/" + status,"_parent","true");
	        });

	        $( "#property" ).change(function() {
	            getSubProperties();
	        });

	        $( "#sub_property" ).change(function() {
	            getSchedule();
	        });

	        $( "#loan_ref_name" ).change(function() {
	            getSchedule();
	        });

	        function getSchedule(){
				var status=$("#status").val();
				var other_expense=$("#other_expense").val();
				var other_schedule=$("#other_schedule").val();

				if(status=="loan") {
	            	var loan_txn_id=$("#loan_ref_name").val();
					if (loan_txn_id!=null && loan_txn_id!="") {
               			window.open("<?php echo base_url();?>index.php/bank_entry/bankEntry/l_" + loan_txn_id,"_parent","true");
               		}
				} else if(other_expense=="true") {
               		//do nothing
				} else if(other_schedule=="true") {
               		//do nothing
				} else {
		            var property=$("#property").val();
		            var sub_property=$("#sub_property").val();
					var dataString = 'status=' + status + '&property_id=' + property + '&sub_property_id=' + sub_property;

					if(property!=0 && property!=null) {
		            	$.ajax({
			               type: "POST",
			               url: "<?php echo base_url() . 'index.php/bank_entry/getBankEntry' ?>",
			               data: dataString,
						   dataType:"json",
			               async: false,
			               cache: false,
			               success: function(data){
			               		txn_id = data.txn_id;
			               		sch_id = data.sch_id;

			               		if (txn_id!=null && txn_id!="" & sch_id!=null & sch_id!="") {
			               			window.open("<?php echo base_url();?>index.php/bank_entry/bankEntry/" + txn_id,"_parent","true");
			               		}
			               		
			               }
			            });
		            }
				}
			}

			function getLoanTxn(){
				var status=$("#status").val();
	            var dataString = 'txn_id=' + <?php echo isset($property_details['loan_txn_id'])?$property_details['loan_txn_id']:0; ?>;
	            
	            $.ajax({
					type: "POST",
					url: "<?php echo base_url() . 'index.php/bank_entry/get_loan_txn' ?>",
					data: dataString,
					async: false,
					cache: false,
					success: function(html){
					   $("#loan_ref_name").html(html);
					} 
	            });
			}

			function getExpenseCategory(){
	            var dataString = 'expense_category_id=' + <?php echo isset($property_details['expense_category_id'])?$property_details['expense_category_id']:0; ?>;
	            
	            $.ajax({
					type: "POST",
					url: "<?php echo base_url() . 'index.php/bank_entry/get_expense_category' ?>",
					data: dataString,
					async: false,
					cache: false,
					success: function(html){
					   $("#expense_category").html(html);
					} 
	            });
			}

			function getProperties(){
				var status=$("#status").val();
	            var dataString = 'status=' + status + '&property_id=' + <?php echo isset($property_details['property_id'])?$property_details['property_id']:0; ?>;
	            
	            $.ajax({
					type: "POST",
					url: "<?php echo base_url() . 'index.php/bank_entry/get_property' ?>",
					data: dataString,
					async: false,
					cache: false,
					success: function(html){
				   		$("#property").html(html);
					} 
	            });
			}

			function getSubProperties(){
				var property=$("#property").val();
				if(property=='0' || property==''){
					$("#sub_property").html('');
					$("#sub_property_div").show();
					$("#payment_summary").html('');
					$("#schedule_tax_detail").html('');
					$("#tot_budget").html('0');
					$("#tot_paid").html('0');
					$("#tot_outstanding").html('0');
				} else {
					var status=$("#status").val();
		            var dataString = 'status=' + status + '&property_id=' + property + '&sub_property_id=' + <?php echo isset($property_details['sub_property_id'])?$property_details['sub_property_id']:0; ?>;

		            $.ajax({
		               	type: "POST",
		               	url: "<?php echo base_url() . 'index.php/bank_entry/get_sub_property' ?>",
		               	data: dataString,
		               	// async: false,
		               	cache: false,
		               	success: function(html){
		                   	$("#sub_property").html(html);

							if(html==""){
								getSchedule();
								$("#sub_property_div").hide();
							} else {
								$("#sub_property_div").show();
								$("#payment_summary").html('');
								$("#schedule_tax_detail").html('');
								$("#tot_budget").html('0');
								$("#tot_paid").html('0');
								$("#tot_outstanding").html('0');
							}
		               	}
		            });
				}
			}

	        $( "#payment_mode" ).change(function() {
	        	checkMode();
	        });

	        function checkMode(){
				if($( "#payment_mode" ).val()=="Cheque"){
	        		$("#payment_id_details").show();
	        		$("#payment_id_type").html('Cheque No<span  class="asterisk_sign" > * </span>');
	        		$("#cheq_no").val("");
	        	} else if($( "#payment_mode" ).val()=="NEFT"){
	        		$("#payment_id_details").show();
	        		$("#payment_id_type").html('Ref No<span  class="asterisk_sign" > * </span>');
	        		$("#cheq_no").val("");
	        	} else {
	        		$("#payment_id_details").hide();
	        	}
			}

			$( document ).ready(function() {
				getLoanTxn();
			    getProperties();
			    // getSubProperties();
			    getDifferneceAmt();
			    // setTaxForView();
			    // checkMode();
			});
	    </script>
    <!-- END SCRIPTS -->      
    </body>
</html>