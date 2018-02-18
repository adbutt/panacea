/**
 * Panacea theme JavaScript.
 */
// grab an element
var myElement = document.querySelector('header')
// construct an instance of Headroom, passing the element
var headroom = new Headroom(myElement, {
  'offset': 205,
  'tolerance': 5
})
// initialise
headroom.init()

// jQuery start
;(function ($) {
  // Hide or show the "back to top" link
  $(window).scroll(function () {
    // Back to top
    var offset = 300 // Browser window scroll (in pixels) after which the "back to top" link is shown
    var offsetOpacity = 1200 // Browser window scroll (in pixels) after which the link opacity is reduced
    var scrollTopDuration = 700 // Duration of the top scrolling animation (in ms)
    var linkClass = '.top'

    if ($(this).scrollTop() > offset) {
      $(linkClass).addClass('is-visible')
    } else {
      $(linkClass).removeClass('is-visible')
    }

    if ($(this).scrollTop() > offsetOpacity) {
      $(linkClass).addClass('fade-out')
    } else {
      $(linkClass).removeClass('fade-out')
    }
  })

  // Document ready start
  $(function () {
    // Set up back to top link
    var moveTo = new MoveTo()
    var target = document.getElementById('target')
    moveTo.move(target)

    // Register a back to top trigger
    var trigger = document.getElementsByClassName('js-trigger')[0]
    moveTo.registerTrigger(trigger)
  })
})(jQuery)
