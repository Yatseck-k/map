<?php
$data = file_get_contents('http://www.marsruty.ru/krasnodar/gps.txt');
if (!$data) {
    echo 'Данные недоступны';
    exit();
}
$keys = array('type', 'number', 'dolgota', 'shirota', 'speed', 'angle', 'bortNumber', 'break');

$data = explode(chr(10), $data);
//эксперемент перечисления массивов
$troll[] = null;
$bus[] = null;
$tram[] = null;

$typeOT = array(
    0 => $troll,
    1 => $bus,
    2 => $tram,
);
$idType = 0;

foreach ($data as $ot => $value) { // разбиваем по типу ОТ
    // echo $ot . ' ' . $value . PHP_EOL;
    if (substr($value, 0) == 1) {
        $troll[] = $value;
    }
    if (substr($value, 0) == 2) {
        $bus[] = $value;
    }
    if (substr($value, 0) == 3) {
        $tram[] = $value;
    }
}
//foreach ($typeOT as $anyOne) {
foreach ($troll as $id => $value) {
    $oneTroll[] = explode(',', $value);


}
$idTroll = 0;
foreach ($oneTroll as $anyTwo => $value) {
    if (!$oneTroll) {
        continue;
    }
    $newTroll = array_combine($keys, $oneTroll[$idTroll]);

    $newTroll['dolgota'] = substr_replace($newTroll['dolgota'], '.', 2, 0);
    $newTroll['shirota'] = substr_replace($newTroll['shirota'], '.', 2, 0);
    $position = $newTroll['shirota'] . ',' . $newTroll['dolgota'];
    $idTroll++;
}

?>

<div id="map" style="width: 100%; height:500px"></div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
            center: [<?php echo $position; ?>],
            zoom: 16
        }, {
            searchControlProvider: 'yandex#search'
        });

        var myCollection = new ymaps.GeoObjectCollection();

        // Добавим метку красного цвета.
        var myPlacemark = new ymaps.Placemark([
            <?php echo $position; ?>
        ], {
            hintContent: 'бррр ',
            balloonContent: '<?php echo
                'Тип ОТ:' .
                $newTroll['type'] .
                ' Номер ОТ:' .
                $newTroll['number'] .
                ' Скорость:' .
                $newTroll['speed']; ?>'
        }, {
            iconLayout: 'default#image',
            iconImageHref: 'bus.png',
            iconImageSize: [30, 30],

        });
        myCollection.add(myPlacemark);

        myMap.geoObjects.add(myCollection);
    }
</script>
<div id="map" style="width: 100%; height:500px"></div>
