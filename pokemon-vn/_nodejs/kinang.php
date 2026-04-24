<?PHP

include_once('../templates/config.php'); 
include_once('../templates/ducnghia.php'); 

#Code opvragen en decoderen
		  $link = base64_decode($_SESSION['aanvalnieuw']);
		  #Code splitten, zodat informatie duidelijk word
		  list ($nieuweaanval['pokemonid'], $nieuweaanval['aanvalnaam']) = split ('[/]', $link);
		  #Andere huidige pagina toewijzen
  $pokemoninfo  = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, pokemon_wild.naam, pokemon_speler.id, pokemon_speler.aanval_1, pokemon_speler.aanval_2, pokemon_speler.aanval_3, pokemon_speler.aanval_4 FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE `id`='".$nieuweaanval['pokemonid']."'"));
          $finish = False;
          
          
  if(empty($_SESSION['aanvalnieuw'])) {
    echo'<br><div class="kengang"></div><center>Không có</center><div class="kengang"></div>Cậu không có pokemon nào tiến hóa được,hãy rèn luyện rồi quay lại nhé';
    exit;
}        
?>
							
	<br><div class="kengang"></div><center>Move skill PokeMon</center><div class="kengang"></div>	
  <table width="100%" border="0">
        <tr>
          <td width="130" height="120" rowspan="4"><img src="images/pokemon/<? echo $pokemoninfo['wild_id']; ?>.gif" /></td>
          <td colspan="2">PokeMon : <? echo $pokemoninfo['naam']; ?> đã có thể học skill <strong><? echo $nieuweaanval['aanvalnaam']; ?>. <br /></strong>
          bạn có muốn cho PokeMOn bạn học được skill này không ? <strong><? echo $nieuweaanval['aanvalnaam']; ?>?<br /><br /></td>
        </tr>
        <?
        echo '<tr>
          	  
					<td width="178"><a href="javascript:pokemon_skill(1);" class="btn btn-success" style="-webkit-animation: glowing 15ms infinite;-moz-animation: glowing 15ms infinite;-o-animation: glowing 10ms infinite;animation: glowing 15ms infinite;">'.$pokemoninfo['aanval_1'].'</a></td>
				          	
            		<td width="178"><a href="javascript:pokemon_skill(2);" class="btn btn-success" style="-webkit-animation: glowing 15ms infinite;-moz-animation: glowing 15ms infinite;-o-animation: glowing 10ms infinite;animation: glowing 15ms infinite;">'.$pokemoninfo['aanval_2'].'</a> </td>
          		</form>
        	</tr>
        	<tr>
            		<td width="178"><a href="javascript:pokemon_skill(3);" class="btn btn-success" style="-webkit-animation: glowing 15ms infinite;-moz-animation: glowing 15ms infinite;-o-animation: glowing 10ms infinite;animation: glowing 15ms infinite;">'.$pokemoninfo['aanval_3'].'</a> </td>
         		
            		<td width="178"><a href="javascript:pokemon_skill(4);" class="btn btn-success" style="-webkit-animation: glowing 15ms infinite;-moz-animation: glowing 15ms infinite;-o-animation: glowing 10ms infinite;animation: glowing 15ms infinite;">'.$pokemoninfo['aanval_4'].'</a> </td>
       	 	</tr>';
        ?> 
        <tr>
            <td colspan="2"><td width="178"><a href="javascript:pokemon_skill(5);" class="btn btn-success">hủy</a> </td></td>
        </tr>
      </table>
    </center>    
	
		