@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

<?
## Ищем совпадения в фондах
$results_funds = SphinxSearch::search(Input::get('s'), 'archive_funds_index')->query();
$results_funds_count = @count($results_funds['matches']);
#Helper::dd($results_funds['matches']);

## Получим ID-шники подходящих записей
#$results = SphinxSearch::search(Input::get('s'), 'archive_pages_index')->query();
#Helper::d($results);

## Получим модели с нужными связями
$results = SphinxSearch::search(Input::get('s'), 'archive_pages_index')->with('meta', 'blocks.meta')->get();
#Helper::tad($results);

## Получим поисковые подсказки
$docs = array();
foreach ($results as $result) {
    $line = '';
    foreach ($result->blocks as $block) {
        $line .= Helper::multiSpace(strip_tags($block->meta->content)) . "\n";
    }
    $docs[$result->id] = trim($line);
}
#Helper::dd($docs);
$excerpts = Helper::buildExcerpts($docs, 'archive_pages_index', Input::get('s'), array('before_match' => '<span>', 'after_match' => '</span>'));
#Helper::d($excerpts);
?>

        <section class="normal-page">
            <div class="wrapper">
                <h1>Результаты поиска</h1>
                <div class="search">

                    @if ($results_funds_count)
                    <div class="search-amount">
                        Найдено
                        <span>
                        {{ trans_choice(':count</span> совпадение|:count</span> совпадения|:count</span> совпадений', $results_funds_count, array(), 'ru') }}
                        в записях по фондам. Для просмотра перейдите на <a href="{{ URL::route('page', 'fonds') }}?s={{ Input::get('s') }}">страницу поиска по фондам</a>.
                    </div>
                    @endif

                    <div class="search-amount">
                        @if (count($results))
                        Всего результатов поиска: <span><span class="results_count">{{ count($results) }}</span></span>
                        @elseif (!$results_funds_count)
                        По запросу "<b>{{ Input::get('s') }}</b>" ничего не найдено.
                        @endif
                    </div>

                    @if (count($results))
                    <ul class="search-list">
                        @foreach ($results as $r => $result)
                        <li>
                            <h3>
                                <a href="{{ URL::route('page', $result->slug) }}">{{ $result->name }}</a>
                            </h3>
                            <div class="search-text">
                                {{ $excerpts[$r] }}
                            </div>
                        @endforeach
                    </ul>
                    @endif

                </div>
            </div>
        </section>


@stop


@section('scripts')
@stop