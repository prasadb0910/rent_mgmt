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
 <style type="text/css">
.panel { box-shadow:none; border:1px dotted #ddd!important; border-top:none!important;}
.address-remark{width:10%;}
.address-container1{width:90%; display:flex;}   

	@media screen and (max-width: 767px) 
	{
.custom-padding .col-md-2 {
    padding:0px!important;
} }
	@media only screen and (max-width: 992px) { 
  .custom-padding .control-label{ padding:0;}  
.address-remark {width:100%; text-align:left!important; margin-left:10px;}
.address-container1 {width:100%;}
.address-remark { padding:0!important;}
	}  
  </style>	     
    </head>
    <body>                              
        <!-- START PAGE CONTAINER -->
           <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">                  
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/rent'; ?>" > Rent List</a>  &nbsp; &#10095; &nbsp;    Rent View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				     <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>  <a class="btn-margin" href="<?php echo base_url().'index.php/rent/edit/'.$r_id; ?>"> 
					 <span class="btn btn-success pull-right btn-font"> Edit </span> </a> <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/rent" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
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
									<form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
										
									   <div id="pdiv" >   
										<div class="panel-body" >
										
									            	<div class="form-group" style="border-top:1px dotted #ddd;">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="">
																<label class="col-md-3 control-label" ><strong>Property   Name:</strong></label>
																<div class="col-md-9 ">
																  <label class="col-md-12 control-label contact-view" style="text-align:left;">
																	<?php if(isset($editrent[0])) { echo $editrent[0]->p_property_name; } ?>
																  </label>
																</div>
															</div>
														</div>
															<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="">
															  <label class="col-md-3 control-label" style="padding-left:0px;padding-right:0px;"><strong>Sub Property Name :</strong></label>
															  <div class="col-md-9">
																  <label class="col-md-12 control-label contact-view" style="text-align:left;">
																	<?php if(isset($editrent[0])) echo $editrent[0]->sp_name; ?>
																  </label>
																</div>
															</div>
														</div>
													</div>
										             <div class="form-group print-border" style="border-top:0px dotted #ddd;">                                            
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="">
																<label class="col-md-3 control-label" ><strong>Tenant Name:</strong></label>
																<div class="col-md-9">
																  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (set_value('owner_name')!=null) { echo set_value('owner_name'); } else if(isset($editrent[0]->c_name)){ echo $editrent[0]->c_name; } else { echo ''; }?></label>
																</div>
															</div>
														</div>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="">
																<label class="col-md-3 control-label" ><strong>Attorney Name:</strong></label>
																<div class="col-md-9">
																  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent[0])) echo $editrent[0]->a_name; ?></label>
																</div>
															</div>
														</div>
													</div>
												  	
										</div>        
													
													
										   
													<div class="panel-heading" style="border-top:0px solid #E5E5E5;   ">
													<h3 class="panel-title" ><strong>Rent Details</strong></h3>
													</div>
													 <div class="panel-body">
													<div class="form-group" style="border-top:0px dotted #ddd;">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 position-name control-label" ><strong>Rent Per month (In &#x20B9;):</strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>=0) { echo format_money($editrent[0]->rent_amount,2); }} ?></label>
															</div>
														</div>
													</div>
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
														  <label class="col-md-3 position-name control-label"><strong>Free Rent Period:</strong></label>
														  <div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->free_rent_period; }} ?></label>
															</div>
														</div>
													</div>
													</div>                                           
													<div class="form-group">
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 position-name control-label" ><strong>Deposit Amount (In &#x20B9;): </strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo format_money($editrent[0]->deposit_amount,2); }} ?></label>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 position-name control-label" ><strong>Deposit Paid Date:</strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->deposit_paid_date!=null && $editrent[0]->deposit_paid_date!='') echo date('d/m/Y',strtotime($editrent[0]->deposit_paid_date)); }} ?></label>
															</div>
														</div>
													</div>
													</div>                                            
													<div class="form-group">
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 position-name control-label" ><strong>Possession Date:</strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->possession_date!=null && $editrent[0]->possession_date!='') echo date('d/m/Y',strtotime($editrent[0]->possession_date)); }} ?></label>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 position-name control-label" ><strong>Termination Date:</strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->termination_date!=null && $editrent[0]->termination_date!='') echo date('d/m/Y',strtotime($editrent[0]->termination_date)); }} ?></label>
															</div>
														</div>
													</div>
													</div>                                            
													<div class="form-group">
													
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3  position-name control-label" style="padding-left:0;"><strong> Rent Due Day: </strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->rent_due_day; }} ?></label>
															</div>
														</div>
													</div>
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3  position-name control-label" ><strong> Lease Period: </strong></label>
															<div class="col-md-9 position-view">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->lease_period; }} ?></label>
															</div>
														</div>
													</div>
													
													</div>                                           
													<div class="form-group print-border">
														<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 control-label" ><strong> CAM / Maintenance By: </strong></label>
															<div class="col-md-9">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->maintenance_by; }} ?></label>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="">
															<label class="col-md-3 control-label" ><strong> Property Tax By: </strong></label>
															<div class="col-md-9">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->property_tax_by; }} ?></label>
															</div>
														</div>
													</div>
													</div>



												 
											 <div class="panel-heading" style="border-top:1px solid #E5E5E5; margin-top:10px; ">
												
											<h3 class="panel-title"  ><strong> Owner  Details</strong></h3>                                    
										  </div>
						 <div class="panel-body">
								<div class="row">
						  
							<div class="table-responsive">
							<table id="contacts" class="table table-bordered" style="border-top:;">
							  <thead>
							  <tr>
								  <th width="5%" align="center">Sr. No.</th>
								  <th width="80%">Owner Name </th>
								  <th width="15%">% Share</th>
								</tr>
							  </thead>
							  <tbody>
								<?php if(isset($s_owner)) { 
								  for ($j=0; $j < count($s_owner); $j++) { ?>
								<tr>
								  <td align="center" class="Contact_name"><?php echo $j+1; ?></td>
								  <td><?php if(isset($s_owner[$j]->owner_name)){ echo $s_owner[$j]->owner_name; } else { echo ''; }?></td>
								  <td><?php echo format_money($s_owner[$j]->pr_ownership_percent,2); ?> </td>
								</tr>
								<?php } } ?>
								
							  </tbody>
							</table>
							
							
							</div>
						  
						  
							  </div>
						  </div>
											  
											
											 <div class="panel-heading" style="border-top:1px solid #E5E5E5;  ">
											<h3 class="panel-title" style=" "><strong>Rent Consideration</strong></h3>
										</div>
							   
											 <div class="panel-body">
											 <div class="row">
											
												<div class="table-responsive">
												<table id="contacts" class="table table-bordered" style="border-top:;">
													<thead>
														<tr>
														  <!-- <th width="9%"> Sr No.   </th>
															<th width="23%"> Cost Head   </th>
															<th width="14%"> Area </th>
															<th width="15%"> Rate (in ₹) </th>
															<th width="18%"> Total Cost (in ₹)   </th>
															<th width="21%"> No of Installment</th>
														 -->
															<th width="5%" align="center"> Sr. No. </th>
															<th > Type  </th>
															<th width="15%" style="text-align:right;">Cost (In &#x20B9;)</th>
															<?php //print_r($tax_name);
															if(isset($tax_name)){
															   // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
																$key=0;
																foreach($tax_name as $row){
																echo '<th width="15%"  style="text-align:right;">'.$row->tax_type.'</th>';
															$tax_array[$key]=$row->tax_type;
															$key++;
														   } 
														   //echo '</tr></table></th>';
													   }
													   ?>
															<th width="15%" style="text-align:right;"> Net Cost (In &#x20B9;)</th>
														</tr>
													</thead>
													<tbody>
														   <?php //print_r($p_schedule);?>
															<?php 
															$j=0;
															$total_basic_cost=0;
															$total_net_amount=0;
															$total_tax_array=array();
															foreach($p_schedule as $row_tax){
																	echo '<tr>
																	<td align="center">'.($j+1).'</td>
																	<td>'.$p_schedule[$j]["event_type"].'</td>
																	
																	<td style="text-align:right;">'.format_money($p_schedule[$j]["basic_cost"],2).'</td>';
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
																$total_basic_cost=$total_basic_cost+$p_schedule[$j]["basic_cost"];

																 $next_count=0;
																	$td_count=0;
																	// print_r($p_schedule);
																	if(isset($p_schedule[$j]['tax_type'])) {
																   // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
																		//echo "<br>hi";
																	  // echo $key;
																	for($tcnt=0;$tcnt<$key;$tcnt++){
																		
																		//echo "step1--";
																	 for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++){
																		$tax_amount='';
																		if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt])
																		{
																			$tax_amount=$p_schedule[$j]['tax_amount'][$nc];
																		   $nc=count($p_schedule[$j]['tax_type']);
																		   //$tcnt=$key;
																	   //}
																		}
																	}
																	if($tax_amount !=''){
																		echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
																			$td_count++;

																	}
																		else{
																			//if($next_count )
																			echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
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

																
																echo'<td style="text-align:right;">'.format_money($p_schedule[$j]["net_amount"],2).'</td>
																	</tr>';
																	$total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
		//print_r($p_schedule[$j]['event_type']);
		$j++;


															}?>

														<tr>
															<td colspan="2"><b>Grand Total (In &#x20B9;)</b></td>
															<td style="text-align:right;"><?php echo (isset($total_basic_cost))?format_money($total_basic_cost,2):0;?></td>
															<?php  $k=0;
																if (isset($total_tax_amount)) {
																	foreach($total_tax_amount as $row){
																		echo '<td style="text-align:right;">'.format_money($total_tax_amount[$k],2).'</td>';
																		$k++;
																	}
																}
															?>
														   <td style="text-align:right;"><?php echo isset($total_net_amount)?format_money($total_net_amount,2):0;?></td>
														</tr>

														
													</tbody>
												</table>
												
												
											  </div>
											
											
											   </div>
											 <!-- info -->
											 
												<!-- <div class="row">
											<h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;"> Taxes and Others </h3>                                    
												</div> -->
										
													<!--    <div class="table-responsive">
												<table id="contacts" class="table table-bordered" style="border-top:;">
													<thead>
														<tr>
														  <th> Sr No.   </th>
															<th> Cost Head   </th>
															<th> Rate (in ₹) </th>
															<th> Total Cost (in ₹)   </th>
															<th> No of Installment</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														  <td class="Contact_name"><label> 1 </label></td>
															<td> <label>    Service Tax </label></td>
															<td> <label>  50% </label></td>
															 <td > <label>  Total Cost (in ₹) </label>   </td>
															<td > <label>  No. of Installment </label></td>
														</tr>
														
														<tr>
														  <td class="Contact_name"><label> 2 </label></td>
															<td> <label> Stamp Duty  </label></td>
															<td> <label>  50% </label></td>
															 <td > <label>  Total Cost (in ₹) </label>   </td>
															<td > <label>  No. of Installment </label></td>
														</tr>
														
														<tr>
														  <td class="Contact_name"><label> 3 </label></td>
															<td> <label> Registration        </label></td>
															<td> <label>  50% </label></td>
															 <td > <label>  Total Cost (in ₹) </label>   </td>
															<td > <label>  No. of Installment </label></td>
														</tr>
														
														<tr>
														  <td class="Contact_name"><label> 4 </label></td>
															<td> <label> VAT </label></td>
															<td> <label>  50% </label></td>
															 <td > <label>  Total Cost (in ₹) </label>   </td>
															<td > <label>  No. of Installment </label></td>
														</tr>
														
														
														
														
													</tbody>
												</table>
												
												
											  </div> -->
												
												</div>
										
											<!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5;  ">
												<h3 class="panel-title" style=""><strong>Brokerage Details </strong></h3>
											</div>
											
											<div class="panel-body">
												<div class="form-group"  style="border-top:1px dotted #ddd;  ">
													<div class="col-md-6 col-sm-6">
														<div class="">
															<label class="col-md-5 col-sm-5 control-label"><strong>Broker Name:</strong></label>
															<div class="col-md-7 col-sm-7">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php //if (set_value('brokername_name')!=null) { echo set_value('brokername_name'); } else if(isset($editbrokerage[0]->c_name)){ echo $editbrokerage[0]->c_name; } else { echo ''; }?></label>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-6">
														<div class="">
															<label class="col-md-5 col-sm-5 control-label"><strong>Remarks:</strong></label>
															<div class="col-md-7 col-sm-7">
															  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php //if(isset($editbrokerage)) { if(count($editbrokerage)>0) { echo $editbrokerage[0]->bro_remarks; }} ?></label>
															</div>
														</div>
													</div>
												</div>
											</div> -->
											

											<?php $this->load->view('templates/related_party_view');?>




											<!-- START DATATABLE -->
											<!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5;">
												<h3 class="panel-title" style="padding:0px; "><strong>Document Details</strong></h3>
										  </div>
											<div class="panel-body">
												<div class="row">
												
													<div class="table-responsive">
													<table id="contacts" class="table table-bordered">
														<thead>
															<tr>
															  <th width="19%">Document Name</th>
																<th width="16%">ID Proof</th>
																<th width="16%">Reference No.</th>
																<th width="15%">Date of Issue</th>
																<th width="20%">Date of Expiry</th>
																<th width="14%" class="th">Download</th>
															</tr>
														</thead>
														<tbody>
															<?php //if(isset($editdocs)) { 
															//for($i=0; $i<count($editdocs); $i++) {?>
															<tr>
																<td class="Contact_name"><?php //echo $editdocs[$i]->rt_doc_name; ?></td>
																<td class="Contact_name"><?php //echo $editdocs[$i]->rt_doc_description; ?></td>
																<td><?php //echo $editdocs[$i]->rt_doc_ref_no; ?></td>
																<td><?php //if($editdocs[$i]->rt_doc_doi!=null && $editdocs[$i]->rt_doc_doi!='') echo date('d/m/Y',strtotime($editdocs[$i]->rt_doc_doi)); ?></td>
																<td><?php //if($editdocs[$i]->rt_doc_doe!=null && $editdocs[$i]->rt_doc_doe!='') echo date('d/m/Y',strtotime($editdocs[$i]->rt_doc_doe)); ?></td>
																<?php //if($editdocs[$i]->rt_document_name!='' && $editdocs[$i]->rt_document_name!=null) { ?>
																	<td align="" class="td">
																		<a href="<?php //echo base_url().'downloads/rent/'.$r_id.'/'.$editdocs[$i]->rt_document_name; ?>" target="_blank" class="btn btn-primary">
																		<i class="glyphicon glyphicon-download"> </i> Download </a>
																	</td>
																<?php //} else { ?>
																	<td align="" class="td"></td>
																<?php //} ?>
															</tr>
															<?php //} } ?>
															
														</tbody>
													</table>
													
													
												  </div>
												
												</div>
											</div> -->
											<!-- END DEFAULT DATATABLE -->

											<?php $this->load->view('templates/document_view');?>

									<?php $this->load->view('templates/pending_activity_view');?>
									
										<div class="panel-heading" style="border-top:0px solid #E5E5E5; ">
											<h3 class="panel-title"><strong> Remarks</strong></h3>
										</div>
										<div class="panel-body">
											<div class="form-group print-form-group  row" style="border-top:0px dotted #ddd;">
												<label class="col-md-2 address-remark control-label"><strong>Maker Remarks:</strong></label>
												<div class="col-md-10 address-container1 remark">
													  <label class="col-md-12  remark control-label contact-view" style="text-align:left;"><?php if (isset($editrent)) { echo $editrent[0]->maker_remark; } ?></label> 
												</div>
											</div>
											<div class="form-group row print-form-group  print-border">
												<label class="col-md-2 address-remark control-label"><strong>Checker Remarks:</strong></label>
												<div class="col-md-10 address-container1 remark">
													  <label class="col-md-12  remark control-label contact-view" style="text-align:left;"><?php if (isset($editrent)) { echo $editrent[0]->remarks; } ?></label> 
												</div>
											</div>
										</div>
										
								   </div>  
                                           </div>								   
									</form>
								
									<?php if(isset($editrent)) { ?>
										<?php if($editrent[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
										  
											<form id="" method="post" action="<?php echo base_url().'index.php/Rent/updaterecord/'.$r_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
													  <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editrent[0])){ echo $editrent[0]->remarks; } else { echo ''; }?></textarea>
														</div>													 
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Rent" class="btn btn-danger">Cancel</a>
													<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
												</div> 
											</form>

										<?php } } } else if($editrent[0]->modified_by != '' && $editrent[0]->modified_by != null) { if($editrent[0]->modified_by!=$rentby) { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
										  
											<form id="" method="post" action="<?php echo base_url().'index.php/Rent/approve/'.$r_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														  <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editrent[0])){ echo $editrent[0]->remarks; } else { echo ''; }?></textarea>
														</div>														  
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Rent" class="btn btn-danger">Cancel</a>
													<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
													<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
												</div> 
											</form>

										<?php } } } } else { ?>

											<form id="" method="post" action="<?php echo base_url().'index.php/Rent/updaterecord/'.$r_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														  <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editrent[0])){ echo $editrent[0]->remarks; } else { echo ''; }?></textarea>
														</div>														 
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Rent" class="btn btn-danger">Cancel</a>
													<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
												</div> 
											</form>

										<?php } } else if($editrent[0]->created_by != '' && $editrent[0]->created_by != null) { if($editrent[0]->created_by!=$rentby && $editrent[0]->txn_status != 'In Process') { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
										  
										<form id="" method="post" action="<?php echo base_url().'index.php/Rent/approve/'.$r_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
													  <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editrent[0])){ echo $editrent[0]->remarks; } else { echo ''; }?></textarea>
														</div>														 
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Rent" class="btn btn-danger">Cancel</a>
													<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
													<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
												</div> 
											</form>

										<?php } } } } else { ?>
											
											<form id="" method="post" action="<?php echo base_url().'index.php/Rent/updaterecord/'.$r_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
													   <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($editrent[0])){ echo $editrent[0]->remarks; } else { echo ''; }?></textarea>
														</div>														
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Rent" class="btn btn-danger">Cancel</a>
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
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;} table tr th:first-child{width:10%;} table tr th:last-child{width:20%;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:55%;}.print-related{ width:33.3%;}.col-md-6 {width:50%;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>