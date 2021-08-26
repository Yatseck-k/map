<!--честно вкратый скрпит -->
<div id="map" style="width: 100%; height:500px"></div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
            center: [<?php echo $list[0]['point']; ?>],
            zoom: 16
        }, {
            searchControlProvider: 'yandex#search'
        });

        var myCollection = new ymaps.GeoObjectCollection();

        <?php foreach ($list as $row): ?>
        var myPlacemark = new ymaps.Placemark([
            <?php echo $row['point']; ?>
        ], {
            balloonContent: '<?php echo $row['name']; ?>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0000ff'
        });
        myCollection.add(myPlacemark);
        <?php endforeach; ?>

        myMap.geoObjects.add(myCollection);

        // Сделаем у карты автомасштаб чтобы были видны все метки.
        myMap.setBounds(myCollection.getBounds(), {checkZoomRange: true, zoomMargin: 9});
    }
</script>
