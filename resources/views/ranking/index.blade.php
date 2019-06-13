@extends('layouts.app')

@section('title', 'ランキング画面')

@section('content')

<div class="main-body">
  <div class="main-body-in">

  <!--▼メインコンテンツ-->
  <main>
    <div class="main-conts">
      <section>
        <div class="section-in">
          <h2>人気な動画</h2>

          @foreach ($ranking_movie_obj as $key => $movie)
            <div class="news ranking-list ranking-list03">
              <article class="@if (($key + 1) < 10)rank0{{ $key + 1 }} @else rank{{ $key + 1 }} @endif on-image news-item">
                <div class="rank-thumb">
                  <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/"><img class="rank-image" src="/images/upload/{{ $movie->thumbnail or 'noimage.gif' }}" width="220" height="220"></a>
                </div>
                <h3 class="news-title">
                  <a href="/{{ config('movie_manage.uri_word') }}/movie/watch/{{ $movie->movie_id }}/">{{ $movie->title }}</a>
                </h3>
                <p class="news-cont f09em text_overflow movie_description">{{ $movie->description }}</p>
              </article>
            </div>
          @endforeach
        </div>
    </section>
  </div>
</div>

@include('ads.ad_script')

@endsection
