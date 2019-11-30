<?php

namespace Wpai\Http;


class Router
{
    public function route($route, $secure = true)
    {
        $container = new \Wpai\Di\WpaiDi(array());

        $request = new Request(file_get_contents('php://input'));

        $q = $route;
        $routeParts = explode('/', $q);
        if($secure){
            $controller = 'Wpai\\App\\Controller\\'.ucwords($routeParts[0]).'Controller';
        } else {
            $controller = 'Wpai\\App\\UnsecuredController\\'.ucwords($routeParts[0]).'Controller';
        }
        $action = ucwords($routeParts[1]).'Action';

        $controller = new $controller($container);
        $response = $controller->$action($request);

        if(!$response instanceof \Wpai\Http\Response) {
            throw new \Exception('The controller must return an HttpResponse instance.');
        }

        $response->render();
    }
}