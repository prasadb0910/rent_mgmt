var get_details = function(elem) {
	var id = elem.id;
	var index = id.substr(id.lastIndexOf('_')+1);

	$('#status').html($('#status_'+index).val());
	$('#type').html($('#type_'+index).val());
	$('#particular').html($('#particular_'+index).val());
	$('#bal_amount').html($('#bal_amount_'+index).val());
	$('#net_amount').html($('#net_amount_'+index).val());
	$('#due_date').html($('#due_date_'+index).val());
	$('#type').attr('href', $('#link_'+index).val());
	$('#owner_name').html($('#owner_name_'+index).val());
}