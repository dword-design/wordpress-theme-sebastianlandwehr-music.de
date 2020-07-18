import 'masonry-layout'
import 'imagesloaded'

import $ from 'jquery'

$('.gallery').imagesLoaded(function () {
  $(this).masonry({
    itemSelector: '.gallery-item',
  })
})
