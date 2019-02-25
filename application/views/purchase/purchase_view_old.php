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
		<link rel="stylesheet" href="<?php echo base_url(); ?>zoom/css/smoothproducts.css">
		
		<style type="text/css">
        .panel { box-shadow:none; border:1px dotted #ddd!important;  }
        .address-remark{width:12.9%;}
        .address-container1{width:87.1%; display:flex;}       
        .page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;   }
        .dataTables_filter { border-bottom:0!important; }
        .heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600;   margin-top: 61px; /*padding-bottom: 0;*/      border-bottom: 1px solid #ddd;}


        .panel .panel-title strong { font-weight:100; font-size: 20px;}
        .form-horizontal .control-label {  /* padding:0;*/}
        .table{ margin-bottom:0;}
        .property-name { line-height:32px; font-weight:100;}
        #map { width:100%;}
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
            <!-- START PAGE CONTAINER -->
          <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">                  
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Purchase'; ?>" > Purchase List</a>  &nbsp; &#10095; &nbsp;    Purchase View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				         <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>   <a  class="btn-margin" href="<?php echo base_url().'index.php/Purchase/edit/'.$p_id; ?>"> 
						 <span class="btn btn-success pull-right btn-font"> Edit </span> </a>  <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/Purchase" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
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
                            <form id="jvalidate" role="form" class="form-horizontal" action="">
                                   
                                   <div id="pdiv" >    
                                    <div class="row" style="padding:10px 0;">
                                    <div class="col-md-3 col-sm-6 print-left">
                                        <div class="slide-img">
                                            <div class="sp-loading"><img src="<?php echo base_url()?>zoom/images/sp-loading.gif" alt=""><br>LOADING IMAGES</div>
                                                <div class="sp-wrap">
                                                    <?php if(isset($p_description_img)) { for($i=0;$i<count($p_description_img);$i++) { ?>
                                                        <a href="<?php echo base_url() . $p_description_img[$i]->file_path ?>"><img src="<?php echo base_url() . $p_description_img[$i]->file_path ?>" alt="" style="width:100%"></a>
                                                    <?php } } ?>
                                                    
                                                </div>
                                             
                                        </div>
                                            <!--src="<?php //if(isset($p_txn)) { echo $p_txn[0]->p_googlemaplink; } ?>"-->
    									<iframe id="map" style="border:none">
										
										</iframe>
                                    </div>
                                    
                                    <div class="col-md-9 col-sm-6 print-right"  >                           
                                    
                                        <div class="">
                                        <div class="row">
                                        <div class="col-md-12  ">                                                                      
                                        <div class="">
                                        <label class=" contact-view property-name print-heading " ><?php if(isset($p_txn)) { echo $p_txn[0]->p_display_name; } ?></label> <br>
                                        <span class="address" > <?php if(isset($p_txn)) { echo $p_txn[0]->p_property_name; } ?> </span>
                                        </div>  
                                        
                                        </div>
                                        </div> 
                                        
                                        <div class="row">
                                        <div class="col-md-12  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name  " > Address Details: </label> 
                                       	<p class="address-text" > <?php if(isset($p_txn)) { echo $p_txn[0]->p_apartment . ' ' . $p_txn[0]->p_flatno . ' ' . $p_txn[0]->p_floor . ' ' . $p_txn[0]->p_wing . ' ' . $p_txn[0]->p_address . ' ' . $p_txn[0]->p_landmark . ' ' . $p_txn[0]->p_state . ' ' . $p_txn[0]->p_city . ' ' . $p_txn[0]->p_pincode . ' ' . $p_txn[0]->p_country; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        <div class="col-md-12  ">       
                                        
                                        <hr>
                                         </div>
                                        
                                        <div class="row">
                                         <div class="col-md-12">                                              
                                        <div class="">
                                          <div class="col-md-3">
                                        	<label class="control-label contact-view address-name1  " > Sellable Area: </label>
                                        </div>  
                                        <div class="col-md-9 ">
                                       	<p class="address-text1" > <?php if(isset($p_description)) { echo format_money($p_description[0]->pr_sellable_area,2) . ' ' . $p_description[0]->pr_sellable_unit; } ?> </p>
                                        </div>
                                        </div>
                                         </div>
                                        </div>
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Purchase Date: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text1" ><?php if(isset($p_txn)) { echo ($p_txn[0]->p_purchase_date!=null && $p_txn[0]->p_purchase_date!='')?date('d/m/Y',strtotime($p_txn[0]->p_purchase_date)):''; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div>
                                           
                                        
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Property Type: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text1" ><?php if(isset($p_txn)) { echo $p_txn[0]->p_type; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div> 
                                        
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Property Status: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text1" > <?php if(isset($p_txn)) { echo $p_txn[0]->p_status; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Seller Name: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text1" ><?php if(isset($p_txn)) { echo $p_txn[0]->seller_name; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Property Usage: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text1" > <?php if(isset($p_txn)) { echo $p_txn[0]->p_usage; } ?>   </p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="row">
                                         <div class="col-md-12  "> 
                                      
                                      	  <div class="col-md-3  ">                                                                      
                                        <div class="">
                                        <label class="control-label contact-view address-name1  " > Property Description: </label>
                                        </div>  
                                        </div>
                                         <div class="col-md-9  ">                                                                      
                                        <div class="">
                                      
                                       	<p class="address-text2"  ><?php if(isset($p_txn)) { echo $p_txn[0]->p_propertydescription; } ?></p>
                                        </div>  
                                        
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    </div>
                                    </div>
                                    <!-- <br clear="all"> -->
                                    <!-- START DATATABLE -->
								<div class="panel-heading clear-all" style="border-top:1px solid #E5E5E5;  ">
									<h3 class="panel-title" style="padding:0;"><strong>Ownership</strong></h3>
								</div>
								<div class="panel-body">
									<div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered table-active">
											<thead>
												<tr>
												  <th width="34%"> Owner Name</th>
													<th width="30%" style="text-align:right;">% of Ownership</th>
													<th width="36%"  style="text-align:right;">Allocated Cost  (In &#x20B9;)</th>
												</tr>
											</thead>
											<tbody>
                                                <?php if(isset($p_ownership)) { for($i=0;$i<count($p_ownership);$i++) { ?>
												<tr>
												  <td class="Contact_name"><?php if(isset($p_ownership)) { echo $p_ownership[$i]->c_name; } ?></td>
													<td style="text-align:right;"><?php if(isset($p_ownership)) { echo format_money($p_ownership[$i]->pr_ownership_percent,2); } ?></td>
													<td style="text-align:right;"><?php if(isset($p_ownership)) { echo format_money($p_ownership[$i]->pr_ownership_allocatedcost,2); } ?></td>
												</tr>
												<?php } } ?>
											</tbody>
										</table>
										
										
									  </div>
									
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->
                                
                                 

                                   
                                    
                                     <div class="panel-heading propinfo" style="border-top:1px solid #E5E5E5;  ">
									<h3 class="panel-title" style="padding:0px; "><strong> Additional Property Information
 </strong></h3>
								</div>
                             	 <div class="panel-body">
											  <div class="form-group" style="border-top:0px dotted #ddd;">
                                    <div class="col-md-6 col-sm-6" style="display: none;">
                                    <div class="">
                                    <label class="col-md-4 position-name col-sm-5 control-label"><strong>Description: </strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_description; } ?>  </label>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="">
                                    <label class="col-md-4 col-sm-5 position-name control-label"><strong>Agreement Area:</strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class=" control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo format_money($p_description[0]->pr_agreement_area,2); } ?> </label>  <label class=" control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_agreement_unit; } ?> </label>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type=='Land-Agriculture' || $p_txn[0]->p_type=='Land-NonAgriculture') { ?>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="">
                                    <label class="col-md-4 position-name col-sm-5 control-label"><strong>Land Area:</strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class="col-md-5 control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) { echo format_money($p_description[0]->pr_land_area,2); } ?> </label>  <label class="col-md-4 control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_land_unit; } ?> </label>
                                    </div>
                                    </div>
                                    </div>
									<?php } } ?>
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type!='Land-Agriculture' && $p_txn[0]->p_type!='Land-NonAgriculture') { ?>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="">
                                    <label class="col-md-4 position-name col-sm-5 control-label"><strong>Carpet Area:</strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) { echo format_money($p_description[0]->pr_carpet_area,2); } ?> </label>  <label class="control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_carpet_unit; } ?> </label>
                                    </div>
                                    </div>
                                    </div>
									<?php } } ?>
                                    </div>
                                    <div class="form-group">
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type!='Land-Agriculture' && $p_txn[0]->p_type!='Land-NonAgriculture') { ?>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="">
                                    <label class="col-md-4 position-name col-sm-5 control-label"><strong>Built Up Area:</strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) { echo format_money($p_description[0]->pr_builtup_area,2); } ?> </label>  <label class="control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_builtup_unit; } ?> </label>
                                    </div>
                                    </div>
                                    </div>
									<?php } } ?>
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type=='Bunglow') { ?>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="">
                                    <label class="col-md-4 position-name col-sm-5 control-label"><strong>Bunglow Area:</strong></label>
                                    <div class="col-md-8 position-view  col-sm-7">
                                    <label class="control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo format_money($p_description[0]->pr_bunglow_area,2); } ?> </label>  <label class=" control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_bunglow_unit; } ?> </label>
                                    </div>
                                    </div>
                                    </div>
									<?php } } ?>
                                    </div>
									<div class="form-group">
									<div class="col-md-6 building_area">
									<div class="">
										<label class="col-md-4 position-name col-sm-5 control-label"><strong>Saleable Area:</strong></label>
										<div class="col-md-8 position-view  col-sm-7">
											<label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) { if(count($p_description)>0) { echo format_money($p_description[0]->pr_sellable_area,2); } }?></label> <label class=" control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo $p_description[0]->pr_sellable_unit; } ?> </label>
										</div>
									</div>
									</div>
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type=='Building') { ?>
									<div class="col-md-6 building_area">
									<div class="">
										<label class="col-md-4 position-name col-sm-5 control-label"><strong>No Of Floors:</strong></label>
										<div class="col-md-8 position-view  col-sm-7">
											<label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_floors,2); }} ?></label>
										</div>
									</div>
									</div>
									<?php } } ?>
									</div>
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type=='Building') { ?>
									<div class="form-group">
									<div class="col-md-6 building_area">
									<div class="">
										<label class="col-md-4 position-name col-sm-5 control-label"><strong>No Of Flats:</strong></label>
										<div class="col-md-8 position-view  col-sm-7">
											<label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_flats,2); }} ?></label>
										</div>
									</div>
									</div>
									<div class="col-md-6 building_area">
									<div class="">
										<label class="col-md-4 position-name col-sm-5 control-label"><strong>No Of Shops:</strong></label>
										<div class="col-md-8 position-view  col-sm-7">
											<label class="control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) {if(count($p_description)>0) {  echo format_money($p_description[0]->pr_no_of_shops,2); }} ?></label>
										</div>
									</div>
									</div>
									</div>
									<?php } } ?>
									<?php if(isset($p_txn)) { if ($p_txn[0]->p_type!='Land-Agriculture' && $p_txn[0]->p_type!='Land-NonAgriculture') { ?>
                                    <div class="form-group print-border-parking">
                                    <div class="">
                                    <div class="col-md-6 col-sm-6 print-Parking">
                                    <div class="Parking">
                                    <label class="col-md-4 position-name-1 col-sm-5 control-label"><strong>No of Open Parking:</strong></label>
                                    <div class="col-md-8 position-view-1 col-sm-7">
                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($p_description)) { echo format_money($p_description[0]->pr_open_parking,2); } ?>  </label>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 print-Parking">
                                    <div class="Parking">
                                    <label class="col-md-4  position-name-1 col-sm-5 control-label"><strong>No Of Covered Parking:</strong></label>
                                    <div class="col-md-8 position-view-1 col-sm-7">
                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($p_description)) { echo format_money($p_description[0]->pr_covered_parking,2); } ?> </label>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                   
                                    </div>
                                    <?php } } ?>
                                    
                                
                                
                                
							 </div>
                                    
                                     <div class="panel-heading" style="border-top:1px solid #E5E5E5; margin-top:10px;  ">
									<h3 class="panel-title" style="padding:0px; "><strong>Purchase Consideration</strong></h3>
								</div>
                       
                             		 <div class="panel-body">
                                     <div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered" style="border-top:;">
											<thead>
												<tr>
												  <!-- <th width="9%"> Sr. No.	</th>
													<th width="23%"> Cost Head	 </th>
													<th width="14%"> Area </th>
													<th width="15%"> Rate (in ₹) </th>
                                                    <th width="18%"> Total Cost (in ₹)	 </th>
													<th width="21%"> No of Installment</th>
												 -->
                                                    <th  width="80" align="center" style="text-align:center"> Sr. No. </th>
                                                    <th width="20%" > Type  </th>
                                                    <th   style="text-align:right;">Cost  (In &#x20B9;)</th>
                                                    <?php //print_r($tax_name);
                                                    if(isset($tax_name)){
                                                        // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
                                                        $key=0;
                                                        foreach($tax_name as $row){
                                                            echo '<th  style="text-align:right; text-transform: capitalize;">'.$row->tax_type.'</th>';
                                                            $tax_array[$key]=$row->tax_type;
                                                            $key++;
                                                        } 
                                                        //echo '</tr></table></th>';
                                                    }
                                                    ?>
                                                    <th   style="text-align:right;" > Net Cost  (In &#x20B9;)</th>
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
                                                    <td colspan="2"><b>Grand Total  (In &#x20B9;)</b></td>
                                                    <td style="text-align:right;"><?php echo (isset($total_basic_cost))?format_money($total_basic_cost,2):0;?></td>
                                                    <?php
                                                        if (isset($total_tax_amount)) {
                                                            foreach($total_tax_amount as $row){
                                                                echo '<td style="text-align:right;">'.format_money($row,2).'</td>';
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
								
											<!-- 	<div class="table-responsive">
										<table id="contacts" class="table table-bordered" style="border-top:;">
											<thead>
												<tr>
												  <th> Sr No.	</th>
													<th> Cost Head	 </th>
													<th> Rate (in ₹) </th>
                                                    <th> Total Cost (in ₹)	 </th>
													<th> No of Installment</th>
												</tr>
											</thead>
											<tbody>
												<tr>
												  <td class="Contact_name"><label> 1 </label></td>
													<td> <label> 	Service Tax </label></td>
													<td> <label>  50% </label></td>
                                                     <td > <label>  Total Cost (in ₹) </label>	 </td>
													<td > <label>  No. of Installment </label></td>
												</tr>
                                                
                                                <tr>
												  <td class="Contact_name"><label> 2 </label></td>
													<td> <label> Stamp Duty	 </label></td>
													<td> <label>  50% </label></td>
                                                     <td > <label>  Total Cost (in ₹) </label>	 </td>
													<td > <label>  No. of Installment </label></td>
												</tr>
                                                
                                                <tr>
												  <td class="Contact_name"><label> 3 </label></td>
													<td> <label> Registration    	 </label></td>
													<td> <label>  50% </label></td>
                                                     <td > <label>  Total Cost (in ₹) </label>	 </td>
													<td > <label>  No. of Installment </label></td>
												</tr>
                                                
                                                <tr>
												  <td class="Contact_name"><label> 4 </label></td>
													<td> <label> VAT </label></td>
													<td> <label>  50% </label></td>
                                                     <td > <label>  Total Cost (in ₹) </label>	 </td>
													<td > <label>  No. of Installment </label></td>
												</tr>
                                                
                                                
												
												
											</tbody>
										</table>
										
										
									  </div> -->
										
                                        </div>
                                      
                                 	
                                
                                
                                <!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5; padding:5px;  ">
									<h3 class="panel-title" style="padding:0px; "><strong>Broker Details </strong></h3>
								</div>
                                <div class="panel-body">
									<div class="form-group" style="border-top:1px dotted #ddd;">
										<div class="col-md-6 col-sm-6">
											<div class="">
												<label class="col-md-4 col-sm-5 control-label"><strong>Broker Name:</strong></label>
												<div class="col-md-8 col-sm-7">
												  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php //if(isset($p_brokerage)) { echo $p_brokerage[0]->c_name; } ?>   </label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="">
												<label class="col-md-4 col-sm-5 control-label"><strong> Remarks:</strong></label>
												<div class="col-md-8 col-sm-7">
												  <label class="col-md-12 control-label contact-view" style="text-align:left;">  <?php //if(isset($p_brokerage)) { echo $p_brokerage[0]->bro_remarks; } ?>  </label>
												</div>
											</div>
										</div>
									</div>
                                </div> -->


                                <!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5; padding:5px; ">
                                    <h3 class="panel-title" style="padding:0;"><strong>Related Party Details</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                        <table id="contacts" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                  <th> Related Party Name </th>
                                                    <th> Remarks </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php //if(isset($p_rp)) { for($i=0;$i<count($p_rp);$i++) { ?>
                                                <tr>
                                                    <td class="Contact_name"><?php //if(isset($p_rp)) { echo $p_rp[$i]->c_name; } ?></td>
                                                    <td style="text-align:right;"><?php //if(isset($p_rp)) { echo $p_rp[$i]->rp_remarks; } ?></td>
                                                </tr>
                                                <?php //} } ?>
                                            </tbody>
                                        </table>
                                      </div>
                                    </div>
                                </div> -->

                                <?php $this->load->view('templates/related_party_view');?>


                                <!-- START DATATABLE -->
								<!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5; padding:5px;  ">
									<h3 class="panel-title" style="padding:0px; "><strong>Document Details</strong></h3>
							  </div>
								<div class="panel-body">
									<div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered">
											<thead>
												<tr>
												  <th width="19%">Document Name</th>
													<th width="16%">Description</th>
													<th width="16%">Reference No.</th>
													<th width="15%">Date of Issue</th>
													<th width="20%">Date of Expiry</th>
													<th width="14%" class="th">Download</th>
												</tr>
											</thead>
											<tbody>
                                                <?php //if(isset($p_docs)) { for($i=0;$i<count($p_docs);$i++) { ?>
												<tr>

												  <td class="Contact_name"><?php //if(isset($p_docs)) { echo $p_docs[$i]->pr_doc_name; } ?></td>
													<td class="Contact_name"><?php //if(isset($p_docs)) { echo $p_docs[$i]->pr_doc_description; } ?></td>
													<td><?php //if(isset($p_docs)) { echo $p_docs[$i]->pr_doc_ref_no; } ?></td>
													<td><?php //echo ($p_docs[$i]->pr_doc_doi!=null && $p_docs[$i]->pr_doc_doi!='')?date('d/m/Y',strtotime($p_docs[$i]->pr_doc_doi)):''; ?></td>
													<td><?php //echo ($p_docs[$i]->pr_doc_doe!=null && $p_docs[$i]->pr_doc_doe!='')?date('d/m/Y',strtotime($p_docs[$i]->pr_doc_doe)):''; ?></td>
													<?php //if($p_docs[$i]->pr_document!='' && $p_docs[$i]->pr_document!=null) { ?>
                                                        <td align="" class="td">
                                                            <a  class="btn btn-primary" href="<?php //if(isset($p_docs)) { echo base_url() . $p_docs[$i]->pr_document; } ?>" target="_blank"><i class="glyphicon glyphicon-download"> </i> Download</a> 
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

                                <?php $this->load->view('templates/document_view');?> <br>


                                <?php $this->load->view('templates/pending_activity_view');?>

                                <div class="panel-heading" style="border-top:1px solid #E5E5E5;  margin-top:10px; ">
                                    <h3 class="panel-title"><strong> Remarks</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group " style="border-top:0px dotted #ddd;">
									   <div class="col-md-12">
                                        <label class="col-md-1 print-width control-label"><strong>Maker Remarks:</strong></label>
                                        <div class="col-md-11 remark">
                                            <label class="col-md-12 remark control-label" style="text-align:left;"><?php if (isset($p_txn)) { echo $p_txn[0]->maker_remark; } ?></label> 
                                        </div>
									 </div>
                                    </div>
                                    <div class="form-group print-border">
									  <div class="col-md-12">
                                        <label class="col-md-1 print-width control-label"><strong>Checker Remarks:</strong></label>
                                        <div class="col-md-11 remark">
                                            <label class="col-md-12 remark control-label" style="text-align:left;"><?php if (isset($p_txn)) { echo $p_txn[0]->remarks; } ?></label> 
                                        </div>
									</div>
                                    </div>
                                </div>
  </div>

                                </form>
								<!-- END DEFAULT DATATABLE -->

                                <?php if(isset($p_txn)) { ?>
                                <?php if($p_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                                  
                                    <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Purchase/updaterecord/'.$p_id; ?>">
                                        <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
											  <div class="col-md-12">
                                                <label class="col-md-1 control-label"><strong>Remarks:</strong></label>
                                                <div class="col-md-11">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($p_txn[0])){ echo $p_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
												 </div>
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Purchase" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" />
                                        </div> 
                                    </form>

                                <?php } } } else if($p_txn[0]->modified_by != '' && $p_txn[0]->modified_by != null) { if($p_txn[0]->modified_by!=$purchaseby) { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                  
                                    <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Purchase/approve/'.$p_id; ?>">
                                         <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
											 <div class="col-md-12">
                                                <label class="col-md-1 control-label"><strong>Remarks:</strong></label>
                                                <div class="col-md-11">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($p_txn[0])){ echo $p_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
											</div>
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Purchase" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                        </div> 
                                    </form>

                                <?php } } } } else { ?>

                                    <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Purchase/updaterecord/'.$p_id; ?>">
                                       <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
											 <div class="col-md-12">
                                                <label class="col-md-1 control-label"><strong>Remarks:</strong></label>
                                                <div class="col-md-11">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($p_txn[0])){ echo $p_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
											 </div>
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Purchase" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" />
                                        </div> 
                                    </form>

                                <?php } } else if($p_txn[0]->created_by != '' && $p_txn[0]->created_by != null) { if($p_txn[0]->created_by!=$purchaseby && $p_txn[0]->txn_status != 'In Process') { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                  
                                    <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Purchase/approve/'.$p_id; ?>">
                                        <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
										   <div class="col-md-12">
                                                <label class="col-md-1 control-label"><strong>Remarks:</strong></label>
                                                <div class="col-md-11">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($p_txn[0])){ echo $p_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
											  </div>
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Purchase" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                        </div> 
                                    </form>

                                <?php } } } } else { ?>
                                    
                                    <form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Purchase/updaterecord/'.$p_id; ?>">
                                      <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
										 <div class="col-md-12">
                                                <label class="col-md-1 control-label"><strong>Remarks:</strong></label>
                                                <div class="col-md-11">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($p_txn[0])){ echo $p_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
											</div>
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Purchase" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete"  onclick="return confirm('Are you sure you want to delete this item?');"/>
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

        <!-- START TEMPLATE -->
        
		
      
	<script type="text/javascript" src="<?php echo base_url(); ?>zoom/js/smoothproducts.min.js"></script>
	<script type="text/javascript">
	/* wait for images to load */
	$(window).load(function() {
		$('.sp-wrap').smoothproducts();
	});
	</script>

    <script  type="text/javascript">
        jQuery(
          function($)
          {
               var q=encodeURIComponent('<?php if(isset($p_txn)) { echo $p_txn[0]->p_googlemaplink; } ?>');
               $('#map')
                .attr('src',
                     'https://www.google.com/maps/embed/v1/place?key=AIzaSyCNy33uOQrIGSIdqfn_4MzP0AKOy2DR1o4&q='+q);

          }
        );
</script>
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

                newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group  .col-md-4 { float:left;} .position-name-1 { width:25%;}.col-md-6 {width:50%;}.print-heading { font-size:30px; font-weight:200display:block; margin-top:30px; margin-bottom: -30px;} .print-Parking {    width: 100%;  padding:5px 10px;      display:inline-block;  }.Parking {display:flex; width:100%;}.print-left{ display: flex;} .sp-wrap{width:250px;     margin-right: 50px;}.print-left img{max-width:250px; width:250px; max-height:250px;}.print-right .col-md-3 .control-label{ width:24%;} .address-text2 {width: 100%; float: left; padding:0;margin-top:0;} .print-border-parking { border-bottom:1px solid #ddd!important; padding:10px 0; display:block;}.col-md-1{ width:3%;} .col-md-11{ width:96%;}.print-width { width:100%;} th{ background:#f1f5f9 !important; }  tr:nth-child(odd) { background-color: #fcfdfd; } tr:nth-child(even) { background-color: #fff; } .propinfo { margin-top: 500px;padding-top:20px; }</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>