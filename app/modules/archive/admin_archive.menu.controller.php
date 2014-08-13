<?php

class AdminArchiveMenuController extends BaseController {

    public static $name = 'archive';
    public static $group = 'archive';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        ##
    }

    ## Shortcodes of module
    public static function returnShortCodes() {
        ##
    }
    
    ## Actions of module (for distribution rights of users)
    public static function returnActions() {
        return array(
        	'view'              => 'Отображать в меню',
            'request_edit'      => 'Работа с запросами',
            'request_create'    => 'Создание запросов',
            'funds_edit'        => 'Работа с фондами',
        );
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        return array(
        	'name' => self::$name,
        	'group' => self::$group,
            'title' => 'Архив',
            'visible' => '1',
        );
    }


    public static function returnMenu() {

        ## Without child links
        return array(
            array(
                'title' => 'Запросы',
                'link' => self::$group . "/request",
                'class' => 'fa-comments',
                'permit' => 'request_edit',
            ),
            array(
                'title' => 'Фонды',
                'link' => self::$group . "/funds",
                'class' => 'fa-university',
                'permit' => 'funds_edit',
            ),
        );
        #*/
    }
        
    /****************************************************************************/
    
	public function __construct(){
        ##
	}
}


