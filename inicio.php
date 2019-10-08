<?php
    require_once "conexion/conexion.php";
    require_once "conexion/metodos_db.php";

    $id_test = $_GET["idtest"];
    
    $obj = new metodos();

    // Obteniendo los datos del test
    $query = "SELECT * FROM test WHERE idtest = $id_test";            
    $test = $obj->mostrarDatos($query);
    $nombre_test = $test[0]["nombre"];
    $descr_test = $test[0]["descripcion"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = 'utf-8'>
    <meta http-equiv = 'X-UA-Compatible' content = 'IE = edge'>
    <title>Page Title</title>
    <meta name = 'viewport' content = 'width = device-width, initial-scale = 1'>
</head>
<body>

    <h1>Bienvenido!!!</h1>    
    <br>

    <div class=contenido_test>
        <form action="procesos/actualizar_test.php?idtest=<?php echo $id_test ?>" method="post">

            <button>Actualizar</button><br><br>

            <input type="text" name="nombre_test" value="<?php echo $nombre_test?>"><br><br>            
            <input type="text" name="descr_test" value="<?php echo $descr_test?>"><br><br>
            
        </form>
    </div>

    <button onclick="location.href = 'preguntas.php?idtest=<?php echo $id_test ?>'">Preguntas</button>
    <button onclick="location.href = 'configuracion_test.php?idtest=<?php echo $id_test ?>'">Configuraciones</button>

</body>
</html>