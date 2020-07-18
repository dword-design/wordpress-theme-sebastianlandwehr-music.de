import { endent } from '@dword-design/functions'
import $ from 'jquery'

$('.home').each(function () {
  // Add anchor to logo
  $('.logo').attr('href', '#teaser')
  $('.panel--teaser').on('activity-changed', (event, isActive) => {
    $('body').toggleClass('menu-bar--slim', isActive)
    $('.social-links').toggleClass('social-links--slim', isActive)
  })
  const $news = $(this).find('.news')
  const loadNextPage = () => {
    if (!$news.hasClass('loading-bottom')) {
      $news.addClass('loading-bottom')
      const postParams = {
        action: 'facebook_news',
      }
      const $next = $news.find('.news__pagination-next')
      if ($next) {
        postParams.next = $next.data('value')
      }
      $.post(window.variables.ajaxUrl, postParams, response => {
        $next.remove()
        $news.append(response)
        $('.video-wrapped').videoEmbedPrivacy()
        $.iframe()
        window.FB.XFBML.parse()
        $news.removeClass('loading-bottom')
      })
    }
  }
  const $newsLink = $(endent`
  <a class="news-link" href="https://www.facebook.com/SebastianLandwehrMusic">
    <span class="news-link__title">Neuigkeiten von Facebook laden</span>
    <span class="news-link__description">Dabei wird eine Verbindung zu den Servern https://www.facebook.com und https://www.youtube.com hergestellt.</span>
  </a>
  `).appendTo($news)
  $newsLink.click(() => {
    $newsLink.remove()
    ;((d, s, id) => {
      const fjs = d.getElementsByTagName(s)[0]
      if (d.getElementById(id)) return
      const js = d.createElement(s)
      js.id = id
      js.src =
        '//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.9&appId=1423681441010836'
      fjs.parentNode.insertBefore(js, fjs)
    })(document, 'script', 'facebook-jssdk')
    loadNextPage()
    return false
  })

  // $(window).scroll(function () {
  //   if ($('.news-link').length == 0) {
  //     if ($(window).scrollTop() + $(window).height() >= $news.offset().top + $news.height() - 100) {
  //         loadNextPage();
  //     }
  //   }
  // })
})
