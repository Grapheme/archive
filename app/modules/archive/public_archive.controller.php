<?php

class PublicArchiveController extends BaseController {

    public static $name = 'archive_public';
    public static $group = 'archive';
    public static $entity = 'request';
    public static $entity_name = 'запрос';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        $entity = self::$entity;
        /*
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
        */
        Route::post('/ajax/send-request', array('as' => 'send-user-request', 'uses' => __CLASS__.'@postSendUserRequest'));
        Route::post('/ajax/funds-data', array('as' => 'ajax-get-funds-data', 'uses' => __CLASS__.'@postGetFundsData'));

        Route::any('/log-in', array('as' => 'log-in', 'uses' => __CLASS__.'@anyLogin'));
        Route::any('/log-out', array('as' => 'log-out', 'uses' => __CLASS__.'@postLogout'));
        Route::get('/status', array('as' => 'status', 'uses' => __CLASS__.'@getStatus'));

        #Route::get('/feedback', array('as' => 'feedback', 'uses' => __CLASS__.'@getFeedback'));
        Route::post('/ajax/send-feedback', array('as' => 'ajax-send-feedback', 'uses' => __CLASS__.'@postAjaxSendFeedback'));


        Route::get('/sphinxtest', array('as' => 'sphinxtest', 'uses' => __CLASS__.'@getSphinxtest'));
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

	public function postSendUserRequest(){

        if(!Request::ajax())
            App::abort(404);

        $json_request = array('status' => FALSE, 'responseText' => '');

        $password = false;

        $email = trim(Input::get('email'));
        $name = trim(Input::get('name'));

        if ($email == '' && $name == '') {
            $json_request['responseText'] = 'invalid email and name';
            #$json_request['status'] = TRUE;
            return Response::json($json_request, 200);
        }

        ## Find user by email
        if ($email != '')
            $user = UserInfo::firstOrCreate(array('email' => $email));
        elseif ($name != '') {
            $json_request['login'] = $name;
            $user = UserInfo::firstOrCreate(array('name' => $name));
        }

        ## Set password if it's is null
        if (!$user->password) {
            $password = mb_substr(md5(time() + rand(9999, 99999)), 0, 8);
            $user->password = Hash::make($password);
        }
        if (!$user->name && $name)
            $user->name = $name;

        $user->save();

        ## Request info
        $input = array(
            'user_id' => $user->id,
            'type' => Input::get('type'),
            'content' => Input::get('content'),
            'postal' => Input::get('postal'),
            #'status_id' => Dic::valueBySlugs('request_types', 'new')->id,
        );
        #Helper::dd($input);

        ## Find or create request
        $request = UserRequest::firstOrNew($input);
        if (!$request->status_id) {

            ## NEW status of request
            $status_new = Dic::valueBySlugs('request_types', 'new')->id;

            ## If new request
            $request->status_id = $status_new;

            ## Upload file_passport
            if (Input::hasFile('file_passport')) {
                $file = Input::file('file_passport');
                $filename = time() . "_" . rand(1000, 1999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Config::get('app-default.upload_dir')), $filename);
                $request->file_passport = Config::get('app-default.upload_dir') . '/' . $filename;
            }

            ## Upload file_workbook
            if (Input::hasFile('file_workbook')) {
                $file = Input::file('file_workbook');
                $filename = time() . "_" . rand(1000, 1999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Config::get('app-default.upload_dir')), $filename);
                $request->file_workbook = Config::get('app-default.upload_dir') . '/' . $filename;
            }

            ## Upload file
            if (Input::hasFile('file')) {
                $file = Input::file('file');
                $filename = time() . "_" . rand(1000, 1999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Config::get('app-default.upload_dir')), $filename);
                $request->file = Config::get('app-default.upload_dir') . '/' . $filename;
            }

            #Helper::tad($request);

            ## Save request
            $request->save();

            ## Add first default request status - NEW
            UserRequestStatus::create(array(
                'request_id' => $request->id,
                'status_id' => $status_new,
            ));

            ## Send confirmation to user - with password
            if ($user->email) {
                $data = array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => @$password ? $password : NULL,
                );
                Mail::send('emails.request_send', $data, function ($message) use ($user) {
                    $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                    $message->subject('Запрос успешно отправлен');
                    $message->to($user->email);
                });
            }
        }

        $json_request['password'] = $password;
        $json_request['status'] = TRUE;
        return Response::json($json_request, 200);
	}


    public function getSphinxtest() {
        $results_funds = SphinxSearch::search('област', 'archive_funds_index')->query();
        echo '<pre>' . print_r($results_funds, 1) . '</pre>';
        die;
    }

    public function postGetFundsData() {

        #Helper::dd(Input::all());

        $json_request = array('status' => FALSE, 'responseText' => '');

        $search = false;
        $limit = 100;
        $funds_ids = array();

        $records = ArchiveFund::orderBy('name', 'ASC')
            ->with('olds')
            ->where('name', '!=', '')
            ->where('date_start', '!=', '0000-00-00')
            ->where('date_stop', '!=', '0000-00-00')
        ;
        /*
        if ($filter = Input::get('filter')) {
            $records = $records->where('name', 'LIKE', '%' . $filter . '%');
            $search = true;
        }
        */
        ## Если задана маска для поиска по названию компании - ищем сфинксом
        if ($filter = Input::get('filter')) {
            ## SPHINX
            $results_funds = SphinxSearch::search($filter, 'archive_funds_index')->query();
            #Helper::dd($results_funds);
            if (isset($results_funds['matches'])) {
                $funds_ids = array_keys($results_funds['matches']);
                #Helper:dd($funds_ids);
                $records = $records->whereIn('id', $funds_ids);
            } else {
                $records = $records->where('id', 0);
            }
        }
        if ($start = Input::get('start')) {
            #$records = $records->where('date_start', '<=', $start);
            $records = $records->where('date_stop', '>=', $start);
            $search = true;
        }
        if ($stop = Input::get('stop')) {
            #$records = $records->where('date_stop', '>=', $stop);
            $records = $records->where('date_start', '<=', $stop);
            $search = true;
        }

        #if (!$search)
        #    return Response::json($json_request, 200);

        if (!$search)
            $records = $records->take($limit);

        $records = $records->get();

        $json_request['funds'] = $records->toJson();
        $json_request['status'] = TRUE;

        #Helper::tad($records);
        return Response::json($json_request, 200);

    }

    public function anyLogin() {

        $json_request = array('status' => FALSE, 'responseText' => '');

        $auth = Session::get('auth');

        #Helper::dd($auth);

        if (Request::method() == 'POST') {

            if ($auth) {
                #return Redirect::route('status');
                $json_request['redirect'] = URL::route('status');
                $json_request['status'] = TRUE;
                return Response::json($json_request, 200);
            }

            $email = Input::get('email');
            $password = Input::get('password');

            #$user_info = UserInfo::firstOrNew(array('email' => $email));
            $user_info = UserInfo::where('email', $email)->first();

            if (!is_object($user_info))
                $user_info = UserInfo::firstOrNew(array('name' => $email));

            if ($user_info->password && $user_info->id) {

                if (Hash::check($password, $user_info->password)) {
                    $auth = true;
                    Session::set('auth', $user_info->id);
                    Helper::cookie_set('auth_name', $email, 60*60*24*30);
                    #return Redirect::route('status');
                    $json_request['redirect'] = URL::route('status');
                    $json_request['status'] = TRUE;
                }

            }

            if (!$auth) {
                $error = "Неверный логин или пароль";
                $json_request['responseText'] = $error;
                #return View::make(Helper::layout('login'), compact('email', 'error'));
            }

            return Response::json($json_request, 200);

        } elseif (Request::method() == 'GET') {

            if ($auth)
                return Redirect::route('status');
            else
                return View::make(Helper::layout('login'), compact('null'));
        }
    }

    public function postLogout() {
        Session::set('auth', false);
        return Redirect::route('log-in');
    }

    public function getStatus() {

        $auth = Session::get('auth');

        $user = UserInfo::find($auth);

        if (!$auth || !$user) {
            Session::set('auth', false);
            return Redirect::route('log-in');
        }

        $requests = UserRequest::where('user_id', $auth)
            ->with('status')
            ->orderBy('created_at', 'DESC')
            ->take(50)
            ->get();

        #Helper::tad($requests);

        return View::make(Helper::layout('status'), compact('requests', 'user'));
    }

    /*
    public function getFeedback() {

        return View::make(Helper::layout('feedback'), compact('null'));
    }
    */

    public function postAjaxSendFeedback() {

        #Helper::dd(Input::all());

        $json_request = array('status' => FALSE, 'responseText' => '');

        ## Send confirmation to user - with password
        $data = array(
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'content' => Input::get('message'),
        );
        Mail::send('emails.feedback', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['name']);
            $message->subject('Сообщение от ' . $data['name']);
            $message->to(Config::get('mail.feedback.address'));
        });

        $json_request['responseText'] = 'Сообщение успешно отправлено.';
        $json_request['status'] = TRUE;

        #Helper::tad($records);
        return Response::json($json_request, 200);
    }
}


