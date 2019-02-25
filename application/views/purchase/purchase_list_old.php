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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Purchase  List</div>
                          <div class="nav-contacts ng-scope" ui-view="@nav">
							  <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
								 <div class="container u-posRelative u-textRight">
									   <div class="pull-left btn-top">
												<?php if(isset($access)){ if($access[0]->r_insert == 1) {?>
															<a class="btn btn-default" href="<?php echo base_url().'index.php/Purchase/addnew'; ?>">
																<span class="fa fa-plus"> </span> Add Purchase Details
															</a>
														<?php } } ?>
												</div>
									
									<i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

									<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
										<li class="all">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/All">
												<span class="ng-binding">All</span>
													<span id="approved">(<?php if(isset($all)) echo $all; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="approved" >
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Approved">
												<span class="ng-binding">Approved</span>
													<span id="approved">(<?php if(isset($approved)) echo $approved; else echo 0; ?>)</span>
											</a>
										</li>

										

										<li class="pending">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Pending">
												<span class="ng-binding">Pending</span>
												<span id="approved">(<?php if(isset($pending)) echo $pending; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="rejected">
											<a href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Rejected">
												<span class="ng-binding">Rejected</span>
												<span id="approved">(<?php if(isset($rejected)) echo $rejected; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="inprocess">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/InProcess">
												<span class="ng-binding">In Process</span>
											<span id="approved">(<?php if(isset($inprocess)) echo $inprocess; else echo 0; ?>)</span>
											</a>
										</li>           
									</ul>

									<i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
							   </div>
							 </div>
                          </div>               
                
                
                <!-- PAGE CONTENT WRAPPER -->
	                	<ul class="topnav" id="myTopnav">
		             		   			<li class="all">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/All">
												<span class="ng-binding">All</span>
													<span id="approved">(<?php if(isset($all)) echo $all; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="approved" >
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Approved">
												<span class="ng-binding">Approved</span>
													<span id="approved">(<?php if(isset($approved)) echo $approved; else echo 0; ?>)</span>
											</a>
										</li>

										

										<li class="pending">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Pending">
												<span class="ng-binding">Pending</span>
												<span id="approved">(<?php if(isset($pending)) echo $pending; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="rejected">
											<a href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Rejected">
												<span class="ng-binding">Rejected</span>
												<span id="approved">(<?php if(isset($rejected)) echo $rejected; else echo 0; ?>)</span>
											</a>
										</li>

										<li class="inprocess">
											<a  href="<?php echo base_url(); ?>index.php/purchase/checkstatus/InProcess">
												<span class="ng-binding">In Process</span>
											<span id="approved">(<?php if(isset($inprocess)) echo $inprocess; else echo 0; ?>)</span>
											</a>
										</li>           
								 
  <li class="icon">
    <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
  </li>
</ul>
			
				

                <div class="page-content-wrap">                
                    <div class="row  main-wrapper">					
				        <div class="main-container"> 						
                             <div class="col-md-12" style="padding:0;" >
								<div class="panel panel-default inside-width" style="border:none;box-shadow:none; ">			
						 
							   
							
								
										<?php $this->load->view('templates/download');?> 

							<!-- START DATATABLE EXPORT -->
							
								<div class="panel-body"  >
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>

											<th  width="70" align="center" >Sr. No.</th>
											<th    >Property Name</th>
											<th   >Owner Name</th>
											<th    >Property Type</th>
											<th  width="180">Purchased Price   (In Rs)</th>
											<th  >Purchased Date</th>
											<th   width="80" >Status</th>

										</tr>
									</thead>
									<tbody>
										<?php if (isset($property)) { for($i=0;$i<count($property); $i++ ) { ?>
										<tr id="trow_<?php echo $i+1;?>">
											<td style="padding:5px;  text-align:center;"><?php echo ($i+1); ?></td>
											<td style="padding:5px;"><a href="<?php echo base_url().'index.php/Purchase/view/'.$property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></a></td>
											<td style="padding:5px;"><?php echo $property[$i]->owner_name; ?></td>
											<td style="padding:5px;"><?php echo $property[$i]->p_type; ?></td>
											<td style="padding:5px;  "><?php echo format_money($property[$i]->purchase_price,2); ?></td>
											<td style="padding:5px;"><?php echo ($property[$i]->p_purchase_date!=null && $property[$i]->p_purchase_date!='')?date('d/m/Y',strtotime($property[$i]->p_purchase_date)):''; ?></td>
											<td style="padding:5px;"><?php echo $property[$i]->txn_status; ?></td>
										</tr>
										<?php }} ?>
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
		 <script>
            $(document).ready(function() {               

                var url = window.location.href;
                if(url.includes('All')){
                    $('.all').attr('class','active');
                } else if(url.includes('Approved')){
                    $('.approved').attr('class','active');
                } else if(url.includes('Assigned')){
                    $('.assigned').attr('class','active');
                } else if(url.includes('Pending')){
                    $('.pending').attr('class','active');
                } else if(url.includes('Rejected')){
                    $('.rejected').attr('class','active');
                } else if(url.includes('InProcess')){
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
    <!-- END SCRIPTS -->      
    </body>
</html>