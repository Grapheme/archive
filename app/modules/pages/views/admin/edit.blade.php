@extends(Helper::acclayout())


@section('style')
    {{ HTML::style('css/redactor.css') }}
@stop


@section('content')

    <?
    #$create_title = "Редактировать " . $module['entity_name'] . ":";
    #$edit_title   = "Добавить " . $module['entity_name'] . ":";
    $create_title = "Изменить страницу:";
    $edit_title   = "Новая страница:";

    $url        = @$element->id ? URL::route($module['entity'].'.update', array('id' => $element->id)) : URL::route($module['entity'].'.store', array());
    $method     = @$element->id ? 'PUT' : 'POST';
    $form_title = @$element->id ? $create_title : $edit_title;
    ?>

    @include($module['tpl'].'/menu')

    {{ Form::model($element, array('url'=>$url, 'class'=>'smart-form', 'id'=>$module['entity'].'-form', 'role'=>'form', 'method'=>$method)) }}

    <!-- Fields -->
    <div class="row margin-top-10">

        <!-- Form -->
        <section class="col col-6">
            <div class="well">
                <header>{{ $form_title }}</header>
                <fieldset>

                    <section>
                        <label class="label">Название</label>
                        <label class="input">
                            {{ Form::text('name') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Системное имя</label>
                        <label class="input">
                            {{ Form::text('slug') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Шаблон</label>
                        <label class="input select input-select2">
                            {{ Form::select('template', array('Выберите...')+$templates) }}
                        </label>
                    </section>

                    <section>
                        <label class="checkbox">
                            {{ Form::checkbox('publication', 1, ($element->publication === 0 ? null : true)) }}
                            <i></i>
                            Опубликовано
                        </label>
                    </section>

                    <section>
                        <label class="checkbox">
                            {{ Form::checkbox('in_menu', 1, (!$element->in_menu ? null : true)) }}
                            <i></i>
                            Отображать в меню
                        </label>
                    </section>

                    @if (count($locales) > 1)

                    <hr class="simple">

                    <section>
                        <label class="label">Индивидуальные настройки для разных (необязательно)</label>

                        <div class="widget-body">
                            <ul id="myTab1" class="nav nav-tabs bordered">
                                <? $i = 0; ?>
                                @foreach ($locales as $locale_sign => $locale_name)
                                <li class="{{ !$i++ ? 'active' : '' }}">
                                    <a href="#locale_{{ $locale_sign }}" data-toggle="tab">
                                        {{ $locale_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div id="myTabContent1" class="tab-content padding-10">
                                <? $i = 0; ?>
                                @foreach ($locales as $locale_sign => $locale_name)
                                <div class="tab-pane fade {{ !$i++ ? 'active in' : '' }}" id="locale_{{ $locale_sign }}">

                                    @include($module['tpl'].'_page_meta', compact('locale_sign', 'locale_name', 'templates', 'element'))

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    @endif

                </fieldset>

                <footer>
                    <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{ link::previous() }}">
                        <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
                    </a>
                    <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                        <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
                    </button>
                </footer>

            </div>
        </section>

        <section class="col col-6">
            <div class="well">

                <header>Блоки на странице:</header>

                <fieldset class="page-blocks">

                    <div id="blocks" class="sortable">
                        @if (count($element->blocks))
                            @foreach($element->blocks as $block)
                                @include($module['tpl'].'_block', array('block' => $block))
                            @endforeach
                        @endif
                    </div>

                    <div>
                        <a href="javascript:void(0)" class="new_block">Добавить блок</a>
                        {{--<a href="javascript:void(0)" class="new_blocks_test">Тестировать</a>--}}
                    </div>

                </fieldset>

            </div>
        </section>
        <!-- /Form -->

    </div>

    {{ Form::close() }}

    <div class="modal fade" id="blockEditModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

    <div id="default_block" class="hidden">
        @include($module['tpl'].'_block', array('block' => new PageBlock))
    </div>

@stop


@section('scripts')
    <script>
        var essence = '{{ $module['entity'] }}';
        var essence_name = '{{ $module['entity_name'] }}';
        var validation_rules = {
            name:              { required: true, maxlength: 100 },
            photo:             { required: true, minlength: 1 },
            date:              { required: true, minlength: 10, maxlength: 10 },
        };
        var validation_messages = {
            name:              { required: "Укажите название", maxlength: "Слишком длинное название" },
            photo:             { required: "Загрузите фотографию", minlength: "Загрузите фотографию" },
            date:              { required: "Выберите дату", minlength: "Выберите дату", maxlength: "Выберите дату" },
        };
        var onsuccess_function = 'update_blocks()';
    </script>

    <script>

        $(document).on('click', '.btn-form-submit', function(e){
            //e.preventDefault();

            var form = $(this).parents('form');
            $(form).find('.block_name').removeClass('error');
            var error_found = false;
            //alert("123");
            $(form).find('.block_name').each(function(){
                //alert($(this).val());
                if (!$(this).val()) {
                    $(this).addClass('error');
                    error_found = true;
                }
            });
            if (error_found)
                return false;

            return true;
        });
    </script>

    {{ HTML::script('js/modules/standard.js') }}

    {{ HTML::script('js/vendor/redactor.min.js') }}
    {{ HTML::script('js/system/redactor-config.js') }}

    <script type="text/javascript">
        if(typeof pageSetUp === 'function'){pageSetUp();}
        if(typeof runFormValidation === 'function') {
            loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}", runFormValidation);
        } else {
            loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
        }
    </script>

    {{ HTML::script('js/plugin/select2/select2.min.js') }}

    <script>

        var block_num = 0;
        var block_pos = 999;
        var page_id = {{ $element->id ? $element->id : 0 }};

        function update_blocks() {

            $.ajax({
                url: "/ajax-pages-get-page-blocks",
                type: 'post',
                data: {
                    id: page_id
                }
            }).done(function(data){
                //console.log(data);
                $('#blocks').html(data);
            }).fail(function(data){
                console.log(data);
            });
        }

        $(document).on('click', '.new_block', function(){
            var block = $('#default_block').html();
            block = block.split('%i%').join(block_num++);
            block = block.split('%p%').join(block_pos++);
            $('#blocks').append(block);
            sorting('.sortable');
        })

        $(document).on('click', '.edit_block', function(e){
            e.preventDefault();

            var block_id = $(this).data('id');
            if (block_id) {
                $.ajax({
                    url: "/ajax-pages-get-block",
                    type: 'post',
                    //dataType: 'json',
                    data: {
                        id: block_id
                    }
                }).done(function(data){
                    //console.log(data);
                    $('#blockEditModal').html(data).modal('show');
                    $('#blockEditModal .redactor').redactor();
                    return false;
                }).fail(function(data){
                    console.log(data);Z
                    return false;
                });
            }

        })


        $('#blockEditModal').on('hide.bs.modal', function (e) {
            // Не включать, т.к. при обновлении теряются несохраненные блоки!
            //update_blocks();
        })

        $(document).on('submit', '#block-form', function(e){
            e.preventDefault();

            var form = $(this);
            $(form).find('.btn-form-submit').elementDisabled(true);

            $.ajax({
                type: $(this).attr('method'),
                url:  $(this).attr('action'),
                data: $(this).serialize(), // serializes the form's elements.
                dataType: 'json'
            }).done(function(response){

                console.log(response);
                $(form).find('.btn-form-submit').elementDisabled(false);

                if(response.status){
                    showMessage.constructor(response.responseText, '');
                    showMessage.smallSuccess();
                }else{
                    showMessage.constructor(response.responseText, response.responseErrorText);
                    showMessage.smallError();
                }

                return false;

            }).fail(function(xhr, textStatus, errorThrown){

                //console.log(xhr);
                $(form).find('.btn-form-submit').elementDisabled(false);

                if (typeof(xhr.responseJSON) != 'undefined') {
                    var err_type = xhr.responseJSON.error.type;
                    var err_file = xhr.responseJSON.error.file;
                    var err_line = xhr.responseJSON.error.line;
                    var err_message = xhr.responseJSON.error.message;
                    var msg_title = err_type;
                    var msg_body = err_file + ":" + err_line + "<hr/>" + err_message;
                } else {
                    console.log(xhr);
                    var msg_title = textStatus;
                    var msg_body = xhr.responseText;
                }
                showMessage.constructor(msg_title, msg_body);
                showMessage.smallError();

                return false;

            });

        });


        $(document).on('click', '.remove_block', function(e){

            e.preventDefault();

            var block = $(this).parents('.block');
            var block_id = $(block).data('block_id');

            // ask verification
            $.SmartMessageBox({
                title : "<i class='fa fa-trash-o txt-color-orangeDark'></i>&nbsp; Удалить блок безвозратно?",
                content : "Все данные этого блока будут удалены без возможности восстановления",
                buttons : '[Нет][Да]'

            }, function(ButtonPressed) {
                if (ButtonPressed == "Да") {

                    if (block_id) {
                        $.ajax({
                            url: "/ajax-pages-delete-block",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                id: block_id
                            }
                        }).done(function(data){
                            //console.log(data);
                        }).fail(function(data){
                            console.log(data);
                        });
                    }

                    $(block).remove();
                    sorting('.sortable');
                }
            });

        })

        if (!document.getElementById('blocks')){
            $('html').css('overflowY', 'scroll');
        }

        $(document).on("mouseover", ".sortable", function(e){

            // Check flag of sortable activated
            if ( !$(this).data('sortable') ) {
                // Activate sortable, if flag is not initialized
                $(this).sortable({
                    // On finish of sorting
                    stop: function() {
                        sorting(this);
                        /*
                         // Send ajax request to server for saving sorting order
                         $.ajax({
                         url: "{{ URL::route($module['entity'].'.blocks-order-profile', array(), false) }}",
                         type: "post",
                         data: {poss: poss},
                         success: function() {}
                         });
                         */
                    }
                });
            }
        });

        function sorting(el) {
            var pls = $(el).children();
            $(pls).each(function(i, item) {
                $(item).find('.block_order').val(i);
            });
        }


        @if (!$element->id)
        $('.new_block').trigger('click');
        @endif


        function forEach(data, callback){
            for(var key in data){
                if(data.hasOwnProperty(key)){
                    callback(key, data[key]);
                }
            }
        }

    </script>

@stop