<?
    $menus = array();
    if (Allow::action($module['group'], 'create')) {
        $menus[] = array(
            'link' => URL::route('dic.create', null),
            'title' => 'Добавить',
            'class' => 'btn btn-primary'
        );
    }
?>
    
    <h1>Словари</h1>

    {{ Helper::drawmenu($menus) }}

