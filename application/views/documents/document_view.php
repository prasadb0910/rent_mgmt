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
         <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/software-view.css'; ?>"/>  
	 
        <!-- EOF CSS INCLUDE -->                                      
	 
 <style> 
 @media only screen and (max-width:620px) { 
	.heading-h2 {
    display: block;   width: 100%;
}
 .responsive-margin {
    width: 100%;
    background: #fff;
    padding: 6px 15px 3px; margin-top:0px!important;
    text-align: right; margin:0;
}
}
 </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Documents'; ?>" > Documents List </a>  &nbsp; &#10095; &nbsp; Document View</div>
                             <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->
                                
                <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a>

                                       <a href="<?php echo base_url() . 'index.php/Documents/editRecord/' . $editdocuments[0]->d_id; ?>" class="btn-margin"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>

                      
                                   <a  class="btn-margin" href="<?php echo base_url()?>index.php/Documents" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>

                             
                                </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row  main-wrapper">
						   <div class="main-container">           
                            <div class="box-shadow">   
                         	  <div class="box-shadow-inside">

					 
						
                        <div class="col-md-12 " style="padding:0;">
						<div class="full-width custom-padding"  >
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">

                                  <div id="pdiv" >  
                                <div class="panel-body">
                                	
                                    <div class="form-group"  >
										<div class="col-md-6" >
										
												<label class="col-md-4 position-name control-label"><strong>Document Name: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php if(isset($editdocuments)){ echo $editdocuments[0]->d_documentname; } ?></label>
												</div>
										
										</div>
										<div class="col-md-6">
											
												<label class="col-md-4 position-name  control-label"><strong>Document Type: </strong></label>
												<div class="col-md-8 position-view ">
													<label class="col-md-12 control-label" style="text-align:left;">
				                                        <?php 
				                                        	$d_type='';
				                                        	if (isset($selected_document_type)) {
			                                        			for ($i=0; $i < count($document_type) ; $i++) { 
				                                        			if(in_array($document_type[$i]->d_type_id,$selected_document_type)){
				                                        				$d_type = $d_type . $document_type[$i]->d_type . ', ';
				                                        			}
				                                        		}
				                                        	}
				                                        	$d_type = substr($d_type, 0, strrpos($d_type, ", "));
				                                        	echo $d_type;
		                                        	 	?>
													</label>
												</div>
											
										</div>
										
									</div>
                                	<div class="form-group">
                                    	<div class="col-md-6">
											
												<label class="col-md-4 position-name  control-label"><strong>Description: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($editdocuments)){ echo $editdocuments[0]->d_description; } ?></label>
												</div>
											
										</div>
                                        
                                        <div class="col-md-6">
												<label class="col-md-4 control-label"><strong>Show Expiry Date: </strong></label>
												<div class="col-md-8">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php if(isset($editdocuments)){ echo $editdocuments[0]->d_show_expiry_date; } ?> </label>
												</div>
											
										</div>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<div class="col-md-6">
											
												<label class="col-md-4 position-name  control-label"><strong>Transaction Type: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($editdocuments)){ echo $editdocuments[0]->d_status; } ?></label>
												</div>
											
										</div>
                                        
                                        <div class="col-md-6">
											
												<label class="col-md-4 position-name  control-label"><strong>Sub Type: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php if(isset($editdocuments)){ echo $editdocuments[0]->d_t_type; } ?> </label>
												</div>
											
										</div>
                                    </div> 
                                    
                                    <div class="form-group print-border" style="border-bottom:0;">
                                    	<div class="col-md-6">
											
												<label class="col-md-4 position-name   control-label"><strong>Category: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php echo $doccatlist[0]; ?></label>
												</div>
											
										</div>
                                        
                                        <div class="col-md-6">
											
												<label class="col-md-4 position-name  control-label"><strong>Property  Type: </strong></label>
												<div class="col-md-8 position-view ">
												<label class="col-md-12 control-label" style="text-align:left;"> <?php echo $doctypelist[0]; ?></label>
												</div>
											
										</div>
                                    </div>
									
                                </div>
								
						 </div>
								
							</form>
						</div>
						</div>
						</div>
					      </div>
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
            var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        group_name: {
                                required: true
                        },
						status: {
                                required: true
                        },
						group_members: {
                                required: true
                        }
                    }                                        
                });
				
			$('#reset').click(function(){
				$('#jvalidate')[0].reset();
				$('.tagsinput').attr('value') = '';
			 });
			 
			$('.contact_id').click(function(){
				var members = "";
				
				$('#contacts tr').each(function() {
					var row = $(this);
					
					if (row.find('input[type="checkbox"]').is(':checked')) {
						members = members + $(this).find("td.Contact_name").html() + ',';
					}
					});
					
				alert(members);
				
				$('#group_members').attr('value', members);
				//$('input[name=group_members]').val(members);
				//$('#group_members').val(members);
			 });
        </script>
    <!-- END SCRIPTS -->      
    <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>

       $('.printdiv').click(function(){

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} table tr th:first-child{width:10%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 { }.col-md-6 { width:50%;}.full-width {padding:0!important;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');



              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>