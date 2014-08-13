
@if (count($faces_worker))

<div class="pop-alumnus pop-window closed" data-popup="faces_worker">
    <div class="pop-title">
        Все руководство
        <i class="pop-close js-pop-close"></i>
    </div>
    <ul class="people-ul unstyled-list">

        @foreach ($faces_worker as $f => $face)
        <? if($f == 10) { break; } ?>
        <li>
            <div class="people-photo" style="background-image: url({{ $face->image->thumb() }});"></div>
            <div class="desc">
                @if ($face->position)
                {{ $face->position }}<br/>
                @endif
                {{ $face->surname }}
                {{ $face->name }}
                {{ $face->lastname }}
            </div>
            <div class="about-pers">
                {{--2008 г.в. <a href="#" class="us-link">Экономика</a><br>--}}
                @if ($face->speciality)
                <a href="{{ URL::action($CLASS.'@getSpeciality', array('speciaity_id' => $face->speciality->id)) }}" class="us-link">{{ $face->speciality->name }}</a><br/>
                @endif
                {{ $face->comments }}
            </div>
        @endforeach

    </ul>
</div>

@endif


@if (count($faces_graduate))

<div class="pop-alumnus pop-window closed" data-popup="faces_graduate">
    <div class="pop-title">
        Успешные выпускники
        <i class="pop-close js-pop-close"></i>
    </div>
    <ul class="people-ul unstyled-list">
        @foreach ($faces_graduate as $f => $face)
        <? if($f == 10) { break; } ?>
        <li>
            <div class="people-photo" style="background-image: url({{ $face->image->thumb() }});"></div>
            <div class="desc">
                @if ($face->position)
                {{ $face->position }}<br/>
                @endif
                {{ $face->surname }}<br/>
                {{ $face->name }}
                {{ $face->lastname }}
            </div>
            <div class="about-pers">
                @if ($face->year)
                {{ $face->year }} г.в.
                @endif
                @if ($face->speciality)
                <a href="{{ URL::action($CLASS.'@getSpeciality', array('speciaity_id' => $face->speciality->id)) }}" class="us-link">{{ $face->speciality->name }}</a><br/>
                @endif
                {{ $face->comments }}
            </div>
        @endforeach

    </ul>
</div>

@endif

