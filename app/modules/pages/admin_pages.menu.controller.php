<?php

class AdminPagesMenuController extends BaseController {

    public static $name = 'pages';
    public static $group = 'pages';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
    }

    ## Shortcodes of module
    public static function returnShortCodes() {
    }

    ## Actions of module (for distribution rights of users)
    public static function returnActions() {
        return array(
            'view'   => 'Просмотр',
            'create' => 'Создание',
            'edit'   => 'Редактирование',
            'delete' => 'Удаление',
        );
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        return array(
        	'name' => self::$name,
        	'group' => self::$group,
        	'title' => 'Страницы',
            'visible' => 1,
        );
    }

    ## Menu elements of the module
    public static function returnMenu() {
        return array(
            array(
            	'title' => 'Страницы',
                'link' => self::$group,
                'class' => 'fa-list-alt', 
                'permit' => 'view',
            ),
        );
    }

    /****************************************************************************/

}