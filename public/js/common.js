$(document).ready(function () {
	
	
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