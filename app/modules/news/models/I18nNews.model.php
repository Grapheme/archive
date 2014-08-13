<?php

class I18nNews extends BaseModel {

	protected $guarded = array();

	protected $table = 'i18n_news';

	public static $order_by = "i18n_news.published_at DESC,i18n_news.id DESC";

	public static $rules = array(
		#'news_ver_id' => 'required',
		#'seo_url' => 'alpha_dash',
	);

    public function metas() {
        return $this->hasMany('I18nNewsMeta', 'news_id', 'id');
    }

    public function meta() {
        return $this->hasOne('I18nNewsMeta', 'news_id', 'id')->where('language', Config::get('app.locale', 'ru'));
    }
}