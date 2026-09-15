jQuery(document).ready(function(){


	/* 스크롤 내렸을 때 header fix */
	if ( $("#header").length > 0 ) {
		$(window).scroll(function  () {
			var scroll_Top = $(window).scrollTop();
			var startTop = $("#wrap").offset().top;
			
			if ( scroll_Top > startTop ) {
				$("#header").addClass("fixed");
			}else {
				$("#header").removeClass("fixed");
			}		 
		});
	}


	var curMgnb = false;
	jQuery(".mobileMenu").click(function(){
		if(curMgnb == false){
			jQuery("#gnbM").stop().animate({right:0}, 250);
			jQuery(".dimdBg").stop().fadeIn(250);
			curMgnb = true;
		}
	});

	jQuery("#gnbM .mobileMenuXbt").click(function(){
		if(curMgnb == true){
			jQuery("#gnbM").stop().animate({right:-280}, 250);
			jQuery(".dimdBg").stop().fadeOut(250);
			curMgnb = false;
		}
	});

	var curMgnb1 = -1;
	jQuery("#gnbM .two").slideUp(0);
	jQuery("#gnbM .one").removeClass("on");
	jQuery("#gnbM .one").each(function(q){
		jQuery(this).click(function(){
			if(curMgnb1 != q){
				jQuery("#gnbM .one").eq(curMgnb1).removeClass("on");
				jQuery("#gnbM .two").eq(curMgnb1).stop().slideUp('fast');
				curMgnb1 = q;
				jQuery("#gnbM .one").eq(curMgnb1).addClass("on");
				jQuery("#gnbM .two").eq(curMgnb1).stop().slideDown('fast');
			}else if(curMgnb1 == q){
				jQuery("#gnbM .one").eq(curMgnb1).removeClass("on");
				jQuery("#gnbM .two").eq(curMgnb1).stop().slideUp('fast');
				curMgnb1 = -1;
			}
		});
	});


    // 하위 li hover시 선택한 부모 li의 a에만 on클래스 추가
    $('ul.depth02 > li').hover(function(){
        $(this).closest('#cssmenu > ul > li.menubox').find('.menu-tit').toggleClass('on');
    });
    
}); 


