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

	var customer_options = $("#customer-select").selectize({
		create: true, 
    	 persist: false,
    	onInitialize: function () {
			var s = this;
			this.revertSettings.$children.each(function () {
			    $.extend(s.options[this.value], $(this).data());
			});
	   },
	   onChange: function (value) {
	   	console.log(value)
	   	var option = this.options[value];
 			$("#customer_id").val(option.id);
	   } 
	});
	
	
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
				this.delivery_notes_datatable();
			},
			internal_po_datatable: function() {
				var transfer_purchase_order_tbl = $("#transfer-purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/StocksTransferController/internal_po_datatable',
						type : 'POST',
						data : data
					},
				});

				$("#transfer-purchase-order-filter").change(function() {

					var store_number = $(this).val();
					transfer_purchase_order_tbl.columns(0).search(store_number).draw();
				})

				$("body").on('click', '.print-dm', function(e) {

					var url = $(this).data('url');

					window.open(url,'popUpWindow','height=768,width=1280,left=150,top=150,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
				})

			},
			delivery_notes_datatable: function() {
				var delivery_notes_datatable = $("#delivery-notes-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/StocksTransferController/delivery_notes_dataTable',
						type : 'POST',
						data : data
					},
					dom:'lrtip'
				});

				$("#delivery-notes-store-filter").change(function(e) {
 
					var store_number = $(this).val(); 
					delivery_notes_datatable.columns(0).search(store_number).draw();
				})
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
				this.find_external_po();
			},

			find_external_po: function() {

				$("#enter-external-po").click(function() {

					var external_po_number = $("#external-po-number").val();

					var data = {};

					data[csrfName] = csrfHash;
					data['external_po_number'] = external_po_number;

					if (external_po_number) {

						$.ajax({
							type: 'POST',
							url: base_url + 'PurchaseOrderController/find_external_po',
							data: data, 
							success: function(data) { 
								
								if (data != '0') {
									var result = JSON.parse(data);
								       
									var total = 0;
									var tbody = $("#products-table tbody").empty();

									for (i = 0; i < result.orderline.length; i++) {
										console.log(result.orderline[i]);

										tbody.append('<tr><td>'+
												'<input type="text" value="'+result.orderline[i].product_name+'" readonly="readonly" autocomplete="off" class="form-control product" required="required" name="product[]">'+
												'<input type="hidden" name="product_id[]" value="'+result.orderline[i].product_id+'">'+
                                 '</td>' + 
                                 '<td>' + 
                                		'<input type="number" required="required" value="'+result.orderline[i].quantity+'" autocomplete="off" class="form-control quantity" name="quantity[]">'+
                                	'</td>' +
                                 '<td>' +   
                                		'<input type="text" required="required" value="'+result.orderline[i].price+'" autocomplete="off" class="form-control" name="price[]">'+
                                	'</td>' +
                                 '<td>' +  
                                		'<input type="text" autocomplete="off" value="'+result.orderline[i].price * result.orderline[i].quantity+'" class="form-control" name="sub[]" readonly="readonly">' +
                                	'</td></tr>');
										 // tbody.append('<tr>' +
										 // 	'<td><input type="text" class="form-control" readonly name="product_id[]" value="'+result.orderline[i].product_id+'"></td>'+
										 // 	'<td><input type="text" readonly="readonly" autocomplete="off" value="'+result.orderline[i].product_name+'" class="form-control product" required="required" name="product[]"></td>'+
										 // 	'<td><input type="number" required="required" autocomplete="off" value="'+result.orderline[i].quantity+'" min="1" data-qty="'+result.orderline[i].quantity+'" class="form-control quantity" name="quantity[]"> <input type="hidden" required="required" autocomplete="off" class="form-control" value="'+result.orderline[i].price+'" name="price[]"><input type="hidden" autocomplete="off" class="form-control" value="'+result.orderline[i].price * result.orderline[i].quantity+'" name="sub[]" readonly="readonly"></td><td><i class="fa fa-trash delete-row"></i> &nbsp;</td></tr>')
										 total += result.orderline[i].price * result.orderline[i].quantity;
									}

									$("#total_amount").val(total);
									$("#grand-total").text(currency + total);

									$("#store-number").val(result.details.store_number); 
									$("#customer_name").val(result.details.customer_name);
									$("#customer_id").val(result.details.customer_id);

								}else {
									alert("Error: No Invoice Found in the database");
								}
								 
							}     
						})
					}else {
						alert("External PO Number Is empty");
					}
				})

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
									console.log(result);
									var total = 0;
									var tbody = $("#products-table tbody").empty();

									for (i = 0; i < result.orderline.length; i++) {

										 tbody.append('<tr><td><input type="text" class="form-control" readonly name="product_id[]" value="'+result.orderline[i].item_id+'"></td><td><input type="text" readonly="readonly" autocomplete="off" value="'+result.orderline[i].name+'" class="form-control product" required="required" name="product[]"></td><td><input type="number" required="required" autocomplete="off" value="'+result.orderline[i].quantity+'" min="1" data-qty="'+result.orderline[i].quantity+'" class="form-control quantity" name="quantity[]"> <input type="hidden" required="required" autocomplete="off" class="form-control" value="'+result.orderline[i].price+'" name="price[]"><input type="hidden" autocomplete="off" class="form-control" value="'+result.orderline[i].price * result.orderline[i].quantity+'" name="sub[]" readonly="readonly"></td><td><i class="fa fa-trash delete-row"></i> &nbsp;</td></tr>')
										 total += result.orderline[i].price * result.orderline[i].quantity;
									}

									$("#grand-total").text(currency + total);

									$("#store-number").val(result.details.store_number);

									$("#customer_name").val(result.details.customer_name);
									$("#customer_id").val(result.details.customer_id);

								}else {
									alert("Error: No Invoice Found in the database");
								}
								 
							}     
						})
					}else {
						alert("Invoice Is empty");
					}
				})
			},
			internal_po_datatable: function() {
				var purchase_order_tbl = $("#purchase-order-tbl").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/PurchaseOrderController/dataTable',
						type : 'POST',
						data : data
					},

				});

				$("#internal-po-store-filter").change(function() {

					var store_number = $(this).val();

					purchase_order_tbl.columns(0).search(store_number).draw();
					
				})
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
					data['store_number'] = $(this).val();

					$.ajax({
						type: 'POST',
						url: base_url + '/ItemController/inventory_total',
						data: data,
						success: function(data) {

							$("#total").text( data );
						},
						error: function(data) {

						}

					})
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

				$("#sales-store-filter").change(function(e) {
					var store_number = $(this).val();

					sales_table.columns(2).search(store_number).draw();
				})
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
				
				$("#expenses-store-filter").change(function(e) {

					expensesTable.columns(2).search($(this).val()).draw();
				})
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
				var invoice_tbl = $("#invoice_tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'TransactionsController/invoice_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false, 
					 
				});

				$("#invoice-store-filter").change(function() {

					var store_number = $(this).val();

					invoice_tbl.columns(0).search(store_number).draw();

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
				this.cash_DataTable();
				this.credits_DataTable();
			},

			cash_DataTable: function() {
				data = {};
				data[csrfName] = csrfHash;

				var credits_tbl = $("#cash-tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'ReportsController/cash_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false,
					drawCallback : function (setting) {
						var data = JSON.parse(setting.json.extra);
						console.log(data);
						$("#total-sales").text(data.total);

					} 
				});

				$("#cash-store-filter").change(function(e) { 
					credits_tbl.columns(2).search($(this).val()).draw();
				});

				$("#to").change(function() {

					if ( date_range = date_range_select("from", "to") ) {
				 
						credits_tbl.columns(0).search(date_range[0])
									.columns(1).search(date_range[1])
									.draw();

					}
				}); 
			},

			credits_DataTable: function() {
				data = {};
				data[csrfName] = csrfHash;

				var credits_DataTable = $("#credits-tbl").DataTable({
					bProcessing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'ReportsController/credits_datatable',
						type : 'POST',
						data : data
					},
					"targets": 'no-sort',
					"bSort": false, 
					drawCallback : function (setting) {
						var data = JSON.parse(setting.json.extra);
						console.log(data);
						$("#total-sales").text(data.total);

					} 
				})

				$("#cash-store-filter").change(function(e) { 
					credits_DataTable.columns(2).search($(this).val()).draw();
				});

				$("#to").change(function() {

					if ( date_range = date_range_select("from", "to") ) {
				 
						credits_DataTable.columns(0).search(date_range[0])
									.columns(1).search(date_range[1])
									.draw();

					}
				}); 
 
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

		var payments = {

			init: function() {
				this.find_invoice();
				this.calculate();
				this.submitForm(); 
				this.datatable();
			},
			find_invoice: function() {

				$("#find-invoice").click(function(e) {

					var data = {};
					var invoice = $("#invoice_number").val();
					data[csrfName] = csrfHash;
					data['invoice_number'] = invoice;

					$.ajax({
						type: 'POST',
						url: base_url + '/PaymentsController/find_invoice',
						data: data,
						success: function(data) {

							if (data != "0") {

								var result = JSON.parse(data);

								$("#customer_id").val(result.customer_id);
								$("#customer_name").val(result.customer_name);
								$("#total_amount").val(result.total);
								$("#invoice_number").attr('readonly', 'readonly');
								$("#payment").focus();


								$("#payment-area").show();
								$("#find-button").hide();


								
							}else {

								$("#payment-area").hide();
								$("#find-button").show();
								alert("Invalid Invoice Number or No Transaction Found");
							}
						},
						error: function(data) {
							alert("Opps something went wrong please try again later");
						}
					})
				})
			},
			calculate: function() {

				$("#payment").keyup(function() {

					var payment = parseFloat($(this).val());
					var total = parseFloat($("#total_amount").val());
					var change = parseInt(payment - total);


					if (change < 0) {
 
						$("#valid").val(0);
						$("#change").val(0);
					}else {

						$("#change").val(change);
						$("#valid").val(1);	
					}

					
				})
			},
			submitForm: function() {

				$("#enter-payment").click(function(e) {
					
					if ($("#valid").val() == 1) {
						$("#payment_form").submit();
					}else {
						alert("Insufficient Payment");
					}
				});
			},
			datatable: function() {

				var paymentsDataTable = $("#payments_table").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'PaymentsController/datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,  
					"dom": "r",
					"processing" : true 
				}); 

				$("#payments_to").change(function() {

					var from = $("#payments_from").val();
					var to = $("#payments_to").val();
					
					if (from && to) {

						paymentsDataTable.columns(1).search(from)
											.columns(2).search(to)
											.draw();
					} 
				})

				$("#store-selector").change(function(e) {

					var store_number = $(this).val();

					paymentsDataTable.columns(0).search(store_number).draw();
				});
			}
		}

		var refunds = {

			init: function() {

				this.find_invoice();
				this.quantity_validation();
				this.refundsDatatable();
			},
			find_invoice: function() {

				$("#return-invoice").click(function() {

					var invoice_number = $("#invoice_number").val();
					var data = {};
					data[csrfName] = csrfHash;
					data['invoice_number'] = invoice_number;

					if (invoice_number) {

						$.ajax({
							type: 'POST',
							url: base_url + '/SalesController/find_invoice',
							data: data,
							success: function(data) {

								if (data != '0') {

									var result = JSON.parse(data);
									var tbody = $("#order-description tbody");

									for (i = 0; i < result.orderline.length; i++) {

										tbody.append('<tr>' +
												'<td> <input type="hidden" name="sales_description_id[]" value="'+result.orderline[i].id+'">'+result.orderline[i].name+'</td>'+
												'<td> <input type="hidden" name="product_names[]" value="'+result.orderline[i].name+'">'+result.orderline[i].price+'</td>'+
												'<td> <input type="hidden" name="prices[]" value="'+result.orderline[i].price+'">'+result.orderline[i].quantity+'</td>'+
												'<td><input type="text" data-qty="'+result.orderline[i].quantity+'" class="form-control quantities" name="quantities[]"></td>'+
											'</tr>');
 
									}

									$("#invoice").val(result.invoice.transaction_number);
									$("#customer_name").val(result.invoice.customer_name);
									$("#refund_form").show();
								}
							},
							error: function(data) {
								showErrorMessage();
							}
						});
					}else {
						alert("Error: Invoice Number is Empty");
					}
				});
			},
			quantity_validation: function() {

				$(document.body).on('keyup', '.quantities', function() {
				 
					var old_qty = $(this).data('qty');
					var qty = $(this).val();
		 
					if (qty > old_qty) {

						$(this).val(old_qty);

						alert("Refund quantity cannot be greather than quantity ordered");
					}
				})
			},
			refundsDatatable: function() {

				var data = {};
				data[csrfName] = csrfHash; 
				var refundDataTable = $("#refunds_table").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + 'RefundsController/datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,  
					"dom": "r",
					"processing" : true 
				}); 

				$("#store-selector").change(function(e) {

					var store_number = $(this).val();

					refundDataTable.columns(0).search(store_number).draw();
				});

				$("#refunds_to").change(function() {

					var from = $("#refunds_from").val();
					var to = $("#refunds_to").val();
					
					if (from && to) {

						refundDataTable.columns(1).search(from)
											.columns(2).search(to)
											.draw();
					}
				})
			}
		} 

		var cash_denomination = {

			init: function() {

				this.cash_denomination_table();
			},
			cash_denomination_table: function() {

				var data = {};
				data[csrfName] = csrfHash; 
				var denomination_datatable = $("#denomination_table").DataTable({
					processing : true,
					serverSide : true, 
					ajax : {
						url : base_url + '/CashDenominationController/denomination_datatable',
						type : 'POST',
						data : data
					}, 
					"targets": 'no-sort',
					"bSort": false,  
					"dom": "r",
					"processing" : true 
				}); 


				$("#store-selector").change(function(e) {

					var store_number = $(this).val();

					denomination_datatable.columns(0).search(store_number).draw();
				});

				$("#denomination_to").change(function() {

					var from = $("#denomination_from").val();
					var to = $("#denomination_to").val();
					
					if (from && to) {

						denomination_datatable.columns(1).search(from)
											.columns(2).search(to)
											.draw();
					}
				})

			}

		}

		cash_denomination.init();
		refunds.init();
		payments.init();
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
	var deliveries_datatable = $("#deliveries_table").DataTable({
		processing : true, 
		serverSide : true, 
		ajax : {
			type : "POST",
			url : base_url + "DeliveriesController/datatable",
			data: data
		}, 
	});

	$("#purchases-store-filter").change(function(e) {
	 
		var store_number = $(this).val();
		deliveries_datatable.columns(0).search(store_number).draw();

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

function showErrorMessage() {

	alert("Opps! Something Went Wrong Please Try Again Later");
}

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