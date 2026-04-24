<?PHP
include_once('../includes/ducnghiadz.php'); include_once('../language/language-general.php'); include_once('../includes/config.php'); include_once('../includes/ingame.inc.php');include_once('../includes/ducnghia.php');include_once('../_GNPANEL/_NEWTECH/Pusher.php');

$error = "<center><div style='padding-bottom:10px;'>Chọn PokeMon Để sử dụng  đá<b class='viptxt'>  ".$_GET['name']."</b>.</div></center>"; 
$gebruiker_item = mysql_fetch_array(mysql_query("SELECT * FROM `gebruikers_item` WHERE `user_id`='".$_SESSION['id']."'"));

if($gebruiker_item[$_GET['name']] <= 0){
	header("Location: index.php?page=home");
	?>
  
  <?
}


  ?>

    <center>
    <table width="100%" border="0">
    	<tr> 
    		<td colspan="5"><? if($error) echo $error; else echo "&nbsp"; ?></td>
    	</tr>
    	<tr> 
    		<td width="50"><center><strong>&raquo;</strong></center></td>
    		<td width="100"><strong>Pokemon:</strong></td>
    		<td width="150"><strong>Tên:</strong></td>
    		<td width="100" align="center"><strong>Cấp:</strong></td>
    		<td width="100" align="center"><strong>T.Hóa:</strong></td>
    	</tr>
    	<tr>
    <?
    //Pokemon laden van de gebruiker die hij opzak heeft
    $poke = mysql_query("SELECT pokemon_wild.* ,pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id WHERE user_id='".$_SESSION['id']."' AND `opzak`='ja' ORDER BY `opzak_nummer` ASC");
    
    //Pokemons die hij opzak heeft weergeven  
    for($teller=0; $pokemon = mysql_fetch_array($poke); $teller++){
      $kan = "<img src='../images/icons/red.png' alt='Kan niet'> KO THỂ TIẾN HÓA";
      $disabled = 'disabled';   
      //Als er een result is kan pokemon evolueren.
      $stoneevolvesql = mysql_query("SELECT `id`, `stone`, `nieuw_id` FROM `levelen` WHERE `wild_id`='".$pokemon['wild_id']."' AND `stone`='".$_GET['name']."'");
      $stoneevolve = mysql_fetch_array($stoneevolvesql);
      
      //Heeft de stone werking?
      if(mysql_num_rows($stoneevolvesql) >= 1){
      	$kan = "<img src='../images/icons/green.png' alt='Kan wel'> Được";
      	$disabled = '';
      }
    
      //Als pokemon geen baby is
      if($pokemon['ei'] != 1){
        echo '
          <td><center><input type="hidden" name="levelenid" id="levelenid" value="'.$stoneevolve['id'].'">
          <input type="radio" name="pokemonid"  id="pokemonid" value="'.$pokemon['id'].'/'.$stoneevolve['id'].'/'.$pokemon['naam'].'/'.$pokemon['wild_id'].'" '.$disabled.'/>
          <input type="hidden" name="pokemonnaam" id="pokemonnaam" value="'.$pokemon['naam'].'"></center></td>
        ';             
      }
      else
        echo '<td><center><input type="radio" id="niet'.$i.'" name="niet" disabled/></center></td></td>';
      
      $pokemon = pokemonei($pokemon);
      $pokemon['naam_goed'] = pokemon_naam($pokemon['naam'],$pokemon['roepnaam']);
      
      echo '
        <td><center><img src="../'.$pokemon['animatie'].'" width="32" height="32" onclick="pokemon('.$pokemon['id'].');"></center></td>
        <td>'.$pokemon['naam_goed'].'</td>
        <td>'.$pokemon['level'].'</td>
      ';
      
      //Als pokemon geen baby is
      if($pokemon['ei'] != 1) echo '<td>'.$kan.'</td>';
      else echo '<td>Error</td>';
      	
      echo '</tr>';
    }
    
  
     ?>
      <tr> 
        <td colspan="5">
        <Center><a href="javascript:hienthi_tienhoa('<? echo $_GET['name']; ?>')"><button>Tiến Hóa</button> </a></Center></td>
      </tr>
     
    </table>
    </center>
   
    <?
    
  
?>
</body></html>