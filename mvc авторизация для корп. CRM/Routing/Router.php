<?php

namespace Routing;

use View\View;

class Router
{
    public function findControllerAndMethod(): array
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            switch ($_SERVER['REQUEST_URI']) {
                case ("/"):
                    return ['controller' => 'Controller\HomePageController', 'method' => 'showHomePage'];
                case ("/404"):
                    http_response_code(404);
                    return ['controller' => 'Controller\ErrorController', 'method' => 'show404'];
                case ("/warning"):
                    return ['controller' => 'Controller\ErrorController', 'method' => 'informAboutMissedAuth'];
                case ("/auth"):
                        header('Location: /404');
                        break;
                case ("/page1" || "/page2"):
                    return ['controller' => 'Controller\PageController', 'method' => 'showOrdinaryPage'];
            }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($_SERVER['REQUEST_URI']) {
                case ("/auth"):
                    return ['controller' => 'Controller\AuthController', 'method' => 'auth'];
                case ("/" || "/404" || "/warning" || "/page1" || "/page2"):
                    header('Location: /');
                    break;
            }
        }
    }

    public function processRequest()
    {
        $path = $this->findControllerAndMethod();

        $method = $path['method'];
        if ($path['controller'] !== 'Controller\ErrorController') {
            (new $path['controller']())
                ->$method();
        } else {
            $path['controller']::$method();
        }
    }
}