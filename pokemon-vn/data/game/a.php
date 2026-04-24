<?php

if(isset($_POST['open'])) {
    ?> <br>
    <center>Bạn muốn làm gì ?</center>    
    
      <button onclick="huongdan(1)">Tra Kĩ Năng</button>
      <button onclick="huongdan(2)">Tra PokeMon</button>
      

    <?PHP
}

if(isset($_POST['1']) or isset($_POST['2'])){ 
if(isset($_POST['1'])){ 
    $ducnghiax = 'move';
} else {
      $ducnghiax = 'pokemon';
  
}
?>		

<br>
    <center>POKEMON DEV</center>    
		<script type="text/javascript">
$(document).ready(function() {
  $('#name').keyup(function() {
  var name = $('#name').val();
				$('#data_kitu').html(name);	
$.ajax({
url : code(),
type : 'POST',
data : {name : name , <?=$ducnghiax?> : <?=$ducnghiax?>,a:'a'},
success : function(result){
var xx = $.parseJSON(result);
				$('#ducnghia_dulieu').html(xx.msg);	
}
});
}) 
});
</script>


	Tìm kiếm :	 <span id="data_kitu">Take Down,PikaChu,Mega,grass,ID v.v</span>  <br>

                <input  name="query" type="text" id="name" />
            <div id="ducnghia_dulieu" class="faq-articles"> </div>
<?PHP } ?>

<?PHP
if(isset($_POST['move'])){		
   $keyword = 	trim($_POST['name']) ;	
	$keyword = mysql_real_escape_string($keyword);
	$query = "select * from aanval where naam like '%$keyword%' ORDER BY `id`  DESC LIMIT 0, 10 ";
	$result = mysql_query($query);
	if($result){
		if(mysql_affected_rows($mysql)!=0){  
			// Hiển thị dữ liệu
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			    $attack=$row;
			    	if(($attack['effect_kans'] == '0') OR ($attack['effect_kans'] == '') OR (($attack['effect_naam'] != 'Sleep') AND ($attack['effect_naam'] != 'Paralyzed') AND ($attack['effect_naam'] != 'Poisoned') AND ($attack['effect_naam'] != 'Flinch') AND ($attack['effect_naam'] != 'Burn') AND ($attack['effect_naam'] != 'Freeze') AND ($attack['effect_naam'] != 'Confued'))) $effect = 'Không';
					else $effect = $attack['effect_kans'].'% '.$attack['effect_naam'];
										$accuracy = 100 - $attack['mis'];

			$data .= '<center>
  

	
	
	  <table>
		<tbody>
		<tr>
			<td width="50%"><b>Tên:</b></td>
		<td width="50%"><b style="font-size: 25px;font-family: ducnghiait;">'.$row[naam].'</b></td>
		</tr>
		<tr>
		
			<td width="50%"><b>Hệ:</b></td>
			<td width="50%"><table><tbody><tr><td style="font-size: 25px;font-family: ducnghiait;"><div class="type '.$row[soort].'">'.$row[soort].'</div></td></tr></tbody></table></td>
		
		</tr>
		<tr>
			<td width="50%"><b>T.Công:</b></td>
			<td width="50%"><b style="font-size: 17px;font-family: ducnghiait;">'.$row[sterkte].'</b></td>
		</tr>
	
	
		<tr>
			<td width="50%"><b>C.Xác:</b></td>
			<td width="50%"><b style="font-size: 17px;font-family: ducnghiait;">'.$accuracy.'</b>%</td>
		</tr>
		
		<tr>
			<td width="50%"><b>H.Ứng %:</b></td>
			<td width="50%"><b style="font-size: 25px;font-family: ducnghiait;">'.$effect.' </b></td>
		</tr>
		
	
		
	  </tbody></table>  
	  <center><img src="/ducnghia/_/'.strtolower($row[soort]).'.gif"></center>

	  
  
  
   </center>'   ;
		}
		}else {
			$data .= 'không có kĩ năng nào tên :"'.$_POST['keyword'].'"';
		}
	}
		$json[msg] = $data;


echo json_encode($json);
	}
	
	
	
if(isset($_POST['pokemon'])){	
     $keyword = 	trim($_POST['name']) ;	
	$keyword = mysql_real_escape_string($keyword);
	$query = "select * from pokemon_wild where naam like '%$keyword%' or wild_id like '%$keyword%' or type1 like '%$keyword%' or type2 like '%$keyword%' LIMIT 50";
	$result = mysql_query($query);
	if($result){
		if(mysql_affected_rows($mysql)!=0){  
			// Hiển thị dữ liệu
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			$data .=' <a href="javascript:info('.$row[wild_id].');"><div class="ducnghia_pokemona" style="background-image:url(/images/pokemon/icon/'.$row[wild_id].'.gif);background-position:right center;background-repeat:no-repeat;">#'.$row[wild_id].' '.$row[naam].'</div></a>   '   ;
		}
		}else {
			$data .= 'không có pokemon nào tên :"'.$keyword.'"';
		}
	}
	$json[msg] = $data;


echo json_encode($json);
	}
	
