<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/header');?>
	<style>
		.edit
		{
			color:#41a541!important;
		}
		.delete
		{
			color:#da5050!important;
		}
		.print
		{
			color:#fe970a!important;
		}
		.a
		{
			border-bottom: 2px solid #edf0f5;
			margin-bottom: 25px;
			padding-bottom: 25px;
		}
		.block1
		{
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		p{
			font-weight: 200px!important;
		}
		.form-group-default label
		{
			font-weight:1000!important;
		}
		.slider:after {
			content:"Off";
		} 
		.slider:before {
			content:"On";
		}
		#prop_info .form-group-default{
			border:none!important;
		}
		.panel-description {
			color: #8c919e;
			font-size: 0.85714rem;
			float:left;
			text-align:left;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
	<div class="content">
		<div class=" container-fluid container-fixed-lg">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="contact.php">Contact List</a></li>
				<li class="breadcrumb-item active"><a href="#">Contact View</a></li>
			</ol>
			<div class="container">
				<div class="row m-t-20">
					<div class="col-md-12">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;margin-right:16px;">
							<div class=" " style="padding:10px;">
								<a href="contact.php">
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
										<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a>
										<a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class=" container-fluid   container-fixed-lg bg-white">
							<div class="card card-transparent">
								<p class="m-t-20"><b>END LEASE PROCESS</b></p>
								<div class="a" id="prop_info">
									<div class="row clearfix">
										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>Property</label>
												<input type="text" class="form-control "  value="Green Acres 2" name="" id="" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>Lease Type</label>
												<input type="text" class="form-control "  value=" Fixed" name="" id="" readonly>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>Start Date</label>
												<input type="text" class="form-control "  value="05-01-2018" name="" id="" readonly>
											</div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>Unit</label>
												<input type="text" class="form-control "  value="1" name="" id="" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>Lease Invoicing</label>
												<input type="text" class="form-control "  value="Seperated" name="" id="" readonly>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group form-group-default ">
												<label>End Date</label>
												<input type="text" class="form-control "  value="05-01-2019" name="" id="" readonly>
											</div>
										</div>
									</div>
								</div>

								<div class="a">
									<p class="m-t-20"><b> UNPAID INVOICES </b></p>
									<p class="panel-description"> Here if any unpaid invoices are pending will be shown.</p>
									<br>
									<div class="row clearfix">
										<div class="col-md-12">
											<table class="view_table" border="1px;" style="width:100%;">
												<thead>
													<tr>
														<th> <a href="#" data-toggle="tooltip" data-placement="top" title="Category of receivable and month of booking income">Category</a></th>
														<th>  <a href="#" data-toggle="tooltip" data-placement="top" title="Total amount to be received">Total</a>  </th>
														<th>  <a href="#" data-toggle="tooltip" data-placement="top" title="Received till date">Received</a>  </th>
														<th>Pending</th>
														<th> <a href="#" data-toggle="tooltip" data-placement="top" title="Want to deduct from deposit?">Deposit</a>  </th>
														<th>Source</th>
														<th>Date Paid</th>
														<th>Amount</th>
													</tr>
												</thead>
												<tbody>
													<tr class="odd gradeX">
														<td>Rent - Jan 18</td>
														<td>Rs. 20,000</td>
														<td>Rs. 0</td>
														<td>Rs. 20,000</td>
														<td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />  <div class="slider"></div></td>
														<td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />  <div class="slider"></div></td>
														<td>
															<div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
																<label>DATE PAID</label>
																<input id="date" type="text" class="form-control date" name="date" required>
															</div>
														</td>
														<td>
															<div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
																<label>Amount</label>
																<input id="amount" type="text" class="form-control " name="amount" >
															</div>
														</td>
													</tr>
												</tbody>
											</table>
											<button class="btn btn-success m-t-20 pull-right" type="submit">record as paid</button>
										</div>
									</div>
								</div>

								<div class="a">
									<p class="m-t-20"><b>RETURN DEPOSIT </b></p>
									<p class="panel-description"> Deposits to be returned.</p>
									<br>
									<div class="row clearfix">
										<div class="col-md-12">
											<table class="view_table" border="1px;" style="width:100%;">
												<thead>
													<tr>
														<th>Category</th>
														<th><a href="#" data-toggle="tooltip" data-placement="top" title="Deposit amount if pending rent is to be deducted from deposit than this amount will be reduced">Available Amount</a></th>
														<th>Refund Date	</th>
														<th>Amount To Refund</th>
													</tr>
												</thead>
												<tbody>
													<tr class="odd gradeX">
														<td>Deposit</td>
														<td>Rs. 1,00,000</td>
														<td>
															<div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
																<label>Refund Date</label>
																<input id="refund_date" type="text" class="form-control date" name="date" required>
															</div>
														</td>
														<td>
															<div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
																<label>Amount</label>
																<input id="refund_amount" type="text" class="form-control " name="amount" >
															</div>
														</td>
													</tr>
												</tbody>
											</table>
											<button class="btn btn-success m-t-20 pull-right" type="submit">record return</button>
										</div>
									</div>
								</div>

								<div class="row clearfix">
									<div class="col-md-6"><button class="btn btn-default-danger pull-left"  type="submit">Cancel</button></div>
									<div class="col-md-4">
										<div class="form-group form-group-default pull-right" style="border:1px solid rgba(0,0,0,0.07)!important; ">
											<label>Date Ended</label>
											<input id="dob" type="text" class="form-control date" name="dob" required>
										</div>
									</div>
									<div class="col-md-2"><button class="btn btn-danger pull-right"  type="submit">END THE LEASE	</button></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('templates/footer');?>

</div>
</div>

<?php $this->load->view('templates/script');?>

</body>
</html>