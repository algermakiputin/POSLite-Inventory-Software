$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var csrfName = $("meta[name='csrfName']").attr('content');
	var csrfHash = $("meta[name='csrfHash']").attr('content');
	var license = $("meta[name='license']").attr('content');
	var totalAmountDue = 0;
	var totalDiscount = 0;
	var transactionComplete = false;
	var currency = '₱';
	var transaction_type = "cash";


	var dHeight = parseInt($(document).height());

	var new_customer = 0;
	
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

	var transaction_type_select = $("#transaction-type").selectize({
		sortField: 'text',
	});

	window.addEventListener('selectstart', function(e){ e.preventDefault(); });
	
	dHeight = dHeight - 58;
	$(".header .box").css('height', dHeight + 'px');
	$(".header .box").css('overflow-y', 'auto');
	$("#cart-tbl").css('min-height', (dHeight - (285)) + 'px');
	$("#cart-tbl").css('max-height', (dHeight - (255 + 231)) + 'px');

	
	$(document).pos();
	$(document).on('scan.pos.barcode', function(event){
 
		if (license === "silver" || license === "gold") {
			if (event.code.length > 5) {
				data = {};
				data[csrfName] = csrfHash;
				data['code'] = event.code;
				$.ajax({
					type : 'POST',
					url : base_url + 'items/find',
					data : data,
					success : function(data) {
						if (data) {
							var result = JSON.parse(data);
							var quantity = 1;
						 	var subtotal = parseInt(quantity) * parseFloat($("#price").text().substring(1));
						 	totalAmountDue += parseFloat(subtotal);

						 	if ( parseInt(result.quantity) > 0 ) {
						 		 
					  	 		if (itemExist(result.id,result.quantity) == false) {
						  	 		var quantity = 1;
								 	var subtotal = parseInt(result.quantity) * parseFloat($("#price").text().substring(1));
								 	totalAmountDue += parseFloat(result.subtotal);
									$("#cart tbody").append(
											'<tr>' +
												'<input name="id" type="hidden" value="'+ result.id +'">' +
												'<td>'+ result.name +'</td>' +
												'<td><input data-stocks="'+result.quantity+'" data-remaining="'+result.quantity+'" data-id="'+result.id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box"></td>' +
												'<td> <input type="text" value="0" placeholder="Discount" name="discount" class="discount-input"></td>' +
												'<td>'+ result.price +'</td>' +
									 			
												'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
											'</tr>'
										);
									recount();
									$("payment").val('');
									$("change").val('');

						  	 	}
						  	 	stockCol.text(parseInt(stocks - 1));
						  	  
						 	}else {
						 		alert("Not enough stocks remaining");
						 	}
  

							recount();
							$("payment").val('');
							$("change").val('');
						}else 
							alert('No item found in the database');
					 
					}
				})
			}
		} else {
			alert("Your license does not support Barcode Feature, Upgrade Now!");
		}
 
	}); 
	 
	data = {};
	data[csrfName] = csrfHash;
	var item_table = $("#item-table").DataTable({
		processing : true, 
		serverSide : true,
		 "bPaginate": true,
		pagin:true,
		"targets": 'no-sort',
		"bSort": false,
		ajax : {
			url : base_url + 'items/data',
			data : data,
			type : 'POST'
		},
	});

	$("#transaction-type").change(function() {

		var type = $(this).val();

		if (type === "cash") {

			$("#cash-fields").show();

		}else {

			$("#cash-fields").hide();
		}

		transaction_type = type;


	});

	$("#item-table").on('click', 'tbody tr', function(event) {
		var id = $(this).find('td').eq(0).text();
		var name = $(this).find('td').eq(1).text();
		var stockCol = $(this).find('td').eq(3);
		var stocks = stockCol.text();
		var price = no_format($(this).find('td').eq(4).text());
		var description = $(this).find('td').eq(2).text();

	 	if ( parseInt(stocks.split(' ').join('')) > 0 ) {
	 		if (id && name && stocks && price && description) {
	  	 		if (itemExist(id,stocks) == false) {
		  	 		var quantity = 1;
				 	var subtotal = parseInt(quantity) * parseFloat($("#price").text().substring(1));
				 	totalAmountDue += parseFloat(subtotal);
					$("#cart tbody").append(
							'<tr>' +
								'<input name="id" type="hidden" value="'+ id +'">' +
								'<td>'+ name +'</td>' +
								'<td><input data-stocks="'+stocks+'" data-remaining="'+stocks+'" data-id="'+id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box"></td>' +
								'<td class="text-right">'+ currency + number_format(price) +'.00</td>' +
					 			'<td class="text-right">' + currency + number_format(price * quantity) +'.00</td>' +
								'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
							'</tr>'
						);
					recount();
					$("payment").val('');
					$("change").val('');
		  	 	}
		  	 	stockCol.text(parseInt(stocks - 1));
	  	 	}
	 	}else {
	 		alert("Not enough stocks remaining");
	 	}
  	 	 
	})

	$("#process-transaction").submit(function(e) {

		e.preventDefault();
		var row = $("#cart tbody tr").length;
	
		if (row) {
			var modal = $("#confirm-transaction-modal"); 

			$("#confirm-transaction-modal").modal("toggle");
			$("#grand_total").text(currency + number_format(totalAmountDue.toFixed(2)));

			return;
		}

		alert("Please add some items to continue");

	});
	
	$("#complete-transaction").click(function(e) {
		e.preventDefault();

		var row = $("#cart tbody tr").length;
		var totalAmountDue = no_format($("#amount-total").text()); 
		var sales = [];
		var customer_id = $("#customer_id").val();
		var customer_name = $("#customer-select option:selected").val();
		var note = $("#note").val();
		var total_amount = 0;
		// var discount = $("#amount-discount").text();
		var payment = $("#payment").val() || 0;
		var change = $("#change").val() || 0;

		if ( !customer_name )
			return alert("Customer is empty"); 

		if (transaction_type != "cash" || transaction_type != "standby") {

			if (!customer_name || !customer_id || customer_id == "0") {
				return alert("Error: Customer is empty, Please select a customer.");
			}
		}
 	  
		if (parseFloat(payment) < parseFloat(totalAmountDue) && transaction_type === "cash")
	 		return alert("Insufficient Amount");


			for (i = 0; i < row; i++) { 
			var r = $("#cart tbody tr").eq(i).find('td');
			var quantity = r.eq(1).find('input').val();
			var price = r.eq(3).text().substring(1).replace(',','');
			var arr = {
					id : $("#cart tbody tr").eq(i).find('input[name="id"]').val(), 
					quantity : quantity, 
					price : price,
					name : r.eq(0).text(),
					subtotal : parseFloat(price) * parseInt(quantity),
					discount : $("#cart tbody tr").eq(i).find('input[name="discount"]').val()
				};

			total_amount += parseFloat(price) * parseInt(quantity);
			sales.push(arr);
		}

		total_amount -= totalDiscount;
		// Receipt Items
		$("#r-items-table tbody").empty();
		$.each(sales, function(key, value) {
	 	 
			$("#r-items-table tbody").append(
					'<tr>' + 
						'<td>'+value.name +'</td>' +
						'<td>'+currency+ number_format(value.price) +'</td>' +
						'<td>'+value.quantity+'</td>' +
						'<td>'+currency+ number_format(value.subtotal)+'</td>' +
					'</tr>'
				);
		});

		var data = {};
		data['sales'] = sales;
		data['transaction_type'] = transaction_type;
		data['customer_name'] = customer_name;
		data['customer_id'] = customer_id;
		data['total_amount'] = totalAmountDue;
		data['note'] = note;
		data[csrfName] = csrfHash;
		$.ajax({
			type : 'POST',
			data : data,
			url : base_url + 'SalesController/insert',
			beforeSend : function() {
				$("#btn").button('loading');
			},
			success : function(data) { 
				transactionComplete = true;
				var total = parseFloat(total_amount);
			 	$("#confirm-transaction-modal").modal("toggle");
				$("#payment-modal").modal('toggle');
				$("#loader").hide();
				//Transaction Summary 

				$("#summary-payment").text( currency + number_format(payment));
				$("#summary-change").text( currency + number_format(change));
			 	$("#summary-discount").text(currency + number_format(totalDiscount));
				$("#summary-total").text( currency + number_format(total_amount) )
				
				//Fill In Receipt 
				$("#r-payment").text( currency + number_format(payment));
				$("#r-change").text( currency + number_format(change));
				$("#r-cashier").text($("#user").text()); 
				$("#r-total-amount").text( currency + number_format(total_amount) )
				$("#r-discount").text(currency + number_format(totalDiscount));
				$("#r-id").text(data);
				$("#r-transaction").text(transaction_type);

				$("#note").val('');
			 	$("#cart tbody").empty();
			 	$("#payment").val('');
			 	$("#change").val('');
			 	$("#amount-due").text(''); 
			 	$("#amount-total").text('');
			 	$("#amount-discount").text(''); 
			 	$("#customer_id").val(0); 
			 	$("#customer-select").data('selectize').setValue('Walk-in Customer');
			 	$("#transaction-type").data('selectize').setValue('cash'); 
			 	item_table.clear().draw();
			 	$("#btn").button('reset');
			 	totalAmountDue = 0;  
				totalDiscount = 0;
				transaction_type = "cash"; 
			}
		}) 
			    
	})

	$("#payment").keyup(function() {

		var payment = parseFloat($(this).val());

		var cart = $("#cart tbody tr").length;
		if (cart) {
			var totalAmountDue = parseFloat($("#amount-total").text().substring(1).replace(',',''));

			if (payment >= totalAmountDue) {
		 	
				return $("#change").val((payment - totalAmountDue).toFixed(2));
			} 

			return $("#change").val('Insufficient Amount');
		} 
		
		return $(this).val('');
		 

	})

	$("#cart").on('click', '.remove',function() {
		var row = $(this).parents('tr');
		var remainingStocks = row.find('.quantity-box').data('stocks');
		var itemID = row.find('.quantity-box').data('id');
		calculateRemainingStocks(remainingStocks, itemID);
		row.remove();
		recount();
	})

	$("#cart").on('input, change, keyup', '.discount-input', function(e) {
		if (e.which == 13) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		}

		var row = $(this).parents('tr');

		var total = parseInt(row.find('input[name="qty"]').val()) * parseFloat(row.find('td').eq(3).text().substring(1).replace(',',''));
		var discount = parseInt($(this).val());
	 
		if (discount != "") {
	 
			if (total <= discount) {
				alert('Discount cannot be greater or equal than the item total value');
				$(this).val(0);
			} 

			recount();

		}else {
			$(this).val('');
		}

	})

	$("#cart").on('focusout','.quantity-box',function(e) {
		var quantity = parseInt($(this).val()); 
		if (isNaN(quantity) || quantity < 0) {
			$(this).val(1);
		 
			calculateRemainingStocks($(this).data('stocks') - 1, $(this).data('id'))
			return quantity = 1; 
		}
	})

 	$("#cart").on('input', '.quantity-box', function(e) {

 		// I Dont remember what this function does :)
 		if (e.which == 13) {
 			e.stopPropagation();
 			return false;
 		}

		var quantity = parseInt($(this).val());
		var currentStocks = $(this).data('stocks');
		var itemID = $(this).data('id');
		var remaining = $(this).data('stocks') - quantity;

		$(this).data('remaining', remaining);
		if (isNaN(quantity) || quantity < 0) {
			return quantity = 1; 
		}

		if ( !isNaN(quantity) && quantity != 0 || $(this).val() == "" ) {
			var row = $("#item-table").find('td').text() == itemID;

			if (quantity <= parseInt(currentStocks)) {
				var row = $(this).parents("tr");
				var priceCol = row.find('td').eq(2);
				var price = no_format(priceCol.text());
				var sub = price * quantity;

				row.find("td").eq(3).text( currency + number_format(sub.toFixed(2)) );

				var subtotal = parseInt(quantity) * parseFloat(price);
				calculateRemainingStocks(remaining,itemID);
				return recount();
			}
			
			alert('Not enough stocks only ' + currentStocks + ' remaining.');
			$(this).val(1);
			calculateRemainingStocks(currentStocks - 1,itemID);
			return recount();
		}

		
	})


	$("#cart").on("blur focusout focus", ".quantity-box", function() {

		if ($(this).val() == "" || isNaN(parseInt($(this).val()))) {
			$(this).val(1);
			var quantity = parseInt(1);
			var currentStocks = $(this).data('stocks');
			var itemID = $(this).data('id'); 
			calculateRemainingStocks(currentStocks - quantity,itemID);
			return recount();
		}
	}); 


	/*
		1. Accepts Two Arguments
			A. The remaining stocks from Quantity Box Data
			B. The Item ID
		2. Find the item with ID in the table and update the remaining Quantity
	*/
	function calculateRemainingStocks(remaining, itemID) {
		var table = $("#item-table > tbody > tr");
		$.each(table, function(key, value) {
			var val = $(value);
			var id = val.find('td').eq(0).text();
			if (id == itemID) {
				return val.find('td').eq(3).text(remaining);
			} 
		});
	}


	/*
		Function Loop through the cart table
		To calculate the total amount
	*/
function itemExist(itemID,stocks) {
		var table = $("#cart-tbl tbody tr");
	 	var exist = false;
		$.each(table, function(index) {
			id = ($(this).find('[name="id"]').val());
			if (id == itemID) {
				qtyCol = $(this).find('[name="qty"]');
				qty = parseInt(qtyCol.val());

				qtyCol.val(qty + 1);
		 		recount(); 
				exist = true; 
			}
		})

		return exist;
}

function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		var discountAmount = 0;

		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			var quantity = parseInt(r.eq(1).find('input').val());
			var price = r.eq(3).text().substring(1).replace(',',''); 

			total += parseFloat(price) * quantity;
 
			
		} 
		totalAmountDue = total;
		
		$("#amount-discount").text(currency + totalDiscount.toFixed(2));
		$("#amount-total").text("₱" + number_format(totalAmountDue.toFixed(2)));
}

 

	$("#print").click(function(){
		$("#receipt").print({
	        	globalStyles: true,
	        	mediaPrint: false,
	        	stylesheet: base_url + 'assets/receipt.css',
	        	noPrintSelector: ".no-print",
	        	iframe: true,
	        	append: null,
	        	prepend: null,
	        	manuallyCopyFormValues: true,
	        	deferred: $.Deferred(),
	        	timeout: 500,
	        	title: 'Receipt',
	        	doctype: '<!doctype html>'
		});
	});


})

function create_customer(name) {

	var data = {};
	data[csrfName] = csrfHash;
	data['name'] = name

	$.ajax({
		type: 'POST',
		url : base_url + 'CustomerContorller/insert',
		data: data,
		success: function(data) {
			alert("Customer Added successfully");
		}
	}) 
}

 

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

function no_format(str) {

	return parseFloat((str.slice(1).replace(/,/g, "")).slice(0,-3));
}

