<?PHP

if(isset($_GET[venha])) {
        mysql_query("UPDATE `users` SET `pokemon`='0' WHERE `id`='{$user_id}'");
}
if(isset($_POST[follow])) {
    $a = file_get_contents('../images/charactersets/'.$_POST[id].'.png');

if(!$a) {
    echo'Pokemon này chưa có hiệu ứng di chuyển ! xin vui lòng chọn pokemon khác.';
}else {
        mysql_query("UPDATE `users` SET `pokemon`='".$_POST[id]."' WHERE `id`='{$user_id}'");
echo'Thành công.';
}
}
if(isset($_POST[boss])) {
    
           	$ck_boss = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_boss` WHERE `id` = '$_POST[id]'"));
           	             		$check_lv = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `opzak_nummer` >='1' AND user_id = '".$user_id."' ORDER BY `level` DESC LIMIT 1"));
$lv=$check_lv[level];//70
$lv1 = $ck_boss[lv]+5;
$lv2 = $ck_boss[lv]-5;

if($lv1 >= $lv AND $lv2 <= $lv ) {
    
 
if($ck_boss[hp] <=0) {
    $code = 1;
    $msg = 'Boss đã bị tiêu diệt';
}  else {
    $code = 0;
    
  

        include("../attack/boss/wild-start.php");
        create_new_attack($ck_boss['pokemon'],$ck_boss[level],$gebied,$_POST[id]);
mysql_query("UPDATE `users` SET `boss`='".$_POST[id]."' WHERE `id`='{$user_id}'");

}
} else {
     $code = 1;
    $msg = 'Boss này chỉ dành riêng cho cấp độ +- '.$ck_boss[lv].' ';
}
  $ducnghiaJSON[code] = $code;

  $ducnghiaJSON[msg] = $msg;

            echo json_encode($ducnghiaJSON);
}
////ngân hàng
if(isset($_GET[edit])) {
    $skill = $_POST['name']; 

  mysql_query("UPDATE `home` SET `text`='".$_POST[noidung]."'  WHERE  `id` = '1'");
  echo'thành công.';
}

if(isset($_POST[thongbao])) {
    $maychu = mysql_fetch_assoc(mysql_query("SELECT * FROM `home` WHERE `id` = '1'"));
              		  $sv = nl2br(ucfirst(BBCODE($maychu['text'],1)));
              		  $sv3 = nl2br(ucfirst($maychu['text']));

    echo'<br><small style="    font-size: 14px;">'.$sv.'</small><hr>';
    

     $req = mysql_query("SELECT * FROM `ducnghia_thongbao` WHERE `user_id` = ' $user_id'");
while ($check = mysql_fetch_assoc($req)) {
          		  $textxxx = nl2br(ucfirst(BBCODE($check['text'],1)));

 echo ''.$textxxx.'<br>';   
}
}

if(isset($_POST[giaotiep])) {
    $npc = mysql_fetch_assoc(mysql_query("SELECT * FROM `npcs` WHERE `id` = '$_POST[scriptData]'  "));
     	$check_nv =new nhiemvu($datauser->nhiemvu->nhiemvu);

   if($check_nv->ducnghia->npc == $npc[id] AND $datauser->nhiemvu->id<=0) {
       $nhiemx .='<b onclick="docnv()" class="viptxt nutchat">'.t($check_nv->ducnghia->ten).'</b>';
   }  else
   if($datauser->nhiemvu->npc == $npc[id] AND $datauser->nhiemvu->song >=$datauser->nhiemvu->can AND $datauser->nhiemvu->id >=1) {
              $nhiemx .='<b onclick="tranv()" class="viptxt nutchat">'.t($check_nv->ducnghia->ten).'</b>';

   }
   
   if($datauser->test==1) {
       $xm= '<b class="viptxt nutchat" onclick="menu_xacminh()">#'.t('LIÊN KẾT TÀI KHOẢN').'</b>';
   }
         
 if($npc['time'] !=0){
   $onclick.= '<b onclick="dan('.$npc[id].')" class="viptxt nutchat">Dẫn về</b>';}
   
   $npcs = new npcs($_POST[scriptData]);
   
 foreach ($npcs->ducnghia as $npcjson) {
   $nx= dichson($npcjson->name);
   if($datauser->id ==1) {
       $r = $npcjson->id;
   }
$onclick.= '<b onclick="'.dichson($npcjson->onclick).'" class="viptxt nutchat">#'.$r.' '.t($npcjson->name).'</b>';
					}  
   
   if(!empty($npc[o1])){
   $onclick.= '<b onclick="'.$npc[o1].'" class="viptxt nutchat">#'.t($npc[n1]).'</b>';}
   

if($datauser->id==1) {
    $idnpc = '['.$npc[id].']';
}
    $xxxx[map] = $idnpc.t($npc[text]);
        $xxxx[menu] = ''.$xm.''.$nhiemx.''.$onclick;

    echo json_encode($xxxx);
die;
     	
}

if(isset($_POST[hoihp])) {
    if($datauser->ducnghia->timehp >= time()) {
        $aa[ducnghia] = ''.t('Pokemon của anh hồi phục sau').' '.($datauser->ducnghia->timehp-time()).'s nữa. ';
    } else { 
        $datauser->setducnghia('timehp',time()+15);
        $datauser->setducnghia('hp',1);

      
        $aa[ducnghia] = t('PokeMon anh sẽ hồi phục sau 15s nữa. ');
    }
 echo json_encode($aa);
die;
}

if(isset($_POST[tui])) {
    $ab.='<br>';
foreach ($user->vatpham as $id => $soluong) {
    if($soluong>0) {
				    $ab .= '<div onclick="xemshopvatpham(\''.$id.'\');" class="showitem" style="border: 2px solid;"><img src="/images/_/'.$id.'.png" ><div class="count count-vp-1">'.$soluong.' </div></div>';
}
					}
					
foreach ($user->item as $inaam => $soluong) {
				  	if($inaam == 'TM01' || $inaam == 'TM08' || $inaam == 'TM21' || $inaam == 'TM31') 				$img = '/images/items/Attack_Fighting.png';	

		elseif($inaam == 'TM02') $type = 'Dragon';
		elseif($inaam == 'TM03' || $inaam == 'TM18') 	$img = '/images/items/Attack_Water.png';	

		elseif($inaam == 'TM04' || $inaam == 'TM10' || $inaam == 'TM16' || $inaam == 'TM29' || $inaam == 'TM33' || $inaam == 'TM43' || $inaam == 'TM48') $img = '/images/items/Attack_Psychic.png';
		elseif($inaam == 'TM05' || $inaam == 'TM17' || $inaam == 'TM27'|| $inaam == 'TM32' || $inaam == 'TM42' || $inaam == 'TM44' || $inaam == 'TM45' || $inaam == 'TM46') $img = '/images/items/Attack_Normal.png';
		elseif($inaam == 'TM06' || $inaam == 'TM36') $type = 'Poison';
		elseif($inaam == 'TM07' || $inaam == 'TM13' || $inaam == 'TM14') $img = '/images/items/Attack_Ice.png';
		elseif($inaam == 'TM09' || $inaam == 'TM19' || $inaam == 'TM22') $img = '/images/items/Attack_Grass.png';
		elseif($inaam == 'TM11' || $inaam == 'TM35' || $inaam == 'TM38' || $inaam == 'TM50') $img = '/images/items/Attack_Fire.png';
		elseif($inaam == 'TM12' || $inaam == 'TM41' || $inaam == 'TM49') $img = '/images/items/Attack_Dark.png';
		elseif($inaam == 'TM15' || $inaam == 'TM40') $type = 'Flying';
		elseif($inaam == 'TM23' || $inaam == 'TM47') $type = 'Steel';
		elseif($inaam == 'TM24' || $inaam == 'TM25' || $inaam == 'TM34' || $inaam == 'TM56'|| $inaam == 'TM62') $img = '/images/items/Attack_Electric.png';
else 
                 $img = '/images/items/'.$inaam.'.png';

if($soluong >0) {
$ab.='<div 
<div onclick="thongtin(\''.$inaam.'\');" class="showitem" style="border: 2px solid;"><img src="'.$img.'"><div class="count count-vp-1">'.$soluong.'</div></div>';
}

					}					
					
	

    $abc[a] = $ab;
    
    echo json($abc);
}




if(isset($_POST['ivp'])){
    	   $vatpham = mysql_fetch_assoc(mysql_query("SELECT * FROM `markt` WHERE  `naam`='".$_POST['id']."'"));
    	   $result=$vatpham;
if($vatpham['soort'] == "tm"){
  $inaam = $result['naam'];
		if($inaam == 'TM01' || $inaam == 'TM08' || $inaam == 'TM21' || $inaam == 'TM31') $type = 'Fighting';
		elseif($inaam == 'TM02') $type = 'Dragon';
		elseif($inaam == 'TM03' || $inaam == 'TM18') $type = 'Water';
		elseif($inaam == 'TM04' || $inaam == 'TM10' || $inaam == 'TM16' || $inaam == 'TM29' || $inaam == 'TM33' || $inaam == 'TM43' || $inaam == 'TM48') $type = 'Psychic';
		elseif($inaam == 'TM05' || $inaam == 'TM17' || $inaam == 'TM27'|| $inaam == 'TM32' || $inaam == 'TM42' || $inaam == 'TM44' || $inaam == 'TM45' || $inaam == 'TM46') $type = 'Normal';
		elseif($inaam == 'TM06' || $inaam == 'TM36') $type = 'Poison';
		elseif($inaam == 'TM07' || $inaam == 'TM13' || $inaam == 'TM14') $type = 'Ice';
		elseif($inaam == 'TM09' || $inaam == 'TM19' || $inaam == 'TM22') $type = 'Grass';
		elseif($inaam == 'TM11' || $inaam == 'TM35' || $inaam == 'TM38' || $inaam == 'TM50') $type = 'Fire';
		elseif($inaam == 'TM12' || $inaam == 'TM41' || $inaam == 'TM49') $type = 'Dark';
		elseif($inaam == 'TM15' || $inaam == 'TM40') $type = 'Flying';
		elseif($inaam == 'TM23' || $inaam == 'TM47') $type = 'Steel';
		elseif($inaam == 'TM24' || $inaam == 'TM25' || $inaam == 'TM34') $type = 'Electric';
		else $type = 'Rock';  
    $img = '<div id="bagitem" style="display: inline-block;"><div  class="showitem" style="border: 2px solid;"><img src="/images/items/Attack_'.$type.'.png"><div class="count count-vp-1">'.$itemdata[$result['naam']].'</div></div></div>';
    $gioithieu = 'Dùng để học kĩ năng mới cho PokeMon';
} else if($result['soort'] == "hm"){
		
		$inaam = $result['naam'];
		
		if($inaam == 'HM01') $type = 'Grass';
		elseif($inaam == 'HM02') $type = 'Flying';
		elseif($inaam == 'HM03' || $inaam == 'HM07' || $inaam == 'HM08') $type = 'Water';
		elseif($inaam == 'HM04' || $inaam == 'HM06') $type = 'Fighting';
		else $type = 'Electric';
		$img = '<div id="bagitem" style="display: inline-block;"><div  class="showitem" style="border: 2px solid;"><img src="/images/items/Attack_'.$type.'.png"><div class="count count-vp-1">'.$itemdata[$result['naam']].'</div></div></div>';
    $gioithieu = 'Dùng để học kĩ năng mới cho PokeMon';
} else {
    	$img = '<div id="bagitem" style="display: inline-block;"><div  class="showitem" style="border: 2px solid;"><img src="/images/items/'.$result['naam'].'.png"><div class="count count-vp-1">'.$itemdata[$result['naam']].'</div></div></div>';
    $gioithieu = ''.$result[naam].'<br>'.$result[omschrijving_en];
}
 $check_sl = mysql_fetch_assoc(mysql_query("SELECT gebruikers_item.*, gebruikers_tmhm.* FROM gebruikers_item INNER JOIN gebruikers_tmhm ON gebruikers_item.user_id = gebruikers_tmhm.user_id WHERE gebruikers_item.user_id = '".$_SESSION['id']."'"));
        $soluong = mysql_fetch_assoc(mysql_query("SELECT *  FROM markt  WHERE `naam` = '".$_POST['id']."'  "));
      if($datauser->item->$_POST[id] > 0){
         $ducnghiaJSONz .='<b class="viptxt nutchat" onclick="banitem('.$soluong[id].')">Kí gửi</b>';
      
          

}

     $ducnghiaJSON[msg] = $vatpham['naam'].' (X'.$check_sl[$soluong['naam']].')';
          $ducnghiaJSON[img] = $img;
                    $ducnghiaJSON[gioithieu] = t($gioithieu,1);
                    $ducnghiaJSON[muaban] = $ducnghiaJSONz;


echo json_encode($ducnghiaJSON);
die;
}


if(isset($_POST['banitemok'])){
            $idaaa = $_POST['id'];
            $bac = $_POST['bac_ban'];
                        $vang = $_POST['vang_ban'];

        $sl =bug($_POST[soluong]);

if(!$user_id) {
    exit;
}



 $check_sl = mysql_fetch_assoc(mysql_query("SELECT gebruikers_item.*, gebruikers_tmhm.* FROM gebruikers_item INNER JOIN gebruikers_tmhm ON gebruikers_item.user_id = gebruikers_tmhm.user_id WHERE gebruikers_item.user_id = '".$_SESSION['id']."'"));
        $soluong = mysql_fetch_assoc(mysql_query("SELECT *  FROM markt  WHERE `id` = '".$_POST['id']."'  "));
        if($datauser->level<=14) {
    $msg = t('Bạn phải đạt trình độ 15 trở lên.');
} else
         if($sl <=0) { 
             $msg = t('Số lượng không hợp lệ'); }
              else if($bac <=0) {
                 $msg = t('Số tiền không hợp lệ.');
             }
             else if($vang <0) {
                 $msg = t('Số tiền không hợp lệ.');
             }
             else {
             
             
                
            if($datauser->item->$soluong['naam'] >= $sl) {
           $msg = t('bán thành công'); 
      		$datauser->setitem($soluong['naam'],'-'.$sl);
      		
      		    $datauser->lichsu(' bán vật phẩm '.$soluong['naam'].' sl : '.$sl.' giá '.$vang.' ruby ,  '.$bac.' xu  ');

      		
     mysql_query("INSERT INTO `ducnghia_cho` SET `tenvatpham` = '".$soluong['naam']."' , `loai` = '{$soluong[soort]}', `soluong` = '$sl',`giabac` = '$bac',`giavang` = '$vang',`nguoiban` = '{$_SESSION['id']}'  ");

        } else {
            $msg = t('Lỗi.');
        }


}
    

$ducnghiaJSON[msg] = $msg;
 echo json_encode($ducnghiaJSON);
die;
} 


if(isset($_POST['vpducnghia'])){
$vp = $_POST['id'];

$item=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id`='".$vp."'"));

$msg .= '<div id="bagitem" style="display: inline-block;"><div onclick="xemshopvatpham('.$item[id].');" class="showitem" style="border: 2px solid;"><img src="/images/_/'.$item[id].'.png"><div class="count count-vp-1">'.$datauser->vatpham->$vp.'</div></div></div>';
$ten = $item['tenvatpham'];

$gioithieu = ''.t($item['tenvatpham']).'<br>'.t($item['thongtin']).$t;

if(!empty($item[query])) {
    if($datauser->vatpham->$vp>=1) {
    $sudung .= '<b onclick="sudung('.$item['id'].',\'1\')" class="viptxt nutchat">'.t('Sử dụng').' 1</b> '; }
    if($datauser->vatpham->$vp>=5) {
    $sudung .= '<b onclick="sudung('.$item['id'].',\'5\')" class="viptxt nutchat">'.t('Sử dụng').' 5</b> '; }

 if($datauser->vatpham->$vp>=20) {
    $sudung .= '<b onclick="sudung('.$item['id'].',\'20\')" class="viptxt nutchat">'.t('Sử dụng').' 20</b> '; }

 if($datauser->vatpham->$vp>=50) {
    $sudung .= '<b onclick="sudung('.$item['id'].',\'50\')" class="viptxt nutchat">'.t('Sử dụng').' 50</b>'; }
} else {
       $sudung .= ''; }
 

if($datauser->vatpham->$vp !=0) {
    $sudung.= '<b onclick="ban_vp('.$item[id].')" class="viptxt nutchat">'.t('Bán').'</b>';

    
}


    $ducnghiaJSON[img] = $msg;
        $ducnghiaJSON[msg] = $ten;
        $ducnghiaJSON[gioithieu] = $gioithieu;
        $ducnghiaJSON[sudung] = $sudung;
        $ducnghiaJSON[ban] = $ban;

    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST['ban'])){
$vp = $_POST['id'];
$vatpham=mysql_query("SELECT * FROM `vatpham` WHERE  `id_shop` = '$vp' AND `user_id` = '$user_id'");
$show=mysql_fetch_array($vatpham);
$item=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id`='$vp'"));

$msg .= '<div id="bagitem" style="display: inline-block;"><div onclick="xemshopvatpham('.$item[id].');" class="showitem" style="border: 2px solid;"><img src="/images/_/'.$item[id].'.png"><div class="count count-vp-1">'.$show[soluong].'</div></div></div>';
$ten = t($item['tenvatpham']);
$gioithieu = $item['thongtin'];

if($datauser->vatpham->$vp!=0) {
        $ban = '<button><a href="javascript:okban_vp_shop('.$item['id'].');">'.t('Đăng bán').'</a></button>';

}


        $ducnghiaJSON[ten] = $ten;
        $ducnghiaJSON[nut] = $ban;

    echo json_encode($ducnghiaJSON);
die;	
	

}

if(isset($_POST['okbducnghia'])){
$vp = $_POST['id'];
$soluong = bug($_POST['sl_ban']);
$giabac = $_POST['gia_ban_bac'];
$giavang = $_POST['gia_ban_vang'];


$vatpham=mysql_query("SELECT * FROM `vatpham` WHERE  `id_shop` = '$vp' AND `user_id` = '$user_id'");
$show=mysql_fetch_array($vatpham);
$item=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id`='$vp'"));
if(!$user_id) {
    exit;
}
if($giabac <=0) {
    $msg = '????';
}else
if($giavang <0) {
    $msg = '????';
}else
if($datauser->level<=14) {
    $msg = t('Trình độ 15 mới được mua bán.');
}else
if($show[timesudung] !=0) {
    $msg = t('Bạn chỉ có thể bán đồ không có hạn sử dụng.');
} else
if($datauser->vatpham->$item['id'] < $soluong or $soluong <=0) {
    $msg = t('Bạn không có số lượng này ');
} else {
    
         mysql_query("INSERT INTO `ducnghia_cho` SET `tenvatpham` = '".$item['id']."' , `loai` = 'ducnghia', `soluong` = '$soluong',`giabac` = '$giabac',`giavang` = '$giavang',`nguoiban` = '{$_SESSION['id']}'  ");

$datauser->setvatpham($item['id'],'-'.$soluong);


$msg = ''.t('Bán thành công.').'';

}

        $ducnghiaJSON[thongbao] .= $msg;

    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST['choitems'])){
              $getevo = mysql_query('SELECT * FROM ducnghia_cho');
            while ($evo1 = mysql_fetch_assoc($getevo)) {
$result = $evo1;
     	$inaam = $result['naam'];
if($result[loai]=='ducnghia') {
    		$img = '/images/_/'.$result[tenvatpham].'.png';

} else
if($result[loai] == 'tm') {
	if($inaam == 'TM01' || $inaam == 'TM08' || $inaam == 'TM21' || $inaam == 'TM31') $type = 'Fighting';
		elseif($inaam == 'TM02') $type = 'Dragon';
		elseif($inaam == 'TM03' || $inaam == 'TM18') $type = 'Water';
		elseif($inaam == 'TM04' || $inaam == 'TM10' || $inaam == 'TM16' || $inaam == 'TM29' || $inaam == 'TM33' || $inaam == 'TM43' || $inaam == 'TM48') $type = 'Psychic';
		elseif($inaam == 'TM05' || $inaam == 'TM17' || $inaam == 'TM27'|| $inaam == 'TM32' || $inaam == 'TM42' || $inaam == 'TM44' || $inaam == 'TM45' || $inaam == 'TM46') $type = 'Normal';
		elseif($inaam == 'TM06' || $inaam == 'TM36') $type = 'Poison';
		elseif($inaam == 'TM07' || $inaam == 'TM13' || $inaam == 'TM14') $type = 'Ice';
		elseif($inaam == 'TM09' || $inaam == 'TM19' || $inaam == 'TM22') $type = 'Grass';
		elseif($inaam == 'TM11' || $inaam == 'TM35' || $inaam == 'TM38' || $inaam == 'TM50') $type = 'Fire';
		elseif($inaam == 'TM12' || $inaam == 'TM41' || $inaam == 'TM49') $type = 'Dark';
		elseif($inaam == 'TM15' || $inaam == 'TM40') $type = 'Flying';
		elseif($inaam == 'TM23' || $inaam == 'TM47') $type = 'Steel';
		elseif($inaam == 'TM24' || $inaam == 'TM25' || $inaam == 'TM34') $type = 'Electric';
		else $type = 'Rock';
		$img = '/images/items/Attack_'.$type.'.png';
} else
if($result[loai] == 'hm') {
 	if($inaam == 'HM01') $type = 'Grass';
		elseif($inaam == 'HM02') $type = 'Flying';
		elseif($inaam == 'HM03' || $inaam == 'HM07' || $inaam == 'HM08') $type = 'Water';
		elseif($inaam == 'HM04' || $inaam == 'HM06') $type = 'Fighting';
		else $type = 'Electric'; 
				$img = '/images/items/Attack_'.$type.'.png';

} else {
				$img = '/images/items/'.$result['tenvatpham'].'.png';

}
	$msg .= '<a onclick="xemdemua('.$result['id'].');"id="item'.$res['id'].'"><div id="bagitem" style="display: inline-block;"><div  class="showitem" style="border: 2px solid;"><img src="'.$img.'"><div class="count count-vp-1"> X'.$result['soluong'].'</div></div></div></a>';
            }
         
			  $n .= '<br><center>'.t('Cửa hàng kí gửi vật phẩm').'</center></br>';
			  			  $n .= $msg;


          
$ducnghiaJSON['a'] = $n;
    echo json_encode($ducnghiaJSON);
die;
}

if(isset($_POST['xemdemua'])){
            $idaaa = $_POST['id'];

        $soluong = mysql_fetch_assoc(mysql_query("SELECT *  FROM ducnghia_cho  WHERE `id` = '".$_POST['id']."'  "));
      if($soluong[id] != 0){

        $vatpham = mysql_fetch_assoc(mysql_query("SELECT *  FROM `shopvatpham`  WHERE `id` = '".$soluong['tenvatpham']."'  "));
if($soluong[loai]=='ducnghia'){
    $ten = t($vatpham[tenvatpham]);
} else {    $ten = $soluong[tenvatpham]; }
$ducnghiaJSON[aaaa] = ''.$ten.' [X'.$soluong[soluong].']  <br>
'.t('Người bán').' : '.users($soluong['nguoiban']).' <br> '.t('Giá bán').' :
  '.highamount($soluong['giabac']).' xu -   '.highamount($soluong['giavang']).' ruby.

';
    
}
$ducnghiaJSON[button] = '<b onclick="okmuaitemthoi('.$soluong['id'].')" class="viptxt nutchat">'.t('Mua').'</b>';

 echo json_encode($ducnghiaJSON);
die;
}


if(isset($_POST['dangmua'])){
            $idaaa = $_POST['id'];
           
        $soluong = mysql_fetch_assoc(mysql_query("SELECT *  FROM ducnghia_cho  WHERE `id` = '".$_POST['id']."'  "));
                $sl =$soluong[soluong];
if($datauser->level<=14) {
    $msg = ''.t('Đạt cấp độ 15 mới có thể tham gia mua bán.').'';
} else
if($soluong['id'] ==0) {
    $msg = ''.t('Món hàng này không tồn tại').'';
}
 else
if($soluong['giabac'] > $gebruiker->xu) {
   $thieu_v= $soluong[giavang] - $datauser->ruby;
    $thieu_b = $soluong[giabac] - $datauser->xu;
    $msg = ''.t('Bạn chưa đủ tiền.').' '; 
}
else
if($soluong['giavang'] > $gebruiker->ruby) {
   $thieu_v= $soluong[giavang] - $datauser->ruby;
    $msg = ''.t('Bạn chưa đủ tiền.').' '; 
}

else {
if($soluong[loai] == "ducnghia") {
  $datauser->setvatpham($soluong['tenvatpham'],$sl);
} else

       {
      			$datauser->setitem($soluong['tenvatpham'],$sl);

        }
        
              			mysql_query("UPDATE users SET `ruby` = `ruby` - '".$soluong['giavang']."',`xu` = `xu` - '".$soluong['giabac']."' WHERE user_id='".$_SESSION['id']."'");
              			
    ///tính phí ///
    $phi = $hethong->data->phi;
    $vua = $soluong['giavang']/100*$phi;
    $nguoi = $soluong['giavang'] - $vua;
    
    $v_xu = $soluong['giabac']/100*$phi;
      $v_nguoi = $soluong['giabac']-$v_xu;
     
        mysql_query("UPDATE users SET `ruby` = `ruby` + '".$nguoi."',`xu` = `xu` + '".$v_nguoi."' WHERE user_id='".$soluong['nguoiban']."'");
 
    mysql_query("UPDATE users SET `ruby` = `ruby` + '".$vua."',`xu` = `xu` + '".$v_xu."' WHERE vua='1'");


             			mysql_query("DELETE FROM `ducnghia_cho` where `id` = $idaaa ");

       $msg = ''.t('Mua thành công.Vui lòng kiểm tra món đồ tại rương.').''; 
 
}

    

$ducnghiaJSON[msg] = $msg;
 echo json_encode($ducnghiaJSON);
die;
} 

if(isset($_POST['cuahangpkm'])){
                          $tl_sql = mysql_query("SELECT pw.naam, pw.type1, pw.type2, ps.*, t.id AS tid, t.silver , t.gold, g.username AS owner FROM pokemon_wild AS pw INNER JOIN pokemon_speler AS ps ON pw.wild_id = ps.wild_id INNER JOIN transferlijst AS t ON t.pokemon_id = ps.id INNER JOIN users AS g ON ps.user_id = g.user_id WHERE (t.to_user='0' OR t.to_user='".$_SESSION['id']."' OR t.user_id='".$_SESSION['id']."') ORDER BY t.silver,t.gold DESC ");
                          for($j=$pagina+1; $tl = mysql_fetch_assoc($tl_sql); $j++){
            $bedrag = number_format(round($tl['silver']),0,",",".");
                        $gold = number_format(round($tl['gold']),0,",",".");

            $owner = $tl['owner'];
			      $decodedid = base64_encode($tl['tid']);
			      $tid = $tl['tid'];

          	#Gegevens juist laden voor de pokemon
          	$tl = pokemonei($tl);
          	#Naam veranderen als het male of female is.
          	$tl['naam'] = pokemon_naam($tl['naam'],$tl['roepnaam']);
      			#popup

      			#$link      = "pokemon/icon/".$naamklein.".gif";
    			  $shinystar = '';
    			  $pokemontype = $tl['type1'];
			
            #Heeft pokemon meerdere types
            if(!empty($tl['type2']))
              $pokemontype = $tl['type1']."-".$tl['type2'];

            if($tl['shiny'] == 1){
              #$link      = "shiny/icon/".$naamklein.".gif";
			        $shinystar = '<img src="images/icons/lidbetaald.png" width="16" height="16" style="margin-bottom:-3px;" border="0" alt="Shiny" title="Shiny">';
            }

          

	$msg .= '<a onclick="pokemon('.$tl['id'].');"id="item'.$res['id'].'"><div class="items"><div class="daocu" style="background: url('.$tl['ducnghia'].'); background-size: 50px;"></div>
			<div class="subitem"> '.$bedrag.' Xu</div>
			</div></a>';
         
			  
          } 

    		  
              
		
	  

            
$ducnghiaJSON['a'] = $msg;
    echo json_encode($ducnghiaJSON);
die;
}


if(isset($_POST['pokemon'])){
        $idaaa = $_POST['id'];
         		$pkm = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_speler WHERE `id`='$idaaa'"));

    	$profiel = mysql_fetch_assoc(mysql_query("SELECT pokemon_speler.*, pokemon_wild.naam, pokemon_wild.type1, pokemon_wild.type2
							   FROM pokemon_speler
							   INNER JOIN pokemon_wild
							   ON pokemon_speler.wild_id = pokemon_wild.wild_id
							   WHERE `id`='$idaaa'"));
    	
    	$pokemon_profile = $profiel;
    	$pkm = $pokemon_profile;
 $pokemon_profile = pokemonei($pokemon_profile);
        $pokemon_profile['naam'] = pokemon_naam($pokemon_profile['naam'],$pokemon_profile['roepnaam']);
        $popup = pokemon_popup($pokemon_profile, $txt);
        if($pokemon['gehecht'] == 1) $gehecht = "<tr><td><strong>".$txt['popup_begin']."</strong></td><td style=&quot;padding-left: 4px;&quot;><img src=&quot;images/icons/friend.png&quot;></td></tr>";
  else $gehecht = "";
  if($pokemon['aanval_2'] == "") $aanval2 = "";
  else $aanval2 = "2. ".$pokemon['aanval_2'];
  if($pokemon['aanval_3'] == "") $aanval3 = "";
  else $aanval3 = "3. ".$pokemon['aanval_3'];
  if($pokemon['aanval_4'] == "") $aanval4 = "";
  else $aanval4 = "4. ".$pokemon['aanval_4'];

         $pokemon_profile['powertotal'] = $pokemon_profile['attack'] + $pokemon_profile['defence'] + $pokemon_profile['speed'] + $pokemon_profile['spc.attack'] + $pokemon_profile['spc.defence'];
 		$ducnghia_nguoibat = mysql_fetch_assoc(mysql_query("SELECT `username` FROM gebruikers WHERE `user_id`='".$pokemon_profile['nguoibat']."'"));
         		$pokeMonai = mysql_fetch_assoc(mysql_query("SELECT `username` FROM gebruikers WHERE `user_id`='".$pokemon_profile['user_id']."'"));
$ducnghiaJSON[chucnang] = $pokemon_profile['roepnaam'];
		$ducnghiaJSON[ten] = $pokemon_profile['roepnaam'];
$ducnghiaJSON[img] = '<img src="'.$pokemon_profile['link'].'">' ;
if($pokemon_profile[opzak] != 'tra') {

if($user_id ==$profiel[user_id]) {

if(empty($pokemon_profile[opzak_nummer])) {
    $catvao.= '
    <div class="left" onclick="chora('.$pokemon_profile['id'].');"><a class="btn">'.t('Lấy').'</a></div>
    ';
} else {
       $catvao.= '    <div class="left" onclick="bo('.$pokemon_profile['id'].');"><a class="btn">'.t('Cất').'</a></div>
';
 
}
       $catvao.= '<div class="left" onclick="trangbi('.$pokemon_profile['id'].')"><a class="btn">'.t('Đồ').'</a></div>';
$catvao.= '<div class="left" onclick="follow('.$pokemon_profile['wild_id'].')"><a class="btn">'.t('Dắt').'</a></div>';       

}

}
if(!empty($pokemon_profile[type1])) {
   $he .= '<div class="type '.$pokemon_profile[type1].'">'.$pokemon_profile[type1].'</div>';
}  if(!empty($pokemon_profile[type2])) {
   $he .= '<div class="type '.$pokemon_profile[type2].'">'.$pokemon_profile[type2].'</div>';

}
if($pokemon_profile['shiny'] == 1) { $img = "shiny"; $img_bg= "shiny"; }
		else { $img = "pokemon"; $img_bg = ""; }
$lvnew = $pokemon_profile['level']+1;
         		$checkskill = mysql_fetch_assoc(mysql_query("SELECT * FROM levelen WHERE `level` = '".$lvnew."' AND `wat` = 'att' AND `wild_id`='".$pokemon_profile['wild_id']."'"));
         		
if($checkskill[id]!=0) {
    $kinang = $checkskill[aanval];
}         else {
    $kinang = ''.t('Không có hiệu ứng').'';
} 	

$checktienhoa = mysql_fetch_assoc(mysql_query("SELECT * FROM levelen WHERE `level` = '".$lvnew."' AND `wat` = 'evo' AND `wild_id`='".$pokemon_profile['wild_id']."'"));
         		
if($checktienhoa[id]!=0) {
    $n_tienhoa = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE `wild_id` = '".$checktienhoa[nieuw_id]."'"));

    $tienhoa = $n_tienhoa[naam];
}         else {
    $tienhoa = 'Không';
} 		


    $ttinh = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE `wild_id` = '".$pokemon_profile[wild_id]."'"));
$dn = $ttinh['groei'];  ///$dn = đức nghĩa
if($dn=="Erratic") {
    $dhp = 10;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
    $sptancong = 3;
    $spphongthu = 3;
  
}

if($dn=="Fast") {
    $dhp = 5;
    $dgiap = 3;
    $dtocdo = 15;
    $dtancong = 0;
  $sptancong = 1;
    $spphongthu = 1;   
}

if($dn=="Medium Fast") {
    $dhp = 15;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
  $sptancong = 6;
    $spphongthu = 6;    
}
if($dn=="Medium Slow") {
    $dhp = 20;
    $dgiap = 20;
    $dtocdo = 15;
    $dtancong = 15;
  $sptancong = 15;
    $spphongthu = 15;    
}
if($dn=="Slow") {
    $dhp = 25;
    $dgiap = 40;
    $dtocdo = 24;
    $dtancong = 36;
  $sptancong = 25;
    $spphongthu = 30;    
}

if($dhp >=1) {
    $tx .= '<b class="viptxt">'.$dhp.'%</b><b class="ducnghia_connet"><font color="red">HP</font></b>|';
}
if($dgiap >=1) {
    $tx .= '<b class="viptxt">'.$dgiap.'%</b><b class="ducnghia_connet"><font color="">DF</font></b>|';
    
}
if($dtocdo >=1) {
        $tx .= '<b class="viptxt">'.$dtocdo.'%</b><b class="ducnghia_connet"><font color="blue">SP</font></b>|';

}
if($dtancong >=1) {
        $tx .= '<b class="viptxt">'.$dtancong.'%</b><b class="ducnghia_connet"><font color="green">AT</font></b>|';
}
if($sptancong >=1) {
    $tx .= '<b class="viptxt">'.$sptancong.'%</b><b class="ducnghia_connet"><font color="red">SP.AT</font></b>|';
}
if($spphongthu >=1) {
    $tx .= '<br><b class="viptxt">'.$spphongthu.'%</b><b class="ducnghia_connet"><font color="red">SP.DE</font></b>|';
}

if($pokemon_profile[user_id]== $user_id AND $pokemon_profile[tn] !=0) {
    $tnhp = '<b onclick="tn('.$pokemon_profile['id'].',1,\'tnhp\')">[+1]</b>   <b onclick="tn('.$pokemon_profile['id'].',5,\'tnhp\')">[+5]</b>';
        $tndf = '<b onclick="tn('.$pokemon_profile['id'].',1,\'tndf\')">[+1]</b>   <b onclick="tn('.$pokemon_profile['id'].',5,\'tndf\')">[+5]</b>';
        $tnat = '<b onclick="tn('.$pokemon_profile['id'].',1,\'tnat\')">[+1]</b>   <b onclick="tn('.$pokemon_profile['id'].',5,\'tnat\')">[+5]</b>';

        $tnsp = '<b onclick="tn('.$pokemon_profile['id'].',1,\'tnsp\')">[+1]</b>   <b onclick="tn('.$pokemon_profile['id'].',5,\'tnsp\')">[+5]</b>';

}
if($pokemon_profile[opzak] != 'tra') {

if($user_id ==$profiel[user_id]) {
   $menu_pkm = '
   
   <div class="pokemonslist">
   <div class="element element-2" onclick="banpkm('.$pokemon_profile['id'].');">'.t('Bán').'</div><div class="element element-3" onclick="info_doiten('.$pokemon_profile['id'].');"> '.t('Đổi tên').'</div><div class="element element-4"onclick="dungvp('.$pokemon_profile['id'].');">'.t('Kẹo').'</div><div class="element element-5" onclick="info_move('.$pokemon_profile['id'].');">Move</div><div class="element element-6" onclick="thapokemon('.$pokemon_profile['id'].');">'.t('Thả').'</div><div class="element element-7" onclick="auto_pkm('.$pokemon_profile['id'].')">Auto</div> 
   </div>
   
'; 
} } else {
    if($user_id !=$profiel[user_id]) {
$you = mysql_fetch_assoc(mysql_query("SELECT * FROM transferlijst WHERE user_id = '".$profiel[user_id]."' AND `pokemon_id` = '".$pokemon_profile['id']."' "));

 $nutmua=' <div class="mid" onclick="muapkm('.$you[id].');"><a class="btn">'.t('Mua pokemon').' </a></div>'; }
 
 else if($user_id ==$profiel[user_id]) {
 $nuthu=' <div class="right" onclick="gopkm('.$pokemon_profile[id].');"><a class="btn">'.t('Hủy bán').'</a></div>'; 
      
 }
    
}
if($pokemon_profile['effect'] !='') {
    $hu  = $pokemon_profile['effect'];
} else {
    $hu = ''.t('không có hiệu ứng').'.';
}

///trangbi
if($pkm[dai]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[dai].','.$pkm[id].')"><img src="/img/trangbi/dai.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Đai').'</b>';

if($pkm[non]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[non].','.$pkm[id].')"><img src="/img/trangbi/155.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Nón').'</b>';
if($pkm[khan]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[khan].','.$pkm[id].')"><img src="/img/trangbi/162.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Khăn').'</b>';
if($pkm[kinh]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[kinh].','.$pkm[id].')"><img src="/img/trangbi/302.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Kính').'</b>';
if($pkm[day]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[day].','.$pkm[id].')"><img src="/img/trangbi/310.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Dây').'</b>';
if($pkm[nhan]!=0) $trangbi.='<b class="trangbi" onclick="trangbi_xem('.$pkm[nhan].','.$pkm[id].')"><img src="/img/trangbi/355.png"></b>'; else $trangbi.='<b class="trangbi">'.t('Nhẫn').'</b>';

$ducnghiaJSON[data] = '<div class="maininfo"><div class="namepanel "> <p class="name" onclick="pokemon('.$pokemon_profile['id'].')">'.$pokemon_profile['naam'].'</p> </div> <div class="introbackground "><p class="text text-1">'.t('Tăng trưởng').'</p> <p class="intername">'.$ttinh['groei'].'</p><p class="text text-2">'.t('Trình độ').'</p><p class="lv">'.highamount($pokemon_profile['level']).'</p><p class="text text-3">'.t('Người bắt').'</p> <p class="sex">'.ducnghia_us($pokemon_profile['nguoibat']).' </p><p class="text text-4">'.t('Lực chiến').'</p> <div class="type viptxt">'.highamount($pokemon_profile['powertotal']).'</div><p class="text text-5">'.t('Chủ').'</p><p class="nature">'.ducnghia_us($pokemon_profile['user_id']).'</p> <p class="text text-6">'.t('Sao').'</p><p class="ot">'.highamount($pokemon_profile[sao]).'*</p></div> </div><div class="chart" id="ducnghia_console">
<br>
<b>
<center>Chi Tiết</center>
<font color="96ef07"> <b>HP:</b>'.highamount($pokemon_profile['leven']).'/'.highamount($pokemon_profile['levenmax']).' '.$tnhp0.'    <b class="sangphai">DEF:'.highamount($pokemon_profile['defence']).' '.$tndf0.'</b>  
	<b class="sangphai">SPE:'.highamount($pokemon_profile['speed']).' '.$tnsp0.'	</b>
<b class="sangphai">'.t('cấp').':'.highamount($pokemon_profile['level']).' '.t('exp').': '.highamount($pokemon_profile['exp']).'/ '.highamount($pokemon_profile['expnodig']).' </b> 
<br>
ATT:'.highamount($pokemon_profile['attack']).' '.$tnat0.'
<b class="sangphai"></b>
 <br>
	<b>Sp.ATT:'.highamount($pokemon_profile['spcattack']).'</b>								
	<b class="sangphai">Sp.DEF:'.highamount($pokemon_profile['spcdefence']).'</b>		
<br>
<b class="sangphai"><img src="img/protein.png" alt="protein" title="protein">+'.$pokemon_profile['attack_up'].'</b>
		<b class="sangphai"><img src="img/iron.png" alt="protein" title="protein">+'.$pokemon_profile['defence_up'].'</b>
<b class="sangphai"><img src="img/carbos.png" alt="protein" title="protein">+'.$pokemon_profile['speed_up'].'</b>	 	
<b class="sangphai"><img src="img/calcium.png" alt="protein" title="protein">+'.$pokemon_profile['spc_up'].'</b>
<b class="sangphai"><img src="img/hpup.png" alt="protein" title="protein">+'.$pokemon_profile['hp_up'].'</b>
</font>

</b>
<br> <br>
<center> 
'.$trangbi.'


</center>



</div><div class="close" onclick="c_table()">X</div> <div class="mainpic "><img class="bigpic" src="images/'.$img.'/'.$pokemon_profile['wild_id'].'.gif">




</div> <div class="mainpoke " style="overflow-y: auto;"> <div class="hp"></div> <div id="trangbi"> <div class="element">'.t('Kĩ năng').'</div><div class="skill skill-1">'.$pokemon_profile['aanval_1'].'</div><div class="skill skill-2">'.$pokemon_profile['aanval_2'].'</div><div class="skill skill-3">'.$pokemon_profile['aanval_3'].'</div><div class="skill skill-4">'.$pokemon_profile['aanval_4'].'</div></div><div class="exp"></div></div><div class="itemhold "> <div class="item">'.$hu.'</div></div>'.$menu_pkm.'   <div class="pokemonscontrol ">'.$catvao.''.$nutmua.' '.$nuthu.' </div>';
$ducnghiaJSON[nhanvat] = 'images/'.$img.'/'.$pokemon_profile['wild_id'].'.gif';


			
	
	


$ducnghiaJSON[ducnghia]='';



    
    echo json_encode($ducnghiaJSON);
die;

}

if(isset($_POST['showban'])){
        $idaaa = $_POST['id'];

    	$profiel = mysql_fetch_assoc(mysql_query("SELECT pokemon_speler.*, pokemon_wild.naam, pokemon_wild.type1, pokemon_wild.type2
							   FROM pokemon_speler
							   INNER JOIN pokemon_wild
							   ON pokemon_speler.wild_id = pokemon_wild.wild_id
							   WHERE `id`='$idaaa'"));
    	
    	$pokemon_profile = $profiel;
 $pokemon_profile = pokemonei($pokemon_profile);
        $pokemon_profile['naam'] = pokemon_naam($pokemon_profile['naam'],$pokemon_profile['roepnaam']);
        $popup = pokemon_popup($pokemon_profile, $txt);
      

        
         	

if($user_id ==$profiel[user_id]) {

$ducnghiaJSON[aaaa] = '<b class="viptxt">Giá</b> : <input id="giabac" class="form-control" type="number" value="Bạc" style="width: 91%;">

	  <button class="btn btn-primary" onclick="okban('.$pokemon_profile['id'].')" id="nutban">Bán</button></b>';
    
}




    
    echo json_encode($ducnghiaJSON);
die;

}


if(isset($_POST['banpkmok'])){
            $idpkm = $_POST['id'];
            $vang = $_POST['vang'];
            $bac = $_POST['bac'];
            
            
$select = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '".$idpkm."'"));
if($select[dai] !=0 or $select[dai] !=0 or $select[non] !=0 or  $select[khan] !=0 or $select[kinh] !=0 or $select[day] !=0 or $select[nhan] !=0 ) {
    $msg = 'Vui lòng tháo hết trang bị ra.';
} else
if($select['user_id'] != $user_id){

    $msg = 'Pokemon này không phải của bạn. '.$select[user_id].'  '.$_POST[id].' ';
} else
if($_POST[bac] <=0) {
    $msg = 'Vui Lòng nhập giá';
}


elseif($select['gehecht'] == 1){
$msg = 'Pokemon này chưa nở.';
} else 			

  	if( empty($bac)) {
  		    $msg = 'Bạn phải nhập số tiền mới có thể bán';
  		}
  		    elseif($select['opzak'] == 'tra') {
  		        $msg = 'Pokemon này đang được đăng bán trên chợ rồi.';
  		    } else{
  		        mysql_query("INSERT INTO `transferlijst` (`datum`, `user_id`, `to_user`, `pokemon_id`, `silver` , `gold`) 
        VALUES ('".date("Y-m-d")."', '".$_SESSION['id']."', '', '".$select['id']."', '".$_POST['bac']."','".$_POST['vang']."')");
      mysql_query("UPDATE `pokemon_speler` SET `opzak`='tra',`opzak_nummer` = '' WHERE `id`='".$select['id']."'");
      $msg = 'Đăng bán thành công.';
  		    }

    $ducnghiaJSON[msg] = $msg ;
 echo json_encode($ducnghiaJSON);
die;
}

if(isset($_POST['thao'])){
    mysql_query("DELETE FROM `transferlijst` WHERE `pokemon_id`='".$_POST[id]."'");
    mysql_query("UPDATE `pokemon_speler` SET `opzak`='nee' WHERE `id`='".$_POST[id]."'");

    $msg = 'Gỡ PokeMon Xuống Thành Công.';
    $ducnghiaJSON[msg] = $msg;
echo json_encode($ducnghiaJSON);
die;
}


if(isset($_POST['muapkm'])){
  $tid = $_POST['id'];

$select = mysql_fetch_assoc(mysql_query("SELECT * FROM transferlijst 
										WHERE id='".$tid."'"));
$you = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$_SESSION['id']."'"));
$inhuis = mysql_num_rows(mysql_query("SELECT `id` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND (opzak = 'nee' OR opzak = 'tra')"));
$maxlevel = $you['rank']*5;

if($datauser->level<=14) {
    $msg = 'Bạn phải đạt cấp độ 15 mới được mua bán';
} else

if($select['id']==0) {
  $msg = 'Gian hàng này không tồn tại '.$tid.' '; } else 
  
  if($select['silver'] > $you['xu']){
      $bacthieu = $select['silver'] - $you['xu'];
      $msg = 'Bạn còn thiếu '.$bacthieu.' xu để mua vật phẩm này. ';
  } else
  {
       mysql_query("UPDATE `pokemon_speler` SET `user_id`='".$_SESSION['id']."', `trade`='1.5', `opzak`='nee' WHERE `id`='".$select['pokemon_id']."'");
        #Nieuwe eigenaar silver minderen
        mysql_query("UPDATE `users` SET `xu`=`xu`-'".$select['silver']."' WHERE `user_id`='".$_SESSION['id']."'");
        #Oude eigenaar silver optellen
          $phi = $hethong->data->phi;
    $vua = $select['silver']/100*$phi;
    $nguoi = $select['silver'] - $vua;
        mysql_query("UPDATE `users` SET `xu`=`xu`+'".$nguoi."' WHERE `user_id`='".$select['user_id']."'");

        mysql_query("UPDATE `users` SET `xu`=`xu`+'".$vua."' WHERE `vua`='1'");
        
        
        #Verwijderen uit transferlijst tabel
        mysql_query("DELETE FROM `transferlijst` WHERE `id`='".$select['id']."'");
        #Opslaan als gezien
        update_pokedex($select['wild_id'],'','buy');
        #Opslaan als gehad bij de ander
        if(mysql_num_rows(mysql_query("SELECT ps.id FROM pokemon_speler AS ps INNER JOIN gebruikers AS g ON ps.user_id = g.user_id WHERE g.username='".$select['username']."' AND ps.wild_id='".$select['wild_id']."'")) == 1)
          mysql_query("UPDATE gebruikers SET `pok_gehad`=concat(pok_gehad,',".$select['wild_id']."') WHERE username='".$select['username']."'");


		#Event taal pack includen
	
		$event = '<img src="images/icons/blue.png" width="16" height="16" class="imglower" /> <a href="?page=profile&player='.$you['username'].'">'.$you['username'].'</a> Đã mua PokeMon  '.$select['naam'].' của bạn.Bạn nhận được  '.highamount($select['silver']).'  bạc và '.highamount($select['gold']).'  vàng';
		
		$noidung = nick($user_id).' Mua pokemon '.$select['naam'].' của bạn.Bạn nhận được  '.highamount($select['silver']).'  bạc .';
			tinnhan($noidung,$select['user_id'],'2');
	
		

$msg = 'Mua thành công PokeMon.Hãy vào rương nhà để nhận.';
      
  }

    $ducnghiaJSON[msg] = $msg;
echo json_encode($ducnghiaJSON);
die;
}

if(isset($_POST['doitenpet'])){
$iddd = $_POST['id'];
	            $tenmoi = $_POST['tenmoi'];
	                  $name = htmlspecialchars(addslashes($tenmoi)); 
$ducnghia_check =  mysql_fetch_assoc(mysql_query("SELECT `id`,`wild_id`,`user_id`,`roepnaam` FROM `pokemon_speler` WHERE `id` = '$iddd'"));

if($user_id == $ducnghia_check[user_id]) {
    $ducnghiaJSON[msg] = '<Br><div class="kengang"><center>Đổi tên</center></div><input id="tenmoi" class="form-control" type="text" value="" style="width: 91%;">
 <button class="btn btn-primary" onclick="doitenok('.$iddd.')" id="nutdotten">Đổi Tên</button>
';
}
    
    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST['doiten'])){
	$iddd = $_POST['id'];
	            $tenmoi = $_POST['tenmoi'];
	                  $name = htmlspecialchars(addslashes($tenmoi)); 
$ducnghia_check =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '$iddd'"));
$pokemon =mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id` = '" .$ducnghia_check['wild_id']."'"));;
	if($gebruiker->xu > 40 AND $ducnghia_check['user_id'] == $user_id){
	mysql_query("UPDATE `pokemon_speler` SET `roepnaam`='".$name."' WHERE `id`='".$iddd."'");
        	mysql_query("UPDATE `users` SET `xu`=`xu`-'40' WHERE `user_id`='".$_SESSION['id']."'"); 
        $ducnghiaJSON[msg] = 'Đổi Tên Thành Công.Giờ PokeMon của bạn tên là <font color="green">'.$name.'</font>';
} else {
            $ducnghiaJSON[msg] = 'Bạn không đủ 40 xu hoặc pokemon này không phải của bạn nhé.  '.$iddd.' ';

} 


    
    echo json_encode($ducnghiaJSON);
die;	
	

}

if(isset($_POST['item'])){

$caidat .='Không thể dùng item';
$ducnghiaJSON[msg] = $caidat;
   
            echo json_encode($ducnghiaJSON);

}


if(isset($_POST['vatpham'])){
	      	$vatpham = $_POST['vatpham']; 
	      	 $ducnghia_id = $_POST['d'];
$ducnghia =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '$ducnghia_id'"));
    $pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.* ,pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id WHERE pokemon_speler.id='".$ducnghia_id."'"));
  
       if ($datauser->item->keo <=0) {
        $msg = 'Bạn không có item này để sử dụng';   
       } else {
    if ($ducnghia['level'] < 100) {
				         $levelnieuw = $pokemon['level']+1;
      nieuwestats($pokemon,$levelnieuw,$pokemon['expnodig']);
      $toestemming = levelgroei($levelnieuw,$pokemon);
 
	$datauser->setitem('keo',-1);
				   $msg = 'PokeMon được tăng một cấp.';
				    }  else { $msg = 'PokeMon đã đạt cấp 100,không thể dùng.';}
       ///vp khac
      

       //het
       }

$ducnghiaJSON[msg] .= $msg;
    
    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST['hm'])){
        $ducnghia_vatpham =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gebruikers_item` WHERE `user_id` = '" .$datauser->id."'"));

      $ducnghia_tm =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gebruikers_tmhm` WHERE `user_id` = '" .$datauser->id."'"));


$caidat .='Vị trí : <select id="stt" name="stt" class="form-control" >
			  
			   <option value="1">Vị Trí 1 </option>
			   <option value="2">Vị Trí 2 </option>
			   <option value="3">Vị Trí 3 </option>
			   <option value="4">Vị Trí 4 </option>	</select>';
			   
$caidat .= '<select id="tm" name="tm" class="text_select">
';	
     $itemdata = mysql_fetch_assoc(mysql_query("SELECT gebruikers_item.*, gebruikers_tmhm.* FROM gebruikers_item INNER JOIN gebruikers_tmhm ON gebruikers_item.user_id = gebruikers_tmhm.user_id WHERE gebruikers_item.user_id = '".$_SESSION['id']."'"));
    $balls = mysql_query("SELECT *  FROM markt WHERE `soort` = 'HM' or `soort` = 'TM'   ORDER BY soort ASC, id ASC");
 while($result = mysql_fetch_assoc($balls)){

       if($datauser->citem($result['naam']) > 0){

    $caidat .=' <option value="'.$result['naam'].'">'.$result['naam'].' (x'.$datauser->citem($result['naam']).')</option> '; 
       }
 }


$caidat .='</select>';
			   
		$caidat .='	  <button class="btn btn-primary" onclick="movetm_ok('.$_POST[id].')" id="nutmove">Học</button> <Br><div id="end3_data"></div>
 ';
$ducnghiaJSON[msg] = $caidat;
   
            echo json_encode($ducnghiaJSON);

}


if(isset($_POST['move'])){
	      	$id_pokemon = $_POST['pokemon'];
	$vitri = $_POST['stt']; //dữ liệu PokeMon số thứ tự
$tm = $_POST['tm'];  /// tên tm
$ducnghia_wildpokemon =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '$id_pokemon'"));
 $ducnghia_tm = mysql_fetch_assoc(mysql_query("SELECT * FROM `gebruikers_tmhm` WHERE `user_id`='".$_SESSION['id']."'"));

  $ducnghia_skill_tim = mysql_fetch_assoc(mysql_query("SELECT * FROM tmhm WHERE `naam`='".$tm."'"));

 
if($ducnghia_wildpokemon['user_id'] != $user_id) {
   $msg = 'Pokemon này không phải của mày !';
} else if($datauser->citem($tm) <=0) {
    $msg = 'Không có TM này';
} else {
    			mysql_query("UPDATE pokemon_speler SET aanval_$vitri = '".$ducnghia_skill_tim['omschrijving']."' WHERE id = '".$_POST['pokemon']."'");
    			
$datauser->setitem($tm,-1);
    			  $msg = 'Sử dụng '.$tm.'  thành công.PokeMon đã học được chiêu thức mới.';

    			

} 
       

$ducnghiaJSON[msg] .= $msg;
    
    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST['shiny'])){
	$a = $_POST['id'];
	   	$pokemoninfo = mysql_fetch_assoc(mysql_query("SELECT pokemon_speler.user_id, pokemon_speler.opzak, pokemon_speler.shiny, pokemon_speler.ei, pokemon_wild.zeldzaamheid
												  FROM pokemon_speler
												  INNER JOIN pokemon_wild
												  ON pokemon_speler.wild_id = pokemon_wild.wild_id
												  WHERE pokemon_speler.id = '".$_POST['id']."'"));
												  if($pokemoninfo['ei'] == 1) {
$ducnghiaJSON['thongbao'] = 'Chỉ là quả trứng ?'; }
else if($pokemoninfo['user_id'] != $_SESSION['id']) {
    $ducnghiaJSON['thongbao'] = 'Hacker :3';
} else if($pokemoninfo['shiny'] == 1) {
     $ducnghiaJSON['thongbao'] = 'PokeMon đã sáng bóng rồi ? muốn phí tiền nữa à ? ';
} 	elseif($pokemoninfo['opzak'] != 'ja')  {
    $ducnghiaJSON['thongbao'] = 'Bạn phải cho pokemon theo người mới shiny được'; } else
    if($gebruiker->ruby < 100) {
        $ducnghiaJSON['thongbao'] = 'Kiếm đủ 100 ruby rồi quay lại đây.';
    } else {
        	mysql_query("UPDATE pokemon_speler SET shiny='1' WHERE id = '".$_POST['id']."' AND user_id = '".$_SESSION['id']."'");
		mysql_query("UPDATE users SET ruby = ruby-'100' WHERE user_id = '".$_SESSION['id']."'");
		        $ducnghiaJSON['thongbao'] = 'Đánh bóng PokeMon thành công..';

    }
    
    echo json_encode($ducnghiaJSON);
die;	
	

}

if(isset($_POST['layra'])){
	$iddd = $_POST['id'];
	            $tenmoi = $_POST['tenmoi'];
	                  $name = htmlspecialchars(addslashes($tenmoi)); 
$ducnghia_check =  mysql_fetch_assoc(mysql_query("SELECT* FROM `pokemon_speler` WHERE `id` = '$iddd'"));
$pokemon =mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id` = '" .$ducnghia_check['wild_id']."'"));;
	if($ducnghia_check['user_id'] != $user_id){

        $ducnghiaJSON[thongbao] = 'Bạn làm đéo gì có PokeMon này ? bug cái lồn gì zậy ?';} 
                mysql_data_seek($pokemon_sql, 0);
                $naampokemon = mysql_fetch_assoc($pokemon_sql);
                if($gebruiker->in_hand == 6)
                {            $ducnghiaJSON[thongbao] = 'Đã có 6 PokeMon mang theo trên người.';
 }
                elseif($naampokemon['transferlijst'] == 'ja') {
                    $ducnghiaJSON[thongbao] = 'PokeMon này đã đang được bán rồi.';
                }
                else   if($ducnghia_check['opzak'] == 'tra') {
  		         $ducnghiaJSON[thongbao] = 'Pokemon này đang được đăng bán trên chợ rồi.';
  		    }
                else{
                  #Opzak_nummer + 1
                  $opzaknummer = $gebruiker->in_hand+1;
                  #Pokemon naar hand verplaatsen
                  mysql_query("UPDATE `pokemon_speler` SET `opzak`='ja', `opzak_nummer`='".$opzaknummer."' WHERE `id`='".$_POST['id']."'");
                  #weergave op het scherm
                                  $over += 1;

$ducnghiaJSON[thongbao] = 'Đã cho PokeMon ra trận. ';
                }
      


echo json_encode($ducnghiaJSON);
die;	
	

}

if(isset($_POST['cat'])){
	$iddd = $_POST['id'];
	   $pokemon_weg = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND `id`='".$_POST['id']."'"));
                #Pokemon in huis tellen
                $pokemoninhuissql = mysql_fetch_assoc(mysql_query("SELECT COUNT(`id`) AS `aantal` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND (opzak = 'nee' OR opzak = 'tra')"));
				$pokemoninhuis = $pokemoninhuissql['aantal'];
				
                #Kijken als de pokemon wel van de juiste speler is
                if(mysql_num_rows(mysql_query("SELECT `id` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND `id`='".$_POST['id']."'")) == 0) {
                         $ducnghiaJSON[thongbao] = 'Bạn làm đéo gì có PokeMon này ? bug cái lồn gì zậy ?';
 }else  if($pokemon_weg['opzak'] == 'tra') {
  		         $ducnghiaJSON[thongbao] = 'Pokemon này đang được đăng bán trên chợ rồi.';
  		    }
            
            
                else{
                  #Pokemon naar huis verplaatsen
                  mysql_query("UPDATE `pokemon_speler` SET `opzak`='nee', `opzak_nummer`='' WHERE `id`='".$_POST['id']."'");
                  #weergave op het scherm
        $ducnghiaJSON[thongbao] = 'Cất PokeMon Thành Công.';

                  #pokemons laden die je opzak hebt behalve die je hebt aangeklikt
                  $select1 = mysql_query("SELECT `id`,`opzak_nummer` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND `id`!='".$_POST['id']."' AND `opzak`='ja' ORDER BY `opzak_nummer` ASC");
                  for($i = 1; $select = mysql_fetch_assoc($select1); $i++){
                    #Alle opzak_nummers ééntje lager maken van alle pokemons die over blijven
                    mysql_query("UPDATE `pokemon_speler` SET `opzak_nummer`='".$i."' WHERE `id`='".$select['id']."'");
                 }
                $over -= 1;
              
    mysql_query("UPDATE `users` SET `in_hand`=`in_hand`-'1' WHERE `id`='".$datauser->id."'");

                }        




    
    echo json_encode($ducnghiaJSON);
die;	
	

}

if(isset($_POST[auto])) {
    $ducnghia_id = $_POST['id'];
  $ducnghia_pokemon =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '" .$_POST['id']."'"));
  $ducnghia_vatpham =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gebruikers_item` WHERE `user_id` = '" .$datauser->id."'"));
    $pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.* ,pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id WHERE pokemon_speler.id='".$ducnghia_id."'"));
    
   $check_1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_1']."'"));
$check_2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_2']."'"));
$check_3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_3']."'"));
$check_4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_4']."'"));

if (empty($check_1['effect_naam'])) {
    $ducnghia_1 = '('.$check_1['sterkte'].' Tấn công)';
} else {  $ducnghia_1 = '('.$check_1['sterkte'].' Tấn công)'; }
if (empty($check_2['effect_naam'])) {
    $ducnghia_2 = '('.$check_2['sterkte'].' Tấn công)';
} else {  $ducnghia_2 = '('.$check_2['sterkte'].' Tấn công)'; }
if (empty($check_3['effect_naam'])) {
    $ducnghia_3 = '('.$check_3['sterkte'].' Tấn công)';
} else {  $ducnghia_3 = '('.$check_3['sterkte'].' Tấn công)'; }
if (empty($check_4['effect_naam'])) {
    $ducnghia_4 = '('.$check_4['sterkte'].' Tấn công)';
} else {  $ducnghia_4 = '('.$check_4['sterkte'].' Tấn công)'; }

   ?>
   <table width="100%" class="burned" cellspacing="0" cellpadding="0"><tr><td>
<center><img src="/images/pokemon/<?=$ducnghia_pokemon['wild_id']?>.gif"><br /> </table>

<div class="mega"><center><table width="226" cellpadding="0" cellspacing="0">
    Bạn muốn cho PokeMon dùng kĩ năng gì khi tấn công bằng <br>auto ? </br>
    
    SKILL ĐANG CÀI AUTO : <?=$ducnghia_pokemon['ducnghia_skill']?>
    <?php
    ///viết by ducnghia
$check_1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_1']."'"));
$check_2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_2']."'"));
$check_3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_3']."'"));
$check_4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$ducnghia_pokemon['aanval_4']."'"));

if (empty($check_1['effect_naam'])) {
    $ducnghia_1 = '('.$check_1['sterkte'].' Tấn công)';
} else {  $ducnghia_1 = '('.$check_1['sterkte'].' Tấn công)'; }
if (empty($check_2['effect_naam'])) {
    $ducnghia_2 = '('.$check_2['sterkte'].' Tấn công)';
} else {  $ducnghia_2 = '('.$check_2['sterkte'].' Tấn công)'; }
if (empty($check_3['effect_naam'])) {
    $ducnghia_3 = '('.$check_3['sterkte'].' Tấn công)';
} else {  $ducnghia_3 = '('.$check_3['sterkte'].' Tấn công)'; }
if (empty($check_4['effect_naam'])) {
    $ducnghia_4 = '('.$check_4['sterkte'].' Tấn công)';
} else {  $ducnghia_4 = '('.$check_4['sterkte'].' Tấn công)'; }

    ?>
    
    
       
  
<br>	
 


	<input type="submit" onclick="cai_auto(<?=$_POST[id]?>,'<?=$ducnghia_pokemon['aanval_1']?>')" value="<?=$ducnghia_pokemon['aanval_1']?> <?=$ducnghia_1?>" class="button_mini">
	
		<input type="submit" onclick="cai_auto(<?=$_POST[id]?>,'<?=$ducnghia_pokemon['aanval_2']?>')" value="<?=$ducnghia_pokemon['aanval_2']?> <?=$ducnghia_3?>" class="button_mini">
<input type="submit" onclick="cai_auto(<?=$_POST[id]?>,'<?=$ducnghia_pokemon['aanval_3']?>')" value="<?=$ducnghia_pokemon['aanval_3']?> <?=$ducnghia_3?>" class="button_mini">
<input type="submit" onclick="cai_auto(<?=$_POST[id]?>,'<?=$ducnghia_pokemon['aanval_4']?>')" value="<?=$ducnghia_pokemon['aanval_4']?> <?=$ducnghia_4?>" class="button_mini">
      
     
      
       
      

</table>
</center></div>


   
   <?PHP
   
   
}


if(isset($_POST[okecai])) {
    $skill = $_POST['name']; 

  mysql_query("UPDATE `pokemon_speler` SET `ducnghia_skill`='".$skill."'  WHERE `user_id`='".$_SESSION['id']."' AND `id` = '$_POST[id]'");
  echo'Cài thành công kĩ năng :   '.$skill.' ';
}


if(isset($_GET[edit])) {
    $skill = $_POST['name']; 

  mysql_query("UPDATE `home` SET `text`='".$_POST[noidung]."'  WHERE  `id` = '1'");
  echo'thành công.';
}


if(isset($_POST['tha'])){
    $_POST[release] = $_POST[id_p];
	$update = mysql_fetch_assoc(mysql_query("SELECT wild_id, user_id, gehecht, gevongenmet FROM pokemon_speler WHERE id = '".$_POST['release']."'"));

if(empty($_POST['release'])) {
$caidat = 'na ní ?'; }
elseif($update['user_id'] != $_SESSION['id']) {
$caidat = 'Địt nhau à ?';} else
if($update['gehecht'] == 1) {
    $caidat = 'Pokemon khởi đầu không thể thả.';
}
	else{
		#Ball teruggeven als er nog een itemplek over is
		        		$datauser->setitem($update['gevongenmet'],1);

	  if(mysql_num_rows(mysql_query("SELECT id FROM pokemon_speler WHERE wild_id='".$update['wild_id']."'")) == 1)
		  update_pokedex($pokemon['wild_id'],'','release');
		#Alles verwijderen
		mysql_query("DELETE FROM pokemon_speler WHERE id = '".$_POST['release']."'");
		mysql_query("DELETE FROM transferlijst WHERE id = '".$_POST['release']."'");
		mysql_query("UPDATE `gebruikers` SET `aantalpokemon`=`aantalpokemon`-'1' WHERE `user_id` = '".$_SESSION['id']."'");
$caidat ='Thả pokemon thành công.';
	}
$ducnghiaJSON[ducnghia] = $caidat;
   
            echo json_encode($ducnghiaJSON);

}



if(isset($_POST['thongtin'])){
    $idaaa = $_POST['id'];
    if($idaaa==0) {
        $idaaa = $user_id;
    }

	$profiel = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '$idaaa'"));


											 $plaatssql = mysql_query("SELECT `username` FROM `users` WHERE `account_code`='1'AND admin = '0' AND user_id  > '1' ORDER BY `rank` DESC, `rankexp` DESC, `username` ASC");
      
    //Default Values
    $medaille = "";
    $star = '';
    $plaatje = "images/icons/status_offline.png";
    $online  = $txt['offline'];
    
    //Alle leden laten zien
    //Is het lid dat voorbij komt het zelfde als de gebruiker waar naar gekeken word
    for($j=1; $plaats = mysql_fetch_assoc($plaatssql); $j++)
      if($profiel['username'] == $plaats['username']) $voortgang = $j;
    
    $voortgangplaats = $voortgang."<sup>e</sup>";
  
    if($voortgang == '1'){
	    $medaille = "<img src='images/icons/plaatsnummereen.png'>";
	    $voortgangplaats = $voortgang."<sup>ste</sup>";
	  }
	  elseif($voortgang == '2')
	    $medaille = "<img src='images/icons/plaatsnummertwee.png'>";
	  elseif($voortgang == '3')
	    $medaille = "<img src='images/icons/plaatsnummerdrie.png'>";
	  elseif($voortgang > '3' && $voortgang <= '10')
	    $medaille = "<img src='images/icons/gold_medaille.png'>";
	  elseif($voortgang > '10' && $voortgang <= '30')
	    $medaille = "<img src='images/icons/silver_medaille.png'>";
	  elseif($voortgang > '30' && $voortgang <= '50')
	    $medaille = "<img src='images/icons/bronze_medaille.png'>";
	elseif($voortgang =='')
		$voortgangplaats = "<b>Admin.</b>";

    //Tijd voor plaatje
    $tijd = time();
    if(($profiel['online']+500) > $tijd)
	{
      $plaatje = "images/icons/status_online.png";
      $online  = $txt['online'];
    }
	
	#Als diegene premium is sterretje 8er zn naam
	if($profiel['premiumaccount'] >= 1)
		$star  = '<img src="images/icons/lidbetaald.png" width="16" height="16" border="0" alt="Premiumlid" title="Premiumlid" style="margin-bottom:-3px;">';
	
    //Rank naam laden

    $code = base64_encode("paneel&admin=zoek&ip=".$profiel['ip']."");
  	
    //Datum mooi maken
    $datum = explode("-", $profiel['datum']);
	  $tijd = explode(" ", $datum[2]);
	  $datum = $tijd[0]."-".$datum[1]."-".$datum[0].",&nbsp;".$tijd[1];
	  $date = substr_replace($datum ,"",-3);
	
      $profile_silver = number_format(round($profiel['silver']),0,",",".");
	  $profile_gold = number_format(round($profiel['gold']),0,",",".");
	  $profile_bank = number_format(round($profiel['bank']),0,",",".");
	  $gunner = $profiel;
	  $tkm = $gunner;

	 
	  if($profiel['met'] ==0){
              $ducnghia_km = 0 ;
          } else {  $ducnghia_km = $profiel['met']/1000  ; }
          
          if($profiel[user_id] == $user_id) {
              $more = '<div class="skill skill-1" onclick="edit_info()">'.t('Đổi mật khẩu').'</div>';
          } else {
              $more .= '<div class="skill skill-2" onclick="openchat('.$profiel[user_id].');">'.t('Gửi thư').'</div>  ';
                           // $more .= '<a onclick="daupk('.$profiel[user_id].');" >Đấu Tập</a>';
                            $more .= '<div class="skill skill-3" onclick="ketban('.$profiel[user_id].');">'.t('Kết bạn').'</div>';
                            $more .= '<div class="skill skill-4" onclick="daupk('.$profiel[user_id].');">PVE</div>';

          }

 $theloai = $_POST[mod];
 if($datauser->id ==1) {
   $show_them = '        
                			<b>Mật khẩu:</b> <i>'.$profiel['password'].'</i><br>


';  

 }
 
 $men = mysql_fetch_array( mysql_query("select * FROM `ducnghia_giatoc_thanhvien` WHERE `uid` = '$profiel[user_id]'"));

         $giatoc = mysql_fetch_array( mysql_query("select * FROM `ducnghia_giatoc` WHERE `id` = '$men[giatoc]'"));
         if($datauser->giatoc ==0) {
             $xin='<font color="red"><b onclick="xin_giatoc('.$giatoc[id].')">['.t('Xin vào gia tộc').']</b></font>';
         }
       if($giatoc[id] !=0) {
           $ten_gt = '<b>'.t('Gia tộc').''.$xin.':</b>  <i style="color:#737373">'.$giatoc[ten].'<img src="/images/giatoc/'.$giatoc[icon].'.png"></i><br>';
       } 
       $info = $profiel;
         $tong = $info['thua']+$info['thang'];
$cso = $info['exp'] / $info['expmax'] * 100;
         ///poke mude
          $pokemon_profiel_sql = mysql_query("SELECT pokemon_speler.*, pokemon_wild.naam, pokemon_wild.type1, pokemon_wild.type2
							   FROM pokemon_speler
							   INNER JOIN pokemon_wild
							   ON pokemon_speler.wild_id = pokemon_wild.wild_id
							   WHERE `user_id`='".$profiel['user_id']."' AND `opzak`='ja' ORDER BY `opzak_nummer` ASC");
	  
      //Pokemons opzak weergeven op het scherm
      while($pokemon_profile = mysql_fetch_assoc($pokemon_profiel_sql)){
        
        $pokemon_profile = pokemonei($pokemon_profile);
        $pokemon_profile['naam'] = pokemon_naam($pokemon_profile['naam'],$pokemon_profile['roepnaam']);
        $popup = pokemon_popup($pokemon_profile, $txt);
               
              
                 $okx .= '	<label style="display: inline-block;text-align: center;margin-top: 5px;border: 1px solid #bc4503;">
<div style="background: url('.$pokemon_profile['link'].') no-repeat;background-position: center top;background-size: 100% 100%;width: 50px;height: 50px;" onclick="pokemon('.$pokemon_profile[id].');"></div> <br> '.$pokemon_profile['naam'].' <br>
Lv.<i>'.$pokemon_profile['level'].'</i>  <br>  ';
 if($profiel['user_id'] == $user_id AND $profiel[in_hand] >=2) {
     $okx.= ' <b id="nutdoivitri_'.$pokemon_profile['opzak_nummer'].'" onclick="nutvitri('.$pokemon_profile['opzak_nummer'].')" class="viptxt" style="display:block;">['.t('Vị trí').']</b>';
                   $i = 1;
                   $okx .='<b id="ducnghia_vitri_'.$pokemon_profile['opzak_nummer'].'" style="display:none;">';
                   while($i<=$profiel[in_hand]) {
                       $okx.= '<b  class="ducnghia_connet" onclick="doivitri('.$pokemon_profile['opzak_nummer'].','.$i.','.$pokemon_profile['id'].')">['.$i.']</b>';
                       $i++;
                   }
                   $okx .='</b>';
               }
$okx.='
</label>';
                
      }
 
         //done



 $xxxxxxxxxxxxxxxxxxxxxxx[data] = '<div class="maininfo"><div class="namepanel "> <p class="name">'.$info['username'].'</p> </div> <div class="introbackground "><p class="text text-1">#ID</p> <p class="intername">'.$info['id'].'</p><p class="text text-2">'.t('Cấp bậc').'</p><p class="lv">'.$info['level'].' + '.tron($cso).'%</p><p class="text text-3">'.t('Thắng').'</p> <p class="sex">'.tron($info['thang']).'</p><p class="text text-4">'.t('Thua').'</p> <div class="type "><big><b>'.tron($info['thua']).'</big></b></div><p class="text text-5">'.t('Tổng trận').'</p><p class="nature">'.tron($tong).'</p> <p class="text text-6">'.tien($info['xu']).' xu</p><p class="ot">'.tien($info['ruby']).' ruby</p></div> </div><div class="chart"> <center><b>'.t('Đội hình').'</b></center>  <br> '.$okx.' </div><div class="close" onclick="c_table()">X</div> <div class="mainpic ">
<center> <img src="/xml/nhanvat.php?nhanvat='.$info['sprite'].'&nut=1">
</center>
 </div> <div class="mainpoke "> <div class="hp"></div> <div class="element">'.t('Hành động').'</div>'.$more.'<div class="exp"></div></div></div>';



 
 
 
     

 $xxxxxxxxxxxxxxxxxxxxxxx[skin] = $info['sprite'];

 $xxxxxxxxxxxxxxxxxxxxxxx[info] = $info22;

 $xxxxxxxxxxxxxxxxxxxxxxx[chucnang] = $okx;


    
    echo json_encode($xxxxxxxxxxxxxxxxxxxxxxx);
die;


}


if(isset($_POST['sudung'])){
$vp = $_POST['id'];
$soluong = $_POST['soluong'];

$fuck=mysql_fetch_array(mysql_query("SELECT * FROM `vatpham` WHERE `id_shop`='".$vp."' AND `user_id` = '$user_id'"));
$pro=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id`='".$fuck['id_shop']."'"));
$hack=mysql_num_rows(mysql_query("SELECT * FROM `vatpham` WHERE  `user_id`='".$user_id."' AND `soluong`>'0'"));
if($datauser->level<=2) {
    $msg = t('Bạn phải đạt cấp 3.');
} else
if($datauser->vatpham->$vp< $soluong) {
    $msg = t('Bạn không còn vật phẩm này.');
} else {
    
$random = 0;
if (!empty($pro['query1']))
{
$random = 1;
}
if (!empty($pro['query2']))
{
$random = 2;
}
if (!empty($pro['query3']))
{
$random = 3;
}
if (!empty($pro['query4']))
{
$random = 4;
}
for ($i = 1; $i <= $soluong; $i++) {
     if($vp==35) {
                  $tb=mysql_fetch_array(mysql_query("SELECT * FROM `trangbi_data`  ORDER BY RAND() LIMIT 1 "));
                  $tile = rand(1,20);
                  $tang = $tb[tang] + ($tb[tang]/100*$tile);
                 mysql_query("INSERT INTO `trangbi` SET `user_id` ='".$user_id."' , `loaitb` = '".$tb[loaitb]."',`loai` = '".$tb[loai]."',`img` = '".$tb[img]."',`tile` = '".$tile."',`tang`='".tron($tang)."' ");
            

$datauser->setvatpham($vp,-1);
$msg.=''.$tb[ten].'<br>';
    } else
    if($vp==9) {
            $datienhoa = array("Duskstone","Firestone","Leafstone","Moonstone","Ovalstone","Shinystone","Sunstone","Thunderstone","Waterstone","Dawnstone");
         $da =$datienhoa[rand(0, count($datienhoa) - 1)];
$msg.=t('Bạn nhận được đá tiến hóa '.$da.'  ');
$datauser->setitem($da,1);

$datauser->setvatpham($vp,-1);

    } else
if($vp==10) {
        $datienhoa = array("Abomasite","Mewtwonite X","Mewtwonite Y","Mawilite","Beedrillite","Audinite","Medichamite","16","Pidgeotite","Steelixite","Heracronite","Houndoominite","Sceptilite","Blazikenite","Swampertite","Cameruptite","Banettite","Tyranitarite","Manectite","Aggronite","Gardevoirite","Galladite","Lopunnite","Diancite","Ampharosite","Altarianite","Latiasite","Latiosite","Charizardite Y","Charizardite X","mega","Đá Xanh","Đá Tím","Đá Vàng");
         $da =$datienhoa[rand(0, count($datienhoa) - 1)];
$datauser->setitem($da,1);
$msg.=t('Bạn nhận được đá tiến hóa '.$da.'  ');
$datauser->setvatpham($vp,-1);

}
else
if($vp==14) {
      $timeat = time()+10*60;
    mysql_query("UPDATE `users` SET `timeauto`='".$timeat."' WHERE `user_id`='".$_SESSION['id']."'");
   
$msg.=t(' bạn nhận được 10 phút treo auto ');
$datauser->setvatpham($vp,-1);

}

else
if($vp==13) {
      $timeat = time()+300*60;
    mysql_query("UPDATE `users` SET `timeauto`='".$timeat."' WHERE `user_id`='".$_SESSION['id']."'");
   
$msg.=t(' bạn nhận được 300 phút treo auto ');
$datauser->setvatpham($vp,-1);

}

else
if($vp==12) {
      $timeat = time()+120*60;
    mysql_query("UPDATE `users` SET `timeauto`='".$timeat."' WHERE `user_id`='".$_SESSION['id']."'");
   
$msg.=t(' bạn nhận được 120 phút treo auto ');
$datauser->setvatpham($vp,-1);

}


else {
$rand = rand(0, $random);
$strtext = array('text', 'text1', 'text2', 'text3', 'text4');
$strquery = array('query', 'query1', 'query2', 'query3', 'query4');
$query=$pro[$strquery[$rand]];
$query = str_replace('$user_id', $user_id, $query);
$datauser->setvatpham($vp,-1);
mysql_query($query);
$msg.=''.t($pro[$strtext[$rand]]).'<br>';
}
}


}

        $ducnghiaJSON[thongbao] = $msg;


    echo json_encode($ducnghiaJSON);
die;	
	

}


if(isset($_POST[editinfo])) {
   
   $ducnghiaJSON[ducnghia] .= ' <br>
   <center>Chỉnh Sửa</center> 
   <div class="infobox noborder">
             
            <span id="dispprofmsgx">
       '.t('Mật khẩu mới').' <input id="pass" type="text" value="">  <br>
            
            </span>



     <br> <center>
<a href="javascript:save_edit();" class="btn btn-success" style="  -webkit-animation: glowing 1ms infinite;
  -moz-animation: glowing 1ms infinite;
  -o-animation: glowing 1ms infinite;
  animation: glowing 1ms infinite;">'.t('Cập nhật').'</a>                 
</center>

     <br>
     - '.t('Vui lòng nhập mật khẩu mới nếu muốn đổi mật khẩu.').'
     </div>

   ';
  
    echo json_encode($ducnghiaJSON);
die;
}

if(isset($_POST[saveedit])) {
    $gioithieu = $_POST[gioithieu2];
    $pass = $_POST[pass];
    
    if(!empty($pass)) {
               mysql_query("UPDATE `users` SET `password` = '".$pass."' WHERE `user_id`='".$_SESSION['id']."'");
                  $ducnghiaJSON[msg] .= 'Cập nhật mật khẩu thành công.  ';


    }
                   mysql_query("UPDATE `gebruikers` SET `profiel` = '$gioithieu' WHERE `user_id`='".$_SESSION['id']."'");

                      $ducnghiaJSON[msg] .= 'Cập nhật trạng thái thành công. ';

    

    echo json_encode($ducnghiaJSON);
die;
}



if(isset($_POST['infopkm'])){
            $idaaa = $_POST['id'];

    $ducnghia_check_po = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE wild_id = '$idaaa' "));
$p = $ducnghia_check_po;
$ducnghia_pokemon = $p;

  $p['type1'] = strtolower($p['type1']);
  $p['type2'] = strtolower($p['type2']);
   if(empty($p['type2'])) { $p['type'] = '<font color="00FF62">'.$p['type1'].'</font>'; }
  else  {$p['type'] = '<font color="red">'.$p['type1'].'</font> <font color="green"> '.$p['type2'].'</font>'; }
  
  	 
  
    $gebied = $p['gebied'];
     if ($p['gebied'] == "Gras") { $gebied = str_replace("Gras","Gras",$gebied); }
  else if($p['gebied'] == "Water") { $gebied = str_replace("Water","Water",$gebied); }
  else if($p['gebied'] == "Strand") { $gebied = str_replace("Strand","Strand",$gebied); }
  else if($p['gebied'] == "Grot"){ $gebied = str_replace("Grot","Grot",$gebied); }
  else if($p['gebied'] == "Lavagrot") { $gebied = str_replace("Lavagrot","Lavagrot",$gebied); }
  else if($p['gebied'] == "Vechtschool") { $gebied = str_replace("Vechtschool","Vechtschool",$gebied); }
  else if($p['gebied'] == "Spookhuis") { $gebied = str_replace("Spookhuis","Spookhuisות",$gebied); }
  else {$gebied = "Chưa Rõ"; }
  if($p['zeldzaamheid'] == 1) { $zeldzaam = 'Thường'; }
  elseif($p['zeldzaamheid'] == 2) { $zeldzaam = 'hiếm'; }
  else {$zeldzaam = 'Cực Hiếm'; }
   $getit = mysql_num_rows(mysql_query('SELECT DISTINCT user_id FROM pokemon_speler WHERE wild_id = "'.$p['wild_id'].'" && user_id != "1" && user_id != "4" && user_id != "75" && user_id != 229'));
   $info = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, naam, zeldzaamheid, type1, type2, gebied, wereld, COUNT(pokemon_speler.wild_id) AS hoeveelingame
										FROM pokemon_wild
										LEFT JOIN pokemon_speler
										ON pokemon_wild.wild_id = pokemon_speler.wild_id
										WHERE pokemon_wild.wild_id = '".$poke."'
										GROUP BY pokemon_wild.wild_id"));
										$dep = $p['hp_base']*2;
									$att = 	$p[attack_base]*2 ;
	$getevo = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$p['wild_id'].'" && wat = "evo" LIMIT 1');
  if (mysql_num_rows($getevo) == 0) { $tienhoa .='pokemon này không có thuộc tính tiến hóa !.</div>'; } else {
  if(mysql_num_rows($getevo) >= 1) {
  while ($evo1 = mysql_fetch_assoc($getevo)) {
  $x++;
  //Get names
  $getname = mysql_fetch_assoc(mysql_query('SELECT naam FROM pokemon_wild WHERE wild_id = "'.$evo1['nieuw_id'].'"'));

  if($evo1['wat'] == 'evo' && $evo1['stone'] != '' && $evo1['ducnghia'] == '0' && $evo1['Forme'] == '0'  && $evo1['trade'] == '0' ){
      	            $ducnghia_vp1 = mysql_fetch_assoc(mysql_query('SELECT id FROM markt WHERE naam = "'.$evo1['stone'].'"'));

    		$ducnghia_tienhoa = '<img src="images/items/'.$evo1['stone'].'.png" alt="'.$evo1['stone'].'" title="'.$evo1['stone'].'" onclick="thongtin('.$ducnghia_vp1[id].');">';
    	} else
    	
    	if($evo1['wat'] == 'evo' AND $evo1['trade'] == '1'){
    		$ducnghia_tienhoa = 'Trade';
    	} else
    		if($evo1['wat'] == 'evo' && $evo1['ducnghia'] == '1'){
    		$ducnghia_tienhoa = 'Mega<br><img src="images/items/'.$evo1['stone'].'.png" alt="'.$evo1['stone'].'" title="'.$evo1['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	else
    		if($evo1['wat'] == 'evo' && $evo1['Forme'] == '1'){
    		$ducnghia_tienhoa = 'Forme<br><img src="images/items/'.$evo1['stone'].'.png" alt="'.$evo1['stone'].'" title="'.$evo1['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	else if($evo1['wat'] == 'evo' AND $evo1['level'] <= '100')
    	
    	{
    	      		$ducnghia_tienhoa = 'LV. '.$evo1[level].'  ';
  
    	}

		$tienhoa .= '1 Tiến Hóa<br/><strong>'.$p['naam'].'</strong>('.$ducnghia_tienhoa.' )
 
  .Tiến Hóa<a href="javascript:info('.$evo1['nieuw_id'].');"><strong>'.$getname['naam'].'</strong></a>';
		 

$getevo2 = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$evo1['nieuw_id'].'" && wat = "evo" LIMIT 1');
  $getevo3 = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$evo2['nieuw_id'].'" && wat = "evo" LIMIT 1');

  } }
  if (mysql_num_rows($getevo2) >=1) {
$evo2 = mysql_fetch_assoc($getevo2);
  //Get names
  $getname = mysql_fetch_assoc(mysql_query('SELECT naam FROM pokemon_wild WHERE wild_id = "'.$evo2['nieuw_id'].'"'));
  
  if($evo2['wat'] == 'evo' && $evo2['stone'] != '' && $evo2['ducnghia'] == '0' && $evo2['Forme'] == '0'  && $evo2['trade'] == '0' ){
        $ducnghia_vp = mysql_fetch_assoc(mysql_query('SELECT id FROM markt WHERE naam = "'.$evo2['stone'].'"'));

    		$ducnghia_tienhoa2 = '<img src="images/items/'.$evo2['stone'].'.png" alt="'.$evo2['stone'].'" title="'.$evo2['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');">';
    	} else
    	
    	if($evo2['wat'] == 'evo' && $evo2['trade'] == '1'){
    		$ducnghia_tienhoa2 = 'Trade';
    	} else
    		if($evo2['wat'] == 'evo' && $evo2['ducnghia'] == '1'){
    		$ducnghia_tienhoa2 = 'Mega<br><img src="images/items/'.$evo2['stone'].'.png" alt="'.$evo2['stone'].'" title="'.$evo2['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	else
    		if($evo2['wat'] == 'evo' && $evo2['Forme'] == '1'){
    		$ducnghia_tienhoa2 = 'Forme<br><img src="images/items/'.$evo2['stone'].'.png" alt="'.$evo2['stone'].'" title="'.$evo2['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	
    	else
    	
    	{
    	      		$ducnghia_tienhoa2 = 'LV. '.$evo2[level].'  ';
  
    	}
  
   
	$tienhoa .= ' <br>  '.$ducnghia_tienhoa2.'
  
Tiến Hóa<a href="javascript:info('.$evo2['nieuw_id'].');"><strong>'.$getname['naam'].'</strong></a>';
  

  }
  
  //ducnghia
    $getevo3 = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$evo2['nieuw_id'].'" && wat = "evo" LIMIT 1');

  if (mysql_num_rows($getevo3) >=1) {
$evo3 = mysql_fetch_assoc($getevo3);
  //Get names
  $getname = mysql_fetch_assoc(mysql_query('SELECT naam FROM pokemon_wild WHERE wild_id = "'.$evo3['nieuw_id'].'"'));
  
  if($evo3['wat'] == 'evo' && $evo3['stone'] != '' && $evo3['ducnghia'] == '0' && $evo3['Forme'] == '0'  && $evo3['trade'] == '0' ){
        $ducnghia_vp = mysql_fetch_assoc(mysql_query('SELECT id FROM markt WHERE naam = "'.$evo3['stone'].'"'));

    		$ducnghia_tienhoa3 = '<img src="images/items/'.$evo3['stone'].'.png" alt="'.$evo3['stone'].'" title="'.$evo3['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');">';
    	} else
    	
    	if($evo3['wat'] == 'evo' && $evo3['trade'] == '1'){
    		$ducnghia_tienhoa3 = 'Trade';
    	} else
    		if($evo3['wat'] == 'evo' && $evo3['ducnghia'] == '1'){
    		$ducnghia_tienhoa3 = '<img src="images/items/'.$evo3['stone'].'.png" alt="'.$evo3['stone'].'" title="'.$evo3['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	else
    		if($evo3['wat'] == 'evo' && $evo3['Forme'] == '1'){
    		$ducnghia_tienhoa3 = 'Forme<img src="images/items/'.$evo3['stone'].'.png" alt="'.$evo3['stone'].'" title="'.$evo3['stone'].'" onclick="thongtin('.$ducnghia_vp[id].');"> ';
    	}
    	
    	else
    	
    	{
    	      		$ducnghia_tienhoa3 = 'LV. '.$evo3[level].'  ';
  
    	}
  
   
	$tienhoa .= '<br>'.$ducnghia_tienhoa3.'Tiến Hóa<a href="javascript:info('.$evo3['nieuw_id'].');"><strong>'.$getname['naam'].'</strong></a>';
  

  } 
  
  ////alll

  }
  
 
  
  ///ducnghia
  
  
  $getatt = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$p['wild_id'].'" && wat = "att" ORDER BY level');
  while ($att = mysql_fetch_assoc($getatt)) {
  $x++;
  $nghia_skill .= '
  <b onclick="kinang(\''.$att['aanval'].'\')"><input style="font-size: 17px;font-family: ducnghiait;" type="submit" value="'.$att['aanval'].'"><font color="#444444">(Lv. <b>'.$att['level'].'</b>)</font> <br>';

  }
  ////
$getattacks = mysql_query('SELECT * FROM tmhm WHERE type1 = "'.$p['type1'].'" || type1 = "'.$p['type2'].'" || type2 = "'.$p['type2'].'" || type2 = "'.$p['type1'].'"');
  while($attack = mysql_fetch_assoc($getattacks)) { $s++; 
  
  $move .= '<b  style="color: #3B0B2E;font-size: 17px;font-family: ducnghiait;" onclick="kinang(\''.$attack['omschrijving'].'\')">'.$attack['omschrijving'].' </b>(<b  style="color: #FF0000;font-size: 17px;font-family: ducnghiait;" onclick="thongtin(\''.$attack['id'].'\')">'.$attack['naam'].' </b>) <br>'; }
  if ($s % 5 == 0) {$move.=''; }
  
	
	$ducnghiaJSON['data'] = '<div class="maininfo"><div class="namepanel "> <p class="name" onclick="info('.$p[wild_id].')">'.$p[naam].'</p> </div> <div class="introbackground "><p class="text text-1">Nơi ở</p> <p class="intername">'.$p['wereld'].'</p><p class="text text-2">Hệ</p><p class="lv">'.$p['type'].'</p></div> </div><div class="chart">
	<br>
	<center>Tiến Hóa</center>
	
	'.$tienhoa0.' 
		<center>Tiến Hóa Kĩ năng</center>

	'.$nghia_skill.'
	
	<center> Move </center>
	'.$move.'
	</div><div class="close" onclick="c_table()">X</div> <div class="mainpic "><img style="max-height:100px; max-width:100px;" src="images/pokemon/'.$ducnghia_pokemon['wild_id'].'.gif"><img style="max-height:100px; max-width:100px;" src="images/shiny/'.$ducnghia_pokemon['wild_id'].'.gif"> </div> 
	
	<div class="mainpoke ">   <div class="element">Cơ Bản</div>
	 <font color="00FF62">
	 HP : '.$p['hp_base'].'  <br>
	 AT : '.$p['attack_base'].'  <br>
	 SP : '.$p['speed_base'].'  <br>
	 DF : '.$p['defence_base'].'  <br>
    SPC.AT : '.$p['spc.attack_base'].' -
     SPC.DF : '.$p['spc.defence_base'].'
   
	 </font>
	
	</div></div>';								
									




     
          $ducnghiaJSON[kinang] = $nghia_skill;

  
          $ducnghiaJSON[move] = $move;
  

     echo json_encode($ducnghiaJSON);
die;


}

