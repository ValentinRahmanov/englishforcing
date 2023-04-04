<?
namespace Controller;

use View\View;

use Model\FromDBToFrontModel;

class PageController {
    
    public $plantName;
    public $paginationPageNumber;
    
    function __construct($parameters = null)
    {
        $this->plantName = $parameters['first'];
        $this->paginationPageNumber = $parameters['second'];
    }
    
    public function showHomePage()
    {
        View::pullHTML('header');
        View::pullHTML('homePage');
        View::pullHTML('footer');
    }

    public function showMoreArticles()
    {
        View::pullHTML('header');
        if($this->paginationPageNumber === '2') {
            View::pullHTML('homePage', ['start' => 11, 'end' => 20]);
        }

        if ($this->paginationPageNumber === '3') {
            print_r('попадает в условие');
            View::pullHTML('homePage', ['start' => 21, 'end' => 30]);
        }

        if ($this->paginationPageNumber === '1') {
            View::pullHTML('homePage', ['start' => 0, 'end' => 10]);
        }

        if ($this->paginationPageNumber === '4') {
            View::pullHTML('homePage', ['start' => 31, 'end' => 40]);
        }

        if ($this->paginationPageNumber === '5') {
            View::pullHTML('homePage', ['start' => 41, 'end' => 50]);
        }

        if ($this->paginationPageNumber === '6') {
            View::pullHTML('homePage', ['start' => 51, 'end' => 60]);
        }

        if ($this->paginationPageNumber === '7') {
            View::pullHTML('homePage', ['start' => 61, 'end' => 70]);
        }

        View::pullHTML('footer');
    }
    
    public function showOrdinaryPage()
    {
 //       print_r($this->plantName);
        $requestDB = new FromDBToFrontModel($this->plantName);

        View::pullHTML('header', $this->plantName);
        echo '<br />';
        View::pullHTML('pageBody', ['pageContents' => $requestDB->getPageContent()]);
        View::pullHTML('footer');
    }
}
