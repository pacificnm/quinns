$(document).ready(function () {
	

	$('#keywords').live('keyup', throttle(function(e) {
		
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, left: 37, right: 39, esc: 27, enter: 13};
		
		if(keyCode == arrow.up || keyCode == arrow.down || keyCode == arrow.esc
			|| keyCode == arrow.left || keyCode == arrow.right){
			return false;
		}
		
		if(keyCode != arrow.enter){
			var keyword = $.trim($(this).val());
			
			if(keyword != ""){ $('.ajax-loader').show(); }
			
			var form_data = {
				search: keyword
			};
			url = '/location/' + "search";
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					
					$('.ajax-loader').hide();
					if(keyword != ""){
						$(".autoComplete").show();
					} else {
						$(".autoComplete").hide();
					}
					$(".autoComplete ul").empty();
					
					
					if(data['noResult'] == null){
						$(data).each(function(index) {
							$(".autoComplete ul").append("<li class=\"name\" style=\" cursor:pointer\" onclick=\" document.getElementById('keywords').value = '" + data[index].keyword+ "'; document.getElementById('locationId').value='"+ data[index].id+"';\">"+BoldSearchTerm(data[index].keyword, data[index].keyword)+"</li>");
						});
						
					} else {
						
						$(".autoComplete ul").append("<li class=\"name\">Add New </li>");
						
					}
					
					
					
					
				}
			});
		}
		
		return false;
	}));
	
	$(document).keydown(function(e){
		
		var keyCode = e.keyCode || e.which,
		arrow = {up: 38, down: 40, esc: 27, enter: 13};
		
		if($('.autoComplete').is(":visible") && !$('.autoComplete li').hasClass('noMatch')){
			
			var element = $('.autoComplete');
			var hasSelected = $('.autoComplete ul li').hasClass('selected');
			var isFirst = $('.autoComplete ul li').first().hasClass('selected');
			var isLast = $('.autoComplete ul li').last().hasClass('selected');
			
			if(hasSelected && keyCode == arrow.enter){
				e.preventDefault();
			}
			
			switch (keyCode) {
				case arrow.up:
					if(hasSelected){
						if(isFirst){
							$('li.selected', element).removeClass('selected');
							$('ul li', element).last().addClass('selected');
							break;
						}
						$('li.selected', element).prev().addClass('selected');
						$('li.selected', element).next().removeClass('selected');
					} else {
						$('ul li', element).last().addClass('selected');
					}
				
				break;
				case arrow.down:
					if(hasSelected){
						if(isLast){
							$('li.selected', element).removeClass('selected');
							$('ul li', element).first().addClass('selected');
							break;
						}	
						$('li.selected', element).next().addClass('selected');
						$('li.selected', element).prev().removeClass('selected');
					} else {
						$('ul li', element).first().addClass('selected');
					}
				
				break;
				case arrow.enter:
					window.location.href = $('li.selected a', element).attr('href');
					$('.autoComplete').hide();
				break;
			}
		}
		
		if(keyCode == arrow.esc){
			$('.autoComplete').hide();
		}
	});
	
	$(document).click(function(){
		$(".autoComplete").hide();
	});
	
	$('#parentCommentID').val('');
	
	$('.comment .reply').click(function(){
		
		$('#parentCommentID').val($(this).attr('href'));
		$('.commentLabel').text('Your Reply to '+ $(this).attr('data-name'));
		$("html,body").animate({ scrollTop: $("#respond").offset().top }, "slow");
		return false;
	});
	
	$('.delete').live('click', function(){
		var confirm = window.confirm("Are you sure you want to delete this Comment?");
		
		if(confirm){
			return true;
		}
		
		return false;
	});
	
	$('.requestForm').submit(function(){

		var request = $.trim($('#request').val());
		if(request != $('#request').attr('placeholder') && request != ''){
			requestMsg('', 'error', false);
			$('.ajax-loader').show();
		} else {
			requestMsg('Please enter either a Movie name or IMDB Code.', 'error', true);
			return false;
		}
		
		var form_data = {
			request: request
		};
		url = webRoot + "request/check";
		
		$.ajax({
			type: 'post',
			url: url,
			cache: false,
			queue: true,
			dataType: 'json',
			data: form_data, 
			success: function(data) {
				if(data.requestsLeft <= 0){
					$('.requestForm').fadeOut(500).remove();
					$('.SearchPanel').append('<div class="requestClosed '+data.status+'" style="display: none;">'+data.message+'</div>');
					$('.SearchPanel .requestClosed').fadeIn(500);
				} else {
					$('.requestForm #request').val('');
					requestMsg(data.message, data.status, true);
				}
				if(data.status == 'success'){
					$('.countLeft .requestCount').text( parseInt($('.countLeft .requestCount').text(), 10) - 1);
				}
				
				$('.ajax-loader').hide();
			}
		});
		
		return false;
	});
	
	var alreadyVoted = false;
	$('.voteBtn').click(function(){
			
		var vote = $(this).attr('data-requestID')
		var form_data = {
			vote: vote
		};
		url = webRoot + "request/vote";
		
		if(!alreadyVoted){
			alreadyVoted = true;
			
			$.ajax({
				type: 'post',
				url: url,
				cache: false,
				queue: true,
				dataType: 'json',
				data: form_data, 
				success: function(data) {
					$('.request'+data.status+' .accepted-request').append('<div class="voted hide">Voted</div>');	
					$('.request'+data.status+' .voteBtn').fadeOut(function(){
						$('.request'+data.status+' .voted').show().animate({ right: -63 }).delay(500).animate({ right: 0 }, function(){
							if(data.votesLeft <= 0){
								$('.voteBtn').fadeOut(function(){
									$(this).remove();
								});
							} else {
								$('.request'+data.status+' .voteBtn').fadeIn(500);
								alreadyVoted = false;
							}
						});
					});
					$('.request'+data.status+' .votes').text( parseInt($('.request'+data.status+' .votes').text(), 10) + 1);
					$('.countLeft .voteCount').text( parseInt($('.countLeft .voteCount').text(), 10) - 1);
				}
			});
		}
		return false;
	});

	$('.accepted-request a.view').click(function(){
		$(this).animate({ bottom: 0 });
		$(this).parents('.request-wrapper').find('.extraImdbInfo').slideDown(600);
		
		return false;
	});
	
	$('.extraImdbInfo a.close').click(function(){
		$(this).parent().slideUp(600, function(){
			$(this).parents('.request-wrapper').find('a.view').animate({ bottom: -21 });
		});
		
		return false;
	});
	
	if(!$.support.placeholder){
		$.each($("[placeholder]"), function() { 
			var input = $(this);
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		});
		
		$("[placeholder]").focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();
	}
	
	$('.load-more-comments').live('click', function(){
		$('.ajax-loader').show();
		$(this).html('Loading...<span></span>')
		
		$movieID = $(this).attr('data-movieID');
		$offset = $(this).attr('data-offset');
		$max = $(this).attr('data-max');
		$("<div>").load(webRoot+'loadcomments/'+$offset+'/'+$movieID, function() {
			$(".comment-list-wrapper").append($(this).html());
			$('.load-more-comments').attr('data-offset', parseInt($offset)+50);
			
			$('.ajax-loader').hide();
			$('.load-more-comments').html('See More Comments<span></span>')
			$('.more-count span').html($('.comment').size());
			
			if($('.comment').size() == $max){
				$('.load-more-comments').remove();
			}
		});
	});

});

	function throttle(f, delay){
		var timer = null;
		return function(){
			var context = this, args = arguments;
			clearTimeout(timer);
			timer = window.setTimeout(function(){
				f.apply(context, args);
			},
			delay || 300);
		};
	}

	function BoldSearchTerm(searchTerm, token){
		token = token.replace('(','\\(').replace(')','\\)');
		return searchTerm.replace( new RegExp('('+token+')', 'i' ), "<strong>$1</strong>" );
	}
	
	function underscore(title){
		title = $.trim(title);
		return title.replace(/ /g,"_");
	}
	
	function requestMsg(text, type, show){
		var r = $('.request .SearchPanel');
		r.stop();
		if(show){
			r.animate({ height: 70 }, 500, function(){
				$('.msgstatus').addClass(type).html(text).fadeIn(300);
			});
		} else {
			$('.msgstatus').fadeOut(300,function(){
				$(this).removeClass('error').removeClass('success')
				r.animate({ height: 55 }, 500);
			});
		}
	}
	
	$.support.placeholder = (function(){
		var i = document.createElement('input');
		return 'placeholder' in i;
	})();