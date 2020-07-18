const $ = window.jQuery
let previousScrollPosition = 0
function updatePanels() {
  const $panels = $('.panel')
  if ($panels.length >= 2) {
    const currentScrollPosition = $(window).scrollTop()
    const $previousActivePanel = $('.panel--active')
    let $newActivePanel = $panels.first()
    $panels.each(function () {
      if (currentScrollPosition >= $(this).position().top) {
        $newActivePanel = $(this)
      }
    })
    if (!$newActivePanel.hasClass('panel--active')) {
      if ($previousActivePanel.length > 0) {
        $previousActivePanel.removeClass('panel--active')
        $previousActivePanel.trigger('activity-changed', false)
      }
      $newActivePanel.addClass('panel--active')
      $newActivePanel.trigger('activity-changed', true)
    }
    $panels.each(function () {
      const top = $(this).position().top
      if (
        (previousScrollPosition < top && currentScrollPosition >= top) ||
        (previousScrollPosition > top && currentScrollPosition <= top)
      ) {
        window.location.hash = `#${$(this).attr('id')}`
      }
    })
    previousScrollPosition = currentScrollPosition
  }
}
$(window).scroll(updatePanels)
updatePanels()
$('.panel:not(.panel--active)').trigger('activity-changed', false)
