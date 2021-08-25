<?php
$data = file_get_contents('http://www.marsruty.ru/krasnodar/gps.txt');
$keys = array('type', 'number', 'dolgota', 'shirota', 'speed', 'angle', 'bortNumber', 'break');

$data = explode(chr(10), $data);
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
foreach ($troll as $id => $value) {
    $oneTroll[] = explode(',', $value);

}
$count = count($oneTroll);
$count = $count -1;
for ($i = 0; $i == 35; $i++) {
   // $newTroll = array_combine($keys, $oneTroll[$idTroll]);
    echo $i;
}


//echo count($keys) . PHP_EOL;
//echo count($oneTroll[]) . PHP_EOL;

//$objectTroll = (object)$oneTroll;
//print_r($keys);
//print_r($bus). PHP_EOL;
//print_r($tram). PHP_EOL;



