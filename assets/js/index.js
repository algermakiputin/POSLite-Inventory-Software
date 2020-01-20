$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var currency = '₱';
	var site_live = $("meta[name='site_live']").attr('content');
	var csrfName = $("meta[name='csrfName']").attr('content');
	var csrfHash = $("meta[name='csrfHash']").attr("content");
	var api_key = $("meta[name='api_key']").attr('content');
	var hide = $("meta[name='admin']").attr("content") == 1 ? true : false;

	$("body").on("click", ".delete-data", function(e) {

		var confirm = window.confirm("Are you sure you want to delete that data?");

		if (!confirm) {

			e.preventDefault();
			return false;
		}
	});

	// $("#side-menu a").click(function() {

	// 	if ($(this).attr('href') != "#") {
	// 		$(".spinner-wrapper").show();
	// 	}
	// })
	 

	$("body").show();
	$("form").parsley();	

	var data = {};
	data[csrfName] = csrfHash;
	
	
	$('[data-toggle="tooltip"]').tooltip();
	$(".datatable").DataTable({
		dom: "ltrp",
		order: [[0, 'DESC']]
	});

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

		var stocksTransfer = {
			init: function() {
				this.internal_po_datatable();
				this.external_po_datatable();
			},
			internal_po_datatable: function() {
				$("#transfer-purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/StocksTransferController/internal_po_datatable',
						type : 'POST',
						data : data
					},
				});
			},
			external_po_datatable: function() {
				$("#transfer-external-purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/StocksTransferController/external_po_dataTable',
						type : 'POST',
						data : data
					},
				});
			},
	

		}

		var purchaseOrderController = {
			init: function() {
				this.findInvoice();
				this.external_po_datatable();
				this.internal_po_datatable();
			},
			findInvoice: function() {

				$("#enter-invoice").click(function() {

					let invoice = $("#invoice-number").val();
					var data = {};

					data[csrfName] = csrfHash;
					data['invoice'] = invoice;

					if (invoice) {

						$.ajax({
							type: 'POST',
							url: base_url + 'StocksTransferController/find_po',
							data: data, 
							success: function(data) { 
								
								if (data != '0') {
									var result = JSON.parse(data);
									
									var total = 0;
									var tbody = $("#products-table tbody").empty();

									for (i = 0; i < result.orderline.length; i++) {

										 tbody.append('<tr><td><input type="text" readonly="readonly" autocomplete="off" value="'+result.orderline[i].name+'" class="form-control product" required="required" name="product[]"><input type="hidden" name="product_id[]" value="'+result.orderline[i].item_id+'"></td><td><input type="number" required="required" autocomplete="off" value="'+result.orderline[i].quantity+'" min="1" data-qty="'+result.orderline[i].quantity+'" class="form-control quantity" name="quantity[]"></td><td><input type="text" required="required" autocomplete="off" class="form-control" value="'+result.orderline[i].price+'" name="price[]"></td><td><input type="text" autocomplete="off" class="form-control" value="'+result.orderline[i].price * result.orderline[i].quantity+'" name="sub[]" readonly="readonly"></td><td><i class="fa fa-trash delete-row"></i> &nbsp;</td></tr>')
										 total += result.orderline[i].price * result.orderline[i].quantity;
									}

									$("#grand-total").text(currency + total);

									$("#store-number").val(result.details.store_number);

								}else {
									alert("Error: No Invoice Found in the database");
								}
								
                   
								 
							}     
						})
					}
				})
			},
			internal_po_datatable: function() {
				$("#purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/PurchaseOrderController/dataTable',
						type : 'POST',
						data : data
					},
				});
			},
			external_po_datatable: function() {
				$("#external-purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/PurchaseOrderController/external_dataTable',
						type : 'POST',
						data : data
					},
				});
			}
		}

		var itemTable;
		var items = {		
			init : function() {
				this.dataTable();
				this.dataTableFilter();
				this.clearDataTableFilter();
				this.deleteItem();
				this.changeImage();
				this.itemForm();
				this.storeFilter();
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
					lengthMenu : [[10, 25, 50, 250, 1000, 3000], [10, 25, 50, 250, 1000, 3000]],
					ajax : {
						url : base_url + 'ItemController/dataTable',
						type : 'POST',
						data : data
					},
					dom : "lfrtBp",
					"targets": 'no-sort',
					"bSort": false,
					columnDefs: [
						{ 
							targets: [3,6], 
							visible: hide,
							searchable: hide
						},
					],
					buttons: [
						{
							extend: 'copyHtml5',
							filename : 'Inventory Report',
							title : 'Inventory',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6 ]
							},
						},
						{
							extend: 'excelHtml5',
							filename : 'Inventory',
							title : 'Inventory Report',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6 ]
							},
						},
						{
							extend: 'pdfHtml5',
							filename : 'Inventory Report',
							title : 'Inventory',
							messageTop : 'Inventory Report',
							className : "btn btn-default btn-sm",
							exportOptions: {
								columns: [ 1, 2, 3,4,5,6 ]
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

					if (column == 4) {
						itemTable.columns(5).search('');
					}

					if (column == 5) 
					{
						itemTable.columns(4).search('');
						
					}

					itemTable.columns(column).search(this.value).draw();

						
				});
			},
			storeFilter: function() {
				$("#store-selector").change(function() {

					itemTable.columns(6).search($(this).val()).draw();
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
					columnDefs: [{
						targets: [1, 8],
						visible: hide ,
						searchable:hide
					} ],
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
							$("#customer-edit input[name='name']").val(customer.name); 
							$("#customer-edit input[name='address']").val(customer.address); 
							$("#customer-edit input[name='city']").val(customer.city);
							$("#customer-edit input[name='zipcode']").val(customer.zipcode);
							$("#customer-edit input[name='number']").val(customer.contact_number);
						}

					});
				})
			},
			graphSales : function() {

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
						$("#customer_table_length").append( '&nbsp; <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Customer</button>');
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
						
						$("#supplier_table_length").append('&nbsp; <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Supplier</button>')
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
					useCurrent : false,
					todayHighlight: true,
    				toggleActive: true,
    				autoclose: true,
				});

				 $("#datetimepicker6").on("dp.change", function (e) {
			        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
			    });
			    $("#datetimepicker7").on("dp.change", function (e) {
			        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
			    });

				$("#min-date").change(function(e){
					$("#max-date").datepicker({
						startDate : new Date(),
						todayHighlight: true,
	    				toggleActive: true,
	    				autoclose: true,
					})
				})
			}
		} 

		var transactions = {

			init: function() {

				this.credits_DataTable();
				this.invoice_DataTable();
				this.standby_order_DataTable();
			},
			credits_DataTable : function() {
				data = {};
				data[csrfName] = csrfHash;
				var credits_tbl = $("#credits_tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'TransactionsController/credits_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false,
					 
					 
				})
			},
			invoice_DataTable : function() {
				data = {};
				data[csrfName] = csrfHash;
				var credits_tbl = $("#invoice_tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'TransactionsController/invoice_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false, 
					 
				})
			},
			standby_order_DataTable : function() {
				data = {};
				data[csrfName] = csrfHash;
				var standby_orders_table = $("#standby_orders_tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'TransactionsController/standby_order_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false, 
					 
				})
			},
		}

		var reports = {

			init: function() {
				this.description();
				this.product_sales();
				this.best_seller();
			},

			description: function() { 

				data = {};
				data[csrfName] = csrfHash;
				itemTable = $("#sales-description-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'ReportsController/description_datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,
					 
				});
			},

			product_sales: function() {
				data = {};
				data[csrfName] = csrfHash; 
				var product_sales_tbl = $("#product-sales-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'ReportsController/product_sales_datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,  
					"dom": "r",
					"processing" : true,
					drawCallback : function (setting) {
						var data = JSON.parse(setting.json.extra);
						console.log(data);
						$("#total-sales").text(data.total);

					}
				}); 

				$("#to").change(function() {

					if ( date_range = date_range_select("from", "to") ) {
				 
						product_sales_tbl.columns(0).search(date_range[0])
									.columns(1).search(date_range[1])
									.draw();

					}
				}); 
			},

			best_seller: function() {
				data = {};
				data[csrfName] = csrfHash; 
				var best_seller_tbl = $("#best-seller-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'ReportsController/best_seller_datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,  
					"dom": "r",
					"processing" : true, 
				}); 

				$("#to").change(function() { 
					if ( date_range = date_range_select("from", "to") ) {
				 
						best_seller_tbl.columns(0).search(date_range[0])
									.columns(1).search(date_range[1])
									.draw();

					}
				}); 
			},
		}

		reports.init();
		transactions.init();
		expenses.init();
		dateTimePickers.init();
		items.init();
		sales.init();
		customers.init();
		suppliers.init();
	 	purchaseOrderController.init();
	 	stocksTransfer.init();
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

	var data = {};
	data[csrfName] = csrfHash;

	$("#history_table").DataTable({
		processing : true, 
		ordering : false, 
		serverSide : true, 
		ajax : {
			type : "POST",
			data: data,
			url : base_url + "UsersController/history_datatable"
		}, 
	});

	$("#users_table").DataTable({
		"targets": 'no-sort',
		"bSort": false,
	});
	$("#categories_table").DataTable({
		ordering : false
	});

	var data = {};
	data[csrfName] = csrfHash;
	$("#deliveries_table").DataTable({
		processing : true, 
		serverSide : true, 
		ajax : {
			type : "POST",
			url : base_url + "DeliveriesController/datatable",
			data: data
		}, 
	});

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
		var serial = $(this).find('[name=serial]').val();

		var jsonData = {};
		var ajaxData = {};
		ajaxData['api_key'] = api_key;
		ajaxData['key'] = key;
		ajaxData['serial'] = serial;
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