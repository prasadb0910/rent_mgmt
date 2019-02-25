<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .a {
            border-bottom: 2px solid #edf0f5;
            margin-bottom: 25px;
            padding-bottom: 25px;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("assets/img/demo/preview.jpg") ;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
        #image-label {
            color:white;
            padding-left:6px;
        }
        #image-label_field{
            background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
        }
        #image-label_field:hover{
            background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add{
            color:#41a541;
            cursor:pointer;
            font-size:14px;
            font-weight:500;
        }
        .remove{
            color:#d63b3b;
            text-align:right;
            cursor:pointer;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1{
            padding: 20px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .delete{
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:pointer;
            margin-top: 15px;
            font-size:20px;
            font-weight:500;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            font-weight:400;
        }
        .blue-btn:hover,
        .blue-btn:active,
        .blue-btn:focus,
        .blue-btn {
            background: transparent;
            border: dotted 1px #27a9e0;
            border-radius: 3px;
            color: #27a9e0;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none !important;
            padding: 10px 20px;
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
            height: 50px;
            margin-top: 0;
        }
        .fileUpload input.uploadlogo {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 42px;
        }
        input::-webkit-file-upload-button {
            cursor: pointer !important;
            height: 42px;
            width: 100%;
        }
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
        }
        .addschedule td{
            border:1px solid;
            padding:0px !important;
        }
        .addschedule th{
            border:1px solid;
        }
        .addtax td{
            border:1px solid;
            /*padding:0px !important;*/
        }
        .addtax th{
            border:1px solid;
        }
        .modal-content{
            width: 1000px;
        }
        #schedule_table td{
            background:#ffffff;
        }
        .modal-footer{
            display: block;
        }
        /*.select2-container {
            z-index:9999!important;
        }*/
        /*.modal.fade {
            z-index:9999!important;
        }*/
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_loan" role="form" method ="post" action="<?php if(isset($editloan)) { echo base_url().'index.php/Loan/updaterecord/'.$l_id; } else { echo base_url().'index.php/Loan/saverecord'; } ?>" enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Loan/checkstatus/All">Loan List</a></li>
          <?php if(isset($editloan)){ ?><li class="breadcrumb-item"><a href="<?php if (isset($l_id)) echo base_url().'index.php/Loan/view/'.$l_id; ?>">Loan View</a></li>
				  <?php } ?>
            <li class="breadcrumb-item active">Loan Details</li>
            <input type="hidden" id="l_id" name="l_id" value="<?php if(isset($editloan)) echo $l_id; ?>" />
        </ol>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-12">
                    <div class="card card-default" style="background:#e6ebf1">
                        <div class="card-header " style="background:#f6f9fc">
                            <div class="card-title">
                                Drag n' drop uploader
                            </div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span>
                        </div>
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($editloan[0]->image)) echo base_url().$editloan[0]->image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        <div id="image-label_field">
                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class=" container-fluid container-fixed-lg bg-white">
                    <div class="card card-transparent">
                        <div class="a">
                            <p class="m-t-20"><b>Owner Details<b></p>
                          
                            <div id="repeatborrower">

                                <?php $j=0; if(isset($editborower)) { 
                                    for ($j=0; $j < count($editborower) ; $j++) { ?>

                                <div id="repeat_borrower_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2  required">
                                            <label class="">Owner</label>
                                            <select id="borrower_<?php echo $j+1; ?>" name="borrower[]" class="form-control borrower full-width select2" data-error="#err_borrower_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$editborower[$j]->brower_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_borrower_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_borrower_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_borrower_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label class="">Owner</label>
                                            <select id="borrower_<?php echo $j+1; ?>" name="borrower[]" class="form-control borrower full-width select2" data-error="#err_borrower_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_borrower_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_borrower_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="borrower_box">
                                <div class="block" id="borrower_block">
                                    <span style="float:left;" class="add" id="repeat-borrower">+ Add Owner</span>
                                </div>
                            </div>
                        </div>
                        <div class="a">
                            <p class=""><b>Loan Details<b></p>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Loan Ref Id </label>
                                        <input type="text" class="form-control" id="ref_id" name="ref_id" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_id;} ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Loan Ref Name</label>
                                        <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo $editloan[0]->ref_name;} ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Loan Type </label>
                                        <select class="form-control full-width" id="loan_type" name="loan_type" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity" data-error="#loan_types">
                                            <option value="">Select</option>
                                            <option value="LAP" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='LAP') { echo "selected";} } ?>> LAP </option>
                                            <option value="Overdraft" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Overdraft') { echo "selected";} }?>> Overdraft </option>
                                            <option value="Normal" <?php if(isset($editloan)) { if($editloan[0]->loan_type=='Normal') { echo "selected";} } ?>> Normal </option>
                                        </select>
                                        <div id="loan_types"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Amount</label>
                                        <input type="text" class="form-control format_number" name="amount" id="amount" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_amount,2);} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required ">
                                        <label>Loan Start Date</label>
                                        <input type="text" class="form-control datepicker" name="loan_start_date" id="loan_start_date" placeholder="Enter Here" value="<?php if(isset($editloan)) { if($editloan[0]->loan_startdate!=null && $editloan[0]->loan_startdate!='') echo date('d/m/Y',strtotime($editloan[0]->loan_startdate));} ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Loan Due Day</label>
                                        <select class="form-control full-width" name="loan_due_day" id="loan_due_day" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity" data-error="#loan_due">
                                            <option value="">Select</option>
                                            <?php if(isset($editloan) && count($editloan)>0) {
                                                    for($i=1; $i<=31; $i++) { 
                                                        if($editloan[0]->loan_due_day==$i) echo '<option selected>'.$i.'</option>'; 
                                                        else echo '<option>'.$i.'</option>';}} 
                                            else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
                                        </select>
                                        <div id="loan_due"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Term (In months) </label>
                                        <input type="text" class="form-control format_number" name="term" id="term" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_term,2);} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Interest Type</label>
                                        <select class="form-control full-width" name="interest_type" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity" data-error="#interest_type">
                                            <option value="">Select</option>
                                            <option value="Fixed" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Fixed') { echo "selected";} } ?>> Fixed </option>
                                            <option value="Float" <?php if(isset($editloan)) { if($editloan[0]->interest_type=='Float') { echo "selected";} }?>> Float </option>
                                        </select>
                                        <div id="interest_type"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Interest Rate (In %) </label>
                                        <input type="text" class="form-control" name="interest_rate" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo format_money($editloan[0]->loan_interest_rate,2);} ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Financial Institution</label>
                                        <input type="text" class="form-control" name="financial_institution" placeholder="Enter Here " value="<?php if(isset($editloan)) { echo $editloan[0]->financial_institution;} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Repayment </label>
                                        <input type="text" class="form-control" name="repayment" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo $editloan[0]->repayment;} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Purpose </label>
                                        <input type="text" class="form-control" name="purpose" placeholder="Enter Here" value="<?php if(isset($editloan)) { echo $editloan[0]->purpose;} ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="a">
                            <p class=""><b>Security</b></p>
                            <div id="repeatproperty">

                                <?php $j=0; if(isset($editproperty)) { 
                                    for ($j=0; $j < count($editproperty) ; $j++) { ?>

                                <div id="repeat_property_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Property</label>
                                            <input type="hidden" id="loan_property_id_<?php echo $j+1;?>" name="loan_property_id[]" value="<?php if(isset($editproperty[$j])) echo $editproperty[$j]->id; ?>" />
                                            <select id="property_<?php echo $j+1; ?>" name="property_id[]" class="form-control property full-width select2" data-error="#err_property_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                <option value="">Select</option>
                                                <?php for($i=0; $i<count($property); $i++) { ?>
                                                        <option value="<?php echo $property[$i]->txn_id; ?>" <?php if($editproperty[$j]->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_property_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="sub_property_div_<?php echo $j+1;?>" style="display: none;">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Sub Property</label>
                                            <select id="sub_property_<?php echo $j+1; ?>" name="sub_property[]" class="form-control full-width select2" data-error="#err_sub_property_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                <option value="">Select</option>
                                            </select>
                                            <div id="err_sub_property_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_property_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php }} else { ?>
                                
                                <div id="repeat_property_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Property</label>
                                            <input type="hidden" id="loan_property_id_<?php echo $j+1;?>" name="loan_property_id[]" value="" />
                                            <select id="property_<?php echo $j+1; ?>" name="property_id[]" class="form-control property full-width select2" data-error="#err_property_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                <option value="">Select</option>
                                                <?php for($i=0; $i<count($property); $i++) { ?>
                                                        <option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_property_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="sub_property_div_<?php echo $j+1;?>" style="display: none;">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Sub Property</label>
                                            <select id="sub_property_<?php echo $j+1; ?>" name="sub_property[]" class="form-control full-width select2" data-error="#err_sub_property_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                <option value="">Select </option>
                                            </select>
                                            <div id="err_sub_property_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_property_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="property_box">
                                <div class="block" id="property_block">
                                    <span style="float:left;" class="add" id="repeat-property">+ Add Security</span>
                                </div>
                            </div>
                        </div>
                 

                    <div class="a">
                        <p class=""><b>Documents</b></p>
                        <?php $this->load->view('templates/document');?>
                        <div class="optionBox" id="optionBox1">
                            <div class="block" id="block2">
                                <span class="add" id="repeat-documents">+ Add Documents</span>
                            </div>
                        </div>
                    </div>

                    <p class="div_heading"><b>Remark</b></p>
                   
                    <div class="a">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Remark</label>
                                    <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($editloan)){ echo $editloan[0]->maker_remark;}?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer" style="padding-bottom: 60px;">
                        <input type="hidden" id="submitVal" value="1" />
                        <a href="<?php echo base_url(); ?>index.php/Loan" class="btn btn-default-danger pull-left" >Cancel</a>
                        <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($editloan)) echo 'display:none'; ?>" />
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php $this->load->view('templates/footer');?>
</div>
</div>

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';

    <?php
        $property_details = '<option value="">Select</option>';
        if(isset($property)) {
            for($i=0; $i<count($property); $i++) {
                $property_details = $property_details . '<option value="'.$property[$i]->txn_id.'">'.str_replace("'","",$property[$i]->p_property_name).'</option>';
            }
        }
    ?>
    var property_details = '<?php echo $property_details; ?>';

    var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
    var tax = new Array();
    var taxname=new Array();
    var taxpurpose=new Array();
    window.cntrinst=0;

    <?php for ($i=0; $i < count($tax) ; $i++) { ?>
        tax.push('<?php echo $tax[$i]->tax_percent; ?>');
        taxname.push('<?php echo $tax[$i]->tax_name; ?>');
        taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
    <?php } ?>

    <?php 
        $tax_list_details = '<option value="">Select</option>';
        if(isset($tax_details)){
            foreach($tax_details as $row){
                $tax_list_details = $tax_list_details . '<option value="'.$row->tax_id.'">'.str_replace("'","",$row->tax_name).'-'.$row->tax_percent.'</option>';
            }
        }
    ?>
    var tax_list_details = '<?php echo $tax_list_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/loan.js"></script>

</body>
</html>