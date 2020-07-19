const $ = window.jQuery
$('.home').each(() => {
  $('.logo').attr('href', '#teaser')
  $('.panel--teaser').on('activity-changed', (event, isActive) => {
    $('body').toggleClass('menu-bar--slim', isActive)
    $('.social-links').toggleClass('social-links--slim', isActive)
  })
})
