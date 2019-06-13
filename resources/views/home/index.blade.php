@extends('layouts.app')

@section('title', 'ホーム画面')

@section('content')

<div class="main-body col2">
  <div class="main-body-in">

  <!--▼メインコンテンツ-->
  <main>
    <div class="main-conts">
      <section>
        <div class="section-in">
          <h2>新着{{ config('movie_manage.ja_word') }}動画</h2>

          @foreach ($new_movie_obj as $key => $movie)

            @if ($key === 5)
              @include('ads/ad_script')
            @endif

            <div class="news">
              <article class="news-item">
                <div class="news-thumb">
                  <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/"><img src="/images/upload/{{ $movie->thumbnail or 'noimage.gif' }}" width="220" height="220"></a>
                </div>
                <h3 class="news-title"><a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/">{{ $movie->title }}</a></h3>
                <p class="news-cont f09em text_overflow movie_description">{{ $movie->description }}</p>
              </article>
            </div>
          @endforeach
        </div>
      </section>

      {{ $new_movie_obj->links() }}

    </div>
  </main>
  <!--/メインコンテンツ-->

  <!--▼サブコンテンツ-->
  <aside class="sub-conts">

    <section class="section-wrap">
      <div class="section-in">
        <div class="search-box">
          <form action="/{{ config('movie_manage.uri_word') }}/actor/search_movie/" method="GET">
            <input type="text" name="search_keyword" value="">
              <button class="btn-search"><img alt="検索" width="32" height="20" src="/keni/{{ config('movie_manage.keni_type') }}/images/icon/icon-btn-search.png"></button>
          </form>
        </div>
      </div>
    </section><!--サイト内検索-->

    <section class="section-wrap">
      <div class="section-in">
        <h3 class="section-title">人気動画</h3>
        <ol class="ranking-list ranking-list03">
          @foreach ($ranking_movie_obj as $key => $movie)
            <li class="rank0{{ $key + 1 }} on-image" onclick="location.href='/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie['movie_id'] }}/'">
              <div class="rank-thumb">
                <img src="/images/upload/{{ $movie['thumbnail'] or 'noimage.gif' }}" width="100" height="100">
              </div>
              <h4 class="rank-title m10-b"><a href="javascript:void(0);"><span class="f08em">{{ $movie['title'] }}</span></a></h4>
            </li>
          @endforeach
        </ol>
        <p class="al-r orange"><a href="/{{ config('movie_manage.uri_word') }}/ranking/">More...</a></p>
      </div>
    </section>

    @if (config('movie_manage.keywords') > 0)
      <section class="m50-b">
        <div class="section-in">
        <h3 class="section-title">キーワード</h3>

          <div class="tagcloud">
              @foreach (config('movie_manage.keywords') as $key => $keyword_data)
              <form name="keyword_{{ $key }}" action="/{{ config('movie_manage.uri_word') }}/actor/search_movie/" method="GET">
                <input type="hidden" name="search_keyword" value="{{ $keyword_data['keyword'] }}" />
                <a href="javascript:void(0);" class="f{{ $keyword_data['size'] }}em" onclick="document.keyword_{{ $key }}.submit(); return false;">{{ $keyword_data['keyword'] }}</a>
              </form>
              @endforeach
          </div>
        </div>
        </section><!--タグ-->
    @endif

    </aside>
    <!--/サブコンテンツ-->

  </div>
</div>

@if (config('movie_manage.ua') == 'pc')
  @include('ads.i_mobile_ads_pc')
@else
  @include('ads.i_mobile_ads_sp')
@endif

@endsection
