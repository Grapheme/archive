<?
    $page_title = "Запросы";

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

    $menus = array();
    $menus[] = $def_arr;
    if (Allow::action($module['group'], 'create')) {
        $menus[] = array(
            'link' => URL::route($module['entity'] . '.create', null),
            'title' => 'Добавить',
            'class' => 'btn btn-primary'
        );
    }

?>

    <h1>{{ $page_title }}</h1>

    {{ Helper::drawmenu($menus) }}

