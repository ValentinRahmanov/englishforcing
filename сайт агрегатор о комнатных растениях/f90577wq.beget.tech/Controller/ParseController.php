<?
namespace Controller;

use Model\ParseModel;

class ParseController {
    public function parseArticles ()
    { 
    $draft = new ParseModel();
    $d = $draft->fullfillParsing();
    }

    public function savePlantsToParse()
    {
       $list = new ParseModel();
       $list->registerPlantsToParse();
    }
}