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

        $password = false;

        $email = trim(Input::get('email'));
        if (!$email)
            return Response::make('invalid email', 400);

        ## Find user by email
        $user = UserInfo::firstOrCreate(array('email' => $email));

        ## Set password if it's is null
        if (!$user->password) {
            $password = mb_substr(md5(time() + rand(9999, 99999)), 0, 8);
            $user->password = Hash::make($password);
        }
        if (!$user->name && Input::get('name'))
            $user->name = Input::get('name');

        $user->save();

        ## Request info
        $input = array(
            'user_id' => $user->id,
            'type' => Input::get('type'),
            'content' => Input::get('content'),
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

        return Response::make('1', 200);
	}


    public function postGetFundsData() {

        #Helper::dd(Input::all());

        $json_request = array('status' => FALSE, 'responseText' => '');

        $search = false;
        $records = ArchiveFund::take(50)
            ->orderBy('name', 'ASC')
            ->where('name', '!=', '')
            ->where('date_start', '!=', '0000-00-00')
            ->where('date_stop', '!=', '0000-00-00')
        ;

        if ($filter = Input::get('filter')) {
            $records = $records->where('name', 'LIKE', '%' . $filter . '%');
            $search = true;
        }
        if ($start = Input::get('start')) {
            $records = $records->where('date_start', '<=', $start);
            $search = true;
        }
        if ($stop = Input::get('stop')) {
            $records = $records->where('date_stop', '>=', $stop);
            $search = true;
        }

        if (!$search)
            return Response::json($json_request, 200);

        $records = $records->get();

        $json_request['funds'] = $records->toJson();
        $json_request['status'] = TRUE;

        #Helper::tad($records);
        return Response::json($json_request, 200);

    }

}


