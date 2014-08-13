var Global = (function(){
	if($('#vk_like').length != 0) {
		VK.Widgets.Like("vk_like", {type: "mini"});
	}
})();

var Popup = (function(){

	allow = true;
	opened = false;
	var show = function(popup) {
		if(!allow) return;
		$('.overlay').addClass('active').css('z-index', 99);
		$('.pop-window[data-popup=' + popup + ']').removeClass('closed');
		$('html').css('overflow', 'hidden');
		opened = popup;
	}

	var close = function(popup) {
		allow = false;
		$('.overlay').removeClass('active');
		$('html').removeAttr('style');
		setTimeout(function(){
			$('.overlay').css('z-index', -1);
			$('.pop-window[data-popup=' + popup + ']').addClass('closed');
			allow = true;
			opened = false;
		}, 500);
	}

	$(document).on('click', '.js-pop-close', function(){
		if(opened) {
			close(opened);
		}
		return false;
	});

	$(document).on('click', '.js-pop-show', function(){
		if(!opened) {
			show($(this).attr('data-popup'));
		}
		return false;
	});

	$(document).on('click', '.overlay', function(){
		if(opened) {
			close(opened);
		}
	});

	$(document).on('click', '.pop-window', function(e){
		e.preventDefault();
		e.stopPropagation();
	});

	if(window.location.hash != '') {
		show(window.location.hash.substr(1));
	}

	return { show: show, close: close };
})();

var Slide = (function(){

	//ALL DIRECTIONS OF THE UNIVERSITY
	$(document).on('click', '.js-alldirs', function(e){
		if($(e.target).is('a') && !$(e.target).hasClass('js-open-allow')) return;
		var block_data = $(this).attr('data-block'),
			active_data = $(this).attr('data-active'),
			block = $('.' + block_data),
			active = $(this).parents('.' + active_data);

		if(block.is(':visible')) {
			block.hide();
			active.removeClass('active');
		} else {
			block.show();
			active.addClass('active');
		}
		return false;
	});
})();

var form_slide = (function($){

	$.fn.FormSlide = function() {
		var input = $(this),
			str = 	'<div class="grade-line">'+
                        '<div class="grade-fill"></div>'+
                    '</div>'+
                    '<div class="grade-dot"></div>';

		input.attr('type', 'hidden');
		input.wrap('<div class="grade-panel" />').before(str);

		var posx = 0,
			move = false,
			fill = false,
			line = false,
			input = false,
			css_pos = 0,
			perc = 0,
			p_value = 0,
			max_value = 10;

		function setVal(n_posx, perc) {
			move.css('left', n_posx);
			fill.css('width', n_posx);
			input.val(perc);
		}

		$(document).on('mousedown', '.grade-dot', function(e){
			posx = e.pageX;
			move = $(this);
			fill = move.parent().find('.grade-fill');
			line = move.parent().find('.grade-line');
			input = move.parent().find('input');
			css_pos = parseInt(move.css('left'));
			perc = line.width() / max_value;
		});

		$(document).on('mousemove', function(e){
			if(move) {
				var n_posx = css_pos + e.pageX - posx;

				if(n_posx <= 0) {
					setVal(0, 0);
					return;
				} else if(n_posx >= move.parent().width()) {
					setVal(move.parent().width(), max_value);
					return;
				}
				p_value = Math.round(n_posx / perc);
				setVal(n_posx, p_value);
			}
		});

		$(document).on('mouseup', function(e){
			move = false;
		});
	}
})(jQuery);

$('.FormSlide').FormSlide();

var UserToolTip = (function(){
	var tooltip = 	'<div class="user-cart">'
							+'<div class="user-photo" style="background-image: url(http://static.general-play.com/thumbs/2e9/40/gp2090e0h1f5i0.jpeg);"></div>'
							+'<div class="user-name">Тимур Юнусов</div>'
							+'<div class="user-desc">'
								+'Студент СПбГУ.<br>'
								+'На сайте с 2012 года.'
							+'</div>'
							+'<div>'
								+'<a href="#" class="us-btn">Написать сообщение</a>'
							+'</div>'
						+'</div>';

	var timeout;

	var init = function() {
		$('body').append(tooltip);
		/*tooltips.forEach(function(value){
			console.log(value);
			$('body').append(value);
		});*/
	}

	var show = function(block) {
		clearTimeout(timeout);

		var x = block.offset().left;
		var y = block.offset().top;
		var height = $('.user-cart').height() + block.height()*3;
		var width = block.width()/2 - $('.user-cart').outerWidth()/2;

		$('.user-cart').show();
		$('.user-cart').css({
			top: y - height,
			left: x + width
		});
	}

	var close = function() {
		out_allow = true;
		timeout = setTimeout(function(){
			if(out_allow) {
				$('.user-cart').hide();
			}
		}, 1000);
	}

	$(document).on('mouseover', '.js-user-tooltip', function(){
		show($(this));
	});

	$(document).on('mouseover', '.user-cart', function(){
		clearTimeout(timeout);
	});

	$(document).on('mouseout', '.js-user-tooltip, .user-cart', function(){
		close();
	});

	init();
})();

var tabs = (function(){
	var init = function(){
		$('.js-tab-parent').each(function(){
			if($(this).find('.js-tab.active').length == 0) {
				$(this).find('.js-tab').first().addClass('active');
			}

			var link = $(this).find('.js-tab.active');
			var block = link.attr('data-block');
			$(this).find('.js-tab-window[data-block="' + block + '"]').show().addClass('active');
		});
	}

	$(document).on('click', '.js-tab', function(){
		var block = $(this).attr('data-block');
		var parent = $(this).parents('.js-tab-parent');
		parent.find('.js-tab').removeClass('active');
		$(this).addClass('active');
		parent.find('.js-tab-window.active').hide().removeClass('active');
		parent.find('.js-tab-window[data-block="' + block + '"]').show().addClass('active');
		return false;
	});

	init();
})();

var Like = (function(){

	var interval;

	var init = function(){
		var str = 	'<div class="js-like-window">'
			            +'<span></span> человек почситали этот отзыв отзыв полезным'
			        +'</div>';
		$('body').append(str);
	}

	var show = function(link){
		clearTimeout(interval);
		var block = link.find('.fa');
		var y = block.offset().top;
		var x = block.offset().left;

		var height = $('.js-like-window').height() + block.height()*2;
		var width = block.width()/2 - $('.js-like-window').outerWidth()/2;

		$('.js-like-window span').text(link.attr('data-likes'));
		$('.js-like-window').show();
		$('.js-like-window').css({
			top: y - height,
			left: x + width
		});
	}

	var close = function(){
		interval = setTimeout(function(){
			$('.js-like-window').hide();
		}, 1000);
	}

	$(document).on('mouseover', '.js-like', function(){
		show($(this));
	});

	$(document).on('mouseout', '.js-like', function(){
		close();
	});

	init();

})();

var jsLabel = (function(){
	$(document).on('click', '.dblock-check', function(e){
		if(!$(e.target).is('input')){
			var input = $(this).find('input');
			input.prop("checked", !input.prop("checked"));	
		}
	});

	$(document).on('click', '.check-parent .fa', function(){
		return false;
	});

	$(document).on('click', '.check-main, .check-item', function(e){
		if(!$(e.target).is('input')){
			var inputs = $(this).find('input');
			inputs.prop("checked", !inputs.prop("checked")).change();	
		}
	});

	$(document).on('change', '.check-item input', function(e){
		var parent = $(this).parents('.check-parent').find('.check-main input');
		var totrue = true;
		$($(this).parents('.checks-in').find('input')).each(function(){
			if(!$(this).prop('checked')) {
				totrue = false;
				return false;
			}
		});

		parent.prop('checked', totrue);

	});

	$(document).on('click', '.check-main .fa', function(e){
		$(this).parents('.check-parent').toggleClass('active');
        $('.checks-block').customScrollbar("resize", true);
    });

	$(document).on('change', '.check-main input', function(){
		var inputs = $(this).parent().parent().find('.checks-in input');
		inputs.prop('checked', $(this).prop('checked'));
	});

})();

var StudLife = (function(){
	if($('.studl-nav').length != 0) {
		$('.studl-info').css('min-height', $('.studl-nav').height() + 20);
	}
})();

var SiteFeedb = (function(){
	$(document).on('mouseover', '.rating-num', function(){
		var i = $(this).index() + 1;
		var j = 0;
		for(j; j < i; j++) {
			$('.rating-num').eq(j).addClass('active');
		}
	});

	$(document).on('mouseout', '.rating-num', function(){
		$('.rating-num').removeClass('active');
	});

	$(document).on('click', '.rating-num', function(){
		$('.rating-num').removeClass('clicked');
		var i = $(this).index() + 1;
		var j = 0;
		for(j; j < i; j++) {
			$('.rating-num').eq(j).addClass('clicked');
		}
		$('.rating-input').val(i);
	});

	$(document).on('click', '.quest-type', function(){
		$(this).addClass('active').siblings().removeClass('active');
		$('.subject-input').val($(this).attr('data-value'));
	});
})();

/********/
/* TEMP */
/********/

if($('.main-select').length) {
	$(".main-select").select2();
}

/*
$('.media-item').on('click', function(){
	Popup.show('photos');
	return false;
});
*/