<?php
include('CorrectnessChecker.php');

$checkCode = new CorrectnessChecker('{{lajkdhf{adfa}{}adfasdfadf{}}}');
$result = $checkCode->checkCode();
print_r($result);

$checkCode = new CorrectnessChecker('{{lajkdhf{adfa');
$result = $checkCode->checkCode();
print_r($result);
?>
