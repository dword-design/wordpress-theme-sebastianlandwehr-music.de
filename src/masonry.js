import 'masonry-layout'
import 'imagesloaded'

const $ = window.jQuery
const $container = $('.gallery')
$container.imagesLoaded(function () {
  $(this).masonry({
    itemSelector: '.gallery-item',
  })
})
