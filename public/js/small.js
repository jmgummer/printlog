//$.fn.select2.defaults.set("theme", "bootstrap");
$('#start_date').datepicker({
     keyboardNavigation: false,
    todayHighlight: true,
    forceParse: false,
    autoclose: true,
    format: 'yyyy-mm-dd',
});

$('#end_date').datepicker({
    keyboardNavigation: false,
    todayHighlight: true,
    forceParse: false,
    autoclose: true,
    format: 'yyyy-mm-dd',
    todayHighlight: true
});

$(function() {
	$('#show-hidden-menu').click(function() {
		 $('.hidden-menu').slideToggle("slow");
		 // Alternative animation for example
		 // slideToggle("fast");
	});
})

$('#print_form').on('click','#get_log',function(){
	var data = $('#print_form').serialize();
	var start = $('#start_date').val();
	var end = $('#end_date').val();
	var end = $('#end_date').val();
	var adtype = $('.adtype').is(":checked");
	var print = $('.print').is(":checked");

	if (start == "") {
		Swal.fire({
			title: 'Start Date Error!!!!',
  			text:'Please Set Start Date!!!',
  			type:'error'
		
		});
	}else if (end == ""){
		Swal.fire({
  		title: 'End Date Error!!!!',
  		text: 'Please Set End Date',
  		type: 'error',
  		confirmButtonText: 'Exit'
})
	} else if(adtype == false){
		Swal.fire({
  		title: 'Ad Type Error!!!!',
  		text: 'Please Select Ad type',
  		type: 'error',
  		confirmButtonText: 'Exit'
		})
	}else if (print == false){
		Swal.fire({
  		title: 'Publication Error!!!!',
  		text: 'Please Select Publication',
  		type: 'error',
  		confirmButtonText: 'Exit'
		})
	} else {
		$.ajax({
			url:'action.php',
			type:"POST",
			data:data,
			success:function(responses){
				$("#station_log_listing").fadeOut(500).hide(function(){                
                    $("#station_log_listing").fadeIn(500).html(responses);
                });
                $("#clipLegend").show();
			}
		})
	}

	return false;
})