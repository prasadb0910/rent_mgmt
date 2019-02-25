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
			input:read-only { 
			    background-color: white!important;
			}
		</style>

    </head>
    <body>
		<div class="page-container page-navigation-top">
         	<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <?php $this->load->view('templates/menus');?>
				<div class="heading-h2">
					<a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; 
					<a href="<?php echo base_url().'index.php/Purchase'; ?>" > Purchase List</a>  &nbsp; &#10095; &nbsp; 
					Purchase Details 
				</div>
				<div class="page-content-wrap">
					<div class="row main-wrapper">
						<div class="main-container">           
							<div class="box-shadow custom-padding"> 
								<form id="form_payment_details" action="<?php echo base_url().'index.php/Payment/save'; ?>" method="POST" class="form-horizontal">
						            <div class="box">
						            <div class="box-header">
						                <h4 class="pull-left"><b>Payment Details</b></h4>
						                <a href="<?php echo base_url().'index.php/Payment'; ?>" class="btn btn-primary btn-sm pull-right">Back</a>
						            </div>
						            <div class="box-body">
						                {{csrf_field()}}
						                <div class="form-group">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">User Name</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="hidden" class="form-control" name="id" value="<?php if(isset($data[0])) echo $data[0]->id;?>">
						                        <input type="text" class="form-control" name="user_name" value="<?php if(isset($data[0])) echo $data[0]->user_name;?>" placeholder="Enter User Name..." readonly>
						                    </div>
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Plan Name</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="plan_name" value="<?php if(isset($data[0])) echo $data[0]->plan_name;?>" placeholder="Enter Plan Name..." readonly>
						                    </div>
						                </div>
						                </div>
						                <div class="form-group">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice No</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="invoice_no" value="<?php if(isset($data[0])) echo $data[0]->invoice_no;?>" placeholder="Enter Invoice No..." readonly>
						                    </div>
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">No Of Properties</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="no_of_properties" value="<?php if(isset($data[0])) echo $data[0]->no_of_properties;?>" placeholder="Enter No Of Properties..." readonly>
						                    </div>
						                </div>
						                </div>
						                <div class="form-group">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Method</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <select class="form-control" id="payment_method" name="payment_method">
						                            <option value="">Select Payment Method</option>
						                            <option value="Cash" <?php if(isset($data[0])) {if($data[0]->payment_method=="Cash") echo "Selected";}?>>Cash</option>
						                            <option value="Cheque" <?php if(isset($data[0])) {if($data[0]->payment_method=="Cheque") echo "Selected";}?>>Cheque</option>
						                        </select>
						                    </div>
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Date</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control datepicker" name="payment_date" value="<?php if(isset($data[0])) echo Carbon\Carbon::parse($data[0]->payment_date)->format('d/m/Y');?>" placeholder="Select Payment Date..."  readonly>
						                    </div>
						                </div>
						                </div>
						                <div class="form-group">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label" style="padding-right: 0px;">Payment Ref / Cheque No</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="payment_ref" value="<?php if(isset($data[0])) echo $data[0]->payment_ref;?>" placeholder="Enter Payment Ref...">
						                    </div>
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Transaction Amount</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="transaction_amount" value="<?php if(isset($data[0])) echo $data[0]->transaction_amount;?>" placeholder="Enter Transaction Amount..."  readonly>
						                    </div>
						                </div>
						                </div>
						                <div class="form-group chq_dtl">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Name</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="bank_name" value="<?php if(isset($data[0])) echo $data[0]->bank_name;?>" placeholder="Enter Bank Name...">
						                    </div>
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Branch</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control" name="branch" value="<?php if(isset($data[0])) echo $data[0]->branch;?>" placeholder="Enter Branch...">
						                    </div>
						                </div>
						                </div>
						                <div class="form-group chq_dtl">
						                <div class="col-md-12 col-sm-12 col-xs-12">
						                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cheque Date</label>
						                    <div class="col-md-4 col-sm-4 col-xs-12">
						                        <input type="text" class="form-control datepicker" name="cheque_date" value="<?php if(isset($data[0])) echo Carbon\Carbon::parse($data[0]->cheque_date)->format('d/m/Y');?>" placeholder="Select Cheque Date..."  readonly>
						                    </div>
						                </div>
						                </div>
						            </div>
						            @if(!Route::is('user_payment_detail.details'))
						            <div class="box-footer">
						                <a href="<?php echo base_url().'index.php/Payment'; ?>" class="btn btn-danger btn-sm">Cancel</a>
						                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
						            </div>
						            </div>
						            @endif
						        </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php $this->load->view('templates/footer');?>

		<script>
			$(document).ready(function(){
		        show_chq_dtl();
		    });
		    $('#payment_method').change(function(){
		        show_chq_dtl();
		    });
		    var show_chq_dtl = function(){
		        if($('#payment_method').val()=="Cheque"){
		            $('.chq_dtl').show();
		        } else {
		            $('.chq_dtl').hide();
		        }
		    }
    	</script>
    </body>
</html>