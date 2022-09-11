<?php

$url = '**************************************';

$html = file_get_contents($url);

$i = 0;

$document = new DOMDocument();

$document->loadHTML($html);

$xpath = new DOMXpath($document);

$elements = $xpath->query('//div[contains(@class,"versions")]/a/@href');

$scriptsmemory1 = fopen('scriptsmemo.csv', 'w+');

foreach($elements as $data) {

    $arr[] = '' . $data->textContent . '';
	
//	echo '<pre>';
//    var_dump($arr);
//    echo '<pre>';

}

foreach($arr as $value) {
    $a = basename($value);
	$cutname[] = '' . $a . '';
    
//	if ($a[0] === '1' && $a[1] === '0' && $a[2] === '1') {

        $zip_url          = "http://cbr.ru" . "$value";
        $destination_path = "C:\Users\Валентин\Desktop\OpenServer\domains\parserlic\archives\/" . $a . "";
		
        file_put_contents($destination_path, fopen($zip_url, 'r'));
		
//    }

}

fputcsv($scriptsmemory1, $cutname, ",");

fclose($scriptsmemory1);

*/

$counter = 0;

$amneziaremedy = fopen( 'scriptsmemo.csv', 'r' );

$archcatalog = fgetcsv($amneziaremedy, 150000, ",");
		
//		echo '<pre>';
//		print_r($archcatalog);
//		echo '<pre>';
		
	fclose($amneziaremedy);
	
while ($archcatalog !== false) {
    
$re = '/\-(\d{4})/m';

$yearsearch = preg_match_all($re, $archcatalog[$counter], $matches, PREG_SET_ORDER, 0);

$twonulls = $matches[0][0];
	
if ($twonulls === '-2021' || $twonulls === '-2020' || $twonulls === '-2019' || $twonulls === '-2018' || $twonulls === '-2017' || $twonulls === '-2016') {
		if (strpos($archcatalog[$counter], '101-') !== false) {
			echo $archcatalog[$counter] . "\n";
		$filename = '' . $archcatalog[$counter] . '';
		
		global $filename;
		
		var_dump($filename);

		$filepath = "W:\domains\parserlic\archives\/";

		$rar_file = rar_open($filepath.$filename);
		
		$list = rar_list($rar_file);
		
//			var_dump($list);
		
		foreach($list as $file) {
		
			$entry = rar_entry_get($rar_file, $file->getName());
			
			$entry->extract("W:\domains\parserlic\purefiles\/");
						
			if (strpos($file, 'В1.') !== false || strpos($file, 'B1.') !== false) {	
			
			$culvert = $file->getName();
			
			echo '<pre>';		
			print_r($culvert);
			echo '<pre>';
					
//			firstPattern($culvert);
			
			}
			
			if (strpos($file, 'N1.') !== false) {	
			
			$rinsing = $file->getName();
			
			echo '<pre>';		
			print_r($rinsing);
			echo '<pre>';
			
//			secondPattern($rinsing);

			}
			
			if (strpos($file, 'NAMES') !== false) {	
			
			$tarnish = $file->getName();
			
			echo '<pre>';		
			print_r($tarnish);
			echo '<pre>';
			
//			thirdPattern($tarnish);

			}
			
			unlink ("W:\domains\parserlic\purefiles\/" . $file->getName() . "");
		}
        rar_close($rar_file);
	

		 
		} 
		
}
		$counter++;

if (end($archcatalog) === $archcatalog[$counter]) {
   exit;
}

	
	}
	
	

function firstPattern($culvert) {

include 'connectdatabase.php';

$db = dbase_open("C:\Users\Валентин\Desktop\OpenServer\domains\parserlic\purefiles\/" . $culvert . "", 0);

if ($db) {
  $record_numbers = dbase_numrecords($db);
  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
      	  
$k = "" . $row['PLAN'] . "";

$h = iconv( "CP866", "UTF-8", $k);

$year = trim(substr($row['DT'], 0, -4));

$month = trim(substr($row['DT'], -4));

$temp_array[] = "('" . $year . "', 
'" . $month . "', 
" . trim($row['REGN']) . ", 
  '" . trim($h) . "', '" . trim($row['NUM_SC']) . "',
  '" . trim($row['A_P']) . "',
  " . trim($row['VR']) . ", " . trim($row['VV']) . ",
  " . trim($row['VITG']) . ", " . trim($row['ORA']) . ",
  " . trim($row['OVA']) . ", " . trim($row['OITGA']) . ",
  " . trim($row['ORP']) . ", " . trim($row['OVP']) . ",
  " . trim($row['OITGP']) . ", " . trim($row['IR']) . ",
  " .  trim($row['IV']) . ", " . trim($row['IITG']) . ",
  " . trim($row['DT']) . ", " . trim($row['PRIZ']) . ")";
	  
  }
}

$sql = "INSERT INTO 101_form_032021b1 () VALUES " . implode(",", $temp_array);

if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

}

function secondPattern($rinsing) {
	
include 'connectdatabase.php';

$db = dbase_open("C:\Users\Валентин\Desktop\OpenServer\domains\parserlic\purefiles\/" . $rinsing . "", 0);

if ($db) {
  $record_numbers = dbase_numrecords($db);
  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
	  $kj = mb_convert_encoding($row['NAME_B'], "UTF-8", "CP866");
	  
$pro = trim($kj);

$dm = trim(substr($rinsing, 0, -10));

$dy = trim(substr($rinsing, 2, -6));
	  
$temp_array[] = "('" . $dy . "', 
'" . $dm . "', 
" . trim($row['REGN']) . ", 
  '" . $pro . "', '" . trim($row['PRIZ']) . "',
  '" . trim($row['PRIZ_P']) . "')";
	  
  }
}

$sql = "INSERT INTO 101_form_032021n1 () VALUES " . implode(",", $temp_array);

if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

}

function thirdPattern($tarnish) {
	
include 'connectdatabase.php';

$db = dbase_open("*****************************************" . $tarnish . "", 0);

if ($db) {
  $record_numbers = dbase_numrecords($db);
  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
	  $clearance = mb_convert_encoding($row['PLAN'], "UTF-8", "CP866");
	  
	  $decode = mb_convert_encoding($row['NAME'], "UTF-8", "CP866");
	  
	  $freshening = trim($clearance);

	  $decodecut = trim($decode);

global $filename;	  

$ye = trim(substr($filename, 4, -8));

$mo = trim(substr($filename, 8, -4));
	  
$temp_array[] = "('" . $ye . "', '" . $mo . "',
'" . $freshening . "', '" . trim($row['NUM_SC']) . "',
'" . $decodecut . "', " . trim($row['TYPE']) . ")";
	  
  }
}

$sql = "INSERT INTO 101_form_names () VALUES " . implode(",", $temp_array);

if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);	
	
};

/*function forthPatern() {
	
};
*/
?>