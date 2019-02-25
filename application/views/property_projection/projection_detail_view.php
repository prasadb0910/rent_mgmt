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
 @media only screen and (max-width: 772px) { 
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
@media screen and (min-width: 250px) and (max-width:767px){ 
.remark-container { padding:15px; padding-top:0; }
.remark-container .control-label{padding:5px 10px!important;}
 .custom-padding .remark{padding:0!important;}
}
@media screen and (min-width: 768px) and (max-width:991px){
.custom-padding .col-md-6{ padding-top:10px;}
.custom-padding .control-label{ padding:0 3px;}
.remark-container { padding:15px; padding-top:0; }
.remark-container .control-label{padding:5px 10px!important;}
 .custom-padding .remark{padding:0!important;}
	}
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
                   <div class="heading-h2">
              <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/property_projection'; ?>" > Property Valuation List  </a>  &nbsp; &#10095; &nbsp; Property Valuation View </div> 
                      <div class="pull-right btn-top-margin responsive-margin">
                                     <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a>
                                 
      
                                     
                                   <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
                                    <a class="btn-margin" href="<?php echo base_url(); ?>index.php/property_projection/edit/<?php echo $projection_detail[0]->id;?>"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                                <?php  }} ?>                             
                                     <a class="btn-margin" href="<?php echo base_url()?>index.php/property_projection" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                                </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">  
                        <div class="box-shadow custom-padding"  > 
					 
						

                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">

                          <div class="col-md-12" style="padding:0;">
						       <div class="full-width ">
                             <div class="panel panel-default">

                                

                                <div id="pdiv" >
                                  <div class="panel-body">
                                	<?php if(count($projection_detail) > 0 ){?>
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
                  										<div class="col-md-6" >
                  											<label class="col-md-4  position-name-1 control-label"><strong>Property Name: </strong></label>
                  											<div class="col-md-8 position-view-1">
                  											    <label class="col-md-12 control-label box-border" style="text-align:left;"> <?php echo $projection_detail[0]->p_property_name;?></label>
                  											</div>
                  										</div>
                                      <div class="col-md-6" >
                                        <label class="col-md-4  position-name-1 control-label"><strong>Sub Property Name: </strong></label>
                                        <div class="col-md-8 position-view-1">
                                            <label class="col-md-12 control-label box-border" style="text-align:left;"> <?php echo $projection_detail[0]->sp_name;?></label>
                                        </div>
                                      </div>
                  									</div>
                                	<div class="form-group">
                                    	<div class="col-md-6">
                  											<label class="col-md-4 position-name control-label"><strong>RRR: </strong></label>
                  											<div class="col-md-8 position-view">
                  											    <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo format_money($projection_detail[0]->req_rate_return,2);?></label>
                  											</div>
                  										</div>
                                    
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>RRV: </strong></label>
                                            <div class="col-md-8 position-view">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo format_money($projection_detail[0]->rrv_value,2);?></label>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>Cost Of Acquisition: </strong></label>
                                            <div class="col-md-8 position-view">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo format_money($projection_detail[0]->cost_of_aqua,2);?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="col-md-4 position-name control-label"><strong>Date: </strong></label>
                                          <div class="col-md-8 position-view">
                                              <label class="col-md-12 control-label box-border" style="text-align:left;"><?php if($projection_detail[0]->projection_date!=null && $projection_detail[0]->projection_date!='') echo date('d/m/Y',strtotime($projection_detail[0]->projection_date));?></label>
                                          </div>
                                        </div>
                                         </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>Market Rate: </strong></label>
                                            <div class="col-md-8 position-view">
                                               
                                                        <label class="col-md-12 control-label box-border" style="text-align:left;"><?php  echo format_money($projection_detail[0]->market_rate,2); ?></label>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>Market Value: </strong></label>
                                            <div class="col-md-8 position-view">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo format_money($projection_detail[0]->market_value,2);?></label>
                                            </div>
                                        </div>
                                    
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>Tax Applicable: </strong></label>
                                            <div class="col-md-8 position-view">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;"> <?php echo $projection_detail[0]->tax_name;?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-4 position-name control-label"><strong>Projected Profit Or Loss (In &#x20B9;): </strong></label>
                                            <div class="col-md-8 position-view">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;"> <?php echo format_money($projection_detail[0]->profit_loss,2);?></label>
                                            </div>
                                        </div>   
                                  
                                    </div>
                                     <div class="form-group print-form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 remark position-maker control-label"><strong>Maker Remark: </strong></label>
                                            <div class="col-md-10 remark">
                                                <label class="col-md-12 remark control-label box-border" style="text-align:left;"><?php echo $projection_detail[0]->maker_remark;?></label>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group print-form-group print-border">
                                        <div class="col-md-12">
                                            <label class="col-md-2 remark position-maker control-label"><strong>Checker Remark: </strong></label>
                                            <div class="col-md-10 remark">
                                                <label class="col-md-12 remark control-label box-border" style="text-align:left;"><?php echo $projection_detail[0]->checker_remark;?></label>
                                            </div>
                                        </div>
                                    </div>
								 </div>
                                </div>
        



                                    <div class=""></div>
                                    <?php } else {?>
                                    <div class="form-group" style="border-top:1px dotted #ddd;">
                                        <div class="col-md-12" >
                                            <label class="col-md-2 control-label"><strong>No Record Found </strong></label>
                                        </div>
                                    </div>
                                    <?php } ?>
                          </div>     
                           </div>
                            </div>
							</form>

			


                           <?php if(isset($projection_detail)) { ?>
                          <?php if($projection_detail[0]->status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                    
                               <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Property_projection/updaterecord/'.$projection_detail[0]->id; ?>">
                          <div class="panel-body" style="padding-top:0px;">
                              <div class="row">
							      <div class="remark-container"  >
                                  <label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                                  <div class="col-md-10">
                                      <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($projection_detail[0])){ echo $projection_detail[0]->checker_remark; } else { echo ''; }?></textarea>
                                  </div>

                              </div>
                          </div>
                               
                          <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Property_projection" class="btn btn-danger">Cancel</a>
                              <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" />
                          </div> 
                      </form>

                  <?php } } } else if($projection_detail[0]->updated_by != '' && $projection_detail[0]->updated_by != null) { if($projection_detail[0]->updated_by!=$Property_projectionby) { if($projection_detail[0]->status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                    
                      <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Property_projection/approve/'.$projection_detail[0]->id; ?>">
                          <div class="panel-body" style="padding-top:0px;">
                              <div class="row">
							  	      <div class="remark-container"  >
                                  <label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                                  <div class="col-md-10">
                                      <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($projection_detail[0])){ echo $projection_detail[0]->checker_remark; } else { echo ''; }?></textarea>
                                  </div>
								  </div>
                              </div>
                          </div>
                               
                          <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Property_projection" class="btn btn-danger">Cancel</a>
                              <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                              <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                          </div> 
                      </form>

                  <?php } } } } else { ?>

                              <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Property_projection/updaterecord/'.$projection_detail[0]->id; ?>">
                          <div class="panel-body" style="padding-top:0px;">
                              <div class="row">
							  	      <div class="remark-container"  >
                                  <label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                                  <div class="col-md-10">
                                      <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($projection_detail[0])){ echo $projection_detail[0]->checker_remark; } else { echo ''; }?></textarea>
                                  </div>
								  </div>
                              </div>
                          </div>
                               
                          <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Property_projection" class="btn btn-danger">Cancel</a>
                              <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" />
                          </div> 
                      </form>

                              <?php } } else if($projection_detail[0]->created_by != '' && $projection_detail[0]->created_by != null) { if($projection_detail[0]->created_by!=$Property_projectionby && $projection_detail[0]->status != 'In Process') { if($projection_detail[0]->status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                    
                                <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Property_projection/approve/'.$projection_detail[0]->id; ?>">
                          <div class="panel-body" style="padding-top:0px;">
                              <div class="row">
							  	      <div class="remark-container"  >
                                  <label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                                  <div class="col-md-10">
                                      <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($projection_detail[0])){ echo $projection_detail[0]->checker_remark; } else { echo ''; }?></textarea>
                                  </div>
								  </div>
                              </div>
                          </div>
                               
                          <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Property_projection" class="btn btn-danger">Cancel</a>
                              <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                              <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                          </div> 
                      </form>

                           <?php } } } } else { ?>
                      
                                 <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Property_projection/updaterecord/'.$projection_detail[0]->id; ?>">
                          <div class="panel-body" style="padding-top:0px;">
                              <div class="row">
							  	      <div class="remark-container"  >
                                  <label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                                  <div class="col-md-10">
                                      <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($projection_detail[0])){ echo $projection_detail[0]->checker_remark; } else { echo ''; }?></textarea>
                                  </div>
								  </div>
                              </div>
                          </div>
                               
                          <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Property_projection" class="btn btn-danger">Cancel</a>
                              <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" />
                          </div> 
                      </form>

                            <?php } } } ?>
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
        var BASE_URL = "<?php echo base_url();?>";
        //alert(BASE_URL);

        function deleteRecord(table_id){
             var formdata = {
    table_id : table_id
  }
   if((table_id != 0 || table_id) && confirm('Are you sure you wish to delete this Record?') ){ 
   $.ajax({
          type : "POST",
          data : formdata,
          dataType : 'json',
          url : BASE_URL+'index.php?/property_projection/deleteRecord',
          success : function(responsmydata){
           // console.log(responsmydata);
             if(responsmydata.status == 0){
                alert(responsmydata.msg);
                       }
                       else{
                        window.location.href=BASE_URL + 'index.php/property_projection';
                       }
                   }
  });

}
        }
        </script>
        <!-- END SCRIPTS -->      
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
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} table tr th:first-child{width:10%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 { }.col-md-6 {width:50%;}.full-width {padding:0!important;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>