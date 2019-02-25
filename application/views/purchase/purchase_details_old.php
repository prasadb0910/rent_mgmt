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
		
		<style>
			body {    -ms-overflow-style: scrollbar;}
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr  {	display: block;
				float: left;
				width: 100%;
				margin-top: 10px;
				margin-bottom: 10px;
				border-color: #BDBDBD;
			}
			
			.dropdown-toggle { margin:0px!important;  }  
			.bootstrap-select.form-control:not([class*="span"]) { 
			 padding:0 !important;
			}

			.bootstrap-select.btn-group .dropdown-menu{overflow:auto !important;}
			
			.message-box .mb-container {
			    position: absolute;
			    left: 15px;
			    top: 1%;
				border-radius:10px;
			    background: rgba(0, 0, 0, 0.9);
			    padding: 20px;
			    width: 98%;
			}
			.message-box .mb-container .mb-middle {
			    width: 100%;
			    left: 0%;
			    position: relative;
			    color: #FFF;
			}
			.addschedule td{
				border:1px solid;
				padding:0px !important;
			}
			.addschedule th{
				border:1px solid;
			}
			.addsummary td{
				border:1px solid;
				/*padding:0px !important;*/
			}
			.addsummary th{
				border:1px solid;
			}
			.addtax td{
				border:1px solid;
				/*padding:0px !important;*/
			}
			.addtax th{
				border:1px solid;
			}				

		</style>
		<style type="text/css">
			.remark-container {padding: 5px 0;}
			.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
			.file-input-wrapper .fileinput { overflow:hidden;}
			 textarea.form-control { overflow:hidden; min-height:80px;}
			.Documents-section .col-md-3, .col-md-4, .col-md-6, col-md-9{ padding:0 3px!important;}
			.pending-group {    padding-right: 15px!important;} 
			.btn-margin { display:block; }
			#panel-property-details { background:#fefefe;}
			  .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-']
	            {
	                padding-left:8px;
	                padding-right:8px;
	            }  
			@media only screen and  (min-width:280px)  and (max-width:1020px) { 
			.addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-'] 
			{ padding:0;  }
			#ptype { margin:0!important;}
			.datepicker{ margin:0!important;}
			.custom-padding .col-md-7 { padding:0!important;}
			.custom-padding .col-md-3 { padding:4px!important;}
			.custom-padding .abs { margin:0!important;}
			.custom-padding .repeatimg .abs { margin:0!important;}
			.custom-padding .btn-container { margin:10px!important;}
			#actual_schedule_div { overflow-x:scroll;}
			#temp_schedule_div { overflow-x:scroll;}
			}		 
		</style>

    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
		<div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
				<?php $this->load->view('templates/menus');?>
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Purchase'; ?>" > Purchase List</a>  &nbsp; &#10095; &nbsp; Purchase Details </div>
				<!-- PAGE CONTENT WRAPPER -->
		      <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	 <div class="main-container">           
                           <div class="box-shadow custom-padding"> 
		                      <form id="form_purchase" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($p_txn)) { echo base_url().'index.php/Purchase/updaterecord/'.$p_id; } else { echo base_url().'index.php/Purchase/saverecord'; } ?>">
								  <div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
				 
			                               	
			
					<input type="hidden" id="p_id" name="p_id" value="<?php if(isset($p_txn)) echo $p_id; ?>" />
			

		
						<div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>
				<div class="panel-body faq">	
					<div class="panel-body panel-group accordion">
							
						
					<div class="panel panel-primary" id="panel-ownership">
					
					
						
						<a href="#accOneColFour">   
							<div class="panel-heading">
								<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Ownership 	</h4>
							</div>  
						</a>      

						<div class="panel-body panel-body-open" id="accOneColFour">
							<div class="repeatowner">
								<?php if(isset($p_ownership)) { 
									for ($j=0; $j < count($p_ownership) ; $j++) {
						 		?>
								<div class="form-group" id="repeat_owner_<?php echo ($j+1); ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
									<div class="col-md-6">
										<div class="">
											<label class="col-md-3 control-label">Owner Name <span class="asterisk_sign">*</span></label>
											<div class="col-md-9">
												<input type="hidden" id="owner_name_<?php echo $j+1;?>_id" name="clientname[]" class="form-control" value="<?php if (set_value('clientname')!=null) { echo set_value('clientname'); } else if(isset($p_ownership[$j]->pr_client_id)){ echo $p_ownership[$j]->pr_client_id; } else { echo ''; }?>" />
	                                            <input type="text" id="owner_name_<?php echo $j+1;?>" name="owner_contact_name[]" class="form-control auto_owner ownership" value="<?php if (set_value('owner_contact_name')!=null) { echo set_value('owner_contact_name'); } else if(isset($p_ownership[$j]->c_name)){ echo $p_ownership[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
											</div>
										</div>
									</div>
									<div class="col-md-6" style="padding: 0px;">
										<div class="">
											<label class="col-md-3 control-label"  >% of Ownership <span class="asterisk_sign">*</span></label>
											<div class="col-md-9">
											<label  style="padding:10px 5px;"  > % </label> 
												<input type="text" class="form-control format_number" id="owner_percent_<?php echo $j+1;?>" name="ownership[]" placeholder="% of Ownership" value="<?php if(count($p_ownership)>0) {  echo format_money($p_ownership[$j]->pr_ownership_percent,2);} ?>" style="width:90%; float:left;"/> 
											</div>
										</div>
									</div>
									<div class="col-md-4" style="padding: 0px; display: none;">
										<div class="">
											<label class="col-md-5 control-label">Allocated Cost (In &#x20B9;)</label>
											<div class="col-md-7">
												<input type="text" class="form-control format_number" name="allocatedcost[]" placeholder="Allocated Cost of Property" value="<?php if(count($p_ownership)>0) {echo format_money($p_ownership[$j]->pr_ownership_allocatedcost,2);} ?>"/>
											</div>
										</div>
									</div>
								</div>
								<?php } } else { ?>
								<div class="form-group" id="repeat_owner_1" style="border-top: 1px dotted #ddd;">
									<div class="col-md-6">
										<div class="">
											<label class="col-md-3 control-label">Owner Name <span class="asterisk_sign">*</span></label>
											<div class="col-md-9">
												<input type="hidden" id="owner_name_1_id" name="clientname[]" class="form-control" />
	                                            <input type="text" id="owner_name_1" name="owner_contact_name[]" class="form-control auto_owner ownership" placeholder="Type to choose owner from database..." />
											</div>
										</div>
									</div>
									<div class="col-md-6" >
										<div class="">
											<label class="col-md-3 control-label" >% of Ownership <span class="asterisk_sign">*</span></label>
											<div class="col-md-9">
											   <label  style="padding:10px 5px;"  > % </label> 
												<input type="text" class="form-control format_number" id="owner_percent_1" name="ownership[]" placeholder="% of Ownership" style="width:90%; float:left;"/>	
											</div>
										</div>
									</div>
									<div class="col-md-4" style="display: none;">
										<div class="">
											<label class="col-md-5 control-label">Allocated Cost (In &#x20B9;)</label>
											<div class="col-md-7">
												<input type="text" class="form-control format_number" name="allocatedcost[]" placeholder="Allocated Cost of Property"/>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						 
							<div class="btn-margin " style="border-top:none;">
							 
									<a href="#accOneColOne" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>

									<button class="btn btn-success repeat-owner" style=" ">+</button>
            						<button type="button" class="btn btn-success reverse-owner" style="margin-left: 10px;">-</button>
								</div>

							</div>
						
				</div>
					<!-- Ownership End -->

					<div class="panel  panel-primary" id="panel-property-details">
						<a href="#accOneColOne">   
							<div class="panel-heading">
								<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>  Property Details  </h4>
							</div>   
						</a>  

						<div class="panel-body text1" id="accOneColOne" style="width:100%; ">
							<div class="form-group" style="border-top:1px dotted #ddd; ">
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label">Property Name <span class="asterisk_sign">*</span></label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="property_name" name="property_name" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_property_name; } ?>" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
										<div class="">
											<label class="col-md-3 control-label">Display Name</label>
											<div class="col-md-9">
												<input type="text" class="form-control" name="display_name" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_display_name; } ?>" />
											</div>
										</div>
								</div>
							</div>

							<div class="form-group">
							 
									<div class="col-md-3">
										<label class="col-md-6 control-label"  >Date Of Purchase <span class="asterisk_sign">*</span></label>
										<div class="col-md-6" style="  padding-right: 0; ">   
											<input type="text" class="form-control datepicker" name="date_of_purchase" placeholder=""   value="<?php if(isset($p_txn)) { echo ($p_txn[0]->p_purchase_date!=null && $p_txn[0]->p_purchase_date!='')?date('d/m/Y',strtotime($p_txn[0]->p_purchase_date)):''; } ?>" style="margin-left:6px; " />
										</div>
									</div>
								 
									<div class="col-md-3">
										<label class="col-md-6 control-label">Mode <span class="asterisk_sign">*</span></label>
										<div class="col-md-6">
											<select class="form-control" name="purchase_mode">
												<option value="">Select</option>
												<option value="Purchased" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="Purchased") {echo 'selected'; } } ?>>Purchased</option>
												<option value="Inheritance" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="Inheritance") { echo 'selected'; } } ?>>Inheritance</option>
												<option value="JV" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="JV") {echo 'selected'; } } ?>>JV</option>
												<option value="JDA" <?php if(isset($p_txn)) { if($p_txn[0]->p_purchase_mode=="JDA") { echo 'selected'; } } ?>>JDA</option>
											</select>
										</div>
									</div>
								 
								<div class="col-md-3">
									<div class="">
										<label class="col-md-6 control-label" >Property Type</label>
										<div class="col-md-6" style="padding-right: 0;">                                                                  
											<select class="form-control" id="ptype"  name="property_type" style="margin-left:8px; "  >
												<option value="">Select</option>
												<option value="Building" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Building") {echo 'selected'; } }?>>Building</option>
												<option value="Apartment" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Apartment") {echo 'selected'; }} ?>>Apartment</option>
												<option value="Bunglow" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Bunglow") {echo 'selected'; }} ?>>Bunglow</option>
												<option value="Commercial" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Commercial") {echo 'selected'; }} ?>>Commercial</option>
												<option value="Retail" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Retail") {echo 'selected'; } }?>>Retail</option>
												<option value="Industrial" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Industrial") {echo 'selected';} } ?>>Industrial</option>
												<option value="Land-Agriculture" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Land-Agriculture") {echo 'selected'; }} ?>>Land - Agriculture</option>
												<option value="Land-NonAgriculture" <?php if(isset($p_txn)) { if($p_txn[0]->p_type=="Land-NonAgriculture") {echo 'selected';} } ?>>Land - Non Agriculture</option>
											</select>
										</div>
									</div>
								</div>												
								<div class="col-md-3 p_status" style="padding-left:0;">
									<div class="">
										<label class="col-md-6 control-label" style="padding-left: 0px;padding-right: 0px;">Property Status <span class="asterisk_sign">*</span></label>
										<div class="col-md-6">                                                                  
											<select class="form-control" name="property_status" id="property_status">
												<option value="">Select</option>
												<option value="Under Construction" <?php if(isset($p_txn)) { if($p_txn[0]->p_status=="Under Construction") {echo 'selected'; }} ?>>Under Construction</option>
												<option value="Completed" <?php if(isset($p_txn)) { if($p_txn[0]->p_status=="Completed") {echo 'selected'; }} ?>>Completed</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label">Seller Name <span class="asterisk_sign">*</span></label>
										<div class="col-md-9">
											<input type="hidden" id="builder_id" name="builder_name" class="form-control" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_builder_name; } ?>" />
                                            <input type="text" id="builder" class="form-control auto_contact_owner" name="builder_name_name" value="<?php if(isset($p_txn)) { echo $p_txn[0]->seller_name; } ?>" placeholder="Type to choose contact or owner from database..." />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label"  >Usage of Property <span class="asterisk_sign" style="position:absolute; top:0; padding:10px; left:94%;">*</span></label>
										<div class="col-md-9"  >                                                                  
											<select  class="form-control" name="property_usage" value="property_usage" style="padding-left: 0;">
												<option value="">Select</option>
												<option value="Self Occupation" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Self Occupation") {echo 'selected'; } }?>>Self Occupation</option>
												<option value="Investment" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Investment") {echo 'selected'; } } ?>>Investment</option>
												<option value="Trading" <?php if(isset($p_txn)) { if($p_txn[0]->p_usage=="Trading") {echo 'selected'; } } ?>>Trading</option>
												
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row" style="">
									<div class="">
										<label class="col-md-2 control-label" >Property Description <span class="asterisk_sign">*</span>  </label>
										<div class="col-md-10">
											<input type="text" class="form-control" name="property_description" placeholder="" style="margin-left: -2px;" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_propertydescription; } ?>"/>
										</div>
									</div>
								</div>
							</div>
							<!-- display:none -->
						 	<div class="propaddr" style="display:none;"> 
						        <div class="form-group panel-heading" style=" margin-bottom:12px;  ">
						            <h3 class="panel-title" style="font-weight: bold;">Address</h3>
						        </div> 
						                                                    
						        <div class="form-group aptname">
						            <div class="col-md-4 buldname aptdesc">
						                    <div class="">
						                        <label class="col-md-4 control-label" >Building Name <span class="asterisk_sign">*</span></label>
						                        <div class="col-md-8"  >
						                            <input type="text" class="form-control" name="apartment_name" placeholder=""  value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_apartment; } ?>"/>
						                        </div>
						                    </div>
						            </div>
						            <div class="col-md-8 aptdesc"  >
						                <div class="col-md-4"  >
						                    <div class="">
						                        <label class="col-md-4 control-label" >Unit No <span class="asterisk_sign">*</span></label>
						                        <div class="col-md-8"  >
						                            <input type="text" class="form-control" name="flat_no" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_flatno; } ?>"/>
						                        </div>
						                    </div>
						                </div>
						                <div class="col-md-4"  >
						                    <div class="">
						                        <label class="col-md-3 control-label"  >Floor</label>
						                        <div class="col-md-9"  >
						                         <input type="text" class="form-control" name="floor" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_floor; } ?>"/>
						                        </div>
						                    </div>
						                </div>
						                <div class="col-md-4"  >
						                    <div class="">
						                        <label class="col-md-3 control-label"  >Wing</label>
						                        <div class="col-md-9" style="padding-right:0;"  >
						                        <input type="text" class="form-control" name="wing" placeholder=""    value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_wing; } ?>" />
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
						        
						        <div class="form-group">
						            <div class="col-md-7">
						                <div class="">
						                    <label class="col-md-2 control-label" style="">Address <span class="asterisk_sign">*</span></label>
						                    <div class="col-md-10" style=" ">
						                        <input  style="margin-left:10px;"  type="text" class="abs form-control" name="address" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_address; } ?>"/>
						                    </div>
						                </div>
						            </div>
						            <div class="col-md-5">
						                <div class="">
						                    <label class="col-md-3 control-label"  >Landmark</label>
						                    <div class="col-md-9" style="padding-right:4px;">
						                        <input   type="text" class="form-control" name="landmark" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_landmark; } ?>"/>
						                    </div>
						                </div>
						            </div>
						        </div>
						        
						        <div class="form-group">
						            <div class="col-md-3"  >
						                <div class="">
						                    <label class="col-md-5 control-label"  >City/Village <span class="asterisk_sign"  >*</span></label>
						                    <div class="col-md-7" style="padding-left: 16px;">
						                    	<input type="hidden" name="city_id" id="pur_add_city_id" />
                                                <input type="text" class="form-control autocompleteCity" name="city" id ="pur_add_city" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_city; } ?>"/>
						                    </div>
						                </div>
						            </div>
						            <div class="col-md-3" >
						                <div class="">
						                    <label class="col-md-4 control-label"  >Pin Code <span class="asterisk_sign">*</span></label>
						                    <div class="col-md-8" >
						                        <input   type="text" class="form-control" name="pincode" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_pincode; } ?>"/>
						                    </div>
						                </div>
						            </div>
						            <div class="col-md-3"  >
						                <div class="">
						                    <label class="col-md-4 control-label">State <span class="asterisk_sign">*</span></label>
						                    <div class="col-md-8" >
						                    	<input type="hidden" name="state_id" id="pur_add_state_id" />
                                                <input type="text" class="form-control loadstatedropdown" name="state" id="pur_add_state" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_state; } ?>"/>
						                    </div>
						                </div>
						            </div>
						            <div class="col-md-3"  >
						                <div class="">
						                    <label class="col-md-4 control-label"  >Country <span class="asterisk_sign">*</span></label>
						                    <div class="col-md-8"  style="padding-right:4px;">
						                    	<input type="hidden" name="country_id" id="pur_add_country_id">
                                                <input type="text" class="form-control loadcountrydropdown" name="country" id="pur_add_country" placeholder="" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_country; } ?>"/>
						                    </div>
						                </div>
						            </div>
						        </div>											
						        
						        <div class="form-group">
						            
						            <div class="row">
						                <div class="">
						                    <label class="col-md-2 control-label" >Google Map Address <span class="asterisk_sign">*</span></label>
						                    <div class="col-md-8">
						                        <input   type="text" id="googlemaplink" class="form-control" name="googlemaplink" placeholder="" onFocus="geolocate()" value="<?php if(isset($p_txn)) { echo $p_txn[0]->p_googlemaplink; } ?>"/>
						                    </div>
						                    <div class="col-md-2">
						                        <a href="https://www.google.co.in/maps" target="_blank" class="btn btn-success">Go to google maps</a>
						                    </div>
						                </div>
						            </div>
						        </div>										
						    
						    </div>				
							 <div style="col-md-12 btn-margin">
							<a href="#accOneColTwo" class=" pull-right" style="margin:10px;"><button type="button" class="btn btn-info  ">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
							</div>
						</div>
					</div>

					<!-- 	Property Details End -->

					<div class="panel panel-primary propdesc" style="display:none;" id="panel-property-description">
						<a href="#accOneColTwo">   
							<div class="panel-heading">
							<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>    Property Description	</h4>
							</div>  
						</a>      

						<div class="panel-body" id="accOneColTwo">
							<div class="form-group" style="border-top: 1px dotted #ddd;">
								<div class="col-md-6" style="display: none;">
									<div class="">
										<label class="col-md-3 control-label">Description</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="pr_description" placeholder="1RK, 1BHK, 2BHK, 3BHK, Others" value="<?php if(isset($p_description)) { if(count($p_description)>0) {echo $p_description[0]->pr_description; }} ?>" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label" style="padding-left:0; padding-right:0;">Agreement Area <span class="asterisk_sign">*</span>
										</label>
										<div class="col-md-6">
											<input type="text" id="agreement_area" class="form-control format_number" name="agreement_area" placeholder="Agreement Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_agreement_area,2); }} ?>" />
										</div>
										<div class="col-md-3">
											<select id="ddlagreementarea" class="form-control" name="agreement_unit">
												<option value="">Select</option>
												<option value="Sq m" <?php if(isset($p_description))  { if(count($p_description)>0) { if($p_description[0]->pr_agreement_unit=="Sq m") { echo "selected"; }}} ?>>Sq m</option>
												<option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_agreement_unit=="Sq ft") { echo "selected"; }}} ?>>Sq ft</option>
												<option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0)  { if($p_description[0]->pr_agreement_unit=="Sq yard") { echo "selected"; }}} ?>>Sq yard</option>
												
											</select>
										</div>
									</div>
								</div>
							</div>
                            
							<div class="form-group">
								<div class="col-md-6 land_area">
										<div class="">
											<label class="col-md-3 control-label">Land Area</label>
											<div class="col-md-6">
												<input type="text" class="form-control format_number" name="land_area" placeholder="Land Area" value="<?php if(isset($p_description)) { if(count($p_description) > 0) { echo format_money($p_description[0]->pr_land_area,2); } }?>" />
											</div>
											<div class="col-md-3">
												<select  class="form-control" name="land_unit">
													<option value="">Select</option>
													<option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
													<option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
													<option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_land_unit=="Sq yard") { echo "selected"; }}} ?>>Sq yard</option>
													
												</select>
											</div>
										</div>
									</div>
								<div class="col-md-6 carpet_area">
									<div class="">
										<label class="col-md-3 control-label">Carpet Area</label>
										<div class="col-md-6">
											<input type="text" class="form-control format_number" name="carpet_area" placeholder="Carpet Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_carpet_area,2); }} ?>"/>
										</div>
										<div class="col-md-3">
											<select  class="form-control" name="carpet_unit">
												<option value="">Select</option>
												<option value="Sq m" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq m") { echo "selected"; } }} ?>>Sq m</option>
												<option value="Sq ft" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
												<option value="Sq yard" <?php if(isset($p_description)) {if(count($p_description)>0) {  if($p_description[0]->pr_carpet_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
												
											</select>
										</div>
									</div>
								</div>
							</div>
                            
							<div class="form-group built_up_saleable_area">
								<div class="col-md-6 built_up_area">
									<div class="">
										<label class="col-md-3 control-label">Built Up Area</label>
										<div class="col-md-6">
											<input type="text" class="form-control format_number" name="built_area" placeholder="Built Up Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_builtup_area,2); }} ?>"/>
										</div>
										<div class="col-md-3">
											<select  class="form-control" name="built_unit">
												<option value="">Select</option>
												<option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
												<option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq ft") { echo "selected"; } } }?>>Sq ft</option>
												<option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_builtup_unit=="Sq yard") { echo "selected"; } } } ?>>Sq yard</option>
												
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6 saleable_area">
									<div class="">
										<label class="col-md-3 control-label">Saleable Area</label>
										<div class="col-md-6">
											<input type="text" class="form-control format_number" name="sell_area" placeholder="Saleable Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_sellable_area,2); } }?>"/>
										</div>
										<div class="col-md-3">
											<select class="form-control" name="sell_unit">
												<option value="">Select</option>
												<option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq m") { echo "selected"; } }} ?>>Sq m</option>
												<option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
												<option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_sellable_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
												
											</select>
										</div>
									</div>
								</div>
							</div>
                            
							<div class="form-group bunglow_building_area">
								<div class="col-md-6 bunglow_area">
									<div class="">
										<label class="col-md-3 control-label">Bunglow Area</label>
										<div class="col-md-6">
											<input type="text" class="form-control format_number" name="bunglow_area" placeholder="Bunglow Area" value="<?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_bunglow_area,2); } }?>"/>
										</div>
										<div class="col-md-3">
											<select class="form-control" name="bunglow_unit">
												<option value="">Select</option>
												<option value="Sq m" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq m") { echo "selected"; } } }?>>Sq m</option>
												<option value="Sq ft" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq ft") { echo "selected"; } }} ?>>Sq ft</option>
												<option value="Sq yard" <?php if(isset($p_description)) { if(count($p_description)>0) { if($p_description[0]->pr_bunglow_unit=="Sq yard") { echo "selected"; }} } ?>>Sq yard</option>
												
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6 building_area">
									<div class="">
										<label class="col-md-3 control-label">No Of Floors</label>
										<div class="col-md-9">
											<input type="text" class="form-control format_number" name="no_of_floors" placeholder="No Of Floors" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_floors,2); }} ?>"/>
										</div>
									</div>
								</div>
							</div>
                            
							<div class="form-group building_area">
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label">No Of Flats</label>
										<div class="col-md-9">
											<input type="text" class="form-control format_number" name="no_of_flats" placeholder="No Of Flats" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_flats,2); }} ?>"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label">No Of Shops</label>
										<div class="col-md-9">
											<input type="text" class="form-control format_number" name="no_of_shops" placeholder="No Of Shops" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_shops,2); }} ?>"/>
										</div>
									</div>
								</div>
							</div>
                            
							<div class="form-group parking_div">
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label" style="padding: 0px;">No Of Open Parking</label>
										<div class="col-md-9">
											<input type="text" class="form-control format_number" name="open_parking" placeholder="Open Parking" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_open_parking,2); }} ?>"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="col-md-3 control-label" style="padding: 0px;">No Of Covered Parking</label>
										<div class="col-md-9">
											<input type="text" class="form-control format_number" name="covered_parking" placeholder="Covered Parking" value="<?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_covered_parking,2); }} ?>"/>
										</div>
									 
									</div>
								</div>
							</div>
                            
							<div class="repeatimg">
								<?php 
									if(isset($p_description_img)) {
										for ($i=0; $i < count($p_description_img) ; $i++) { 
								?>
								<div class="form-group" id="repeat_img_<?php echo ($i+1); ?>">
									<div class="col-md-4">
										<div class="abs" style="margin-left: 28px;">
											<label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Upload Image</label>
											<div class="col-md-8">
												<input type="file" class="fileinput btn-primary" name="propertydoc_<?php echo $i; ?>" />
												<?php if($p_description_img[$i]->file_path!= '') { ?><a target="_blank" href="<?php echo base_url().$p_description_img[$i]->file_path; ?>">Download</a><?php } ?>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="">
											<label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label>
											<div class="col-md-8">
												<input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date" value="<?php echo ($p_description_img[$i]->file_date!=null && $p_description_img[$i]->file_date!='')?date('d/m/Y',strtotime($p_description_img[$i]->file_date)):''; ?>" />
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="">
											<label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label>
											<div class="col-md-9">
												<input type="text" class="form-control" name="capture_description[]" placeholder="Description" value="<?php echo $p_description_img[$i]->file_description; ?>"/>
											</div>
										</div>
									</div>
								</div>
								<?php } } else { ?>
								<div class="form-group" id="repeat_img_1">
									<div class="col-md-4">
										<div class="abs" style="margin-left: 28px;">
											<label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Upload Image</label>
											<div class="col-md-8">
												<input type="file" class="fileinput btn-primary" name="propertydoc_0" />
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="">
											<label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label>
											<div class="col-md-8">
												<input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date"/>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="">
											<label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label>
											<div class="col-md-9">
												<input  type="text" class="form-control" name="capture_description[]" placeholder="Description"/>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div> 
                            
                         

							<div class="">
								<div class="col-md-12 btn-margin">
									<a href="#accOneColThree" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
									<button class="btn btn-success repeat-img"  >+</button>
            						<button type="button" class="btn btn-success reverse-img" style="margin-left: 10px;">-</button>
								</div>
							</div>
						</div>
					</div>
				
					<!-- Property Description End -->

					<div class="panel panel-primary" id="panel-purchase-consideration">
						<a href="#accOneColThree">   
							<div class="panel-heading">
								<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>    Purchase Consideration	</h4>
							</div>  
						</a>      

						<div class="panel-body" id="accOneColThree">
							<!-- <div id="schedule_error"></div> -->
						 	<div id="temp_schedule_div"></div>												
 							<div class="show" id="actual_schedule_div" style="padding:10px;">
								<div class="table-stripped">
									<table id="contacts" class="table table-bordered group addsummary" >
										<thead>
											<tr>
												<th  width="55px">Sr. No.</th>
												<th  >Type</th>
												<th width="120">Total Cost  (In &#x20B9;)</th>

												<?php //print_r($tax_name);
                                                    if(isset($tax_name)){
                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
                                                        $key=0;
                                                        foreach($tax_name as $row){
	                                                        echo '<th style="text-align: center;vertical-align: middle;">'.$row->tax_type.' (In &#x20B9;)</th>';
		                                                    $tax_array[$key]=$row->tax_type;
		                                                    $key++;
	                                                   	} 
	                                                   //echo '</tr></table></th>';
	                                                  // print_r($tax_array);
	                                               	}
                                               	?>

												<th width="120">Net Cost (In &#x20B9;)</th>

											</tr>
										</thead>
										<tbody>
											<?php //print_r($p_schedule);?>
                                            <?php 
                                            $j=0;
                                            $total_basic_cost=0;
                                            $total_net_amount=0;
                                            $total_tax_array=array();
                                            if(isset($p_schedule1)){
                                            foreach($p_schedule1 as $row_tax) {
                                                echo '<tr>
                                                <td style="text-align:left;">'.($j+1).'</td>
                                                <td style="text-align:left;">'.$p_schedule1[$j]["event_type"].'</td>
                                                

                                                
                                                <td>'.format_money($p_schedule1[$j]["basic_cost"],2).'</td>';
                                                //echo count($p_schedule[$j]['tax_type']);
                                               /* if(isset($p_schedule[$j]['tax_type'])){
                                                for($tcnt=0;$tcnt<$key;$tcnt++){
                                                   // print_r($p_schedule[$j]['tax_type']);
                                                    $tax_amount='';
                                                    if(count($p_schedule[$j]['tax_type'])>=($tcnt+1)){

                                                    if($p_schedule[$j]['tax_type'][$tcnt]==$tax_array[$tcnt]){
                                                        $tax_amount=$p_schedule[$j]['tax_amount'][$tcnt];
                                                    }
                                                }
                                                    echo '<td>'.$tax_amount.'</td>';
                                                }
                                                }*/
												//echo $key;
                                                $total_basic_cost=$total_basic_cost+$p_schedule1[$j]["basic_cost"];
                                             	$next_count=0;
                                                $td_count=0;
												if(isset($p_schedule1[$j]['tax_type'])) {
                                               		// for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                    //echo "<br>hi";
                                                  	// echo $key;
                                                    for($tcnt=0;$tcnt<$key;$tcnt++){
                                                        //echo "step1--";
	                                                 	for($nc=0;$nc<count($p_schedule1[$j]['tax_type']);$nc++){
	                                                        $tax_amount='';
	                                                        if($p_schedule1[$j]['tax_type'][$nc]==$tax_array[$tcnt]){
	                                                            $tax_amount=$p_schedule1[$j]['tax_amount'][$nc];
	                                                           	$nc=count($p_schedule1[$j]['tax_type']);
	                                                           	//$tcnt=$key;
                                                       			//}
	                                                        }
	                                                    }
	                                                    if($tax_amount !=''){
	                                                        echo '<td>'.format_money($tax_amount,2).'</td>';
	                                                        $td_count++;
	                                                    } else {
                                                            //if($next_count )
                                                            echo '<td>'.format_money($tax_amount,2).'</td>';
                                                            $td_count++;
                                                        }
                                                       	// $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
                                                  		//  $total_tax_array[$tcnt]= $tax_amount;
                                                   		// print_r($total_tax_array);
                                                	}
                                           		// }
												}
                                                $inserttd=$key-$td_count;
                                                if($inserttd !=0){
                                                    for($tdint=0;$tdint<$inserttd;$tdint++){
                                                        echo "<td></td>";
                                                    }
                                                }
                                                echo'<td>'.format_money($p_schedule1[$j]["net_amount"],2).'</td></tr>';
                                                $total_net_amount=$total_net_amount+$p_schedule1[$j]["net_amount"];
												//print_r($p_schedule[$j]['event_type']);
												$j++;


                                            } ?>

											<tr>
                                                <td colspan="2" style="text-align:left;"><b>Grand Total  (In &#x20B9;) </b></td>
                                                <td><?php echo format_money($total_basic_cost,2);?></td>
                                                <?php  $k=0;if(isset($total_tax_amount)) {
                                                foreach($total_tax_amount as $row){
                                                    echo '<td>'.format_money($total_tax_amount[$k],2).'</td>';
                                                	$k++;
                                               	} } ?>
                                               <td><?php echo format_money($total_net_amount,2); ?></td>
                                            </tr>
                                            <?php } ?>
										</tbody>
									</table>
									<!--<div class="row">
										<button class="btn btn-success repeat-summary" style="margin-left: 10px;">+</button>
									</div>-->
								</div>
							</div>
							<div class="" >
								<div class="col-md-12  btn-margin">
									<a href="#accOneColFive"><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
									<button type="button" class="btn btn-info mb-control" data-box="#message-box-info" onclick="opentable(); return false;">Schedule</button>
								</div>
							</div>
							
						 	<!-- info -->
						 	<div class="message-box message-box-info animated fadeIn" id="message-box-info" style=" " >
								<div class="mb-container" style="background:#fff;    overflow: auto;max-height: 600px;">
									<div class="mb-middle">
										<div class="mb-title" style="color:#000;text-align:center;">Schedule</div>
										<div class="mb-content">
										<div class="form-group" style="border-top: 1px dotted #ddd;">
											<label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
											<input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a>
											<!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
										</div>
										<div class="table-stripped">
											<table id="contacts" class="table group addschedule" style="font-size: 12px; vertical-align:middle;">
												<thead>
													<tr>
														<th style="text-align: center;vertical-align: middle;" width="60">Sr. No.</th>
														<th style="text-align: center;vertical-align: middle;">Type</th>
														<th style="text-align: center;vertical-align: middle;">Event</th>
														<!-- <th style="text-align: center;vertical-align: middle;">Payment Type</th>
														<th style="text-align: center;vertical-align: middle;">Agreement Value</th> -->
														<th style="text-align: center;vertical-align: middle;"  width="120">Date</th>

														<th style="text-align: center;vertical-align: middle;"  width="130">Cost (In &#x20B9;)</th>
														<?php for ($i=0; $i < count($tax) ; $i++) { 
															//echo '<th style="text-align: center;vertical-align: middle;">'.$tax[$i]->tax_name.'</th>';
														}
														?>
														<th style="text-align: center;vertical-align: middle;" width="70">Tax(%)</th>
													</tr>
												</thead>
											<tbody id="schedule_table">
											<?php $i=0; $schedule_id=1;
					 						if(isset($p_schedule)){
						
											foreach($p_schedule as $row){
												$sch_id=$p_schedule[$i]['schedule_id'];
												$event_type=$p_schedule[$i]['event_type'];
												$event_name=$p_schedule[$i]['event_name'];
												$basic_cost=$p_schedule[$i]['basic_cost'];
												$event_date=date('d/m/Y',strtotime($p_schedule[$i]['event_date']));
												$tax_master=array();
												$j=0;
												if(isset($p_schedule[$i]['tax_type'])){
												for($j=0;$j<count($p_schedule[$i]['tax_type']);$j++ ){
													$p_schedule[$i]['tax_id'][$j];
													$tax_master[]=$p_schedule[$i]['tax_master_id'][$j];
												}
											}	?>

											<tr id="repeat_schedule_<?php echo $i+1; ?>">
											<td style="color:#000;background:#F9F9F9; text-align:left; vertical-align:middle;" align="middle"><?php echo $i+1; ?></td>
											<input type="hidden" name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>
											
											<td><input type="text" name="sch_type[]" id="sch_type_<?php echo $i+1; ?>" class="form-control sch_type" value="<?php echo $event_type;?>" style="border:none; text-align:left;"/></td>
											
											<td><input type="text" name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none; text-align:left;"/></td>
											<!-- <td><input type="text" name="sch_pay_type[]" class="form-control" value="<?php //echo $p_schedule[$i]['sch_pay_type'];?>" style="border:none; text-align:left;"/></td>
											<td><input type="radio" name="sch_agree_value[0]" id="sch_agree_yes_1" value="yes" <?php //if(($p_schedule[$i]['sch_agree_value'])=='yes'){echo 'checked';} ?> >Yes &nbsp;&nbsp;<input type="radio" name="sch_agree_value[0]" id="sch_agree_no_1" value="no" <?php //if(($p_schedule[$i]['sch_agree_value'])=='no'){ echo 'checked';}?> >No</td> -->
											<td><input type="text" name="sch_date[]" class="form-control datepicker" value="<?php echo $event_date;?>" style="border:none; text-align:left;"/></td>
											<td><input type="text" name="sch_basiccost[]" class="form-control format_number" value="<?php echo format_money($basic_cost,2);?>" style="border:none; text-align:right;"/></td>
											<td ><select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class=" select" style="display: none;">
											<?php $schedule_id++;
											if(isset($tax_details)){
												//print_r($tax_id);
												foreach($tax_details as $row){
													if(in_array($row->tax_id, $tax_master)){
														//echo "hi";
														$selected="selected='selected'";
													}
													else{
														$selected='';
													}
													echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
												}
											};?></select></td>
											</tr>
											<?php $i++; 
											}	
											} ?>
										 	<?php //if (isset($p_schedule)) {
											// 	for ($i=0; $i < count($p_schedule) ; $i++) { 
											// 		echo "<tr> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>".($i+1)."</td> <td><input   type='text' id='eve' name='sch_event[]' class='form-control' value='".$p_schedule[$i]->event_name."' style='border:none;'/></td> <td><input   type='text' id='txtevent' name='sch_date[]' value='".date('d/m/Y',strtotime($p_schedule[$i]->event_date))."'  class='form-control datepicker' style='border:none;'/></td> <td><input   type='text' id='bs_" . ($i +1). " name='sch_basiccost[]' value='".$p_schedule[$i]->basic_cost."' class='form-control format_number' style='border:none;'/></td>";
											// 		for ($j=0; $j < count($tax) ; $j++) { 
											// 			echo " <td>None<input   type='text' id='tx_".$j."_".$i."' name='sch_tax".$i."[]'  value='".$p_schtxn[$j]->tax_amount."' class='form-control' style='border:none;'/></td>";
											// 		}
											// 		echo "<td><input  type='text' id='net_" .($i+1)."' name='sch_netamount[]'  value='".$p_schedule[$i]->net_amount."' class='form-control' style='border:none;'/></td> </tr>";
											// 	}
											// }
											?>
											</tbody>
											</table>
										</div>
										</div>
															
										<div class="mb-footer">
											<button class="btn btn-success repeat-schedule" id="schedule_btn" style=" ">+</button>
        									<button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
											<button class="btn btn-danger  pull-right mb-control-close" onclick="closetemp(); return false;">Close</button>
											<button type="button" class="btn btn-success   pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id-1;?>">
					</div>
					
					

					<?php $this->load->view('templates/related_party');?>

					<!-- Brokerage Details End -->

					<div class="panel panel-primary" id="panel-documents">
						<a href="#accOneColSix">   
							<div class="panel-heading">
							<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Documents	</h4>
							</div>  
						</a>      

						<div class="panel-body" id="accOneColSix">
							<div id="adddoc">
                                <!-- <?php //if(isset($p_docs)) { 
                                   // for($i=0; $i<count($p_docs); $i++) {?>
		                                <div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
		                                    <div class="col-md-2">
		                                    	<input type="hidden" class="form-control" name="doc_id[]" value="<?php //echo $p_docs[$i]->fk_d_id; ?>" />
		                                        <input type="hidden" class="form-control" id="d_m_status_<?php //echo $i; ?>" value="<?php //echo $p_docs[$i]->d_m_status; ?>" />
		                                        <input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="Document Name" value="<?php //echo $p_docs[$i]->pr_doc_name; ?>" <?php //if($p_docs[$i]->d_m_status=="Yes") echo 'readonly style="color:#0b385f;"'; ?> />
		                                    </div>
		                                    <div class="col-md-2">
		                                        <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php //echo $p_docs[$i]->pr_doc_description; ?>" />
		                                    </div>
		                                    <div class="col-md-2">
		                                        <input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value="<?php //echo $p_docs[$i]->pr_doc_ref_no; ?>"/>
		                                    </div>
		                                    <div class="col-md-2">
		                                        <input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value="<?php //echo ($p_docs[$i]->pr_doc_doi!=null && $p_docs[$i]->pr_doc_doi!='')?date('d/m/Y',strtotime($p_docs[$i]->pr_doc_doi)):''; ?>"/>
		                                    </div>
		                                    <div class="col-md-2">
		                                        <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php //echo ($p_docs[$i]->pr_doc_doe!=null && $p_docs[$i]->pr_doc_doe!='')?date('d/m/Y',strtotime($p_docs[$i]->pr_doc_doe)):''; ?>"/>
		                                    </div>
		                                    <div class="col-md-2">
			                                    <div class="col-md-8">
			                                        <input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
			                                        <div id="doc_<?php //echo $i; ?>_error"></div>
			                                        <?php //if($p_docs[$i]->pr_document!= '') { ?><a target="_blank" id="doc_file_download_<?php //echo $i; ?>" href="<?php //echo base_url().$p_docs[$i]->pr_document; ?>">Download</a><?php //} ?>
			                                    </div>
	                                            <div class="col-md-4">
	                                            	<a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
	                                            </div>
                                            </div>
		                                </div>
                                <?php //}} else { 
                                    //for($i=0; $i<count($docs); $i++) {?>
                                        <div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
                                            <div class="col-md-2">
                                            	<input type="hidden" class="form-control" name="doc_id[]" value="<?php //echo $docs[$i]->d_id; ?>" />
                                            	<input type="hidden" class="form-control" id="d_m_status_<?php //echo $i; ?>" value="<?php //echo $docs[$i]->d_m_status; ?>" />

                                        		<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="" style="width:94% !important; float:left;"  value="<?php //echo $docs[$i]->d_documentname; ?>" <?php //if($docs[$i]->d_m_status=="Yes") echo 'readonly style="color:#0b385f;"'; ?> /> <span  class="asterisk_sign" > * </span> 

                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php //echo $docs[$i]->d_description; ?>" />
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
                                            </div>

		                                    <div class="col-md-2">
	                                            <div class="col-md-8">
	                                                <input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/><span  class="asterisk_sign" > * </span> 
	                                        		<div id="doc_<?php //echo $i; ?>_error"></div>
	                                            </div>
	                                            <div class="col-md-4">
	                                            	<a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
	                                            </div>
                                            </div>
                                        </div>
                                <?php //}} ?> -->

							<?php $this->load->view('templates/document');?>

							</div>

							<div class="">
								<div class="btn-margin">
								 	<!-- <button class="btn btn-success repeat-doc" style="margin-left: 10px;" name="addkycbtn">+</button> -->

								 	<button type="button" class="btn btn-success" id="repeat-documents">+</button>
                                    <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->

							 	</div>
							</div>

						 
						
						</div>
					</div>

					<?php $this->load->view('templates/pending_activity');?>

					<div class="panel panel-primary" id="nominee-section" style="display:block;">
                        <a href="#accOneColfour"> 
                            <div class="panel-heading">
                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                            </div>
                        </a>                                 
                        <div class="panel-body" id="accOneColfour">
						    <div class="remark-container1"  >
                                <div class="form-group" style="background: none;border:none">
                                <div class=" ">
                                    <div class="col-md-12">
                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($p_txn)){ echo $p_txn[0]->maker_remark;}?></textarea>
                                        <!-- <label style="margin-top: 5px;">Remark </label> -->
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
													
													</div>
				         </div>
    			      
 <br clear="all"/>
					  </div>
													<div class="panel-footer">
														<input type="hidden" id="submitVal" value="1" />
														<a href="<?php echo base_url(); ?>index.php/purchase" class="btn btn-danger" >Cancel</a>
														<input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
														<input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
													
	            	</div>
								

								</form>

				                <!-- start contact popup -->
                             
                                 <!-- end contact popup -->
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNy33uOQrIGSIdqfn_4MzP0AKOy2DR1o4&libraries=places&callback=initAutocomplete" async defer></script>

        
		<script>
			// This example displays an address form, using the autocomplete feature
			// of the Google Places API to help users fill in the information.

			// This example requires the Places library. Include the libraries=places
			// parameter when you first load the API. For example:
			// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      		var placeSearch, autocomplete;
			var componentForm = {
				street_number: 'short_name',
				route: 'long_name',
				locality: 'long_name',
				administrative_area_level_1: 'short_name',
				country: 'long_name',
				postal_code: 'short_name'
			};

      		function initAutocomplete() {
		        // Create the autocomplete object, restricting the search to geographical
		        // location types.
        		autocomplete = new google.maps.places.Autocomplete(
            	/** @type {!HTMLInputElement} */(document.getElementById('googlemaplink')),
            	{types: ['geocode']});
		        // When the user selects an address from the dropdown, populate the address
		        // fields in the form.
		        //autocomplete.addListener('place_changed', fillInAddress);
			}

	        // Get each component of the address from the place details
	        // and fill the corresponding field on the form.

			// Bias the autocomplete object to the user's geographical location,
			// as supplied by the browser's 'navigator.geolocation' object.
      		function geolocate() {
		        if (navigator.geolocation) {
		          navigator.geolocation.getCurrentPosition(function(position) {
		            var geolocation = {
		              lat: position.coords.latitude,
		              lng: position.coords.longitude
		            };
		            var circle = new google.maps.Circle({
		              center: geolocation,
		              radius: position.coords.accuracy
		            });
		            autocomplete.setBounds(circle.getBounds());
		          });
		        }
	      	}
    	</script>
	   

		<script type="text/javascript">
            function loadinittable(){
            	var area=document.getElementById("agreement_area").value;
            	document.getElementById("area_1").value = area;
            	document.getElementById("area_2").value = area;
            	document.getElementById("area_3").value = area;
            }

            function totcost(arg) {
            	var bsid = arg.getAttribute('id');
				var rate=parseInt(document.getElementById(bsid).value);
				
				var tyu='';
				for (var i = 5; i < bsid.length; i++) {
					tyu=tyu+bsid.charAt(i);
				};
				var obtid='area_'+tyu;
				var area = parseInt(document.getElementById(obtid).value);
				var cost = rate * area;
				document.getElementById('total_' + tyu).value = cost;
            }
        </script>

		<script type="text/javascript">
			var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
			var tax = new Array();
			var taxname=new Array();
			var taxpurpose=new Array();
			window.cntrinst=0;
			
			<?php for ($i=0; $i < count($tax) ; $i++) { ?>
				tax.push('<?php echo $tax[$i]->tax_percent; ?>');
				taxname.push('<?php echo $tax[$i]->tax_name; ?>');
				taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
			<?php }	?>

			function opentable(){
				if(flag==false) {
					document.getElementById('message-box-info').style.display = "block";
					// var installments=document.getElementById('installments').value;
					// var purchase=document.getElementById('purchase').value;
					// var downpymnt=document.getElementById('downpymnt').value;
					// var amt1=purchase - downpymnt;
					
					// var amt2=Math.round(amt1/installments);
					// rows='';
					// if(installments!=''){
					// 	window.cntrinst=(parseInt(installments)-1);
					// }
					// for (var i = 0; i < installments; i++) {
					// 	var ntamt=amt2;						
					// 	rows=rows+ "<tr> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ (i+1) +"</td> <td><input type='text' id='txttype' name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text' id='txtpaytype' name='sch_pay_type[]' class='form-control' value='' style='border:none;'/></td><td><input type='radio'name='sch_agree_value[]'id='sch_agree_yes_"+i+"' value='yes'>Yes &nbsp;&nbsp;<input type='radio'name='sch_agree_value[]'id='sch_agree_no_"+i+"' value='no'>No</td><td><input type='text' id='txtevent' name='sch_date[]' value=''  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' id='bs_"+i+"' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='" + amt2 + "' class='form-control format_number' style='border:none; text-align:right;'/></td>";
					// 		for (var j = 0; j < taxname.length; j++) {
					// 			if(taxpurpose[j]=='Add') {
					// 				var staxamt=Math.round(amt2*tax[j]/100);
					// 				ntamt=ntamt+staxamt;
					// 				rows=rows+"<td><input type='text' id='tx_"+j+"_"+i+"' name='sch_tax"+ i + "[]'  value='" + staxamt + "' class='form-control' style='border:none;'/></td>";
					// 			} else {
					// 				var staxamt=Math.round(amt2*tax[j]/100);
					// 				ntamt=ntamt-staxamt;
					// 				rows=rows+"<td><input type='text' id='tx_"+j+"_"+i+"' name='sch_tax"+ i + "[]'  value='" + staxamt + "' class='form-control' style='border:none;'/></td>";
					// 			}
					// 		};
					// 	 rows=rows+ "<td><input type='text' id='ntat_"+i+"' name='sch_netamount[]'  value='" + ntamt + "' class='form-control' style='border:none;'/></td> </tr>";
					// 	 ntamt=0;
					// }
					// document.getElementById('schedule_table').innerHTML=rows;
					// document.getElementById('sch_bal').value=0;
					flag=true;
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
				} else {
					document.getElementById('message-box-info').style.display = "block";
				}
			}

			function calculatetaxes(arg){
				var bsid = arg.getAttribute('id');
				var bsicamt = parseInt(document.getElementById(bsid).value.replace(',',''));
				
				var tyu='';
				for (var i = 3; i < bsid.length; i++) {
					tyu=tyu+bsid.charAt(i);
				};
				
				var nwamt=0;
				var netamt=0;
				for (var i = 0; i < tax.length; i++) {
					var tx=tax[i];
					var oper=taxpurpose[i];
					if(oper=="Add") {
						nwamt=Math.round(bsicamt*tx/100);
						netamt=netamt + nwamt;
					} else if (oper=="Subtract") {
						nwamt=Math.round(bsicamt*tx/100);
						netamt = netamt - nwamt;
					}
					var tempid = 'tx_'+i+'_'+tyu;
					document.getElementById(tempid).value=nwamt;
				};
				//document.getElementById('bs_'+tyu).value=bsicamt;
				document.getElementById('ntat_'+tyu).value=netamt;
				if(document.getElementById('purchase').value!=''){
					var cstprc=parseInt(document.getElementById('purchase').value);	
				} else {
					var cstprc=0;
				}
				
				var newcst=0;
				if(document.getElementById('downpymnt').value!=''){
					var dwnpymt=parseInt(document.getElementById('downpymnt').value);	
				} else {
					var dwnpymt=0;	
				}
				
				var inst=document.getElementById('installments').value;


				for (var i = 0; i <= window.cntrinst; i++) {
					var bsc = parseInt(document.getElementById('bs_'+i).value);
					newcst=newcst + bsc;
				};
				var bal = newcst + dwnpymt;
				bal = cstprc - bal;
				document.getElementById('sch_bal').value=bal;
			}

			
			function savetemp() {
				removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
			    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
			    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
			    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');

			    addMultiInputNamingRules('#form_purchase', 'input[name="sch_type[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_purchase', 'input[name="sch_event[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_purchase', 'input[name="sch_date[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_purchase', 'input[name="sch_basiccost[]"]', { required: true }, "");

			    var valid = true;

			    if (!$("#form_purchase").valid()) {
			    	$("#schedule_table").find('.error').each(function(index) {
			    		if($(this).is(":visible")){
			    			valid = false;
			    		}
			    	});
			    }

			    if (valid==true) {
					removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
				    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
				    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
				    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');

			    	var formdata = {};
					var formdata={
						sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
						sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
						sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
						sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get(),
						// sch_pay_type:$('input[name="sch_pay_type[]"]').map(function(){return $(this).val();}).get(),
						// sch_agree_value:$('input[name="sch_agree_value[]"]').map(function(){return $(this).val();}).get()

					}

					var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
					console.log(sch_type.length);
					var j=1;
					for(var i=0;i<sch_type.length;++i){
						//console.log("step1");
						formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
						j++;
					}
					//console.log(formdata);
					$.ajax({
						url:"<?php echo base_url().'index.php/sale/insertTempSchedule';?>",
						data:formdata,
						dataType:"json",
						type:"POST",
						success:function(responsemydata){
							if(responsemydata.status==1){
								$("#temp_schedule_div").html(responsemydata.data);
							}
							//alert(responsemydata.data);
						},
					});
				
					//var bl=parseInt(document.getElementById('sch_bal').value);
					/*if(bl!=0) {
						alert("Balance should be 0. Kindly check the same.")
					} else {*/
						document.getElementById('message-box-info').style.display = "none";
						$("#actual_schedule_div").removeClass('show').addClass('hide');
					//}
			    }
			}

			function closetemp() {
				document.getElementById('message-box-info').style.display = "none";
				flag=false;
			}

			function instchange(){
				flag=false;
			}
		</script>
		<script>
			jQuery(function(){
				$('.sch').click(function(event){
					event.preventDefault();
					//alert('hi');
				});
			});

			jQuery(function(){
				var counter = parseInt(<?php if(isset($p_ownership)) { echo count($p_ownership)+1; } else { echo '2'; } ?>);
				$('.repeat-owner').click(function(event){
					event.preventDefault();

					var newRow = jQuery('<div class="form-group" id="repeat_owner_'+counter+'"> <div class="col-md-6"> <div class=""> <label class="col-md-3 control-label">Owner Name <span class="asterisk_sign">*</span></label> <div class="col-md-9"> <input type="hidden" id="owner_name_'+counter+'_id" name="clientname[]" class="form-control" /> <input type="text" id="owner_name_'+counter+'" name="owner_contact_name[]" class="form-control auto_owner ownership" placeholder="Type to choose owner from database..." /> </div> </div> </div> <div class="col-md-6" style=""> <div class=""> <label class="col-md-3 control-label" >% of Ownership <span class="asterisk_sign">*</span></label> <div class="col-md-9"> 	 <label  style="padding:10px 5px;"  > % </label> <input type="text" class="form-control format_number" id="owner_percent_'+counter+'" name="ownership[]" placeholder="% of Ownership" style="width:90%; float:left;"/> </div> </div> </div> <div class="col-md-4" style="display: none;"> <div class=""> <label class="col-md-5 control-label">Allocated Cost</label> <div class="col-md-7">  <input type="text" class="form-control format_number" name="allocatedcost[]" placeholder="Allocated Cost of Property" /> </div> </div> </div> </div>');

					$('.auto_owner', newRow).autocomplete(autocomp_opt_owner);
					$('.repeatowner').append(newRow);
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
					$('.format_number').keyup(function(){
				        format_number(this);
				    });
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
					counter++;
				});
			    $('.reverse-owner').click(function(event){
					///alert('hi');
			    	if((counter-1)!=1){
				        var id="#repeat_owner_"+(counter-1).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});
			
			jQuery(function(){
				var counter = parseInt(<?php if(isset($p_description_img)) { echo count($p_description_img)+1; } else { echo '2'; } ?>);
				$('.repeat-img').click(function(event){
					event.preventDefault();
					// var newRow = jQuery('<div class="form-group"><div class="col-md-6"><div class="" style=""><label class="col-md-3 control-label">Upload Image</label><div class="col-md-9"> <a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary" name="propertydoc_' + counter + '" style="left: -157.313px; top: -3px;"></a> </div> </div> </div> <div class="col-md-6"> <div class=""> <label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label> <div class="col-md-9"> <input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date"/> </div> </div> </div> <div class="col-md-4" style="display:none;"> <div class=""> <label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label> <div class="col-md-9"> <input type="text" class="form-control" name="capture_description[]" placeholder="Description"/> </div> </div> </div></div>');
					var newRow = jQuery('<div class="form-group" id="repeat_img_'+counter+'"><div class="col-md-4"><div class="abs" style="margin-left: 28px;"><label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Upload Image</label><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary" name="propertydoc_' + (counter-1) + '" style="left: -157.313px; top: -3px;"/></a></div></div></div><div class="col-md-4"><div class=""><label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label><div class="col-md-8"><input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date"/></div></div></div><div class="col-md-4"><div class=""><label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label><div class="col-md-9"><input  type="text" class="form-control" name="capture_description[]" placeholder="Description"/></div></div></div></div>');
					$('.repeatimg').append(newRow);
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
					counter++;
				});
			    $('.reverse-img').click(function(event){
			    	if((counter-1)!=1){
				        var id="#repeat_img_"+(counter-1).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});

			// jQuery(function(){
   //          	var counter = $('input.doc_file').length;
			// 	// var counter = <?php if(isset($p_docs)) { echo count($p_docs); } else { ?>$("input.doc_file").length<?php } ?>;
			// 	$('.repeat-doc').click(function(event){
			// 		event.preventDefault();
			// 		var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><input type="hidden" class="form-control" name="doc_id[]" value="" /><input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" /><input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+ counter + '" placeholder="Document Name" value="" /></div><div class="col-md-2"><input type="text" class="form-control" name="doc_desc[]" placeholder="Description"  value="" /></div><div class="col-md-2"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" /></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');
			// 		$('#adddoc').append(newRow);
			// 		$('.datepicker').datepicker();
	  //               $('.delete_row').click(function(event){
	  //                   delete_row($(this));
	  //               });
			//         $("form :input").change(function() {
		 //                $(".save-form").prop("disabled",false);
		 //            });
			// 		counter++;
			// 	});
			// });
			
			jQuery(function(){
				var counter = 7;
				var tst=1;
				$('.repeat-summary').click(function(event){
					event.preventDefault();
					//alert(window.cntrinst);
					var ctr=window.cntrinst;
					//alert(ctr);
					//counter = counter+ctr;
					window.cntrinst=counter;
					tst=counter+1;
					var newRow = jQuery('<tr id="repeat_summary_'+counter+'"><td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" name="cost_head[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txtarea[]" id="area_' + counter + '" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txtrate[]" id="rate_' + counter + '" onkeyup="totcost(this);" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttotalcost[]" id="total_' + counter + '" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="inst_'+ counter + '" name="txtnoofinstallment[]" class="form-control" style="border:none;background:none;"/></td> </tr>');
					$('.addsummary').append(newRow);
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
					counter++;
				});
			    $('.reverse-summary').click(function(event){
			    	if((counter-1)!=1){
				        var id="#repeat_summary_"+(counter-1).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});
			
			jQuery(function(){
				var counter = 5;
				var tst=1;
				$('.repeat-tax').click(function(event){
					event.preventDefault();
					//alert(window.cntrinst);
					var ctr=window.cntrinst;
					//alert(ctr);
					//counter = counter+ctr;
					window.cntrinst=counter;
					tst=counter+1;
					var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" name="txttaxcosthead[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxrateinpercent[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxtotalcost[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxnoofinstallment[]" class="form-control" style="border:none;background:none;"/></td> </tr>');
					$('.addtax').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
					counter++;
					
				});
			});
			
			jQuery(function(){
				var counter = 1;
				var tst=1;
				$('.repeat-schedule').click(function(event){
					event.preventDefault();
					//alert(window.cntrinst);
					scheduleRepeat(counter,tst);
				});
			    $('.reverse-schedule').click(function(event){
			        scheduleReverse(counter,tst);
			    });
			});

			function scheduleRepeat(counter,tst){
				var ctr=window.cntrinst;
				//alert(ctr);
				var counter = tst;
				if(ctr == 0){
				var tst=parseInt($("#schedule_id").val())+1;						
				}
				else{
					//alert(ctr);
					tst=parseInt(ctr)+parseInt(1);
				}
				// var newRow = jQuery('<tr><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text" id="txttype" name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text" id="txtevent" name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text" id="bs_'+counter+'"  onkeyup="calculatetaxes(this);""  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none;"/></td><?php for ($j=0; $j < count($tax) ; $j++) { $txa="tx_".$j; echo "<td><input type=\"text\" id=\"tx_".$j."_'+counter+'\" name=\"sch_tax".$j."[]\"  value=\"\" class=\"form-control\" style=\"border:none;\"/></td>";} ?><td><input type="text" id="ntat_'+counter+'" name="sch_netamount[]"  value="" class="form-control" style="border:none;"/></td> </tr>');
				// var newRow= jQuery('<tr><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control sch_type" value="" style="border:none;"/></td>	<td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text" id="txtpaytype" name="sch_pay_type[]" class="form-control" value="" style="border:none;"/></td><td><input type="radio"name="sch_agree_value['+tst+']"id="sch_agree_yes_'+tst+'" value="yes" /><font style="color:#000;">Yes</font> &nbsp;&nbsp;<input type="radio" name="sch_agree_value['+tst+']" id="sch_agree_no_'+tst+'" value="no" /><font style="color:#000;">No</font></td><td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align:right;"/></td><td><select name="sch_tax_'+tst+'[]" multiple class="form-control select" style="display: none;"><?php if(isset($tax_details)){foreach($tax_details as $row){echo "<option value=".$row->tax_id.">".$row->tax_name."-".$row->tax_percent."</option>";}}?><select></td></tr>');
				var newRow= jQuery('<tr id="repeat_schedule_'+tst+'"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control sch_type" value="" style="border:none;"/></td>	<td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align:right;"/></td><td><select name="sch_tax_'+tst+'[]" multiple class="select" style="display: none;"><?php if(isset($tax_details)){foreach($tax_details as $row){echo "<option value=".$row->tax_id.">".$row->tax_name."-".$row->tax_percent."</option>";}}?><select></td></tr>');
				$('.addschedule').append(newRow);
				$('.select').selectpicker();
				//counter++;
				//tst++;
				window.cntrinst=tst;

				$('.datepicker').datepicker({changeMonth: true,changeYear: true,yearRange:'-100:+100'});
				$('.format_number').keyup(function(){
			        format_number(this);
			    });
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
			}

			function scheduleReverse(counter,tst){
		    	var ctr=window.cntrinst;
				var counter = tst;
				if(ctr == 0){
				var tst=$("#schedule_id").val();						
				}
				else{
					//alert(ctr);
					tst=parseInt(ctr);
				}
		        var id="#repeat_schedule_"+(tst).toString();
		        if($(id).length>0){
		            $(id).remove();
		            tst--;
		            window.cntrinst=tst;
		            $("#schedule_id").val(tst);
		        }
			}

			$(document).ready(function(){
				$('.p_status').show();

				if($('#ptype option:selected').val()=="Land - Agriculture" || $('#ptype option:selected').val()=="Land - Non Agriculture" || $('#ptype option:selected').val()=="Bunglow") {
					$('.aptname').hide();
				} else {
					$('.aptname').show();
				}

				if($('#ptype option:selected').val()=="Building") {
					$('.buldname').show();
					$('.aptdesc').hide();
				}

				if($('#ptype option:selected').val()=="Apartment" || $('#ptype option:selected').val()=="Commercial" || $('#ptype option:selected').val()=="Retail" || $('#ptype option:selected').val()=="Industrial") {
					$('.land_area').hide();
					$('.bunglow_building_area').hide();
					$('.bunglow_area').hide();
					$('.building_area').hide();
					$('.carpet_area').show();
					$('.built_up_saleable_area').show();
					$('.built_up_area').show();
					$('.saleable_area').show();
					$('.parking_div').show();
				} else if($('#ptype option:selected').val()=="Building") {
					$('.land_area').hide();
					$('.bunglow_building_area').show();
					$('.bunglow_area').hide();
					$('.building_area').show();
					$('.carpet_area').show();
					$('.built_up_saleable_area').show();
					$('.built_up_area').show();
					$('.saleable_area').show();
					$('.parking_div').show();
				} else if($('#ptype option:selected').val()=="Bunglow") {
					$('.land_area').hide();
					$('.bunglow_building_area').show();
					$('.bunglow_area').show();
					$('.building_area').hide();
					$('.carpet_area').show();
					$('.built_up_saleable_area').show();
					$('.built_up_area').show();
					$('.saleable_area').show();
					$('.parking_div').show();
				} else if($('#ptype option:selected').val()=="Land-Agriculture" || $('#ptype option:selected').val()=="Land-NonAgriculture") {
					$('.land_area').show();
					$('.bunglow_building_area').hide();
					$('.bunglow_area').hide();
					$('.building_area').hide();
					$('.carpet_area').hide();
					$('.built_up_saleable_area').hide();
					$('.built_up_area').hide();
					$('.saleable_area').hide();
					$('.parking_div').hide();
					$('.p_status').hide();
					$('#property_status').val('');
				}
				
				if($('#ptype option:selected').val()=="Select") {
					$('.propaddr').hide();
					$('.propdesc').hide();
				} else {
					$('.propaddr').show();
					$('.propdesc').show();
				}

				$('#ptype').change(function(){
					$('.p_status').show();

					if(this.value=="Land-Agriculture" || this.value=="Land-NonAgriculture" || this.value=="Bunglow") {
						$('.aptname').hide();
					} else {
						$('.aptname').show();
						$('.aptdesc').show();
					}

					if(this.value=="Building") {
						$('.buldname').show();
						$('.aptdesc').hide();
					}

					if(this.value=="Apartment" || this.value=="Commercial" || this.value=="Retail" || this.value=="Industrial") {
						$('.land_area').hide();
						$('.bunglow_building_area').hide();
						$('.bunglow_area').hide();
						$('.building_area').hide();
						$('.carpet_area').show();
						$('.built_up_saleable_area').show();
						$('.built_up_area').show();
						$('.saleable_area').show();
						$('.parking_div').show();
					} else if(this.value=="Building") {
						$('.land_area').hide();
						$('.bunglow_building_area').show();
						$('.bunglow_area').hide();
						$('.building_area').show();
						$('.carpet_area').show();
						$('.built_up_saleable_area').show();
						$('.built_up_area').show();
						$('.saleable_area').show();
						$('.parking_div').show();
					} else if(this.value=="Bunglow") {
						$('.land_area').hide();
						$('.bunglow_building_area').show();
						$('.bunglow_area').show();
						$('.building_area').hide();
						$('.carpet_area').show();
						$('.built_up_saleable_area').show();
						$('.built_up_area').show();
						$('.saleable_area').show();
						$('.parking_div').show();
					} else if(this.value=="Land-Agriculture" || this.value=="Land-NonAgriculture") {
						$('.land_area').show();
						$('.bunglow_building_area').hide();
						$('.bunglow_area').hide();
						$('.building_area').hide();
						$('.carpet_area').hide();
						$('.built_up_saleable_area').hide();
						$('.built_up_area').hide();
						$('.saleable_area').hide();
						$('.parking_div').hide();
						$('.p_status').hide();
						$('#property_status').val('');
					}
					
					if(this.value=="Select") {
						$('.propaddr').hide();
						$('.propdesc').hide();
					} else {
						$('.propaddr').show();
						$('.propdesc').show();
					}

					<?php if(isset($p_txn)) {  } else {  ?>
					var counter = 0;
			        $.ajax({
			            url: "<?php echo base_url() . 'index.php/Purchase/loadpurchasedocuments/' ?>" + this.value,
			            data: $("#form_purchase").serialize(),
			            cache: false,
			            type: "POST",
			            dataType: 'json',
			            global: false,
			            async: false,
			            success: function (data) {
							if(data.status==1){
								$('#adddoc').html("");
								$('#adddoc').html(data.data);
								$(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
								$('.datepicker').datepicker({changeMonth: true,changeYear: true});
				                $('.delete_row').click(function(event){
				                    delete_row($(this));
				                });
						        $("form :input").change(function() {
					                $(".save-form").prop("disabled",false);
					            });
							}
			            },
			            error: function (xhr, status, error) {
			                    //alert(xhr.responseText);
			            }
			        });
					<?php } ?>

					addMultiInputNamingRules('#form_purchase', 'input[name="owner_contact_name[]"]', { required: function(element) {
				                                                                                                if($("#submitVal").val()=="0"){
				                                                                                                    return true;
				                                                                                                } else {
				                                                                                                    return false;
				                                                                                                }
				                                                                                            }
				                                                                                }, "");
				    addMultiInputNamingRules('#form_purchase', 'input[name="ownership[]"]', { required: function(element) {
				                                                                                            if($("#submitVal").val()=="0"){
				                                                                                                return true;
				                                                                                            } else {
				                                                                                                return false;
				                                                                                            }
				                                                                                        }
				                                                                                }, "");
				    addMultiInputNamingRules('#form_purchase', 'input[name="sch_type[]"]', { required: true }, "");
				    addMultiInputNamingRules('#form_purchase', 'input[name="sch_event[]"]', { required: true }, "");
				    addMultiInputNamingRules('#form_purchase', 'input[name="sch_date[]"]', { required: true }, "");
				    addMultiInputNamingRules('#form_purchase', 'input[name="sch_basiccost[]"]', { required: true }, "");
				    addMultiInputNamingRules('#form_purchase', '.doc_name', { required:function(element) {
				                                                                        if($("#submitVal").val()=="0"){
				                                                                            return true;
				                                                                        } else {
				                                                                            return false;
				                                                                        }
				                                                                    }
				                                                                }, "Document");

				});
				
				$('#ddlagreementarea').change(function(){
					//alert(this.value);
					$('#a_unit_1').text(this.value);
					$('#a_unit_2').text(this.value);
					$('#a_unit_3').text(this.value);
				});
			});

			function saveTempBulkUpload() {
				var input = ($("#schedule_upload"))[0];
				var upload_txn_type = 'purchase';
		        file = input.files[0];
		        if(file != undefined){
		            formData= new FormData();            
                    formData.append("data_file", file);
                    formData.append("upload_txn_type",upload_txn_type);
                    $.ajax({
                        url: "<?php echo base_url() . 'index.php/purchase/saveTempBulkUpload' ?>",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(data){
                        	if(data.status==0){
                        		alert(data.errormsg);
                        	} else {
                        		var counter=data.rowcounter;
                        		var tst=data.rowcounter;
                        		window.cntrinst=tst-1;
                        		$("#schedule_id").val(tst-1);
                        		$("#message-box-info").html(data.data);
                        		$('.select').selectpicker();
                        		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
                        		$('#schedule_upload').bootstrapFileInput();
                        		//$('.repeat-schedule').trigger('click');
								$('.repeat-schedule').click(function(event){
									event.preventDefault();
									//alert(window.cntrinst);
									scheduleRepeat(counter,tst);
									
								});
								$('.reverse-schedule').click(function(event){
									event.preventDefault();
									//alert(window.cntrinst);
									scheduleReverse(counter,tst);
									
								});
							    $('.sch_basiccost').each(function(){
							    	format_number(this);
							    });
								$('.format_number').keyup(function(){
							        format_number(this);
							    });
						        $("form :input").change(function() {
						            $(".save-form").prop("disabled",false);
						        });
                        	}
                     	}
                    });
		        } else {
		            $("#file_photo_error").html('Input something!');
		        }
			}
		</script>

		<script>
			jQuery(function(){
			    var counter = <?php if(isset($related_party)) { echo count($related_party); } else { echo '1'; } ?>;
			    $('.repeat-related_party').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<div class="form-group" id="related_party_'+counter+'" '+((counter==1)?'style="border-top: 1px dotted #ddd;"':'')+'>'+
				                            '<div class="col-md-4">'+
				                                '<label class="col-md-3 control-label">Type</label>'+
				                                '<div class="col-md-9">'+
				                                    '<select name="related_party_type[]" class="form-control rp_type" id="rp_type_'+counter+'">'+
				                                        '<option value="">Select</option>'+
				                                        '<?php for ($k=0; $k < count($contact_type) ; $k++) { ?>'+
				                                            '<option value="<?php echo $contact_type[$k]->id; ?>"><?php echo $contact_type[$k]->contact_type; ?></option>'+
				                                        '<?php } ?>'+
				                                    '</select>'+
				                                '</div>'+
				                            '</div>'+
				                            '<div class="col-md-4">'+
				                                '<label class="col-md-3 control-label">Name</label>'+
				                                '<div class="col-md-9">'+
				                                    '<input type="hidden" id="rp_'+counter+'_id" name="related_party[]" class="form-control" value="" />'+
				                                    '<input type="text" id="rp_'+counter+'" name="related_party_name[]" data-error="#rp_error_'+counter+'" class="form-control auto_client_by_type" value="" placeholder="Type to choose contact from database..." />'+
				                                    '<div id="rp_error_'+counter+'"></div>'+
				                                '</div>'+
				                            '</div>'+
				                            '<div class="col-md-4">'+
				                                '<label class="col-md-3 control-label" style="padding-left: 0px;">Remarks</label>'+
				                                '<div class="col-md-9">'+
				                                    '<input type="text" class="form-control" name="related_party_remarks[]" placeholder="Remarks" value="" />'+
				                                '</div>'+
				                            '</div>'+
				                        '</div>');
			    	$('.auto_client_by_type', newRow).autocomplete(auto_client_by_type_opt);
			        $('#related_party').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
			    });
			    $('.reverse-related_party').click(function(event){
			    	if(counter!=1){
				        var id="#related_party_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
				    }
			    });
			});

			$('.rp_type').change(function(){
				var id = this.id;
				var cnt = id.substr(id.lastIndexOf("_")+1);
				$("#rp_" + cnt.toString() + "_id").val("");
				$("#rp_" + cnt.toString()).val("");
			});

			jQuery(function(){
			    var counter = <?php if(isset($pending_activity)) { echo count($pending_activity); } else { echo '1'; } ?>;
			    $('.repeat-pending_activity').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" '+((counter==1)?'style="border-top: 1px dotted #ddd;"':'')+'><div class="col-md-1 col-sm-1 col-xs-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div><div class="col-md-11 col-sm-11 col-xs-11" style="    padding-right: 14px;"><input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
			        $('#pending_activity').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
			    });
			    $('.reverse-pending_activity').click(function(event){
			    	if(counter!=1){
				        var id="#pending_activity_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
				    }
			    });
			});
		</script>
    </body>
</html>