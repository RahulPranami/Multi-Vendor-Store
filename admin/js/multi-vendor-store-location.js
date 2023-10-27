(function ($) {
    "use strict";
    const access_token =
        "pk.eyJ1IjoicmFodWxwcmFuYW1pLWJpenRlY2giLCJhIjoiY2xvOGNoZGNmMDBhbjJxa2xjNGNidHFmZyJ9.CqSMl873hAXDund1IEQL8A";

    mapboxgl.accessToken = access_token;

    const marker = new mapboxgl.Marker();
    const map = new mapboxgl.Map({
        container: "map",
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: "mapbox://styles/mapbox/streets-v12",
        zoom: 9,
    });

    marker
        .setLngLat([
            $("#store-branch-longitude").val(),
            $("#store-branch-latitude").val(),
        ])
        .addTo(map);

    map.flyTo({
        center: [
            $("#store-branch-longitude").val(),
            $("#store-branch-latitude").val(),
        ],
        zoom: 8,
        duration: 2000,
        offset: [100, 50],
    });

    map.on("click", function (e) {
        // var pointer = new mapboxgl.Marker()
        marker.setLngLat(e.lngLat).addTo(map);
        console.log(e);

        // Set input box values to latitude and longitude
        $("#store-branch-latitude").val(e.lngLat.lat);
        $("#store-branch-longitude").val(e.lngLat.lng);
        $("#store-branch-location-fetched").val("");
        $("#store-branch-location-fetched").attr("readonly", false);
    });

    $(document).on("click", ".location", function () {
        marker.remove();

        $("#store-branch-location-fetched").val($(this).data("displayname"));
        $("#store-branch-latitude").val($(this).data("latitude"));
        $("#store-branch-longitude").val($(this).data("longitude"));

        // Create a new marker.
        marker
            .setLngLat([$(this).data("longitude"), $(this).data("latitude")])
            .addTo(map);

        map.flyTo({
            center: [$(this).data("longitude"), $(this).data("latitude")],
            zoom: 8,
            duration: 2000,
            offset: [100, 50],
        });
    });

    $("#store-branch-location").on("focusout", function () {
        let location = $(this).val();
        let url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${location}.json?access_token=${access_token}`;
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            statusCode: {
                200: function (response) {
                    $("#fetched-locations").empty();
                    console.log(response);

                    response.features.forEach((element) => {
                        $("#fetched-locations").append(
                            `<li class='fetched-location' >  <input type='radio' class='location' name='selected_location' id='${element.id}' data-longitude='${element.geometry.coordinates[0]}' data-displayname='${element.place_name}' data-latitude='${element.geometry.coordinates[1]}' /><label for='${element.id}'>${element.place_name}</label></li>`
                        );
                    });
                },
            },
        });
    });
})(jQuery);
