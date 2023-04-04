<?

spl_autoload_register(function ($classRequired) {
    require_once('../' . str_replace("\\", "/", $classRequired) . '.php');
});


$_ENV["plants"] = ['cyanotis' => 'цианотис', 'сhlorophytum' => 'хлорофитум',
    'chamaedorea' => 'хамедорея', 'ficus' => 'фикус',
    'portulacaria' => 'портулакария', 'orchid' => 'орхидея',
    'groundsel' => 'крестовник', 'conophytum' => 'конофитум',
    'cardamom' => 'кардамон', 'kalanchoe' => 'каланхоэ', 'cranesbill' => 'герань',
    'bowiea' => 'бовиэя', 'begonia' => 'бегония',
    'anthurium' => 'антуриум', 'azalea' => 'азалия',
    'adromischus' => 'адромискус', 'zamioculcas' => 'замиокулькас', 'sansevieria' => 'сансевиерия',
    'aglaonema' => 'аглаонема', 'alocasia' => 'алоказия', 'aspidistra' => 'аспидистра', 'vriesea' => 'вриезия',
    'gardenia' => 'гардения', 'hydrangea' => 'гортензия', 'granatum' => 'гранат', 'tuftroot' => 'диффенбахия',
    'calathea' => 'калатея', 'camellia' => 'камелия', 'codiaeum' => 'кодиеум',
    'cordyline' => 'кордилина', 'crassula' => 'крассула', 'lemon-tree' => 'лимонное_дерево',
    'nolina' => 'нолина', 'mandarin-tree' => 'мандариновое_дерево',
    'sword-fern' => 'нефролепсис', 'olive-tree' => 'оливковое_дерево',
    'philodendron' => 'филодендрон', 'bauhinia' => 'баухиния', 'strelitzia' => 'стрелиция',
    'albuka' => 'альбука_прицветиковая', 'vorsleya' => 'ворслея', 'gelikonia' => 'геликония',
    'sensitive-plant' => 'мимоза_стыдливая', 'chamaecyparis' => 'кипарисовик', 'buvardia' => 'бувардия',
    'pitcher-plant' => 'саррацения', 'abelia' => 'абелия', 'abelmosh' => 'абельмош',
    'agapantus' => 'агапантус', 'agave' => 'агава',
    'averrhoa' => 'аверойя', 'abutilon' => 'абутилон', 'adenathos' => 'аденатос',
    'balzamin' => 'бальзамин', 'bambusa' => 'бамбук',
    'elephants-ear' => 'бегония_цветущая', 'gasteria' => 'гастерия', 'gesneria' => 'геснерия',
    'gerbera' => 'гербера', 'hedichium' => 'гедихиум', 'hemanthus' => 'гемантус'];

$_ENV["config"] = json_decode(file_get_contents("../config.json"), true);

$router = new Routing\Router2();
$router->serveAttendantRequest();

