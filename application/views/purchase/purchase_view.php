<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('templates/header');?>
<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" >
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo base_url(); ?>assets/css/c3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js/c3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>

<style>

.card.card-default>.card-header 
{
    color:#626262!important;
	
}
.dataTables_scrollBody thead tr:first-child
{
	height:0px!important;
}
.form-control 
{
	font-family:'Montserrat'!important;
	font-size:13px!important;
}
#sales_div b,#rent_div b,#kyc-section b
{
		font-size:14px!important;
}

.table.dataTable 
{
	margin-top:0px!important
}
::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}
::-webkit-scrollbar
{
	width: 6px;
	height: 6px;
	background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
	background-color: #000000;
}
.dataTables_scroll
{
	overflow-x:auto!important;
}
.tags-btn {
    border-color: #ffc05e;
    color: #ffc05e;
	    min-width: 80px;
    padding: 6px 14px;
   
	    border-radius: 100px;
	    border: 1px solid;
}
}
.tenant_count {
    color: #fff;
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
		
	.dt-buttons
	{
		display:none!important;
	}
	.table tbody tr td
	{
		padding:10px!important;
	}

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    img {
      margin-bottom: -4px;
    }

    .caption-container {
      text-align: center;
      background-color: black;
      padding: 2px 16px;
      color: white;
    }

    .demo {
      opacity: 0.6;
    }

    .active,
    .demo:hover {
      opacity: 1;
    }

    img.hover-shadow {
      transition: 0.3s
    }

    .hover-shadow:hover {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
    }
    .column
    {
    	width:25%;
    }
    .tenant_count
    {
    	color:#fff;	
    }
</style>

<style>
    .edit
    {
    	
    	color:#41a541!important;
    }
    .delete
    {
    	color:#da5050!important;
		margin-left:0px!important;
    }
    .print
    {
    	color:#fe970a!important;
		display:none!important;
    }

    .a
    {
    border-bottom: 2px solid #edf0f5;
    margin-bottom: 25px;
    padding-bottom: 25px;
    }
    .prop_img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
    }
    .markup {
    border-radius:20px;
    }
    #contact1 {
        width: 150px;
        height: 150px;
        text-align: center;
    	float: none;
        margin: 15px auto;
        display: block;
    	color:#fff!important;
    }
    .info
    {
    	text-align:center;
       
    }
    .invoice
    {
        margin: 10px;
        padding: 0 27px;
        border-radius: 30px;
        font-size: 13px;
    }
    .btn-group-justified
    {
    	margin-left:2px;
    }
    .email
    {
    	font-size:13px!important;
    		display: block;
    		text-align:center;
    		color:#fff;
    }
    .title_1
    {
    	
    	font-size: 15px!important;
        font-family: inherit!important;
        font-weight: 500!important;
        letter-spacing: 0.02em!important;
        text-transform: capitalize!important;
    	text-align:center;
    	display: block;
    	color:#fff;
    }
    .contact_card
    {
    	border-radius:5px!important;
    }
	  .rent a
	  {
		    color:#fff!important;
	  }
    .rent
    {

    color:#fff!important;
    	border-right:2px solid #edf0f5;
    	    padding: 6px 10px;
    		text-align:center;
    		
    	border-color: rgba(255,255,255,0.1) !important;	
    }
    .rent:hover
    {
    	background-color: rgba(255,255,255,0.1) !important;
    }
    .leases
    {
    color:#fff!important;
    border-top: 2px solid #edf0f5;
    padding: 6px 10px;
    text-align:center;

    border-right:2px solid #edf0f5;
    border-color: rgba(255,255,255,0.1) !important;
    }

	   .leases a
    {
		color:#fff!important;
	}
    .leases:hover
    {
    	background-color: rgba(255,255,255,0.1) !important;
    }

    .badge-notify {
        background: #899be7;
        position: relative;
        top: -88px;

        left: 188px;
        width: 28px;
        height: 28px;
        color: #fff;

        border: 2px solid #ffffff;
        position: absolute;
        top: 30px;

        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #41c997;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;

        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        border: 2px solid #ffffff;
        -webkit-transition: background-color 0.2s linear;
        transition: background-color 0.2s linear;
    }
    #money.fa 
    {
    	font-size:22px!important;
    }
    .user-roommates:after {
        content: '';
        position: absolute;
        left: 50%;
       top: 161px;
        width: 22px;
        height: 1px;
        margin-left: -11px;
        background-color: #e6ebf1;
    }

    .user-roommates.empty>p {
       text-align:center;
        font-size: 12px;
        color: #d1d3d8;
    }
    .form-group-default
    {
    	border:none!important;
    }

    .form-group-default label
    {
    	font-weight:1000!important;
    }

    .thumbnail-wrapper.d32>* {
        line-height: 110px!important;
    }

    	#invoice_box:before
        {
    		content: '';
    		position: absolute;
    		top: -16px;
    		left: 50%;
    		width: 22px;
    		height: 3px;
    		opacity: 0.4;
    		margin-left: -11px;
    		border-radius: 2px;
    		background-color: #000000;
    	}
    .block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left:12px;
			margin-right:12px;
		}
		p {
			font-weight: 200px!important;
			margin-left:12px;
			
		}

    .month 
    {
    	background:#f6f9fc;
    	
    }
    .month td
    {
    	padding:5px;
    }
    tr, th, td
    {
    	padding:5px;
    }
    .prop_sq li
    {
    	list-style-type:none!important;
    }
</style>

<style>
    .unit
    {
    	font-weight:500!important;
    	font-size:18px!important;
		font-family:'Montserrat'!important;
    	   
    }	
    .sq
    {
    	font-weight:300;
    	font-size:14px;
		padding-left:12px!important;
			font-family:'Montserrat'!important;
    	
    }
	.prop_sq
	{
		padding-left:12px!important;
		font-family:'Montserrat'!important;
	}
	.prop_sq b
	{
		font-size:14px!important;
	}
    .view_prop
    {
    	
        width: 100%!important;
        max-width: 100%!important;
			font-family:'Montserrat'!important;
    	
    }
		.card-title p,.card-title a
		{
				font-family:'Montserrat'!important;
				text-transform:Capitalize!important;
				font-size:14px!important;
		}
		#accounting_dtl p,#accounting_dtl a
		{
				font-family:'Montserrat'!important;
				font-size:14px!important;
		}
		
		b{
			font-family:'Montserrat'!important;
		}
    .files-item {
        padding: 15px;
        position: relative;
        width: 65px;
        height: 70px;
        border: 2px solid #e6ebf1;
        
    	display: inline-flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
		margin-bottom: 20px;
        margin-right: 26px;
    }

    .file-icon-lg {
            font-size: 40px;
        color:#f77171!important;
    }

    .item-title {
        position: absolute;
        font-size: 0.71429rem;
        left: 0;
        bottom: -20px;
        white-space: nowrap;
        font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    }
	#example4_wrapper
	{
		overflow-x:auto;
	}
	.table thead tr th
	{
		border-bottom:none!important;
	}
#image-preview {
            min-width: auto;
            min-height: 250px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        .dropdown-item input {
            display: inline; 
            padding-left: 0px;
            cursor: pointer;
            font-size: 13px;
        }
</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
    <?php $this->load->view('templates/main_header');?>
    <div class="page-content-wrapper">
        <div class="content">
            <form id="form_purchase_view" role="form" method ="post" action="<?php echo base_url().'index.php/Purchase/update/'.$p_id; ?>" enctype="multipart/form-data">
            <div class=" container-fluid   container-fixed-lg">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Purchase/checkstatus/All">Property List</a></li>
                    <li class="breadcrumb-item active">Property View</li>
                </ol>

                <div class="container">
                    <div class="row">
                        <div class="card card-transparent  bg-white " style="background:#fff;">
                            <div class=" " style="padding:10px;">
                                <a href="<?php echo base_url().'index.php/Purchase'; ?>">
                                    <div class="fileUpload blue-btn btn width100 pull-left">
                                        <span><i class="fa fa-arrow-left"></i></span> 
                                    </div>
                                </a>
                                <div class="dropdown pull-right hidden-md-down">
                                    <button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="fileUpload blue-btn btn width100">
                                            <span><i class="fa fa-ellipsis-h"></i></span> 
                                        </div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                                        <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
                                            <a href="<?php echo base_url().'index.php/Purchase/edit/'.$p_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
                                        <?php } }  ?>

                                        <!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

                                        <?php if(isset($p_txn)) { ?>
                                        <?php if($p_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                                            <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
                                        <?php } } } else if($p_txn[0]->modified_by != '' && $p_txn[0]->modified_by != null) { if($p_txn[0]->modified_by!=$purchaseby) { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                            <a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
                                            <a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
                                        <?php } } } } else { ?>
                                            <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
                                            <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
                                        <?php } } else if($p_txn[0]->created_by != '' && $p_txn[0]->created_by != null) { if($p_txn[0]->created_by!=$purchaseby && $p_txn[0]->txn_status != 'In Process') { if($p_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                            <a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
                                            <a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
                                        <?php } } } } else { ?>
                                            <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
                                            <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i>  <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
                                        <?php } } } ?>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-3" style="background: linear-gradient(45deg, #39414d 0%, #39414d 25%, #444c59 51%, #4c5561 78%, #4e5663 100%); padding-right: 15px;padding-left: 15px;">
                          
                           
                          <div class="p-t-20">
		                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($p_txn[0]->p_image)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
		                            <!-- <input type="file" name="image" id="image-upload" /> -->
		                            <!-- <img src="<?php //echo base_url().$sub_property[0]->c_image; ?>"> -->
		                        </div>
		                        <!-- <div id="image-label_field">
		                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
		                        </div> -->
		                    </div>
                          
                            <hr>
                               <div class="row ">
                                <div class="col-md-12">
                                    <span class="title_1"> <?php if(isset($p_txn)) { echo $p_txn[0]->p_property_name; } ?> </span>
                                    <span class="email  p-t-15"><?php if(isset($p_txn)) { echo get_address($p_txn[0]->p_address, $p_txn[0]->p_landmark, $p_txn[0]->p_city, $p_txn[0]->p_pincode, $p_txn[0]->p_state, $p_txn[0]->p_country); } ?></span>
                                    <span class="title_1  p-t-15  p-b-15"><?php if(isset($r_txn)) {if(count($r_txn)>0) echo 'OCCUPIED'; else echo 'VACANT';} else echo 'VACANT'; ?></span>
                                    <span class="tenant_count"> 
								
						<p class="tags-btn line-link" style="float:left;margin-left:0px;"><?=$tenant_count //if(isset($r_txn)) {if(count($r_txn)>0) echo '1'; else echo '0';} else echo '0'; ?> Tenant </p>
                                      <p class="tags-btn line-link"style="float:right;margin-right:0px;"><?=$maintenance_count?> Maintenances </p>
                                    </span>
                                </div>
                            </div>
                            <div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(255,255,255,0.1);">
                                <div class="row">
                                    <div class="col-md-6 rent">
                                       <a href="<?php echo base_url().'index.php/sale/checkstatus/All/'.$p_id;  ?>"> <i style="font-size:22px;" class="fa fa-th-list"></i><br>
                                        Sale</a>
                                    </div>
                                    <div class="col-md-6 rent" style="border-right:none;">
                                        <a href="<?php echo base_url().'index.php/loan/checkstatus/All/'.$p_id;  ?>"><i style="font-size:22px;" class="fa fa-money"></i><br>
                                        Loan</a>
                                    </div>
                                    <div class=" col-md-6 leases">
                                        <a href="<?php echo base_url().'index.php/rent'; ?>"><i style="font-size:22px;" class="fa fa-home "></i><br>
                                        Rent</a>
                                    </div>
                                    <div class=" col-md-6 leases" style="border-right:none;">
                                        <a href="<?php echo base_url().'index.php/task/checkstatus/'.$p_id; ?>"><i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
                                        Maintenance</a>
                                    </div>
                                </div>
                            </div> 
                            <div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="invoice_box" style="background:rgba(0,0,0,0.2);">
							<div class="row">
                                <div class=" col-md-12">
                                    <span class="invoice"><a href="<?php echo base_url().'index.php/Purchase/view/'.$p_id.'/true'; ?>"><button class="btn btn-success btn-xs invoice" type="button"><span>View Property </span></button></a></span>
                                </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row  p-t-10">
                                <div class="col-md-12">
                                    <iframe id="map" style="border:none;width:100%;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCNy33uOQrIGSIdqfn_4MzP0AKOy2DR1o4&amp;q=19.111368%2C%2072.862375"></iframe>
                                </div>
                            </div>
                       
                             <!-- <h5 class="view-title" style="color:#fff">Documents</h5>
                            <?php 
                                /*if(isset($documents)) {
                                    $doc_no=0;
                                    for($i=0; $i<count($documents); $i++) { 
                                        if($documents[$i]->doc_document!= '') {*/
                            ?>
                            <div class="files-item m-t-20">
                                <div class="item-media"> 
                                    <div class="file-icon-lg ">
                                        <i class="fa fa-file" >
                                            <span data-type="pdf"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="item-title">
                                    <a target="_blank" title="Download" id="doc_file_download_<?php //echo $doc_no; ?>" href="<?//php echo base_url().$documents[$i]->doc_document; ?>"><?php //echo $documents[$i]->document_name; ?></a>
                                </div>
                            </div>-->
                            <?php 
                              //  $doc_no=$doc_no+1;
                                //}}} 
                            ?>
                        </div>

                        <div class="col-md-9">
                            <div class=" container-fluid container-fixed-lg bg-white">
                                <div class="card card-transparent all_info" >
                                    <p class="m-t-20"></p>
                                    <div class="a">
                                        <div class="row">
                                            <div class="col-md-7" id="accounting_dtl">
                                                <div class="row" style="border:1px solid rgba(0,0,0,0.07);">
                                                    <div class="col-md-12" style="width:100%;border-bottom:none;">
                                                        <p  class=" p-t-10" style="float:left"> <b>Accounting</b> </p>
                                                        <a class="p-t-10 p-r-10" style="float:right; color:#5cb85c" href="<?php echo base_url().'index.php/Accounting'; ?>">view all <i class="fa fa-angle-right"> </i> </a>
                                                    </div>
													
                                                    <table id="example4" class="table table-bordered table-striped view_prop" style="overflow-x:scroll">
                                                        <thead>
                                                            <tr style="height:0px!important">
                                                                <th> sr</th>
                                                                <th> Category </th>
                                                                <th> Amount </th>
                                                                <th> Paid </th>
                                                                <th> Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $j=0; for ($i=0; $i < count($bankentry) ; $i++) { ?>
                                                            <tr class="">
                                                                <td class="text-center"><?php echo $j+1; ?></td>
                                                                <td><?php echo $bankentry[$i]['particulars']; ?></td>
                                                                <td class="text-right"><?php echo format_money($bankentry[$i]['net_amount'],2); ?></td>
                                                                <td class="text-right"><?php echo format_money($bankentry[$i]['paid_amount'],2); ?></td>
                                                                <td>Paid</td>
                                                            </tr>
                                                            <?php $j++; } ?>
                                                            <?php for($i=0;$i<count($pendingbankentry);$i++) { ?>
                                                            <tr class="">
                                                                <td class="text-center"><?php echo $j+1; ?></td>
                                                                <td><?php echo $pendingbankentry[$i]['particulars']; ?></td>
                                                                <td class="text-right"> <?php echo format_money($pendingbankentry[$i]['net_amount'],2); ?></td>
                                                                <td class="text-right"><?php echo format_money($pendingbankentry[$i]['paid_amount'],2); ?></td>
                                                                <td>Unpaid</td>
                                                            </tr>
                                                            <?php $j++; } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="card card-default bg-success">
                                                    <div class="card-header  separator">
                                                        <div class="card-title" style="text-align:center;display:block">
                                                            <p><b>Sub Properties</b></p>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div id="chartMessages"></div>
                                                        <div style=""><a href="<?php echo base_url().'index.php/Allocation'; ?>" style="text-align:center;color:#5cb85c"><p style="font-size:14px; font-family:'Montserrat'!important">Add Unit</p></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									
									
									
									
									
									
									
									
									
									

                                    <div class="a">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <p class="unit"><?php if(isset($p_txn)) { echo $p_txn[0]->p_display_name; } ?><p>
                                                    <div class="sq">
                                                        <?php if(isset($p_txn)) { echo $p_txn[0]->p_type; } ?> / 
                                                        <?php if(isset($p_description)) { if(count($p_description)>0) { 
                                                            echo format_money($p_description[0]->pr_agreement_area,2); }} ?> 
                                                        <?php if(isset($p_description))  { if(count($p_description)>0) 
                                                            echo $p_description[0]->pr_agreement_unit; } ?>
                                                    </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row ">
                                            <?php if(isset($r_txn)) { if(count($r_txn)>0) { ?>
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Tenant</b></li>
                                                    <li> <?php if(isset($r_txn)) {if(count($r_txn)>0) echo $r_txn[0]->owner_name; } ?> </li>
                                                    <li> <?php if(isset($r_txn)) {if(count($r_txn)>0) echo $r_txn[0]->c_emailid1; } ?> </li>
                                                </ul>
                                            </div>
                                            <?php }} ?>
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Owners</b></li>
                                                    <?php 
                                                    if(isset($p_ownership)) { 
                                                        for ($j=0; $j < count($p_ownership) ; $j++) {
                                                            for ($k=0; $k < count($contact) ; $k++) { 
                                                                if($contact[$k]->c_id==$p_ownership[$j]->pr_client_id) { 
                                                                    echo '<li>'.$contact[$k]->contact_name.'</li>';
                                                                }
                                                            }
                                                        }
                                                    } 
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                        $bl_view_txn=false;
                                        if(isset($r_txn)) { if(count($r_txn)>0) $bl_view_txn=true; } 
                                        if(isset($l_txn)) { if(count($l_txn)>0) $bl_view_txn=true; }
                                        if($bl_view_txn==true) { 
                                    ?>
                                    <div class="a">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <?php if(isset($r_txn)) { if(count($r_txn)>0) { ?>
                                                    <div class="col-lg-6">
                                                        <div class="card card-default bg-success " >
                                                            <div class="card-header  separator">
                                                                <div class="card-title" style="text-align:center;display:block">
                                                                    <p style="float:left"><b>Maintenance Details</b> </p>
                                                                   <a href="<?php echo base_url().'index.php/task/checkstatus/'.$p_id; ?>" ><p style="float:right;color:#5cb85c"><b> View details <i class="fa fa-angle-right"></i></b> </p> </a>
                                                                </div>
                                                            </div>
                                                            <div class="card-block" style="padding-bottom:54px;">
                                                                <div id="chartMessages1"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>

                                                    <?php if(isset($l_txn)) { if(count($l_txn)>0) { ?>
                                                    <div class="col-md-6">
                                                        <div class="card card-default bg-success">
                                                            <div class="card-header  separator">
                                                                <div class="card-title" style="text-align:center;display:block">
                                                                    <p style="float:left"><b>Loan </b></p>
                                                                    <a href="<?php echo base_url().'index.php/loan/checkstatus/All/'.$p_id;  ?>" style=""><p style="float:right;color:#5cb85c"><b> View details <i class="fa fa-angle-right"></i> </b></p> </a>
                                                                </div>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="row clearfix">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Loan Amount</label>
                                                                            <input type="text" class="form-control format_number" name="amount" id="amount" placeholder="Amount" value="&#x20B9;<?php if(isset($l_txn)) { echo format_money($l_txn[0]->disbursement_amount,2);} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label> Paid Amount</label>
                                                                            <input type="text" class="form-control format_number" name="paid_amount" id="paid_amount" placeholder="Paid Amount"value="&#x20B9;<?php if(isset($l_txn)) { echo format_money($l_txn[0]->tot_principal,2);} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Outstanding</label>
                                                                            <input type="text" class="form-control format_number" name="tot_outstanding" id="tot_outstanding" placeholder="Outstanding" value="&#x20B9;<?php if(isset($l_txn)) { echo format_money($l_txn[0]->tot_outstanding,2);} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row clearfix">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label> Loan Tenure (IN months)</label>
                                                                            <input type="text" class="form-control format_number" name="term" id="term" placeholder="Term" value="<?php if(isset($l_txn)) { echo format_money($l_txn[0]->loan_term,2) ;} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Interest</label>
                                                                            <input type="text" class="form-control" name="interest_rate" placeholder="Interest Rate" value="<?php if(isset($l_txn)) { echo format_money($l_txn[0]->loan_interest_rate,2);} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>EMI</label>
                                                                            <input type="text" class="form-control format_number" name="emi" id="emi" placeholder="EMI" value="&#x20B9;<?php if(isset($l_txn)) { echo format_money($l_txn[0]->emi,2);} ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if(isset($r_txn)) { if(count($r_txn)>0) { ?>
                                    <div class="a" id="rent_div">
                                        <div class="col-md-12" ><p style="float:left"><b>Rent Details </b></p>
                                            <a href="<?php echo base_url().'index.php/rent/checkstatus/All/'.$p_id; ?>" style="float:right;color:#5cb85c"><b>View details <i class="fa fa-angle-right"></i></b></a>
                                        </div><br>
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Lease Period (IN months)</label>
                                                    <input type="text" class="form-control format_number" name="lease_period" id="lease_period"  value="<?php if(isset($r_txn)) { if(count($r_txn)>0) { echo $r_txn[0]->lease_period; }} ?> " readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label> Start Date</label>
                                                    <input type="text" class="form-control" name="possession_date" id="possession_date" onchange="calculatedate(); instchange(); opentable();" placeholder="Start Date" value="<?php if(isset($r_txn)) { if(count($r_txn)>0) { if($r_txn[0]->possession_date!=null && $r_txn[0]->possession_date!='') echo date('d/m/Y',strtotime($r_txn[0]->possession_date)); }} ?>" readonly />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>End Date</label>
                                                    <input type="text" class="form-control" name="termination_date" id="termination_date" onchange="calculatedate(); instchange(); opentable();" placeholder="End Date" value="<?php if(isset($r_txn)) { if(count($r_txn)>0) { if($r_txn[0]->termination_date!=null && $r_txn[0]->termination_date!='') echo date('d/m/Y',strtotime($r_txn[0]->termination_date)); }} ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label> Free Rent Period (IN months) </label>
                                                    <input type="text" class="form-control format_number" name="free_rent_period" id="free_rent_period"  value="<?php if(isset($r_txn)) { if(count($r_txn)>0) { echo $r_txn[0]->free_rent_period; }} ?> " readonly /> 
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Rent<label>
                                                    <input type="text" class="form-control format_number" name="rent_amount" id="rent_amount" onchange="instchange(); opentable();" placeholder="Amount" value="&#x20B9;<?php if(isset($r_txn)) { if(count($r_txn)>=0) { echo format_money($r_txn[0]->rent_amount,2); }} ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Deposit</label>
                                                    <input type="text" class="form-control format_number" name="deposit_amount" id="deposit_amount" placeholder="Amount" value="&#x20B9;<?php if(isset($r_txn)) { if(count($r_txn)>0) { echo format_money($r_txn[0]->deposit_amount,2); }} ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Notice Period (IN months)</label>
                                                    <input type="text" class="form-control format_number" name="notice_period" id="notice_period"  value="<?php if(isset($r_txn)) { if(count($r_txn)>0) { echo $r_txn[0]->notice_period; }} ?> " readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                    
                                    <?php $this->load->view('templates/document_view');?>

                                    <?php if(isset($s_txn)) { if(count($s_txn)>0) { ?>
                                    <div class="a" id="sales_div">
                                        <div class="col-md-12" ><p style="float:left"><b > Sale Details </b></p>
                                            <a href="<?php echo base_url().'index.php/sale/checkstatus/All/'.$p_id ?>" style="float:right;color:#5cb85c"><b>View details <i class="fa fa-angle-right"></i></b></a>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Buyer</b></li>
                                                    <?php for($i=0; $i<count($s_txn); $i++) {
                                                        echo '<li> '.$s_txn[$i]->owner_name.' </li>';
                                                    } ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b> Price </b></li>
                                                    <?php for($i=0; $i<count($s_txn); $i++) {
                                                        echo '<li> &#x20B9; '.$s_txn[$i]->share_percent.' </li>';
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script  type="text/javascript">
    jQuery(
    function($){
        var q=encodeURIComponent('<?php if(isset($p_txn)) { echo $p_txn[0]->p_googlemaplink; } ?>');
        $('#map').attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyCNy33uOQrIGSIdqfn_4MzP0AKOy2DR1o4&q='+q);
    });
</script>


<script>
    var chart = c3.generate({
        bindto: '#chartMessages',
        data: {
            columns: [
                ['vacant', <?php if(isset($property_cnt[0]->vacant_cnt)) echo $property_cnt[0]->vacant_cnt; ?>],
                ['occupied', <?php if(isset($property_cnt[0]->rent_cnt)) echo $property_cnt[0]->rent_cnt; ?>]
            ],
            type: 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },

        donut: {
            label: {
                format: function(value) {
                    return value;
                },
        show: true, // to turn off the min/max labels.
    },
    min: 0,
        max: 100, // 100 is default
        // units: 'Remaining',
        width: 4, // for adjusting arc thickness
    },

    legend: {
        position: 'bottom'
    },
    size: {
        height: 170
    }
    });
</script>
<script>
    var chart = c3.generate({
        bindto: '#chartMessages1',
        data: {
            columns: [
            ['new', 0],['in progress', 0],[' resolved', 2],[' deferred', 0]

            ],
            type: 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: {
            label: {
                format: function(value) {
                    return value;
                },
                show: true, // to turn off the min/max labels.
            },
            min: 0,
            max: 100, // 100 is default
            // units: 'Remaining',
            width: 4, // for adjusting arc thickness
        },
        legend: {
            position: 'right'
        },
        size: {
            height: 150
        }
    });
</script>
</body>
</html>
