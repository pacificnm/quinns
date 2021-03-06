$(document).ready(function () {
	
	$('#latlon').live('keyup', throttle(function(e) {
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
			url = '/location/search/index/type/lat/keyword/' + keyword;
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.latlonAutoComplete').hide();
					if(keyword != ""){
						$(".latlonAutoComplete").show();
					} else {
						$(".latlonAutoComplete").hide();
					}
					$(".latlonAutoComplete ul").empty();
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".latlonAutoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('latlon').value = '" + data[index].keyword + " " +  data[index].street+ "'; document.getElementById('locationId').value='"+ data[index].id+"';\">"+ BoldSearchTerm(data[index].keyword, data[index].keyword) + " " +BoldSearchTerm(data[index].street, data[index].street)+ " " + BoldSearchTerm(data[index].city, data[index].city) +"</li>");
						});
					} else {
						$(".latlonAutoComplete ul").append("<li class=\"name\">Search word '"+data+"' - did not match any movies. </li>");
					}
					
				}
			});
		}
		
		return false;
	}));
	


	$(document).click(function(){
		$(".latlonAutoComplete").hide();
	});
	
	
	
});