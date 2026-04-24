<?PHP




if(isset($_POST[shop])) {
 $ducnghia_kho=mysql_query("SELECT * FROM `markt` WHERE  `beschikbaar` = '1'");
    while($ducnghia_do=mysql_fetch_array($ducnghia_kho)) {
        if($ducnghia_do[soort] == "balls")
$ducnghia_img = '/ducnghia/balls/'.$ducnghia_do['id'].'.png';
else 
$ducnghia_img = '/ducnghia/items/'.$ducnghia_do['id'].'.png';

$out .='
<div onclick="markt('.$ducnghia_do['id'].',\'item\')" class="showitem" style="border: 2px solid;"><img src="'.$ducnghia_img.'"><div class="count count-vp-1">'.tien($ducnghia_do[silver]).' X</div></div>		';

}
$ducnghia_kho=mysql_query("SELECT * FROM `shopvatpham` WHERE `hienthi`='0' ");
    while($ducnghia_do=mysql_fetch_array($ducnghia_kho)) {
      
$ducnghia_img = '/images/_/'.$ducnghia_do[id].'.png';

if($ducnghia_do[loaitien]=="ruby") {
    $tien = 'Rb';
} else {     $tien ='X';}


	
	$out .='
<div onclick="markt('.$ducnghia_do['id'].',\'vatpham\')" class="showitem" style="border: 2px solid;"><img src="'.$ducnghia_img.'"><div class="count count-vp-1">'.tien($ducnghia_do[gia]).' '.$tien.'</div></div>		';

}
echo '<div class="maininfo"><div class="namepanel "> <p class="name">Shop</p> </div> </div><div class="chart">'.$out.'</div><div class="close" onclick="c_table()">X</div> <div class="mainpic "></div> <div class="mainpoke "><b id="data_shop" style="color: rgb(255, 173, 0);background-color: rgb(47, 49, 48);">'.t('Bạn muốn mua gì nào ?').'</b> <div class="element"></div><b id="menu_shop"></b><div class="exp"></div></div></div>';


}


if(isset($_POST['markt'])){
        $markt=mysql_fetch_array(mysql_query("SELECT * FROM `markt` WHERE `id`='{$_POST[id]}' AND `beschikbaar` = '1' "));
if($markt[soort] == "balls") {
$ducnghia_img = '/ducnghia/balls/'.$markt['id'].'.png'; }
else  {
$ducnghia_img = '/ducnghia/items/'.$markt['id'].'.png'; }
    
    $msg = ''.t($markt[omschrijving_en]).'';
    $menu= '<div class="skill skill-1" onclick="markt('.$markt['id'].',\'muamarkt\',1)">'.t('Mua').' 1</div> <div class="skill skill-2" onclick="markt('.$markt['id'].',\'muamarkt\',5)">'.t('Mua').' 5</div>  <div class="skill skill-3" onclick="markt('.$markt['id'].',\'muamarkt\',25)">'.t('Mua').' 25</div>';
       

   
$ducnghiaJSON[ducnghia] = $msg;
$ducnghiaJSON[menu] = $menu;

 echo json_encode($ducnghiaJSON);
die;
} 


if(isset($_POST['muamarkt'])){
        $markt=mysql_fetch_array(mysql_query("SELECT * FROM `markt` WHERE `id`='{$_POST[id]}' AND `beschikbaar` = '1' "));
        $soluong = $_POST[soluong_mua];
        if($soluong <=0) {
             $msg = '????';
        } else
        if($markt[beschikbaar] !=1) {

   $msg = 'Mày là trẻ trâu à ?';
        }
        else
        if($user->xu < $markt[silver]*$soluong) {
            $msg = ''.t('Bạn chưa đủ tiền để mua.').'';
        } else {
            $tien = $markt[silver]*$soluong;
                        $msg = ''.t('Mua thành công.').' ';
      							$user->setitem($markt['naam'], $soluong);
  
        
           mysql_query("UPDATE `users` SET 
                      `xu` = `xu` - '$tien'
                      
                      WHERE `user_id`='".$_SESSION['id']."'");

        }
$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 


if(isset($_POST['vatpham'])){
        $markt=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `hienthi`='0' AND `id`  = '{$_POST[id]}' "));
if($markt[loaitien]=="gold") {
    $tien = $markt[gia].' Vàng';
} else {     $tien = $markt[gia].' Bạc';}
    
 
  $msg = ''.t($markt[thongtin]).'';
    $menu= '<div class="skill skill-1" onclick="markt('.$markt['id'].',\'muavatpham\',1)">'.t('Mua').' 1</div> <div class="skill skill-2" onclick="markt('.$markt['id'].',\'muavatpham\',5)">'.t('Mua').' 5</div>  <div class="skill skill-3" onclick="markt('.$markt['id'].',\'muavatpham\',25)">'.t('Mua').' 25</div>';

   
$ducnghiaJSON[ducnghia] = $msg;
$ducnghiaJSON[menu] = $menu;

   
$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 

if(isset($_POST['muavatpham'])){
        $markt=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE  `id`  = '{$_POST[id]}' "));
        $soluong = $_POST[soluong_mua];
                    $tien = $markt[gia]*$soluong;
$id_a = $markt[id];
if($soluong <=0) {
             $msg = '????';
        } else
        if($markt[hienthi] !=0) {

   $msg = ''.t('Lỗi').'';
        }
        else
        if($user->$markt[loaitien] < $markt[gia]*$soluong) {
            $msg = ''.t('Bạn không đủ tiền.').'';
        } else {
                        $msg = ''.t('Mua thành công.').'';

							$user->setvatpham($id_a, $soluong);


           mysql_query("UPDATE `users` SET 
                      `$markt[loaitien]` = `$markt[loaitien]` - '$tien'
                      
                      WHERE `user_id`='".$_SESSION['id']."'");

        }
$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 

if(isset($_POST[nhanpkm])) {
    $check = mysql_num_rows($pokemon_sql);
  $id = $_POST[id];
  
          $j=mysql_fetch_array(mysql_query("SELECT * FROM `pokemon_speler` WHERE  `user_id`  = '{$user_id}' "));

  
  if($id == "1" OR $id =="4" OR $id =="7") {
      if($j[id]==0) {
          echo''.t('Nhận pokemon thành công.').'';
          pokemon($id,'5');
      } else {
          echo''.t('Bạn đã nhận pokemon rồi.').'';
      }
  } else {
      echo''.t('Lỗi.').'';
  }
    
}


