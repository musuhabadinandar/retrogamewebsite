function myIcon(str) {
    var a = '<img src="/img/app/bbcode/';
    var b = '.gif" >';


str = str.replace(/\:d/g,	 a + "=)"  + b);
str = str.replace(/\:D/g,	 a + "=D"  + b);
str = str.replace(/\:p/g,	 a + "=D"  + b);

  	return str;
}

function MakeArray(n){
  this.length=n;
  for(var i=1; i<=n; i++) this[i]=i-1;
  return this
}

hex=new MakeArray(16);
hex[11]="A"; hex[12]="B"; hex[13]="C"; hex[14]="D";
hex[15]="E"; hex[16]="F";

function ToHex(x){   // Changes a int to hex (in the range 0 to 255)
  var high=x/16;
  var s=high+"";        //1
  s=s.substring(0,2);   //2 the combination of these = trunc funct.
  high=parseInt(s,10);  //3
  var left=hex[high+1]; // left part of the hex-value
  var low=x-high*16;    // calculate the rest of the values
  s=low+"";             //1
  s=s.substring(0,2);   //2 the combination of these = trunc funct.
  low=parseInt(s,10);   //3
  var right=hex[low+1]; // right part of the hex-value
  var string=left+""+right; // add the high and low together
  return string;
}

function fadeout(text){
stringcolor = '';
  text=text.substring(3,text.length-4);
                         // gets rid of the HTML-comment-tags
  color_d1=255;          // any value in 'begin' 0 to 255
  mul=color_d1/text.length;
  var j=1;
for(i=0;i<text.length;i++){
   color_d1=255*Math.sin(i/(text.length/3));
   // some other things you can try>>
   // "=255-mul*i" to fade out, "=mul*i" to fade in,
   // or try "255*Math.sin(i/(text.length/3))"
   color_h1=ToHex(color_d1);
   color_d2=mul*i;
   color_h2=ToHex(color_d2);
   color_d3=mul*(text.length-i);
   color_h3=ToHex(color_d3);

      j = i;

  if (text.substring(i,i+1) == '&')
  {
        for (j = i+1; j < text.length; j++)
        {
               if (text.substring(j,j+1) == ';') { break; }
        }
        if (j == text.length) { j = i; }
  }

  if (text.substring(i,i+1) == '<')
  {
        for (j = i+1; j < text.length; j++)
        {
               if (text.substring(j,j+1) == '>') { break; }
        }
        if (j == text.length) { j = i; }
  }

   stringcolor += "<FONT COLOR='#"+color_h3+color_h1+color_h2+"' >"+
                  text.substring(i,j+1)+'</FONT>';
         i = j;
}
return stringcolor;
}
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
$(document).on('click',function(event){
     var button = event.target;
 var ducnghia_n = button.id;
if(ducnghia_n =="fixloi" ||ducnghia_n =="chatConsole" || ducnghia_n =="playerList" || ducnghia_n =="gameChatBar"  || ducnghia_n =="messageBox" || ducnghia_n =="ducnghia_chat2" || ducnghia_n =="ducnghia_chat3" || ducnghia_n ==   "ducnghia_chat4" ) {
     	$("#gameChatBar").css("background-color", "#FFF");

 	$("#gameChatBar").css("z-index", "999");
	$("#gameChatBar").animate({
		opacity: 0.9
	});
	camdi = 1;
	if(tatc >=1) {
	          $('#chat_show').toggle('fast','linear');  
	          $('#chat_an').toggle('fast','linear');  
tatc =0;
	} 
count_chat = 0;
         	$("#count_chat").html(count_chat);

	
} else {
    camdi=0;
         	$("#gameChatBar").css("background-color", "rgba(0, 0, 0, 0)");

 	$("#gameChatBar").css("z-index", "0");
}
 
});



function chatMsg(ct) {

	ct = '<div>' + myIcon(ct) + '</div>'
	$("#chatConsole").html(ct + $("#chatConsole").html());
	
}

function fixloi(ct) {

	ct = '<div>' + ct + '</div>'
	$("#fixloi").html(ct + $("#fixloi").html());
	
}

function chatm(ct) {

	ct = '<div>' + ct + '</div>'
	$("#playerList").html(ct + $("#playerList").html());
	
}

function chatm0(ct) {
  if(ct.map==mapID) {
	ct = '<div>' + ct.username + ' : ' + ct.noidung + '</div>'
	$("#playerList").html(ct + $("#playerList").html());
  }
	
}