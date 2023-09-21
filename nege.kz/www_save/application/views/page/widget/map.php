<div class="section">
    <div id="YMapsID" style="width: 100%; height: 450px;">
</div>
<script>
    <?php
        $points = ORM::factory('Point');
        $points_list = array();
        foreach($points->find_all() as $point){
            $points_list[] = array("lat"=>$point->lat, "lng"=>$point->lng, "title"=>$point->title);
        };
        $points_list = json_encode($points_list);
    ?>
    var map_data = <?=$points_list?>;
</script>
<script type="text/javascript">
    var myMap;
    ymaps.ready(function () {
        myMap = new ymaps.Map("YMapsID", {
            center: [51.18428912306394, 71.44768041992188],
            zoom: 11
        });
        myMap.behaviors.disable('scrollZoom');
        for(var i = 0; i < map_data.length; i++){
            myMap.geoObjects.add(new ymaps.Placemark([map_data[i].lat, map_data[i].lng], {
                balloonContent: map_data[i].title
            }, {
                preset: 'islands#dotIcon',
                iconColor: '#735184'
            }));
        }
    });
</script>
