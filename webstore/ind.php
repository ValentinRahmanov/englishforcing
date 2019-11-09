<?php
    
    session_start();
    ?>
    <html>
    <head>
        <meta charset="UTF-8">
        <link href="styles/site.css" rel="stylesheet">
        <title>
            Авторизируйтесь
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
                    <a href="catalogue.php">
                        Магазин
                    </a>
                </div>
            </div>
        </header>
        <div id="glue">
    <h2>Авторизация</h2>
    <form action="registr.php" method="post">

 <p>
    <label>Ваш логин:<br></label>
    <input name="login" type="text" size="15" maxlength="15">
    </p>

    <p>
    <label>Ваш пароль:<br></label>
    <input name="password" type="password" size="15" maxlength="15">
    </p>

    <p>
    <input type="submit" name="submit" value="Войти">

<br>
 

    </p></form>
    <br>
    <?php
   
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {

    echo "Вы вошли на сайт, как гость<br><a href='#'>Эта ссылка  доступна только зарегистрированным пользователям</a>";
    }
    else
    {

    echo "Здравствуйте," . $_SESSION['login'];
    
    }

    ?>
        </div>
        <div id="kla">
            
        </div>
        <footer>
            ©2018-2019. Интернет-магазин книг "Cheep Books". Все права защищены.
    </footer>
    
</body>
</html>