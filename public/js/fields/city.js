$(document).ready(function () {
	
	$('#city').live('keyup', throttle(function(e) {
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, left: 37, right: 39, esc: 27, enter: 13};
		
		if(keyCode == arrow.up || keyCode == arrow.down || keyCode == arrow.esc
			|| keyCode == arrow.left || keyCode == arrow.right){
			return false;
		}
		
		if(keyCode != arrow.enter){
			var keyword = $.trim($(this).val());
			
			if(keyword != ""){ $('.cityAjaxLoader').show(); }
			
			var form_data = {
				search: keyword
			};
			url = '/city/search';
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.cityAjaxLoader').hide();
					if(keyword != ""){
						$(".cityAutoComplete").show();
					} else {
						$(".cityAutoComplete").hide();
					}
					$(".cityAutoComplete ul").empty();
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".cityAutoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('city').value = '" + data[index].value+ "';\">"+BoldSearchTerm(data[index].value, data[index].value)+"</li>");
						});
					} else {
						$(".cityAutoComplete ul").append("<li class=\"name\">Search word '"+data+"' - did not match any movies. </li>");
					}
					
				}
			});
		}
		
		return false;
	}));
	


	$(document).click(function(){
		$(".cityAutoComplete").hide();
	});
	
	
	
});