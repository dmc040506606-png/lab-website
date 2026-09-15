<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
// 자신만의 코드를 넣어주세요.

if ($w == 'u' && $is_admin && $wr_datetime) {
         $sql = "update $write_table set wr_datetime = '$wr_datetime' where wr_id = '$wr_id'";
         sql_query($sql);        
		 sql_query("update $write_table set wr_hit='$wr_hit' where wr_id='$wr_id'"); 
 }

?>
