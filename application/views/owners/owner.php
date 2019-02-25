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
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			.hide_panel {display:none;}
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
							
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Owner Details</strong></h3>
								<ul class="panel-controls">
									<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
								</ul>
							</div>
							
							<hr/>
							





						<div class="col-md-1">&nbsp;</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="<?php echo base_url(); ?>audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="<?php echo base_url(); ?>audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->                

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/highlight/jquery.highlight-4.js"></script>
		
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="js/settings.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/faq.js"></script>
        <!-- END TEMPLATE -->
		
		<script>
			jQuery(function(){
    var counter = 1;
    $('.repeat-huf').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-6"><div class="form-group"><label class="col-md-3 control-label">Family Details</label><div class="col-md-9"><select class="form-control" name="family_details[]"><option>Select</option><?php for ($i=0; $i < count($contact) ; $i++) { echo '<option value="'. $contact[$i]->c_id.'">'.$contact[$i]->c_Name.'</option>';}?></select></div></div></div><div class="col-md-6"><div class="form-group"><label class="col-md-3 control-label">Relation</label><div class="col-md-9"><input type="text" class="form-control" name="relation[]" placeholder="Relation"/></div></div></div></div>');
        $('.huf').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-huf-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_doc_name[]" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_doc_desc[]" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_ref_no[]" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_date_issue[]" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="huf_date_expiry[]" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="doc_'+counter+'" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.addkyc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Director '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-3"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div></div>');
        $('.pvtltd').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-share').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Share Holder '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/></div></div>');
        $('.sharepvtltd').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.pvtltddoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-pvtltd-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.pvtltdsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-partner').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-1" style="padding-right: 0px;"><label class="col-md-12 control-label">Partner '+counter+'</label></div><div class="col-md-4"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Partnership %"/></div></div>');
        $('.llppartner').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.llpdoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-llp-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.llpsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Trustee '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-3"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div></div>');
        $('.trustdetails').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-share').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-1" style="padding-left: 0px;"><label class="col-md-12 control-label" style="padding-left: 0px;padding-right: 0px;">Beneficiary '+counter+'</label></div><div class="col-md-4"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Shareholder %"/></div></div>');
        $('.trustshare').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-doc').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Document Name"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><select id="category" class="form-control select" ><option>ID Proof</option><option>Address Proof</option><option>Others</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Reference No"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Issue"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="pan" placeholder="Date of Expiry"/></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse file</span><input type="file" class="fileinput btn-primary" name="photograph" id="photograph" title="Browse file" style="    width: 100%;height: 28px;"></a></div></div></div></div>');
        $('.trustdoc').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});

jQuery(function(){
    var counter = 1;
    $('.repeat-trust-sign').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<div class="form-group"><div class="col-md-2"><label class="col-md-12 control-label">Authorised Signatory '+counter+'</label></div><div class="col-md-3"><input type="text" class="form-control" name="dname" placeholder="Name"/></div><div class="col-md-2"><input type="text" class="form-control" name="dmobile" placeholder="Mobile"/></div><div class="col-md-3"><input type="text" class="form-control" name="demail" placeholder="Email ID"/></div><div class="col-md-2"><input type="text" class="form-control" name="dshareperc" placeholder="Purpose of AS"/></div></div>');
        $('.trustsign').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
    });
});
		</script>
		
		<script type="text/javascript">
            /*var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        group_name: {
                                required: true
                        },
						status: {
                                required: true
                        },
						contact: {
                                required: true
                        },
						designation: {
                                required: true
                        }
                    }                                        
                });
			$('#reset').click(function(){
				$('#jvalidate')[0].reset();
			 });*/
			$("#category").change(function() {
				$('#individual').slideUp();
				$('#huf').slideUp();
				$('#private_limited').slideUp();
				
				$('#llp').slideUp();
				$('#partnership').slideUp();
				$('#aop').slideUp();
				$('#trust').slideUp();
				var panelId = $('#category').val();
				if(panelId=="#limited") {
					panelId="#private_limited";
				}
				if(panelId=="#partnership" || panelId=="#aop") {
					panelId="#llp";
				}
				if(panelId=="#select"){
					$('#category').hide();
				}
				$(panelId).delay(10).fadeIn();
			});
        </script>

        <script type="text/javascript">
        	function loadclientdetail(){
        		var clientid = document.getElementById("individual_client").value;
        		var xmlhttp=new XMLHttpRequest();
        		xmlhttp.onreadystatechange = function() {
        			if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
        				var data = JSON.parse(xmlhttp.responseText);
        				document.getElementById('ind_gender').value = data['gender'];
        				document.getElementById('ind_designation').value = data['designation'];
        				document.getElementById('ind_email_id1').value = data['email1'];
        				document.getElementById('ind_email_id2').value = data['email2'];
        				document.getElementById('ind_mobile_no1').value = data['mobile1'];
        				document.getElementById('ind_mobile_no2').value = data['mobile2'];
        			}
        		};
        		xmlhttp.open("POST", "<?php echo base_url().'index.php/owners/loadselectedindividual/'; ?>" + clientid, true);
        		xmlhttp.send();
        	}
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>