$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var currency = '₱';

	$('.date-range-filter').datepicker();
	$("#history_table").DataTable({
		'bLengthChange' : false,
		'searching' : false,
		'ordering' : false,

	});

	$("#graph-menu button").click(function() {
		$('#graph-menu button').removeClass('active');
		$(this).addClass('active');
		var type = $(this).data('id');
		$.ajax({
			type : 'POST',
			url : base_url + 'sales/graph-filter',
			data : {
				type : type
			},
			success : function(data) {

				var result = JSON.parse(data);
			
				if (type == "week")
					myChart.data.datasets[0].label = "Sales for the last 7 Days";
				else if (type == "month")
					myChart.data.datasets[0].label = "Monthly Sales";
				else if (type == "year")
					myChart.data.datasets[0].label = "Yearly Sales";

				myChart.data.labels = Object.keys(result);
				myChart.data.datasets.data = Object.values(result);
				myChart.data.datasets[0].data = Object.values(result);
				myChart.update();

			}
		});
	});
	var sales_table = $("#sales_table").DataTable({
		searching : true,
		ordering : false,
		bLengthChange :false,
		serverSide : true,
		info : false,
		processing : true,
		bsearchable : true,
		paging : false,
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

	$("#sales_table").on('click','.view', function() {
		var id = $(this).data('id');
		var row = $(this).parents('tr');
		var total = row.find('td').eq(2).text();
		 
		$.ajax({
			type : 'POST',
			data : {
				id : id
			},
			url : base_url + 'SalesController/details',
			success : function(data) {
				var description = JSON.parse(data);
				$("#sales-description-table tbody").empty();
				$.each(description, function(key,value) {
					$("#sales-description-table tbody").append(
							'<tr>' +
								'<td>' +value[0]+'</td>' + 
								'<td>' +value[1]+'</td>' + 
								'<td>'+ currency +value[2]+'</td>' + 
								'<td>' +value[3]+'</td>' +
								'<td>'+ currency +value[4]+'</td>' +
							'</tr>'
						);
				});

				$("#sales-description-table tbody").append(
						'<tr>' +
							'<td colspan="4" class="text-right">Total:</td>' +
							'<td>'+ currency + total+'</td>' +
						'</tr>'
					);	
				$("#sale-id").text(id);
			}
		});
		$("#modal").modal('toggle');
	})


	$("#supplier_table").DataTable({
		ordering : false,
		initComplete : function() {
			$("#supplier_table_length").append('&nbsp; <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">Add Supplier</button>')
		}
	});
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
	var itemTable = $("#item_tbl").DataTable({
		initComplete : function() { 
			$("#item_tbl_length").append("&nbsp;<select id='cat' class='form-control'>" +
						'<option value="">Select Category</option>' +
					"</select>"
				);
			$.ajax({
				method : 'GET',
				url : base_url + 'categories/get',
				success : function(data) {
					result = JSON.parse(data);
					$.each(result, function(key, value) {
						$("#cat").append("<option value='"+value.name+"'>"+value.name+"</option>");
					});
				}

			});
			
			$("#cat").change(function() {
				category = $(this).val();
				itemTable.search(category).draw();
			})
		}
	});
	$("#users_table").DataTable();
	$("#categories_table").DataTable({
		ordering : false
	});
	$("#deliveries_table").DataTable();
	$("#customer_table").DataTable({
		ordering : false,
		initComplete : function() {
			$("#customer_table_length").append('&nbsp; <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">Add Customer</button>');
		}
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

	$("#btn-group-menu .btn").click(function() {
		$('.btn-group .btn').removeClass('active');
		$(this).addClass('active');
		if ($(this).data('id') == "table") {
			$("#table_view").show();
			$("#graph").hide();
			$("#table-menu").show();
			$("#graph-menu").hide();
		}else {
			$("#table_view").hide();
			$("#graph").show();
			$("#table-menu").hide();
			$("#graph-menu").show();
		}
	})
	var ctx = document.getElementById("myChart");
	var myChart = new Chart(ctx, {
	    type: 'line',
	    data: {
	        labels: labels,
	        datasets: [{
	            label: 'Sales for the Last 7 Days',
	            data: totalSales,
	            backgroundColor: [
	                '#337ab7',
	            ],
	            strokeColor: [
	                '#337ab7',
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true,
	                    callback : function(value, index, values) {
	                    	return '₱' + (value);

	                    }
	                }
	            }]
	        }
	    }
	}); 
})


