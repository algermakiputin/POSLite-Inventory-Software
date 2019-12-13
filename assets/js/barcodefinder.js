 

	
 	var test;
	function barcode_finder(barcode) {
		 
		data['code'] = barcode;
		$.ajax({
			type: "POST",
			url: base_url + 'ItemController/find',
			data: data, 
			success: function() {
				alert(0)
			},
			error: function() {
				
			}
		}); 
		
	} 

	
 