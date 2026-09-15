<?php
include_once('./_common.php');

if (!$is_admin) alert("권한이없습니다.");

$csv = 'xls';
// MS엑셀 XLS 데이터로 다운로드 받음
if ($csv == 'xls')
{

	if ($sca) $searches = "and ca_name='$sca' ";

    $sql = " SELECT count(*) as ct FROM g5_write_{$bo_table} where wr_is_comment = '0' {$searches}";
	$rowx = sql_fetch($sql);   	  
    $cnt = $rowx['ct'];

	 $sqlx = " SELECT * FROM g5_write_{$bo_table} where wr_is_comment = '0' {$searches}";
	$resultN = sql_query($sqlx);

	
    if (!$cnt)
        alert("출력할 내역이 없습니다.");


    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, $board.".xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
    $data = array('No','Name','Title','Journal','Vol','Page','Author','Date','Year of publication','Content','Link1','Link2','File1','File2','Write Date');
    $data = array_map('iconv_euckr', $data);
   
    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

    for($i=1; $row=sql_fetch_array($resultN); $i++)
    {
		$row = array_map('iconv_euckr', $row);

		$wr_name = $row['wr_name'];
		$title = $row['wr_subject'];
		$journal = $row['wr_3'];
		$vol = $row['wr_5'];
		$pagex = $row['wr_6'];
		$author = $row['wr_1'];
		$datex = $row['wr_4'];
		$year_of_publication  = $row['ca_name'];
		$content = get_text(strip_tags($row['wr_content']));	
		$content = preg_replace("/\"/", "&#034;", $content);

		$wr_link1 = $row['wr_link1'];
		$wr_link2 = $row['wr_link2'];

		$filex = get_file($bo_table, $row['wr_id']);
		if ($filex[0][source] !="") $file1 = $filex[0][source]; else $file1="";
		if ($filex[1][source] !="") $file2 = $filex[1][source]; else $file2="";

		$up_date = date("Y-m-d", strtotime($row['wr_datetime']));

		 $worksheet->write($i, 0, $i);
		 $worksheet->write($i, 1, $wr_name);
		 $worksheet->write($i, 2, $title);
		 $worksheet->write($i, 3, $journal);
		 $worksheet->write($i, 4, $vol);
		 $worksheet->write($i, 5, $pagex);
		 $worksheet->write($i, 6, $author);
		 $worksheet->write($i, 7, $datex);
		 $worksheet->write($i, 8, $year_of_publication);
		 $worksheet->write($i, 9, $content);
		 $worksheet->write($i, 10, $wr_link1);
		 $worksheet->write($i, 11, $wr_link2);
		 $worksheet->write($i, 12, $file1);
		 $worksheet->write($i, 13, $file2);
		 $worksheet->write($i, 14, $up_date);       
		 
    }
    $workbook->close();
	header("Content-charset=utf-8");
	header("Content-Type: application/x-msexcel; name=\"".$board['bo_subject']."_".date("Ymd", time()).".xls\"");
	header("Content-Disposition: inline; filename=\"".$board['bo_subject']."_".date("Ymd", time()).".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);

    exit;
}

if ($cnt == 0)
{
    echo "<script>alert('출력할 내역이 없습니다.'); window.close();</script>";
    exit;
}
?>
