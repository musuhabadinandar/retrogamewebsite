<?PHP

include_once('../templates/config.php'); 
include_once('../templates/ducnghia.php'); 

 #Code opvragen en decoderen
		  $link = base64_decode($_SESSION['evolueren']);
		  #Code splitten, zodat informatie duidelijk word
		  list ($evolueren['pokemonid'], $evolueren['nieuw_id']) = split ('[/]', $link);
		  
$pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, pokemon_wild.naam, pokemon_wild.groei, pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$evolueren['pokemonid']."'"));

$update = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$evolueren['nieuw_id']."'"));


if(empty($_SESSION['evolueren'])) {
    echo'Cậu không có pokemon nào tiến hóa được,hãy rèn luyện rồi quay lại nhé';
    exit;
}
?>

<br><div class="kengang"></div><center>PokeMon của bạn có thể tiến hóa</center><div class="kengang"></div>
<br>
<div class="kengang"></div>
<center>
    <table width="100%" border="0">
      <tr>
        <td colspan="3"><center>PokeMon <b class=viptxt><?=$pokemon['naam']?></b> có thể tiến hóa thành <b class=viptxt><?=$update['naam']?></b></center></td>
      </tr>
      <tr>
        <td width="200" valign="top"><center><img src="images/<?php if($pokemon['shiny'] == 0) echo 'pokemon'; else echo 'shiny'; ?>/<? echo $pokemon['wild_id']; ?>.gif" /></center></td>
        <td width="86" valign="middle"><center><img src="images/icons/pijl_rechts.png" width="16" height="16" /></center></td>
        <td width="200" valign="top"><center><img src="images/<?php if($pokemon['shiny'] == 0) echo 'pokemon'; else echo 'shiny'; ?>/<? echo $update['wild_id']; ?>.gif" /></center></td>
      </tr>
      <tr>
        <td colspan="3">
        <center>
       
        <a href="javascript:tienhoaok(1)"><button>Tiến Hóa</button></a>
              - 
            <input type="submit"  value="Không" class="button" oncick="tienhoaok(2)">


        </center></td>
      </tr>
    </table>
  </center>
  <div class="kengang"></div>