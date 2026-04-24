
<div id="ducnghia_loadmap">
    <script>
    setTimeout(function(){

        	$('#ducnghia_loadmap').load('/_ajax/loadmap.php?map=<?=$datauser[map_num]?>&ducnghia_x=<?=$datauser[map_x]?>&ducnghia_y=<?=$datauser[map_y]?>');
    },50);
    

    </script>
 </div>
			<div style="clear: both;"></div>



<button onclick="chuyenmap(1,1)">Fix lag</button>

		<!------source di chuyển mobile----->
	<table id="ziehen" style="display: none;position: absolute; z-index:50; left: 79px; top:625px;">
				<tbody><tr>
					<td></td>
					<td><img src="/_ajax/button/len.png" id="button1" tabindex="0" onclick="dichuyen('up');"></td>
					<td></td>
				</tr>
				<tr>
					<td><img src="/_ajax/button/trai.png" id="button2" tabindex="0" onclick="dichuyen('left');"></td>
					<td style="text-align: center; cursor: move; vertical-align: middle;">
					<img src="/_ajax/button/giua.png" id="draggy">
					</td>
					<td><img src="/_ajax/button/phai.png" id="button3" tabindex="0" onclick="dichuyen('right');"></td>
				</tr>
				<tr>
					<td></td>
					<td><img src="/_ajax/button/xuong.png" id="button4" tabindex="0" onclick="dichuyen('down');"></td>
					<td></td>
				</tr>
			</tbody></table>		
		
		
			



</center>

</div>

</div>

<style>
    #chat_ducnghia {background-color:rgb(0,255,0);}

</style>




