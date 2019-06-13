<!-- シェアボタン [ここからコピー] -->
<div class="social-area-syncer">
  <ul class="social-button-syncer">
    <li>
      <a href="https://twitter.com/share" class="twitter-share-button" data-text="{{ $movie_obj->title }}" data-size="large" data-hashtags="{{ config('movie_manage.title_word') }}" data-dnt="true">Tweet</a>
    </li>
    <li>
      <div class="fb-like" data-href="{{ $movie_obj->movie_url }}" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
    </li>
  </ul>
</div>

<!-- シェアボタン [ここまでコピー] -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
