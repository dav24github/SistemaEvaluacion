<?php 
	require_once "conexion/conexion.php";
	require_once "conexion/metodos_db.php";
	
	$obj =  new metodos();

	$id_test = $_GET['id_test'];
	$id_pregunta = $_GET['id_pregunta'];
	$tipo_pregunta = $_GET["tipo_pregunta"];

	$sql = "SELECT * from pregunta where idpregunta = $id_pregunta";			
	$pregunta = $obj->mostrarDatos($sql);
	$enunciado = $pregunta[0]["enunciado"];

	$sql = "SELECT * from respuesta where idpregunta = $id_pregunta";	
	$respuestas = $obj->mostrarDatos($sql);
	$nro_respuestas = count($respuestas);

	$sql = "SELECT * from opcion where idpregunta = $id_pregunta";	
	$opciones = $obj->mostrarDatos($sql);	
	$nro_opciones = count($opciones);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script>
        $(document).ready(function(){
            var nro_op_nuevas = 0;
			var nro_res_nuevas = 0;
           
            $(".add_opcion").click(function(e) {
                e.preventDefault();
                nro_op_nuevas++;
                $(".items_opciones").append('<div><input type="text" name="opcion_nueva' + nro_op_nuevas + '">' +
					'<select id="sancion_porcentual_nueva'+ nro_op_nuevas +'" name="sancion_porcentual_nueva'+ nro_op_nuevas +'"><option value=""></option><option value="0">0</option><option value="-20">-20</option><option value="-25">-25</option><option value="-33.3">-33.33</option><option value="-50">-50</option><option value="-100">-100</option></select>'+
					'<input type="button" value="X" class="delete" /></div>');
                $(".nro_opciones_nuevas").val(nro_op_nuevas);
            });

            $(".add_respuesta").click(function(e) {
                e.preventDefault();
                nro_res_nuevas++;
                $(".items_respuestas").append('<div><input type="text" name="respuesta_nueva' + nro_res_nuevas + '">' +
					'<select id="valor_porcentual_nueva'+ nro_res_nuevas +'" name="valor_porcentual_nueva'+ nro_res_nuevas +'"><option value=""></option><option value="0">0</option><option value="20">20</option><option value="25">25</option><option value="33.3">33.33</option><option value="50">50</option><option value="100">100</option></select>'+
					'<input type="button" value="X" class="delete" /></div>');
                $(".nro_respuestas_nuevas").val(nro_res_nuevas);
            });


            $('body').on('click', '.delete', function(e) {
                $(this).parent('div').remove();
            });
	    });
    </script>    
</head>
<body>

	<?php
		if($tipo_pregunta=="falso_verdadero"){
	?>	
		<form action = "procesos/actualizar_pregunta.php" method = "post" id="falso_verdadero">

			<input type="text" hidden="" value="<?php echo $id_test ?>" name="id_test">
			<input type="text" hidden="" value="<?php echo $id_pregunta ?>" name="id_pregunta">             

			<label>Enunciado</label>
			<input type = "text" name = "enunciado" value="<?php echo $enunciado ?>"> <br><br>

			<label>Respuesta</label>
			<input type="text" hidden="" value="<?php echo $respuestas[0]["idrespuesta"] ?>" name="id_respuesta1">
			<select name="respuesta1" title="Elige la respuesta">
					<option value="falso" <?php if($respuestas[0]["descripcion"]=="falso") echo "selected"; else echo ""?>>Falso</option>
					<option value="verdadero" <?php if($respuestas[0]["descripcion"]=="verdadero") echo "selected"; else echo ""?>>Verdadero</option>
			</select>      

			<div class="opciones">
				<input type='text' hidden='' value="<?php $opciones[0]['idopciones']?>" name="id_opcion1">
				<p>Falso</p> <input type="text" hidden="" name="opcion1" value="falso">
				<input type='text' hidden='' value="<?php $opciones[1]['idopciones']?>" name="id_opcion2">
				<p>Verdadero</p><input type="text" hidden="" name="opcion2" value="verdadero">
			</div>

			<input type="text" hidden="" value="1" name="nro_respuestas">           
			<input type="text" hidden="" value="2" name="nro_opciones"><br>     

			<input class="nro_respuestas_nuevas" type="text" hidden="" value="0" name="nro_respuestas_nuevas">           
			<input class="nro_opciones_nuevas" type="text" hidden="" value="0" name="nro_opciones_nuevas">  

			<button>Continuar</button>

		</form>
	<?php
		}
	?>
	<?php	
		if($tipo_pregunta=="opcion_simple"){
	?>	
		<form action = "procesos/actualizar_pregunta.php" method = "post" id="opcion_simple">      
		
			<input type="text" hidden="" value="<?php echo $id_test ?>" name="id_test">
			<input type="text" hidden="" value="<?php echo $id_pregunta ?>" name="id_pregunta">      

			<label>Enunciado</label>
			<input type = "text" name = "enunciado" value="<?php echo $enunciado ?>"> <br><br>

			<label>Respuesta</label>
			<input type="text" hidden="" value="<?php echo $respuestas[0]["idrespuesta"] ?>" name="id_respuesta1">
			<input type = "text" name = "respuesta1" value="<?php echo $respuestas[0]["descripcion"] ?>"> <br><br>

			<label>Opciones:</label>
			<div class="items_opciones">
				<?php 
					for($i=1; $i<=$nro_opciones; $i++){
						echo "<input type='text' hidden='' value='" . $opciones[$i-1]["idopciones"] . "' name='id_opcion". $i ."'>";
						echo "<div>";							
							echo "<input type='text' value='". $opciones[$i-1]["descripcion"] ."' name='opcion". $i ."'>";
							echo '<input type="button" value="X" class="delete" />';
						echo "</div>";
					}
				?>				
			</div>  

			<input type="button" value="+ añadir" class="add_opcion"> 	
			<br><br><br>

			<input type="text" hidden="" value="1" name="nro_respuestas">           
			<input class="nro_opciones"  type="text" hidden="" value="<?php echo $nro_opciones ?>" name="nro_opciones">
			
			<input class="nro_respuestas_nuevas" type="text" hidden="" value="0" name="nro_respuestas_nuevas">           
			<input class="nro_opciones_nuevas" type="text" hidden="" value="" name="nro_opciones_nuevas">  

			<button type="submit">Continuar</button>
 		</form>

	<?php		
		}
	?>
	<?php
		if($tipo_pregunta=="opcion_multiple"){
	?>
		<form action = "procesos/actualizar_pregunta.php" method = "post" id="opcion_multiple">      
			
			<input type="text" hidden="" value="<?php echo $id_test ?>" name="id_test">
			<input type="text" hidden="" value="<?php echo $id_pregunta ?>" name="id_pregunta">      

			<label>Enunciado</label>
			<input type = "text" name = "enunciado" value="<?php echo $enunciado ?>"> <br><br>

			<label>Respuesta..........................</label><label>Valor (%)</label>
			<div class="items_respuestas">
				<?php 
					for($i=1; $i<=$nro_respuestas; $i++){
						echo "<input type='text' hidden='' value='" . $respuestas[$i-1]["idrespuesta"] . "' name='id_respuesta". $i ."'>";
						echo "<div>";							
							echo "<input type='text' value='". $respuestas[$i-1]["descripcion"] ."' name='respuesta". $i ."'>";
							?>
								<select id="valor_porcentual<?php echo $i?>" name="valor_porcentual<?php echo $i?>">
									<option value=""></option>
									<option value="0" <?php if($respuestas[$i-1]["valor"]==0) echo "selected"; else echo ""?>>0</option>
									<option value="20" <?php if($respuestas[$i-1]["valor"]==20) echo "selected"; else echo ""?>>20</option>
									<option value="25" <?php if($respuestas[$i-1]["valor"]==25) echo "selected"; else echo ""?>>25</option>
									<option value="33.3" <?php if($respuestas[$i-1]["valor"]==33.3) echo "selected"; else echo ""?>>33.33</option>
									<option value="50" <?php if($respuestas[$i-1]["valor"]==50) echo "selected"; else echo ""?>>50</option>
									<option value="100" <?php if($respuestas[$i-1]["valor"]==100) echo "selected"; else echo ""?>>100</option>
								</select>  
							<?php
							echo '<input type="button" value="X" class="delete" />';
						echo "</div>";
					}
				?>				
			</div>   

			<input type="button" value="+ añadir" class="add_respuesta"> 
			<br>
			<label>Opciones..........................</label><label>Sancion (%)</label>
			<div class="items_opciones">
				<?php 
					for($i=1; $i<=$nro_opciones; $i++){
						echo "<input type='text' hidden='' value='" . $opciones[$i-1]["idopciones"] . "' name='id_opcion". $i ."'>";
						echo "<div>";							
							echo "<input type='text' value='". $opciones[$i-1]["descripcion"] ."' name='opcion". $i ."'>";
							?>
								<select id="sancion_porcentual<?php echo $i?>" name="sancion_porcentual<?php echo $i?>">
									<option value=""></option>
									<option value="0" <?php if($opciones[$i-1]["sancion"]==-0) echo "selected"; else echo ""?>>-0</option>
									<option value="-20" <?php if($opciones[$i-1]["sancion"]==-20) echo "selected"; else echo ""?>>-20</option>
									<option value="-25" <?php if($opciones[$i-1]["sancion"]==-25) echo "selected"; else echo ""?>>-25</option>
									<option value="-33.3" <?php if($opciones[$i-1]["sancion"]==-33.3) echo "selected"; else echo ""?>>-33.33</option>
									<option value="-50" <?php if($opciones[$i-1]["sancion"]==-50) echo "selected"; else echo ""?>>-50</option>
									<option value="-100" <?php if($opciones[$i-1]["sancion"]==-100) echo "selected"; else echo ""?>>-100</option>
								</select>  
							<?php
							echo '<input type="button" value="X" class="delete" />';
						echo "</div>";
					}
				?>		
			</div>

			<input type="button" value="+ añadir" class="add_opcion"> 		
			<br><br><br>

			<input class="nro_respuestas" type="text" hidden="" value="<?php echo $nro_respuestas ?>" name="nro_respuestas">           
			<input class="nro_opciones" type="text" hidden="" value="<?php echo $nro_opciones ?>" name="nro_opciones">  
			
			<input class="nro_respuestas_nuevas" type="text" hidden="" value="" name="nro_respuestas_nuevas">           
			<input class="nro_opciones_nuevas" type="text" hidden="" value="" name="nro_opciones_nuevas">  
			
			<button type="submit">Continuar</button>
		</form>
	<?php		
		}
	?>


</body>
</html>