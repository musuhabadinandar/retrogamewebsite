<?PHP
if(isset($_POST[my])) {
   $check_nv = new nhiemvu($datauser->nhiemvu->nhiemvu);

          $check_ten_npc = mysql_fetch_assoc(mysql_query("SELECT * FROM `npcs` WHERE `id` = '".$check_nv->ducnghia->npc."'  "));
          $check_map = mysql_fetch_assoc(mysql_query("SELECT * FROM `maps` WHERE `id` = '$check_ten_npc[map]'  "));

        	
          	          	 if($datauser->nhiemvu->id>0) {
          	          	     
          	   if($datauser->nhiemvu->song >=$datauser->nhiemvu->can){
          	       $trangthai = '[SONG]';
          	   }       	      else {           	       $trangthai = '[ĐANG LÀM]';}
          	   
       	  if($check_nv->ducnghia->ruby>=1) {
       	      $thuong .=','.$check_nv->ducnghia->ruby.' Ruby,';
       	  }
       	  
 	if(!empty($check_nv->ducnghia->vatpham)) {
foreach(explode(',',$check_nv->ducnghia->vatpham) as $vatpham)
{
    $soluong = explode(':',$vatpham);
    $datauser->setvatpham($soluong[0],$soluong[1]);
      $shopvatpham=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id` ='".$soluong[0]."' "));

$thuong .=$shopvatpham[tenvatpham].'*'.$soluong[1].',';
}

	   	    } 
if(!empty($check_nv->ducnghia->item)) {
foreach(explode(',',$check_nv->ducnghia->item) as $vatpham)
{
    $soluong = explode(':',$vatpham);
    $datauser->setitem($soluong[0],$soluong[1]);

$thuong .=$soluong[0].'*'.$soluong[1].',';
}

	   	    }	   	          	  
       	  
       	  if($check_nv->ducnghia->loai=="pokemon") {
       	                $ck = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id` = '".$check_nv->ducnghia->pokemon."'  "));

       	      $mapxxx = '- <B>'.t('đánh bại').'</b>  : <font color="red">'.$ck[naam].' <img src="/images/pokemon/icon/'.$ck[wild_id].'.gif"></font> ';
       	  }
          	     
          	     
                 $x[ducnghia] = '
                 <br> <big><center>'.t($check_nv->ducnghia->ten).'</center>
               -  '.t($check_nv->ducnghia->text).' <br>
               <font color="green">- '.t('Tiến trình').' '.$datauser->nhiemvu->song.'/'.$datauser->nhiemvu->can.' '.$trangthai.' </font> <br>
                              <font color="blue">- '.t('Phần thưởng').' :  </font>
                              
                           <br> <b class="viptxt"><font color="black">
                '.$check_nv->ducnghia->xu.' xu,'.$check_nv->ducnghia->{'exp'}.' '.t('Kinh nghiệm').'
                '.$thuong.'</font></b>  <br>
                
                - <b>'.t('Nơi nhận').'</b> : <b><font color="04B4AE">'.t($check_ten_npc[name]).'</font> - <font color="B404AE">'.t($check_map[ten]).'</font></b>
<br> '.$mapxxx.'
                </big> </div>';

} else {
    if($check_nv->id !=0) {
        $msg_chua = '<br><big><center>'.$check_nv->ducnghia->ten.'</center></font><hr> <br> Hãy đến gặp <b><font color="04B4AE">'.$check_ten_npc[name].'</font> - <font color="B404AE">'.$check_map[ten].'</font></b><hr></center><big>';
    } else {
        $msg_chua = 'Tạm thời chưa có nhiệm vụ...';
    }
    
    $x[ducnghia] = ''.$msg_chua.'';
 
}

}

if(isset($_POST[tranv])) {
           $x[menu] = '';

          	$check_nv = new nhiemvu($datauser->nhiemvu->nhiemvu);
          	 if($datauser->nhiemvu->song >=$datauser->nhiemvu->can AND $datauser->nhiemvu->id >0) {
          	     
                       			mysql_query("UPDATE users SET `xu` = `xu` + '".$check_nv->ducnghia->xu."', `ruby` = `ruby` + '".$check_nv->ducnghia->ruby."', `exp` = `exp` + '".$check_nv->ducnghia->{'exp'}."' WHERE id='".$_SESSION['id']."'");
                       			$cong =$datauser->nhiemvu->nhiemvu+1;
                $datauser->nhiemvu('nhiemvu',$cong);
                $item.='';
     	if(!empty($check_nv->ducnghia->vatpham)) {
foreach(explode(',',$check_nv->ducnghia->vatpham) as $vatpham)
{
    $soluong = explode(':',$vatpham);
    $datauser->setvatpham($soluong[0],$soluong[1]);
      $shopvatpham=mysql_fetch_array(mysql_query("SELECT * FROM `shopvatpham` WHERE `id` ='".$soluong[0]."' "));

$item .=$shopvatpham[tenvatpham].'*'.$soluong[1].',';
}

	   	    } 
	   	 $km.='';   
if(!empty($check_nv->ducnghia->item)) {
foreach(explode(',',$check_nv->ducnghia->item) as $vatpham)
{
    $soluong = explode(':',$vatpham);
    $datauser->setitem($soluong[0],$soluong[1]);

$km .=$soluong[0].'*'.$soluong[1].',';
}

	   	    }	   	    
                
                

       	  
       	  if($check_nv->ducnghia->ruby>=1) {
       	      $ruby=','.$check_nv->ducnghia->ruby.' Ruby.';
       	  } else {
       	      $ruby = '';
       	  }

          	     
          	     
                $x[text] = ''.t($check_nv->ducnghia->text2).'';
$datauser->nhiemvu('id',0);
        $x[npc] = $check_nv->ducnghia->npc;
       
       $x[xu] = $check_nv->ducnghia->xu;
              $x['exp'] = $check_nv->ducnghia->{'exp'};
              $x['item'] = $item.$ruby.'';
              $x['tmhm'] = $tmhm.$km;

    $datauser->lichsu(' hoàn thành nhiệm vụ '.$check_nv->ducnghia->ten.'   ');

   } else {
                $x[text] = 'lỗi.....';

   }

    
}






if(isset($_POST[nhannv])) {
   
        	$ne = new nhiemvu($datauser->nhiemvu->nhiemvu);

      if($datauser->nhiemvu->id<=0) {
    $x[text] = t('Nhận nhiệm vụ thành công.');
        $x[menu] = '';
        $x[npc] = $check_nv[npc];


       $datauser->nhiemvu('id',$ne->id); 
       $datauser->nhiemvu('npc',$ne->ducnghia->npc);   
       $datauser->nhiemvu('ten',$ne->ducnghia->ten);   
       $datauser->nhiemvu('text',$ne->ducnghia->text);   
       $datauser->nhiemvu('loai',$ne->ducnghia->loai);  
       $datauser->nhiemvu('name',$ne->ten($ne->ducnghia->npc));   
       
       $datauser->nhiemvu('pokemon',$ne->ducnghia->pokemon);   
       $datauser->nhiemvu('song',0);   
       $datauser->nhiemvu('can',$ne->ducnghia->can);   
       
   } else {
         $x[text] = 'lỗi,bạn đang làm một nhiệm vụ nào đó....';
  
   }       

    
}

if(isset($_POST[docnv])) {
   
        $new = new nhiemvu($datauser->nhiemvu->nhiemvu);

      if($datauser->nhiemvu->id<=0) {
       $nhiemx .='<b onclick="nhannv()" class="viptxt nutchat">#'.t('Nhận nhiệm vụ').'</b>';
   }       
    $x[text] = t($new->ducnghia->text).'';
        $x[menu] = ''.$nhiemx.'';


    
}







if(isset($_POST[add])) {
  
          	    $get_nv = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_nhiemvu`  ORDER BY `nhiemvu` DESC LIMIT 1"));
$nnz = $get_nv[nhiemvu] + 1;
             mysql_query("INSERT INTO `ducnghia_nhiemvu` SET 
             `nhiemvu` = '".$nnz."'
             ");
             
           $add = new nhiemvu($nnz);
         $add->add('ten',$_POST['tennv']);  
         $add->add('text',$_POST['text']);  
         $add->add('text2',$_POST['nhiemvu']);  
         $add->add('npc',$_POST['npc']);  
         $add->add('loai',$_POST['loai']);  
         $add->add('pokemon',$_POST['pokemon']);  
         $add->add('can',$_POST['can']);  
         $add->add('xu',$_POST['silver']);  
         $add->add('exp',$_POST['exp']);  
         $add->add('ruby',$_POST['gold']);  
         $add->add('vatpham',$_POST['vatpham']);  
         $add->add('item',$_POST['item']);  
         
                 $x[msg] = 'done';


    }





echo json_encode($x);
die;