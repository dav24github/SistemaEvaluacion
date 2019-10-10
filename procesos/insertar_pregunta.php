<?php 
	require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";
	
	$id_test = $_POST["idtest"];

	$enunciado = $_POST['enunciado'];
	$tipo_pregunta = $_POST["tipo_pregunta"];	
	$datos_pregunta = array(
		$enunciado,
		$tipo_pregunta
	);

	$nro_respuestas = (int) $_POST['nro_respuestas'];	
	$nro_opciones = (int) $_POST['nro_opciones']; 

	// obteniendo las respuestas
	$index=1;
	for($i=1; $i<=$nro_respuestas; $i++){
		if(isset($_POST['respuesta' . $i])){
			$respuestas[$index] = $_POST['respuesta' . $i]; 
			$index++;
		}
	}	

	// obteniendo los valores (%)
	$index=1;
	for($i=1; $i<=$nro_respuestas; $i++){
		if($tipo_pregunta=="falso_verdadero" || $tipo_pregunta=="opcion_simple"){
			$valores[$index] = "100"; 
			break;
		}

		if(isset($_POST['valor_porcentual' . $i])){
			$valores[$index] = $_POST['valor_porcentual' . $i]; 
			$index++;
		}
	}	

	//obteniendo las opciones
	$index=1;
	for($i=1; $i<=$nro_opciones; $i++){		
		if($tipo_pregunta=="falso_verdadero"){
			if($_POST['respuesta1']=="verdadero"){
				$opciones[$index]="falso";
			}else{
				$opciones[$index]="verdadero";
			}
			break;
		}
		
		if(isset($_POST['opcion' . $i])){
			$opciones[$index] = $_POST['opcion' . $i]; 
			$index++;
		}
	}	

	// obteniendo las sanciones (%)
	$index=1;
	for($i=1; $i<=$nro_opciones; $i++){
		if(isset($_POST['sancion_porcentual' . $i])){
			$sanciones[$index] = $_POST['sancion_porcentual' . $i]; 
			$index++;
		}
	}	

	$obj =  new metodos();
	$query = "SELECT * FROM pregunta WHERE enunciado = '$enunciado'";        
	$pregunta = $obj->mostrarDatos($query);
	
	// Existe ya esa pregunta?
    if($pregunta != Null){	
		$id_pregunta = $pregunta[0]["idpregunta"];
	}else{
		$id_pregunta = $obj->insertar($datos_pregunta, "pregunta");		
		$respuestas[0] = $id_pregunta; // pregunta a la que pertenece la respuesta
		$opciones[0] = $id_pregunta; // pregunta a la que pertenece la opcion
		
		$id_respuesta = $obj->insertar($respuestas, "respuesta"); 
		$id_opcion = $obj->insertar($opciones, "opcion"); 

		$valores[0] = $id_respuesta; // las respuestas a la que pertenece el valor
		$sanciones[0] = $id_opcion; // las opciones a la que pertenece la sancion

		$obj->actualizar($valores, "respuesta_valor");
		$obj->actualizar($sanciones, "opcion_sancion");
	}

	$datos_test_pregunta = array(
		$id_pregunta,
		$id_test
	);	

	$obj->insertar($datos_test_pregunta, "test_pregunta");

	header("location:../preguntas.php?idtest=$id_test");

 ?>