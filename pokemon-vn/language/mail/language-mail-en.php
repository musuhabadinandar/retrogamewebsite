<?php
	//NEDERLANDS MAIL
	
	//Register
	$txt['mail_register_title'] = 'Activation';
	$txt['mail_register'] = 'Welkom op Pokemon Area '.$voornaam.' '.$achternaam.'!<br>
								<br> 
								Je activatiecode is: <b>'.$activatiecode.'</b><br>
								Je kunt je account hier activeren: <a href="/?page=activate&player='.$inlognaam.'&code='.$activatiecode.'" target="_blank">
								/?page=activate&player='.$inlognaam.'&code='.$activatiecode.'</a><br>
								<br>
								Je inlognaam is: <b>'.$inlognaam.'</b><br>
								Je wachtwoord is: <b>'.$wachtwoord.'</b><br>
								*Bewaar deze e-mail goed, deze informatie kan nog eens van pas komen.<br>
								<br>
								Wij wensen je veel speelplezier, en probeer niet vals te spelen!<br>
								<br>
								Met vriendelijke groet,<br>
								Pokemon Browser MMO Team';
								
	//Contact
	$txt['mail_contact'] = $bericht;
	
	//Forgot username
	$txt['mail_forgot_username_title'] = 'PokeMon Việt Nam 2018';
	$txt['mail_forgot_username'] = 'xin chào '.$gegeven['voornaam'].' '.$gegeven['achternaam'].'!<br><br>
								có phải bạn vừa quên tài khoản ! tài khoản của bạn là: <strong>'.$gegeven['username'].'</strong><br><br>
									hãy bảo quản kĩ thông tin của mình! ;)<br><br>
								nếu như không phải bạn yêu cầu lấy tài khoản,vui lòng bỏ qua email này,vui lòng không trả lời lại email<br>
									Cộng Đồng PokeMon Việt Nam';
									
	//Forgot password
	$txt['mail_forgot_password_title'] = 'Pokemon Browser MMO Nieuw Wachtwoord';
	$txt['mail_forgot_password'] = 'Beste '.$gegeven['voornaam'].' '.$gegeven['achternaam'].'!<br><br>
									Je hebt een nieuw wachtwoord opgevraagd, dit is: <b>'.$nieuwww.'</b><br><br>
									*Je kunt je wachtwoord in het spel weer veranderen;<br>
									1. Inloggen met je nieuwe wachtwoord<br>
									2. Account opties<br>
									3. Wachtwoord<br><br>
									Probeer je wachtwoord dan wel te onthouden!<br><br>
									Met vriendelijke groet,<br>
									Pokemon Browser MMO Team';
									
	//Premium Shop
	$txt['mail_premiumshop_title'] = 'Pokemon Area Premium Shop';
	$txt['mail_premiumshop_password'] = 'Beste '.$voornaam.' '.$achternaam.',<br><br> 
									Je hebt een <b>'.$packnaam.'</b> gekocht ter waarde van &euro;'.$packkosten.'<br>
									Bewaar deze mail goed, dit geldt als een betalingsbewijs.<br><br>
									Veel plezier hiermee!<br><br>
									Met vriendelijke groet,<br>
									Pokemon Browser MMO Team';