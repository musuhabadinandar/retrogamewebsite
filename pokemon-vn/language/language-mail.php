<?php
	$language_array = array("en");
	
	if(isset($_COOKIE['pa_language']) && in_array($_COOKIE['pa_language'], $language_array)){
		//Language is wat jij hebt gekozen
		$_COOKIE['pa_language'] = $_COOKIE['pa_language'];
	}
	else{
		//Default language is Engels
		$_COOKIE['pa_language'] = 'en';
	}
	include('mail/language-mail-'.$_COOKIE['pa_language'].'.php');
?>