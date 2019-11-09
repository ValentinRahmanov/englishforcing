<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link href="styles/site.css" rel="stylesheet">
        <title>
            Интернет-магазин
        </title>
</head>
<body>
<header>
            <div id="headerInside">
                <div id="logo"></div>
                <div id="companyName">Cheep Books</div>
                <div id="navWrap">
                    <a href="index.html">
                        Главная
                    </a>
                </div>
            </div>
    </header>
    <br />

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

$sql = "SELECT id, img, discript FROM pl ORDER BY id";
$sth = $connection->query($sql);
while ($result=$sth->fetch_array()) {
echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'"/>';
echo $result['id'];
echo $result['log']. '<br />';
echo $result['discript'] . '<hr />';
}

?>
<footer>
            ©2018-2019. Интернет-магазин книг "Cheep Books". Все права защищены.
    </footer>
</body>
</html>