<?php
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/start.php';

echo __DIR__.'/../bootstrap/start.php';

$routes = Route::getRoutes();
foreach($routes as $route) {
    echo URL::to($route->getPath()) . " <br/>\n";
}

echo '!';