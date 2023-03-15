<?php

class Parser {

    public function parse() {
        $this->getLinksFormXLSXToXML();
        $this->parseXMLWithXPAth();
    }

    private function getLinksFormXLSXToXML() : void
    {
        exec("unzip -n" . __DIR__ . $_ENV["conf"]["publications_about_LIC"]["link_directory"] . $_ENV["conf"]["publications_about_LIC"]["name_of_file"] . " -d " . __DIR__ . $_ENV["conf"]["publications_about_LIC"]["link_directory"]);
    }

    public function parseXMLWithXPAth()
    {
        $xml = simplexml_load_file(__DIR__. $_ENV["conf"]["publications_about_LIC"]["links_unzipped_already"]);

        foreach($xml as $result) {
            $d = $result->attributes()["Target"][0];
            $dStr = (string) $d;

        }

    }
}