<?PHP
include_once('../templates/config.php');
include_once('../templates/ducnghia.php');
if(isset($_POST[dan])) {
    $carot = ducnghia_vp(41);
if($carot[soluong]<=0) {
    echo'Bạn chưa có carot.';
} else {
   echo 1; 
                   mysql_query("UPDATE `users` SET `pokemon`='tho' WHERE `user_id`='".$_SESSION['id']."'");
               vatpham(41,-1,$user_id);
                mysql_query("DELETE FROM `npcs`  WHERE  `id`='$_POST[id]' ");

}
}

if(isset($_POST[tho])) {
    if($datauser[pokemon] =="tho") {
                mysql_query("UPDATE `users` SET `pokemon`='' WHERE `user_id`='".$_SESSION['id']."'");
echo'Bánh trung thu.';
               vatpham(37,'1',$user_id);

    } else {
                    $carot = ducnghia_vp(41);
if($carot[soluong]<=0) {
    echo'Bạn chưa có carot.';
} else {
        $npc = '[{"line":1,"function":"DISPLAY MESSAGE","arguments":{"@cdata":"xxxx"}}]';

      $mapnl=mysql_fetch_array(mysql_query("SELECT * FROM `maps` WHERE `hieuung` = '1' AND `id` !='3'  ORDER BY RAND() LIMIT 1 "));
   	$map_npc=mysql_fetch_array(mysql_query("SELECT * FROM `npcs` WHERE `map` = '".$mapnl[id]."' AND `style` !=''  ORDER BY RAND() LIMIT 1 "));
            mysql_query("INSERT INTO `npcs` SET `map` = '".$map_npc[map]."',`x` = '".$map_npc[x]."',`y` = '".$map_npc[y]."',`name`='Thỏ ngọc',`movement` = 'Slow Random',`style`='tho.png',`client_script`='".$npc."',`type`='Action Button',`time`='".(time()+120)."',`text`='Ta lạc mất tiên cánh rồi :('");
   echo'Hãy tới mau '.$mapnl[ten].' để tìm thỏ ngọc ! Cậu chỉ có 2 phút thôi. ';         

}
}
}
if(isset($_POST[doiqua])) {
         $ducnghia_kho=mysql_query("SELECT * FROM `ducnghia_sukien` WHERE `id` = '".$_POST[id]."'");
$vpg=mysql_fetch_array($ducnghia_kho);

$diem = $datauser[sukien];
if($diem < $vpg[sukien]) {
    echo'Bạn chưa có đủ điểm sự kiện...';
} else {
    if($vpg[loai]=="item") {
           mysql_query("UPDATE `gebruikers_item` SET `".$vpg['ten']."`=`".$vpg['ten']."`+'1' WHERE `user_id`='".$_SESSION['id']."'");
 
    }
    
     if($vpg[loai]=="tm") {
         $tm = 'TM'.rand(10,90).'';
           mysql_query("UPDATE `gebruikers_tmhm` SET `$tm`=`$tm`+'1' WHERE `user_id`='".$_SESSION['id']."'");
 
    }
      if($vpg[loai]=="hm") {
         $tm = 'HM0'.rand(1,8).'';
           mysql_query("UPDATE `gebruikers_tmhm` SET `$tm`=`$tm`+'1' WHERE `user_id`='".$_SESSION['id']."'");
 
    }
    if($vpg[loai]=="vatpham") {
                       vatpham($vpg[idpkm],1,$user_id);

    }
    
    
        mysql_query("UPDATE `users` SET `sukien`=`sukien` - '".$vpg[sukien]."' WHERE `user_id`='{$user_id}'");
echo'Đổi quà thành công';
}
    
}


if(isset($_POST[xem])) {
        $ducnghia_kho=mysql_query("SELECT * FROM `ducnghia_sukien` WHERE `id` = '".$_POST[id]."'");
$ducnghia_do=mysql_fetch_array($ducnghia_kho);
    echo'<b style="float: right;" onclick="xmenu()"><font color="red">[Đóng]</font></b><b class="ducnghia_connet"><center>Bạn có muốn đổi vật phẩm này không ?</center>  
    <center class="ducnghia_connet"><font color="green">'.$ducnghia_do[ten].'<br>
    "'.$ducnghia_do[thongtin].'" <br>
    <a onclick="sk_doi('.$ducnghia_do[id].')" class="btn" style="  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;">Đổi quà ('.$ducnghia_do[sukien].'đ)  </a> </font>
    </center>
    </b>';
}


if(isset($_POST[shop])) {
    $ducnghia_kho=mysql_query("SELECT * FROM `ducnghia_sukien`");
    echo'<center><hr>Đổi Quà ( '.tron($datauser[sukien]).'đ)</center><hr>';
    while($ducnghia_do=mysql_fetch_array($ducnghia_kho)) {
      
$ducnghia_img = ''.$ducnghia_do[img].'';

	

echo'<div class="kengang"></div><img src="'.$ducnghia_img.'"> '.$ducnghia_do['ten'].'  <button onclick="xem_vp_sk('.$ducnghia_do['id'].')">Đổi '.tien($ducnghia_do[sukien]).'đ</button>  ';
}

}

if(isset($_POST[tang])) {
                $keo = ducnghia_vp(37);
$sl  = $_POST[keotang];
    $diemsk = $sl*5;
    $k = $keo[soluong];


if($sl <=0) {
    echo'Chưa nhập số lượng';
} else if($k < $sl) {
    echo'Vui lòng nhập số lượng hợp lệ';
} else {
   

               vatpham(37,'-'.$sl.'',$user_id);
    
    mysql_query("UPDATE `users` SET `sukien`=`sukien` + '$diemsk' WHERE `user_id`='{$user_id}'");
echo'Bạn nhận được '.$diemsk.' điểm sự kiện. ';
}


}

if(isset($_POST[tangkeo])) {
    echo'<center>
   <b class="ducnghia_connet"> <font color="red"> 1<img src="/images/_/37.png">  =  5đ  </font> <b onclick="cl()">[Đóng]</b>
    <br>
<input class="form-control"  placeholder="Số lượng" id="keotang" style="width: 60%;">
<a onclick="oketang(1)" class="viptxt">[Tặng Bánh]</a> 

  
  
</center>';



}



if(isset($_POST[doi])) {
            $but = ducnghia_vp(39);
            $sach = ducnghia_vp(40);
$sl  = $_POST[keo];

$butcan = $sl*10;
$sachcan = $sl*10;
if($sl <=0) {
    echo'Vui lòng nhập số lượng';
}else
       if( $but[soluong] < $butcan or $sach[soluong] < $sachcan ) {
           echo'bạn chưa đủ nguyên liệu nhé.';
       } else {
           
           vatpham(39,'-'.$butcan.'',$user_id);
           vatpham(40,'-'.$sachcan.'',$user_id);
           vatpham(38,$sl,$user_id);
echo'Đổi thành công '.$_POST[keo].' Lồng đèn.. ';

       }
       
    
    
    

    
    
}



if(isset($_POST[doinl])) {
    $loai = $_POST[loai];
    
    echo'<center>
   <b class="ducnghia_connet"> <font color="red"> 1<img src="/images/_/38.png"> =  10<img src="/images/_/39.png"> + 10<img src="/images/_/40.png"> </b> </font> <b onclick="cl()">[Đóng]</b>
    <br><div class="input-group">
<input class="form-control"  placeholder="Số lượng" id="keo" style="width: 60%;"><a onclick="doikeo(1)" class="btn" style="  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;">Đổi</a> 
   
  
  </div>
</center>';
 


}






if(isset($_POST[dotphao])) {
  $it2 = ducnghia_vp(38);
  if($it2[soluong]<=0) {
    echo'Thất bại.';                         
} else {
    vatpham(38,-1,$user_id);
    vatpham(41,1,$user_id);
    $vp = rand(1,100);
    $exp = rand(10000,500000);
    $bac = rand(10000,100000);
        $ruby = rand(1,5);

    if($vp==1) {
                mysql_query("UPDATE users SET`exp` = `exp` + '".$exp."',`xu` = `xu` + '".$bac."' WHERE user_id='$user_id'");
 echo'Bạn nhận được '.$bac.' xu.,*1 carot. ';
    }
    
     if($vp==2) {
                mysql_query("UPDATE users SET `exp` = `exp` + '".$exp."',`ruby` = `ruby` + '".$ruby."' WHERE user_id='$user_id'");
 echo'Bạn nhận được '.$ruby.' ruby.,*1 carot. ';
    }
    
      if($vp==3) {
 echo' Bạn nhận được Master Ball. ';
         mysql_query("UPDATE `gebruikers_item` SET `Master Ball`=`Master Ball`+'1' WHERE `user_id`='".$_SESSION['id']."'");
  tin(''.$datauser[username].' góp lồng đèn nhận được master ball.,*1 carot.');

    }
    
     if($vp==4) {
         $tm = 'TM'.rand(10,60).'';
 echo' Bạn nhận được '.$tm.'. ';
         mysql_query("UPDATE `gebruikers_tmhm` SET `$tm`=`$tm`+'1' WHERE `user_id`='".$_SESSION['id']."'");
  tin(''.$datauser[username].' góp lồng đèn nhận được '.$tm.'.,*1 carot.');

    }
    
    if($vp>=5 AND $vp<=19) {
         $datienhoa = array("Duskstone","Firestone","Leafstone","Moonstone","Ovalstone","Shinystone","Sunstone","Thunderstone","Waterstone","Dawnstone","Abomasite","Mewtwonite X","Mewtwonite Y","Mawilite","Beedrillite","Audinite","Medichamite","Pidgeotite","Steelixite","Heracronite","Houndoominite","Sceptilite","Blazikenite","Swampertite","Cameruptite","Banettite","Tyranitarite","Manectite","Aggronite","Gardevoirite","Galladite","Lopunnite","Diancite","Ampharosite","Altarianite","Latiasite","Latiosite","Charizardite Y","Charizardite X","mega","Đá Xanh","Đá Tím","Đá Vàng");
         $da =$datienhoa[rand(0, count($datienhoa) - 1)];
                  echo'Bạn nhận được đá '.$da.' ,*1 carot.';

           tin(''.$datauser[username].' góp lồng đèn nhận được đá '.$da.'.');
         mysql_query("UPDATE `gebruikers_item` SET `$da`=`$da`+'1' WHERE `user_id`='".$_SESSION['id']."'");

    }
    
     if($vp>=20) {
 echo'*1 carot.';
        

    }
    
    

}
}