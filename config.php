<?php
	
$dbHost = 'localhost';
$dbName = 'cursophp';
$dbUser = 'root';
$dbPass = '';
try{
	// crear una conexion
$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUser,$dbPass);
	// asignar las excepciones
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(Exception $e){
	echo $e->getMessage(); 
}