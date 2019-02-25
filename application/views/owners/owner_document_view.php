<?php if(isset($editcontdoc)) { for ($i=0; $i < count($editcontdoc); $i++) { ?>
	<tr>
	  <td class="Contact_name"><?php echo $editcontdoc[$i]->doc_name; ?></td>
		<td class="Contact_name"><?php echo $editcontdoc[$i]->doc_description; ?></td>
		<td><?php echo $editcontdoc[$i]->doc_ref_no; ?></td>
		<td><?php if ($editcontdoc[$i]->doc_doi!='') { if($editcontdoc[$i]->doc_doi != '') echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doi)); }?></td>
		<td><?php if ($editcontdoc[$i]->doc_doe!='') { if($editcontdoc[$i]->doc_doe != '') echo date('d/m/Y',strtotime($editcontdoc[$i]->doc_doe)); } ?></td>
		<?php if($editcontdoc[$i]->doc_document!='' && $editcontdoc[$i]->doc_document!=null) { ?>
			<td align="" class="td">
            	
            		<a  class="btn btn-primary" target="_blank" href="<?php echo base_url().$editcontdoc[$i]->doc_document; ?>"><i class="glyphicon glyphicon-download"> </i> Download </a>
            	
			</td>
		<?php } else { ?>
			<td align="" class="td"></td>
		<?php } ?>
	</tr>
<?php } } ?>