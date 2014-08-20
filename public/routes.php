<?php

#echo realpath(__DIR__.'/../bootstrap/autoload.php') . "<br/>\n";

require __DIR__.'/../bootstrap/autoload.php';

#echo realpath(__DIR__.'/../bootstrap/start.php') . "<br/>\n";

$app = require_once __DIR__.'/../bootstrap/start.php';

$app->run();

$routes = Route::getRoutes();

#echo URL::to("!!!");

#Helper::dd( URL::current() );

#Helper::dd( $app );

#$app['path.base'] = '/archive/';

#Helper::dd($routes);

#Helper::dd( $app->request->root() );

foreach($routes as $route) {
    echo URL::to($route->getPath()) . " <br/>\n";
}

die;

#echo '!!';

#phpinfo();