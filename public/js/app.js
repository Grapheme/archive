
$(document).ready(function() {

    var unifersity_form = '#university-form';
    var speciality_form = '#speciality-form';
    var calculator_form = '#calculator-form';
    var university_select = '.university-select';
    var speciality_select = '.speciality-select';
    var speciality_select_2 = '.speciality-select-2';

    $(university_select).on('change', function(){

        //alert(this.value);

        //$(unifersity_form + " *").attr('disabled', 'disabled');

        var uid = this.value;
        $.ajax({
            url: "/ajax-university-select",
            type: 'post',
            dataType: 'json',
            data: {
                uid: uid
            }
        }).done(function(data){

            console.log(data);
            //return;

            var len = Object.keys(data).length;
            //alert(len);

            // JSON DECODE -> Tags
            $(speciality_select).html('<option selected="selected" value="0">Все направления</option>');
            if (len > 0) {
                /*
                $(data).each(function (i) {
                    alert(i + ' > ' + data[i] + " | ");
                    $(speciality_select).append('<option value="' + i + '">' + data[i] + '</option>');
                });
                */
                var object = data;
                for(var index in object) {
                    if (object.hasOwnProperty(index)) {
                        //var attr = object[index];
                        $(speciality_select).append('<option value="' + index + '">' + object[index] + '</option>');
                    }
                }
            }

            //$(unifersity_form + " *").removeAttr('disabled');

            //var selectBox = new SelectBox($(speciality_select));
            $(speciality_select).select2("destroy");
            $(speciality_select).select2();

        }).fail(function(data){
            console.log(data);
        });
    });

    /*
    $('.select-link').on('click', function(){
        $(speciality_select).select2("data", {id: "0", text: "Экономика"});
    )};
    */

    $(".select-link").click(function () {
        //$(speciality_select).select2("data", {id: "CA", text: "California"});
        $(speciality_select).select2("open");
        $('.select2-input').val($(this).text()).trigger('keyup');
    });

    $(unifersity_form).on('submit', function(){

        //console.log($(university_select).select2("data"));
        //alert( $(university_select).select2("data").id + ' | ' + $(speciality_select).select2("data").id );
        //if( $(university_select).val() == 0 && $(speciality_select).val() == 0 ) {

        if( $(university_select).select2("data").id == 0 && $(speciality_select).select2("data").id == 0 ) {
            return confirm('Вы не ввели ни одного параметра поиска, продолжить?');
        }
    });


    $(speciality_form).on('submit', function(){

        //alert( $(speciality_form).find('input[type=checkbox]:checked').length );
        //return false;

        if( $(speciality_select_2).select2("data").id == 0 && $(speciality_form).find('input[type=checkbox]:checked').length == 0 ) {
            return confirm('Вы не ввели ни одного параметра поиска, продолжить?');
        }
    });


    $(calculator_form).on('submit', function(){

        //alert( $(calculator_form).find('input[type=text][val!=""]').length );
        //alert( $(calculator_form).find('input[type=text]:first').val() );
        var i = 0;
        var total = 0;
        $(calculator_form).find('input[type=text]').each(function(index){
            //alert(++i + " | " + $(this).val());
            ++total;
            if ($(this).val() == '')
                ++i;
        });
        //alert(i);
        //return false;

        if( i == total ) {
            return confirm('Вы не ввели ни одного параметра поиска, продолжить?');
        }
    });


    /*************************************************************************************************/

    $('.view-full-desc').on('click', function(){
        $('.university-short-desc').slideUp(300);
        $('.university-full-desc').slideDown(300);
        return false;
    });

    $(document).on('click', '.faq-link', function(e){
        $(this).parent().find('.faq-answer').toggle();
        return false;
    });

    $(document).on('submit', '.faq-form', function(e){

        e.preventDefault();
        var form = $(this);

        var formdata = $(form).serialize();
        //alert(); //return false;

        var form_valid = true;

        // Subject
        if( !$(form).find('[name=subject] :selected').val() ) {
            $(form).find('.error-subject').removeClass('hidden');
            form_valid = false;
        } else
            $(form).find('.error-subject').addClass('hidden');

        // Email
        if( !validateEmail($(form).find('[name=email]').val()) ) {
            $(form).find('.error-email').removeClass('hidden');
            form_valid = false;
        } else
            $(form).find('.error-email').addClass('hidden');

        // Message
        if( !$(form).find('[name=message]').val() ) {
            $(form).find('.error-message').removeClass('hidden');
            form_valid = false;
        } else
            $(form).find('.error-message').addClass('hidden');

        if (!form_valid)
            return false;

        $(form).find('*').attr('disabled', 'disabled');
        $('.send-result').addClass('hidden');

        $.ajax({
            type: $(form).attr('method') || 'GET',
            url:  $(form).attr('action'),
            data: formdata
        }).done(function(data) {

            //alert('All OK!');
            $('.send-result *').addClass('hidden');
            $('.send-result .success').removeClass('hidden');
            $('.send-result').removeClass('hidden');
            $(form).slideUp();

        }).fail(function() {

            //alert('Ошибка');
            $('.send-result *').addClass('hidden');
            $('.send-result .error').removeClass('hidden');
            $('.send-result').removeClass('hidden');

        }).always(function(data) {
            console.log(data);
            $(form).find('*').removeAttr('disabled');
        });

        return false;
    });


    /*************************************************************************************************/


    $(document).on('click', '.media-link', function(e){
        //alert($(this).data('full'));
        $('#main-photo').attr('src', $(this).data('full')).data('mediaid', $(this).data('mediaid'));
        $('.media-author').text($(this).data('author'));
        $('.media-date').text($(this).data('date'));
        $('.media-likes').text($(this).data('likes'));
        $('.media-dislikes').text($(this).data('dislikes'));
        Popup.show('photos');
        return false;
    });

    $(document).on('click', '.photo-screen .nav-prev', function(e){
        //alert('<-' + $('#main-photo').data('mediaid'));

        var link = $('.pop-photos .media-link[data-mediaid=' + $('#main-photo').data('mediaid') + ']');
        var prev = $(link).parents('li').prev().find('a')
        if (!$(prev).data('mediaid'))
            prev = $(link).parents('li').parent().find('li:last').find('a');
        $(prev).click();

        //return false;
    });

    $(document).on('click', '.photo-screen .nav-next', function(e){
        //alert($('#main-photo').data('mediaid') + '->');

        var link = $('.pop-photos .media-link[data-mediaid=' + $('#main-photo').data('mediaid') + ']');
        var next = $(link).parents('li').next().find('a')
        if (!$(next).data('mediaid'))
            next = $(link).parents('li').parent().find('li:first').find('a');
        $(next).click();

        //return false;
    });

});

function validateEmail(x) {
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        return false;
    } else {
        return true;
    }
}
