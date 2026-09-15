<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);


?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->



<article id="bo_v" style="width:<?php echo $width; ?>">

<!-- 게시물 상단 버튼 시작 { -->
	<div id="bo_v_top">
	    <?php ob_start(); ?>

	    <ul class="btn_bo_user bo_v_com">
			<li><a href="<?php echo $list_href ?>" class="btn_b01 btn" title="목록"><i class="fa fa-list" aria-hidden="true"></i><span>목록</span></a></li>
	        <!--<?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01 btn" title="답변"><i class="fa fa-reply" aria-hidden="true"></i><span >답변</span></a></li><?php } ?>-->
	        <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span>글쓰기</span></a></li><?php } ?>
	       	<?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
	       	<li>
	       		<button type="button" class="btn_more_opt is_view_btn btn_b01 btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span>관리</span></button>
	        	<ul class="more_opt is_view_btn"> 
                <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>">수정<i class="fa-solid fa-pen" aria-hidden="true"></i></a></li><?php } ?>
                    <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제<i class="fa-solid fa-trash-can" aria-hidden="true"></i></a></li><?php } ?>
                    <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;">복사<i class="fa-regular fa-copy" aria-hidden="true"></i></a></li><?php } ?>
                    <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;">이동<i class="fa-solid fa-arrows-up-down-left-right" aria-hidden="true"></i></a></li><?php } ?>
		            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>">검색<i class="fa fa-search" aria-hidden="true"></i></a></li><?php } ?>
		        </ul> 
	       	</li>
	       	<?php } ?>
	    </ul>
	    <script>
           jQuery(function($){
            // 게시판 보기 버튼 옵션
			$(".btn_more_opt.is_view_btn").on("click", function(e) {
                e.stopPropagation();
			    $(".more_opt.is_view_btn").toggle();
			});
            $(document).on("click", function (e) {
                if(!$(e.target).closest('.is_view_btn').length) {
                    $(".more_opt.is_view_btn").hide();
                }
            });
	         });
        </script>
	    <?php
	        $link_buttons = ob_get_contents();
	        ob_end_flush();
		?>
	</div>
<!-- } 게시물 상단 버튼 끝 -->


  <div class="publi_view">
	<h5 class="txtTitle"><?=$view['wr_subject']?></h5>

	<?if ($view['wr_1']){?>
	<dl class="author">
		<dt>Author</dt>
		<dd><?=$view['wr_1']?></dd>
	</dl>
	<?}?>

	<?if ($view['wr_2']){?>
	<dl class="author">
		<dt>Co-author</dt>
		<dd><?=$view['wr_2']?></dd>
	</dl>
	<?}?>

	<?if ($view['wr_3']){?>
	<dl>
		<dt>Journal</dt>
		<dd><?=$view['wr_3']?></dd>
	</dl>
	<?}?>	

	<?if ($view['wr_4']){?>
	<dl>
		<dt>Status</dt>
		<dd><?=$view['wr_4']?></dd>
	</dl>
	<?}?>

	<?if ($view['wr_5']){?>
	<dl>
		<dt>Vol</dt>
		<dd><?=$view['wr_5']?></dd>
	</dl>
	<?}?>

	<?if ($view['wr_6']){?>
	<dl>
		<dt>Page</dt>
		<dd><?=$view['wr_6']?></dd>
	</dl>
	<?}?>

	<?if ($view['wr_7']){?>
	<dl>
		<dt>Year</dt>
		<dd><?=$view['wr_7']?></dd>
	</dl>
	<?}?>
	
	<!-- 분류 Year -->
<!-- 	<dl> -->
<!-- 		<dt>Year</dt> -->
<!-- 		<dd><?=$view['ca_name']?></dd> -->
<!-- 	</dl> -->

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">

	<dl>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
			<dt>File</dt>
              <dd><a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <i class="fa fa-upload"></i>
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
				</dd>
        <?php
            }
        }
         ?>
	</dl>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if ($view['link']) {
    ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
       <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
		<dl>

           <dt>Link</dt>
             <dd><a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <i class="fa fa-chain"></i>
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </dd>
        </dl>
        <?php
            }
        }
         ?>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

	<div class="conWr">
		<?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?><?php echo get_view_thumbnail($view['content']); ?>

	</div>





    <?php
    include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>



</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->