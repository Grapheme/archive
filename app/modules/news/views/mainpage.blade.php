
    <ul class="index-news">
    	@foreach($news as $new)
        <li>
            <div class="news-date">{{ Helper::rdate("j M Y", strtotime($new->published_at)) }}</div>
            <a href="{{ URL::route('news_full', array('url' => $new->slug), false) }}" class="us-link">
                {{ $new->meta->title }}
            </a>
    	@endforeach
    </ul>
