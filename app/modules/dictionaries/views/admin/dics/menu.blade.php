<?
    $menus = array();
    if (Allow::action($module['group'], 'create')) {
        $menus[] = array(
            'link' => URL::route('dic.create', null, true),
            'title' => 'Добавить',
            'class' => 'btn btn-primary'
        );
    }
?>
    
    <h1>Словари</h1>


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
