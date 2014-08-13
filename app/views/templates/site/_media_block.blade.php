@if (@count($mediafiles))
<ul class="unstyled-list media-list" style="width:100%">
    <!--
    @foreach ($mediafiles as $mediafile)
    <? if(@++$i>3) { break; } ?>
    --><li><a href="#" class="media-item media-video_ media-link" style="background-image: url({{ $mediafile->image->thumb() }})"
           data-mediaid="{{ $mediafile->id }}"
           data-full="{{ $mediafile->image->full() }}"
           data-date="{{ Helper::rdate('j M Y', $mediafile->created_at->timestamp) }}"
           data-author="{{ trim($mediafile->user->surname.' '.$mediafile->user->name) }}"
           data-likes="111" data-dislikes="222"
           ></a></li><!--
    @endforeach
    -->

    @if (@$link && $i >= 3)
    <a href="{{ $link }}" class="us-link-dash fl-r clearfix media-all-link">все фото и видео</a>
    @endif

</ul>
@endif