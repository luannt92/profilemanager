$(document).ready(function(){
	// Menu mobi
    $m = $('div#menu').html();
    $('nav#menu-mobi').append($m);
    
    $('nav#menu-mobi .search').addClass('search-mobi').removeClass('search');
    $('.display-menu').click(function(){
      $('nav#menu-mobi').css({height: "auto"});
    });
    $('.user .fa-user-plus').toggle(function(){
      $('.user ul').slideDown(300);
    },function(){
      $('.user ul').slideUp(300);
    });
    
    $('nav#menu-mobi').mmenu({
        extensions  : [ 'effect-slide-menu', 'pageshadow' ],
        searchfield : true,
        counters  : true,
        navbar    : {
        title   : ''
        },
        navbars   : [
          {
            position  : 'top',
            content   : [ 'searchfield' ]
          }, {
            position  : 'top',
            content   : [
              'prev',
              'title',
              'close'
            ]
          }, {
            position  : 'bottom',
            content   : [
            ]
          }
        ]
    });

    // Menu cate mobi
    $m = $('div#sidebar-left').html();
    $('nav#menucate').append($m);
    $('.mobi-cate').click(function(){
      $('nav#menucate').css({height: "auto"});
    });
    $('nav#menucate').mmenu({
        extensions  : [ 'effect-slide-menu', 'pageshadow' ],
        searchfield : true,
        counters  : true,
        navbar    : {
        title   : 'Danh mục'
        },
        navbars   : [
          {
            position  : 'top',
            content   : [ 'searchfield' ]
          }, {
            position  : 'top',
            content   : [
              'prev',
              'title',
              'close'
            ]
          }, {
            position  : 'bottom',
            content   : [
            ]
          }
        ]
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 250) {
            $('.back-top').fadeIn();
        } else {
            $('.back-top').fadeOut();
        }
    });
    $('.back-top').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });
    // support fb
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }
    (document, 'script', 'facebook-jssdk'));
    jQuery(".chat_fb").click(function() {
        jQuery('.fchat').toggle('slow');
    });

    $('#btn-login').on('click',function(){
    	if($('#email-login').val()==''){
    		$('#email-login').addClass('color-placehol').attr('placeholder','Bạn chưa nhập Email đăng ký');
    	}
    });
    $('#grid').on('click',function(){
        if($(this).hasClass('grid-view')){
            $(this).removeClass('grid-view').addClass('list-view');
            $('#content-area-grid').css('display','none');
            $('#content-area-list').css('display','block');
        }else{
            $(this).removeClass('list-view').addClass('grid-view');
            $('#content-area-list').css('display','none');
            $('#content-area-grid').css('display','block');
        }
    });
    $('.caret-top').on('click',function(){
        $(this).closest('.col-addoption').removeClass('in');
    });
    $('.btn-cancel').on('click',function(){
        $(this).closest('.row-notes').removeClass('in');
    });
    
    $(window).scroll(function () {
        if ($(window).scrollTop() >= $('.header').outerHeight()) {
            $('.submenunav').addClass('submenunav-scroll');
            $('.right-content .cart-content').css({
                position:'fixed',
                top: $('.toolbar-list').height() +'px',
            });
            if($(window).width() >= 1200){
                $('#cart-product.cart-product').css({
                    width: '350px'
                })
            }
            else if($(window).width() <= 640){
                if($('#cart-product').hasClass('cart-product')){
                    $(this).css({
                        width: '100%'
                    })
                }
            }
            else{
                $('#cart-product.cart-product').css({
                    width: '360px'
                })
            }
        }else{
            $('.submenunav').removeClass('submenunav-scroll');
            $('.right-content .cart-content').css({
                position:'unset',
                top: $('.header').height() + 50 + 'px',
            });
            if($(window).width() >= 640){
                $('#cart-product.cart-product').css({
                    width: '345px'
                })
            }
            else{
                if($('#cart-product').hasClass('cart-product')){
                    $(this).css({
                        width: '100%'
                    })
                }
            }
        }
    });
    $('#frm-kind').on('click',function(){
        if($(this).hasClass('frm-kind')){
            $(this).closest('#cart-product').addClass('cart-product');
            $(this).closest('.toolbar-list').addClass('toolbar-list2')
            $('#content-area-list').addClass('content-area-list');
            $('#right-content').addClass('right-content');
            $(this).removeClass('frm-kind');
            $('.right-content .cart-content').css({
               top: $('.toolbar-list').height() +'px'       
            });
            if($(window).width() <= 640){
                $('.right-content .cart-content').css({
                    width: $('#content-list').width(),
                });
            }else{
                $('.right-content .cart-content').css({
                    width: '345px',
                });
            }
        }else{
            $(this).closest('#cart-product').removeClass('cart-product');
            $(this).closest('.toolbar-list').removeClass('toolbar-list2')
            $('#content-area-list').removeClass('content-area-list');
            $('#right-content').removeClass('right-content');
            $(this).addClass('frm-kind');
        }
    });
    $('#btn-search').on('click',function(){
        $('.input-group-search').css({
            display:'inline-flex',
        });
        $('.input-group-search').animate({
            width:'260px',
        },300);
        if ($(window).width() >=1170) {
            $('.grid-toggle').css('width','30%');
        }else{
            $('.grid-toggle').css('width','auto');
        }
    });
    $('.close-search').on('click',function(){
        $('.input-group-search').css({
            display:'none',
        });
        $('.input-group-search').animate({
            width:'0'
        },300);
        if ($(window).width() >=1170) {
            $('.grid-toggle').css('width','40%');
        }else{
            $('.grid-toggle').css('width','auto');
        }
    });

    var inp = $('input[type="number"]').val();
    $('.subnum').on('click',function(e){
        e.preventDefault();
        if(inp > 1){
            inp --;
        }
        $('input[type="number"]').val(inp);
    });
    $('.addnum').on('click',function(e){
        e.preventDefault();
        inp++;
        $('input[type="number"]').val(inp);
    });

    $(".btn-icon","#locale").click(function(n){
        n.stopPropagation();
        $("#locale").toggleClass("open-select");
    });
    $(".btn-icon","#locale2").click(function(n){
        n.stopPropagation();
        $("#locale2").toggleClass("open-select");
    });

    $('#change-language').attr('data-select','selected');
    $('.language a').on('click',function(){
        var sel = $('#change-language').attr('data-select');
        $(this).attr('data-select','selected');
        // console.log(sel);
        if($(this).attr('data-select') == sel){
            var app = $(this).html();
            var a = '';
            $('#change-language').html(a).append(app);
            $('#change-language').closest('.dropdown').removeClass('open-select').addClass('selected');
        }
    });
});