$(document).ready(function () {
	
	$('#tank_model').live('keyup', throttle(function(e) {
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, left: 37, right: 39, esc: 27, enter: 13};
		
		if(keyCode == arrow.up || keyCode == arrow.down || keyCode == arrow.esc
			|| keyCode == arrow.left || keyCode == arrow.right){
			return false;
		}
		
		if(keyCode != arrow.enter){
			var keyword = $.trim($(this).val());
			
			if(keyword != ""){ $('.tankModelAjaxLoader').show(); }
			
			var form_data = {
				search: keyword
			};
			url = '/tank-model/search';
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.tankModelAjaxLoader').hide();
					if(keyword != ""){
						$(".tankModelAutoComplete").show();
					} else {
						$(".tankModelAutoComplete").hide();
					}
					$(".tankModelAutoComplete ul").empty();
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".tankModelAutoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('tank_model').value = '" + data[index].value+ "';\">"+BoldSearchTerm(data[index].value, data[index].value)+"</li>");
						});
					} else {
						$(".tankModelAutoComplete ul").append("<li class=\"name\">Search word '"+data+"' - did not match any movies. </li>");
					}
					
				}
			});
		}
		
		return false;
	}));
	


	$(document).click(function(){
		$(".tankModelAutoComplete").hide();
	});
	
	
	
});