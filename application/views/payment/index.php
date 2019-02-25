<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>" />
    </head>
    <body>
        <div class="page-container page-navigation-top">
			<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
            	<?php $this->load->view('templates/menus');?>
               	<div class="heading-h2">
               		<a href="<?php echo base_url().'index.php/dashboard'; ?>"> Dashboard </a> &nbsp; &#10095; &nbsp; 
               		Payment  List
               	</div>
              	<div class="nav-contacts ng-scope" ui-view="@nav">
				  	<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
					 	<div class="container u-posRelative u-textRight">
						   	<!-- <div class="pull-left btn-top">
								<?php //if(isset($access)){ if($access[0]->r_insert == 1) {?>
									<a class="btn btn-default" href="<?php //echo base_url().'index.php/Payment/addnew'; ?>">
										<span class="fa fa-plus"> </span> Add Payment Details
									</a>
								<?php //} } ?>
							</div> -->
								
							<i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

							<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
								<li class="payments_done">
									<a  href="<?php echo base_url(); ?>index.php/Payment/checkstatus/payments_done">
										<span class="ng-binding">Payment Done</span>
											<span id="payments_done">(<?php if(isset($payments_done)) echo $payments_done; else echo 0; ?>)</span>
									</a>
								</li>

								<li class="payments_pending">
									<a  href="<?php echo base_url(); ?>index.php/Payment/checkstatus/payments_pending">
										<span class="ng-binding">Pending Payments</span>
											<span id="payments_pending">(<?php if(isset($payments_pending)) echo $payments_pending; else echo 0; ?>)</span>
									</a>
								</li>
							</ul>

							<i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
					   	</div>
				 	</div>
              	</div>

              	<ul class="topnav" id="myTopnav">
              		<li class="payments_done">
              			<a  href="<?php echo base_url(); ?>index.php/Payment/checkstatus/payments_done">
              				<span class="ng-binding">Payment Done</span>
              				<span id="payments_done">(<?php if(isset($payments_done)) echo $payments_done; else echo 0; ?>)</span>
              			</a>
              		</li>

              		<li class="payments_pending" >
              			<a  href="<?php echo base_url(); ?>index.php/Payment/checkstatus/payments_pending">
              				<span class="ng-binding">Pending Payments</span>
              				<span id="payments_pending">(<?php if(isset($payments_pending)) echo $payments_pending; else echo 0; ?>)</span>
              			</a>
              		</li>
              	</ul>
				
              	<div class="page-content-wrap">
              		<div class="row  main-wrapper">
              			<div class="main-container">
              				<div class="col-md-12" style="padding:0;">
              					<div class="panel panel-default inside-width" style="border:none;box-shadow:none;">
              						<?php $this->load->view('templates/download');?>
              						<div class="panel-body">
              							<div class="table-responsive">
              								<table id="customers2" class="table datatable table-bordered">
              									<thead>
              										<tr>
                                    <th>Sr. No</th>
				                            <th>Payment Date</th>
				                            <th>Invoice No/Receipt no</th>
				                            <th>Plan Name</th>
				                            <th>No Of Properties Registered</th>
				                            <th>Payment Method</th>
				                            <th>Amount</th>
				                            <th>CGST</th>
				                            <th>SGST</th>
				                            <th>IGST</th>
				                            <th>Round Off Amount</th>
				                            <th>Total Amount</th>
              										</tr>
              									</thead>
              									<tbody>
              										<?php if (isset($data)) { for($i=0;$i<count($data); $i++ ) { ?>
              										<tr id="trow_<?php echo $i+1;?>">
              											<td style="padding:5px; text-align:center;"><?php echo ($i+1); ?></td>
              											<td style="padding:5px;"><?php echo ($data[$i]->payment_date!=null && $data[$i]->payment_date!='')?date('d/m/Y',strtotime($data[$i]->payment_date)):''; ?></td>
              											<td style="padding:5px;"><a href="<?php echo base_url().'index.php/Payment/get_invoice/'.$data[$i]->id; ?>" target="_blank"><?php echo $data[$i]->invoice_no; ?></a></td>
              											<td style="padding:5px;"><?php echo $data[$i]->plan_name; ?></td>
              											<td style="padding:5px;"><?php echo $data[$i]->no_of_properties; ?></td>
              											<td style="padding:5px;"><?php echo $data[$i]->payment_method; ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->amount,2); ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->cgst,2); ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->sgst,2); ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->igst,2); ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->round_off_amount,2); ?></td>
              											<td style="padding:5px;"><?php echo format_money($data[$i]->transaction_amount,2); ?></td>
              										</tr>
              										<?php }} ?>
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

        <?php $this->load->view('templates/footer');?>

	 	<script>
            $(document).ready(function() {
                var url = window.location.href;
                if(url.includes('payments_done')){
                    $('.payments_done').attr('class','active');
                } else if(url.includes('payments_pending')){
                    $('.payments_pending').attr('class','active');
                } else {
                	$('.payments_done').attr('class','active');
                }
            });
     	</script>
    </body>
</html>