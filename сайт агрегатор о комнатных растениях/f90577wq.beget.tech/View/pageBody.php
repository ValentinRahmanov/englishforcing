
<div class="container">
 <div class="row">
    <div class="col">Этот текст расположен внутри сетки Bootstrap</div>
    <div class="col">
        <?php
        echo '<h1>' . $_ENV['content'][0]['title'] . '</h1>';
        echo '<br />';
        foreach($_ENV['content'] as $oneChepter => $oneChepterContent) {
            echo $_ENV['content'][$oneChepter]['text'];
            echo '<h2>Ссылка на источник:</h2>' . $_ENV['content'][$oneChepter]['link'];
        }
    
    
    ?>
    </div>
    <div class="col">Этот текст расположен внутри сетки Bootstrap</div>
 

</div>
</div>
