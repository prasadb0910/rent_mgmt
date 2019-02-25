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
	 
                   body {  word-break: break-all;}
		</style>

                        <style type="text/css">

 .bootstrap-select.btn-group .dropdown-menu.inner {
	 min-height:1px !important;
	 height: 99px !important;
    overflow-y: auto;
	-ms-overflow-style:auto;
 }
 
.bootstrap-select:not([class*="span"]):not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
     width:100%;  
}
.show-tick { display: flex!important;padding: 0!important ; }
.bootstrap-select  {padding: 0!important; line-height: 35px;  }
.dropdown-menu > li > a {
    padding: 8px 15px;
    width: 100%;
    border-bottom: 1px solid #E9E9E9;
    line-height: 20px;
}
.non-transactional { padding: 0;  }
.Category { width: 12.3%; }
        </style>

        <style type="text/css">
  #document_details { padding: 10px;}  

.delete-btn a{ font-size:25px;  color: #333;  }
.delete-btn a:hover { color: #e90404; }

.delete_row  {font-size:25px; color: #333;   }
.delete_row:hover { color: #e90404;  }

.download-btn a{     font-size:25px;  color: #333;  }
.download-btn a:hover { color: #1caf9a; }
.btn-margin { padding: 10px 0px!important;    }
.table {  width: 100%;   max-width: 100%;  margin-bottom:0px;}
.panel-footer { padding: 10px; }
#transactional_type { line-height:30px;}
.Property-Type { line-height:30px;}
.non-transactional { line-height:30px;}
 @media only screen and  (min-width:250px)  and (max-width:500px) { .custom-padding .col-md-6{ padding-top:10px;} }
  @media only screen  and (max-width:850px) {.Category { width: 100%; text-align:left; }}
</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Documents'; ?>" > Documents List </a>  &nbsp; &#10095; &nbsp; Document Details  </div> <!-- Master -->

                <!-- PAGE CONTENT WRAPPER -->
             	<div class="page-content-wrap">

                  <div class="row main-wrapper">
                   <div class="main-container">           
                         <div class="box-shadow" style="padding-top:10px;">  
                        

                <form method="post" id="form_documets" action="<?php if(isset($editdocuments)) { echo base_url().'index.php/documents/updateRecord/'.$d_id;} else {echo base_url().'index.php/documents/saveRecord';} ?>">
							
						<!-- 	<div class="panel-heading">
								<h3 class="panel-title" ><strong>Document Master</strong></h3>
								
							</div> -->
                                <div class="box-shadow-inside custom-padding">
                          <div class="col-md-12" style="overflow:hidden!important;">
                        <div class="panel panel-default">
							<div class="panel-body">  
                                <div class="form-group" style="border-top:1px dotted #ddd"  >
                                <div class="col-md-6">
                            
                                    <label class="col-md-3 control-label">Document Name * </label>
                                    <div class="col-md-9">
                                    <input type="hidden" class="form-control" name="doc_id" id="doc_id" value="<?php if(isset($d_id)) { echo $d_id; } ?>"/>
                                    <input type="text" class="form-control" name="doc_name" id="doc_name" placeholder="Document Name" value="<?php if(isset($editdocuments)){ echo $editdocuments[0]->d_documentname; } ?>"/>
                                    </div>
                                
                                </div>
                                <div class="col-md-6">
                                
                                <label class="col-md-3 control-label"  >Document Type *</label>
                                <div class="col-md-9">
                                    <select name="d_type[]" class="select" multiple style="width:100%;position:absolute;"  >
                                        <?php for ($i=0; $i < count($document_type) ; $i++) { ?>
                                            <option value="<?php echo $document_type[$i]->d_type_id; ?>" <?php if (isset($selected_document_type)) {echo in_array($document_type[$i]->d_type_id,$selected_document_type) ? "selected" : null;} ?>><?php echo $document_type[$i]->d_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                </div>
                                <br clear="all" >
                                </div>
                                <div class="form-group">
                                <div class="col-md-6">
                                
                                <label class="col-md-3 control-label" >Description</label>
                                <div class="col-md-9">
                                <input type="text" class="form-control" name="doc_desc" placeholder="Description" value="<?php if(isset($editdocuments)){ echo $editdocuments[0]->d_description; } ?>"/>
                                </div>
                                
                                </div>
                                <div class="col-md-6">
                                <label class="col-md-3 control-label"  >Show Expiry Date *</label>
                                <div class="col-md-9" style="line-height:30px;">
                                <input type="radio" value="Yes" class="icheckbox" checked name="show_expiry_date" <?php if(isset($editdocuments)){if($editdocuments[0]->d_show_expiry_date=="Yes"){echo "checked";}} ?>/> &nbsp;&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="No" class="icheckbox" name="show_expiry_date" <?php if(isset($editdocuments)){if($editdocuments[0]->d_show_expiry_date=="No"){echo "checked";}} ?>/> &nbsp;&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                
                                </div>
                                   <br clear="all" >
                                </div>
                                <div class="form-group">
                                <div class="col-md-6">
    
                                <label class="col-md-3 control-label"  >Transaction Type *</label>
                                <div class="col-md-9">
                                <select id="status" class="form-control ttype" name="status">
                                <option value="">Select</option>
                                <option value="Transactional" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_status=="Transactional"){echo 'selected';}} ?>>Transactional</option>
                                <option value="Non Transactional" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_status=="Non Transactional"){echo 'selected';}} ?>>Non Transactional</option>
                                </select>
                                </div>
    
                                </div>
                                <div class="col-md-6">
    
                                <label class="col-md-3 control-label" id="transactional_type_label"  >Sub Type *</label>
                                <div class="col-md-9">
                                    <div id="transactional_type">
                                        <input type="checkbox" class="icheckbox" name="purchase" id="purchase" value="Yes" data-error="#transactional_type_error" <?php if(isset($editdocuments)){if(strpos($editdocuments[0]->d_t_type,"purchase")!==false)  echo "checked='checked'";}?> > &nbsp;Purchase &nbsp;&nbsp;
                                        <input type="checkbox" class="icheckbox" name="sale" id="sale" value="Yes" <?php if(isset($editdocuments)){if(strpos($editdocuments[0]->d_t_type,"sale")!==false)  echo "checked='checked'";}?> > &nbsp;Sale &nbsp;&nbsp;
                                        <input type="checkbox" class="icheckbox" name="rent" id="rent" value="Yes" <?php if(isset($editdocuments)){if(strpos($editdocuments[0]->d_t_type,"rent")!==false)  echo "checked='checked'";}?> > &nbsp;Rent &nbsp;&nbsp;
                                        <input type="checkbox" class="icheckbox" name="loan" id="loan" value="Yes" <?php if(isset($editdocuments)){if(strpos($editdocuments[0]->d_t_type,"loan")!==false)  echo "checked='checked'";}?> >&nbsp;Loan 
                                        <div id="transactional_type_error"></div>
                                    </div>
                                    <div id="non_transactional_type">
                                        <input type="checkbox" class="icheckbox" name="owner" id="owner" value="Yes" data-error="#non_transactional_type_error" <?php if(isset($editdocuments)){if(strpos($editdocuments[0]->d_t_type,"owner")!==false)  echo "checked='checked'";}?> >&nbsp;&nbsp;Owner
                                        <div id="non_transactional_type_error"></div>
                                    </div>
                                    <!-- <select id="type" class="form-control stype" name="type">
                                    <option value="">Select</option>
        
                                    </select> -->
                                </div>
    
                                </div>
                                   <br clear="all" >
                                </div>
                                <div class="form-group cat_hide" style="display:none;">
                                            <div class="col-md-12">
                                                                                       
                                                    <label class="col-md-2 col-sm-12  col-xs-12 control-label Category" >Category</label>
                                                    <div class="col-md-10 col-sm-12  col-xs-12 non-transactional">
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="individual" name="individual" data-error="#err_category" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_individual=="Yes"){echo 'checked';}} ?>/> &nbsp;Individual &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="huf" name="huf" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_huf=="Yes"){echo 'checked';}} ?>/>  
                                                        &nbsp;HUF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="privateltd" name="privateltd" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_privateltd=="Yes"){echo 'checked';}} ?>/>  &nbsp;Private Limited &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="ltd" name="ltd" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_limited=="Yes"){echo 'checked';}} ?>/> &nbsp;Limited &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="llp" name="llp" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_lpp=="Yes"){echo 'checked';}} ?>/> 
                                                        &nbsp;LLP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="partnership" name="partnership" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_partnership=="Yes"){echo 'checked';}} ?>/>  &nbsp;Partnership &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="aop" name="aop" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_aop=="Yes"){echo 'checked';}} ?>/> 
                                                        &nbsp;AOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="trust" name="trust" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_trust=="Yes"){echo 'checked';}} ?>/>  &nbsp;Trust &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="proprietorship" name="proprietorship" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_cat_proprietorship=="Yes"){echo 'checked';}} ?>/> &nbsp;Proprietorship
                                                        <div id="err_category"></div>
                                                    </div>
                                                
                                            </div>
                                               <br clear="all" >
                                        </div>
                                <div class="form-group ptype_hide" style="display:none;">
                                            <div class="col-md-12">
                                                                                      
                                                    <label class="col-md-2 col-sm-12  col-xs-12 control-label  Category"  >Property Type *</label>
                                                    <div class="col-md-10 col-sm-12  col-xs-12 Property-Type"  >
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="building" name="building" data-error="#err_prop_type" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_building=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Building&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="apartment" name="apartment" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_apartment=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Apartment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="bunglow" name="bunglow" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_bunglow=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Bunglow&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="commercial" name="commercial" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_commercial=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Commercial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="retail" name="retail" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_retail=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Retail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="industry" name="industry" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_industry=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Industry&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="landagri" name="landagri" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_landagriculture=="Yes"){echo 'checked';}} ?>/> &nbsp;&nbsp;Land-Agriculture&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" value="Yes" class="icheckbox" id="landnonagri" name="landnonagri" <?php if(isset($editdocuments)){ if($editdocuments[0]->d_type_landnonagricultural=="Yes"){echo 'checked';}} ?>	/> &nbsp;&nbsp;Land-Non Agriculture&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <div id="err_prop_type"></div>
                                                    </div>
                                                
                                            </div>
                                               <br clear="all" >
                                        </div>
							</div>

                              
                                </div>
                        </div>
                        </div>
                          <div class="panel-footer">
                                    <a class="btn btn-danger" href="<?php echo base_url();?>index.php/Documents">Cancel</a>
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
           
        <script>
            $(document).ready(function() {
                if($('.ttype').val()=='Transactional'){
                    $('#transactional_type_label').show();
                    $('#transactional_type').show();
                    $('#non_transactional_type').hide();
                    $('.cat_hide').hide();
                    $('.ptype_hide').show();
                }else if($('.ttype').val()=='Non Transactional'){
                    $('#transactional_type_label').hide();
                    $('#transactional_type').hide();
                    $('#non_transactional_type').show();
                    $('.cat_hide').show();
                    $('.ptype_hide').hide();
                }else{
                    $('#transactional_type_label').hide();
                    $('#transactional_type').hide();
                    $('#non_transactional_type').hide();
                    $('.cat_hide').hide();
                    $('.ptype_hide').hide();
                }
                
                // if($('.stype').val()=='purchase' || $('.stype').val()=='Sale' || $('.stype').val()=='rent' || $('.stype').val()=='loan'){
                //     $('.cat_hide').hide();
                //     $('.ptype_hide').show();
                // }
                // else if($('.stype').val()=='owner'){
                //     $('.cat_hide').show();
                //     $('.ptype_hide').hide();
                // }
                
                $('.ttype').change(function(e) {
                    if(e.target.options[e.target.selectedIndex].text=='Transactional'){
                        // $('.stype').find('option').remove().end().append('<option value="">Select</option><option value="purchase">Purchase</option><option value="Sale">Sale</option><option value="rent">Rent</option><option value="loan">Loan</option>');
                        $('#transactional_type_label').show();
                        $('#transactional_type').show();
                        $('#non_transactional_type').hide();
                        $('#owner').iCheck('uncheck');
                        $('.cat_hide').hide();
                        $('.ptype_hide').show();
        				$('#individual').iCheck('uncheck');
        				$('#huf').iCheck('uncheck');
        				$('#privateltd').iCheck('uncheck');
        				$('#ltd').iCheck('uncheck');
        				$('#llp').iCheck('uncheck');
        				$('#partnership').iCheck('uncheck');
        				$('#aop').iCheck('uncheck');
        				$('#trust').iCheck('uncheck');
                        $('#proprietorship').iCheck('uncheck');
                    }else if(e.target.options[e.target.selectedIndex].text=='Non Transactional'){
                        // $('.stype').find('option').remove().end().append('<option value="owner">Owner</option>');
                        $('#transactional_type_label').hide();
                        $('#transactional_type').hide();
                        $('#non_transactional_type').hide();
                        $('#owner').iCheck('check');
                        $('#purchase').iCheck('uncheck');
                        $('#sale').iCheck('uncheck');
                        $('#rent').iCheck('uncheck');
                        $('#loan').iCheck('uncheck');
                        $('.cat_hide').show();
                        $('.ptype_hide').hide();
                        $('#building').iCheck('uncheck');
        				$('#apartment').iCheck('uncheck');
        				$('#bunglow').iCheck('uncheck');
        				$('#commercial').iCheck('uncheck');
        				$('#retail').iCheck('uncheck');
        				$('#industry').iCheck('uncheck');
        				$('#landagri').iCheck('uncheck');
        				$('#landnonagri').iCheck('uncheck');
                    }else{
                        // $('.stype').find('option').remove().end().append('<option value="">Select</option>');
                        $('#transactional_type_label').hide();
                        $('#transactional_type').hide();
                        $('#non_transactional_type').hide();
                        $('#owner').iCheck('uncheck');
                        $('#purchase').iCheck('uncheck');
                        $('#sale').iCheck('uncheck');
                        $('#rent').iCheck('uncheck');
                        $('#loan').iCheck('uncheck');
                        $('.cat_hide').hide();
                        $('.ptype_hide').hide();
                        $('#individual').iCheck('uncheck');
                        $('#huf').iCheck('uncheck');
                        $('#privateltd').iCheck('uncheck');
                        $('#ltd').iCheck('uncheck');
                        $('#llp').iCheck('uncheck');
                        $('#partnership').iCheck('uncheck');
                        $('#aop').iCheck('uncheck');
                        $('#trust').iCheck('uncheck');
                        $('#proprietorship').iCheck('uncheck');
                        $('#building').iCheck('uncheck');
                        $('#apartment').iCheck('uncheck');
                        $('#bunglow').iCheck('uncheck');
                        $('#commercial').iCheck('uncheck');
                        $('#retail').iCheck('uncheck');
                        $('#industry').iCheck('uncheck');
                        $('#landagri').iCheck('uncheck');
                        $('#landnonagri').iCheck('uncheck');
                    }
                });
            
                // $('.stype').change(function(e) {
                //     if(e.target.options[e.target.selectedIndex].text=='Purchase' || e.target.options[e.target.selectedIndex].text=='Sale' || e.target.options[e.target.selectedIndex].text=='Rent' || e.target.options[e.target.selectedIndex].text=='Loan'){
                //         $('.cat_hide').hide();
                //         $('.ptype_hide').show();
                //     }else if(e.target.options[e.target.selectedIndex].text=='Owner'){
                //         $('.cat_hide').show();
                //         $('.ptype_hide').hide();
                //     }
                // });
            });
        </script>
    </body>
</html>