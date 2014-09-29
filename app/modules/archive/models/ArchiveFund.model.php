<?php

class ArchiveFund extends BaseModel {

	protected $guarded = array();

	protected $table = 'archive_funds';

	public static $order_by = "name ASC";

	public static $rules = array(
        'fund_number' => 'required',
        'name' => 'required',
	);


    public function current() {
        return $this->hasOne('ArchiveFund', 'id', 'current_company_id');
    }

    public function olds() {
        return $this->hasMany('ArchiveFund', 'current_company_id', 'id')->where('current_company_id', '!=', NULL)->orderBy('date_start', 'DESC');
    }

}