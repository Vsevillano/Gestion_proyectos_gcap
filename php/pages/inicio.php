<?php 
	require_once('php/clases/Convocatoria.php');
	require_once('php/clases/Admin.php');

	function mostrarNubeEtiquetas() {
		// Cogemos tooodas las etiquetas de la base de datos
		$var = Convocatoria::singleton_convocatoria();
		$etiquetas = $var->get_etiquetas_proyectos();
		// Formamos un array para la nube
		$nube = array();
		// Recorremos ese array
		foreach ($etiquetas as $key) {
			foreach ($key as $key2) {
				// Y separamos los resultados por espacio (si fuera por , da igual)
				$array = explode(" ", $key2);
				// Añadimos las etiquetas a un nuevo array
				if(is_array($array)) {
					foreach ($array as $valor2) {
						array_push($nube, $valor2);
					}	
				}
			}
		}
		// Contamos los valores iguales para saber que tamaño ponerles
		$nube = array_count_values($nube);
		// Y contamos el numero de etiquetas total
		$etiquetas = count($etiquetas);

		$i = 0;
		// Recorremos la nube de etiquetas
		foreach ($nube as $key => $value) {
			if($i == 4) {
				echo "<br>";
				$i = 0;
			}
			// Creamos un enlace a cada etiqueta y le aplicamos el tamaño en funcoin del percentil
			echo "<a href='index.php?page=mostrar&etiqueta=".$key."' style='font-size:";
			$percentil = (($value/$etiquetas)*100);

			if($percentil < 10){
				echo "12px";
			}
			else if ($percentil>10 && $percentil<21){
					echo "14px";
			}
			else if ($percentil>20 && $percentil<31){
					echo "16px";
			}
			else if ($percentil>30 && $percentil<41){
					echo "18px";
			}
			else if ($percentil>40 && $percentil<51){
					echo "20px";
			}
			else if ($percentil>50 && $percentil<61){
					echo "22px";
			}
			else if ($percentil>60 && $percentil<71){
					echo "24px";
			}
			else if ($percentil>70 && $percentil<81){
					echo "26px";
			}
			else if ($percentil>80 && $percentil<91){
					echo "28px";
			}
			else {
					echo "30px";
			}
			echo "'; >"." ".$key."  "."</a>";
			$i++;
		}
	}



?>
	<div class="envoltorio">
	<div class="contenido_inicio">
	<?php
	
	if(isset($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				echo "<h3 style='color:red'>El enlace para ser dado de alta como admin ha caducado.</h3>";
				break;
			case '2':
				echo "<h3 style='color:red'>El enlace para registrar el proyecto ha caducado.</h3>";
				break;
			case '3':
				echo "<h3 style='color:green'>Proyecto registrado con exito.</h3>";
				break;
			case '4':
				echo "<h3 style='color:red'>La convocatoria no pudo crearse, ya existe una con el mismo nombre.</h3>";
				break;
			case '5':
				echo "<h3 style='color:red'>No se puede cambiar el estado. Ya hay una convocatoria en estado 'Actual'.</h3>";
				break;
			case '6':
				echo "<h3 style='color:green'>Ha solicitado comentar en un proyeto. En breve le llegara un email donde podrá hacerlo.</h3>";
			break;
			case '7':
			echo "<h3 style='color:green'>El enlace para comentar no es correcto.</h3>";
			break;
			case '8':
			echo "<h3 style='color:green'>Ha solicitado valorar un proyeto. En breve le llegara un email donde podrá hacerlo.</h3>";
			break;
			case '9':
			echo "<h3 style='color:red'>El enlace ha caducado.</h3>";
			break;
			case '10':
			echo "<h3 style='color:red'>El proyecto elegido ya ha sido votado por ese correo.</h3>";
			break;
			case '11':
			echo "<h3 style='color:red'>El correo no esta registrado en el sistema.</h3>";
			break;
			case '12':
			echo "<h3 style='color:green'>La contraseña ha sido actualizada.</h3>";
			break;
			case '13':
			echo "<h3 style='color:green'>Se ha enviado un correo para actualizar su contraseña.</h3>";
			break;
			case '14':
			echo "<h3 style='color:red'>Las contraseñas no coinciden.</h3>";
			break;
		}
	}
	?>
		<div class="info">
			<h2>Convocatorias</h2>
			<p>Bienvenido a Gestion de Proyectos Integrados. A continuación le mostramos los proyectos agrupados en las diferentes convocatorias, asi como los ciclos formativos (ASIR / DAW) al que pertenecen.</p>
		<?php
		$var = Convocatoria::singleton_convocatoria();
		$convocatorias = $var->get_convocatorias();

		foreach ($convocatorias as $key ) {
		if ($key['estado'] == 'Actual')  {
			echo "<div class='tabla_proyectos'>";
			echo "<h2>Horario de presentaciones ".$key['convocatoria']."</h2>";

			$var = Admin::singleton_admin();
			$proyectos = $var->get_proyectos_convocatoria($key['id']);
		
			echo "<table>";
			echo "<tr><td>Titulo</td><td>Ciclo</td><td>Componentes</td><td>Fecha</td></tr>";

			foreach ($proyectos as $key2 ) {
			echo "<tr>";
			echo "<td>".$key2['titulo']."</td>";
			echo "<td>".$key2['ciclo']."</td>";

			$var = Convocatoria::singleton_convocatoria();
			$componentes = $var->get_componentes($key2['proyecto_id']);
			
			echo "<td>";
			foreach ($componentes as $key3) {
				echo $key3['nombre']."<br>";
			}
			echo "</td>";

			echo "<td>".$key2['fechaPresentacion']." / ".$key2['horaPresentacion']."</td>";
			echo "</tr>";

			}
			echo "</div>";
            
            echo "</table>";

            
            echo "</div>";

		}
	}



			$var = Convocatoria::singleton_convocatoria();
			$convocatorias = $var->get_convocatorias();
			echo "<div class='convocatorias'>";

			foreach ($convocatorias as $key) {
					echo "<div class='convocatoria'>";
							echo "<h3>$key[convocatoria]</h3>";
							echo "<div class='ciclo'>";
								echo "<form action='index.php?page=mostrar' method='post'>";
									echo "<input type='hidden' name='idConvocatoria' value='$key[id]'>";
									echo "<h4>ASIR</h4>";
									echo "<p>Admin. de Sistemas Informáticos en Red</p>";
									echo "<input type='submit' name='asir' value='Ver proyectos'>";
									echo "<input type='hidden' name='ciclo' value='ASIR'>";

								echo "</form>";			
							echo "</div>";
							
							echo "<div class='ciclo'>";
								echo "<form action='index.php?page=mostrar' method='post'>";
									echo "<input type='hidden' name='idConvocatoria' value='$key[id]'>";
									echo "<h4>DAW</h4>";
									echo "<p>Desarrollo de Aplicaciones Web</p>";
									echo "<input type='submit' name='daw' value='Ver proyectos'>";
									echo "<input type='hidden' name='ciclo' value='DAW'>";

								echo "</form>";
							echo "</div>";
					echo "</div>";

			}

			echo "</div>";
		?>
			
		</div>
		
	</div>
	<div class="side">
	<div class="buscar">
            <?php
            echo "<form action='index.php?page=mostrar' method='post'>";
            echo "<input type='search' name='busqueda' placeholder='Buscar proyecto...'>";
            echo "<input type='submit' name='buscar' value=' '>";
            echo "</form>";
            ?>
        </div>
			<h2>Nube de etiquetas</h2>
			<?php
				mostrarNubeEtiquetas();
			?>

	</div>
	</div>