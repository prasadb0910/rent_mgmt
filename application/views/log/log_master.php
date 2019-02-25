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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->                                                  
		
 
		<style>
		
		@media only screen and (min-width:280px) and (max-width: 1020px) {
.heading-h2 {  display:flex!important;}}
		</style>

    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
           <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>   

                   <div class="heading-h2"> 
                 	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Log Master 
                 </div> 
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row  main-wrapper">
						<div class="main-container"> 
                          <div class="col-md-12">
							<div class="panel panel-default inside-width">
								<?php $this->load->view('templates/download');?> 
								<form id="form_log" method="post" action="#">
						      	<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top:none;">
									<thead>
										<tr>
											<th width="74" align="center">Sr. No.</th>
											<th width="150">Group Name</th>
											<th width="150">Section</th>
											<th width="200">Action</th>
											<th width="75">Reference</th>
											<th width="75">Created By</th>
											<th width="75">Action Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=0;$i<count($log); $i++) {?>
										<tr id="trow_1">
											<td align="center"><?php echo ($i + 1); ?></td>
											<td><?php echo $log[$i]->group_name; ?></td>
											<td><?php echo $log[$i]->module_name; ?></td>
											<td><?php echo $log[$i]->action; ?></td>
											<td><?php echo $log[$i]->ref_name; ?></td>
											<td><?php echo $log[$i]->gu_email; ?></td>
											<td><?php echo ($log[$i]->date!=null && $log[$i]->date!='')?date('d/m/Y g:i a',strtotime($log[$i]->date)):''; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                              </form>
							</div>
						 </div>
						</div>
					</div>
				</div>
        <!-- END PAGE CONTAINER -->
		</div>
	</div>
        <?php $this->load->view('templates/footer');?>  
    
    </body>
</html>