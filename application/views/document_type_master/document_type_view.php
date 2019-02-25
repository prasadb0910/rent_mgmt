<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="<?php echo base_url(); ?>image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		<style >
        	/*.lable-box { padding:8px ; font-weight:500; background:#f9f9f9; width:100%;  } */
			.control-label { padding:8px 0;  }
			.form-group { border:1px solid #f9f9f9; border-bottom:none; background:#fcfcfc; margin-bottom:1px;}
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
               <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                             	<div class="panel-heading">
                                	<h3 class="panel-title"><strong>Document View</strong></h3>
                                   	<a href="<?php echo base_url()?>index.php/document_type_master" > <span class="btn btn-default pull-right btn-font"> Cancel </span>  </a>
								   	<a href="<?php echo base_url() . 'index.php/document_type_master/editRecord/' . $document_type[0]->d_type_id; ?>" class=""><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group" style="border-top:1px dotted #f9f9f9;">
										<div class="col-md-6" >
											<label class="col-md-4 control-label"><strong>Document Type: </strong></label>
											<div class="col-md-8">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php if(isset($document_type)){ echo $document_type[0]->d_type; } ?></label>
											</div>
										</div>
                                        <div class="col-md-6">
											<label class="col-md-4 control-label"><strong>Mandatory: </strong></label>
											<div class="col-md-8">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php if(isset($document_type)){ echo $document_type[0]->d_m_status; } ?> </label>
											</div>
										</div>
                                    </div>
                                </div>
							</form>
						</div>
						</div>
						
						<div class="col-md-1"></div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
    </body>
</html>