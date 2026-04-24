<?PHP


if(isset($_POST[quay])) {
  echo'Phiên bản thử nghiệm không có tính năng này.
Nâng cấp phiên bản vui lòng liên hệ <br>
<a href="//fb.com/ducnghiast">DUCNGHIA</a>';
}


if(isset($_POST[show])) {
echo'<br><br><br><center><div id="phanthuong" class="none"></div>
<div id="error" class="error none">Bạn không có 3 ruby hoặc chưa đủ level 10.</div>
<ul class="play">
   <li class="mm m1 box"><font size="1">Exp</font></li>
    <li class="mm m2 box"><img src="/images/pokemon/10362.gif" width="25">
</li>
    <li class="mm m3 box"><img src="/images/items/Attack_Psychic.png" width="30"></li>
	<div>
    <li class="mm m8 box"><font size="1">Xu</font></li>
	
<span class="btn" id="quay" onclick="quaynao('.$id.')" style="margin-top:20px;margin-right: 11px;margin-left: 20px; width: 56.43px">Quay</span>	
    <li class="mm m4 box"><img src="/images/_/10.png" width="30"></li>
	</div>
    <li class="mm m7 box"><img src="/images/items/keo.png"></li>
    <li class="mm m6 box"><font size="1"><img src="/images/_/9.png" width="30"></font></li>
    <li class="mm m5 box active"><img src="/images/items/Master%20ball.png"></li>
	<div class="result"></div>
</ul>
</center>';
}