jQuery("[data-toggle='date-picker']").datepicker({});

jQuery("[data-toggle='time-picker']").timepicker();

//$("#time").timepicker();

jQuery(function() {
	$("[data-toggle='tooltip']").tooltip();
});
jQuery(function() {
	$("[data-toggle='popover']").popover();
});

jQuery(document).ready(function() {
	
	var defaults = {
			containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear' 
		};
	$().UItoTop({ easingType: 'easeOutQuart' });
	
});


