<?PHP

function nick2($gid){
 return   ducnghia_us2($gid);
}
if(isset($_POST[fixket])) {
        		      mysql_query("UPDATE `users` SET `map`='{\"id\":1,\"x\":23,\"y\":48}' WHERE `id`='".$_SESSION['id']."'");

}

function ducnghia_us2($gid){
	global $_con;
	$gunner = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = $gid"));
$tkm = $gunner;

if(empty($tkm[name])) {$tennv =ucfirst($gunner['username']);}else{ $tennv =ucfirst($gunner['name']);}

if($tkm[admin]==1)  {
    $chuc = 'style="background-image: url(img/2.gif);width:350px;"'; $ma = 'mod'; }
    if($tkm[admin]==2) {
    $chuc = '[GM]'; }
    if($tkm[admin]==3) {
        $chuc .= 'style="background-image: url(img/backround3.gif);width:350px;"';
        $ma = 'admin';
    }
if($tkm[ducnghia_thoigiankhoa] > time()) {
return '<a href="javascript:ttnv('.$gid.')" style="color:#190B07;"><strike>'.$tennv.'</strike></a>'; 
} else {
	return '<img src="/images/items/Poke ball.png">'.$tennv.''; }
   
	
	
	}
	
if(isset($_POST['mychat'])){
$x = mysql_query("SELECT * FROM `chat_users` WHERE `user_fr` = $user_id ORDER BY `time` DESC, `amount` DESC");
while($xx = mysql_fetch_assoc($x)){
	if(!$xx['view'])
	$view .= '<a href="javascript:msg('.$xx[user_id].',1)">'.nick2($xx['user_id'],2).' <b style="color:red;">+'.$xx['amountplus'].'</b></a><div class="kengang"></div>';
else
	$view2 .= '<a href="javascript:msg('.$xx[user_id].',1)">'.nick2($xx['user_id'],2).' <b style="color:blue;">('.$xx['amount'].')</b></a><div class="kengang"></div>';
}
echo '<b><i class="fa fa-inbox fixbot"></i> CHƯA ĐỌC</b><br>
'.$view.'<br>
<b><i class="fa fa-inbox fixbot"></i> CŨ HƠN</b><br>
'.$view2.'';
}


if(isset($_POST[ruongdo])) {
 	$out .='
<div onclick="ok_skin('.$ducnghia_do['id'].')" class="showitem" style="border: 2px solid;"><img src="'.$ducnghia_img.'"><div class="count count-vp-1"></div></div>		';

$aantal_pokemon = mysql_num_rows(mysql_query("SELECT `id` FROM `pokemon_speler` WHERE `user_id`='".$_SESSION['id']."' AND `opzak`='nee'"));
    $poke = mysql_query("SELECT pokemon_speler.*, pokemon_wild.naam, pokemon_wild.type1, pokemon_wild.type2
							   FROM pokemon_speler
							   INNER JOIN pokemon_wild
							   ON pokemon_speler.wild_id = pokemon_wild.wild_id
							   WHERE pokemon_speler.user_id='".$_SESSION['id']."' AND pokemon_speler.opzak='nee' ORDER BY `pokemon_speler`.`id` DESC, pokemon_speler.wild_id ASC ");
	if($aantal_pokemon == 0){
    					$msg = 'Kh??ng có PokeMon nào trong nhà';
    				}
    				else{
    				    for($i=$pagina+1; $pokemon = mysql_fetch_assoc($poke); $i++){
                $pokemon = pokemonei($pokemon);
                $pokemon['naam'] = pokemon_naam($pokemon['naam'],$pokemon['roepnaam']);
                $popup = pokemon_popup($pokemon, $txt);
                #Default
                $shinyimg = 'pokemon';
                $shinystar = '';
                #Shiny?
                if($pokemon['shiny'] == 1){
                  $shinyimg = 'shiny';
                  $shinystar = '<img src="images/icons/lidbetaald.png" width="16" height="16" style="margin-bottom:-3px;" border="0" alt="Shiny" title="Shiny">';
                }
    		  
              
			$msg .= '<a href="javascript:ruongdo_lay('.$pokemon['id'].');"id="item'.$res['id'].'"><div class="items"><div class="daocu" style="background: url('.$pokemon['ducnghia'].'); background-size: 50px;"></div>
			<div class="subitem">'.$pokemon['naam'].'</div>
			</div></a>';
	  

              }
}

$nn = 'My Bag<hr>';
$n = $nn.$msg;

echo $n;




}


if(isset($_POST[amthanh])) {
    if($datauser->sound ==1) {
    		      mysql_query("UPDATE `users` SET `sound`='0',`music`='0' WHERE `id`='".$_SESSION['id']."'");
    		      echo'Tắt âm thanh thành công,vui lòng tải lại game.';
    }
     if($datauser->sound ==0) {
    		      mysql_query("UPDATE `users` SET `sound`='1',`music`='1' WHERE `id`='".$_SESSION['id']."'");
    		      echo'Bật âm thanh thành công,vui lòng tải lại game.';
    }

}
