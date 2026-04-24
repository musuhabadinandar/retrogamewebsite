(function(){
  function noopSocket(){
    return {
      on:function(){ return this; },
      emit:function(){ return this; },
      disconnect:function(){ return this; },
      connected:false,
      offline:true
    };
  }
  var offlineSocket = window.__pokemonOfflineSocket || noopSocket();
  window.__pokemonOfflineSocket = offlineSocket;
  window.io = window.io || { connect:function(){ return offlineSocket; } };
  window.socket = window.socket || offlineSocket;
  window.socket2 = window.socket2 || offlineSocket;
  window.ws = window.ws || { send:function(){} };
})();
  ////chat

var socket = (function(){ var url = window.POKEMON_SOCKET_URL || ''; if (!url || url === 'URLSOCKEY' || typeof io === 'undefined') { console.warn('Pokemon socket disabled for local POC'); return { on:function(){}, emit:function(){}, disconnect:function(){} }; } return io.connect(url); })();

socket.on("socket_chat", function(ducnghiadzvc)	{
    if(ducnghiadzvc != "msg") {
updateChat(ducnghiadzvc); }

});

///ducnghia
var tatc = 0;
var boxchat = 0;
var tipchung = 0;
var tipmap = 0;
var tipfix = 0;

function doichat(idb) {
    boxchat = idb;
   if(idb == 0 && tipchung <= 0) {
           chatMsg("<font color='red'>DucNghia</font> : <b>Vui lòng nói chuyện văn minh,không quảng cáo,spam ! cám ơn.</b> ");
    tipchung =1;
   } 
   
    if(idb == 1 && tipmap <= 0) {
           chatm("<font color='red'>DucNghia</font> : <b>Chỉ những người chơi trong bản đồ mới thấy bạn chát.</b> ");
    tipmap =1;
   } 
   
   
   if(idb == 3 && tipfix <= 0) {
           fixloi("<font color='red'>DucNghia</font> : <b>Kênh này dùng để debui,fix lỗi ! ví dụ bạn bị lỗi kẹt map vui lòng nhập <font color='blue'>/gohome</font>.Xem chi tiết tại hưỡng dẫn.Nếu bạn là admin/người buid map thì hãy gõ <b>data</b> để xem dữ liệu NPC,<b>tao</b> để tạo dữ liệu v.v </b> ");
    tipfix =1;
   } 
    
}

function chatMessage() {
    var t = new Date();
    var time = t.toLocaleDateString() + "/" + t.toLocaleTimeString();
    //alert(time);
    var txt = $("#messageBox").val();
     txt2 = txt.split(" ");
     txt3 = txt.split("_");
     if(txt2[0]=="kick") {

    socket.emit("kick", txt2[1]);
                      fixloi("<font color='red'>DucNghia</font> : <b>Đã đuổi người chơi.</b>");
 
     }else    
if(txt2[0]=="pet") {

 pet(txt2[1]);   
}else    
if(txt2[0]=="caidat") {
caidat();    
}else         
if(txt2[0]=="admin") {
cp();    
}else         
if(txt2[0]=="menux") {
goirong(3);    
}else     
if(txt2[0]=="menu") {
    testo();
}else
    if(boxchat==3) {
 if(txt3[0]=="#") {
     
      $.ajax({
url : '/datalog/modu.php?sua',
type : 'POST',
data : {text : txt3[1]},
success : function(result){

}
});     
 }    else    
         if(txt2[0]=="load") {
    	        	loadMapEvents();

 } else  
  if(txt2[0]=="chat") {
     c(txt2[1])

 } else       
 
   if(txt2[0]=="map") {
     map(txt2[1],30,30,txt2[2])

 } else       
         if(txt2[0]=="admin") {

     admin =1;
 } else      
          if(txt2[0]=="pokemon") {

     mappokemon();
 } else      
         if(txt2[0]=="tao") {

     taodata();
 } else      
   if(txt2[0]=="data") {

     datamap();
 } else      
      if(txt2[0]=="/tat") {
          tatc=1;
           $('#chat_show').toggle('fast','linear');  
	          $('#chat_an').toggle('fast','linear');  
      fixloi("<font color='red'>DucNghia</font> : <b>Ẩn chát thành công.</b>"); } else
 if(txt2[0]=="/gohome") {
     if(tagAlong=="tho") {
              fixloi("<font color='red'>DucNghia</font> : <b>Không thể thực hiện lệnh này</b>");
 
     }else {
     map('t2',30,30,'t2a')
      fixloi("<font color='red'>DucNghia</font> : <b>Bạn đã về nhà.</b>");
     }
     
 } else {
     fixloi("<font color='red'>DucNghia</font> : <b>Không có lệnh này.Vui lòng kiểm tra lại.</b>");
 }
        
    } else {
    
    if(txt.length <1) {
      if(boxchat==0) {
        chatMsg("<b><font color='red'>DucNghia:</font> Xin hãy viết dài hơn.</b>");
} else {
     chatm("<b><font color='red'>DucNghia:</font> Xin hãy viết dài hơn.</b>");
}  
    } else {

    var data = {
        "id": userID,
          "username": userName,
           "mapid": mapID,
     
        "txt": txt,
        "time": time
    };
    
    $("#messageBox").val("");
    if(boxchat==0) {
        chatMsg(""+userName+": " + txt);

    socket.emit("sendchat", data);
} else {
     chatm(""+userName+": " + txt);

    socket.emit("chatmap", data); 
    updateChat('^2|'+userID+'|'+userName+'|'+txt+'|DUCNGHIA');
}

}
}
}


socket.on("chatall", function (data) {
    var us =  JSON.parse(data);
    
    chatMsg('<b onclick="ttnv('+us.id+')">'+us.username+'</b> : '+us.noidung+' ');
 count_chat++;
         	$("#count_chat").html(count_chat);   

})

socket.on("chat", function (data) {

    chatm0(JSON.parse(data));
    console.log(data);

})


///online to map
socket.on("nguoichoi", function (data) {
var a = '';
for (var i in data.ducnghia) {
			
			if (data.ducnghia[i].id>=1 && data.ducnghia[i].mapid == mapID && data.ducnghia[i].id != userID && data.ducnghia[i].icon !="undefined") {
		a+='^'+data.ducnghia[i].id+'|'+data.ducnghia[i].username+'|'+data.ducnghia[i].skin+'|'+data.ducnghia[i].mapid+'|'+data.ducnghia[i].x+'|'+data.ducnghia[i].y+'|'+data.ducnghia[i].direction+'|'+data.ducnghia[i].battle+'|'+data.ducnghia[i].icon+'|'+data.ducnghia[i].viettat+'|'+data.ducnghia[i].pokemon+'|'+data.ducnghia[i].exp+'|'+data.ducnghia[i].xu+'|'+data.ducnghia[i].camxuc+'';		
			}
		}
//console.log(a);
updateMMOEvents('DUCNGHIA'+a);
});

//updateChat to map

socket.on("datachat", function (data) {
	updateChat('DUCNGHIA^2|'+data.id+'|'+data.username+'|'+data.noidung+'|DUCNGHIA');
});

socket.on("online", function (data) {

online = data;

})








function bosstomap(data){
    	for (var i=0; i<data.length; i++) {
		var boss = data[i];
		         $('#hp_boss_'+boss.id+'').html(boss.hp);
    	}
}








/* PVP ONLINE DUCNGHIA*/

socket.on("pvp_moi", function (data) {
if(data==userID) {
    giaotiep('%user% Muốn PVP với bạn ? Bạn đồng ý không ?');
 					$("#npc_menu").html('<b onclick="dongy()" class="nutchat">Chấp Nhận</b> <b onclick="tuchoi()" class="nutchat">Từ chối</b>');
   
}

})

socket.on("pvp_ok", function (data) {
if(data==userID) {
pkok();
    
}
})


socket.on("kick", function (data) {
outkick(data);
})
