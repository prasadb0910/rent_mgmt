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
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			th{text-align:center;}
			.center{text-align:center;}
		</style>
 <style type="text/css">
            
.page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;   }
.dataTables_filter { border-bottom:0!important; }
.heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px; /*padding-bottom: 0;*/      border-bottom: 1px solid #ddd;}
.heading-h2 a{  color: #444;     }
/*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
  border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
.nav-contacts {/* float: right; width: 55%;*/ }
.main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
.main-container {margin:0 12px; margin-bottom: 20px; } 
h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
.box-shadow {margin-top: 20px; width:100%;
background: #fff; box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; display: inline-block;}
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important;}
.btn-container {  }
.btn-top { margin-top: 10px!important; }
.box-shadow-inside {  display: flex; }
.panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
.panel { margin: 0; border-radius: 0!important; box-shadow: none; border: 1px dotted #ddd!important; border-bottom: none!important }
.panel-heading {border-radius: 0; }

.form-control {
    display: block;
    width: 100%;
    padding: 10px 6px!important;
    height: 35px;
    font-size: 12px;
    line-height: 1.42857143;
    font-weight: 500;
    color: #0b385f;
    background-color: white;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 0px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.03);
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}

.btn-primary { padding:6px 10px; }
.table-responsive {  min-height: .01%; overflow-x: auto;  margin: 15px;}
.remark-container {padding: 10px;}
.panel-footer { padding: 10px 10px; }
        </style>		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>

                

                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Assign/form_admin_user_assign_details'; ?>" > User List  </a>  &nbsp; &#10095; &nbsp;User Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
                    <div class="main-container">               
						 <div class="box-shadow" style="padding-top:10px;">  
                            <form id="form_admin_user_assign_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($user)) echo base_url(). 'index.php/Assign/updateadminuser/' . $user[0]->c_id; else echo base_url().'index.php/Assign/saveadminuser'; ?>">
                                   <div class="box-shadow-inside">
                                 <div class="col-md-12" >
                               <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group" style="    ">
										<div class="col-md-12">
											
												<label class="col-md-1 control-label">Full Name <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-3">
                                                    <input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if(isset($user)) echo $user[0]->c_id;?>"/>
                                                    <input type="text" class="form-control" name="con_first_name" placeholder="First Name" value="<?php if(isset($user)) echo $user[0]->c_name;?>"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="con_middle_name" placeholder="Middle Name" value="<?php if(isset($user)) echo $user[0]->c_middle_name;?>"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="con_last_name" placeholder="Last Name" value="<?php if(isset($user)) echo $user[0]->c_last_name;?>"/>
                                                </div>
											
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
                                            <label class="col-md-1 control-label">Email ID <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="con_email_id1" id="con_email_id1" placeholder="Email ID" value="<?php if(isset($user)) echo $user[0]->c_emailid1;?>"/>
                                            </div>
                                            <label class="col-md-4 control-label" style="text-align:right;">Mobile No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="con_mobile_no1" placeholder="Mobile No" value="<?php if(isset($user)) echo $user[0]->c_mobile1;?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($user)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-12">
                                            <label class="col-md-1 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-3">
                                                <select class="form-control" name="con_status">
                                                    <option value="Approved" <?php if(isset($user)) {if ($user[0]->c_status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="Rejected" <?php if(isset($user)) {if ($user[0]->c_status=='Rejected') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                            <label class="col-md-4 control-label">Remarks <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <textarea style="overflow: hidden; text-align:justify;" class="form-control" name="con_txn_remarks"><?php if(isset($user)) echo $user[0]->txn_remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 </div>
                                  </div>
                        </div>   
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/assign/adminuser" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right">Save</button>
                                </div>
							</form>
							
						
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>