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
		var price = $(this).find('td').eq(4).text();
		var description = $(this).find('td').eq(2).text();
		$("#item-id").val(id) 
		$("#item").val(name);
		$("#item-name").text(name);
		$("#price").text(price);
		$("#description").text(description);
		$("#modal").modal('toggle');
	})

	$("#add-cart").click(function() {

		if ($("#quantity").val !== "" && $("#price").text() !== ""){
			var quantity = $("#quantity").val();
		 	var subtotal = parseInt(quantity) * parseInt($("#price").text().substring(1));
		 	totalAmountDue += subtotal;
			$("#cart tbody").append(
					'<tr>' +
						'<td>'+ $("#item-id").val() +'</td>' +
						'<td>'+ $("#item-name").text() +'</td>' +
						'<td>'+ quantity +'</td>' +
						'<td>'+ $("#price").text() +'</td>' +
						'<td>₱'+ subtotal +'</td>' + 
					'</tr>'
				);

			$("#amount-due").text("₱" + totalAmountDue);

			$("#item-id").val('') 
			$("#item").val('');
			$("#item-name").text('');
			$("#price").text('');
			$("#quantity").val('');
			$("#description").text(''); 
		}else {
			alert('Please select an item and enter quantity before adding to cart');
		}
		

	})

	$("#process").click(function() {
		var row = $("#cart tbody tr").length;
		
		if (row) {
			$("#payment").modal('toggle');
			var totalAmountDue = $("#amount-due").text().substring(1);
			$("#total-amount-due").val('₱' + totalAmountDue);
		}

	})

	$("#amount-pay").keyup(function() {
		var payment = parseInt($(this).val());
		var totalAmountDue = parseInt($("#total-amount-due").val().substring(1));

		if (payment >= totalAmountDue) {
			$("#complete-transaction").prop('disabled',false);
			$("#change").val(payment - totalAmountDue);
		}else {
			$("#complete-transaction").prop('disabled',true);
		}

	}); 



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
					r.eq(2).text(),
					r.eq(3).text().substring(1),
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

 