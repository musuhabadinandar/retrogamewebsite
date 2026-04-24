<?php
require_once('sys.php');
$trang_xg = mysql_fetch_array(mysql_query("SELECT `text` FROM `ducnghia_text` Where `id` !=0 ORDER BY RAND() LIMIT 1"));
if($set['start']==8 ){  
 if($vatpham['sex']==0 ){
$_SESSION['err'] = 'chọn giới tính trước đi nào ?????';
header('Location: /gioitinh');
exit();
}
if($set['trangthai']==1 ){
$_SESSION['err'] = 'Chào Mừng Bạn Quay Lại Quá Khứ';
header('Location: /quakhu');
exit();
}
}
$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `chat`"),0);
	if(($dem-$_SESSION['new_ce']) >0)
	$new_ce = '+'.($dem-$_SESSION['new_ce']);
	
if ($user) {
	$icon_mail = "";
    echo '<div class="block_zero border1">';
    if ($set['start'] == 8) {
        echo '<a href="/home">';
    }
	$name_main="";
	if($set['mesto'] != 'Trang chính')
	$name_main = 'Trang chủ »» ';
	?><?php
    echo '<a href="/home">Trang Chủ</a> | <a href="/mail.php/" title="Tin Nhắn"><img src="/ducnghia/img/sms.png" ><span style="color: #c66;"><small> ' .number_format(mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_dialog` WHERE `status` = '0' AND `id_dialog` = '$user_id' "), 0)) . '</small></a> | 
<a href="/muavang" title="Vàng"><img src="/ducnghia/img/gold.png" ><span style="color: #ffd555;"><small> ' . number_format($set['gold']) . '</b></span></a></small>

|  <a href="/nganhang" title="Bạc"><img src="/ducnghia/img/bac.png" ><span style="color: #ffd555;"><small> ' . number_format($set['baks']) . '</b></span></a></small>|<a href="/tutorial/exit" title="đăng xuất"><img src="/images/icons/exit.png" >Thoát</a>
    <span style="float: right;">' . $icon_mail . ' <a href=""><img src="/images/icons/refresh.png" width="18px" height="18px" alt="Update"></a>
    </span>
    
   
							</div>
   
    
    </div><div class="block_zero">';
    $level = file('system/ducnghia.dat');
    //$level = require_once('ducnghia.dat');
    if ($set['lvl'] < 220) {
        $exp = _NumFilter($level[$set['lvl'] + 1]);
    } else {
        $exp = FALSE;
    }
    if ($set['exp'] >= $exp) {
        $exp_lvl = $set['exp'] - $exp;
		$maxmp = 100 + $set['lvl'] + 1;
		$maxhp = 100 + $set['lvl'] + 1;
        mysql_query("UPDATE `user_set` SET `lvl`=`lvl`+'1', `exp`='" . $exp_lvl . "', `hp`=`hp`+'50', `mp`=`mp`+'50',`max_hp`='".$maxhp."',`max_mp`='".$maxmp."', `skill`=`skill`+'5' WHERE `id`='" . $user_id . "' LIMIT 1");
        $_SESSION['light'] = '<span class="quality-4">Chúc mừng bạn đã đạt cấp độ mới!<br/>Thể lực và năng lượng hồi phục 50 điểm!<br/>Thể lực và năng lượng tối đa được gia tăng thêm!</span></div>';
    }
    $set = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_id . "'");
    ?>

<!---<div class="exp_bar" title="Kinh Nghiệm của Bạn">
	<div class="progress" style="width: <?php echo  round(100 / ($exp / ($set['exp']))) ?>%" ></div>
</div> --->

	


<?php
    if ($set['skill'] > 0) {
        $skill_kol = '#ff3434';
    } else {
        $skill_kol = '#3c3';
    }
	//mod chat the gioi by DucNghia ///
$ducnghiax = mysql_fetch_array(mysql_query("SELECT * FROM `wnew` ORDER BY `id` DESC LIMIT 1"));
$tinhtimeht = time() - $ducnghiax['time'];
if($tinhtimeht <= 60){
$idchat = $ducnghiax['user'];
$nick = mysql_fetch_array(mysql_query("SELECT * FROM `user_reg` WHERE `id`='".$idchat."'"));
?>
<div class="main">
	
	<div class="mini-line"></div>
<marquee style="border:red 2px SOLID">		«Kênh Thế Giới» <span style="color: #fffabd;"><?php echo $nick['ten'];?>
</span>
</b>: <span style="color: #9c9;"><?php echo $ducnghiax['text'];?></span></b></marquee></div>	<div class="dot-line"></div>
<?php
}
    if ($set['baove'] == 1000) {
?><div class="main">
	
	<div class="mini-line"></div>
<marquee style="border:red 2px SOLID">		«Hệ Thống» 
</span>
</b>: <span style="color: #9c9;">Nhân Vật Của Bạn Đang Được Bảo Vệ Trong Vòng <span style="color: #fffabd;"> <?php echo ' '.thoigiantinh($set[timebaove]).' '  ?></span> bạn sẽ không bị người khác cướp</span></b></marquee></div>	<div class="dot-line"></div>
<?php
}

/// ket thuc mod chat the gioi
  $trantrang = rand(1,11); 
  if ($trantrang == 1 ){$text_ducnghia='VIP sẽ có nhiều quyền lợi hơn.';
  } else if ($trantrang == 2 ){$text_ducnghia='Hãy truy cập nhiều vào Hoạt Động để không bỏ lỡ hoạt động nào nhé.';
  }
  else if ($trantrang == 3 ){$text_ducnghia='Hãy chú tâm làm nhiệm vụ.';
  } else if ($trantrang == 4 ){$text_ducnghia='Có 5 hệ pokemon theo Kim - Mộc - Thủy - Hỏa - Thổ.';
  }
  else if ($trantrang == 5 ){$text_ducnghia='Pokemon Mega còn có tên gọi là PokeMon Huyền Thoại';
  }  else if ($trantrang == 6 ){$text_ducnghia='Quà TOP sẽ được trao vào 24h hằng ngày';
  } else if ($trantrang == 7 ){$text_ducnghia='Công Thành Chiến mở cửa lúc 10h - 11 và 19-20h chú ý tham gia nhé';
  } else if ($trantrang == 8 ){$text_ducnghia='Đấu Gym sẽ được x4 EXP ! hãy tham gia nhé';
  }else if ($trantrang == 9 ){$text_ducnghia='Boss có rất nhiều món đồ đặc biệt';
  }else if ($trantrang == 10 ){$text_ducnghia='thể hiện bản lĩnh bằng cách đấu rank';
  }
  else if ($trantrang == 11 ){$text_ducnghia='Mỗi ngày bạn có 1 điều ước MIỄN PHÍ từ Rồng Thần';
  }
		?>
		
<div class="mini-line"></div>

                                   <font color="FF6600">Chào mừng đến với thế giới Pokémon</font><br/>
<a href="/faq.php"><font color="6633FF">Bạn Gặp Khó khăn Hãy ấn Vào Đây</a></font>
<br/><a href="https://www.facebook.com/ducnghia27"><font color="00FF00">>>Like Fanpages Của PokeMonZ Việt Nam<<</a>	</font>								<br/>

									<b><font color="red">
									<?php
										
									
									
									
									echo $trang_xg['text'] ?>									</font></b>
									<br/>
									<a href="/"><img src="/ducnghia/img/IMGTB.png" border="0" style="float:left;width:100px;"/></a>: Cập Nhật Tính Năng Chiếm Thành Mỏ ! Chi Tiết  	<a href="https://pkmvietnam.top/diendan/bai-140"><font color="6633FF">TẠI ĐÂY</a></font>								<br>	
		<br>


	
<div class="mini-line"></div>
                            
                                        	
		<br>
	
		
		
		
		
		
		
		
	<?php
			
} else {
    echo '<div class="foot center"><b style="color: #999;">«' . $game . '»</b></div><div class="line"></div>';
}
if (isset($_SESSION['err'])) {
    echo '<div class="error center animated shake"><img src="/images/icons/error.png"> ' . $_SESSION['err'] . '</div>';
    $_SESSION['err'] = NULL;
}
if (isset($_SESSION['ok'])) {
    echo '<div class="ok center animated shake"><img src="/images/icons/ok.png"> ' . $_SESSION['ok'] . '</div>';
    $_SESSION['ok'] = NULL;
}
if (isset($_SESSION['light'])) {
    echo '<div class="block_light center animated shake">' . $_SESSION['light'] . '</div>';
    $_SESSION['light'] = NULL;
}
if (isset($_SESSION['train_ok'])) {
    echo '<script>
	$(function(){
		$(".block_light").hide();
		$(".togg").hide();
			$(".block_light").animate({
			opacity: 0.8,
			left: "+=20",
			height: "toggle"
			},5000, function() {
				$(".block_light").animate({
				opacity: 0.8,
				left: "+=20",
				height: "toggle"
				},1000, function() {
					$(".togg").show();
				});
			});
			$(".togg").click(function() {
				$(".block_light").animate({
				opacity: 0.8,
				left: "+=20",
				height: "toggle"
				},1000, function() {
				});
			});
	});</script>
	<div class="block_zero center">
	<a class="togg" href="#"> Xem lại trận đấu </a> 
	</div>
	<div class="block_light center small animated shake"><span class="quality-4">' . $_SESSION['train_ok'] . '</span></div>';
    $_SESSION['train_ok'] = NULL;
}

$datauser=$set;
?>