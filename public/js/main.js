var search = (function(){
	var open = false,
		allow = true,
		search_block = $('.header-search'),
        search_anim = $('.search-anim'),
		nav_block = $('.main-nav');

	function search_open() {
		open = true;
		nav_block.addClass('closed');
        search_anim.css({
            'width': '800px',
            'opacity': 1
        }).addClass('active');
        search_block.find('input').trigger('focus');
		setTimeout(function(){
			nav_block.hide();
			allow = true;
		}, 500);
	}

	function search_close() {
        allow = false;
		open = false;
		nav_block.show();
		search_anim.removeClass('active').removeAttr('style');
        setTimeout(function(){
            nav_block.removeClass('closed');
        }, 250);
		setTimeout(function(){
			allow = true;
		}, 750);
	}

	$(document).on('click', '.search-icon', function(){
		if(!allow) return;
		allow = false;
		if(open) {
			allow = true;
			if(search_block.find('input').val() == '') {
				return false;
			}
		} else {
			search_open();
			return false;
		}
	});

	$(document).on('click', '.menu-icon', function(){
		if(!allow) return;
		search_close();
	});
})();

var file_input = (function(){
	$(document).on('change', '.apply-file', function(){
		var str = $(this).val().split("\\");
		var name = str[str.length - 1];
		$(this).parent().find('.file-btn .us-link').text(name);
	});
})();

$(document).on('click', '.file-btn', function(){
    $(this).parent().find('.apply-file').trigger('click');
    return false;
});

var fonds = (function(){
	function setNumbers() {
		var element = $('.fonds-list tbody tr');
		var i = 1;
		element.each(function(){
			$(this).find('td').first().attr('data-number', i);
			i++;
		});
	}

	return { setNumbers: setNumbers };
})();

var crosses = (function(){
	var fond_bytes = 0;

	$(document).on('input', '.search-body input', function(){
		var	parent = $(this).parents('.search-body'),
			cross = parent.find('.input-cross'),
			inputs = parent.find('input'),
			length = inputs.length,
			i = 0;

		inputs.each(function(){
			if($(this).val() != '') {
				i++;
			}
		});

		if(i > 0) {
			cross.addClass('active');
		} else {
			cross.removeClass('active');
		}
	});
	$(document).on('click', '.search-body .input-cross', function(){
		var parent = $(this).parents('.search-body');
		parent.find('input').val('');
		parent.find('.input-cross').removeClass('active');
		return false;
	});
	$(document).on('input', '.fond-input', function(){
		var form = $(this).parents('form');
		if($(this).val().length > 2) {
			form.trigger('submit');
		}
		fond_bytes = $(this).val().length;
	});
	$(document).on('input', '.slider-input', function(){
		var form = $(this).parents('form');
		if($(this).val().length == 4) {
			form.trigger('submit');
            $( "#slider-range" ).slider( "option", "values", [ $("#slider-from").val(), $("#slider-to").val() ] );
		}
	});
    $(document).on('fonds::change', function(){
        $('#fundsForm').trigger('submit');
    });
})();

var page_nav = (function(){
	var line_time = false;

	$(window).on('hashchange', function(){
		show();
	});

	$(document).on('mouseover', '.page-nav a', function(){
		clearTimeout(line_time);
		setLine($(this).parent());
	});

	$(document).on('mouseout', '.page-nav a', function(){
		line_time = setTimeout(function(){
			setLine();
		}, 1000);
	});

	function setLine(element) {
		if(!element) {
			element = $('.page-nav li.active');
		}
		var left = element.position().left;
		var width = element.find('a').width();
		$('.nav-line').css({
			'width': width,
			'left': left
		});
	}

	function show() {
		if(window.location.hash == '') {
			$('.js-tabs li').first().addClass('active');
			$('.page-nav li').first().addClass('active');
		} else {
			var data = window.location.hash.substr(1);
			$('.page-nav li').removeClass('active');
			$('.js-tabs li').removeClass('active');
			$('.page-nav a[href="#' + data + '"]').parent().addClass('active');
			$('.js-tabs li[data-tab="' + data + '"]').addClass('active');
		}
		setLine(false);
	}

	function init() {
		show();
		setTimeout(function(){
			$('.nav-line').addClass('transition');
		}, 100);
	}
	
	return {init : init};

})();

var show_map = (function(){
    $(document).on('click', '.js-show-map', function(){
        $('.map-cont').addClass('active');
        $(this).addClass('closed');
        $('html, body').animate({
            scrollTop: $('.map-cont').offset().top + $('#contact-map').height()/2 - $(window).height()/2
        });
        return false;
    });
})();

/*$.fn.slider = function() {
    var slider = $(this),
        bar = slider.find('.js-slider-in'),
        line_width = $(this).find('.js-slider-bar').width(),
        drag_allow = false,
        drag_line = false,
        original_left = 0,
        original_width = 0,
        original_x = 0,
        min = $(this).data('min'),
        date = new Date(),
        max = date.getFullYear();


    $(document).on('mousedown', '.js-slider-in span', function(e){
        drag_allow = true;
        original_x = e.pageX;
        original_left = parseInt(bar.css('left'));
        original_right = parseInt(bar.css('right'));
        drag_line = $(this);
    });
    $(document).on('mouseup', function(){
        drag_allow = false;
    });
    $(document).on('mousemove', function(e){
        if(drag_allow) {
            var x = e.pageX - original_x;
            var new_left = original_left + x;
            var right = original_right;

            if(drag_line.index() == 0) {
                if( new_left <= 0 || new_left <= right ) return;

                bar.css({
                    'left': new_left+'%'
                });
            }
        }
    });

    function setMin(year) {
        if(year >= min && year <= max) {
            var perc = line_width / 100;
            var year_perc = (max - min) / 100;
            var none_year = year - min;

            var new_perc = none_year / year_perc;
        }
    }

    function setMax(year) {
        if(year >= min && year <= max) {
            var perc = line_width / 100;
            var year_perc = (max - min) / 100;
            var none_year = year - min;

            var new_perc = none_year / year_perc;
        }
    }

    setMin(1993);
    setMax(2000);
}

$('.js-slider').slider();*/

/***************************************************************/

// validate signup form on keyup and submit
$("#sendRequestForm").validate({
    rules: {
        //fio: "required",
        name: {
            required: true,
            minlength: 4
        },
        //email: {
        //    required: true,
        //    email: true
        //},
        type: {
            required: true,
            min: 1
        },
        content: {
            required: true,
            minlength: 10
        },
        file_passport: "required",
        file_workbook: "required"
    },
    messages: {
        name: '',
        email: '',
        type: '',
        content: '',
        file_passport: 'Загрузите копию паспорта',
        file_workbook: 'Загрузите копию трудовой книжки'
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //console.log(form);
        sendRequestForm(form);
        return false;
    }
});

function sendRequestForm(form) {

    //console.log(form);

    var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

    options.beforeSubmit = function(formData, jqForm, options){
        $(form).find('button').addClass('loading');
    }

    options.success = function(response, status, xhr, jqForm){
        console.log(response);
        if (typeof response.password != 'undefined' && typeof response.login != 'undefined') {
            $('.success').append('<p>При отправке запроса Вы не указали адрес e-mail, поэтому нам некуда отправлять пароль. Пожалуйста, запишите его и храните в надежном месте. Для авторизации используйте следующие данные:</p><p>Ваш логин: <strong>' + response.login + '</strong></p><p>Ваш пароль: <strong>' + response.password + '</strong></p>');
        }
        $('.success').hide().removeClass('hidden').slideDown();
        $(form).slideUp();
    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(xhr);
    }

    options.complete = function(data, textStatus, jqXHR){
        $(form).find('button').removeClass('loading');
    }

    $(form).ajaxSubmit(options);
}

/*
$.validator.addMethod("atleastone",
    function(value, element, params) {
        //console.log($.validator);
        var valid = false;
        $(params.selector).each(function(key, val){
            //console.log(val);
            //console.log($(val).val());
            if ($(val).val())
                if (
                    !params.minlength
                    ||( params.minlength > 0 && $(val).val().length >= params.minlength )
                    ) {
                    valid = true;
                    return;
                }
        });
        //alert(valid);
        $(params.selector).each(function(key, val){
            if (valid)
                $(val).removeClass(params.errorClass);
            else
                $(val).addClass(params.errorClass);
        });
        //return false;
        return valid;
    },
    "Fill in at least one field"
);
*/

$("#fundsForm").validate({
    rules: {
        //name: "required",
        filter: {
            require_from_group: [1, ".atleastone"],
            minlength: 3
        },
        start: {
            require_from_group: [1, ".atleastone"],
            digits: true,
            min: 1900,
            max: new Date().getFullYear()
        },
        stop: {
            require_from_group: [1, ".atleastone"],
            digits: true,
            min: 1900,
            max: new Date().getFullYear()
        }
    },
    messages: {
        filter: '',
        start: '',
        stop: ''
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //console.log(form);
        fundsFormSubmit(form);
        return false;
    }
});

function fundsFormSubmit(form) {

    //console.log(form);

    var options = {
        target: null,
        type: $(form).attr('method'),
        dataType: 'json'
    };

    var this_timeout = false;

    options.beforeSubmit = function(formData, jqForm, options){
        //$(form).find('button').addClass('loading');
        $('.fonds-list').css({
                'min-height': parseInt($('.fonds-list').height()),
                'opacity': 0
            });
        this_timeout = setTimeout(function(){
        	$('.ajaxload').removeClass('hidden');
        }, 1000);
    }

    options.success = function(response, status, xhr, jqForm){
        //console.log(response);
        //$('.success').hide().removeClass('hidden').slideDown();
        //$(form).slideUp();

        //console.log( jQuery.parseJSON(response.funds) );
        //return;
        clearTimeout(this_timeout);
        var funds = jQuery.parseJSON(response.funds);
        if (typeof(response.funds) != 'undefined' && funds.length) {
            var new_str = '';
            var data_array = [];
            var i = 0;
            $(funds).each(function(key, val){
                //console.log(val);
                var date_start = new Date(val.date_start);
                var date_stop = new Date(val.date_stop);
                var old_names = '';
                if (val.olds.length) {
                    var parent_val_id = val.id;
                    old_names += '<section class="trows">';
                    //old_names += '<span class="oldnames">';
                    $(val.olds).each(function(key, val){
                        var date_start = new Date(val.date_start);
                        var date_stop = new Date(val.date_stop);
                        old_names += '<p class="trow-old hidden" data-parent="' + parent_val_id + '"><span>&nbsp;</span><span>' + val.name + '</span><span>' + date_start.getFullYear() + '-' + date_stop.getFullYear() + '</span></p>';
                    });
                    old_names += '</section>';
                    val.olds.length;
                    //old_names += '</span>';
                    //alert(old_names);
                }
                var this_str = '<div class="trow"><span>'
                    + val.fund_number
                    + '</span><span>' + val.name
                    + (old_names ? '<br/>и его <a href="#" data-childs-for="' + val.id + '" class="old-link">предшественники</a>' : '')
                    + '</span><span>' + date_start.getFullYear() + '-' + date_stop.getFullYear() + '</span></div>'
                    + old_names;

                //new_str += this_str;
                data_array[i] = 
                                { 
                                    number: val.fund_number,
                                    org: val.name,
                                    html: this_str
                                };

                //$('.fonds-list tbody').append('<tr><td>' + val.name + '</td><td>' + d.getFullYear() + '-' + val.date_stop + '</td></tr>');
                i++;
            });
        
            var sort_elem = $('.js-sort-parent').attr('data-sort');
            var sort_type = $('.js-sort-parent').attr('data-sort-type');
            var sorted_array;

            if(sort_elem == 'num') {
                sorted_array = numSort(data_array, sort_type);
            } else {
                sorted_array = nameSort(data_array, sort_type);
            }

            $.each(sorted_array, function(index, value){
                new_str += value.html;
            });

            $('.fonds-list .tbody').html(new_str);
        } else {
            $('.fonds-list .tbody').html('<div><p style="text-align: center; margin: 0;">Не найдено подходящих записей. Попробуйте изменить условия поиска.</p></div>');
        }
    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(jqXHR);
    }

    options.complete = function(data, textStatus, jqXHR){
        //$(form).find('button').removeClass('loading');
        $('.fonds-list').removeAttr('style');
        $('.ajaxload').addClass('hidden');
    }

    $(form).ajaxSubmit(options);
}

$(document).on('click', 'a[data-childs-for]', function(){
    //alert($(this).data('childs-for'));
    $('[data-parent="' + $(this).data('childs-for') + '"]').toggleClass('hidden');
    return false;
});

$("#loginForm").validate({
    rules: {
        //fio: "required",
        email: {
            required: true,
            //email: true
        },
        password: {
            required: true,
            minlength: 4
        },
    },
    messages: {
        email: '',
        password: ''
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //console.log(form);
        sendLoginForm(form);
        return false;
    }
});

function sendLoginForm(form) {

    //console.log(form);

    var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

    options.beforeSubmit = function(formData, jqForm, options){
        $(form).find('button').addClass('loading');
        $('.error').text('').hide();
    }

    options.success = function(response, status, xhr, jqForm){
        //console.log(response);
        //$('.success').hide().removeClass('hidden').slideDown();
        //$(form).slideUp();

        if (response.status && response.redirect) {
            $('.error').text('').hide();
            location.href = response.redirect;
        } else {
            $('.error').text(response.responseText).show();
        }

    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(xhr);
    }

    options.complete = function(data, textStatus, jqXHR){
        $(form).find('button').removeClass('loading');
    }

    $(form).ajaxSubmit(options);
}



$("#feedbackForm").validate({
    rules: {
        name: "required",
        email: {
            required: true,
            email: true
        },
        message: {
            required: true,
            minlength: 4
        },
    },
    messages: {
        name: '',
        email: '',
        message: ''
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //console.log(form);
        sendFeedbackForm(form);
        return false;
    }
});

function sendFeedbackForm(form) {

    //console.log(form);

    var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

    options.beforeSubmit = function(formData, jqForm, options){
        $(form).find('button').addClass('loading');
        //$('.error').text('').hide();
    }

    options.success = function(response, status, xhr, jqForm){
        //console.log(response);
        //$('.success').hide().removeClass('hidden').slideDown();
        //$(form).slideUp();

        if (response.status) {
            //$('.error').text('').hide();
            //location.href = response.redirect;
            $('.response').text(response.responseText).slideDown();
            $(form).slideUp();
        } else {
            $('.response').text(response.responseText).show();
        }

    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(xhr);
    }

    options.complete = function(data, textStatus, jqXHR){
        $(form).find('button').removeClass('loading');
    }

    $(form).ajaxSubmit(options);
}


function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function numSort(array, type) {


    var sorted = array.sort(function(a, b){
        if(type == "asc") {
            return a.number - b.number;
        } else {
            return b.number - a.number;
        }
    });

    return sorted;
}

function nameSort(array, type) {
    var sorted = array.sort(function(a, b){
        var nameA=a.org.toLowerCase(), nameB=b.org.toLowerCase();
        if(type == "asc") {
            if (nameA < nameB)
                return -1
            if (nameA > nameB)
                return 1
            return 0
        } else {
            if (nameA > nameB)
                return -1
            if (nameA < nameB)
                return 1
            return 0
        }
    });

    return sorted;
}
