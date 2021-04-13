<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
    <style>
        .map {
            width: 100%;
            height:600px;
        }
        .ol-popup {
            position: absolute;
            background-color: white;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            bottom: 12px;
            left: -50px;
            min-width: 280px;
        }
        .ol-popup:after, .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 48px;
            margin-left: -10px;
        }
        .ol-popup:before {
            border-top-color: #cccccc;
            border-width: 11px;
            left: 48px;
            margin-left: -11px;
        }
        .ol-popup-closer {
            text-decoration: none;
            position: absolute;
            top: 2px;
            right: 8px;
        }
        .ol-popup-closer:after {
            content: "✖";
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>

    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>


    <script type="text/javascript">
        // Vector source for markers
        var vectorSource = new ol.source.Vector({
            features: [
                new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([-119.814972, 39.530895]))
                })
            ]
        })

        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                new ol.layer.Vector({
                    source: vectorSource
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-119.814972, 39.530895]),
                zoom: 11
            })
        });

        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');

        var overlay = new ol.Overlay({
            element: container,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });
        map.addOverlay(overlay);

        closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };

        map.on("singleclick", function(event) {

            var latLong = ol.proj.transform(event.coordinate, 'EPSG:3857', 'EPSG:4326');
            var long    = latLong[0];
            var lat     = latLong[1];

            console.log("Click! Long: " + long + ", Lat: " + lat);

            if (map.hasFeatureAtPixel(event.pixel) === true) {
                // Spot already exists at location, bring up details
                var coordinate = event.coordinate;

                content.innerHTML = '<b>Hello world!</b><br />I am a popup.';
                overlay.setPosition(coordinate);
            } else {
                // No spot, prompt to create one

                var newfeature = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([long, lat]))
                })

                vectorSource.addFeature(newfeature);

                //overlay.setPosition(undefined);
                //closer.blur();
            }
        });
    </script>
</x-app-layout>
