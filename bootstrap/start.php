<?php

$app = new Illuminate\Foundation\Application;
$env = $app->detectEnvironment(array(
	'az' => array('Acer_5742G'),
	#'production' => array('www.grapheme.ru'),
));
$app->bindInstallPaths(require __DIR__.'/paths.php');
$framework = $app['path.base'].'/vendor/laravel/framework/src';
require $framework.'/Illuminate/Foundation/start.php';
return $app;