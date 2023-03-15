<?php

namespace Controller;

use View\View;

class PageController
{
    public function showOrdinaryPage(): void
    {
        $folder = '../View';
        $fileNames = array_diff(scandir($folder), array('..', '.'));

        foreach ($fileNames as $file) {
            $defineRequestedPageNumber = substr($_SERVER['REQUEST_URI'], -1);

            if (AuthController::checkAuth() !== true) {
                header('Location: /warning');
                continue;
            }

            if (strpos($file, 'page') !== false) {
                if (strpos($file, $defineRequestedPageNumber) !== false) {

                    $articleName = 'page' . $defineRequestedPageNumber;
                    View::renderHTML('headerWithoutButton');
                    View::renderHTML($articleName);
                    View::renderHTML('footer');
                }
            }
        }
    }
}