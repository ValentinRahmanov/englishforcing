<?php

namespace Model;

use \DB;

class ParseModel {

    private function getDataFromSearchEngine($searchPhrase)
    {
        $YandexApiRequestRes = file_get_contents($_ENV["config"]["yandex_xml"]["api_url_for_request_first_part"] . $searchPhrase . $_ENV["config"]["yandex_xml"]["api_url_for_request_second_part"]);
        echo '<pre>';
        print_r($YandexApiRequestRes);
        echo '<pre>';
        return simplexml_load_string($YandexApiRequestRes);
    }
    
    private function sendArticleInTheDatabase($plant, $text, $url, $title)
    {
        DB::query("INSERT INTO f90577wq_plants.articles(plant,text,link,title) VALUES('" . $plant . "', '" . $text . "', '" . $url . "', '" . $title . "')");
    }

    public function registerPlantsToParse()
    {
        foreach($_ENV['plants'] as $index => $plant) {
        DB::query("INSERT INTO f90577wq_plants.plants(plants) VALUES('" . $plant  . "')");
    }
    }

    private function getUnuploadedPlants()
    {
       $result = DB::query("SELECT * FROM f90577wq_plants.plants");

       foreach ($result as $row)
       {
           $plantsToParse[] = $row['plants'];
       }

       return $plantsToParse;
    }

    private function deleteFromDBThatIsAlreadyServed($plantToDelete)
    {
        print_r('что попадает в запрос');
        print_r($plantToDelete);
        print_r('что попадает в запрос');
        DB::query("DELETE FROM f90577wq_plants.plants WHERE plants='" . $plantToDelete  . "'");
    }
    
    private function processParticularArticleFromSearachResults($plant)
    {
        foreach ($this->getDataFromSearchEngine($plant)->{'response'}->results->grouping->group as $separateOutputRes) {

            $title = $separateOutputRes->doc->title->hlword[0];
            
            $url = $separateOutputRes->doc->url;
            
            $page = file_get_contents($url);
            preg_match_all('|<p>(.+)</p>|', $page, $matches);
          
             foreach ($matches[0] as $elemNumber => $match) {
                 
                 if(strpos($match, '<img') !== false || strpos($match, '<src') !== false || strpos($match, '<center') !== false || strpos($match, 'href') !== false) {
                     unset($matches[0][$elemNumber]);
                 } 
                 
             }
             
             $text = implode(' ', $matches[0]);
             
            $this->sendArticleInTheDatabase($plant, $text, $url, $title);

            $this->deleteFromDBThatIsAlreadyServed($plant);
        }
    }
    
    private function getAllArticlesInDB()
    {
        foreach($this->getUnuploadedPlants() as $plantNumber => $plant) {

        $this->processParticularArticleFromSearachResults($plant);
 //       sleep(60);
        }
    }
    
    public function fullfillParsing()
    {
        $this->getAllArticlesInDB();
    }
}