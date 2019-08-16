<?php
	$root = "http://" .$_SERVER['HTTP_HOST'];
	//echo $_SERVER['SCRIPT_NAME'];
	$root .= str_replace("assets/bootstrap/".basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']); //echo $root; exit();
	header('location:'.$root.'Auth/logout'); 
?>