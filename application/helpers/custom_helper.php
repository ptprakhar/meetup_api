<?php

function convertToDate($dobString){
	list($d , $m, $y) = explode("/", $dobString);  
	return ($y . '/' . $m . '/' . $d);  
}


