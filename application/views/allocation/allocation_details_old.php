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
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{
                display: block;
    			float: left;
    			width: 100%;
    			margin-top: 10px;
    			margin-bottom: 10px;
    			border-color: #BDBDBD;
            }
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
		 

		</style>
<style type="text/css">
 
.panel-footer { padding:10px;}
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;} 
 textarea.form-control { overflow:hidden; min-height:80px;}
 .Documents-section .col-md-3, .col-md-4, .col-md-6, col-md-9{ padding:0 3px!important;}
 .pending-group {    padding-right: 15px!important;}
 
 #panel-pending-activity{ margin-top:5px;} 
        </style>	
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

                <?php $this->load->view('templates/menus');?>                    
                    <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Allocation'; ?>" > Sub Property List</a>  &nbsp; &#10095; &nbsp; Sub Property Details </div>
                <!-- PAGE CONTENT WRAPPER -->
				
                      <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	 <div class="main-container">           
                           <div class="box-shadow"> 						    
                            <form id="form_sub_property" role="form" class="form-horizontal" method="post" action="<?php if(isset($sub_property)){ echo base_url().'index.php/Allocation/updaterecord/'.$p_id.'/'.$sub_property[0]->txn_status;} else {echo base_url().'index.php/Allocation/saverecord';} ?>">
                                 <div class="box-shadow-inside custom-padding">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="  panel-default">
                                                
                                <div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>

                                <div class="panel-body faq">
                                <div class="panel-body panel-group accordion">
                                <div class="panel  panel-primary" id="panel-sub-property-details">
                                    <a href="#accOneColOne">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>  Sub Property Details </h4>
                                        </div>   
                                    </a>  
                                    <div class="panel-body panel-body-open text1 full-width" id="accOneColOne" style="width:100%; ">
                                        <div class="form-group"  >
                                             <div class="col-md-12">
                                                <div class="">
                                                    <label class="col-md-2 control-label">Select Property <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-5">
                                                        <select class="form-control Select-Property" name="property">
                                                            <option value="">Select Property </option>
                                                            <?php for ($i=0; $i < count($property) ; $i++) { ?>
                                                                <option value="<?php echo $property[$i]->txn_id; ?>" <?php if(isset($sub_property)) { if($sub_property[0]->property_id==$property[$i]->txn_id) { echo "selected"; } } ?>><?php echo $property[$i]->p_property_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                   

                                        <div class="mb-container" style="background:#fff; padding:10px;">
                                            <div class="mb-middle">
                                                <div class="mb-content">
                                                    <div class="sub-property-grid">
                                                    <div class="table-stripped" style="border-top:1px solid #ddd;">
                                                        <table class="table group addschedule">
                                                        <thead>
                                                            <tr>
                                                            <th style="text-align: center;vertical-align: middle;">Sr.No.</th>
                                                            <th style="text-align: center;vertical-align: middle;" width="140">Sub Property Name <span class="asterisk_sign">*</span></th>
                                                            <th style="text-align: center;vertical-align: middle;" width="145">Sub Property Type <span class="asterisk_sign">*</span></th>
                                                            <th style="text-align: center;vertical-align: middle;">Carpet Area</th>
                                                            <th style="text-align: center;vertical-align: middle;">Built Up Area</th>
                                                            <th style="text-align: center;vertical-align: middle;">Saleable Area</th>
                                                 <th style="text-align: center;vertical-align: middle;">Allocated Cost (In &#x20B9;)</th>
                                                            <th style="text-align: center;vertical-align: middle;">Allocated Maintenance (In &#x20B9;)</th>
                                                            <th style="text-align: center;vertical-align: middle;">Allocated Expenses (In &#x20B9;)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sub_property_table">
                                                        <?php if(isset($sub_property)) { for ($i=0; $i < count($sub_property) ; $i++) { ?>
                                                        <tr>
                                                        <td style="color:#000; vertical-align: middle;" align="middle"><?php echo $i+1;?></td>
                                                        <td>
                                                            <input type="hidden" name="sub_property_id[]" class="form-control" value="<?php echo $sub_property[$i]->txn_id; ?>">
                                                            <input type="text" name="sub_property[]" class="form-control" style="border:none;background:none; width:128px;" value="<?php echo $sub_property[$i]->sp_name; ?>">
                                                        </td>
                                                        <td>
                                                           <select class="form-control" name="sub_type[]" style="border-radius:0px; width:122px; border:none; ">
                                                                <option value=""> Select </option>
                                                                <option value="Shop" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Shop') { echo "selected"; }} ?>> Shop  </option>
                                                                <option value="Flat" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Flat') { echo "selected"; }} ?>>  Flat </option>
                                                                <option value="Floor" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Floor') { echo "selected"; }} ?>> Floor </option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="carpet[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;" value="<?php echo format_money($sub_property[$i]->sp_carpet_area,2); ?>">
                                                            <select class="form-control" name="carpet_unit[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                                <option value="">Select</option>
                                                                <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                                <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                                <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="builtup[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;" value="<?php echo format_money($sub_property[$i]->sp_builtup_area,2); ?>">
                                                            <select class="form-control" name="builtup_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                                <option value="">Select</option>
                                                                <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                                <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                                <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                                
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="sellable[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;" value="<?php echo format_money($sub_property[$i]->sp_sellable_area,2); ?>">
                                                            <select class="form-control" name="sellable_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                                <option value="">Select</option>
                                                                <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                                <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                                <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="allocated_cost[]" class="form-control format_number" style="border:none;background:none; width:100px; text-align:right;" value="<?php echo format_money($sub_property[$i]->allocated_cost,2); ?>"></td>
                                                        <td><input type="text" name="allocated_maintainance[]" class="form-control format_number" style="border:none;background:none; width:150px; text-align:right;" value="<?php echo format_money($sub_property[$i]->allocated_maintainance,2); ?>"></td>
                                                        <td><input type="text" name="allocated_expenses[]" class="form-control format_number" style="border:none;background:none; width:130px; text-align:right;" value="<?php echo format_money($sub_property[$i]->allocated_expenses,2); ?>"></td>
                                                        </tr>
                                                        <?php } } else { ?>
                                                        <tr>
                                                        <td style="color:#000; vertical-align: middle;" align="middle">1</td>
                                                        <td>
                                                            <input type="hidden" name="sub_property_id[]" class="form-control">
                                                            <input type="text" name="sub_property[]" class="form-control" style="border:none;background:none; width:128px;">
                                                        </td>
                                                        <td>
                                                           <select class="form-control" name="sub_type[]" style="border-radius:0px; width:122px; border:none; ">
                                                                <option value=""> Select </option>
                                                                <option value="Shop"> Shop  </option>
                                                                <option value="Flat">  Flat </option>
                                                                <option value="Floor"> Floor </option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="carpet[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;">
                                                         <select class="form-control" name="carpet_unit[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                            <option value="">Select</option>
                                                            <option value="Sq m">Sq m</option>
                                                            <option value="Sq ft">Sq ft</option>
                                                            <option value="Sq yard">Sq yard</option>
                                                        </select>
                                                        </td>
                                                        <td><input type="text" name="builtup[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;">
                                                            <select class="form-control" name="builtup_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                                <option value="">Select</option>
                                                                <option value="Sq m">Sq m</option>
                                                                <option value="Sq ft">Sq ft</option>
                                                                <option value="Sq yard">Sq yard</option>
                                                            </select></td>
                                                        <td><input type="text" name="sellable[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;">
                                                            <select class="form-control" name="sellable_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;">
                                                                <option value="">Select</option>
                                                                <option value="Sq m">Sq m</option>
                                                                <option value="Sq ft">Sq ft</option>
                                                                <option value="Sq yard">Sq yard</option>
                                                            </select></td>
                                                        <td><input type="text" name="allocated_cost[]" class="form-control format_number" style="border:none;background:none; width:100px; text-align:right;"></td>
                                                        <td><input type="text" name="allocated_maintainance[]" class="form-control format_number" style="border:none;background:none; width:150px; text-align:right;"></td>
                                                        <td><input type="text" name="allocated_expenses[]" class="form-control format_number" style="border:none;background:none; width:130px; text-align:right;"></td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                        </table>
                                                        <div class="row"  >
                                                            <button class="btn btn-success repeat-schedule"  >+</button>
                                                            <a href="#accOneColSeven" >
                                                                <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
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
										  <div class="remark-container">
                                                <div class="form-group" style="background: none;border:none">
                                                <div class="col-md-12">
                                                    <div class=" ">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($sub_property)){ echo $sub_property[0]->maker_remark;}?></textarea>
                                                       
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
								 
    <br clear="all"/>
								 </div>
                                <div class="panel-footer">
                                    <input type="hidden" id="submitVal" value="1" />
                                    <a href="<?php echo base_url();?>index.php/allocation" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($sub_property)) echo 'display:none'; ?>" />
                                </div>
 
							</form>
							
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
            var BASE_URL="<?php echo base_url();?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
		
		<script>
			jQuery(function(){
    			var counter = <?php if(isset($sub_property)) { echo count($sub_property); } else { echo 1; } ?>;
    			$('.repeat-schedule').click(function(event){
    					event.preventDefault();
                        counter++;
    					var newRow = jQuery('<tr><td style="color:#000; vertical-align: middle;" align="middle">' + counter + '</td><td><input type="hidden" name="sub_property_id[]" class="form-control"><input type="text" name="sub_property[]" class="form-control" style="border:none;background:none; width:128px;"></td><td><select class="form-control" name="sub_type[]" style="border-radius:0px; width:122px; border:none; "><option value=""> Select </option><option value="Shop"> Shop  </option><option value="Flat">  Flat </option><option value="Floor"> Floor </option></select></td><td><input type="text" name="carpet[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left;text-align:right;"><select class="form-control" name="carpet_unit[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;"><option value="">Select</option><option value="Sq m">Sq m</option><option value="Sq ft">Sq ft</option><option value="Sq yard">Sq yard</option></select></td><td><input type="text" name="builtup[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;"><select class="form-control" name="builtup_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;"><option value="">Select</option><option value="Sq m">Sq m</option><option value="Sq ft">Sq ft</option><option value="Sq yard">Sq yard</option></select></td><td><input type="text" name="sellable[]" class="form-control format_number" style="border:none;background:none; width:52%; float:left; text-align:right;"><select class="form-control" name="sellable_area[]" style=" width:48%; border-radius:0px; border:none; border-left:1px solid #eee;"><option value="">Select</option><option value="Sq m">Sq m</option><option value="Sq ft">Sq ft</option><option value="Sq yard">Sq yard</option></select></td><td><input type="text" name="allocated_cost[]" class="form-control format_number" style="border:none;background:none; width:100px; text-align:right;"></td><td><input type="text" name="allocated_maintainance[]" class="form-control format_number" style="border:none;background:none; width:150px; text-align:right;"></td><td><input type="text" name="allocated_expenses[]" class="form-control format_number" style="border:none;background:none; width:130px; text-align:right;"></td></tr>');
    					$('.addschedule').append(newRow);
                        $("form :input").change(function() {
                            $(".save-form").prop("disabled",false);
                        });
						$('.format_number').keyup(function(){
							format_number(this);
						});
				});
			});
		</script>

        <script>
            jQuery(function(){
                var counter = <?php if(isset($pending_activity)) { echo count($pending_activity); } else { echo '1'; } ?>;
                $('.repeat-pending_activity').click(function(event){
                    event.preventDefault();
                    counter++;
                    var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" style="border-top: 1px dotted #ddd;"><div class="col-md-1 col-sm-1 col-xs-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div><div class="col-md-11 col-sm-11 col-xs-11"><input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
                    $('#pending_activity').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
                });
                $('.reverse-pending_activity').click(function(event){
                    var id="#pending_activity_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                });
            });

            $(document).ready(function(){
                addMultiInputNamingRules('#form_sub_property', 'input[name="sub_property[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_sub_property', 'select[name="sub_type[]"]', { required: true }, "");
            });
        </script>
    </body>
</html>