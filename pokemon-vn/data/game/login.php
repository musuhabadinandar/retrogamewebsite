<?php

    //$thongbao = 'Phí chợ kí gửi là '.$hethong->data->phi.'%. ';
$thongbao = t('Trò chơi dành cho người 12+.Chơi quá 180 phút sẽ có hại cho sức khỏe.');
$taikhoan = mysql_real_escape_string($_POST[taikhoan]);
$matkhau = mysql_real_escape_string($_POST[matkhau]);
$baotri = 0;
$uid = 1000000;
$baotrimsg = t('bảo trì cập nhật phiên bản 4.0 mời các bạn quay lại sau.');
if(isset($_POST[regchoi])) {
           $duc2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `username` = '".$taikhoan."'"));
   if($baotri==1) {
       $j[ducnghia]= t('Trò chơi đang bảo trì.Đọc thông báo để biết thêm chi tiết.');
   }        else 
 if(!preg_match('/^[A-Za-z][A-Za-z0-9]{4,19}$/', $taikhoan)) {

 $j[ducnghia]= t('Tên nhân vật chỉ được phép dùng kí tự A-Z,0-9,lớn hơn 4 kí tự và nhỏ hơn 19 kí tự.');
} else
 if($duc2[id] !=0) {
     $j[ducnghia]= t('Tên nhân vật này đã được sử dụng rồi.');
 } else {
     mysql_query("INSERT INTO `users` (`username`, `test`, `sprite`, `map`, `sound`, `music`) VALUES ('" . $taikhoan . "', '1', '".$_POST[nhanvat]."', '{\"id\":1,\"x\":39,\"y\":29}', '1', '1')");    
     
        $duc = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `username` = '".$taikhoan."'"));
 $j[ducnghia] = t('Chơi thử thành công,hãy gặp NPC bất kì để xác minh tài khoản nhé.Hãy sử dụng các phím lên xuống để di chuyên ( phím ảo trên màn hình nếu chơi điện thoại) khi giao tiếp với NPC hãy ấn phím X(nếu trên máy tính) hoặc phím ảo A(trên điện thoại).Chúc các bạn có chuyến phưu lưu vui vẻ.');
        $j[ok] = '1';
        	$user = new user($duc['id']);
	$map = new map($user->map->id);

                $j[map] =  $map->code;
                    $j[name] =  $map->name;
                            $j[thongbao] =  $thongbao;

                $j[x] =  $user->map->x - 1;
                $j[y] =  $user->map->y -1;
                
                $j[uid] =  $user->id;
                $j[music] =  $user->sound;
                $j[uidname] =  $user->username;
                $j[skin] =  $user->sprite;
 $j[viettat] =  $user->viettat;
                $j[icon] =  $user->icon;
        	$_SESSION['user_id'] =$duc[id];
				$_SESSION['id'] = $duc[id];
				$_SESSION['naam'] = $user->username;

 }
 
  echo json_encode($j);
die;
 
}


if(isset($_POST[choingay])) {
    echo' <center id="ducnghia_tip" style=" height: auto;
   
display: block;"><hr><img src="/images/items/Ultra%20ball.png">CHƠI MỚI<img src="/images/items/Poke ball.png"><hr>
<div  class="showitem" style="border: 2px solid;"><img id="choingay_img" src="/xml/nhanvat.php?nhanvat=Hero-Male.png&amp;nut=1"></div>
	     
	     <Center><b onclick="choingay_nv(1)" class="viptxt"><< </b> [<b id="idnv">1</b>]  <b class="viptxt" onclick="choingay_nv(2)"> >> </b></center>
	     
	     <b id="nvchon" style="display:none;">Hero-Male.png</b>
	     
	     <img src="/images/items/Master ball.png">Tên N.Vật : <input id="taikhoan" class="input" type="text" value="" style="width: 40%;"> <br>
  <div class="nut" onclick="reg_choingay()">VÀO GAME</div> <br>
<div class="nut3" onclick="menu_login()">ĐĂNG NHẬP</div> <br>	     
	    
	     </center>
 

  ';
}

if(isset($_POST[dangnhap])) {
        $duc = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `taikhoan` = '".$taikhoan."' AND `password` = '".$matkhau."' "));
if($duc[khoa]>time()) {
    $timekkhoa = $duc[khoa]-time();
    $j[ducnghia] = 'Tài khoản của bạn bị khóa.Liên hệ admin.( thời gian khóa : '.$timekkhoa.'s) ';
}  else         
        
if($duc[id]==0) {
    $j[ducnghia] = t('Tài khoản hoặc mật khẩu chưa chính xác.');
}  else 
if($duc[id]>$uid) {
    $j[ducnghia] = $baotrimsg;
}  else {
    
       $j[ducnghia] = 'Đăng nhập thành công';
        $j[ok] = '1';
        	$user = new user($duc['id']);
        
        if($user->vua==1 AND $user->id !=1) {
            tin('VUA THÁCH ĐẤU '.$user->username.' vừa đăng nhập vào game.');
        }	
        	
	$map = new map($user->map->id);
                    $j[name] =  $map->name;
                $j[thongbao] =  $thongbao;

                $j[map] =  $map->code;
                $j[mx] =  $user->map->x - 1;
                $j[my] =  $user->map->y - 1;
                $j[uid] =  $user->id;
                $j[music] =  $user->sound;
                $j[uidname] =  $user->username;
                $j[skin] =  $user->sprite;
                $j[viettat] =  $user->viettat;
                $j[icon] =  $user->icon;
                $j[pokemon] =  $user->pokemon;

        	$_SESSION['user_id'] =$duc[id];
				$_SESSION['id'] = $duc[id];
$_SESSION['naam'] = $user->username;

}
 echo json_encode($j);
die;


}

if(isset($_POST[dangki])) {
        $duc = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `taikhoan` = '".$taikhoan."'  "));
if($duc[id] >0) {
    echo t('Tài khoản đã được đăng kí bởi người chơi khác.');
} else
if($datauser->test !=1) {
    echo t('Tên nhận vật đã xác minh rồi.');
}

else
				if (!preg_match('/^[A-Za-z][A-Za-z0-9]{4,19}$/', $taikhoan)) {

echo t('Tài khoản chỉ được phép dùng kí tự A-Z,0-9,lớn hơn 4 kí tự và nhỏ hơn 19 kí tự.');
} else {
    echo t('Xác minh tài khoản thành công.');
    
                        mysql_query("UPDATE users SET `test` =  '0',`taikhoan`='".$_POST[taikhoan]."',`password` = '".$_POST[matkhau]."' WHERE id='$user_id'");

}


}
?>