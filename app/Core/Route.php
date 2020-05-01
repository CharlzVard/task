<?php

namespace App\Core;

class Route
{
	static function start()
	{
		$appfolder = dirname(__DIR__, 1) . "/";

		$controller_name = 'Task';
		$action_name = 'index';

		$url = explode('?', $_SERVER['REQUEST_URI']);
		$routes = explode('/', $url[0]);

		if (!empty($routes[1])) {
			$controller_name = ucfirst($routes[1]);
		}

		if (!empty($routes[2])) {
			$action_name = $routes[2];
		}

		$model_name = $controller_name;
		$controller_name = $controller_name . 'Controller';

		$model_file = $model_name . '.php';
		$model_path = $appfolder . $model_file;
		if (file_exists($model_path)) {
			include $appfolder . $model_file;
		}


		$controller_file = $controller_name . '.php';
		$controller_path = $appfolder . "Controllers/" . $controller_file;

		if (file_exists($controller_path)) {
			include $appfolder . "Controllers/" . $controller_file;
		} else {
			return Route::ErrorPage404("Контроллер не найден");
		}
		$controller_namespace_name = 'App\\Controllers\\' . $controller_name;

		$controller = new $controller_namespace_name();
		$action = $action_name;

		if (method_exists($controller, $action)) {
			$params = [];
			if (isset($url[1])) parse_str($url[1], $params);
			$controller->$action($params);
		} else {
			return Route::ErrorPage404("Экшн не найден");
		}
	}

	static function ErrorPage404($e)
	{
		// $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		// // header('HTTP/1.1 404 Not Found');
		// // header("Status: 404 Not Found");
		// // header('Location:' . $host . '404');
		// // PHP program to describes header function 
		echo $e;
	}
}
