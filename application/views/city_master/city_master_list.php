<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" >
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
<style>
.nav-tabs.nav-tabs-left~.tab-content
{
	width:100%!important;
}
table.dataTable thead .sorting:after {
    opacity: 0.2; 
    content: ""; 
}
table.dataTable thead .sorting_asc:after {
    content: "";
}
table.dataTable thead .sorting_desc:after {
    content: "";
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
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>

<li class="breadcrumb-item active"> Settings</li>
</ol>




<div class="card card-transparent">

<div class="card-block no-padding">
<div class="row">
<div class="col-xl-12">
<div class="card card-transparent flex-row">
<ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white" id="tab-3">
<li class="nav-item">
<a href="#" class="active" data-toggle="tab" data-target="#tab3hellowWorld">Service Settings	
</a>
</li>
<!--<li class="nav-item">
<a href="#" data-toggle="tab" data-target="#tab3FollowUs">City Master	
	
</a>
</li>-->

</ul>
<div class="tab-content bg-white">
<div class="tab-pane active" id="tab3hellowWorld">
<form>
<div class="form-group row required">
<label class="col-md-12 control-label">Services opt for:</label>
<div class="col-md-12">
<div class="radio radio-success">
<input type="radio" value="rent" name="prop" id="rent">
<label for="rent">Rent Management</label>
<input type="radio" checked="checked"  value="rent1" name="prop" id="rent1">
<label for="rent1">Property and Rent Management
</label>
</div>
</div>


</div>

<div class="form-group row required">
<label class="col-md-12 control-label">Do you want maker and checker</label>
<div class="col-md-12">
<div class="radio radio-success">
<input type="radio" value="maker_yes" name="no" id="maker_yes">
<label for="maker_yes">Yes</label>
<input type="radio" checked="checked"  value="maker_no" name="no" id="maker_no">
<label for="maker_no">No</label>
</div>
</div>


</div>
<button class="btn btn-default pull-right m-r-10" type="submit">Save</button>
<form>
</div>
<div class="tab-pane " id="tab3FollowUs" style="display:none;">

<div class="card card-transparent " >
 <div class="card card-transparent">

<form id="form-personal form_tax" role="form" autocomplete="off" method="post" action="<?php echo base_url()?>index.php/city_master/insertUpdateRecord">

<div class="container" style="background:#f6f9fc;margin:10px;padding:20px">
<div class="row">
 <input type="hidden" name="city_id" id="city_id" value="<?php if(isset($city_details)){ echo $city_details[0]->city_id; }  ?>">
<div class="col-md-6">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">State Name</label>
<select class="full-width"  data-init-plugin="select2" name="state_name" id="state_name">
    <option value=''>Select State</option>
                                                    <?php if(isset($state_list)){
                                                        foreach($state_list as $row){
                                                           if(isset($city_details)){
                                                            if($row->id == $city_details[0]->state_id){
                                                            echo "<option value='".$row->id."' selected='selected'>".$row->state_name."</option>";
                                                                
                                                            }
                                                            else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                            }
                                                        }
                                                        else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                        }
                                                        }

                                                    }?>
                                                    </select>
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default required">
<label>City</label>
 <input type="text" class="form-control city_name" name="city_name" placeholder="City Name" value="<?php if(isset($city_details)){ echo $city_details[0]->city_name; } ?>" >
</div>
</div>

</div>
<button class="btn btn-default pull-right" type="submit"> Save</button><br>



</div>


</div>


<div class="card-block">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>Sr No.</th>
<th>City</th>
<th>State</th>

</tr>
</thead>
<tbody>
										<?php 
										if(isset($city_details)){
										 for($i=0; $i < count($city_details); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td align="center"><?php if(isset($city_details)){ echo ($i+1) ;} else {echo '1';} ?></td>
											
												<td>
														<a href="<?php echo base_url().'index.php/city_master/city_view/'.$city_details[$i]->city_id; ?>"><?php echo $city_details[$i]->city_name; ?></a>
													
												</td>
												<td><?php echo $city_details[$i]->state_name;?></td>
												
												
										</tr>
										<?php } 
									}?>
									</tbody>
</table>
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





</div>




    <?php $this->load->view('templates/footer');?>
</div>
</div>

<?php $this->load->view('templates/script');?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script>
 $(".date").datepicker();

</script>
   <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            var div_master = "";

            
        </script>

</html>