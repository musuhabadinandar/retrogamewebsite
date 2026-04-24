<style>
.ducnghia_open_thongbao {
 display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity


/* Modal Content */
}
.ducnghia_thongbao {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.ducnghia_dong_thongbao {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.ducnghia_dong_thongbao:hover,
.ducnghia_dong_thongbao:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>


<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="ducnghia_thongbao" class="ducnghia_open_thongbao">

  <!-- Modal content -->
  <div class="ducnghia_thongbao">
    <span class="ducnghia_dong_thongbao">&times;</span>
<!--DỮ LIỆU--->


  


<!--ĐÓNG DỮ LIỆU BY DUCNGHIA--->

  </div>

</div>

<script>
// Get the modal
var ducnghia_thongbao = document.getElementById('ducnghia_thongbao');

// Get the button that opens the modal
var ducnghia_thongbao = document.getElementById("ducnghia_thongbao");

// Get the <span> element that closes the modal
var ducnghia_dong_thongbao = document.getElementsByClassName("ducnghia_dong_thongbao")[0];

// When the user clicks the button, open the modal 
ducnghia_thongbao.onclick = function() {
    ducnghia_thongbao.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
ducnghia_dong_thongbao.onclick = function() {
    ducnghia_thongbao.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == ducnghia_thongbao) {
        ducnghia_thongbao.style.display = "none";
    }
}
</script>



















































<style>
.ducnghia_open_thegioi {
 display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity


/* Modal Content */
}
.ducnghia_thegioi {
        background: url(/img/04be72a5f0cfd1202ffb277288c7cee6.png);
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.ducnghia_dong_thegioi {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.ducnghia_dong_thegioi:hover,
.ducnghia_dong_thegioi:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>


<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="ducnghia_thegioi" class="ducnghia_open_thegioi">

  <!-- Modal content -->
  <div class="ducnghia_thegioi">
    <span class="ducnghia_dong_thegioi">&times;</span>
<!--DỮ LIỆU--->
<center>BẠN MUỐN ĐI ĐÂU ?</center>
<div id="errorxxx"></div> <div id="okxxx"></div>
<?php
    $prijs['kanto'] = 5;
$prijs['kantototaal'] = $prijs['kanto']*$gebruiker['aantalpokemon'];
$prijs['johto'] = 10;
$prijs['johtototaal'] = $prijs['johto']*$gebruiker['aantalpokemon'];
$prijs['hoenn'] = 15;
$prijs['hoenntotaal'] = $prijs['hoenn']*$gebruiker['aantalpokemon'];
$prijs['sinnoh'] = 20;
$prijs['sinnohtotaal'] = $prijs['sinnoh']*$gebruiker['aantalpokemon'];
$prijs['unova'] = 50;
$prijs['unovatotaal'] = $prijs['unova']*$gebruiker['aantalpokemon'];

$prijs['kalos'] = 100;
$prijs['kalostotaal'] = $prijs['kalos']*$gebruiker['aantalpokemon'];
$prijs['alola'] = 150;
$prijs['alolatotaal'] = $prijs['alola']*$gebruiker['aantalpokemon'];

#Als er op de knop gedrukt word
?>

<form method="post"> 
    <table width="550" style="width:100%;height:100%;" cellpadding="0" cellspacing="0">
      <tr>
        <td width="70" class="top_td"><center>#</center></td>
        <td width="100" class="top_td">Quê Hương</td>
        <td width="160" class="top_td">Phí</td>
        <td width="130" class="top_td">Tổng Cần</td>
      </tr>
      <tr>
                  <td class="normal_td"><center><label for="traveljohto">1</center></label></td>

        <td class="normal_td"><label for="travelkanto">Kanto</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['kanto']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['kantototaal']; ?></td>
      </tr>
      <tr>
                  <td class="normal_td"><center><label for="traveljohto">2</center></label></td>

        <td class="normal_td"><label for="traveljohto">Johto</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['johto']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['johtototaal']; ?></td>
      </tr>
      <tr>
        <td class="normal_td"><center>3</center></td>
        <td class="normal_td"><label for="travelhoenn">Hoenn</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['hoenn']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['hoenntotaal']; ?></td>
      </tr>
      <tr>
        <td class="normal_td"><center>4</center></td>
        <td class="normal_td"><label for="travelsinnoh">Sinnoh</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['sinnoh']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['sinnohtotaal']; ?></td>
      </tr>
      <tr>
        <td class="normal_td"><center>5</center></td>
        <td class="normal_td"><label for="travelunova">Unova</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['unova']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['unovatotaal']; ?></td> 
        
        
         
      </tr> <tr>
      <td class="normal_td"><center>6</center></td>
        <td class="normal_td"><label for="travelunova">Kalos</label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['kalos']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['kalostotaal']; ?></td> </tr>
      
        <tr>
      <td class="normal_td"><center>7</center></td>
        <td class="normal_td"><label for="travelalola">Alola </label></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['alola']; ?></td>
        <td class="normal_td"><img src="images/icons/silver.png" title="Silver"> <? echo $prijs['alolatotaal']; ?></td> </tr>

      
     

       
			   
        <td><center>
            <select id="wereld" class="text_select">
			   <option value="Kanto">Kanto</option>
			   <option value="Johto">johto</option>
			   <option value="Hoenn">hoenn</option>
			   <option value="Sinnoh">sinnoh</option>
			   <option value="Unova">unova</option>
			    <option value="Kalos">kalos</option>
			     <option value="Alola">alola</option>
			   
			   <br>
            
            
            <input type="submit" id="btn_submitx" name="travel" value="Đi tới" class="button_mini" /></center></td>
        <td colspan="3">&nbsp;</td>
      </tr>
    </table>
</form>
</center>

    <script language="javascript">
		$("#btn_submitx").on("click", function(){
		var wereld = $("#wereld").val();
		var errorxxx = $("#errorxxx");
		var okxxx = $("#okxxx");
 		errorxxx.html("");
		okxxx.html("");
 
		$.ajax({
		  url: "/ajax_call/ducnghia_travel.php",
		  method: "POST",
		  data: { wereld : wereld },
		  success : function(response){
		  	if (response == "1") {
		  		errorxxx.html("Bạn không đủ tiền để đi tới khu vực này.");
		  
		  
		  	}else if (response == "3") {
		  	okxxx.html("<div class='green'>Đi đến khu vực này thành công.</green>");

		  	}
		  }	});	});
</script> 


<!--ĐÓNG DỮ LIỆU BY DUCNGHIA--->

  </div>

</div>

<script>
// Get the modal
var ducnghia_thegioi = document.getElementById('ducnghia_thegioi');

// Get the button that opens the modal
var ducnghia_mo_thegioi = document.getElementById("ducnghia_mo_thegioi");

// Get the <span> element that closes the modal
var ducnghia_dong_thegioi = document.getElementsByClassName("ducnghia_dong_thegioi")[0];

// When the user clicks the button, open the modal 
ducnghia_mo_thegioi.onclick = function() {
    ducnghia_thegioi.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
ducnghia_dong_thegioi.onclick = function() {
    ducnghia_thegioi.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == ducnghia_thegioi) {
        ducnghia_thegioi.style.display = "none";
    }
}
</script>



















