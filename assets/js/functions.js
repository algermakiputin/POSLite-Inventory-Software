 


function date_range_select(from, to) {

	var date_from = $("#" + from);
	var date_to = $( "#" + to); 

	var date1 = new Date(date_from.val());
	var date2 = new Date(date_to.val());

	if (date1 && date2) {

		if (date2 >= date1) {

			return [date1.toISOString()
                    .split("T")[0], 
                    date2.toISOString()
                    .split("T")[0]];
		}else {
			return false;
		}
	}

	return false;

};
 