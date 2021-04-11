<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
    <style>
        .map {
            height: 600px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>

    <div id="map" class="map"></div>
    <script type="text/javascript">
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-119.814972, 39.530895]),
                zoom: 11
            })
        });

        self.map.on("singleclick", function(evt) {
            var self = this;

            var latLong = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
            var lat     = latLong[1];
            var long    = latLong[0];

            console.log("Click! " + lat + ", " + long);
        });
    </script>
</x-app-layout>
