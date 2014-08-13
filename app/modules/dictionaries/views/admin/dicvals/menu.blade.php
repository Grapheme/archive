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
