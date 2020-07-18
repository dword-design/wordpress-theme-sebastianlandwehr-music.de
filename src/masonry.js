import 'masonry-layout'
import 'imagesloaded'

const $ = window.jQuery
const $container = $('.gallery')
$container.imagesLoaded(() =>
  $container.masonry({
    itemSelector: '.gallery-item',
  })
)
