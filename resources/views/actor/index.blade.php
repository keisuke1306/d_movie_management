
@extends('layouts.app')

@section('title', '検索画面')

@section('content')

  <form class="search_form" method="GET" action="/{{ config('movie_manage.uri_word') }}/actor/search_movie/">
    <div class="search_menu">
      <span class="search_label">キーワード検索</span>
      <input type="text" class="search_input" name="search_keyword" value="{{ $search_keyword or '' }}" />
      <button class="btn-search"><img alt="検索" width="32" height="32" src="/keni/{{ config('movie_manage.keni_type') }}/images/icon/icon-btn-search.png"></button>
    </div>
  </form>

  @if (config('movie_manage.ua') == 'pc')
    @include('ads/i_mobile_ads_pc')
  @else
    @include('ads/i_mobile_ads_sp')
  @endif

  <hr style="width: 95%;" />

  <div class="main-body">
    <div class="main-body-in">

      {{ $movie_obj->appends($search_params)->links() }}

      <!--▼メインコンテンツ-->
      <main>
        <div class="main-conts">
          <section class="section-wrap">
            <div class="section-in">
              @if (count($movie_obj) > 0)
                <h2>キーワードで検索</h2>

                @foreach ($movie_obj as $key => $movie)

                  @if ($key === 5)
                    @include('ads/ad_script')
                  @endif

                  <div class="news">
                    <article class="news-item item_ranking1">
                      <div class="news-thumb">
                        <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/"><img src="/images/upload/{{ $movie->thumbnail or 'noimage.gif' }}" width="220" height="220"></a>
                      </div>
                      <h3 class="news-title">
                        <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/">{{ $movie->title }}</a>
                      </h3>
                      <div class="news-cat">
                        @if (is_numeric($movie->number_of_people))
                          <span class="cat number_of_people">{{ $movie->number_of_people }}人村</span>
                        @endif
                        @if ($movie->ability_status === '1')
                          <span class="cat open_abilty">役職公開</span>
                        @elseif ($movie->ability_status === '2')
                          <span class="cat close_ability">役職非公開</span>
                        @endif
                      </div>
                      <p class="news-cont f09em text_overflow movie_description">{{ $movie->description }}</p>
                    </article>
                  </div>
                @endforeach
              @else
                <h3>検索条件に合う動画はありません</h3>
                @if (count(config('movie_manage.keywords')) > 0)
                  <h5>人気のキーワード</h5>
                  @foreach (config('movie_manage.keywords') as $key => $keyword_data)
                    <form name="keyword_{{ $key }}" action="/{{ config('movie_manage.uri_word') }}/actor/search_movie/" method="GET">
                      <input type="hidden" name="search_keyword" value="{{ $keyword_data['keyword'] }}" />
                      <a href="javascript:void(0);" class="f{{ $keyword_data['size'] }}em" onclick="document.keyword_{{ $key }}.submit(); return false;">{{ $keyword_data['keyword'] }}</a>
                    </form>
                  @endforeach
                @endif

                <a href="/{{ config('movie_manage.uri_word') }}/actor/" style="float:right">一覧に戻る</a>
              @endif
            </div>
          </section>
        </div>
      </main>
    </div>

    {{ $movie_obj->appends($search_params)->links() }}

  </div>

  @include('ads/ad_script')

@endsection
