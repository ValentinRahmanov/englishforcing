<?
namespace View;

class View {
    public static function pullHTML ($templateName, $infForPageGeneration = null) {

        if(!empty(is_array($infForPageGeneration['pageContents']))) {
            $_ENV['content'] = $infForPageGeneration['pageContents'];
        }

        if(is_string($infForPageGeneration)) {
            $_ENV['content'] = $infForPageGeneration;
        }

        if(!empty($infForPageGeneration['start']) | !empty($infForPageGeneration['end'])) {
            $_ENV['pagination'] = $infForPageGeneration;
        }
        
        if ($templateName !== 'homePage') {
            include('../View/' . $templateName . '.php');
        } else {
            include('../View/main/' . $templateName . '.php');
        }
    }
}