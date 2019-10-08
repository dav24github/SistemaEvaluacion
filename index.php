<?php
    require_once "conexion/conexion.php";
    require_once "conexion/metodos_db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = 'utf-8'>
    <meta http-equiv = 'X-UA-Compatible' content = 'IE = edge'>
    <title>inicio</title>
    <meta name = 'viewport' content = 'width = device-width, initial-scale = 1'>
</head>
<body>
    <section class = "contenedor">

        <button onclick = "location.href = 'crear_test.php'">Crear test</button>

        <div class = "contenido_test">
            <?php
                // Obteniendo los test
                $obj =  new metodos();                
                $sql = "SELECT * FROM TEST";
                $tests = $obj->mostrarDatos($sql);
                
                foreach ($tests as $key){                    
                    echo "<a href='inicio.php?idtest=" . $key['idtest'] . "'>" . $key['nombre'] . "</a>"; // nombre del test
                    echo "------<a href='procesos/eliminar_test.php?idtest=" . $key['idtest'] . "'>X</a>"; // boton de eliminar
                    echo "<br>";                    
                }
            ?>
        </div>  

    </section>
</body>
</html>