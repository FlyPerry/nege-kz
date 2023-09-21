/**
 * Created with JetBrains PhpStorm.
 * User: sgm
 * Date: 19.11.13
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */
(function($){
    MapLib={};
    MapLib.init=function(el,lat,lng){
        var center=[];
        var zoom=12;
        if (lat && lng){
            center = [lat,lng];
            zoom=17;
        } else {
            center=[51.18428912306394, 71.44768041992188];
        }
        var map = new ymaps.Map(el.get(0), {
            center: center,
            zoom: zoom
        });
        map.controls.add('zoomControl');
        map.controls.add('searchControl');
        map.setType('yandex#publicMap');
        map.behaviors.enable('scrollZoom');
        return map;
    }

    MapLib.typeahead=function (el, options, map) {
        var input = el.get(0);
        el.keypress(function(e){
            if (e.keyCode==13){
                return false;

            }
        });
        autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            //   infowindow.close();
            var place = this.getPlace();
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                //tonw.map.setZoom(17);  // Why 17? Because it looks good.
            }


        });
        return autocomplete;
    }
})(jQuery);