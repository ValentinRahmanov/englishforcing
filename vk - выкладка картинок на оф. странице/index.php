<?php

require_once('Parser.php');

$_ENV["conf"] = json_decode(file_get_contents(__DIR__ . "/config.json"), true);

$l = new Parser();
$l->parse();


