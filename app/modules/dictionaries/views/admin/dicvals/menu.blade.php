<?
    $menus = array();
    $menus[] = array(
        'link' => action('dicval.create', array('dic_id' => $dic->id)),
        'title' => 'Добавить',
        'class' => 'btn btn-primary'
    );
    if (Allow::action($module['group'], 'edit')) {
        $menus[] = array(
            'link' => action('dic.edit', array('dic_id' => $dic->id)),
            'title' => 'Изменить',
            'class' => 'btn btn-success'
        );
    }
?>
    
    <h1>{{ $dic->name }}</h1>

    {{ Helper::drawmenu($menus) }}
