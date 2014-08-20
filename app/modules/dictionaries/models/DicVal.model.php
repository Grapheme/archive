<?php

class DicVal extends BaseModel {

	protected $guarded = array();

	public $table = 'dictionary_values';
    public $timestamps = false;

	public static $order_by = "name ASC";

	public static $rules = array(
		'name' => 'required',
	);

    #public static function rules() {
    #    return self::$rules;
    #}

    public function dic() {
        return $this->belongsTo('Dictionary', 'dic_id')->orderBy('name');
    }


}