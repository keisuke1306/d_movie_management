(function() {

    //マウスオーバー（ファイルの末尾に「_off」「_on」で切り替え）
    $("img.over,input.over")
    .each( function(){
      $("<img>,<input>").attr("src",$(this).attr("src").replace(/^(.+)_off(\.[a-z]+)$/, "$1_on$2"));
    })
    .mouseover( function(){
      $(this).attr("src",$(this).attr("src").replace(/^(.+)_off(\.[a-z]+)$/, "$1_on$2"));
    })
    .mouseout( function(){
      $(this).attr("src",$(this).attr("src").replace(/^(.+)_on(\.[a-z]+)$/, "$1_off$2"));
    });
    
    //テーブルのセルとリストに偶数・奇数を付与
    $("li:odd,tr:odd").addClass("odd"),
    $("li:even,tr:even").addClass("even");

    //スムーズスクロール
    var topBtn = $('.page-top');
    topBtn.hide();
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        topBtn.fadeIn();
      } else {
        topBtn.fadeOut();
      }
    });

    $("a[href^='#']").click(function(){
      var Hash = $(this.hash);
      var HashOffset = $(Hash).offset().top;
      $("html,body").animate({
        scrollTop: $($(this).attr("href")).offset().top }, 'slow','swing');
      return false;
    });

    //グローバルメニューのプルダウン設定
    $("#menu li").hover(function() {
      $("> ul:not(:animated)", this).fadeIn("normal");
    }, function() {
      $("> ul", this).fadeOut("normal");
    });
    
    //モバイル用のグローバルメニュー設定
    $(".global-nav-panel").click(function(){
      $("#menu").toggleClass("show-menu");
    });

    $(".global-nav-panel").click(function() {
      if($("span",this).hasClass("btn-global-nav icon-gn-menu")){
        $("span",this).removeClass("icon-gn-menu").addClass("icon-gn-close");
        $("span",this).text("閉じる");
      } else {
        $("span",this).removeClass("icon-gn-close").addClass("icon-gn-menu");
        $("span",this).text("メニュー");
      };
    });

    //クリックでテキストを選択
    $(".text-field")
      .focus(function(){
        $(this).select();
      })
      .click(function(){
        $(this).select();
        return false;
    });

    function lpHeader(){
      hdrWidth = $(window).width();
      hdrHeight = $(window).height();
      $('.full-screen,.full-screen .site-header-in,.full-screen .site-header-conts').css({
        width: hdrWidth + 'px',
        height: hdrHeight + 'px',
        maxHeight: '1500px'
      });

      if(window.innerWidth < 678) {
        h1Size = hdrWidth / 12;
        fontSize = hdrWidth / 16;
        $('.full-screen .site-header-conts h1').css('font-size', h1Size + 'px');
        $('.full-screen .site-header-conts .lp-catch').css('font-size', fontSize + 'px');
      } else {
        h1Size = hdrHeight / 12;
        fontSize = hdrHeight / 24;
        $('.full-screen .site-header-conts h1').css('font-size', h1Size + 'px');
        $('.full-screen .site-header-conts .lp-catch').css('font-size', fontSize + 'px');
      }
    }
    lpHeader();
    $(window).resize(function() {
      lpHeader();
    });

    // text over flow
    let limitCount = $('#des_limit_count').attr('data-dec_limit_count');
    $('.text_overflow').each(function() {
      let thisText = $(this).text();
      let textLength = thisText.length;

      if (textLength > limitCount) {
        let showText = thisText.substring(0, limitCount);
        let hideText = thisText.substring(limitCount, textLength);
        let insertText = showText;
        insertText += "<span class='hide'>" + hideText + "</span>";
        insertText += "<span class='omit'>...</span>";
        insertText += "<a href='javascript:void(0);' class='more'>もっと見る</span>";
        $(this).html(insertText);
      };
    });

    $('.text_overflow .hide').hide();
    $('.text_overflow .more').click(function() {
      $(this).hide()
             .prev('.omit').hide()
             .prev('.hide').fadeIn();
      return false;
    });
})();
