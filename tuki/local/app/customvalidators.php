<?php 

Validator::extend('longitud_latitud', function($attribute, $value)
{
	return preg_match('/^[+-]?[0-9]{1,9}(?:\.[0-9]{1,25})?$/u', $value);
});

Validator::extend('valid_imagebase64', function($attribute, $value)
{
	list($type, $value) = array_pad(explode(';', $value, 2), 2, null);
	list(, $value) = array_pad(explode(',', $value, 2), 2, null);
	//list($type, $value) = explode(';', $value);
	//list(, $value)      = explode(',', $value);
	$decoded = base64_decode($value, true);
	// Check if there is no invalid character in string
	if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value)){		
		return false;
	}
	// Decode the string in strict mode and send the response
	if(!base64_decode($value, true)){
		return false;
	} 
	// Encode and compare it to origional one
	if(base64_encode($decoded) != $value){
		return false;
	}
	return true;
});

Validator::extend('date_greater_than_today', function($attribute, $value)
{
	$actualDate = date("Y-m-d");
	$date =  Helper::convertDateOne($value);
	return $date>$actualDate;
});

