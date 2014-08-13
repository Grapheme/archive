<?php

class UserRequestStatus extends BaseModel {

	protected $guarded = array();

	protected $table = 'user_request_status';

	public static $order_by = "name ASC";

	public static $rules = array(
        'request_id' => 'required',
        #'content' => 'required',
	);

    public function status() {
        return $this->belongsTo('DicVal', 'status_id', 'id');
    }
}