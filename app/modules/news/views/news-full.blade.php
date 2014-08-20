@extends(Helper::layout())


@section('style')
	<link rel="stylesheet" href="/css/fotorama.css">
@stop


@section('content')
<main1>
    <h1>
        {{ $news->meta->title }}
    </h1>

    <p class="news-date">
        {{ date("d/m/Y", strtotime($news->published_at)) }}
    </p>

    <div class="news-desc">
        <h3>Анонс новости</h3>
        {{ $news->meta->preview }}
    </div>

    <div class="news-desc">
        <h3>Содержание новости</h3>
        {{ $news->meta->content }}
    </div>

    <hr />

    @if (@is_object($news->meta->photo))
        <h3>Изображение</h3>
        <img src="{{ URL::to($news->meta->photo->thumb()) }}">
    @endif

    @if (@is_object($news->meta->gallery) && $news->meta->gallery->photos->count())
        <h3>Галерея (слайдер)</h3>
        <div class="fotorama" data-nav="false" data-width="100%" data-fit="contain" style="width:300px">
        @foreach($news->meta->gallery->photos as $photo)
        <img src="{{ URL::to($photo->full()) }}">
        @endforeach
        </div>
    @endif

    @if (@is_object($news->meta->seo))
        <h3>SEO-данные</h3>
        {{ Helper::ta($news->meta->seo) }}
    @endif

</main1>
@stop


@section('scripts')
    <script src="/js/vendor/fotorama.js"></script>
@stop