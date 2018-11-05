$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	 
	$("#supplier_table").on('click','.edit',function() {
		var id = $(this).data('id');
		$("#supplier_id").val(id);
		$.ajax({
			type : 'POST',
			url : base_url + 'suppliers/find',
			data : {
				id : id
			},
			success : function(data) {
				var supplier = JSON.parse(data);
				$("#edit-supplier-form input[name='name']").val(supplier.name);
				$("#edit-supplier-form input[name='address']").val(supplier.address);
				$("#edit-supplier-form input[name='contact']").val(supplier.contact);
			}

		});
	});

	$("#customer_table").on('click','.edit',function() {
		var id = $(this).data('id');
		 $("#customer_id").val(id);
		 $.ajax({
			type : 'POST',
			url : base_url + 'customers/find',
			data : {
				id : id
			},
			success : function(data) {
				var customer = JSON.parse(data);
				console.log(customer); 
				$("#customer-edit input[name='name']").val(customer.name);
				$("#customer-edit input[name='email']").val(customer.email);
				$("#customer-edit input[name='gender']").val(customer.gender);
				$("#customer-edit input[name='address']").val(customer.address);
				$("#customer-edit input[name='city']").val(customer.city);
				$("#customer-edit input[name='state']").val(customer.state); 
				$("#customer-edit input[name='zipcode']").val(customer.zipcode);
				$("#customer-edit input[name='mobileNumber']").val(customer.mobileNumber);
			}

		});
	})
 
})