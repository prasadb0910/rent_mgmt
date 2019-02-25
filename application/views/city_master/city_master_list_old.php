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
        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>                                 
		
		<style>	 
.heading-h2 { background:#eee;   line-height: 25px;   padding: 7px 15px;   text-transform:uppercase;   font-weight:600;    display: inline-block;     margin-top:61px;    width: 100%;    font-size: 14px; border-bottom:1px solid #ddd;}
		</style>
    </head>
    <body>								
            <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>   

                   <div class="heading-h2"> 
                   <div class="heading-h2-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; City Details List </div>	 
					 
					  <div class="heading-h2-heading">
                    	<div class="pull-left ">
						<div class="c">
											<?php  //if(isset($access)) { if($access[0]->r_insert == 1) {  ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/city_master/city_edit">
												<span class="fa fa-plus"></span> Add City
											</a>
											<?php // }}  ?>
						</div>
				   </div>	      
                 </div>	 
                 </div>  
                  
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row  main-wrapper">
						<div class="main-container"> 
                           <div class="col-md-12">
							<div class="panel panel-default inside-width">
								<?php $this->load->view('templates/download');?> 
								
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top: none;">
									<thead>
										<tr>
											<th width="90" align="center">Sr. No.</th>
											<th >City </th>
											<th > State</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										if(isset($city_details)){
										 for($i=0; $i < count($city_details); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td align="center"><?php if(isset($city_details)){ echo ($i+1) ;} else {echo '1';} ?></td>
											
												<td>
														<a href="<?php echo base_url().'index.php/city_master/city_view/'.$city_details[$i]->city_id; ?>"><?php echo $city_details[$i]->city_name; ?></a>
													
												</td>
												<td><?php echo $city_details[$i]->state_name;?></td>
												
												
										</tr>
										<?php } 
									}?>
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
		
    <!-- END SCRIPTS -->      
    </body>
</html>