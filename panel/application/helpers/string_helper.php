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
