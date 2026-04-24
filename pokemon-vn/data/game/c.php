<?PHP
if(isset($_GET[add])){
     function ducnghia_sql_code($ducnghia_code) {
$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$size = strlen($char);
for($i = 0; $i<$ducnghia_code; $i++) {
$str .= $chars[rand(0, $size -1)];
$str=substr(str_shuffle($chars), 0, $ducnghia_code);
}
return$str;
}
$soluong = $_POST['soluong'];
for ($i = 1; $i <= $soluong; $i++) {

$ducnghia_ma = ducnghia_sql_code(16);
  $ducnghia_gift = $_POST;
	
        	    if($datauser[admin] ==3) {
        	    $msg .= 'mã code <font color="red">'.$ducnghia_ma.'</font><br>'; }
}
}

else {
$nghia = $_POST[macode];
      $code = trim($nghia); 
 $ducnghia_giftx = mysql_num_rows(mysql_query("SELECT * FROM `giftcode` WHERE `code`='".$code."'")); 
$ducnghia_gift =  mysql_fetch_assoc(mysql_query("SELECT * FROM `giftcode` WHERE `code` = '$code'"));
$gift =  mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_giftcode` WHERE `text` = '{$code}' AND `user_id` = '$user_id'"));
if($datauser->code->giftcode->{$code}->ok !=0) {
    $msg = 'Bạn đã sử dụng mã quà tặng này rồi...';
} else

if($ducnghia_giftx == 0){
			$msg = 'Mã quà tặng chưa chính xác,vui lòng kiểm tra lại.';
	  	}
	   	else{
	   	  $datauser->code->giftcode->{$code}->ok = 1;
	   	  $datauser->code->giftcode->{$code}->thoigian = date('h:m:s d-m-Y');

	  	mysql_query("UPDATE `users` SET `code` = '" .json_encode($datauser->code,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) . "' WHERE `id` = '" . $datauser->id . "'");
  
	   	    
	   	    if($ducnghia_gift[xu] !=0) {
        	mysql_query("UPDATE `users` SET `xu`=`xu`+'".$ducnghia_gift['xu']."' WHERE `id`='".$_SESSION['id']."'");	
      $nghiacode.=$ducnghia_gift['xu'].'xu,';
	   	    }
	   	    
	   	       if($ducnghia_gift[ruby] !=0) {
        	mysql_query("UPDATE `users` SET `ruby`=`ruby`+'".$ducnghia_gift['ruby']."' WHERE `id`='".$_SESSION['id']."'");	
            $nghiacode.=$ducnghia_gift['ruby'].'ruby,';

	   	    }
	   	    
	if(!empty($ducnghia_gift[vatpham])) {
foreach(explode(',',$ducnghia_gift[vatpham]) as $vatpham)
{
    $soluong = explode(':',$vatpham);
    $datauser->setvatpham($soluong[0],$soluong[1]);
      $shopvatpham=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id` ='".$soluong[0]."' "));

$nghiacode.=$shopvatpham[tenvatpham].'*'.$soluong[1].',';

}

	   	    }   
	   	    
	if(!empty($ducnghia_gift[item])) {
foreach(explode(',',$ducnghia_gift[item]) as $item)
{
    $soluong = explode(':',$item);

       $datauser->setitem($soluong[0],$soluong[1]);


$nghiacode.=$soluong[0].'*'.$soluong[1].',';

} }   	 

	if(!empty($ducnghia_gift[tmhm])) {
foreach(explode(',',$ducnghia_gift[tmhm]) as $tmhm)
{
    $soluong = explode(':',$tmhm);


       $datauser->setitem($soluong[0],$soluong[1]);


$nghiacode.=$soluong[0].'*'.$soluong[1].',';

} }   	 
	   	    
      
      
      
        	        	if($ducnghia_gift[vinhvien]==0) {
        	        	        	mysql_query("DELETE FROM `giftcode` WHERE `code`='".$code."'");
        	        	}
	


$ducnghiaJSON[qua] = $nghiacode;
        	$msg= 'code:400-Thanh_cong';
	   	}

}

$ducnghiaJSON[thongbao] .= $msg;

echo json_encode($ducnghiaJSON);
die;	
	

