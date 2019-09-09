$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var currency = '₱';
	var site_live = $("meta[name='site_live']").attr('content');
	var csrfName = $("meta[name='csrfName']").attr('content');
	var csrfHash = $("meta[name='csrfHash']").attr("content");
	var api_key = $("meta[name='api_key']").attr('content');
	$("body").show();
	$("form").parsley();	
	
	$('[data-toggle="tooltip"]').tooltip();
	$(".sidebar-nav ul li a").click(function(e) {
		$(".sidebar").css("top", "0px");
	})

 	if (site_live == 1) {
 		if (!sessionStorage.getItem("demo")) {
	 		introJs().start().oncomplete(endDemo)
							.onskip(endDemo)
							.onexit(endDemo);
	 	}
 	}
	function endDemo() {
		sessionStorage.setItem("demo", false);
	}

	(function() {
		var itemTable;
		var items = {		
			init : function() {
				this.dataTable();
				this.dataTableFilter();
				this.clearDataTableFilter();
				this.deleteItem();
				this.changeImage();
				this.itemForm();
			},
			itemForm: function() {
				$("#item-form").submit(function(e) {
					var price = $("[name='price']").val();
					var retail = $("[name='retail_price']").val();
					if (parseInt(price) > retail) {
						alert("Retail price must be greather or equal to price");
						e.preventDefault();
					}
				})
			},
			changeImage : function() {
				$("#productImage").change(function() {
					readURL(this);
				});
			},
			dataTable : function() {
				data = {};
				data[csrfName] = csrfHash;
				itemTable = $("#item_tbl").DataTable({
					processing : true,
					serverSide : true,
					lengthMenu : [[10, 25, 50, 0], [10, 25, 50, "Show All"]],
					ajax : {
						url : base_url + 'ItemController/dataTable',
						type : 'POST',
						data : data
					},
					dom : "lfrtBp",
					buttons: [
						{
							extend: 'copyHtml5',
							filename : 'Inventory Report',
							title : 'Inventory',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6,7 ]
							},
						},
						{
							extend: 'excelHtml5',
							filename : 'Inventory',
							title : 'Inventory Report',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6,7 ]
							},
						},
						{
							extend: 'pdfHtml5',
							filename : 'Inventory Report',
							title : 'Inventory',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6,7 ]
							},

						},
					],
					initComplete : function(settings, json) {
						
						$.previewImage({
						   'xOffset': 30,  // x-offset from cursor
						   'yOffset': -270,  // y-offset from cursor
						   'fadeIn': 1000, // delay in ms. to display the preview
						   'css': {        // the following css will be used when rendering the preview image.
					
						   'border': '2px solid black', 
						   }
						});
					} 
				})
			},
			dataTableFilter : function() {
				$(".filter-items").change(function() {
					let column = $(this).data('column');
					if (column == 4)
						itemTable.columns(5).search('');
					if (column == 5)
						itemTable.columns(4).search('');
					itemTable.columns(column).search(this.value).draw();
				})
			},
			clearDataTableFilter : function() {
				$("#clear-filter").click(function(e) {
					$(".filter-items").each(function() {
						$(this).val('');
						itemTable.columns($(this).data('column')).search('');
					})

					itemTable.draw();
				})
			},
			deleteItem : function() {
				$("body").on('click', '.delete-item', function() {
					var c = confirm('Delete Item?')
					var id = $(this).data('id');
					var link = $(this).data('link');
					if (c == false) {

						return false;
					}

					$(this).next("form").submit();
				})
			}
		}

		var sales = {
			init : function() {
				this.deletePurchaseItem();
				this.salesDataTable();
			},
			deletePurchaseItem : function() {

				$("body").on('click', '.delete-sale', function(e) {
					var row = $(this).parents('tr');
					var sales_description_id = $(this).data('id');
					e.preventDefault();
					jQueryConfirm.deleteConfimation('Confirmation', 'Are you sure you want to delete that sales purchase?', function(e) {
						$.ajax({
							type : 'GET',
							url : base_url + 'SalesController/Destroy/' + sales_description_id, 
							success : function(data) {
								if (data == 1) {
									row.remove();
									alert("Sale deleted successfully! Stocks has been restored");
									sales_table.draw();
								}
							}
						});
					})
					

				})
			},
			salesDataTable : function() {
				data = {};
				data[csrfName] = csrfHash;
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
						type : 'POST',
						data : data
					},
					initComplete : function(settings, json) {
						
						$("#total-sales").text('₱' + json.total_sales);
						$("#total-expenses").text('₱' + json.expenses);
						$("#max-date").change(function() {
							$(this).datepicker('hide');
							var to = $(this).val();
							var from = $("#min-date").val();
							
							if (from) {
								sales_table.columns(0).search(from);
								sales_table.columns(1).search(to).draw();
								$("#range").text('Date: ' +to + ' - ' + from);
								$("#widgets").show();

							}else {
								alert('Select from date');
							}
						})
					},
					drawCallback : function (setting) {
						var data = setting.json;
						console.log(data);
						$("#total-sales").text('₱' + data.total_sales);
						$("#total-profit").text('₱' + data.profit);
						$("#total-lost").text('₱' + data.lost);
						$("#total-expense").text('₱' + data.expenses);
					}
				});
			}
		}

		var jQueryConfirm = {
			deleteConfimation : function(title,content, callbackFunction) {
				$.confirm({
				    title: title,
				    content: content,
				    buttons: {
				        confirm: {
				        	text : 'Delete',
				        	btnClass : 'btn btn-danger',
				        	action : callbackFunction
				        },
				        cancel: function () {
				            $.alert('Canceled!');
				        } 
				    }
				});
			}
		}

		var customers = {
			init : function() {
				this.edit();
				this.graphSales();
				this.customerDatatable();
			},
			edit : function() {
				$("#customer_table").on('click','.edit',function() {
					var id = $(this).data('id');
					$("#customer_id").val(id);
					/*
						Set Data
						1 - csrfname and token
						2 - customer ID
					*/
					var data = {};
					data[csrfName] = csrfHash;
					data['id'] = id;
					$.ajax({
						type : 'POST',
						url : base_url + 'customers/find',
						data : data,
						success : function(data) {
							var customer = JSON.parse(data);
							console.log(customer); 
							$("#customer-edit input[name='name']").val(customer.name); 
							$("#customer-edit input[name='gender']").val(customer.gender);
							$("#customer-edit input[name='home_address']").val(customer.home_address);
							$("#customer-edit input[name='outlet_location']").val(customer.outlet_location);
							$("#customer-edit input[name='outlet_address']").val(customer.outlet_address);  
							$("#customer-edit input[name='contact_number']").val(customer.contact_number);
						}

					});
				})
			},
			graphSales : function() {
				$("#graph-menu button").click(function() {
				$('#graph-menu button').removeClass('active');
				$(this).addClass('active');
				var type = $(this).data('id');
				var btn = $(this).button('loading');
				var data = {};
				data[csrfName] = csrfHash;
				data['type'] = type;
				$.ajax({
						type : 'POST',
						url : base_url + 'sales/graph-filter',
						data : data,
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
							btn.button("reset");

						}
					});
				});
			},
			customerDatatable() {
				var customer_table = $("#customer_table").DataTable({
					ordering : false,
					dom : "lfrtBp",
					buttons: [
					{
						extend: 'copyHtml5',
						filename : 'Inventory Report',
						title : 'Inventory',
						messageTop : 'Inventory Report',
						className : "btn btn-default btn-sm",
						exportOptions: {
							columns: [ 0, 1, 2, 3,4,5,6 ]
						},
					},
					{
						extend: 'excelHtml5',
						filename : 'Inventory',
						title : 'Inventory Report',
						messageTop : 'Inventory Report',
						className : "btn btn-default btn-sm",
						exportOptions: {
							columns: [ 0, 1, 2, 3,4,5,6 ]
						},
					},
					{
						extend: 'pdfHtml5',
						filename : 'Inventory Report',
						title : 'Inventory',
						messageTop : 'Inventory Report',
						className : "btn btn-default btn-sm",
						exportOptions: {
							columns: [ 0, 1, 2, 3,4,5,6 ]
						},

					},
					],
					initComplete : function() {
						$("#customer_table_length").append( '&nbsp;&nbsp;<select class="form-control" id="member-status"><option value="">Membership Status</option>'+
							'<option value="Active">Active</option>' + 
							'<option value="Expired">Expired</option>' + 
							'<option value="Needs Renewal">Needs Renewal</option>' + 
							'<option value="Not Open">Not Open</option>' + 
							'</select>'
							+'&nbsp; <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Add Customer</button>');
						
						$("#member-status").change(function() {
							customer_table.columns(7).search($(this).val()).draw();
						})
					}
				});
			}
		}

		var suppliers = {
			init : function() {
				this.dataTable();
				this.edit();
			},
			dataTable : function(){
				$("#supplier_table").DataTable({
					ordering : false,
					initComplete : function() {
						$("#supplier_table_length").append('&nbsp; <select class="form-inline form-control"></select>')
						$("#supplier_table_length").append('&nbsp; <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Add Supplier</button>')
					}
				})

			},
			edit : function(){
		 
				$("#supplier_table").on('click','.edit',function() {
					var id = $(this).data('id');
					var data = {};
					$("#supplier_id").val(id);
					data['id'] = id;
					data[csrfName] = csrfHash;
					$.ajax({
						type : 'POST',
						url : base_url + 'suppliers/find',
						data : data,
						success : function(data) {
							var supplier = JSON.parse(data);
							$("#edit-supplier input[name='name']").val(supplier.name);
							$("#edit-supplier input[name='address']").val(supplier.address);
							$("#edit-supplier input[name='contact']").val(supplier.contact);
							$("#edit-supplier input[name='email']").val(supplier.email);
						}

					});
				})
			} 
		}

		var expensesTable;
		var totalExpenses;
		var expenses = {

			init : function() {
				this.dataTable();
				this.filterReports();
			},
			dataTable: function () {
				data = {};
				data[csrfName] = csrfHash;
				expensesTable = $("#expenses_table").DataTable({
					searching : true,
					ordering : false, 
					serverSide : true,
					info : false,
					processing : true,
					bsearchable : true,
					paging : false,
					dom : 'lrtB',
					ajax : {
						url : base_url + 'expenses/reports',
						type : 'POST',
						data : data
					},
					buttons: [ 
						{
							extend: 'excelHtml5',
							filename : 'Expenses',
							title : function() {
								return 'Expenses Report: ' + $("#expenses_from").val() + ' - ' + $("#expenses_to").val();
							 	
							}, 
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 0,1, 2, 3 ]
							},
							messageTop: function() {
								return "Total: " + $("#total").text();
							}
						},
						{
							extend: 'pdfHtml5',
							filename : 'Expenses Report',
							title : function() {
								return 'Expenses Report: ' + $("#expenses_from").val() + ' - ' + $("#expenses_to").val();
							 	
							},
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 0, 1, 2, 3 ]
							},
							messageTop: function() {
								return "Total: " + $("#total").text();
							}
						},
					],
					drawCallback: function(setting) {
						var data = setting.json;
						totalExpenses = data.total;
						$("#total").text(totalExpenses);

					}
				}); 
					
			},
			filterReports: function() {
				$("#expenses_to").change(function(e) {
					var toDate = $(this).val();
					var fromDate = $("#expenses_from").val();
					
					if (fromDate && toDate && toDate >= fromDate) {
						expensesTable.columns(0).search(fromDate)
									.columns(1).search(toDate)
									.draw();
					}else {
						alert("From date is empty or from date is greather than to date");
					}
				})
			}

		}

		var dateTimePickers = {
			init : function() {
				this.initDatePickers();
			},
			initDatePickers : function() {
				$('.date-range-filter').datepicker({
					useCurrent : false
				});

				 $("#datetimepicker6").on("dp.change", function (e) {
			        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
			    });
			    $("#datetimepicker7").on("dp.change", function (e) {
			        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
			    });

				$("#min-date").change(function(e){
					$("#max-date").datepicker({startDate : new Date()})
				})
			}
		} 

		expenses.init();
		dateTimePickers.init();
		items.init();
		sales.init();
		customers.init();
		suppliers.init();
	 
	})();

	$("#customer_table").on('click', '.renew', function() {
		var id = $(this).data('id');
		if (id) {
			$.ajax({
				type : 'POST',
				url : base_url + '/CustomersController/getMembership',
				data : {
					id : id
				},
				success : function(data) {
					var result = JSON.parse(data);
					console.log(result)
					$("#date-open").text((result.date_open));
					$("#renew-date").text(moment().format('YYYY-MM-DD'));
					$("#new-expiration").text(moment().add(3,'years').format('YYYY-MM-DD'));
					$("#customer-id").val(result.customer_id);
				}
			})
		}
		$("#renew-modal").modal('toggle');
	})

	var profit_table = $("#profit_table").DataTable({
		processing : true,
		bLengthChange : false,
		ordering : false,
		paging : false,
		serverSide : true,
		dom : 'r',
		ajax : {
			type : "POST",
			url : base_url + "AccountingController/data"
		},
		initComplete : function() {
			$("#accounting-filter input").change(function() {
				var start = $("#min-date").val();
				var end = $("#max-date");

				if (start && end.val()) {
					end.datepicker('hide');
					profit_table.columns(0).search(start);
					profit_table.columns(1).search(end).draw();
					$("#range").text('Date: ' + start + ' - ' + end.val());
				}
			})
		},
		drawCallback : function (setting) {
			var data = setting.json;
			$("#total-profit").text('₱' + data.profit);

		}
	});
	
	
	$("#history_table").DataTable({
		'bLengthChange' : false,
		'searching' : false,
		'ordering' : false,
	});

	$("#mail").click(function() {
		var button = $(this);
		$.ajax({
			type : 'GET',
			url : base_url + 'SuppliersController/mail',
			beforeSend : function() {
				button.button('loading');
			},
			success : function(data) {
				
				if (data == 1) 
					$("#message").show();
				else 
					alert("Opps! Something went wrong please try again later");
				button.button('reset');
			},
			error : function() {
				alert('Opps! Something went wrong we cannot send your email');
				button.button('reset');
			}
		});
	})

	$("#export").click(function(e) {
		e.preventDefault();
		var start = $("#min-date").val();
		var end = $("#max-date").val();

		if (start && end) {
			window.location.href = base_url + "SalesController/export?start=" + start + "&end=" + end;
		}else {
			alert("Please select date");
		}
	})

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

	
	$("#users_table").DataTable();
	$("#categories_table").DataTable({
		ordering : false
	});

	$("#deliveries_table").DataTable();

	$("#btn-group-menu .btn").click(function() {
		$('.btn-group .btn').removeClass('active');
		$(this).addClass('active');
		if ($(this).data('id') == "table") {
			$("#table_view").show();
			$("#graph").hide();
			$("#table-menu").show();
			$("#graph-menu").hide();
			$("#widgets").show();
		}else {
			$("#widgets").hide();
			$("#table_view").hide();
			$("#graph").show();
			$("#table-menu").hide();
			$("#graph-menu").show();
		}
	})


	$("#activation-form").submit(function(e) {
		e.preventDefault();
		var key = $(this).find('[name=key]').val();
		var jsonData = {};
		var ajaxData = {};
		ajaxData['api_key'] = api_key;
		ajaxData['key'] = key;
		jsonData[csrfName] = csrfHash;

		if (key) {
			$.ajax({
				type : 'POST',
				url : 'https://poslite-license.herokuapp.com/index.php/LicenseController/validateLicense',
				data : ajaxData,
				beforeSend : function() {
					$("#key-submit").button('loading');
				},
				success : function(data) {
					 
					if (data ) {
						var result = JSON.parse(data);
						jsonData['data'] = result;
						
						$.ajax({
							type : 'POST',
							url : base_url + 'LicenseController/activateLicense',
							data : jsonData,
							success : function(data) {
								 window.location.href = data;
							}
						})
					} else {
					 	alert('Invalid License Key');
					}

					$("#key-submit").button('reset');
				},
				error : function() {
					$("#key-submit").button('reset');
				}
			})
		}
	})

	
})


function readURL(input) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			
			$('#imagePreview').css('background-image', "url("+e.target.result+")");
			$("#imagePreview img").hide();
		}

		reader.readAsDataURL(input.files[0]);
	}
}