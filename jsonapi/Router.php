<?php

namespace Routing;

class Router
{
    public function findControllerAndMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            switch ($_SERVER['REQUEST_URI']) {
                case ("/"):
                    return ['controller' => 'Controller\JsonApiReplyController', 'method' => 'getWholeCatalogue'];
                case ("/category" === strtok($_SERVER["REQUEST_URI"], '?')):
                    $delimiterNumber = strpos($_SERVER['QUERY_STRING'], "=");
                    $strCut = substr($_SERVER['QUERY_STRING'], $delimiterNumber + 1);
                    return ['controller' => 'Controller\JsonApiReplyController', 'method' => 'getPartNeeded', 'argument' => $strCut];
                case ("/add" === strtok($_SERVER["REQUEST_URI"], '?')):
                    $addingArr = explode('&', $_SERVER['QUERY_STRING']);
                    foreach ($addingArr as $itemKey => $item) {
                        $addingArr[$itemKey] = explode('=', $addingArr[$itemKey]);
                    }
                    return ['controller' => 'Controller\JsonApiReplyController', 'method' => 'addElem', 'argument' => $addingArr];

                case ("/shift" === strtok($_SERVER["REQUEST_URI"], '?')):
                    $shiftingArr = explode('&', $_SERVER['QUERY_STRING']);
                    foreach ($shiftingArr as $itemKey => $item) {
                        $shiftingArr[$itemKey] = explode('=', $shiftingArr[$itemKey]);
                    }
                    return ['controller' => 'Controller\JsonApiReplyController', 'method' => 'shiftElem', 'argument' => $shiftingArr];
                case ("/delete" === strtok($_SERVER["REQUEST_URI"], '?')):
                    $deleteArr = explode('=', $_SERVER['QUERY_STRING']);
                    return ['controller' => 'Controller\JsonApiReplyController', 'method' => 'deleteElem', 'argument' => $deleteArr];
                default:
                    return ['controller' => 'Controller\InputGetUrlDataErrorsController', 'method' => 'serviceWrongParameterInUrl'];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return ['controller' => 'Controller\InputGetUrlDataErrorsController', 'method' => 'replyIfTypePOST'];
        }
    }

    public function processRequest()
    {
        $path = $this->findControllerAndMethod();
        $method = $path['method'];

        if (empty($path['argument'])) {
            (new $path['controller']())
                ->$method();
        } else {
            (new $path['controller']())
                ->$method($path['argument']);
        }
    }
}