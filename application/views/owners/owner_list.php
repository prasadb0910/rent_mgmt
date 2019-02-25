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
		  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/> 
	 	<style>
            #approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
            .table thead tr th { padding:8px 5px!important; font-weight:600; } 
            .btn-cntr { margin-bottom: 10px!important; }
            .add-owner { float: left;   }
            .add-owner .col-md-3 { padding:5px 0; text-align: left;   }
            #category { padding: 0 10px; }
		</style>
        
        <style>
            <?php if($maker_checker!='yes') { ?>
                .approved {
                    display: none !important;
                }
                .pending {
                    display: none !important;
                }
                .rejected {
                    display: none !important;
                }
            <?php } ?>
        </style>

    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
          <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                    <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Owner List </div>
 
               <div class="nav-contacts ng-scope" ui-view="@nav">
                <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
                    <div class="container owner-panel u-posRelative u-textRight">
                    	<div class="btn-top add-owner col-md-4">
								<div class="">
											<?php if(isset($access)) { if($access[0]->r_insert == 1) { ?>
												<label class="control-label col-md-3"  >Add owner</label>
												<div class="col-md-9">
												<select class="form-control" id="category" name="category" onchange="loadType();">
													<option selected>Choose category</option>
													<option value="0">Individual</option>
													<option value="1">HUF</option>
													<option value="2">Private Limited</option>
													<option value="3">Limited</option>
													<option value="4">LLP</option>
													<option value="5">Partnership</option>
													<option value="6">AOP</option>
													<option value="7">Trust</option>
													<option value="8">Proprietorship</option>
												</select>
											</div>
											<?php } } ?>
										</div>
											</div>  
								


                        <i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

                           <ul class="m-nav--linetriangle   col-md-8  col-md-8" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
                            <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/All">
                                    <span class="ng-binding">All</span>
                                    <span id="approved">  (<?php echo count($all); ?>)  </span>
                                </a>
                            </li>

                            <li class="approved" >
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/Approved">
                                    <span class="ng-binding">Approved</span>
                                    <span id="approved"> (<?php echo count($approved); ?>)</span>
                                </a>
                            </li>

                            

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/Pending">
                                    <span class="ng-binding">Pending</span>
                                    <span id="approved"> (<?php echo count($pending); ?>) </span>
                                </a>
                            </li>

                            <li class="rejected">
                                <a href="<?php echo base_url(); ?>index.php/owners/checkstatus/Rejected">
                                    <span class="ng-binding">Rejected</span>
                                    <span id="approved"> (<?php echo count($rejected); ?>) </span>
                                </a>
                            </li>

                            <li class="inprocess">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/InProcess">
                                    <span class="ng-binding">In Process</span>
                                    <span id="approved"> (<?php echo count($inprocess); ?>) </span>
                                </a>
                            </li>           
                        </ul>


                        <i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
                    </div>
                </div>
            </div>

<ul class="topnav" id="myTopnav">
        <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/All">
                                    <span class="ng-binding">All</span>
                                    <span id="approved">  (<?php echo count($all); ?>)  </span>
                                </a>
                            </li>

                            <li class="approved" >
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/Approved">
                                    <span class="ng-binding">Approved</span>
                                    <span id="approved"> (<?php echo count($approved); ?>)</span>
                                </a>
                            </li>

                            

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/Pending">
                                    <span class="ng-binding">Pending</span>
                                    <span id="approved"> (<?php echo count($pending); ?>) </span>
                                </a>
                            </li>

                            <li class="rejected">
                                <a href="<?php echo base_url(); ?>index.php/owners/checkstatus/Rejected">
                                    <span class="ng-binding">Rejected</span>
                                    <span id="approved"> (<?php echo count($rejected); ?>) </span>
                                </a>
                            </li>

                            <li class="inprocess">
                                <a  href="<?php echo base_url(); ?>index.php/owners/checkstatus/InProcess">
                                    <span class="ng-binding">In Process</span>
                                    <span id="approved"> (<?php echo count($inprocess); ?>) </span>
                                </a>
                            </li>    
  <li class="icon">
    <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
  </li>
</ul>
      
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                 <div class="row  main-wrapper">					
				     <div class="main-container"> 						
                        <div class="col-md-12">
						<div class="panel panel-default inside-width" style="border:none; box-shadow:none;">	
							<div class="panel-body">                                                                        
								

										<?php $this->load->view('templates/download');?> 
								
							<div class="panel-body" >
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top: none;">
									<thead>
										<tr>
											<th style="padding:5px;" width="40" align="center">Sr. No.</th>
											<th style="padding:5px;" width="500">Name</th>
											<th style="padding:5px;" width="100">Category</th>
											<th style="padding:5px;" width="50">Status</th>
											<th style="padding:5px;" width="50">Created Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=0; $i <count($owners); $i++) { ?>
										<tr id="trow_1">
											<td style="padding:5px;" align="center"><?php if(isset($owners)){ echo ($i+1) ;} else {echo '1';} ?></td>
											<?php if(isset($access)) { if($access[0]->r_view == 1) { ?>
												<td style="padding:5px;"><a href="<?php echo base_url().'index.php/owners/'.$editaction[$i].'/'.$owners[$i]->ow_id; ?>"><?php echo $ownername[$i]; ?></a></td>
											<?php } else { ?> <td style="padding:5px;"><?php echo $ownername[$i]; ?></td> 
											<?php }} else { ?> <td style="padding:5px;"><?php echo $ownername[$i]; ?></td> 
											<?php } ?>
											
											<td style="padding:5px;"><?php echo $ownergroup[$i]; ?></td>
											<td style="padding:5px;"><?php echo $owners[$i]->ow_status; ?></td>
											<td style="padding:5px;"><?php if($owners[$i]->ow_create_date!='' && $owners[$i]->ow_create_date!=null) echo date('d/m/Y', strtotime($owners[$i]->ow_create_date)); ?></td>
											<!-- <td>
											<?php //if(isset($access)) { if($access[0]->r_edit == 1) { ?>
												<a href="<?php //echo base_url().'index.php/owners/'.$editaction[$i].'/'.$owners[$i]->ow_id; ?>"><button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button></a>
												<?php //} if($access[0]->r_delete == 1) { ?>
												<button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button>
												<?php //} } ?>
											</td> -->
										</tr>
										<?php } ?>
										
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
						</div>
						</div>
						
					</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
		
		<script type="text/javascript">
			function loadType() {
				var catval=document.getElementById('category').value;
				if(catval=="0") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_individual'; ?>")
				} else if (catval=="1") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_huf'; ?>")
				} else if (catval=="2") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_pvtltd'; ?>")
				} else if (catval=="3") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_ltd'; ?>")
				} else if (catval=="4") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_llp'; ?>")
				} else if (catval=="5") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_partnership'; ?>")
				} else if (catval=="6") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_aop'; ?>")
				} else if (catval=="7") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_trust'; ?>")
				} else if (catval=="8") {
					window.location.assign("<?php echo base_url().'index.php/owners/add_new_proprietorship'; ?>")
				}
			}
		</script>
    <!-- END SCRIPTS -->    
      <script>
            $(document).ready(function() {               

                var url = window.location.href;
                if(url.includes('All')){
                    $('.all').attr('class','active');
                } else  if(url.includes('Approved')){
                    $('.approved').attr('class','active');
                } else  if(url.includes('Assigned')){
                    $('.assigned').attr('class','active');
                } else  if(url.includes('Pending')){
                    $('.pending').attr('class','active');
                } else  if(url.includes('Rejected')){
                    $('.rejected').attr('class','active');
                } else  if(url.includes('InProcess')){
                    $('.inprocess').attr('class','active');
                } else {
                    $('.all').attr('class','active');
                }

                $('.ahrefall').click(function(){
                    alert(window.location.href );
                    //$('.a').attr('class','active');
                });
            });
        </script>  
    </body>
</html>