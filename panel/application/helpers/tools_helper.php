<?php

function converToSEO($text){
	$turkce = array("ç", "Ç", "ğ", "Ğ", "ü", "Ü", "ö", "Ö", "ı", "İ", "ş", "Ş", ".", ",", "!", "'", "\"", " ", "?", "*", "_", "|", "=", "(", ")", "[", "]", "{", "}", "#");
	$convert    = array("c", "c", "g" ,"g", "u", "u", "o", "o", "i", "i", "s", "s", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-");
	return strtolower(str_replace($turkce, $convert, $text));
}

function option_result($option1, $equal)
{   // kullanıcının cinsiyet bilgisine göre seçili olan alanı döndüren fonksiyon.
	return ($option1 == $equal) ? 'selected' : '';
}

function get_active_user(){
	$t = &get_instance();
	$user = $t->session->userdata("user");

	if ($user){
		return $user;
	}else{
		return false;
	}
}

function get_match($regex,$content)
{
	if (preg_match($regex,$content,$matches)) {
		return $matches[0];
	} else {
		return null;
	}
}

function isAdmin(){
	$t = get_instance();

	$user = $t->session->userdata("user");
	if($user->class == "admin")
		return true;
	else
		return false;

}

