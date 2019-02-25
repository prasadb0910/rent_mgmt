<?php

//error_reporting(0);

?>
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

<style>
.a
{
border-bottom: 2px solid #edf0f5;
margin-bottom: 25px;
padding-bottom: 25px;
}
</style>
<style type="text/css">
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
#image-label 
{
    
color:white;
padding-left:6px;

}
#image-label_field
{
background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
	
	
}
#image-label_field:hover
{
	background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
}
.add
{
	color:#41a541;
	cursor:default;
font-size:14px;
		font-weight:500;
}
.remove
{
color:#d63b3b;
text-align:right;
	cursor:default;
	    margin-bottom: 10px;
		font-size:14px;
		font-weight:500;
}
.block1
{
	padding: 20px 20px;
    border: 2px solid #edf0f5;
    border-radius: 7px;
    background: #f6f9fc;
	    margin-top: 10px;
    margin-bottom: 10px;
}

.delete
{
color:#d63b3b;
text-align:left;
vertical-align:center;
	cursor:default;
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

/*Chrome fix*/
input::-webkit-file-upload-button {
  cursor: pointer !important;
  height: 42px;
  width: 100%;
}
.attachments
{
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

<div class="content ">

<div class=" container-fluid   container-fixed-lg ">



<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
<li class="breadcrumb-item active "><a href="#">Report Details</a></li>

</ol>
<div class="row">






<div class="col-md-12">

<div class=" container-fluid  p-t-20 p-b-5 container-fixed-lg bg-white" >


 <div class="card card-transparent">


<form id="form_download_report form-personal" role="form"  method="post" enctype="multipart/form-data" action="<?php if(isset($report_id)) { echo base_url().'index.php/Account/generate_report/'.$report_id; } ?>">
<span><b>  <?php if(isset($report_name)) echo $report_name; ?> <b><a class="btn btn-default-danger pull-right" href="<?php echo base_url() . 'assets/reports_sample/' . (isset($sample_report_name)?$sample_report_name:'') ;?>" download><i class="fa fa-file-pdf-o "></i> View Sample</a></span>
<br>
<br>

<div class="row clearfix">
  <div class="col-md-6">
    <div class="form-group form-group-default form-group-default-select2 required" >
    <label class="">Select Property</label>
      <select  class="full-width"  data-init-plugin="select2" id="property1" name="property">
      <option value="">ALL</option>
      <?php for($i=0; $i<count($purchase_data); $i++) { ?>
      <option value="<?php echo $purchase_data[$i]->txn_id; ?>"><?php echo $purchase_data[$i]->p_property_name; ?></option>
      <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default form-group-default-select2 required"  style="display:none;" id="subprop">
    <label class="">Select Sub Property</label>
    <select class="full-width" data-placeholder="Select " data-init-plugin="select2" id="sub_property"  name="sub_property" >
    <option value="">Select Sub Property</option>
    </select>


    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-md-6">
  <div class="form-group form-group-default form-group-default-select2 required" >
  <label class="">Select Owner</label>
   <select class="full-width" data-placeholder="Select " data-init-plugin="select2" name="owner" id="owner">
    <option value=""></option>
   <?php
    for ($i=0; $i < count($owner) ; $i++) { ?>
   <option value="<?php echo $owner[$i]->pr_client_id; ?>">
    <?php echo $owner[$i]->owner_name; ?></option>
  <?php } ?>
  </select>

  </div>
  </div>
</div>


<div class="row clearfix">

<div class="col-md-6">
<div class="form-group form-group-default input-group"  >
<div class="form-input-group">
<label>From </label>
<input id="from_date" type="text" class="form-control date" name="from_date"  id="datepicker-component2" placeholder="Select ">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>
		
</div>


<div class="col-md-6">
<div class="form-group form-group-default input-group"  >
<div class="form-input-group">
<label>To </label>
<input id="to_date" type="text" class="form-control date" name="to_date"  id="datepicker-component2" placeholder="Select">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>
		
</div>



</div>


<div style="text-align:center;"><button class="btn btn-default-danger " type="submit"><i class="fa fa-download "></i> Download</button></div>

 <div class="panel-footer">
								 <!-- <input class="btn btn-danger " type="reset" id="reset" value="Cancel">  -->
							   <a href="<?php echo base_url(); ?>index.php/reports/view_reports" class="btn btn-default-danger" >Cancel</a>
                            </div>
</form>
</div>
</div>

</div>



</div>
</div>
</div>




</div>




<?php $this->load->view('templates/footer');?>

</div>

</div>



<?php $this->load->view('templates/script');?>
<script type="text/javascript">
$(document).ready(function() {

  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  });
});
</script>
<script>
 $(".date").datepicker();

</script>

<script type="text/javascript">
   $( "#property1" ).change(function() {
    var property=$("#property1").val();
    var dataString = 'property_id=' + property + '&txn_id=64';
    //($('#s_id').val()==''?0:$('#s_id').val())
    $.ajax({
       type: "POST",
       url: "<?php echo base_url() .'index.php/Account/get_sub_property'?>",
       data: dataString,
       cache: false,
       success: function(data){

          if(data!=0)
          {
              var html = '<option value="" Selected>Select Sub Property</option>';
              var obj = $.parseJSON(data);
              var subproperty = obj['sub_property'];
              var sub_property_id = obj['sub_property_id'];
              $.each(subproperty, function()
              { 
                if (sub_property_id == this['sp_id']) 
                {
                    html += '<option value="'+this['sp_id']+ '" selected>'+ this['sp_name']+'</option>';
                }
                else
                {
                    html += '<option value="'+this['sp_id']+ '" >'+ this['sp_name']+'</option>';   
                }
                
              });
              $("#sub_property").html(html);
              $("#subprop").show();
          }
          else
          {    
             $("#sub_property").empty();
             $("#subprop").hide();   
          } 
          
       } 
    });

    $.ajax({
      type: "POST",
       url: "<?php echo base_url() .'index.php/Account/get_owner'?>",
       data: dataString,
       cache: false,
       success: function(data)
       {
          if(data!=0)
          {
              $("#owner").empty();
              var html = '<option value="" Selected>Select Sub Property</option>';
              var owner = obj = $.parseJSON(data);
             /* var subproperty = obj['sub_property'];
              var sub_property_id = obj['sub_property_id'];*/
              $.each(owner, function()
              { 
                 html += '<option value="'+this['pr_client_id']+ '" >'+ this['c_name']+'</option>'; 
                
              });
              $("#owner").html(html);
          }
        }  
    });
});
</script>

	   <script type="text/javascript">
          /*$( "#property" ).change(function() {
	            getSubProperties();
	        });

	        function getSubProperties(){
				var property=$("#property").val();
				var txn_type=$("#txn_type").val();
				if(property==''){
					$("#sub_property").html('');
					$("#sub_property_div").hide();
				} else {
        			// console.log(property);
					var status=$("#status").val();
		            var dataString = 'property_id=' + property + '&txn_type=' + txn_type;

		            $.ajax({
		               	type: "POST",
		               	url: "<?php echo base_url() . 'index.php/export/get_sub_property' ?>",
		               	data: dataString,
		               	// async: false,
		               	cache: false,
		               	success: function(html){
		                   	$("#sub_property").html(html);

							if(html==""){
								$("#sub_property_div").hide();
							} else {
								$("#sub_property_div").show();
							}
		               	}
		            });
				}
			}*/
        </script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>