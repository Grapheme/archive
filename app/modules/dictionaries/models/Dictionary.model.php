<?php

class Dictionary extends BaseModel {

	protected $guarded = array();

    public $table = 'dictionary';
    public $timestamps = false;

	public static $order_by = "name ASC";

	public static $rules = array(
		'name' => 'required',
	);

    #public static function rules() {
    #    return self::$rules;
    #}

    public function values() {
        return $this->hasMany('DicVal', 'dic_id', 'id')->orderBy('order', 'ASC')->orderBy('slug', 'ASC')->orderBy('name', 'ASC')->orderBy('id', 'ASC');
    }

    public function value() {
        return $this->hasOne('DicVal', 'dic_id', 'id');
    }

    public function valueBySlug($slug) {
        return $this
            ->with(array('value' => function($query) use ($slug) {
                    $query->whereSlug($slug);
                }))->first()->value;
    }


}

class Dic extends Dictionary {
    ## Alias
}