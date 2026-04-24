<?PHP
include_once('../templates/config.php'); 
include_once('../templates/ducnghia.php'); 


 ?>
 <script type="text/javascript" src="/attack/ducnghia.js?<?=rand(1,100000)?>"></script>
	<link href="/ducnghia/ducnghia.css" rel="stylesheet" type="text/css"/>
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
 
#hit {position:absolute;left:260px;top:50px;z-index:9999;}

#hit2 {position:absolute;left:105px;top:200px;z-index:9999;}



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
 
<?PHP
//Load Safety Script
//Load language
$page = 'attack/trainer/trainer-attack';
//Goeie taal erbij laden voor de page
include_once('../language/language-pages.php');
//Include Attack Functions
include("../attack/attack.inc.php");



$aanval_log = aanval_log($_SESSION['trainer']['aanval_log_id']);
$trainer = mysql_fetch_array(mysql_query("SELECT * FROM `trainer` WHERE `naam`='".$aanval_log['trainer']."'"));

if(empty($trainer['badge']) and $trainer['id'] != '138' and !$_SESSION['pk_dt'] ){
  $return_link = "/_nodejs/huanluyen.php";
  $gym = 1;
    $class = 'dauhl';

} 
else if(!empty($trainer['badge'])){
       $class = 'daugym';

  $return_link = "/_nodejs/gym.php";
  $gym = 0;
} else {
      $gym = 1;

   $class = 'pkboss';
   $return_link = "/admin.php?ducnghia=boss";       
}



//Player in log is diffirent then loggedin
if($aanval_log['user_id'] != $_SESSION['id'])
{
  //End Attack
  remove_attack($aanval_log['id']);
  //Send back to home
  unset($_SESSION['trainer']['duel_id']);
}
else
{
  //Load All Openent Info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  //Make all letters small
  $computer_info['naam_klein'] = strtolower($computer_info['naam']);
  //Change name for male and female
  $computer_info['naam_goed'] = computer_naam($computer_info['naam']);
  
  //Calculate Life in Procent for Computer         
  if($computer_info['leven'] != 0) $computer_life_procent = round(($computer_info['leven']/$computer_info['levenmax'])*100);
  else $computer_life_procent = 0;
  
  //Shiny
  $computer_info['map'] = "pokemon";
  $computer_info['star'] = "none";
  if($computer_info['shiny'] == 1){
    $computer_info['map'] = "shiny";
    $computer_info['star'] = "block";
  }
  
  //Load All Pokemon Info
  $pokemon_info = pokemon_data($aanval_log['pokemonid']);
  $pokemon_info['naam_klein'] = strtolower($pokemon_info['naam']);
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);
  
  //Calculate Life in Procent for Pokemon         
  if($pokemon_info['leven'] != 0) $pokemon_life_procent = round(($pokemon_info['leven']/$pokemon_info['levenmax'])*100);
  else $pokemon_life_procent = 0;
  
  //Calculate Exp in procent for pokemon
  if($pokemon_info['expnodig'] != 0) $pokemon_exp_procent = round(($pokemon_info['exp']/$pokemon_info['expnodig'])*100);
  else $pokemon_exp_procent = 0;
  
  //Shiny
  $pokemon_info['map'] = "pokemon";
  $pokemon_info['star'] = "none";
  if($pokemon_info['shiny'] == 1){
    $pokemon_info['map'] = "shiny";
    $pokemon_info['star'] = "block";
  }
  
  ?>
  <script language="javascript">
  var speler_attack
  var timer
  var next_turn_timer
  var attack_timer = 0
  var speler_wissel
  
  //If div is ready
  $("#message").ready(function() {
    //Show Starting Screen
    if((("<? echo $aanval_log['laatste_aanval']; ?>" == "spelereersteaanval") || ("<? echo $aanval_log['laatste_aanval']; ?>" == "computereersteaanval")) && ("<? echo $_SESSION['trainer']['begin_zien']; ?>" == 1)) {
      //Set Images
      $("#img_pokemon").attr("src","/img/loadlightbox.gif")
      $("#img_trainer").attr("src","/img/loadlightbox.gif")
      setTimeout("show_start_text();", 1000)
      $("#message").html("<? echo $txt['start_0'].$aanval_log['trainer'].$txt['start_1']; ?>")
      $("#pokemon_text").hide()
      $("#trainer_naam").html("<? echo $aanval_log['trainer']." ".$txt['appears']; ?>.")
      $.nghia({
        type: "GET",
        url: "/attack/trainer/trainer-stop-start.php"
      });     
    }
    //Write Start Text
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "spelereersteaanval"){
      speler_attack = 1
      $("#message").html("<?php echo $txt['you_first_attack']; ?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "computereersteaanval"){
      speler_attack = 0
      speler_wissel = 0;
      $("#message").html("<? echo $computer_info['naam_goed'].' '.$txt['opponent_first_attack']; ?>")
      next_turn()
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "pokemon"){
      speler_attack = 0
      next_turn()
      $("#message").html("<? echo $computer_info['naam_goed'].' '.$txt['opponents_turn']; ?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "computer"){
      speler_attack = 1
      $("#message").html("<?php echo $txt['your_turn']; ?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "speler_wissel"){
      speler_attack = 0
      speler_wissel = 1
      $("#message").html("<? echo $pokemon_info['naam_goed'].' '.$txt['have_to_change']; ?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "trainer_wissel"){
      speler_attack = 0
      speler_wissel = 0
      $("#message").html("<? echo $computer_info['naam_goed'].' '.$txt['opponent_have_to_change_1'].' '.$aanval_log['trainer'].' '.$txt['opponent_have_to_change_2']; ?>")
      trainer_change()
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "klaar"){
      speler_attack = 1
      $("#message").html("<?php echo $txt['fight_finished']; ?>")
 dong_huanluyen();      setdrawn(0,0,'kết thúc...',0,0);
  }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "end_screen")
	{
      speler_attack = 0
      speler_wissel = 0
      show_end_screen()
    }
    else
	{
      c_attack();
         setdrawn(0,0,'Vui lòng tới bệnh viện.',0,0);


    } 
  });     
  </script>
  <?

  //Player Pokemon In Hand
  for($inhand = 1; $player_hand = mysql_fetch_assoc($pokemon_sql); $inhand++){
    //Check Wich Pokemon is infight
    if($player_hand['id'] == $pokemon_info['id']) $infight = 1;
    else $infight = 0;
    if($player_hand['ei'] == 1)
	{ 
      $player_hand['naam'] = "??";
      $player_hand['wild_id'] = "??";
    }
    ?>

    <script>
      //If div is ready
      $("div[id='change_pokemon']").ready(function() 
	  {
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
        else if("Ja" == "<? echo $player_hand['baby']; ?>"){
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
    <?
  } 
  //Set Player hand query counter on 0
  mysql_data_seek($pokemon_sql, 0);
  ?>
  <script type="text/javascript" src="/attack/javascript/attack.js"></script>
  <script language="javascript">
   
  function show_start_text(){
    $("#img_pokemon").attr("src","images/<? echo $pokemon_info['map']; ?>/back/<? echo $pokemon_info['wild_id']; ?>.gif");
    $("#img_trainer").attr("src","images/<? echo $computer_info['map']; ?>/<? echo $computer_info['wild_id']; ?>.gif");
    $("#pokemon_naam").html("<? echo $pokemon_info['naam_goed']; ?>")
    $("#pokemon_level").html("<? echo $pokemon_info['level']; ?>")
    $("#trainer_naam").html("<? echo $computer_info['naam_goed']; ?>")
    $("#pokemon_text").show()
    if("<? echo $aanval_log['laatste_aanval']; ?>" == "spelereersteaanval"){
      speler_attack = 1
      speler_wissel = 1
      $("#message").html("<?php echo $txt['you_first_attack']; ?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "computereersteaanval")
	{
      speler_attack = 0
      speler_wissel = 0;
      $("#message").html("<? echo $computer_info['naam_goed'].' '.$txt['opponent_first_attack']; ?>")
      next_turn()
    }
  }
  
  function show_end_screen(id){
    $.get("/attack/trainer/trainer-finish.php?aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(), function(data) {
      request = data.split(" | ")
       document.getElementById('hit').style.display = "none";
		document.getElementById('hit2').style.display = "none";
      if(request[4] == 1){
        if(request[0] == "") $("#message").html("<? echo $txt['defeated_1'].' '.$aanval_log['trainer'].' '.$txt['defeated_2']; ?>"+request[1]+" Silver.")
        else if(request[2] == "1") $("#message").html("<? echo $txt['defeated_1'].' '.$aanval_log['trainer'].' '.$txt['defeated_masterball']; ?>"+request[1]+" Ruby.")
        else $("#message").html("<? echo $txt['defeated_1'].' '.$aanval_log['trainer'].' '.$txt['get_badge_1']; ?> "+request[0]+" <?php echo $txt['get_badge_2']; ?> "+request[1]+" Ruby.")
        
        $("#message").append(request[3])
        $("#trainer_"+id).attr("src","images/icons/pokeball_black.gif")
      }
      else{
        $("#message").html("<? echo $aanval_log['trainer'].' '.$txt['has_defeated_you_1']; ?>")
        if(request[1] > 0) $("#message").append("<?php echo $txt['has_defeated_you_2']; ?> "+request[1]+" Silver. ")
        $("#message").append("<?php echo $txt['has_defeated_you_3']; ?>")
      }
      $("#pokemon_text").hide()
      $("#trainer_naam").html("<? echo $aanval_log['trainer']; ?>.")
      //Set Images
      $("#img_pokemon").attr("src","images/you/back/<? echo $gebruiker->character; ?>.png")
      $("#img_trainer").attr("src","images/trainers/<? echo $aanval_log['trainer']; ?>.png")
          setdrawn(0,0,'Chiến thắng',0,0);

 dong_huanluyen();    });
  }
  
  //Change attack status
  function attack_status(msg){
    request = msg.split(" | ")
        
    var time = 250
    
    if(request[7] < 25) time = 500
    else if(request[7] < 50) time = 800
    else if(request[7] < 100) time = 900
    else if(request[7] < 150) time = 1100
    else if(request[7] < 200) time = 1200
    else if(request[7] < 250) time = 1500
    else if(request[7] >= 250) time = 1800
    if(request[12]=="normal") {
			        request[12] = "normal2";
			    }
		if(request[4] == "pokemon"){
	
 $("#img_computer_f").addClass('eff_f2');
		document.getElementById('dame2').style.display = "";
        $("#dame2").html("- "+request[7]);
	
			   
			    			    $("#hit2").addClass(''+request[12]+'');		
		
		} else {
	 $("#img_pokemon_f").addClass('eff_f');
		document.getElementById('dame').style.display = "";
        $("#dame").html("- "+request[7]);
			    			    $("#hit").addClass(''+request[12]+'');
		}
      
    if(request[5] == 1) leven_verandering(request[2],request[4],request[3])
    attack_timer = setTimeout("attack_status_2('"+msg+"');", time)
  }
   
  
  function attack_status_2(msg){
     clearTimeout(attack_timer)
	$("#hit2").removeClass();
			   $("#hit").removeClass();
	document.getElementById('dame2').style.display = "none";
	document.getElementById('dame').style.display = "none";
	$('#img_trainer').removeClass('animated');
	$('#img_pokemon').removeClass('animated');
	$('#img_computer_f').removeClass('eff_f2');
	$('#img_pokemon_f').removeClass('eff_f');
	$('#img_trainer').removeClass('shake');
	$('#img_pokemon').removeClass('tada');
    request = msg.split(" | ")
	
      
      
    $("#message").html(request[0])
    if(request[4] == "pokemon"){
      life_procent = Math.round((request[2]/request[3])*100)
      $("#"+request[8]+"_life").width(life_procent + '%')
      $("#"+request[8]+"_leven").html(request[2])
      $("#"+request[8]+"_leven_max").html(request[3])
      $("div[id='change_pokemon'][name='"+request[9]+"']").attr("title", "<? echo $pokemon_info['naam']; ?> \nLife:"+request[2]+"/"+request[3]+"");
    }
    
    if(request[4] == "pokemon"){
      if(request[6] == 1) setTimeout("show_end_screen();", 2000)
      else if(request[2] == 0) speler_wissel = 1
      else{
        speler_attack = 1
        speler_wissel = 1
      }
    }
    else if(request[4] == "computer"){
      speler_attack = 0
      speler_wissel = 0
      if(request[2] == 0){
        exp_change(request[10],request[11])
        if(request[6] == 0){ 
          next_turn_timer = setTimeout('trainer_change()', 1000)
        }
        else if(request[6] == 1){
          $("#trainer_"+request[8]).attr("src","images/icons/pokeball_black.gif")
          setTimeout("show_end_screen();", 1000)
        }
      }
      else if(request[1] == 1) next_turn()
    } 
  }
  
  //Change Pokemon Function
  function change_pokemon_status(msg){
    //Get php variables
    request = msg.split(" | ")
    //Send message
    $("#message").html(request[0])
    //Stop Life Change 
    clearTimeout(timer);
    //Change was succesfull
    if(request[1] == 1){
      //Change Pokemon in fight name, level and attacks
      $("#pokemon_naam").html(request[3]);
        $("#pokemon_level").html(request[4]);
        $("div[id='aanval']:eq(0)").html(request[5]);
        $("div[id='aanval']:eq(1)").html(request[6]);
        $("div[id='aanval']:eq(2)").html(request[7]);
        $("div[id='aanval']:eq(3)").html(request[8]);
        
	 	$("#types1").attr("src","/img/type/"+request[16]+".png");
		$("#types2").attr("src","/img/type/"+request[17]+".png");
		$("#types3").attr("src","/img/type/"+request[18]+".png");

		$("#types4").attr("src","/img/type/"+request[19]+".png");
      //Create image for new pokemon in fight
      if(request[14] == 1){
        var map = "shiny"
        $("#pokemon_star").show() 
      }
      else
	  {
        var map = "pokemon"
        $("#pokemon_star").hide()  
      }
      $("#img_pokemon").attr("src","images/"+map+"/back/" + request[15] + ".gif")
      //Show all pokemon in your hand
      $("div[id*='change_pokemon'][name*='1']").show()
      $("div[id*='change_pokemon'][name*='2']").show()
      $("div[id*='change_pokemon'][name*='3']").show()
      $("div[id*='change_pokemon'][name*='4']").show()
      $("div[id*='change_pokemon'][name*='5']").show()
      $("div[id*='change_pokemon'][name*='6']").show()
      //Hide the new pokemon that is in fight
      $("div[id*='change_pokemon'][name*='"+ request[9] +"']").hide()
      //Change the HP Status from new pokemon in fight
      var pokemon_life_procent = Math.round((request[10]/request[11])*100)
      $("#pokemon_life").width(pokemon_life_procent+'%')
      //Change EXP Status from new pokemon in fight
      var exp_procent = Math.round((request[12]/request[13])*100)
      $("#pokemon_exp").width(exp_procent+'%')
      //Computer make next turn
      if(request[2] == 1){
        speler_attack = 0
        speler_wissel = 0
        next_turn()
      }
      else{
        speler_attack = 1
        speler_wissel = 1
      }
    }
  }
  
  //Use item function
  function use_item_status(msg)
  {
    //Get php variables
    request = msg.split(" | ")
    //Send message
    $("#message").html(request[0])
    //change amount of item
    var option = $("option[title="+request[5]+"][name="+request[3]+"]")
    //Set New Amount
    var amount = request[2]
    //If Amount is smaller than 1, amount -> 0
    if(request[2] < 1) {
      amount = 0;
      option.css({ backgroundColor : "silver" })
    }
    //Change tekst
    option.html(option.val() + " ("+amount+")") 
    //It was a potion
    if(request[5] == "Potion"){
      //The pokemon in fight life has to change
      if(request[8] == 1) leven_verandering(request[6],'pokemon',request[7])
      //Potion screen has to go away
      $("#potion_screen").hide()
      //Calculate new life for pokemon
      var green = Math.round(request[6]/request[7]*100);
      //Set new life for potion screen
      $("#"+request[11]+"_green").width(green + 'px')
      $("#"+request[11]+"_red").width(100-green + 'px')
      $("#"+request[11]+"_leven").html(request[6])
      //Change pokemon change field title
      $("div[id=change_pokemon][name="+request[9]+"]").attr("title", request[10] + " \nLife: " + request[6] + "/" + request[7])
      //Computer make next turn
      if(request[1] == 1){
        speler_attack = 0
        speler_wissel = 0
        next_turn()
      }
    }
    else if(request[5] == "Pokeball"){
      speler_attack = 0
      speler_wissel = 0
      //Computer make next turn
      if(request[1] == 1) next_turn()
      //Attack finished
      else { dong_huanluyen();     setdrawn(0,0,'Trận chiến đã kết thúc',0,0);
}
    }
  }
  
  //Try To Run Function
  function attack_run_status(msg){
    //Get php variables
    request = msg.split(" | ")
     //Send message
    $("#message").html(request[0])
    if(request[1] == 1) { dong_huanluyen();     setdrawn(0,0,'Chạy trốn thành công.',0,0);
 }
    //Computer make next turn
    if(request[1] == 0){
      speler_attack = 0
      speler_wissel = 0
      next_turn()
    }
  }
  
  function trainer_change_pokemon(msg){
    request = msg.split(" | ")
    $("#message").html(request[0])
    $("#trainer_naam").html(request[1])
    $("#img_trainer").attr("src","images/pokemon/" + request[6] + ".gif")
    var computer_life_procent = Math.round((request[3]/request[2])*100)
    $("#computer_life").width(computer_life_procent+'%')
    $("#trainer_"+request[5]).attr("src","images/icons/pokeball_black.gif")
    $("#trainer_"+request[5]).attr("title","Dead")
    if(request[4] == 1) next_turn()
    else{
      speler_attack = 1
      speler_wissel = 1
    }
  }
  
  //Make Computer Do Attack
  function next_turn(){
    clearTimeout(next_turn_timer)
    next_turn_timer = setTimeout('computer_attack()', 1000)
  }
  
  //Player Can Do Stuff
  $(document).ready(function(){
    //Player Do Attack
    $("div[id='aanval']").click(function(){
	    if(speler_attack == 1){
        if($(this).html() != ""){
                  	  speler_attack = 0
		$('#img_trainer').removeClass('animated slideInLeft');
		$('#img_pokemon').removeClass('animated slideInLeft');
		  $('#img_trainer').addClass('animated shake');
		
		
		
				$('#attack_effect').insertAfter('#img_trainer');
    			$("#message").prepend($("#pokemon_naam").html()+" Dùng kỹ năng: "+$(this).html()+".<br/>")
    			$("#potion_screen").hide()

    			$.nghia({
    			  type: "GET",
    			  url: "/attack/trainer/trainer-do_attack.php?attack_name="+$(this).html()+"&wie=pokemon&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
    			  ducnghia: attack_status
    			}); 
  			}
  		}
    });
      
    //Player Make Change Pokemon
    $("div[id='change_pokemon']").click(function(){
      if(speler_wissel == 1){
        if(($(this).attr("name") != "") && ($(this).attr("title")) != "Egg"){
           $("#hit2").removeClass();
			   $("#hit").removeClass();
          $("#potion_screen").hide()
          $.nghia({
            type: "GET",
            url: "/attack/attack_change_pokemon.php?opzak_nummer="+$(this).attr("name")+"&computer_info_name=<? echo $computer_info['naam']; ?>&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
            ducnghia: change_pokemon_status
          }); 
        }
      }
    });
    
    //Player Using Item
    $("button[id='use_item']").click(function(){
      if(speler_attack == 1){
        if($('#item').val() == "Kies") $("#message").html("<?php echo $txt['no_item_selected']; ?>")
        $("#item_name").html($('#item').val())
        $("#message").html()
        $("#potion_screen").show()
      }
    });
    
    //Player is Using Potion
    $("button[id='use_potion']").click(function(){
      if(speler_attack == 1){
        if($("input[name='potion_pokemon_id']:checked").val() == undefined) $("#message").html("<?php echo $txt['potion_no_pokemon_selected']; ?>")
        else{   
          $.nghia({
            type: "GET",
            url: "/attack/attack_use_potion.php?item="+$("#item_name").html()+"&computer_info_name=<? echo $computer_info['naam']; ?>&option_id="+$('#item :selected').attr("name")+"&potion_pokemon_id="+$("input[name='potion_pokemon_id']:checked").val()+"&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
            ducnghia: use_item_status
          });
          $("#potion_screen").hide()
        }
      }
    });
  });

  //Computer Do Attack
  (function($){
    computer_attack = function() {
      if(speler_attack == 0){
        $("#message").html("<?php echo $txt['busy_with_attack']; ?>")
         $("#potion_screen").hide()
        $('#img_computer').removeClass('animated slideInLeft');
		$('#img_pokemon').removeClass('animated slideInLeft');
		$('#img_pokemon').addClass('animated tada');

        $.nghia({
          type: "GET",
          url: "/attack/trainer/trainer-do_attack.php?attack_name=undifined&wie=computer&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
          ducnghia: attack_status
        }); 
      }
    };
  })(jQuery);
  
  //Computer Change Pokemon
  (function($){
    trainer_change = function() {
      if(speler_attack == 0){
        $("#potion_screen").hide()
        $.nghia({
          type: "GET",
          url: "/attack/trainer/trainer-change-pokemon.php?pokemon_info_name=<? echo $pokemon_info['naam']; ?>&computer_info_name=<? echo $computer_info['naam']; ?>&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
          ducnghia: trainer_change_pokemon
        }); 
      }
    };
  })(jQuery);
   
  </script>
   
  
  <style>#table_fight_b {
background-size: cover;
	min-height: 300px;
	margin: 0 auto;
}</style>
<?php 
    
  $ducnghia_map=rand(1,7);
 
  
 echo'    <table id="table_fight_b" class="'.$class.'"> '; ?>


  
  
  <center>
 
    <tr><td></td><td></td>

			<td>
			    	<div class="statbar lstatbar animated fadeInRight" style="display: block;left: 130px;top: 120px;opacity: 1;">

			
				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><span id="trainer_naam"><? echo $computer_info['naam_goed']; ?></span><span id='computer_star' style='display:none;'></font></strong></small>
				
				<div class="hpbar">
					<div class="prevhp" style="width: <?=$computer_life_procent?>px;">
						<div class="hp" id="computer_life" style="width: <?=$computer_life_procent?>%; border-right-width: 1px;"></div>
					</div>
					
					(<?php
    		  $trainer_pok = mysql_query("SELECT `id`, `leven` FROM `pokemon_wild_gevecht` WHERE `aanval_log_id`='".$aanval_log['id']."' ORDER BY `id`");
        while($trainer_pokemon = mysql_fetch_array($trainer_pok)){
            if($trainer_pokemon['leven'] > 0) echo '<img id="trainer_'.$trainer_pokemon['id'].'" src="./images/icons/pokeball.gif" width="14" height="14" alt="Bereit" title="Bereit" />';
            else echo '<img id="trainer_'.$trainer_pokemon['id'].'" src="./images/icons/pokeball_black.gif" width="14" height="14" "Besiegt" title="Besiegt" />';
        }
        ?>)
					<div class="status"></div>
				</div>
			</div>
				<div align="center" id="dame" style="display:none;"></div>
				<div id="img_computer_f">
                <img class="animated slideInLeft" id="img_trainer" src="images/<? echo $computer_info['map']."/".$computer_info['wild_id']; ?>.gif" style="padding: 20px 0px 0px 50px;max-width: 70%;height:auto;max-height:100px"/></div> 
            </td></tr>
			<tr>
			<td> 
			<div class="statbar rstatbar animated fadeInLeft" style="display: block; left: 350px; top: 24px; opacity: 1;">
				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><span id="pokemon_naam"><? echo $pokemon_info['naam_goed']; ?></span><span id="pokemon_star" style="display:none;"></span><br/><span id="pokemon_hp" style="padding:0px 0 0px 5px;">LV.<? echo $pokemon_info['level']; ?></span></font></strong></small>
				<div class="hpbar">
					<div class="prevhp" style="width: <?php echo $pokemon_life_procent; ?>px;">
						<div class="hp" id="pokemon_life" style="width: <?php echo $pokemon_life_procent; ?>%; border-right-width: 1px;"></div>
					</div>
					
					
					<div class="status"></div>
				</div>
				<div><div class="exp_blue">
				<div class="progress" id="pokemon_exp" style="width:  <?php echo $pokemon_exp_procent; ?>%"></div>
				</div></div>
			</div>	
				<div class="infront" align="center" id="hit" style="display:block;"></div>
				<div class="inback" align="center" id="hit2" style="display:block;"></div>
				<div align="center" id="dame2" style="display:none;"></div>

                <div id="img_pokemon_f"><img class="animated slideInLeft" id="img_pokemon" src="images/<? echo $pokemon_info['map']; ?>/back/<? echo $pokemon_info['wild_id']; ?>.gif" style="padding: 10px 0 0 10px;max-height:100px"/></div>
            </td>
			<td id="message"  class="attack_messe"></td>
			</tr>
	</table>
 
		  

    <?PHP
   $skill1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_1']."'"));
					     $skill2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_2']."'"));
					      $skill3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_3']."'"));
					       $skill4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_4']."'"));
   ?>
   <!-------->
   <center>
  	<div id="control-main">		
   
   <div id="MovesBlock" class="thumbnail ">
       <button class=" btn-kinang"><div class="skillName text-center" id="aanval"><? echo $pokemon_info['aanval_1']; ?></div><div class="pull-left"><img id="types1" src="/img/type/<?=$skill1['soort']?>.png"></div></button>
       
<button class=" btn-kinang"><div class="skillName text-center" id="aanval"><? echo $pokemon_info['aanval_2']; ?></div><div class="pull-left"><img id="types2" src="/img/type/<?=$skill2['soort']?>.png"></div></button>

<button class=" btn-kinang"><div class="skillName text-center" id="aanval"><? echo $pokemon_info['aanval_3']; ?></div><div class="pull-left"><img id="types3" src="/img/type/<?=$skill3['soort']?>.png"></div></button>

<button class=" btn-kinang"><div class="skillName text-center" id="aanval"><? echo $pokemon_info['aanval_4']; ?></div><div class="pull-left"><img id="types4" src="/img/type/<?=$skill4['soort']?>.png"></div></button>
       
  
       </div>

   <div id="control_left" class=" col-xs-12 thumbnail ">	
   <div  class="pokemonsBlock col-xs-8 thumbnail">
       
       
       <div class="col-xs-2 icons" id="change_pokemon" name="1" title="" style="background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;display:none;"></div>
    <div class="col-xs-2 icons" id="change_pokemon" name="2" title="" style="display:none;background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;"></div>
   <div class="col-xs-2 icons" id="change_pokemon" name="3" title="" style="display:none;background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;"></div>
  <div class="col-xs-2 icons" id="change_pokemon" name="4" title="" style="display:none;background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;"></div>
  
    <div class="col-xs-2 icons" id="change_pokemon" name="5" title="" style="display:none;background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;"></div>
   
        <div class="col-xs-2 icons" id="change_pokemon" name="6" title="" style="display:none;background-image: url(); height: 32px; width: 32px; border: 0px; cursor: pointer;position: relative;left: 15px;top: 3px;"></div>

  
    </div>		
    <!-----ITEM--->

   <!---------->
   
   </div>	</div>
   <!-------->
   </center>
   
   
   
	
 
</div>

    		<?PHP } ?>