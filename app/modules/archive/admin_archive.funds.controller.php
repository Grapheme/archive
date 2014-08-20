<?php

class AdminArchiveFundsController extends BaseController {

    public static $name = 'archive_funds';
    public static $group = 'archive';
    public static $entity = 'funds';
    public static $entity_name = 'запись';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        $entity = self::$entity;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class, $entity) {
        	Route::resource($class::$group."/".$entity, $class,
                array(
                    'except' => array('show'),
                    'names' => array(
                        #'show'    => $entity.'.show',
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
    
	public function __construct(ArchiveFund $essence){

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
            ->select('*', DB::raw('LENGTH(fund_number) lfn'))
            ->orderBy('lfn')->orderBy('fund_number')
        ;

        if (Input::get('parsed') != '')
            $elements = $elements->where('parsed', Input::get('parsed'));

        if (Input::get('fund') != '')
            $elements = $elements->where(DB::raw('fund_number*1'), Input::get('fund'));

        if (Input::get('date_start') != '')
            $elements = $elements->where('date_start', '<=', DateTime::createFromFormat('m.Y', Input::get('date_start'))->format('Y-m-01'));

        if (Input::get('date_stop') != '')
            $elements = $elements->where('date_stop', '>=', DateTime::createFromFormat('m.Y', Input::get('date_stop'))->format('Y-m-01'));

        if (Input::get('search') != '')
            $elements = $elements->where('name', 'LIKE', '%' . Input::get('search') . '%');

        $elements = $elements->paginate( Config::get('site.paginate_limit') )->appends($_GET);

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
            App::abort(404);

        #$id = Input::get('id');

        #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        #$json_request['responseText'] = "<pre>" . print_r(date_parse_from_format('mm.yyyy', $input['date_start']), 1) . "</pre>";
        #return Response::json($json_request,200);

        $input = Input::all();
        /*
        $json_request['responseText'] = "<pre>" . print_r(
                DateTime::createFromFormat('m.Y', $input['date_start'])->format('Y-m')
                , 1) . "</pre>";
        return Response::json($json_request,200);
        */
        $input['date_start'] = $input['date_start'] ? DateTime::createFromFormat('m.Y', $input['date_start'])->format('Y-m-01') : null;
        $input['date_stop'] = $input['date_stop'] ? DateTime::createFromFormat('m.Y', $input['date_stop'])->format('Y-m-01') : null;

		$json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE);
		$validator = Validator::make($input, $this->essence->rules());
		if($validator->passes()) {

            $redirect = false;

            if ($id > 0) {

                $element = $this->essence->where('id', $id)->first();

                #Helper::tad($element);

                if ($element->exists()) {
    
        		    #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        		    #return Response::json($json_request,200);

                    $element->update($input);
                }

            } else {

                $element = $this->essence->create($input);
                $id = $element->id;
                $redirect = URL::route($this->module['entity'].'.index', array(), null);

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
            App::abort(404);

		$json_request = array('status'=>FALSE, 'responseText'=>'');

        if ($this->essence->find($id)->exists())
	       $this->essence->find($id)->delete();

		$json_request['responseText'] = 'Удалено';
		$json_request['status'] = TRUE;
		return Response::json($json_request,200);
	}

}


