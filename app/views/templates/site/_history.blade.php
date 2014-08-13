@if ($history != false && @count($history))
<?
#var_dump($history); die();
?>
<div class="gray-block margin-t20">
    <div class="normal-title">Ранее вы смотрели</div>
    <ul class="relative-dirs unstyled-list">

        @foreach ($history as $timestamp => $obj)
        <?
        $obj = (object)$obj;
        if (isset($obj->university))
            $obj->university = (object)$obj->university;
        #Helper::dd($obj);
        ?>
        <li class="margin-t15">
            <div class="dir-left">

                @if (@$obj->university)
                <div class="title">
                    <a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $obj->id)) }}" class="us-link">{{ $obj->name }}</a>
                </div>
                <div class="desc">
                    <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $obj->university->id)) }}" class="us-link">{{ $obj->university->name }}</a>
                </div>
                @else
                <div class="title">
                    <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => @$obj->id)) }}" class="us-link">{{ @$obj->fullname }}</a>
                </div>
                <div class="desc">
                </div>
                @endif
            </div>
            <div class="rating fl-r not_ready">0,0</div>
        </li>
        @endforeach
    </ul>
</div>
@endif