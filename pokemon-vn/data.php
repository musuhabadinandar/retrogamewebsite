<?PHP
include_once('templates/config.php');
include_once('templates/header.php');

$kun = base64_decode($_GET['ducnghia'] ?? '');

if (empty($_SESSION['ducnghia_game'])) {
    $_SESSION['ducnghia_game'] = 'local-poc';
}
?>
<script type='text/javascript' src='sql/database.js?ab'></script>
<script type='text/javascript' src='sql/ducnghia.js?code'></script>
<script type="text/javascript">
$(document).ready( function () {
    dulieu();
});
</script>
<style>
html{background-color: rgba(246, 220, 161, 0.5);
    background-image: url("/sql/58422.jpg");
    
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


<!------------------->
<div id="chien" class="none">0</div>
<div id="auto" class="none">10</div>
<div id="time_auto" class="none">0</div>
    <div class="container" style="width: 99%;">




				<div id="mws-explore-area" style="height:457px;">
				    
	<div id="nghiait_att" style=" display: none; height: 90px; z-index: 11; font-size: 11px; width: 350px; color: rgb(17, 17, 17); position: absolute; left: 68px;  border: 1px solid rgba(0, 0, 0, 0.15); top: 190px;">
<div id="infotran" style="z-index:4;position: absolute;top: -30px;font-size: 13px;color: 000000;padding-top: 16px;text-align:center;background: url(/img/canvas/notice.png) no-repeat;background-position: center top;background-size: 100% 100%;width: 200px;height: 40px;"><b>Info</b></div>	 
	    
	  <div id="nghiait_att_data"></div>  
	</div>			    
				    
						<canvas id="cvsGame" width="490" height="447" style="width:100%;height:447px;"></canvas>
					
				<div id="canvas" style="display:none;position: absolute;background: url(/img/canvas/duc.png) no-repeat;height: 413px;background-position: center top;background-size: 100% 100%;z-index:10;">
			<div id="canvas_game" style="z-index:4;position: absolute;top: 10px;font-size: 13px;color: red;padding-top: 10px;text-align:center;background: url(/img/canvas/ui_activitylayer_17.png) no-repeat;background-position: center top;background-size: 100% 100%;width: 200px;height: 40px;"><b>Info</b></div>	  
			
			<div id="canvas_out" style="position:absolute;top:0px;"><img onclick="c_canvas()" src="/img/canvas/ui_openService_13.png"></div>
				 
				 <div id="canvas_data" style="overflow-y:auto;height: 330px;position:absolute;top:60px;left:5px">zzzzzzz</div>   
				    
				</div>				
				
		<div id="ducnghia_canvas" ></div>				
				

	<div id="ducnghia_nhanthuong" style="display:none;height: 172px;z-index : 55;top: 200px;
font-size:11px;width:326px;color:#FFF;position:absolute;left:36px;background:  url(img/ducnghia/nhanthuong.png) 0 0/cover no-repeat;background-repeat: no-repeat;">



<div id="ducnghia_nhanthuong_data" style="overflow-y: auto;
    height: 60px;
    position: absolute;
    top: 55px;
    left: 50px;">
</div>

<center><div  id="nut_nhan" style="
    position: absolute;
    top: 120px;left:160px;
   "><img src="/img/ducnghia/nhan.png" onclick="c_nhanthuong()"></div></center>
	</div>		
				
						
		<div id="ducnghia_menu" style="display:none;height: 401px;z-index : 5;top: 60px;
font-size:11px;width:350px;color:#FFF;position:absolute;left:36px;background:  url(img/ducnghia/info.png);background-position: center top;
    background-size: 100% 100%;background-repeat: no-repeat;"> <div id="ducnghia_menu_out" style="position:absolute;top:10px;"><img onclick="c_menu()" src="/style/images/game/close.png"></div>

<div  style="left:15px;position:absolute;top:10px;height:58px;"><b class="phai" id="menu_name">Pokemon Vietnam</b></div>

<div id="ducnghia_data" style="overflow-y:auto;height: 330px;position:absolute;top:50px;left:5px">
</div>


	</div>					
	<!------------>
	<div id="table_game" class="pokedetailcontainer" style="
    background-color: rgb(47, 49, 48);
    box-shadow: 12px 9px 15px rgba(0, 0, 0, .5);
    z-index: 11;top: 60px;position:absolute;display:none;"></div>
	
	<!------------->
	
	<div id="gameChatBar" class="" style="opacity: 0.5;"><div id="chat_show">
	    <ul id="myTab" class="nav nav-tabs"><li class="active"><a id="ducnghia_chat2" href="#chatConsole" data-toggle="tab" onclick="doichat(0)">Chat(<b class="viptxt" id="count_chat">0</b>)</a></li><li class=""><a href="#playerList" data-toggle="tab" id="ducnghia_chat3" onclick="doichat(1)">Map</a></li> <li class=""><a href="#fixloi" data-toggle="tab" id="ducnghia_chat4" onclick="doichat(3)">Fix</a></li></ul><div class="tab-content"><div class="tab-pane active" id="chatConsole"></div><div class="tab-pane" id="playerList"></div> <div class="tab-pane" id="fixloi"></div></div><div class="table-bordered " style="position:absolute; bottom:0px;"><input type="text" id="messageBox" onkeydown="if(event.keyCode == 13) chatMessage();" style="width: 100%;border: 0px solid #ffffff;border-radius: 25px;background-color: rgba(0,0,0,0);color:red;    outline: 0!important;       
" placeholder="Type a message..."></div>
</div>
<div id="chat_an" style="display:none;"><font color="red">click chat</font></div>


</div>
	
	
		
	<div id='ducnghia_dichuyen' style='display:none;'>
				
					<center> 			
	<button id="Up"  onclick="wsgo(1)" style="width: 50px;height : 50px;position: absolute;top: 0px;left:55px" class="ducnghia_nutbam admin">↑</button>				
<br>
	<button id="Left" onclick="wsgo(2)" style="width: 50px;height : 50px;position: absolute;top: 0px;left:0px" class="ducnghia_nutbam admin"><</button>				


	<button id="A" onclick="wsgo(5)" style="width: 50px;height : 50px;position: absolute;top: 0px;left:110px" class="ducnghia_nutbam admin">A</button>	
	

	<button id="Right" onclick="wsgo(3)" style="width: 50px;height : 50px;position: absolute;top: 0px;left:110px" class="ducnghia_nutbam admin">></button>				

<br>

	<button id="Down" onclick="wsgo(4)" style="width: 50px;height : 50px;position: absolute;top: 0px;left:55px" class="ducnghia_nutbam admin">↓</button>				

</center>  



					    
					    
					</div>				
		
		
			<div id='divKeys' style='display:none;'>
				
					<center id="ziehen"> 			
	<button id="keyUp" style="width: 50px;height : 50px;position: absolute;top: 0px;left:55px" class="ducnghia_nutbam admin">↑</button>				
<br>
	<button id="keyLeft" style="width: 50px;height : 50px;position: absolute;top: 0px;left:0px" class="ducnghia_nutbam admin"><</button>				


	<button id="keyA" style="width: 50px;height : 50px;position: absolute;top: 0px;left:110px" class="ducnghia_nutbam admin">A</button>	
	

	<button id="keyRight" style="width: 50px;height : 50px;position: absolute;top: 0px;left:110px" class="ducnghia_nutbam admin">></button>				

<br>

	<button id="keyDown" style="width: 50px;height : 50px;position: absolute;top: 0px;left:55px" class="ducnghia_nutbam admin">↓</button>				

</center>  



					    
					    
					</div>			
						
			<!--------------->
	    
		
			<!--------------->
			<!------------->
			<div id="ducnghia_giaotiep" style="display: none;height: 126px;z-index: 15;font-size: 11px;width: 312px;color:000000;position: absolute;left: 36px;background: url(/img/canvas/ui_offlineLayer_8.png) no-repeat;background-position: center top;background-size: 100% 100%;"><b id="ducnghia_npc" style="position : absolute;top:17px;left:20px;overflow-y: auto;height: 90px;"></b>	</div>	

	<div id="ducnghia_menu_giaotiep" style="overflow-x: auto;display: none; height: 78px;z-index: 14; font-size: 11px;width: 350px;color: rgb(255, 255, 255);position: absolute; left: 36px;"><span id="npc_menu"></span><B onclick="c_giaotiep()" class="nutchat">Close</B></div>	
					    <!---------------CODE CỬA HÀNG,THÔNG TIN POKEMON V>V---------------->

	
	<!-------------SHOW NHIỆM VỤ,AUTO,TIN NHẮN------------->
	<div
style="position: absolute;
    top: 50px;
    z-index: 0;
    color: #FFFFFF;
    word-break: break-all;
    font-size: 12px;z-index :0; "><p class="ducnghia_connet">
        
    

<b class="ducnghia_connet">
    <br> <font color="357ebd"><b id="nhiemvu"></b> <br> <b  id="sms"></b> <br>
      <span id="t_au" style="display: none;"></span>

    </font>
    </b>
     <br>


<b id="vitripkm_x" style="display:none;"></b> 
<b id="vitripkm_y" style="display:none;"></b>


     </p></div>
	    
	    	<div id="listonline" style="overflow-y: auto;display: none;height: 90px;z-index: 4; font-size: 11px;width: 350px;color: #111;position: absolute;left: 36px;background: rgba(249,249,249,0.25);border: 1px solid rgba(0,0,0,.15);top: 190px;"></div>
	
	<!----------------ducnghia---------------->
			<!-----------chát---------->
			

			
		<!-------BẠN BÈ V.V------>
		<div id="menu_nho" style="overflow-y: auto;display: none;height: 90px;z-index: 15; font-size: 11px;width: 350px;color: #111;position: absolute;left: 36px;background: rgba(249,249,249,0.25);border: 1px solid rgba(0,0,0,.15);top: 190px;"></div>
		<!----------------------->
			<!----------------------------->
			<div id="map_button_nut_x" 
style="position: absolute;
    top: 448px;
    z-index: 1;
    /* width: 385px; */
    height: 30px;
    margin: 0px auto;
    color: #fafafa;
    word-break: break-all;
    font-size: 12px;
    right: 0px;"><img height="18" src="/img/t/menu.png" onclick="map_b()"></div> 
    
     <div id="map_button_xxx" 
style="position: absolute;
    top: 83px;
    z-index: 1;
    margin: 0px auto;
    color: #fafafa;
    word-break: break-all;
    font-size: 12px;
    right: 0px;display: none;">
         
                  <p class="ducnghia_thongbao" onclick="map_thongbao()"></p>

                <p class="ducnghia_tui" onclick="tuido()"></p>
                <p class="ducnghia_nhiemvu" onclick="nhiemvu()"></p>
                <p class="ducnghia_tinnhan" onclick="mychat()"></p>
                 <p class="ducnghia_auto" onclick="autov()"></p>
                 <p class="ducnghia_banbe" onclick="banbe()"></p>

                 <p class="ducnghia_dctt" onclick="tabdichchuyen()"></p>
                 <p class="ducnghia_chon" onclick="web_dichuyen()"></p>
                 <p class="ducnghia_naptien" onclick="naptien()"></p>

        <p class="ducnghia_giatoc" onclick="giatoc()"></p>
              <p><img onclick="pokemon_on_map()" src="/img/ducnghia/GM.png" height="40"></p>

                <p class="ducnghia_dongmenu" onclick="map_b()"></p>

    
    </div> 
			
		
			<!-------------------------->
			<!------------------>
				<div style="display:block;" id="ducnghia_in"> 
</div>		

	
  
						
					<div id="phaohoa" class="phaohoa" style="
    overflow-y: auto;
    height: 256px;
        display: none;

    z-index: 0;
    font-size: 11px;
    width: 235px;
    color: rgb(17, 17, 17);
    position: absolute;
    left: 70px;
    top: 50px;"></div>	
						
						
						</div>

					<img id='curMonImage' style='display:none;position:absolute;' src='/images/blank.png'/>
					<img id='curOppImage' style='display:none;position:absolute;' src='/images/blank.png'/>
					<img id='curMonImageAni' style='display:none;position:absolute;' src='/images/blank.png'/>
					<img id='curOppImageAni' style='display:none;position:absolute;' src='/images/blank.png'/>
					
					
			
				
					
				
	
					  

					<!--------code by ducnghia------>
					<div>
					    
					    
					    <!------------------------------>
					    
					    <!-------------------------------->
		
			
			<!------------------code giao tiếp-------------->
			<div id="ducnghia_info_g" style="display:none;font-size:11px;padding-right:50px;width:200px;color:#FFF;padding-top:5px;position:absolute;left:20px;top:142px;background-image:url('/images/bubble_encounter_right.png');">
					     <p id="ducnghia_menu_data"></p>
					
					</div>
			
				<div id="ducnghia_pkm" style="display:none;font-size:11px;padding-right:50px;width:200px;color:#FFF;padding-top:5px;position:absolute;left:20px;top:142px;background-image:url('/images/bubble_encounter_right.png');">
					    
					
					</div>

				<div id="mws-explore-trade-or-battle" style="display:none;font-size:11px;padding-right:50px;width:200px;color:#FFF;padding-top:5px;position:relative;left:20px;top:-342px;background-image:url('/images/bubble_encounter_right.png');">
					    
					
					</div>


				



				<!-- Panels End -->
			
				
            </div></div>


SESSION['ducnghia_game'])) {
<?PHP
include_once('templates/config.php');

	include_once('templates/header.php');

$kun = base64_decode(($_GET['ducnghia'] ?? ''));

if(empty($_SESSION['ducnghia_game'])) {
    echo'DucNghia : nodata.';
    exit();
} else {
    $_SESSION['ducnghia_game'] ='';
}
?>


