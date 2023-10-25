(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

setTimeout(function () {
  var workingHrs = $(".mt0.mb0.text-muted:eq(0)").find("span").text();
//   var addMin = 585 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];
  var addMin = 8.5 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];
//   var addMin = 7.5 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];
//   var addMin = 7.25 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];
//   var addMin = 7 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];

  // set out time
  var cTime = new Date();
  var sTime = new Date();
  sTime.setMinutes(cTime.getMinutes() + addMin);

  var outTime = sTime.toLocaleString("en-US", {
    hour: "numeric",
    minute: "numeric",
    hour12: true,
  });

  $(".mt0.mb0.text-muted:eq(0)").find("span").text(outTime.split(" ")[0]);

  setTimeout(function () {
    $(".mt0.mb0.text-muted:eq(0)").find("span").text(workingHrs);
  }, 2000);

  //   $(".mt0.mb0.text-muted:eq(0)").before(
  //     '<h4 class="mt0 mb0"><span class="text-muted">GoodBye At: </span><span>' +
  //       outTime +
  //       "</span></h4>"
  //   );
}, 2000);


// setTimeout(function () {
// 	var workingHrs = $(".mt0.mb0.text-muted:eq(0)").find("span").text();
// 	var addMin =
// 		8.5 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];
// 	//   var addMin = 7 * 60 - workingHrs.split(":")[0] * 60 - workingHrs.split(":")[1];

// 	// set out time
// 	var cTime = new Date();
// 	var sTime = new Date();
// 	sTime.setMinutes(cTime.getMinutes() + addMin);

// 	var outTime = sTime.toLocaleString("en-US", {
// 		hour: "numeric",
// 		minute: "numeric",
// 		hour12: true,
// 	});
// 	new Notification("Out Time", { body: outTime });
// }, 2000);
