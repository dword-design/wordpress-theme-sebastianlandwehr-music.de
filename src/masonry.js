import 'masonry-layout'
import 'imagesloaded'

const $ = window.jQuery
$('.gallery').imagesLoaded(function () {
  $(this).masonry({
    itemSelector: '.gallery-item',
  })
})
