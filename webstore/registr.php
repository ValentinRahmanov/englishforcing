<?php
    session_start();

if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} }

    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password == '') { unset($password);} }
    
if (empty($login) or empty($password)) 
    
    {
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }
    
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
$password = stripslashes($password);
    $password = htmlspecialchars($password);

    $login = trim($login);
    $password = trim($password);

    include ("connection.php"); 
 
$bin = "SELECT id, log, pass FROM auth WHERE log='$login'";
$ht = $connection->query($bin);
$myrow1 = $ht->fetch_array();
echo $myrow1['id'];
echo $myrow1['log'];
$a = $myrow1['pass'];

    if ($myrow1['log'] == '')
    {

    exit ("Извините, введённый вами login или пароль неверен.");
    }

include ("password.php");

if (password_verify($password, $a)) {
    $_SESSION['login']=$myrow1['log']; 
    $_SESSION['id']=$myrow1['id'];
    
    echo "Вы успешно вошли на сайт! <a href='adminka.html'>Админка (для сотрудников магазина)</a>";
    }
 else {

    exit ("Извините, введённый вами login или пароль неверный.");
    }
    ?>