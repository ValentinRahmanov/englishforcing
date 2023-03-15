<?php

include('config.php');


//Скачали файлы

getFromTheSource($dirDownload);

doHandle ( $dirDownload, $dirTemp, $withSlash, $dirDone );

function getFromTheSource ($dirDownload) {

    global $amneziaremedy, $arrayforcsv;

    $url = 'http://cbr.ru/banking_sector/otchetnost-kreditnykh-organizaciy/';
	$html = file_get_contents($url);

	$document = new DOMDocument();
	$document->loadHTML($html);
	
	$xpath = new DOMXpath($document);
    $jk = YearsAndFormNames($xpath);

    $lat = readScriptsMemo($jk);
    $oncemorestep = divergenceSearch($jk, $lat, $klr, $commonarr);

    $unitestr1 = formStringForXpath($oncemorestep, $totalarrforxpath);

	$elements = $xpath->query('//div/div[' . $unitestr1 . ']/a/@href');


            $ak = json_encode($jk, JSON_UNESCAPED_UNICODE);

            $json = fopen(__DIR__. '/scriptsmemo.json', 'w+');
            fwrite($json, $ak);
            fclose($json);

	foreach($elements as $data) {


        $thenameofform = basename('' . $data->textContent . '');

        $checkonfrom = substr($thenameofform, 0, 3);

        $whatstheyear = substr($thenameofform, 4, 4);

        $checkonmonth = substr($thenameofform, 8, 2);

        echo '<pre>';
        echo 'Момент 1' . PHP_EOL;
        echo memory_get_usage();
        echo '<pre>';

        if ($oncemorestep[$checkonfrom]['year'][$whatstheyear] !== null) {
            if (in_array($checkonmonth, $oncemorestep[$checkonfrom]['year'][$whatstheyear], true)) {

                $zip_url = "http://cbr.ru" . "" . $data->textContent . "";

                $destination_path = $dirDownload . basename( '' . $data->textContent . '' );
                echo 'Момент 2' . PHP_EOL;
                echo memory_get_usage();
                file_put_contents( $destination_path, fopen( $zip_url, 'r' ) );
            }

        }
    }

}

function doHandle($dirDownload, $dirTemp, $withSlash, $dirDone) {

    $archivesregister = array_diff(scandir($dirDownload), array('..', '.'));
	
	foreach($archivesregister as $single)
	
	{
		$rar_file = rar_open($dirDownload.$single);
				
		$list = rar_list($rar_file);

        echo '<pre>';
        echo 'Момент 3' . PHP_EOL;
        echo memory_get_usage();
        echo '<pre>';

		foreach ($list as $separatefile) 			
			
			{			
				
				$entry = rar_entry_get($rar_file, $separatefile->getName());

				$entry->extract($dirTemp);
				
				switch ($archivesregister)
				{
                    case strpos($single, '101-') !== false:
                        parse_101_form($separatefile, $withSlash, $single);
                        break;

                    case strpos($single, '102-') !== false:
                        parse_102_form($separatefile, $withSlash, $single);
                        echo '<pre>';
                        echo 'Момент 4' . PHP_EOL;
                        echo memory_get_usage();
                        echo '<pre>';
                        break;

                    case strpos($single, '123-') !== false:
                        parse_123_form($separatefile, $withSlash, $single);
                        break;

                    case strpos($single, '135-') !== false:
                        parse_135_form($separatefile, $withSlash, $single);
                        break;

                    case strpos($single, '802-') !== false:
                        parse_802_form($separatefile, $withSlash, $single);
                        break;

                    case strpos($single, '803-') !== false:
                        parse_803_form($separatefile, $withSlash, $single);
                        break;

                    case strpos($single, '805-') !== false:
                        parse_805_form($separatefile, $withSlash, $single);
                        break;
				}
									
				unlink ($dirTemp.$separatefile->getName());
							
			}
		
		rar_close($rar_file);
        echo 'Момент 5' . PHP_EOL;
        echo memory_get_usage();
	}

	foreach($archivesregister as $treatedalready) {
        rename ($dirDownload.$treatedalready, $dirDone.$treatedalready);
    }

/*   $sde = array_diff(scandir($dirDownload), array('..', '.'));
	foreach($sde as $sdffd) {
        unlink ($dirDownload.$sdffd);
    }
*/

}

function parse_101_form ($separatefile, $withSlash, $single)

{
	
if (strpos($separatefile, 'B1.') !== false) {	
				
				$culvert = $separatefile->getName();
				
				form_101_firstPattern($withSlash, $culvert);
				
				}

if (strpos($separatefile, 'NAMES') !== false) {

        $tarnish = $separatefile->getName();

        form_101_secondPattern($withSlash, $tarnish, $single);

    }

}

function parse_102_form ($separatefile, $withSlash, $single)

{

    if (strpos($separatefile, '_P1.') !== false) {

        $nex = $separatefile->getName();

        form_102_thirdPattern($withSlash, $nex, $single);

    }

}

function parse_123_form ($separatefile, $withSlash, $single)

{

    if (strpos($separatefile, '_123D.') !== false) {

        $thirdform = $separatefile->getName();

        form_123_forthPattern($withSlash, $thirdform, $single);

    }

    if (strpos($separatefile, '_123N.') !== false) {

        $ubic = $separatefile->getName();

        form_123_fifthPattern($withSlash, $ubic, $single);

    }

}

function parse_135_form ($separatefile, $withSlash, $single)

{

    if (strpos($separatefile, '_1.') !== false) {

        $stock = $separatefile->getName();

        form_135_sixthPattern($withSlash, $stock, $single);

    }

    if (strpos($separatefile, '_2.') !== false) {

        $regularform = $separatefile->getName();

        form_135_seventhPattern($withSlash, $regularform, $single);

    }

    if (strpos($separatefile, '_3.') !== false) {

        $fivecolumntable = $separatefile->getName();

        form_135_eighthPattern($withSlash, $fivecolumntable, $single);

    }

    if (strpos($separatefile, '_4.') !== false) {

        $transgression = $separatefile->getName();

        form_135_tenthPattern($withSlash, $transgression, $single);

    }


}

function parse_802_form ($separatefile, $withSlash, $single)
{

    if (strpos($separatefile, 'PK802') !== false) {

        $accounting = $separatefile->getName();

        form_802_eleventhPattern($withSlash, $accounting, $single);

    }

    if (strpos($separatefile, 'PS802') !== false) {

        $shortages = $separatefile->getName();

        form_802_twelfthPattern($withSlash, $shortages, $single);

    }

    if (strpos($separatefile, 'PP802') !== false) {

        $loans = $separatefile->getName();

        form_802_thirteenth($withSlash, $loans, $single);

    }

}

function parse_803_form ($separatefile, $withSlash, $single)
{

    if (strpos($separatefile, 'PK803') !== false) {

        $finresults = $separatefile->getName();

        form_803_fourteenth($withSlash, $finresults, $single);

    }

}

function parse_805_form ($separatefile, $withSlash, $single)
{

    if (strpos($separatefile, 'PKAPI') !== false) {

        $selfmeans = $separatefile->getName();

        form_805_fifteenth($withSlash, $selfmeans, $single);

    }

    if (strpos($separatefile, 'PRASI') !== false) {

        $some = $separatefile->getName();

        form_805_sixteenth($withSlash, $some, $single);

    }

    if (strpos($separatefile, 'PRNI') !== false) {

        $certainresults = $separatefile->getName();

       form_805_seventeenth($withSlash, $certainresults, $single);

    }

    if (strpos($separatefile, 'PN805') !== false) {

        $mandatory = $separatefile->getName();

        form_805_eighteenth($withSlash, $mandatory, $single);

    }

    if (strpos($separatefile, 'PN26A') !== false) {

        if (strpos($separatefile, '.DBT') === false) {

            $liquidityrequirements = $separatefile->getName();

            form_805_nineteenth($withSlash, $liquidityrequirements, $single);

        }
    }

    if (strpos($separatefile, 'PN26B') !== false) {

        $liqval = $separatefile->getName();

        form_805_twentieth($withSlash, $liqval, $single);

    }

    if (strpos($separatefile, 'PO805') !== false) {

        $add = $separatefile->getName();

        form_805_twenty_first($withSlash, $add, $single);
    }

    if (strpos($separatefile, 'PD805') !== false) {

        $twopart = $separatefile->getName();

        form_805_twenty_second($withSlash, $twopart, $single);
    }

    if (strpos($separatefile, 'PC805') !== false) {

        $reference = $separatefile->getName();

        form_805_twenty_third($withSlash, $reference, $single);
    }

    if (strpos($separatefile, 'f805m') !== false) {

        $onetwin = $separatefile->getName();

        form_805_twenty_fourth($withSlash, $onetwin, $single);
    }

    if (strpos($separatefile, 'f805_') !== false) {

        $twotwin = $separatefile->getName();

        form_805_twenty_fifth($withSlash, $twotwin, $single);
    }
}



function form_101_firstPattern($withSlash, $culvert) {

 include 'connectdatabase.php';
	
	$db = dbase_open($withSlash.$culvert . "", 0);

	if ($db) {
		
		$record_numbers = dbase_numrecords($db);
		
		for ($i = 1; $i <= $record_numbers; $i++) {	  
			  
			$row = dbase_get_record_with_names($db, $i);
			
//			print_r($row);
				  
			$k = "" . $row['PLAN'] . "";

			$h = iconv( "CP866", "UTF-8", $k);

			$year = trim(substr($row['DT'], 0, -4));

			$month = trim(substr($row['DT'], -4, -2));

			$day = trim(substr($row['DT'], -2));

			$res = new DateTime($year .'-'. $month .'-'. $day);

			$formatting = $res->format('Y-m-d');

			$temp_array[] = "('" . $formatting . "', 
			" . trim($row['REGN']) . ", 
			  '" . trim($h) . "', '" . trim($row['NUM_SC']) . "',
			  '" . trim($row['A_P']) . "',
			  " . trim($row['VR']) . ", " . trim($row['VV']) . ",
			  " . trim($row['VITG']) . ", " . trim($row['ORA']) . ",
			  " . trim($row['OVA']) . ", " . trim($row['OITGA']) . ",
			  " . trim($row['ORP']) . ", " . trim($row['OVP']) . ",
			  " . trim($row['OITGP']) . ", " . trim($row['IR']) . ",
			  " .  trim($row['IV']) . ", " . trim($row['IITG']) . ",
			  " . trim($row['PRIZ']) . ")";
								
		}
	}

$pg = "INSERT INTO public.a101_data 
					VALUES " . implode(",", $temp_array);
				
				if (pg_query($conn, $pg)) {
					  echo "New record created successfully";
				} else {
					  echo "Error: ";			  
					  			  
				}

pg_close($conn);


}

function form_101_secondPattern($withSlash, $tarnish, $single) {

   include 'connectdatabase.php';

    $db = dbase_open($withSlash.$tarnish . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);
            $clearance = mb_convert_encoding($row['PLAN'], "UTF-8", "CP866");

            $decode = mb_convert_encoding($row['NAME'], "UTF-8", "CP866");

            $freshening = trim($clearance);

            $decodecut = trim($decode);


            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', '" . $freshening . "', '" . trim($row['NUM_SC']) . "',
'" . $decodecut . "', " . trim($row['TYPE']) . ")";

        }
    }

    $pg = "INSERT INTO public.a101_definitions VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_102_thirdPattern($withSlash, $nex, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$nex, 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $decode = mb_convert_encoding($row['CODE'], "UTF-8", "CP866");

            $freshening = trim($decode);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $vs = empty(trim($row['DT'])) ? $row['DT'] : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . $row['REGN'] . ", '" . $row['CODE'] . "', " . $row['SIM_R']. ",
" . $row['SIM_V']. ", " . $row['SIM_ITOGO']. ", '" . $vs . "')";

        }
    }


    $pg = "INSERT INTO public.a102_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_123_forthPattern($withSlash, $thirdform, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$thirdform . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN']) . ", '" . trim($row['C1']) . "', " . trim($row['C3']) . ")";

        }
    }


    $pg = "INSERT INTO public.a123_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_123_fifthPattern($withSlash, $ubic, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$ubic . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $decode = mb_convert_encoding($row['C2_1'], "UTF-8", "CP866");

            $blankcolumn = mb_convert_encoding($row['C2_2'], "UTF-8", "CP866");

            $three = mb_convert_encoding($row['C2_3'], "UTF-8", "CP866");

            $freshening = trim($decode);

            $trublevalue = trim($blankcolumn);

            $pork = trim($three);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
'" . trim($row['C0']) . "', '" . trim($row['C1']) . "', '" . $freshening . "',
'" . $trublevalue . "', '" . $pork . "')";

        }
    }


    $pg = "INSERT INTO public.a123_definitions VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_135_sixthPattern($withSlash, $stock, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$stock . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $decode = mb_convert_encoding($row['C1_1'], "UTF-8", "CP866");

            $freshening = trim($decode);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
'" . trim($row['REGN']) . "', " . $freshening . ", '" . trim($row['C2_1']) . "')";

        }
    }


    $pg = "INSERT INTO public.a135_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_135_seventhPattern($withSlash, $regularform, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$regularform . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $decode = mb_convert_encoding($row['C1_2'], "UTF-8", "CP866");

            $freshening = trim($decode);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN']) . ", '" . $freshening . "', " . trim($row['C2_2']) . ")";

        }
    }


    $pg = "INSERT INTO public.a135_some_company_results_against_requirements VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_135_eighthPattern($withSlash, $fivecolumntable, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$fivecolumntable . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['C1_3'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['C4_3'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $reassure = trim($c2);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN']) . ", '" . $freshening . "', " . trim($row['C2_3']) . ", " . trim($row['C3_3']) . ", '" . $reassure . "')";

        }
    }


    $pg = "INSERT INTO public.a135_values_required VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_135_tenthPattern($withSlash, $transgression, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$transgression . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['C2_4'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN']) . ", " . trim($row['C1_4']) . ", '" . $freshening . "', " . trim($row['C3_4']) . ", '" . trim($row['C4_4']) . "')";

        }
    }


    $pg = "INSERT INTO public.a135_banks_broke_requirements VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_802_eleventhPattern($withSlash, $accounting, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$accounting . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['KORR_P']) . ", " . trim($row['KORR_M']) . ", " . trim($row['VSEGO']) . ")";

        }
    }


    $pg = "INSERT INTO public.a802_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_802_twelfthPattern($withSlash, $shortages, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$shortages . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['STR_NAME'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $c3 = trim($c2);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', '" . $c3 . "', " . trim($row['OR_MSFO9']) . ", " . trim($row['RVP_462P']) . ")";

        }
    }


    $pg = "INSERT INTO public.a802_reserves_on_shortages VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_802_thirteenth($withSlash, $loans, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$loans . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['STR_NAME'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $c3 = trim($c2);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', '" . $c3 . "', " . trim($row['SUM_REZ']) . ")";

        }
    }


    $pg = "INSERT INTO public.a802_reserves_on_loans VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_803_fourteenth($withSlash, $finresults, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$finresults . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['RAZDEL'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $c3 = trim($c2);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', '" . $c3 . "', " . trim($row['KORR_P']) . ", " . trim($row['KORR_M']) . ", " . trim($row['VSEGO']) . ")";

        }
    }


    $pg = "INSERT INTO public.a803_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_fifteenth($withSlash, $selfmeans, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$selfmeans . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['NOM_STR'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['KORR']) . ", " . trim($row['IITG']) . ")";

        }
    }


    $pg = "INSERT INTO public.a805_data VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_sixteenth($withSlash, $some, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$some . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['RASH'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['KORR']) . ", " . trim($row['IITG']) . ")";

        }
    }


    $pg = "INSERT INTO public.a805_codes VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_seventeenth($withSlash, $certainresults, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$certainresults . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['NAME_POK'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['KORR']) . ", " . trim($row['IITG']) . ")";

        }
    }


    $pg = "INSERT INTO public.a805_definitions VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_eighteenth($withSlash, $mandatory, $single) {

    include 'connectdatabase.php';
var_dump($mandatory);
    $db = dbase_open($withSlash.$mandatory . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $c1 = mb_convert_encoding($row['NAME_NORM'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['PRIM'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $c3 = trim($c2);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

//$vs = empty(trim($trublevalue)) ? $trublevalue : NULL;

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['FAKT_ZN']) . ", '" . $c3 . "')";

        }
    }


    $pg = "INSERT INTO public.a805_values_required VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_nineteenth($withSlash, $liquidityrequirements, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$liquidityrequirements . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

 //           var_dump($row['PRIM']);

 //           var_dump($row['DATE_NAR']);

//            $c1 = mb_convert_encoding($row['PRIM'], "UTF-8", "CP866");

//            $c2 = mb_convert_encoding($row['DATE_NAR'], "UTF-8", "CP866");

            $freshening = trim($row['PRIM']);

            $trublevalue = trim($row['DATE_NAR']);

//            $c3 = trim($c2);

 //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            if (trim($trublevalue) === "") {
                $vs = NULL;
            } else {
                $vs = $trublevalue;
            }

            if (trim($freshening) === "") {
                $psp = NULL;
            } else {
                $psp = $freshening;
            }
            var_dump($vs);
            var_dump($psp);
            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", " . trim($row['ZN_FAKT']) . ", " . trim($row['ZN_NAR']) . ", '" . $vs . "', '" . $psp . "')";

        }
    }

 //   var_dump($temp_array);

        $pg = "INSERT INTO public.a805_liquidity_requirements VALUES " . implode(",", $temp_array);

        if (pg_query($conn, $pg)) {
            echo "New record created successfully";
        } else {
            echo "Error: ";
        }
        pg_close($conn);

}

function form_805_twentieth($withSlash, $liqval, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$liqval . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            //           var_dump($row['PRIM']);

            //           var_dump($row['DATE_NAR']);

            $c1 = mb_convert_encoding($row['POK_NAME'], "UTF-8", "CP866");

//            $c2 = mb_convert_encoding($row['DATE_NAR'], "UTF-8", "CP866");

            $freshening = trim($c1);

//            $c3 = trim($c2);

            //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['KOD_VAL']) . ", " . trim($row['POK_SUM']) . ")";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.a805_company_liqidity_values VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_twenty_first($withSlash, $add, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$add . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", " . trim($row['NAIM_OTKL']) . ")";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.a805_additions_got_by_banks VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_twenty_second($withSlash, $twopart, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$twopart . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            //           var_dump($row['PRIM']);

            //           var_dump($row['DATE_NAR']);

            $c1 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

//            $c2 = mb_convert_encoding($row['DATE_NAR'], "UTF-8", "CP866");

            $freshening = trim($c1);

//            $c3 = trim($c2);

            //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');
            
            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', " . trim($row['NORM_ZNACH']) . ", " . trim($row['MIN_DOP']) . ")";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.a805_additional_requirements VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}


function form_805_twenty_third($withSlash, $reference, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$reference . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            //           var_dump($row['PRIM']);

            //           var_dump($row['DATE_NAR']);

            $c1 = mb_convert_encoding($row['STR'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['KSTRAN'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $c3 = trim($c2);

            //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['REGN_GKO']) . ", '" . $freshening . "', '" . $c3 . "', " . trim($row['NAC_NAD']) . ", " . trim($row['TREB']) . ")";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.a805_general_facts VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_twenty_fourth($withSlash, $onetwin, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$onetwin . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            //           var_dump($row['PRIM']);

            //           var_dump($row['DATE_NAR']);

            $c1 = mb_convert_encoding($row['FRAZD'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['FSECTION'], "UTF-8", "CP866");

            $c3 = mb_convert_encoding($row['FSTR'], "UTF-8", "CP866");

            $c4 = mb_convert_encoding($row['FVALUE'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $bm1 = trim($c2);

            $bm2 = trim($c3);

            $bm3 = trim($c4);

            //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', 
" . trim($row['FSORT']) . ", '" . $freshening . "', '" . $bm1 . "', '" . $bm2. "', '" . $bm3 . "')";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.a805_mondatory_normatives VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}

function form_805_twenty_fifth($withSlash, $twotwin, $single) {

    include 'connectdatabase.php';

    $db = dbase_open($withSlash.$twotwin . "", 0);

    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);

            //           var_dump($row['PRIM']);

            //           var_dump($row['DATE_NAR']);

            $c1 = mb_convert_encoding($row['FN_NUM_RUS'], "UTF-8", "CP866");

            $c2 = mb_convert_encoding($row['FN_NUM_LAT'], "UTF-8", "CP866");

            $c3 = mb_convert_encoding($row['FN_TP_NM'], "UTF-8", "CP866");

            $freshening = trim($c1);

            $bm1 = trim($c2);

            $bm2 = trim($c3);



            //           $trublevalue = c2;

            $ye = trim(substr($single, 4, -8));

            $mo = trim(substr($single, 8, -6));

            $dd = trim(substr($single, 10, -4));

            $res = new DateTime($ye .'-'. $mo .'-'. $dd);

            $formatting = $res->format('Y-m-d');

            $temp_array[] = "('" . $formatting . "', 
'" . $freshening . "', '" . $bm1 . "', " . $row['FN_TP_NUM'] . ", '" . $bm2 . "', " . $row['SRT_NUM'] . ")";

        }
    }

    //   var_dump($temp_array);

    $pg = "INSERT INTO public.а805_mondatory_normatives_two VALUES " . implode(",", $temp_array);

    if (pg_query($conn, $pg)) {
        echo "New record created successfully";
    } else {
        echo "Error: ";
    }
    pg_close($conn);

}



function YearsAndFormNames($xpath)

{

    $lklk = $xpath->query('//div[contains(@class,"versions")]/a/@href');

    //   $assa = $xpath->query('//@data-item-select');
    /*
        $form = "101";
        $year = 2019;
        $data = [1,2,3,4];
    */

    //   $array[$form][$year]['data'][] = 1;


    foreach ($lklk as $sda) {


        $form_title = $sda->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue;

        $hjo = substr($form_title, 0, -13);

        $truedate = $sda->parentNode->textContent;

        $comp = '' . $sda->textContent . '';

        $gt = substr($comp, -12);

        $ert = substr($gt, 0, -8);

        if ($hjo === 'Данные оборотной ведомости по счетам бухгалтерского учёта, форма 101, dbf в архиве') {

            $chiefkey = 101;

            $onemore[] = array($ert => $truedate);

            $arrayfor101[] = $ert;

        }

        if ($hjo === 'Отчёт о финансовых результатах, форма 102, dbf в архиве') {

            $main = 102;

            $yearandmonth[] = array($ert => $truedate);

            $arrayfor102[] = $ert;

        }

        if ($hjo === 'Расчёт собственных средств (капитала) («Базель III»), форма 123, dbf в архиве') {

            $central = 123;

            $fr123[] = array($ert => $truedate);

            $arrayfor123[] = $ert;
        }

        if ($hjo === 'Информация об обязательных нормативах, форма 135, dbf в архиве') {

            $milestone = 135;

            $ba135[] = array($ert => $truedate);

            $arrayfor135[] = $ert;
        }

        if ($hjo === 'Консолидированный балансовый отчет, форма 0409802, dbf в архиве') {

            $keyforaccess = 802;

            $acnumbers802[] = array($ert => $truedate);

            $arrayfor802[] = $ert;
        }

        if ($hjo === 'Консолидированный отчет о финансовых результатах, форма 0409803, dbf в архиве') {

            $mk = 803;

            $consolidrep[] = array($ert => $truedate);

            $arrayfor803[] = $ert;
        }

        if ($hjo === 'Расчет собственных средств (капитала) и значений обязательных нормативов банковской группы, форма 0409805, dbf в архиве') {

            $cornerstone = 805;

            $lead[] = array($ert => $truedate);

            $arrayfor805[] = $ert;
        }

    }
//    Расчёт собственных средств (капитала) («Базель III»), форма 123, dbf в архиве
    $jo = array_flip(array_unique($arrayfor101));

    $nextform = array_flip(array_unique($arrayfor102));

    $internulfunds = array_flip(array_unique($arrayfor123));

    $blaccounts = array_flip(array_unique($arrayfor135));

    $lokr = array_flip(array_unique($arrayfor802));

    $economics = array_flip(array_unique($arrayfor803));

    $acuilam = array_flip(array_unique($arrayfor805));


    foreach ($jo as $xyi => $rhrh) {
        $vas[$xyi] = array();

    }

    foreach ($nextform as $returnved => $ler) {
        $profits[$returnved] = array();

    }

    foreach ($internulfunds as $general123 => $particle) {
        $ifu[$general123] = array();

    }

    foreach ($blaccounts as $blac => $simpdate) {
        $hor[$blac] = array();

    }

    foreach ($lokr as $fur => $connoisseur) {
        $peer[$fur] = array();

    }

    foreach ($economics as $scrap => $clandestine) {
        $kol[$scrap] = array();

    }

    foreach ($acuilam as $lest => $argentum) {
        $ladpal[$lest] = array();

    }

    foreach($onemore as $keo => $lj) {

        array_splice($vas[key($lj)],0, 0, array(substr($lj[key($lj)], -2)));

    }

    foreach($yearandmonth as $one102 => $particular102) {

        array_splice($profits[key($particular102)],0, 0, array(substr($particular102[key($particular102)], -2)));

    }

    foreach($fr123 as $one123 => $priv123) {

        array_splice($ifu[key($priv123)],0, 0, array(substr($priv123[key($priv123)], -2)));

    }

    foreach($ba135 as $one135 => $acsums) {

        array_splice($hor[key($acsums)],0, 0, array(substr($acsums[key($acsums)], -2)));

    }

    foreach($acnumbers802 as $one802 => $lim) {

        array_splice($peer[key($lim)],0, 0, array(substr($lim[key($lim)], -2)));

    }

    foreach($consolidrep as $one803 => $lizard) {

        array_splice($kol[key($lizard)],0, 0, array(substr($lizard[key($lizard)], -2)));

    }

    foreach($lead as $one805 => $marsh) {

        array_splice($ladpal[key($marsh)],0, 0, array(substr($marsh[key($marsh)], -2)));

    }



    $commonarr[$chiefkey] = array('type' => 'quarter', 'year' => $vas);

    $commonarr[$main] = array('type' => 'quarter', 'year' => $profits);

    $commonarr[$central] = array('type' => 'quarter', 'year' => $ifu);

    $commonarr[$milestone] = array('type' => 'quarter', 'year' => $hor);

    $commonarr[$keyforaccess] = array('type' => 'quarter', 'year' => $peer);

    $commonarr[$mk] = array('type' => 'quarter', 'year' => $kol);

    $commonarr[$cornerstone] = array('type' => 'quarter', 'year' => $ladpal);


//    $ar[$chiefkey] = $jo;
/*
        foreach ($rra as $lore) {
            if (strpos(key($lore), '101') !== false) {
                $mainkey = 101;
        }
            if (key($lore) === 'Данные оборотной ведомости по счетам бухгалтерского учёта, форма 101, dbf в архиве') {
                var_dump($lore);
            }
    }
*/
//    $commonarr = array_merge($koi, $bedr);
/*
        $ak = json_encode($commonarr, JSON_UNESCAPED_UNICODE);

        $json = fopen(__DIR__. '/scriptsmemo.json', 'w+');
        fwrite($json, $ak);
        fclose($json);
*/
/*
        echo '<pre>';
 //    var_dump($commonarr);
    echo '<pre>';
*/
    return $commonarr;
}

function readScriptsMemo ($jk)

{

    $getolddata = file_get_contents(__DIR__. '/scriptsmemo.json',FILE_USE_INCLUDE_PATH);

    $klr = json_decode($getolddata,true);

    return $klr;

}

function divergenceSearch($commonarr, $klr)

{
    global $totalarrforxpath;

    if (!empty($klr)) {

        $flevelu = array_keys($commonarr);

        $flevelnon = array_keys($klr);

        $rc = array_diff($flevelu, $flevelnon);


        $tom = array_diff_assoc($commonarr, $klr);

//var_dump($tom);
//commanarr новый
//klr старый

        foreach ($commonarr as $fl => $subfl) {
            if ($klr[$fl] != null) {

                foreach ($commonarr[$fl]['year'] as $yk => $ink) {

                    if ($klr[$fl]['year'][$yk] === null) {
                        foreach ($ink as $cch => $withoutyear) {
                            $regularyear[] = array($fl => array($yk => $withoutyear));
                        }

                    } else {
                        foreach ($ink as $hc => $sepmonth) {
                            //   print_r("$sepmonth" . PHP_EOL);
                            $stumbleupon = (in_array($sepmonth, $klr[$fl]['year'][$yk]));
                            if ($stumbleupon === FALSE) {

                                $raa[] = array($fl => array($yk => $sepmonth));
                            }

                        }

                    }

                }

            } else {

                $tom = array_diff_assoc($commonarr, $klr);

                foreach ($tom as $hol => $vval) {
                    foreach ($commonarr[$fl]['year'] as $llk => $hrt) {
                        foreach ($hrt as $ero) {
                            $absform[] = array($fl => array($llk => $ero));

                        }
                    }
                }

            }


        }

        $raa === null ? $raa = [] : $raa;

        $regularyear === null ? $regularyear = [] : $regularyear;

        $absform === null ? $absform = [] : $absform;

        $outputarr = array_merge($raa, $regularyear, $absform);

        if (empty($outputarr)) {

            /* Если все архивы с сайта загружены, загружать ничего не нужно, выходим из программы. Если нужно заполнить таблицы заново,
              то необходимо просто все удалить из файла scriptsmemo.json */
            echo 'Все архивы с сайта sbr.ru загружены';
            exit;
        } else {
            foreach ($outputarr as $ewe => $st) {
                $oi[] = key($st);
            }

            $io = array_unique($oi);

            foreach ($io as $ew => $mnb) {

                $rightcount[$mnb] = array('type' => 'quarter', 'year' => array());

            }

            foreach ($outputarr as $iuy => $eq) {

                array_push($rightcount[key($eq)]['year'], $eq[key($eq)]);


            }


//        echo '<pre>';
//        var_dump($particle);
//echo '<pre>';

            function keys_alter(&$kkey, $keysre)
            {

                foreach ($kkey['year'] as $demolish => $particle) {
                    $hern[key($particle)] = array($keysre);
                    //               $kkey = $hern;


                }

                foreach ($kkey['year'] as $effort => $part3) {

                    if ($hern[key($part3)][0] == $keysre) {

                        if ($hern[key($part3)] !== null) {

                            array_push($hern[key($part3)], $part3[key($part3)]);


                        }
                    }
                }

                foreach ($hern as $reter => $lwx) {
                    //         var_dump($hern[$reter][0]);

                    array_splice($hern[$reter], 0, 1);

                    $kkey['year'] = $hern;

                }

            }

            array_walk($rightcount, 'keys_alter');

            $totalarrforxpath = $rightcount;


//            echo '<pre>';
//            var_dump($totalarrforxpath);
//            echo '<pre>';

    }
    } else {
        $totalarrforxpath = $commonarr;

        echo "Скрипт ранее не запускался, все данные в таблицы грузим по новой, как впервые";
//        echo '<pre>';
//        var_dump($totalarrforxpath);
//        echo '<pre>';
    }

    return $totalarrforxpath;

}

function formStringForXpath($totalarrforxpath)

{
        global $unitestr;


        $inr = 0;

    foreach ($totalarrforxpath as $xpathstring => $elem) {
        foreach ($elem['year'] as $dire => $aks) {
            $xpathyears[] = $dire;
        }
        }


    $inr = 0;

        foreach ($xpathyears as $laterthen2016) {
            if ($laterthen2016 >= 2018) {

                $finprocessing[] = $laterthen2016;

            }

        }

    $ru = array_unique($finprocessing);

    foreach($ru as $unqueyearsonly) {
 //       $transf = array_unique($finprocessing);

        if ($inr == 0) {
            $compoundxpath[] = "substring(@data-versions-items,1,4)=" . $unqueyearsonly . "";
        } else {
            $compoundxpath[] = "or substring(@data-versions-items,1,4)=" . $unqueyearsonly . "";
        }

        $inr++;
    }

    $unitestr = implode(" ", $compoundxpath);

    return $unitestr;

     /*
        $array_meged=array();
        foreach($a as $child){
            $array_meged += $child;
        }
/*

    }



/*
                foreach () {

                }
                substring(@data - versions - items, 1, 4) = "2021" or
                substring(@data - versions - items, 1, 4) = "2020" or substring(@data - versions - items, 1, 4) = "2019" or
                substring(@data - versions - items, 1, 4) = "2018" or substring(@data - versions - items, 1, 4) = "2017" or
                substring(@data - versions - items, 1, 4) = "2016"
    */
 //    echo '<pre>';
 //var_dump($totalarrforxpath);
// echo '<pre>';



}

?>