<?php
	//ENGLISH BOX
	
	//Language things
	$lang['taalshort']    		= 'en';
	$lang['taalgeneral']  		= 'Canada';
	$lang['taal']         		= 'Canada';
	
	############################## SELL BOX #####################################
	if($page == 'sell-box'){
		//Alerts
		$txt['alert_too_low_rank'] = 'Xếp hạng quá thấp.';
		$txt['alert_not_your_pokemon'] = 'Đây không phải là pokemon của bạn.';
		$txt['alert_beginpokemon'] = 'Đây là pokemon bắt đầu của bạn, bạn có thể
\'t bán  anh ta.';
		$txt['alert_no_amount'] = 'Không có số tiền chèn.';
		$txt['alert_price_too_less'] = 'Pokemon quá rẻ, tối thiểu là <img src="images/icons/silver.png" title="Silver" />';
		$txt['alert_price_too_much'] = 'Pokemon quá đắt, tối đa là <img src="images/icons/silver.png" title="Silver" />';
		$txt['alert_pokemon_already_for_sale'] = 'Pokemon này đã được bán.
';
		$txt['alert_user_dont_exist'] = 'Người dùng không\'t Tồn Tại';
		$txt['alert_success_sell'] = 'Đã đặt thành công pokemon của bạn trên danh sách chuyển.';
		$txt['alert_too_much_on_transfer_1'] = 'Bạn\'ve đã';
		$txt['alert_too_much_on_transfer_2'] = 'pokemon trên danh sách chuyển nhượng.<br>Lấy danh sách đầu tiên từ danh sách chuyển.';
		
		//Screen
		$txt['pagetitle'] = 'Sell';
		$txt['sell_box_title_text_1'] = 'Bạn có chắc chắn muốn đặt';
		$txt['sell_box_title_text_2'] = 'Giảm giá mạnh?';
		$txt['sell_box_title_text_3'] = 'hiện đang có giá trị
';
		$txt['sell_box_title_text_4'] = 'bạc.<br /><br />
										 Bạn muốn bao nhiêu bạc
';
		$txt['sell_box_title_text_5'] = 'để bán?';
		$txt['keep_empty'] = 'Bạn có thể giữ trống.';
		
		$txt['sell_rules'] = '* Bạn có thể đặt pokemon của bạn trên danh sách chuyển đổi gấp 1,5 lần giá trị tối đa.<br />
							  * Giá tối thiểu là giá trị đáng giá.';
		$txt['button_sell_box'] = 'Sell';
	}
	
	######################## AREA MESSENGER ########################
	elseif($page == 'area-messenger'){
		//Alerts
		$txt['alert_no_message'] = 'Nothing insert.';
		
		//Screen
		$txt['pagetitle'] = 'Area messenger';
		$txt['area_messenger_title_text'] = 'Welcome '.$_SESSION['naam'].' on Area messenger.<br />
											 <span class="smalltext">Don\'t scold, spam or advertise, else you will be banned from the site.</span>';
		$txt['area_messenger_advertisement'] = 'Advertisement.<br />
											 <span class="smalltext">Please click on the ads.</span>';
		$txt['say'] = 'Say:';
		$txt['button_area_messenger'] = 'Submit';
		$txt['please_login_first'] = '! --- You have to be signed in to respond, press F5 when you\'re logged in --- !';
		$txt['footer_made_by'] = 'Made by Siteshark';
		$txt['footer_copyright'] = 'Copyright &copy; '.date('Y').' - Pokemon Browser MMO.com - All rights reserved';
	}
	
	############################## PREMIUM BOX #####################################
	elseif($page == 'area-box'){
		//Screen
		$txt['pagetitle'] = 'Premium';
		$txt['colorbox_text'] = 'Open this window again and this message will still be here.';
		$txt['prembox_title_text_1'] = 'You want to buy a';
		$txt['prembox_title_text_2'] = 'for account';
		$txt['prembox_title_text_3'] = 'price';
		
		$txt['call_text'] = '<div class="title_premium">Call</div>Here you can pay with the telefone.<br />
			 A computer will talk to you and say numbers to you. Type the numbers from the screen on your phone, when it\'s done, you have your pack.';
		$txt['call_button'] = 'Call now';
		$txt['paypal_text'] = '<div class="title_premium">Paypal</div>Here can you pay with Paypal.<br />
			Paypal is a online pay-method, you need a paypal account.';
		$txt['paypal_button'] = 'Paypal now';
		$txt['ideal_text'] = '<div class="title_premium">Ideal</div>
			Ideal is a pay-method. You can pay with your bank account.<br />
			With the following banks you can pay:<br />
			* ING<br />
			* ABM Amro<br />
			* Rabobank<br />
			* SNS<br />
			* Fortis<br />
			* Friesland Bank';
		$txt['ideal_button'] = 'Pay nu';
		$txt['wallie_text'] = '<div class="title_premium">Wallie</div>
			Here can you pay with a wallie card.<br />
			You can buy a wallie card at some shops, the most likely is Free Record Shop.';
		$txt['wallie_button'] = 'Wallie now';
	}
	
	############################## PREMIUM BOX IDEAL #####################################
	elseif($page == 'area-box-ideal'){
		//Screen
		$txt['title_text'] = 'You want to buy a '.$_SESSION['packnaam'].' pack for &euro;'.$info['kosten'].' with a bank payment. See here how:<br /><br />
								1. Go to your bank website.<br />
								2. Go to \'money transfer\'.<br />
								3. Insert at description:<br />
								<div style="padding-left:25px; float:left;">* Site: (<strong>Pokemon Browser MMO</strong>).</div><br />
								<div style="padding-left:25px; float:left;">* Username: (<strong>'.$_SESSION['naam'].'</strong>).</div><br />
								<div style="padding-left:25px;">* Packname: (<strong>'.$_SESSION['packnaam'].'</strong>).</div><br />
								4. Transfer <strong>&euro; '.$info['kosten'].'</strong> to <strong>56.09.35.803</strong>.<br />
								5. Ask a administrator (<strong>SV2011</strong>) to check of the payment is done.<br />
								If the payment is successfully, the administrator will give you your premium things.<br /><br />
								* Important! If you transfer money in the weekend, the money will be transfered on Monday.<br />
								* Transfer the whole amount.';
	}
	
	############################## TRANSFERLIST BOX #####################################
	elseif($page == 'transferlist-box'){
		//Alerts
		$txt['alert_sold'] = 'được bán hoặc nhận được từ danh sách chuyển nhượng của chủ sở hữu.
';
		$txt['alert_too_low_rank_1'] = 'phải đợi, thứ hạng của bạn quá thấp
.<br><br>Với thứ hạng bạn hiện đang ở cấp độ';
		$txt['alert_too_low_rank_2'] = 'là số tiền tối đa bạn có thể mua.';
		$txt['alert_house_full'] = 'bạn\'nhà lại đầy.';
		$txt['alert_too_less_silver'] = 'Bạc quá ít.';
		
		//Screen
		$txt['pagetitle'] = 'Transferlist';
		$txt['trbox_title_text_bought_1'] = 'Xin chúc mừng với pokemon mới của bạn!';
		$txt['trbox_title_text_bought_2'] = 'Bạn có';
		$txt['trbox_title_text_bought_3'] = 'Đã mua thành công';
		$txt['trbox_title_text_bought_4'] = 'bây giờ đang ở trong nhà bạn!';
		
		$txt['trbox_title_text_1'] = 'Mua';
		$txt['trbox_title_text_2'] = 'Ở';
		$txt['trbox_title_text_3'] = '....';
		$txt['trbox_title_text_4'] = 'đáng.';
		$txt['trbox_title_text_5'] = 'là để bán cho giá';
		$txt['trbox_title_text_6'] = 'Bạn có chắc bạn muốn';
		$txt['trbox_title_text_7'] = '?';
		$txt['button_transferlist_box'] = 'Mua';
	}