<?php 

	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";

	$nombre_test = $_POST['nombre_test'];
	$descr_test = $_POST['descr_test'];
	$id_test = $_GET['idtest'];

	$datos_test = array(
				$nombre_test,
				$descr_test,
				$id_test
			);

	$obj =  new metodos();
	$obj->actualizar($datos_test,"test");
	
	header("location:../inicio.php?idtest=$id_test");

 ?>