<!DOCTYPE html>
    <head>
    <?php
    if(empty(is_string($_ENV['content']))) {
        echo '<title>' . 'Комнатные растения' . '</title>';
        echo '<meta name="description" content="Сайт о разных видах комнатных растений, содержит статьи об отдельных растениях с рекомендациями по уходу, интересными фактами, описанием особенностей и важных характеристик">';
        echo '<meta name="keywords" content="Растения, Домашние, Комнатные, Факты, Уход, Рекоммендации, Разведение, Выращивание, Какое растение завести дома, Растение на подоконник,">';
        echo '<meta property="og:title" content="Комнатные растения -а" />';
    } else {

        echo '<title>' . $_ENV['content'] . '</title>';
        echo '<meta name="description" content="Статья о том, как ухаживать за ' . $_ENV['content'] . ', об особенностях растения, полезые советы и лайфхаки, советы по разведению">';
        echo '<meta name="keywords" content="' . $_ENV['content'] . ', Уход, Разведение, О растении, Факты, Особенности, Полезные советы, Характеристика, Разведение в домашних условиях, Завести">';
    }
    ?>

    <link rel="shortcut icon" href="http://f90577wq.beget.tech/favicon.ico" type="image/x-icon" />


    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Комнатные растения"
    <meta property="og:url" content="http://f90577wq.beget.tech/">
    <meta property="og:image" content="http://f90577wq.beget.tech/house-plants.jpg">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:description" content="Сайт о разных видах комнатных растений, содержит статьи об отдельных растениях с рекомендациями по уходу, интересными фактами, описанием особенностей и важных характеристик">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <meta name="yandex-verification" content="b229aff208bfc665" />
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(92453722, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/92453722" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="/">Комнатные растения</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">На главную<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://f90577wq.beget.tech/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Меню</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Контакты</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
        </form>
      </div>
    </nav>
