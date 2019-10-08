<?php 

	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";

	$nombre = $_POST['nombre_test'];
	$descripcion  =  "";

	$datos_test = array(
				$nombre,
				$descripcion
			);

	$obj =  new metodos();
	$id_test = $obj->insertar($datos_test,"test");
			
	header("location:../inicio.php?idtest=$id_test");

 ?>