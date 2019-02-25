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
 
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
 .panel.panel-primary {   border-top:2px solid #33414e!important; }
 textarea.form-control { overflow:hidden; min-height:80px;}
 .Documents-section .col-md-3, .col-md-4, .col-md-6, col-md-9{ padding:0 3px!important;}
 .pending-group {    padding-right: 15px!important;}
 #panel-pending-activity .form-group{ padding-right:10px;}
 
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
    <body onload="loadsubproperties();">								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                 <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Loan'; ?>" > Loan List</a>  &nbsp; &#10095; &nbsp; Loan Details </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	 <div class="main-container">           
                           <div class="box-shadow custom-padding"> 
                           
                            <form id="form_loan" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($editloan)) { echo base_url().'index.php/Loan/updaterecord/'.$l_id;} else { echo base_url().'index.php/Loan/saverecord'; } ?>">

							<div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
                                   <div class="panel-body  box-padding faq">
                                 	<div class="panel-body panel-group accordion">

                          
                                    
                                    <input type="hidden" id="l_id" name="l_id" value="<?php if(isset($editloan)) echo $l_id; ?>" />
                                
                								
                                <div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>


                                <div class="panel  panel-primary" id="panel-ownership">
                                    <a href="#accOneColOne">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>  Owner Details </h4>
                                        </div>   
                                    </a>  
                                    <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                        <div class="repeatowner">
                                            <?php if(isset($editborower)) { 
                                            for ($j=0; $j < count($editborower) ; $j++) { 
                                            ?>

                                            <div class="form-group" id="repeat_owner_<?php echo $j+1;?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;';?>">

                                                <div class="col-md-6">
                                                    <div class="">
                                                        <label class="col-md-5 control-label" ><?php if($j==0) echo 'Name Of Applicant <span class="asterisk_sign">*</span>'; else echo 'Name Of Co Applicant <span class="asterisk_sign">*</span>';?></label>
                                                        <div class="col-md-7">
                                                            <input type="hidden" id="borrower_<?php echo $j+1;?>_id" name="borrower[]" class="form-control" value="<?php if(isset($editborower[$j]->brower_id)){ echo $editborower[$j]->brower_id; } else { echo ''; }?>" />
                                                            <input type="text" id="borrower_<?php echo $j+1;?>" name="borrower_name[]" class="form-control auto_owner ownership" value="<?php if(isset($editborower[$j]->c_name)){ echo $editborower[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } } else { ?>

                                            <div class="form-group" id="repeat_owner_1" style="border-top: 1px dotted #ddd;">

                                                <div class="col-md-6">
                                                    <div class="">
                                                        <label class="col-md-5 control-label" style="padding-left: 0;">Name Of Applicant <span class="asterisk_sign">*</span></label>
                                                        <div class="col-md-7">
                                                            <input type="hidden" id="borrower_1_id" name="borrower[]" class="form-control" />
                                                            <input type="text" id="borrower_1" name="borrower_name[]" class="form-control auto_owner ownership" placeholder="Type to choose owner from database..." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <div class="">
                                            <div class="btn-margin">
                                                <button class="btn btn-success pull-left repeat-owner" >+</button>
                                                <button type="button" class="btn btn-success reverse-owner" style="margin-left: 10px;">-</button>
                                                <a href="#accOneColTwo" > <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel  panel-primary" id="panel-loan-details"> 
                                    <a href="#accOneColTwo">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Loan Details    </h4>
                                        </div>  
                                    </a>  
                                    <div class="panel-body" id="accOneColTwo">
                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label">Loan Ref Id <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" id="ref_id" name="ref_id" placeholder="Loan Ref Id" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label">Loan Ref Name</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="ref_name" placeholder="Loan Ref Name" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Loan Type <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" id="loan_type" name="loan_type">
                                                            <option value="">Select</option>
                                                            <option value="LAP" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='LAP') { echo "selected";} } ?>> LAP </option>
                                                            <option value="Overdraft" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Overdraft') { echo "selected";} }?>> Overdraft </option>
                                                            <option value="Normal" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Normal') { echo "selected";} } ?>> Normal </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Amount <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control format_number" name="amount" id="amount" placeholder="Amount" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" style="padding-left: 0;" > Loan Start Date <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control datepicker" name="loan_start_date" id="loan_start_date" placeholder="Loan Start Date" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" style="padding-left: 0;" > Loan Due Day <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="loan_due_day" id="loan_due_day">
                                                            <option value="">Select</option>
                                                            <?php if(isset($editloan) && count($editloan)>0) {
                                                                    for($i=1; $i<=31; $i++) { 
                                                                        if($editloan[0]->loan_due_day==$i) echo '<option selected>'.$i.'</option>'; 
                                                                        else echo '<option>'.$i.'</option>';}} 
                                                            else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
                                                        </select>
                                                        <!-- <input type="text" class="form-control" name="loan_due_day" id="loan_due_day" placeholder="Loan Due Day" value="<?php //if(isset($editloan)) { echo $editloan[0]->loan_due_day;} ?>"> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="">                                        
                                                    <label class="col-md-5 control-label"> Term (In months) <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control format_number" name="term" id="term" placeholder="Term" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Interest Type <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">                                                                  
                                                        <select class="form-control" name="interest_type">
                                                            <option value="">Select</option>
                                                            <option value="Fixed" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Fixed') { echo "selected";} } ?>> Fixed </option>
                                                            <option value="Float" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Float') { echo "selected";} }?>> Float </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="">
                                                    <label class="col-md-5 control-label" > Interest Rate (In %) <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="interest_rate" placeholder="Interest Rate" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <div class="">                                        
                                                    <label class="col-md-2 control-label">Financial Institution <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="financial_institution" placeholder="Financial Institution" value="<?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <div class="">                                        
                                                    <label class="col-md-2 control-label"> Repayment </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="repayment" placeholder="Repayment" value="<?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <div class="">                                        
                                                    <label class="col-md-2 control-label">Purpose</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="purpose" placeholder="Purpose" value="<?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     
                                            <div class="col-md-12 btn-margin">
                                                <a href="#accOneColFour" id="next_panel"><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
                                            </div>
                                      
                                    </div>
                                </div>
                                
                                <div class="panel  panel-primary" id="panel-security" <?php //if(isset($editloan)) { if($editloan[0]->loan_type!='LAP') echo 'style="display: none;"'; } else echo 'style="display: none;"'; ?>> 
                                    <a href="#accOneColFour">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Security  </h4>
                                        </div>  
                                    </a>
                                    <div class="panel-body" id="accOneColFour">
                                        <div class="repeatproperty">
                                        <?php if(isset($editproperty)) { 
                                            for ($j=0; $j < count($editproperty) ; $j++) { 
                                            ?>

                                            <div class="form-group property" id="repeat_property_<?php echo $j+1;?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;';?>">

                                                <div class="col-md-6">
                                                    <div class="">
                                                        <label class="col-md-4 control-label"> Name </label>
                                                        <div class="col-md-8">
                                                          

                                                            <input type="hidden" id="loan_property_id_<?php echo $j+1;?>" name="loan_property_id[]" value="<?php if(isset($editproperty[$j])) echo $editproperty[$j]->id; ?>" />
                                                            <input type="hidden" id="property_<?php echo $j+1;?>_id" name="property_id[]" class="form-control" value="<?php if(isset($editproperty[$j]->property_id)){ echo $editproperty[$j]->property_id; } else { echo ''; }?>" />
                                                            <input type="text" id="property_<?php echo $j+1;?>" name="property[]" class="form-control auto_property" value="<?php if(isset($editproperty[$j]->p_property_name)) {if($editproperty[$j]->p_property_name!="") echo $editproperty[$j]->p_property_name; else echo $editproperty[$j]->property;} else echo $editproperty[$j]->property; ?>" placeholder="Type to choose property from database..." />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="sub_property_div_<?php echo $j+1;?>" style="display: none;">
                                                    <div class="">
                                                        <label class="col-md-4 control-label">  Sub Property </label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="sub_property[]" id="sub_property_<?php echo $j+1;?>">
                                                                <option value="0">Select Sub Property</option>                                          
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } } else { ?>

                                            <div class="form-group property" id="repeat_property_1" style="border-top: 1px dotted #ddd;">

                                                <div class="col-md-6">
                                                    <div class="">
                                                        <label class="col-md-4 control-label"> Name </label>
                                                        <div class="col-md-8">
                                                          

                                                            <input type="hidden" id="loan_property_id_1" name="loan_property_id[]" value="" //>
                                                            <input type="hidden" id="property_1_id" name="property_id[]" class="form-control" value="" />
                                                            <input type="text" id="property_1" name="property[]" class="form-control auto_property" value="" placeholder="Type to choose property from database..." />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="sub_property_div_1" style="display: none;">
                                                    <div class="">
                                                        <label class="col-md-4 control-label">  Sub Property </label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="sub_property[]" id="sub_property_1">
                                                                <option value="0">Select Sub Property</option>                                          
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                       

                                    
                                            <div class="  btn-margin">
                                                <button class="btn btn-success repeat-property" >+</button>
                                                <button type="button" class="btn btn-success reverse-property" style="margin-left: 10px;">-</button>
                                                <a href="#accOneColFive" > <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
                                            </div>
                                      

                                    </div>
                                </div>

                                <div class="panel  panel-primary" id="panel-documents" style="margin-bottom:5px;"> 
            					   <a href="#accOneColFive">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Documents  </h4>
                                        </div>  
                                    </a>  
                					<div class="panel-body" id="accOneColFive">
                						<div id="adddoc">
                							<!-- <?php //if(isset($editdocs)) { 
                                            //for($i=0; $i<count($editdocs); $i++) {?>
                                                <div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="doc_name[]" placeholder=""  value="<?php //echo $editdocs[$i]->ln_doc_name; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="doc_desc[]" placeholder=""  value="<?php //echo $editdocs[$i]->ln_doc_description; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value="<?php //echo $editdocs[$i]->ln_doc_ref_no; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value="<?php //echo $editdocs[$i]->ln_doc_doi; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php //echo $editdocs[$i]->ln_doc_doe; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-8">
                                                                <input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
                                                                <div id="doc_<?php //echo $i; ?>_error"></div>
                                                                <?php //if($editdocs[$i]->ln_document!= '') { ?><a target="_blank" href="<?php //echo base_url().'downloads/loan/'.$l_id.'/'.$editdocs[$i]->ln_document_name; ?>">Download</a><?php //} ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php //}} else { 
                                            //for($i=0; $i<count($docs); $i++) {?>
                                                <div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="doc_name[]" placeholder=""  value="<?php //echo $docs[$i]->d_documentname; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="doc_desc[]" placeholder=""  value="<?php //echo $docs[$i]->d_description; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="">
                                                            <div class="col-md-8">
                                                                <input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
                                                                <div id="doc_<?php //echo $i; ?>_error"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php //}} ?> -->

                                                <?php $this->load->view('templates/document');?>
                						</div>

                						<div class="">
                							<div class="btn-margin">
            								    

                                                <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                           
                                                <a href="#accOneColSeven" >
                                                    <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                </a>
                							 </div>
                					 
                                        
            						</div>
            				    </div>
                                </div>
                                <?php $this->load->view('templates/pending_activity');?>

                                <div class="panel panel-primary" id="panel-remark" style="display:block;">
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
                                                    <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($editloan)){ echo $editloan[0]->maker_remark;}?></textarea>
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
                                    <a href="<?php echo base_url(); ?>index.php/loan" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                                </div>
                            </form>
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
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>


        <script>
            /**
            *getOwner list autocomplete
            **/
            var autocomp_opt_property={
                source: BASE_URL+'index.php/loan/loadproperty',
                focus: function(event, ui) {
                        // prevent autocomplete from updating the textbox
                        event.preventDefault();
                        // manually update the textbox
                        $(this).val(ui.item.label);
                },
                select: function(event, ui) {
                        // prevent autocomplete from updating the textbox
                        event.preventDefault();
                        // manually update the textbox and hidden field
                        $(this).val(ui.item.label);
                        var id = this.id;
                        $("#" + id + "_id").val(ui.item.value);
                },
                change: function(event, ui) {
                        var id = this.id;
                        $("#" + id + "_id").val('');
                        var con_name = $(this).val();
                        // $(this).val('');

                        if (con_name!="" && con_name!=null) {
                          $.ajax({
                            method:"GET",
                            url:BASE_URL+'index.php/loan/loadproperty',
                            data:{term : con_name},
                            dataType:"json",
                            success:function(responsdata){
                              $("#"+id).val(responsdata[0].label);
                              $("#" + id + "_id").val(responsdata[0].value);
                              loadsubproperty($("#" + id));
                            }   
                          });
                        }
                },
                minLength: 1
            };

            $(function() {
              //autocomplete
              $(".auto_property").autocomplete({
                source: BASE_URL+'index.php/loan/loadproperty',
                focus: function(event, ui) {
                        // prevent autocomplete from updating the textbox
                        event.preventDefault();
                        // manually update the textbox
                        $(this).val(ui.item.label);
                },
                select: function(event, ui) {
                        // prevent autocomplete from updating the textbox
                        event.preventDefault();
                        // manually update the textbox and hidden field
                        $(this).val(ui.item.label);
                        var id = this.id;
                        $("#" + id + "_id").val(ui.item.value);
                },
                change: function(event, ui) {
                        var id = this.id;
                        $("#" + id + "_id").val('');
                        var con_name = $(this).val();
                        // $(this).val('');

                        if (con_name!="" && con_name!=null) {
                          $.ajax({
                            method:"GET",
                            url:BASE_URL+'index.php/loan/loadproperty',
                            data:{term : con_name},
                            dataType:"json",
                            success:function(responsdata){
                              $("#"+id).val(responsdata[0].label);
                              $("#" + id + "_id").val(responsdata[0].value);
                              loadsubproperty($("#" + id));
                            }   
                          });
                        }
                },
                minLength: 1
              });
            });
        </script>

        <script type="text/javascript">
            function loadsubproperty(elem){
                // var property_id = elem.value;
                // var prop_elem_id = elem.id;
                var prop_elem_id = elem.attr('id');
                var index = prop_elem_id.substr(prop_elem_id.lastIndexOf('_')+1);
                var sub_prop_elem_id = "sub_property_" + index;
                var sub_prop_div_elem_id = "sub_property_div_" + index;
                var loan_prope_id_elem_id = "loan_property_id_" + index;
                var loan_property_id = document.getElementById(loan_prope_id_elem_id).value;
                var property_id = document.getElementById("property_" + index + "_id").value;

                loan_property_id = (loan_property_id==null || loan_property_id=="")?0:loan_property_id;

                if(property_id>0) {
                    index=parseInt(index)-1;
                    var xmlhttp=new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                            var data = xmlhttp.responseText;
                            document.getElementById(sub_prop_elem_id).innerHTML = data;

                            if(data==""){
                                document.getElementById(sub_prop_div_elem_id).style.display='none';
                            } else {
                                document.getElementById(sub_prop_div_elem_id).style.display='block';
                            }
                        }
                    };
                    xmlhttp.open("POST", "<?php echo base_url().'index.php/Loan/get_sub_property/'; ?>" + <?php if(isset($l_id)) echo $l_id; else echo '0';?>  + "/" + loan_property_id + "/" + property_id, true);
                    xmlhttp.send();
                } else {
                    document.getElementById(sub_prop_elem_id).innerHTML = "";
                }
            }

            function loadsubproperties(){
                $('select[name="property[]"]').each(function(index){
                    loadsubproperty($(this));
                });
            }
        </script>
        
		<script>
            jQuery(function(){
				var counter = <?php if(isset($editborower)) { echo count($editborower); } else { echo 1; } ?>;
				$('.repeat-owner').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_owner_' + counter + '" style="'+((counter==1)?"border-top: 1px dotted #ddd;":'')+'"> <div class="col-md-6"> <div class=""> <label class="col-md-5 control-label" style="padding-left: 0;" >' + ((counter==1)? "Name Of Applicant <span class='asterisk_sign'>*</span>": "Name Of Co Applicant <span class='asterisk_sign'>*</span>") + '</label> <div class="col-md-7"> <input type="hidden" id="borrower_' + counter + '_id" name="borrower[]" class="form-control" /> <input type="text" id="borrower_' + counter + '" name="borrower_name[]" class="form-control auto_owner ownership" placeholder="Type to choose owner from database..." /> </div> </div> </div> </div>');
					$('.auto_owner', newRow).autocomplete(autocomp_opt_owner);
                    $('.repeatowner').append(newRow);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
				});
                $('.reverse-owner').click(function(event){
                    if(counter!=1){
                        var id="#repeat_owner_"+(counter).toString();
                        if($(id).length>0){
                            $(id).remove();
                            counter--;
                        }
                    }
                });
			});
			
            jQuery(function(){
                // var counter = <?php //if(isset($editproperty)) { echo count($editproperty); } else { echo 1; } ?>;
                var counter = $('div.property').length;
                $('.repeat-property').click(function(event){
                    event.preventDefault();
                    counter++;

                    var newRow = jQuery('<div class="form-group property" id="repeat_property_' + counter + '" style="'+((counter==1)?"border-top: 1px dotted #ddd;":'')+'"> \
                                            <div class="col-md-6"> \
                                                <div class=""> \
                                                    <label class="col-md-4 control-label"> Name </label> \
                                                    <div class="col-md-8"> \
                                                        <input type="hidden" id="loan_property_id_'+counter+'" name="loan_property_id[]" value="" /> \
                                                        <input type="hidden" id="property_'+counter+'_id" name="property_id[]" class="form-control" value="" /> \
                                                        <input type="text" id="property_'+counter+'" name="property[]" class="form-control auto_property" value="" placeholder="Type to choose property from database..." /> \
                                                    </div> \
                                                </div> \
                                            </div> \
                                            <div class="col-md-6" id="sub_property_div_'+counter+'" style="display: none;"> \
                                                <div class=""> \
                                                    <label class="col-md-4 control-label">  Sub Property </label> \
                                                    <div class="col-md-8"> \
                                                        <select class="form-control" name="sub_property[]" id="sub_property_'+counter+'"> \
                                                            <option value="0">Select Sub Property</option> \
                                                        </select> \
                                                    </div> \
                                                </div> \
                                            </div> \
                                        </div>');
                    $('.repeatproperty').append(newRow);
                    $('.auto_property', newRow).autocomplete(autocomp_opt_property);
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
                });
                $('.reverse-property').click(function(event){
                    if(counter!=1){
                        var id="#repeat_property_"+(counter).toString();
                        if($(id).length>0){
                            $(id).remove();
                            counter--;
                        }
                    }
                });
            });
		</script>

        <script>
            jQuery(function(){
                var counter = <?php if(isset($pending_activity)) { echo count($pending_activity); } else { echo '1'; } ?>;
                $('.repeat-pending_activity').click(function(event){
                    event.preventDefault();
                    counter++;

                    var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" style="'+((counter==1)?"border-top: 1px dotted #ddd;":'')+'"><div class="col-md-1 col-sm-1 col-xs-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div><div class="col-md-11 col-sm-11 col-xs-11"><input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
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
    <!-- END SCRIPTS -->
    </body>
</html>