<?php
/* Local POC: maintenance gate disabled after isolated setup. */
include_once('templates/config.php');
	include_once('templates/lib.php');
	include_once('templates/ducnghia.php');
include_once('templates/header.php');

if($_SERVER["SERVER_NAME"]=="pkmw.tk"){
    $_SESSION['ngonngu']='en';
}


$_SESSION['ducnghia_game'] = 'DEV : TRAN DO DUC NGHIA
birthday : 27/06/2004
LIVE : VIET NAM
MY FACEBOOK : fb.com/ducnghiast
MY EMAIL : trandoducnghia@gmail.com
Time : '.date("Y-m-d").'
YOU IP : '.$_SERVER['REMOTE_ADDR'].'
ID:'.rand(1000000000000000,1999900000000000009).'';
$decode = base64_encode($_SESSION['ducnghia_game']);
?>


<script type='text/javascript' src='sql/game.js?poc=20260421c'></script>

<style>
html{background-color: rgba(246, 220, 161, 0.5);
    background-image: url("/sql/58422.jpg");
			background-size: cover;

}
body,p,form,table,img,td,tr,li,ul{margin:0;padding:0;border:0;}
body{	
 max-width: auto;
   margin: auto;
    margin-top: 0;
    font-size: 13px;
    font-family: Comfortaa;
    line-height: 20px;
}
</style>
<center><ducnghia>Loading game data.</ducnghia></center>
        </body>
        </html>
   
