<!--▼サイトヘッダー-->
<header id="top" class="site-header">

  <div class="site-header-in">
    <div class="site-header-conts">
      <h1 class="site-title"><a href="/{{ config('movie_manage.uri_word') }}/home/">{{ config('movie_manage.title_word') }}&nbsp;<img class="top_icon" src="/images/icon/favicon.jpg" /></a></h1>
    </div>
  </div>

  <!--▼グローバルナビ-->
  <nav class="global-nav">
    <div class="global-nav-in">
      <div class="global-nav-panel"><span class="btn-global-nav icon-gn-menu">メニュー</span></div>
      <ul id="menu">
        <li>
          <a href="/{{ config('movie_manage.uri_word') }}/home/">ホーム</a>
        </li>
         <li>
          <a href="/{{ config('movie_manage.uri_word') }}/ranking/">人気な動画</a>
        </li>
         <li>
          <a href="/{{ config('movie_manage.uri_word') }}/actor/">キーワードで探す</a>
        </li>
      </ul>
    </div>
  </nav>
  <!--▲グローバルナビ-->

</header>
<!--▲サイトヘッダー-->
