<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
	
	.select2-container .select2-selection .select2-selection__rendered {
    padding: 0;
    padding-left: 3px;
    padding-top: 0px!important;
    padding-right: 7px!important;
}

 .select2-container .select2-selection .select2-selection__arrow 
{
    right: 0px!important;	
}
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
            padding: 5px 20px;
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
            height: 43px;
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
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_sub_property" role="form" method ="post" action="<?php if(isset($sub_property)){ echo base_url().'index.php/Allocation/updaterecord/'.$p_id.'/'.$sub_property[0]->txn_status;} else {echo base_url().'index.php/Allocation/saverecord';} ?>" enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Allocation/checkstatus/<?php if (isset($contact_type)) echo $contact_type; else if (isset($sub_property[0]->c_type)) echo $sub_property[0]->c_type; ?>/All">Sub Property List</a></li>
			  <?php //if(isset($sub_property)){?>
          <!-- <li class="breadcrumb-item"><a href="<?php //if (isset($p_id)) echo base_url().'index.php/Allocation/view/'.$p_id; ?>">Sub Property View</a></li>-->
	     <?php //} ?>
            <li class="breadcrumb-item active">Sub Property Details</li>
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
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($sub_property)) echo base_url().$sub_property[0]->image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                            <!-- <img src="<?php //echo base_url().$sub_property[0]->c_image; ?>"> -->
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
                            <p class="m-t-20"><b>Sub Property Details<b></p>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Select Property</label>
                                        <select class="form-control full-width Select-Property" name="property" data-error="#err_property" data-placeholder="Select " data-init-plugin="select2">
                                            <option value="">Select Property </option>
                                            <?php for ($i=0; $i < count($property) ; $i++) { ?>
                                                <option value="<?php echo $property[$i]->txn_id; ?>" <?php if(isset($sub_property)) { if($sub_property[0]->property_id==$property[$i]->txn_id) { echo "selected"; } } else echo ($this->uri->segment(3)==$property[$i]->txn_id?"selected":""); ?>><?php echo $property[$i]->p_property_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div id="err_property"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="repeatsubproperty">
                                <?php $i=0; if(isset($sub_property)) { for ($i=0; $i < count($sub_property) ; $i++) { ?>
                                <div class="block1" id="repeat_sub_property_<?php echo $i+1; ?>">
                                    <div class="remove delete_row" id="repeat_sub_property_<?php echo $i+1; ?>_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>
                                    <div class="row clearfix">
                                        <!-- <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Sr. No.</label>
                                                <input type="text" class="form-control" name="sr_no[]" value="<?php //echo $i+1; ?>" readonly >
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Sub Property Name.</label>
                                                <input type="hidden" name="sub_property_id[]" class="form-control" value="<?php echo $sub_property[$i]->txn_id; ?>">
                                                <input type="text" name="sub_property[]" class="form-control sub_property" value="<?php echo $sub_property[$i]->sp_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Select Sub Property Type</label>
                                                <select class="full-width select2" name="sub_type[]" data-placeholder="Type" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                    <option value="Shop" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Shop') { echo "selected"; }} ?>>Shop</option>
                                                    <option value="Flat" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Flat') { echo "selected"; }} ?>>Flat</option>
                                                    <option value="Floor" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_type=='Floor') { echo "selected"; }} ?>>Floor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Carpet Area</label>
                                                    <input type="text" name="carpet[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_carpet_area,2); ?>">
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="carpet_unit[]" data-placeholder="Carpet" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_carpet_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Built Up Area</label>
                                                    <input type="text" name="builtup[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_builtup_area,2); ?>">
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="builtup_area[]" data-placeholder="Built Up" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_builtup_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Saleable Area</label>
                                                    <input type="text" name="sellable[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->sp_sellable_area,2); ?>">
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="sellable_area[]" data-placeholder="Saleable" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="Sq m" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq m') { echo "selected"; }} ?>>Sq m</option>
                                                        <option value="Sq ft" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq ft') { echo "selected"; }} ?>>Sq ft</option>
                                                        <option value="Sq yard" <?php if(isset($sub_property)) {if($sub_property[$i]->sp_sellable_area_unit=='Sq yard') { echo "selected"; }} ?>>Sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Cost(₹)</label>
                                                <input type="text" name="allocated_cost[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_cost,2); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Maintenance(₹)</label>
                                                <input type="text" name="allocated_maintainance[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_maintainance,2); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Expense(₹)</label>
                                                <input type="text" name="allocated_expenses[]" placeholder="Enter Here" class="form-control format_number" value="<?php echo format_money($sub_property[$i]->allocated_expenses,2); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } else { ?>
                                <div class="block1" id="repeat_sub_property_<?php echo $i+1; ?>">
                                    <div class="remove delete_row" style="display:none;"id="repeat_sub_property_<?php echo $i+1; ?>_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>
                                    <div class="row clearfix" style="padding-top:25px">
                                        <!-- <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Sr. No.</label>
                                                <input type="text" class="form-control" name="sr_no[]" value="1" readonly >
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Sub Property Name</label>
                                                <input type="hidden" name="sub_property_id[]" class="form-control">
                                                <input type="text" name="sub_property[]" class="form-control sub_property">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Select Sub Property Type</label>
                                                <select class="full-width select2" name="sub_type[]" data-placeholder="Type" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                    <option value="shop">shop</option>
                                                    <option value="Flat">Flat</option>
                                                    <option value="Floor">Floor</option>
                                                </select>
                                            </div>
                                        </div>
										<div class="col-md-4">
                                    </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Carpet Area</label>
                                                    <input type="text" name="carpet[]" class="form-control format_number" >
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="carpet_unit[]" data-placeholder="Carpet" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="sq ft">sq ft</option>
                                                        <option value="sq mt">sq m</option>
                                                        <option value="sq yard">sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Built Up Area</label>
                                                    <input type="text" name="builtup[]" class="form-control format_number" >
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="builtup_area[]" data-placeholder="Built Up" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="sq ft">sq ft</option>
                                                        <option value="sq mt">sq m</option>
                                                        <option value="sq yard">sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label>Saleable Area</label>
                                                    <input type="text" name="sellable[]" class="form-control format_number" >
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <select class="full-width select2" name="sellable_area[]" data-placeholder="Select Country" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                        <option value="select">select</option>
                                                        <option value="sq ft">sq ft</option>
                                                        <option value="sq mt">sq m</option>
                                                        <option value="sq yard">sq yard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Cost(₹)</label>
                                                <input type="text" name="allocated_cost[]" class="form-control format_number" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Maintenance(₹)</label>
                                                <input type="text" name="allocated_maintainance[]" class="form-control format_number" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-default required">
                                                <label>Allocated Expense(₹)</label>
                                                <input type="text" name="allocated_expenses[]" class="form-control format_number" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="optionBox" id="sub_prop_box">
                                <div class="block" id="sub_prop_block">
                                    <span class="add" id="repeat-sub_property">+ Add Sub Property</span>
                                </div>
                            </div>
                        </div>

                        <p><b>Remark</b></p>
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Remark</label>
                                        <input type="text" class="form-control " name="maker_remark" placeholder="Remark" value="<?php //if (isset($sub_property)) { echo $sub_property[0]->c_maker_remark; } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer" style="padding-bottom: 60px;">
                            <input type="hidden" id="submitVal" value="1" />
                            <a href="<?php echo base_url(); ?>index.php/Allocation" class="btn btn-default-danger pull-left" >Cancel</a>
                            <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                            <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
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

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url(); ?>js/document.js"></script> -->
<script>
    jQuery(function(){
        var counter = $('input.sub_property').length+1;

        $('#repeat-sub_property').click(function(event){
            event.preventDefault();
            var newRow = jQuery('<div class="block1" id="repeat_sub_property_'+counter+'">'+
                                    '<div class="remove delete_row" id="repeat_sub_property_'+counter+'_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>'+
                                    '<div class="row clearfix">'+
                                        '<!-- <div class="col-md-4">'+
                                            '<div class="form-group form-group-default required">'+
                                                '<label>Sr. No.</label>'+
                                                '<input type="text" class="form-control" name="sr_no[]" value="'+counter+'" readonly >'+
                                            '</div>'+
                                        '</div> -->'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default required">'+
                                                '<label>Sub Property Name.</label>'+
                                                '<input type="hidden" name="sub_property_id[]" class="form-control">'+
                                                '<input type="text" name="sub_property[]" class="form-control sub_property">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default form-group-default-select2 required">'+
                                                '<label class="">Select Sub Property Type</label>'+
                                                '<select class="full-width select2" name="sub_type[]" data-placeholder="Type" data-init-plugin="select2">'+
                                                    '<option value="shop">shop</option>'+
                                                    '<option value="Flat">Flat</option>'+
                                                    '<option value="Floor">Floor</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row clearfix">'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default input-group">'+
                                                '<div class="form-input-group">'+
                                                    '<label>Carpet Area</label>'+
                                                    '<input type="text" name="carpet[]" class="form-control format_number" >'+
                                                '</div>'+
                                                '<div class="input-group-addon bg-transparent h-c-50">'+
                                                    '<select class="full-width select2" name="carpet_unit[]" data-placeholder="Carpet" data-init-plugin="select2">'+
                                                        '<option value="select">select</option>'+
                                                        '<option value="sq ft">sq ft</option>'+
                                                        '<option value="sq mt">sq m</option>'+
                                                        '<option value="sq yard">sq yard</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default input-group">'+
                                                '<div class="form-input-group">'+
                                                    '<label>Built Up Area</label>'+
                                                    '<input type="text" name="builtup[]" class="form-control format_number" >'+
                                                '</div>'+
                                                '<div class="input-group-addon bg-transparent h-c-50">'+
                                                    '<select class="full-width select2" name="builtup_area[]" data-placeholder="Built Up" data-init-plugin="select2">'+
                                                        '<option value="select">select</option>'+
                                                        '<option value="sq ft">sq ft</option>'+
                                                        '<option value="sq mt">sq m</option>'+
                                                        '<option value="sq yard">sq yard</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default input-group">'+
                                                '<div class="form-input-group">'+
                                                    '<label>Saleable Area</label>'+
                                                    '<input type="text" name="sellable[]" class="form-control format_number" >'+
                                                '</div>'+
                                                '<div class="input-group-addon bg-transparent h-c-50">'+
                                                    '<select class="full-width select2" name="sellable_area[]" data-placeholder="Select Country" data-init-plugin="select2">'+
                                                        '<option value="select">select</option>'+
                                                        '<option value="sq ft">sq ft</option>'+
                                                        '<option value="sq mt">sq m</option>'+
                                                        '<option value="sq yard">sq yard</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row clearfix">'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default required">'+
                                                '<label>Allocated Cost(₹)</label>'+
                                                '<input type="text" name="allocated_cost[]" class="form-control format_number" >'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default required">'+
                                                '<label>Allocated Maintenance(₹)</label>'+
                                                '<input type="text" name="allocated_maintainance[]" class="form-control format_number" >'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group form-group-default required">'+
                                                '<label>Allocated Expense(₹)</label>'+
                                                '<input type="text" name="allocated_expenses[]" class="form-control format_number" >'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
            $('#repeatsubproperty').append(newRow);
            $('.select2', newRow).select2();
            $("form :input").change(function() {
                $(".save-form").prop("disabled",false);
            });
            $('.format_number').keyup(function(){
                format_number(this);
            });
            $('.delete_row').click(function(event){
                delete_row($(this));
            });
            counter++;
        });
    });
</script>
</body>
</html>