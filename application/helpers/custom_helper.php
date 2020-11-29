<?php

function convertToDate($string){
	$time_input = strtotime($string);  
	return date('Y-m-d' , $time_input);  
}