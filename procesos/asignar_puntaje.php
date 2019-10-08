<?php 

    require_once "../conexion/conexion.php";
	require_once "../conexion/metodos_db.php";
	
	$obj =  new metodos();
    $id_test = $_GET['idtest'];

    $nro_preguntas = $_POST['nro_preguntas']; 
    echo $nro_preguntas;  
    for($i=1; $i<=$nro_preguntas; $i++){        
        $datos_pregunta = array(
            $_POST["puntaje_pregunta" . $i],
            $_POST["id_pregunta". $i]
        );
        print_r($datos_pregunta);
        $obj->actualizar($datos_pregunta, "pregunta_puntaje");
    }
    
	header("location:../preguntas.php?idtest=$id_test");

 ?>