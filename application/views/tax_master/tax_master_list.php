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
		.heading-h2 {  background: #eee;  line-height: 25px;   padding: 7px 15px;  text-transform: uppercase;font-weight: 600;   display: inline-block;    margin-top: 61px;   width: 100%;  font-size: 14px;}
		</style>
 
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                      <div class="heading-h2"> 
                  <div class="heaing-h2-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Tax  List </div>
					 
					 <div class="heaing-h2-heading">
					   <div class=" btn-top">
                    	<div class="pull-left ">
										<div class="c">
											<?php  if(isset($access)) { if($access[0]->r_insert == 1) {  ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/Tax_master/tax_edit">
												<span class="fa fa-plus"></span> Add Tax Details
											</a>
											<?php  }}  ?>

					</div>
				</div>	      
                </div>
					 </div>
					 
                 </div>  
                 	 
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row  main-wrapper">
						 <div class="main-container"> 
						 
						
                        <div class="col-md-12" style="padding:0;">
						<div class="panel panel-default inside-width" >

										
									<?php $this->load->view('templates/download');?> 

							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top: none;">
									<thead>
										<tr>
											<th width="80" align="center">Sr. No.</th>
											<th  >Tax Name</th>
											<th  width="155" >Tax Percentage (%)  </th>
											<th >Transaction Type</th>
											<th width="170"  >Actions</th> 
										</tr>
									</thead>
									<tbody>
										<?php $tranasction_type=array("Subtract From Amount","Add To Amount");
										 for($i=0; $i < count($tax_detail); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td align="center"><?php if(isset($tax_detail)){ echo ($i+1) ;} else {echo '1';} ?></td>
											
												<td>
														<a href="<?php echo base_url().'index.php/Tax_master/tax_view/'.$tax_detail[$i]->tax_id; ?>"><?php echo $tax_detail[$i]->tax_name; ?></a>
													
												</td>
												<td><?php echo $tax_detail[$i]->tax_percent;?></td>
												<td><?php echo $tax_detail[$i]->txn_type;?></td>
												<td><?php echo $tranasction_type[$tax_detail[$i]->tax_action];?></td>
											
											<!-- <td>
												<?php //if(isset($access)) { if($access[0]->r_edit == 1) { ?>
												<button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button></a>
												<?php //} if($access[0]->r_delete == 1) { ?>
												<a href=""><button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button></a>
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
		
    <!-- END SCRIPTS -->      
    </body>
</html>