<?PHP


if(isset($_POST[sua])){
    if($datauser->ruby<=1) {
        echo'Cần một ruby.';
    } else {
                  mysql_query("INSERT INTO `chatthegioi` SET name = '".$datauser->username."',`text` = '".$_POST[text]."'");
}
}

if(isset($_POST[giftcode])) {
    

echo 'Phiên bản thử nghiệm không có tính năng này.
Nâng cấp phiên bản vui lòng liên hệ <br>
<a href="//fb.com/ducnghiast">DUCNGHIA</a>';
}


if(isset($_POST[cha])) {
    $bandau = $_POST[bandau];
    $vitri = $_POST[vitri];
    $idpkm = $_POST[idpkm];
        $checkvt=mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `user_id` = '".$user_id."' AND `opzak_nummer` = '".$vitri."'"));
            mysql_query("UPDATE `pokemon_speler` SET `opzak_nummer`='".$vitri."' WHERE `user_id`='" .$user_id."' AND `id` = '".$idpkm."'");
            mysql_query("UPDATE `pokemon_speler` SET `opzak_nummer`='".$bandau."' WHERE `user_id`='" .$user_id."' AND `id` = '".$checkvt[id]."'");

}
if(isset($_POST[hoimau])) {
    $vp1=mysql_fetch_assoc(mysql_query("SELECT * FROM `vatpham` WHERE `user_id` = '".$user_id."' AND `id_shop` = '22'"));
    $vp2=mysql_fetch_assoc(mysql_query("SELECT * FROM `vatpham` WHERE `user_id` = '".$user_id."' AND `id_shop` = '23'"));
    $vp3=mysql_fetch_assoc(mysql_query("SELECT * FROM `vatpham` WHERE `user_id` = '".$user_id."' AND `id_shop` = '24'"));

    $id= $_POST[id];
    
    if($vp1[soluong]==0 AND $vp2[soluong]==0 AND $vp3[soluong]==0) {
        echo'Bạn chưa có vật phẩm hồi phục.';
    } else {
        if($id==0) {
            mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '1'");
        } else {
                       mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '$id'");
 
        }
        echo'Hồi Phục thành công.';
    }
    
}
if(isset($_POST[dichchuyen])) {
    echo'Phiên bản thử nghiệm không có tính năng này.
Nâng cấp phiên bản vui lòng liên hệ <br>
<a href="//fb.com/ducnghiast">DUCNGHIA</a>';
}