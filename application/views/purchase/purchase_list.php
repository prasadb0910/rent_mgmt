<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

     <link href="<?php echo base_url(); ?>assets/css/prop_list.css" rel="stylesheet" />

    <style>
        <?php if($maker_checker!='yes') { ?>
            .approved {
                display: none !important;
            }
            .pending {
                display: none !important;
            }
            .rejected {
                display: none !important;
            }
        <?php } ?>
    </style>
</head>
<body class="fixed-header">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper">
    <div class="content ">
        <div class=" container-fluid container-fixed-lg">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Purchase List</a></li>
            </ol>

            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class="<?php if($checkstatus=='All') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/purchase/checkstatus/All">All(<?php echo $all; ?>)</a>
                    </li>
                    <li class="nav-item approved">
                        <a class="<?php if($checkstatus=='Approved') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Approved">Approved(<?php echo $approved; ?>)</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="<?php if($checkstatus=='Pending') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Pending">Pending(<?php echo $pending; ?>)</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="<?php if($checkstatus=='Rejected') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/purchase/checkstatus/Rejected">Rejected(<?php echo $rejected; ?>)</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class="<?php if($checkstatus=='InProcess') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/purchase/checkstatus/InProcess">Draft(<?php echo $inprocess; ?>)</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content"style="background:none;">
                    <div class="tab-pane sm-no-padding active slide-left" id="tab1">
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all">
                                        <div id="myDIV">
                                            <button class="btn1 active1 grid_btn" id="grid_btn_1"><i class="fa fa-th" aria-hidden="true"></i></button>
                                            <button class="btn1 list_btn" id="list_btn_1"><i class="fa fa-list" aria-hidden="true"></i></button>

                                            <a href="<?php echo base_url(); ?>index.php/sale"><button class="btn btn-default pull-right m-r-10" type="submit"> <span>Sold List</span></button></a>
											<a href="<?php echo base_url(); ?>index.php/sale/addnew"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-minus tab-icon"></i> <span>Sell</span></button></a>
											<a href="<?php echo base_url(); ?>index.php/purchase/addnew"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Add / Buy</span></button></a>
                                        </div>
                                        <br>
                                      
                                        <div class="row grid">
                                            <?php for($i=0; $i<count($property); $i++) { ?>
                                            <div class=" col-md-6">
                                                <div class="markup">
                                                    <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-4">
                                                                <img src="<?php echo base_url().$property[$i]->p_image; ?>" alt="Paris" class="prop_img m-t-20 m-l-20" style="width:180px"onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                            </div>
                                                            <div class=" col-md-8">
                                                                <div class="card-header ">
																   <div class="building_name"><b><?php echo $property[$i]->p_display_name; ?></b></div>
                                                                    <div class="owner_name"><H4 class="m-t-0 m-b-0"><?php echo $property[$i]->owner_name; ?></H4></div>
                                                                </div>
                                                                <div class="card-block">
                                                                    <p class=" flat_info m-t-0 m-b-0"><?php echo $property[$i]->p_type . ', ' . $property[$i]->pr_agreement_area . ' sf , ' . $property[$i]->p_status; ?></p>
																    <p class="avaibility m-t-0 m-b-0"><?php if(isset($property)) { if($property[$i]->prop_status=='Vacant') echo 'Vacant'; 
                                                                                                            else if($property[$i]->prop_status=='Sold') echo 'Sold On '.(($property[$i]->date_of_sale!=null && $property[$i]->date_of_sale!='')?date('d/m/Y',strtotime($property[$i]->date_of_sale)):''); 
                                                                                                            else if($property[$i]->prop_status=='Occupied') echo 'Occupied,Rent Expires On '.(($property[$i]->termination_date!=null && $property[$i]->termination_date!='')?date('d/m/Y',strtotime($property[$i]->termination_date)):''); } ?></p>
                                                                    <div class="address"><i class="fa fa-map-marker"></i> <?php if(isset($property)) { echo $property[$i]->p_apartment . '' . $property[$i]->p_address . ' ' . $property[$i]->p_landmark . ' ' . $property[$i]->p_state . ' ' . $property[$i]->p_city . ' ' . $property[$i]->p_pincode . ' ' . $property[$i]->p_country; } ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <div class="col-md-3 rent">
                                                                 <a href="<?php echo base_url() . 'index.php/contacts/checkstatus/All/Tenants/' . $property[$i]->txn_id; ?>"><i style="font-size:22px;" class="fa fa-group"></i><br>
                                                                Tenants
																	</a>
                                                            </div>
                                                            <div class=" col-md-3 leases">
																 <a href="<?php echo base_url().'index.php/Accounting/checkstatus/All/'.$property[$i]->txn_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
																	</a>
                                                            </div>
                                                       
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
															 <a href="<?php echo base_url().'index.php/task/checkstatus/'.$property[$i]->txn_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                Maintenance
																</a>
                                                            </div>
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
                                                                <a href="<?php echo base_url().'index.php/Allocation/checkstatus/All/'.$property[$i]->txn_id; ?>">
                                                                    <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                    Sub Property
                                                                </a>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-12">
                                                            <a href="<?php echo base_url().'index.php/Purchase/view/'.$property[$i]->txn_id; ?>" class=" pull-right invoice p-b-5     p-t-5" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row list">
                                            <?php for($i=0; $i<count($property); $i++) { ?>
                                            <div class=" col-md-12">
                                                <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                    <div class="row">
                                                        <img src="<?php echo base_url().$property[$i]->p_image; ?>" alt="Paris" class="prop_img" style="max-width:100%;max-height:100%;height:100px; width:100px;border:none;padding: 8px;" onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                        <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;width:35%">
															<div class="building_name"><?php echo $property[$i]->p_display_name; ?></div>
                                                            <div class="owner_name"><H4 class="m-t-0 m-b-0"><?php echo $property[$i]->owner_name; ?></H4></div>
                                                         
                                                            <div class="address"><i class="fa fa-map-marker"></i>  <?php if(isset($property)) { echo $property[$i]->p_apartment . ' ' . $property[$i]->p_address . ' ' . $property[$i]->p_landmark . ' ' . $property[$i]->p_state . ' ' . $property[$i]->p_city . ' ' . $property[$i]->p_pincode . ' ' . $property[$i]->p_country; } ?></div>
                                                        </div>
                                                        <p class=" flat_info m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 10px;width: 18%;"><?php echo $property[$i]->p_type . ', ' . $property[$i]->pr_agreement_area . ' sf , ' . $property[$i]->p_status; ?></p>
                                                     
														<p class="avaibility m-t-0 m-b-0pull-left" style="margin-top: 45px;padding-left: 10px;"><?php if(isset($property)) { if($property[$i]->prop_status=='Vacant') echo 'Vacant'; 
                                                                                                            else if($property[$i]->prop_status=='Sold') echo 'Sold On '.(($property[$i]->date_of_sale!=null && $property[$i]->date_of_sale!='')?date('d/m/Y',strtotime($property[$i]->date_of_sale)):''); 
                                                                                                            else if($property[$i]->prop_status=='Occupied') echo 'Occupied,Rent Expires On '.(($property[$i]->termination_date!=null && $property[$i]->termination_date!='')?date('d/m/Y',strtotime($property[$i]->termination_date)):''); } ?></p>
														
                                                        <div class="prop_btns">
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url() . 'index.php/contacts/checkstatus/All/Tenants/' . $property[$i]->txn_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Tenants"><i style="font-size:22px;" class="fa fa-group"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url().'index.php/Accounting/checkstatus/All/'.$property[$i]->txn_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Accounting"><i style="font-size:22px;" class="fa fa-inr"></i></a>
                                                            </div>
                                                           
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url().'index.php/task/checkstatus/'.$property[$i]->txn_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Maintenance"><i style="font-size:22px;" class="fa fa-file-text-o"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url().'index.php/Allocation/checkstatus/All/'.$property[$i]->txn_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Sub Property"><i style="font-size:22px;" class="fa fa-building-o"></i></a>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo base_url().'index.php/Purchase/view/'.$property[$i]->txn_id; ?>" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-left: 20px;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
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
    $(document).ready(function() {
        $('.list').hide();
        $('.grid_btn').on('click', function () {
            $('.grid').show();
            $('.list').hide();
            set_active_button($(this), 'list_btn');
        });
        $('.list_btn').on('click', function () {
            $('.grid').hide();
            $('.list').show();
            set_active_button($(this), 'grid_btn');
        });
    });
    var set_active_button = function(elem, btn){
        var id = elem.attr('id');
        var index = id.substring(id.lastIndexOf('_'));
        elem.addClass(' active1');
        $('#'+btn+index).removeClass('active1')
    }
</script>
</body>
</html>