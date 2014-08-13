<?
    $page_title = "Фонды";

    /*
    #Helper::dd(Dictionary::whereSlugValues('request_statuses'));
    $statuses = array();
    $statuses[] = array(
        'link' => URL::route($module['entity'] . '.index', null),
        'title' => 'Все запросы (' . UserRequest::count() . ')',
    );
    $def_arr = false;
    foreach (Dictionary::whereSlugValues('request_statuses') as $status) {
        $arr = array(
            'link' => URL::route($module['entity'] . '.index', array('status' => $status->id)),
            'title' => $status->name. ' (' . UserRequest::where('status_id', $status->id)->count() . ')',
        );
        if (Input::get('status') && Input::get('status') == $status->id)
            $def_arr = $arr;
        $statuses[] = $arr;
    }
    if (!$def_arr)
        $def_arr = array(
            'link' => URL::route($module['entity'] . '.index', null),
            'title' => 'Все запросы (' . UserRequest::count() . ')',
        );
    $def_arr['class'] = 'btn btn-default';
    $def_arr['child'] = $statuses;
    */

    $menus = array();
    #$menus[] = $def_arr;
    $menus[] = array(
        'link' => URL::route($module['entity'] . '.index', null),
        'title' => 'Все фонды',
        'class' => 'btn btn-default'
    );
    $menus[] = array(
        'link' => URL::route($module['entity'] . '.create', null),
        'title' => 'Добавить',
        'class' => 'btn btn-primary'
    );

    ## № фонда
    $menus[] = array(
        'raw' =>
            ' | '
            . Form::open(array('url' => URL::route($module['entity'].'.index'), 'method' => 'GET', 'class' => 'smart-form col-3', 'style' => 'display:inline-block; width:120px; vertical-align:middle'))
            #. Helper::hiddenGetValues()
            . '<div class="input-group">'
            . Form::text('fund', Input::get('fund'), array('class' => 'form-control text-center', 'placeholder' => '№ фонда'))
            . '     <button type="submit" class="btn btn-default input-group-btn"><i class="fa fa-search"></i></button>'
            . '</div>'
            . Form::close()
    );

    ## Даты
    $menus[] = array(
        'raw' =>
            ' | '
            . Form::open(array('url' => URL::route($module['entity'].'.index'), 'method' => 'GET', 'class' => 'smart-form col-3', 'style' => 'display:inline-block; width:220px; vertical-align:middle'))
            #. Helper::hiddenGetValues()
            . Form::text('date_start', Input::get('date_start'), array('class' => 'form-control text-center pull-left col-5', 'placeholder' => 'дата с'))
            . '<div class="input-group">'
            . Form::text('date_stop', Input::get('date_stop'), array('class' => 'form-control text-center', 'placeholder' => 'дата по'))
            . '<button type="submit" class="btn btn-default col-2 input-group-btn"><i class="fa fa-search"></i></button>'
            . '</div>'
            . Form::close()
    );

    ## Поиск по названию
    $menus[] = array(
        'raw' =>
            ' | '
            . Form::open(array('url' => URL::route($module['entity'].'.index'), 'method' => 'GET', 'class' => 'smart-form col-3', 'style' => 'display:inline-block; width:220px; vertical-align:middle'))
            #. Helper::hiddenGetValues()
            . '<div class="input-group">'
            . Form::text('search', Input::get('search'), array('class' => 'form-control text-center', 'placeholder' => 'Название организации'))
            . '     <button type="submit" class="btn btn-default input-group-btn"><i class="fa fa-search"></i></button>'
            . '</div>'
            . Form::close()
    );

    ## Записи без дат
    $menus[] = array(
        'raw' =>
            ' | '
            . Form::open(array('url' => URL::route($module['entity'].'.index'), 'method' => 'GET', 'class' => 'smart-form col-3', 'style' => 'display:inline-block; width:30px; vertical-align:middle'))
            . Form::hidden('parsed', '0')
            . '<button type="submit" class="btn btn-warning input-group-btn" title="Записи без крайних дат"><i class="fa fa-wrench"></i></button>'
            . Form::close()
    );

    ##################################################################

    /*
    if (isset($element) && is_object($element) && @$element->name) {
        #Helper::dd($element);
        $page_title = "<i class='fa fa-edit'></i> &nbsp;" . $element->name . ($element->fullname ? ' ('.$element->fullname.')' : '');
    } else {
        foreach ($menus as $menu) {
            if($_SERVER['REQUEST_URI'] == $menu['link']) {
                $page_title = $menu['title'];
                break;
            }
        }
    }
    */
?>

    <h1>{{ $page_title }}</h1>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="margin-bottom-25 margin-top-10 ">

            @foreach ($menus as $m => $menu)
            <?
            $child_exists = (isset($menu['child']) && is_array($menu['child']) && count($menu['child']));
            ?>

            @if ($child_exists)
            <div class="btn-group">
            @endif

                @if (@$menu['raw'])
                    {{ $menu['raw'] }}
                @else
                    <a class="{{ $menu['class'] }}" href="{{ $menu['link'] }}">
                        <? if($_SERVER['REQUEST_URI'] == $menu['link']) { echo '<i class="fa fa-check"></i>'; } ?>
                        {{ $menu['title'] }}
                    </a>
                    @if ($child_exists)
                    <a class="btn btn-default {{ @$menu['class'] }} dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu text-left">
                        @foreach ($menu['child'] as $c => $child)
                        <li>
                            <a class="{{ @$child['class'] }}" href="{{ $child['link'] }}">
                                {{ $child['title'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                @endif

            @if ($child_exists)
            </div>
            @endif
            @endforeach

        </div>
    </div>
</div>
