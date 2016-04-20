<?php 

Validator::extend('longitud_latitud', function($attribute, $value)
{
	return preg_match('/^[+-]?[0-9]{1,9}(?:\.[0-9]{1,25})?$/u', $value);

});