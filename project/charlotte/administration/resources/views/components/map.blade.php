@php
$id = uniqid();
$lat = (empty($options['default_values']['lat'])) ? 42.698334 : $options['default_values']['lat'];
$lng = (empty($options['default_values']['lng'])) ? 23.319941 : $options['default_values']['lng'];
$zoom = (empty($options['default_values']['zoom'])) ? 13 : $options['default_values']['zoom'];
@endphp
<div class="form-group col-sm-12 without-language ">
    <div class="m-b-20" id="{{$id}}" style="width: 100%; height: 350px;"></div>
</div>

<input id="lat_{{$id}}" name="lat" type="hidden" value="{{ $lat }}">
<input id="lng_{{$id}}" name="lng" type="hidden" value="{{ $lng }}">

@section('js')
    <script>
        let id = '{{$id}}';
        let default_lat = parseFloat('{{$lat}}');
        let default_lng = parseFloat('{{ $lng }}');
        let zoom = parseInt('{{ $zoom }}');

        function initMap() {
            let options = {
                zoom: zoom,
                center: {lat: default_lat, lng: default_lng},
                styles: [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#242f3e"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#746855"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#242f3e"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.locality",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#d59563"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#d59563"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#263c3f"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#6b9a76"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#38414e"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#212a37"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9ca5b3"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#746855"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#1f2835"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#f3d19c"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#2f3948"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#d59563"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#17263c"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#515c6d"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#17263c"
                            }
                        ]
                    }
                ],
                mapTypeControlOptions: {
                    mapTypeIds: ['roadmap', 'styled_map']
                },
            };
            map = new google.maps.Map(document.getElementById(id),options);
            let marker = new google.maps.Marker({
                position:{lat: default_lat , lng: default_lng},
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            google.maps.event.addListener(marker, 'dragend', function (e) {
                let gpsLat = document.querySelector('#lat_' + id);
                let gpsLng = document.querySelector('#lng_' + id);
                gpsLat.setAttribute('value', e.latLng.lat());
                gpsLng.setAttribute('value', e.latLng.lng());
            });
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuzsQdTJRWkqZWPeRg9-8e3z76EWuYfng&callback=initMap">
    </script>

@append