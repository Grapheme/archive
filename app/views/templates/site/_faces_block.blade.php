
@if (@count($faces_worker) || @count($faces_graduate))

<div class="">

    <!--
    @if (count($faces_worker))
    --><div class="dir-people">
        <div class="title">Руководство:</div>
        <ul class="people-ul unstyled-list">
            @foreach ($faces_worker as $f => $face)
            <? if($f == 3) { break; } ?>
            <li>
                <div class="people-photo" style="background-image: url({{ $face->image->thumb() }});"></div>
                <div class="desc">
                    @if ($face->position)
                    {{ $face->position }}<br/>
                    @endif
                    {{ $face->surname }}<br/>
                    {{ Helper::firstletter($face->name) }}
                    {{ Helper::firstletter($face->lastname) }}
                </div>
            @endforeach
        </ul>
        <div class="fl-r"><a href="#" class="us-link js-pop-show" data-popup="faces_worker">все руководство</a></div>
    </div><!--
    @endif

    @if (count($faces_graduate))
    --><div class="dir-people">
        <div class="title">Успешные выпускники:</div>
        <ul class="people-ul unstyled-list">
            @foreach ($faces_graduate as $f => $face)
            <? if($f == 4) { break; } ?>
            <li>
                <div class="people-photo" style="background-image: url({{ $face->image->thumb() }});"></div>
                <div class="desc">
                    @if ($face->position)
                    {{ $face->position }}<br/>
                    @endif
                    {{ $face->surname }}<br/>
                    {{ Helper::firstletter($face->name) }}
                    {{ Helper::firstletter($face->lastname) }}
                </div>
            @endforeach
        </ul>
        <div class="fl-r"><a href="#" class="us-link js-pop-show" data-popup="faces_graduate">больше выпускников</a></div>
    </div><!--
    @endif
    -->

</div>

@endif