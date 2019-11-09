<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

  <?php

	$sqlserver = "localhost";
	$sqluser = "root";
	$sqlpass = "";
	$sqlbase = "lk";
 
$connection = mysqli_connect($sqlserver, $sqluser, $sqlpass, $sqlbase);

    if (!$connection) {
        echo "Ошибка: Невозможно установить соединение с MySQL<br>";
        echo "<br>Код ошибки errno: " . mysqli_connect_errno();
        echo "<br>Текст ошибки error:" . mysqli_connect_error();
        exit;
    }

$image = addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
$but = $_POST['commoditycard'];
$query = "INSERT INTO pl (id,img,discript) VALUES('','$image','$but')";  
$qry = mysqli_query($connection, $query);
    ?>
    
    <h2>Спасибо! Картинка и описание загружены в базу данных</h2>
</body>
</html>