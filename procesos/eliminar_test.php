<?php

	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";

	$id_test = $_GET['idtest'];

	$obj =  new metodos();
	$obj->eliminar($id_test,"test");

	header("location:../index.php");
	
 ?>