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
		/*	 table thead tr th:nth-child(6) { display: none; }
              table  tr td:nth-child(6) { display: none; }*/
			  .heading-h2-heading { width:100%;}
			  .heading-h2 {
    background: #eee;
    line-height: 25px;
    padding: 7px 15px;
    text-transform: uppercase;
    font-weight: 600;
    display: inline-block;
    margin-top: 61px;
    width: 100%;
    font-size: 14px;
}
		</style>
	
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>   

                   <div class="heading-h2"> 
                   <div class="heading-h2-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Group Master  </div>	 
					 
					  <div class="heading-h2-heading">
                    	<div class="pull-left ">
												<?php if(isset($access)) { 
					if($access[0]->r_insert == 1) {
					?>
					<a class="btn btn-success btn-block" href="<?php echo base_url(); ?>index.php/groups/add_Group">
					<span class="fa fa-plus"></span> Add Group
					</a>
					<?php }} ?>
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

									<table id="customers2" class="table datatable table-bordered" style="border-top:none;">
										<thead>
											<tr>
												<th width="78" align="center">Sr. No.</th>
												<th  >Group Name</th>
												<th  >Owner</th>
												<th width="100" >Status</th>
												<th width="130">Creation Date</th>
												<!--<th width="75">Actions</th>-->
											</tr>
										</thead>
										<tbody>

	                                        <?php for ($i=0;$i< count($group);$i++) {
										      echo '<tr id="trow_1">';
											  echo '<td  align="center">'.(string)($i+1).'</td>';
	                                          echo '<td><a class="" href="'.base_url().'index.php/groups/view/'. $group[$i]->g_id.'">'.$group[$i]->group_name.'</a></td>';
	                                          echo '<td>'.$owners[$i].'</td>';
	                                          echo '<td>'.$group[$i]->group_status.'</td>';
	                                          echo '<td>'.date('Y-m-d',strtotime(str_replace('-','/', $group[$i]->create_date))).'</td>';
	                                         // echo '<td>';
											 // if($access[0]->r_edit==1) { echo '<a class="btn btn-default btn-rounded btn-sm" href="'.base_url().'index.php/groups/view/'. $group[$i]->g_id.'"><span class="fa fa-eye"></span></a>'; }
											 // if($access[0]->r_edit==1 or $access[0]->r_approvals==1 )	{ echo '<a class="btn btn-default btn-rounded btn-sm" href="'.base_url().'index.php/groups/edit/'. $group[$i]->g_id.'"><span class="fa fa-pencil"></span></a>'; }
											 // echo	'</td>';
											  echo '</tr>';
	                                        }
	                                        ?>
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
    </body>
</html>