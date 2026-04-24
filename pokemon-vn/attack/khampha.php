<?
//Script laden zodat je nooit pagina buiten de index om kan laden
include("includes/security.php");

//Kijken of je wel pokemon bij je hebt
if($gebruiker['in_hand'] == 0) header('location: index.php');

$page = 'attack/agaditorium';
//Goeie taal erbij laden voor de page
include_once('language/language-pages.php');
if ($gebruiker['rank'] >= 3) {
if ($gebruiker['legendary'] > 0) {


if(mysql_num_rows(mysql_query("SELECT `id` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND `ei`='0' AND `opzak`='ja'")) > 0){
  if((isset($_POST['gebied'])) && (is_numeric($_POST['gebied']))){
    if($_POST['gebied'] == 1) $gebied = 'Lavagrot';
    elseif($_POST['gebied'] == 2) $gebied = 'Vechtschool';
    elseif($_POST['gebied'] == 3) $gebied = 'Gras';
    elseif($_POST['gebied'] == 4) $gebied = 'Spookhuis';
    elseif($_POST['gebied'] == 5) $gebied = 'Grot';
    elseif($_POST['gebied'] == 6) $gebied = 'Water';
    elseif($_POST['gebied'] == 7) $gebied = 'Strand';
	
    
    if($gebruiker['in_hand'] == 0)
      echo '<div class="blue"><img src="images/icons/blue.png"> '.$txt['alert_no_pokemon'].'</div>';
    elseif(($gebied == 'Water') AND ($gebruiker['Fishing rod'] == 0))
      $error	= '<div class="red">Chưa có Fishi rod</div>';
    elseif(($gebied == 'Grot' || $_POST['gebied'] == 'Lavagrot') AND ($gebruiker['Cave suit'] == 0))
      $error	= '<div class="red">Chưa có Cave Suit<div>';
    else{
      //Zeldzaamheid bepalen
      $zeldzaam = rand(500,2500);
      if($zeldzaam <= 100) $trainer = 1;// Team Rocket
      elseif($zeldzaam <= 2100) $zeldzaamheid = 1;
      elseif($zeldzaam <= 2499) $zeldzaamheid = 2;
      elseif($zeldzaam == 2500) $zeldzaamheid = 3;
            if($trainer == 1){
        $query = mysql_fetch_assoc(mysql_query("SELECT `naam` FROM `trainer` WHERE `badge`='' AND (`gebied`='".$gebied."' OR `gebied`='All') ORDER BY rand() limit 1"));
        include('attack/trainer/trainer-start.php');
        mysql_data_seek($pokemon_sql, 0);
        $opzak = mysql_num_rows($pokemon_sql);
        $level = 0;
        while($pokemon = mysql_fetch_assoc($pokemon_sql)) $level += $pokemon['level'];
        $trainer_ave_level = $level/$opzak;
        //Make Fight
        $info = create_new_trainer_attack($query['naam'],$trainer_ave_level,$gebied);
        if(empty($info['bericht'])) header("Location: ?page=attack/trainer/trainer-attack");
        else echo "<div class='red'>".$txt['alert_no_pokemon']."</div>";
      }
	  
	        if($trainer == 1){
        $query = mysql_fetch_assoc(mysql_query("SELECT `naam` FROM `trainer` WHERE `badge`='' AND (`gebied`='".$gebied."' OR `gebied`='All') ORDER BY rand() limit 1"));
        include('attack/trainer/trainer-start.php');
        mysql_data_seek($pokemon_sql, 0);
        $opzak = mysql_num_rows($pokemon_sql);
        $level = 0;
        while($pokemon = mysql_fetch_assoc($pokemon_sql)) $level += $pokemon['level'];
        $trainer_ave_level = $level/$opzak;
        //Make Fight
        $info = create_new_trainer_attack($query['naam'],$trainer_ave_level,$gebied);
        if(empty($info['bericht'])) header("Location: ?page=attack/trainer/trainer-attack");
        else echo "<div class='red'>".$txt['alert_no_pokemon']."</div>";
      }
      else{
        if(($gebruiker['rank'] > 15) && (!empty($gebruiker['lvl_choose']))){
          $level = explode("-", $gebruiker['lvl_choose']);
          $leveltegenstander = rand($level[0],$level[1]);
        }
        else $leveltegenstander = rankpokemon($gebruiker['rank']);
        
        $query = mysql_fetch_assoc(mysql_query("SELECT wild_id FROM `pokemon_wild` WHERE `gebied`='".$gebied."' AND `wereld`='".$gebruiker['wereld']."' AND `zeldzaamheid`='".$zeldzaamheid."' ORDER BY rand() limit 1"));
        //Geen pokemon geen gekozen
        if(empty($query['wild_id']))
          $query = mysql_fetch_assoc(mysql_query("SELECT wild_id FROM `pokemon_wild` WHERE `gebied`='".$gebied."' AND `wereld`='".$gebruiker['wereld']."' AND `zeldzaamheid`='1' ORDER BY rand() limit 1"));
          //echo "<div class='red'>".$txt['alert_error']." 100".$zeldzaamheid.".</div>";
        //else{
		$upd = mysql_query('UPDATE gebruikers SET legendary = legendary-1 WHERE user_id = "'.$gebruiker['user_id'].'"');
          include("attack/wild/wild-start.php");
          $info = create_new_attack($query['wild_id'],$leveltegenstander,$gebied);
          if(empty($info['bericht'])) header("Location: ?page=attack/wild/wild-attack");
          else echo "<div class='red'>".$txt['alert_no_pokemon']."</div>";
        //}
      }
    }
  }
  
  echo $error; ?>
    	<center>
<img src="images/pkm.jpg" alt="אגדיתוריום"/>
				</center>
				<div class="dialog">Xin chào bạn đến với Khám Phá.tại đây bạn sẽ có 25% tỉ lệ gặp PokeMon Huyền Thoại ! chúc may mắn.<br/>
				Số trận đấu còn lại:
				<b><?=$gebruiker['legendary']?></b> Trận.
			
				</div>
				<br/>
<script src="../javascripts/main.js" type="text/javascript"></script>
<style>
#tooltip{
	position:absolute;
	border:1px solid #333;
	background:#f7f5d1;
	padding:2px 5px;
	color:#333;
	display:none;
	}	
	</style>
<?php 
$places = array("none","Lavagrot","Vechtschool","Gras","Spookhuis","Grot","Water","Strand"); // Array for the items
$r = rand(1,7);
$theplace = $places[$r];
	if ($gebruiker['wereld'] == "Kanto") { 
	?>
	<form method="post" name="<?=$theplace?>">
	<input type="image" onClick="<?=$theplace?>.submit();" src="images/kanto.jpg" alt="click để vào trận chiến"
	<input type='hidden' value='<?=$r?>' name='gebied'>
	</form>
	<?php
	}
	elseif ($gebruiker['wereld'] == "Johto") {        
	?>
	<form method="post" name="<?=$theplace?>">
	<input type="image" onClick="<?=$theplace?>.submit();" src="images/kanto.jpg" alt="click để vào trận chiến">
	<input type='hidden' value='<?=$r?>' name='gebied'>
	</form>
	<?php
	}
	elseif ($gebruiker['wereld'] == "Hoenn") {        
	?>
	<form method="post" name="<?=$theplace?>">
	<input type="image" onClick="<?=$theplace?>.submit();" src="images/kanto.jpg" alt="האגדיתוריום של הואן">
	<input type='hidden' value='<?=$r?>' name='gebied'>
	</form>
	<?php
	}
	elseif ($gebruiker['wereld'] == "Sinnoh") {        
	?>
	<form method="post" name="<?=$theplace?>">
	<input type="image" onClick="<?=$theplace?>.submit();" src="images/kanto.jpg" alt="האגדיתוריום של סינו">
	<input type='hidden' value='<?=$r?>' name='gebied'>
	</form>
	<?php
	}
	elseif ($gebruiker['wereld'] == "Unova") {        
	?>
	<form method="post" name="<?=$theplace?>">
	<input type="image" onClick="<?=$theplace?>.submit();" src="images/kanto.jpg" alt="האגדיתוריום של יונובה">
	<input type='hidden' value='<?=$r?>' name='gebied'>
	</form>
	<?php
}
}
else{
  echo '<div style="padding-top:10px;"><div class="blue"><img src="images/icons/blue.png" width="16" height="16" /> '.$txt['alert_no_pokemon'].'</div></div>';
}
} else  { echo '<div class="error">
Bạn đã hết lượt khám phá.xin vui lòng quay lại ngày mai.
</div>'; }
} else { echo'<img src="images/agadilock.jpg" alt="Giải đấu bị đóng cửa ">'; }
?>