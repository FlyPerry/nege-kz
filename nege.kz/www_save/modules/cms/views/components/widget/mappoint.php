<div class="mappoint" id="<?=$id?>">
    <?php
    echo Arr::get($elements,'address','');
    echo Arr::get($elements,'lat','');
    echo Arr::get($elements,'lng','');
    ?>
    <div class="control-group">
        <label class="control-label">Выберите точку на карте:</label>
        <div class="controls"><div class="map"  style="height: 500px"></div></div>
    </div>

    <script type="text/javascript">
        $(function(){



            var init=function(){
                var id="<?=$id?>";
                var widget=$('#'+id);
                var town=$('<input type="hidden"  name="town"/>');
                widget.append(town);

                var marker=null;
                var map=null;
                var lat=parseFloat(widget.find('input[role="lat"]').val());
                var lng=parseFloat(widget.find('input[role="lng"]').val());
                var address=widget.find('input[role="address"]');
                if (lat && lng){
                    marker =new ymaps.Placemark([lat, lng],{iconImageHref:'/images/wifi_icon_map.png'});
                    map=MapLib.init(widget.find('.map'),lat,lng);
                    map.geoObjects.add(marker);
                } else {
                    map=MapLib.init(widget.find('.map'));
                }

                map.events.add('click',function(e){
                    var coords= e.get('coordPosition');
                    if (marker){
                        map.geoObjects.remove(marker);
                    }

                    marker = new ymaps.Placemark(coords,{iconImageHref:'/images/wifi_icon_map.png'});
                    map.geoObjects.add(marker);

                    ymaps.geocode(coords).then(function (res) {
                        var names = [];
                        // Переберём все найденные результаты и
                        // запишем имена найденный объектов в массив names
                        res.geoObjects.each(function (obj) {
                            names.push(obj.properties.get('name'));
                        });
                        console.log(names);
                        widget.find('input[role="address"]').val(names[0]);
                        town.val(names.reverse().join(';'));


                    });
                    widget.find('input[role="lat"]').val(coords[0]);
                    widget.find('input[role="lng"]').val(coords[1]);

                });
//                if (address.length>0)
//                {
//                    MapLib.typeahead(address,{
//                        //   bounds: defaultBounds,
//                        types:['geocode']
//                    },map);
//                }
//                google.maps.event.addListener(map, 'click', function (e) {
//                        if (marker != null) {
//                            marker.setPosition(e.latLng);
//                        } else {
//
//                            marker = new google.maps.Marker({
//                                position:e.latLng,
//                                map:map
//                            });
//                        }
//    //                    map.setCenter(e.latLng);
//                        widget.find('input[role="lat"]').val(e.latLng.lat());
//                        widget.find('input[role="lng"]').val(e.latLng.lng());
//
//                });
            }

            ymaps.ready(init);
        });
    </script>
</div>