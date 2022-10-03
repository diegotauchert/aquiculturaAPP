<div id="mapa">
    <div id="map_canvas" class="contact-map"></div>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrLeIHmhTz63VCfuJIa3BbrbNIYK5wTXQ"></script>
    <script>
        function initialize() {
            var myLatlng = new google.maps.LatLng(-10.9576368,-37.046923);

            var styleArray = [
                {
                    "stylers": [
                        {"hue": "#014978"},
                        {"saturation": 1},
                        {"lightness": 1},
                        {"gamma": 1},
                        {"invert_lightness": true}
                    ]
                }
            ];

            var mapOptions = {
                zoom: 14,
                center: myLatlng,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                scaleControl: true,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP
                },
                fullscreenControl: false,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                scrollwheel: false
            };

            var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            var infowindow1 = new google.maps.InfoWindow({
                content: '<div class="map_marker"><strong>Camp Perrin</strong><br />Rua Jornalista João Batista de Santana - Coroa do Meio, Aracaju - SE</div>'
            });

            var marker1 = new google.maps.Marker({
                position: new google.maps.LatLng(-10.9576368,-37.046923),
                map: map,
                title: "Camp Perrin"
            });

            google.maps.event.addListener(marker1, 'click', function () {
                $('.representantes .content').fadeOut(250, function() {
                                var t = $(this);
                                var f = $('<button class="btn btn-outline-primary border-0 float-right" type="button"><span class="fas fa-times"></span></button>')
                                t.html(infowindow1.content).prepend(f).fadeIn(250);
                                f.click(function() {
                                    t.fadeOut(250);
                                });
                            });
                //infowindow1.open(map, marker1);
            });

        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
</div>
