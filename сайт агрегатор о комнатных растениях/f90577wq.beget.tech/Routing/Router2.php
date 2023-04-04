<?php

namespace Routing;

class Router2 {
    private function mapARoutePerRequest() {
        
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            switch($_SERVER['REQUEST_URI']) {
                case ("/"):
                    return ['Controller' => 'Controller\PageController', 'method' => 'showHomePage'];
                case (array_key_exists(substr($_SERVER['REQUEST_URI'], 1), $_ENV['plants'])):
                    return ['Controller' => 'Controller\PageController', 'method' => 'showOrdinaryPage', 'argument' => ['first' => $_ENV['plants'][substr($_SERVER['REQUEST_URI'], 1)], 'second' => null]];
 //               case("/run"):
 //                   return ['Controller' => 'Controller\ParseController', 'method' => 'parseArticles'];
 //               case("/listPlants"):
 //                   return ['Controller' => 'Controller\ParseController', 'method' => 'savePlantsToParse'];
                case("/1"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '1']];
                case("/2"):
                   return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '2']];
                case("/3"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '3']];
                case("/4"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '4']];
                case("/5"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '5']];
                case("/6"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '6']];
                case("/7"):
                    return['Controller' =>'Controller\PageController', 'method' => 'showMoreArticles', 'argument' => ['first' => null, 'second' => '7']];
                default:
                    print_r("Ошибка 404. Нет такой страницы");
        }
    }
    }
    
    public function serveAttendantRequest() {
        $path = $this->mapARoutePerRequest();

        if(empty($path['argument'])) {
        $method = $path['method'];
            (new $path['Controller']())
                ->$method();
        } else {
            $method = $path['method'];
            (new $path['Controller']($path['argument']))
                ->$method();

        }
    }
}