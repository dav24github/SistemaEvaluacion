<?php 
	require_once "conexion/conexion.php";
	require_once "conexion/metodos_db.php";
	
	$obj =  new metodos();
  
    if(isset($_GET['idtest']))
        $id_test = $_GET['idtest'];

    // Obtenemos las preguntas falso verdadero del test
    $sql = "SELECT * FROM pregunta WHERE tipo_pregunta='falso_verdadero'" ;			
    $preguntas_fv = $obj->mostrarDatos($sql);

    // Obtenemos preguntas simples del test
    $sql = "SELECT * FROM pregunta WHERE tipo_pregunta='opcion_simple'" ;			
    $preguntas_opc_sim = $obj->mostrarDatos($sql);

    // Obtenemos las preguntas multiples del test
    $sql = "SELECT * FROM pregunta WHERE tipo_pregunta='opcion_multiple'" ;			
    $preguntas_opc_mul = $obj->mostrarDatos($sql);

    // Entrar si hemos elegido una pregunta existente
    if (isset($_GET['id_pregunta'])) { 
        $id_test =  $_GET['id_test'];
        $id_pregunta = $_GET['id_pregunta']; 
        $tipo_pregunta = $_GET['tipo_pregunta']; 

        // Obtenemos los datos de la pregunta elegida
        $sql = "SELECT * from pregunta WHERE idpregunta = $id_pregunta";
        $pregunta = $obj->mostrarDatos($sql);        
	    $enunciado = $pregunta[0]["enunciado"];
        $sql = "SELECT * from respuesta WHERE idpregunta = $id_pregunta";
        $respuestas = $obj->mostrarDatos($sql);        
	    $nro_respuestas = count($respuestas);        
        $sql = "SELECT * from opcion WHERE idpregunta = $id_pregunta";
        $opciones = $obj->mostrarDatos($sql);
        $nro_opciones = count($opciones);
        $sql = "SELECT valor from respuesta WHERE idpregunta = $id_pregunta";
        $valores = $obj->mostrarDatos($sql);
        $sql = "SELECT sancion from opcion WHERE idpregunta = $id_pregunta";
        $sanciones = $obj->mostrarDatos($sql);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="js/jquery-3.4.1.min.js"></script>   
    <script src="js/script_crear_pregunta.js"></script>   
</head>
<body>

    <!-- Botones de para elegir el tipo de pregunta a crear -->
    <button id="f_v">Falso/Verdadero</button>
    <button id="osimple">Opción Simple</button>
    <button id="omultiple">Opción Multiple</button>
    <br><br>
    
    <?php
        // Entrar si hemos elegido una pregunta existente
        if(isset($tipo_pregunta)){ ?>
            <input type="text" hidden="" id="t_pregunta" value="<?php echo $tipo_pregunta?>">
    <?php
        }else {?>
            <input type="text" hidden="" id="t_pregunta" value="">
    <?php
        }
    ?>

    <input type="text" hidden="" value="<?php echo $id_test ?>" name="id_test" id="id_test"> 

    <!-- ---------------------------------------------------------------------------- -->

    <!-- ----------------------FORMULARIO FALSO VERDADERO---------------------------- -->

    <form action = "procesos/insertar_pregunta.php" method = "post" id="falso_verdadero">

        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($_GET['id_pregunta'])){ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }else{ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }
        ?> 

        <input type="text" hidden="" value="falso_verdadero" name="tipo_pregunta" id="tipo_pregunta_fv">        
        
        <label>Enunciado</label>
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($enunciado)){ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="<?php echo $enunciado?>">
        <?php
            }else{ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="">
        <?php
            }
        ?>    

        <!-- lista de preguntas ya existentes -->
        <select id="pregunta_reutilizada_fv" name="pregunta_reutilizada" onchange = "return buscar_fv();">
            <option>--Seleciona tu pregunta--</option>  
            <?php
                foreach($preguntas_fv as $key){
                    echo "<option value='" . $key["idpregunta"]. "'>". $key["enunciado"] ."</option>";
                }
            ?>
        </select>  
        <br><br>

        <label>Respuesta</label>
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($respuestas)){ ?>
                <input type="text" hidden="" value="<?php echo $respuestas[0]["idrespuesta"] ?>" name="id_respuesta1">
                <select name="respuesta1" title="Elige la respuesta" disabled>
                    <option value="falso" <?php if($respuestas[0]["descripcion"]=="falso") echo "selected"; else echo ""?>>Falso</option>
					<option value="verdadero" <?php if($respuestas[0]["descripcion"]=="verdadero") echo "selected"; else echo ""?>>Verdadero</option>
                </select> 
          <?php 
            }else{ ?>
                <select id="falso_o_verdadero" name="respuesta1" title="Elige la respuesta">
                    <option value="falso">Falso</option>
                    <option value="verdadero">Verdadero</option>
                </select> 
        <?php
            }
        ?>      
        
        <!-- Opciones -->
        <!-- <div class="opciones">
            <p>Falso</p> <input type="text" hidden="" name="opcion1" value="falso">
            <p>Verdadero</p><input type="text" hidden="" name="opcion2" value="verdadero">
        </div> -->

        <input class="nro_respuestas" type="text" hidden="" value="1" name="nro_respuestas">           
        <input class="nro_opciones" type="text" hidden="" value="1" name="nro_opciones">           
        
        <button>Continuar</button>

    </form>

    <!-- ---------------------------------------------------------------------------- -->

    <!-- -----------------------FORMULARIO OPCIÓN SIMPLE----------------------------- -->
 
    <form action = "procesos/insertar_pregunta.php" method = "post" id="opcion_simple">    

        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($_GET['id_pregunta'])){ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }else{ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }
        ?> 

        <input type="text" hidden="" value="opcion_simple" name="tipo_pregunta" id="tipo_pregunta_simple"> 
        
        <label>Enunciado</label>
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($enunciado)){ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="<?php echo $enunciado?>">
        <?php
            }else{ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="">
        <?php
            }
        ?>    

        <!-- lista de preguntas ya existentes -->  
        <select id="pregunta_reutilizada_simple" name="pregunta_reutilizada" onchange = "return buscar_simple();">
            <option>--Seleciona tu pregunta--</option>
            <?php
                foreach($preguntas_opc_sim as $key){
                    echo "<option value='" . $key["idpregunta"]. "'>". $key["enunciado"] ."</option>";
                }
            ?>
        </select> 
        <br><br>

        <label>Respuesta</label>
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($respuestas)){ 
                echo '<input type="text" hidden="" value="'.$respuestas[0]["idrespuesta"].'" name="id_respuesta1">';
		        echo '<input type = "text" name = "respuesta1" value="'. $respuestas[0]["descripcion"] . '" disabled> <br><br>';       
            }else{
                echo "<input type='text' name='respuesta1' value=''>";
            }
        ?>    
        <br><br>   
        
        <label>Opciones (incorrectas):</label>
        <div class="items_opciones">
            <?php
                // Entrar si hemos elegido una pregunta existente
                if (isset($opciones)){ 
                    for($i=1; $i<=$nro_opciones; $i++){
						echo "<input type='text' hidden='' value='" . $opciones[$i-1]["idopciones"] . "' name='id_respuesta". $i ."'>";
						echo "<div>";							
							echo "<input type='text' value='". $opciones[$i-1]["descripcion"] ."' name='respuesta". $i ."' disabled>";
						echo "</div>";
					}           
                }else{
                    echo "<input type='text' name='opcion1' value=''>";
                }
            ?>              
        </div> 
        
        <?php
        // Entrar si *NO* hemos elegido una pregunta existente
        if (!isset($opciones)){ 
            echo '<input type="button" value="+ añadir" class="add_opcion_simple">';
        } 
        ?>   
        <br><br>   

        <input class="nro_respuestas" type="text" hidden="" value="1" name="nro_respuestas">           
        <input class="nro_opciones" type="text" hidden="" value="" name="nro_opciones">           

        <button type="submit">Continuar</button>

    </form>

    <!-- ---------------------------------------------------------------------------- -->

    <!-- -----------------------FORMULARIO OPCIÓN MÚLTIPLE----------------------------- -->
    
    <form action = "procesos/insertar_pregunta.php" method = "post" id="opcion_multiple">
        
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($_GET['id_pregunta'])){ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }else{ ?>
                <input type="text" hidden="" value="<?php echo $id_test ?>" name="idtest"> 
        <?php
            }
        ?> 

        <input type="text" hidden="" value="opcion_multiple" name="tipo_pregunta" id="tipo_pregunta_multiple"> 
   
        <label>Enunciado</label>
        <?php
            // Entrar si hemos elegido una pregunta existente
            if (isset($enunciado)){ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="<?php echo $enunciado?>">
        <?php
            }else{ ?>
            <input id="enunciado" type = "text" name = "enunciado" value="">
        <?php
            }
        ?>       

        <!-- lista de preguntas ya existentes -->  
        <select id="pregunta_reutilizada_multiple" name="pregunta_reutilizada" onchange = "return buscar_multiple();">
            <option>--Seleciona tu pregunta--</option>
            <?php                
                foreach($preguntas_opc_mul as $key){
                    echo "<option value='" . $key["idpregunta"]. "'>". $key["enunciado"] ."</option>";
                }
            ?>
        </select> 
        <br><br>

        <label>Respuesta..........................</label><label>Valor (%)</label>
        <div class="items_respuestas">
            <?php
                // Entrar si hemos elegido una pregunta existente
                if (isset($respuestas)){ 
                    for($i=1; $i<=$nro_respuestas; $i++){
						echo "<input type='text' hidden='' value='" . $respuestas[$i-1]["idrespuesta"] . "' name='id_respuesta". $i ."'>";
						echo "<div>";							
                            echo "<input type='text' value='". $respuestas[$i-1]["descripcion"] ."' name='respuesta". $i ."' disabled>";
                            echo "<input type='text' value='". $valores[$i-1]["valor"] ."' name='valor_porcentual". $i ."' disabled>";
						echo "</div>";
					}           
                }else{
                    echo "<input type='text' name='respuesta1' value=''>";
                    // Valor de la respuesta
                    ?>
                        <select id="valor_porcentual1" name="valor_porcentual1">
                            <option value=""></option>
                            <option value="0">0</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="33.3">33.33</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>  
                    <?php
                }
            ?>              
        </div> 
        
        <?php
        // Entrar si *NO* hemos elegido una pregunta existente
        if (!isset($respuestas)){ 
            echo '<input type="button" value="+ añadir" class="add_respuesta">';
        } 
        ?>   
        <br><br>         

        <label>Opciones (incorrectas):</label>..........................</label><label>Sancion (%)</label>
        <div class="items_opciones">
            <?php
                // Entrar si hemos elegido una pregunta existente
                if (isset($opciones)){ 
                    for($i=1; $i<=$nro_opciones; $i++){
						echo "<input type='text' hidden='' value='" . $opciones[$i-1]["idopciones"] . "' name='id_respuesta". $i ."'>";
						echo "<div>";							
                            echo "<input type='text' value='". $opciones[$i-1]["descripcion"] ."' name='respuesta". $i ."' disabled>";
                            echo "<input type='text' value='". $sanciones[$i-1]["sancion"] ."' name='sancion_porcentual". $i ."' disabled>";
						echo "</div>";
					}           
                }else{
                    echo "<input type='text' name='opcion1' value=''>";
                    // Valor de la respuesta
                    ?>
                        <select id="sancion_porcentual1" name="sancion_porcentual1">
                            <option value=""></option>
                            <option value="0">0</option>
                            <option value="-20">-20</option>
                            <option value="-25">-25</option>
                            <option value="-33.3">-33.33</option>
                            <option value="-50">-50</option>
                            <option value="-100">-100</option>
                        </select>  
                    <?php
                }
            ?>              
        </div> 

        <?php
        // Entrar si *NO* hemos elegido una pregunta existente
        if (!isset($opciones)){ 
            echo '<input type="button" value="+ añadir" class="add_opcion_multiple">';
        } 
        ?>   
        <br><br>   
        
        <input class="nro_respuestas" type="text" hidden="" value="" name="nro_respuestas">           
        <input class="nro_opciones" type="text" hidden="" value="" name="nro_opciones">      

        <button type="submit">Continuar</button>
    </form>

</body>
</html>