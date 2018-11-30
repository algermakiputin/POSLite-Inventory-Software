$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var totalAmountDue = 0;
	var transactionComplete = false;
	var currency = '₱';
	
	var dHeight = ($(document).height());
	dHeight -= ($("#left").height() + $(".navbar").height() + 140);
	$("#cart-tbl").css('height', dHeight + 'px')

	var item_table = $("#item-table").DataTable({
			processing : true,
			serverSide : true,
			ajax : {
				url : base_url + 'items/data',
				type : 'POST'
			}
		});

	$("#item").click(function() {
		$("#modal").modal('toggle');
		item_table.clear().draw();
		
	})

	$("#item-table").on('click', 'tbody tr', function() {
		var id = $(this).find('td').eq(0).text();
		var name = $(this).find('td').eq(1).text();
		var stocks = $(this).find('td').eq(3).text();
		var price = $(this).find('td').eq(4).text();
		var description = $(this).find('td').eq(2).text();
		$("#item-id").val(id) 
		$("#item").val(name);
		$("#item-name").text(name);
		$("#price").text(price);
		$("#description").text(description);
		$("#modal").modal('toggle');

		var quantity = 1;
	 	var subtotal = parseInt(quantity) * parseFloat($("#price").text().substring(1));
	 	totalAmountDue += parseFloat(subtotal);
		$("#cart tbody").append(
				'<tr>' +
					'<td>'+ $("#item-id").val() +'</td>' +
					'<td>'+ $("#item-name").text() +'</td>' +
					'<td><input data-stocks="'+stocks+'" type="text" value="'+quantity+'" class="quantity-box"> &nbsp;* </td>' +
					'<td>'+ $("#price").text() +'</td>' +
					'<td>₱'+ subtotal +'</td>' + 
					'<td><i class="fa fa-trash remove" title="Remove Item"></i></td>' +
				'</tr>'
			);
		$("#amount-due").text("₱" + totalAmountDue);
		
	})

	$("#cart").on('click', '.fa.remove',function() {
		$(this).parents('tr').remove();
		recount();
	})

 	$("#cart").on('input', '.quantity-box', function() {

		var quantity = parseInt($(this).val());
		var currentStocks = $(this).data('stocks');

		if (isNaN(quantity)) {
			quantity = 1;
			 
		}else if (!isNaN(quantity) && quantity != 0) {
			if (quantity <= parseInt(currentStocks)) {
				var row = $(this).parents("tr");
				var priceCol = row.find('td').eq(3);
				var price = priceCol.text().substring(1);
				var subtotal = parseInt(quantity) * parseFloat(price);
				row.find('td').eq('4').text("₱" + subtotal);
				recount();
			}else {
				alert('Not enough stocks only ' + currentStocks + ' remaining.');
				$(this).val(1);
			}
		}

		
	})

	$("#cart").on("blur", ".quantity-box", function() {
		if ($(this).val() == "" || isNaN(parseInt($(this).val()))) {
			$(this).val(1);
		}
	});
	$("#cart").on('focus', '.quantity-box', function() {
	 
		$(this).val('');
	})

	$("#process").click(function() {
		var row = $("#cart tbody tr").length;
		
		if (row) {
			$("#payment").modal('toggle');
			var totalAmountDue = $("#amount-due").text().substring(1);
			$("#total-amount-due").val('₱' + totalAmountDue);
		}else {
			alert('Please add some items');
		}

	})

	$("#reset").click(function() {
		$("#cart tbody").empty();
		$("#item").val('');
		$("#item-name").text('');
		$("#description").text('');
		$("#price").text('');
		$("#amount-due").text('');
	})

	$("#amount-pay").keyup(function() {
		var payment = parseFloat($(this).val());
		var totalAmountDue = parseFloat($("#total-amount-due").val().substring(1));

		if (payment >= totalAmountDue) {
			$("#complete-transaction").prop('disabled',false);
			$("#change").val((payment - totalAmountDue).toFixed(2));
		}else {
			$("#complete-transaction").prop('disabled',true);
		}

	}); 

	function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			total += parseFloat(r.eq(4).text().substring(1));
		}

		$("#amount-due").text("₱" + total);
	}

	$("#complete-transaction").click(function() {
		var row = $("#cart tbody tr").length;
		var sales = [];
		var customer_id = $("#customer-id").val();
		var total_amount = $("#total-amount-due").val();
		var payment = $("#amount-pay").val();
		var change = $("#change").val();

		$("#loader").show();
		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');

			var arr = [
					r.eq(0).text(), 
					r.eq(2).find('input').val(),
					r.eq(3).text(),
					r.eq(4).text().substring(1),
					customer_id,
					r.eq(1).text(),
				];
			sales.push(arr);
		}
		//Receipt Items
		$("#r-items-table tbody").empty();
		$.each(sales, function(key, value) {
			$("#r-items-table tbody").append(
					'<tr>' +
						'<td>'+value[0]+'</td>' +
						'<td>'+value[5]+'</td>' +
						'<td>'+value[2]+'</td>' +
						'<td>'+value[1]+'</td>' +
						'<td>'+value[3]+'</td>' +

					'</tr>'
				);
		});

		$.ajax({
			type : 'POST',
			data : {
				sales : sales
			},
			url : base_url + 'SalesController/insert',
			success : function(data) { 
 				transactionComplete = true;
				$("#loader").hide();
				//Transaction Summary
				$("#summary-due").text(total_amount);
				$("#summary-payment").text( currency + payment);
				$("#summary-change").text( currency + change);
				//Fill In Receipt
				$("#r-due").text(total_amount);
				$("#r-payment").text( currency + payment);
				$("#r-change").text( currency + change);
				$("#r-cashier").text($("#user").text());
				$("#r-date").text(moment().format('YY/MM/DD'));
				$("#r-time").text(moment().format('h:mm:ss a'));
				$("#r-id").text(data);
				totalAmountDue = 0; 
				$("#payment .modal-dialog").addClass('modal-lg');
				$("#panel1").hide();
				$("#panel2").show();

				$("#item").val('');
				$("#item-name").text('');
				$("#description").text('');
				$("#price").text('');
			}
		})
	})

	$('#payment').on('hidden.bs.modal', function () {
	  	if (transactionComplete) {
	  		$("#cart tbody").empty();
	  		$("#panel1").show();
	  		$("#panel2").hide();
	  		$("#customer-id").val('');
			$("#total-amount-due").val('');
			$("#amount-pay").val('');
			$("#change").val('');
			$("#amount-due").text(''); 
	  		transactionComplete = false;
	  		$("#payment .modal-dialog").removeClass('modal-lg');
	  	}
	})

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

 