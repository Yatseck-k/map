<!DOCTYPE html>
<body lang="ru">
<header>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Map_Krd</title>
</header>
<body>
<div class="zag">
    <p>
    <h1>Общественный транспорт Краснодара</h1>
</div>
<!-- <div class="radio">
    <form  method="post">
        <p>
            <input type="checkbox" checked name="typeOT" value="eBus"/>Троллейбус
        </p>
        <p>
            <input type="checkbox" name="typeOT" value="bus"/>Автобус
        </p>
        <p>
            <input type="checkbox" name="typeOT" value="train"/>Трамвай
        </p>
        <p>
            <button type="submit" value="submit">Выбрать</button>
        </p>
    </form>
</div> -->
<?php
/*
 * тип пс, (1 — троллейбус, 2 — автобус, 3 — трамвай), номер, координаты, скорость, угол к северу, бортовой номер
 * longitude - долгота latitude - широта
 */
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
$scripts = new MapScript();

//дефолты
$position = '45.02,38.59';
$type = 'Некий транспорт';
$typeIcon = 'icons/default.png';
$data = file_get_contents('http://www.marsruty.ru/krasnodar/gps.txt');
if (!$data) {
    error_reporting(0);
    echo 'Данные недоступны';
    exit();
}
$keys = array('type', 'number', 'longitude', 'latitude', 'speed', 'angle', 'tailNumber', 'position');
$data = explode(chr(10), $data);

// разбиваем по типу ОТ и исключаем технический транспорт
foreach ($data as $idData => $valueData) {
    if (substr($valueData, 0) == 1) {
        $eBus[] = $valueData;
    }
    if (substr($valueData, 0) == 2) {
        $bus[] = $valueData;
    }
    if (substr($valueData, 0) == 3) {
        $train[] = $valueData;
    }
}

$typesOT = array(
    0 => $eBus,
    1 => $bus,
    2 => $train,
);
/*
if ($_POST['typeOT']) {
    $answer = $_POST['typeOT'];
    if ($answer == "eBus") {
        unset($bus, $train);
    }
    if ($answer == "bus") {
        unset($eBus, $train);
    }
    if ($answer == "train") {
        unset($eBus, $bus);
    }
}
*/
foreach ($typesOT as $idType => $valueType) { //проходим по всем типам ОТ
    foreach ($valueType as $idUnit => $valueUnit) {  //проходим по каждому отдельной единице в типе
        $unit[] = explode(',', $valueUnit);
    }
}
$idOT = 0;
foreach ($unit as $id => $value) {
    if (!$unit) {
        continue;
    }
    $exitUnit = array_combine($keys, $unit[$idOT]); //смешиваем единицы транспорта с человекочитаемыми ключами
    $exitUnit['longitude'] = substr_replace($exitUnit['longitude'], '.', 2, 0);
    $exitUnit['latitude'] = substr_replace($exitUnit['latitude'], '.', 2, 0);
    $exitUnit['position'] = $exitUnit['latitude'] . ',' . $exitUnit['longitude']; // запихиваем преобразованную долготу и широту в геометку
    $idOT++;
    $transports[] = $exitUnit;
}

print '
    <div class="map" >
        ' . $scripts->script($transports) . '
    </div> 
    ' ?>

<div class="scheme">
    <p>
    <h2>Схема маршрутов</h2>
    <a href="scheme/eBusScheme.jpg"> <img src="icons/eBus.png" alt="Схема троллейбусных маршрутов"> </a>
    <a href="scheme/busScheme.jpg"> <img src="icons/bus.png" alt="Схема автобусных маршрутов"> </a>
    <a href="scheme/trainScheme.jpg"> <img src="icons/train.png" alt="Схема трамвайных маршрутов"> </a>
</div>
</body>


<footer>
    <div class="footer">
        &copy;Yatseck_map_project
    </div>
</footer>
