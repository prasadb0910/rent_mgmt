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
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}

.dataTables_empty { color:#e90404!important; font-size: 14px!important;  }
.bin {font-size:20px; font-weight: 600;  color: #333;  }
.bin:hover { color: #e90404; }
.btn-cntnr { margin-bottom: 10px; }
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
                   <div class="heading-h2-heading">	<a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Document List</div>	 
					 
					  <div class="heading-h2-heading">
                    	<div class="pull-left ">
												 <a class="btn btn-success btn-block" href="<?php echo base_url().'index.php/Documents/addDocument'; ?>">
												<span class="fa fa-plus"></span> Add Document
											</a>
				</div>	      
                </div>	 
                 </div>  

                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
							 <div class="main-container"> 					
						
                        <div class="col-md-12">
						<div class="panel panel-default inside-width">
							
						
						
								
							<!-- START DATATABLE EXPORT -->

									<?php $this->load->view('templates/download');?>
						
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top:none;  ">
									<thead>
										<tr>
											<th width="75" align="center">Sr. No.</th>
											<th width="150" >Document Name</th>
											<th  >Description</th>
											<th >Category</th>
											<th >Sub Category</th>
											<th  >Body Corporate</th>
											<th  >Property Type</th>
											<th width="100">Created Date</th>
											<th   width="80" align="center">Actions</th>
											<!-- <th width="100">Status</th> -->
										</tr>
									</thead>
									<tbody>
										<?php for($i=0;$i<count($documents); $i++) {?>
										<tr id="trow_1">
											<td align="center"><?php echo ($i + 1); ?></td>
											<td><a href="<?php echo base_url().'index.php/Documents/viewDocument/'.$documents[$i]->d_id; ?>"><?php echo $documents[$i]->d_documentname ; ?></a></td>
											<td><?php echo $documents[$i]->d_description ?></td>
											<td><?php echo $documents[$i]->d_status; ?></td>
											<td><?php echo $documents[$i]->d_t_type; ?></td>
											<td><?php echo $doccatlist[$i]; ?></td>
											<td><?php echo $doctypelist[$i]; ?></td>
											<td><?php echo $documents[$i]->d_add_date; ?></td>
											<td style="text-align:center;" align="middle">
												<a onclick="return confirm('Are you sure you want to delete this item?');" class="bin" href="<?php echo base_url().'index.php/Documents/deleteRecord/'.$documents[$i]->d_id; ?>"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
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