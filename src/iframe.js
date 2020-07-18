import $ from 'jquery'

$.iframe = function () {
  $('iframe').each(function () {
    const $parent = $(this).parent()
    if ($parent.length > 0 && $(this).outerWidth() > $parent.width()) {
      $(this).outerWidth($parent.width())
      $(this).outerHeight(
        ($(this).outerHeight() * $(this).attr('height')) / $(this).attr('width')
      )
    }
  })
}
const updateIframeSize = () => $.iframe()
$(window).resize(updateIframeSize)
