<!DOCTYPE html>
<html lang="ja">
  <head>

    <!--  css -->
    <link media="screen and (min-device-width:481px)" rel="stylesheet" href="/css/layout.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <link media="only screen and (max-device-width:480px)" rel="stylesheet" href="/css/layout_sp.min.css">

    <link rel="stylesheet" type="text/css" href="/keni/{{ config('movie_manage.keni_type') }}/css/base.min.css" />
    <link rel="stylesheet" type="text/css" href="/keni/{{ config('movie_manage.keni_type') }}/css/rwd.min.css" />
    <link rel="apple-touch-icon" href="/images/icon/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="/images/icon/favicon.ico" />
    <link rel="icon" href="/images/icon/favicon.ico" />
    <link rel="shortcut icon" href="/images/icon/favicon.ico" />

    <title>@yield('title') - {{ config('movie_manage.title_word') }}</title>

    @include('ads.google_adsense')

  </head>

  <body>
    @include('layouts.header_menu')

    @yield('content')

    @include('layouts.footer')

    @include('layouts.scripts')

    @include('layouts.ga_script')

  </body>
</html>
