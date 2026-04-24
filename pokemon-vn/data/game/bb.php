<?php


if(isset($_POST[ketban])) {
  
        $check233 = mysql_result(mysql_query("SELECT COUNT(*) FROM `ducnghia_banbe` WHERE `uid` = '$_POST[id]' AND `my` = '$user_id' "), 0);

        if($datauser->code->banbe->{$_POST[id]} <=0) {
            $datauser->setcode('banbe',$_POST[id],1);
                  // mysql_query("INSERT INTO `ducnghia_banbe` SET `my` = '{$user_id}',`uid` = '$_POST[id]' ");
                    echo t('Kết bạn thành công.');
		tinnhan(''.nick($user_id).' vừa thêm bạn vào danh sách bạn bè.',$giatoc[toctruong],'2');

        } else {
            echo t('bạn đã là bạn bè với người này rồi.');
        }
    
}
if(isset($_POST[banbe])) {
   
        
                      
if($g[soluong] !=0 AND $datauser->pokemon !='tho') {
        	$userx = new user($banbe[uid]);
	$map = new map($userx->map->id);
 $code =$map->code;
 $ns = '<button><font color="blue" onclick="dctgiapninja(\''.$code.'\','.$banbe[uid].')">[DỊCH CHUYỂN]</button></font> ';
}
        

    
  foreach ($datauser->code->banbe as $id => $soluong) {
    
				    echo '#['.$id.'] '.$o.''.nick($id).' <b><font color="red" onclick="xoa_banbe('.$id.')">[XÓA]</b></font> '.$ns.' <div class="kengang"></div>';

					}  
    
}


if(isset($_POST[xoa]))
{
    
          $id_xin = mysql_fetch_array( mysql_query("select * FROM `ducnghia_banbe` WHERE `uid` = '$_POST[id]' AND `my` = '".$user_id."'"));
if($datauser->code->banbe->{$_POST[id]}<=0) {
        echo t('Người này không là bạn với bạn.');
} else
 {
$datauser->xoacode('banbe',$_POST[id]);
        
        echo t('Đã loại bỏ người chơi này ra khỏi danh sách.');
        	

}
    
}