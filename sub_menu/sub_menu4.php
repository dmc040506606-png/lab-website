

<script>
$(document).ready(function(){
    $(".btn_s_menu").click(function(){
        $(".s_menu").toggle();
    });

	$(".vNav>ul>li").each(function(idx){
		var line = $(".sub_menu .line");
		var aThis = $(".vNav>ul>li").eq(idx);
		aThis.on("mouseover", function(){
			line.stop().animate({opacity:1, left:aThis.position().left+"px", width:aThis.children("a").innerWidth()+"px"},300);
		});
		aThis.on("mouseleave", function(){
				line.stop().animate({opacity:"0", width:0},300);
		});
	});
});
</script>



<div class="vNav" id="page4">
	<ul>
		<li id="menu01" <? if ($sNum == "1") echo "class='active'"; ?>>
		<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=sub4_1" class="box4_4_1">Publication</a></li>
		<!-- <li id="menu02" <? if ($sNum == "2") echo "class='active'"; ?>>
		<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=sub4_2" class="box4_4_2">Before 2019</a></li> -->
	</ul>
	<span class="line"></span>
</div>


 <div class="m_sub_menu">
    <button type="button" class="btn_s_menu">
      <span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span> <i class="arrow right"></i>
    </button>
    <ul class="s_menu">
		<li id="menu01" <? if ($sNum == "1") echo "class='active'"; ?>>
		<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=sub4_1" class="box4_4_1">Publication</a></li>
		<!-- <li id="menu02" <? if ($sNum == "2") echo "class='active'"; ?>>
		<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=sub4_2" class="box4_4_2">Before 2019</a></li> -->
	</ul>
  </div>

