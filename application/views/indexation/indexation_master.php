<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.tile {padding: 0px;
				   min-height: 77px;}
		   	.control-label {padding-right: 0px;}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <form method="post" action="<?php if(isset($editdocuments)) { echo base_url().'index.php/documents/updateRecord/'.$d_id;} else {echo base_url().'index.php/documents/saveRecord';} ?>">
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
							<div class="panel-heading">
								<h3 class="panel-title"></h3>
								
							</div>
							<div class="panel-body">                                                                        
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Document Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="doc_name" placeholder="Document Name" value="<?php if(isset($editdocuments)){ echo $editdocuments[0]->d_documentname; } ?>"/>
												</div>
											</div>
										</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Document Type</label>
                                                    <div class="col-md-9">
                                                            <select class="form-control" name="doc_type">
                                                                    <option  value="Select">Select</option>    
                                                                    <option  value="ID Proof" <?php if(isset($editdocuments)){if($editdocuments[0]->d_type=="ID Proof"){echo "selected";}} ?>>ID Proof</option>
                                                                    <option  value="Address Proof" <?php if(isset($editdocuments)){if($editdocuments[0]->d_type=="Address Proof"){echo "selected";}} ?>>Address Proof</option>
                                                                    <option  value="Others" <?php if(isset($editdocuments)){if($editdocuments[0]->d_type=="Others"){echo "selected";}} ?>>Others</option>
                                                            </select>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                            
                                <div class="row">&nbsp;</div>
                                                            
                                <div class="row">
                                    <div class="form-group">
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Description</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="doc_desc" placeholder="Description" value="<?php if(isset($editdocuments)){ echo $editdocuments[0]->d_description; } ?>"/>
												</div>
											</div>
										</div>
                                                                                <div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Mandatory</label>
												<div class="col-md-9">
                                                                                                    <input type="radio" value="Yes" class="icheckbox" name="m_status" <?php if(isset($editdocuments)){if($editdocuments[0]->d_m_status=="Yes"){echo "checked";}} ?>/> &nbsp;&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                    <input type="radio" value="No" class="icheckbox" name="m_status" <?php if(isset($editdocuments)){if($editdocuments[0]->d_m_status=="No"){echo "checked";}} ?>/> &nbsp;&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">&nbsp;</div>
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Transaction Type</label>
												<div class="col-md-9">
													<select id="status" class="form-control ttype" name="status">
                                                                                                                <option value="Select">Select</option>
														<option value="Transactional" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_status=="Transactional"){echo 'selected';}} ?>>Transactional</option>
														<option value="Non Transactional" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_status=="Non Transactional"){echo 'selected';}} ?>>Non Transactional</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Sub Type</label>
												<div class="col-md-9">
													<select id="type" class="form-control stype" name="type">
														<option>Select</option>
<!--														<option value="Acquisition" <?php // if(isset($editdocuments)){ if($editdocuments[0]->d_type=="Acquisition"){echo 'selected';}} ?>>Acquisition</option>
														<option value="Buy" <?php // if(isset($editdocuments)){ if($editdocuments[0]->d_type=="Buy"){echo 'selected';}} ?>>Buy</option>
														<option value="Sell" <?php // if(isset($editdocuments)){ if($editdocuments[0]->d_type=="Sell"){echo 'selected';}} ?>>Sell</option>
														<option value="Rent" <?php // if(isset($editdocuments)){ if($editdocuments[0]->d_type=="Rent"){echo 'selected';}} ?>>Rent</option>
														<option value="Common" <?php // if(isset($editdocuments)){ if($editdocuments[0]->d_type=="Common"){echo 'selected';}} ?>>Common</option>-->
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">&nbsp;</div>
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
                                            <div class="form-group cat_hide" style="display:none;">
												<label class="col-md-2 control-label">Category</label>
												<div class="col-md-10">
													<input type="checkbox" value="Yes" class="icheckbox" name="individual" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_individual=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Individual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="huf" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_huf=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;HUF&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="privateltd" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_privateltd=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Private Limited&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="ltd" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_limited=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Limited&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="llp" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_lpp=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;LLP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="partnership" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_partnership=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Partnership&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="aop" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_aop=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;AOP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="trust" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_trust=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Trust
													<input type="checkbox" value="Yes" class="icheckbox" name="proprietorship" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_proprietorship=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Proprietorship
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">&nbsp;</div>
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
                                        	<div class="form-group ptype_hide" style="display:none;">
												<label class="col-md-2 control-label">Property Type</label>
												<div class="col-md-10">
													<input type="checkbox" value="Yes" class="icheckbox" name="apartment" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_apartment=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Apartment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="bunglow" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_bunglow=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Bunglow&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="commercial" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_commercial=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Commercial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="retail" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_retail=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Retail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="industry" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_industry=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Industry&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="landagri" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_landagriculture=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;&nbsp;Land-Agriculture&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" value="Yes" class="icheckbox" name="landnonagri" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_landnonagricultural=="Yes"){echo 'checked';}} ?>	/> &nbsp;&nbsp;&nbsp;Land-Non Agriculture&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</div>
											</div>
										</div>
									</div>
								</div>
								<input type="submit">
								<?php if(isset($access)) { if($access[0]->r_approvals == 1) { ?>
                                    <div class="col-md-4" style="float:right;">
										<textarea id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ></textarea>
									</div>
									<div class="col-md-4" style="float:right;">
										<select class="form-control select" id="astatus" name="txn_status">
											<option value="Pending">Pending</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<?php } } ?>
									
							</div>
								
							<!-- START DATATABLE EXPORT -->
							<div class="panel-heading">
								<h3 class="panel-title">Document List</h3>
								
								<div class="btn-group pull-right">
									<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
									<ul class="dropdown-menu">
										<li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
										
										<li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
										
									</ul>
								</div>
								
							</div>
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable">
									<thead>
										<tr>
											<th width="100">ID</th>
											<th width="100">Document Name</th>
											<th width="100">Description</th>
											<th width="100">Status</th>
											<th width="100">Type</th>
											<th width="100">Category</th>
											<th width="100">Property Type</th>
											<th width="75">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=0;$i<count($documents); $i++) {?>
										<tr id="trow_1">
											<td><?php echo ($i + 1); ?></td>
											<td><?php echo $documents[$i]->d_documentname; ?></td>
											<td><?php echo $documents[$i]->d_description ?></td>
											<td><?php echo $documents[$i]->d_status; ?></td>
											<td><?php echo $documents[$i]->d_type; ?></td>
											<td><?php echo $doccatlist[$i]; ?></td>
											<td><?php echo $doctypelist[$i]; ?></td>
											<td>
												<a class="btn btn-default btn-rounded btn-sm" href="http://www.google.com"><span class="fa fa-eye"></span></a>
												<a class="btn btn-default btn-rounded btn-sm" href="<?php echo base_url().'index.php/documents/editRecord/'.$documents[$i]->d_id; ?>"><span class="fa fa-pencil"></span></a>
												
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
						</div>
						</div>
						
						<div class="col-md-1"></div>
						
                    </div>
                </form>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
            
         </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
		
    <!-- END SCRIPTS -->      
    
    </body>
</html>