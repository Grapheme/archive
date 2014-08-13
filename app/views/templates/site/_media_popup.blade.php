
<div class="pop-photos pop-window closed" data-popup="photos">

    <div class="pop-title">
        Все фото {{--и видео--}}
        <i class="pop-close js-pop-close"></i>
    </div>
    <div class="photo-screen">
        <a href="#" class="nav-prev"><i class="fa fa-step-backward"></i></a>
        <a href="#" class="nav-next"><i class="fa fa-step-forward"></i></a>
        <a href="#" class="photo-like"><i class="fa fa-heart"></i></a>
        <img class="photo" id="main-photo" src="{{--http://campus.ie/sites/default/files/ucc_1.jpg--}}">
    </div>
    <div class="photo-info">
        <span class="fl-l">Загрузил <a href="#" class="us-link media-author">И. Петров</a> <span class="media-date">22 января 2012</span></span>
            <span class="fl-r">
                <a href="#" class="feed-like us-link">
                    Нравится <i class="fa fa-thumbs-up"></i><span class="media-likes">14</span>
                </a>
                <a href="#" class="feed-like us-link">
                    Не нравится <i class="fa fa-thumbs-down"></i><span class="media-dislikes">120</span>
                </a>
            </span>
        <div class="clearfix"></div>
    </div>

    <?
    if (@count($mediafiles)) {
        $mediafiles_official = array();
        $mediafiles_students = array();
        foreach ($mediafiles as $mediafile) {
            if($mediafile->official)
                $mediafiles_official[] = $mediafile;
            else
                $mediafiles_students[] = $mediafile;
        }
    }
    ?>

    @if (@count($mediafiles_official))
    <div class="other-photos">
        <div class="title">Офицальные фото и видео:</div>
        <ul class="media-block unstyled-list">
            @foreach ($mediafiles_official as $mediafile)
            <li class="media-item media-video_">
                <a href="#" class="media-link" style="background-image: url({{ $mediafile->image->thumb() }})"
                   data-mediaid="{{ $mediafile->id }}"
                   data-full="{{ $mediafile->image->full() }}"
                   data-date="{{ Helper::rdate('j M Y', $mediafile->created_at->timestamp) }}"
                   data-author="{{ trim($mediafile->user->surname.' '.$mediafile->user->name) }}"
                   data-likes="111" data-dislikes="222"
                    ></a>
                @endforeach
        </ul>
    </div>
    @endif

    @if (@count($mediafiles_students))
    <div class="other-photos">
        <div class="title">Популярные фото и видео, загруженные студентами:</div>
        <ul class="media-block unstyled-list">
            @foreach ($mediafiles_students as $mediafile)
            <li class="media-item media-video_">
                <a href="#" style="background-image: url({{ $mediafile->image->thumb() }})"
                   data-mediaid="{{ $mediafile->id }}"
                   data-full="{{ $mediafile->image->full() }}"
                   data-date="{{ Helper::rdate('j M Y', $mediafile->created_at->timestamp) }}"
                   data-author="{{ trim($mediafile->user->surname.' '.$mediafile->user->name) }}"
                   data-likes="111" data-dislikes="222"
                    ></a>
                @endforeach
        </ul>
        @if (0)
        <ul class="media-block unstyled-list">
            <li class="media-item media-video">
                <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
            <li class="media-item">
                <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
            <li class="media-item">
                <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
            <li class="media-item">
                <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
        </ul>
        @endif
    </div>
    @endif

</div>
