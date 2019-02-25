<?php if(isset($editcontdoc)) {
        $id_proof = true;
        $address_proof = true;
        $doc_no=0;
        for($i=0; $i < count($editcontdoc); $i++) {
?>

<?php 
    if(strpos($editcontdoc[$i]->d_type,"ID Proof")!==false) { ;
        if($id_proof==true) { $id_proof=false; 
?>
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background: none;border:none">
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="ID Proof" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $editcontdoc[$i]->d_m_status; ?>" />
                <label class="doc_file">ID Proof <span class="asterisk_sign">*</span></label>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <select name="doc_name[]" class="form-control doc_name" id="doc_name_<?php echo $doc_no; ?>" onChange="getMStatus(this);">
                    <option value="">Select</option>
                    <?php for ($j=0; $j < count($id_proof_doc) ; $j++) { ?>
                        <option value="<?php echo $id_proof_doc[$j]->d_documentname; ?>" <?php if($id_proof_doc[$j]->d_documentname==$editcontdoc[$i]->doc_name) { echo 'selected'; } ?>><?php echo $id_proof_doc[$j]->d_documentname; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4" style="padding-left:1px; padding-right:1px;">                                                     
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $editcontdoc[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $editcontdoc[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doi!='' && $editcontdoc[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doe!='' && $editcontdoc[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-8" style="padding-left:1px; padding-right:1px;">
                <input type="file" class="fileinput btn btn-primary doc_file"  name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
                <?php if($editcontdoc[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$editcontdoc[$i]->doc_document; ?>">Download</a><?php } ?>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#">Delete</a>
            </div>
        </div>
    </div>

<?php 
    }} else if(strpos($editcontdoc[$i]->d_type,"Address Proof")!==false) { 
    if($address_proof==true) { $address_proof=false; 
?>
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background: none;border:none">
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="Address Proof" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $editcontdoc[$i]->d_m_status; ?>" />
                <label class="doc_file">Address Proof <span class="asterisk_sign">*</span></label>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <select name="doc_name[]" class="form-control doc_name" id="doc_name_<?php echo $doc_no; ?>" onChange="getMStatus(this);">
                    <option value="">Select</option>
                    <?php for ($j=0; $j < count($address_proof_doc) ; $j++) { ?>
                        <option value="<?php echo $address_proof_doc[$j]->d_documentname; ?>" <?php if($address_proof_doc[$j]->d_documentname==$editcontdoc[$i]->doc_name) { echo 'selected'; } ?>><?php echo $address_proof_doc[$j]->d_documentname; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $editcontdoc[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $editcontdoc[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doi!='' && $editcontdoc[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doe!='' && $editcontdoc[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-8" style="padding-left:1px; padding-right:1px;">
                <input type="file"  class="fileinput btn btn-primary doc_file"  name="doc_<?php echo $doc_no;?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
                <?php if($editcontdoc[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$editcontdoc[$i]->doc_document; ?>">Download</a><?php } ?>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#">Delete</a>
            </div>
        </div>
    </div>
<?php 
    }} else if(strpos($editcontdoc[$i]->d_type,"Others")!==false) { 
?>
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background: none;border:none">
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="Others" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $editcontdoc[$i]->d_m_status; ?>" />
                <label class="doc_file">Others</label>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php echo $doc_no; ?>" placeholder="Document Name" value="<?php echo $editcontdoc[$i]->doc_name; ?>" />
            </div>
        </div>
        <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $editcontdoc[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $editcontdoc[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doi!='' && $editcontdoc[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doe!='' && $editcontdoc[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-8" style="padding-left:1px; padding-right:1px;">
                <input type="file"  class="fileinput btn btn-primary doc_file"  name="doc_<?php echo $doc_no;?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
                <?php if($editcontdoc[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$editcontdoc[$i]->doc_document; ?>">Download</a><?php } ?>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#">Delete</a>
            </div>
        </div>
    </div>
<?php 
    } else { 
?>
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background: none;border:none">
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="Others" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $editcontdoc[$i]->d_m_status; ?>" />
                <label class="doc_file">Others</label>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php echo $doc_no; ?>" placeholder="Document Name" value="<?php echo $editcontdoc[$i]->doc_name; ?>" />
            </div>
        </div>
        <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $editcontdoc[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $editcontdoc[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doi!='' && $editcontdoc[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($editcontdoc)) { if($editcontdoc[$i]->doc_doe!='' && $editcontdoc[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-8" style="padding-left:1px; padding-right:1px;">
                <input type="file"  class="fileinput btn btn-primary doc_file"  name="doc_<?php echo $doc_no;?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
                <?php if($editcontdoc[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$editcontdoc[$i]->doc_document; ?>">Download</a><?php } ?>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#">Delete</a>
            </div>
        </div>
    </div>
<?php 
    }  } } else { ?>
    <div id="repeat_doc_0" class="form-group" style="background: none;border:none">
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_0" value="" />
                <input type="hidden" class="form-control" id="d_m_status_0" value="" />
                <label class="doc_file">Others</label>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_0" placeholder="Document Name" value="" />
            </div>
        </div>
        <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_0" placeholder="Reference No" value=""/>
            </div>
        </div>
        <div class="col-md-3" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value=""/>
            </div>
            <div class="col-md-6" style="padding-left:1px; padding-right:1px;">
                <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
            </div>
        </div>
        <div class="col-md-2" style="padding-left:1px; padding-right:1px;">
            <div class="col-md-8" style="padding-left:1px; padding-right:1px;">
                <input type="file"  class="fileinput btn btn-primary doc_file"  name="doc_0" id="doc_file_0" data-error="#doc_0_error"/>
                <div id="doc_0_error"></div>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px;">
                <a id="repeat_doc_0_delete" class="delete_row" href="#">Delete</a>
            </div>
        </div>
    </div>
<?php } ?>