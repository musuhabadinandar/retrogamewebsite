<?PHP



if(isset($_POST[giftcode])) {
 
$msg = '<center><div class="input-group">
<input id="macode" class="form-control" type="text" value="" style="width: 40%;"> <a href="javascript:nhapcode();" class="btn btn-success" style="  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;">Nhận</a> </div><font color="blue"><b id="tb_giftcode"></b></font>
</center>';
$nn = '<center class="viptxt">Mã Quà Tặng</center>';
$n = $nn.$msg;

echo $n;




}

if(isset($_POST[top])) {
 $g = $_POST[id];
 if($g==1) {
 
  $req=mysql_query("SELECT * FROM `users` WHERE `level`>=0 AND `user_id` >=5 ORDER BY `level` DESC, exp DESC LIMIT 0,10");
 
 $i = 1;

while ($res = mysql_fetch_array($req)) {
$_chiso = $res[exp] / $res[expmax] * 100;

$msg.= '#'.$i.' <img src="/xml/nhanvat.php?nhanvat='.$res[sprite].'&nut=1" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.nick($res[user_id]).'</b> Lv.'.$res[level].' + '.highamount($_chiso).'% <br>
Exp: '.highamount($res[exp]).'/'.highamount($res[expmax]).'

<div class="kengang"></div> ';
++$i;
}
}

if($g==2) {
 
  $req=mysql_query("SELECT * FROM `users` WHERE `xu`>=0 AND `user_id` >=5 ORDER BY `xu` DESC LIMIT 0,10");
 
 $i = 1;
while ($res = mysql_fetch_array($req)) {

$msg.= '#'.$i.' <img src="/xml/nhanvat.php?nhanvat='.$res[sprite].'&nut=1" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.nick($res[user_id]).'</b><br>
Xu: '.highamount($res[xu]).'

<div class="kengang"></div> ';
++$i;
}
}
 
 
 


if($g==3) {
 
  $req=mysql_query("SELECT * FROM `users` WHERE `sukien`>=0 AND `user_id` >=5 ORDER BY `sukien` DESC LIMIT 0,10");
 
 $i = 1;
while ($res = mysql_fetch_array($req)) {

$msg.= '#'.$i.' <img src="/xml/nhanvat.php?nhanvat='.$res[sprite].'&nut=1" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.nick($res[user_id]).'</b><br>
Điểm: '.highamount($res[sukien]).'

<div class="kengang"></div> ';
++$i;
}
}

if($g==4) {
 
  $req=mysql_query("SELECT * FROM `users` WHERE `ruby`>=0 AND `user_id` >=5 ORDER BY `ruby` DESC LIMIT 0,10");
 
 $i = 1;
while ($res = mysql_fetch_array($req)) {

$msg.= '#'.$i.' <img src="/xml/nhanvat.php?nhanvat='.$res[sprite].'&nut=1" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.nick($res[user_id]).'</b><br>
ruby: '.highamount($res[ruby]).'

<div class="kengang"></div> ';
++$i;
}
}

if($g==5) {
 
  $req=mysql_query("SELECT * FROM `users` WHERE `thang`>=0 AND `user_id` >=5 ORDER BY `thang` DESC LIMIT 0,10");
 
 $i = 1;
while ($res = mysql_fetch_array($req)) {

$msg.= '#'.$i.' <img src="/xml/nhanvat.php?nhanvat='.$res[sprite].'&nut=1" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.nick($res[user_id]).'</b><br>
Thắng - Thua: '.highamount($res[thang]).' - '.highamount($res[thua]).'

<div class="kengang"></div> ';
++$i;
}
}

if($g==6) {
    $top5pokemonsql = mysql_query("SELECT pokemon_speler.*, pokemon_wild.wild_id, pokemon_wild.naam, pokemon_wild.type1, pokemon_wild.type2, users.username,
							  SUM(`attack` + `defence` + `speed` + `spc.attack` + `spc.defence`) AS strongestpokemon 
							  FROM pokemon_speler
							  INNER JOIN pokemon_wild
							  ON pokemon_speler.wild_id = pokemon_wild.wild_id
							  INNER JOIN users
							  ON pokemon_speler.user_id = users.user_id
							  WHERE  users.user_id > '1' 
							  
							  GROUP BY pokemon_speler.id ORDER BY strongestpokemon DESC LIMIT 5");

while($pokemon = mysql_fetch_array($top5pokemonsql)){
	
	if($pokemon['shiny'] == 1) $type= 'shiny';
	else $type = 'pokemon';
	$wildid = $pokemon['wild_id'];
	$strongestpokemonnumber ++;
	$lowname = strtolower($pokemon['naam']);
	$eigenaar = $pokemon['username'];
	$statistics = 1;
    $pokemon = pokemonei($pokemon);
    $pokemon['naam'] = pokemon_naam($pokemon['naam'],$pokemon['roepnaam']);
    $popup = pokemon_popup($pokemon, $txt);
  $msg.= '#'.$i.' <img onclick="pokemon('.$pokemon[id].')" src="images/'.$type.'/'.$wildid.'.gif" style="float:left;margin:15px 15px;border:2px solid #000;"><B class="viptxt"> '.ducnghia_us($pokemon[user_id]).'</b><br>


<div class="kengang"></div> ';
}
}



$nn='<hr>';
$n = $nn.$msg;

echo $n;



}


