<?

namespace Model;

use \DB;

class FromDBToFrontModel {
    
    public $plantName;
    
    function __construct($plantName)
    {
        $this->plantName = $plantName;
    }
    
    private function getFromDB()
    {
        $rows = DB::query("SELECT plant, text, link, title FROM f90577wq_plants.articles WHERE plant='" . $this->plantName . "'");

        foreach($rows as $row) {
            $information[] = $row; 
        }
        
        return $information;
    }
    
    public function getPageContent()
    {
        return $this->getFromDB();
    }
}