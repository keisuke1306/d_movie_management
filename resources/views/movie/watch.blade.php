@extends('layouts.app')

@section('title', '動画ページ')

@section('content')

<div class="main-body">
  <div class="main-body-in">

    <!--▼メインコンテンツ-->
    <main>
      <div class="main-conts">
        <section>
          <div class="section-in">
            <div class="news">
              <article class="news-item">
                <div class="news-thumb">
                  <a href="javascript:void(0);"><img src="/images/upload/{{ $movie_obj->thumbnail or 'noimage.gif' }}" width="220" height="220"></a>
                </div>
                <h3 class="news-title">
                  <a href="javascript:void(0);">{{ $movie_obj->title }}</a>
                </h3>
              </article>
            </div>
          </div>
        </section>

        <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
        <div id="player"></div>

        @include('layouts.sns_html')

        @include('ads/ad_script')

        @if ($movie_obj->description != '')
          <section>
            <h3>動画情報</h3>
            <div class="section-in">
              <div class="news">
                <article class="news-item">
                  <div class="each_movie_description">{{ $movie_obj->description }}</p>
                </article>
              </div>
            </div>
          </section>
        @endif

        <h3>その他の{{ config('movie_manage.ja_word') }}動画</h3>
        @foreach ($relate_movie_data as $key => $movie)
          <div class="news">
            <article class="news-item item_ranking1">
              <div class="news-thumb">
                <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/"><img class="relate_movie_thumbnail" src="/images/upload/{{ $movie->thumbnail or 'noimage.gif' }}" width="200" height="200"></a>
              </div>
              <h3 class="news-title">
                <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/">{{ $movie->title }}</a>
              </h3>
              <p class="news-cont f09em text_overflow movie_description">{{ $movie->description }}</p>
            </article>
          </div>
        @endforeach
      </div>
    </main>
  </div>
</div>

<script>
  // 2. This code loads the IFrame Player API code asynchronously.
  var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // 3. This function creates an <iframe> (and YouTube player)
  //    after the API code downloads.
  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      width: "{{ $movie_width }}",
      height: "{{ $movie_height }}",
      videoId: "{{ $movie_obj->video_id }}",
      events: {
        // 'onReady': onPlayerReady,
        // 'onStateChange': onPlayerStateChange
      }
    });
  }

  // 4. The API will call this function when the video player is ready.
  function onPlayerReady(event) {
    event.target.playVideo();
  }

  // 5. The API calls this function when the player's state changes.
  //    The function indicates that when playing a video (state=1),
  //    the player should play for six seconds and then stop.
  var done = false;
  function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
      setTimeout(stopVideo, 6000);
      done = true;
    }
  }
  function stopVideo() {
    player.stopVideo();
  }

</script>
<script src="/js/sns_button.js" type="text/javascript"></script>

@if (config('movie_manage.ua') == 'pc')
  @include('ads.i_mobile_ads_pc')
@else
  @include('ads.i_mobile_ads_sp')
@endif

@endsection
