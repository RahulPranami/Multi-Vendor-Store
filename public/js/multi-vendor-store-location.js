(function ($) {
    "use strict";
    const access_token = mapbox.apiKey;
    mapboxgl.accessToken = access_token;

    if (document.getElementById("map")) {
        const marker = new mapboxgl.Marker();
        const map = new mapboxgl.Map({ container: "map", style: "mapbox://styles/mapbox/streets-v12", center: [80, 36], zoom: 1, pitch: 0, bearing: 0});
        map.on("style.load", () => {
            map.setFog({
                color: 'rgb(186, 210, 235)', // Lower atmosphere
                    'high-color': 'rgb(36, 92, 223)', // Upper atmosphere
                    'horizon-blend': 0.02, // Atmosphere thickness (default 0.2 at low zooms)
                    'space-color': 'rgb(11, 11, 25)', // Background color
                    'star-intensity': 0.6 // Background star brightness (default 0.35 at low zooms )
            });
        });

        if (typeof stores === "object" && stores !== null) {
            const locations = Object.entries(stores.locations);

            if (0 !== locations.length) {
                showLocation(geojson.features);

                let coordinates = [];
                locations.forEach(([id, location]) => coordinates.push(location));

                if (1 !== coordinates.length) {
                    const boundingBox = new mapboxgl.LngLatBounds();
                    coordinates.forEach((coord) => boundingBox.extend(coord));
                    map.fitBounds(boundingBox);
                } else {
                    const lastCoord = coordinates[coordinates.length - 1];
                    map.flyTo({ center: lastCoord, zoom: 8, duration: 5000 });
                }
            }
            async function showLocation(geojson) {
                for (const feature of geojson) {
                    await new Promise((resolve) => setTimeout(resolve, 500));
                    const el = document.createElement("div");
                    el.className = "marker";
                    el.style.backgroundImage = `url(${feature.properties.image})`;

                    new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).setPopup( new mapboxgl.Popup({ offset: 25 }).setHTML( `<div><h4>${feature.properties.title}</h4><p>${feature.properties.description}</p></div>` )).addTo(map);
                }
            }
        }

        if ($("#store-latitude").val() && $("#store-longitude").val()) {
            setTimeout(() => map.flyTo({ center: [ $("#store-longitude").val(), $("#store-latitude").val() ], bearing: 10, pitch: 25, zoom: 8, duration: 5000, essential: true }), 1000);
            setTimeout(() => marker.setLngLat([$("#store-longitude").val(),$("#store-latitude").val()]).addTo(map), 2500);
        }
    }
})(jQuery);
