///  || OR
// && AND
var imgload = '/sql/load/pokemon_swordshield_galar-1200x1698.jpg';
var imglogo = '/sql/load/pokemmo.png';
var version = '4.0.0';
(function($) {
  var IS_IOS = /iphone|ipad/i.test(navigator.userAgent);
  $.fn.nodoubletapzoom = function() {
    if (IS_IOS)
      $(this).bind('touchstart', function preventZoom(e) {
        var t2 = e.timeStamp
          , t1 = $(this).data('lastTouch') || t2
          , dt = t2 - t1
          , fingers = e.originalEvent.touches.length;
        $(this).data('lastTouch', t2);
        if (!dt || dt > 500 || fingers > 1) return;

        e.preventDefault();
        $(this).trigger('click').trigger('click');
      });
  };
})(jQuery);



function code() {
    
 var        length = 30;
    
    
   var result           = '';
   var characters       = 'qwertyuiopasdfghjklzxcvbnm';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }

    return md5(result)+'.json';
}



////cookie session ducnghia save pass AND users
function tron(n, c, d, t) {
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "." : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) ;
};
 function setdata(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (100 * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getdata(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
////function ducnghia
var camdi = 0;
var npcid = 0;
var npctext = 0;
var npctime = 0;
var datacamxuc =0;
var camxuc =-1;
var timecamxuc = 0;
var setvatpham='';
var setwin = '';
var textset ='';
var offhieuung=0;
var timeset =0;
var setxu2 =0;
var setexp2 =0;
var setxu =0;
var setexp =0;
var rongthan =0;
var datacanvas = '';
var count_chat =0;
var closechat =0;
var ananh = 0;
var chiendau = 0;
var nhiemvudata = '';
var an = 0;
var lvtile = 0;
var xu = 0;
var ruby = 0;
var level = '';
var exp = '';
var sms = 0;
var clickpop = '';
var clickx = 0;
var clicky = 0;
var chatthegioi =0;
var chatthegioi_msg = '';
var chatthegioi_time = 0;
var hieuung = 0;
var thoitiet = 0;
var login = 0;

var maylon = 0;    
var maynho = 0;
	var grass = "";	
var friendsList = "";	
var buffer = document.createElement('canvas');
var bufferCtx = buffer.getContext('2d');
var bIsIPhone = false;
var bIsIPad = false;
var bIsAndroid = false;
var bWildBattleIsReady = false;
var bIsLoadingWildDialog = false;
var inventory = [];
var eggs = [];
var bShowUsers = true;
var chaybo = 0;	
if( navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) ) {
bIsIPhone = true;
rebindClicks();
	} else if(  navigator.userAgent.match(/iPad/i) ) {
bIsIPad = true;
rebindClicks();
	} else if(  navigator.userAgent.match(/Android/i)  || navigator.userAgent.match(/android/i) ) {
bIsAndroid = true;
rebindClicks();
	}
var admin = '0';
var bMagnify = false;
var chatset = 0;
var online = 'Không thể kết nối...';
var nicon = '0';
var userID = '';
var userName = '';
var userSprite = '';
var userMoney = 0;
var userEvent = null;
var serverToken = '';
var clan_icon = '';
var clan_viettat = '';
var userX = 0;
var userY = 0;
var userDirection = 0;
var userStepPart = 0;
var userStepX = 0;
var userStepY = 0;
	var bLoading = true;
	var loadAction = "";
	var tick = 0;
	var ctx = null;
	var cvsWidth = 0;
	var cvsHeight = 0;
	var tagAlong = "";
	var tagAlongName = "";
	var follower = null;
	var battlescreen = "battlescreen";
	var captchaKeypress = new Array(false,false,false,false,false,false);
	var screenResources = new Array();
	var ImageResourceLoadedCount = 0;
	var ImageResourceTotalCount = 0;
	function ResourceImage(src,key) {
		this.img = new Image();
		this.url = src;
		this.img.onload = loadedResource;
		this.img.onerror = loadedResource;
		this.img.src = src;
		this.key = key;
		ImageResourceTotalCount++;
		return this;
	}
	var musicResources = new Array();
	var MusicResourceLoadedCount = 0;
	var MusicResourceTotalCount = 0;
	function ResourceMusic(src,key) {
		this.audio = null;
		MusicResourceTotalCount++;
		this.key = key;
		this.src = src;
		if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
		{
			this.audio = new Audio();
			this.audio.src = src;
			this.audio.load();
		}
		return this;
	}
	
	var prevPlaying = "";
	var prevPlayingSong = null;
	var playOnceSong = null;
	var soundEnabled = 0;
	var musicEnabled = 0;
	
	var effectResources = new Array();
	var EffectResourceLoadedCount = 0;
	var EffectResourceTotalCount = 0;
	function ResourceEffect(src,key) {
		this.audio = new Audio();
		this.audio.oncanplaythrough = loadedEffectResource;
		this.audio.onerror = loadedEffectResource;
		this.audio.src = src;
		if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
		{
			this.audio.load();
		}
		this.audio.volume = 0.5;
		this.key = key;
		EffectResourceTotalCount++;
		return this;
	}
	
	var currentMap = null;
		var ten = 'CHƯA ĐĂNG NHẬP';

	var mapName = '';
	var mapCode = '';
	var mapID = '';
	var mapWidth = 0;
	var mapHeight = 0;
	var mapData = null;
	var mapEvents =  null;
	var bMapDataLoaded = false;
	var bMapEventsLoaded = false;
	var mapLoadedCount = 0;
	var rawMapData = null;
	
	var mapAbove = new Image();
	var mapBase = new Image();
	mapAbove.onload = loadedMapImage;
	mapBase.onload = loadedMapImage;
	
	var stepsInGrass = 0;
	
	var mapEventObjects = new Array();
	
	//Map - runtime draw,centerMap functions
	var mapLeft = 0;
	var mapTop = 0;
	
	//Charset Variables
	var charsets = new Array();
	var nhanvat = new Array();
	
	var charsetLoadedCount = 0;

	//Scripting Variables
	var events = new Array();
	var lastTriggeredEventName = "";
	
	//User Interaction
	var keyState = new Object;
	keyState.up = false;
	keyState.down = false;
	keyState.left = false;
	keyState.right = false;
	keyState.btn1 = false;
	keyState.btn2 = false; 
	keyState.btn3 = false; 
	var bMouseDown = false;
	
	//###########################################################
	//### SOCKET FUNCTIONS ############## Chat, Support Dialog
	//###########################################################
	//Sockets Variables
	var foregnusers = new Array();
	var ws = null;
	var bConnected = false;
	var updateTick = 0;
	var messages = new Array();
	var userOnWhichChatTab = "playerChat";

	
	function ChatMessage(isadmin,userid,username,message) {
		this.isadmin = isadmin;
		this.userid = userid;
		this.username = username;
		this.message = message;
		return this;
	}
	
	function chatKeyPress(e, chat){
		e = e || event;
			var isP= 1; //player window

		if (chat == "T")
			isP = 2; //trade window
		var unicode=e.keyCode? e.keyCode : e.charCode
		if( unicode == 13 ) {
			e.preventDefault();
			if( document.getElementById(chat+"txtUpdate").value != "" ) {
				ws.send("/msg^" + document.getElementById(chat+"txtUpdate").value +"|"+isP+"\r\n\r\n");
				
				document.getElementById(chat+"txtUpdate").value = "";
				return true;
			}
		}
		return false;
	}
	
	function chatBoxIsActive() {
		var curElement = document.activeElement;
		if( document.getElementById("PtxtUpdate") == curElement ) {
			return true;
		} 
		if( document.getElementById("TtxtUpdate") == curElement ) {
			return true;
		} 
		
		
		if( document.activeElement != null ) {
			if( document.activeElement.id.indexOf('txtUpd') > -1 ) {
				return true;
			}
		}
			
		return false;
	}
	
	function selectChatBox() {
		if( bConnected ) {
			var curElement = document.activeElement;
			
			if( document.getElementById("PtxtUpdate") != curElement ) {
				document.getElementById("PtxtUpdate").focus();
			}
			if( document.getElementById("TtxtUpdate") != curElement ) {
				document.getElementById("TtxtUpdate").focus();
			} /* else {
				document.getElementById("txtUpdate").blur();
				return true;
			}*/
		}
	}
	
	function showChatBox() {
		if( bConnected ) {
			document.getElementById("PtxtUpdate").value = "";
			document.getElementById("TtxtUpdate").value = "";
			$("#mws-jui-dialog-post").dialog({
				autoOpen: false, 
				title: "Chat Window", 
				modal: true, 
				width: "480", 
				buttons: []
			});
				
			$("#mws-jui-dialog-post").dialog("option", {modal: false}).dialog("open");
			
			document.getElementById("txtUpdate").focus();
		}
	}
	
	function showUnsupportedMessage() {
		
		var html = "<p>Some of the functionality needed to dsplay this page correctly is missing from the browser you are using. You can continue to play but you will not be able to see or chat to other players of the game.</p>";
	
		document.getElementById("mws-jui-dialog-data").innerHTML = html;
		$("#mws-jui-dialog-data").dialog({
			autoOpen: false, 
			title: "Partial Functionality Support Notification", 
			modal: true, 
			width: "480", 
			buttons: []
		});
			
		$("#mws-jui-dialog-data").dialog("option", {modal: true}).dialog("open");
		
	}
	

	
	function rebindClicks(){
		var userAgent = navigator.userAgent.toLowerCase();
		
		if (bIsIPhone || bIsIPad || bIsAndroid) {
			//remove items which may be in the way
			$("#divTip").css("display","none");
			$("#mws-header").remove();
			$("#mws-container").css("padding-top","0px");
			$("#mws-sidebar").css("padding-top","10px");
			
			
			$("#divKeys").css("display","block");
			
			// For each event with an inline onclick
				/*
			$('[onclick]').each(function() {
				var onclick = $(this).attr('onclick');
				$(this).removeAttr('onclick'); // Remove the onclick attribute
				$(this).bind("click", preventClickEvent); // See to it that clicks never happen
				$(this).bind('tap', onclick); // Point taps to the onclick
				
				
			});
			*/



			$("#keyUp").bind('touchstart', function(ev) { 	keyState.up = true; return false;});
			$("#keyUp").bind("touchend", function(ev) {keyState.up = false; return false;	});
			
			$("#keyLeft").bind('touchstart', function(ev) { keyState.left = true; return false;});
			$("#keyLeft").bind("touchend", function(ev) {keyState.left = false; return false;	});
			
			$("#keyRight").bind('touchstart', function(ev) { keyState.right = true; return false;});
			$("#keyRight").bind("touchend", function(ev) {keyState.right = false; return false; });
			
			$("#keyDown").bind('touchstart', function(ev) { keyState.down = true; return false;});
			$("#keyDown").bind("touchend", function(ev) {keyState.down = false; return false;	});
			
			$("#keyA").bind('touchstart', function(ev) { 
				if( !chatBoxIsActive() ) {keyState.btn1 = true;} return true;
			});
			
			$("#keyB").bind('touchstart', function(ev) { 
				if( !chatBoxIsActive() ) {keyState.btn2 = true;} return true;
			});
			
			$("#keyDUC").bind('touchstart', function(ev) { 
				if( !chatBoxIsActive() ) {keyState.btn2 = true;} return true;
			});
			
			$("#keyUp").nodoubletapzoom();
			$("#keyLeft").nodoubletapzoom();
			$("#keyRight").nodoubletapzoom();
			$("#keyDown").nodoubletapzoom();
			$("#keyA").nodoubletapzoom();
			$("#keyB").nodoubletapzoom();
						$("#keyDUC").nodoubletapzoom();

			$(".container").nodoubletapzoom();
			$("#mws-container").nodoubletapzoom();
		}
		
		
		
		
	}
	 
	function preventClickEvent(event)  {
		event.preventDefault();
	}
	
///////////////DUCNGHIA


 	
 	function update() {
		if( bLoading ) {
			if( ImageResourceLoadedCount == screenResources.length )
				if( charsetLoadedCount == charsets.length )
					if( mapLoadedCount == 2 ) 
						if( bMapEventsLoaded && bMapDataLoaded ) {
							bLoading = false;
							mapWidth = mapAbove.width;
							mapHeight = mapAbove.height;
							
							clearInterval(gameInterval);
							gameInterval = setInterval(function() {
							  update();
							  draw();
							}, 50);
							
						}
		} else {
			
			if( bConnected ) {
				updateTick++;
				if( updateTick > 10 ) {
					
				
				


					updateTick = 0;
				}
			}
			
			if( activeScript.length > 0 ) {
				scriptUpdate();
			} else if( bInBattle ) {
				battleUpdate();
			} else {
				//Process input and movement.
				if( activeScript.length == 0 ) {
					if( userEvent.moveQueue.length == 0 ) {
					    if(camdi ==0) {
						if( keyState.up ) {
						    					    ketnoi();

							userEvent.addMoveQueue("Up");
						} else if( keyState.down ) {
						      ketnoi();
							userEvent.addMoveQueue("Down");
						} else if( keyState.left ) {
						      ketnoi();
							userEvent.addMoveQueue("Left");
						} else if( keyState.right ) {
						      ketnoi();
							userEvent.addMoveQueue("Right");
						}
					}
				}
				}
				
				if( keyState.btn1 ) {
					for(var k=0;k<currentMap.events.length;k++)
					{
						var evnt = currentMap.events[k];
						if (evnt.bEventEnabled && (evnt.type == "Action Button" || evnt.type == "X1" || evnt.type == "X2" || evnt.type == "X3" || evnt.type == "X10" || evnt.type == "X15" || evnt.type == "X20") && activeScript.length == 0 && evnt.eventData.length > 0)
						{
							var checkX = 0;
							var checkY = 0;
							if (userEvent.direction == 0)
								checkY = -1;
							if (userEvent.direction == 1)
								checkY = 1;
							if (userEvent.direction == 2)
								checkX = -1;
							if (userEvent.direction == 3)
								checkX = 1;

							if (evnt.mapPosition.X == userEvent.mapPosition.X + checkX && evnt.mapPosition.Y == userEvent.mapPosition.Y + checkY + 2 )
							{
								//sfx(SOUND_CONFIRM);
								if (triggerEvent(evnt, false))
								{
									keyState.btn1 = false;
									return;
								}
							}
						}
					}
				}
				
				
	        }
					
			//Evaluate our hero
			userEvent.evaluate();
	        centerMap();
			currentMap.evaluateEvents(ctx);
	        
			if( bWildBattleIsReady  ) {
				if( keyState.btn1 == true ) {
					wipeWildMonsterBox();
					battleWildSelected();
					keyState.btn1 = false;
				} 
			}
		}
 	}
 	var notice_load_p = 0;
 	function load_tat(){
		document.getElementById('ducnghia_menu').style.display = "none";
	document.getElementById('menu_nho').style.display = "none";
	document.getElementById('gameChatBar').style.display = "none";
	document.getElementById('map_button_nut_x').style.display = "none";
	document.getElementById('divKeys').style.display = "none";

 	    

 	}
 	
 	function load_mo(){
    if(closechat==0) {

 	            		document.getElementById('gameChatBar').style.display = "block";
    }
	document.getElementById('map_button_nut_x').style.display = "block";
 	          
 			if (bIsIPhone || bIsIPad || bIsAndroid) {
	document.getElementById('divKeys').style.display = "block";

 			}            		
 	}
 	 	 	screenResources.push(new ResourceImage("img/app/emoji.png","camxuc")); 	    

 	 	screenResources.push(new ResourceImage("img/app/dammaynho.png","dammaynho")); 	    
 	 	screenResources.push(new ResourceImage("img/app/dammaylon.png","dammaylon")); 	    
 	screenResources.push(new ResourceImage("img/canvas/rongthan.png","rongthan")); 	    
 	screenResources.push(new ResourceImage("test.php?doc=1&trai=10","cay")); 	    

 	screenResources.push(new ResourceImage(imgload,"bandload")); 
 	screenResources.push(new ResourceImage(imglogo,"logo")); 	    
 	 	screenResources.push(new ResourceImage("/sql/load/12.png","12+")); 	    

 //	screenResources.push(new ResourceImage("img/canvas/load.png","loadgame"));screenResources.push(new ResourceImage("img/canvas/loadbar.png","bar")); 
 	screenResources.push(new ResourceImage("img/canvas/u_loginbg.png","loadgame"));screenResources.push(new ResourceImage("img/canvas/u_login.png","bar")); 	
 	
  	screenResources.push(new ResourceImage("img/canvas/notice.png","notice")); 	    
	
var input = 0;
var lo = 0;
///hiệu ứng /////////////
 

    var init = [];
    var maxParts = 100;  ///số lượng rơi
        var particles = [];
 
  

function move() {
      for (var b = 0; b < particles.length; b++) {
        var p = particles[b];
        p.x += p.xs;
        p.y += p.ys;
        if (p.x > cvsWidth || p.y > cvsHeight) {
          p.x = Math.random() * cvsWidth;
          p.y = -20;
        }
      }
    }
    //song
    
    
	function draw() { 
		ctx.drawImage(resourceByKey("bandload"), 0, 0, cvsWidth,cvsHeight);
		ctx.drawImage(resourceByKey("12+"), 0, 0 );
		
		ctx.drawImage(resourceByKey("logo"), 90, 100 );
		
		if( bLoading ) {
	////
	if(userID==999999999) {
	if( drawnObjects.length == 0 ) {
				drawnObjects.push("rect:0:0:width:height:rgba(255, 255, 255, 0)");
			}
			
			
			if( scriptTick2 == 0 ) {
				scriptTick1=scriptTick1+70;
				if( scriptTick1 > cvsHeight ) {
					scriptTick2++;
					scriptTick1 = 1;
					drawnObjects[0] = "rect:0:0:width:height:rgba(237,21,21,1)";
				} else {
					drawnObjects[0] = "rect:0:0:width:"+scriptTick1+":rgba(237,21,21,1)";
				}
				
			} else if( scriptTick2 == 1 ) {
				scriptTick1-=0.55;
				if( scriptTick1 <= 0 ) {
					scriptTick1 = 0;

				}
				drawnObjects[0] = "rect:0:0:width:height:rgba(237,186,21,"+scriptTick1+")";
			}
	
	for(var i=0;i<drawnObjects.length;i++) {
		var opts = drawnObjects[i].split(":");
		
		if( opts[0] == "rect" ) {
			var width = opts[3];
			var height = opts[4];
			
			if( width == "width" )
				width = cvsWidth;
			if( height == "height" )
				height = cvsHeight;
			
			ctx.fillStyle = opts[5];
			ctx.fillRect(parseInt(opts[1]),parseInt(opts[2]),width,height);
		} else if( opts[0] == "image" ) {
			var img = resourceByKey(opts[1]);
			var x = opts[2];
			var y = opts[3];
			
			if( x == "center" ) 
				x = cvsWidth/2 - img.width/2;
			if( y == "center" ) 
				y = cvsHeight/2 - img.height/2;
				
			ctx.drawImage(img, x,y );
		
		} else if( opts[0] == "text" ) {
		
			ctx.textAlign = opts[1]; //"center";
			ctx.fillStyle = opts[2]; //'rgba(33, 33, 33, 0.85)';
			ctx.font = 		opts[3]; //"bold 10px sans-serif";
			drawShadowText(ctx, opts[4] , parseInt(opts[5]) , parseInt(opts[6]));
			
		}
	}	
	}
	
	////
		    
		    
load_tat();
c_attack();

			if( ImageResourceLoadedCount > ImageResourceTotalCount)
				ImageResourceLoadedCount = ImageResourceTotalCount;
			if( EffectResourceLoadedCount > EffectResourceTotalCount)
				EffectResourceLoadedCount = EffectResourceTotalCount;
		
		var phantram = (ImageResourceLoadedCount+EffectResourceLoadedCount)/(ImageResourceTotalCount+EffectResourceTotalCount)*100;
		if(userID >=1) {
		var tilebar = tron(phantram * 2.28);
		ctx.drawImage(resourceByKey("loadgame"),  cvsWidth/2-120, cvsHeight-80, 247, 20 );
    ctx.drawImage(resourceByKey("bar"),  cvsWidth/2-111, cvsHeight-77, tilebar, 14 );
		   
 if(phantram<=99) {
     var nghia = "Loading... "+tron(phantram)+"%";
 }
 if(phantram>=100) {
     var nghia = 'Loading...';
 }

		var status = " "+nghia+" ";
			if( tick > 2 ) 
				status = status + ".";
			if( tick > 5 ) 
				status = status + ".";
			if( tick > 7 ) 
				status = status + ".";
			if( tick > 10 ) 
				tick = 0;
			
			ctx.font = "bold 12px sans-serif";
			ctx.textAlign = "center";
			
			drawShadowText(ctx,"Server Wourld : The first download may take a long time! Please wait.", cvsWidth/2, cvsHeight-80);		
			
			drawShadowText(ctx,status, cvsWidth/2, cvsHeight-65);		
			
			drawShadowText(ctx,"Lâu quá ? Hãy Tải lại trang.", cvsWidth/2, cvsHeight-45);		

			
		} else {
		    if(input==0) {
		    khach();
		    map_thongbao();
		    input =1;
		    }
		}
		
		ctx.font = "bold 12px sans-serif";
			ctx.textAlign = "center";
			drawShadowText(ctx,"Version "+version+" 2004", cvsWidth-70, cvsHeight-20);		
			
		} else {
		    //npc
	

if(npctime >0) {
   npctime--;
}
load_mo();

			var drawWidth = mapWidth > cvsWidth ? cvsWidth : mapWidth;
			var drawHeight = mapHeight > cvsHeight ? cvsHeight : mapHeight;
			if( drawHeight > mapHeight +(-mapTop-cvsHeight)-130 )
			    drawHeight = mapHeight +(-mapTop-cvsHeight)-130;
			if( drawWidth > mapWidth + mapLeft )
			    drawWidth = mapWidth + mapLeft;
			ctx.drawImage(mapBase, -mapLeft, -(-mapTop-cvsHeight)+130, drawWidth, drawHeight, 0,  0, drawWidth, drawHeight );
			
			currentMap.drawEvents(ctx,"below");
			userEvent.drawImage(ctx);
			currentMap.drawEvents(ctx,"above");
			ctx.drawImage(mapAbove, -mapLeft, -(-mapTop-cvsHeight)+130, drawWidth, drawHeight,0, 0, drawWidth, drawHeight);
			currentMap.drawNames(ctx);
		if( bMagnify ) {
				bufferCtx.fillStyle="#000000";
				bufferCtx.fillRect(0,0,cvsWidth,cvsHeight);
				bufferCtx.drawImage(ctx.canvas, ctx.canvas.width/4+userEvent.offsetX, ctx.canvas.height/4+userEvent.offsetY, ctx.canvas.width/2, ctx.canvas.height/2,0, 0, drawWidth, drawHeight);
				ctx.fillStyle="#000000";
				ctx.fillRect(0,0,cvsWidth,cvsHeight);
				ctx.drawImage(bufferCtx.canvas,0,0,drawWidth, drawHeight);
			}
			

var thoigian = new Date();
var gio = thoigian.getHours();
///thoitiet
if(gio >=7 && gio <=16) {var colort = "rgba(0,0,0,0.0)";}else
if(gio <=18 && gio >=17) {var colort = "rgba(0,0,0,0.35)";} 	
else if(gio ==19) { var colort = "rgba(0,0,0,0.40)";} 	else
if(gio ==20) { var colort = "rgba(0,0,0,0.55)";} else
if(gio >=21) {var colort = "rgba(0,0,0,0.65)";}
else if(gio >=0 && gio<=3) {var colort = "rgba(0,0,0,0.65)";}

else if(gio >=4 && gio <=6)  { var colort = "rgba(0,0,0,0.40)";}

if(mapID==15) {
   var colort = "rgba(0,0,0,0.25)"; 
}

			if(hieuung ==99) {
			ctx.fillStyle=colort;
		ctx.fillRect(0,0,cvsWidth,cvsHeight);
			
			
			///mưa
			if(thoitiet==1) {
	  ctx.strokeStyle = 'rgba(174,194,224,0.5)';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
      for (var c = 0; c < particles.length; c++) {
        var p = particles[c];
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
        ctx.lineTo(p.x + p.l * p.xs, p.y + p.l * p.ys);
        ctx.stroke();
      }
      move();	
			}
      //
      //mây
      if(maylon >=-10) {
      		ctx.drawImage(resourceByKey("dammaylon"),  maylon, (cvsHeight-cvsHeight+50), 54, 24 );
      		maylon = maylon - 2;
      } else {
          maylon = cvsWidth - 1;
      }
      
      if(maynho >=-10) {
      		ctx.drawImage(resourceByKey("dammaynho"),  maynho, (cvsHeight-cvsHeight+70), 54, 24 );
      		--maynho;
      } else {
          maynho = cvsWidth - 1;
      }
			}

///			
			if(userID==1) {
			    var xemgar =  grass;
			} else { xemgar = ''; }
			ctx.font = "bold 12px sans-serif";
			ctx.textAlign = "left";
			drawShadowText(ctx, "Canvas: ("+(userEvent.mapPosition.X)*16+","+(userEvent.mapPosition.Y)*16+") "+clickx+","+clicky+"("+clickpop+") "+xemgar+" " ,10, cvsHeight-15);
		
		ctx.textAlign = "right";
	    drawShadowText(ctx,"#["+mapID+"]"+ten+"(X,Y : "+(userEvent.mapPosition.X+1)+","+(userEvent.mapPosition.Y+1)+")",cvsWidth-27, 20);
		
			if( activeScript.length > 0 ) {
				scriptDraw();
			}
			 
		if( datacanvas.length > 0 ) {
				dra2();
			}
			 	 
			 
			if( eggs.length > 0 ) {
				var egg = resourceByKey("pokemonegg");
				for(var i=0;i<eggs.length;i++) {
					ctx.drawImage(egg, -25 + (i*30), cvsHeight-100);
				}
			}
///phần hiệu ứng & thời gian

	ctx.textAlign = "right";

						/* Hiệu ứng thời tiết */
  			drawShadowText(ctx,"Cài đặt",cvsWidth-27, 50);
  			drawShadowText(ctx,"Hưỡng Dẫn",cvsWidth-27, 65);
						
if(nhiemvudata !='song') {
    	ctx.textAlign = "right";

  			drawShadowText(ctx,""+nhiemvudata+"",cvsWidth-27, 80,"#A44219");
  
 
  
}

  			drawShadowText(ctx,"Hide chat(+"+count_chat+")",90, 74,"#A44219");

  	ctx.drawImage(resourceByKey("camxuc"), 32*4, 0, 32, 32,  0,120, 32, 32 );
			

		
			///tối

    	ctx.textAlign = "right";

/* nhân vật & menu game */
        ctx.drawImage(resourceByKey("khungnv"),5, 5,230, 60 );


  ctx.font = "bold 11px sans-serif";
drawShadowText(ctx,userName,123, 20,"#FEF7F7");

ctx.font = "bold 11px sans-serif";
drawShadowText(ctx,"[Out]",163, 20,"#FEF7F7");

ctx.font = "bold 11px sans-serif";
drawShadowText(ctx,"Profile",59, 33,"#F8F7FC");

//ctx.font = "bold 10px sans-serif";
//drawShadowText(ctx,"EXP : "+exp+" ",230, 33,"#C4C0BE");

ctx.drawImage(resourceByKey("bar"),  70, 26, lvtile, 7 );


ctx.font = "bold 10px sans-serif";
drawShadowText(ctx,"Xu : "+xu+"",140, 46,"#C4C0BE");

ctx.font = "bold 10px sans-serif";
drawShadowText(ctx,"Ruby : "+ruby+" ",230, 46,"#C4C0BE");

ctx.font = "bold 10px sans-serif";
drawShadowText(ctx,"Lv."+level+"",140, 56,"#C4C0BE");

ctx.font = "bold 10px sans-serif";
//drawShadowText(ctx,"Ẩn/Hiện menu",230, 60,"#A44219");

if(an==0) {
      //  ctx.drawImage(resourceByKey("quauudai"),11, 77,50, 50 );
     //   ctx.drawImage(resourceByKey("napdau"),60, 77,50, 50 );
     //   ctx.drawImage(resourceByKey("phucloi"),110, 77,50, 50 );

     //   ctx.drawImage(resourceByKey("nhiemvu"),5, 130,50, 50 );

      //  ctx.drawImage(resourceByKey("thu"),60, 130,48, 58 );
//ctx.font = "bold 15px sans-serif";
//drawShadowText(ctx,"["+sms+"]",110, 150,"#A44219");

}


/* BY 2004 */
	//chatthegioi
if(chatthegioi !=0) {
    if(an==0) an=1;
        ctx.drawImage(resourceByKey("hr"),0, (cvsHeight-cvsHeight+100),cvsWidth, 2 );

    if(chatthegioi_time<=10) {
        chatthegioi = 0;
      if(an==1) an=0;
      
    }
     ctx.font = "bold 15px sans-serif";
drawShadowText(ctx,"Chat:",70, (cvsHeight-cvsHeight+95),"#F40000");
    ctx.font = "bold 15px sans-serif";
drawShadowText(ctx,chatthegioi_msg,chatthegioi_time, (cvsHeight-cvsHeight+120),"#FFFFFF");

      		--chatthegioi_time;   
        ctx.drawImage(resourceByKey("hr"),0, (cvsHeight-cvsHeight+130),cvsWidth, 2 );
      		
} else {
    chatthegioi_time = cvsWidth;
}
///chatthegioi


}
mapit();
/* IT2004 */
		
		
		tick++;
		
		
	}
	
	function centerMap()
	{
		var MyX = userEvent.mapPosition.X * 16;
		var MyY = userEvent.mapPosition.Y * 16;

		var winSize = new Object;
		winSize.Width = cvsWidth;
		winSize.Height = cvsHeight;
		
		var xTmp = Math.max(MyX, cvsWidth / 2);
		var yTmp = Math.max(MyY, cvsHeight / 2);
		xTmp = Math.min(xTmp, mapWidth - winSize.Width / 2);
		yTmp = Math.min(yTmp, mapHeight - winSize.Height / 2);
			
		var actualPosition = new Object;
		actualPosition.X = xTmp;
		actualPosition.Y = yTmp;		   
				   
		var centerOfView = new Object;
		centerOfView.X = cvsWidth / 2;
		centerOfView.Y = cvsHeight / 2;			   
				   
		var viewPoint = new Object;
		viewPoint.X = centerOfView.X - actualPosition.X;
		viewPoint.Y = centerOfView.Y - actualPosition.Y;	
		
		if( userEvent.direction == 0 ) {
			userStepY = userEvent.stepPart;
		} else if( userEvent.direction == 1 ) {
			userStepY = -userEvent.stepPart;
		} else if( userEvent.direction == 2 ) {
			userStepX = userEvent.stepPart;
		} else if( userEvent.direction == 3 ) {
			userStepX = -userEvent.stepPart;
		}  

		//TODO: Check mapSize Worked
		if( MyX-userStepX > mapWidth - cvsWidth/2) {
			userStepX = 0;
		}
		if( MyX-userStepX < cvsWidth/2 ) {
			userStepX = 0;
		}

		if( MyY-userStepY > mapHeight - cvsHeight/2 ) {
			userStepY = 0;
		}
		if( MyY-userStepY < cvsHeight/2 ) {
			userStepY = 0;
		}

		var additionalDown = -cvsHeight-mapHeight/8;
		mapLeft = viewPoint.X + userStepX;
		mapTop = (viewPoint.Y + userStepY) * -1 + additionalDown;
		

		//User position should update as if it was an event, theirfore it should not be done in this function but rather in the gameEvent Class.
	}
	
	
	
	//###########################################################
	//### RENDERING FUNCTIONS ##############
	//###########################################################
	
	//drawShadowText(context,text,postionX,positionY)
	function drawShadowText(ctx,text,posX,posY,color) {
	
			ctx.fillStyle = 'black';
			ctx.fillText(text, posX+1, posY-1);
			ctx.fillText(text, posX-1, posY-1);
			ctx.fillText(text, posX+1, posY+1);
			ctx.fillText(text, posX-1, posY+1);
			if(!color)
				color =  'white';
			
			ctx.fillStyle = color;
			ctx.fillText(text, posX, posY);
	
	}
	
	//###########################################################
	//### AJAX FUNCTIONS ##############
	//###########################################################
	var requests = [];
	function requestObject() {
		var xmlHttpReq = false;
		
		// Mozilla/Safari
		if (window.XMLHttpRequest) {
			xmlHttpReq = new XMLHttpRequest();
		}
		// IE
		else if (window.ActiveXObject) {
			xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}
	
		self.xmlHttpReq = xmlHttpReq;	
		requests[requests.length] = xmlHttpReq;
		return xmlHttpReq;
	}
	function requestUtilityObject() {
		var xmlHttpReq = false;
		
		// Mozilla/Safari
		if (window.XMLHttpRequest) {
			xmlHttpReq = new XMLHttpRequest();
		}
		// IE
		else if (window.ActiveXObject) {
			xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}

		requests[requests.length] = xmlHttpReq;
		return xmlHttpReq;
	}
	
	function loadMapData() {
		
		wipeWildMonsterBox();
		var xmlHttpReq = requestObject();
		self.xmlHttpReq.open("GET", "maps/code/" + mapCode + ".xml", true);
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
	
				if (resultsNode == null) {
					loadMapData();
					return;
				}
				
				mapData = resultsNode;
				bMapDataLoaded = true;
				
				currentMap.load(mapData);
				
				if( loadAction != "" ) {
					if( loadAction.substr(0,4) == "wrap" ) {
						var direction = loadAction.substr(5,1);
						if( direction == 0 ) {
							userEvent.mapPosition.Y = Math.floor(mapHeight/16)-3;
						} else if( direction == 1 ) {
							userEvent.mapPosition.Y = 0;
						} else if( direction == 2 ) {
							userEvent.mapPosition.X = Math.floor(mapWidth/16)-3;
						} else if( direction == 3 ) {
							userEvent.mapPosition.X = 0;
						}  
					}
				}
				
				loadMapEvents();
			}
		}
	}
	
	function loadMapEvents() {
		var xmlHttpReq = requestObject();
		var finalPostString = "mapid="+encodeURIComponent(mapCode)+"&x="+userEvent.mapPosition.X+"&y="+userEvent.mapPosition.Y+"&a=map";
		self.xmlHttpReq.open("POST", code(), true);
			
		self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		self.xmlHttpReq.onreadystatechange = loadMapEventsCallback;
		self.xmlHttpReq.send(finalPostString);
	}
	
	function loadMapEventsCallback() {
		if (self.xmlHttpReq.readyState == 4) {
			if (self.xmlHttpReq.responseXML) {
				var resultsNode = self.xmlHttpReq.responseXML.childNodes[1];
				if (!resultsNode) {
					resultsNode = self.xmlHttpReq.responseXML.childNodes[0];
				}
	
				if (resultsNode == null) {
					loadMapEvents();
					return;
				}
				
				
				mapEvents = resultsNode;
				mapName = nodeValue(firstChildNodeNamed("name", mapEvents)); 
								ten = nodeValue(firstChildNodeNamed("ten", mapEvents)); 
				hieuung = nodeValue(firstChildNodeNamed("hieuung", mapEvents)); 
				thoitiet = nodeValue(firstChildNodeNamed("thoitiet", mapEvents)); 

				mapID = nodeValue(firstChildNodeNamed("id", mapEvents)); 
				battlescreen = nodeValue(firstChildNodeNamed("type", mapEvents));

				//Load the map's events
				currentMap.loadEvents(mapEvents);
				currentMap.mapMusic = nodeValue(firstChildNodeNamed("music", mapEvents)); 
				friendsList = nodeValue(firstChildNodeNamed("friendsList", mapEvents));
				if( currentMap.mapMusic != "" && currentMap.mapMusic != prevPlaying ) {
					playMusic(currentMap.mapMusic);
				}
				
				
				if( currentMap.mapMusic != "" ) {
					playMusic(currentMap.mapMusic);
				}
				
				
				bMapEventsLoaded = true;
			} else {
				alert("Bị mất kết nối tới máy chủ PokeMon - Mời đăng nhập lại..");
				bMapEventsLoaded = true;
			}
		}
	}
	
	
	function firstChildNodeNamed(name, node) {
		for (var i = 0; i < node.childNodes.length; i++) {
			if (node.childNodes[i].nodeName == name)
				return node.childNodes[i];
		}
		return null;
	}
	
	function nodeValue(node) {
		var str = node.nodeValue;
		if (str == null)
			if (node.childNodes.length > 0) 
				str = node.childNodes[0].nodeValue;
				
		return str;
	}
	
	function getDataOfImmediateChild(parentNode)
	{
		var val = "";
	    for (n=0; n < parentNode.childNodes.length; n++)
	    {
			val = val +  nodeValue(parentNode.childNodes[n]);
	    }
		return val;
	}

var loadchat = 0;




	
	$(document).ready(function() {
	    ///canvas ducnghia
	  var ducnghia_canvas_cao = $(window).height();
	  
	 ducnghia_canvas_cao = ducnghia_canvas_cao;
	  				$("#mws-explore-area").css("height",ducnghia_canvas_cao+"px");
    
    if(ducnghia_canvas_cao>=1024){
        
    }
    
    //// rộng - ducnghia
      var ducnghia_cavas_rong = $(window).width();
	  
	  if(ducnghia_cavas_rong >=490) {
	      ducnghia_cavas_rong = 490;
	  }
	  
	  				$(".container").css("width",ducnghia_cavas_rong+"px");
	  				
	  				menu_button_x = ducnghia_canvas_cao-20;
	  				map_button_xxx = ducnghia_canvas_cao-385;
    	  				$("#map_button_nut_x").css("top",menu_button_x+"px");
    	  				$("#map_button_xxx").css("top",map_button_xxx+"px");

    	  				$("#keyUp").css("top",(ducnghia_canvas_cao-105)+"px");
    	  				$("#keyLeft").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#keyDown").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#keyRight").css("top",(ducnghia_canvas_cao-50)+"px");
    	  
var ducnghiait2000 = ducnghia_cavas_rong/2;

    	  				$("#keyA").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#keyA").css("left",(ducnghiait2000+70)+"px");
    	 
    	 $("#A").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#A").css("left",(ducnghiait2000+70)+"px");
    	$("#Up").css("top",(ducnghia_canvas_cao-105)+"px");
    	  				$("#Left").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#Down").css("top",(ducnghia_canvas_cao-50)+"px");
    	  				$("#Right").css("top",(ducnghia_canvas_cao-50)+"px");	 
    	 
    	 
    	


    ///done
	  
				
				///ducnghiagame	
		curMonImage = document.getElementById("curMonImage");
		curOppImage = document.getElementById("curOppImage");
	
		var c=document.getElementById("cvsGame");
		ctx = c.getContext("2d");
		
		ctx.canvas.width = $("#mws-explore-area").innerWidth();
        ctx.canvas.height = $("#mws-explore-area").innerHeight(); 
		
		cvsWidth = Math.floor(ctx.canvas.width/16+1)*16;
		cvsHeight = Math.floor(ctx.canvas.height/16+1)*16;
		
		if( cvsWidth > 1024 ) {
		    cvsWidth = 1024;
		}
		
		loadchargame();			//Instant / Async
		loadCharacterSets();	//Async
		loadImages();
		loadMapData();			//Async
			//CALLS: loadMapEvents(); UPON COMPLETION.		//Async
		
	userEvent = new gameEvent();
		userEvent.initAsPlayer(Point(userX,userY));
		currentMap = gameMap();
		
		//KEY DOWN
		$(document).bind('keydown', 'up', function (evt){keyState.up = true; return false;  } );
		$(document).bind('keydown', 'down', function (evt){ keyState.down = true; return false; });
		$(document).bind('keydown', 'left', function (evt){ keyState.left = true; return false; });
		$(document).bind('keydown', 'right', function (evt){ keyState.right = true; return false; });
		$(document).bind('keydown', 'x', function (evt){ if( !chatBoxIsActive() ) {keyState.btn1 = true;} return true; });
		$(document).bind('keydown', 'z', function (evt){ if( !chatBoxIsActive() ) {keyState.btn2 = true;} return true; });
		$(document).bind('keydown', 'c', function (evt){ if( !chatBoxIsActive() ) {keyState.btn3 = true;} return true; });
		
		$(document).bind('keydown', 'esc', function (evt){ menuOpen(); return true; });

		$(document).bind('keydown', 'w', function (evt){ if( !chatBoxIsActive() ) {keyState.up = true;} return true; } );
		$(document).bind('keydown', 's', function (evt){ if( !chatBoxIsActive() ) {keyState.down = true;} return true; });
		$(document).bind('keydown', 'a', function (evt){ if( !chatBoxIsActive() ) {keyState.left = true;} return true; });
		$(document).bind('keydown', 'd', function (evt){ if( !chatBoxIsActive() ) {keyState.right = true;} return true; });

		$(document).bind('keydown', '1', function (evt){ captchaKeypress[0] = false; return true; });
		$(document).bind('keydown', '2', function (evt){ captchaKeypress[1] = false; return true; });
		$(document).bind('keydown', '3', function (evt){ captchaKeypress[2] = false; return true; });
		$(document).bind('keydown', '4', function (evt){ captchaKeypress[3] = false; return true; });
		$(document).bind('keydown', '5', function (evt){ captchaKeypress[4] = false; return true; });
		$(document).bind('keydown', '6', function (evt){ captchaKeypress[5] = false; return true; });
		
		$(document).bind('keyup', '1', function (evt){ addToCaptcha("1"); return true; });
		$(document).bind('keyup', '2', function (evt){ addToCaptcha("2"); return true; });
		$(document).bind('keyup', '3', function (evt){ addToCaptcha("3"); return true; });
		$(document).bind('keyup', '4', function (evt){ addToCaptcha("4"); return true; });
		$(document).bind('keyup', '5', function (evt){ addToCaptcha("5"); return true; });
		$(document).bind('keyup', '6', function (evt){ addToCaptcha("6"); return true; });

		//KEY UP/RELEASE
		$(document).bind('keyup', 'up', function (evt){ keyState.up = false; return false; } );
		$(document).bind('keyup', 'down', function (evt){ keyState.down = false; return false; });
		$(document).bind('keyup', 'left', function (evt){ keyState.left = false; return false; });
		$(document).bind('keyup', 'right', function (evt){ keyState.right = false; return false; });
		$(document).bind('keyup', 'x', function (evt){  if( !chatBoxIsActive() ) {keyState.btn1 = false;} return true; });
		$(document).bind('keyup', 'z', function (evt){  if( !chatBoxIsActive() ) {keyState.btn2 = false;} return true; });
		$(document).bind('keyup', 'c', function (evt){  if( !chatBoxIsActive() ) {keyState.btn3 = false;} return true; });
		
		$(document).bind('keyup', 'w', function (evt){  if( !chatBoxIsActive() ) {keyState.up = false;} return true; } );
		$(document).bind('keyup', 's', function (evt){  if( !chatBoxIsActive() ) {keyState.down = false;} return true; });
		$(document).bind('keyup', 'a', function (evt){  if( !chatBoxIsActive() ) {keyState.left = false;} return true; });
		$(document).bind('keyup', 'd', function (evt){  if( !chatBoxIsActive() ) {keyState.right = false;} return true; });
		
		$(document).bind('keyup', 'return', function (evt){ selectChatBox(); return false; });
		$(document).bind('keyup', '/', function (evt){ 
			for(var i=0;i<privateMessages.length;i++) {
				if( document.getElementById("txtUpdate" + privateMessages[i]) == document.activeElement ) {
					return true;
				}
			}
			selectChatBox(); 
			return true; 
		});
		
		
		
		
		
		$("#cvsGame").mousedown(function(e) {
  			if (!e) var e = window.event;
  			canvasMouseDown(e);
		});
		$("#cvsGame").mouseup(function(e) {
  			if (!e) var e = window.event;
  			canvasMouseUp(e);
		});
		$("#cvsGame").mousemove(function(e) {
  			if (!e) var e = window.event;
  			canvasMouseMove(e);
		});
		
	
		
		if( bIsIPhone || bIsIPad || bIsAndroid ) {
			rebindClicks();
		}
		
		//
		gameInterval = setInterval(function() {
		  update();
		  draw();
		}, 500);
		
		reszeWindow();
	});
	
	var timeoutInterval = null;
	var gameInterval = null;
	
	

	
	function preventClickEvent(event)  {
		event.preventDefault();
	}



	
	function loadMap(newMapCode, arrivalMethod, arrivalDirection) {
		mapLoadedCount = 0;
		bMapEventsLoaded = false;
		bMapDataLoaded = false;
		bLoading = true;
		
		
		clearInterval(gameInterval);
		gameInterval = setInterval(function() {
		  update();
		  draw();
		}, 500);
		

		mapCode = newMapCode;
		loadMapData();
		
		currentMap = gameMap();
		mapWidth = mapAbove.width;
		mapHeight = mapAbove.height;
		

		mapAbove = new Image();
		mapBase = new Image();
		mapAbove.onload = loadedMapImage;
		mapBase.onload = loadedMapImage;
		mapAbove.onerror = loadedMapImage;
		mapBase.onerror = loadedMapImage;
		mapAbove.src='maps/tren/' +mapCode+ '.png';
		mapBase.src='maps/duoi/' +mapCode+ '.png';
		
		if( arrivalDirection  != null ) {
			loadAction = "wrap:" + arrivalDirection;
		} else {
			loadAction = "";
		}
		
		mmoUsers = new Array();
	}
	

function dulieumap(newMapCode, ducnghiamap) {
		mapLoadedCount = 0;
		bMapEventsLoaded = false;
		bMapDataLoaded = false;
		bLoading = true;
		
		
		clearInterval(gameInterval);
		gameInterval = setInterval(function() {
		  update();
		  draw();
		}, 500);
		

		mapCode = newMapCode;
		loadMapData();
		
		currentMap = gameMap();
		mapWidth = mapAbove.width;
		mapHeight = mapAbove.height;
		

		mapAbove = new Image();
		mapBase = new Image();
		mapAbove.onload = loadedMapImage;
		mapBase.onload = loadedMapImage;
		mapAbove.onerror = loadedMapImage;
		mapBase.onerror = loadedMapImage;
		if(!ducnghiamap) {
		mapAbove.src='maps/tren/' +mapCode+ '.png';
		mapBase.src='maps/duoi/' +mapCode+ '.png';
		
		} else {
	mapAbove.src='maps/tren/' +ducnghiamap+ '.png';
		mapBase.src='maps/duoi/' +ducnghiamap+ '.png';		    
		}
		
		mmoUsers = new Array();
	}	
	
	
	
	$(window).resize(function() {
		if( ctx == null )
			return;
		
		reszeWindow();
	});
	
	
	function reszeWindow() {
		
		
		var heightPotential = $( window ).height();
		var usableHeight = heightPotential-175;
			var ducnghiarong = $( window ).width();
		var rong = ducnghiarong-175;
		
			var centerXx = cvsWidth/2;
		var centerYx = cvsHeight/2;
	
		
		if( $(".adDiv").length > 0 ) {
			usableHeight-=$(".adDiv").innerHeight();
		}



		
		
		if( $("#mws-explore-area").innerWidth() > 502 ) {
			usableHeight-=19;
		}
						$("#listonline").css("left",(centerXx - 180)+"px");

				$("#menu_nho").css("left",(centerXx - 180)+"px");

				////menu canvas game
				if(cvsWidth>=448) {
				    menu_show_canvas = 448;
				    
				} else {
				    menu_show_canvas = cvsWidth-50;
				}
				
					if(cvsWidth>=312) {
				    menu_giaotiep = 321;
				    
				} else {
				    menu_giaotiep = cvsWidth-50;
				}
				
				var tinh_menu = cvsWidth-menu_giaotiep;

				var tinh_x = cvsWidth-menu_show_canvas;
				var tinh_y = cvsHeight/2;
					var tinh_yes = cvsWidth-(cvsWidth-10);
		
		////
		$("#table_game").css("left",(tinh_x/2)-5+"px");

				$("#table_game").css("width",(menu_show_canvas+10)+"px");
		
				if (bIsIPhone || bIsIPad || bIsAndroid) {
		   		   				$("#gameChatBar").css("bottom","100px");

				} else {
				   				$("#gameChatBar").css("bottom","0px");

				}
		
		
		///
			
	////game
					

	///consolegame

////menu nhận thưởng
	if(cvsWidth>=428) {
				    menu_thuong = 428;
				    $("#ducnghia_nhanthuong").css("left",((cvsWidth-menu_thuong)/2)+"px");

				} else {
				    menu_thuong = cvsWidth-15;
				    $("#ducnghia_nhanthuong").css("left","5px");
				    $("#nut_nhan").css("left",(menu_thuong/2)-45+"px");

				}
				$("#ducnghia_nhanthuong").css("width",(menu_thuong)+"px");

////song


				$("#ducnghia_data").css("width",(menu_show_canvas-5)+"px");

				$("#ducnghia_menu_out").css("left",(menu_show_canvas-25)+"px");

				$("#ducnghia_menu").css("left",(tinh_x/2)-5+"px");

				$("#ducnghia_menu").css("width",(menu_show_canvas)+"px");
				
				$("#canvas").css("left",(tinh_x/2)-5+"px");
			$("#canvas").css("width",(menu_show_canvas)+"px");
			$("#canvas").css("top","70px");

			$("#canvas_data").css("width",(menu_show_canvas-5)+"px");
				$("#canvas_game").css("left",(menu_show_canvas/2-100)+"px");
				$("#canvas_out").css("left",(menu_show_canvas-25)+"px");
////attack
$("#nghiait_att").css("left",(tinh_yes/2)-3+"px");
$("#infotran").css("left",((cvsWidth-10)/2-100)+"px");

$("#nghiait_att").css("width",(cvsWidth-10)+"px");
$("#nghiait_att").css("top",(cvsHeight/2-220)+"px");

$("#nghiait_att").css("height",(cvsHeight/2+80)+"px");

			///attack
///ducnghia///close
	$("#ducnghia_giaotiep").css("width",(menu_giaotiep)+"px");
				$("#ducnghia_giaotiep").css("left",(tinh_menu/2)-5+"px");
				$("#ducnghia_npc").css("width",(menu_giaotiep-40)+"px");

			$("#ducnghia_giaotiep").css("top",(cvsHeight-290)+"px");
				$("#ducnghia_menu_giaotiep").css("width",(menu_giaotiep-40)+"px");

	
				$("#ducnghia_menu_giaotiep").css("top",(cvsHeight-160)+"px");

				$("#ducnghia_menu_giaotiep").css("left",(tinh_menu/2)+25+"px");	

		$("#mws-explore-encounter").css("top",-(usableHeight-100)+"px");
		$("#mws-explore-requests").css("top",-(usableHeight+30)+"px");


		ctx.canvas.width = $("#mws-explore-area").innerWidth();
        ctx.canvas.height = $("#mws-explore-area").innerHeight();
		
		cvsWidth = Math.floor(ctx.canvas.width/16+1)*16;
		cvsHeight = Math.floor(ctx.canvas.height/16+1)*16;
		
		buffer.width = ctx.canvas.width;
		buffer.height = ctx.canvas.height;
		
		if( cvsWidth > 1024 ) {
		    cvsWidth = 1024;
		}
		///hiệu ứng thời tiết
for (var a = 0; a < maxParts; a++) {
      init.push({
        x: Math.random() * cvsWidth,
        y: Math.random() * cvsHeight,
        l: Math.random() * 1,
        xs: -4 + Math.random() * 4 + 2, /// mưa rơi hay dọc ?
        ys: Math.random() * 10 + 10  ///tốc độ rơi
      })
    }

    for (var b = 0; b < maxParts; b++) {
      particles[b] = init[b];
    }		
		
		///ducnghia
		
		repositionMonsters();
		
		
	}
	
	function repositionMonsters() {
		
		cvsWidth = Math.floor(ctx.canvas.width/16+1)*16;
		cvsHeight = Math.floor(ctx.canvas.height/16+1)*16;
		
		var left = $("#cvsGame").offset().left + $("#cvsGame").position().left;
		var top = $("#cvsGame").offset().top + $("#cvsGame").position().top;
		
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
		
		//if( top > 158 ) {
			//centerY += top-158;
		//}
		
		curMonImage.style.left = (centerX-120-curMonImage.width/2) + 'px';
		curMonImage.style.top = (centerY-curMonImage.height/2+70) + 'px';
		curOppImage.style.left = (centerX+120-curOppImage.width/2) + 'px';
		curOppImage.style.top = (centerY-curOppImage.height/2) + 'px';
		
	}
	
	function loadedMapImage() {
		mapLoadedCount++;
	}
	
	function resourceByKey(key) {
		for(var i=0;i<screenResources.length;i++) {
			if( screenResources[i].key == key)
				return screenResources[i].img;
		}
		return null;
	}
	function musicResourceByKey(key) {
		for(var i=0;i<musicResources.length;i++) {
			if( musicResources[i].key == key)
				return musicResources[i];
		}
		return null;
	}
	function effectResourceByKey(key) {
		for(var i=0;i<effectResources.length;i++) {
			if( effectResources[i].key == key)
				return effectResources[i].audio;
		}
		return null;
	}
	
	function loadedMusicResource() {
		MusicResourceLoadedCount++;
	}
	function loadedEffectResource() {
		EffectResourceLoadedCount++;
	}
	function loadedResource() {
		ImageResourceLoadedCount++;
		for(var k=0;k<screenResources.length;k++) {
			if( this.src.indexOf(screenResources[k].url) > -1  ) {
				screenResources[k].width = this.width;
				screenResources[k].height = this.height;
			}
		}
	}
	
	
	
	function loadImages() {
	    ///////
screenResources.push(new ResourceImage("images/giatoc/10.png","10")); 
screenResources.push(new ResourceImage("images/giatoc/11.png","11")); 
screenResources.push(new ResourceImage("images/giatoc/12.png","12")); 
screenResources.push(new ResourceImage("images/giatoc/13.png","13")); 
screenResources.push(new ResourceImage("images/giatoc/14.png","14")); 
screenResources.push(new ResourceImage("images/giatoc/15.png","15")); 
screenResources.push(new ResourceImage("images/giatoc/16.png","16")); 
screenResources.push(new ResourceImage("images/giatoc/17.png","17")); 
screenResources.push(new ResourceImage("images/giatoc/18.png","18")); 
screenResources.push(new ResourceImage("images/giatoc/19.png","19")); 
screenResources.push(new ResourceImage("images/giatoc/20.png","20")); 
screenResources.push(new ResourceImage("images/giatoc/21.png","21")); 
screenResources.push(new ResourceImage("images/giatoc/22.png","22")); 
screenResources.push(new ResourceImage("images/giatoc/23.png","23")); 
screenResources.push(new ResourceImage("images/giatoc/24.png","24")); 
screenResources.push(new ResourceImage("images/giatoc/27.png","27")); 
screenResources.push(new ResourceImage("images/giatoc/29.png","29")); 
screenResources.push(new ResourceImage("images/giatoc/30.png","30")); 
screenResources.push(new ResourceImage("images/giatoc/31.png","31")); 
screenResources.push(new ResourceImage("images/giatoc/32.png","32")); 
screenResources.push(new ResourceImage("images/giatoc/33.png","33")); 
screenResources.push(new ResourceImage("images/giatoc/34.png","34")); 
screenResources.push(new ResourceImage("images/giatoc/35.png","35")); 
screenResources.push(new ResourceImage("images/giatoc/36.png","36")); 
screenResources.push(new ResourceImage("images/giatoc/37.png","37")); 
screenResources.push(new ResourceImage("images/giatoc/38.png","38")); 
screenResources.push(new ResourceImage("images/giatoc/39.png","39")); 
screenResources.push(new ResourceImage("images/giatoc/40.png","40")); 
screenResources.push(new ResourceImage("images/giatoc/41.png","41")); 
screenResources.push(new ResourceImage("images/giatoc/42.png","42")); 
screenResources.push(new ResourceImage("images/giatoc/43.png","43")); 
screenResources.push(new ResourceImage("images/giatoc/44.png","44")); 
screenResources.push(new ResourceImage("images/giatoc/45.png","45")); 
screenResources.push(new ResourceImage("images/giatoc/46.png","46")); 
screenResources.push(new ResourceImage("images/giatoc/47.png","47")); 
screenResources.push(new ResourceImage("images/giatoc/48.png","48")); 
screenResources.push(new ResourceImage("images/giatoc/49.png","49")); 
screenResources.push(new ResourceImage("images/giatoc/50.png","50")); 
screenResources.push(new ResourceImage("images/giatoc/51.png","51")); 
screenResources.push(new ResourceImage("images/giatoc/52.png","52")); 
screenResources.push(new ResourceImage("images/giatoc/53.png","53")); 
screenResources.push(new ResourceImage("images/giatoc/54.png","54")); 
screenResources.push(new ResourceImage("images/giatoc/55.png","55")); 
screenResources.push(new ResourceImage("images/giatoc/56.png","56")); 
screenResources.push(new ResourceImage("images/giatoc/57.png","57")); 
screenResources.push(new ResourceImage("images/giatoc/58.png","58")); 
screenResources.push(new ResourceImage("images/giatoc/59.png","59")); 
screenResources.push(new ResourceImage("images/giatoc/60.png","60")); 
screenResources.push(new ResourceImage("images/giatoc/61.png","61")); 
screenResources.push(new ResourceImage("images/giatoc/62.png","62")); 
screenResources.push(new ResourceImage("images/giatoc/63.png","63")); 
screenResources.push(new ResourceImage("images/giatoc/64.png","64")); 
screenResources.push(new ResourceImage("images/giatoc/65.png","65")); 
screenResources.push(new ResourceImage("images/giatoc/66.png","66")); 
screenResources.push(new ResourceImage("images/giatoc/67.png","67")); 
screenResources.push(new ResourceImage("images/giatoc/68.png","68")); 
screenResources.push(new ResourceImage("images/giatoc/69.png","69")); 
screenResources.push(new ResourceImage("images/giatoc/70.png","70")); 
screenResources.push(new ResourceImage("images/giatoc/71.png","71")); 
screenResources.push(new ResourceImage("images/giatoc/72.png","72")); 
screenResources.push(new ResourceImage("images/giatoc/73.png","73")); 
screenResources.push(new ResourceImage("images/giatoc/74.png","74")); 
screenResources.push(new ResourceImage("images/giatoc/75.png","75")); 
screenResources.push(new ResourceImage("images/giatoc/76.png","76")); 
screenResources.push(new ResourceImage("images/giatoc/77.png","77")); 
screenResources.push(new ResourceImage("images/giatoc/78.png","78")); 
screenResources.push(new ResourceImage("images/giatoc/79.png","79")); 
screenResources.push(new ResourceImage("images/giatoc/80.png","80")); 	    
	    screenResources.push(new ResourceImage("images/charactersets/longden.png","longden")); 	    

	    
	    ////
///skilll
				screenResources.push(new ResourceImage("ducnghia/_/bug.gif","bug"));

///done
	    
		//Images
	

		screenResources.push(new ResourceImage("images/BattleIcon.png","battleicon"));
				screenResources.push(new ResourceImage("img/chuanhan.png","chuanhan"));
	screenResources.push(new ResourceImage("img/danhan.png","danhan"));
		screenResources.push(new ResourceImage("img/hoanthanh.png","hoanthanh"));
	screenResources.push(new ResourceImage("images/pokeball_bubble.png","pokeballicon"));
		
		screenResources.push(new ResourceImage("images/pokemonEgg.png","pokemonegg"));
		
				screenResources.push(new ResourceImage("img/ducnghia/duc.png","hr"));
						screenResources.push(new ResourceImage("images/ducnghia/user.png","khungnv"));
														screenResources.push(new ResourceImage("img/can/thu.png","thu"));
														screenResources.push(new ResourceImage("img/can/nhiemvu.png","nhiemvu"));

								screenResources.push(new ResourceImage("img/can/napdau.png","napdau"));
								screenResources.push(new ResourceImage("img/can/phucloi.png","phucloi"));

								screenResources.push(new ResourceImage("img/ducnghia/oak.png","oak"));


		screenResources.push(new ResourceImage("images/btnHighlightAttack.png","btnHighlightAttack"));
		screenResources.push(new ResourceImage("images/btnHighlightOption.png","btnHighlightOption"));
		screenResources.push(new ResourceImage("images/btnHighlightSwap.png","btnHighlightSwap"));
		
		screenResources.push(new ResourceImage("img/can/nap.png","quauudai"));

		//sfx

		//music
	musicResources.push(new ResourceMusic("audio/1.mp3","tone"));
	musicResources.push(new ResourceMusic("audio/map2.mp3","music2"));
	musicResources.push(new ResourceMusic("audio/map1.mp3","music1"));
	musicResources.push(new ResourceMusic("audio/soidong.mp3","soidong"));
	musicResources.push(new ResourceMusic("audio/hiendai.mp3","hiendai"));
	musicResources.push(new ResourceMusic("audio/buonnhe.mp3","buonnhe"));
	musicResources.push(new ResourceMusic("audio/echigo.mp3","echigo"));
	musicResources.push(new ResourceMusic("audio/them.mp3","them"));

		
		
		
	}
	
	//Loads all NPC and main character sprites into an array
	function loadCharacterSets() {
		//no longer used. All are loaded from explore.php.
	}
	
	
	function loadedSprite() {
		charsetLoadedCount++;
	}
	
	//Adds a sprite to the charsets array
	function addCharset(imgURL) {
		var newImage = new Image();
		newImage.onload = loadedSprite;
		newImage.onerror = loadedSprite;
		newImage.src = imgURL;
		charsets.push(newImage);

	}
	
	//### SCRIPTING FUNCTIONS ##############

	function triggerEvent( Event, fromCollision)
	{
		if( Event.bEventEnabled ) {
	
			lastTriggeredEventName = Event.name;
			
			//face the user
			if( Event.mapPosition.X > userEvent.mapPosition.X ) {
				scriptAddLine("move event",Event.id + "^Face Left^-5");
			} else if( Event.mapPosition.X < userEvent.mapPosition.X ) {
				scriptAddLine("move event",Event.id + "^Face Right^-5");
			} else if( Event.mapPosition.Y > userEvent.mapPosition.Y+2 ) {
				scriptAddLine("move event",Event.id + "^Face Up^1");
			} else if( Event.mapPosition.Y < userEvent.mapPosition.Y+2 ) {
				scriptAddLine("move event",Event.id + "^Face Down^1");
			} 
			
			for(var i=0;i<Event.eventData.length;i++) {
				activeScript.push(Event.eventData[i]);
			}
			if( activeScript.length > 0 ) {
				scriptProgress();
				return true;
			} else {
				return false;
			}
	
		}
		return false;
	}
	
	//### KEY PRESS / MOUSE FUNCTIONS ##############
	
	function getPosition(e) {
		e = e || window.event;
		var cursor = {x:0, y:0};
		if (e.pageX || e.pageY) {
			cursor.x = e.pageX;
			cursor.y = e.pageY;
		} 
		else {
			var de = document.documentElement;
			var b = document.body;
			cursor.x = e.clientX + 
				(de.scrollLeft || b.scrollLeft) - (de.clientLeft || 0);
			cursor.y = e.clientY + 
				(de.scrollTop || b.scrollTop) - (de.clientTop || 0);
		}
		return cursor;
	}
	
	function hitTest(x,y,boxX1,boxY1,boxX2,boxY2) {
		if( x >= boxX1 && x <= boxX2 ) {
			if( y >= boxY1 && y <= boxY2 ) {
				return true;
			}
		}
		return false;
	}
	
	function checkMousePosition(posX,posY) {
		var boxWidth = 160;
		var boxHeight = 40;
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
		
		var boxX = centerX+46;
		var boxY = centerY+110-50;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "atk1";
		}
		
		boxX = centerX+174;
		boxY = centerY+110-50;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "atk2";
		}
		
		boxX = centerX+46;
		boxY = centerY+145-50;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "atk3";
		}
		
		boxX = centerX+174;
		boxY = centerY+145-50;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "atk4";
		}

		boxWidth = 100;
		boxX = centerX-232+45;
		boxY = centerY+125-40;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "run";
		}
		
		boxX = centerX-138+45;
		boxY = centerY+125-40;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "item";
		}
		
		
		boxWidth = 50;
		boxHeight = 50;
		boxX = centerX-220;
		boxY = centerY-111-80;
		if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
			return "swap";
		}
		
		if( battleSelectedMenu > 6 && battleSelectedMenu <= 12 ) {
			for(var k=0;k< teamMonsters.length;k++) {
				var pos = k+1;
			
				var x = centerX;
				var y = centerY-75-60;
				if( pos < 4 ) {
					x = x - 110; 
					y = y + pos * 30;
				} else {
					x = x + 110; 
					y = y + (pos-3) * 30;
				}
				
				boxWidth = 200;
				boxHeight = 40;
				boxX = x;
				boxY = y;
				if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
					return "swap" + pos;
				}
			}
		} if( battleSelectedMenu == 13 ) {
			
			for(var k=0;k< battleItems.length;k++) {
				var pos = k+1;
			
				var x = centerX;
				var y = centerY-75-60;
				if( pos < 5 ) {
					x = x - 110; 
					y = y + pos * 30;
				} else {
					x = x + 110; 
					y = y + (pos-4) * 30;
				}
			
				boxWidth = 200;
				boxHeight = 40;
				boxX = x;
				boxY = y;
				if( hitTest(posX,posY,boxX-boxWidth/2,boxY-boxHeight/2,boxX+boxWidth/2,boxY+boxHeight/2) ) {
					return "item" + pos;
				}
			}
			
			
			
		}
		
		return "";
	}
	
	function canvasMouseDown(e) {
		var pos = getPosition(e);
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
		bMouseDown = true;
		
		var left = $("#cvsGame").offset().left + $("#cvsGame").position().left;
		var top = $("#cvsGame").offset().top + $("#cvsGame").position().top;
		
		var posX = pos.x-left;
		var posY = pos.y-top;




if(posX >=128 && posX <=150) {
if(posY >=10 && posY <=17) {
out();
}}

if(posX >=14 && posX <=56) {
if(posY >=23 && posY <=33) {
ttnv();
}}

if(posX >=3 && posX <=80) {
if(posY >=64 && posY <=75) {
    if(closechat==0) {
 	$("#gameChatBar").css("display", "none");
 	closechat =1;
} else {
  	$("#gameChatBar").css("display", "none");
   closechat=0;
}
    
}}

if(posX >=0 && posX <=28) {
if(posY >=121 && posY <=143) {
    ///camxuc
    
        datacanvas="camxuc";
    
}}

if(datacanvas=="camxuc") {
    if(posX >=0 && posX <=32 && posY >=157 && posY <=178) {
    camxuc =  0;datacanvas = '';timecamxuc =0;ketnoi();
    }
    
  if(posX >=33 && posX <=32*2 && posY >=157 && posY <=178) {
camxuc =  2;datacanvas = '';timecamxuc =0;ketnoi();
    }  
    
if(posX >=32*2 && posX <=32*3 && posY >=157 && posY <=178) {
camxuc =  4;timecamxuc =0;datacanvas = '';ketnoi();
    }      
    
if(posX >=32*3 && posX <=32*4 && posY >=157 && posY <=178) {
camxuc =  6; datacanvas = '';timecamxuc =0;ketnoi();
    } 
    ///hang2
  if(posX >=0 && posX <=32 && posY >=157+35 && posY <=178+35) {
    camxuc =  8;datacanvas = '';timecamxuc =0;ketnoi();
    }
    
  if(posX >=33 && posX <=32*2 && posY >=157+35 && posY <=178+35) {
camxuc =  10;datacanvas = '';timecamxuc =0;ketnoi();
    }  
    
if(posX >=32*2 && posX <=32*3 && posY >=157+35 && posY <=178+35) {
camxuc =  12;timecamxuc =0;datacanvas = '';ketnoi();
    }      
    
if(posX >=32*3 && posX <=32*4 && posY >=157+35 && posY <=178+35) {
camxuc =  14; datacanvas = '';timecamxuc =0;ketnoi();
    }        
    
    ///d
    
     ///hang2
  if(posX >=0 && posX <=32 && posY >=157+35*2 && posY <=178+35*2) {
    camxuc =  16;datacanvas = '';timecamxuc =0;ketnoi();
    }
    
  if(posX >=33 && posX <=32*2 && posY >=157+35*2 && posY <=178+35*2) {
camxuc =  18;datacanvas = '';timecamxuc =0;ketnoi();
    }  
    
if(posX >=32*2 && posX <=32*3 && posY >=157+35*2 && posY <=178+35*2) {
camxuc =  20;timecamxuc =0;datacanvas = '';ketnoi();
    }      
    
if(posX >=32*3 && posX <=32*4 && posY >=157+35*2 && posY <=178+35*2) {
camxuc =  22; datacanvas = '';timecamxuc =0;ketnoi();
    }        
    
    ///d
}

		
		
				var ex = -mapLeft + posX + 0 +13-20;
ey = (-currentMap.mapHeight/2-mapTop - posY-300)*-1-35;
clickx = tron(ex/16);
clicky = tron(ey/16);
if(userID ==1 && admin==1) {
userEvent.mapPosition.Y=clicky;
userEvent.mapPosition.X=clickx;
}
		if( bInBattle ) {
			if( battleScript.length > 0 ) {
				keyState.btn1 = true;
			} else {
				var activeMenu = checkMousePosition(posX,posY);
				if( activeMenu != "") {
					if( activeMenu != "item" && activeMenu != "swap" ) {
						keyState.btn1 = true;
					}
				}
			}
			
		} else {
			document.getElementById('mws-explore-trade-or-battle').innerHTML = "";
			for(var i=0;i< mmoUsers.length;i++) {
				var user = mmoUsers[i];
				if( pos.x-left > user.drawPosX && pos.x-left < user.drawPosX +32 ) {
					if( pos.y-top < user.drawPosY && pos.y-top > user.drawPosY -48 ) {
						if( user.name.indexOf("'s Pet") == -1 ) {
							displayMMOUser(user);
						}
					}
				}
			}
		}
		
		return false;
	}
	
	
	function canvasMouseUp(e) {
		var pos = getPosition(e);
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
		bMouseDown = false;
		

		
		return false;
	}
	
	
	function canvasMouseMove(e) {
		var pos = getPosition(e);
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
		var left = $("#cvsGame").offset().left + $("#cvsGame").position().left;
		var top = $("#cvsGame").offset().top + $("#cvsGame").position().top;
		
		var posX = pos.x-left;
		var posY = pos.y-top;
		
			var ex = -mapLeft + posX + 0 +13-20;
ey = (-currentMap.mapHeight/2-mapTop - posY-300)*-1-35;
clickx = tron(ex/16);
clicky = tron(ey/16);
clickpop = ' ('+posX+','+posY+') ';


		if( bInBattle ) {
			if( battleScript.length == 0 ) {
		
				var activeMenu = checkMousePosition(posX,posY);
				if( activeMenu == "atk1" && parseInt(battleStage) != 1) {
					battleSelectedMenu = 2;
				} else if( activeMenu == "atk2" && parseInt(battleStage) != 1) {
					battleSelectedMenu = 3;
				} else if( activeMenu == "atk3" && parseInt(battleStage) != 1) {
					battleSelectedMenu = 4;
				} else if( activeMenu == "atk4" && parseInt(battleStage) != 1) {
					battleSelectedMenu = 5;
				} else if( activeMenu == "run" && parseInt(battleStage) != 1) {
					battleSelectedMenu = 0;
				} else if( activeMenu == "item" && battleSelectedMenu != 13 && parseInt(battleStage) != 1) {
					battleSelectedMenu = 13;
				} else if( activeMenu == "swap"  && parseInt(battleStage) != 1 ) {
					battleSelectedMenu = 7;
				} else if( activeMenu.indexOf('swap') > -1 && activeMenu != "swap" ) {
					var pos = parseInt(activeMenu.replace(/swap/gi,''));
					battleSelectedMenu = pos+6;
				
				} else if( activeMenu.indexOf('item') > -1  && battleSelectedMenu == 13   && parseInt(battleStage) != 1 ) {
					var pos = parseInt(activeMenu.replace(/item/gi,''));
					battleItemSelectedMenu = pos-1;
				}
				
				if( activeMenu != "" )
					battleUpdatedMenu();
					
			
			}
		}

		
	}
	
	function dong_mmo(){
				$("#ducnghia_menu_data").html("");

	}
	
	//### MMO FUNCTIONS ###############
	function displayMMOUser(user) {
document.getElementById('ducnghia_info_g').style.display = "block";

				$("#ducnghia_menu_data").html("<center><b>" + user.name + "</b><br/> <button onclick='ketban(" + user.id + ")'>Kết bạn/add friend</button> <button onclick='openchat(" + user.id + ")'>Pm</button> <button onclick='ttnv(" + user.id + ")'>Profile</button> <button onclick='daupk(" + user.id + ")'>PVE</button><button onclick='moipk(" + user.id + ")'> PVP</button> <button onclick='dong_mmo()'>X</button>");
	}
	
	function pmUser(name) {
		if (userOnWhichChatTab	== "playerChat") {
			document.getElementById("PtxtUpdate").value = "/pm " + name + " ";
			document.getElementById("PtxtUpdate").focus();
		}
		else 
		{
			document.getElementById("TtxtUpdate").value = "/pm " + name + " ";
			document.getElementById("TtxtUpdate").focus();
		}
	}
	
	function pvpRequest(name) {
		ws.send("/msg^/pvprequest " + name + "\r\n\r\n");
		document.getElementById('mws-explore-trade-or-battle').innerHTML = ""; 
	}
	function pvpAccept(name) {
		ws.send("/msg^/pvpaccept " + name + "\r\n\r\n");
		document.getElementById("mws-explore-requests").innerHTML = "";
		
	}
	
	function pvpRequested(data) {
		var dataRow = data.split("^");
		document.getElementById("mws-explore-requests").innerHTML = '<div style="padding:8px;"><b>'+dataRow[1]+'</b> wants to battle: <br/><center><input type="button" style="width:120px;"  class="mws-tooltip-s mws-button green" value="Accept PvP" onclick="pvpAccept(\'' +dataRow[1]+ '\')" title="Accept"></center></div>';
	}
	
	var userCount = "?";
	function serverPing(data) {
		var dataRow = data.split("^");
		userCount = parseInt(dataRow[1]);
	}
	
	function pvpLoadBattle(data) {
		var dataRow = data.split("^");
		battleRoundTacker = 0;
			
		curOpp = null;
		nextOpp = null;
		curMon = null;
		nextMon = null;
		
		curMonImage.src = 'images/blank.png';
		curOppImage.src = 'images/blank.png';
		
		battleLoading = false;
		//battle_id needs to be provided.
		curOpp = null;
		scriptAddLine(battlescreen,"PVP");
		//bInBattle = true; - this is set in the above script funciton
		battleSelectedMenu = 2;
		playSFX("battle");
		playMusic("battle1");
		if( prevPlayingSong )
			prevPlayingSong.currentTime = 0;
		bWildBattle = false;
		wipeWildMonsterBox();
	}
	
	
	
	function chatPMKeyPress(e){
		e = e || event;
		
		var unicode=e.keyCode? e.keyCode : e.charCode
		if( unicode == 13 ) {
			e.preventDefault();
			if( e.target.value != "" ) {
				ws.send("/msg^/pm " + $(e.target).data('party') + " " + e.target.value + "\r\n\r\n");
				e.target.value = "";
				
				setTimeout(function(){ e.target.focus(); }, 50);
				return true;
			}
		}
		return false;
	}
	
	
	var privateMessages = new Array();
	
	function updateChat(data) {
		var dataRow = data.split("^");
		var dataMsg = dataRow[1].split("|");
		var isadmin = dataMsg[0];
		var userids = dataMsg[1];
		var user = dataMsg[2];
		var msg = dataMsg[3];
		var isPM = dataMsg[4];
		var whichChat = parseInt(dataMsg[4]);
		if (whichChat <= 0 || whichChat > 2 || whichChat === undefined)
			whichChat = 1;

		var changeColor = true;
		var title = "A Legend";
		var monid = 0;
		messages.push(new ChatMessage(isadmin,userids,user,msg));
		
		var sender = mmoUserByName(user);
		if( sender != null ) {
			sender.msg = msg;
			sender.msgTick = 0;
		} else {
			if( userids == userID ) {
				userEvent.msg = msg;
				userEvent.msgTick = 0;
			}
		}

		
		if (msg.toLowerCase().indexOf(userName.toLowerCase()) > -1)
		{
			color = "#CE93D8";
			changeColor = false;
		}

	
		
	
			privateMessages.push(pmParty);
			

		}
		
		
	
	
	function closePM(divName, party) {
		$("#" + divName).remove();
		privateMessages.remove(party);
	}

	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
			what = a[--L];
			while ((ax = this.indexOf(what)) !== -1) {
				this.splice(ax, 1);
			}
		}
		return this;
	};
	
	String.prototype.toTitleCase = function(n) {
		var s = this;
		if (1 !== n) s = s.toLowerCase();
		return s.replace(/\b[a-z]/g,function(f){return f.toUpperCase()});
	}
	
	function quickPM(msg)
	{
		if (msg.getAttribute("data-username") != "You" ){
			if (msg.getAttribute("data-chat") == "2")
				document.getElementById("TtxtUpdate").value = "/pm "+msg.getAttribute("data-username")+" ";
			else
				document.getElementById("PtxtUpdate").value = "/pm "+msg.getAttribute("data-username")+" ";
		}
	}
	
	//### AUDIO FUNCTIONS ###############
	
	function restoreLastSong() {
		if( musicEnabled == false ) 
			return;
			
		if( prevPlayingSong ) 
			prevPlayingSong.play();
			
		
	}
	
	function playMusicOnce(key) {
		if( musicEnabled == false ) 
			return;
			
		var audio = musicResourceByKey(key);
		if( audio ) {
		
			if( prevPlayingSong )
				prevPlayingSong.pause();
			
			if( playOnceSong )
				playOnceSong.pause();
			
			if( audio.audio == null ) {
				audio.audio = new Audio();
				audio.audio.src = audio.src;
				audio.audio.volume = 0.5;
				//this.audio.play();
				//this.audio.pause();
			}
			
			audio.audio.loop = false;
			audio.audio.addEventListener('ended', restoreLastSong);
			audio.audio.currentTime = 0;
			audio.audio.play();
			playOnceSong = audio.audio;
		}
	}
	
	function playMusic(key) {
		if( musicEnabled == false ) 
			return;
			
		var audio = musicResourceByKey(key);
		if( audio ) {
		
			if( prevPlayingSong )
				prevPlayingSong.pause();
			
			if( playOnceSong )
				playOnceSong.pause();
			
			if( audio.audio == null ) {
				audio.audio = new Audio();
				audio.audio.src = audio.src;
				audio.audio.volume = 0.35;
				//this.audio.play();
				//this.audio.pause();
			}
			
			audio.audio.loop = true;
			audio.audio.play();
			prevPlayingSong = audio.audio;
			prevPlaying = key;
		}
	}
	function playSFX(key) {
		if( soundEnabled == false ) 
			return;
			
		var audio = effectResourceByKey(key);
		if( audio ) {
			audio.play();
		}
	}
	
	
	//### SUPPORT FUNCTIONS ###############
	
	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	
	
// ################################################
// ### MMO USER CLASS ###########################
// ################################################
function mapit() {
}	
	
	

function MMOUser(id,name,trainerimg) {
	this.id = id;
	this.name = name;
	this.trainerimg = trainerimg;
	this.mapid = 0;
	this.x = 0;
	this.y = 0;
	this.NewX = 0;
	this.NewY = 0;
	this.direction = 0;
	this.step = 0;
	this.inbattle = 0;
 this.giatoc = 0;
 this.viettat = 0;

	this.drawPosX = 0;
	this.drawPosY = 0;
	this.drawStartX = 0;
	this.drawStartY = 0;
	
	this.isRunning = 0;
	
	this.stepPart = 0;
	this.stepAnimation = 0;
	this.offsetX = 0;
	this.offsetY = 0;
	this.stepX = 0;
	this.stepY = 0;
	
    this.moveQueue = new Array();
		
	this.msg = "";
	this.msgTick = 0;
	this.msgexp = 0;
	this.exp = 0;
	this.xu = 0;
	
	this.frameCount = 2;
	this.ImageRef = null;
		this.imgpokemon = null;

	this.updated = false;
	this.follow = '';
  this.camxuc = -1;
  this.timecamxuc = 0;
  this.stepcx2 = 0;
  this.datacamxuc2 = 0;
	this.evaluate = function() {
		
		this.stepX = 0;
		this.stepY = 0;
		if( this.moveQueue.length > 0 ) {
			if( this.moveQueue[0] == "up" ) {
				this.stepY = -this.stepPart;
			} else if( this.moveQueue[0] == "down" ) {
				this.stepY = this.stepPart;
			} else if( this.moveQueue[0] == "left" ) {
				this.stepX = -this.stepPart;
			} else {
				this.stepX = this.stepPart;
			}
		}
		
		this.drawPosX = mapLeft + (this.x * 16)+ this.stepX +13;
		this.drawPosY = -mapTop-currentMap.mapHeight/2 + ((this.y+2) * 16)+ this.stepY +2-130+32;
		
		var additionalDown = currentMap.mapHeight/2-cvsHeight/2;
		this.drawPosY = -mapTop-cvsHeight/2-currentMap.mapHeight/2 + ((this.y+2) * 16) + this.stepY +2+28 + (additionalDown-192);
		
		
		this.updateTextureCoords();	
		
		
		//process move queue - in between movequeue syncs check for position reevaluate
		this.processMoveQueue();
		
		if( this.msg != "" ) {
			this.msgTick++;
			if( this.msgTick > 250 ) {
				this.msg = "";
			}
		}
		
		if( this.exp > 0 ) {
			this.msgexp++;
			if( this.msgexp > 50 ) {
				this.exp = 0;
				this.xu = 0;
				this.msgexp = 0;
			}
		}
	}
	
	if(this.camxuc>=0) {
	    this.timecamxuc++;
	    if(this.timecamxuc >=150) {
	        this.camxuc =-1;
	        this.timecamxuc = 0;
	    }
	    
	}
	


	this.updatesWithoutMove = 0;
	this.processMoveQueue = function()    // Define Method
	{
		if( currentMap == null ) {
			return false;
		}
		
		if( this.moveQueue.length > 0 ) {
	
			if( this.moveQueue[0].toLowerCase() == "up" ) {
				this.direction = 0;
			} else if( this.moveQueue[0].toLowerCase() == "down" ) {
				this.direction = 1;
			} else if( this.moveQueue[0].toLowerCase() == "left" ) {
				this.direction = 2;
			} else if( this.moveQueue[0].toLowerCase() == "right" ) {
				this.direction = 3;
			}  
	
			if( this.stepPart == 8 || this.stepPart == 0 ) {
				this.stepAnimation++; 
				if( this.stepAnimation > this.frameCount ) 
					this.stepAnimation = 0;
			}

			this.stepPart = this.stepPart + 4;
			
		
	
			if( this.stepPart >= 16 ) {
				this.stepPart = 0;
		
				//update the coordanates at the end of the step.
				if( this.moveQueue[0] == "up" ) {
					this.y = this.y - 1;
				} else if( this.moveQueue[0] == "down" ) {
					this.y = this.y + 1;
				} else if( this.moveQueue[0] == "left" ) {
					this.x = this.x - 1;
				} else {
					this.x = this.x + 1;
				}
		
				this.moveQueue.splice(0,1); 
				
				if( Math.abs(this.NewX - this.x) > 6 || Math.abs(this.NewY - this.y) > 6 ) {
					this.x = this.NewX;
					this.y = this.NewY;
					this.moveQueue.length = 0;
				}
				
			}
		}
		
		if( this.moveQueue.length == 0 ) {
			//add to moveQueue based on position
			
			if( this.y > this.NewY ) {
				if( currentMap.tileIsWalkable( Point(this.x,this.y-2-1)) ) {
					this.addMoveQueue("up");
				}
			} else if( this.y < this.NewY ) {
				if( currentMap.tileIsWalkable( Point(this.x,this.y-2+1)) ) {
					this.addMoveQueue("down");
				}
			} else if( this.x > this.NewX ) {
				if( currentMap.tileIsWalkable( Point(this.x-1,this.y-2)) ) {
					this.addMoveQueue("left");
				}
			} else if( this.x < this.NewX ) {
				if( currentMap.tileIsWalkable( Point(this.x+1,this.y-2)) ) {
					this.addMoveQueue("right");
				}
			}
			
			this.updatesWithoutMove++;
			
			if( this.updatesWithoutMove > 10 ) {
				this.x=this.NewX;
				this.y=this.NewY;
				this.updatesWithoutMove = 0;
			}

		} else {
			this.updatesWithoutMove = 0;
		}

	}
	

	
	
	this.addMoveQueue = function(moveDirection)    // Define Method
	{
		this.moveQueue.push(moveDirection.toLowerCase());
	}
	
	this.drawNames = function(ctx)    // Define Method
	{
		if( this.name.indexOf("'s Pet") > -1 ) {
			return;
		}
	
		ctx.font = "bold 11px sans-serif";
		ctx.textAlign = "center";

if(this.exp >0) {
    	drawShadowText(ctx,"+"+this.exp+" Xp",  this.drawPosX+12, this.drawPosY+20-this.msgexp,"#00FFFF");  
}
if(this.xu >0) {
    	drawShadowText(ctx,"+"+this.xu+" xu",  this.drawPosX+12, this.drawPosY+35-this.msgexp,"#01DF01");  
}

	if(this.camxuc>=0) {
	if(this.datacamxuc<=10) {
			     this.stepcx = 32;  
			    this.datacamxuc++;
			}
			else
			if(this.datacamxuc>=11 && this.datacamxuc <=20) {
			   			     this.stepcx =0; this.datacamxuc++; 
 
			}
			else {
			     this.stepcx =0; this.datacamxuc=0; 
			}		
	ctx.drawImage(resourceByKey("camxuc"), 32*this.camxuc+this.stepcx, 0, 32, 32,  this.drawPosX-5, this.drawPosY-40, 32, 32 );
		
			}

	 			drawShadowText(ctx,this.name,  this.drawPosX+12, this.drawPosY-1);
    
	 
			ctx.font = "bold 13px sans-serif";
		ctx.textAlign = "center";
		if( this.msg != "" && this.id == 1 ) {
			drawShadowText(ctx,this.msg,  this.drawPosX+12, this.drawPosY-14,"#B8570D");
		} 
		
			if( this.msg != "" && this.id != 1 ) {
			drawShadowText(ctx,'"'+this.msg+'"',  this.drawPosX+12, this.drawPosY-14,"#FFFFFF");
		}
		
	
	}

	
	this.drawImage = function(ctx)    // Define Method
	{

		//context.drawImage(img,sx,sy,swidth,sheight,dx,dy,dwidth,dheight);
		if( this.ImageRef == null ) {
			for(var i=0;i< charsets.length;i++) {
				var img = charsets[i];
				if( img.src ) {
				    			//	console.log(img);

					if( img.src.indexOf("/" + this.trainerimg) > 0 ) {
						this.ImageRef = img;
						if( img.width == 64 ) {
							this.frameCount = 1;
						}
						if( img.width == 32 ) {
							this.frameCount = 0;
						}
					}
				}
			}
		}
		
		///pokemon
		if( this.imgpokemon == null ) {
			for(var i=0;i< charsets.length;i++) {
				var img = charsets[i];
				if( img.src ) {
				    			//	console.log(img);

					if( img.src.indexOf("/" + this.follow) > 0 ) {
						this.imgpokemon = img;
						if( img.width == 64 ) {
							this.frameCount = 1;
						}
						if( img.width == 32 ) {
							this.frameCount = 0;
						}
					}
				}
			}
		}
		
		if( this.ImageRef != null ) {
			ctx.drawImage(this.ImageRef, this.drawStartX, this.drawStartY, 32, 32,  this.drawPosX-5, this.drawPosY, 32, 32 );
			
		}
		
 if(this.imgpokemon != null) {
if(this.direction==0){
var xpet = this.drawPosX;
var ypet = this.drawPosY+25;     
}

if(this.direction==1){
var xpet = this.drawPosX;
var ypet = this.drawPosY-25;         
}

if(this.direction==2){
var xpet = this.drawPosX+25;
var ypet = this.drawPosY;      
}

if(this.direction==3){
var xpet = this.drawPosX-25;
var ypet = this.drawPosY;
}
	
	ctx.drawImage(this.imgpokemon, this.drawStartX, this.drawStartY, 32, 32,  xpet, ypet, 32, 32 );	         
	         
}
		    	    
		    
		    
		


		if( parseInt(this.inbattle) == 1 ) {
		    ctx.drawImage(resourceByKey("pokeballicon"), this.drawPosX+4, this.drawPosY-26);
		}
		
		///module gia tộc
		///MODULE ICON
		if( parseInt(this.giatoc) != 0) {
		if(nicon !=1) {
		ctx.textAlign = "left";
	 ctx.drawImage(resourceByKey(this.giatoc),this.drawPosX-26, this.drawPosY-10);
		}
	 ///MODULE VIẾT TẮT
	 			ctx.font = "bold 10px sans-serif";

		ctx.textAlign = "left";
			drawShadowText(ctx,"["+this.viettat+"]",  this.drawPosX+36, this.drawPosY-1, "#BBDEFB");
}

///ducnghia

		
		
		

	}

	this.updateTextureCoords = function()    // Define Method
	{

		var startX = 0;
		var startY = 0;

		if( this.direction == 0 ) {
			switch(this.stepAnimation) {
				case 0 :
					startX = 0;
					startY = 0;
				break;
				case 1 :
					startX = 1;
					startY = 0;
				break;
				case 2 :
					startX = 2;
					startY = 0;
				break;
			}
		} else if( this.direction == 1 ) {
			switch(this.stepAnimation) {
				case 0 :
					startX = 0;
					startY = 1;
				break;
				case 1 :
					startX = 1;
					startY = 1;
				break;
				case 2 :
					startX = 2;
					startY = 1;
				break;
			}
		} else if( this.direction == 2 ) {
			switch(this.stepAnimation) {
				case 0 :
					startX = 0;
					startY = 2;
				break;
				case 1 :
					startX = 1;
					startY = 2;
				break;
				case 2 :
					startX = 2;
					startY = 2;
				break;
			}
		} else {
			switch(this.stepAnimation) {
				case 0 :
					startX = 0;
					startY = 3;
				break;
				case 1 :
					startX = 1;
					startY = 3;
				break;
				case 2 :
					startX = 2;
					startY = 3;
				break;
			}
		}
		
		this.drawStartX = startX*32;
		this.drawStartY = startY*32;
	}
		
	return this;
}

var mmoUsers = new Array();
function updateMMOEvents(updateData) {

	for(var k=0;k<mmoUsers.length;k++) {
		mmoUsers[k].updated = false;
	}

	var dataRaw = updateData.split("^");
	for(var k=1;k<dataRaw.length;k++) {

		if( dataRaw[k] != "" ) {
			var dataUser = dataRaw[k].split("|");
			if (bShowUsers	|| friendsList.indexOf(dataUser[0]) > -1) {
			var user = mmoUserByName(dataUser[1]);
			if( user == null ) {
				//add id,name,trainerimg
				
				user = new MMOUser(dataUser[0],dataUser[1],dataUser[2]);
				mmoUsers.push(user);
			}
			
			//update mapid,x,y,direction,step,inbattle
			
			user.mapid = dataUser[3];
			
			user.NewX = parseInt(dataUser[4]);
			user.NewY = parseInt(dataUser[5]);
			
			if( user.x == 0 ) {
				user.x = user.NewX;
				user.y = user.NewY;
			}
			
			user.direction = parseInt(dataUser[6]);
			user.step = 0;
			user.isRunning = 0;
			user.inbattle = dataUser[7];
			user.giatoc = dataUser[8];
			user.viettat = dataUser[9];
			user.follow = dataUser[10];
			user.exp = dataUser[11];
			user.xu = dataUser[12];
			user.camxuc = dataUser[13];
	
			user.updated = true;
		  }
		}
	}

	
	//remove old connections
	for(var k=0;k<mmoUsers.length;k++) {
		if( k < mmoUsers.length ) {
			if( mmoUsers[k].updated == false ) {
				mmoUsers.splice(k,1);
				k--;
			}
		}
	}
	
}

function mmoUserByName(name) {
	for(var k=0;k<mmoUsers.length;k++) {
		if( name == mmoUsers[k].name ) {
			return mmoUsers[k];
		}
	}
	return null;
}


function Point(x,y) {
	this.X = x;
	this.Y = y;
	return this;
}

// ################################################
// ### GAME EVENT CLASS ###########################
// ################################################
function ScriptLine(line,func,args,id) {
	this.func = func;
	this.args = args;
	this.line = line;
		this.id = id;

	return this;
}


function GameEgg(node) {
	if( node ) {
        
		this.id = nodeValue(firstChildNodeNamed("id", node));
		this.steps = nodeValue(firstChildNodeNamed("steps", node));
		
	}
	return this;
}

function GameItem(node) {
	if( node ) {
        
		this.id = nodeValue(firstChildNodeNamed("id", node));
		this.name = nodeValue(firstChildNodeNamed("name", node));
		this.file = nodeValue(firstChildNodeNamed("file", node));
		this.qty = nodeValue(firstChildNodeNamed("qty", node));
	}
	return this;
}

    function gameEvent(node)
	{
        this.moveQueue = new Array();
        this.mapPosition = new Object;
        
        this.bEventEnabled = false;
        this.bHidden = false;
        
        
		this.bIsUser = true;
		this.id = 0; 
		this.name = "";
		this.mapPosition.X = 0;
		this.mapPosition.Y = 0;
		this.spriteName = "";
		this.type = "";
		this.direction = 0;
		this.moveType = "";
		
		this.quest = 0;
			this.chuanhan = 0;
				this.danhan = 0;
				this.hoanthanh = 0;

		this.frameCount = 2;
		
        //Event Properties
        this.eventData = new Array();
        
		this.mapPosition.X = 0;
		this.mapPosition.Y = 0;
		


        //Core Variables
        if( node ) {

			this.id = nodeValue(firstChildNodeNamed("id", node));
			this.name = nodeValue(firstChildNodeNamed("name", node));
			this.mapPosition.X = parseInt(nodeValue(firstChildNodeNamed("x", node)))-1;
			this.mapPosition.Y = parseInt(nodeValue(firstChildNodeNamed("y", node)))+1;
			this.type = nodeValue(firstChildNodeNamed("type", node));
			this.spriteName = nodeValue(firstChildNodeNamed("style", node));
			this.direction = parseInt(nodeValue(firstChildNodeNamed("direction", node)));
			this.moveType = nodeValue(firstChildNodeNamed("movement", node));
        	this.bIsUser = false;
        	this.bEventEnabled = true;
        	
			this.quest = parseInt(nodeValue(firstChildNodeNamed("quest", node)));
						this.chuanhan = parseInt(nodeValue(firstChildNodeNamed("chuanhan", node)));

									this.danhan = parseInt(nodeValue(firstChildNodeNamed("danhan", node)));

								this.hoanthanh = parseInt(nodeValue(firstChildNodeNamed("hoanthanh", node)));
	
        	var script = firstChildNodeNamed("script", node);
        	for(var i=0;i<script.childNodes.length;i++) {
        		line = script.childNodes[i];
        		this.eventData.push(new ScriptLine( nodeValue(firstChildNodeNamed("line", line)) , nodeValue(firstChildNodeNamed("function", line)) , nodeValue(firstChildNodeNamed("arguments", line)),nodeValue(firstChildNodeNamed("id", node)) ));
        	//	console.log('xxxx');
        	}
        		
        }

        //Movement
        this.stepPart = 0;
        this.stepAnimation = 0;

        this.bJumping = false;
        this.jumpYAdd = 0;
        this.jumpYAcc = 0;
        
		this.drawStartX = 0;
		this.drawStartY = 0;
        this.X = 0;
        this.Y = 0;
        
        this.offsetX = 0;
        this.offsetY = 0;
        this.stepX = 0;
        this.stepY = 0;

		this.msg = "";
		this.msgTick = 0;
        
        this.bHasAppearance = false;
		if( this.spriteName != "" ) {
			this.bHasAppearance = true;
		}
		
        
        this.ImageRef = null;
 this.nx = 0;
 this.ny =0;
 this.canhX = 29;
 this.canhY = 48;
 	this.ducnghiacanh = function()    // Define Method
		{
		
			var dNX = this.canhX * 16;
			var dMY = this.canhY * 16;
			if( currentMap == null ) {
				return;
			}
	
				//NPC EVENT POSITIONING
				
			
	
				var additionalDown2 = currentMap.mapHeight/2-cvsHeight/2;
				 this.nx = mapLeft + dNX + 0+13;
				this.ny = -mapTop-cvsHeight/2-currentMap.mapHeight/2 + dMY + 0 -2+28 + (additionalDown2-192);
				
			
	
		}       

	this.drawImage2 = function(ctx)    // Define Method
		{
		    if(mapID ==3)
		   ctx.drawImage(resourceByKey("longden"),  this.nx-5, this.ny);
 
		}

		this.drawImage = function(ctx)    // Define Method
		{


        	//context.drawImage(img,sx,sy,swidth,sheight,dx,dy,dwidth,dheight);
			
        	if( this.ImageRef == null ) {

				for(var i=0;i< charsets.length;i++) {
					var img = charsets[i];
					if( img.src ) {
						if( img.src.indexOf("/" + this.spriteName) > 0 ) {
						   // console.log(this.spriteName);

							this.ImageRef = img;
							if( img.width == 64 ) {
								this.frameCount = 1;
							}
							if( img.width == 32 ) {
								this.frameCount = 0;
							}
						}
					}
				}
        	}

        	  

        	
        	if( this.ImageRef != null ) {
     	    
        		if( this.bHidden == false ) {
        			ctx.drawImage(this.ImageRef, this.drawStartX, this.drawStartY, 32, 32,  this.X-5, this.Y, 32, 32 );
        		    
	
					if( parseInt(this.quest) > 0  ) {
						ctx.drawImage(resourceByKey("battleicon"),  this.X+2, this.Y-14);
					}
					
		if( parseInt(this.chuanhan) > 0) {
						ctx.drawImage(resourceByKey("chuanhan"),  this.X+5, this.Y-30);
					}
								var img = resourceByKey("ani-air");

	//		ctx.drawImage((resourceByKey("ani-air"), 10, 15, 32, 32,  this.drawPosX-5, this.drawPosY, 32, 32 );

					
	if( parseInt(this.danhan) > 0) {
						ctx.drawImage(resourceByKey("danhan"),  this.X+5, this.Y-30);
					}	
					
	if( parseInt(this.hoanthanh) > 0) {
						ctx.drawImage(resourceByKey("hoanthanh"),  this.X+5, this.Y-30);
					}						
					
				
				
	

if(npcid == this.id && npctime >0) {
  	ctx.font = "bold 12px sans-serif";
				ctx.textAlign = "center";
		//sử lí text giaoiep npc.
		var demkitu = npctext.length;
		if(demkitu <=30) {
				
				drawShadowText(ctx,npctext,  this.X+10, this.Y-1,"#01DF01");  
		}else
		if(demkitu >=31 && demkitu <=60) {
		    				drawShadowText(ctx,npctext.substr(0, 30),  this.X+10, this.Y-15,"#01DF01");  
		    				drawShadowText(ctx,npctext.substr(30, 60),  this.X+10, this.Y-1,"#01DF01");  

		}else
		
		if(demkitu >=61 && demkitu <=90) {
		    				drawShadowText(ctx,npctext.substr(0, 30),  this.X+10, this.Y-29,"#01DF01");  
		    				drawShadowText(ctx,npctext.substr(30, 60),  this.X+10, this.Y-15,"#01DF01");  
		    				drawShadowText(ctx,npctext.substr(60, 90),  this.X+10, this.Y-1,"#01DF01");  

		}else
		
		if(demkitu >=91 && demkitu <=120) {
		    		    				drawShadowText(ctx,npctext.substr(0, 30),  this.X+10, this.Y-43,"#01DF01");  

		    				drawShadowText(ctx,npctext.substr(30, 60),  this.X+10, this.Y-29,"#01DF01");  
		    				drawShadowText(ctx,npctext.substr(60, 90),  this.X+10, this.Y-15,"#01DF01");  
		    				drawShadowText(ctx,npctext.substr(90, 120),  this.X+10, this.Y-1,"#01DF01");  

		}

} else {
    	ctx.font = "bold 10px sans-serif";
				ctx.textAlign = "center";
				drawShadowText(ctx,this.name,  this.X+10, this.Y-1);
}
				
        		}
        	}
        }
        
		 
		this.initWithData = function(data)    // Define Method
		{
			
			this.processConditions();
			this.evaluate();
		}
	
		this.initAsPlayer = function(position)    // Define Method
		{
			this.bIsUser = true;
			this.bEventEnabled = true;
			
			this.spriteName = userSprite;
			this.direction = 1;
			
			this.mapPosition.X = position.X;
			this.mapPosition.Y = position.Y;
			
			
			
			
			this.evaluate();
		}
		
		this.processConditions = function()    // Define Method
		{
			this.bEventEnabled = true;
		}
	
		this.addMoveQueue = function(moveDirection)    // Define Method
		{
			this.moveQueue.push(moveDirection.toLowerCase());

		}
		
		
	
		this.evaluate = function()    // Define Method
		{
			if( this.bEventEnabled == false ) {
				return;
			}
			if( currentMap == null ) {
				return;
			}
			if( this.bIsUser == false && this.bHidden == false ) {
				this.processNPCMovement();
			}
			this.processMoveQueue();
			this.updatePosition();
			this.ducnghiacanh();
			
			if( this.msg != "" ) {
				this.msgTick++;
				if( this.msgTick > 250 ) {
					this.msg = "";
				}
			}
		}
	
		this.processNPCMovement = function()    // Define Method
		{
			if( this.moveQueue.length == 0 && activeScript.length == 0  &&  bInBattle == false) {
				if( this.moveType == "Slow Random" || this.moveType == "Fast Random" ) {
			
					//Random Movement
					if( Math.floor(Math.random() * 10) == 1 ) {
						var randDirection = Math.floor(Math.random() * 4);
						if( randDirection == 0 ) {
							if( currentMap.tileIsWalkable( Point(this.mapPosition.X,this.mapPosition.Y-2-1)) ) {
								this.addMoveQueue("up");
							}
						} else if( randDirection == 1 ) {
							if( currentMap.tileIsWalkable( Point(this.mapPosition.X,this.mapPosition.Y-2+1)) ) {
								this.addMoveQueue("down");
							}
						} else if( randDirection == 2 ) {
							if( currentMap.tileIsWalkable( Point(this.mapPosition.X-1,this.mapPosition.Y-2)) ) {
								this.addMoveQueue("left");
							}
						} else {
							if( currentMap.tileIsWalkable( Point(this.mapPosition.X+1,this.mapPosition.Y-2)) ) {
								this.addMoveQueue("right");
							}
						}

					}
				} else if( this.moveType ==  "Follow User" ) {
					var xDif = userEvent.mapPosition.X - this.mapPosition.X;
					var yDif = userEvent.mapPosition.Y + 2 - this.mapPosition.Y;
					steps = 0;
					var dir = "";
					
					if( userEvent.moveQueue.length != 0 ) {
						if( xDif != 0 ) {
							if( xDif < 0 ) {
								dir = "left";
								steps = -xDif-5;
							} else {
								dir = "right";
								steps = xDif+5;
							}
						}
						if( yDif != 0 ) {
							if( yDif < 0 ) {
								dir = "up";
								steps = -yDif;
							} else {
								dir = "down";
								steps = yDif;
							}
						}

						
						
						if( dir != "" ) {
							this.addMoveQueue(dir);
						}

						
					}
				}
			}
		}
	
		this.processMoveQueue = function()    // Define Method
		{
			if( currentMap == null ) {
				return false;
			}
			
			
			
			
			var bPassedCheck = false;
			if( !this.bIsUser ) {
				bPassedCheck = true;
				if( this.moveQueue.length > 0 ) {
					if( this.moveQueue[0].toLowerCase() == "face up" ) {
						this.direction = 0;
						this.moveQueue.splice(0,1); 
					} else if( this.moveQueue[0].toLowerCase() == "face down" ) {
						this.direction = 1;
						this.moveQueue.splice(0,1); 
					} else if( this.moveQueue[0].toLowerCase() == "face left" ) {
						this.direction = 2;
						this.moveQueue.splice(0,1); 
					} else if( this.moveQueue[0].toLowerCase() == "face right" ) {
						this.direction = 3;
						this.moveQueue.splice(0,1); 
					} else if( this.moveQueue[0].toLowerCase() == "hide" ) {
						this.bHidden = true;
						this.moveQueue.splice(0,1); 
					} else if( this.moveQueue[0].toLowerCase() == "show" ) {
						this.bHidden = false;
						this.moveQueue.splice(0,1); 
					}
						
				}
			} else {
				while( bPassedCheck == false ) {
					if( this.moveQueue.length > 0 ) {
c_giaotiep();
auto_t();
timvitri()
    		$("#chien").html('0');
    document.getElementById('listonline').style.display = "none";

						if( this.moveQueue[0] == "up" ) {
						  

							if( !currentMap.tileIsWalkable( Point(this.mapPosition.X,this.mapPosition.Y-1)) ) {
								this.moveQueue.splice(0,1); 
								this.direction = 0;
							} else {
								bPassedCheck = true;
							}
						} else if( this.moveQueue[0] == "down" ) {
							if( !currentMap.tileIsWalkable( Point(this.mapPosition.X,this.mapPosition.Y+1)) ) {
								this.moveQueue.splice(0,1); 
								this.direction = 1;
							} else {
								bPassedCheck = true;
							}
						} else if( this.moveQueue[0] == "left" ) {
							if( !currentMap.tileIsWalkable( Point(this.mapPosition.X-1,this.mapPosition.Y)) ) {
								this.moveQueue.splice(0,1); 
								this.direction = 2;
							} else {
								bPassedCheck = true;
							}
						} else if( this.moveQueue[0] == "right" ) {
							if( !currentMap.tileIsWalkable( Point(this.mapPosition.X+1,this.mapPosition.Y)) ) {
								this.moveQueue.splice(0,1); 
								this.direction = 3;
							} else {
								bPassedCheck = true;
							}
							
						} else if( this.moveQueue[0] == "jump" ) {
							bPassedCheck = true;
						} else if( this.moveQueue[0].toLowerCase() == "face up" ) {
							this.direction = 0;
							this.moveQueue.splice(0,1); 
						} else if( this.moveQueue[0].toLowerCase() == "face down" ) {
							this.direction = 1;
							this.moveQueue.splice(0,1); 
						} else if( this.moveQueue[0].toLowerCase() == "face left" ) {
							this.direction = 2;
							this.moveQueue.splice(0,1); 
						} else if( this.moveQueue[0].toLowerCase() == "face right" ) {
							this.direction = 3;
							this.moveQueue.splice(0,1); 
						} else if( this.moveQueue[0].toLowerCase() == "hide" ) {
							this.bHidden = true;
							this.moveQueue.splice(0,1); 
						} else if( this.moveQueue[0].toLowerCase() == "show" ) {
							this.bHidden = false;
							this.moveQueue.splice(0,1); 
						}  else {
							bPassedCheck = true;
						}
				//	document.getElementById('ducnghia_img').src = '/xml/nhanvat.php?nhanvat='+userSprite+'&nut='+this.direction+'&nghia='+this.stepAnimation+'';	


					} else {
						bPassedCheck = true;
					}
					
					if( bPassedCheck == false ) {
						//this.moveQueue.splice(0, 1);
					}
				}
			}
	
			if( this.moveQueue.length > 0 ) {
		
				if( this.moveQueue[0].toLowerCase() == "up" ) {
					this.direction = 0;
				} else if( this.moveQueue[0].toLowerCase() == "down" ) {
					this.direction = 1;
				} else if( this.moveQueue[0].toLowerCase() == "left" ) {
					this.direction = 2;
				} else if( this.moveQueue[0].toLowerCase() == "right" ) {
					this.direction = 3;
				} else if( this.moveQueue[0].toLowerCase() == "jump" ) {
					this.jumpYAcc = this.jumpYAcc + 2;
					this.jumpYAdd = this.jumpYAdd + this.jumpYAcc;
			
					if( this.jumpYAcc == 4 ) {
						this.jumpYAcc = 0;
						this.jumpYAdd = 0;
						this.bJumping = false;
				
						this.moveQueue.splice(0,1); 
					}
	
					return;
				}
								

		
				if( this.stepPart == 8 || this.stepPart == 0 ) {
					this.stepAnimation++; 
					if( this.stepAnimation > this.frameCount ) 
						this.stepAnimation = 0;
				}
	
				this.stepPart = this.stepPart + 4;
				if( this.moveType == "Slow Random" ) 
					this.stepPart = this.stepPart - 2;
					
		if( userID >=1 && this.moveQueue.length == 1 && (this.bIsUser || this.id==-1))  {
		    if(userSprite =="Ghost-Spooky.png") {
		        this.speednew = 2;
		    } else
		    if(userSprite =="PrincessPhoenix.png") {
		        this.speednew = 2;
		    } else
		    if(userSprite =="Mummy.png") {
		        this.speednew = 3;
		    } else 
		    
		    if(userSprite =="Illusionist.png") {
		        this.speednew = 2;
		    } else 
		    
		    {
		        this.speednew = 0;
		    }
		    
					this.stepPart = this.stepPart + this.speednew ;			
				
		}
				if( keyState.btn2 && this.moveQueue.length == 1 && (this.bIsUser || this.id==-1)) 
					this.stepPart = this.stepPart + 4;

				if( keyState.btn2 && this.moveQueue.length == 1 && (!this.bIsUser ) && this.id != -1 && this.moveType ==  "Follow User" ) 
					this.stepPart = this.stepPart + 4;
		
				if( this.stepPart >= 16 ) {
					this.stepPart = 0;
			
					//update the coordanates at the end of the step.
					if( this.moveQueue[0] == "up" ) {
						this.mapPosition.Y = this.mapPosition.Y - 1;
					} else if( this.moveQueue[0] == "down" ) {
						this.mapPosition.Y = this.mapPosition.Y + 1;
					} else if( this.moveQueue[0] == "left" ) {
						this.mapPosition.X = this.mapPosition.X - 1;
					} else {
						this.mapPosition.X = this.mapPosition.X + 1;
					}
			
					if( this.bIsUser ) {
						if( activeScript.length == 0 ) {
							if( this.eventCheck() == true ) {
								this.arrivedOnTile();
							}
						}
					}
			
					this.moveQueue.splice(0,1); 
				}
		
			}
		}
		

		
				
		this.eventCheck = function()    // Define Method
		{
	        for(var i=0;i<currentMap.events.length;i++) {
				var evnt = currentMap.events[i];
				
		        if( evnt.mapPosition.X == userEvent.mapPosition.X && evnt.mapPosition.Y == userEvent.mapPosition.Y + 2  ) {
                    if (evnt.type == "On Walk" && evnt.bEventEnabled && activeScript.length == 0 && evnt.eventData.length > 0)
                    {
				        if( triggerEvent( evnt , false) ) {
					        return false;
				        }
			        }
		        }
				
				//type
		        if( evnt.bEventEnabled && (evnt.type == "X1" || evnt.type == "X2" || evnt.type == "X3" || evnt.type == "X10" || evnt.type == "X15" || evnt.type == "X20")  && activeScript.length == 0 && evnt.eventData.length > 0 ) {
			        var stepsCheck = 1;
			        if( evnt.type == "X2" )
				        stepsCheck = 2;
			        if( evnt.type == "X3" )
				        stepsCheck = 3;
				    if( evnt.type == "X10" )
				        stepsCheck = 10;
				    if( evnt.type == "X15" )
				        stepsCheck = 15;
				    if( evnt.type == "X20" )
				        stepsCheck = 20;
				    
				    
			
			        for(var check = 1;check <= stepsCheck;check++) {
				        if( evnt.mapPosition.X+check == userEvent.mapPosition.X && evnt.mapPosition.Y == userEvent.mapPosition.Y + 2 && evnt.direction == 3 ) {
					        if( triggerEvent( evnt , true) ) {
						        return false;
					        }
				        }
				        if( evnt.mapPosition.X-check == userEvent.mapPosition.X && evnt.mapPosition.Y == userEvent.mapPosition.Y + 2 && evnt.direction == 2  ) {
					        if( triggerEvent( evnt , true) ) {
						        return false;
					        }
				        }
				        if( evnt.mapPosition.X == userEvent.mapPosition.X && evnt.mapPosition.Y+check == userEvent.mapPosition.Y + 2 && evnt.direction == 1  ) {
					        if( triggerEvent( evnt , true) ) {
						        return false;
					        }
				        }
				        if( evnt.mapPosition.X == userEvent.mapPosition.X && evnt.mapPosition.Y-check == userEvent.mapPosition.Y + 2 && evnt.direction == 0  ) {
					        if( triggerEvent( evnt , true) ) {
						        return false;
					        }
				        }
			        }
		        }
	        }
	        return true;
		}
		
		this.arrivedOnTile = function()    // Define Method
		{
			if( this.mapPosition.X == -1 ) {
				if( firstChildNodeNamed("west", mapEvents) != null ) {
					loadMap(nodeValue(firstChildNodeNamed("west", mapEvents)), "wrap", 2)
					return;
				}
			}
			if( this.mapPosition.X+2 == Math.floor(mapWidth/16) ) {
				if( firstChildNodeNamed("east", mapEvents) != null ) {
					loadMap(nodeValue(firstChildNodeNamed("east", mapEvents)), "wrap", 3)
					return;
				}
			}
			if( this.mapPosition.Y+2 == Math.floor(mapHeight/16) ) {
				if( firstChildNodeNamed("south", mapEvents) != null ) {
					loadMap(nodeValue(firstChildNodeNamed("south", mapEvents)), "wrap", 1)
					return;
				}
			}
			if( this.mapPosition.Y == -1 ) {
				if( firstChildNodeNamed("north", mapEvents) != null ) {
					loadMap(nodeValue(firstChildNodeNamed("north", mapEvents)), "wrap", 0)
					return;
				}
			}
			if( this.isInGrass() ) {
				stepsInGrass++;
			} else {
			
			}
			if( stepsInGrass >= 9 ) {
			
				
					//TODO: START A BATTLE!!!				
					showMonsterAtCoord();
					
					stepsInGrass=0;

			
			}
			
				
			
			if( activeScript.length == 0 ) {
				if( parseInt(Math.random()*15) == 2 ) {
					if( eggs.length > 0 ) {
						for(var i=0;i<eggs.length;i++) {
							if( eggs[i].steps > 45 ) {
								hatchingEgg = true;
								loadUtility("action=hatch");
								break;
							}
						}
					}
				}
			}
			
			
		}
		
		this.isInGrass = function()    // Define Method
		{
			for(var i=0;i<currentMap.grassPatches.length;i++) {
				var patch = currentMap.grassPatches[i];
				grass = '(Grass:X,Y: '+patch.VX+','+patch.VY+' -W,H: '+patch.VW+','+patch.VH+') ';
				if( this.mapPosition.X >= patch.X1 && this.mapPosition.X <= patch.X2-2 ) {
					if( this.mapPosition.Y+2 >= patch.Y1 && this.mapPosition.Y+2 <= patch.Y2 ) {
						return true;
					}
				}
			}
			return false;
		} 
		
		
		
		///http://forum.pokemonlegends.com/viewtopic.php?t=669
		
	
		this.updatePosition = function()    // Define Method
		{
			var ySink = 0;
			
			this.stepX = 0;
			this.stepY = 0;
			
			this.offsetX = 0;
			this.offsetY = 0;
			
	
			var MyX = this.mapPosition.X * 16;
			var MyY = this.mapPosition.Y * 16;
			if( currentMap == null ) {
				return;
			}
	
			if( this.bIsUser == false ) {
				//NPC EVENT POSITIONING
				
				if( this.moveQueue.length > 0 ) {
					if( this.moveQueue[0] == "up" ) {
						this.stepY = -this.stepPart;
					} else if( this.moveQueue[0] == "down" ) {
						this.stepY = this.stepPart;
					} else if( this.moveQueue[0] == "left" ) {
						this.stepX = -this.stepPart;
					} else {
						this.stepX = this.stepPart;
					}
				}
	
				var additionalDown = currentMap.mapHeight/2-cvsHeight/2;
				this.X = mapLeft + MyX + this.stepX+13;
				//this.Y = -mapTop-currentMap.mapHeight/2 + MyY + this.stepY - Math.floor(this.jumpYAdd)+2-130+32;
				this.Y = -mapTop-cvsHeight/2-currentMap.mapHeight/2 + MyY + this.stepY - Math.floor(this.jumpYAdd)+2+28 + (additionalDown-192);
				
			} else {
				//USER EVENT POSITIONING
				if( this.moveQueue.length > 0 ) {
					if( this.moveQueue[0] == "left" ) {
						if(  MyX <= cvsWidth/2 || MyX > currentMap.mapWidth - cvsWidth/2 ) {
							this.stepX = -this.stepPart;
						}
					} else if( this.moveQueue[0] == "right" ) {
						if(  MyX < cvsWidth/2 || MyX >= currentMap.mapWidth - cvsWidth/2 ) {
							this.stepX = this.stepPart;
						}
					}
				}
				if(  MyY <= cvsHeight/2 || MyY >= currentMap.mapHeight - cvsHeight/2 ) {
					if( this.moveQueue.length > 0 ) {
						if( this.moveQueue[0] == "up" ) {
							this.stepY = -this.stepPart;
						} else if( this.moveQueue[0] == "down" ) {
							this.stepY = this.stepPart;
						}
					}
				}
		
				if( this.moveQueue.length > 0 ) {
					if( this.moveQueue[0] == "right" ) {
						if( MyX+this.stepX >= currentMap.mapWidth - cvsWidth/2 ) {
							this.offsetX = cvsWidth/2 + ( currentMap.mapWidth - MyX-this.stepX ) * -1;
						}
					} else {
						if( MyX-this.stepX > currentMap.mapWidth - cvsWidth/2 ) {
							this.offsetX = cvsWidth/2 + ( currentMap.mapWidth - MyX-this.stepX ) * -1;
						}
					}
				} else {
					if( MyX-this.stepX > currentMap.mapWidth - cvsWidth/2 ) {
						this.offsetX = cvsWidth/2 + ( currentMap.mapWidth - MyX-this.stepX ) * -1;
					}
				}
		
				if( this.moveQueue.length > 0 ) {
					if(  this.moveQueue[0] == "left" ) {
						if( MyX+this.stepX <= cvsWidth/2 ) {
							this.offsetX = (cvsWidth/2-MyX-this.stepX)*-1;
						}
					} else {
						if( MyX-this.stepX < cvsWidth/2 ) {
							this.offsetX = (cvsWidth/2-MyX-this.stepX)*-1;
						}
					}
				} else {
					if( MyX-this.stepX < cvsWidth/2 ) {
						this.offsetX = (cvsWidth/2-MyX-this.stepX)*-1;
					}
				}
	
				if( MyY+this.stepY > currentMap.mapHeight - cvsHeight/2 ) {
					this.offsetY = cvsHeight/2 + (currentMap.mapHeight - MyY-this.stepY ) * -1;
				}
				if( MyY+this.stepY < cvsHeight/2 ) {
					this.offsetY = (cvsHeight/2-MyY-this.stepY)*-1;
				}
		
				var half = (cvsWidth - currentMap.mapWidth);
				if( half < 0 )
					half = 0;
				this.X = half+cvsWidth/2 + this.offsetX+13;
								this.ducnghia = half+cvsWidth + this.offsetX+13;

				this.Y = cvsHeight/2 + this.offsetY - ySink - Math.floor(this.jumpYAdd);
	
			}
	
			this.updateTextureCoords();
		}
	
		this.updateTextureCoords = function()    // Define Method
		{
	
			var startX = 0;
			var startY = 0;
	
			if( this.direction == 0 ) {

				switch(this.stepAnimation) {
					case 0 :
						startX = 0;
						startY = 0;
					break;
					case 1 :
						startX = 1;
						startY = 0;
					break;
					case 2 :
						startX = 2;
						startY = 0;
					break;
				}
			} else if( this.direction == 1 ) {
				switch(this.stepAnimation) {
					case 0 :
						startX = 0;
						startY = 1;
					break;
					case 1 :
						startX = 1;
						startY = 1;
					break;
					case 2 :
						startX = 2;
						startY = 1;
					break;
				}
			} else if( this.direction == 2 ) {
				switch(this.stepAnimation) {
					case 0 :
						startX = 0;
						startY = 2;
					break;
					case 1 :
						startX = 1;
						startY = 2;
					break;
					case 2 :
						startX = 2;
						startY = 2;
					break;
				}
			} else {
				switch(this.stepAnimation) {
					case 0 :
						startX = 0;
						startY = 3;
					break;
					case 1 :
						startX = 1;
						startY = 3;
					break;
					case 2 :
						startX = 2;
						startY = 3;
					break;
				}
			}
			
			this.drawStartX = startX*32;
			this.drawStartY = startY*32;
		}


        return this;
	}
    
	
	
// ################################################
// ### MAP CLASS ###########################
// ################################################


function Region(x1,y1,x2,y2,vx,vy,vw,vh) {
	this.X1 = x1;
	this.Y1 = y1;
	this.X2 = x2;
	this.Y2 = y2;
	this.VX = vx;
	this.VY = vy;
	this.VW = vw;
	this.VH = vh;
	
	return this;
}

// ################################################
// ### GAME MAP CLASS ############################# 
// ################################################

	function gameMap()
	{
		this.mapCollisionData = null;
		
		this.mapWidth = 0;
		this.mapHeight = 0;
		
		this.mapMusic = '';
		
		this.tileSize = 16;
		
		this.grassPatches = new Array();
		this.events = new Array();
		
		this.loadEvents = function(mapEvents)    // Define Method
		{
			events = new Array();
			
			var npcs = firstChildNodeNamed("npcs", mapEvents); 
			for(var k=0;k<npcs.childNodes.length;k++) {
				var npc = npcs.childNodes[k];
				
				events.push(new gameEvent(npc));
			}
			
			
			eggs = [];
			var eggsNode = firstChildNodeNamed("eggs", mapEvents); 
			for(var k=0;k<eggsNode.childNodes.length;k++) {
				var egg = eggsNode.childNodes[k];
				eggs.push(new GameEgg(egg));
			}
			
			inventory = [];
			var inv = firstChildNodeNamed("inventory", mapEvents); 
			for(var k=0;k<inv.childNodes.length;k++) {
				var item = inv.childNodes[k];
				
				inventory.push(new GameItem(item));
			}
			
			
			if( tagAlong != "" ) {
				follower = new gameEvent();
				events.push(follower);
				
				follower.id = -1;
				follower.name = tagAlongName;

				follower.mapPosition.X = userEvent.mapPosition.X;
				follower.mapPosition.Y = userEvent.mapPosition.Y+3;
				follower.type = "Action Button";
				follower.spriteName = tagAlong + ".png";
				follower.direction = userEvent.direction;
				follower.moveType = "Follow User";
				follower.bIsUser = false;
				follower.bEventEnabled = true;
        		follower.eventData.push(new ScriptLine( 1, "MOVE EVENT" , "-1^move to user^1"));
        	
			}
			
		}
		
		this.getEvent = function(id) 
		{
			for(var k=0;k<events.length;k++) {
				if( events[k].id == id ) {
					return events[k];
				}
			}
			return null;
		}
		
		this.evaluateEvents = function()    // Define Method
		{
			for(var k=0;k<events.length;k++) {
				events[k].evaluate();
			}
			for(var k=0;k<mmoUsers.length;k++) {
				mmoUsers[k].evaluate();
			}
		}
		
		this.drawEvents = function(ctx,positionToDraw)    // Define Method
		{
			for(var k=0;k<events.length;k++) {
				if( positionToDraw == "above" ) {
					if( events[k].mapPosition.Y > userEvent.mapPosition.Y+2 ) {
						events[k].drawImage(ctx);
						events[k].drawImage2(ctx);
					}
				} else {
					if( events[k].mapPosition.Y <= userEvent.mapPosition.Y+2 ) {
						events[k].drawImage(ctx);
				         events[k].drawImage2(ctx);

					}
				}
			}
			for(var k=0;k<mmoUsers.length;k++) {
				if( positionToDraw == "above"  ) {
					if( mmoUsers[k].y > userEvent.mapPosition.Y ) {
						mmoUsers[k].drawImage(ctx);
					}
				} else {
					if( mmoUsers[k].y <= userEvent.mapPosition.Y ) {
						mmoUsers[k].drawImage(ctx);
					}
				}
			}
		}
		
		this.drawNames = function(ctx)    // Define Method
		{
			for(var k=0;k<mmoUsers.length;k++) {
				mmoUsers[k].drawNames(ctx);
			}
			//thongtin
			
			if(offhieuung !=0 && timeset <=50) {
			    timeset++;
			  	ctx.font = "bold 13px sans-serif";
				ctx.textAlign = "center";
				if(setwin) {
			drawShadowText(ctx,""+setwin+"",  userEvent.X+12, userEvent.Y-25-timeset,"#B40404"); 
				}
				if(setvatpham) {
			drawShadowText(ctx,""+setvatpham+"",  userEvent.X+12, userEvent.Y-10-timeset,"#F5A9A9"); 
				}
				if(textset) {
			drawShadowText(ctx,""+textset+"",  userEvent.X+12, userEvent.Y+5-timeset,"#086A87"); 
				}
			if(setexp >0) {
			drawShadowText(ctx,"+"+setexp+" Xp",  userEvent.X+12, userEvent.Y+20-timeset,"#00FFFF");  
			}
if(setxu>0) {
				drawShadowText(ctx,"+"+setxu+" Xu",  userEvent.X+12, userEvent.Y+35-timeset,"#01DF01");  
}
				if(timeset>50) {
				    offhieuung = 0;
				    timeset =0;
				    setxu=0
				    setexp =0;
				}
			}
			
			if( userEvent.msg != "" ) {
				ctx.font = "bold 13px sans-serif";
				ctx.textAlign = "center";
				drawShadowText(ctx,userEvent.msg,  userEvent.X+12, userEvent.Y-1,"#FFFFFF");
			} else {
				ctx.font = "bold 11px sans-serif";
				ctx.textAlign = "center";
				drawShadowText(ctx,userName,  userEvent.X+12, userEvent.Y-1,"#12D055");
			}
			if(rongthan==1) {
			ctx.drawImage(resourceByKey('rongthan'),userEvent.X-70, userEvent.Y-230);
			}
			
			if(camxuc>=0 && timecamxuc <=150) {
			if(datacamxuc<=10) {
			    var stepcx = 32;  
			    datacamxuc++;
			}
			else
			if(datacamxuc>=11 && datacamxuc <=20) {
			   			    var stepcx =0; datacamxuc++; 
 
			}
			else {
			    var stepcx =0; datacamxuc=0; 
			}
			
	ctx.drawImage(resourceByKey("camxuc"), 32*camxuc+stepcx, 0, 32, 32,  userEvent.X-5, userEvent.Y-40, 32, 32 );
		timecamxuc++;
		if(timecamxuc >=150) {
		    timecamxuc =0;
		    camxuc = -1;
		}
			}
		}
		
		
		this.load = function(mapData)    // Define Method
		{
		
			this.tileSize = mapData.getAttribute("tilewidth");
			this.mapWidth = mapData.getAttribute("width") * this.tileSize;
			this.mapHeight = mapData.getAttribute("height") * this.tileSize;
			
			
			
			var tileCount = (this.mapWidth / this.tileSize) * (this.mapHeight / this.tileSize);
			this.mapCollisionData = new Array(tileCount);
			
			for(var i=0;i<mapData.childNodes.length;i++) {
				var node = mapData.childNodes[i];
				
				if( node.nodeName == "layer") {
					if( node.getAttribute("name") == "Collision" ) {
						var dataNode = firstChildNodeNamed("data",node);
						var data = getDataOfImmediateChild(dataNode);
						
						data = data.replace(/\r\n/i, '').trim();
						rawMapData = stringToBytes(base64_decode(data));
						
						//for (var k = 0; k < tileCount; k++)
						//	mapCollisionData[k] = getIntAt(rawData,k*4);
						
					} else
					if( node.getAttribute("name") == "ducnghia" ) {
						var dataNode = firstChildNodeNamed("data",node);
						var data = getDataOfImmediateChild(dataNode);
						
						data = data.replace(/\r\n/i, '').trim();
						rawMapData = stringToBytes(base64_decode(data));
						
						//for (var k = 0; k < tileCount; k++)
						//	mapCollisionData[k] = getIntAt(rawData,k*4);
						
					}
				} else if( node.nodeName == "objectgroup") {
					if( node.getAttribute("name").toLowerCase() == "grass" ) {
						this.grassPatches = new Array();
						
						for (var k = 0; k < node.childNodes.length; k++) {
							var object = node.childNodes[k];
							
							if( object.nodeName != "#text" ) {
								var x1 = parseInt(object.getAttribute("x"))/this.tileSize;
								var y1 = parseInt(object.getAttribute("y"))/this.tileSize;
								
								var width = parseInt(object.getAttribute("width"))/this.tileSize;
								var height = parseInt(object.getAttribute("height"))/this.tileSize;
								
								var x2 = x1 + (width+1);
								var y2 = y1 + (height+1);
                               var vx = parseInt(object.getAttribute("x"));
                               var vy =  parseInt(object.getAttribute("y"));
                               var vw =  parseInt(object.getAttribute("width"));
                               var vh =  parseInt(object.getAttribute("height"));

								this.grassPatches.push(new Region(x1,y1,x2,y2,vx,vy,vw,vh));
							}
							
						}
					}
				}
				
			}
		}
		
		
        this.getTile = function( x,  y)
        {
        	var tilesWide = mapWidth / tileSize;
        	var pos = 0;
            x++;
            y++;
//dichuyen
        	if( y * tilesWide + x >= 0 && y * tilesWide + x < mapCollisionData.length ) {
        		if( rawMapData ) {
        			pos = (y * tilesWide + x)*4;
        		//	console.log(rawMapData[pos]);
        			if(rawMapData[pos] <= 0 && rawMapData[pos+1] <= 0  && rawMapData[pos+2] <= 0  && rawMapData[pos+3] <= 0   ) {
        				return 0;
        			}
        			return 1;
        		}
        		
            	//return mapCollisionData[y * tilesWide + x];
            } 
            return -1;
        }
		
		
		this.tileIsWalkable = function(position)    // Define Method
		{
			if( position.X < -1 )
				return false;
			if( position.Y < -1 )
				return false;
			if( position.X > this.mapWidth/16 )
				return false;
			if( position.Y > this.mapHeight/16 )
				return false;
	
			if( this.tileIsFreeFromEvents(position) == false ) {
				return false;
			}
	
			if( this.getTile(position.X,position.Y) == 0 ) {
				return true;
			}
				
			return false;
		}
		
		this.tileIsFreeFromEvents = function(position)    // Define Method
		{	
			
			for(var k=0;k<events.length;k++) {
			    if( events[k].spriteName != "" && events[k].spriteName != null && events[k].bHidden == false && events[k].bEventEnabled == true ) {
					if( events[k].mapPosition.X == position.X ) {
						if( events[k].mapPosition.Y == position.Y+2 ) {
							return false;
						}
					}
				}
			}
			
			
			//TODO: Complete Event Collision Detection
			return true;
		}
		
		return this;
	}

function base64_decode (data) {
    // Decodes string using MIME base64 algorithm  

    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        dec = "",
        tmp_arr = [];
 
    if (!data) {
        return data;
    }
 
    data += '';
 
    do { // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));
 
        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;
 
        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;
 
        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);
 
    dec = tmp_arr.join('');
    //dec = this.utf8_decode(dec);
 
    return dec;
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function stringToBytes ( str ) {
  var ch, st, re = [];
  for (var i = 0; i < str.length; i++ ) {
    ch = str.charCodeAt(i);  // get char 
    st = [];                 // set up "stack"
    do {
      st.push( ch & 0xFF );  // push byte to stack
      ch = ch >> 8;          // shift value down by 1 byte
    }  
    while ( ch );
    // add stack contents to result
    // done because chars have "wrong" endianness
    re = re.concat( st.reverse() );
  }
  // return an array of bytes
  return re;
}

function getIntAt ( arr, offs ) {
	
	if( arr[offs+0] == 0 && arr[offs+1] == 0 && arr[offs+2] == 0 && arr[offs+3] == 0 ) {
		return 0;
	} 
	return 1;
          
  return (arr[offs+0] << 24) +
         (arr[offs+1] << 16) +
         (arr[offs+2] << 8) +
          arr[offs+3];
}


// ################################################
// ### BATTLE CLASS ###########################
// ################################################

//Battle Variables
var bInBattle = false;
var battleStage = 0;
var battleTaskQueue = new Array();

var teamMonsters = new Array();
var opponentMonsters = new Array();

var monSkills = new Array();
var battleItems = new Array();

var doingCaptcha = false;

var captchaImages = new Array();
var captchaKeys = new Array();

var curMon = null;
var curOpp = null;
var nextMon = null;
var nextOpp = null;

var battleScript = new Array();
var battleSelectedMenu = 0;
var battleItemSelectedMenu = 0;

var battleSwappedMonsters = false;

var battleTick1 = 0;
var battleTick2 = 0;
var battleTick3 = 0;
var battleLoading = false;
var loadExplore = false;

var drawMons = true;
var drawMyHp = true;
var drawOpHp = true;

var bWildBattle = false;

function addToCaptcha(letter) {
	if( doingCaptcha ) {
		if( captchaKeypress[parseInt(letter)-1]== false ) {
			captchaKeys.push(letter);
			if( captchaKeys.length == 3 ) {
				$str = captchaKeys[0] + captchaKeys[1] + captchaKeys[2];
				loadBattle("captcha=" + $str);
			}
			captchaKeypress[parseInt(letter)-1] = true;
		}
	}
}


function MonsterSkill(id,name) {
	this.id = id;
	this.name = name;
}

function BattleItem(id,name,file,qty) {
	this.id = id;
	this.name = name;
	this.file = file;
	this.qty = qty;
}

function BattleMonsterLineup(id,name,level,special,specialName,gender,hpleft,hp,image,type1,type2,reborn) {
	
	this.id = id;
	this.name = name;
	this.level = level;
	this.special = special;
	this.specialName = specialName;
	this.gender = gender;
	this.hpleft = parseInt(hpleft);
	this.hp = parseInt(hp);
	this.image = image;
	this.type1 = type1;
	this.type2 = type2;
	this.reborn = reborn;
	
	return this;
}





function showMonsterAtCoord() {
if(mapID==15) {
    vuotai();
} else {
	$.nghia({
url : code(),
type : 'POST',
data : {a:'pk' , map : mapID , x : userEvent.mapPosition.X  ,y : userEvent.mapPosition.Y},
ducnghia : function(result){
	    var res = $.parseJSON(result);
	    if (res.name != "undefined") {
				      
			
				showMonsterAtCoordCallback(res.id,res.name,res.level,res.info);
	} else {
	    showMonsterAtCoordCallback();
}
}
});
	
	
}
}

function showMonsterAtCoordCallback(id,name,lv,info) {
    if(id >0) {
$("#ducnghia_pkm").show();

				$("#ducnghia_pkm").html("<center><img src='/images/pokemon/"+id+".gif'><br> "+name+" Lv."+lv+" "+info+" <b onclick='info("+id+")' class='viptxt'>[?]</b><br> <button onclick='ducnghia_att_pk()'>Attack</button>  <button onclick='chaytron()'>X</button></center>");
} else {
    $("#ducnghia_pkm").hide();

}

}

function chaytron() {
        $("#ducnghia_pkm").hide();

}




function battleMonsterAtCoord() {
//	battleScript = new Array();
//	playSFX("MonAppear");
	showMonsterAtCoord() ;
	return;
	
	//bInBattle = true; - this is set in the above script funciton
}

function battleWildSelected() {
	battleSelectedMenu = 2;
	playSFX("battle");
	playMusic("battle1");
	if( prevPlayingSong ) {
		try
		{
			prevPlayingSong.currentTime = 0;
		}
		catch(err)
		{
		}
	}
	
	battleLoading = false;
	bWildBattle = true;
	bInBattle = true;
	
	wipeWildMonsterBox();
}

function battleWithTrainer() {
	curOpp = null;
	scriptAddLine(battlescreen,"TRAINER");
	//bInBattle = true; - this is set in the above script funciton
	battleSelectedMenu = 2;
	playSFX("battle");
	playMusic("battle1");
	
	curOpp = null;
	nextOpp = null;
	curMon = null;
	nextMon = null;
	
	curMonImage.src = 'images/blank.png';
	curOppImage.src = 'images/blank.png';
	
	if( prevPlayingSong )
		prevPlayingSong.currentTime = 0;
	bWildBattle = false;
	wipeWildMonsterBox();
}

function wipeWildMonsterBox() {
	bWildBattleIsReady = false;
	var form = document.getElementById('mws-explore-encounter');
	if( form ) {
		form.innerHTML = "";
	}
	
}

function battleScriptEndLine() {

	battleScript.splice(0, 1);
	battleScriptStartLine();
	
	drawMons = true;
	drawOpHp = true;
	drawMyHp = true;
	
	
}

function battleScriptStartLine() {
	battleTick1 = 0;
	battleTick2 = 0;
	battleTick3 = 0;
	
	if( !bInBattle ) 
		return;
	
	var centerX = cvsWidth/2;
	var centerY = cvsHeight/2;
	
	if( battleScript.length > 0 ) {
		var data = battleScript[0].split("|");
		//battleSelectedMenu = 2;
		
		if( data[0] == "MSG" ) {
			drawMons = true;
			drawOpHp = true;
			drawMyHp = true;
		
				repositionMonsters();
				curMonImage.style.display = 'block';
				curOppImage.style.display = 'block';
		} else if( data[0] == "ATTACK" ) {
			drawMons = true;
			drawOpHp = true;
			drawMyHp = true;
			playSFX("hit");
			
		} else if( data[0] == "MUTATE" ) {
			drawMons = false;
			drawOpHp = false;
			drawMyHp = false;
			var args = data[1].split("-");
			
			//load required images: Monster Image
			var img = resourceByKey(args[1]);
			if( img == null )
				screenResources.push(new ResourceImage(args[1],args[1]));
				
			//load required images: Arrow Image
			img = resourceByKey("resultset_next.png");
			if( img == null )
				screenResources.push(new ResourceImage("css/icons/32/resultset_next.png","resultset_next.png"));
			
		} else if( data[0] == "HPCHANGE" ) {
			battleTick3 = parseInt(data[2]) / 10; 
		} else if( data[0] == "DEFEAT" ) {
			
			if( (parseInt(data[1]) < 6 && !battlePlayerAwayTeam) || (parseInt(data[1]) >= 6 && battlePlayerAwayTeam)  ) {
				battleSelectedMenu = 7;
				curMon.hpleft = 0;
				curMonImage.src = 'images/blank.png';
			} else {
				curOpp.hpleft = 0;
				curOpp = nextOpp;
				curOppImage.src = 'images/blank.png';
			}
		} else if( data[0] == "SWAP" ) {
			var monImage = null;
			
			if( (parseInt(data[1]) < 6 && !battlePlayerAwayTeam) || (parseInt(data[1]) >= 6 && battlePlayerAwayTeam)  ) {
				if( nextMon != null ) {
					curMon = nextMon;
				}
				//sharks
				if (data[2] == null)
					data[2] = 0;
				//end
				
				if( curMon != null ) {
					curMon.hpleft = parseInt(data[2]);
					curMonImage.src = curMon.image;
					curMonImage.style.display = 'block';
				}
				repositionMonsters();
				
				
			} else if( (parseInt(data[1]) < 6 && battlePlayerAwayTeam) || (parseInt(data[1]) >= 6 && !battlePlayerAwayTeam)  ) {
				if( nextOpp != null ) {
					curOpp = nextOpp;
				}
				curOpp.hpleft = parseInt(data[2]);
				
				curOppImage.src = curOpp.image;
				curOppImage.style.display = 'block'; 
				repositionMonsters();
				
			}
			
			
			battleScriptEndLine(); 
		} else if( data[0] == "SFX" ) {
			playSFX(data[1]);
			battleScriptEndLine();
		} else if( data[0] == "LEVELUP" ) {
			playSFX("levelup");
			battleScriptEndLine(); 
		} else if( data[0] == "CLIENT SCRIPT" ) {
			scriptAddLine(data[1],data[2]);
			battleScriptEndLine(); 
		} else if( data[0] == "SCRIPT" ) {
		
			if( data[1] != "" ) {
				scriptAddLine("server side",data[1]);
			}
			battleScriptEndLine(); 
			battleEnd();
		}
	} else { //
		if( !battleLoading ) {
			if( parseInt(battleStage) == 3 || parseInt(battleStage) == 4 ) {
				battleEnd();
				if( parseInt(battleStage) == 4 ) {
					
					userFaint();
				} else {
					//if( !bWildBattle ) {
						playMusicOnce("victory");
					//}
				}
			} else if( parseInt(battleStage) == 5 || parseInt(battleStage) == 6 ) {
				battleEnd();
				if( battlePlayerAwayTeam ) {
					if( parseInt(battleStage) == 6 ) {
						playMusicOnce("victory");
					} else {
						userFaint();
					}
				} else {
					if( parseInt(battleStage) == 5 ) {
						playMusicOnce("victory");
					} else {
						userFaint();
					}
				}
			}
		}
	}
}

function battleEnd() {

	bInBattle=false;
	battleSelectedMenu = 0;
	battleScript = new Array();
	
	teamMonsters = new Array();
	opponentMonsters = new Array();

	curMon = null;
	curOpp = null;
	
	curOppImage.style.display = 'none';
	curMonImage.style.display = 'none';
	
	playMusic(currentMap.mapMusic);
	
	
}

function battleScriptDraw() {
	var centerX = cvsWidth/2;
	var centerY = cvsHeight/2;
	
	if( battleScript.length > 0 ) {
		var data = battleScript[0].split("|");
		
		if( data[0] == "MSG" ) {
			
			battleTick1++;
			if( battleTick1 > 1 ) {
				battleTick2++;
				battleTick1=0;
			}
				
			if( (keyState.btn1 || keyState.btn2) && battleTick2 > data[1].length ) {
				battleScriptEndLine();
				keyState.btn1 = false;
				keyState.btn2 = false;
				playSFX("beep");
			} else if( keyState.btn1 || keyState.btn2  ) {
				battleTick2 = data[1].length;
				keyState.btn1 = false;
				keyState.btn2 = false;
				playSFX("beep");
			}
			
			//ctx.textAlign = "left";
			//ctx.font = "bold 9px sans-serif";
			//drawShadowText(ctx,data[1].substr(0,battleTick2), centerX-230,centerY+103);
	
			ctx.textAlign = "left";
			ctx.font = "bold 12px sans-serif";
			
			var line1 = data[1];
			var line2 = "";
			
			if( line1.length > 32 ) {
			    var lastSpace = line1.lastIndexOf(" ", 32);
			    line2 = line1.substr(lastSpace+1,line1.length-lastSpace-1);
			    line1 = line1.substr(0,lastSpace);
			}
			
			if( battleTick2 <= line1.length ) {
				drawShadowText(ctx,line1.substr(0,battleTick2), centerX-234,centerY+100);
			} else {
				drawShadowText(ctx,line1, centerX-234,centerY+100);
				drawShadowText(ctx,line2.substr(0,battleTick2-line2.length), centerX-234,centerY+ 116);
			}
		} else if( data[0] == "MUTATE" ) {
		
			drawMons = false;
			drawOpHp = false;
			drawMyHp = false;
			var args = data[1].split("-");
			
			
			ctx.textAlign = "left";
			ctx.font = "bold 12px sans-serif";
			
			drawShadowText(ctx,"Let the Pokemon Evolve?", centerX-234,centerY+100);
			drawShadowText(ctx,"Press 'X' to confirm, 'Z' to cancel.", centerX-234,centerY+ 116);
			
			
			ctx.textAlign = "center";
			ctx.font = "bold 14px sans-serif";
			
			
			//Draw Monster
			var mon = resourceByKey(curMon.image);
			ctx.drawImage(mon, centerX-80-mon.width/2,centerY-mon.height/2); 
			drawShadowText(ctx,curMon.name, centerX-80,centerY+60);
			
			//Draw Monster Evolution
			mon = resourceByKey(args[1]);
			ctx.drawImage(mon, centerX+80-mon.width/2,centerY-mon.height/2); 
			drawShadowText(ctx,"???", centerX+80,centerY+60);
			
			
			//Draw Arrow
			mon = resourceByKey("resultset_next.png");
			ctx.drawImage(mon, centerX-mon.width/2-mon.width,centerY-mon.height/2); 
			ctx.drawImage(mon, centerX-mon.width/2,centerY-mon.height/2); 
			ctx.drawImage(mon, centerX-mon.width/2+mon.width,centerY-mon.height/2); 
			
			if( keyState.btn1 ) {
			loadBattle("mutate=true&mutatetarg="+data[2]);
				//loadBattle("mutate=true");
				keyState.btn1 = false;
				battleScriptEndLine();
			} else if( keyState.btn2 ) {
				keyState.btn2 = false;
				battleScriptEndLine();
			}
			
			
			
			//
			//curMon
	
		} else if( data[0] == "ATTACK" ) {
			
			var img = resourceByKey("ani-"+data[4]);
			battleTick1++;
			
			if( img == null ) {
				battleScriptEndLine();
			} else {
				
				if( (parseInt(data[2]) < 6 && !battlePlayerAwayTeam) ||(parseInt(data[2]) >= 6 && battlePlayerAwayTeam)  ) {
					ctx.drawImage(img, battleTick2 ,0,80,80,centerX-120-80/2,centerY-img.height/2+40,80,80); 
				} else {
					ctx.drawImage(img, battleTick2 ,0,80,80,centerX+120-80/2,centerY-img.height/2-40 ,80,80); 
				}
				
				if( battleTick2 > img.width ) {
					battleScriptEndLine();
				}
			}
				
            battleTick2=battleTick2+80;
		} else if( data[0] == "DEFEAT" ) {
			battleScriptEndLine();
		} else if( data[0] == "HPCHANGE" ) {
			battleTick1++;
			if( battleTick1 < 10 ) {
				if( (parseInt(data[1]) < 6 && !battlePlayerAwayTeam) ||(parseInt(data[1]) >= 6 && battlePlayerAwayTeam)  ) {
					curMon.hpleft = curMon.hpleft - battleTick3;
				} else {
					curOpp.hpleft = curOpp.hpleft - battleTick3;
				}
			} else {
				if( (parseInt(data[1]) < 6 && !battlePlayerAwayTeam) ||(parseInt(data[1]) >= 6 && battlePlayerAwayTeam)  ) {
					curMon.hpleft = parseInt(data[3]);
				} else {
					curOpp.hpleft = parseInt(data[3]);
				}
				battleScriptEndLine();
			}
		} else if( data[0] == "BATTLEEND" ) {
			battleEnd();
		}
	}
}





function getBattleMonByID(ary, id) {
	for(var k=0;k<ary.length;k++) {
		if( ary[k].id == id ) {
			return ary[k];
		}
	}
	return null;
}

var lastRequest = null;

function loadBattle(args) {
	

}

var curMonImage = null;
var curOppImage = null;

var battleRequestCounter = 0;
var battlePVPWaitTimer = 0;

var battlePVP = 0;
var battlePlayerAwayTeam = false;
var battleRoundTacker = 0;
var battlePVPWaiting = false;

function loadBattleScriptFrom(roundNode) {
	var bInitScript = battleScript.length == 0;
	for(var i=0;i<roundNode.childNodes.length;i++) {
		battleScript.push(nodeValue(roundNode.childNodes[i]).trim());
	}
	
	//if there wasn't any script before but there is now we better kick it off.
	if( battleScript.length > 0 && bInitScript )
		battleScriptStartLine();
}

function itemFromNode(node) {
	var id = nodeValue(firstChildNodeNamed("id", node));
	var name = nodeValue(firstChildNodeNamed("name", node));
	var file = nodeValue(firstChildNodeNamed("file", node));
	var qty = nodeValue(firstChildNodeNamed("qty", node));
	return new BattleItem(id,name,file,qty);
}


function skillFromNode(node) {
	var id = nodeValue(firstChildNodeNamed("id", node));
	var name = nodeValue(firstChildNodeNamed("name", node));
	return new MonsterSkill(id,name);
}

function monFromNode(opMon,hpTemplate) {

	var f1 = nodeValue(firstChildNodeNamed("f1", opMon));
	var f2 = nodeValue(firstChildNodeNamed("f2", opMon));
	var f3 = nodeValue(firstChildNodeNamed("f3", opMon));
	var f4a = nodeValue(firstChildNodeNamed("f4a", opMon));
	var f4b = nodeValue(firstChildNodeNamed("f4b", opMon));
	if( f4b == null )
		f4b = "";
	var f5 = nodeValue(firstChildNodeNamed("f5", opMon));
	
	var f7a = nodeValue(firstChildNodeNamed("f7a", opMon));
	var f7b = nodeValue(firstChildNodeNamed("f7b", opMon));
	if( hpTemplate != null )
		f7a = hpTemplate.hpleft;
	
	var f8 = nodeValue(firstChildNodeNamed("f8", opMon));
	var f9a = nodeValue(firstChildNodeNamed("f9a", opMon));
	var f9b = nodeValue(firstChildNodeNamed("f9b", opMon));
	var f13 = nodeValue(firstChildNodeNamed("f13", opMon));

	return new BattleMonsterLineup(f1,f2,f3,f4a,f4b,f5,f7a,f7b,f8,f9a,f9b,f13);
}


function loadLineupArrays(resultsNode) {
	teamMonsters = new Array();
	
	//check that the images are/have loading/loaded.
	var trainer = firstChildNodeNamed("trainer", resultsNode); 
	var opponent = firstChildNodeNamed("opponent", resultsNode); 
	
	
	
	var myLineup = firstChildNodeNamed("lineup", trainer); 
	
	for(var i=0;i<myLineup.childNodes.length;i++) {
		var mon = myLineup.childNodes[i];
		var f8 = nodeValue(firstChildNodeNamed("f8", mon));
		
		
		//only update the first time.
		if( i == teamMonsters.length ) {
			teamMonsters.push(monFromNode(mon));
		}
		
	}
	
	var opponent = firstChildNodeNamed("opponent", resultsNode); 
	if( opponent ) {
		var oppLineup = firstChildNodeNamed("lineup", opponent); 
		
		//Reset the opponents array to refresh all data there.
		opponentMonsters = new Array();
		
		for(var i=0;i<oppLineup.childNodes.length;i++) {
			var mon = oppLineup.childNodes[i];
			var f8 = nodeValue(firstChildNodeNamed("f8", mon));
			
	
			opponentMonsters.push(monFromNode(mon));
			
		}
	}
	
	if( opponent != null ) {
		//swap the teams if your the opponent in pvp
		var opponentName = nodeValue(firstChildNodeNamed("user", opponent)); 
		if( userName == opponentName ) {
			var temp = opponentMonsters;
			opponentMonsters = teamMonsters;
			teamMonsters = temp;
		}
	}
	
}

function userFaint() {
	window.location = "/explore.php";
}


// ################################################
// ### SCRIPTING CLASS ###########################
// ################################################

//Script Variables
var activeScript = new Array();

//Animation timers
var scriptTick1 = 0;
var scriptTick2 = 0;
var scriptTick3 = 0;
var scriptTick4 = 0;

var drawnObjects = new Array();


var menuSelection = 0;
var menuOptions = new Array();
var menuDepth = new Array();

function MenuItem(text, style, icon) {
	this.text = text;
	this.style = style;
	this.icon = icon;
	this.x = 0;
	this.y = 0;
	this.width = 0;
	this.height = 0;
	return this;
}

//processes the start of each script line.
function scriptProgress() {
	//reset objects for the next function
	drawnObjects = new Array();
	scriptTick1 = 0;
	scriptTick2 = 0;
	scriptTick3 = 0;
	scriptTick4 = 0;
	wipeWildMonsterBox();
	menuOptions = new Array();
	
	
	while( activeScript[0].func == null )
		activeScript.splice(0,1);
	
	if( activeScript.length > 0 ) {
		var scriptFunc = activeScript[0].func.toLowerCase();
		var scriptData = activeScript[0].args; 
		if( scriptFunc == "server side" ) {
			loadServerSide("a=map&token=" + scriptData.trim());
		} else if( scriptFunc == "display message" ) {
		
		} else if( scriptFunc == "sync all" ) {
			//do nothing till all events finish
		
		} else if( scriptFunc == "playonce" ) {
			playMusicOnce(scriptData.trim());
			scriptLineComplete();
		} else if( scriptFunc == "sfx" ) {
			playSFX(scriptData.trim());
			scriptLineComplete();
			
		} else if( scriptFunc == "main menu inventory" ) {
			menuSelection = 0;
			
		} else if( scriptFunc == "main menu" ) {
			menuSelection = 0;
			
			menuDepth = new Array();
			
			//menuOptions.push(new MenuItem("Appearance","basic",""));
			//menuOptions.push(new MenuItem("My Pokemon","basic",""));
			menuOptions.push(new MenuItem("Inventory","basic",""));
			//menuOptions.push(new MenuItem("Options","basic",""));
			menuOptions.push(new MenuItem("Press Z to close","basic",""));
		
			//menuSelection
			
		} else if( scriptFunc == "wipe" ) {
			
			var evnt = currentMap.getEvent(scriptData);
			if( evnt != null ) {
				evnt.eventData = new Array();
			}
			scriptLineComplete();
		} else if( scriptFunc == "pokemon pc" ) {
			window.open('/monsters', '_blank');
		    scriptLineComplete();
		} else if( scriptFunc == "quest start" ) {
			
		} else if( scriptFunc == "quest finish" ) {
			
		} else if( scriptFunc == "money" ) {
			userMoney = parseInt(scriptData);
			scriptLineComplete();
		} else if( scriptFunc == "hide event" ) {
			var evnt = currentMap.getEvent(scriptData);
			
			evnt.bHidden = true;
			
		    scriptLineComplete();
		} else if( scriptFunc == "move event" ) {
			//Add the function to the events queue
			var args = scriptData.split("^");
			var evnt = currentMap.getEvent(args[0]);
			var dir = args[1].toLowerCase();
			var steps = parseInt(args[2]);
			
			if( args[0] == "0" )
			    evnt = userEvent;
			
			if( dir.toLowerCase() == "move to user" ) {
				var xDif = userEvent.mapPosition.X - evnt.mapPosition.X;
				var yDif = userEvent.mapPosition.Y + 2 - evnt.mapPosition.Y;
				steps = 0;
				
				if( xDif != 0 ) {
					if( xDif < 0 ) {
						dir = "left";
						steps = -xDif;
					} else {
						dir = "right";
						steps = xDif;
					}
				}
				if( yDif != 0 ) {
					if( yDif < 0 ) {
						dir = "up";
						steps = -yDif;
					} else {
						dir = "down";
						steps = yDif;
					}
				}
				
				if( steps == 1)
					steps++;
				
				for(var i=0;i<steps-1;i++) {
					evnt.moveQueue.push(dir);
				}
				
			} else {	
			
				if( dir == "forward" ) {
					if( evnt.direction == 0 )
						dir = "up";
					if( evnt.direction == 1 )
						dir = "down";
					if( evnt.direction == 2 )
						dir = "left";
					if( evnt.direction == 3 )
						dir = "right";
				}
				
				for(var i=0;i<steps;i++) {
					evnt.moveQueue.push(dir);
				}
			}
			
		    scriptLineComplete();
		} else if( scriptFunc == "transition" ) {
		
		} else if( scriptFunc == "shop" ) {
			battleItemSelectedMenu = 0;
			var items = scriptData.split("^");
			for(var i=0;i<items.length;i++) {
				var item = items[i].split("|");
				
				screenResources.push(new ResourceImage("images/items/" + item[3],"item." + item[1] ));
			}
		} else if( scriptFunc == "choice" ) {
			scriptTick3 = 0;
			scriptTick4 = 0;
		} else if( scriptFunc == "add item" ) {
			var args = scriptData.split("^");
			screenResources.push(new ResourceImage("images/items/" + args[1],"item." + args[0] ));
			
			playSFX("coinchange");
		} else if( scriptFunc == "warp" ) {
			arrivalDirection = null;
			var args = scriptData.split("^");
			
			userEvent.mapPosition.X = parseInt(args[1]);
			userEvent.mapPosition.Y = parseInt(args[2]);
			
		    scriptLineComplete();
		    if( args[0].toLowerCase() != mapCode.toLowerCase() ) {
		        dulieumap(args[0],args[3]);
		    }
		} else if( scriptFunc == battlescreen ) {
		
		} else if( scriptFunc == "battle" ) {
		//	battleWithTrainer(); ///xóa
		    scriptLineComplete();
		} else if( scriptFunc == "inn animation" ) {
			playMusicOnce("healing");
		} else {
		    scriptLineComplete();
		}
		
	}
}

//updates the current line being executed and triggers the end of the script function
function scriptUpdate() {
	if( activeScript.length > 0 ) {
		var scriptFunc = activeScript[0].func.toLowerCase();
		var scriptData = activeScript[0].id;
		
		if( scriptFunc == "display message" ) {
					scriptLineComplete();
		//	giaotiep(scriptData);
			
			////ajax by ducnghia
	 $.nghia({
url : code(),
type : 'POST',
data : {scriptData : scriptData , a :'chucnang',giaotiep:1},
ducnghia : function(result){
var xx = $.parseJSON(result);
giaotiep(xx.map);
npc(scriptData,xx.map);
console.log(scriptData);
					$("#npc_menu").html(xx.menu);


}
});		
			
	/////ajax////
	
	
	
	///done
			
			
			
		} else if( scriptFunc == "main menu inventory" ) {
		
			if( keyState.btn2 ) {
				if( menuDepth.length == 0 ) {
					keyState.btn2 = false;
					scriptLineComplete();
					scriptAddLine("main menu","");
					scriptProgress();
				}
			} else if( keyState.btn1 ) {
				var selectedItem = inventory[menuSelection];
				if( selected.name == "Inventory" ) {
					//use item...
					scriptLineComplete();
				}
			} else if( keyState.up ) {
				menuSelection--;
				if( menuSelection < 0 )
					menuSelection = inventory.length-1;
				keyState.up = false;
			} else if( keyState.down ) {
				menuSelection++;
				if( menuSelection >= inventory.length )
					menuSelection = 0;
				keyState.down = false;
			} 
		
		} else if( scriptFunc == "main menu" ) {
		
			if( keyState.btn2 ) {
				if( menuDepth.length == 0 ) {
					keyState.btn2 = false;
					scriptLineComplete();
				}
			} else if( keyState.btn1 ) {
				var selected = menuOptions[menuSelection];
				if( selected.text == "Inventory" ) {
					keyState.btn1 = false;
					scriptLineComplete();
					scriptAddLine("main menu inventory","");
					scriptProgress();
				}
			} else if( keyState.up ) {
				menuSelection--;
				if( menuSelection < 0 )
					menuSelection = menuOptions.length-1;
				keyState.up = false;
			} else if( keyState.down ) {
				menuSelection++;
				if( menuSelection >= menuOptions.length )
					menuSelection = 0;
				keyState.down = false;
			} 
		
			
		} else if( scriptFunc == "battle" ) { 
		
		} else if( scriptFunc == "quest start" ) {
			scriptTick1++;
			if( scriptTick1 > 1 ) {
				scriptTick2++;
				scriptTick1=0;
			}
			
			if( (keyState.btn1 || keyState.btn2) && scriptTick2 > 10 ) {
				scriptLineComplete();
				keyState.btn1 = false;
				keyState.btn2 = false;
			}
		} else if( scriptFunc == "quest finish" ) {
			scriptTick1++;
			if( scriptTick1 > 1 ) {
				scriptTick2++;
				scriptTick1=0;
			}
			
			if( (keyState.btn1 || keyState.btn2) && scriptTick2 > 10 ) {
				scriptLineComplete();
				keyState.btn1 = false;
				keyState.btn2 = false;
			}
		} else if( scriptFunc == "shop" ) {
			var items = scriptData.split("^");
			
			if( scriptTick1 == 0 ) {
				if( keyState.up ) {
					battleItemSelectedMenu = battleItemSelectedMenu - 1;
					if( battleItemSelectedMenu < 0 ) 
							battleItemSelectedMenu=0;
					keyState.up = false;
				} else if( keyState.right ) {
					battleItemSelectedMenu = battleItemSelectedMenu + 4;
					if( battleItemSelectedMenu >= items.length ) 
						battleItemSelectedMenu = items.length-1;
					keyState.right = false;
				} else if( keyState.left ) {
					battleItemSelectedMenu = battleItemSelectedMenu - 4;
					if( battleItemSelectedMenu < 0 ) 
						battleItemSelectedMenu=0;
					keyState.left = false;
				} else if( keyState.down ) {
					battleItemSelectedMenu = battleItemSelectedMenu + 1;
					if( battleItemSelectedMenu >= items.length ) 
						battleItemSelectedMenu = items.length-1;
					keyState.down = false;
				} else if( keyState.btn1 ) {
					var itemData = items[battleItemSelectedMenu].split("|");
					loadUtility("action=buy&item=" + itemData[0] + "&npc=" + lastTriggeredEventName);
					keyState.btn1 = false;
					
				} else if( keyState.btn2 ) {
					scriptLineComplete();
					keyState.btn2 = false;
				}
			}
		
			
		} else if( scriptFunc == "add item" ) {
			
			scriptTick1++;
			if( scriptTick1 > 80 ) {
				scriptLineComplete();
			}
			
		} else if( scriptFunc == "sync all" ) {
			
			var bClear = true;
			for(var k=0;k<currentMap.events.length;k++) {
				if( currentMap.events[k].moveQueue.length > 0 ) {
					bClear = false;
				}
			}
			if( userEvent.moveQueue.length > 0 ) {
				bClear = false;
			}
			
			if( bClear ) {
				scriptLineComplete();
			}
			
		} else if( scriptFunc == "move event" ) {
		    
		} else if( scriptFunc == "choice" ) {
			var args = scriptData.split("^");
		    
		    scriptTick1++;
			if( scriptTick1 > 1 ) {
				scriptTick2++;
				scriptTick1=0;
			}
			
			if( (keyState.btn1 || keyState.btn2) && scriptTick2 < args[0].length ) {
				playSFX("beep");
				scriptTick2 = args[0].length;
				keyState.btn1 = false;
				keyState.btn2 = false;
			} else {
				//make choice
				if( keyState.up ) {
					scriptTick3--;
					if( scriptTick3 < 0 ) {
						scriptTick3 = args.length-2;
					}
					keyState.up = false;
				} else if( keyState.down ) {
					scriptTick3++;
					if( scriptTick3 > args.length-2 ) {
						scriptTick3 = 0;
					}
					keyState.down = false;
				} else if( keyState.btn1 && scriptTick4 == 0) {
					loadUtility("action=choice&item=" + (scriptTick3+1) );
					scriptTick4 = 1;
					
					keyState.btn1 = false;
				}
				
				
				
			}
			
			
			
		} else if( scriptFunc == battlescreen ) {
		 	//
			// Animate curtains falling down the screen.
			//
			//
			// Animate curtains falling down the screen.
			//
			if( drawnObjects.length == 0 ) {
				drawnObjects.push("rect:0:0:width:height:rgba(255, 255, 255, 0)");
			}
			
			
			if( scriptTick2 == 0 ) {
				scriptTick1=scriptTick1+24;
				if( scriptTick1 > cvsHeight ) {
					scriptTick2++;
					scriptTick1 = 1;
					drawnObjects[0] = "rect:0:0:width:height:rgba(237,21,21,1)";
				} else {
					drawnObjects[0] = "rect:0:0:width:"+scriptTick1+":rgba(237,21,21,1)";
				}
				
			} else if( scriptTick2 == 1 ) {
				scriptTick1-=0.05;
				if( scriptTick1 <= 0 ) {
					scriptTick1 = 0;
					
					bInBattle = true;
					
					if( scriptData == "WILD" ) {
						loadBattle("x="+userEvent.mapPosition.X+"&y="+userEvent.mapPosition.Y+"&action=encounter");
					} else if( scriptData == "TRAINER" ) {
					///	loadBattle("x="+userEvent.mapPosition.X+"&y="+userEvent.mapPosition.Y+"&action=trainer");
					console.log('trainer');
					} else if( scriptData == "PVP" ) {
						loadBattle("x="+userEvent.mapPosition.X+"&y="+userEvent.mapPosition.Y+"&action=pvp");
					}
					
					scriptLineComplete();
					return;
				}
				drawnObjects[0] = "rect:0:0:width:height:rgba(237,186,21,"+scriptTick1+")";
			}
				
					
		} else if( scriptFunc == "inn animation" ) {
		 	//
			// Animate curtains falling down the screen.
			//
			if( drawnObjects.length == 0 ) {
				drawnObjects.push("rect:0:0:width:height:rgba(255, 255, 255, 0)");
			}
			
			
			if( scriptTick2 == 0 ) {
				scriptTick1=scriptTick1+16;
				if( scriptTick1 > cvsHeight ) {
					scriptTick2++;
					scriptTick1 = 1;
					drawnObjects[0] = "rect:0:0:width:height:rgba(237,186,21,1)";
				} else {
					drawnObjects[0] = "rect:0:0:width:"+scriptTick1+":rgba(237,186,21,1)";
				}
				
			} else if( scriptTick2 == 1 ) {
				scriptTick1-=0.01;
				if( scriptTick1 <= 0 ) {
					scriptTick1 = 0;
					scriptLineComplete();
					return;
				}
				drawnObjects[0] = "rect:0:0:width:height:rgba(237,186,21,"+scriptTick1+")";
			}
			
		}
	}
}

function scriptLineComplete() {
	activeScript.splice(0, 1);
	if( activeScript.length > 0 )
		scriptProgress();
}

function menuOpen() {
	if( activeScript.length == 0 ) {
		scriptAddLine("main menu");
		scriptProgress();
	}
}

//Accepts user input
function scriptKeys() {


}

function testo() {
    datacanvas = 'Ducnghia';
}

var rect={
    ducnghia:{x:100,y:100,w:75,h:40}
    
};


function dra2() {
    		var dataconssole = datacanvas;
var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;
    	if(dataconssole=="camxuc") {
	ctx.drawImage(resourceByKey("camxuc"), 32*0, 0, 32, 32,  0,155, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*2, 0, 32, 32,  32*1,155, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*4, 0, 32, 32,  32*2,155, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*6, 0, 32, 32,  32*3,155, 32, 32 );

	ctx.drawImage(resourceByKey("camxuc"), 32*8, 0, 32, 32,  32*0,190, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*10, 0, 32, 32,  32*1,190, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*12, 0, 32, 32,  32*2,190, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*14, 0, 32, 32,  32*3,190, 32, 32 );
	
	ctx.drawImage(resourceByKey("camxuc"), 32*16, 0, 32, 32,  32*0,225, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*18, 0, 32, 32,  32*1,225, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*20, 0, 32, 32,  32*2,225, 32, 32 );
	ctx.drawImage(resourceByKey("camxuc"), 32*22, 0, 32, 32,  32*3,225, 32, 32 );	

	   	


	}
}


function scriptDraw() {
	
	if( activeScript.length > 0 ) {
		var scriptFunc = activeScript[0].func.toLowerCase();
		var scriptData = activeScript[0].args;
		var centerX = cvsWidth/2;
		var centerY = cvsHeight/2;

	   if( scriptFunc == "server side" ) {
			

		//	ctx.fillStyle = 'rgba(255, 255, 255, 0.55)';
		//	ctx.fillRect(centerX - 101, centerY +77, 202,32);
		//	ctx.fillStyle = 'rgba(0, 0, 0, 0.75)';
		//	ctx.fillRect(centerX - 100, centerY +78, 200,30);
			
			ctx.textAlign = "center";
			ctx.font = "bold 14px sans-serif";
		ctx.drawImage(resourceByKey("notice"),  centerX - 101, centerY+77, 200, 40 );
					drawShadowText(ctx,"Load game...", centerX,centerY+107);


			
			
		}
	}
	


}

//Adds an action to the queue
function scriptAddLine(command,data) {
	activeScript.push(new ScriptLine(0,command,data));
	if( activeScript.length == 1 ) {
		scriptProgress();
	}

}


//******************************************************
// Quick script functions.
//******************************************************


function loadServerSide(args) {
	
	loadExplore = true; //sets this as true on warp/first load and thus enables wild encounters
	var xmlHttpReq = requestObject();
	self.xmlHttpReq.open("POST", code(), true);
		self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	self.xmlHttpReq.onreadystatechange = loadServerSideCallback;
	self.xmlHttpReq.send(args);
}

function loadServerSideCallback() {
	if (self.xmlHttpReq.readyState == 4) {
		if (self.xmlHttpReq.responseXML) {
			var resultsNode = self.xmlHttpReq.responseXML.childNodes[1];
			if (!resultsNode) {
				resultsNode = self.xmlHttpReq.responseXML.childNodes[0];
			}
			
			if (resultsNode == null) {
				return;
			}
			
			//load the new script functions
			var script = firstChildNodeNamed("script", resultsNode);
        	for(var i=0;i<script.childNodes.length;i++) {
        		line = script.childNodes[i];
        		if( line.nodeName != "#comment" ) {
        			activeScript.push(new ScriptLine( nodeValue(firstChildNodeNamed("line", line)) , nodeValue(firstChildNodeNamed("function", line)) , nodeValue(firstChildNodeNamed("arguments", line)) ));
        		
        		}
        	}
        	
			//end the current sript line which must be a "server side"
			scriptLineComplete();
			
		}
	}
}

var hatchingEgg = false;
var keepAliveRequest = null;
function loadUtility(args) {
	
		scriptTick1 = 1;
		keepAliveRequest = requestUtilityObject();
		keepAliveRequest.open("POST", "/xml/utility.xml.php?rand=" + (Math.random() * 1000000), true);
		keepAliveRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		if( args == "keepAlive=true" ) {
			keepAliveRequest.onreadystatechange = loadUtilityCallbackDummy;
		} else {
			keepAliveRequest.onreadystatechange = loadUtilityCallback;
		}
		keepAliveRequest.send(args);
	
}

function loadUtilityCallbackDummy() {
 
}

function loadUtilityCallback() {
	if (keepAliveRequest.readyState == 4) {
		if (keepAliveRequest.responseXML) {
			var resultsNode = keepAliveRequest.responseXML.childNodes[1];
			if (!resultsNode) {
				resultsNode = keepAliveRequest.responseXML.childNodes[0];
			}
			
			if (resultsNode == null) {
				return;
			}
			
			if( hatchingEgg) {
				var inner = nodeValue(resultsNode);
				if( inner != null ) {
					activeScript.splice(0,0,  new ScriptLine(0,"Display Message",inner) );
					playSFX("levelup");
					scriptProgress();
					eggs.splice(0,1);
				}
				hatchingEgg = false;
			} else {
			
			
				if( activeScript.length > 0 ) {
					var scriptFunc = activeScript[0].func.toLowerCase();
					var scriptData = activeScript[0].args;
					
					if( scriptFunc == "shop" ) {
						var moneyNode = firstChildNodeNamed("money", resultsNode);
						if( moneyNode ) 
							userMoney = parseInt(nodeValue(moneyNode));
							
						var msgNode = firstChildNodeNamed("msg", resultsNode);
						if( msgNode ) {
							activeScript.splice(0,0,  new ScriptLine(0,"Display Message",nodeValue(msgNode)) );
							playSFX("coinchange");
							scriptProgress();
						}
					} else {
						scriptLineComplete();
					}
				}
			}
			
		}
		scriptTick1 = 0;
	}
}

function hideRequest()
{
document.getElementById("mws-explore-requests").innerHTML = "";	
}

function btnShowUsers(btn)
{
	if (btn.value == "On")
	{
		btn.value = "Off";
		bShowUsers = false;
		btn.className = "mws-button red small";

	}
	else
	{
		btn.value = "On";
		bShowUsers = true;
		btn.className = "mws-button green small";

	}
}

function userOnWhichChat(v)
{
	userOnWhichChatTab = v.id;
}



function dongtalk() {
  clearTimeout(dxxx);

     }


function giaotiep(data) {
  					$("#npc_menu").html('');
   
 var check = $('#ducnghia_npc').html();
if(check.length >=1) {
    dongload();
}
	var form = document.getElementById('ducnghia_giaotiep');
		document.getElementById('ducnghia_giaotiep').style.display = "block";
		document.getElementById('ducnghia_menu_giaotiep').style.display = "block";

	//	form.innerHTML =data;
	
	var content = data;
	
var contentLength = content.length;
var char = 0;
(function ducnghai_Dz_takl() { 
  dxxx = setTimeout(function() {
        char++;
        var type = content.substring(0, char);
  $('#ducnghia_npc').html(type + '');
  //recursive
        ducnghai_Dz_takl();
    }, 20);
}());
}
function c_giaotiep() {
    		document.getElementById('ducnghia_giaotiep').style.display = "none";
		document.getElementById('ducnghia_menu_giaotiep').style.display = "none";
 var check = $('#ducnghia_npc').html();
if(check.length >=1) {
    dongload();
}
}

function dongload() {
  clearTimeout(dxxx);

     }
     
     
     function datamap(){
         $.nghia({
url : '/xml/tool.php?xem',
type : 'POST',
data : {mapID : mapID},

ducnghia : function(result){
canvas('Dữ liệu trò chơi',result);
}
});
     }   
     
     
     function edit(id){
         $.nghia({
url : '/xml/tool.php?edit',
type : 'POST',
data : {id : id},

ducnghia : function(result){
canvas('Sửa trò chơi',result);

}
});
     } 
     
  
     
   
    function taodata(){
         $.nghia({
url : '/xml/tool.php?taodata',
type : 'POST',
data : {mapID : mapID , x : userEvent.mapPosition.X, y : userEvent.mapPosition.Y},

ducnghia : function(result){
canvas('Tạo dữ liệu game',result);

}
});
     }   
     
     
     function xemtruoc() {
   
  var direction = $('#direction').val();
  var images = $('#style').val();

				$('#xemtruoc').html('<img src="/xml/nhanvat.php?nhanvat='+images+'&nut='+direction+'">');	
}


function dongedit(){
    $('#ducnghia_listdata').html('');

}
     
     
     function editcode(){
    $.nghia({
            	       	url         : '/xml/tool.php?luu',
    	            	type        : 'POST',
    	            	data        : $("#ducnghia_dz_trang").find("select, textarea, input").serialize(),
                  	ducnghia : function(result){

						$('#giaotiep').html('ADMIN:<font color="red"><b>'+result+'</b></font>');	
    	            	}
    	        	});
    	        	loadMapEvents();
}

 function taocode(){
    $.nghia({
            	       	url         : '/xml/tool.php?tao',
    	            	type        : 'POST',
    	            	data        : $("#ducnghia_dz_trang").find("select, textarea, input").serialize(),
                  	ducnghia : function(result){

						$('#giaotiep').html('ADMIN:<font color="red"><b>'+result+'</b></font>');	
    	            	}
    	        	});
    	        	loadMapEvents();
}





function benhvien(){
$.nghia({
	url : code(),
type : 'POST',
data : { a :'chucnang',hoihp:1},

	ducnghia : function(result){
	var x = $.parseJSON(result);
		giaotiep(x.ducnghia);
				
	}

});
} 

function c_menu() {
    if(userID>=1) {
    		document.getElementById('ducnghia_menu').style.display = "none";
    }
}

function o_menu() {
    		document.getElementById('ducnghia_menu').style.display = "block";
 
}

function tuido(){


    $.nghia({
url : code(),
type : 'POST',
data : { a : 'chucnang' , tui :1},
ducnghia : function(result){
var x = $.parseJSON(result);
canvas('Bag',x.a);


}
});
}


function thongtin(id,modal){	
  $.nghia({
url : code(),
type : 'POST',
data : {id : id , a : 'chucnang' , ivp : 1},
ducnghia : function(result){
    
    var x = $.parseJSON(result);
giaotiep(x.gioithieu);
					$("#npc_menu").html(x.muaban);


}
});
} 

function banitem(id){
   
      canvas('BÁN VẬT PHẨM','Giá Xu : <input id="bac_ban" class="form-control" type="number" value="0" style="width: 91%;"><br>Giá Ruby : <input id="vang_ban" class="form-control" type="number" value="0" style="width: 91%;">Số lượng : <input id="sl" class="form-control" type="number" value="1" style="width: 91%;"><button class="btn btn-primary" onclick="okbanitem('+id+')" id="nutban">Bán</button>');

c_giaotiep();
} 


function okbanitem(id){
var vang_ban = $('#vang_ban').val();
var bac_ban = $('#bac_ban').val();
var soluong = $('#sl').val();

$.nghia({
	url : code(),
	type : 'POST',
	data : {banitemok :1 , a : 'chucnang',id : id , vang_ban : vang_ban , bac_ban : bac_ban , soluong : soluong},
	ducnghia : function(result){

	var x = $.parseJSON(result);
giaotiep(x.msg);
					$("#npc_menu").html('');


	}

});
}


function xemshopvatpham(id,modal){	
$.nghia({
url : code(),
type : 'POST',
data : {id : id , a : 'chucnang' , vpducnghia :1},
ducnghia : function(result){
    

    var x = $.parseJSON(result);
giaotiep(x.gioithieu);
					$("#npc_menu").html(x.sudung);



}
});
} 


function ban_vp(id,ducnghiait){
    
    ///////xem VP ĐỂ BÁN
$.nghia({
url : code(),
type : 'POST',
data : {id : id , ban : 1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);
		canvas('KÍ GỬI','<br><hr><center><big> '+x.ten+' </big></center> <br>   Số Lượng<input id="sl_ban" class="form-control" type="number" value="0" style="width: 91%;"> Giá Xu :<input id="gia_ban_bac" class="form-control" type="number" value="0" style="width: 91%;"> <br> Giá Ruby : <input id="gia_ban_vang" class="form-control" type="number" value="0" style="width: 91%;">   <br> '+x.nut+'');

c_giaotiep();
}


});
}


function okban_vp_shop(id){
    	var sl_ban = $('#sl_ban').val();
    	var gia_ban_bac = $('#gia_ban_bac').val();
    	var gia_ban_vang = $('#gia_ban_vang').val();

 ///sử lí dữ liệu bán lun
$.nghia({
url : code(),
type : 'POST',
data : {okbducnghia :1 , a : 'chucnang',id : id , sl_ban : sl_ban , gia_ban_bac : gia_ban_bac , gia_ban_vang : gia_ban_vang},
ducnghia : function(result){
    var x = $.parseJSON(result);
giaotiep(x.thongbao);
					$("#npc_menu").html('');
}
});    
    

}


function kigui_item(){
      c_giaotiep();

      ///tui pokemon
$.nghia({
url : code(),
data : {choitems:1,a:'chucnang'},
type : 'POST',
ducnghia : function(result){
var x = $.parseJSON(result);
canvas('Shop Item',x.a);
}
});
  }


function xemdemua(id,modal){
        c_giaotiep();

$.nghia({
url : code(),
type : 'POST',
data : {id : id , xemdemua : 1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);
//  $('#end_data').html(x.aaaa);

giaotiep(x.aaaa);
					$("#npc_menu").html(x.button);

}
});
} 

function okmuaitemthoi(id){
            c_giaotiep();

$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , dangmua : 1 , a : 'chucnang'},
	ducnghia : function(result){

	var x = $.parseJSON(result);

giaotiep(x.msg);

	}
});
}


function kigui_pokemon(){
      c_giaotiep();

      ///tui pokemon
$.nghia({
url : code(),
data : {cuahangpkm :1 , a:'chucnang'},
type : 'POST',
ducnghia : function(result){
var x = $.parseJSON(result);
canvas('SHOP POKEMON',x.a);
}
});
  }
  
  
 

function banpkm(id){
      c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {id : id , showban :1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);
					$("#ducnghia_console").html(x.aaaa);


}
});
} 

function okban(id){
var bac = $('#giabac').val();

$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id ,  bac : bac , banpkmok :1 , a : 'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);

 giaotiep(x.msg);
	}

});
}


function gopkm(id){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , thao :1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);
 giaotiep(x.msg);

}
});
} 


function muapkm(id){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , muapkm : 1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);

 giaotiep(x.msg);

}
});
} 

 function info_doiten(id){

$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , doitenpet :1 , a : 'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
	$('#ducnghia_console').html(x.msg);



	}

});	

} 


function doitenok(id){
var tenmoi = $('#tenmoi').val();

$.nghia({
	url : code(),
	type : 'POST',
	data : {tenmoi : tenmoi , id : id , doiten: 1 , a : 'chucnang'},
	ducnghia : function(result){

	var x = $.parseJSON(result);


		  pokemon(id);
 giaotiep(x.msg);

	}

});
}


function info_vatpham(id){

$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , item :1 , a : 'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
	$('#ducnghia_console').html(x.msg);


	}

});
} 


function dungvp(d){
	

$.nghia({
	url : code(),
	type : 'POST',
	data : {d : d , vatpham: 1 , a : 'chucnang'},
	ducnghia : function(result){

	var x = $.parseJSON(result);
giaotiep(x.msg);
pokemon(d);

	}

});
}

function info_move(id){


$.nghia({
	url : code(),
		type : 'POST',
	data : {id : id , hm :1 , a :'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
	$('#ducnghia_console').html(x.msg);


	}

});
} 

function movetm_ok(pokemon){
	
var tm = $('#tm').val();
var stt = $('#stt').val();


$.nghia({
	url : code(),
	type : 'POST',
	data : {stt : stt , pokemon : pokemon , tm : tm , move :1 , a : 'chucnang'},
	ducnghia : function(result){

	var x = $.parseJSON(result);
 giaotiep(x.msg);

	}

});
}


function shiny(id){
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , shiny : shiny , a : 'chucnang'},
	ducnghia : function(result){
		var x = $.parseJSON(result);
	pokemon(id); 
giaotiep(x.thongbao);

	}
});
}


function chora(id){
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , layra :1 , a : 'chucnang'},
	ducnghia : function(result){
		var x = $.parseJSON(result);
  giaotiep(x.thongbao);

pokemon(id);
	}
});
}

function bo(id){
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , cat :1 , a : 'chucnang'},
	ducnghia : function(result){
		var x = $.parseJSON(result);
pokemon(id)
  giaotiep(x.thongbao);

	}
});
}


function auto_pkm(id){
      c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {id : id , auto : 1 , a:'chucnang'},
ducnghia : function(result){
					$("#ducnghia_console").html(result);

}
});
}

function cai_auto(id,name){
      c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {id : id , name : name , okecai :1 , a :'chucnang'},
ducnghia : function(result){
giaotiep(result);

}
});
}

function thapokemon(id) {
    giaotiep('bạn có chắc chắn muốn thả pokemon này không ? Bạn sẽ nhận lại bóng đã bắt pokemon ?');
    					$("#npc_menu").html('<b onclick="ok_tha('+id+');" class="viptxt nutchat">Xác nhận</b>');

}

function ok_tha(id_p){

$.nghia({
	url : code(),
	type : 'POST',
	data : {id_p : id_p , tha :1 , a:'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
c_menu();
giaotiep(x.ducnghia);
c_table();
	}
 
});
} 




function user(id,mod){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , mod : mod , thongtin :1 , a : 'chucnang'},
ducnghia : function(result){
var x = $.parseJSON(result);

  $('#them').html(x.chucnang);

}
});
}

function sudung(id,soluong){
$.nghia({
url : code(),
type : 'POST',
data : {id : id , soluong: soluong , sudung :1 , a : 'chucnang'},
ducnghia : function(result){
    var x = $.parseJSON(result);
   nhanthuong(x.thongbao);
tuido();
}
});    
    
} 

///chat///ducnghia
function mychat(){

$.nghia({
url : code(),
type : 'POST',
data : {a : 'us' , mychat :1},
ducnghia : function(result){
canvas('SMS',result);
}
});
}



function sendmsg(id){
    	$('#listacc').html('Đang gửi.....');

	$('#t20_btchat').html('<i class="fa fa-spinner fa-pulse"></i>');
	var text = $('#t20_chat').val();
			if(text.trim() != '' || $('#t20_display').html().trim() == ''){
				if(text.trim() == '' && id != 2) text = '';
				$('#t20_chat').attr('disabled','disabled');
$.nghia({
url : code(),
type : 'POST',
data : { text : text , user : id , a :'sms' },
ducnghia : function(result){
var x = $.parseJSON(result);
		$('#t20_chat').val('');
		$('#t20_btchat').html('Gửi');
		$('#t20_chat').removeAttr('disabled');
if(!x.error)
	$('#listacc').html('<hr><center>Trò Chuyện </center><hr> '+x.msg+'');
else
	giaotiep('Thành cong...'+x.error+'');
}
});
			} else {
				$('#t20_btchat').html('Gửi');
			}
}




function msg(id,modal){
canvas('INBOX','<span class="input-group-btn"></span><input class="form-control" type="text" placeholder="Nhập tin nhắn" id="t20_chat"> <span class="input-group-btn"> <button class="btn btn-info" type="button" id="t20_btchat">Gửi</button></span>	<ul class="NB_list-group deschat" id="t20_display"></ul><div id="listacc"></div>');

$('#t20_btchat').attr('onclick','sendmsg('+id+')');
$('#t20_display').attr('MSGufr',id);
sendmsg(id);


}



function markt(id,ducnghiait,soluong){
    	var soluong_mua = soluong;
    	    ///hiển thị mark
    	    if(ducnghiait == "item") {
	      $.nghia({
	url : code(),
	type : 'POST',
	data : {id : id,markt:1,a:'x'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
		    						  		       

					$("#data_shop").html(x.ducnghia);
					$("#menu_shop").html(x.menu);

	}

});  }

if(ducnghiait == "vatpham") {

	      $.nghia({
	url : code(),
	type : 'POST',
	data : {id : id,vatpham:1,a:'x'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
		    						  		       

	$("#data_shop").html(x.ducnghia);
					$("#menu_shop").html(x.menu);

	}

});  }
///song

/// mua markt //
 if(ducnghiait == "muamarkt") {

	      $.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , soluong_mua : soluong_mua , muamarkt:muamarkt,a:'x'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
		    						  		      
	$("#data_shop").html(x.ducnghia);
					$("#menu_shop").html('');


	}

});  }


if(ducnghiait == "muavatpham") {
        	       

	      $.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , soluong_mua : soluong_mua , muavatpham : 1,a:'x'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
		    						  		      
	$("#data_shop").html(x.ducnghia);
					$("#menu_shop").html('');
	}

});  }

//song
    	    
    	   

} 



function nhannv(){

         $.nghia({
url : code(),
data : {a : 'nhiemvu',nhannv :1},
type : 'POST',
ducnghia : function(result){
var xx = $.parseJSON(result);

giaotiep(xx.text);
					$("#npc_menu").html('');

setdrawn(0,0,0,0,'Nhận nhiệm vụ thành công.');

    	        	loadMapEvents();

}
});
     }  


 function docnv(){

         $.nghia({
url : code(),
data : {a : 'nhiemvu',docnv:1},
type : 'POST',
ducnghia : function(result){
var xx = $.parseJSON(result);

giaotiep(xx.text);
					$("#npc_menu").html(xx.menu);



}
});
     }
     
     
     
     function tranv(){
         $.nghia({
url : code(),
data : {a : 'nhiemvu',tranv :1},
type : 'POST',
ducnghia : function(result){
var xx = $.parseJSON(result);

giaotiep(xx.text);
setdrawn(xx.xu,xx.exp,xx.item,xx.tmhm,'HOÀN THÀNH');

					$("#npc_menu").html(xx.menu);
    	        	loadMapEvents();
					$("#nhiemvu").html('');
nhiemvudata = 'song';
}
});
     } 
     
     
function nhanpokemon(id) {
     $.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , nhanpkm :1,a:'x'},
	ducnghia : function(result){

 			giaotiep(result);

	}

});
}     


function nhiemvu(){
    $.nghia({
url : code(),
type : 'POST',
data : {a : 'nhiemvu',my :1},
ducnghia : function(result){
var x = $.parseJSON(result);
canvas('NHIỆM VỤ',x.ducnghia);

}
});
}

function map_b(){
      $('#map_button_nut_x').toggle('fast','linear');  
      $('#map_button_xxx').toggle('fast','linear');  

  }  
  
  function web_chat(){

      $('#show_chatmap').toggle('fast','linear');  

  }  
  
  

	
	
  function smileys(){
			$('#t1_smileys').slideToggle();
			}
			
			function smile(text,gelement) {
	var t1_default = $(gelement).val();
	if(t1_default.trim() != '') text = ' '+text;
                $(gelement).val(t1_default + text);
				$(gelement).focus();
            }
  
  /////////////////ducnghia
  
  function openchat(id,user){

 o_menu();

   msg(id);
}


function map_movelevel(){
    c_giaotiep();

o_menu();
$.nghia({
url : '/_nodejs/tienhoa.php',
type : 'POST',

ducnghia : function(result){
  canvas('TIẾN HÓA',reusult);

}
});
} 
 

function tienhoaok(id){
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , a : 'tancong' , tienhoa :1},
	ducnghia : function(result){

c_canvas();

	}
 
});
} 


function map_moveskill(){
c_giaotiep();
$.nghia({
url : '/_nodejs/kinang.php',
type : 'POST',

ducnghia : function(result){
canvas('Skills',result);
}
});
} 


function pokemon_skill(id){
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , a : 'tancong' , skill :1},
	ducnghia : function(result){
	var x = $.parseJSON(result);
 
c_canvas();

	}
 
});
} 
///module gia tộc
function giatoc_nangcap() {



         $.nghia({
url : code(),
data : {a : 'gt' , nangcap:1},
type : 'POST',
ducnghia : function(result){

giaotiep(result);

}
}); 
      }









 function tintuc(trang) {


         $.nghia({
url : '/datalog/tintuc.php?list',
type : 'POST',
data : {trang : trang},
ducnghia : function(result){
canvas('HƯỠNG DẪN',result);

}
}); 
      }
      
   
      
      
       function doctin(id) {

	//$('#ducnghia_tintuc').modal('show');


         $.nghia({
url : '/datalog/tintuc.php?doctin',
type : 'POST',
data : {id : id},
ducnghia : function(result){
    var xx = $.parseJSON(result);
  
canvas(xx.title,xx.text);

}
}); 
      }
 
 
 
 
 
 
 
 
 
 function giatoc_kick(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , kick :1 , a : 'gt'},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }
      
 function giatoc_roi() {

         $.nghia({
url : code(),
data : {a : 'gt', roi:1},
type : 'POST',
ducnghia : function(result){

giaotiep(result);

}
}); 
      }     
      
 
 function giatoc_dongy(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , dongy :1 , a :'gt'},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }
      
      
       function giatoc_khong(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , huy :1 , a : 'gt'},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }
 
 
 
 
 function giatoc_danhsachxin(){
       

    $.nghia({
url : code(),
type : 'POST',
data : {danhsach :1 , a :'gt'},
ducnghia : function(result){
canvas('List',result);
}
});
}
 function xin_giatoc(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , a :'gt',xin :1},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }
      
 function giatoc(){
     
    $.nghia({
url : code(),
type : 'POST',
data : {a : 'gt', giatoc :1},
ducnghia : function(result){
canvas('GIA TỘC',result);

}
});
}
 function taogiatoc(){
        c_giaotiep();


    $.nghia({
url : code(),
data : {a:'gt',showtao :1},
type : 'POST',
ducnghia : function(result){
canvas('TẠO GIA TỘC',result);
  

}
});
}
 
 function ok_taogiatoc() {
	var viettat = $('#viettat').val();

	var giatoc = $('#giatoc').val();
	var icon = $('input[name=icon]:checked').val();

         $.nghia({
url : code(),
type : 'POST',
data : {giatoc : giatoc , icon : icon , viettat : viettat , a : 'gt',tao:1},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }
 
function ducnghia_att_pk() {
 	// $('#pk').modal('show');
 //	$('#data_pk').html('Đang tải dữ liệu');

$.nghia({
	url : code(),
	data : {a : 'tancong',wild :1},
	type : 'POST',
	ducnghia : function(result){
 // ducnghia_battel.style.display = "block";
attack_pk('Thám Hiểm');
	$('#nghiait_att_data').load('/_nodejs/wild.php');
	$('#ducnghia_text').html('Tiếp tục trận đấu');

	}

});
}
function pk(id) {
    huanluyen(id);
}

function huanluyen(id){
$.nghia({
	url : code(),
	type : 'POST',

	data : {id : id , trainer :1 , a : 'tancong'},

	ducnghia : function(result){
	        var xx = $.parseJSON(result);
if(xx.code==1) {
attack_pk('Huấn Luyện');
	$('#nghiait_att_data').load('/_nodejs/trainer.php?n=');
} else {
    giaotiep(xx.msg);
}
	}

});
}




function map_thongbao(){
   
$.nghia({
url : ''+code()+'',
data : {a:'chucnang',thongbao:1},
type : 'POST',

ducnghia : function(result){
    canvas('THÔNG BÁO',result);

}
});
}  


  function dong_huanluyen(){
c_attack();
}

////ducnghia


var b = 0;
		var m = 0;
		var m_reset = 0;
		function quaynao(){
			$('#hide').slideUp();
			$('#error').fadeOut();
			$('#phanthuong').fadeOut();
			$('.active').removeClass('active');
			$.nghia({
				url : code(),
				data : {quay :1 , a : 'qs'},
				type : 'POST',
				ducnghia : function (result){
					var getData = $.parseJSON(result);
					if(getData.error == 1){
						$('#error').fadeIn();
					} else {
						$('#quay').attr('onclick','doi').html('<span class="cb_end"><span class="cb_ttl white">Chờ</span></span>');
			m = 0;
			b = 0;
			m_reset = 0;
			wheel(100,getData.vongquay);
					}
				}
			});

		}
        function wheel(d, c)
        {
            var f = 8*3 + c;
            setTimeout(function() {
				if(m >1)
				m_reset = m-1;
			else 
				m_reset = 8;
				$('.m'+m_reset).removeClass('active');
                $('.m'+m).addClass('active');
                m++;
                b++;
				if(m ==9)
					m = 1;
                if (b < f)
                    wheel(d, c);   
				if (b == f){
					$('#quay').attr('onclick','quaynao();').html('<span class="cb_end"><span class="cb_ttl white">Quay</span></span>');
					$('#phanthuong').fadeIn().html('Quay thành công ! Nhận được vật phẩm !');
				
				}
            }, d);
        }
     
////

function quayso(){
$.nghia({
url : code(),
type : 'POST',
data : {show :1 , a :'qs'},

ducnghia : function(result){
 canvas('THỬ VẬN MAY',result);

}
});
}  


  function xempkm(){
         $.nghia({
url : '/xml/tool.php?idpkm',
type : 'POST',
//data : {id : id},

ducnghia : function(result){
$('#ducnghia_listdata2').html(result);

}
});
     }
     
       function xempkmok() {
   
  var idpkm = $('#id').val();
    $.nghia({
url : '/xml/tool.php?id',
type : 'POST',
data : {idpkm : idpkm},

ducnghia : function(result){
$('#notice2').html(result);

}
});
}

     
      function mappokemon(){
         $.nghia({
url : '/xml/tool.php?pkmmap',
type : 'POST',
data : {mapID : mapID},

ducnghia : function(result){
canvas('POKEMON',result);
}
});
     }   
     
      function editgrass(){
            var grass = $('#grass').val();

         $.nghia({
url : '/xml/tool.php?editgrass',
type : 'POST',
data : {mapID : mapID , grass : grass},

ducnghia : function(result){
$('#notice').html(result);

}
});
     } 
     
     
     function ruongdo(){
c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {a:'us',ruongdo:1},

ducnghia : function(result){

canvas('RƯƠNG NHÀ',result);
}
});
}  

function ruongdo_lay(id){
giaotiep('Bạn muốn lấy pokemon này ra không ?');
					$("#npc_menu").html('<b class="viptxt nutchat" onclick="chora('+id+')">#Lấy Ra</b>');

}

function chora(id){
    c_giaotiep();
$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , layra :1 , a : 'chucnang'},
	ducnghia : function(result){
		var x = $.parseJSON(result);

ruongdo();
	}
});
}


function icon(btn)
{
	if (btn.value == "On")
	{
		btn.value = "Off";
        nicon = '1';
	}
	else
	{
		btn.value = "On";
        nicon = '0';

	}
}


function amthanh()
{
    $.nghia({
	url : code(),
	type : 'POST',
	data : {a:'us',amthanh:1},
	ducnghia : function(result){

giaotiep(result);
	}
});


}
 
 
function autov(){
    document.getElementById('t_au').style.display = "block";
    		$("#auto").html('1');
console.log('oke');
}

 


 

function auto_t(){
    document.getElementById('t_au').style.display = "none";
    		$("#auto").html('0');

}
function chien_out(){
    		$("#chien").html('0');

}


function dong_thamhiem(){
      $('#pk').modal('hide');

}



function c(msg){
  chatthegioi_msg = msg;
  chatthegioi = 1;
  var abcedz = cvsWidth / 1.5;
    chatthegioi_time= cvsWidth+abcedz;              
}


function topgame(id){
c_giaotiep();


$.nghia({
url : code(),
type : 'POST',
data : {id : id , top:1 , a :'t'},

ducnghia : function(result){
canvas('TOP',result);
}
});

}  


 function xoagame(id){
         $.nghia({
url : '/xml/tool.php?delete',
type : 'POST',
data : {id : id},
ducnghia : function(result){
datamap();
    	        	loadMapEvents();

}
});
     }    
     
     
     function nap() {
c_giaotiep();
 $.nghia({
url : '/napthe/index.php',
type : 'POST',
ducnghia : function(result){
canvas('NẠP RUBY',result);

}
});

      }
      
      
      function napthe(){
        	    	    	var card_type_id = $('#card_type_id').val();
        	    	    	var price_guest = $('#price_guest').val();
        	    	    	var pin = $('#pin').val();
        	    	    	var seri = $('#seri').val();
        	    	    	var note = $('#note').val();
        	    	   	var ma_bao_mat = $('#ma_bao_mat').val();

   $('#notice_the').html('Đang nạp xin chờ...');

$.nghia({
	url : '/napthe/napthe.php',
	type : 'POST',
	data : {card_type_id : card_type_id , price_guest : price_guest , pin : pin , seri : seri , note : note , ma_bao_mat : ma_bao_mat },
	ducnghia : function(result){
	var x = $.parseJSON(result);
    $('#notice_the').html(x.msg);


		                        $("#captcha").attr('src', '/napthe/securimage/securimage_show.php?sid=' + Math.random());
	
	}
 
});
}  
      
      
      function thegioi(noidung){
          
		  socket.emit("ducnghia_thegioi", noidung,userID);
}

function chuyenmap(ducnghiaid,ducnghiax,ducnghiay){
    	arrivalDirection = null;

			userEvent.mapPosition.X =ducnghiax;
			userEvent.mapPosition.Y =ducnghiay;
			
		    scriptLineComplete();
		    
		  
		    	loadMap(ducnghiaid);
		    
}



 function edit_info(){


$.nghia({
url : code(),
data : {editinfo:1 , a : 'chucnang'},
type : 'POST',
ducnghia : function(result){
var x = $.parseJSON(result);
canvas('EDIT',x.ducnghia);

}
});
}

 function save_edit(){
	var pass = $('#pass').val();
	var gioithieu2 = $('#gioithieu2').val();


$.nghia({
url : code(),
type : 'POST',
data : {gioithieu2 : gioithieu2 , pass : pass , saveedit :1 , a :'chucnang'},

ducnghia : function(result){
var x = $.parseJSON(result);

giaotiep(x.msg);
}
});
}


function web_dichuyen(){
   
$.nghia({
url : code(),
data : {open:1,a:'a'},
type : 'POST',
ducnghia : function(result){
canvas('PokeMon Dex',result);
}
});
}  

function huongdan(id){
    
$.nghia({
url : code(),
data : {id:id,a:'a'},
type : 'POST',
ducnghia : function(result){
canvas('PokeDex',result);
}
});
}  


function info(id , modal){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , infopkm :1 , a : 'chucnang'},
ducnghia : function(result){
var x = $.parseJSON(result);
$('#pokemondex').modal('show');
$('#thongtin').html(x.thongtin);
$('#tienhoa').html(x.tienhoa);
$('#tienhoa2').html(x.tienhoa2);

$('#kinang').html(x.kinang);
$('#move').html(x.move);

table();
	$('#table_game').html(x.data);	



}
});
}

function bossw(id){

$.nghia({
	url : code(),
	type : 'POST',
	data : {id : id , boss :1,a:'chucnang'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
 if(x.code == '1') {
     giaotiep(x.msg);
 } else {
////
attack_pk('BOSS');
	$('#nghiait_att_data').load('/_nodejs/boss.php');

///
 }
			
	}
 
});
} 

function dctt(){
    	var xn = $('#xnext').val();
	var yn = $('#ynext').val();
userEvent.mapPosition.X = xn;
userEvent.mapPosition.Y = yn;
}

function goto(x,y){
    
userEvent.mapPosition.X = x;
userEvent.mapPosition.Y = y;

}

 function dich(){
     
$('#ducnghia_listdata').html('<div style="width:100%;background-color:#eee;padding:10px;margin-top:1px"> Dịch chuyển :<br><input type="text" value="" id="tocdo" placeholder="Tốc độ" value="1"><br><button onclick="bay(\'trai\')">Trái</button><button onclick="bay(\'phai\')">Phải</button><button onclick="bay(\'len\')">Lên</button><button onclick="bay(\'xuong\')">xuống</button>');

     }  
     
     
     function bay(duc){

if(duc="phai") {
userEvent.mapPosition.X = userEvent.mapPosition.X + 1;
userEvent.mapPosition.Y = my;
}
if(duc="trai") {
userEvent.mapPosition.X = mx - tocdo;
userEvent.mapPosition.Y = my;
}
if(duc="len") {
userEvent.mapPosition.X = userEvent.mapPosition.X;
userEvent.mapPosition.Y = my + tocdo;
}
if(duc="xuong") {
userEvent.mapPosition.X = userEvent.mapPosition.X;
userEvent.mapPosition.Y = my - tocdo;
}
}
function tat(){
          socket.disconnect();

}
function fix(){
map('Grassy Patch',26,15);
			
}



function tienhoamap() {
   c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {chonpokemon:1,a:'q'},
ducnghia : function(result){
canvas('Tiến Hóa',result);
}
});   
  }   
  
  
function tienhoatiep(id) {
    c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {a:'q',chon:1,id:id},
ducnghia : function(result){
canvas('Tiến Hóa',result);

}
});   
  }     
  
  
  function tienhanh(id,idmy) {
    c_giaotiep();
$.nghia({
url : code(),
data : {a:'q',tienhanh:1,id:id,idmy:idmy},

type : 'POST',
ducnghia : function(result){
canvas('Tiến Hóa',result);

}
});   
  }     
  
  
  
  
  
  function reset(){
      c_giaotiep();
$.nghia({
url : code(),
data : {reset :1 , a :'pokemon'},
type : 'POST',
ducnghia : function(result){
giaotiep(result);

}
});
}

 function resetdb(){
      c_giaotiep();
$.nghia({
url : code(),
data : {resetdb :1 , a : 'pokemon'},
type : 'POST',
ducnghia : function(result){
giaotiep(result);

}
});
}

function resetskill(dxx){
    if(dxx !=1) {
      c_giaotiep();
      o_menu();
    }
$.nghia({
url : code(),
data : {skill  :1 , a :'pokemon'},
type : 'POST',
ducnghia : function(result){
canvas('Học Lại Kĩ Năng',result);

}
});
}

 function hoclai(name){
         	var vitri = $('#vitri').val();

       $.nghia({
url : code(),
type : 'POST',
data : {vitri : vitri , name : name, hoc :1 , a :'pokemon'},

ducnghia : function(result){
giaotiep(result);
resetskill(1);

}
});
 }


 function tabdichchuyen(){
$.nghia({
url : code(),
type : 'POST',
data : {id : mapID , dichchuyen :1 , a : 'm'},

ducnghia : function(result){
canvas('DỊCH CHUYỂN',result);

}
});
}
 function follow(id){
       $.nghia({
url : code(),
type : 'POST',
data : {id : id , follow :1 , a : 'chucnang'},

ducnghia : function(result){
    
giaotiep(result);
if(result=="Thành công.") {
pet(id); }
}
});
 }
function pet(ducnghia,ten) {
    tagAlong = ducnghia;
    tagAlongName = '';
    follower = new gameEvent();
				events.push(follower);
				
				follower.id = -1;
				follower.name = '';

				follower.mapPosition.X = userEvent.mapPosition.X;
				follower.mapPosition.Y = userEvent.mapPosition.Y+2;
				follower.type = "Action Button";
				follower.spriteName = tagAlong + ".png";
				follower.direction = userEvent.direction;
				follower.moveType = "Follow User";
				follower.bIsUser = false;
				follower.bEventEnabled = true;
        		follower.eventData.push(new ScriptLine( 2, "MOVE EVENT" , "-1^move to user^1"));
        	    	        	loadMapEvents();

}

function nutvitri(id){

      $('#nutdoivitri_'+id).toggle('fast','linear');  
      $('#ducnghia_vitri_'+id).toggle('fast','linear');  

  }  
  
  function doivitri(bandau,vitri,idpkm){
       $.nghia({
url : code(),
type : 'POST',
data : {bandau : bandau , vitri:vitri , idpkm : idpkm , cha :1 , a : 'm' },

ducnghia : function(result){
ttnv(userID);
}
});
 }
 
 
 function tn(id,diem,loai){
       $.nghia({
url : code(),
type : 'POST',
data : {id : id , loai:loai , diem : diem , a :'m', tn :1},

ducnghia : function(result){
pokemon(id);
}
});
 }
 
 function login2(){
      $('#loginac').toggle('fast','linear');  
      $('#maychu').toggle('fast','linear');  
 }
 
 
 
 
  function dangki(){
   	var taikhoan = $('#taikhoan').val();
		   	var matkhau = $('#matkhau').val();

$.nghia({
url : code(),
type : 'POST',
data : { taikhoan : taikhoan , matkhau : matkhau , dangki:1,a:'login' },
ducnghia : function(result){

giaotiep(result);
}
});
			
}
var loginstt =0;

   function dangnhap(){
   	var taikhoan = getdata('taikhoan');
		   	var matkhau = getdata('matkhau');
giaotiep('loading ....');
$.nghia({
url : code(),
type : 'POST',
data : { taikhoan : taikhoan , matkhau : matkhau , dangnhap:1,a:'login' },
ducnghia : function(result){
var x = $.parseJSON(result);
 setTimeout(function() {

if(x.ok==1) {
    c_giaotiep();
c_menu();
    c_vemap();
   userName=x.uidname; 
   soundEnabled = x.music;
      musicEnabled = x.music;
userID = x.uid;
clan_icon=x.icon;
clan_viettat=x.viettat;
  $('#ducnghia_user_exp').html('PKMVN_'+userID);
  $('#ducnghia_users').html(userName);
 
 tagAlong = x.pokemon;
 
  
//////
    socket.emit("ducnghialogin", "/ducnghia^"+userID+"^" + x.map +"^"  + x.mx +"^" + x.my +"^0^0^"+x.uidname+"^"+x.skin+"^"+x.icon+"^"+x.viettat+"");
      socket2.emit("ducnghia",userID); 
   c(x.thongbao);
/////

   map(x.map,x.mx,x.my,x.name);
userSprite = x.skin;
 userEvent = new gameEvent();
		userEvent.initAsPlayer(Point(x.mx,x.my));
		

setTimeout(function() {
      ketnoi();
    }, 2000);
} else {
    giaotiep(x.ducnghia);

}
}, 2000);      

}
});
			
}





function map(map,x,y,images) {
    	
  userEvent.mapPosition.X = x;
userEvent.mapPosition.Y = y;
userX = x;
userY = y;

      mapCode = map;
  dulieumap(map,images);

	
	

}

function doitrang(ducnghiatrang) {
    var xduc = userEvent.mapPosition.X;
    var yduc = userEvent.mapPosition.Y;
    
    userSprite = ducnghiatrang;
    userEvent = new gameEvent();
		userEvent.initAsPlayer(Point(xduc,yduc));
}


function shop_skin(){
c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {shopskin :1 , a :'skin'},

ducnghia : function(result){
canvas('Cửa Hàng Trang Phục',result);
}
});
}  


function xem_skin(id){
$.nghia({
url : code(),
type : 'POST',
data : {id : id , xemskin :1 , a :'skin'},

ducnghia : function(result){
var xx = $.parseJSON(result);
giaotiep(xx.info);
					$("#npc_menu").html(xx.ok);

}
});
}  

function mua_skin(id){
$.nghia({
url : code(),
type : 'POST',
data : {id : id , muaskin :1 , a :'skin'},

ducnghia : function(result){
giaotiep(result);
}
});
}  


function doiskin(){
c_giaotiep();
$.nghia({
url : code(),
data : {doiskin:1,a:'skin'},
type : 'POST',

ducnghia : function(result){
canvas('BAG',result);
}
});
} 


function ok_skin(id){
c_menu();
$.nghia({
url : code(),
type : 'POST',
data : {id : id , okdoi:1,a:'skin'},

ducnghia : function(result){
    var x = $.parseJSON(result);
doitrang(x.nv);
}
});
}  


 function taonv(){
         $.nghia({
url : '/xml/tool.php?taonv',
type : 'POST',

ducnghia : function(result){
$('#ducnghia_listdata').html(result);

}
});
     }   
     
     
       function adnv(){
    $.nghia({
            	       	url         : '/xml/tool.php?adnv',
    	            	type        : 'POST',
    	            	data        : $("#ducnghia_dz_trang").find("select, textarea, input").serialize(),
                  	ducnghia : function(result){

						$('#giaotiep').html('ADMIN:<font color="red"><b>'+result+'</b></font>');	
    	            	}
    	        	});
}

function dotphao(){
         $.nghia({
url : '/datalog/sukien.php?dotphao',
type : 'POST',

ducnghia : function(result){
if(result!="Thất bại.") {
setdrawn(0,0,result,0,0);

}else {
giaotiep(result);
}
}
});
     }   



function chetao(){
         $.nghia({
url : code(),
type : 'POST',
data : {a : 'giap' , tao :1},

ducnghia : function(result){
if(result!="Thất bại.") {
$("#hieuung").show();
 jQuery("#hieuung").delay(5000).fadeOut("slow");
}
giaotiep(result);
}
});
     }   

function taogiap(){
c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {menu :1 , a :'giap'},

ducnghia : function(result){
canvas('TẠO GIÁP NINJA',result);
}
});
}    






 function sk_doi(id){
c_giaotiep();

$.nghia({
url : '/datalog/sukien.php?doiqua',
type : 'POST',
	data : {id : id},

ducnghia : function(result){
giaotiep(result);
}
});
}  

function shop_sukien(){
c_giaotiep();
$.nghia({
url : '/datalog/sukien.php?shop',
type : 'POST',

ducnghia : function(result){
canvas('ĐỔI VẬT PHẨM',result);
}
});
} 

function xem_vp_sk(id){
$.nghia({
url : '/datalog/sukien.php?xem',
type : 'POST',
data : {id : id},

ducnghia : function(result){
  $('#menu_nho').html(result);
    document.getElementById('menu_nho').style.display = "block";

}
});
}  
function xmenu() {
    document.getElementById('menu_nho').style.display = "none";

}
  
  function oketang(loai){
      	var keotang = $('#keotang').val();

$.nghia({
url : '/datalog/sukien.php?tang',
type : 'POST',
	data : {loai : loai , keotang : keotang},

ducnghia : function(result){
giaotiep(result);
    setdrawn(0,0,result,0,0);

}
});
}  
  
  function doikeo(loai){
      	var keo = $('#keo').val();

$.nghia({
url : '/datalog/sukien.php?doi',
type : 'POST',
	data : {loai : loai , keo : keo},

ducnghia : function(result){
giaotiep(result);
}
});
}  
 
 function ghepnl(loai){
c_giaotiep();
$.nghia({
url : '/datalog/sukien.php?doinl',
type : 'POST',
	data : {loai : loai},

ducnghia : function(result){
document.getElementById('menu_nho').style.display = "block";
  $('#menu_nho').html(result);
}
});
}  

 function tangkeo(){
c_giaotiep();
$.nghia({
url : '/datalog/sukien.php?tangkeo',
type : 'POST',

ducnghia : function(result){
document.getElementById('menu_nho').style.display = "block";
  $('#menu_nho').html(result);
}
});
}  


function banbe(){

$.nghia({
url : code(),
type : 'POST',
data : {a : 'bb' , banbe :1},

ducnghia : function(result){
canvas('BẠN BÈ',result);
}
});
}  


function xoa_banbe(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , xoa :1 , a : 'bb'},
ducnghia : function(result){

giaotiep(result);

}
}); 
      }

function ketban(id) {



         $.nghia({
url : code(),
type : 'POST',
data : {id : id , ketban:1,a:'bb'},
ducnghia : function(result){
giaotiep(result);

}
}); 
      }
      
      
      function caidat(){
          var menu = '';
          menu+='<center><b class="viptxt">Cài đặt cấu hình <b onclick="cl()">Đóng</b></b></center><b>';
          menu+='<div class="kengang"></div>Hiện thị icon gia tộc : <input type="button" id="icon" onclick = "icon(this);" value="On">';
        menu+='<div class="kengang"></div>Âm Thanh : <button onclick="amthanh()">Tắt/bật</button>';
          menu+='<div class="kengang"></div>Ẩn người chơi : <input type="button" id="btnShowUsers" onclick = "btnShowUsers(this);" value="On">';
menu+='<div class="kengang"></div><b onclick="phimao()" class="viptxt">Bật phím ảo</b>( Dành riêng cho tivi)';
          menu+='</b>';
          document.getElementById('menu_nho').style.display = "block";
  $('#menu_nho').html(menu);
      }
      




function reg_choingay() {
   	var taikhoan = $('#taikhoan').val();
    var nhanvat = $('#nvchon').html();

$.nghia({
url : code(),
type : 'POST',
data : { taikhoan : taikhoan , nhanvat : nhanvat , regchoi :1,a:'login' },
ducnghia : function(result){
var x = $.parseJSON(result);
giaotiep(x.ducnghia);

if(x.ok==1) {
    c_vemap();
c_menu();
   userName=x.uidname; 
   soundEnabled = x.music;
      musicEnabled = x.music;
userID = x.uid;
clan_icon=x.icon;
clan_viettat=x.viettat;
  $('#ducnghia_user_exp').html('PKMVN_'+userID);

map(x.map,x.x,x.y,x.name);
userSprite = x.skin;
 userEvent = new gameEvent();
		userEvent.initAsPlayer(Point(x.x,x.y));


  $('#ducnghia_users').html(userName);

    socket.emit("ducnghialogin", "/ducnghia^"+userID+"^" + x.map +"^"  + x.mx +"^" + x.my +"^0^0^"+x.uidname+"^"+x.skin+"^"+x.icon+"^"+x.viettat+"");
      socket2.emit("ducnghia",userID); 
   c(x.thongbao);


}

}
});
			
   
}

function xacminh(){
       	var taikhoan = $('#taikhoan').val();
       	var matkhau = $('#matkhau').val();

o_menu();
$.nghia({
url : code(),
type : 'POST',
data : { taikhoan : taikhoan , matkhau : matkhau , dangki :1 , a : 'login' },

ducnghia : function(result){

giaotiep(result);
document.getElementById('ducnghia_b_login').style.display = 'none';

}

});
}  


function menu_xacminh(){
     c_giaotiep();
     

$.nghia({
url : ''+code()+'',
data : {a:'home',xac:1},
type : 'POST',
ducnghia : function(result){
canvas('XÁC MINH TÀI KHOẢN',result);
}
});

 }
 
 var vx1 ='0';
 var vx2 = '0';
 var vy1 = '0';
 var vy2 = '0';
 var cong ='0';
 var tem = '0';
 
 function setvitri(x1,y1,x2,y2) {
     document.getElementById('vitripkm_x').style.display = 'block';
                document.getElementById('vitripkm_y').style.display = 'block';

vx1 = x1;
vx2 = y2;
vy1 = y1;
vy2 = y2;
cong = 3;
timvitri();
          document.getElementById('menu_nho').style.display = "none";

 }

 function pokemon_on_map() {
$.nghia({
url : code(),
type : 'POST',
data : { mapID : mapID , pokemon :1 , a:'pokemon'},

ducnghia : function(result){

canvas('PokeMon Trong Map',result);
}

});
 }
 
function timvitri(){
  if(userEvent.mapPosition.X == vx1 &&  userEvent.mapPosition.X <= vx1 && userEvent.mapPosition.Y >=vy1 && userEvent.mapPosition.Y <=vy2)   {
           document.getElementById('vitripkm_x').style.display = 'none';
           document.getElementById('vitripkm_y').style.display = 'none';

  }
  
  if(userEvent.mapPosition.X - vx1==0) {
                 document.getElementById('vitripkm_x').style.display = 'none';

  }
   if(userEvent.mapPosition.Y - vy1==0) {
                 document.getElementById('vitripkm_y').style.display = 'none';

  }
 
  
var xt = vx1 + cong;
  if(userEvent.mapPosition.X >= xt) {
      var trai = userEvent.mapPosition.X - vx1;
        $('#vitripkm_x').html('Đi sang trái '+trai+' bước.   ');

  } else {
         var trai = vx1 -  userEvent.mapPosition.X;
        $('#vitripkm_x').html('Đi sang phải '+trai+' bước.   ');
  }
  
  var yt = vy1 + cong;
  if(userEvent.mapPosition.Y >= yt) {
      var trai2 = userEvent.mapPosition.Y - vy1;
        $('#vitripkm_y').html('Đi lên trên '+trai2+' bước.   ');

  } else {
         var trai2 = vy1 -  userEvent.mapPosition.Y;
        $('#vitripkm_y').html('Đi xuống dưới '+trai2+' bước.   ');
  }
  
  
} 


 




function setchat(){
    if(chatset==0) {
               $('#setcaidat').html('[Map]');
                 $('#notice_chat_xx').html('[Map]:người cùng map mới thấy gõ <b>/huongdan</b> để rõ hơn nhé..');
             
 chatset =1;
    } else {
                         $('#notice_chat_xx').html('[chung] : chát toàn máy chủ.');

                       $('#setcaidat').html('[chung]');
chatset =0;
    }
}


function daupk(username){
     


$.nghia({
	url : code(),
		type : 'POST',
	data : {username : username , a : 'tancong' , pk :1},
	ducnghia : function(result){
attack_pk('So Tài');
	$('#nghiait_att_data').load('/_nodejs/trainer.php');
	}

});
} 
function base(nghia){
    return btoa(unescape(encodeURIComponent(nghia)));
}

function gym(id){


$.nghia({
	url : code(),
	type :'POST',
	data : {id : id , gym :1 , a : 'tancong'},

	ducnghia : function(result){
attack_pk('GYMS');
	$('#nghiait_att_data').load('/_nodejs/trainer.php?n=');
	}

});
}



 setInterval(function(){
 
  
  if(mapID>=1 && userEvent.mapPosition.X >=0  && userEvent.mapPosition.Y >=0 ) {

 $.nghia({
	url : code(),
	type : 'POST',
	data : {a : 'users' , data : userID , x : userEvent.mapPosition.X , y : userEvent.mapPosition.Y , id : mapID  },

	ducnghia : function(result){
var data = $.parseJSON(result);
chaybo=0;
clan_icon=data.icon;
clan_viettat=data.viettat;
thoitiet = data.thoitiet;
    //userSprite = data.sprite;
    		    		$("#time_auto").html(data.timeauto);
    		    	sms = data.inbox;

    		    		$("#t_au").html('Thời gian tự động : '+data.thoigian);
///datapk

    if(data.pk==1 && document.getElementById('nghiait_att').style.display=="none") {
    //    pk();
        
    }           



///PKPK

	}

});        
  }   





},10000);
 

function c_nhanthuong(){
                         document.getElementById('ducnghia_nhanthuong').style.display = 'none';
       $('#ducnghia_nhanthuong').removeClass('lac');

}

function nhanthuong(nghiait){

    $('#ducnghia_nhanthuong').addClass('lac');

                     document.getElementById('ducnghia_nhanthuong').style.display = 'block';
						$('#ducnghia_nhanthuong_data').html('<b class="viptxt">'+nghiait+'</b>');	

}




function phimao(){
          $('#ducnghia_dichuyen').toggle('fast','linear');  

}


 
function c_vemap(){
	$('#ducnghia_canvas').html('');	

}


function khach(){
    var nx =    cvsWidth;
var ny =    cvsHeight;
  var khach ='';
   
   $.nghia({
url : ''+code()+'',
data : {a:'home',home:'1'},
type : 'POST',
ducnghia : function(result){
     if(getdata('taikhoan') !="null") {
        khach+='<div class="nutplay" onclick="dangnhap();">Log.'+getdata('taikhoan')+'</div>';
    }
            khach+= result;
  var left= (nx/2)-80;
    var width = nx/2;
    var height = 'auto';
    var top = ny-250;
	$('#ducnghia_canvas').html('<div style="display:none;position: absolute; left: '+(left-50)+'px; width: '+width+'px; height: '+height+'; top: '+(top-250)+'px;"><img src="/sql/load/pokemmo.png"></div><div style="position: absolute; left: '+left+'px; width: '+width+'px; height: '+height+'; top: '+(top-30)+'px;">'+khach+'</div>');	
}
});   



  

    
}

function newac(){
  var khach ='';
    khach+= '<b id="nvchon" style="display:none;">Hero-Male.png</b><img src="/images/items/Master ball.png">Name :<input class="input3" id="taikhoan"  type="text" value="Name">';
                    khach+='<div class="btlogin" onclick="reg_choingay()">PLAY</div>';

                khach+='<div class="btlogin2" onclick="khach()">X</div>';

   var nx =    cvsWidth;
var ny =    cvsHeight;
 var left= (nx/2)-120;
    var width = nx/2;
    var height = 'auto';
    var top = ny-300;
	$('#ducnghia_canvas').html('<div style="position: absolute; left: '+left+'px; width: '+width+'px; height: '+height+'; top: '+top+'px;">'+khach+'</div>');	 

    
}



function saveacc(){
    var taikhoan = $('#taikhoan').val();
    var matkhau = $('#matkhau').val();
 setdata('taikhoan',taikhoan);
 setdata('matkhau',matkhau);
 khach();
}

function me_ackhac(){
  var khach ='';
   
   
   khach+='<input class="input3" id="taikhoan"  type="text" value="'+getdata('taikhoan')+'">';
      khach+='<input class="input3" id="matkhau"  type="password" value="'+getdata('matkhau')+'">';

      khach+='<center><b class="btlogin" onclick="saveacc()">OK</b><b class="btlogin2" onclick="khach()">X</b>';

    //  khach+='<b class="nut3" onclick="fixlogin()">Fix Đăng Nhập</b></center>';

    
var nx =    cvsWidth;
var ny =    cvsHeight;
 var left= (nx/2)-120;
    var width = nx/2;
    var height = 'auto';
    var top = ny-300;
	$('#ducnghia_canvas').html('<div style="position: absolute; left: '+left+'px; width: '+width+'px; height: '+height+'; top: '+top+'px;">'+khach+'</div>');	
}


function fixlogin(){
    var taikhoan = $('#taikhoan').val();
    var matkhau = $('#matkhau').val();
$.nghia({
url : login(),
type : 'POST',
data : {taikhoan : taikhoan , matkhau : matkhau , login :1 , a : 'm'},
ducnghia : function(result){
giaotiep(result);

}
});
}



function user(id,mod){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , mod : mod , thongtin :1 , a :'chucnang'},
ducnghia : function(result){
var x = $.parseJSON(result);

  $('#ducnghia_them').html(x.chucnang);

}
});
}


 

function canvas(nghiacntt,nghiadulieu,it){
    if(!it) {
    c_giaotiep();
    }
    if(nghiacntt=="" || nghiacntt =="null" ) {
        nghiacntt = 'PokeMon';
    }
    	$('#canvas_game').html(nghiacntt);	
    	$('#canvas_data').html(nghiadulieu);	

                         document.getElementById('canvas').style.display = 'block';

}

function c_canvas(){
                         document.getElementById('canvas').style.display = 'none';

}

function attack_pk(nghiaattackname){
     c_menu();
    c_giaotiep();
    c_canvas();
                  	$('#infotran').html(nghiaattackname);	
              document.getElementById('nghiait_att').style.display = 'block';
     // $('#nghiait_att').toggle('fast','linear');  
               
chiendau = 1;
ketnoi();
}

function c_attack(){
                     	$('#nghiait_att_data').html('');	

                  	$('#infotran').html('');	
               document.getElementById('nghiait_att').style.display = 'none';
                    // $('#nghiait_att').toggle('fast','linear');  

chiendau = 0;
    ketnoi();
}




function pk(){
 c_menu();
    c_giaotiep();
    c_canvas();
                  	$('#infotran').html('PVP ONLINE');	
               document.getElementById('nghiait_att').style.display = 'block';

	$('#nghiait_att_data').load('/_nodejs/pvp.php');
	
}

function pkok() {
    $.nghia({
url : code(),
type : 'POST',
data : {load :1 , a :'pvp'},
ducnghia : function(result){
var nghia = $.parseJSON(result);
if(nghia.pk==1) {
    pk();
} else {
    giaotiep('Có lỗi xẩy ra : có thể trận không tồn tại hoặc hết thời gian chờ.');
}
}
});
}

function moipk(id) {
   $.nghia({
url : code(),
type : 'POST',
data : {id : id , moi :1 , a : 'pvp'},
ducnghia : function(result){
giaotiep(result);
if(result=="Xin chờ đối thủ đồng ý.") {
    socket.emit("pvp_moi", id);
    
}
}
});
}

function dongy(){
      $.nghia({
url : code(),
data : {dongy :1 , a :'pvp'},
type : 'POST',
ducnghia : function(result){
    if(result>="1") {
        pk();
    socket.emit("pvp_ok", result);
        
    }else {
giaotiep(result);
}

}
});
}

function tuchoi(){
      $.nghia({
url : code(),
data : {huybo :1 , a :'pvp'},
type : 'POST',
ducnghia : function(result){
giaotiep(result);
}
});
}


////ducnghia

function out(){
            map();

    khach();
    userID = 0;
    socket.emit("out", 'OUTGAME'); 

}









function ketnoi() {
  
    
    chaybo = chaybo+1;
if(userID >=0 && userSprite ) {
var ducnghiacxz = "";
			ducnghiacxz = "/ducnghia^"+userID+"^" + mapID +"^"  + userEvent.mapPosition.X +"^"  + userEvent.mapPosition.Y +"^"  + userEvent.direction +"^"+chiendau+"^"+userName+"^"+userSprite+"^"+clan_icon+"^"+clan_viettat+"^"+tagAlong+".png^"+setexp+"^"+setxu+"^"+camxuc+"";			
    socket.emit("Move", ducnghiacxz);

}
}


function table(){
 document.getElementById('table_game').style.display = 'block';

}
function c_table(){
 document.getElementById('table_game').style.display = 'none';

}


////done

function pokemon(id){
$.nghia({
url : code(),
type : 'POST',
data : {id : id , pokemon :1 , a:'chucnang'},
ducnghia : function(result){
var nghia = $.parseJSON(result);
table();
	$('#table_game').html(nghia.data);	
}
});
}


function ttnv(id,modal){

$.nghia({
url : code(),
type : 'POST',
data : {id : id , thongtin :1 , a : 'chucnang'},
ducnghia : function(result){
var nghia = $.parseJSON(result);
table();
	$('#table_game').html(nghia.data);	


}
});
}

function shop(){
 c_giaotiep();
    $.nghia({
url : code(),
type : 'POST',
data : {shop:1,a:'x'},

ducnghia : function(result){
table();
	$('#table_game').html(result);	
    
}
});
}  

function wsgo(nut) {
    if(nut ==1) keyState.up = true;
    if(nut ==2) keyState.left = true;
    if(nut ==3) keyState.right = true;
    if(nut ==4) keyState.down = true;
	if(nut==5) keyState.btn1 = true;
	
	setTimeout(function(){ 
	    		keyState.up = false;
	    		keyState.left = false;
	    		keyState.right = false;
	    		keyState.down = false;
	    		keyState.btn1 = false;
	}, 50);

}







function daocamap(id){
    $.nghia({
url : code(),
type : 'POST',
data : {id : id , dao :1 , a :'m'},

ducnghia : function(result){
if(result=="nghia") {
    map('daocamap',21,8,'daocamap');
} else {
    giaotiep(result);
}
    
}
});
}  
	

function giftcode(){
c_giaotiep();
$.nghia({
url : code(),
data : {giftcode :1 , a : 'm'},
type : 'POST',

ducnghia : function(result){
document.getElementById('menu_nho').style.display = "block";
  $('#menu_nho').html(result);

}
});
}  
function cl() {
  document.getElementById('menu_nho').style.display = "none";
  
}


function nhapcode(){
    	var macode = $('#macode').val();
    	    
$.nghia({
	url : code(),
	type : 'POST',
	data : {macode : macode , a : 'c'},
	ducnghia : function(result){
	var x = $.parseJSON(result);
		    						  		       
		$('#tb_giftcode').html(x.thongbao);
if(x.thongbao=="code:400-Thanh_cong") {
        nhanthuong(x.qua);

}
	}

});
} 



function trangbi(id) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id , ruong:1 , a:'tb'},
ducnghia : function(result){
					$("#trangbi").html(result);
				

}
});		
}

function trangbi_xem(id,pokemon) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id , pokemon : pokemon , xem:1,a:'tb'},
ducnghia : function(result){
					$("#trangbi").html(result);
				

}
});		
}

function trangbi_mac(id,idpkm) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id , pokemon : idpkm , mac:1, a:'tb'},
ducnghia : function(result){
giaotiep(result);
pokemon(idpkm);
trangbi(idpkm);
}
});		
}

function trangbi_thao(id,idpkm) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id , pokemon : idpkm,thao:1,a:'tb'},
ducnghia : function(result){
giaotiep(result);
pokemon(idpkm);
trangbi(idpkm);

}
});		
}

function trangbi_xoa(id,idpkm) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id , pokemon : idpkm,xoa:1,a:'tb'},
ducnghia : function(result){
giaotiep(result);
trangbi(idpkm);

}
});		
}

  function tinhluyen(){
c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data:{ruongdo:1,a:'tb'},

ducnghia : function(result){

canvas('Tinh Luyện',result);
}
});
}  


function tinhluyen_chon(id) {
	 $.nghia({
url : code(),
type : 'POST',
data : {id : id,chon:1,a:'tb'},
ducnghia : function(result){
canvas('Tinh Luyện',result);

}
});		
}

function tinhluyen_ok(id){
          $('#ducnghia_s').hide();  

         $.nghia({
url : code(),
type : 'POST',
data : {id : id , ok:1,a:'tb'},

ducnghia : function(result){

			    		$("#ducnghia_cofe").addClass('cofe');
setTimeout(function(){ 
	    		 $("#ducnghia_cofe").removeClass('cofe');
          $('#ducnghia_s').show();  
giaotiep(result);
if(result=="Chúc mừng nhóc nhé.") {
   tinhluyen_chon(id); 
}
	}, 1000);  
}
});
     }  
     
     
function tienhoapokemon(id,idmy) {
              $('#ducnghia_s').hide();  

$.nghia({
url : code(),
data : {a:'q',tienhoa:1,id:id,idmy:idmy},

type : 'POST',
ducnghia : function(result){
	$("#ducnghia_cofe").addClass('cofe');
setTimeout(function(){ 
	    		 $("#ducnghia_cofe").removeClass('cofe');
          $('#ducnghia_s').show();  
giaotiep(result);
if(result=="Chúc mừng bạn nhé.") {
c_canvas();
    
}
	}, 1000);  
}


});   
  }          


function goirong(id) {
	 $.nghia({
url : '/datalog/rongthan.php?goi',
type : 'POST',
data : {id : id},
ducnghia : function(result){
var xx = $.parseJSON(result);
giaotiep(xx.giaotiep);
					$("#npc_menu").html(xx.menu);
					if(xx.code==1) {
   rongthan=1; }


}
});		

}


function cp() {
	 $.nghia({
url : '/xml/admin.php?admin',
type : 'POST',
ducnghia : function(result){
canvas('ADMIN',result);
}
});		
}


function cp_chon(name) {
	 $.nghia({
url : '/xml/admin.php?tool',
type : 'POST',
data : {mapID : mapID , x : userEvent.mapPosition.X, y : userEvent.mapPosition.Y, name : name , di : userEvent.direction},
ducnghia : function(result){

canvas('ADMIN',result);

}
});		

}


function adminad(name){
    $.nghia({
            	       	url         : '/xml/admin.php?'+name+'',
    	            	type        : 'POST',
    	            	data        : $("#admin").find("select, textarea, input").serialize(),
                  	ducnghia : function(result){
giaotiep(result);
fixloi(result);
    	            	}
    	        	});
}



function taixiu(){
	 $.nghia({
url : code(),
data : {a : 'taixiu'},
type : 'POST',
ducnghia : function(result){

canvas('VÒNG QUAY MAY MẮN',result,1);

}
});		

}


function datcuoc(){
    $.nghia({
            	       	url         : code(),
    	            	type        : 'POST',
    	            	data        :  {   a :'taixiu'  , cuoc : 1},
                  	ducnghia : function(result){
giaotiep(result);
taixiu();
    	            	}
    	        	});
}


function tho(){
         $.nghia({
url : '/datalog/sukien.php?tho',
type : 'POST',

ducnghia : function(result){
if(result=="Bánh trung thu.") {
    setdrawn(0,0,result,0,0);

    pet('');
}else {
giaotiep(result);
}
}
});
     }   

function dan(id) {
 $.nghia({
url : '/datalog/sukien.php?dan',
type : 'POST',
data : {id : id},

ducnghia : function(result){
if(result=="1") {
        	        	pet('tho');
        	        	c_giaotiep();
}else {
giaotiep(result);
}
}
});
     }   



function setdrawn(xu,exp ,stext,vp,no) {
   
    setvatpham = vp;
    setwin = no;
    textset = stext;
    setxu = tron(xu);
    setexp = tron(exp);
    timeset=0;
    offhieuung =1;
}

function dctgiapninja(mapabc,abcid){
   
    for(var i=0;i< mmoUsers.length;i++) {
        if(abcid==mmoUsers[i].id) {
       
          map(mapabc,mmoUsers[i].x,mmoUsers[i].y);
        } else {
            giaotiep('không hoạt động....');
        }
console.log(mmoUsers[i]);
			}
		
			c_canvas();
}


function outkick(acc) {
    if(acc<=0) {
        giaotiep('Kết nối thất bại ! máy chủ bảo trì hoặc mất kết nối ! Vui lòng đăng nhập lại.');
         setTimeout(function() {
              location.reload();

    }, 3000);
    } else {
        if(acc==userID) {
        giaotiep('Bạn bị ngắt kết nối tới máy chủ.Vui lòng đăng nhập lại.');
         setTimeout(function() {
              location.reload();

    }, 3000);      
        }
    }
}


function tangsao(){
    c_giaotiep();
	 $.nghia({
url :code(),
type : 'POST',
data : {a:'s',ruongdo:1},
ducnghia : function(result){

canvas('TĂNG SAO',result);

}
});		

}

function chontangsao(id){
    c_giaotiep();
	 $.nghia({
url : code(),
type : 'POST',
data : {id :id, chon:1,a:'s'},
ducnghia : function(result){

canvas('TĂNG SAO',result);

}
});		

}

function tangsao_ok(id){
    c_giaotiep();
          $('#ducnghia_s').hide();  

         $.nghia({
url : code(),
type : 'POST',
data : {id : id,ok:1,a:'s'},

ducnghia : function(result){

			    		$("#ducnghia_cofe").addClass('cofe');
setTimeout(function(){ 
	    		 $("#ducnghia_cofe").removeClass('cofe');
          $('#ducnghia_s').show();  
giaotiep(result);
if(result=="Chúc mừng nhóc nhé.") {
  c_canvas();
}
	}, 1000);  
}
});
     }
     
     function npc(id,textg){
      npcid = id;
 npctext = textg;
 npctime = 50;    

     }
     
     
     function cauhoi() {

        $.nghia({
url : '/datalog/cauhoi.php?lay',
type : 'POST',
data : {id :id},
ducnghia : function(result){
    	var x = $.parseJSON(result);

   giaotiep(xx.giao);
        	$("#npc_menu").html(xx.menu);

}
});		  
     }
     
function gop_giatoc(){
$.nghia({
url : code(),
type : 'POST',
data : {a : 'gt', gop :1},

ducnghia : function(result){
  $('#menu_nho').html(result);
    document.getElementById('menu_nho').style.display = "block";

}
});
}     

function giatoc_gop(id){
            	var sotien = $('#sotien').val();

$.nghia({
url : code(),
type : 'POST',
data : {id : id , sotien : sotien , gopa :1 , a :'gt'},

ducnghia : function(result){
giaotiep(result);
}
});
}     



function giatoc_shop(){
c_giaotiep();
$.nghia({
url : code(),
type : 'POST',
data : {shop :1 , a : 'gt'},

ducnghia : function(result){
canvas('SHOP GIA TỘC',result);
}
});
} 

function giatoc_shop_xem(id){
$.nghia({
url : code(),
type : 'POST',
data : {id : id , a:'gt', xem :1},

ducnghia : function(result){
  $('#menu_nho').html(result);
    document.getElementById('menu_nho').style.display = "block";

}
});
} 

function giatoc_tang(id){
            	var thanhvien = $('#thanhvien').val();

$.nghia({
url : code(),
type : 'POST',
data : {id : id , thanhvien : thanhvien , tang :1 , a:'gt'},

ducnghia : function(result){
giaotiep(result);
}
});
}     
     
     setInterval(function(){
if(userID >=1) {
    ketnoi();
}

//////auto////
 var timeat = $('#time_auto').html();
 var auto = $('#auto').html();
 var chien = $('#chien').html();

  if(auto == '1'){
    if(timeat >= '1') {
            if(chien=='0') {
 //lấy data tạm
 $.nghia({
url : code(),
type : 'POST',
data: {a :'pk', map : mapID , x :userEvent.mapPosition.X ,y : userEvent.mapPosition.Y , auto :1 },

ducnghia : function(result){
    		var x = $.parseJSON(result);

    if(x.name !="undefined") {
ducnghia_att_pk();
    		$("#chien").html('1');
}
}

});
}
}
}

////xxxx

var timeat = $('#time_auto').html();
 var auto = $('#auto').html();
 var chien = $('#chien').html();



  if(auto == '1'){
    if(timeat >= '1') {
            if(chien=='1') {
 auto2();
}
}
}

},3000);


