<style>
/* 페이지인식-메인 */
#page1 #menu0<?=$sNum?> > .box1_<?=$mNum?>_<?=$sNum?> {
	color: #000;
    background: #fff;
}

.active a{color: #000!important;
    background: #fff;}

.m_sub_menu {display: none;}

@media (max-width:1200px) {
.m_sub_menu {display: block;}
}
</style>



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

<div class="vNav" id="page<?=$mNum?>">
	<ul>
<?
                 $menu_code = $mNum + 1;
                 $me_code = "{$mNum}0";
                 $meSql = " select me_order,me_target,me_name,me_link,me_id from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4'  and substring(me_code, 1, 2) = '{$me_code}' order by me_order, me_id ";
                  $meResult = sql_query($meSql);
                                  for ($k=1; $meRow=sql_fetch_array($meResult); $k++) {
                                  ?>
          <li  id="menu0<?=$k?>" <? if ($sNum ==$k) {echo "class='active'"; } ?>>
                  <?=$mene_code?> <a href="<?php echo $meRow['me_link']; ?>" target="_<?php echo $meRow['me_target']; ?>" class="box<?=$mNum?>_<?=$sNum?>_<?=$k?>"><?php echo $meRow['me_name'] ?><?php// echo $meRow['me_order'] ?></a>
          </li>
<?}?>
	</ul>
</div>



 <div class="m_sub_menu">
    <button type="button" class="btn_s_menu">
      <span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span> <i class="arrow right"></i>
    </button>
    <ul class="s_menu">

<?
                 $menu_code = $mNum + 1;
                 $me_code = "{$mNum}0";
                 $meSql = " select me_order,me_target,me_name,me_link,me_id from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4'  and substring(me_code, 1, 2) = '{$me_code}' order by me_order, me_id ";
                  $meResult = sql_query($meSql);
                                  for ($k=1; $meRow=sql_fetch_array($meResult); $k++) {
                                  ?>
          <li  id="menu0<?=$k?>" <? if ($sNum ==$k) {echo "class='active'"; } ?>>
                  <?=$mene_code?> <a href="<?php echo $meRow['me_link']; ?>" target="_<?php echo $meRow['me_target']; ?>" class="box<?=$mNum?>_<?=$sNum?>_<?=$k?>"><?php echo $meRow['me_name'] ?><?php// echo $meRow['me_order'] ?></a>
          </li>
<?}?>
	</ul>
  </div>