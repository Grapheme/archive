<?php

class PageMeta extends BaseModel {

	protected $guarded = array();

	protected $table = 'pages_meta';

	public static $rules = array(
		#'title' => 'required',
		#'seo_url' => 'alpha_dash',
	);

}