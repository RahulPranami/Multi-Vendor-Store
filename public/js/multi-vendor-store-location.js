(function ($) {
    "use strict";

    const access_token =
        "pk.eyJ1IjoicmFodWxwcmFuYW1pLWJpenRlY2giLCJhIjoiY2xvOGNoZGNmMDBhbjJxa2xjNGNidHFmZyJ9.CqSMl873hAXDund1IEQL8A";

    mapboxgl.accessToken = access_token;

    const marker = new mapboxgl.Marker();
    const map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v12",
    });

    if (typeof stores === "object" && stores !== null) {
        const locations = Object.entries(stores.locations);

        if (0 !== locations.length) {
            let coordinates = [];
            locations.forEach(([id, location]) => {
                new mapboxgl.Marker().setLngLat(location).addTo(map);
                coordinates.push(location);
            });

            if (1 !== coordinates.length) {
                const boundingBox = new mapboxgl.LngLatBounds();
                coordinates.forEach((coord) => boundingBox.extend(coord));
                map.fitBounds(boundingBox);
            } else {
                const lastCoord = coordinates[coordinates.length - 1];
                map.flyTo({
                    center: lastCoord,
                    zoom: 8,
                    duration: 5000,
                });
            }
        }
    }

    if ($("#store-latitude").val() && $("#store-longitude").val()) {
        marker
            .setLngLat([
                $("#store-longitude").val(),
                $("#store-latitude").val(),
            ])
            .addTo(map);

        setTimeout(() => {
            map.flyTo({
                center: [
                    $("#store-longitude").val(),
                    $("#store-latitude").val(),
                ],
                zoom: 8,
                duration: 5000,
            });
        }, 1000);
    }
})(jQuery);
