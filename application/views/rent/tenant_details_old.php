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
		body {   -ms-overflow-style: scrollbar;}
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr {
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
            
. 
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
 textarea.form-control { overflow:hidden; min-height:80px;}
 .Documents-section .col-md-3, .col-md-4, .col-md-6, col-md-9{ padding:0 3px!important;}
 .pending-group {    padding-right: 15px!important;}
 .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-']
            {
                padding-left:8px;
                padding-right:8px;
            }  
 .control-label {
 padding: 7px 0!important;
margin-bottom: 0;
text-align: right;
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
					
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Rent'; ?>" > Rent List</a>  &nbsp; &#10095; &nbsp; Rent Details </div>
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	 <div class="main-container">           
                           <div class="box-shadow"> 
                            <form id="form_rent" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($editrent)){ echo base_url().'index.php/Rent/updaterecord/'.$r_id; } else { echo base_url().'index.php/Rent/saverecord';} ?>">
                               <div class="box-shadow-inside custom-padding">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
							
								<div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>

								<div class="panel-body">
									<div class="form-group" style="border-top: 1px dotted #ddd;">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label">Property <span  class="asterisk_sign" > * </span></label>
												<div class="col-md-8">                                                        
													<select  onchange="getdocuments();" class="form-control" name="property" id="property">
														<option value="">Select</option>
														<?php if(isset($editrent)) { 
															for($i=0; $i<count($property); $i++) { ?>
																<option value="<?php echo $property[$i]->txn_id; ?>" <?php if($editrent[0]->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
														<?php } } else { ?>
																<?php for($i=0; $i<count($property); $i++) { ?>
																<option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
														<?php } } ?>
													</select>   
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label" >Sub Property</label>
												<div class="col-md-8">                                                        
													<select  class="form-control" name="sub_property" id="sub_property">
														<option value="">Select</option>
														<?php if(isset($editrent)) { 
															for($i=0; $i<count($sub_property); $i++) { ?>
																<option value="<?php echo $sub_property[$i]->sp_id; ?>" <?php if($editrent[0]->sub_property_id == $sub_property[$i]->sp_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
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
												<label class="col-md-4 control-label" >Tenant Name <span  class="asterisk_sign" > * </span></label>
												<div class="col-md-8">
													<input type="hidden" id="auth_name_id" name="owners" class="form-control" value="<?php if (set_value('owners')!=null) { echo set_value('owners'); } else if(isset($editrent[0]->tenant_id)){ echo $editrent[0]->tenant_id; } else { echo ''; }?>" />
                                                    <input type="text" id="auth_name" name="owner_name" class="form-control auto_contact_owner" value="<?php if (set_value('owner_name')!=null) { echo set_value('owner_name'); } else if(isset($editrent[0]->c_name)){ echo $editrent[0]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact or owner from database..." />
													<!-- <button class="btn btn-info mb-control sch" id="schedule_btn" data-box="#message-box-info2" style="margin-left: 2px;">+</button> -->
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 control-label" >Attorney Name</label>
												<div class="col-md-8">
													<input type="hidden" id="attorney_name_id" name="attorney" class="form-control" value="<?php if (set_value('owners')!=null) { echo set_value('owners'); } else if(isset($editrent[0]->attorney_id)){ echo $editrent[0]->attorney_id; } else { echo ''; }?>" />
                                                    <input type="text" id="attorney_name" name="attorney_name" class="form-control auto_client" value="<?php if (set_value('owner_name')!=null) { echo set_value('owner_name'); } else if(isset($editrent[0]->a_name)){ echo $editrent[0]->a_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
													<!-- <button class="btn btn-info mb-control sch" id="schedule_btn" data-box="#message-box-info2" style="margin-left: 2px;">+</button> -->
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="panel-body faq ">
									<div class="panel-body panel-group accordion"  >
										
										<div class="panel  panel-primary" id="panel-rent-details">
											<a href="#accOneColOne">   
												<div class="panel-heading">
													<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span> Rent Details  </h4>
												</div>   
											</a>  

											<div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
												<div class="form-group" style="border-top:1px solid #ddd; padding-top:10px;">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Rent per month (In &#x20B9;) <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7">
																
																<input  type="text" class="form-control format_number" name="rent_amount" id="rent_amount" onchange="instchange();" value="<?php if(isset($editrent)) { if(count($editrent)>=0) { echo format_money($editrent[0]->rent_amount,2); }} ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Free Rent Period</label>
															<div class="col-md-5">
																<input  type="text" class="form-control format_number" name="free_rent_period" id="free_rent_period" value="<?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->free_rent_period; }} ?>"/> 
															</div>
															<label class="col-md-2 control-label" style="text-align: left;    padding-left: 0;">Months</label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Deposit Amount (In &#x20B9;) <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7">
																<input  type="text" class="form-control format_number" name="deposit_amount" id="deposit_amount" value="<?php if(isset($editrent)) { if(count($editrent)>0) { echo format_money($editrent[0]->deposit_amount,2); }} ?>"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label" style="padding-left: 0px;">Deposit Paid Date</label>
															<div class="col-md-7">
																<input  type="text" class="form-control datepicker" name="deposit_paid_date" id="deposit_paid_date" value="<?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->deposit_paid_date!=null && $editrent[0]->deposit_paid_date!='') echo date('d/m/Y',strtotime($editrent[0]->deposit_paid_date)); }} ?>"/>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Possession Date <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7">
																<input  type="text" class="form-control datepicker" name="possession_date" id="possession_date" onchange="calculatedate(); instchange();" value="<?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->possession_date!=null && $editrent[0]->possession_date!='') echo date('d/m/Y',strtotime($editrent[0]->possession_date)); }} ?>"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Termation Date <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7">

																<input  type="text" class="form-control datepicker" name="termination_date" id="termination_date" onchange="calculatedate(); instchange(); " value="<?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->termination_date!=null && $editrent[0]->termination_date!='') echo date('d/m/Y',strtotime($editrent[0]->termination_date)); }} ?>"/>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Rent Due Day <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7">
																<select class="form-control" name="rent_due_day" id="rent_due_day" onchange="instchange();">
																	<option value="">Select</option>
																	<?php if(isset($editrent) && count($editrent)>0) {
																			for($i=1; $i<=31; $i++) { 
																				if($editrent[0]->rent_due_day==$i) echo '<option selected>'.$i.'</option>'; 
																				else echo '<option>'.$i.'</option>';}} 
																	else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
																</select>
																<!-- <input  type="text" class="form-control format_number" name="rent_due_day" id="rent_due_day" onchange="instchange();" value="<?php //if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->rent_due_day; }} ?>"/> -->
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Lease Period <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-5">
																<input  type="text" class="form-control format_number"  name="lease_period" id="lease_period" value="<?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->lease_period; }} ?>"/>
															</div>
															<label class="col-md-2 control-label" style="text-align: left;    padding-left: 0;">Months</label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">CAM / Maintenance By <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7" style="line-height:30px;">
																<input type="radio" name="maintenance_by" class="icheckbox" value="Owner" id="maintenance_by_owner" data-error="#err_maintenance_by" <?php if (isset($editrent)) { if($editrent[0]->maintenance_by=='Owner') echo 'checked'; } ?>/>&nbsp;&nbsp;Owner&nbsp;&nbsp;&nbsp;
                                                    			<input type="radio" name="maintenance_by" class="icheckbox" value="Tenant" id="maintenance_by_tenant" data-error="#err_maintenance_by" <?php if (isset($editrent)) { if($editrent[0]->maintenance_by=='Tenant') echo 'checked'; } ?>/>&nbsp;&nbsp;Tenant
                                                        		<div id="err_maintenance_by"></div>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-5 control-label">Property Tax By <span  class="asterisk_sign" > * </span></label>
															<div class="col-md-7"  style="line-height:30px;">
																<input type="radio" name="property_tax_by" class="icheckbox" value="Owner" id="property_tax_by_owner" data-error="#err_property_tax_by" <?php if (isset($editrent)) { if($editrent[0]->property_tax_by=='Owner') echo 'checked'; } ?>/>&nbsp;&nbsp;Owner&nbsp;&nbsp;&nbsp;
                                                    			<input type="radio" name="property_tax_by" class="icheckbox" value="Tenant" id="property_tax_by_tenant" data-error="#err_property_tax_by" <?php if (isset($editrent)) { if($editrent[0]->property_tax_by=='Tenant') echo 'checked'; } ?>/>&nbsp;&nbsp;Tenant
                                                        		<div id="err_property_tax_by"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<div class="panel panel-primary" id="panel-rent-consideration">
											<a href="#accOneColTwo">   
												<div class="panel-heading">
													<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span> Rent Consideration </h4>
												</div>   
											</a>  

											<div class="panel-body" id="accOneColTwo" style="width:100%; ">
												<div id="temp_schedule_div"></div>
												
												<?php if(isset($p_schedule)) { ?>
												<div class="row">
												<div class="table-responsive" id="actual_schedule_div" style="overflow: visible;">
												<table id="contacts" class="table table-bordered" style="border-top:;">
												    <thead>
												        <tr>
												          	<th  width="55px" align="center">Sr. No.</th>
														    <th  >Type</th>
														    <th width="120">Total Cost  (In &#x20B9;)</th>
												            <?php if(isset($tax_name)){
												                        $key=0;
												                        foreach($tax_name as $row){
												                            echo '<th width="15%">'.$row->tax_type.'</th>';
												                            $tax_array[$key]=$row->tax_type;
												                            $key++;
												                   		}
												       				}
												       		?>
												            <th width="120">Net Cost (In &#x20B9;)</th>
												        </tr>
												    </thead>
												    <tbody>
												        <?php 
												            $j=0;
												            $total_basic_cost=0;
												            $total_net_amount=0;
												            $total_tax_array=array();
												            
												            foreach($p_schedule as $row_tax) {
												                echo '<tr>
												                <td align="center">'.($j+1).'</td>
												                <td>'.$row_tax["event_type"].'</td>
												                <td >'.format_money($row_tax["basic_cost"],2).'</td>';
												                $total_basic_cost=$total_basic_cost+$row_tax["basic_cost"];
												             	$next_count=0;
												                $td_count=0;
												                // print_r($p_schedule);
												                if(isset($row_tax['tax_type'])) {
												                   	// for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
												                    //echo "<br>hi";
												                  	// echo $key;
												                    for($tcnt=0;$tcnt<$key;$tcnt++){
												                        //echo "step1--";
												                     	for($nc=0;$nc<count($row_tax['tax_type']);$nc++){
												                        	$tax_amount='';
												                        	if($row_tax['tax_type'][$nc]==$tax_array[$tcnt]){
												                            	$tax_amount=$row_tax['tax_amount'][$nc];
												                           		$nc=count($row_tax['tax_type']);
												                           		//$tcnt=$key;
												                       			//}
												                    		}
												                		}
												                    	if($tax_amount !=''){
												                        	echo '<td  >'.format_money($tax_amount,2).'</td>';
												                            $td_count++;
												                    	}
												                        else{
												                            //if($next_count )
												                            echo '<td  >'.format_money($tax_amount,2).'</td>';
												                            $td_count++;
												                        }
												                       	// $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
												                  		//  $total_tax_array[$tcnt]= $tax_amount;
												                   		// print_r($total_tax_array);
												                	}
												                }
												            	$inserttd=$key-$td_count;
												                if($inserttd !=0){
												                    for($tdint=0;$tdint<$inserttd;$tdint++){
												                        echo "<td></td>";
												                    }
												                }

												                echo '<td  >'.format_money($row_tax["net_amount"],2).'</td></tr>';
												                $total_net_amount=$total_net_amount+$row_tax["net_amount"];
																//print_r($p_schedule[$j]['event_type']);
																$j++;
												        	}
												    	?>

												        <tr>
												            <td colspan="2" align="right"><b>Grand Total (In &#x20B9;)</b></td>
												            <td><?php echo (isset($total_basic_cost)?format_money($total_basic_cost,2):0);?></td>
												            <?php  
												            	$k=0;
												                if (isset($total_tax_amount)) {
												                    foreach($total_tax_amount as $row){
												                        echo '<td>'.format_money($row[$k],2).'</td>';
												                        $k++;
												                    }
												                }
												            ?>
												           <td><?php echo (isset($total_net_amount)?format_money($total_net_amount,2):0);?></td>
												        </tr>
												    </tbody>
												</table>
												</div>
												</div>
	                                       		<?php } ?>
	                             				
												<div class="btn-margin">
													<div class="">
														<a href="#accOneColThree" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
														<button type="button" class="btn btn-info mb-control" data-box="#message-box-info" onclick="opentable(); return false;">Schedule</button>
													</div>
												</div>
												
												<div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;" onmouseover="document.body.style.overflow='hidden';" onmouseout="document.body.style.overflow='auto';">
													<div class="mb-container" style="background:#fff;">
														<div class="mb-middle">
															<div class="mb-title" style="color:#000;text-align:center;">Schedule</div>
															<div class="mb-content">
																<div class="form-group" style="border-top: 1px dotted #ddd;">
																	<label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
																	<input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>schedule_format_rent.xlsx" target="_blank">Download Format</a>
																	<!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
																</div>
																<div class="table-stripped">
																	<table id="contacts" class="table group addschedule">
																		<thead>
																			<tr>
																			<th style="text-align: center;" width="60">Sr. No.</th>
																				<th style=" display:none;">Event Type</th>
																				<th style=" ">Event Name</th>
																				<th   width="120">Date</th>
																			    <th   width="130">Basic Cost  (In &#x20B9;)</th>					
																				<th    width="130">Tax Appilcable</th>
																			</tr>
																		</thead>
																		<tbody id="schedule_table">
																		<?php $i=0; $schedule_id=1;
							 												if(isset($p_schedule1)){
																			//print_r($p_schedule1);
																			foreach($p_schedule1 as $row){
																				$sch_id=$p_schedule1[$i]['schedule_id'];
																				$event_type=$p_schedule1[$i]['event_type'];
																				$event_name=$p_schedule1[$i]['event_name'];
																				$basic_cost=$p_schedule1[$i]['basic_cost'];
																				$event_date=date('d/m/Y',strtotime($p_schedule1[$i]['event_date']));
																				$tax_master=array();
																				$j=0;
																				if(isset($p_schedule1[$i]['tax_type'])){
																					for($j=0;$j<count($p_schedule1[$i]['tax_type']);$j++ ){
																						//$p_schedule1[$i]['tax_master'][$j];
																						$tax_master[]=$p_schedule1[$i]['tax_master_id'][$j];
																					}
																				}
																			?>

																			<tr id="repeat_schedule_<?php echo $i+1; ?>"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle"><?php echo $i+1; ?></td>
																			<input type="hidden"  name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>

																			<td style="display: none;"><input type="text"  name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
																			<td><input type="text"  name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
																			<td><input type="text"  name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none;"/></td>
																			<td><input type="text"   name="sch_basiccost[]" value="<?php echo format_money($basic_cost,2);?>" class="form-control format_number" style="border:none"/></td>
																			<td><select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="  select" style="display: none;">
																				<?php $schedule_id++;
																					if(isset($tax)){
																						//print_r($tax_id);
																						foreach($tax as $row){
																							if(in_array($row->tax_id, $tax_master)){
																								//echo "hi";
																								$selected="selected='selected'";
																							}
																							else{
																								$selected='';
																							}
																							echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
																						}
																					};?>
																				</select>
																			</td>
																			</tr>
																		<?php $i++; }} ?>									
																		</tbody>
																	</table>
																</div>
															</div>
															
															<div class="mb-footer">
																<button class="btn btn-success repeat-schedule"  >+</button>
																<button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
																<button class="btn btn-danger  pull-right mb-control-close" onclick="closetemp(); return false;">Close</button>
																<button class="btn btn-success   pull-right" style="margin-right: 10px;" id="savebtn" onclick="savetemp(); return false;">Save</button>
															</div>
														</div>
													</div>
												</div>

												<input type="hidden" id="rowdisplaycount" value="<?php echo $i;?>">
											</div>

											<input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id-1;?>" />
										</div>


										<?php $this->load->view('templates/related_party');?>



										<div class="panel panel-primary" id="panel-documents" style="margin-bottom:5px">
											<a href="#accOneColFour">   
												<div class="panel-heading">
													<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Documents	</h4>
												</div>  
											</a> 
											<div class="panel-body" id="accOneColFour">
											<div id="adddoc">
												<!-- <?php //if(isset($editdocs)) { 
												//for($i=0; $i<count($editdocs); $i++) {?>
			 										<div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
														<div class="col-md-2">
					                                    	<input type="hidden" class="form-control" name="doc_id[]" value="<?php //echo $editdocs[$i]->fk_d_id; ?>" />
					                                        <input type="hidden" class="form-control" id="d_m_status_<?php //echo $i; ?>" value="<?php //echo $editdocs[$i]->d_m_status; ?>" />
															<input  type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="Document Name" value="<?php //echo $editdocs[$i]->rt_doc_name; ?>" />

														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control" name="doc_desc[]" placeholder="Description"  value="<?php //echo $editdocs[$i]->rt_doc_description; ?>" />
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value="<?php //echo $editdocs[$i]->rt_doc_ref_no; ?>"/>
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value="<?php //if($editdocs[$i]->rt_doc_doi!=null && $editdocs[$i]->rt_doc_doi!='') echo date('d/m/Y',strtotime($editdocs[$i]->rt_doc_doi)); ?>"/>
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php //if($editdocs[$i]->rt_doc_doe!=null && $editdocs[$i]->rt_doc_doe!='') echo date('d/m/Y',strtotime($editdocs[$i]->rt_doc_doe)); ?>"/>
														</div>

														<div class="col-md-2">
			                                    			<div class="col-md-8">
																<input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
																<div id="doc_<?php //echo $i; ?>_error"></div>

																<?php //if($editdocs[$i]->rt_document!= '') { ?><a target="_blank" href="<?php //echo base_url().'downloads/rent/'.$r_id.'/'.$editdocs[$i]->rt_document_name; ?>">Download</a><?php //} ?>
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
															<input  type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="Document Name" value="<?php //echo $docs[$i]->d_documentname; ?>" />

														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control" name="doc_desc[]" placeholder=""  value="<?php //echo $docs[$i]->d_description; ?>" />
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/>
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/>
														</div>
														<div class="col-md-2">
															<input  type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
														</div>

														<div class="col-md-2">
															<div class="col-md-8">
																<input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
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
										 
												<div class="col-md-12  btn-container" style="border-top:1px dotted #ddd;">
												 	<!-- <br> <button class="btn btn-success repeat-doc" style="margin-left: 10px;" name="addkycbtn">+</button> -->
												 	<button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                    				<!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
													
													<a href="#accOneColSeven" >
												<button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
											  </a>
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
                                                <div class=" ">
                                                    <div class="col-md-12">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($editrent)){ echo $editrent[0]->maker_remark;}?></textarea>
                                                        <!-- <label style="margin-top: 5px;">Remark </label> -->
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
		                            <a href="<?php echo base_url(); ?>index.php/rent" class="btn btn-danger" >Cancel</a>
		                            <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
		                            <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($editrent)) echo 'display:none'; ?>" />
		                        </div>
	                        
                            </form>
                    			
                			<!-- start contact popup -->
                			<form id="contact_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
                            <div class="message-box message-box-info animated fadeIn" id="message-box-info2" style="overflow:auto;">
                                <div class="mb-container" style="background:#fff;width: 50%;top: 25%;left: 25%;">
                                    <div class="mb-middle">
                                        <div class="mb-title" style="color:#000;text-align:center;">Add Contact</div>
                                        <div class="mb-content">
                                            <div class="form-group" style="border-top: 1px dotted #ddd;" >
                                                <label class="col-md-2 control-label" style="width: 12.5%;color: black;padding-left: 0px;">Full Name</label>
                                                <div class="col-md-4">
                                                        <input type="text" class="form-control" name="con_first_name" placeholder="First Name"/>
                                                </div>
                                                <div class="col-md-3">
                                                        <input type="text" class="form-control" name="con_middle_name" placeholder="Middle Name"/>
                                                </div>
                                                <div class="col-md-3">
                                                        <input type="text" class="form-control" name="con_last_name" placeholder="Last Name"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label" style="width: 12.5%;color: black;">Email ID</label>
                                                    <div class="col-md-4">
                                                            <input type="text" class="form-control" name="con_email_id1" placeholder="Email ID"/>
                                                    </div>
                                                    <label class="col-md-2 control-label" style="width: 12.5%;color: black;padding-left: 0px;">Mobile No</label>
                                                    <div class="col-md-5">
                                                            <input type="text" class="form-control" name="con_mobile_no1" placeholder="Mobile No"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-footer">
                                            <button class="btn btn-danger btn-lg pull-right mb-control-close">Close</button>
                                            <button id="save_contact" type="button" class="btn btn-success btn-lg pull-right" style="margin-right: 10px;">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
							</form>
                            <!-- End contact popup -->
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
	        var BASE_URL="<?php echo base_url()?>";
	    </script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
		
        <script type="text/javascript">
			var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
			var tax = new Array();
			var taxname=new Array();
			var taxpurpose=new Array();

			<?php for ($i=0; $i < count($tax) ; $i++) { ?>
				tax.push('<?php echo $tax[$i]->tax_percent; ?>');
				taxname.push('<?php echo $tax[$i]->tax_name; ?>');
				taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
			<?php }	?>

			function calculatedate(){
				var lease="";
				if(document.getElementById('possession_date').value!=null && document.getElementById('possession_date').value!="" && 
				   document.getElementById('termination_date').value!=null && document.getElementById('termination_date').value!="") {
					
					var stdt= $("#possession_date").val();
					var endt=$('#termination_date').val();
					
					var from = moment(stdt, 'DD/MM/YYYY'); 
					var to = moment(endt, 'DD/MM/YYYY'); 
					 
					var duration = to.diff(from, 'months')

					lease=duration;
				}
				
				document.getElementById('lease_period').value=lease;
			}

			function opentable(){

				if(flag==false) {
					document.getElementById('message-box-info').style.display = "block";
					var lease=get_number(document.getElementById('lease_period').value,2);
					var rent=get_number(document.getElementById('rent_amount').value,2);
					//alert(rent);
					var stdt=document.getElementById('possession_date').value;
					var endt=document.getElementById('termination_date').value;
					var duedy=get_number(document.getElementById('rent_due_day').value,2);
					if (isNaN(duedy) || duedy==0) duedy=1;
					//duedy++;
					var amt2=Math.round(rent);
					rows='';
					var tax='';
					var tmpdt=new Date(stdt);
					//console.log(stdt);
					//alert(tmpdt);
					var yy=null;
					var mm=null;
					if($("#possession_date").val()!="" && $("#possession_date").val()!=null){
						mm=$("#possession_date").datepicker('getDate').getMonth();
						//console.log(mm);
						yy=$("#possession_date").datepicker('getDate').getFullYear();;
					}

					// var cntSch = <?php //isset($p_schedule1)? echo count($p_schedule1): 0;?>
					// var counter = (cntSch>lease)?lease:cntSch;
					// for (var i=0; i<counter; i++) {
					<?php $i=0; $schedule_id=1;
						if(isset($p_schedule1)){
						foreach($p_schedule1 as $row){
							$sch_id=$p_schedule1[$i]['schedule_id'];
							$event_type=$p_schedule1[$i]['event_type'];
							$event_name=$p_schedule1[$i]['event_name'];
							$basic_cost=format_number($p_schedule1[$i]['basic_cost'],2);
							$event_date=date('d/m/Y',strtotime($p_schedule1[$i]['event_date']));
							$tax_master=array();
							$j=0;
							if(isset($p_schedule1[$i]['tax_type'])){
								for($j=0;$j<count($p_schedule1[$i]['tax_type']);$j++ ){
									//$p_schedule1[$i]['tax_master'][$j];
									$tax_master[]=$p_schedule1[$i]['tax_master_id'][$j];
								}
							}
						?>

						if(mm>11){
							mm=1;
							yy++;
						} else {
							mm++;
						}
						var taxidcount=parseInt(i)+parseInt(1);
						var abc=yy+'/'+mm+'/'+duedy;
						//alert(abc);
						abc=moment(abc).format('DD/MM/YYYY');

						rows=rows+ "<tr id='repeat_schedule_<?php echo $i+1; ?>'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'><?php echo $i+1; ?></td> \
									<td style='display: none;'> \
										<input type='hidden' name='sch_id[]' class='form-control' value='<?php echo $sch_id;?>' style='border:none;'/> \
										<input type='text' id='txttype' name='sch_type[]' class='form-control' value='<?php echo $event_type;?>' style='border:none;'/> \
									</td> \
									<td><input type='text' id='txtevent' name='sch_event[]' class='form-control' value='<?php echo $event_name;?>' style='border:none;'/></td> \
									<td><input type='text' id='txtevent' name='sch_date[]' value='"+ abc +"' class='form-control datepicker' style='border:none;'/></td> \
									<td><input type='text' id='bs<?php echo $i; ?>' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='<?php echo format_money($basic_cost,2);?>' class='form-control format_number' style='border:none;'/></td> \
									<td><select class='form-control select' multiple name='sch_tax_<?php echo $schedule_id;?>[]'>";

						<?php $schedule_id++;
							if(isset($tax)){
								foreach($tax as $row){
									if(in_array($row->tax_id, $tax_master)){
										//echo "hi";
										$selected="selected='selected'";
									}
									else{
										$selected='';
									} ?>
									rows=rows+"<option value='<?php echo $row->tax_id;?>' <?php echo $selected;?>><?php echo $row->tax_name.'-'.$row->tax_percent ; ?></option>";
						<?php 	} 
							} ;?>

						rows=rows+ "</select></td></tr>";
					<?php $i++; }} ?>

					for (var i = <?php echo isset($p_schedule1)? count($p_schedule1): 0;?>; i < lease; i++) {
						if(mm>11){
							mm=1;
							yy++;
						} else {
							mm++;
						}
						var taxidcount=parseInt(i)+parseInt(1);
						var abc=yy+'/'+mm+'/'+duedy;
						//alert(abc);
						abc=moment(abc).format('DD/MM/YYYY');
						var ntamt=amt2;

						rows=rows+ "<tr id='repeat_schedule_"+ (i+1) +"'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ (i+1) +"</td> <td style='display: none;'><input type='hidden' name='sch_id[]' class='form-control' value='' style='border:none;'/> <input type='text' id='txttype' name='sch_type[]' class='form-control' value='' style='border:none;'/></td><td><input type='text' id='txtevent' name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text' id='txtevent' name='sch_date[]' value='"+ abc +"'  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' id='bs"+i+"' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='" + format_money(amt2,2) + "' class='form-control format_number' style='border:none;text-align:right;'/></td><td><select class='form-control select' multiple name='sch_tax_"+taxidcount+"[]'>";
						
						<?php if(isset($tax)){
							foreach($tax as $row){ ?>
								//alert("step"+i);
							rows=rows+"<option value='<?php echo $row->tax_id;?>'><?php echo $row->tax_name."-".$row->tax_percent ; ?></option>";
						<?php } } ?>					
						rows=rows+ "</select></td></tr>";
						ntamt=0;
					}

					document.getElementById('schedule_table').innerHTML=rows;
					$(".select").selectpicker();
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
					$('.select').selectpicker();
					$("#rowdisplaycount").val(i);
					$('.format_number').keyup(function(){
				        format_number(this);
				    });
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
					flag=true;
				} else {
					document.getElementById('message-box-info').style.display = "block";
				}
			}

			function calculatetaxes(arg){
				var bsid = arg.getAttribute('id');
				var tyu=bsid.charAt(2);
				
				for (var i = 0; i < tax.length; i++) {
					tax[i]
				};
				var basic=document.getElementById()
			}

			function savetemp() {
				removeMultiInputNamingRules('#form_rent', 'input[alt="sch_event[]"]');
			    removeMultiInputNamingRules('#form_rent', 'input[alt="sch_date[]"]');
			    removeMultiInputNamingRules('#form_rent', 'input[alt="sch_basiccost[]"]');

				var formdata = {};
				var formdata={
					// sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
					sch_type:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
					sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
					sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
					sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get()
					//sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get()
				}

				// var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
				var sch_type=$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get();
				//console.log(sch_type.length);
				var j=1;
				for(var i=0;i<sch_type.length;++i){
					//console.log("step1");
					formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
					j++;
				}
				console.log(formdata);
				$.ajax({
					url:"<?php echo base_url().'index.php/sale/insertTempSchedule';?>",
					data:formdata,
					dataType:"json",
					type:"POST",
					success:function(responsemydata){
						if(responsemydata.status==1){
							$("#temp_schedule_div").html(responsemydata.data);
							$("#actual_schedule_div").hide();

						}
					},
					error:function(responsemydata,status,error) {
						var err=eval("("+responsemydata.responseText+")");
						alert(err.Message);
					
						//alert(responsemydata.data);
					},
				});
				
				addMultiInputNamingRules('#form_rent', 'input[name="sch_event[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    addMultiInputNamingRules('#form_rent', 'input[name="sch_date[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    addMultiInputNamingRules('#form_rent', 'input[name="sch_basiccost[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    
				//var bl=parseInt(document.getElementById('sch_bal').value);
				/*if(bl!=0) {
					alert("Balance should be 0. Kindly check the same.")
				} else {*/
					document.getElementById('message-box-info').style.display = "none";
					//$("#actual_schedule_div").removeClass('show').addClass('hide');
				//}
			}

			function closetemp() {
				document.getElementById('message-box-info').style.display = "none";
			}

			function instchange(){
				flag=false;
			}


		</script>

		<script>
			jQuery(function(){

				$('.repeat-schedule').click(function(event){
					event.preventDefault();
					scheduleRepeat();
				});
			    $('.reverse-schedule').click(function(event){
			        scheduleReverse();
			    });
			});

			function scheduleRepeat(){
				var counter = $("#rowdisplaycount").val();
				//alert(counter);
				counter++;
				var rows='';
				//collen=tax.length;
				//alert(collen);
				// if(counter%2==0)
				// {
				// 	var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
				// 	$('.addschedule').append(newRow);
				// }
				// else
				// {
				// 	var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
				// }
				rows=rows+ "<tr id='repeat_schedule_"+counter+"'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ counter +"</td> <td style='display: none;'><input type='text'  name='sch_type[]' class='form-control' value='' style='border:none;'/></td><td><input type='text'  name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text'  name='sch_date[]' value=''  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' name='sch_basiccost[]' value='' class='form-control format_number' style='border:none; text-align:right;'/></td><td><select class='select' multiple name='sch_tax_"+counter+"[]'>";
					<?php 
					if(isset($tax)){
						foreach($tax as $row){ ?>
							//alert("step"+i);
						rows=rows+"<option value='<?php echo $row->tax_id;?>'><?php echo $row->tax_name."-".$row->tax_percent ; ?></option>";
						<?php } } ?>					
					 rows=rows+ "</select></td></tr>";
					 // counter++;
			 	$('.addschedule').append(rows);	$("#rowdisplaycount").val(counter);
				$('.datepicker').datepicker({changeMonth: true,changeYear: true});
    			$('.select').selectpicker();
				$('.format_number').keyup(function(){
			        format_number(this);
			    });
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
			}

			function scheduleReverse(){
				var counter = $("#rowdisplaycount").val();
		  //   	var ctr=window.cntrinst;
				// var counter = tst;
				// if(ctr == 0){
				// var tst=$("#schedule_id").val();						
				// }
				// else{
				// 	//alert(ctr);
				// 	tst=parseInt(ctr);
				// }
		        var id="#repeat_schedule_"+(counter).toString();
		        if($(id).length>0){
		            $(id).remove();
		            counter--;
		            // window.cntrinst=counter;
		            $("#rowdisplaycount").val(counter);
		            $("#schedule_id").val(counter);
		        }
			}
			
		
			// jQuery(function(){
   //          	var counter = $('input.doc_file').length;
			// 	// var counter = <?php //if(isset($editdocs)) { echo count($editdocs); } else {echo count($docs);} ?>;
			// 	// var counter = <?php //if(isset($editdocs)) { echo count($editdocs); } else { ?>$("input.doc_file").length<?php //} ?>;
			// 	$('.repeat-doc').click(function(event){
			// 		event.preventDefault();

			// 		var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><input type="hidden" class="form-control" name="doc_id[]" value="" /><input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" /><input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" placeholder="Document Name" value="" /></div><div class="col-md-2"><input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description"  value="" /></div><div class="col-md-2"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '"  id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" /></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');

			// 		$('.adddoc').append(newRow);
			// 		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
	  //               $('.delete_row').click(function(event){
	  //                   delete_row($(this));
	  //               });
			//         $("form :input").change(function() {
		 //                $(".save-form").prop("disabled",false);
		 //            });
			// 		counter++;
			// 	});
			// });
		</script>

	    <script>
	    	function getdocuments() {
        		<?php if(isset($editrent)) {  } else {  ?>
					var counter = 0;
					var propid = document.getElementById("property").value;
					$('#adddoc').empty();

			        $.ajax({
			            url: "<?php echo base_url() . 'index.php/Rent/loaddocuments/' ?>" + propid,
			            data: $("#form_rent").serialize(),
			            cache: false,
			            type: "POST",
			            dataType: 'json',
			            global: false,
			            async: false,
			            success: function (data) {
							// if(data!=null) {
							// 	 //alert(data);
	      //                       $.each(data, function(key,value) {
	      //                           // alert(value.d_documentname + ' ' + value.d_description);
	      //                           var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><input type="hidden" class="form-control" name="doc_id[]" value="'+ value.d_id +'" /><input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="'+ value.d_m_status +'" /><input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" placeholder="Document Name" value="'+ value.d_documentname +'" /></div><div class="col-md-2"><input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description"  value="'+ value.d_description +'" /></div><div class="col-md-2"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" /></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');
							// 		$('.adddoc').append(newRow);
							// 		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
					  //               $('.delete_row').click(function(event){
					  //                   delete_row($(this));
					  //               });
							//         $("form :input").change(function() {
							//             $(".save-form").prop("disabled",false);
							//         });
							// 		counter = counter+1;
	      //                       });
	      //                   }

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
        	}


        	$(document).ready(function(){
			    // addMultiInputNamingRules('#form_rent', 'input[name="sch_type[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_rent', 'input[name="sch_event[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    addMultiInputNamingRules('#form_rent', 'input[name="sch_date[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    addMultiInputNamingRules('#form_rent', 'input[name="sch_basiccost[]"]', { required: function(element) {
																			                        if($("#submitVal").val()=="0"){
																			                            return true;
																			                        } else {
																			                            return false;
																			                        }
																			                    } }, "");
			    addMultiInputNamingRules('#form_rent', '.doc_name', { required:function(element) {
			                                                                        if($("#submitVal").val()=="0"){
			                                                                            return true;
			                                                                        } else {
			                                                                            return false;
			                                                                        }
			                                                                    }
			                                                                }, "Document");
        	});


			function saveTempBulkUpload(){
					var input = ($("#schedule_upload"))[0];
					var upload_txn_type = 'rent';
			        file = input.files[0];
			        if(file != undefined){
			            formData= new FormData();            
			                    formData.append("data_file", file);
			                    formData.append("upload_txn_type",upload_txn_type);
			                    $.ajax({
			                        url: "<?php echo base_url() . 'index.php/rent/saveTempBulkUpload' ?>",
			                        type: "POST",
			                        data: formData,
			                        processData: false,
			                        contentType: false,
			                        dataType: "json",
			                        success: function(data){
			                        	if(data.status==0){
			                        		alert(data.errormsg);
			                        	}
			                        	else{
			                        		var counter=data.rowcounter;
			                        		var tst=data.rowcounter;
			                        		$("#rowdisplaycount").val(parseInt(data.rowcounter)-1);
			                        		$("#message-box-info").html(data.data);
			                        		$('.select').selectpicker();
			                        		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
			                        		$('#schedule_upload').bootstrapFileInput();
											$('.repeat-schedule').click(function(event){
												event.preventDefault();
												//alert(window.cntrinst);
												scheduleRepeat();
												
											});
											$('.reverse-schedule').click(function(event){
												event.preventDefault();
												//alert(window.cntrinst);
												scheduleReverse();
												
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
			//                
			        }else{
			            $("#file_photo_error").html('Input something!');
			//                alert('Input something!');
			        }
			}
	    </script>
	    <!-- END SCRIPTS -->   
	  	
		<script>
	        $( "#property" ).change(function() {
	            var property=$("#property").val();

	            // alert(property);
	            // alert(<?php //if(isset($r_id)) echo $r_id; else echo '0';?>);

	            var dataString = 'property_id=' + property + '&txn_id=' + <?php if(isset($r_id)) echo $r_id; else echo '0';?>;

	            $.ajax({
	               type: "POST",
	               url: "<?php echo base_url() . 'index.php/rent/get_sub_property' ?>",
	               data: dataString,
	               cache: false,
	               success: function(html){
	                   $("#sub_property").html(html);
	               } 
	            });
	        });
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
			        var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" '+((counter==1)?'style="border-top: 1px dotted #ddd;"':'')+'><div class="col-md-1 col-sm-1 col-xs-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div><div class="col-md-11 col-sm-11 col-xs-11 pending-group"><input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
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