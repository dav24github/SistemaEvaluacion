<?php 
	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";
	
	$obj =  new metodos();

    $id_test = $_POST["id_test"];
    $id_pregunta = $_POST["id_pregunta"]; 
	$datos_pregunta = array(
		$_POST["enunciado"],
		$id_pregunta
	);
    
    
	$nro_respuestas = (int) $_POST['nro_respuestas'];	
	$nro_opciones = (int) $_POST['nro_opciones']; 
	$nro_respuestas_nuevas = (int) $_POST['nro_respuestas_nuevas'];	
	$nro_opciones_nuevas = (int) $_POST['nro_opciones_nuevas']; 

	//actualizar pregunta
	$obj->actualizar($datos_pregunta, "pregunta");

	// obteniendo las respuestas
	for($i=1; $i<=$nro_respuestas; $i++){
        if (isset($_POST['respuesta' . $i])) {
            $datos_respuesta = array(
                $_POST["respuesta" . $i],
                $_POST["id_respuesta". $i]
            );
            $obj->actualizar($datos_respuesta, "respuesta");
        }else{
			$obj->eliminar($_POST['id_respuesta' . $i],"respuesta");
		}
	}

	// obteniendo los valores (%)
	for($i=1; $i<=$nro_respuestas; $i++){
		if (isset($_POST['valor_porcentual' . $i])) {
			$datos_valor_porcentual = array(
				$_POST["valor_porcentual" . $i],
				$_POST["id_respuesta". $i]
			);
			$obj->actualizar($datos_valor_porcentual, "actualizar_respuesta_valor");
		}
	}

	// obteniendo las opciones
	for($i=1; $i<=$nro_opciones; $i++){
        if (isset($_POST['opcion' . $i])) {
            $datos_opcion = array(
                $_POST["opcion" . $i],
                $_POST["id_opcion". $i]
            );
            $obj->actualizar($datos_opcion, "opcion");
        }else{
			$obj->eliminar($_POST['id_opcion' . $i],"opcion");
		}
	}

	// obteniendo las sanciones (%)
	for($i=1; $i<=$nro_opciones; $i++){
		if (isset($_POST['sancion_porcentual' . $i])) {
			$datos_sancion_porcentual = array(
				$_POST["sancion_porcentual" . $i],
				$_POST["id_opcion". $i]
			);
			print_r($datos_sancion_porcentual);
			$obj->actualizar($datos_sancion_porcentual, "actualizar_opcion_sancion");
		}
	}


	// obteniendo las respuestas nuevas
	$index = 1;
	for($i=1; $i<=$nro_respuestas_nuevas; $i++){
        if (isset($_POST['respuesta_nueva' . $i])) {
			$respuestas_nuevas[$index] = $_POST['respuesta_nueva' . $i];
			$index++;
        }
	}	

	// obteniendo los valores (%) nuevas
	$index = 1;
	for($i=1; $i<=$nro_respuestas_nuevas; $i++){
        if (isset($_POST['valor_porcentual_nueva' . $i])) {
			$valores_nuevas[$index] = $_POST['valor_porcentual_nueva' . $i];
			$index++;
        }
	}

	$index = 1;
	// obteniendo las opciones nuevas
	for($i=1; $i<=$nro_opciones_nuevas; $i++){
		if(isset($_POST['opcion_nueva' . $i])){
			$opciones_nuevas[$index] = $_POST['opcion_nueva' . $i];
			$index++; 
		}
	}	

	// obteniendo las sanciones (%) nuevas
	$index = 1;
	for($i=1; $i<=$nro_opciones_nuevas; $i++){
        if (isset($_POST['sancion_porcentual_nueva' . $i])) {
			$sanciones_nuevas[$index] = $_POST['sancion_porcentual_nueva' . $i];
			$index++;
        }
	}
	
	$respuestas_nuevas[0] = $id_pregunta; // pregunta a la que pertenece la respuesta
	$opciones_nuevas[0] = $id_pregunta; // pregunta a la que pertenece la opcion
	
	$id_respuesta = $obj->insertar($respuestas_nuevas, "respuesta");
	$id_opcion = $obj->insertar($opciones_nuevas, "opcion");

	$valores_nuevas[0] = $id_respuesta; // las respuestas a la que pertenece el valor
	$sanciones_nuevas[0] = $id_opcion; // las opciones a la que pertenece la sancion

	$obj->actualizar($valores_nuevas, "respuesta_valor");
	$obj->actualizar($sanciones_nuevas, "opcion_sancion");

	header("location:../preguntas.php?idtest=$id_test");

 ?>