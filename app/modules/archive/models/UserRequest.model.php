<?php

class UserRequest extends BaseModel {

	protected $guarded = array();

	protected $table = 'user_request';

	public static $order_by = "name ASC";

	public static $rules = array(
        'type' => 'required',
        'content' => 'required',
	);

    public function statuses() {
        return $this->hasMany('UserRequestStatus', 'request_id', 'id')->orderBy('created_at', 'DESC');
    }

    /*
    public function status() {
        return $this->hasOne('UserRequestStatus', 'request_id', 'id')->orderBy('created_at', 'DESC');
    }
    */

    public function status() {
        return $this->belongsTo('DicVal', 'status_id', 'id');
    }
}