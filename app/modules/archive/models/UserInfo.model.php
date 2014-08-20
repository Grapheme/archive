<?php

class UserInfo extends BaseModel {

	protected $guarded = array();

	protected $table = 'user_info';

	#public static $order_by = "name ASC";

	public static $rules = array(
        'type' => 'required',
        'content' => 'required',
	);

    public function requests() {
        return $this->hasMany('UserRequest', 'user_id', 'id')->orderBy('created_at', 'DESC');
    }

}