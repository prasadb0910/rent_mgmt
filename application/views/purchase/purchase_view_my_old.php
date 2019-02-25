<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <style>
        .prev,
        .next {
          cursor: pointer;
          position: absolute;
          top: 50%;
          width: auto;
          padding: 16px;
          margin-top: -50px;
          color: white;
          font-weight: bold;
          font-size: 20px;
          transition: 0.6s ease;
          border-radius: 0 3px 3px 0;
          user-select: none;
          -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
          right: 0;
          border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
          background-color: rgba(0, 0, 0, 0.8);
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
        </style>

        </style>
        <style>
        .edit
        {

          color:#41a541!important;
        }
        .delete
        {
          color:#da5050!important;
        }
        .print
        {
          color:#fe970a!important;
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
        }
        .contact_card
        {
          border-radius:5px!important;
        }
        .rent
        {


          border-right:2px solid #edf0f5;
          padding: 6px 10px;
          text-align:center;
          color:#40434b;
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
          color:#40434b;
          border-right:2px solid #edf0f5;
          border-color: rgba(255,255,255,0.1) !important;
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
        #pricing_box:before
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

        .block1
        {
          padding: 20px 20px;
          border: 2px solid #edf0f5;
          border-radius: 7px;
          background: #f6f9fc;
          margin-top: 10px;
          margin-bottom: 10px;
        }
        p{
          font-weight: 200px!important;
        }

        .month 
        {
          background:#f6f9fc;
        }

        .prop_sq li
        {
          list-style-type:none!important;
        }

      </style>

      <style>
        .dot {
          height: 115px;
          width: 115px;
          border: 1px solid #0facf352;
          border-radius: 50%;
          display: block;
          font-size: 15px;
          text-align: center;
          line-height: 115px;
          margin:0 auto;
        }
        .unit
        {
          font-weight:400!important;
          font-size:18px!important;
          padding-left: 40px;
        }	
        .sq
        {
          font-weight:300;
          font-size:14px;
          padding-left: 40px;
        }
        .view_prop
        {

          width: 100%!important;
          max-width: 100%!important;
          border:1px solid rgba(0,0,0,0.07)!important;
        }

        .files-item {
          padding: 15px;
          position: relative;
          width: 65px;
          height: 70px;
          border: 2px solid #e6ebf1;
          display: -webkit-box;
          display: -webkit-flex;
          display: -ms-flexbox;
          display: flex;
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
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
    <?php $this->load->view('templates/main_header');?>
    <div class="page-content-wrapper ">
        <div class="content">
            <form id="form_purchase_view" role="form" method ="post" action="<?php echo base_url().'index.php/Purchase/update/'.$p_id; ?>" enctype="multipart/form-data">
            <div class="container-fluid container-fixed-lg">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Purchase/checkstatus/All">Property List</a></li>
                    <li class="breadcrumb-item active">Property View</li>
                </ol>
                <div class="container">
                    <div class="row m-t-20">
                        <div class="card card-transparent  bg-white" style="background:#fff;margin-right:8px;">
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
                                            <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
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
                                            <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
                                        <?php } } } ?>

                                        <a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-3" style="background:#fff;">
                            <div class="mySlides p-t-30">
                                <div class="numbertext">1 / 3</div>
                                <img src="<?php if (isset($p_txn)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>" style="width:100%">
                            </div>
                            <div class="mySlides p-t-30">
                                <div class="numbertext">2 / 3</div>
                                <img src="assets/img/csv.png" style="width:100%">
                            </div>
                            <div class="mySlides p-t-30">
                                <div class="numbertext">3 / 3</div>
                                <img src="<?php if (isset($p_txn)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>" style="width:100%">
                            </div>
                            <div class="row  p-t-20">
                                <div class="col-md-4">
                                    <img class="demo cursor" src="<?php if (isset($p_txn)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>" style="width:100%;max" onclick="currentSlide(1)" alt="Nature and sunrise">
                                </div>
                                <div class="col-md-4">
                                    <img class="demo cursor" src="<?php echo base_url(); ?>assets/img/csv.png" style="width:100%" onclick="currentSlide(2)" alt="Trolltunga, Norway">
                                </div>
                                <div class="col-md-4">
                                    <img class="demo cursor" src="<?php if (isset($p_txn)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>" style="width:100%" onclick="currentSlide(3)" alt="Mountains and fjords">
                                </div>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-md-12">
                                    <span class="title_1"> <?php if(isset($p_txn)) { echo $p_txn[0]->p_property_name; } ?> </span>
                                    <span class="email  p-t-15"><?php if(isset($p_txn)) { echo get_address($p_txn[0]->p_address, $p_txn[0]->p_landmark, $p_txn[0]->p_city, $p_txn[0]->p_pincode, $p_txn[0]->p_state, $p_txn[0]->p_country); } ?></span>
                                    <span class="title_1  p-t-15  p-b-15"><?php if(isset($r_txn)) {if(count($r_txn)>0) echo 'OCCUPIED'; else echo 'VACANT';} else echo 'VACANT'; ?></span>
                                    <span class=""> <p style="float:left"><?php if(isset($r_txn)) {if(count($r_txn)>0) echo '1'; else echo '0';} else echo '0'; ?> Tenant </p>
                                        <a><p style="float:right">2 Maintenances </p> </a>
                                </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row  p-t-20">
                                <div class="col-md-4">
                                    <div id="map" style="width:220px;height:200px;"></div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="view-title">Documents</h5>
                            <div class="files-item m-t-20">
                                <div class="item-media"> 
                                    <div class="file-icon-lg ">
                                        <i class="fa fa-file" >
                                            <span data-type="pdf"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="item-title">
                                    <a href="https://tenantcloud.s3-us-west-2.amazonaws.com/assets/lease_agreements/f/y/1/fy1emajwnznkbufj/original.pdf" target="_system" href="https://tenantcloud.s3-us-west-2.amazonaws.com/assets/lease_agreements/f/y/1/fy1emajwnznkbufj/original.pdf">Leas...ment.pdf</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class=" container-fluid   container-fixed-lg bg-white">
                                <div class="card card-transparent">
                                    <p class="m-t-20"></p>
                                    <div class="a">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12" style="border:1px solid rgba(0,0,0,0.07);width:100%"><p  class="p-l-10" style="float:left">Accounting </p>
                                                        <a style="float:right">view all >   </a>
                                                    </div>
                                                    <br>
                                                    <table class="view_prop">
                                                        <thead>
                                                            <tr>
                                                                <th> sr</th>
                                                                <th> Category </th>
                                                                <th> Amount </th>
                                                                <th> Paid </th>
                                                                <th> Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="month">
                                                                <td colspan="5" >01-01-2018</td>
                                                            </tr>
                                                            <tr class="">
                                                                <td>1</td>
                                                                <td>Rent</td>
                                                                <td>10000</td>
                                                                <td>0</td>
                                                                <td>Paid</td>
                                                            </tr>

                                                            <tr class="month">
                                                                <td colspan="5" >01-jan-2018</td>
                                                            </tr>
                                                            <tr class="">
                                                                <td>1</td>
                                                                <td>Rent</td>
                                                                <td>10000</td>
                                                                <td>0</td>
                                                                <td>Paid</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-default bg-success">
                                                    <div class="card-header  separator">
                                                        <div class="card-title" style="text-align:center;display:block"><p><b>Sub Properties</b></p>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <h3>
                                                        <span class="dot" style="0 auto;">1 Total</span>
                                                        <div style=""><p style="float:left">1 Occupied </p>
                                                            <a style="float:right"><p>0 Vacant</p></a>
                                                        </div>
                                                        <br>
                                                        <div style=""><a style="text-align:center"><p>Add Unit</p></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="a">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <p class="unit">Unit 1<p>
                                                <div class="sq">1 BED   /    1 BATH     /    500.00 Sq Ft
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Tenant</b></li>
                                                    <li> Raj Shah </li>
                                                    <li> dhaval.maru@pecanreams.com </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Tenant</b></li>
                                                    <li> Raj Shah </li>
                                                    <li> dhaval.maru@pecanreams.com </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="a">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="card card-default bg-success">
                                                            <div class="card-header  separator">
                                                                <div class="card-title" style="text-align:center;display:block">
                                                                    <p style="float:left"><b>Rent Details</b> </p>
                                                                    <a><p style="float:right"><b> View details ></b> </p> </a>
                                                                </div>
                                                            </div>
                                                            <div class="card-block">
                                                                <h3>
                                                                <span class="dot" style="float:left;">1 Total</span>
                                                                <div class="" style="text-align: center;">
                                                                    <div style=""><p>1 Pending </p></div>
                                                                    <div style=""><p>1 Resolved </p></div>
                                                                    <div style=""><p>1 In Process </p></div>
                                                                    <div style=""><p>1 Deferred </p></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-default bg-success">
                                                            <div class="card-header  ">
                                                                <div class="card-title" style="text-align:center;display:block">
                                                                    <p style="float:left"><b>Loan </b></p>
                                                                    <a><p	 style="float:right"><b> View details > </b></p> </a>
                                                                </div>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="row clearfix">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Loan Amount</label>
                                                                            <input type="text" class="form-control "  value="1,00,00,000" name="" id="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label> Paid Amount</label>
                                                                            <input type="text" class="form-control "  value="10,00,000" name="" id="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Outstanding</label>
                                                                            <input type="text" class="form-control "  value="95,00,000" name="" id="" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row clearfix">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label> Loan Tenure </label>
                                                                            <input type="text" class="form-control "  value="15 years" name="" id="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>Interest</label>
                                                                            <input type="text" class="form-control "  value="8%" name="" id="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group form-group-default ">
                                                                            <label>EMI</label>
                                                                            <input type="text" class="form-control "  value="Rs. 1,00,000" name="" id="" readonly>
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

                                    <div class="a">
                                        <div class="col-md-12" ><p style="float:left"><b>Rent Details </b></p>
                                            <a style="float:right"><b>View details > </b></a>
                                        </div><br>
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Lease Period</label>
                                                    <input type="text" class="form-control "  value="1 year" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label> Start Date</label>
                                                    <input type="text" class="form-control "  value="01-01-2017" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>End Date</label>
                                                    <input type="text" class="form-control "  value="01-01-2018" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label> Lockin Period</label>
                                                    <input type="text" class="form-control "  value="3 Years" name="" id="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label> Free Rent Period </label>
                                                    <input type="text" class="form-control "  value="0 months" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Rent</label>
                                                    <input type="text" class="form-control "  value="Rs. 20,000 / Month" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Deposit</label>
                                                    <input type="text" class="form-control "  value="Rs. 1,00,000" name="" id="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default ">
                                                    <label>Notice Period
                                                    </label>
                                                    <input type="text" class="form-control "  value="1 Month" name="" id="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="a" id="kyc-section">
                                        <p class="m-t-20"><b>Document Details</b></p>
                                        <div class="block1">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default ">
                                                        <label class="">Documents Type</label><input type="text" class="form-control "  value="1" name="" id="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default ">
                                                        <label>Description</label><input type="text" class="form-control "  value="1" name="" id="" readonly>
                                                    </div>
                                                </div>
                                                    <div class="col-md-4">
                                                    <div class="form-group form-group-default ">
                                                        <label>Refernce No.</label><input type="text" class="form-control "  value="1" name="" id="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default ">
                                                        <label>Date Of Issue</label>
                                                        <input type="text" class="form-control "  value="1" name="" id="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default ">
                                                        <label>Date Of Expiry</label><input type="text" class="form-control "  value="1" name="" id="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix"> 
                                                <div class="btn btn-default-danger">
                                                    <span><i class="fa fa-download"></i>  Download</span>
                                                </div>&nbsp &nbsp 
                                                <div class="btn btn-default-warning">
                                                    <span><i class="fa fa-search"></i>  Preview</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="a">
                                        <div class="col-md-12" ><p style="float:left"><b> Sale Details </b></p>
                                            <a style="float:right"><b>View details > </b></a>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b>Buyer</b></li>
                                                    <li> Dhaval Maru </li>
                                                    <li>Aniket Patil</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="prop_sq">
                                                    <li><b> Price </b></li>
                                                    <li>1,50,00,000</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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

<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}
</script>
</body>
</html>
