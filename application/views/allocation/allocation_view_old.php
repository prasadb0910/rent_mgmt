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
        <!-- EOF CSS INCLUDE -->
	<style>
	@media only screen and (max-width: 660px) { 
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
	</style>
    </head>
    <body>								
      <!-- START PAGE CONTAINER -->
          <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">                  
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/allocation'; ?>" > Sub-Property List</a>  &nbsp; &#10095; &nbsp;    Sub-Property View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				        <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?><a class="btn-margin" href="<?php echo base_url() . 'index.php/Allocation/edit/' . $p_id . '/' . $sub_property[0]->txn_status; ?>"  ><span class="btn btn-success pull-right btn-font"> Edit </span>  </a><?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/allocation" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                  </div>
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
				    <div class="row main-wrapper">
					  <div class="main-container">           
					    <div class="box-shadow">   
					        <div class="box-shadow-inside">	
					          <div class="col-md-12" style="padding:0;">	
					             <div class="full-width custom-padding" >
									<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" method="post" action="javascript:alert('Form #validate2 submited');">
                             
                            <div id="pdiv" >
                                <div class="panel-body">
                                    <div class="form-group print-border" style="border-top:0px dotted #ddd; ">
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Property Name :</label>
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    <?php for ($i=0; $i < count($property) ; $i++) { ?>
                                                        <?php if(isset($sub_property)) { if($sub_property[0]->property_id==$property[$i]->txn_id) { ?>
                                                            <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php echo $property[$i]->p_property_name; ?> </label>
                                                        <?php } } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Owner Name :</label>
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    
                                                            <label class="col-md-12 control-label contact-view" style="text-align:left;">
                                                             <?php 
                                                             if(isset($owner)){
                                                                $owner_name='';
                                                                foreach($owner as $row){
                                                                    $owner_name=$owner_name.' ,'.$row->owner_name;
                                                                }
                                                                echo substr($owner_name,2);
                                                             }
                                                            ?> </label>
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                  
        							<div class="mb-container" style="background:#fff; margin:10px;">
        								<div class="mb-middle">
        									<div class="mb-content">
                                            	<div class="sub-property-grid">
        										<div class="table-stripped" style="border-top:1px solid #ddd;">
                                                    <table id="contacts" class="table group addschedule table-bordered" style="border-top:0;">
                                                        <thead>
                                                        <tr>
                                                        <th style="text-align: center;vertical-align: middle;" width="60px">Sr. No.</th>
                                                        <th style="text-align: center;vertical-align: middle;">Sub Property Name</th>
                                                        <th style="text-align: center;vertical-align: middle;">Sub Property Type</th>
                                                        <th style="text-align: center;vertical-align: middle;">Carpet Area</th>
                                                        <th style="text-align: center;vertical-align: middle;">Built Up Area</th>
                                                        <th style="text-align: center;vertical-align: middle;">Saleable Area</th>
                                                        <th style="text-align: center;vertical-align: middle; width:130px">Allocated Cost (In &#x20B9;)</th>
                                                        <th style="text-align: center;vertical-align: middle; width:180px">Allocated Maintenance (In &#x20B9;)</th>
                                                        <th style="text-align: center;vertical-align: middle; width:160px">Allocated Expenses (In &#x20B9;)</th>
                                                        </tr>
                                                        </thead>
                                                    <tbody>
                                                    <?php if(isset($sub_property)) { for ($i=0; $i < count($sub_property) ; $i++) { ?>
                                                    <tr>
                                                        <td style="vertical-align: middle;" align="middle"><?php echo $i+1;?></td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo $sub_property[$i]->sp_name; ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo $sub_property[$i]->sp_type; ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->sp_carpet_area,2) . ' '; ?>
                                                            <?php echo $sub_property[$i]->sp_carpet_area_unit; ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->sp_builtup_area,2) . ' '; ?>
                                                            <?php echo $sub_property[$i]->sp_builtup_area_unit; ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->sp_sellable_area,2) . ' '; ?>
                                                            <?php echo $sub_property[$i]->sp_sellable_area_unit; ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->allocated_cost,2); ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->allocated_maintainance,2); ?>
                                                        </td>
                                                        <td style="vertical-align: middle;" align="middle">
                                                            <?php echo format_money($sub_property[$i]->allocated_expenses,2); ?>
                                                        </td>
                                                    </tr>
                                                    <?php }} ?>
                                                    </tbody>
                                                    </table>
        								        </div>
                                                </div>
        									</div>
        								</div>
        							</div>

                                
                                </div>

                                <?php $this->load->view('templates/pending_activity_view');?>
                                <div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
                                    <h3 class="panel-title"><strong> Remarks</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group row print-form-group" style="border-top:0px dotted #ddd;">
                                        <label class="col-md-2 Remarks control-label"><strong>Maker Remarks:</strong></label>
                                        <div class="col-md-10">
                                              <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($sub_property)) { echo $sub_property[0]->maker_remark; } ?></label> 
                                        </div>
                                    </div>
                                    <div class="form-group row print-form-group print-border">
                                        <label class="col-md-2 Remarks control-label"><strong>Checker Remarks:</strong></label>
                                        <div class="col-md-10">
                                              <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
							</form>
							
                            <?php if(isset($sub_property)) { ?>
                            <?php if($sub_property[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Allocation/updaterecord/'.$p_id.'/'.$sub_property[0]->txn_status; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
									   <div class="col-md-2   sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10  ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></textarea>
                                        </div>
                                      
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } else if($sub_property[0]->modified_by != '' && $sub_property[0]->modified_by != null) { if($sub_property[0]->modified_by!=$allocationby) { if($sub_property[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Allocation/approverecord/'.$p_id.'/'.$sub_property[0]->txn_status; ?>">
                                   <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                         <div class="col-md-2  sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10  ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></textarea>
                                        </div>
                                  
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                                </form>

                            <?php } } } } else { ?>

                                <form id="" method="post" action="<?php echo base_url().'index.php/Allocation/updaterecord/'.$p_id.'/'.$sub_property[0]->txn_status; ?>">
                                      <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                         <div class="col-md-2   sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></textarea>
                                        </div>
 
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } else if($sub_property[0]->created_by != '' && $sub_property[0]->created_by != null) { if($sub_property[0]->created_by!=$allocationby) { if($sub_property[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Allocation/approverecord/'.$p_id.'/'.$sub_property[0]->txn_status; ?>">

                                       <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2   sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10  ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></textarea>
                                        </div>
                                        
                                        
                                        </div>
                                        </div>
                                         
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    
                                        </div> 
                                </form>

                            <?php } } } } else { ?>
                                
                                <form id="" method="post" action="<?php echo base_url().'index.php/Allocation/updaterecord/'.$p_id.'/'.$sub_property[0]->txn_status; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                         <div class="col-md-2   sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10  ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($sub_property)) { echo $sub_property[0]->txn_remarks; } ?></textarea>
                                        </div>                                       
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } ?>
                            
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
                 $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")

               newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:40%;}.col-md-6 {width:50%;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>