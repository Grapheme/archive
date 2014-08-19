@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Подать запрос</h1>
                <div class="apply-form">
                    
                    {{ $page->block('intro') }}

                    <form>
                        <table class="apply-table">
                            <tr>
                                <td>Ф.И.О.</td>
                                <td><input type="text" class="apply-input inp-error"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="text" class="apply-input"></td>
                            </tr>
                            <tr>
                                <td>Тип запроса</td>
                                <td>
                                    <select class="apply-select">
                                        <option>1</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Текст запроса</td>
                                <td><textarea class="apply-textarea"></textarea></td>
                            </tr>
                        </table>
                        <div class="form-container">
                            <div class="file-btn">Файл: <a href="#" class="us-link">выберите файл</a></div>
                            <input type="file" class="apply-file">
                            <button class="us-btn invert loading">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
@stop


@section('scripts')
@stop