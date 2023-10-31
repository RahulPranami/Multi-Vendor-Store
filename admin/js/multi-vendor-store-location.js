(function ($) {
    "use strict";
    const access_token =
        "pk.eyJ1IjoicmFodWxwcmFuYW1pLWJpenRlY2giLCJhIjoiY2xvOGNoZGNmMDBhbjJxa2xjNGNidHFmZyJ9.CqSMl873hAXDund1IEQL8A";
    let timer;

    mapboxgl.accessToken = access_token;

    if (document.getElementById("map")) {
        const marker = new mapboxgl.Marker();
        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v12",
        });

        if ( $("#store-branch-latitude").val() && $("#store-branch-longitude").val() ) {
            setTimeout(() => marker.setLngLat([ $("#store-branch-longitude").val(), $("#store-branch-latitude").val() ]).addTo(map), 2000);
            setTimeout(() => map.flyTo({center: [ $("#store-branch-longitude").val(), $("#store-branch-latitude").val() ], zoom: 8, duration: 5000 }), 1000);
        }

        map.on("click", function (e) {
            marker.setLngLat(e.lngLat).addTo(map);
            getLocations(`${e.lngLat.lng},${e.lngLat.lat}`);

            // Set input box values to latitude and longitude
            $("#store-branch-latitude").val(e.lngLat.lat);
            $("#store-branch-longitude").val(e.lngLat.lng);
            $("#store-branch-location-fetched").val("");
            $("#store-branch-location-fetched").attr("readonly", false);
        });

        $(document).on("click", ".location", function () {
            $(".location.active").removeClass('active');
            $(this).addClass('active');

            $("#store-branch-location-fetched").val($(this).data("displayname"));
            $("#store-branch-latitude").val($(this).data("latitude"));
            $("#store-branch-longitude").val($(this).data("longitude"));

            // Create a new marker.
            marker
                .setLngLat([
                    $(this).data("longitude"),
                    $(this).data("latitude"),
                ])
                .addTo(map);

            map.flyTo({
                center: [$(this).data("longitude"), $(this).data("latitude")],
                zoom: 8,
                duration: 2000,
            });
        });

        $("#store-branch-location").on("keyup", function () {
            delayedAutoSuggest($(this).val());
        });
    }

    function delayedAutoSuggest(value) {
        clearTimeout(timer);
        timer = setTimeout(() => getLocations(value), 1000);
    }

    function getLocations(location) {
        let url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${location}.json?access_token=${access_token}`;
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            statusCode: {
                200: function (response) {
                    $("#fetched-locations").empty();
                    $("#fetched-locations").show();
                    response.features.forEach((element) => {
                        $("#fetched-locations").append(
                            `<div class="location fetched-location" id="${element.id}" data-longitude="${element.geometry.coordinates[0]}" data-displayname="${element.place_name}" data-latitude="${element.geometry.coordinates[1]}"><span>${element.place_name}</span></div>`
                            );
                    });
                },
            },
        });
    }
})(jQuery);