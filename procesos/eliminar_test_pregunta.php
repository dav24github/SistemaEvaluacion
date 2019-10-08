<?php 
    $id_test = $_GET['id_test'];
	$id_pregunta = $_GET['id_pregunta'];
	
	$datos_id = array(
		$id_test,
		$id_pregunta
	);

	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";

    $obj =  new metodos();
    
	$obj->eliminar($datos_id,"test_pregunta");

	header("location:../preguntas.php?idtest=$id_test");
 ?>