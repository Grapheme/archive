@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Подать запрос</h1>
                <div class="apply-form">

                    <div class="success hidden">
                    {{ $page->block('success') }}
                    </div>

                    {{ Form::open(array('url' => URL::route('send-user-request'), 'class' => '', 'id' => 'sendRequestForm', 'role' => 'form', 'method' => 'POST', 'files' => true)) }}

                        {{ $page->block('intro') }}

                        <table class="apply-table">
                            <tr>
                                <td>Ф.И.О. *</td>
                                <td>
                                    {{--<input type="text" class="apply-input">--}}
                                    {{ Form::text('name', '', array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    {{ Form::text('email', '', array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Почтовый адрес</td>
                                <td>
                                    {{ Form::text('postal', '', array('class' => 'apply-input', 'placeholder' => '')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Тип запроса *</td>
                                <td>
                                    {{ Form::select(
                                    'type',
                                    array('Выберите...')+Dictionary::whereSlugValues('request_types')->lists('name', 'id'),
                                    '',
                                    array('class' => 'apply-select')
                                    ) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Текст запроса *</td>
                                <td>
                                    {{ Form::textarea('content', '', array('class' => 'apply-textarea')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Копия паспорта *</td>
                                <td>
                                    <div class="file-btn"><a href="#" class="us-link">выберите файл</a></div>
                                    {{ Form::file('file_passport', array('class' => 'apply-file', 'accept' => 'image/jpeg,image/png,image/gif')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Копия трудовой книжки *</td>
                                <td>
                                    <div class="file-btn"><a href="#" class="us-link">выберите файл</a></div>
                                    {{ Form::file('file_workbook', array('class' => 'apply-file', 'accept' => 'image/jpeg,image/png,image/gif')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Файл</td>
                                <td>
                                    <div class="file-btn"><a href="#" class="us-link">выберите файл</a></div>
                                    {{ Form::file('file', array('class' => 'apply-file', 'accept' => 'image/jpeg,image/png,image/gif')) }}
                                </td>
                            </tr>
                        </table>

                        <div class="form-container">

                            К загрузке принимаются только изображения в форматах JPG, PNG или GIF.
                            
                            {{--
                            <div class="file-btn">Дополнительно: <a href="#" class="us-link">выберите файл</a></div>
                            {{ Form::file('file', array('class' => 'apply-file')) }}
                            --}}

                            <div class="clearfix"></div>

                            <button class="us-btn invert{{-- loading--}}">Отправить</button>

                        </div>

                    {{ Form::close() }}

                </div>
            </div>
        </section>
@stop


@section('scripts')
@stop