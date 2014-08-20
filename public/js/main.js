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
		var parent;
	});
})();


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

    /*
    $.ajax({
        type: $(form).attr('method') || 'GET',
        url:  $(form).attr('action'),
        data: $(form).serialize(),
        beforeSend: function(xhr) {
            //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            $(form).find('button').addClass('loading');
        }
    }).done(function(data, textStatus, jqXHR) {

        console.log(data);
        $('.success').hide().removeClass('hidden').slideDown();
        $(form).slideUp();

    }).fail(function(jqXHR, textStatus, errorThrown) {

        console.log(jqXHR);
    }).always(function(data) {

        //console.log(data);
        $(form).find('button').removeClass('loading');
    });
    */

    var options = { target: null, type: 'post' };

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

    options.always = function(data, textStatus, jqXHR){
        $(form).find('button').removeClass('loading');
    }

    $(form).ajaxSubmit(options);

}
