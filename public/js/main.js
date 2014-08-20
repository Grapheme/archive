var search = (function(){
	var open = false,
		allow = true,
		search_block = $('.header-search'),
		nav_block = $('.main-nav');

	function search_open() {
		open = true;
		nav_block.addClass('closed');
		search_block.show();
		setTimeout(function(){
			search_block.addClass('active');
			setTimeout(function(){
				search_block.find('.menu-icon').addClass('active');
			}, 100);
		}, 15);
		setTimeout(function(){
			nav_block.hide();
			allow = true;
		}, 500);
	}

	function search_close() {
		open = false;
		nav_block.show();
		search_block.removeClass('active');
		setTimeout(function(){
			nav_block.removeClass('closed');
		}, 15);
		setTimeout(function(){
			search_block.hide();
			allow = true;
		}, 500);
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
		allow = false;
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
		}
	});
})();


/***************************************************************/

// validate signup form on keyup and submit
$("#sendRequestForm").validate({
    rules: {
        //fio: "required",
        name: {
            required: true,
            minlength: 4
        },
        email: {
            required: true,
            email: true
        },
        type: {
            required: true,
            min: 1
        },
        content: {
            required: true,
            minlength: 10
        }
    },
    messages: {
        name: '',
        email: '',
        type: '',
        content: ''
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

    var options = { target: null, type: $(form).attr('method') };

    options.beforeSubmit = function(formData, jqForm, options){
        $(form).find('button').addClass('loading');
    }

    options.success = function(response, status, xhr, jqForm){
        console.log(response);
        $('.success').hide().removeClass('hidden').slideDown();
        $(form).slideUp();
    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(jqXHR);
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
            max: 2014
        },
        stop: {
            require_from_group: [1, ".atleastone"],
            digits: true,
            min: 1900,
            max: 2014
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
        $('.fonds-list').addClass('hidden');
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
            $(funds).each(function(key, val){
                //console.log(val.name);
                var date_start = new Date(val.date_start);
                var date_stop = new Date(val.date_stop);
                new_str += '<tr><td>' + val.name + '</td><td>' + date_start.getFullYear() + '-' + date_stop.getFullYear() + '</td></tr>';
                //$('.fonds-list tbody').append('<tr><td>' + val.name + '</td><td>' + d.getFullYear() + '-' + val.date_stop + '</td></tr>');
            });
            $('.fonds-list tbody').html(new_str);
        } else {
            $('.fonds-list tbody').html('<tr><td colspan="2" style="text-align: center">Не найдено подходящих записей. Попробуйте изменить условия поиска.</td></tr>');
        }
    }

    options.error = function(xhr, textStatus, errorThrown){
        console.log(jqXHR);
    }

    options.complete = function(data, textStatus, jqXHR){
        //$(form).find('button').removeClass('loading');
        $('.fonds-list').removeClass('hidden');
        $('.ajaxload').addClass('hidden');
    }

    $(form).ajaxSubmit(options);
}
