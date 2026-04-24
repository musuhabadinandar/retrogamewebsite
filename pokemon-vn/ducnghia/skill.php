<!--chọn skill by Đức Nghĩa-->
<?php
 $ducnghia_id = $_GET['id'];
  $ducnghia_pokemon =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE `id` = '" .$_GET['id']."'"));
  $ducnghia_vatpham =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gebruikers_item` WHERE `user_id` = '" .$datauser['user_id']."'"));
    $pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.* ,pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id WHERE pokemon_speler.id='".$ducnghia_id."'"));

if(isset($_POST['ducnghia_dung'])){
$skill = $_POST['vatpham']; 

  mysql_query("UPDATE `pokemon_speler` SET `ducnghia_skill`='".$skill."'  WHERE `user_id`='".$_SESSION['id']."' AND `id` = '$ducnghia_id'");

   
    echo '<div class="green">bạn đã cài đặt thành công SKILL '.$skill.' cho PokeMon.Từ giờ khi auto đánh PokeMon sẽ dùng kĩ năng này.</div>';
    
}
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
    
    
        <form method="post">
  
<br>	<select name="vatpham" class="text_select">
		<?php if (!empty($ducnghia_pokemon['aanval_1'])) { ?>
			   <option value="<?=$ducnghia_pokemon['aanval_1']?>"><?=$ducnghia_pokemon['aanval_1']?> <?=$ducnghia_1?></option>
			   <?php } ?>
			   
			   	<?php if (!empty($ducnghia_pokemon['aanval_2'])) { ?>
			   <option value="<?=$ducnghia_pokemon['aanval_2']?>"><?=$ducnghia_pokemon['aanval_2']?> <?=$ducnghia_2?></option>
			   <?php } ?>
			   
			   	<?php if (!empty($ducnghia_pokemon['aanval_3'])) { ?>
			   <option value="<?=$ducnghia_pokemon['aanval_3']?>"><?=$ducnghia_pokemon['aanval_3']?> <?=$ducnghia_3?></option>
			   <?php } ?>
			   
			   	<?php if (!empty($ducnghia_pokemon['aanval_4'])) { ?>
			   <option value="<?=$ducnghia_pokemon['aanval_4']?>"><?=$ducnghia_pokemon['aanval_4']?> <?=$ducnghia_4?></option>
			   <?php } ?>
			   
			   
			   

                    
		</select><br>

 


	<input type="submit" name="ducnghia_dung" value="Chọn" class="button_mini">

      
     
      
       
      
  </form>
  <br>
  <font color="red"><big>CHỈ CÀI NHỮNG SKILL CÓ TẤN CÔNG >0</big></font> <BR>
  <font color="red">ĐÂY LÀ GÌ?</font> Đây là tính năng giúp bạn <br>
  treo pokemon hiệu quả khi đi tập luyện , khi cài đặt song.<br>thì khi đánh auto <br>
  pokemon chỉ dùng kĩ năng mà bạn đã cài đặt cho</br>,sẽ không bị đánh những skill  
  mà như hiệu ứng ! n<br>gại ngần gì mà không dùng tính năng này ?
</table>
</center></div>
<style>
.burned {
border: 1px solid #000000;border-bottom:0;
border-radius:10px 10px 0 0;
box-shadow:0 0 5px #333;
background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 75%, rgba(237,237,237,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(75%,rgba(255,255,255,1)), color-stop(100%,rgba(237,237,237,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 75%,rgba(237,237,237,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 75%,rgba(237,237,237,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 75%,rgba(237,237,237,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 75%,rgba(237,237,237,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 ); /* IE6-9 */
text-align:center;
}
.bubble {
background:#fff;
	border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius:6px;
	width:99%;
	box-shadow:0 0 5px #ccc;
	}
div.mega {
	width: 100%;
	color: #d63934;
	font-weight: bold;
	background: #dfcfbd;
	border: 1px solid #d63934;
	margin: 0px 0px 10px 0px;
	padding: 5px 5px 5px 28px;
	text-align:center;
	border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius:6px;
}
.error { background-color:#e83c37; width:97%; border:1px solid #eee;box-shadow:inset 0px 1px 0px 0px #953c3e, 0 0 5px #ccc;margin-bottom:10px;color:#fff;text-shadow:1px -1px #953c3e;text-align:right;padding-right:15px; }
.error h2 { text-align:center; }
</style>
