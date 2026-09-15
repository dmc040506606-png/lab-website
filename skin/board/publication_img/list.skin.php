<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 3;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

//여분필드추가시 wr_번호
if ($fadmin =='fok') {
	if ($is_admin =='super') {
	$start = 1; //시작할번호 : wr_추가시작할 번호
$last = 10; //마지막번호 : 생성할 마지막번호

for ($temp=$start; $temp<=$last; $temp++) {
	$addSql ="ALTER TABLE $g5[write_prefix]$bo_table MODIFY wr_{$temp} TEXT NOT NULL";
	$addRow = sql_query($addSql,false);

	if ($addRow) {
	echo "$bo_table 게시판에 wr_{$temp} 필드생성 성공 하였습니다.
";
	} else {
	echo "$bo_table 게시판에 wr_{$temp} 필드가 이미 존재 하거나 생성실패 하였습니다.
";
	}
	}
	} else {
	alert("잘못된 접근입니다.");
	}
	//exit;
 }


if ($fadmin =='fok') {
	if ($is_admin =='super') {
	$start = 11; //시작할번호 : wr_추가시작할 번호
$last = 50; //마지막번호 : 생성할 마지막번호

for ($temp=$start; $temp<=$last; $temp++) {
	$addSql ="ALTER TABLE $g5[write_prefix]$bo_table ADD wr_{$temp} TEXT NOT NULL";
	$addRow = sql_query($addSql,false);

	if ($addRow) {
	echo "$bo_table 게시판에 wr_{$temp} 필드생성 성공 하였습니다.
";
	} else {
	echo "$bo_table 게시판에 wr_{$temp} 필드가 이미 존재 하거나 생성실패 하였습니다.
";
	}
	}
	} else {
	alert("잘못된 접근입니다.");
	}
	//exit;
 }
?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">


    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">


		 <!-- 게시판 카테고리 시작 { -->
        <?php if ($is_category) { ?>
        <nav id="bo_cate" class="cate_line">
            <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
            <ul id="bo_cate_ul">
                <?php echo $category_option ?>
            </ul>
        </nav>
        <?php } ?>
        <!-- } 게시판 카테고리 끝 -->

			<?php
			if ($is_admin){
			?>
			 <div class="" style="display:none;"><a href="<?php echo $board_skin_url?>/xls_dn.php?bo_table=<?php echo $bo_table;?>&sca=<?php echo $sca;?>">엑셀다운</a></div>
			<?php } ?>

        <!-- 게시판 페이지 정보 및 버튼 시작 { -->
        <div id="bo_btn_top">
            <div id="bo_list_total">
                <span>Total <?php echo number_format($total_count) ?>건</span>
                <?php echo $page ?> 페이지
            </div>

			


            <?php if ($rss_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
                <?php if ($is_admin == 'super' || $is_auth) {  ?>
                <li>
                    <button type="button" class="btn_more_opt is_list_btn btn_b01 btn" title="게시판 리스트 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트 옵션</span></button>
                    <?php if ($is_checkbox) { ?>
                    <ul class="more_opt is_list_btn">
                    <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><i class="fa-solid fa-trash-can" aria-hidden="true"></i>선택삭제</button></li>
					<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><i class="fa-regular fa-copy" aria-hidden="true"></i> 선택복사</button></li>
					<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><i class="fa-solid fa-arrows-up-down-left-right" aria-hidden="true"></i> 선택이동</button></li>
                    </ul>
                    <?php } ?>
                </li>
                <?php }  ?>
            </ul>
            <?php } ?>
        </div>
        <!-- } 게시판 페이지 정보 및 버튼 끝 -->

        <div class="publi_list">
            <ul class="publiCon">



<!-- 목록 상단 분류 -->
                <?	if ($sca){?>
                <li style="border-bottom:none;">
                    <h4 class="cateName"><?=$sca?></h4>
                </li>
                <?}?>

                <?
				$sql ="SELECT max(ca_name) yy FROM $write_table";
				$result = sql_query($sql);
				$rows = sql_fetch_array($result);
				$yyT = $rows['yy'];
				//$yyT = date('Y');

				for ($i=0; $i<count($list); $i++) {
					$bg = $i%2 ? 0 : 1;
					//echo $cate_before.":before   {$list[$i][ca_name]}:  now   ";
					//if ($yyT == trim($list[$i][ca_name])){
					if ($cate_before != trim($list[$i][ca_name])){
					$yyLine =true;
				}
				$yyT =trim($list[$i][ca_name]);
			?>

                <?if ($yyLine && !$sca){?>
                <li style="border-bottom:none;" class="cate_year">
                    <h4 class="cateName"><?=$list[$i][ca_name]?></h4>
                </li>
                <?}?>
                <li>
<!--/// 목록 상단 분류 -->

                   
<!-- 목록 시작 -->
                    <!-- 게시물 번호 { -->
                    <div class="postNum"> <span> <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong class="notice_icon"><i class="fa fa-bullhorn" aria-hidden="true"></i><span class="sound_only">공지</span></strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?></span> </div>
                    <!-- } 게시물 번호 -->

                    <!-- 내용 { -->
                    <div class="txtCon">

                        <div class="ConWr">
				        <?php
				            if ($list[$i]['is_notice']) { // 공지사항  ?>
				                <span class="is_notice">공지</span>
				         <?php } else {
				            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
				
				            if($thumb['src']) {
				                $img_content = '<a href="'.$list[$i]['href'].'" class="img"><img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" ></a>';
				            } else {
				                $img_content = '';
				            }
								echo $img_content;
				             }
				        ?>             
				                        
                            <!-- 관리자가 관리할 수 있는 체크인풋 { -->
                            <?php if ($is_checkbox) { ?><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>"><?php } ?>
                            <!-- } 관리자가 관리할 수 있는 체크인풋 -->
                            <a href="<?php echo $list[$i]['href'] ?>">

                                <p class="txtTitle"><?=$list[$i]['subject'] ?></p>
								
								<div class="txtInfo">
									<?if ($list[$i]['wr_1']){?><span class="txtAuthor"><?php echo $list[$i]['wr_1'] ?></span>,
									<?}?>
									<?if ($list[$i]['wr_2']){?><span class="txtCoauthor"><?php echo $list[$i]['wr_2'] ?></span>,
									<?}?>
									<?if ($list[$i]['wr_3']){?><span class="txtJournal"><i><?php echo $list[$i]['wr_3'] ?></i></span>,
									<?}?>
									<?if ($list[$i]['wr_4']){?><span class="txtStatus"><?php echo $list[$i]['wr_4'] ?></span>,
									<?}?>
                                    <?if ($list[$i]['wr_5']){?><span class="txtVol"><?php echo $list[$i]['wr_5'] ?></span>,
									<?}?>
									<?if ($list[$i]['wr_7']){?><span class="txtPage"><?php echo $list[$i]['wr_7'] ?></span>
									<?}?>
									<?if ($list[$i]['wr_6']){?><span class="txtYear"><?php echo $list[$i]['wr_6'] ?></span>
									<?}?>
									

								</div>
								<!--<p class="txtCnt">
									<?php echo utf8_strcut(strip_tags($list[$i]['wr_content']), 150, '..'); ?>
								</p>-->

                            </a>
                        </div>

                        <div class="btnWr">


                            <!-- Download 버튼 { -->
                            <div class="btnDownWr">
                                <?
				if($list[$i][file][0]) {
					$down_link0 = "download.php?bo_table=" . $bo_table . "&wr_id=" . $list[$i][wr_id] . "&no=0";
					echo "&nbsp;<a href='$down_link0' class='btnDown'  target='_blanked'><i class='fa fa-download'></i> Download</a>";
									}	else{
					echo "";
									}

				if($list[$i][file][1]) {
					$down_link1 = "download.php?bo_table=" . $bo_table . "&wr_id=" . $list[$i][wr_id] . "&no=1";
					echo "&nbsp;<a href='$down_link1' class='btnDown'  target='_blanked'><i class='fa fa-download'></i> Download 2</a>";
									}	else{
					echo "";
									}
				?>
                            </div>


                        </div>
                        <!-- } Download 버튼 -->


                        <div class="btnLinkWr">
                            <!-- Link 버튼 { -->
                            <?
					if($list[$i][wr_link1])
						echo "<a href='{$list[$i][link_href][1]}' target=_blank  class='btnLink'><i class='fa fa-link'></i> LINK</a>";
					else
						echo "";

					?>

                            <?
						if($list[$i][wr_link2])
							echo "<a href='{$list[$i][link_href][2]}' target=_blank  class='btnLink'><i class='fa fa-link'></i> LINK</a>";
						else
							echo "";

					?>
                            <!-- } Link 버튼 -->
                        </div>
                    </div>
                    <!-- } 내용 -->


                    <?
                                   $ss_name = "ss_view_{$bo_table}_{$list[$i][wr_id]}";
                                         set_session($ss_name, true);

                                   $cate_before = trim($list[$i][ca_name]);
                                  ?>

                    <?
					echo " " . $list[$i][icon_secret];
					echo $nobr_end;
					echo "";
					?>
                    <?
                                   $ss_name = "ss_view_{$bo_table}_{$list[$i][wr_id]}";
                                         set_session($ss_name, true);

                                   $cate_before = trim($list[$i][ca_name]);
                                  ?>
                </li>


                <?
				$yyT =$yyT -1;
				$yyLine ="";
				}
				?>

                <?php if (count($list) == 0) { echo '<li class="empty">게시물이 없습니다.</li>'; } ?>
            </ul>

        </div>


        <?php if ($list_href || $is_checkbox || $write_href) { ?>
        <div class="bo_fx">
            <?php if ($list_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
            </ul>
            <?php } ?>
        </div>
        <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
    <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages;  ?>


    <!-- 게시판 검색 시작 { -->
        <fieldset class="bo_sch">
            <h3>검색</h3>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <!--<?php echo get_board_sfl_select_options($sfl); ?>-->
            <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>Title&nbsp;&nbsp;&nbsp;</option>
			<option value="wr_1"<?php echo get_selected($sfl, 'wr_1'); ?>>Author</option>
			<!-- <option value="wr_2"<?php echo get_selected($sfl, 'wr_2'); ?>>Co-author</option> -->
			<option value="wr_3"<?php echo get_selected($sfl, 'wr_3'); ?>>Journal</option>
			<!-- <option value="wr_4"<?php echo get_selected($sfl, 'wr_4'); ?>>Status</option> -->
			<!-- <option value="wr_5"<?php echo get_selected($sfl, 'wr_5'); ?>>Vol</option> -->
			<!-- <option value="wr_6"<?php echo get_selected($sfl, 'wr_6'); ?>>Page</option> -->
			<option value="wr_7"<?php echo get_selected($sfl, 'wr_7'); ?>>Date</option>
            </select>
            <div class="sch_bar">
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">
                <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            </div>
            </form>
        </fieldset>
    <!-- } 게시판 검색 끝 --> 

<?php if ($is_checkbox) { ?>
<script>
    function all_checked(sw) {
        var f = document.fboardlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]")
                f.elements[i].checked = sw;
        }
    }

    function fboardlist_submit(f) {
        var chk_count = 0;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택복사") {
            select_copy("copy");
            return;
        }

        if (document.pressed == "선택이동") {
            select_copy("move");
            return;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                return false;

            f.removeAttribute("target");
            f.action = g5_bbs_url + "/board_list_update.php";
        }

        return true;
    }

    // 선택한 게시물 복사 및 이동
    function select_copy(sw) {
        var f = document.fboardlist;

        if (sw == "copy")
            str = "복사";
        else
            str = "이동";

        var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

        f.sw.value = sw;
        f.target = "move";
        f.action = "./move.php";
        f.submit();
    }
    // 게시판 리스트 관리자 옵션
    jQuery(function($) {
        $(".btn_more_opt.is_list_btn").on("click", function(e) {
            e.stopPropagation();
            $(".more_opt.is_list_btn").toggle();
        });
        $(document).on("click", function(e) {
            if (!$(e.target).closest('.is_list_btn').length) {
                $(".more_opt.is_list_btn").hide();
            }
        });
    });

</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
