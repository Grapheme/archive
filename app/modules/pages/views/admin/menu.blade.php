<?

    $menus = array();
    $menus[] = array(
        'link' => URL::route($module['entity'] . '.index', array(), false),
        'title' => 'Страницы',
        'class' => 'btn btn-default'
    );
    $menus[] = array(
        'link' => URL::route($module['entity'] . '.create', array(), false),
        'title' => 'Добавить',
        'class' => 'btn btn-primary'
    );

?>

    <h1>Страницы</h1>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="margin-bottom-25 margin-top-10 ">

                @foreach ($menus as $m => $menu)
                <a class="{{ $menu['class'] }}" href="{{ $menu['link'] }}">
                    <? if($_SERVER['REQUEST_URI'] == $menu['link']) { echo '<i class="fa fa-check"></i>'; } ?>
                    {{ $menu['title'] }}
                </a>
                @endforeach

            </div>
        </div>
    </div>
