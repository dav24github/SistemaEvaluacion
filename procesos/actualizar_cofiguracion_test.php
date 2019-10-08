<?php 
	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";

    $id_test = $_GET['idtest'];	
    
    $duracion = $_POST['duracion'];

    $cantidad_repeticiones = $_POST['cantidad_repeticiones'];

    if(isset($_POST['ver_respuestas'])) $ver_respuestas_correctas = 1;
    else $ver_respuestas_correctas = 0;

    if(isset($_POST['ver_respuestas_i'])) $ver_respuestas_incorrectas = 1;
    else $ver_respuestas_incorrectas = 0;

    if(isset($_POST['terminar_ult_pregunta'])) $terminar_en_ultima_pregunta = 1;
    else $terminar_en_ultima_pregunta = 0;

    if(isset($_POST['enviar_tiempo'])) $enviar_auto_tiempo = 1;
    else $enviar_auto_tiempo = 0;

	$datos_config = array(
            $duracion,
            $cantidad_repeticiones,
            $ver_respuestas_correctas,
            $ver_respuestas_incorrectas,
            $terminar_en_ultima_pregunta,
            $enviar_auto_tiempo,
            $id_test
		);

	$obj =  new metodos();

    $obj->actualizar($datos_config,"test_config");

	print_r($datos_config);
	header("location:../inicio.php?idtest=$id_test");


 ?>