<?
    $page_title = "Запросы";

    #Helper::dd(Dictionary::whereSlugValues('request_statuses'));
    $statuses = array();
    $statuses[] = array(
        'link' => URL::route($module['entity'] . '.index', null, false),
        'title' => 'Все запросы (' . UserRequest::count() . ')',
    );
    $def_arr = false;
    foreach (Dictionary::whereSlugValues('request_statuses') as $status) {
        $arr = array(
            'link' => URL::route($module['entity'] . '.index', array('status' => $status->id), false),
            'title' => $status->name. ' (' . UserRequest::where('status_id', $status->id)->count() . ')',
        );
        if (Input::get('status') && Input::get('status') == $status->id)
            $def_arr = $arr;
        $statuses[] = $arr;
    }
    if (!$def_arr)
        $def_arr = array(
            'link' => URL::route($module['entity'] . '.index', null, false),
            'title' => 'Все запросы (' . UserRequest::count() . ')',
        );
    $def_arr['class'] = 'btn btn-default';
    $def_arr['child'] = $statuses;

    $menus = array();
    $menus[] = $def_arr;
    if (Allow::action($module['group'], 'create')) {
        $menus[] = array(
            'link' => URL::route($module['entity'] . '.create', null, false),
            'title' => 'Добавить',
            'class' => 'btn btn-primary'
        );
    }
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

                @if ($child_exists)
            </div>
            @endif
            @endforeach

        </div>
    </div>
</div>
