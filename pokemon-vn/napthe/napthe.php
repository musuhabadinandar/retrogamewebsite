<?php
include_once('../templates/config.php');
include_once('../templates/ducnghia.php');
	include_once('../templates/lib.php');

//Láº¥y thÃ´ng tin tá»« Gamebank táº¡i https://sv.gamebank.vn/user/tich-hop-the-cao
$merchant_id = getenv('POKEMON_CARD_MERCHANT_ID') ?: ''; // interger
$api_user = getenv('POKEMON_CARD_API_USER') ?: ''; // string
$api_password = getenv('POKEMON_CARD_API_PASSWORD') ?: ''; // string

$localCredentials = __DIR__ . '/credentials.local.php';
if (is_file($localCredentials)) {
    require $localCredentials;
}

if ($merchant_id === '' || $api_user === '' || $api_password === '') {
    echo json_encode(array('code' => 1, 'msg' => 'Card charging is not configured on this environment.'));
    exit();
}

//Truyá»n dá»¯ liá»‡u tháº»
$pin = $_POST['pin']; // string
$seri = $_POST['seri']; // string

$price_guest = $_POST['price_guest']; // interger
$card_type = $_POST['card_type_id']; // interger
$note = $_POST['note'];
$captcha = $_POST['ma_bao_mat'];

/**
 * Card_type = 1 => Viettel
 * Card_type = 2 => Mobiphone
 * Card_type = 3 => Vinaphone
 * Card_type = 4 => Gate
 * Card_type = 5 => VTC (vcoin)
 * Card_type = 6 => Vietnammobile
 * Card_type = 7 => Zing
 * Card_type = 8 => Bit
 * Card_type = 9 => Megacard
 * Card_type = 10 => Oncash
 
**/

require_once 'securimage/securimage.php';
$securimage = new Securimage();

if ($securimage->check($captcha) == false) {
     echo json_encode(array('code' => 1, 'msg' => "Sai mÃ£ báº£o máº­t"));
     exit();
}

$return = cardCharging($seri,$pin,$card_type,$price_guest,$note,$merchant_id,$api_user,$api_password);

// nap the thanh cong
if($return['code'] === 0 && $return['info_card'] >= 10000) {
    $tien =  $return['info_card'];
    if($tien=="10000") {
        $ruby = '20';
    }
     if($tien=="20000") {
        $ruby = '50';
    }
     if($tien=="30000") {
        $ruby = '75';
    }
      if($tien=="50000") {
        $ruby = '160';
    }
     if($tien=="100000") {
        $ruby = '350';
    }
     if($tien=="200000") {
        $ruby = '950';
    }
    if($tien=="300000") {
        $ruby = '2500';
    }
    
        $user->ducnghia->naplandau =  1;
        $user->ducnghia->tongnap =  $user->ducnghia->tongnap+$tien;
        $user->ducnghia->tongruby =  $user->ducnghia->tongruby+$ruby;
$rb = $ruby*1;
            mysql_query("UPDATE users SET ruby = ruby  + '$rb',`ducnghia` = '" . json_encode($user->ducnghia) . "' WHERE id='$user_id'");

   
       echo json_encode(array('code' => 0, 'msg' => "Nap thanh cong ".$tien." VND.Ban nhan duoc ".$ruby." Ruby vao tai khoan. "));
 
}
else {
    // get thong bao loi
    echo json_encode(array('code' => 1, 'msg' => $return['msg']));
}

function _isCurl()
{
	return function_exists('curl_version');
}

function cardCharging($seri,$pin,$card_type,$price_guest,$note,$merchant_id,$api_user,$api_password)
{
	if (_isCurl()) {
		$fields = array(
			'merchant_id' => $merchant_id,
			'pin' => $pin,
			'seri' => $seri,
			'price_guest' => $price_guest,
			'card_type' => $card_type,
			'note' => $note
		);
		$ch = curl_init("https://sv.gamebank.vn/api/card");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_USERPWD, $api_user . ":" . $api_password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		$result = json_decode($result);

		$return = array(
			'code' => $result->code,
			'msg' => $result->msg,
			'info_card' => $result->info_card,
			'transaction_id' => $result->transaction_id,
		);
		
	} else {
		//TrÆ°á»ng há»£p mÃ¡y chá»§ chÆ°a báº­t cURL
		$result =  file_get_contents("http://sv.gamebank.vn/api/card2?merchant_id=".$merchant_id."&api_user=".trim($api_user)."&api_password=".trim($api_password)."&pin=".trim($pin)."&seri=".trim($seri)."&card_type=".intval($card_type)."&price_guest=".$price_guest."&note=".urlencode($note)."");   
		$result = str_replace("\xEF\xBB\xBF",'',$result); 
		$result = json_decode($result);
		$return = array(
			'code' => $result->code,
			'msg' => $result->msg,
			'info_card' => $result->info_card,
			'transaction_id' => $result->transaction_id,
		);
	}
	return $return;
}
