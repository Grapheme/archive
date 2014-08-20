@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')
<?
$years = array();
?>
    <section class="normal-page">
        <div class="wrapper">
            <h1>Новости</h1>

            @if(isset($news) && is_object($news) && $news->count())
            <ul class="news-list">
                @foreach($news as $new)
                <? $years[date('Y', strtotime($new->published_at))] = 1; ?>
                <li data-year="{{ date('Y', strtotime($new->published_at)) }}">
                    <h3>
                        <a href="#">{{ $new->meta->title }}</a>
                    </h3>
                    <div class="news-date">{{ Helper::rdate('j M Y', $new->published_at) }}</div>
                    <div class="news-text">
                        <p>{{ $new->meta->content }}</p>
                    </div>
                @endforeach
            </ul>
            @endif

            <ul class="news-year">
                @foreach ($years as $year => $null)
                <li{{ date('Y') == $year ? ' class="active"' : '' }}><a href="#{{ $year }}">{{ $year }}</a>
                @endforeach
            </ul>
        </div>

        {{ $news->links() }}

    </section>
@stop



@section('scripts')
@stop