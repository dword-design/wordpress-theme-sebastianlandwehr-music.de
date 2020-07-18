import $ from 'jquery'

const $embed = $('.fullscreen-video .video-wrapped')
$embed.hide()
$('.fullscreen-video__is-playing').change(function () {
  $embed.toggle($(this).prop('checked'))
  if ($(this).prop('checked')) {
    $embed.trigger('click')
  } else {
    $embed.find('iframe').remove()
  }
})
