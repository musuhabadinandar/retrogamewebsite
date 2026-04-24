<?php
if($phienban == 'beta') {
	$ducnghia_check_po = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE wild_id = '".$computer_info['wild_id']."' "));
$p = $ducnghia_check_po ; ?>

<!---thành phố--->
<div class="modal fade" id="ducnghia_pokemon"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="t26_title"><i class="fa fa-book"></i>Thông Tin PokeMon</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><img src="/screen/images/game/close.png"></span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="deschat">
	<!---DỮ LIÊU-->
   
   
<style>
#topteam{
	background:#fff;
	border:2px solid #156073;
	border-radius:10px;
	width:100%;
	max-width: 100px;
	display: block;
	float: right;
	position:relative;
	color:#575757;
}
#topteam img{
	padding: 5px;
}
#topteam2{
	background:#fff;
	border:2px solid #156073;
	border-radius:10px;
	width:100%;
	display: block;
	float: right;
	position:relative;
	color:#575757;
}
#topteam2 img{
	padding: 5px;
}
.ptd {
text-align:center;
}
.th1 {
padding:5px;
background-color:#eee;
border:1px solid #D4D4D4;
}
.td1 {
text-align:center;
background-color:#fff;
padding:5px;
border:1px solid #D4D4D4;
}
.th2 {
padding:5px;
background-color:#314263;
border:1px solid #D4D4D4;
color:white;
font-weight:bold;
width:60%;
margin:10px;
}
.th3 {
padding:5px;
background-color:#314263;
border:1px solid #D4D4D4;
color:white;
font-weight:bold;
width:19%;
margin:10px;
}
.mad {padding-top:5px;padding-left:10px;margin-right:70px;}
.mad2 {padding-top:5px;}
</style>
<center>
<h2>Thông tin Pokemon</h2>
<?php $ducnghia_pokemon = $p; ?>
<hr>



<table>
<tbody><tr>
<td style="text-align:center"><div id="topteam">Thường<br><img style="max-height:100px; max-width:100px;" src="images/pokemon/<?=$ducnghia_pokemon['wild_id']?>.gif"></div></td>
<td style="text-align:center"><div id="topteam">Shiny<br><img style="max-height:100px; max-width:100px;" src="images/shiny/<?=$ducnghia_pokemon['wild_id']?>.gif"></div></td>
</tr>

</tbody></table>


<!---Kết thúc mod Ghi Nguồn By DucNghia-->
<?php

  $p['type1'] = strtolower($p['type1']);
  $p['type2'] = strtolower($p['type2']);

  if(empty($p['type2'])) $p['type'] = '<font color="00FF62">'.$p['type1'].'</font>';
  else $p['type'] = '<font color="red">'.$p['type1'].'</font> <font color="green"> '.$p['type2'].'</font>';
  ?>
  <?php
  if ($p['groei'] == "Medium Slow") { $p['groei'] = "Trung Bình A"; }
  else if ($p['groei'] == "Slow") { $p['groei'] = "Chậm"; } 
  else if ($p['groei'] == "Medium Fast") { $p['groei'] = "Vừa Nhanh"; } 
  else if ($p['groei'] == "Fast") { $p['groei'] = "Nhanh"; } 
  else if ($p['groei'] == "Medium") { $p['groei'] = "Trung Bình S"; } 
  ?>


<hr class="home">
<div class="th2">Chi tiết</div>

  
  <table style="width:100%;background-color:#eee;padding:10px;margin-top:1px">
<td class="txtst"><big>
    <font color="green"><i class="fa fa-id-card-o" aria-hidden="true"></i>
 Họ Tên:</font> <?=$p[naam]?> <br>
   <font color="741414"><i class="fa fa-free-code-camp" aria-hidden="true"></i>
 Hệ:</font> <?=$p['type']?> <br>
 
   <font color="0C371C"><i class="fa fa-rebel" aria-hidden="true"></i>
 Tỉ Lệ Bắt:</font>  <?php
  	  $egesz = 765.7657657657659;
  $egy = $egesz/100;
  $rate = $p['vangbaarheid'];
  $eredmeny = $rate/$egy;
 number_format($eredmeny, 2, '.', '');
 $a = $eredmeny;
 $b = 50;
  $thechance = ceil($a*$b)/$b;
  echo $thechance;
  ?>% <br>
  
   <font color="6A63CE"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 Tăng Trưởng:</font> <?=$p['groei']?> <br>
 
  <font color="060329"><i class="fa fa-map-marker" aria-hidden="true"></i>
 Nơi Yêu Thích:</font> <?php
  $gebied = $p['gebied'];
     if ($p['gebied'] == "Gras") { $gebied = str_replace("Gras","Gras",$gebied); }
  else if($p['gebied'] == "Water") { $gebied = str_replace("Water","Water",$gebied); }
  else if($p['gebied'] == "Strand") { $gebied = str_replace("Strand","Strand",$gebied); }
  else if($p['gebied'] == "Grot"){ $gebied = str_replace("Grot","Grot",$gebied); }
  else if($p['gebied'] == "Lavagrot") { $gebied = str_replace("Lavagrot","Lavagrot",$gebied); }
  else if($p['gebied'] == "Vechtschool") { $gebied = str_replace("Vechtschool","Vechtschool",$gebied); }
  else if($p['gebied'] == "Spookhuis") { $gebied = str_replace("Spookhuis","Spookhuisות",$gebied); }
  else {$gebied = "Chưa Rõ"; }
  echo $gebied;
  ?> <br>
    
     <font color="FD140C"><i class="fa fa-location-arrow" aria-hidden="true"></i>
 Nơi Ở:</font> <?=$p['wereld']?> <br>
 
 <font color="40FF00"><i class="fa fa-rss-square" aria-hidden="true"></i>
 Độ Hiếm:</font>  <?php
    if($p['zeldzaamheid'] == 1) $zeldzaam = 'Thường';
  elseif($p['zeldzaamheid'] == 2) $zeldzaam = 'hiếm';
  else $zeldzaam = 'Cực Hiếm';
  echo $zeldzaam;
  ?> <br>
  
  
   <font color="FD140C"><i class="fa fa-location-arrow" aria-hidden="true"></i>
 Nơi Ở:</font> <?=$p['wereld']?> <br>
 <?php
  $getit = mysql_num_rows(mysql_query('SELECT DISTINCT user_id FROM pokemon_speler WHERE wild_id = "'.$p['wild_id'].'" && user_id != "1" && user_id != "4" && user_id != "75" && user_id != 229'));
   $info = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, naam, zeldzaamheid, type1, type2, gebied, wereld, COUNT(pokemon_speler.wild_id) AS hoeveelingame
										FROM pokemon_wild
										LEFT JOIN pokemon_speler
										ON pokemon_wild.wild_id = pokemon_speler.wild_id
										WHERE pokemon_wild.wild_id = '".$poke."'
										GROUP BY pokemon_wild.wild_id"));
  ?>
 <font color="009CFC"><i class="fa fa-paw" aria-hidden="true"></i>
 Đã Bị Bắt:</font>  <? echo highamount($info['hoeveelingame'])?> con <br>
    
    
    </big>
</td>
</table>
  <table style="width:100%;background-color:#eee;padding:5px;margin-top:1px">
<tbody><tr>
<td class="txtst"><img src="images/icons/hp.png" style="vertical-align:middle;padding-bottom:2px"> HP</td><td><div class="mad" style="width:<?=$p['hp_base']*2?>px;
background-color:#98C542;"><?=$p['hp_base']?></div></td>
  </tr>
<tr>
<td><img src="/images/icons/atk.png" style="vertical-align:middle;padding-bottom:2px"> Attack</td><td><div class="mad" style="width:<?=$p['attack_base']*2?>px;
background-color:#E64A22;"><?=$p['attack_base']?></div></td>
  </tr>
  <tr>
<td class="txtst"><img src="/images/icons/def.gif" style="vertical-align:middle;padding-bottom:2px"> Defense</td><td><div class="mad" style="width:<?=$p['defence_base']*2?>px;
background-color:#E64A22;"><?=$p['defence_base']?></div></td>
  </tr>
  <tr>
<td class="txtst"><img src="/images/icons/spc_atk.png" style="vertical-align:middle;padding-bottom:2px"> Sp. Atk</td><td><div class="mad" style="width:<?=$p['spc.attack_base']*2?>px;
background-color:#E64A22;"><?=$p['spc.attack_base']?></div></td>
  </tr>
    <tr>
<td class="txtst"><img src="/images/icons/spc_def.png" style="vertical-align:middle;padding-bottom:2px"> Sp. Def</td><td><div class="mad" style="width:<?=$p['spc.defence_base']*2?>px;
background-color:#98C542;"><?=$p['spc.defence_base']?></div></td>
  </tr>
    <tr>
<td class="txtst"><img src="/images/icons/spc_spd.png" style="vertical-align:middle;padding-bottom:2px"> Speed</td><td><div class="mad" style="width:<?=$p['speed_base']*2?>px;
background-color:#E64A22;"><?=$p['speed_base']?></div></td>
  </tr>
  </tbody></table>
  <hr class="home">
  
  <div class="th2">Tiến hóa</div>
  
    <table>
  <tbody>
					<tr>
			<?php
  //Get evo
  $getevo = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$p['wild_id'].'" && wat = "evo"');
  if (mysql_num_rows($getevo) == 0) { echo '<div class="info">pokemon này không có thuộc tính tiến hóa !.</div>'; } else {
  if(mysql_num_rows($getevo) >= 1) {
  while ($evo1 = mysql_fetch_assoc($getevo)) {
  $x++;
  //Get names
  $getname = mysql_fetch_assoc(mysql_query('SELECT naam FROM pokemon_wild WHERE wild_id = "'.$evo1['nieuw_id'].'"'));
  if ($evo1['trade'] == 1) { $trade = 1; }

      	if($evo1['wat'] == 'evo' && $evo1['stone'] != ''){
    		$stone = 1;
    	}
		if (!$stone && !$trade && $evo1['level'] > 100) $unknown = 1;
  ?>
  <td style="text-align:center"><div id="topteam">1 Tiến Hóa<br/><strong><?=$p['naam']?></strong><br/><img src="/images/pokemon/<?=$p['wild_id']?>.gif"></td><td style="text-align:center"><img src="/images/leftarrow.png"><br/>
  <div class="ok" style="width:60px"><?php if (!$trade && !$stone && !$unknown) { ?>Lv. <?=$evo1['level']?><?php } else { if ($trade) echo '<img src="//">Đổi lại</a>'; if ($stone) echo' '.$evo1['stone'].''; } if ($unknown) echo'Mega'; ?></div></td></td>
  <td style="text-align:center"><div id="topteam">2.Tiến Hóa<br/><a href="?page=pokemon&id=<?=$evo1['nieuw_id']?>"><strong><?=$getname['naam']?></strong><br/><img src="/images/pokemon/<?=$evo1['nieuw_id']?>.gif"></a></td>
 <?php if ($x%2 == 0) {echo '</tr><tr>'; } ?>
  <?php
  $getevo2 = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$evo1['nieuw_id'].'" && wat = "evo"');
  } }
  if (mysql_num_rows($getevo2) >=1) {
$evo2 = mysql_fetch_assoc($getevo2);
  //Get names
  $getname = mysql_fetch_assoc(mysql_query('SELECT naam FROM pokemon_wild WHERE wild_id = "'.$evo2['nieuw_id'].'"'));
  if ($evo2['trade'] == 1) { $trade = 1; }
    	if($evo2['wat'] == 'evo' && $evo2['stone'] != ''){
    		$stone = 1;
    	}
  ?> <br>
  <td style="text-align:center"><img src="/images/leftarrow.png">
  <div class="ok" style="width:40px"><?php if (!$trade && !$stone) { ?>רמה <?=$evo2['level']?><?php } else { if ($trade) echo 'Mega'; if ($stone) echo'Mega '.$getevo2['stone'].''; } ?></div></td></td> <br>
  <td style="text-align:center"><div id="topteam">3.Tiến Hóa<br/><a href="?page=pokemon&id=<?=$evo2['nieuw_id']?>"><strong><?=$getname['naam']?></strong><br/><img src="/images/pokemon/<?=$evo2['nieuw_id']?>.gif"></a></td>
  <?php
  } } ?>
				</tr>
					
  </tbody></table>
    	
	
 <hr class="home">
  <div class="th2">Tấn Công</div>
  <table style="width:100%;height:100%;"><tr>
  <?php
  //Get attacks
  $getatt = mysql_query('SELECT * FROM levelen WHERE wild_id = "'.$p['wild_id'].'" && wat = "att" ORDER BY level');
  while ($att = mysql_fetch_assoc($getatt)) {
  $x++;
  ?>
  <td>
  <table style="width:100%;height:100%;"><tr><td>
  <img src="/images/leftarrow.png">
  </td><td>
  <div class="dialog" style="width:150px;margin-bottom:10px;text-align:center"><b><?=$att['aanval']?></b><br/><font color="#444444">(Lv. <b><?=$att['level']?></b>)</font></div>
  </td></tr></table>
  </td>
  <?php
  if ($x % 3 == 0) {echo '</tr><tr>'; } ?>
  <?php } ?>
  </tr></table>
      
  
  <hr class="home">
  <div class="th2">MOVE có thể học</div>
  <table style="width:100%;height:100%;"><tr>
  <?php
  $getattacks = mysql_query('SELECT omschrijving,naam FROM tmhm WHERE type1 = "'.$p['type1'].'" || type1 = "'.$p['type2'].'" || type2 = "'.$p['type2'].'" || type2 = "'.$p['type1'].'"');
  while($attack = mysql_fetch_assoc($getattacks)) { $s++; ?>
  <td class="dialog" style="width:150px;text-align:center;direction:ltr"><?=$attack['omschrijving']?> <br/>(<b><?=$attack['naam']?></b>)</td> <?php if ($s % 5 == 0) {echo'</tr><tr>'; } 
  }
  ?>
  </tr></table>
</center></div>

			
			
			
			
			
			
			
			
			
			
			</div>
			
		</td>
		
	<tr>
	    
</table>
</center> 
<style>
#halloween { width:90%; margin:0 auto; }
#halloween .info { width:75%; background: #feffff; /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover,  #feffff 0%, #d2ebf9 100%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#feffff), color-stop(100%,#d2ebf9)); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  #feffff 0%,#d2ebf9 100%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  #feffff 0%,#d2ebf9 100%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  #feffff 0%,#d2ebf9 100%); /* IE10+ */
background: radial-gradient(ellipse at center,  #feffff 0%,#d2ebf9 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#feffff', endColorstr='#d2ebf9',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
 vertical-align:top; border:1px solid #ccc; border-radius:10px; padding:5px; box-shadow:0 0 5px #ccc; margin:10px; }
#halloween .info h2 { color: #ccffff; text-shadow: 0px 0px 5px #000, 0px 1px #006699; }
#halloween .howmuch {width:65%; text-align:center; margin-right:auto; margin-left:auto; border:2px solid #ccc; padding:5px;border-radius:5px; background:#fff; }
#event-shop { background:#fff; margin:5px; border:1px solid #ccc; padding:5px; width:570px; text-align:right; -webkit-transition:all .2s;-moz-transition:all .2s;-o-transition:all .2s;-ms-transition:all .2s;transition:all .2s; border-radius:2px; }
#event-shop:hover { box-shadow:0 1px 5px #888;text-shadow:1px 1px #fff;border:1px solid #28610c; }
#event-shop .iimg { width:100px; height:100px; }
#event-shop .info { border:1px solid #ccc; background:#eee; vertical-align:top; padding:5px; }
#event-shop .iprice { background:#fff; border:1px solid #ccc; text-align:center; }
#event-shop .take { width:72px; height:128px; border:1px solid #ccc; background:#fff; border-right:0; -webkit-transition:all .2s;-moz-transition:all .2s;-o-transition:all .2s;-ms-transition:all .2s;transition:all .2s; }
#event-shop .take:hover { background:#cbffb1; color:#28610c; text-shadow:1px 1px #fff; font-weight:bold;cursor:pointer; }
div.error {
	width: 70%;
	color: #DC0000;
	font-weight: bold;
	background: #FFE5DF url(images/icons/alert_red.png) left center no-repeat;
	border: 1px solid #DC0000;
	margin: 0px 0px 10px 0px;
	padding: 5px 5px 5px 28px;
	text-align:center;
	font-size: 16px;
}div.accept {
	width: 70%;
	color: #00a139;
	font-weight: bold;
	background: #dfffd6 url(images/icons/alert_green.png) left center no-repeat;
	border: 1px solid #7cb86c;
	margin: 0px 0px 10px 0px;
	padding: 5px 5px 5px 28px;
	text-align:center;
}
small { font-size:10px; }
</style>	
	<!--HẾT--->
	
	
	
	  </div> 
		</div>
	
    </div>
  </div>
</div>
<script>
// Get the modal
var modal  = document.getElementById('ducnghia_pokemon');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php }?>