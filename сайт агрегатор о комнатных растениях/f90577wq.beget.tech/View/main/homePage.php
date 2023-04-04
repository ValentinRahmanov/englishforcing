
            <br />
            <br />
            <p></p><a href="/zamioculcas">Читайте о растении Замиокулькас на нашем сайте</a></p>
            <br />
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3037487327932064"
                    crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                 style="display:block; text-align:center;"
                 data-ad-layout="in-article"
                 data-ad-format="fluid"
                 data-ad-client="ca-pub-3037487327932064"
                 data-ad-slot="2543855753"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            <br />
            <div class="container">
                <div class="row">
                    <div class="col-sm">

                        <?php
                        function showExcerpts($plants, $start = 0, $end = 10)
                        {

                            $i = 0;
                            foreach ($plants as $arrayNumber => $plant) {

                                if($i >= $start) {
                                    $url = 'http://f90577wq.beget.tech/' . $arrayNumber;

                                    $article = file_get_contents($url);

                                    if (empty($article)) {
                                        continue;
                                    }

                                    echo '<div class="row">';
                                    echo '<div class="border">';


                                    $str = substr(trim($article), 0, 6000);
                                    preg_match_all('|<p>(.+)</p>|', $str, $matches);
                                    $readyText = strip_tags("" . $matches[0][0] . "");
                                    print_r('<h2>' . $plant . '</h2>');
                                    print_r('<p>' . $readyText . '...' . '</p><p><a href=' . $url . '>Читать далее</a></p>');

                                    echo '</div>';
                                    echo '</div>';
                                    echo '<br />';
                                }
                                $i++;

                                if ($i == $end) {
                                    break;
                                }
                            }
                        }

                            if(!empty($_ENV['pagination']['start']) | !empty($_ENV['pagination']['end'])) {
                                showExcerpts($_ENV["plants"], $_ENV['pagination']['start'], $_ENV['pagination']['end']);
                            } else {
                                showExcerpts($_ENV["plants"]);
                            }

                        ?>
                        <nav aria-label="...">
                            <ul class="pagination pagination-lg">
                                <li class="page-item"><a class="page-link" href="1">1</a></li>
                                <li class="page-item"><a class="page-link" href="2">2</a></li>
                                <li class="page-item"><a class="page-link" href="3">3</a></li>
                                <li class="page-item"><a class="page-link" href="4">4</a></li>
                                <li class="page-item"><a class="page-link" href="5">5</a></li>
                                <li class="page-item"><a class="page-link" href="6">6</a></li>
                                <li class="page-item"><a class="page-link" href="7">7</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-sm">

                    </div>
                    <div class="col-sm">
                        Одна из трёх колонок
                    </div>
                </div>
            </div>