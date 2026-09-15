<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$wr_1_editor_html = editor_html('wr_1', $write['wr_1'], true);
$wr_1_editor_js = '';
$wr_1_editor_js .= get_editor_js('wr_1', true);
$wr_1_editor_js .= chk_editor_js('wr_1', true);
?>

<div id="bo_w">

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        // if ($is_notice) {
        //     $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">Notice</label>';
        // }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>
	

	<div class="writ_form">

		<div class="writ_option">
		<?php if ($option) { ?>
			<div class="notice_chek"><?php echo $option ?></div>
		<?php } ?>
		</div>

		<?php if($is_admin){ ?> 
		<dl class="writ_list mainchk">
			<dt>메인에 노출</dt>
			<dd><input type="checkbox" name="wr_10" value="1"<? echo ($wr_10 =='1') ? ' checked="checked"' : '';?> placeholder="메인에 노출시 체크하세요."></dd>
		</dl>
		<?php } ?>

		<?php if ($is_name) { ?>
		<dl class="writ_list">
			<dt>이름<span>*</span></dt>
			<dd><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="w_txt_box" maxlength="20"  placeholder="이름"></dd>
		</dl>
		<?php } ?>

		<?php if ($is_password) { ?>
		<dl class="writ_list">
			<dt>비밀번호<span>*</span></dt>
			<dd><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="w_txt_box" <?php echo $password_required ?> maxlength="20"  placeholder="패스워드"></dd>
		</dl>
		<?php } ?>

		<?php if ($is_category) { ?>
		<dl class="writ_list">
			<dt>Year<span>*</span></dt>
			<dd class="w_sele_box">
				<select name="ca_name" id="ca_name" required class="required" >
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
			</dd>
		</dl>
		<?php } ?>


		<dl class="writ_list">
			<dt>Title<span>*</span></dt>
			<dd>
	        <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="w_txt_box" maxlength="255" placeholder="Title of paper">
				<?php if ($is_member) { // 임시 저장된 글 기능 ?>
				<script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
				<!--<button type="button" id="btn_autosave" class="btn_black">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>-->
				<div id="autosave_pop" style="display: none;">
					<div class="alert alert-info" style="margin-top:5px;"><strong>임시 저장된 글 목록</strong>
					<button type="button" class="btn_black autosave_close">닫기</button></div>
					<ul></ul>
				</div>
				<?php } ?>
			</dd>
		</dl>

        <dl class="writ_list">
			<dt>Author</dt>
			<div class="wr_1">
				<?php echo $wr_1_editor_html; ?>
			</div>
		</dl>

		<!-- <dl class="writ_list">
			<dt>Author</dt>
			<dd><input type="text" name="wr_1" value="<?php echo $write[wr_1] ?>" id="wr_1" id="wr_1" class="w_txt_box" maxlength="800"  placeholder="Author" /></dd>
		</dl> -->

		<!-- <dl class="writ_list">
			<dt>Co-author</dt>
			<dd><input type="text" name="wr_2" value="<?php echo $write[wr_2] ?>" id="wr_2" id="wr_2" class="w_txt_box" maxlength="800" placeholder="Co-author" /></dd>
		</dl> -->

		<dl class="writ_list">
			<dt>Journal</dt>
			<dd><input type="text" name="wr_3" value="<?php echo $write[wr_3] ?>" id="wr_3" id="wr_3" class="w_txt_box" maxlength="800" placeholder="Journal" /></dd>
		</dl>

		<!-- <dl class="writ_list">
			<dt>Status</dt>
			<dd><input type="text" name="wr_4" value="<?php echo $write[wr_4] ?>" id="wr_4" id="wr_4" class="w_txt_box" maxlength="800" placeholder="Status" /></dd>
		</dl> -->

        <!-- <dl class="writ_list">
			<dt>Vol</dt>
			<dd><input type="text" name="wr_5" value="<?php echo $write[wr_5] ?>" id="wr_5" id="wr_5" class="w_txt_box" maxlength="800" placeholder="Vol" /></dd>
		</dl> -->

		<!-- <dl class="writ_list">
			<dt>Page</dt>
			<dd><input type="text" name="wr_6" value="<?php echo $write[wr_6] ?>" id="wr_6" id="wr_6" class="w_txt_box" maxlength="800" placeholder="Page" /></dd>
		</dl> -->

		<dl class="writ_list">
			<dt>Date</dt>
			<dd><input type="text" name="wr_7" value="<?php echo $write[wr_7] ?>" id="wr_7" id="wr_7" class="w_txt_box" maxlength="800" placeholder="Date" /></dd>
		</dl>

		

		


		<div class="w_edit_area">
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
			<?php } ?>
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<div id="char_count_wrap"><span id="char_count"></span>글자</div>
			<?php } ?>
		</div>

		<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
		<dl class="writ_list">
			<dt>링크 #<?php echo $i ?></dt>
			<dd><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="w_txt_box" placeholder="http://abcd.kr"></dd>
		</dl>
		<?php } ?>

		<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
		<dl class="writ_list">
			<dt>파일 #<?php echo $i+1 ?></dt>
			<dd class="w_file_box"><input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능"></dd>
		</dl>


		<?php if ($is_file_content) { ?>
		<dl class="writ_list">
			<dt><label>파일설명<?php echo $i+1 ?></label></dt>
			<dd>
				<input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="w_txt_box" size="50" placeholder="파일 설명을 입력해주세요." >
				<?php } ?>
				<?php if($w == 'u' && $file[$i]['file']) { ?>
				<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
				<?php } ?>
			</dd>
		</dl>
		<?php } ?>

		<?php if ($is_guest) { //자동등록방지  ?>
		<div>
			<?php echo $captcha_html ?>
		</div>
		<?php } ?>

	</div>


	<div class="btn_confirm write_div">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel btn">취소</a>
    	<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit btn">
    </div>
    </form>
</div>
    <script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $wr_1_editor_js; ?>
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

<!-- } 게시물 작성/수정 끝 -->