<?php
  ob_start(); 

	$language_array = array("en");
	$taal = array();
	
	if(isset($_GET['language']) && in_array($_GET['language'], $language_array)){
		setcookie("pa_language", $_GET['language'], time()+(60*60*24*365));
		header("Location: index.php?page=".$_GET['page']."");
	}
	else{
		if(isset($_COOKIE['pa_language']) && in_array($_COOKIE['pa_language'], $language_array)){
			//Language is wat jij hebt gekozen
			$_COOKIE['pa_language'] = $_COOKIE['pa_language'];
			}
		else{
			//Default language is Engels
			$_COOKIE['pa_language'] = 'en';
		}
		include('general/language-general-'.$_COOKIE['pa_language'].'.php');
	}
?>