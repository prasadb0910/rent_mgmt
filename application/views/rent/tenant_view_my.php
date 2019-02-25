<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
	.created_date {
		text-align:center;
	}
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
	.btn-group-justified {
		margin-left:2px;
	}
	.leases_status {
		border: 1px solid #41a541;
		color: #41a541;
		background-color: transparent;
		border-color: #41a541;
		display: inline-block;
		padding: 2px 8px;
		border-radius: 4px;
		font-size: 11px;
		font-weight: 400;
		font-style: normal;
		letter-spacing: 0.0625em;
		text-transform: lowercase;
		font-family: "proxima-nova", "tenantcloud", Avenir, sans-serif;
	}
	.view-block-btn .btn {
		width:100%;
		margin-bottom:15px;
	}
	.m-panel__view article {
		min-width: 100%;
		margin-bottom: 25px;
		padding-bottom: 10px;
		border-bottom: 2px solid #edf0f5;
	}
	.view-block {
		display:inline-flex;
	}
	#contact1 {
		width: 60px;
		height: 60px;
		text-align: left;
		float: none;
		margin: 15px auto;
		display: block;
	}
	.info {
		text-align:center;
	}
	.email {
		font-size:13px!important;
		color:#4a65da!important;
	}
	.title_1 {
		margin-bottom:5px!important;
		font-size: 1.14286rem!important;
		font-family: inherit!important;
		font-weight: 500!important;
		letter-spacing: 0.02em!important;
		text-transform: capitalize!important;
	}
	.mob_no {
		text-align:center;
		font-size: 14px;
		color: #8b92a2;
	}
	.view-title {
		margin-bottom: 15px;
		color: #4a65da;
		font-size: 14px!important;
		font-weight: 600!important;
	}
	article {
		min-width: 100%;
		padding-bottom: 10px;
		border-bottom: 2px solid #edf0f5;
	}
	.info-name-property {
		font-weight: 600;
		text-transform: capitalize;
		font-size: 14px;
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
	}
	a {
		color: #41a541;
		text-decoration: none;
		cursor: pointer;
		outline: medium none;
		-webkit-transition: color 0.2s ease 0s;
		transition: color 0.2s ease 0s;
	}
	.m-property-info {
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		font-weight:500;
	}
	.info-location .icon-svg {
		margin-right: 5px;
	}
	.info-location {
		display: inline-flex;
	}
	.unit-options {
		display: inline-flex;
		-webkit-box-flex: 1;
		-webkit-flex: 1 0 auto;
		-webkit-box-align: center;
		align-items: center;
		height: 44px;
	}
	small {
		font-size: 12px;
		font-weight: 400;
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		color: #8c919e;
	}
	.unit-options>div>span {
		font-size: 1.07143rem;
		font-weight: 600;
		padding:10px;
	}
	.title-block>span {
		font-family: "proxima-nova", "tenantcloud", Avenir, sans-serif;
		font-size: 22px;
		font-weight: 400;
	}
	.title-block>h4 {
		margin-top: 4px!important;
		font-size: 14px;
		font-weight: 600;
	}
	.title-block {
		min-width: 120px;
	}
	.title-block .period {
		font-family: "proxima-nova", "tenantcloud", Avenir, sans-serif;
		font-size: 16px;
		font-weight: 400;
	}
	.view_block_type_lease>h5 {
		font-size:14px!important;
		font-weight:600!important;
	}
	.m-status--leases-type {
		padding: 1px 15px;
		color: #40434b;
		border: 1px solid #e6ebf1;
		background-color: #f6f9fc;
		border-radius: 4px;
		font-size: 11px;
		font-weight: 400;
		font-style: normal;
		letter-spacing: 0.0625em;
		text-transform: lowercase;
		font-family: "proxima-nova", "tenantcloud", Avenir, sans-serif;
	}
	.files-item {
		padding: 15px;
		position: relative;
		width: 65px;
		height: 70px;
		border: 2px solid #e6ebf1;
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-align: center;
		-webkit-align-items: center;
		-ms-flex-align: center;
		align-items: center;
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		-webkit-flex-direction: column;
		-ms-flex-direction: column;
		flex-direction: column;
		-webkit-box-pack: center;
		-webkit-justify-content: center;
		-ms-flex-pack: center;
		justify-content: center;
		margin-bottom: 20px;
		margin-right: 26px;
	}
	.file-icon-lg {
		font-size: 40px;
		color:#f77171!important;
	}
	.item-title {
		position: absolute;
		font-size: 0.71429rem;
		left: 0;
		bottom: -20px;
		white-space: nowrap;
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
	}
	.utilities-block {
		border: 2px solid #f6f9fc;
		padding: 20px;
		margin-bottom: 20px;
		-webkit-box-flex: 1;
		-webkit-flex-grow: 1;
		-ms-flex-positive: 1;
		flex-grow: 1;
	}
	.utilities-tag .tag {
		padding: 4px 10px;
		margin: 4px 5px;
		border: 1px solid #41a541;
		border-radius: 100px;
		color: #41a541;
		font-size: 9px;
		font-weight: 700;
		text-transform: uppercase;
		white-space: nowrap;
		display: inline-block;
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
			<form id="form_rent_view" role="form" method ="post" action="<?php echo base_url().'index.php/Rent/update/'.$r_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Rent/checkstatus/All">Rent List</a></li>
					<li class="breadcrumb-item active">Rent View</li>
				</ol>
				<div class="container">
					<div class="row m-t-20">
						<div class="card card-transparent  bg-white m-t-20" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Rent'; ?>">
									<div class="pull-left">
										<span><i class="fa fa-file-text-o" style="font-size:24px"></i> Lease</span>
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
											<a href="<?php echo base_url().'index.php/Rent/edit/'.$r_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($editrent)) { ?>
										<?php if($editrent[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } else if($editrent[0]->modified_by != '' && $editrent[0]->modified_by != null) { if($editrent[0]->modified_by!=$rentby) { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($editrent[0]->created_by != '' && $editrent[0]->created_by != null) { if($editrent[0]->created_by!=$rentby && $editrent[0]->txn_status != 'In Process') { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
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
						<div class="col-md-9" style="margin-left: -15px;">
							<div class=" container-fluid  container-fixed-lg bg-white p-b-10">
								<div class="card card-transparent">
									<article>
										<h5 class="view-title">Property information &amp; terms</h5>
										<div class="m-property-info ">
											<div class="info-name-property">
												<span>
													<a class="info-link" href="<?php echo base_url().'index.php/Purchase/view/'.$editrent[0]->property_id; ?>">
														<?php echo $editrent[0]->p_display_name; ?>
													</a>
													<span>,</span>
												</span>
												<a  class="info-link" title="" href="">
													<?php echo $editrent[0]->p_type; ?>
												</a>
											</div>
											<div class="info-location">
												<div class="icon-svg">
													<i class="fa fa-map-marker" aria-hidden="true"></i>
												</div>
												<div class="location-address">
													<address><?php echo $editrent[0]->p_address; ?></address>
													<address><?php echo $editrent[0]->p_googlemaplink; ?></address>
												</div>
											</div>
										</div>
										<div class="unit-options">
											<div>
												<span>1</span>
												<small>bed</small>
											</div> &nbsp /
											<div>
												<span>1</span>
												<small>bath</small>
											</div> &nbsp /
											<div>
												<span><?php echo format_money($editrent[0]->pr_agreement_area,2); ?></span>
												<small><?php echo $editrent[0]->pr_agreement_unit; ?></small>
											</div>
										</div>
									</article>
									<article class="period-transaction">
										<section>
											<div class="row">
												<div class="col-md-12 col-sm-4">
													<div class="transaction-item">
														<div class="view-block m-b-0">
															<div class="title-block">
																<h4>Lease Type</h4>
																<span class="period">Fixed</span></span>
															</div>
															<div class="title-block">
																<h4>Lockin Period</h4>
																<span class="period"><?php echo $editrent[0]->lease_period; ?> years</span>
															</div>
															<div class="title-block">
																<h4>Notice Period </h4>
																<span class="period"><?php echo $editrent[0]->notice_period; ?> month</span>
															</div>
															<div class="title-block">
																<h4>Rent Free Period</h4>
																<span class="period"><?php echo $editrent[0]->free_rent_period; ?> month</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</article>
									<article class="lease-residents">
										<h5 class="view-title">Residents information</h5>
		                                <?php $j=0; if(isset($tenants)) { 
		                                    for ($j=0; $j < count($tenants) ; $j++) { ?>

										<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
											<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 14px;font-size:20px;"><span><?php echo (strlen($tenants[$j]->c_name)>0?substr($tenants[$j]->c_name, 0, 1):'') . (strlen($tenants[$j]->c_last_name)>0?substr($tenants[$j]->c_last_name, 0, 1):''); ?></span>
											</div>  
										</div>
										<div class="info pull-left p-l-10" style="margin-top: 15px;text-align:left;">
											<span class="title_1"><?php echo $tenants[$j]->c_name . ' ' . $tenants[$j]->c_last_name; ?></span><br>
											<span class="email"><?php echo $tenants[$j]->c_emailid1; ?></span><br>
											<span class="mob_no"><?php echo $tenants[$j]->c_mobile1; ?></span>
										</div>

                                		<?php }} ?>
									</article><br>
									<article class="lease-transaction">
										<h5 class="view-title">Lease transactions</h5>
										<section>
											<div class="row">
												<div class="col-md-12 col-sm-4">
													<div class="transaction-item">
														<div class="view-block m-b-0">
															<div class="title-block">
																<h4>Rent</h4>
																<span>₹<?php echo format_money($editrent[0]->rent_amount,2); ?></span></span>
															</div>
															<div class="title-block">
																<h4>Due day</h4>
																<span><?php echo $editrent[0]->rent_due_day; ?><?php if($editrent[0]->rent_due_day=='1') echo 'st'; else if($editrent[0]->rent_due_day=='2') echo 'nd'; else if($editrent[0]->rent_due_day=='3') echo 'rd'; else echo'th'; ?></span>
															</div>
															<div class="title-block">
																<h4>GST </h4>
																<span><?php if($editrent[0]->gst=='1') echo 'yes'; ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</article>
									<article class="deposite">
										<section>
											<div class="row">
												<div class="col-md-12 col-sm-4">
													<div class="transaction-item">
														<div class="view-block m-b-0">
															<div class="title-block">
																<h4>Deposits</h4>
																<span>₹<?php echo format_money($editrent[0]->deposit_amount,2); ?></span></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</article>
									<article class="escalations">
										<h5 class="view-title">Y-o-Y Escalations</h5>
										<section>
											<div class="row">
												<div class="col-md-12 col-sm-4">
													<table class="view_table">
														<thead>
															<tr>
																<th>Year</th>
																<th>Escalation %</th>
															</tr>
														</thead>
														<tbody>
							                                <?php $j=0; if(isset($escalations)) { 
							                                    for ($j=0; $j < count($escalations) ; $j++) { ?>

															<tr class="odd gradeX">
																<td><?php echo $escalations[$j]->year; ?></td>
																<td><?php if(isset($escalations)) { if(count($escalations)>0) { echo format_money($escalations[$j]->escalation,2); }} ?>%	</td>
															</tr>

                                							<?php }} ?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</article>
									<article class="lease-utilities" ng-class="{'border-none' : $ctrl.isTenant}">
										<h5 class="view-title">
											<span>Utilities</span>
											<span  class="icon-fo-ok"></span>
										</h5>
										<div class="row">
											<div class="col-xs-24 col-sm-12" >
												<div class="utilities-block">
													<div class="utilities-tag">
														<?php for ($k=0; $k < count($utility) ; $k++) { 
																if(isset($utility[$k]->tenant)) { if($utility[$k]->tenant=='1') { ?>
																	<span class="tag"><?php if(isset($utility[$k]->utility)) echo $utility[$k]->utility; ?></span>
														<?php }}} ?>
													</div>
												</div>
											</div>
										</div>
									</article>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="background-color: #f6f9fc;border-left: 2px solid #edf0f5;padding:20px;">
							<div class="status" style="float:right">
								<span class="leases_status">Active</span>
								<span class="leases_status status_name">#1</span>
							</div>
							<div class="view_block_type_lease p-t-20 p-b-20" style=" border-bottom:2px solid #edf0f5;">
								<div class="m-b-10">
									<h5  style="font-size:16px;font-weight:600">Lease type</h5>
									<span class="m-status--leases-type"><?php echo $editrent[0]->schedule; ?></span>
								</div>
							</div>
							<div class="view-block-date p-b-20"  style=" border-bottom:2px solid #edf0f5;">
								<div class="date-type">
									<div>
										<div>
											<h5  style="font-size:16px;font-weight:600">Start date</h5>
											<span><?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->possession_date!=null && $editrent[0]->possession_date!='') echo date('d/m/Y',strtotime($editrent[0]->possession_date)); }} ?></span>
										</div>
									</div>
									<div>
										<div>
											<h5  style="font-size:16px;font-weight:600">End date</h5>
											<span><?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->termination_date!=null && $editrent[0]->termination_date!='') echo date('d/m/Y',strtotime($editrent[0]->termination_date)); }} ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="view-block-btn p-t-20"style=" border-bottom:2px solid #edf0f5;">
								<div>
									<a class="btn btn-warning" href="">
										<span>Renew lease</span>
									</a>
								</div>
								<div>
									<a class="btn btn-danger" href="">
										<span>End lease</span>
									</a>
								</div>
							</div>
							<h5 class="view-title">Documents</h5>
								<?php if(isset($documents)) { for ($i=0; $i < count($documents); $i++) { ?>
								<?php if($documents[$i]->doc_document!='' && $documents[$i]->doc_document!=null) { ?>
							<div class="files-item m-t-20">
								<div class="item-media"> 
									<div class="file-icon-lg ">
										<i class="fa fa-file" >
											<span data-type="pdf"></span>
										</i>
									</div>
								</div>
								<div class="item-title">
									<a href="<?php echo base_url().$documents[$i]->doc_document; ?>" target="_system"><?php echo $documents[$i]->document_name; ?></a>
								</div>
							</div>
								<?php } ?>
								<?php } } ?>
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