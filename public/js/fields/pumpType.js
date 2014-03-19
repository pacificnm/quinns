$(document).ready(function () {
	
	$('#pump_type').live('keyup', throttle(function(e) {
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, left: 37, right: 39, esc: 27, enter: 13};
		
		if(keyCode == arrow.up || keyCode == arrow.down || keyCode == arrow.esc
			|| keyCode == arrow.left || keyCode == arrow.right){
			return false;
		}
		
		if(keyCode != arrow.enter){
			var keyword = $.trim($(this).val());
			
			if(keyword != ""){ $('.pumpTypeAjaxLoader').show(); }
			
			var form_data = {
				search: keyword
			};
			url = '/pump-type/search';
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.pumpTypeAjaxLoader').hide();
					if(keyword != ""){
						$(".pumpTypeAutoComplete").show();
					} else {
						$(".pumpTypeAutoComplete").hide();
					}
					$(".pumpTypeAutoComplete ul").empty();
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".pumpTypeAutoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('pump_type').value = '" + data[index].value+ "';\">"+BoldSearchTerm(data[index].value, data[index].value)+"</li>");
						});
					} else {
						$(".pumpTypeAutoComplete ul").append("<li class=\"name\">Search word '"+data+"' - did not match any movies. </li>");
					}
					
				}
			});
		}
		
		return false;
	}));
	


	$(document).click(function(){
		$(".pumpTypeAutoComplete").hide();
	});
	
	
	
});