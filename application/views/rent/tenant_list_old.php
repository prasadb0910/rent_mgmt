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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->                                   
		
		<style>
			 
		.nav-tabs > li > a:hover {
		    border-color: transparent;
		    background: #33414e; color: #fff; border-top-right-radius:3px; border-top-left-radius: 3px;
		}
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .nav-tabs > .dropdown.active.open > a:hover {
		    border: 0px;
		    border-top: 2px solid #33414e; color: #fff;
		    background: #33414e;
		    -moz-border-radius: 3px 3px 0px 0px;
		    -webkit-border-radius: 3px 3px 0px 0px;
		    border-radius: 3px 3px 0px 0px;
		}
		.panel-default .tabs { border: 1px solid #eee; box-shadow: none; background: #fff transparent;  }
		</style>
		<style>
		.table-responsive { padding:10px;}
		.tab-section { margin-top:40px;}
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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Tenant List</div>
                          <div class="nav-contacts ng-scope" ui-view="@nav">
							  <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
								 <div class="container u-posRelative u-textRight">
											<div class="pull-left btn-top">
												<div class="NotOnrent1">
													<?php if(isset($access)) { if($access[0]->r_insert == 1) { ?>
													<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/Rent/addnew">
														<span class="fa fa-plus"></span> Add Tenant Details
													</a>
													<?php }} ?>
												</div>
												<div class="Onrent1">
													<?php if(isset($access)) { if($access[0]->r_insert == 1) { ?>
												  <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/Rent/addnew">
													<span class="fa fa-plus"></span> Add Tenant Details
												</a>
												<?php }} ?>
												</div>
										</div>

									
									<i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

									
									<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
										<li class="all">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/All">
												<span class="ng-binding">All</span>
													<span id="approved">(<?php if(isset($all)) echo $all; else echo 0; ?>)</span>
											</a>

										</li>


										<li class="approved" >
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/Approved">
												<span class="ng-binding">Approved</span>
													<span id="approved">(<?php if(isset($approved)) echo $approved; else echo 0; ?>)</span>
											</a>
										</li>
										

										<li class="pending">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/Pending">
												<span class="ng-binding">Pending</span>
												<span id="approved">(<?php if(isset($pending)) echo $pending; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="rejected">
											<a href="<?php echo base_url(); ?>index.php/rent/checkstatus/Rejected">
												<span class="ng-binding">Rejected</span>
												<span id="approved">(<?php if(isset($rejected)) echo $rejected; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="inprocess">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/InProcess">
												<span class="ng-binding">In Process</span>
											<span id="approved">(<?php if(isset($inprocess)) echo $inprocess; else echo 0; ?>)</span>
											</a>
										</li>           
									</ul>

									<i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
							   </div>
							 </div>
                          </div>         
         
					<ul class="topnav" id="myTopnav">
		             		   						<li class="all">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/All">
												<span class="ng-binding">All</span>
													<span id="approved">(<?php if(isset($all)) echo $all; else echo 0; ?>)</span>
											</a>

										</li>


										<li class="approved" >
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/Approved">
												<span class="ng-binding">Approved</span>
													<span id="approved">(<?php if(isset($approved)) echo $approved; else echo 0; ?>)</span>
											</a>
										</li>
										

										<li class="pending">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/Pending">
												<span class="ng-binding">Pending</span>
												<span id="approved">(<?php if(isset($pending)) echo $pending; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="rejected">
											<a href="<?php echo base_url(); ?>index.php/rent/checkstatus/Rejected">
												<span class="ng-binding">Rejected</span>
												<span id="approved">(<?php if(isset($rejected)) echo $rejected; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="inprocess">
											<a  href="<?php echo base_url(); ?>index.php/rent/checkstatus/InProcess">
												<span class="ng-binding">In Process</span>
											<span id="approved">(<?php if(isset($inprocess)) echo $inprocess; else echo 0; ?>)</span>
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
                             <div class="col-md-12" style="padding:0;" >
								<div class="panel panel-default inside-width" style="border:none;box-shadow:none;  ">		
								<?php $this->load->view('templates/download');?> 
							
							<div class="tab-section" style=" ">                               
                            <!-- START JUSTIFIED TABS -->
                            <div class="panel panel-default tabs" >
                                <ul class="nav nav-tabs">
                                    <li class="active Onrent"><a href="#tab8" data-toggle="tab">Properties on Rent</a></li>
                                    <li class="NotOnrent"><a href="#tab9" data-toggle="tab">Properties Not on Rent</a></li>
                                    
                                </ul>
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab8">
                                        <!-- START DATATABLE EXPORT -->
										
										<div class="panel-body" >
											<div class="table-responsive">
											<table id="customers2" class="table datatable table-bordered">
												<thead>
													<tr>

														<th style="padding:5px;" width="40"> Sr. No.</th>

														<th style="padding:5px;" width="125">Property Name</th>
														<th style="padding:5px;" width="125">Sub Property Name</th>
														<th style="padding:5px;" width="100">Tenant Name</th>
														<th style="padding:5px;" width="70">Rent Per Month</th>
														<th style="padding:5px;" width="70">Possession Date</th>
														<th style="padding:5px;" width="60">Termation Date</th>
														<th style="padding:5px;" width="50">Status</th>

													</tr>
												</thead>
												<tbody>
													<?php for ($i=0; $i < count($rent) ; $i++) { ?>
													<tr id="trow_1">
														<td style="padding:5px;" align="center"><?php echo ($i+1); ?></td>
														<td style="padding:5px;"><a href="<?php echo base_url().'index.php/Rent/view/'.$rent[$i]->txn_id; ?>"><?php echo $rent[$i]->p_property_name; ?></a></td>
														<td style="padding:5px;"><?php echo $rent[$i]->sp_name; ?></td>
														<td style="padding:5px;"><?php echo $rent[$i]->c_name; ?></td>
														<td style="padding:5px;  "><?php echo format_money($rent[$i]->rent_amount,2); ?></td>
														<td style="padding:5px;"><?php echo ($rent[$i]->possession_date!=null && $rent[$i]->possession_date!='')?date('d/m/Y',strtotime($rent[$i]->possession_date)):''; ?></td>
														<td style="padding:5px;"><?php echo ($rent[$i]->termination_date!=null && $rent[$i]->termination_date!='')?date('d/m/Y',strtotime($rent[$i]->termination_date)):''; ?></td>
														<td style="padding:5px;"><?php echo $rent[$i]->txn_status; ?></td>
													</tr>
													<?php } ?>
													
												</tbody>
											</table>
											</div>
										</div>
										<!-- END DEFAULT DATATABLE -->
                                    </div>
                                    <div class="tab-pane" id="tab9">
                                        <!-- START DATATABLE EXPORT -->
										
										<div class="panel-body"  >
											<div class="table-responsive">
											<table id="customers3" class="table datatable table-bordered"  >
												<thead>
													<tr>
														<th style="padding:5px;" width="35" align="center">Sr. No.</th>
														<th style="padding:5px;" width="135">Property Name</th>
														<th style="padding:5px;" width="135">Owner Name</th>
														<th style="padding:5px;" width="130">Property Type</th>
														<th style="padding:5px;" width="100">Purchased Price (In Rs)</th>
														<th style="padding:5px;" width="75">Purchased Date</th>
														<th style="padding:5px;" width="20">Status</th>
													</tr>
												</thead>
												<tbody>
												<?php for($i=0;$i<count($propertynorent);$i++) { ?>
													<tr id="trow_1">
														<td style="padding:5px;"  align="center"><?php echo ($i+1); ?></td>
														<td style="padding:5px;"><?php echo $propertynorent[$i]->p_property_name; ?></td>
														<td style="padding:5px;"><?php echo $propertynorent[$i]->owner_name; ?></td>
														<td style="padding:5px;"><?php echo $propertynorent[$i]->p_type; ?></td>
														<td style="padding:5px; "><?php echo format_money($propertynorent[$i]->purchase_price,2); ?></td>
														<td style="padding:5px;"><?php echo ($propertynorent[$i]->p_purchase_date!=null && $propertynorent[$i]->p_purchase_date!='')?date('d/m/Y',strtotime($propertynorent[$i]->p_purchase_date)):''; ?></td>
														<td style="padding:5px;"><?php echo $propertynorent[$i]->txn_status; ?></td>
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
                            <!-- END JUSTIFIED TABS -->
                        	</div>
                        	
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

        <script>
			$(document).ready(function() {
				$('.NotOnrent1').hide();
                $('.Onrent1').show();
		        $('.Onrent').click(function() {
	                $('.NotOnrent1').hide();
	                $('.Onrent1').show();
		        });
		        $('.NotOnrent').click(function() {
	                $('.Onrent1').hide();
	                $('.NotOnrent1').show();
		        });
		    });
		</script>
		 <script>
            $(document).ready(function() {               

                var url = window.location.href;
                if(url.includes('All')){
                    $('.all').attr('class','active');
                }
                else  if(url.includes('Approved')){
                    $('.approved').attr('class','active');
                }
                 else  if(url.includes('Assigned')){
                    $('.assigned').attr('class','active');
                }
                 else  if(url.includes('Pending')){
                    $('.pending').attr('class','active');
                }
               else  if(url.includes('Rejected')){
                    $('.rejected').attr('class','active');
                }
                  else  if(url.includes('InProcess')){
                    $('.inprocess').attr('class','active');
                }


                $('.ahrefall').click(function(){
                    alert(window.location.href );
                    //$('.a').attr('class','active');
                });
            });
         </script>	
    <!-- END SCRIPTS -->      
    </body>
</html>