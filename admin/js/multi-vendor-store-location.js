// (function ($) {
//     "use strict";

//     $(document).on("click", ".location", function () {
//         $("#store-branch-latitude").val($(this).data("latitude"));
//         $("#store-branch-location-fetched").val($(this).data("displayname"));
//         $("#store-branch-longitude").val($(this).data("longitude"));
//     });

//     $("#store-branch-location").on("input", function () {
//         $.ajax({
//             url: "https://geocode.maps.co/search",
//             method: "GET",
//             data: {
//                 q: $(this).val(),
//             },
//             dataType: "json",
//             statusCode: {
//                 200: function (response) {
//                     $("#fetched-locations").empty();

//                     response.forEach((element) => {
//                         $("#fetched-locations").append(
//                             `<li class='fetched-location' >  <input type='radio' class='location' name='selected_location' id='${element.place_id}' data-longitude='${element.lon}' data-displayname='${element.display_name}' data-latitude='${element.lat}' /><label for='${element.place_id}'>${element.display_name}</label></li>`
//                         );
//                     });
//                 },
//             },
//         });
//     });
// })(jQuery);
mapboxgl.accessToken = "pk.eyJ1IjoicmFodWxwcmFuYW1pLWJpenRlY2giLCJhIjoiY2xvOGNoZGNmMDBhbjJxa2xjNGNidHFmZyJ9.CqSMl873hAXDund1IEQL8A";
var map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
});
