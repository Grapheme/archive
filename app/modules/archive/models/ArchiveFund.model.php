<?php

class ArchiveFund extends BaseModel {

	protected $guarded = array();

	protected $table = 'archive_funds';

	public static $order_by = "name ASC";

	public static $rules = array(
        'fund_number' => 'required',
        'name' => 'required',
	);

}