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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/software-details.css'; ?>"/>
        <!-- EOF CSS INCLUDE -->                                          
		<style>
		 @media only screen and  (min-width:280px)  and (max-width:480px) {.box-shadow-inside { padding:10px!important;}  }
	 @media screen and (max-width:767px) {  
.custom-padding{}
  .custom-padding .control-label{ padding:0;}
  .custom-padding .rspns-pdng, .custom-padding .col-md-7, .custom-padding .col-md-8, .custom-padding .col-md-9,.custom-padding .col-md-11 { padding:0;}
 .row [class^='col-xs-'], [class^='col-sm-'], [class^='col-md-'], [class^='col-lg-'] {
    margin-bottom: 5px;
}
.custom-padding .form-group   { padding:10px; padding-bottom:0;}
.full-width { padding:15px;}
  
  .table-responsive { margin:0; padding:0;}
  .custom-padding .col-md-2{ padding:0 10px!important;}
  .custom-padding .sr { text-align:left; margin-top:10px;}
  .custom-padding .col-md-4 { text-align:left; }
  .custom-padding .col-md-10{ padding-top:0!important;}
  .btn-display { display:flex;}
  }

  
   @media only screen and  (min-width:280px)  and (max-width:1020px) { 
   .heading-h2{ display:block;}
    .custom-padding .rspns-pdng, .custom-padding .col-md-7, .custom-padding .col-md-8, .custom-padding .col-md-9{ padding:0;}

  }
</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Document_type_master'; ?>" >Document Type Master List  </a>  &nbsp; &#10095; &nbsp; Document Type Master</div>
                <!-- PAGE CONTENT WRAPPER -->
             	<div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">  
              		
						
                          <div class="box-shadow" style="padding-top:10px;">  
                        <form method="post" id="form_documet_type" action="<?php if(isset($document_type)) { echo base_url().'index.php/document_type_master/updateRecord/'.$d_type_id;} else {echo base_url().'index.php/document_type_master/saveRecord';} ?>">
						   <div class="box-shadow-inside custom-padding">
                               <div class="col-md-12" style="padding-left:10px; padding-right:10px;">
                               <div class="panel panel-default">
							<div class="panel-body">  
                                <div class="form-group"  >
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="col-md-4 col-sm-5 col-xs-12 control-label">Document Type *</label>
                                        <div class="col-md-8 col-sm-7 col-xs-12">
                                            <input type="hidden" class="form-control" name="d_type_id" id="d_type_id" value="<?php if(isset($d_type_id)) { echo $d_type_id; } ?>"/>
                                            <input type="text" class="form-control" name="d_type" id="d_type" placeholder="Document Type" value="<?php if(isset($document_type)){ echo $document_type[0]->d_type; } ?>"/>
                                        </div>
                                    </div>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="col-md-4 col-sm-5 col-xs-12 control-label">Mandatory *</label>
                                        <div class="col-md-8 col-sm-7 col-xs-12" style="line-height: 30px;">
                                            <input type="radio" value="Yes" class="icheckbox" checked name="d_m_status" <?php if(isset($document_type)){if($document_type[0]->d_m_status=="Yes"){echo "checked";}} ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" value="No" class="icheckbox" name="d_m_status" <?php if(isset($document_type)){if($document_type[0]->d_m_status=="No"){echo "checked";}} ?>/>&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
									<br clear="all"/>
                               </div>
                                </div>
                            </div>
                            <br clear="all"/>
							
							</div>
                            </div>   
							
                            <div class="panel-footer">
                                <a class="btn btn-danger" href="<?php echo base_url();?>index.php/Document_type_master">Cancel</a>
                                <button class="btn btn-success pull-right">Save</button>
                            </div>
                        </form>       
										
					</div>
                    </div>
                    </div>  
                </div>
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
		<script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    </body>
</html>