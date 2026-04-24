<?PHP
include_once('../templates/config.php'); 
include_once('../templates/ducnghia.php'); 


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
#Load Safety Script

#Load language 
$page = 'attack/wild/wild-attack';
#Goeie taal erbij laden voor de page

#Include Attack Functions
include("../attack/attack.inc.php");


$_SESSION['fight']++;

$aanval_log = aanval_log($_SESSION['attack']['aanval_log_id']);

#Player in log is diffirent then loggedin
if($aanval_log['user_id'] != $_SESSION['id']){
  #End Attack
  remove_attack($aanval_log['id']);
  #Send back to home
  header("Location: index.php?page=game/bando");
  unset($_SESSION['attack']['duel_id']);
}
else{
  #Load All Openent Info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  #Make all letters small
  $computer_info['naam_klein'] = strtolower($computer_info['naam']);
  #Change name for male and female
  $computer_info['naam_goed'] = computer_naam($computer_info['naam']);
  #Check if Player Has a Pokedex Chip
 $computer_info['level'] = $computer_info['level'];
  
  #Shiny
  $computer_info['map'] = "pokemon";
  $computer_info['star'] = "none";
  if($computer_info['shiny'] == 1){
    $computer_info['map'] = "shiny";
    $computer_info['star'] = "block";
  }
  $pokemon_info['naam_klein'] = strtolower($pokemon_info['naam']);
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);
  
  
  $rarity = $computer_info['zeldzaamheid'];
  if ($rarity == 1) $rarity = "<font color='#4d4d4d'>Chung</font>";
  else if ($rarity == 2) $rarity = "<b>Hiếm</b>";
  else $rarity = "<font color='#9e3838'><b>Hiếmוד</b></font>";
 
  #Calculate Life in Procent for Computer         
  if($computer_info['leven'] != 0) $computer_life_procent = round(($computer_info['leven']/$computer_info['levenmax'])*100);
  else $computer_life_procent = 0;
  
  #Load All Pokemon Info
  $pokemon_info = pokemon_data($aanval_log['pokemonid']);
  $pokemon_info['naam_klein'] = strtolower($pokemon_info['naam']);
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);

  
  #Calculate Life in Procent for Pokemon         
  if($pokemon_info['levenmax'] != 0) $pokemon_life_procent = round(($pokemon_info['leven']/$pokemon_info['levenmax'])*100);
  else $pokemon_life_procent = 0;
  
  #Calculate Exp in procent for pokemon
  if($pokemon_info['expnodig'] != 0) $pokemon_exp_procent = round(($pokemon_info['exp']/$pokemon_info['expnodig'])*100);
  else $pokemon_exp_procent = 0;
  
  #Shiny
  $pokemon_info['map'] = "pokemon";
  $pokemon_info['star'] = "none";
  if($pokemon_info['shiny'] == 1){
    $pokemon_info['map'] = "shiny";
    $pokemon_info['star'] = "block";
  }
  
      $new['type1']       = strtolower($computer_info['type1']);
    $new['type2']       = strtolower($computer_info['type2']);
    //Heeft de pokemon twee types?
    if(empty($computer_info['type2'])) $new['type'] = '<div class="type '.$new['type1'].'" style="float:left;margin-left:4px">'.$new['type1'].'</div>';
    else $new['type'] = '<div class="type '.$new['type1'].'" style="float:left;margin-left:4px">'.$new['type1'].'</div> <div class="type '.$new['type2'].'" style="float:left;margin-left:4px">'.$new['type2'].'</div>';
  		$new['type'] = str_replace("electric","Điện",$new['type']);
		$new['type'] = str_replace("type חשמל","type electric",$new['type']);
		$new['type'] = str_replace("rock","סלע",$new['type']);
		$new['type'] = str_replace("type סלע","type electric",$new['type']);
		$new['type'] = str_replace("ice","קרח",$new['type']);
		$new['type'] = str_replace("type קרח","type ice",$new['type']);
		$new['type'] = str_replace("water","מים",$new['type']);
		$new['type'] = str_replace("type מים","type water",$new['type']);
		$new['type'] = str_replace("ghost","רוח",$new['type']);
		$new['type'] = str_replace("type רוח","type ghost",$new['type']);
		$new['type'] = str_replace("steel","ברזל",$new['type']);
		$new['type'] = str_replace("type ברזל","type steel",$new['type']);
		$new['type'] = str_replace("flying","מעופף",$new['type']);
		$new['type'] = str_replace("type מעופף","type flying",$new['type']);
		$new['type'] = str_replace("normal","רגיל",$new['type']);
		$new['type'] = str_replace("type רגיל","type normal",$new['type']);
		$new['type'] = str_replace("dragon","דרקון",$new['type']);
		$new['type'] = str_replace("type דרקון","type dragon",$new['type']);
		$new['type'] = str_replace("psychic","על-חושי",$new['type']);
		$new['type'] = str_replace("type על-חושי","type psychic",$new['type']);
		$new['type'] = str_replace("fire","אש",$new['type']);
		$new['type'] = str_replace("type אש","type fire",$new['type']);
		$new['type'] = str_replace("bug","חרק",$new['type']);
		$new['type'] = str_replace("type חרק","type bug",$new['type']);
		$new['type'] = str_replace("poison","רעל",$new['type']);
		$new['type'] = str_replace("type רעל","type poison",$new['type']);
		$new['type'] = str_replace("grass","דשא",$new['type']);
		$new['type'] = str_replace("type דשא","type grass",$new['type']);
		$new['type'] = str_replace("dark","אופל",$new['type']);
		$new['type'] = str_replace("type אופל","type dark",$new['type']);
		$new['type'] = str_replace("fighting","לוחם",$new['type']);
		$new['type'] = str_replace("type לוחם","type fighting",$new['type']);
		$new['type'] = str_replace("ground","אדמה",$new['type']);
		$new['type'] = str_replace("type אדמה","type ground",$new['type']);

        mysql_query("UPDATE `users` SET `chiendau`='1' WHERE `user_id`='$user_id'");

 $ducnghia_pokemon =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE  `user_id` = '".$user_id."' AND `opzak_nummer` = '1'"));

if (!empty($pokemon_info['ducnghia_skill'])) {
    $ducnghia_okx = $pokemon_info['ducnghia_skill'];
    
} else {
	    $ducnghia_okx =  $pokemon_info['aanval_1']; } 
  #Player Pokemon In Hand
  
  for($inhand = 1; $player_hand = mysql_fetch_array($pokemon_sql); $inhand++){
    #Check Wich Pokemon is infight
    if($player_hand['id'] == $pokemon_info['id']) $infight = 1;
    else $infight = 0;
    if($player_hand['ei'] == 1) $player_hand['naam'] = "??";
    if($player_hand['ei'] == 1) $player_hand['wild_id'] = "??";
    ?>
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
    <?
  }
  mysql_data_seek($pokemon_sql, 0); 
  ?>
  <div class="chien_dau">
  <script type="text/javascript" src="attack/javascript/attack.js"></script>
  <script language="javascript">
    
  var speler_attack; var timer; var next_turn_timer; var attack_timer = 0; var speler_wissel;

  function show_end_screen(text){
    $.get("attack/wild/wild-finish.php?aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(), function(data) {
      request = data.split(" | ");
	  document.getElementById('hit').style.display = "none";
		document.getElementById('hit2').style.display = "none";
      if(request[0] == 1) { $("#message").prepend("<font size='3'><b>bạn chiến thắng.</b> "+text); 
            	              
setdrawn(0,0,0,0,'BOSS Đã bị tiêu diệt.');

      	           
c_attack();
          
      }
      else if(request[0] == 0){
      	             			
setdrawn(0,0,0,0,'Thất bại.');
      c_attack();
      
      }
 <?php If($datauser->data ==1) {?>
c_attack();
chien_out();
      <?php } ?>
    });
  }

  //If div is ready
  $("#message").ready(function() {
    //Write Start Text
    if("<? echo $aanval_log['laatste_aanval']; ?>" == "spelereersteaanval"){
      speler_attack = 1
      speler_wissel = 1
      $("#message").prepend("PokeMon bạn tấn công đầu tiên")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "computereersteaanval"){
      speler_attack = 0
      speler_wissel = 0
      $("#message").prepend("<? echo $computer_info['naam_goed']?> tấn công trước.")
      setTimeout('next_turn()', 1500)
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "pokemon"){
      speler_attack = 0
      next_turn()
      $("#message").prepend("Đến lượt <b><? echo $computer_info['naam_goed']?></b> tấn công.")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "computer"){
      speler_attack = 1
      $("#message").prepend("<b>đến lượt pokemon bạn tấn công</b>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "wissel"){
      speler_attack = 0
      speler_wissel = 1
      $("#message").prepend("<? echo $pokemon_info['naam_goed']?>")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "end_screen"){
      speler_attack = 0
      speler_wissel = 0
      show_end_screen("Đang trong cuộc chiến")
    }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "klaar"){
      speler_attack = 1
      $("#message").prepend("kết thúc trận đấu,xin chờ.")
      	             				$('#ducnghia_pkm').hide();
c_attack();
   }
    else if("<? echo $aanval_log['laatste_aanval']; ?>" == "gevongen"){
      speler_attack = 1
      $("#message").prepend("PokeMon <?=$computer_info['naam_goed']?> đang bị bán.")

    }
    else { $("#message").prepend("Pokemon của bạn đã kiệt sức.hãy tới bệnh viện chữa trị đi nhé.")
c_attack();
        
    }
    });      
  
  //Change attack status
  function attack_status(msg){
  
    request = msg.split(" | ")
    var time = 50
   
     if(request[7] < 25) time = 350
    else if(request[7] < 50) time = 350
    else if(request[7] < 100) time = 350
    else if(request[7] < 150) time = 350
    else if(request[7] < 200) time = 350
    else if(request[7] < 250) time = 350
    else if(request[7] >= 250) time = 350
              $("#ducnghia_hp").html("- "+request[7]);
 if(request[18]=="normal") {
			        request[18] = "normal2";
			    }
	if(request[4] == "pokemon"){
	    $("#img_computer_f").addClass('eff_f2');
		document.getElementById('dame2').style.display = "";
        $("#dame2").html("- "+request[7]);
	
			   
			    			    $("#hit2").addClass(''+request[18]+'');

		} else {

		    $("#img_pokemon_f").addClass('eff_f');
		document.getElementById('dame').style.display = "";
        $("#dame").html("- "+request[7]);
			    			    $("#hit").addClass(''+request[18]+'');

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
		$('#img_computer_f').removeClass('eff_f2');
		$('#img_pokemon_f').removeClass('eff_f');
		$('#img_computer').removeClass('animated shake')
		$('#img_pokemon').removeClass('animated tada')
    request = msg.split(" | ")
       if(request[13] > 0) leven_verandering(request[14],request[16],request[15])
    if(request[17] != '') stappen = request[17]
    else if(request[16] == 'pokemon') stappen = '';
    $("#message").prepend(request[0])
    if(request[4] == "pokemon"){
      life_procent = Math.round((request[2]/request[3])*100)
      $("#"+request[8]+"_life").width(life_procent + '%')
      $("#"+request[8]+"_leven").html(request[2])
      $("#"+request[8]+"_leven_max").html(request[3])
      $("div[id='change_pokemon'][name='"+request[9]+"']").attr("title", "<? echo $pokemon_info['naam']; ?> \nLife:"+request[2]+"/"+request[3]+"");
      	  $("#pokemon_hp").html("HP "+request[2]+"/"+request[3]);

    }
    
    if(request[4] == "pokemon"){
      if(request[2] == 0) speler_wissel = 1
      else{
        speler_attack = 1
        speler_wissel = 1
      }
    }
    else{
      speler_attack = 0
      speler_wissel = 0
    } 
    
    //Computer make next turn
    if(request[1] == 1) next_turn()
    else if(request[6] == 1){
      setTimeout("exp_change("+request[11]+","+request[12]+");", 1500)
      setTimeout("show_end_screen('"+request[10]+"');", 1500)
      speler_attack = 0
      speler_wissel = 0
    }
  }
  
  //Change Pokemon Function
  function change_pokemon_status(msg){
    //Get php variables
    request = msg.split(" | ")
    //Send message
    $("#message").prepend(request[0])
    //Stop Life Change 
    clearTimeout(timer);
    //Change was succesfull
   if (request[1] == 1) {
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

	 	
		
	

		if(request[14] == 1){
			var map = "shiny"
			$("#pokemon_star").show() 
			$("#img_pokemon").addClass('saturate')
		  }
		  else{
			var map = "pokemon"
			$("#pokemon_star").hide()  
			$("#img_pokemon").removeClass('saturate')
		  }
		$("#img_pokemon").attr("src","images/"+map+"/back/" + request[15] + ".gif");
        //Show all pokemon in your hand
        $("div[id*='change_pokemon'][name*='1']").show();
        $("div[id*='change_pokemon'][name*='2']").show();
        $("div[id*='change_pokemon'][name*='3']").show();
        $("div[id*='change_pokemon'][name*='4']").show();
        $("div[id*='change_pokemon'][name*='5']").show();
        $("div[id*='change_pokemon'][name*='6']").show();
        //Hide the new pokemon that is in fight
		 $("div[id*='change_pokemon'][name*='"+ request[9] +"']").hide()
      //Change the HP Status from new pokemon in fight
      var pokemon_life_procent = Math.round((request[10]/request[11])*100)
      $("#pokemon_life").width(pokemon_life_procent+'%')
      //Change EXP Status from new pokemon in fight
      var exp_procent = Math.round((request[12]/request[13])*100)
      $("#pokemon_exp").width(exp_procent+'%')
	  $("#menus").show();
		$("#menu1").hide();
		$("#menu2").hide();
		$("#menu3").hide();
		$("#potions_screen").hide();
		$("#potion_screen").hide();
		$("#ball_screen").hide();
        //Computer make next turn
        if (request[2] == 1) {
            speler_attack = 0;
            speler_wissel = 0;
            next_turn();
        } else {
            speler_attack = 1;
            speler_wissel = 0;
        }
    }
}
  
  //Use item function
  function use_item_status(msg){
    //Get php variables
    request = msg.split(" | ")
    //Send message
    //change amount of item
    var getpokemon =   $('#ducnghia_'+request[3]+'').html();
   var tinh = getpokemon -1;
   if(tinh<=0) {
       tinh = 0;
   }
    $('#ducnghia_'+request[3]+'').html(tinh);
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
      speler_attack = 0;
      speler_wissel = 0;
      
      //Computer make next turn
      if(request[1] == 1) { 
	      	$("#hit").addClass('pokeball');

	document.getElementById('img_computer').style.display = "none";


setTimeout(function(){ 
$("#hit").removeClass();
$("#hit").addClass('pokeball');

setTimeout(function(){ 
$("#hit").removeClass();
document.getElementById('img_computer').style.display = "block";
    $("#message").prepend(request[0]);
          next_turn();

}, 200);

}, 500);


      }
      //Attack finished
      else   {    	 	$('#ducnghia_pkm').hide();                                     c_attack();

}

    }
  }
  
  //Try To Run Function
  function attack_run_status(msg){
    //Get php variables
    request = msg.split(" | ")
    //Send message
    $("#message").prepend(request[0])
    if(request[1] == 1) {                                    
        c_attack();

     	             				$('#ducnghia_pkm').hide();
 }
    //Computer make next turn
    if(request[1] == 0){
      speler_attack = 0
      speler_wissel = 0
      next_turn()
    }
  }
  
  //Make Computer Do Attack
  function next_turn(){
    clearTimeout(next_turn_timer)
    next_turn_timer = setTimeout('computer_attack()', 1000)
  }
  
  
  
  
  
  
  
  
  
     






  
  
  
  function auto2(){
       if(speler_attack == 1){
                speler_attack = 0

			   $("#hit2").removeClass();
			   $("#hit").removeClass();

    			$("#message").prepend($("#pokemon_naam").html()+ " dùng kĩ năng "+$(this).html()+".")
    			$("#potion_screen").hide()
 $.nghia({ 
          type: "GET",
         
           url: "/attack/boss/wild-do_attack.php?attack_name="+'<?=$ducnghia_okx?>'+"&wie=pokemon&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
          ducnghia: attack_status
        }); 
      }
  }
  
  
  
  
  //Player Can Do Stuff
  $(document).ready(function(){
    //Player Do Attack
    ///auto
    
   
   
    
   

 $("div[id='aanval']").click(function(){
	    if(speler_attack == 1){
        if($(this).html() != ""){
          speler_attack = 0
          			    $("#hit2").removeClass();

$('#img_computer').removeClass('animated slideInLeft');
				$('#img_pokemon').removeClass('animated slideInLeft');
				$('#img_computer').addClass('animated shake');
    			$("#message").prepend($("#pokemon_naam").html()+ " Sử dụng kĩ năng <b>"+$(this).html()+"</b> ,<big><b><font color='green'><?php echo $computer_info['naam_goed'] ?></font> Mất <font color='red'><span id='ducnghia_hp'>0</span>HP</font></big></b><br>.")
    			$("#potion_screen").hide()
    			//alert($(this).html())
    			$.nghia({
    			  type: "GET",
    			  url: "/attack/boss/wild-do_attack.php?attack_name="+$(this).html()+"&wie=pokemon&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
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
    
    $("img[id='run']").click(function() {
        if (speler_attack == 1) {
            $("#potion_screen").hide()
            $.nghia({
                type: "POST",
                url: "/attack/boss/wild-attack_run.php?computer_info_name=<? echo $computer_info['naam']; ?>&aanval_log_id=<? echo $aanval_log['id']; ?>&sid="+Math.random(),
                ducnghia: attack_run_status
            });
        }
    });
    
    
    //Player Using Item
    $("button[id='use_item']").click(function(){
      if(speler_attack == 1){
        if($('#item').val() == "Kies") $("#message").prepend("Chưa chọn item sao sử dụng ?")
        else if($('#item :selected').attr("title") == "Potion"){
          $("#item_name").prepend($('#item').val())
          $("#message").prepend()
          $("#potion_screen").show()
        }
        else if($('#item :selected').attr("title") == "Run"){
          if(speler_attack == 1){
            $("#potion_screen").hide()
            $.nghia({
              type: "GET",
              url: "/attack/boss/wild-attack_run.php?computer_info_name=<? echo $computer_info['naam']; ?>&aanval_log_id=<? echo $aanval_log['id']; ?>&sid="+Math.random(),
              ducnghia: attack_run_status
            }); 
          }
        }
        else{
          $("#potion_screen").hide()
          $.nghia({
            type: "GET",
            url: "/attack/boss/wild-attack_use_pokeball.php?item="+$('#item').val()+"&computer_info_name=<? echo $computer_info['naam']; ?>&option_id="+$('#item :selected').attr("name")+"&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
            ducnghia: use_item_status
          }); 
        }
      }
    });
    $("img[id='run']").click(function() {
        if (speler_attack == 1) {
            $("#potion_screen").hide()
            $.nghia({
                type: "POST",
                url: "/attack/boss/wild-attack_run.php",
				data: "computer_info_name=<? echo $computer_info['naam']; ?>&aanval_log_id=<? echo $aanval_log['id']; ?>&sid="+Math.random(),
                ducnghia: attack_run_status
            });
        }
    });
    //Player is Using Potion
    $("button[id='use_potion']").click(function(){
      if(speler_attack == 1){
        if($("input[name='potion_pokemon_id']:checked").val() == undefined) $("#message").prepend("Chưa chọn pokemon sao dùng ?")
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
        $("#message").prepend("<img src='images/loading.png' alt='DucNghia'/><br/> Đang tải trận chiến.")
        $("#potion_screen").hide()
        $('#img_computer').removeClass('animated slideInLeft');
		$('#img_pokemon').removeClass('animated slideInLeft');
		$('#img_pokemon').addClass('animated tada');

        $.nghia({
          type: "GET",
          url: "/attack/boss/wild-do_attack.php?attack_name=undifined&wie=computer&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
          ducnghia: attack_status,
          
      
       
           
        }); 
       
      }
    };
    
    
    
    
  }) (jQuery);
   

function pokeball(ducnghiadz,uid) {
    
    $.nghia({
            type: "GET",
            url: "/attack/boss/wild-attack_use_pokeball.php?item="+ducnghiadz+"&computer_info_name=<? echo $computer_info['naam']; ?>&option_id="+uid+"&aanval_log_id="+<? echo $aanval_log['id']; ?>+"&sid="+Math.random(),
            ducnghia: use_item_status
          }); 
}
     
   
  </script> 
  
  
  
  
  
  
  <style>#table_fight_b {
	background-size: cover;
	min-height: 300px;
	margin: 0 auto;
}</style>
  
  
   
  
  <center>
<div class="available" style="display:none;" > 

<div class="war_win" style="display:none;" > </div>
<div id="war_taward" style="display: none; color: gold; font-weight: bold;"><i class="fa fa-trophy"></i> PHẦN THƯỞNG</div>
<div id="war_award"></div>
<div id="div_win" class="dnone"> <a class="btn btn-danger" type="button" class="close" onclick="c_attack()"><i class="fa fa-sign-out-alt"></i>RỜI</a></div>

<!--THUA-->
<div class="war_lose" style="display:none;" > </div>
<div id="div_lose" class="dnone"><a class="btn btn-danger" type="button" class="close" onclick="c_attack()"><i class="fa fa-sign-out-alt"></i>RỜI</a></div>
<!---DUCNGHIA-->
</div>
<?PHP
 $vung =  mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id` = '".$computer_info['wildid']."'"));


?>
<div id="ducnghia_an">
  
  <table id="table_fight_b" <?php if ($vung['gebied'] == "Gras") {?>class="battlearea1"
  <?php } else if($vung['gebied'] == "Water") {?>
  class="battlearea2"<?php } else if($vung['gebied'] == "Strand") {?>class="battlearea3" <?php } 
  else if($vung['gebied'] == "Grot") {?>class="battlearea4" <?php }
  else if($vung['gebied'] == "Lavagrot") {?>class="battlearea1" <?php }
  else if($vung['gebied'] == "Vechtschool") {?>class="battlearea6" <?php }
  else if($vung['gebied'] == "Spookhuis") {?>class="battlearea7" <?php }
  else {?>class="battlearea1"<?php } ?>>
  
               <center>
 
    <tr><td></td>
			<td></td>

			<td>
			    <div class="statbar lstatbar animated fadeInRight" style="display: block;left: 130px;top: 120px;opacity: 1;" id="ducnghia_die">

				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><?php echo $computer_info['naam_goed'] ?><span id='computer_star' style='display:none;'></span>
				<br>HP:<b id="hp_boss_<?=$datauser->boss?>" class="viptxt">???</b>
				</font></strong></small>
				<div class="hpbar">
					<div class="prevhpa" style="width: <?=$computer_life_procent?>px;">
						<div class="hp"  id="computer_life" style="width: <?=$computer_life_procent?>%; border-right-width: 1px;"></div>
					</div>
					<div class="status"></div>
				</div>
			</div>
				<div align="center" id="dame" style="display:none;"></div>
				<div id="img_computer_f" onclick="info(<?=$computer_info['wild_id']?>)">
                <img class="animated slideInLeft" id="img_computer" src="images/<? echo $computer_info['map']."/".$computer_info['wild_id']; ?>.gif" style="padding: 20px 0px 0px 50px;max-width: 70%;height:auto;max-height:100px"/></div> 
            </td></tr>
			<tr>
			<td> 
			<div class="statbar rstatbar animated fadeInLeft" style="display: block; left: 350px; top: 24px; opacity: 1;">
				<small><strong><font style='text-shadow:1px 1px 1px #fff;'><span id="pokemon_naam"><? echo $pokemon_info['naam_goed']; ?></span><span id="pokemon_star" style="display:none;"></span><br/><span id="pokemon_hp" style="padding:0px 0 0px 5px;">HP: <? echo $pokemon_info['leven']; ?>/<? echo $pokemon_info['levenmax']; ?> </span> LV.<? echo $pokemon_info['level']; ?>
				</font></strong></small> <div>
				<div class="hpbar">
					<div class="prevhpa" style="width: <?php echo $pokemon_life_procent; ?>px;">
						<div class="hp" id="pokemon_life" style="width: <?php echo $pokemon_life_procent; ?>%; border-right-width: 1px;"></div>
					</div> 
					
					
					
					<div class="status"></div>
				</div> </div>
				<div><div class="exp_blue">
				<div class="progress" id="pokemon_exp" style="width:  <?php echo $pokemon_exp_procent; ?>%"></div>
				</div></div>
			</div>	
				<div class="ghost" align="center" id="hit" style="display:block;"></div>
				<div class="ghost" align="center" id="hit2" style="display:block;"></div>
				<div align="center" id="dame2" style="display:none;"></div>

                <div id="img_pokemon_f"><center><img class="animated slideInLeft" id="img_pokemon" src="images/<? echo $pokemon_info['map']; ?>/back/<? echo $pokemon_info['wild_id']; ?>.gif" style="padding: 10px 0 0 10px;max-height:100px"/></center></div>
                
               
                
            </td>
			<td  id="message" class="attack_messe">
			</td>
			</tr>
	</table>
 
		  

 
   <?PHP
   $skill1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_1']."'"));
					     $skill2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_2']."'"));
					      $skill3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_3']."'"));
					       $skill4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$pokemon_info['aanval_4']."'"));
   ?>
   <!-------->
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
   

</div>
    
    </div>		

<?

}
?>