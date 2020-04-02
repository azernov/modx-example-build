<?php
$matches = array();
$input = str_replace(array('(',')','+',' ','-'),'',$input);

preg_match("/^(\+?[0-9])([0-9]{3})([0-9]{7})$/",$input,$matches);
array_shift($matches);
$matches[2] = substr($matches[2],0,3).'-'.substr($matches[2],3,2).'-'.substr($matches[2],5,3);
return str_replace(array("{countryCode}","{code}","{phone}"),$matches,$options);