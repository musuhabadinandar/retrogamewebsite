<?php
//Sicherheit
include("includes/security.php");

//$page = 'Minimon_welt';

if($gebruiker['in_hand'] == 0) header('location: index.php');

$map2 = (int) $_GET['map']; 
$ap2= mysql_real_escape_string($map2);
$map = strip_tags($ap2);

$uid = (int) $_SESSION['id'];

//Are player pokemon alive?
$kill_query = mysql_query("SELECT `opzak`, `leven`, SUM(`leven`) as `endleben` FROM `pokemon_speler` WHERE `user_id`='{$uid}' AND `opzak`='ja'");

while ($endleben = mysql_fetch_assoc($kill_query)){
	if($endleben['endleben'] <= 0){
	header("Location: ?page=pokemoncenter&pokedead");
	}
}

/////chỗ này
        include("attack/ducnghia.php");
        mysql_query("UPDATE `gebruikers` SET `ducnghia_map`='$map' WHERE `user_id`='$user_id'");

        include("attack/ducnghia/$map.php");
        include("attack/loithoai.php");

?>
<!--thống kê bản đồ by ducnghia-->




<table id="ziehen" style="position: absolute; z-index:50; left: <?php echo $gebruiker['arrow_x']; ?>px; top: <?php echo $gebruiker['arrow_y']; ?>px;">
				<tbody><tr>
					<td><img src="images/in_battle0.gif"></td>
					<td><img src="images/arrows/up.png" id="button1" tabindex="0" onclick="nachOben();"></td>
					<td><img src="images/in_battle0.gif"></td>
				</tr>
				<tr>
					<td><img src="images/arrows/left.png" id="button2" tabindex="0" onclick="nachLinks();"></td>
					<td style="text-align: center; cursor: move; vertical-align: middle;">
					<img src="images/draggable.png" id="draggy">
					</td>
					<td><img src="images/arrows/right.png" id="button3" tabindex="0" onclick="nachRechts();"></td>
				</tr>
				<tr>
					<td><img src="images/in_battle0.gif"></td>
					<td><img src="images/arrows/down.png" id="button4" tabindex="0" onclick="nachUnten();"></td>
					<td><img src="images/in_battle0.gif"></td>
				</tr>
			</tbody></table>	


			<?Php 
			if($map == 1){
			    $ducnghia_txt = 'CAO NGUYÊN';
			} else 
			if($map ==2){
			    $ducnghia_txt = 'BIỂN PHÍA ĐÔNG';
			} else
				if($map ==3){
			    $ducnghia_txt = 'HANG ĐỘNG';
			} else
				if($map ==5){
			    $ducnghia_txt = 'PHÍA DƯỚI HANG ĐỘNG';
			}
			else
				if($map ==6){
			    $ducnghia_txt = 'LÀNG CHÀI';
			}
			else
				if($map ==7){
			    $ducnghia_txt = 'NHÀ THI ĐẤU';
			}
			else
				if($map ==4){
			    $ducnghia_txt = 'CĂN PHÒNG MA';
			}
				else
				if($map ==8){
			    $ducnghia_txt = 'LÀNG CỔ';
			}
				else
				if($map ==21){
			    $ducnghia_txt = 'RỪNG MÊ HOẶC';
			}
			

			?> 			<div id="#map">
<b ><center><h2 style="background-image: url(/img/backround3.gif);width:350px;"><< <?=$ducnghia_txt?> >></h2></center> </b><br>
<table align="center">
	<tr>
		<td>
		    <center>
		        <style>
.center {
     margin: auto;
    width: 100%;
    border: 3px solid #73AD21;
    padding: 10px;
   
}
</style>
<!--CHỖ NÀY LÀ ÂM NHẠC-->
 <audio width="300" height="32" src="/php/music/map<?=$map?>.mp3" autoplay="autoplay"> </audio>


<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

<style>
div#mws-sidebar
{
	width:100px;
}

div#mws-container
{
	margin-left:106px;
	
}

div#mws-sidebar-stitch
{
	left:89px;
}



div#mws-sidebar-bg
{
	width:100px;
}

div#mws-searchbox
{
	margin:0 10px 10px 6px;
	padding:3px;
}

div#mws-searchbox .mws-search-input
{
	width:45px;
	padding:1px;
	font-size:82.5%;
}

div#mws-searchbox .mws-search-submit
{
	margin-left:58px;
	width:20px;
	height:20px;
}

div#mws-navigation ul li a, 
div#mws-navigation ul li span
{
	text-align:center;
}

div#mws-navigation ul li a.mws-i-24, 
div#mws-navigation ul li span.mws-i-24, 
div#mws-navigation ul li a.mws-ic, 
div#mws-navigation ul li span.mws-ic
{
	padding:0;
	padding-top:40px;
	padding-bottom:6px;
	background-position:center 8px;
}

div#mws-navigation ul li ul li a, 
div#mws-navigation ul li ul li span
{
	padding:4px 0;
	text-align:center;
}

div#mws-navigation ul li span.mws-nav-tooltip
{
	font-size:11px;
	position:absolute;
	line-height:16px;
	margin:0; right:auto;
	left:60%; top:-4px;
	background:#c00;
	z-index:99999;
	height:16px; min-width:12px;
	padding:0 2px;
	color:#ffffff !important; 
	
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	-o-box-shadow:none;
	-khtml-box-shadow:none;
	box-shadow:none;				
}

div#mws-footer
{
	left:106px;
}

canvas {
    image-rendering: optimizeSpeed;             // Older versions of FF
    image-rendering: -moz-crisp-edges;          // FF 6.0+
    image-rendering: -webkit-optimize-contrast; // Safari
    image-rendering: -o-crisp-edges;            // OS X & Windows Opera (12.02+)
    image-rendering: pixelated;                 // Awesome future-browsers
    -ms-interpolation-mode: nearest-neighbor;   // IE
   max-width: 750px;
}
div#mws-explore-area {
   max-width: 750px;

}

img.imgKey {
	height: 52px;
	width: 56px;
}
</style>
<script type='text/javascript'>
(function(){
 
    var _z = console;
    Object.defineProperty( window, "console", {
	get : function(){
	    if( _z._commandLineAPI ){
		throw "Failure.";
            }
	    return _z; 
	},
	set : function(val){
	    _z = val;
	}
    });
 
})(); 


	var c=document.getElementById("ducnghia_x");
		ctx = c.getContext("2d");
		
		ctx.canvas.width = $("#mws-explore-area").innerWidth();
        ctx.canvas.height = $("#mws-explore-area").innerHeight(); 
		
		cvsWidth = Math.floor(ctx.canvas.width/16+1)*16;
		cvsHeight = Math.floor(ctx.canvas.height/16+1)*16;
		
		if( cvsWidth > 1024 ) {
		    cvsWidth = 1024;
		}
		
	
		loadMapData();			//Async



function loadMapData() {
		
		wipeWildMonsterBox();
		var xmlHttpReq = requestObject();
		self.xmlHttpReq.open("GET", "/tienich/maps/Grassy Patch.xml", true);
		self.xmlHttpReq.onreadystatechange = loadMapDataCallback;
		self.xmlHttpReq.send();
	}
	
	function loadMapDataCallback() {
		if (self.xmlHttpReq.readyState == 4) {
			if (self.xmlHttpReq.responseXML) {
				var resultsNode = self.xmlHttpReq.responseXML.childNodes[1];
				if (!resultsNode) {
					resultsNode = self.xmlHttpReq.responseXML.childNodes[0];
				}
	




</script>
                    <div class="mws-panel-body">

	<div id="mws-explore-area" style="width:100%; height:447px;max-width: 1750px !important;">
						<canvas id="ducnghia_x" width="100%" height="447px"></canvas>
						

		        <center><?=$datauser['username']?></center> <br>
			  <img src="ducnghia/nhanvat/<?php echo $direction; ?>/trainer<?=$datauser['nhanvat']?><?php echo $direction; ?>.png " id="mySprite" title="<?php echo $_SESSION['username']; ?>" style="position: absolute; top: <?php echo (($startY*16)-4); ?>px; left: <?php echo ($startX*16); ?>px; z-index: 2;" /> 
			  
			 
					<div id="ducnghia_my"></div>
										<div id="ducnghia_user"></div>

			  
			  
</div> </div> </div>
			<div style="clear: both;"></div>
		</td>
		



</font></div>
		
		<td>
			<tr id="pInfo" style="display: none;">
			<td>
			<div id="info"></div>
			</td>
			<td>&nbsp;</td>
			</tr>
		</td>
		
			
	</tr>
</table>

<?php $ducnghia_it = mysql_result(mysql_query("SELECT COUNT(*) FROM `gebruikers` WHERE `map_num` = '{$map}' AND `map_lastseen`>='{$ducnghia_hien}'"), 0);
$q = @mysql_query("select * FROM `gebruikers` WHERE `map_num` = '{$map}' AND `map_lastseen`>='{$ducnghia_hien}'");
while ($ducnghiaa = mysql_fetch_array($q)){
$ducnghia_ten[] = '<font color="33CCCC">'.$ducnghiaa['username'].'</font>,';
}
 ?>
 
  
<div>Người trên bản đồ: 
<font color="red"> <?=$ducnghia_it?></font>(<?if ($ducnghia_it > 0){
echo implode(' ',$ducnghia_ten).'';
}?>) 
</center>
<center><a href="?page=attack/fix&ducnghia=<?=$map?>"><button class="button">FIX GÓC KẸT</button></a> - <a href="?page=attack/arrow&ducnghia=<?=$map?>"><button class="button">Hiện Bàn Phím Ảo</button></a>

<Br><a href="/?page=game/bando&chuyen=1"><button class="button">CHUYỂN QUA BẢN ĐỒ DI CHUYỂN</button></a>
</center>
		<Hr>
		  <center>  <a class="button" id="ducnghia_mo_huongdan">HƯỠNG DẪN</a>
		<br><br></center>

<br>
</div>



<!---KẾT THÚC ĐẸP TRAI VC-->

<style>
.ducnghia_open_huongdan {
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
.ducnghia_huongdan {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.ducnghia_dong_huongdan {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.ducnghia_dong_huongdan:hover,
.ducnghia_dong_huongdan:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>



<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="ducnghia_huongdan" class="ducnghia_open_huongdan">

  <!-- Modal content -->
  <div class="ducnghia_huongdan">
    <span class="ducnghia_dong_huongdan">&times;</span>
<!--DỮ LIỆU--->
<center><big><font color="Red" style="background-image: url(/img/backround3.gif);width:350px;">HƯỠNG DẪN
</font></big></center>
1,Chào mừng bạn đến với chức năng di chuyển của PokeMon Việt Nam.
2,chắc hẳn đây là tính năng mới nên còn nhiều người chơi chưa nắm rõ cách chơi,<br>
3,để chơi được các bạn cần di chuyển nhân vật của mình theo 2 cách : <br>
<b>+Đối với điện thoại</b> : nếu chưa hiện bàn phím ảo trên màn hình thì các bạn hãy click vào chữ : <b>HIỆN BÀN PHÍM ẢO</b> <BR>
    <b>+ Đối với máy tính :</b> các bạn dùng nút <b>lên,xuống,trái,phải</b>
trên bàn phím của các bạn để di chuyển.
<br>Khi các bạn bị kẹt thì hãy ấn nút <b>FIX GÓC KẸT</b>
<br>BÀN PHÍM ẢO CÓ THỂ DI CHUYỂN.NÊN HÃY DI CHUYỂN ĐỂ VỊ TRÍ PHÙ HỢP VỚI TAY ĐỂ ĐI LẠI CHO DỄ NHÉ
<br> còn thắc mắc liên hệ ADMIN Đức Nghĩa nhé.
<br>GIỜ THÌ LOAD LẠI TRANG RỒI CHƠI THÔI :D
  </div>

</div>

<script>
// Get the modal
var ducnghia_huongdan = document.getElementById('ducnghia_huongdan');

// Get the button that opens the modal
var ducnghia_mo_huongdan = document.getElementById("ducnghia_mo_huongdan");

// Get the <span> element that closes the modal
var ducnghia_dong_huongdan = document.getElementsByClassName("ducnghia_dong_huongdan")[0];

// When the user clicks the button, open the modal 
ducnghia_mo_huongdan.onclick = function() {
    ducnghia_huongdan.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
ducnghia_huongdan_thegioi.onclick = function() {
    ducnghia_huongdan.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == ducnghia_huongdan) {
        ducnghia_huongdan.style.display = "none";
    }
}
</script>


<div id="result" height="160" style="
margin: 0 auto;
margin-top: -460px;
position: absolute;
width:auto;
max-width: 400px;
z-index: 15;
float: center;
border-radius: 4px;
text-align: center;
display: block;
 background-color: #f5eeee;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
"></div>


