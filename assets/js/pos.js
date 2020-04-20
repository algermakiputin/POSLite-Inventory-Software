	$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var csrfName = $("meta[name='csrfName']").attr('content');
	var csrfHash = $("meta[name='csrfHash']").attr('content');
	var license = $("meta[name='license']").attr('content');
	var totalAmountDue = 0;
	var totalDiscount = 0;
	var transactionComplete = false;
	var currency = '₱';


	var dHeight = parseInt($(document).height());
 	
	dHeight = dHeight - 60;
	$(".header .box").css('height', dHeight + 'px');
	$(".header .box").css('overflow-y', 'auto');
	$("#cart-tbl").css('min-height', (dHeight - (80 + 231 + 25)) + 'px');
	$("#cart-tbl").css('max-height', (dHeight - (80 + 150 + 231)) + 'px');


	$("body").on('click', '#advance_pricing_options tbody tr', function() {
  
  		$(this).find("input[type='radio']").prop('checked', true);
  	});



	window.addEventListener('selectstart', function(e){ e.preventDefault(); });
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
 
				  	 		var quantity = 1;
						 	var subtotal = parseInt(result.quantity) * parseFloat($("#price").text().substring(1));
						 	totalAmountDue += parseFloat(result.subtotal);
							$("#cart tbody").append(
									'<tr>' +
										'<input name="id" type="hidden" value="'+ result.id +'">' +
										'<input name="capital" type="hidden" value="'+ result.capital +'">' +
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
		ajax : {
			url : base_url + 'items/data',
			data : data,
			type : 'POST'
		},
	});

	$("#item-table").on('click', 'tbody tr', function(event) {
		var id = $(this).find('input[name="item-id"]').val();
		var name = $(this).find('td').eq(0).text(); 
		var price = $(this).find('td').eq(2).text();
		var description = $(this).find('td').eq(1).text();
		var pricing = $(this).find('input[name="advance_pricing"]').val();
		var capital = $(this).find('input[name="capital"]').val();
	 	 
 		if (itemExist(id) == false) {
	 		
 			var advance_pricing = JSON.parse(pricing);
			var enable_ap = Object.keys(advance_pricing).length;

			$("#product-name").text(name);
			$("#item_id").val(id);
			$("#capital").val(capital);


			$("#advance_pricing_options tbody").empty(); 
			$("#advance_pricing_options tbody").append("<tr>" +
						"<td>Base Price</td>" +
						"<td>"+price+"</td>" +
						'<td><input type="radio" checked  name="pricing" value="'+price+'" class="radio"></td>' +
					"</tr>"
					);

			$.each(advance_pricing, function(key, value) {

				$("#advance_pricing_options tbody").append("<tr>" +
						"<td>"+value.label+"</td>" +
						"<td>"+ currency + number_format(value.price) +".00</td>" +
						'<td><input type="radio" name="pricing" value="'+ currency + number_format(value.price) +'.00" class="radio"></td>' +
					"</tr>"
					);			
			});
 	
			
			// var price_options = JSON.parse(pricing);
			// console.log(price_options);
			$("#advance_pricing_modal").modal('toggle'); 
			
			$("payment").val('');
			$("change").val('');
	 	} 

	 	recount();
	});

	$('#advance_pricing_modal').on('hidden.bs.modal', function () {
	  	$("#quantity").val(1);
	});

	$("#add-product").click(function(e) {

		var item_id = $("#item_id").val();
		var name = $("#product-name").text();
		var quantity = $("#quantity").val();
		var price = $("input[name='pricing']:checked").val(); 
		let capital = $("#capital").val();


		if (!quantity)
			return alert("Quantity is required");

		$("#advance_pricing_modal").modal('toggle');  
		insert_product(item_id, name, price, quantity, capital);

	})

	$(document).on('keyup', function(e) {

  		if (e.keyCode === 13) {

  			if ($("#advance_pricing_modal").hasClass("in")) {

  				$("#add-product").click();
  				
  			}
  		}
  	})



	function insert_product(id, name, price, quantity, capital) {
 	
 		var sub = remove_comma(price.substring(1)) * quantity;

		$("#cart tbody").append(
				'<tr>' +
					'<input name="id" type="hidden" value="'+ id +'">' +
					'<input name="capital" type="hidden" value="'+ capital +'">' +
					'<td>'+ name +'</td>' +
					'<td><input  data-id="'+id+'" name="qty" type="text" value="'+quantity+'" autocomplete="off" class="quantity-box"></td>' +
					'<td> <input type="text" value="0" placeholder="Discount" name="discount" class="discount-input"></td>' +
					'<td>'+ price +'</td>' + 
					'<td>'+ currency + number_format(sub)  +'.00</td>' + 
					'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
				'</tr>'
			);
 
		recount();
	}

	function itemExist(itemID) {
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

	$("#process-form").submit(function(e) {
		e.preventDefault();
		var row = $("#cart tbody tr").length;
		var sales = [];
		var customer_id = $("#customer-id").val();
		var total_amount = 0;
		// var discount = $("#amount-discount").text();
		var payment = $("#payment").val();
		var change = $("#change").val();
 	 
 		if (row) {
 
	 
			if (parseFloat(payment) >= parseFloat(totalAmountDue)) {
		 		
	 			for (i = 0; i < row; i++) {
					var r = $("#cart tbody tr").eq(i).find('td');
					var quantity = r.eq(1).find('input').val();
					var price = remove_comma(r.eq(3).text().substring(1));
					var capital = $("#cart tbody tr").eq(i).find('input[name="capital"]').val()
					var arr = {
							id : $("#cart tbody tr").eq(i).find('input[name="id"]').val(), 
							quantity : quantity, 
							price : price,
							name : r.eq(0).text(),
							subtotal : parseFloat(price) * parseInt(quantity),
							discount : $("#cart tbody tr").eq(i).find('input[name="discount"]').val(),
							capital : capital
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
		 			 	var d = new Date();
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
						$("#r-time").text(d.toLocaleTimeString());

					 	$("#cart tbody").empty();
					 	$("#payment").val('');
					 	$("#change").val('');
					 	$("#amount-due").text(''); 
					 	$("#amount-total").text('');
					 	$("#amount-discount").text('');

					 	item_table.clear().draw();
					 	$("#btn").button('reset');
					 	totalAmountDue = 0;  
						totalDiscount = 0
					 	
					}
				})
				return;
			}  
			
			return alert("Insufficient Amount");
 		}
 		
 		return alert('Please add some items');
 		
		
	})

	$("#payment").keyup(function() {

		var payment = parseFloat($(this).val());

		var cart = $("#cart tbody tr").length;
		if (cart) {
 

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
		var quantity = parseFloat($(this).val()); 
		if (isNaN(quantity) || quantity < 0 || quantity == "") {
			$(this).val(1);
		 
			calculateRemainingStocks($(this).data('stocks') - 1, $(this).data('id'))
			return quantity = 1; 
		}
	})

 	$("#cart").on('input', '.quantity-box', function(e) {

 		if (e.which == 13) {
 			e.stopPropagation();
 			return false;
 		}

		var quantity = parseFloat($(this).val());
		var currentStocks = $(this).data('stocks');
		var itemID = $(this).data('id');
		var remaining = $(this).data('stocks') - quantity;

		$(this).data('remaining', remaining);
		if (isNaN(quantity) || quantity < 0) {
			return quantity = 1; 
		}

		if (!isNaN(quantity) && quantity != 0 || $(this).val() == "") {
			var row = $("#item-table").find('td').text() == itemID;

			 
			var row = $(this).parents("tr");
			var priceCol = row.find('td').eq(2);
			var price = priceCol.text().substring(1);
			var subtotal = parseInt(quantity) * parseFloat(price);
			calculateRemainingStocks(remaining,itemID);
			return recount();
		 
			
		 
		}

		
	})


	$("#cart").on("blur focusout", ".quantity-box", function() {
  
		var quantity = parseInt(1);
		var currentStocks = $(this).data('stocks');
		var itemID = $(this).data('id'); 
		calculateRemainingStocks(currentStocks - quantity,itemID);
		return recount();
	   
	}); 

	$("#cart").on("focus", ".quantity-box", function(e) {

		$(this).val('');
	})


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
	function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		var discountAmount = 0;

		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			var quantity = parseFloat(r.eq(1).find('input').val());
			var price = remove_comma(r.eq(3).text().substring(1));
			var discount = parseInt(r.eq(2).find('input').val());
			total += parseFloat(price) * quantity;

			r.eq(4).text(currency + number_format(price * quantity) + '.00');
			discountAmount += isNaN(discount) == true ? 0 : discount ;
			
		}


		totalDiscount = discountAmount;
		totalAmountDue = total - discountAmount;

		
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
	})


})

 

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

function remove_comma(str) {

	return str.replace(/,/g, '')
}