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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>   
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/software-view.css'; ?>"/>  
        <!-- EOF CSS INCLUDE -->                                      
		<style> 
 @media only screen and (max-width:600px) { 
	.heading-h2 {
    display: block;   width: 100%;
}
 .responsive-margin {
    width: 100%;
    background: #fff;
    padding: 6px 15px 3px; margin-top:0px!important;
    text-align: right; margin:0;
}
}
 

 @media only screen and (max-width:992px) {  .custom-padding .dates { padding:0;}
 .custom-padding .control-label { padding:0;}
  .custom-padding .col-md-6{ padding-top:10px;}
 }
 
</style> 
         
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>                    
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Groups'; ?>" > Group Master </a>  &nbsp; &#10095; &nbsp; Group Details</div>

                   <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->
                                
                                   
									 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
                                      
                                     <a href="<?php echo base_url().'index.php/groups/edit/'.$group_id; ?>" class="btn-margin"  ><span class="btn btn-success pull-right btn-font"> Edit </span> </a>

										 <a class="btn-margin" href="<?php echo base_url()?>index.php/Groups" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                             
                                </div>

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
                     <div class="main-container">           
                         <div class="box-shadow">   
                         	  <div class="box-shadow-inside">
					
					 
						
                        <div class="col-md-12" style="padding:0;">
						<div class="full-width custom-padding">
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                              <!--   <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Group Details</strong></h3>
                                    <ul class="" style="display: flex;float: right;list-style-type: none;">
                                         <li><a class="printdiv"> <span class="btn btn-default pull-right btn-font"> Print </span>  </a></li>

                                        <li><a href="<?php echo base_url().'index.php/groups/edit/'.$group_id; ?>" class="" style="float: right;"><span class="btn btn-success pull-right btn-font"> Edit </span> </a></li>

										<li><a href="<?php echo base_url()?>index.php/Groups" > <span class="btn btn-default pull-right btn-font"> Cancel </span>  </a></li>
                                    </ul>
                                </div> -->

                                 

                                 <div id="pdiv" >  
                                <div class="panel-body" style= "">
									<div class="form-group print-border">
										<div class="col-md-4  position-main" >
										
												<label class="col-md-5 control-label"><strong>Group Name: </strong></label>
												<div class="col-md-7">
												<label class="col-md-12 control-label" style="text-align:left;"><?php echo $group[0]->group_name; ?></label>
												</div>
										
										</div>
										<div class="col-md-4 position-main">
											
												<label class="col-md-6 control-label"><strong>Date of Creation: </strong></label>
												<div class="col-md-6 dates">
												<label class="col-md-12 control-label" style="text-align:left;"><?php if (isset($group[0]->create_date)) { if($group[0]->create_date!='' && $group[0]->create_date!=null) echo date('d/m/Y',strtotime($group[0]->create_date)); } ?></label>
												</div>
											
										</div>
										<div class="col-md-4 position-main-1">
											
												<label class="col-md-4 Status control-label"><strong>Status: </strong></label>
												<div class="col-md-8">
												<label class="col-md-12 control-label" style="text-align:left;"><?php echo $group[0]->group_status; ?></label>
												</div>
											
										</div>
									</div>
								
									
                                </div>
								
								
								<!-- START DATATABLE -->
								<div class="panel-heading">
									<h3 class="panel-title">User - Owner</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
							<table id="contacts" class="table datatable group table-bordered " style="border-top:;">
											<thead>
												<tr>
													<th align="center" width="55">Sr. No.</th>
													<th>Name</th>
													<th>Designation</th>
													<th>Mobile</th>
													<th>Email ID</th>
												</tr>
											</thead>
											<tbody>
                                                <?php $gusr=0;?>
                                                <?php for($i=0;$i<count($contact); $i++) { ?>
												<tr>
													<td align="center"><?php echo ($i + 1); ?></td>
													<td class="Contact_name"><?php echo $contact[$i]->c_name . ' ' . $contact[$i]->c_last_name; ?></td>
													<td><?php echo $contact[$i]->c_designation; ?></td>
													<td><?php echo $contact[$i]->c_mobile1; ?></td>
													<td><?php echo $contact[$i]->c_emailid1; ?> </td>
												</tr>
                                                <?php } ?>
												
												
											</tbody>
										</table>
									 
										
										</div>
									</div>
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->


								<div class="panel-heading">
									<h3 class="panel-title">Software Developer - Users</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table datatable group table-bordered">
											<thead>
												<tr>
												<th align="center" width="55">Sr. No.</th>
													<th>Name</th>
													<th>Mobile No</th>
													<th>Email Id</th>
													<th>Role</th>
												</tr>
											</thead>
											<tbody>
                                                <?php $gusr=0;?>
                                                <?php for($i=0;$i<count($software_developer_users); $i++) { ?>
												<tr>
													<td align="center"><?php echo ($i + 1); ?></td>
													<td class="Contact_name"><?php echo $software_developer_users[$i]->c_name . ' ' . $software_developer_users[$i]->c_last_name; ?></td>
													
													<td><?php  if($software_developer_users[$i]->c_gid == 0){ echo $software_developer_users[$i]->c_mobile1;}else{ echo '-';} ?></td>
													<td><?php if($software_developer_users[$i]->c_gid == 0){ echo $software_developer_users[$i]->c_emailid1;}else{ echo '-';} ?></td>
													<td><?php echo $software_developer_users[$i]->gu_role; ?> </td>
												</tr>
                                                <?php } ?>
												
												
											</tbody>
										</table>
										 
										</div>
									</div>
									</div>
								</div>


								<div class="panel-heading">
									<h3 class="panel-title">Group Admin - Users</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table datatable group table-bordered">
											<thead>
												<tr>
												<th align="center" width="55">Sr. No.</th>
													<th>Name</th>
													<th>Mobile No</th>
													<th>Email Id</th>
													<th>Role</th>
												</tr>
											</thead>
											<tbody>
                                                <?php $gusr=0;?>
                                                <?php for($i=0;$i<count($group_admin_users); $i++) { ?>
												<tr>
													<td align="center"><?php echo ($i + 1); ?></td>
													<td class="Contact_name"><?php echo $group_admin_users[$i]->c_name . ' ' . $group_admin_users[$i]->c_last_name; ?></td>
													
													<td><?php  if($group_admin_users[$i]->c_gid == 0){ echo $group_admin_users[$i]->c_mobile1;}else{ echo '-';} ?></td>
													<td><?php if($group_admin_users[$i]->c_gid == 0){ echo $group_admin_users[$i]->c_emailid1;}else{ echo '-';} ?></td>
													<td><?php echo $group_admin_users[$i]->gu_role; ?> </td>
												</tr>
                                                <?php } ?>
												
												
											</tbody>
										</table>
									 
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
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        
        <?php $this->load->view('templates/footer');?>
    <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>

       $('.printdiv').click(function(){

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} table tr th:first-child{width:10%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:33.3%; text-align:left; }.col-md-6 {}.full-width {padding:0!important;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>