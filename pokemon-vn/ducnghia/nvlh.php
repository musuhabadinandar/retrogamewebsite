<audio width="300" height="32" src="/ducnghia/amthanh/nvlh.mp3" autoplay="autoplay"> </audio>
<script language="javascript">
	$(document).ready(function(){
		$('.ducnghiaVH').on('click','#ducnghiadz',function(){
				var soluong = $("#soluong").val();
				var ducnghia_nhanthuong = $("#ducnghia_nhanthuong").val();
				var ducnghia_nhan = $("#ducnghia_nhan").val();

			$.ajax({
				url: '/ajax_call/ducnghia_nvlh.php',
				type: 'POST',
				dataType: 'text',
				data: {
				    soluong : soluong,
					ducnghia_nhan: ducnghia_nhan,
															ducnghia_nhanthuong: ducnghia_nhanthuong

				},
				success: function(result){
					$('.ducnghiaVH').html(result);
				}
			});
			return false;
		});
	});
</script> 
 <div class="ducnghiaVH">


 <?php
 if(isset($_POST['ducnghia_nhan'])){
      	if($datauser['nv_th'] >=  10){
			echo '<div class="red">Ngày hôm Nay Cậu Đã làm 10 nhiệm vụ rồi ! hãy quay lại tìm tôi vào ngày mai !</div>';
	  	}else
	  	if($datauser['nv_th_yeucau'] !=  0){
			echo '<div class="red">Nhận cc gì lắm vậy ? tính bug à ? đi làm mẹ nhiệm vụ đi :v !</div>';
	  	}else
	  	
	  	
	  	{
        $yeucau = rand(1,50);
        	mysql_query("UPDATE `gebruikers` SET `nv_th_yeucau`='$yeucau',`nv_th_hientai`='0' WHERE `user_id`='".$_SESSION['id']."'");
        	echo '<div class="green">Nhận Nhiệm Vụ Thành Công ! Nhiệm Vụ của bạn là thắng '.$yeucau.' lần thám hiểm </div>';
	  	} }
	  	
	  	else 
	  	 if(isset($_POST['ducnghia_nhanthuong'])){
      	if($datauser['nv_th_hientai'] <  $datauser['nv_th_yeucau']){
			echo '<div class="red">hack cái qq nhé bạn !</div>';
	  	}else
	  	if($datauser['nv_th_yeucau'] < 1 AND  $datauser['nv_th_hientai'] < 1 ){
			echo '<div class="red">hack cái qq nhé bạn !</div>'; }
	  	else
	  	
	  	{
        $yeucau = rand(1,50);
        $gold = rand(1,3);
        $silver = rand(500,2000);
        $diemhoatdong = rand(1,3);
        	mysql_query("UPDATE `gebruikers` SET `nv_th_yeucau`='0',`nv_th_hientai`='0',`nv_th`=`nv_th`+'1',`gold`=`gold` + '$gold',`silver`=`silver` + '$silver',`diemhoatdong`=`diemhoatdong` + '$diemhoatdong' WHERE `user_id`='".$datauser['user_id']."'");
        	echo '<div class="green">hoàn thành nhiệm vụ thành công ! bạn nhận được '.$gold.' vàng,'.$silver.' bạc,'.$diemhoatdong.' điểm hoạt động  </div>';
	  	} }
 
 
 ?>
 <div class="content"><style>
.bubble {
background:#fff;
	border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius:6px;
	width:100%;
	box-shadow:0 0 5px #ccc;
	}
div.mega {
	width: 99%;
	color: #d63934;
	font-weight: bold;
	background: #dfcfbd;
	border: 1px solid #d63934;
	margin: 0px 0px 10px 0px;
	padding: 2px 2px 2px 2px;
	text-align:center;
	border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius:6px;
}
.error { background-color:#e83c37; width:99%; border:1px solid #eee;box-shadow:inset 0px 1px 0px 0px #953c3e, 0 0 5px #ccc;margin-bottom:10px;color:#fff;text-shadow:1px -1px #953c3e;text-align:right;padding-right:15px; }
.error h2 { text-align:center; }
</style>

<center>
<div class="bubble">
	<img src="/img/NVTH.jpg" style="background-image: url(img/backround.gif);width:280px;">
	<div style="border-top:1px solid #ccc; height:1px;"></div>
Xin Chào bạn ! tôi có 1 số công việc cần giao cho bạn đây ! bạn muốn làm hay không ? mỗi ngày làm đủ nhiệm vụ tôi sẽ tặng bạn <font color="red">3 điểm</font> hoạt động. Mỗi lần hoàn thành nhiệm vụ tôi sẽ tặng bạn 1 phần thưởng ngẫu nhiên !!<br/>
	Sau Khi hoàn thành nhiệm vụ rồi thì quay lại đây nhé ! sau 24h chưa song tôi xóa nhiệm vụ đi luôn à nha !!
	<div class="mega">
	     
<?php If($datauser['nv_th_hientai'] == 0 AND $datauser['nv_th_yeucau'] == 0 ) { echo'  <form method="post"><center><input type="submit" id="ducnghia_nhan" name="ducnghia_nhan" value="Nhận Nhiệm Vụ" id="ducnghiadz" class="button" /></center></form>' ; }
else $con = $datauser['nv_th_yeucau'] -  $datauser['nv_th_hientai'];
If($datauser['nv_th_yeucau'] != 0 AND $datauser['nv_th_yeucau'] > $datauser['nv_th_hientai']  ) { echo' <center>nhiệm vụ của bạn còn '.$con.' thắng trận thám hiểm</center>' ; }  else 
If($datauser['nv_th_hientai'] >= $datauser['nv_th_yeucau'] AND $datauser['nv_th_hientai'] !=0 AND $datauser['nv_th_yeucau'] !=0  ) { echo'  <form method="post"><center><input type="submit" id="ducnghia_nhanthuong" id="ducnghiadz" name="ducnghia_nhanthuong" value="Nhận Thưởng" class="button" /></center></form>' ; }




?>




<br/>	</div>
</div>
<hr>
<div>
<a href="?page=quest"><button class="button">Quay lại</button></a>
</div>
</center>
	
</div> </div>