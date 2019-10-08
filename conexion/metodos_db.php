<?php 
	class metodos{

		public function mostrarDatos($sql){
			$c  =  new conectar();
			$conexion = $c->conexion();

			$result = mysqli_query($conexion,$sql);

			return mysqli_fetch_all($result,MYSQLI_ASSOC);
		}

		public function insertar($datos, $tabla){
			$sql="";
			$id = null; //inicializamos la var id;
			$c = new conectar();
			$conexion  =  $c->conexion();

            switch ($tabla) {

                case "test":{
                    $sql = "INSERT into test (nombre,descripcion)
							values ('$datos[0]','$datos[1]')";
					if(mysqli_query($conexion,$sql)==1);			
						$id = mysqli_insert_id($conexion);
                    break;
                }

                case "pregunta":{
                    $sql = "INSERT into pregunta (enunciado,tipo_pregunta)
							values ('$datos[0]','$datos[1]')";
					if(mysqli_query($conexion,$sql)==1);			
						$id = mysqli_insert_id($conexion);
                    break;
				}
				
				case "test_pregunta":{
					$sql = "INSERT into test_pregunta (idpregunta, idtest)
							values ($datos[0],$datos[1])";
					if(mysqli_query($conexion,$sql)==1);			
						$id = mysqli_insert_id($conexion);		
                    break;
				}

				case "respuesta":{
					for($i=1; $i<=count($datos)-1; $i++){						
						$sql = "INSERT into respuesta (descripcion, idpregunta)
							values ('$datos[$i]',$datos[0])";
						if(mysqli_query($conexion,$sql)==1);			
							$id[$i-1] = mysqli_insert_id($conexion);
					}
                    break;
				}

				case "opcion":{
					for($i=1; $i<=count($datos)-1; $i++){						
						$sql = "INSERT into opcion (descripcion, idpregunta)
						values ('$datos[$i]',$datos[0])";
						if(mysqli_query($conexion,$sql)==1);			
							$id[$i-1] = mysqli_insert_id($conexion);
					}
                    break;
				}
			}
			return $id;
		}

		public function actualizar($datos,$tabla){
			$sql="";
			$c = new conectar();
			$conexion  =  $c->conexion();

			switch ($tabla) {

				case "test":{   						
					$sql = "UPDATE test SET nombre = '$datos[0]',
											descripcion = '$datos[1]'
										WHERE idtest = '$datos[2]'";
					$result = mysqli_query($conexion,$sql);
					break;	
				}
				
				case "test_config":{   	
					$sql = "UPDATE test SET duracion = '$datos[0]',
											cantidad_repeticiones = '$datos[1]',
											ver_respuestas_correctas = '$datos[2]',
											ver_respuestas_incorrectas = '$datos[3]',
											terminar_en_ultima_pregunta = '$datos[4]',
											enviar_auto_tiempo = '$datos[5]'
										WHERE idtest = '$datos[6]'";
					$result = mysqli_query($conexion,$sql);
					break;	
                }

                case "pregunta":{ 
					$sql = "UPDATE pregunta SET enunciado = '$datos[0]'
										WHERE idpregunta = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}

				case "pregunta_puntaje":{ 
					$sql = "UPDATE pregunta SET puntaje = '$datos[0]'
										WHERE idpregunta = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}
				
				case "respuesta":{
					$sql = "UPDATE respuesta SET descripcion = '$datos[0]'
										WHERE idrespuesta = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}

				case "opcion":{
					$sql = "UPDATE opcion SET descripcion = '$datos[0]'
										WHERE idopciones = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}

				case "respuesta_valor":{
					for($i=1; $i<=count($datos)-1; $i++){	
						$idrespuesta = 	$datos[0][$i-1];				
						$sql = "UPDATE respuesta SET valor = $datos[$i]
								WHERE idrespuesta = $idrespuesta";
						$result = mysqli_query($conexion,$sql);
					}
                    break;
				}

				case "actualizar_respuesta_valor":{
					$sql = "UPDATE respuesta SET valor = '$datos[0]'
										WHERE idrespuesta = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}

				case "actualizar_opcion_sancion":{
					$sql = "UPDATE opcion SET sancion = '$datos[0]'
										WHERE idopciones = '$datos[1]'";
					$result = mysqli_query($conexion,$sql);
					break;
				}

				case "opcion_sancion":{
					for($i=1; $i<=count($datos)-1; $i++){
						$idopcion = $datos[0][$i-1];						
						$sql = "UPDATE opcion SET sancion = $datos[$i]
								WHERE idopciones = $idopcion";
						$result = mysqli_query($conexion,$sql);
					}
                    break;
				}
			}
		}

		public function eliminar($id, $tabla){
			$sql="";
			$c = new conectar();
			$conexion  =  $c->conexion();

			switch ($tabla) {

				case "test":{   				
					$sql = "DELETE FROM test_pregunta WHERE idtest = $id";					
					mysqli_query($conexion,$sql);
					$sql = "DELETE FROM test WHERE idtest = $id";					
					mysqli_query($conexion,$sql);
					break;	
                }

                case "pregunta":{ 
					break;
				}
				
				case "test_pregunta":{								
					$sql = "DELETE FROM test_pregunta WHERE idtest = $id[0] AND idpregunta = $id[1]";					
					mysqli_query($conexion,$sql);
                    break;
				}

				case "respuesta":{
					$sql = "DELETE FROM respuesta WHERE idrespuesta = $id";					
					mysqli_query($conexion,$sql);
					break;
				}

				case "opcion":{					
					$sql = "DELETE FROM opcion WHERE idopciones = $id";					
					mysqli_query($conexion,$sql);
					break;
				}

			}
			
		}

	}
 ?>