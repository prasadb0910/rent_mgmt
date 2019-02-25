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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		

		
		
        <style type="text/css">
 
.bootstrap-select.btn-group .dropdown-menu li > a {
    cursor: pointer;
    width: 100%;
}
.panel-body .form-group { padding-right:10px;}
        </style>	
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
		<div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
				<?php $this->load->view('templates/menus');?>                     
				   <div class="heading-h2">
              <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/property_projection'; ?>" > Property Valuation List  </a>  &nbsp; &#10095; &nbsp; Property Valuation Details </div> 
				<!-- PAGE CONTENT WRAPPER -->
				<div class="page-content-wrap">

				 <div class="row main-wrapper">                  
                    <div class="main-container">           
                         <div class="box-shadow custom-padding">
				 

				 

		        <form id="property_projection" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($projection_detail[0]->id)) { echo base_url().'index.php/property_projection/updaterecord/'.$projection_detail[0]->id; } else { echo base_url().'index.php/property_projection/saverecord'; } ?>">
				<input type="hidden" name="table_id" id="table_id" value="<?php if(!empty($projection_detail)) { echo $projection_detail[0]->id;}?>" >
					
				<div class="col-md-12" style="padding:0;">
				<div class="box-shadow-inside ">  
                <div class="panel panel-default">

				<div class="panel-body faq">	
					<div class="panel-body panel-group accordion">
						<div class="form-group" style="border-top: 1px dotted #ddd;">
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Property Name <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
										<select  class="form-control" id="property" name="property">
											<option value="">Select Property</option>
												<?php if(!empty($projection_detail)) { 

													for($i=0; $i<count($property); $i++) { ?>
														<option value="<?php echo $property[$i]->txn_id; ?>" <?php if($projection_detail[0]->purchase_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
												<?php } 
											} else { ?>
														<?php for($i=0; $i<count($property); $i++) { ?>
														<option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
												<?php } 
											} ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Sub Property</label>
									<div class="col-md-7">                                                        
										<select class="form-control" id="sub_property" name="sub_property">
											<option value="">Select Sub Property</option>
											<?php if(isset($projection_detail)) { 
												for($i=0; $i<count($sub_property); $i++) { ?>
													<option value="<?php echo $sub_property[$i]->sp_id; ?>" <?php if($projection_detail[0]->sub_property_id == $sub_property[$i]->sp_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
											<?php } } else { ?>
													<?php for($i=0; $i<count($sub_property); $i++) { ?>
													<option value="<?php echo $sub_property[$i]->sp_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
											<?php } } ?>
										</select>   
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">RRR <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
										<input type="hidden" name="agreement_area" id="agreement_area" value=" "/>  
                                        <input type="text" id="req_rate_return" name="req_rate_return" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->req_rate_return,2);}?>"  />
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">RRV <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="rrv_value" name="rrv_value" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->rrv_value,2);}?>" />
									</div>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Index Cost Value <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="index_cost_value" name="index_cost_value" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->cost_of_aqua,2);}?>" />
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Date <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="projection_date" name="projection_date" class="form-control  datepicker" value="<?php if(!empty($projection_detail)){if($projection_detail[0]->projection_date!=null && $projection_detail[0]->projection_date!='') echo date('d/m/Y',strtotime($projection_detail[0]->projection_date));}?>" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Market Rate <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="market_rate" name="market_rate" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->market_rate,2);}?>" />
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Market Value <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="market_value" name="market_value" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->market_value,2);}?>" />
									</div>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label">Tax Applicable</label>
									<div class="col-md-7">
                                        <select id="tax_app" name="tax_app" class="form-control " >
                                        	<option value="">Please Select</option>
                                        	<?php if(isset($projection_detail)) { 
												for($i=0; $i<count($tax_details); $i++) { ?>
													<option value="<?php echo $tax_details[$i]->tax_id; ?>" <?php if($projection_detail[0]->tax_applicable == $tax_details[$i]->tax_id) { echo 'selected';} ?> ><?php echo $tax_details[$i]->tax_name; ?></option>
											<?php } } else { ?>
													<?php for($i=0; $i<count($sub_property); $i++) { ?>
													<option value="<?php echo $tax_details[$i]->tax_id; ?>"><?php echo $tax_details[$i]->tax_name; ?></option>
											<?php } } ?>
                                        	<?php //if(!empty($tax_details)){
                                        		//foreach($tax_details as $row){
                                        			//echo "<option value='".$row->tax_id."'>".$row->tax_name."</option>";
                                        		//}
                                        	//} ?>
                                        </select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="">
									<label class="col-md-5 control-label" style=" padding:0!important;">Projected Profit Or Loss (In &#x20B9;) <span  class="asterisk_sign prop_other_name"> * </span></label>
									<div class="col-md-7">
                                        <input type="text" id="profit_loss" name="profit_loss" class="form-control format_number" value="<?php if(!empty($projection_detail)){echo format_money($projection_detail[0]->profit_loss,2);}?>" />
									</div>
								</div>
							</div>		
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="">
									<label class="col-md-2 control-label">Maker Remark</label>
									<div class="col-md-10">
                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(!empty($projection_detail)){ echo $projection_detail[0]->maker_remark;}?></textarea>
									</div>
								</div>
							</div>
						</div>
	            	</div>
					
            	</div>
				
				</div>
				</div>
				 <br clear="all"/>
				</div>
            	<div class="panel-footer">
                    <input type="hidden" id="submitVal" value="1" />
                    <a href="<?php echo base_url(); ?>index.php/property_projection" class="btn btn-danger" >Cancel</a>
                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style=" " />
                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                </div>

				</form>
				
				<!-- END PAGE CONTAINER -->
				
				
						</div>
					</div>
				 </div>
				</div>
		    </div>
		 </div>						
		<?php $this->load->view('templates/footer');?>
		<script type="text/javascript">
	        var BASE_URL="<?php echo base_url()?>";
	    </script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

		<script>
		<?php if (!empty($projection_detail)){ ?>
			getAgreementArea(<?php echo $projection_detail[0]->purchase_id;?>);

			<?php } ?>

		function getAgreementArea(property_id){
			$.ajax({
				url:BASE_URL+"index.php/property_projection/getAgreementArea",
				method:"post",
				dataType:"JSON",
				data:{property_id:property_id},
				success:function(responsedata){
					//console.log(responsedata);
					if(responsedata.status==1){
						//alert(responsedata.agreement_area);
						
					$("#agreement_area").val(format_money(responsedata.agreement_area,2));

					}
				}

			});
		}
		$("#req_rate_return").blur(function() {
			var req_rate_return=get_number($("#req_rate_return").val(),2);
			var property_id=$("#property").val();
			var rrv_value=0;					
			var agreement_area=get_number($("#agreement_area").val(),2); 
			rrv_value=parseInt(req_rate_return)*parseInt(agreement_area);
					$("#rrv_value").val(format_money(rrv_value,2));
					getProjected_profit_loss();
			
		});
		$("#market_rate").blur(function() {
			var market_rate=get_number($("#market_rate").val(),2);
			var agreement_area=get_number($("#agreement_area").val(),2);
			var market_value=parseInt(market_rate)*parseInt(agreement_area);
			//console.log(market_value);
			$("#market_value").val(format_money(market_value,2));
			getProjected_profit_loss();
		});

		$("#property").blur(function() {
			var property_id=$("#property").val();
			var projection_date=$("#projection_date").val();
			$.ajax({
				url:BASE_URL+'index.php/property_projection/getCostOfIndexation',
				method:"post",
				data:{property_id:property_id, projection_date:projection_date},
				dataType:"json",
				success:function(responsedata){
						$("#index_cost_value").val(format_money(responsedata,2));
					}
			});

			getAgreementArea(property_id);
			getProjected_profit_loss();

		});

		$("#projection_date").change(function() {
			var property_id=$("#property").val();
			var projection_date=$("#projection_date").val();
			console.log(projection_date);
			$.ajax({
				url:BASE_URL+'index.php/property_projection/getCostOfIndexation',
				method:"post",
				data:{property_id:property_id, projection_date:projection_date},
				dataType:"json",
				success:function(responsedata){
						$("#index_cost_value").val(format_money(responsedata,2));
					}
			});

			getAgreementArea(property_id);
			getProjected_profit_loss();

		});
		

		function getProjected_profit_loss(){
			var market_price=get_number($("#market_value").val(),2);
			var cost_of_acquisition=get_number($("#index_cost_value").val(),2);
			var rrv=$("#rrv_value").val();
			var profit_loss=0;
			profit_loss=parseInt(market_price)-parseInt(cost_of_acquisition);
			if(isNaN(profit_loss)){
				profit_loss=0;
			}
			$("#profit_loss").val(format_money(profit_loss,2));
		}


		</script>

		<script>
	        $( "#property" ).change(function() {
	            var property=$("#property").val();
	            var dataString = 'property_id=' + property + '&txn_id=' + <?php if(isset($s_id)) echo $s_id; else echo '0';?>;

	            $.ajax({
	               type: "POST",
	               url: "<?php echo base_url() . 'index.php/sale/get_sub_property' ?>",
	               data: dataString,
	               cache: false,
	               success: function(html){
	                   $("#sub_property").html(html);
	               } 
	            });
	        });
	    </script>
    </body>
</html>