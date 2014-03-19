$(document).ready(function () {
	
	$('#address').live('keyup', throttle(function(e) {
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, left: 37, right: 39, esc: 27, enter: 13};
		
		if(keyCode == arrow.up || keyCode == arrow.down || keyCode == arrow.esc
			|| keyCode == arrow.left || keyCode == arrow.right){
			return false;
		}
		
		if(keyCode != arrow.enter){
			var keyword = $.trim($(this).val());
			
			
			
			var form_data = {
				search: keyword
			};
			url = '/location/search/index/type/address/keyword/' + keyword;
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.addressAutoComplete').hide();
					if(keyword != ""){
						$(".addressAutoComplete").show();
					} else {
						$(".addressAutoComplete").hide();
					}
					$(".addressAutoComplete ul").empty();
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".addressAutoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('address').value = '" + data[index].street+ " " +data[index].city +"'; document.getElementById('locationId').value='"+ data[index].id+"';\">"+BoldSearchTerm(data[index].street, data[index].street)+" " + BoldSearchTerm(data[index].city, data[index].city) + "</li>");
						});
					} else {
						$(".addressAutoComplete ul").append("<li class=\"name\">We did not find the address you searched for. Click Search and you will be taken to the Add Location Page.</li>");
					}
					
				}
			});
		}
		
		return false;
	}));
	


	$(document).click(function(){
		$(".addressAutoComplete").hide();
	});
	
	
	
});