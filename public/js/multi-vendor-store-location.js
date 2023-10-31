(function ($) {
    "use strict";

    const access_token =
        "pk.eyJ1IjoicmFodWxwcmFuYW1pLWJpenRlY2giLCJhIjoiY2xvOGNoZGNmMDBhbjJxa2xjNGNidHFmZyJ9.CqSMl873hAXDund1IEQL8A";

    mapboxgl.accessToken = access_token;

    // const geojson2 = {
    //     type: "FeatureCollection",
    //     features: [
    //         {
    //             type: "Feature",
    //             properties: {
    //                 message: "Foo",
    //                 iconSize: [60, 60],
    //                 title: "Mapbox",
    //                 description: "Washington, D.C.",
    //             },
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-66.324462, -16.024695],
    //             },
    //         },
    //     ],
    // };

    // const geojson = {
    //     type: "FeatureCollection",
    //     features: [
    //         {
    //             type: "Feature",
    //             properties: {
    //                 message: "Foo",
    //                 iconSize: [60, 60],
    //                 title: "Mapbox",
    //                 description: "Washington, D.C.",
    //             },
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-66.324462, -16.024695],
    //             },
    //         },
    //         {
    //             type: "Feature",
    //             properties: {
    //                 message: "Bar",
    //                 iconSize: [50, 50],
    //                 title: "Mapbox",
    //                 description: "Washington, D.C.",
    //             },
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-61.21582, -15.971891],
    //             },
    //         },
    //         {
    //             type: "Feature",
    //             properties: {
    //                 message: "Baz",
    //                 iconSize: [40, 40],
    //                 title: "Mapbox",
    //                 description: "Washington, D.C.",
    //             },
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-63.292236, -18.281518],
    //             },
    //         },
    //     ],
    // };

    // const geojson = {
    //     type: "FeatureCollection",
    //     features: [
    //         {
    //             type: "Feature",
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-77.032, 38.913],
    //             },
    //             properties: {
    //                 title: "Mapbox",
    //                 description: "Washington, D.C.",
    //             },
    //         },
    //         {
    //             type: "Feature",
    //             geometry: {
    //                 type: "Point",
    //                 coordinates: [-122.414, 37.776],
    //             },
    //             properties: {
    //                 title: "Mapbox",
    //                 description: "San Francisco, California",
    //             },
    //         },
    //     ],
    // };

    if (document.getElementById("map")) {
        const marker = new mapboxgl.Marker();
        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v12",
        });

        if (typeof stores === "object" && stores !== null) {
            const locations = Object.entries(stores.locations);

            if (0 !== locations.length) {
                for (const feature of geojson.features) {
                    const el = document.createElement("div");
                    el.className = "marker";
                    el.style.backgroundImage = `url(${feature.properties.image})`;

                    new mapboxgl.Marker(el)
                        .setLngLat(feature.geometry.coordinates)
                        .setPopup(
                            new mapboxgl.Popup({ offset: 25 })
                                .setHTML(
                                    `<div><h4>${feature.properties.title}</h4><p>${feature.properties.description}</p></div>`
                                )
                        )
                        .addTo(map);
                }

                let coordinates = [];
                locations.forEach(([id, location]) =>
                    coordinates.push(location)
                );

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

            setTimeout(
                () =>
                    map.flyTo({
                        center: [
                            $("#store-longitude").val(),
                            $("#store-latitude").val(),
                        ],
                        zoom: 8,
                        duration: 5000,
                    }),
                1000
            );
        }
    }
})(jQuery);
