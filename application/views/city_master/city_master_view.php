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
		  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
<style>
.control-label {
 padding: 7px 0;
margin-bottom: 0;
text-align: right;
}
.State { padding:7px 0;}
</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
                if($action == 'edit_insert'){?>
				 <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/city_master'; ?>" > City Master List</a>  &nbsp; &#10095; &nbsp;    City Master Details</div>
                <div class="page-content-wrap">
					<div class="row main-wrapper">
					    <div class="main-container">           
					     <div class="box-shadow">   
					       <div class="box-shadow-inside">	
					          <div class="col-md-12" style="padding:0;">	
					            <div class="full-width custom-padding" >
									<div class="panel panel-default">
								      <form id="form_tax" method="post" action="<?php echo base_url()?>index.php/city_master/insertUpdateRecord">
                
										<div class="panel-body">                                                                        
                                <input type="hidden" name="city_id" id="city_id" value="<?php if(isset($city_details)){ echo $city_details[0]->city_id; }  ?>">
								
								
									<div class="form-group" style="float: left;width: 100%; ">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label State">State Name *</label>
												<div class="col-md-8">
													<select class="form-control state_name" name="state_name" id="state_name" required >
												    <option value=''>Select State</option>
                                                    <?php if(isset($state_list)){
                                                        foreach($state_list as $row){
                                                           if(isset($city_details)){
                                                            if($row->id == $city_details[0]->state_id){
                                                            echo "<option value='".$row->id."' selected='selected'>".$row->state_name."</option>";
                                                                
                                                            }
                                                            else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                            }
                                                        }
                                                        else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                        }
                                                        }

                                                    }?>
                                                    </select>
                                                </div>
											</div>
										</div>
                                         <div class="col-md-6">
                                             <div class="">
                                                <label class="col-md-4 control-label State">City Name *</label>
                                                    <div class="col-md-8">
                                                       <input type="text" class="form-control city_name" name="city_name" placeholder="City Name" value="<?php if(isset($city_details)){ echo $city_details[0]->city_name; } ?>" required/>
                                                    </div>
                                             </div>
                                        </div>
                                     </div>
                                    
                              
                                
                                <div class="">
                                	<div class="col-md-12 btn-container"  > 
									 	<div class="pull-left" >
                                     		<a href="<?php echo base_url(); ?>index.php/city_master" class="btn btn-danger">Cancel</a>
                                     	</div>
                                     	<div class="pull-right"> 
                                     		<input type="submit" class="btn btn-success" value="Submit" />
                                     	</div>
                                   
                                    </div>
                                </div>
                            </div>
				
									</form>
                                   </div>
								  </div>
							    </div>
							  </div>
				    	    </div>
					     </div>
					</div>
				</div>
                <!-- END PAGE CONTENT WRAPPER -->
                <?php } else{?>
			 
				 <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/city_master'; ?>" > City Master List</a>  &nbsp; &#10095; &nbsp;    City Master View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					    <?php
                                 // if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
                                    <a class="btn-margin" href="<?php echo base_url(); ?>index.php/city_master/city_edit/<?php echo $city_details[0]->city_id;?>"  ><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                                <?php
                                 // }} ?>
				 
					 
					  <a class="btn-margin" href="<?php echo base_url(); ?>index.php/city_master" ><span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                  </div>
			 
				   
                <div class="page-content-wrap">
					<div class="row main-wrapper">
					  <div class="main-container">           
					    <div class="box-shadow">   
					       <div class="box-shadow-inside">	
					          <div class="col-md-12" style="padding:0;">	
					            <div class="full-width" >
									<div class="panel panel-default">
                                      <form method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
									   <div class="panel-body">
    								  <div class="form-group" style="float: left;width: 100%; ">
    									<div class="col-md-12">
    										<div class="">
    											<label class="col-md-2 control-label">City Name</label>
    											<div class="col-md-10">
    												<!-- <input type="text" class="form-control" name="tax_name[]"  placeholder="Tax Name" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_name; } ?>"/> -->
    												<?php echo $city_details[0]->city_name;?>
    											</div>
    										</div>
    									</div>
									  </div>
									    <div class="form-group" style="float: left;width: 100%; ">
                                         <div class="col-md-12">
                                             <div class="">
                                                <label class="col-md-2 control-label">State Name</label>
                                                    <div class="col-md-10">
                                                       <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                                    	<?php echo $city_details[0]->state_name;?>
                                                    </div>
                                             </div>
                                        </div>
                                    </div>

                                    <div class=" ">
                                    <div class="col-md-12 btn-container btn-display"  >
                                <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url(); ?>index.php/city_master/delete_record/<?php if(isset($city_details)){ echo $city_details[0]->city_id; }  ?>" class=""><span class="btn btn-danger pull-right btn-font"> Delete </span>  </a>
                                        
                                    </div>
                                 </div>
                            

                            
                             
                            </div>
									</form>
								 </div>
								</div>
							   </div>
						   </div>
						</div>
					  </div>
			       </div>
			   </div>
                <?php } ?>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->     
        </div>
        <!-- END PAGE CONTENT -->

        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            var div_master = "";

            
        </script>
        <!-- END SCRIPTS -->
    </body>
</html>