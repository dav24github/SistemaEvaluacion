<?php
    require_once "conexion/conexion.php";
    require_once "conexion/metodos_db.php";

    $id_test = $_GET["idtest"];
    $obj = new metodos();
    $query = "SELECT * FROM test WHERE idtest = $id_test";            
    $test = $obj->mostrarDatos($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
    
    <form action="procesos/actualizar_cofiguracion_test.php?idtest=<?php echo $id_test ?>" method="post">
        <label>---------Configuraciones---------</label><br><br>
        <label>Duracion: </label><br>
        <input type="text" name="duracion" value="<?php echo $test[0]["duracion"] ?>">
        <br>
        <label>Cantidad de repeticiones: </label><br>
        <input type="text" name="cantidad_repeticiones" value="<?php echo $test[0]['cantidad_repeticiones']?>">
        <br>
        <input type="checkbox" name="ver_respuestas" <?php if($test[0]['ver_respuestas_correctas']==1) echo "checked"; else ""?>>
        <label>Ver las respuestas correctas: </label>
        <br>
        <input type="checkbox" name="ver_respuestas_i" <?php if($test[0]['ver_respuestas_incorrectas']==1) echo "checked"; else ""?>>
        <label>Ver las respuestas incorrectas: </label>
        <br>
        <input type="checkbox" name="terminar_ult_pregunta" <?php if($test[0]['terminar_en_ultima_pregunta']==1) echo "checked"; else ""?>>
        <label>Terminar en la ultima pregunta: </label>
        <br>        
        <input type="checkbox" name="enviar_tiempo" <?php if($test[0]['enviar_auto_tiempo']==1) echo "checked"; else ""?>>
        <label>Enviar test despues de finalizado el tiempo: </label>
        <br>

        <button>Guardar</button>
    </form>

</body>
</html>