<?php

class PublicPagesController extends BaseController {

    public static $name = 'pages_public';
    public static $group = 'pages';

    /****************************************************************************/
    /**
     * @author Alexander Zelensky
     * @todo Возможно, в будущем здесь нужно будет добавить проверку параметра, использовать ли вообще мультиязычность по сегментам урла, или нет. Например, удобно будет отключить мультиязычность по сегментам при использовании разных доменных имен для каждой языковой версии.
     */
    public static function returnRoutes($prefix = null) {
        
        #Helper::dd(I18nPage::count());

        /**
         * Laravel не дает возможности переписывать пути (роуты), если они были зарегистрированы ранее.
         * А это значит, что если данный модуль активен и в нем создана хоть одна страница, то будет переписан корневой путь: /
         * Это не даст в будущем добавлять роуты от корня с помощью метода Route::controller('', '..@..'), придется все прописывать руками.
         * Надо бы подключать модуль страниц последним
         * [
         *     '/login' => Route object to /login,
         *     '{_missing}' => Fallthrough route object,
         *     '/' => Route object to /,
         * ]
         * Описание данной ситуации здесь:
         * http://stackoverflow.com/questions/20617244/laravel-4-1-controller-method-not-found?rq=1
         * https://github.com/laravel/framework/issues/2848
         * https://github.com/laravel/framework/pull/2850
         * https://github.com/laravel/framework/issues/2863
         * https://github.com/bencorlett/framework/pull/1
         * https://github.com/bencorlett/framework/commit/ac091a25465d070f8925a80b46eb237ef21ea912
         */
        if (!Allow::module(self::$group) || !Page::count())
            return false;

        ## УРЛЫ С ЯЗЫКОВЫМИ ПРЕФИКСАМИ ДОЛЖНЫ ИДТИ ПЕРЕД ОБЫЧНЫМИ!
        ## Если в конфиге прописано несколько языковых версий...
        if (is_array(Config::get('app.locales')) && count(Config::get('app.locales')) > 1) {
            ## Для каждого из языков...
            foreach(Config::get('app.locales') as $locale_sign => $locale_name) {
            	## ...генерим роуты с префиксом (первый сегмент), который будет указывать на текущую локаль.
            	## Также указываем before-фильтр i18n_url, для выставления текущей локали.
                Route::group(array('before' => 'i18n_url', 'prefix' => $locale_sign), function(){
                    Route::any('/{url}', array('as' => 'page',     'uses' => __CLASS__.'@showPage')); ## Show Page
                    Route::any('/',      array('as' => 'mainpage', 'uses' => __CLASS__.'@showPage')); ## Show Main Page
                });
            }
        }

        ## Генерим роуты без префикса, и назначаем before-фильтр i18n_url.
        ## Это позволяет нам делать редирект на урл с префиксом только для этих роутов, не затрагивая, например, /admin и /login
        Route::group(array('before' => 'i18n_url'), function(){
            Route::any('/{url}', array('as' => 'page', 'uses' => __CLASS__.'@showPage')); ## Show Page
            Route::any('/', array('as' => 'mainpage', 'uses' => __CLASS__.'@showPage')); ## Show Main Page
        });
    }
    
    ## Shortcodes of module
    public static function returnShortCodes() {
        /**
         * @todo Сделать шорткод для страниц (вставка страницы внутрь другой страницы, OMG). Да и нужно ли.. Уточнить у Андрея
         */
        #$tpl = static::returnTpl();
    	#shortcode::add("page",
        #    function($params = null) use ($tpl) {},
        #    function($params = null) use ($tpl) {},
        #);
    }

    ## Actions of module (for distribution rights of users)
    public static function returnActions() {
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
    }

    /****************************************************************************/

	public function __construct(Page $page, PageMeta $page_meta, PageBlock $page_block, PageBlockMeta $page_block_meta){

        $this->page = $page;
        $this->page_meta = $page_meta;
        $this->page_block = $page_block;
        $this->page_block_meta = $page_block_meta;
        $this->locales = Config::get('app.locales');

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            #'rest' => self::$group,
            'tpl' => static::returnTpl('admin'),
            'gtpl' => static::returnTpl(),
            'class' => __CLASS__,

            #'entity' => self::$entity,
            #'entity_name' => self::$entity_name,
        );
        View::share('module', $this->module);
	}

    ## Функция для просмотра мультиязычной страницы
    public function showPage($url = false){

        if (!$this->page->count())
            return View::make(Config::get('app.welcome_page_tpl'));

        if (!$url)
            $url = Input::get('url');

        /*
        ## Страница /de упорно не хотела открываться, пытаясь найти страницу со slug = "de", пришлось сделать вот такой хак:
        if ($url == Config::get('app.locale'))
            $url = '';
        */

        #if ( @$this->locales[Request::segment(1)] )
        #    $url = '';

        #Helper::dd($url);
        #Helper::dd( Request::segment(1) );

        $page = $this->page->where('publication', 1);

        ## Page by ID
        if (is_numeric($url)) {

            $slug = false;
            $page = $page->where('id', $url);
            $page = $page
                ->with('meta.seo', 'blocks.meta')
                ->first();

            #Helper::tad($page);

            if (@is_object($page)) {

                if (@is_object($page->meta) && @is_object($page->meta->seo)) {
                    $slug = $page->meta->seo->url;
                } else {
                    $slug = $page->slug;
                }

                #$slug = false;
                #Helper::dd($slug);

                if ($slug) {
                    $redirect = URL::route('page', array('url' => $slug));
                    #Helper::dd('from is_numeric check' . $redirect);
                    return Redirect::to($redirect, 301);
                }
            }

        } elseif ($url != '') {

            ## Page by SLUG

            ## Search slug in SEO URL
            $page_meta_seo = Seo::where('module', 'page_meta')->where('url', $url)->first();
            #Helper::tad($page_meta_seo);
            if (is_object($page_meta_seo) && is_numeric($page_meta_seo->unit_id)) {

                $page = $this->page_meta
                    ->where('id', $page_meta_seo->unit_id)
                    ->with('page.meta.seo', 'page.blocks.meta')
                    ->first()
                    ->page;
                #Helper::tad($page);

                /*
                ## Check SEO url & gettin' $url
                ## and make 301 redirect if need it
                if (@is_object($page->meta) && @is_object($page->meta->seo) && $page->meta->seo->url != '' && $page->meta->seo->url != $url) {
                    $redirect = URL::route('page', array('url' => $page->meta->seo->url));
                    #Helper::dd($redirect);
                    return Redirect::to($redirect, 301);
                }
                */

            } else {

                ## Search slug in SLUG
                $page = $this->page
                    ->where('slug', $url)
                    ->with('meta.seo')
                    ->with('blocks.meta')
                    ->first();
                #Helper::tad($page);

                /*
                ## Check SEO url & gettin' $url
                ## and make 301 redirect if need it
                if (@is_object($page->meta) && @is_object($page->meta->seo) && $page->meta->seo->url != '' && $page->meta->seo->url != $url) {
                    $redirect = URL::route('page', array('url' => $page->meta->seo->url));
                    #Helper::dd($redirect);
                    return Redirect::to($redirect, 301);
                }
                */
            }

            ## Check SEO url & gettin' $url
            ## and make 301 redirect if need it
            if (@is_object($page->meta) && @is_object($page->meta->seo) && $page->meta->seo->url != '' && $page->meta->seo->url != $url) {
                $redirect = URL::route('page', array('url' => $page->meta->seo->url));
                #Helper::dd($redirect);
                return Redirect::to($redirect, 301);
            }

        } else {
            $page = $page->where('start_page', 1)->first();
        }

        #Helper::tad($page);

        if (!@is_object($page))
            App::abort(404);

        if ($page->start_page && $url != '') {
            $redirect = URL::route('mainpage');
            #Helper::dd('to mainpage: ' . $redirect);
            return Redirect::to($redirect, 301);
        }

        if (!$page->template)
            $page->template = 'default';

        if(empty($page->template) || !View::exists($this->module['gtpl'].$page->template))
            throw new Exception('Template [' . $this->module['gtpl'].$page->template . '] not found.');

        #Helper::dd($page);
        #Helper::dd($page->blocks['pervyy_blok']->meta->content);

        ## Рендерим контент всех блоков - обрабатываем шорткоды
        if (is_object($page->blocks) && $page->blocks->count()) {

            $page = $page->blocksBySlug();

            foreach ($page->blocks as $b => $block) {
                if (is_object($block) && is_object($block->meta)) {
                    #Helper::dd($block->meta);
                    if ($block->meta->content != '') {
                        #$block->meta->content = self::content_render($meta->content);
                        $page->blocks[$b]->meta->content = self::content_render($block->meta->content);
                    }
                }
            }
        }

        #Helper::tad($page);

        return View::make($this->module['gtpl'].$page->template, compact('page'));






        /*
        ## Если текущая страница - главная, и по какой-то необъяснимой причине у нее задан SLUG - обязательно редиректом юзера на главную страницу для его локали, чтобы не было дублей контента
        if (isset($page->slug) && $page->slug != '' && $page->slug == $url && $page->start_page == 1) {
        	## А чтобы ссылка на главную страницу была правильной - делаем вот такую штуку
        	## Вся соль в том, что если в данный момент текущая локаль - дефолтная, то в slink::createLink() нужно передавать пустую строку. Дефолтная локаль устанавливается равной той же, что и 'app.locale', в файле filters.php
        	$str = Config::get('app.default_locale') == Config::get('app.locale') ? "" : Config::get('app.locale');
	    	Redirect(link::to($str));
        }
		$content = self::content_render($page_meta->content);
		return View::make(
		    $this->tpl.$page->template,
		    array(
		        'page_title' => $page_meta->seo_title,
		        'page_description' => $page_meta->seo_description,
				'page_keywords' => $page_meta->seo_keywords,
				'page_author' => '',
				'page_h1' => $page_meta->seo_h1,
				'menu' => I18nPage::getMenu($page->template),
				'content' => $content
			)
        );
        */
	}
    

	public static function content_render($page_content, $page_data = NULL){

		$regs = $change = $to = array();
		preg_match_all('~\[([^\]]+?)\]~', $page_content, $matches);

        #dd($page_content);
        #dd($matches);

		for($j=0; $j<count($matches[0]); $j++) {
			$regs[trim($matches[0][$j])] = trim($matches[1][$j]);
		}
        
        #dd($regs);
        
		if(!empty($regs)) {
			foreach($regs as $tochange => $clear):
                
                #echo "$tochange => $clear"; die;
                
				if(!empty($clear)):
					$change[] = $tochange;
					$tag = explode(' ', $clear);

                    #dd($tag);
                    
					if(isset($tag[0]) && $tag[0] == 'view') {
						$to[] = self::shortcode($clear, $page_data);
					} else {
						$to[] = self::shortcode($clear);
					}
				endif;
			endforeach;
		}
        
        #dd($change);
        
		return str_replace($change, $to, $page_content);
	}

	private static function shortcode($clear, $data = NULL){

        ## $clear - строка шорткода без квадратных скобок []
        #dd($clear);

		$str = explode(" ", $clear);
		#$type = $str[0]; ## name of shortcode
        $type = array_shift($str);
		$options = NULL;
		if(count($str)) {
			#for($i=1; $i<count($str); $i++) {
            foreach ($str as $expr) {
                if (!strpos($expr, "="))
                    continue;
				#preg_match_all("~([^\=]+?)=['\"]([^'\"\s\t\r\n]+?)['\"]~", $str[$i], $rendered);
                #dd($rendered);
                list($key, $value) = explode("=", $expr);
                $key = trim($key);
                $value = trim($value, "'\"");
				if($key != '' && $value != '') {
					$options[$key] = $value;
				}
			}
		}

        #dd($type);
        #dd($options);

		return shortcode::run($type, $options);
	}

}