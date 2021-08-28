<?php

class MapScript
{
    public function script($newTrolls = null)
    {
        ?>
        <div id="map" style="width: 100%; height:500px"></div>

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
        <script type="text/javascript">
            ymaps.ready(init);

            function init() {
                var myMap = new ymaps.Map("map", {
                    center: [<?php echo $newTrolls[0]['position']; ?>],
                    zoom: 16
                }, {
                    searchControlProvider: 'yandex#search'
                });

                var myCollection = new ymaps.GeoObjectCollection();
                <?php foreach ($newTrolls as $newTroll): ?>
                var myPlacemark = new ymaps.Placemark([
                    <?php echo $newTroll['position']; ?>
                ], {
                    hintContent: 'brrr',
                    balloonContent: '<?php
                        switch ($newTroll['type']) {
                            case 1:
                                $type = 'Троллейбус';
                                break;
                            case 2:
                                $type = 'Автобус';
                                break;
                            case 3:
                                $type = 'Трамвай';
                                break;
                        }
                        echo
                            $type . ' №' .
                            $newTroll['number'] . ' ' .
                            $newTroll['speed'] . ' ' .
                            'км/ч'; ?>'
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '<?php
                        switch ($newTroll['type']) {
                            case 1:
                                $typeIcon = 'icons/eBus.png';
                                break;
                            case 2:
                                $typeIcon = 'icons/bus.png';
                                break;
                            case 3:
                                $typeIcon = 'icons/train.png';
                                break;
                        }
                        echo $typeIcon;
                        ?>',
                    iconImageSize: [30, 30],

                });
                myCollection.add(myPlacemark);
                <?php endforeach; ?>

                myMap.geoObjects.add(myCollection);
            }
        </script>
        <div id="map" style="width: 100%; height:500px"></div>

        <?php
    }
}

?>