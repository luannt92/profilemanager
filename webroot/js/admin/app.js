$(document).ready(function(){
    $(function(){
        $.fn.limit = function($n){
            this.each(function(){
                var allText   = $(this).html();
                var tLength   = $(this).html().length;
                var startText = allText.slice(0,$n);
                if(tLength >= $n){
                    $(this).html(startText+'...');
                }else {
                    $(this).html(startText);
                };
            });

            return this;
        }
        $('.textline').limit(50);
    });


    if ($(window).outerWidth() <= 1200) {
        $('.navbar-default .container').removeClass('container').addClass('container-fluid');
    }
    $(window).on('resize', function(){
        if ($(window).outerWidth() <= 1200) {
            $('.navbar-default .container').removeClass('container').addClass('container-fluid');
        }else{
            $('.navbar-default .container-fluid').removeClass('container-fluid').addClass('container');
        }
    });

    if($('ul.tabsplan li.active') === true){
        $(this).addClass('tabactive');
    }

    $('.div-border').on('click',function(){
        $(this).find('.border').css('display', 'none');
    });

    $('.fastar').on('click',function(){
        $(this).toggleClass('fastar2');
    });

    if ($(window).outerWidth() > 992) {
        $('.caretdown').on('click',function(){
            $(this).closest('.uljob').removeClass('in');
        });
        $('.caretup').on('click',function(){
            $(this).closest('.uljobshow').removeClass('in');
        });
    }

    if ($(window).outerWidth() <= 992) {
        $('.caretdown').removeAttr('data-toggle').attr('data-toggle','modal');
        $('.caretdown').attr('data-target','#modaltree');
    }
    $(window).on('resize', function(){
        if ($(window).outerWidth() <= 992) {
            $('.caretdown').removeAttr('data-toggle').attr('data-toggle','modal');
            $('.caretdown').attr('data-target','#modaltree');
        }else{
            $('.caretdown').removeAttr('data-toggle').attr('data-toggle','collapse');
            $('.caretdown').removeAttr('data-target','#modaltree');
        }

        if ($(window).outerWidth() > 992) {
            $('.caretdown').on('click',function(){
                $(this).closest('.uljob').removeClass('in');
            });
            $('.caretup').on('click',function(){
                $(this).closest('.uljobshow').removeClass('in');
            });
        }else{
            $('.caretdown').on('click',function(){
                $(this).closest('.uljob').addClass('in');
            });
        }
    });

    $('.hoverbox').hover(function(){
        $(this).find('.iconedit').css('display','inline-table')
    },function(){
        $(this).find('.iconedit').css('display','none')
    });


});
