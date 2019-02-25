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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/software-view.css'; ?>"/>  
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->                                      
		 

              <style type="text/css">
  .form-group { display:flex;}          
.form-group .control-label { padding:7px 0;} 
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.paddingtop { line-height:30px;}
.custom-padding .col-md-8 { line-height:30px;}
  @media screen and (max-width: 500px) 
	{
 
.custom-padding .col-md-4 { width:100%!important;}
.custom-padding .col-md-8 { width:100%!important;}
  /*.form-group { display:block!important;} */
}

   @media screen and (max-width: 650px)  	{
   .custom-padding .col-md-6 { width:100%!important;}
 .form-group { display:block!important;}
/* .custom-padding .col-md-8 { line-height:20px!important;}*/
   }

  @media screen and (max-width: 780px) 
	{
.form-group .control-label { text-align:left;  }  
    /*.form-group { display:block!important;} */
	/* .custom-padding .col-md-8 { line-height:20px!important;}*/
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
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
                if($action == 'edit_insert'){?>
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Tax_master'; ?>" > Tax  List </a>  &nbsp; &#10095; &nbsp; Tax  Details</div> 


                <form id="form_tax" method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
                    <div class="row main-wrapper">
                   <div class="main-container">           
                            <div class="box-shadow">   
                            <div class="box-shadow-inside">							
                        <div class="col-md-12 " style="padding:0;">
						<div class="full-width custom-padding">
						<div class="panel panel-default">
							
					
							<div class="panel-body">                                                                        
                                <input type="hidden" name="tax_id[]" id="tax_id_1" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_id; }  ?>">
								<div id="tax_divid_1">
								<div class="row tax_div_1" id="tax_div_1">
									<div class="form-group" >
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Tax Name *</label>
												<div class="col-md-8 col-sm-7 col-xs-12 position-view">
													<input type="text" class="form-control tax_name" name="tax_name[]" id="tax_name_1" placeholder="Tax Name" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_name; } ?>"/>
												</div>
											</div>
										</div>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="">
                                                <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Tax Percentage *</label>
                                               <div class="col-md-8 col-sm-7 col-xs-12 percentage position-view"  >
													<span  style="padding:10px 5px; line-height:30px;   "  > % </span>
                                                       <input type="text" class="form-control tax_perecnt" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?> " style="width:90px;  float:left;"/> 
													   
                                                    </div>
													 
                                             </div>
                                        </div
										<br clear="all"/> 
                                     </div>
                                     <div class="form-group"  >
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="">
                                                <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Transaction Type *</label>
                                                    <div class="col-md-8 col-sm-7 col-xs-12 position-view paddingtop" style= >
                                                        <input type="checkbox" class="icheckbox txn_type" data-error="#txn_type_1_error" name="txn_for_1[]" id="txn_purchase_1" value="purchase" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "purchase")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Purchase&nbsp;&nbsp;
                                                        <input type="checkbox" class="icheckbox" name="txn_for_1[]" id="txn_sale_1" value="sale" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "sale")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Sale&nbsp;&nbsp;
                                                        <input type="checkbox" class="icheckbox" name="txn_for_1[]" id="txn_rent_1" value="rent" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "rent")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Rent&nbsp;&nbsp;
                                                        <input type="checkbox" class="icheckbox" name="txn_for_1[]" id="txn_loan_1" value="loan" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "loan")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Loan&nbsp;&nbsp;
                                                        <input type="checkbox" class="icheckbox" name="txn_for_1[]" id="txn_maintenance_1" value="maintenance" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "maintenance")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Maintenance&nbsp;&nbsp;
                                                        <input type="checkbox" class="icheckbox" name="txn_for_1[]" id="txn_valuation_1" value="valuation" <?php if(isset($tax_detail)){if(strpos($tax_detail[0]->txn_type, "valuation")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Valuation&nbsp;&nbsp;
                                                        <div id="txn_type_1_error"></div>
                                                    </div>
                                             </div>
                                        </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <div class="">
                                                      <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Transaction Action *</label>
                                                      <div class="col-md-8 col-sm-7 col-xs-12 position-view paddingtop"  >
                                                          <input type="radio" class="txn_action icheckbox" data-error="#txn_action_1_error" name="txn_type_1" id="txn_type_add_1" value="1" <?php if(isset($tax_detail)){if($tax_detail[0]->tax_action == "1")  echo "checked='checked'";}?> >&nbsp;&nbsp;Add To Amount 
                                                          <input type="radio" class="icheckbox" name="txn_type_1" id="txn_type_sub_1" value="0" <?php if(isset($tax_detail)){if($tax_detail[0]->tax_action == '0')  echo "checked='checked'";}?> >&nbsp;&nbsp;Subtract from Amount
                                                            <div id="txn_action_1_error">                                                  
                                                            </div>
                                                     </div>
                                             </div>
                                        </div>
										<br clear="all"/> 
                                     </div>									 
									 
                                    <div  class="form-group"  	>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                              <div class="">
                                                 <label class="col-md-4 col-sm-5 col-xs-12 position-name control-label">Effective From*</label>
                                                <div class="col-md-8 col-sm-7 col-xs-12 position-view">
                                                   <input type="text" class="form-control datepicker" name="effective_date[]" id="effective_date_1" value="<?php if(isset($tax_detail)){if($tax_detail[0]->effective_date!=null && $tax_detail[0]->effective_date!='') echo date('d/m/Y',strtotime($tax_detail[0]->effective_date));}?>" required>
                                                    <div id="txn_action_1_error">                                            
                                                </div>
                                              </div>
                                            </div>
                                          </div>
										  <br clear="all"/> 
                                    </div>

                                
                        </div>
                                <!-- <div class="btn-margin" style="margin:10px!important;" >

                                    <button  type="button"  class="btn btn-success" style=""  onclick="addNewRow(this)">+</button>
                                    <button  type="button"  class="btn btn-success" style="margin-left: 10px;"  onclick="removeNewRow(this)">-</button>
                                </div> -->
                                </div>                              
                              </div>
                            </div>
							 </div>
                          </div>
                        </div>
						<!---  <div class="panel-footer">
                                	<div class="" style="float: left;width: 100%;"><br>
                                     	<div class="col-md-6 col-sm-6 col-xs-12" style="float:right;    text-align: right;">
                                     		<input type="submit" class="btn btn-success" value="Submit" />
                                     	</div>
                                    	<div class="col-md-6 col-sm-6 col-xs-12" style="float:left;    text-align: left;">
                                     		<a href="<?php echo base_url(); ?>index.php/tax_master" class="btn btn-default">Cancel</a>
                                     	</div>
                                    </div>
                                </div> -->
								
								 <div class="panel-footer">
                                   	<a href="<?php echo base_url(); ?>index.php/tax_master" class="btn btn-danger">Cancel</a>
                                    <button class="btn btn-success pull-right">Save</button>
                                    
                                </div>
                        </div> 
                      </div>
                    </div>

                </form>
              
                <!-- END PAGE CONTENT WRAPPER -->
                <?php } else{?>
                <div class="page-content-wrap">
				    <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Tax_master'; ?>" > Tax  List </a>  &nbsp; &#10095; &nbsp; Tax  View</div> 
					<div class="pull-right btn-top-margin responsive-margin">
						<!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->     
						<a class="printdiv  btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a>
						<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
						<a  class="btn-margin" href="<?php echo base_url(); ?>index.php/tax_master/tax_edit/<?php echo $tax_detail[0]->tax_id;?>" class=""> <span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
						<?php  }} ?>
						<a class="btn-margin" href="<?php echo base_url(); ?>index.php/tax_master" class=""><span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
					</div>
					
					
					
                <form method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
                    <div class="row main-wrapper">
                   <div class="main-container">  
    					  <div class="box-shadow">   
                            <div class="box-shadow-inside">	
                        <div class="col-md-12 " style="padding:0;">
						<div class="full-width custom-padding">
    				   	<div class="panel panel-default">
    						
    						 
                      <div id="pdiv" >  
    						<div class="panel-body">
    							<div class="row">
    								<div class="form-group" style=" ">
    									<div class="col-md-6 col-sm-6 col-xs-12">
    										<div class="">
    											<label class="col-md-4 col-sm-5 col-xs-12 control-label">Tax Name :</label>
    											<div class="col-md-8 col-sm-7 col-xs-12">
    												<!-- <input type="text" class="form-control" name="tax_name[]"  placeholder="Tax Name" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_name; } ?>"/> -->
    												<?php echo $tax_detail[0]->tax_name;?>
    											</div>
    										</div>
    									</div>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="">
                                                <label class="col-md-4 col-sm-5 col-xs-12 control-label">Tax Percentage :</label>
                                                    <div class="col-md-8 col-sm-7 col-xs-12">
                                                       <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                                    	<?php echo $tax_detail[0]->tax_percent;?>  %
                                                    </div>
                                             </div>
                                        </div>
										<br clear="all"/> 
                                    </div>
                                </div>

                                <div class="row">
                                <div class="form-group" style=" ">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php $tranasction_type=array("Subtract From Amount","Add To Amount"); ?>
                                    <div class="">
                                        <label class="col-md-4 col-sm-5 col-xs-12 control-label">Transaction Action :</label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                               <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                                <?php echo $tranasction_type[$tax_detail[0]->tax_action];?>
                                            </div>
                                     </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php //$tranasction_type=array("Subtract From Amount","Add To Amount"); ?>
                                    <div class="">
                                        <label class="col-md-4 col-sm-5 col-xs-12 control-label">Transaction Type :</label>
                                        <div class="col-md-8 col-sm-7 col-xs-12">
                                           <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                            <?php echo $tax_detail[0]->txn_type;?>
                                        </div>
                                    </div>
                                </div>
								<br clear="all"/> 
                                </div>
                                </div>
                                <div class="row">
                                <div class="form-group print-border" style=" ">
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="col-md-4 col-sm-5 col-xs-12 control-label">Effective Date :</label>
                                        <div class="col-md-8 col-sm-7 col-xs-12">
                                           <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                            <?php if(isset($tax_detail)){if($tax_detail[0]->effective_date!=null && $tax_detail[0]->effective_date!='') echo date('d/m/Y',strtotime($tax_detail[0]->effective_date));}?>
                                        </div>
                                    </div>
									<br clear="all"/> 
                                </div>
                            </div>
                           
                            </div>

    					</div>
                        </div>
						</div>	
                    </div>
				</div>
				</div>
				</div>
                </form>

           
                <?php } ?>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->     
        </div>
	</div>
        <!-- END PAGE CONTENT -->

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
			  
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} table tr th:first-child{width:10%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 { }.col-md-6 {width:50%;}.full-width {padding:0!important;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            var div_master = "";

            function addNewRow(mydiv){
            //alert(mydiv);
            	var newdiv = 0;
            	var $maindiv = $(mydiv).parents('div[id^="tax_divid_"]');
            	var $div = $($maindiv).find('div[id^="tax_div_"]:last'); 

            	var lastdivid = $div.attr("id");
            	var slice_divid = lastdivid.split("_");
            	var new_divid = parseInt(slice_divid[2]) + 1;
            	var $newdiv = $div.clone().find("input:text").val("").end().find("input:checkbox").attr('checked', false).end().find("input:radio").attr('checked', false).end().prop('id', 'tax_div_'+new_divid );
                //var $newdiv.("#tax_id_1").val(' ');
            	//var $newremovebutton = $($newdiv).find('button[id^="removebutton_"]');
                var $newtextboxtaxname = $($newdiv).find('input[id^="tax_name_"]');
                var $newcheckbox = $($newdiv).find('input[name^="txn_for_"]');
                var $newcheckboxpurchase = $($newdiv).find('input[id^="txn_purchase_"]');
                var $newcheckboxsale = $($newdiv).find('input[id^="txn_sale_"]');
                var $newcheckboxrent = $($newdiv).find('input[id^="txn_rent_"]');
                var $newcheckboxloan = $($newdiv).find('input[id^="txn_loan_"]');
                var $newcheckboxmaintenance = $($newdiv).find('input[id^="txn_maintenance_"]');
                var $newcheckboxvaluation = $($newdiv).find('input[id^="txn_valuation_"]');
                var $newcheckboxerror = $($newdiv).find('div[id^="txn_type_"]');
                var $newrediobutton = $($newdiv).find('input[id^="txn_type_add_"]');
                var $newrediobutton2 = $($newdiv).find('input[id^="txn_type_sub_"]');
                var $newradioerror = $($newdiv).find('div[id^="txn_action_"]');

                //console.log($newrediobutton);

                $($newtextboxtaxname).prop('id','tax_name_'+new_divid);
                $($newcheckbox).prop('name','txn_for_'+new_divid+'[]');
                $($newcheckboxpurchase).prop('id','txn_purchase_'+new_divid);
                $($newcheckboxpurchase).attr('data-error','#txn_type_'+new_divid+'_error');
                $($newcheckboxsale).prop('id','txn_sale_'+new_divid);
                $($newcheckboxrent).prop('id','txn_rent_'+new_divid);
                $($newcheckboxloan).prop('id','txn_loan_'+new_divid);
                $($newcheckboxmaintenance).prop('id','txn_maintenance_'+new_divid);
                $($newcheckboxvaluation).prop('id','txn_valuation_'+new_divid);
                $($newcheckboxerror).prop('id','txn_type_'+new_divid+'_error');
                $($newrediobutton).prop('name','txn_type_'+new_divid).prop('id','txn_type_add_'+new_divid).attr('data-error','#txn_action_'+new_divid+'_error');
                $($newrediobutton2).prop('name','txn_type_'+new_divid).prop('id','txn_type_sub_'+new_divid);
                $($newradioerror).prop('id','txn_action_'+new_divid+'_error');
                $($newdiv).find('input[id^="effective_date_"]').prop('id','effective_date_'+new_divid);
 $newdiv.find('#effective_date_'+new_divid).removeClass('hasDatepicker').removeData('datepicker').datepicker({autoclose:true, dateFormat: "dd/mm/yy",  yearRange: "-100:+0",changeMonth: true, changeYear: true });  

                // $($newremovebutton).prop('id','removebutton_'+new_divid);
                $newdiv.insertAfter($div);
                // $($div).find('.div_master').select2();
                // $($newdiv).find('.div_master').select2();

            }

            function removeNewRow(mydiv){
                //alert(mydiv);
                var newdiv = 0;
                var $maindiv = $(mydiv).parents('div[id^="tax_divid_"]');
                var $div = $($maindiv).find('div[id^="tax_div_"]:last'); 

                var lastdivid = $div.attr("id");
                if (lastdivid!="tax_div_1"){
                    $('#' + lastdivid).remove();
                }
            }
        </script>
        <!-- END SCRIPTS -->
      <!-- END SCRIPTS -->      
  
    </body>
</html>