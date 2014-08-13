<?php

class AdminDicvalsController extends BaseController {

    public static $name = 'dicvalues';
    public static $group = 'dictionaries';
    public static $entity = 'dic';
    public static $entity_name = 'словарь';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        $entity = self::$entity;
        Route::group(array('before' => 'auth', 'prefix' => $prefix . "/" . $class::$group), function() use ($class, $entity) {
            Route::post($entity.'/ajax-order-save', $class."@postAjaxOrderSave");
            Route::resource('dic.val', $class,
                array(
                    'except' => array('show'),
                    'names' => array(
                        'index' => 'dicval.index',
                        'create' => 'dicval.create',
                        'store' => 'dicval.store',
                        'edit' => 'dicval.edit',
                        'update' => 'dicval.update',
                        'destroy' => 'dicval.destroy',
                    )
                )
            );
        });
    }

    ## Shortcodes of module
    public static function returnShortCodes() {
        ##
    }
    
    ## Actions of module (for distribution rights of users)
    public static function returnActions() {
        ##
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        ##
    }
        
    /****************************************************************************/
    
	public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group,
            'tpl' => static::returnTpl('admin/dicvals'),
            'gtpl' => static::returnTpl(),

            'entity' => self::$entity,
            'entity_name' => self::$entity_name,
        );

        View::share('module', $this->module);
        View::share('CLASS', __CLASS__);
	}

	#public function getIndex(){

	public function index($dic_id){

        Allow::permission($this->module['group'], 'dicval');

        $dic = Dictionary::find((int)$dic_id);
        if (!is_object($dic))
            App::abort(404);

        $elements = DicVal::where('dic_id', $dic_id)->orderBy('order', 'ASC')->orderBy('name', 'ASC')->paginate(30);
        #Helper::dd($elements);
		return View::make($this->module['tpl'].'index', compact('elements', 'dic'));
	}

    /************************************************************************************/

	#public function getCreate($entity){
	public function create($dic_id){

        Allow::permission($this->module['group'], 'dicval');

        $dic = Dictionary::find((int)$dic_id);
        if (!is_object($dic))
            App::abort(404);

        $element = new Dictionary;
		return View::make($this->module['tpl'].'edit', compact('element', 'dic'));
	}
    

	#public function getEdit($entity, $id){
	public function edit($dic_id, $id){

        Allow::permission($this->module['group'], 'dicval');

        $dic = Dictionary::find((int)$dic_id);
        if (!is_object($dic))
            App::abort(404);

		$element = DicVal::find($id);
		return View::make($this->module['tpl'].'edit', compact('element', 'dic'));
	}


    /************************************************************************************/


	public function store($dic_id) {

		return $this->postSave($dic_id);
	}


	public function update($dic_id, $id) {

		return $this->postSave($dic_id, $id);
	}


	public function postSave($dic_id, $id = false){

        #Helper::dd($entity);

        Allow::permission($this->module['group'], 'dicval');

		if(!Request::ajax())
            return App::abort(404);

        $dic = Dictionary::find((int)$dic_id);
        if (!is_object($dic))
            App::abort(404);

        #$input = Input::all();
        $input = array(
            'slug' => trim(Input::get('slug')) != '' ? trim(Input::get('slug')) : NULL,
            'name' => Input::get('name'),
            'dic_id' => $dic_id,
        );

		$json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE);
		$validator = Validator::make($input, array('name' => 'required'));
		if($validator->passes()) {

            $redirect = false;

            if ($id > 0) {

                if (NULL !== DicVal::find($id)) {
    
        		    #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        		    #return Response::json($json_request,200);

                    DicVal::find($id)->update($input);
                }

            } else {

                DicVal::insert($input);
                $redirect = true;
            }

			$json_request['responseText'] = 'Сохранено';
            if ($redirect && Input::get('redirect'))
			    $json_request['redirect'] = Input::get('redirect');
			$json_request['status'] = TRUE;
		} else {
			$json_request['responseText'] = 'Неверно заполнены поля';
			$json_request['responseErrorText'] = $validator->messages()->all();
		}
		return Response::json($json_request, 200);
	}

    /************************************************************************************/

	#public function deleteDestroy($entity, $id){
	public function destroy($id){

        Allow::permission($this->module['group'], 'dicval');

		if(!Request::ajax())
            return App::abort(404);

		$json_request = array('status'=>FALSE, 'responseText'=>'');

        if (NULL !== DicVal::find($id))
            DicVal::find($id)->delete();

		$json_request['responseText'] = 'Удалено';
		$json_request['status'] = TRUE;
		return Response::json($json_request,200);
	}


    public function postAjaxOrderSave() {

        $poss = Input::get('poss');

        $pls = DicVal::whereIn('id', $poss)->get();

        if ( $pls ) {
            foreach ( $pls as $pl ) {
                $pl->order = array_search($pl->id, $poss);
                $pl->save();
            }
        }

        return Response::make('1');
    }

}


