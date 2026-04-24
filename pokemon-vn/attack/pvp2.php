<?PHP
include_once('../includes/ducnghiadz.php'); include_once('../language/language-general.php'); include_once('../includes/config.php'); include_once('../includes/ingame.inc.php');include_once('../includes/ducnghia.php');include_once('../_GNPANEL/_NEWTECH/Pusher.php');

 ?>
 
 
   <style> 
       
      .ducnghia_text{ 
	display: block;
	background: #1e5238 no-repeat; 
    width: 100%;
    height: auto;
	color:#c7f9ef; 
	font-size:11px;
	font-family:tahoma;
	overflow: auto;
	overflow-y: scroll;
	max-height: 70px;
		position: relative;

}
.ducnghia_text::-webkit-scrollbar {
    width: 6px;
    background-color: #F5F5F5;
} 
.ducnghia_text::-webkit-scrollbar-thumb {
    background-color: #000000;
}
.ducnghia_text::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

}
  </style>

 <style>
 #tooltip{
	position:absolute;
	border:1px solid #333;
	background:#f7f5d1;
	padding:2px 5px;
	color:#333;
	display:none;
	}
.attack-pp {
	font-size: 12px;
    text-align: center;
    color: #6d0526;
    cursor: pointer;
	position: absolute;
    right: 5px;
    bottom: 5px;
}
#hit,#hit2{
width:10px;
height:10px;
background-size: 100% 100%;
background-repeat:no-repeat;
background-position:center center; 
position:absolute;
 margin-left: 10px;
z-index: 909;
}
#hit {position:absolute;left:-30px;top:250px;animation:eff 1s;-webkit-animation:eff 1s;-webkit-animation-delay:0s;-webkit-animation-iteration-count:1;animation-iteration-count: 1;opacity:0;}
@-webkit-keyframes eff {10% {opacity:0.5;left:220px;top:30px;width:120px;height:120px;}100% {opacity:0.8;left:220px;top:30px;width:120px;height:120px;}}
#hit{background:url('/images/ducnghia/hieuung/ducnghia_1.gif');background-size: 100% 100%;}
@keyframes eff {10% {opacity:0.5;left:220px;top:20px;width:120px;height:120px;}100% {opacity:0.8;left:220px;top:20px;width:120px;height:120px;}}
#hit{background:url('/images/ducnghia/hieuung/ducnghia_1.gif');background-size: 100% 100%;}

#hit2 {position:absolute;left:220px;top:10px;animation:eff2 1s;-webkit-animation:eff2 1s;-webkit-animation-delay:0s;-webkit-animation-iteration-count:1;animation-iteration-count: 1;opacity:0;}
@-webkit-keyframes eff2 {10% {opacity:0.5;left:-20px;top:100px;width:120px;height:120px;}100% {opacity:0.8;left:-20px;top:100px;width:120px;height:120px;}}
#hit2{background:url('/images/ducnghia/hieuung/ducnghia_1.gif');background-size: 100% 100%;}
@keyframes eff2 {10% {opacity:0.5;left:-20px;top:100px;width:120px;height:120px;}100% {opacity:0.8;left:-20px;top:100px;width:120px;height:120px;}}
#hit2{background:url('/images/ducnghia/hieuung/ducnghia_1.gif');background-size: 100% 100%;}

#hit #hit2 {
     animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
  transform: translate3d(0, 0, 0);
  backface-visibility: hidden;
  perspective: 1000px;
}
@keyframes shake {
  10%, 90% {
    transform: translate3d(-1px, 0, 0);
  }
  
  20%, 80% {
    transform: translate3d(2px, 0, 0);
  }

  30%, 50%, 70% {
    transform: translate3d(-4px, 0, 0);
  }

  40%, 60% {
    transform: translate3d(4px, 0, 0);
  }
}


.eff_f {position:absolute;animation:efff 0.4s;-webkit-animation:efff 0.4s;-webkit-animation-delay:0s;-webkit-animation-iteration-count:1;animation-iteration-count: 1;}
@-webkit-keyframes efff {10% {opacity:0.8;left:20px;top:100px;max-width:100px;height:auto;}100% {opacity:0.7;left:220px;top:30px;max-width:80px;height:auto;}}
@keyframes efff {10% {opacity:0.8;left:20px;top:100px;max-width:100px;height:auto;}100% {opacity:0.7;left:220px;top:30px;max-width:80px;height:auto;}}

.eff_f2 {position:absolute;animation:efff2 0.4s;-webkit-animation:efff2 0.4s;-webkit-animation-delay:0s;-webkit-animation-iteration-count:1;animation-iteration-count: 1;}
@-webkit-keyframes efff2 {10% {opacity:0.8;left:220px;top:30px;max-width:100px;height:auto;}100% {opacity:0.7;left:-20px;top:100px;max-width:80px;height:auto;}}
@keyframes efff2 {10% {opacity:0.8;left:220px;top:30px;max-width:100px;height:auto;}100% {opacity:0.7;left:-20px;top:100px;max-width:80px;height:auto;}}
</style>
<?php
#Load Safety Script
include("../includes/security.php");

#Load language
$page = 'attack/duel/duel-attack';
#Goeie taal erbij laden voor de page
include_once('../language/language-pages.php');

#Include Duel Functions
include("../attack/duel/duel.inc.php");

#Include Attack Functions
include("../attack/attack.inc.php");
    mysql_query("UPDATE `gebruikers` SET `pvp`='0' WHERE `user_id`='".$_SESSION['id']."'");

#Load duel info
$duel_info = duel_info($_SESSION['duel']['duel_id']);

# Check if uitdager en tegenstander or valid
if(($duel_info['uitdager'] != $_SESSION['naam']) AND ($duel_info['tegenstander'] != $_SESSION['naam'])){
  remove_duel($duel_info['id']);
  #Send back to home
?>
 <script language="javascript">
     node('/admin.php?ducnghia=pvp');

 </script>
<?PHP
#Delete Cookie
  unset($_SESSION['duel']['duel_id']);
} 

if($duel_info['uitdager'] == $_SESSION['naam']){
  $duel_info['you'] = "uitdager";
  $duel_info['you_duel'] = "u_klaar";  
  $duel_info['you_sex'] = $duel_info['u_character'];
  $duel_info['opponent'] = "tegenstander";
  $duel_info['opponent_duel'] = "t_klaar";
  $duel_info['opponent_sex'] = $duel_info['t_character'];
  $duel_info['opponent_name'] = $duel_info['tegenstander'];
  
  #Load All Pokemon Info
  $pokemon_info = pokemon_data($duel_info['u_pokemonid']);
  $pokemon_info['naam_klein'] = strtolower($pokemon_info['naam']);
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);

  #Calculate Life in Procent for Pokemon         
  if($pokemon_info['leven'] != 0) $pokemon_life_procent = round(($pokemon_info['leven']/$pokemon_info['levenmax'])*100);
  else $pokemon_life_procent = 0;

  #Calculate Exp in procent for pokemon
  if($pokemon_info['exp'] != 0) $pokemon_exp_procent = round(($pokemon_info['exp']/$pokemon_info['expnodig'])*100);
  else $pokemon_exp_procent = 0;
  
  #Shiny
  $pokemon_info['map'] = "pokemon";
  $pokemon_info['star'] = "none";
  if($pokemon_info['shiny'] == 1){
    $pokemon_info['map'] = "shiny";
    $pokemon_info['star'] = "block";
  }

  #Load All Opoonent Info
  $opponent_info = pokemon_data($duel_info['t_pokemonid']);
  $opponent_info['naam_klein'] = strtolower($opponent_info['naam']);
  $opponent_info['naam_goed'] = pokemon_naam($opponent_info['naam'],$opponent_info['roepnaam']);

  #Calculate Life in Procent for Pokemon         
  if($opponent_info['leven'] != 0) $opponent_life_procent = round(($opponent_info['leven']/$opponent_info['levenmax'])*100);
  else $opponent_life_procent = 0;
  
  #Shiny
  $opponent_info['map'] = "pokemon";
  $opponent_info['star'] = "none";
  if($opponent_info['shiny'] == 1){
    $opponent_info['map'] = "shiny";
    $opponent_info['star'] = "block";
  }
}

elseif($duel_info['tegenstander'] == $_SESSION['naam']){
  $duel_info['you'] = "tegenstander";
  $duel_info['you_duel'] = "t_klaar";
  $duel_info['you_sex'] = $duel_info['t_character'];
  $duel_info['opponent'] = "uitdager";
  $duel_info['opponent_duel'] = "u_klaar";
  $duel_info['opponent_sex'] = $duel_info['u_character'];
  $duel_info['opponent_name'] = $duel_info['uitdager'];

  #Load All Pokemon Info
  $pokemon_info = pokemon_data($duel_info['t_pokemonid']);
  $pokemon_info['naam_klein'] = strtolower($pokemon_info['naam']);
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);

  #Calculate Life in Procent for Pokemon         
  if($pokemon_info['leven'] != 0) $pokemon_life_procent = round(($pokemon_info['leven']/$pokemon_info['levenmax'])*100);
  else $pokemon_life_procent = 0;

  #Calculate Exp in procent for pokemon
  if($pokemon_info['exp'] != 0) $pokemon_exp_procent = round(($pokemon_info['exp']/$pokemon_info['expnodig'])*100);
  else $pokemon_exp_procent = 0;
  
  #Shiny
  $pokemon_info['map'] = "pokemon";
  $pokemon_info['star'] = "none";
  if($pokemon_info['shiny'] == 1){
    $pokemon_info['map'] = "shiny";
    $pokemon_info['star'] = "block";
  }
			if(!empty($pokemon_info['vorm'])) { $geg = '-'.$pokemon_info['vorm']; }
		else { $geg = ''; }
		
  #Load All Opoonent Info
  $opponent_info = pokemon_data($duel_info['u_pokemonid']);
  $opponent_info['naam_klein'] = strtolower($opponent_info['naam']);
  $opponent_info['naam_goed'] = pokemon_naam($opponent_info['naam'],$opponent_info['roepnaam']);
			if(!empty($opponent_info['vorm'])) { $geg1 = '-'.$opponent_info['vorm']; }
		else { $geg1 = ''; }
  #Calculate Life in Procent for Pokemon         
  if($opponent_info['leven'] != 0) $opponent_life_procent = round(($opponent_info['leven']/$opponent_info['levenmax'])*100);
  else $opponent_life_procent = 0;
  #Shiny
  $opponent_info['map'] = "pokemon";
  $opponent_info['star'] = "none";
  if($opponent_info['shiny'] == 1){
    $opponent_info['map'] = "shiny";
    $opponent_info['star'] = "block";
  }
}

$time_left = strtotime(date("Y-m-d H:i:s"))-$duel_info['laatste_beurt_tijd'];
if($time_left > 61) $time_left = 59;


for($inhand = 1; $player_hand = mysql_fetch_assoc($pokemon_sql); $inhand++){
  #Check Wich Pokemon is infight
  if($player_hand['id'] == $pokemon_info['id']) $infight = 1;
  else $infight = 0;
  if($player_hand['ei'] == 1){ 
    $player_hand['naam'] = "??";
    $player_hand['wild_id'] = "??";
  }
  ?>
      <script type="text/javascript" src="/attack/javascript/attack.js"></script>

  <script>

    //If div is ready

  $("div[id='change_pokemon']").ready(function() {
        //Is pokemon in fight, so yes, don't show
        if(<? echo $infight; ?> == 1){
          if(<? echo $player_hand['shiny']; ?> == 1){
            $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").css({ backgroundImage : "url(images/shiny/icon/<? echo strtolower($player_hand['wild_id']); ?>.gif)" });
            $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").attr("title", "<? echo $player_hand['naam']; ?> \nLife: <? echo $player_hand['leven']; ?>/<? echo $player_hand['levenmax']; ?>");
          }
          else{
       	    $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").css({ backgroundImage : "url(images/pokemon/icon/<? echo strtolower($player_hand['wild_id']); ?>.gif)" });
            $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").attr("title", "<? echo $player_hand['naam']; ?> \nLife: <? echo $player_hand['leven']; ?>/<? echo $player_hand['levenmax']; ?>");
          }      
        }
        else if(1 == "<? echo $player_hand['ei']; ?>"){
          $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").css({ backgroundImage : "url(images/icons/egg.gif)" });
          $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").attr("title", "Egg");
          $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").show()
        }
        //Pokemon is not in fight, show.
        else{
          if(<? echo $player_hand['id']; ?> != ""){
            if(<? echo $player_hand['shiny']; ?> == 1){
              $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").css({ backgroundImage : "url(images/shiny/icon/<? echo strtolower($player_hand['wild_id']); ?>.gif)" });
              $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").attr("title", "<? echo $player_hand['naam']; ?> \nLife: <? echo $player_hand['leven']; ?>/<? echo $player_hand['levenmax']; ?>");
            }
            else{
         	    $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").css({ backgroundImage : "url(images/pokemon/icon/<? echo strtolower($player_hand['wild_id']); ?>.gif)" });
              $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").attr("title", "<? echo $player_hand['naam']; ?> \nLife: <? echo $player_hand['leven']; ?>/<? echo $player_hand['levenmax']; ?>");
            }
            $("div[id='change_pokemon'][name='<? echo $inhand; ?>']").show()
          }
        }
      });
  </script>
<?php
}
//Player Pokemon In Hand
mysql_data_seek($pokemon_sql, 0);
?>
<script type="text/javascript" src="attack/duel/javascript/duel.js"></script>
<script language="javascript">
var you_to_late
var opp_to_late
var ready_check
var attack
var wissel
var start_text
var max_time = 60
var you_time_used
var opp_time_used
var end
var you = "<?php echo $gebruiker['username']; ?>";

function your_to_late(){
  clearTimeout(you_to_late)
  $("#message").prepend("Bạn thua do không đánh.")
  setTimeout("show_end_screen();", 1000)
}

function you_check_to_late(){
  you_time_used++
  $("#time_left").html(max_time-you_time_used)
  if(you_time_used >= max_time) your_to_late()
  else you_to_late = setTimeout('you_check_to_late()', 1000)
}

function opponent_check_to_late(){
  opp_time_used++
  $("#time_left").html(max_time-opp_time_used)
  if(opp_time_used >= max_time) last_move_check()
  else opp_to_late = setTimeout('opponent_check_to_late()', 1000)
}

function do_wissel(request){
  if(request[5] == 1){
    $("#img_opponent").attr("src","images/shiny/"+request[3]+"<?php echo $geg1; ?>.gif")
    $("#opponent_star").show()
  }
  else{
    $("#img_opponent").attr("src","images/pokemon/"+request[3]+"<?php echo $geg1; ?>.gif")
    $("#opponent_star").hide()
  }
  var opponent_life_procent = Math.round((request[6]/request[7])*100)
  $("#opponent_life").width(opponent_life_procent+'%')
  $("#opponent_naam").html(request[4])
  if(request[8] != ""){
    $("#opponent_hand_"+request[8]).attr("src","images/icons/pokeball_black.gif")
    $("#opponent_hand_"+request[8]).attr("title","Dead")
  }
}

function last_move_check(){
  clearTimeout(you_to_late)
  $.get("attack/duel/last_move_check.php?duel_id="+<?php echo $duel_info['id']; ?>+"&sid="+Math.random(), function(data) {
    request = data.split(" | ")
    //No reaction
    if(request[0] == 0){
      setTimeout('last_move_check()', 1000)
      attack = 0
      wissel = 0
    }
    //You can to Attack
    else if(request[0] == 1){
      if(request[2] == "wissel"){
        do_wissel(request)
      }
      else{
        leven_verandering(request[3],'pokemon',request[4])
        $("div[id='change_pokemon'][name='"+request[6]+"']").attr("title", ""+request[5]+" \nLife: "+request[3]+"/"+request[4]+"");
      }
      clearTimeout(opp_to_late)
      $("#message").prepend(request[1])
      attack = 1
      wissel = 1
      you_time_used = request[9]
      you_check_to_late()
    }
    //Opponent Has to Attack
    else if(request[0] == 3){
      if(request[2] == "wissel"){
        do_wissel(request)
      }
      clearTimeout(opp_to_late)
      $("#message").prepend(request[1])
      attack = 0
      wissel = 0
      opp_time_used = request[9]
      opponent_check_to_late()
      setTimeout('last_move_check()', 1000)
    }
    //Player Has To Change
    else if(request[0] == 4){
      clearTimeout(opp_to_late)
      $("#message").prepend(request[1])
      leven_verandering(request[3],'pokemon',request[4])
      $("div[id='change_pokemon'][name='"+request[6]+"']").attr("title", ""+request[5]+" \nLife: "+request[3]+"/"+request[4]+"");
      attack = 0
      wissel = 1
      you_time_used = request[9]
      you_check_to_late()
    }
    //Opponent Was to Late
    else if(request[0] == 2){
      clearTimeout(opp_to_late)
      $("#message").prepend(request[1])
      end = setTimeout("show_end_screen();", 1000)
      $("#time_left").html("0")
      attack = 0
      wissel = 0
    }
    //Player lost
    else if(request[0] == 5){
      clearTimeout(opp_to_late)
      $("#message").prepend(request[1])
      $("#time_left").html("0")
      leven_verandering(request[3],'pokemon',request[4])
      end = setTimeout("show_end_screen();", 1000)
      attack = 0
      wissel = 0
    }
  });
}

function show_start_text(begin,your,opp,opp_life,you_link,opp_link,you_life,you_exp){
  clearTimeout(start_text)
  $("#img_you").attr("src",you_link)
  $("#img_opponent").attr("src",opp_link)
  $("#opponent_life").width(opp_life+'%')
  $("#pokemon_life").width(you_life+'%')
  $("#pokemon_exp").width(you_exp+'%')

  $("#you_naam").html("<?php echo $pokemon_info['naam_goed']; ?>")
  $("#you_level").html("<?php echo $pokemon_info['level']; ?>")
  $("#opponent_naam").html("<?php echo $opponent_info['naam_goed']; ?>")
  $("#you_text").show()
  if(begin == you+"_begin"){
    $("#message").prepend("bạn là người đầu tiên tấn công <Br>")
    attack = 1
    wissel = 1
    you_time_used = 0
    you_check_to_late()
  }

  else {
    $("#message").prepend("<?php echo $duel_info['opponent_name']?> tấn công trước")
    attack = 0
    wissel = 0
    last_move_check()
    opp_time_used = 0
    opponent_check_to_late()
  }
}

function check_ready(){
  $.get("attack/duel/duel-check-ready.php?duel_id="+<?php echo $duel_info['id']; ?>+"&sid="+Math.random(), function(data) {
    request = data.split(" | ")
    if(request[0] == 0){
      if(request[1] != "") $("#message").prepend(request[1])
      else ready_check = setTimeout("check_ready()", 1000)
    }
    else if(request[0] == 1){
      clearTimeout(ready_check)
      start_text = setTimeout("show_start_text(\'"+request[1]+"\',\'"+request[2]+"\',\'"+request[3]+"\',\'"+request[4]+"\',\'"+request[5]+"\',\'"+request[6]+"\',\'"+request[7]+"\',\'"+request[8]+"\');", 1000)
    }
    else ready_check = setTimeout("check_ready()", 1000)
  });
}

$("#message").ready(function() {
  if("<?php echo $_SESSION['duel']['begin_zien']; ?>" == 1) {
    $("#you_text").hide()
    if(you == "<?php echo $duel_info['tegenstander']; ?>"){
      $("#message").prepend("<?php echo $duel_info['uitdager']?> đã nhường bạn tấn công.")
      $("#opponent_naam").html("<?php echo $duel_info['opponent_name']; ?>.")    
    }

    else if(you == "<?php echo $duel_info['uitdager']; ?>"){
      $("#message").prepend("<?php echo $txt['you_invite_1'].' '.$duel_info['tegenstander'].' '.$txt['you_invite_2']; ?>")
      $("#opponent_naam").html("<?php echo $duel_info['opponent_name']; ?>.")
    }
    //Set Images
    $("#img_you").attr("src","images/you/back/<?php echo $duel_info['you_sex']; ?>.png")
    $("#img_opponent").attr("src","images/you/opponent/<?php echo $duel_info['opponent_sex']; ?>.png")
    $("#opponent_life").width('100%')
    $("#pokemon_life").width('100%')
    $("#pokemon_exp").width('0%')
    
    ready_check = setTimeout("check_ready()", 1000)
  }
  else if("<?php echo $duel_info['laatste_beurt']; ?>" == you+"_begin"){
    $("#message").prepend("đến lượt bạn tấn công.")
    attack = 1
    wissel = 1
    you_time_used = <?php echo $time_left; ?>;
    you_check_to_late()
  }
  else if ("<?php echo $duel_info['laatste_beurt']; ?>".match(/begin.*/)) {
    var who = "<?php echo $duel_info['laatste_beurt']; ?>".split("_",1);
    $("#message").prepend(who+" tấn công đầu.")
    attack = 0
    wissel = 0
    last_move_check()
    opp_time_used = <?php echo $time_left; ?>;
    opponent_check_to_late()
  }
  else if("<?php echo $duel_info['volgende_zet']; ?>" == "end_screen"){
    end = show_end_screen()
  }
  else if(("<?php echo $duel_info['volgende_beurt']; ?>" == you) && ("<?php echo $duel_info['volgende_zet']; ?>" == "wisselen")){
    $("#message").prepend("<?php echo $txt['change_now']; ?>")
    attack = 0
    wissel = 1
    you_time_used = <?php echo $time_left; ?>;
    you_check_to_late()
  }
  else if("<?php echo $duel_info['volgende_beurt']; ?>" == you){
    $("#message").prepend("đến lượt bạn")
    attack = 1
    wissel = 1
    you_time_used = <?php echo $time_left; ?>;
    you_check_to_late()
  }
  else if("<?php echo $duel_info['volgende_zet']; ?>" == "wisselen"){
    $("#message").prepend("<?php echo $duel_info['tegenstander'].' '.$txt['opponent_change']; ?>")
    attack = 0
    wissel = 0
    last_move_check()
    opp_time_used = <?php echo $time_left; ?>;
    opponent_check_to_late()
  }
  else{
    $("#message").prepend("đến lượt của <?php echo $duel_info['tegenstander']?> </br>")
    attack = 0
    wissel = 0
    last_move_check()
    opp_time_used = <?php echo $time_left; ?>;
    opponent_check_to_late()
  }
});

function show_end_screen(){
  clearTimeout(end)
  $.get("attack/duel/duel-finish.php?duel_id="+<?php echo $duel_info['id']; ?>+"&sid="+Math.random(), function(data) {
    request = data.split(" | ")
    document.getElementById('hit').style.display = "none";
		document.getElementById('hit2').style.display = "none";
    if(request[0] == 1){
      $("#message").prepend("bạn là người chiến thắng")
      if(request[1] > 0) $("#message").append("bạn thắng "+request[1]+"") 
     
      
    }
    else if(request[0] == 2){
      
      
    }
    $("#pokemon_text").hide()
    $("#trainer_naam").html(request[3])
    //Set Images
    $("#img_pokemon").attr("src","images/you/back/"+request[4]+".")
    $("#img_trainer").attr("src","images/trainers/"+request[5]+".png")
setTimeout(function(){
    node('/admin.php?ducnghia=pvp');
}, 3000);
  });
}

function attack_status_2(msg){
    	document.getElementById('hit').style.display = "none";
		document.getElementById('hit2').style.display = "none";
		document.getElementById('dame2').style.display = "none";
		document.getElementById('dame').style.display = "none";
		$('#img_computer_f').removeClass('eff_f2');
		$('#img_pokemon_f').removeClass('eff_f');
		$('#img_computer').removeClass('animated shake')
		$('#img_pokemon').removeClass('animated tada')
  request = msg.split(" | ")
  $("#pokemon_hp").html("HP "+request[3]+"/"+request[4]);
  $("#message").prepend(request[0])
  if(request[1] == 1){
    setTimeout('last_move_check()', 1000)
    opp_time_used = 0
    opponent_check_to_late() 
    attack = 0
    wissel = 0
    if(request[3] == 0) exp_change(request[6],request[7])
  }
  else if(request[1] == 2){
    exp_change(request[6],request[7])
    setTimeout("show_end_screen();", 1000)
  }

}

function attack_status(msg){
  request = msg.split(" | ")
  var time = 250
  if(request[2] < 25) time = 350
  else if(request[2] < 50) time = 350
  else if(request[2] < 100) time = 350
  else if(request[2] < 150) time = 350
  else if(request[2] < 200) time = 350
  else if(request[2] < 250) time = 350
  else if(request[2] >= 250) time = 350
      $("#pokemon_hp").html("HP "+request[3]+"/"+request[4]);

if(request[2]>-1) {

              $("#ducnghia_hp").html("- "+request[2]);

	if(request[9] == "u"){
	    $("#img_computer_f").addClass('eff_f2');
	
		document.getElementById('hit2').style.backgroundImage = 'url("'+request[8]+'")';
			document.getElementById('hit2').style.backgroundRepeat = "no-repeat";
			
	 $("#img_pokemon_f").addClass('eff_f');
		document.getElementById('dame').style.display = "";
        $("#dame").html("- "+request[2]);
        
         $('#img_computer').removeClass('animated slideInLeft');
		$('#img_pokemon').removeClass('animated slideInLeft');
		$('#img_pokemon').addClass('animated tada');
        
document.getElementById('hit').style.backgroundImage = 'url("'+request[8]+'")';
			document.getElementById('hit').style.backgroundRepeat = "no-repeat";		
			
			
		} else{
		    $("#img_pokemon_f").addClass('eff_f');
		document.getElementById('dame').style.display = "";
        $("#dame").html("- "+request[2]);
        
         $('#img_computer').removeClass('animated slideInLeft');
		$('#img_pokemon').removeClass('animated slideInLeft');
		$('#img_pokemon').addClass('animated tada');
        
document.getElementById('hit').style.backgroundImage = 'url("'+request[8]+'")';
			document.getElementById('hit').style.backgroundRepeat = "no-repeat";
			}
  }

  if(request[2] > 0) leven_verandering(request[3],'opponent',request[4])
  attack_timer = setTimeout("attack_status_2('"+msg+"');", time)
}

//Change Pokemon Function
function change_pokemon_status(msg){
  //Get php variables
  request = msg.split(" | ")
  //Send message
  $("#message").prepend(request[0])
  //Change was succesfull
  if(request[1] == 1){ 
    //Change Pokemon in fight name, level and attacks
    $("#pokemon_naam").html(request[2])
    $("#pokemon_level").html(request[3])
   
    
     $("div[id='aanval']:eq(0)").html(request[9]);
        $("div[id='aanval']:eq(1)").html(request[10]);
        $("div[id='aanval']:eq(2)").html(request[11]);
        $("div[id='aanval']:eq(3)").html(request[12]);
        	 document.getElementById("types1").style.backgroundImage = 'url(images/battle/move/' + request[16] + '.png)';
		document.getElementById("types2").style.backgroundImage = 'url(images/battle/move/' + request[17] + '.png)';
		document.getElementById("types3").style.backgroundImage = 'url(images/battle/move/' + request[18] + '.png)';
		document.getElementById("types4").style.backgroundImage = 'url(images/battle/move/' + request[19] + '.png)';

    //Create image for new pokemon in fight
    if(request[4] == 0){
      $("#img_you").attr("src","images/pokemon/back/" + request[15] + "<?php echo $geg; ?>.gif")
      $("#pokemon_star").hide()
    }
    else{
      $("#img_you").attr("src","images/shiny/back/" + request[15] + "<?php echo $geg; ?>.gif")
      $("#pokemon_star").show() 
    }
    //Show all pokemon in your hand
    $("div[id*='change_pokemon'][name*='1']").show()
    $("div[id*='change_pokemon'][name*='2']").show()
    $("div[id*='change_pokemon'][name*='3']").show()
    $("div[id*='change_pokemon'][name*='4']").show()
    $("div[id*='change_pokemon'][name*='5']").show()
    $("div[id*='change_pokemon'][name*='6']").show()
    //Hide the new pokemon that is in fight
    $("div[id*='change_pokemon'][name*='"+request[13]+"']").hide()
    //Change the HP Status from new pokemon in fight
    var pokemon_life_procent = Math.round((request[5]/request[6])*100)
    $("#pokemon_life").width(pokemon_life_procent+'%')
    //Change EXP Status from new pokemon in fight
    var exp_procent = Math.round((request[7]/request[8])*100)
    $("#pokemon_exp").width(exp_procent+'%')
          	  $("#pokemon_hp").html("HP "+request[3]+"/"+request[4]);

    //Opponent make next turn
    wissel = 0
    if(request[14] == you){
      attack = 1
      you_time_used = 0;
      you_check_to_late()
    }
    else{
      attack = 0
      setTimeout('last_move_check()', 1000)
      opp_time_used = 0
      opponent_check_to_late()
    }
  }
}

//Player Can Do Stuff
$(document).ready(function(){
  //Player Do Attack

  $("div[id='aanval']").click(function(){
	    if(attack == 1){
        if($(this).html() != ""){
          attack = 0
		  document.getElementById('hit2').style.display = "none";
$('#img_opponent').removeClass('animated slideInLeft');
				$('#img_pokemon').removeClass('animated slideInLeft');
				$('#img_opponent').addClass('animated shake');
    			$("#message").prepend($("#pokemon_naam").html()+ " Sử dụng kĩ năng <b>"+$(this).html()+"</b> ,<big><b><font color='green'><?php echo $computer_info['naam_goed'] ?></font> Mất <font color='red'><span id='ducnghia_hp'>0</span>HP</font></big></b><br>.")
    			$("#potion_screen").hide()
    			//alert($(this).html())
				document.getElementById('hit').style.display = "";
    			$.ajax({
    			  type: "GET",
  			  url: "attack/duel/duel-do_attack.php?attack_name="+$(this).html()+"&wie="+you+"&duel_id="+<?php echo $duel_info['id']; ?>+"&sid="+Math.random(),
    			  success: attack_status
    			}); 
  			}
  		}
    });
  
  
  //Player Make Change Pokemon
  $("div[id='change_pokemon']").click(function(){
    if(wissel == 1){
      if(($(this).attr("name") != "") && (($(this).attr("title")) != "Egg") && (($(this).attr("title")) != "")){
        clearTimeout(you_to_late)
        $.ajax({
          type: "GET",
          url: "attack/duel/duel-change-pokemon.php?opzak_nummer="+$(this).attr("name")+"&wie="+you+"&duel_id="+<?php echo $duel_info['id']; ?>+"&sid="+Math.random(),
          success: change_pokemon_status
        }); 
      }
    }
  });
});


/// chaxbox


</script>
<style>.battle_area {     background-image: url('img/battle/duel-area.png'); width: 676px; height: 402px; }
		.timing { padding:10px; margin:10px; background-color:#eee; border:2px solid #444; border-radius:5px; width:300px; }
		.timing_font { font-family: "Impact";font-size:26px; }</style>
		 <style>#table_fight_b {
	background-size: cover;
	min-height: 200px;
	margin: 0 auto;
}</style>
 <style>
  .ducnghiaskill {
    font-size: 18px;
    text-align: right;
    padding: 5px 8px 0px 0px;
    color: #333;
    cursor: pointer;
}
  .attack-name:hover {
    font-weight: bold;
}
.statbar {
	width: 120px;
	min-height: 40px;
	padding: 2px 4px;
}
.statbar .hpbar {
    position: relative;
    border: 1px solid #777;
    background: #fcfeff;
    padding: 1px;
    height: 8px;
    margin: 0;
    width: 101px;
    border-radius: 4px;
}
.statbar .hpbar .prevhp {
    background: #bec;
    height: 8px;
    border-radius: 3px;
}
.statbar .hpbar .hp {
    height: 4px;
    border-top: 2px solid #00dd60;
    background: #00bb51;
    border-bottom: 2px solid #007734;
    border-right: 1px solid #007734;
    border-radius: 3px;
}
.statbar .status {
    min-height: 10px;
    font-size: 7pt;
}
.opacity_0 {
	position: absolute;
	max-width: 550px;
	margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
}
#myVideo {
width:100%;
height:100%;
max-width: 550px;
max-height:200px;
opacity: 0.5;
object-fit: fill;
}
</style>
  
	<center>
	<div class="timing">
 Lượt : <br/>
	<span class="timing_font" id="time_left"></span> Giây
	</div>
	<div class="sep"></div>
	<div class="blue"><a onclick="pk()"><i class="fa fa-refresh"></i><font color="red"><b class=viptxt>Ấn vào đây</b></font></a> nếu không hiện pokemon.</div></center>
<center>
<div id="ducnghia_an">
  
	<a href="javascript:info(<?=$computer_info['wild_id'];?>);">
 <img src="/pokedex.png"> </a>
  <table id="table_fight_b" <?php if ($aanval_log['gebied'] == "Gras") {?>class="battlearea1"
  <?php } else if($aanval_log['gebied'] == "Water") {?>
  class="battlearea2"<?php } else if($aanval_log['gebied'] == "Strand") {?>class="battlearea3" <?php } 
  else if($aanval_log['gebied'] == "Grot") {?>class="battlearea4" <?php }
  else if($aanval_log['gebied'] == "Lavagrot") {?>class="battlearea5" <?php }
  else if($aanval_log['gebied'] == "Vechtschool") {?>class="battlearea6" <?php }
  else if($aanval_log['gebied'] == "Spookhuis") {?>class="battlearea7" <?php }
  else {?>class="battlearea1"<?php } ?>>
               <center>
 
    <tr><td>
        			<div class="statbar lstatbar animated fadeInRight" style="display: block;left: 130px;top: 120px;opacity: 1;" id="ducnghia_die">

				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><?php echo $opponent_info['naam_goed'] ?><span id='opponent_star' style='display:none;'></span> LV:<?=$opponent_info['level'] ?> </font></strong></small>
				<div class="hpbar">
					<div class="prevhpa" style="width: <?=$opponent_life_procent?>px;">
						<div class="hp"  id="opponent_life" style="width: <?=$opponent_life_procent?>%; border-right-width: 1px;"></div>
					</div>
					<div class="status"></div>
					 (<?php
		  $opponent_pok = mysql_query("SELECT psg.id, psg.leven FROM gebruikers AS g INNER JOIN pokemon_speler_gevecht AS psg ON g.user_id = psg.user_id INNER JOIN pokemon_speler AS ps ON psg.id = ps.id WHERE g.username='".$duel_info['opponent_name']."' AND psg.duel_id='".$duel_info['id']."' ORDER BY ps.opzak_nummer");
      while($opponent_pokemon = mysql_fetch_array($opponent_pok)){
        if($opponent_pokemon['leven'] > 0) echo '<img id="opponent_hand_'.$opponent_pokemon['id'].'" src="./images/icons/pokeball.gif" width="14" height="14" alt="Alive" title="Alive" />';
        else echo '<img id="opponent_hand_'.$opponent_pokemon['id'].'" src="./images/icons/pokeball_black.gif" width="14" height="14" "Dead" title="Dead" />';
      }
      ?>)
				</div>
			</div>
			</td>

			<td>
				<div align="center" id="dame" style="display:none;"></div>
				<div id="img_computer_f">
                <img class="animated slideInLeft" id="img_opponent" src="images/<? echo $opponent_info['map']."/".$opponent_info['wild_id']; ?>.gif" style="padding: 20px 0px 0px 50px;max-width: 50%;height:auto;max-height:100px"/></div> 
            </td></tr>
			<tr>
			<td> 
				<div class="infront" align="center" id="hit" style="display:none;"></div>
				<div class="inback" align="center" id="hit2" style="display:none;"></div>
				<div align="center" id="dame2" style="display:none;"></div>

                <div id="img_pokemon_f"><center><img class="animated slideInLeft" id="img_you" src="images/<? echo $pokemon_info['map']; ?>/back/<? echo $pokemon_info['wild_id']; ?>.gif" style="padding: 10px 0 0 10px;max-height:100px"/></center></div>
                
               
                
            </td>
			<td>
			<div class="statbar rstatbar animated fadeInLeft" style="display: block; left: 350px; top: 24px; opacity: 1;">
				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><span id="pokemon_naam"><? echo $pokemon_info['naam_goed']; ?></span><span id="pokemon_star" style="display:none;"></span><br/><span id="pokemon_hp" style="padding:0px 0 0px 5px;">HP: <? echo $pokemon_info['leven']; ?>/<? echo $pokemon_info['levenmax']; ?> </span> LV.<? echo $pokemon_info['level']; ?>
				</font></strong></small>
				<div class="hpbar">
					<div class="prevhpa" style="width: <?php echo $pokemon_life_procent; ?>px;">
						<div class="hp" id="pokemon_life" style="width: <?php echo $pokemon_life_procent; ?>%; border-right-width: 1px;"></div>
					</div>
					
					
					<div class="status"></div>
				</div>
				<div><div class="exp_blue">
				<div class="progress" id="pokemon_exp" style="width:  <?php echo $pokemon_exp_procent; ?>%"></div>
				</div></div>
			</div>	
			</td>
			</tr>
	</table>
 
		  
<center>
<div class="text-box-ok">
	<div class="text-box"><div style="padding: 10px;" id="message" align="center"></div></div>
</div></center>
   
   
   
   
	<script type="text/javascript" src="/attack/ducnghia.js?<?=rand(1,100000)?>"></script>
	<link href="/ducnghia/ducnghia.css" rel="stylesheet" type="text/css"/>
  <big>	<table  cellpadding=0 cellspacing=0>
		<td id="menus" width="100%">
									<img id="attack" src="images/battle/ui/attack.png" style="cursor: pointer;width: 45%;max-width: 150px;"/>
					<img id="chagepokemon" src="images/battle/ui/pokemon.png" style="cursor: pointer;width: 45%;max-width: 150px;"/><br/>
					<img id="bag" src="images/battle/ui/bag.png" style="cursor: pointer;width: 45%;max-width: 150px;"/>
					<img id="run" src="images/battle/ui/run.png" style="cursor: pointer;width: 45%;max-width: 150px;"/>
										
				</td>
						   <?php 
					   $skill1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_1']."'"));
					     $skill2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_2']."'"));
					      $skill3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_3']."'"));
					       $skill4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_4']."'"));

					$ducnghia_skill_1 = 100 - $skill1['mis'];
										$ducnghia_skill_2 = 100 - $skill2['mis'];
					$ducnghia_skill_3 = 100 - $skill3['mis'];
					$ducnghia_skill_4 = 100 - $skill4['mis'];


					    ?>		
			<td id="menu1" width="100%" style="display:none">
                    <table width="100%">
							<td style="float:right;"><a  title='Quay lại'><img id="back" src="images/battle/ui/back.png" align="top" style="cursor: pointer;"/></a></td>
					</table>	
					<table width="100%" align="center">
					<tr>
					 
						<td>
							<div id="types1" style="background: url('images/battle/move/<?=$skill1['soort']?>.png');background-repeat: no-repeat;background-size:100%;width: 120px;height: 45px;margin-left: 5px;">
								<div id="aanval" class="attack-name s1"><? echo $pokemon_info['aanval_1']; ?></div>
							<div class="attack-pp pp1"></div>
							</div>
						</td>
						<td>
							<div id="types2" style="background: url('images/battle/move/<?=$skill2['soort']?>.png');background-repeat: no-repeat;background-size:100%;width: 120px;height: 45px;margin-left: 5px;">
								<div id="aanval" class="attack-name s2"><? echo $pokemon_info['aanval_2']; ?></div>
								<div class="attack-pp pp2">	</div>
							</div>
						</td>
						</tr>
						<tr>
						<td>
							<div id="types3" style="background: url('images/battle/move/<?php echo $skill3['soort']?>.png');background-repeat: no-repeat;background-size:100%;width: 120px;height: 45px;margin-left: 5px;">
								<div id="aanval" class="attack-name s3"><? echo $pokemon_info['aanval_3']; ?></div>
								<div class="attack-pp pp3">	</div>
							</div>
						</td>
						<td>
							<div id="types4" style="background: url('images/battle/move/<?=$skill4['soort']?>.png');background-repeat: no-repeat;background-size:100%;width: 120px;height: 45px;margin-left: 5px;">
								<div id="aanval" class="attack-name s4"><? echo $pokemon_info['aanval_4']; ?></div>
								<div class="attack-pp pp4">	</div>
							</div>
						</td>
						</tr>
                    </table>
                </td>
				<td id="menu2" width="100%" style="display:none">
					<table width="100%">
						<td style="float:right;"><a  title='Quay lại'><img id="back2" src="images/battle/ui/back.png" align="top" style="cursor: pointer;"/></a></td>
					</table>
					<table width="100%">
					<tr>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="1" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="2" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="3" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
						
					</tr>
					<tr>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="4" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="5" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
						<td>
							<div class="pokemon_change">
								<div id="change_pokemon" name="6" title="" style="display:none; background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;" /></div>
							</div>
						</td>
					</tr>
					</table>
				</td>
				<td id="menu3" width="100%" style="display:none">
					<table width="100%">
						<td style="float:right;"><a title='Quay lại'><img id="back3" src="images/battle/ui/back.png" align="top" style="cursor: pointer;"/></a></td>
					</table>
					<table width="100%">
					    <?php
					$sql2 = mysql_query("SELECT `naam`, `wat` FROM `items` WHERE (`wat` = 'pokeball' OR `wat` = 'potion' OR `wat` = 'run')");
                    
           
                
                    //Als eerste Kies weergeven
                    $itemm[0] = "Choose";
                    $item2[0] = "Choose";
                
                    //Items opbouwen.
                    for($i=1; $items = mysql_fetch_array($sql2); $i++){
                      //Makkelijk naam toewijzen
                      $naamm = $items['naam'];
                      //Als de gebruiker er wel 1 van heeft dan weergeven,
                      if($gebruiker[$naamm] > 0){ 
                        $itemm[$i] = $naamm." (".$gebruiker[$naamm].")";
                        if($naamm == "Bike") $itemm[$i] = $naamm;
                        $item2[$i] = $naamm;
                        $style[$i] = "white";
                      }
                      else{
                        $itemm[$i] = $naamm."(0)";
                        $item2[$i] = $naamm;
                        $style[$i] = "silver";
                        $disabled[$i] = "disabled";
                      }
                      $title[$i] = ucfirst($items['wat']);
                    }
                
                    //Laten zien in keuze lijst.
                    echo '<select id="item" class="text_select" onChange="if(this.options[this.selectedIndex].state==\'disabled\') this.selectedIndex=0">';    
                  		for ($i = 0; $i < sizeof($item2); $i++) {
                  			echo '<option title="'.$title[$i].'" value="'.$item2[$i].'" name='.$i.' style="background-color:'.$style[$i].';" state='.$disabled[$i].' class="balk_zwart">'.$itemm[$i].'</option>';
                  		}
                  	echo ' </select>';
                    ?></td>
                <tr>
                  <td><button id="use_item" class="button">Sử Dụng</button></td>
                </tr>
					</table>
				</td>
			</table>
			<table id="potions_screen" class="potions" cellpadding=0 cellspacing=0 border=0>
												
			</table>
			
													
			</table>
</div>
    
    </div>		



  </center>
 
<?php
//Page Completly loaded, Player Ready
mysql_query("UPDATE `duel` SET `".$duel_info['you_duel']."`='1' WHERE `id`='".$duel_info['id']."'");
?>