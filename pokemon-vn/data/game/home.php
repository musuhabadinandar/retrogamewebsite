<?PHP

if(isset($_POST[home])) {
    echo'<div class="nutplay" onclick="me_ackhac()">'.t('ĐỔI TÀI KHOẢN').'</div>';
    echo'<div class="nutplay" onclick="newac()">'.t('CHƠI MỚI').'</div>';
echo '<div class="nutplay" onclick="map_thongbao()">'.t('THÔNG BÁO').'</div>';
}

if(isset($_POST[xac])) {
    echo'<center id="ducnghia_tip" style=" height: auto;display: block;"><br><img src="/images/items/pokeball.gif">'.t('Liên kết tài khoản').'<img src="/images/items/pokeball.gif"><hr><img src="/images/items/Poke%20ball.png">'.t('Tài Khoản').' : <input id="taikhoan"  class="input" type="text" value="" style="width: 40%;"><br> <img src="/images/items/Pokedex.png">'.t('Mật khẩu').' : <input id="matkhau" class="input" type="password" value="" style="width: 40%;"><br> <div class="nut" onclick="xacminh()">'.t('Đăng kí').'</div></center>';
}