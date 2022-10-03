<div id="mapa">
    <div id="map_canvas" class="representante-map"></div>
    <div class="col-md-5 col-lg-4 h-100 representantes d-flex">
        <div class="shadow p-4 my-auto w-100 content"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key="></script>
    <script>
        var mark = [];
        var infoMark = [];
        var markReg = [];
        var infoMarkReg = [];

        function initialize() {
            var myLatlng = new google.maps.LatLng(-15.7997067, -47.8663516);

            var styleArray = [{
                "stylers": [{
                        "hue": "#014978"
                    },
                    {
                        "saturation": 1
                    },
                    {
                        "lightness": 1
                    },
                    {
                        "gamma": 1
                    },
                    {
                        "invert_lightness": true
                    }
                ]
            }];

            var mapOptions = {
                zoom: 5,
                center: myLatlng,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                scaleControl: false,
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

            $(function() {
                $.getJSON("{{ route('web.representantes.json') }}", function(resp) {
                    if (resp.representantes) {
                        $.each(resp.representantes, function(index, representante) {
                            infoMark[representante.id] = new google.maps.InfoWindow({
                                content: "<div class=\"map_marker\">" +
                                "<div class=\"row\">" +
                                "<div class=\"col py-2\">" +
                                "<div class=\"row\">" +
                                (representante.foto ? "<div class=\"col-5 col-sm-3 my-auto order-1 order-sm-0 py-2\">" : "") +
                                (representante.foto ? "<img src=\"" + representante.foto + "\" class=\"w-100\">" : "") +
                                (representante.foto ? "</div>" : "") +
                                "<div class=\"col-sm my-auto order-0 order-sm-1 py-2\">" +
                                "<p class=\"h4\">" + representante.nome + "</p>" +
                                (representante.descricao ? "<div class=\"py-3\">" : "") +
                                (representante.descricao ? representante.descricao : "") +
                                (representante.descricao ? "</div>" : "") +
                                representante.contatos +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "<div class=\"col-auto btclose py-2\">" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            });

                            mark[representante.id] = new google.maps.Marker({
                                position: new google.maps.LatLng(representante.latitude, representante.longitude),
                                map: map,
                                title: "{{ config('app.name') }}"
                            });

                            google.maps.event.addListener(mark[representante.id], 'click', function () {
                                $('.representantes .content').fadeOut(250, function() {
                                    var t = $(this);
                                    var f = $('<button class="btn btn-outline-primary border-0 float-right" type="button"><span class="fas fa-times"></span></button>')
                                    t.html(infoMark[representante.id].content).fadeIn(250);
                                    $('.btclose', t).append(f);
                                    f.click(function() {
                                        t.fadeOut(250);
                                    });
                                });
                            });

                            $('[data-toggle="tooltip"], .o-tooltip', infoMark).tooltip({html: true, container: 'body'});
                        });
                    }

                    if (resp.regioes) {
                        $.each(resp.regioes, function(index, regiao) {
                            markReg[regiao.id] = new google.maps.Polygon({
                                paths: regiao.coords,
                                strokeColor: '#0e635a',
                                strokeOpacity: 0.8,
                                strokeWeight: 3,
                                fillColor: '#0e635a',
                                fillOpacity: 0.35
                            });
                            markReg[regiao.id].setMap(map);

                            var infoHtml = "<div class=\"map_marker\">" +
                                "<div class=\"row\">" +
                                "<div class=\"col\">" +
                                "<div class=\"list-group list-group-flush\">";

                                $.each(regiao.representantes, function(index, representante) {
                                    infoHtml += "<div class=\"list-group-item row py-2 px-0\">" +
                                        (representante.foto ? "<div class=\"col-5 col-sm-3 my-auto order-1 order-sm-0 py-2\">" : "") +
                                        (representante.foto ? "<img src=\"" + representante.foto + "\" class=\"w-100\">" : "") +
                                        (representante.foto ? "</div>" : "") +
                                        "<div class=\"col-sm my-auto order-0 order-sm-1 py-2\">" +
                                        "<p class=\"h4\">" + representante.nome + "</p>" +
                                        (representante.descricao ? "<div class=\"py-3\">" : "") +
                                        (representante.descricao ? representante.descricao : "") +
                                        (representante.descricao ? "</div>" : "") +
                                        representante.contatos +
                                        "</div>" +
                                        "</div>"
                                });

                            infoHtml += "</div>" +
                                        "</div>" +
                                        "<div class=\"col-auto btclose py-2\">" +
                                        "</div>" +
                                        "</div>" +
                                        "</div>";

                            infoMarkReg[regiao.id] =
                            new google.maps.InfoWindow({
                                content: infoHtml
                            });

                            google.maps.event.addListener(markReg[regiao.id], 'click', function () {
                                $('.representantes .content').fadeOut(250, function() {
                                    var t = $(this);
                                    var f = $('<button class="btn btn-outline-primary border-0 float-right" type="button"><span class="fas fa-times"></span></button>')
                                    t.html(infoMarkReg[regiao.id].content).fadeIn(250);
                                    $('.btclose', t).append(f);
                                    f.click(function() {
                                        t.fadeOut(250);
                                    });
                                });
                            });
                        });
                    }
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</div>
