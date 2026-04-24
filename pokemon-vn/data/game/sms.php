<?php

$usera = intval($_POST['user']);
$toi = $_SESSION[id];
if(!isset($_GET['all'])){
//sleep(1);
if(mb_strlen(trim($_POST['text'])) >0){
	if($datauser->level!=9999){

if(!mysql_num_rows(mysql_query("SELECT * FROM `chat_users` WHERE `user_id` = {$toi} AND `user_fr` = {$usera}"))) {
mysql_query("INSERT INTO `chat_users` SET `user_id` = {$toi}, `user_fr` = {$usera}"); 
    ///	$data['error'] = '  '.$usera.'  '.$_SESSION['id'].' Hãy mở lại chát ';

}
$last = mysql_fetch_assoc(mysql_query("SELECT `text`,`user_id` FROM `chat` WHERE ((`user_fr` = $usera AND `user_id` = $toi) OR (`user_fr` = $toi AND `user_id` = $usera)) ORDER BY `id` DESC LIMIT 1"));
$last1 = mysql_fetch_assoc(mysql_query("SELECT `user_id`,`text` FROM `chat` WHERE `user_fr` = $usera AND `user_id` = $toi ORDER BY `id` DESC LIMIT 1"));
if(($last['text'] != 'Đã vào room chat !') || ($last['text'] == 'Đã vào room chat !' && $last['user_id'] != $last1['user_id']) || $_POST['text'] != 'Đã vào room chat !'){
	if($_POST['text'] != 'Đã vào room chat !')
mysql_query("UPDATE `chat_users` SET `amount` = `amount`+1, `amountplus` = `amountplus`+1, `view` = 0, `time` = '".time()."' WHERE `user_id` = $toi AND `user_fr` = $usera");
mysql_query("UPDATE `chat_users` SET `view` = 1, `amountplus` = 0 WHERE `user_id` = $usera AND `user_fr` = $toi");
mysql_query("INSERT INTO `chat` SET `user_id` = $toi, `user_fr` = $usera, `time` = '".time()."', `text` = '".$_POST['text']."'");
}

	} else {
	mysql_query("UPDATE `chat_users` SET `view` = 1, `amountplus` = 0 WHERE `user_id` = $usera AND `user_fr` = $toi");
	$data['error'] = 'Đạt cấp 2 mới có thể chát.';
	}
} else {
mysql_query("UPDATE `chat_users` SET `view` = 1, `amountplus` = 0 WHERE `user_id` = $usera AND `user_fr` = $toi");
}
$data['msg_uid'] = $toi;
$data['msg_ufr'] = $usera;
$data['msg_count'] = mysql_num_rows(mysql_query("SELECT * FROM `chat_users` WHERE `user_fr` = $usera AND `view` = 0"));
$data['msg_count2'] = mysql_num_rows(mysql_query("SELECT * FROM `chat_users` WHERE `user_fr` = $toi AND `view` = 0"));
	    $get = mysql_query("SELECT * FROM `chat` WHERE (`user_fr` = $usera AND `user_id` = $toi) OR (`user_fr` = $toi AND `user_id` = $usera) ORDER BY `id` DESC LIMIT 10");
		$i = 1;
  while($got = mysql_fetch_assoc($get)){
  $data['msg'] .= '<div class="list-group-item-light"><span style="color:black;"><b>'.ducnghia_us($got['user_id']).'</b>:</span> '.nl2br(BBCODE($got['text'],1)).'</div><div class="kengang"></div>';
  $i++;
  }
 
} else {
	    $get = mysql_query("SELECT * FROM `chat` WHERE (`user_fr` = $usera AND `user_id` = $toi) OR (`user_fr` = $toi AND `user_id` = $usera) ORDER BY `id` DESC");
  while($got = mysql_fetch_assoc($get)){
  $data['msg'] .= '<div><span style="color:black;"><b>'.ducnghia_us($got['user_id']).'</b>:</span> '.nl2br(BBCODE($got['text'],1)).' <small style="color:blue;">'.display_date($got[time]).'</small></div>';
  }
}

if(!is_array($data))
	$data['error'] = 1;
echo json_encode($data);
die;
?>