$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	$('.date-range-filter').datepicker();

	var sales_table = $("#sales_table").DataTable({
		searching : true,
		ordering : false,
		bLengthChange :false,
		serverSide : true,
		info : false,
		processing : true,
		bsearchable : true,
		dom : 'lrtip',
		ajax : {
			url : base_url + 'sales/report',
			type : 'POST'
		},
		initComplete : function(settings, json) {
			$("#total-sales").text('₱' + json.total_sales);
			$("#max-date").change(function() {
				$(this).datepicker('hide');
				var to = $(this).val();
				var from = $("#min-date").val();
				
				if (from) {
					sales_table.columns(0).search(from);
					sales_table.columns(1).search(to).draw();
					$("#range").text(to + ' - ' + from);
				}else {
					alert('Select from date');
				}
			})
		},
		drawCallback : function (setting) {
			var data = setting.json;
			$("#total-sales").text('₱' + data.total_sales);
		}
	});

	


	$("#supplier_table").DataTable();
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
	$("#item_tbl").DataTable();
	$("#users_table").DataTable();
	$("#categories_table").DataTable();
	$("#deliveries_table").DataTable();
	$("#customer_table").DataTable();
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