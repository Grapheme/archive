<?
    $page_title = "Фонды";

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

    {{ Helper::drawmenu($menus) }}
