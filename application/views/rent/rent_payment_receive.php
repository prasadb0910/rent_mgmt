<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
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
				   
				   .select
				   {
				       height: 23px;
				   }
				   .selectpicker
				   {
				       padding-top: 0px;
    padding-bottom: 0;
				   }
				   
				   .addschedule td{
	border:1px solid;
	padding:0px !important;
}
.addschedule th{
	border:1px solid;
}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <form action="<?php echo base_url().'index.php/Rent/savepayment/'.$sch_id; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Recieve Payment for <?php if(isset($rent_txn)){echo $rent_txn[0]->p_property_name;} ?></strong></h3>
								<ul class="panel-controls">
									<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
								</ul>
							</div>
							<div class="panel-body">                                                                        
								<div class="row">
									<div class="form-group">
										<div class="col-md-4">
											<div class="form-group">
												<label class="col-md-4 control-label">Recieved Date</label>
												<div class="col-md-6">
													<input type="text" class="form-control" name="rec_date" placeholder="" style="height: 23px;"/>
												</div>
												<div class="col-md-1"><i class="fa fa-calendar" style="    margin-left: -40px;font-size: 21px;margin-top: 1px"></i></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="col-md-3 control-label">Amount</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="payment_amount" placeholder="" style="height: 23px;"/>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="col-md-5 control-label">Payment Method</label>
												<div class="col-md-7">
													<select class="form-control select" style="height: 23px;" name="method">
														<option>Select</option>
														<option value="Cash">Cash</option>
														<option value="Cheque">Cheque</option>
														<option value="DD">DD</option>
														<option value="RTGS/NEFT">RTGS / NEFT</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								
								<div class="row">&nbsp;</div>
								
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-8">
											<div class="form-group">
												<label class="col-md-1 control-label">Memo</label>
												<div class="col-md-11" style="padding-left: 64px;">
													<input type="text" class="form-control" name="memo" placeholder="" value="Payment"/>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								
								<div class="row">&nbsp;</div>
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<div class="form-group">
												<label class="col-md-2 control-label">Attach File / Photos</label>
												<div class="col-md-10" style="padding-left: 36px;">
													<input type="file" class="fileinput btn-primary" name="attach" id="photograph" title="Browse file"/>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								
								<input type="submit"/>
								<div class="row">&nbsp;</div>
								
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="form-group">
												<div class="table-stripped">
													<table id="contacts" class="table group addschedule">
														<thead>
															<tr>
																<th style="text-align: center;vertical-align: middle;">Id</th>
																<th style="text-align: center;vertical-align: middle;">Account</th>
																<th style="text-align: center;vertical-align: middle;">Balance</th>
																<th style="text-align: center;vertical-align: middle;">Amount</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
													<div class="row">
														&nbsp;
													</div>
													<div class="row">
														<button class="btn btn-success repeat-schedule" style="margin-left: 10px;">+</button>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
								
							
                            
						</div>
						</div>
						
						<div class="col-md-1">&nbsp;</div>
						
                    </div>
                    
                </div>
                </form>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="<?php echo base_url(); ?>audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="<?php echo base_url(); ?>audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->                
<script type="text/javascript" src="<?php echo base_url(); ?>js/demo_tables.js"></script>
		
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/datatables/jquery.dataTables.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/tableExport.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jquery.base64.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/html2canvas.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/base64.js"></script>
        <!-- END PAGE PLUGINS -->
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="js/settings.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
        <!-- END TEMPLATE -->
		
		<script>
		jQuery(function(){
			var counter = <?php if(isset($rent_note)) { echo count($rent_note);} else { echo "1"; } ?>;
			$('.repeat-schedule').click(function(event){
					event.preventDefault();
						var newRow = jQuery('<tr><td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td><td><input type="text" id="txttype" name="account[]" value="" class="form-control" style="border:none;background:none;"/></td><td><input type="text" id="txtevent" name="balance[]" value="" class="form-control" style="border:none;background:none;text-align: right;"/></td><td><input type="text" id="txtdtp" name="amount[]" class="form-control" style="border:none;background:none;"/></td></tr>');
						$('.addschedule').append(newRow);
				        $("form :input").change(function() {
				            $(".save-form").prop("disabled",false);
				        });
						counter++;
					
				});
			});
		</script>
		
    <!-- END SCRIPTS -->      
    </body>
</html>