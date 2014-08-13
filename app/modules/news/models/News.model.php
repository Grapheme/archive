<?php

class News extends BaseModel {

	protected $guarded = array();

	protected $table = 'news';

	public static $order_by = "news.published_at DESC,news.id DESC";

	public static $rules = array(
		#'news_ver_id' => 'required',
		#'seo_url' => 'alpha_dash',
	);

    public function metas() {
        return $this->hasMany('NewsMeta', 'news_id', 'id');
    }

    public function meta() {
        return $this->hasOne('NewsMeta', 'news_id', 'id')->where('language', Config::get('app.locale', 'ru'));
    }
}