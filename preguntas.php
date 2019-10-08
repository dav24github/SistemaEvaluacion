<?php
    require_once "conexion/conexion.php";
    require_once "conexion/metodos_db.php";

    $id_test = $_GET['idtest'];

    $obj =  new metodos();

    // Obtenemos el puntaje de las preguntas del test
    $sql = "SELECT puntaje FROM test_pregunta INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta)
            INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $puntajes = $obj->mostrarDatos($sql); 

    // Obtenemos el puntaje total del test
    $sql = "SELECT sum(puntaje) as sum_puntaje FROM test_pregunta INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta)
            INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $puntaje_total = $obj->mostrarDatos($sql);  

    // Obtenemos los valorres de las respuestas del test
    $sql = "SELECT valor FROM test_pregunta  INNER JOIN respuesta ON (respuesta.idpregunta = test_pregunta.idpregunta)
            INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta) INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $valores = $obj->mostrarDatos($sql);  

    // Obtenemos las sanciones de las opciones del test
    $sql = "SELECT sancion FROM test_pregunta  INNER JOIN opcion ON (opcion.idpregunta = test_pregunta.idpregunta)
            INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta) INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $sanciones = $obj->mostrarDatos($sql);  

    // Obtenemos el tipo de pregunta de cada pregunta del test
    $sql = "SELECT tipo_pregunta FROM test_pregunta INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta)
            INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $tipo_preguntas = $obj->mostrarDatos($sql); 

    // Obtenemos las preguntas del test
    $sql = "SELECT pregunta.* FROM test_pregunta INNER JOIN pregunta ON (pregunta.idpregunta = test_pregunta.idpregunta)
            INNER JOIN test ON (test.idtest = test_pregunta.idtest) WHERE test.idtest = $id_test";
    $preguntas = $obj->mostrarDatos($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Preguntas</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script>
        // function del autollenado de los inputs puntaje
        function llenar_puntaje(){
            $(".puntaje").val($("#auto_puntaje").val());
        }
    </script>
</head>
<body>
    <section class = "contenedor">
        
        <button onclick = "location.href = 'crear_pregunta.php?idtest=<?php echo $id_test ?>'">Añadir pregunta</button>
        
        <form action="procesos/asignar_puntaje.php?idtest=<?php echo $id_test ?>" method="post">

            <!-- Puntaje -->
            <p id="puntaje_total">Puntaje total: <?php echo $puntaje_total[0]['sum_puntaje']?> pts.</p>
            <!-- Autollenado del puntaje -->
            <select id="auto_puntaje" onchange="llenar_puntaje()">
                <option value="">Seleccione puntaje</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> 
            <button>Asignar puntaje</button>
            <br><br>

            *--------------------------------------------*

            <div class = "contenedor_preguntas">
                <?php
                    if($preguntas != null){
                        $index_pregunta=1; 
                        $index_valor=0;
                        $index_sancion = 0;   
                        // Recorremos las preguntas del test     
                        foreach ($preguntas as $preg) {                             
                            $id_pregunta= $preg["idpregunta"];
                            $tipo_pregunta =  $preg["tipo_pregunta"];

                            // Obtenemos las respuestas de la pregunta actual
                            $sql = "SELECT * FROM respuesta WHERE idpregunta = $id_pregunta";
                            $respuestas = $obj->mostrarDatos($sql);                            
                            // Obtenemos las opciones de la pregunta actual
                            $sql = "SELECT * FROM opcion WHERE idpregunta = $id_pregunta";
                            $opciones = $obj->mostrarDatos($sql);

                            // Mostramos el enunciado de la pregunta actual
                            echo $index_pregunta . ". Pregunta: " . $preg['enunciado'] . "............";  
                            // Botones de editar y eliminar pregunta                      
                            echo "<a href='editar_pregunta.php?id_test=" . $id_test . "&id_pregunta=" . $id_pregunta . "&tipo_pregunta=" . $tipo_pregunta . "'> *editar* </a>";
                            echo "<a href='procesos/eliminar_test_pregunta.php?id_test=" . $id_test . "&id_pregunta=" . $id_pregunta . "'> *eliminar* </a>";                      
                            echo "<br>--------------------------- <br>";                        
                            
                            // Recorremos las respuestas de cada pregunta
                            foreach($respuestas as $res){
                                if($tipo_preguntas[$index_pregunta-1]['tipo_pregunta']=="opcion_multiple"){
                                    // Si es pregunta multiple mostramos la respuesta y su valor (%)
                                    echo "Respuesta: " . $res['descripcion'] . "_____"; 
                                    echo "Valor: " . $valores[$index_valor]['valor'] . " (%)<br>"; 
                                    $index_valor++;
                                }
                                else{
                                    // Sino mostramos la única respuesta
                                    echo "Respuesta: " . $res['descripcion'] . "<br>";
                                    $index_valor++;
                                }
                            }
                            echo "--------------------------- <br>";     

                            // Recorremos las opciones de cada pregunta
                            foreach($opciones as $opc){    
                                if($tipo_preguntas[$index_pregunta-1]['tipo_pregunta']=="opcion_multiple"){
                                    // Si es pregunta multiple mostramos la opcion y su valor (%)
                                    echo "opcion: " . $opc['descripcion']  . "_____"; 
                                    echo "Sancion: " . $sanciones[$index_sancion]['sancion'] . " (%)<br>"; 
                                    $index_sancion++;
                                }
                                else{
                                    // Sino mostramos la opcion
                                    echo "Opcion: " . $opc['descripcion'] . "<br>";
                                    $index_sancion++;
                                }
                            }

                            // Puntaje de la pregunta actual
                            echo "<br><label>Puntaje: </label>";
                            echo "<input type='text' hidden='' value='$id_pregunta' name='id_pregunta".$index_pregunta."'>";
                            echo "<input class='puntaje' type='text' value='". $puntajes[$index_pregunta-1]["puntaje"] ."' name='puntaje_pregunta".$index_pregunta."'>";
                            echo "<br> ************************************************** <br>";  
                            $index_pregunta++;
                        }

                        $index_pregunta--; // restamos 1 para obtener la cantidad de preguntas
                        echo "<input type='text' hidden='' value='$index_pregunta' name='nro_preguntas'>";
                    }
                    else{   
                        echo "No existen preguntas";
                    }
                ?>
            </div>

        </form>

    </section>
</body>
</html>