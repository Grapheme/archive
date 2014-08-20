<?php

class AdminArchiveRequestController extends BaseController {

    public static $name = 'archive_request';
    public static $group = 'archive';
    public static $entity = 'request';
    public static $entity_name = 'запрос';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        $entity = self::$entity;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class, $entity) {
        	Route::resource($class::$group."/".$entity, $class,
                array(
                    #'except' => array('show'),
                    'names' => array(
                        'show'    => $entity.'.show',
                        'index'   => $entity.'.index',
                        'create'  => $entity.'.create',
                        'store'   => $entity.'.store',
                        'edit'    => $entity.'.edit',
                        'update'  => $entity.'.update',
                        'destroy' => $entity.'.destroy',
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
        ##return array();
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        ##
    }
        
    /****************************************************************************/
    
	public function __construct(UserRequest $essence){

        $this->essence = $essence;

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group."/".self::$entity,
            'tpl' => static::returnTpl('admin/'.self::$entity),
            'gtpl' => static::returnTpl(),

            'entity' => self::$entity,
            'entity_name' => self::$entity_name,
        );

        View::share('module', $this->module);
	}

	public function index(){

        ##
        ## Получение значения записи из словаря по SLUG
        ##
        #$a = Dictionary::whereSlug('request_statuses')->value('new')->first();
        #Helper::tad($a);

        Allow::permission($this->module['group'], $this->module['entity'].'_edit');

		$elements = $this->essence
            ->orderBy('created_at', 'DESC')
            ->with('status');
        if (Input::get('status'))
            $elements = $elements->where('status_id', Input::get('status'));
        $elements = $elements->paginate( Config::get('site.paginate_limit') );

        #Helper::tad($elements);

		return View::make($this->module['tpl'].'index', compact('elements'));
	}

    /************************************************************************************/

	public function create(){

        Allow::permission($this->module['group'], $this->module['entity'].'_edit');

        $element = new $this->essence;
		return View::make($this->module['tpl'].'edit', compact('element'));
	}
    

	public function edit($id){

        Allow::permission($this->module['group'], $this->module['entity'].'_edit');
		
		$element = $this->essence->find($id);
		return View::make($this->module['tpl'].'edit', compact('element'));
	}

    /************************************************************************************/

	public function store() {

		return $this->postSave();
	}


	public function update($id) {

		return $this->postSave($id);
	}


	public function postSave($id = false){

        Allow::permission($this->module['group'], $this->module['entity'].'_edit');

		if(!Request::ajax())
            return App::abort(404);

        #$id = Input::get('id');

        #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        #$json_request['responseText'] = "<pre>" . print_r($id, 1) . "</pre>";
        #return Response::json($json_request,200);

        $input = array(
            'type' => Input::get('type'),
            'content' => Input::get('content'),
            'status_id' => Input::get('status_id'),
        );
        $status = Input::get('status_id');

		$json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE);
		$validator = Validator::make($input, $this->essence->rules());
		if($validator->passes()) {

            $redirect = Input::get('redirect');

            if ($id > 0) {

                $element = $this->essence->where('id', $id)->with('status')->first();

                #Helper::tad($element);

                if ($element->exists()) {
    
        		    #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        		    #return Response::json($json_request,200);

                    $element->update($input);

                    if ($status && $element->status->status_id != $status) {
                        UserRequestStatus::create(
                            array(
                                'request_id' => $id,
                                'status_id' => $status,
                            )
                        );

                        /**
                         * @TODO Отправка сообщения пользователю
                         */

                    }
                }

            } else {

                $status_new = Dictionary::whereSlug('request_statuses')->value('new')->first()->id;
                $input['status_id'] = $status_new;

                $element = $this->essence->create($input);
                $id = $element->id;

                UserRequestStatus::create(
                    array(
                        'request_id' => $id,
                        'status_id' => $status_new,
                    )
                );

            }

			$json_request['responseText'] = 'Сохранено';
            if ($redirect)
			    $json_request['redirect'] = $redirect;
			$json_request['status'] = TRUE;
		} else {
			$json_request['responseText'] = 'Неверно заполнены поля';
			$json_request['responseErrorText'] = $validator->messages()->all();
		}
		return Response::json($json_request, 200);
	}

    /************************************************************************************/

	public function destroy($id){

        Allow::permission($this->module['group'], $this->module['entity'].'_edit');

		if(!Request::ajax())
            return App::abort(404);

		$json_request = array('status'=>FALSE, 'responseText'=>'');

        if ($this->essence->find($id)->exists())
	       $this->essence->find($id)->delete();

		$json_request['responseText'] = 'Удалено';
		$json_request['status'] = TRUE;
		return Response::json($json_request,200);
	}

}


