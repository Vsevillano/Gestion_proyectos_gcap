<?php 
    require_once('php/clases/Convocatoria.php');

?>
    
        
	<div class="contenido">

		<div class="info">
			
        <?php
        // Si se accede por busqueda directa

        if(!isset($_POST['buscar']) && !isset($_GET['etiqueta']) ) {
            $var = Convocatoria::singleton_convocatoria();
            $convocatoria = $var->get_convocatoria($_POST['idConvocatoria']);
            
            echo "<h2>".$convocatoria['convocatoria']." > ".$_POST['ciclo']. "</h2>";
            
			$var = Convocatoria::singleton_convocatoria();
            $proyectos = $var->get_proyectos_convocatoria($_POST['idConvocatoria'], $_POST['ciclo']);
        
            // Comprobamos que al menos hay 1 proyecto, sino informamos al usuario
            if(!empty($proyectos)){
                echo "<div class='convocatorias'>";
                    foreach ($proyectos as $key) {
                            echo "<div class='proyectos'>";
                            echo "<form action='index.php?page=proyecto' method='post'>";
                                echo "<img src='$key[logo]'>";
                                echo "<h3>$key[titulo]</h3>";
                                echo "<p>$key[descripcion]</p>";
                                echo "<input type='hidden' name='idProyecto' value='$key[proyecto_id]'>";
                                echo "<input type='submit' name='ver' value='Ver'>";
                                echo "</form>";
                            echo "</div>";
                    }
                echo "</div>";
            }
            else {
                echo "<h3>Aún no hay proyectos para esta convocatoria</h3>";
            }
        }
        else if (isset($_POST['buscar'])) {
        $var = Convocatoria::singleton_convocatoria();
        $proyectos = $var->buscar_proyecto($_POST['busqueda']);        
        // Comprobamos que al menos hay 1 proyecto, sino informamos al usuario
            if(!empty($proyectos)){
            echo "<div class='convocatorias'>";
                foreach ($proyectos as $key) {
                        echo "<div class='proyectos'>";
                        echo "<form action='index.php?page=proyecto' method='post'>";
                            echo "<img src='$key[logo]'>";
                            echo "<h3>$key[titulo]</h3>";
                            echo "<p>$key[descripcion]</p>";
                            echo "<input type='hidden' name='idProyecto' value='$key[proyecto_id]'>";
                            echo "<input type='submit' name='ver' value='Ver'>";
                            echo "</form>";
                        echo "</div>";
                }
            echo "</div>";
            }
            else {
                echo "<h3>No se ha encontrado ningun resultado para la busqueda '".$_POST['busqueda']."'</h3>";
            }
        }
        else {
        $var = Convocatoria::singleton_convocatoria();
        $proyectos = $var->buscar_proyecto($_GET['etiqueta']);        
        // Comprobamos que al menos hay 1 proyecto, sino informamos al usuario
        if(!empty($proyectos)){
            echo "<div class='convocatorias'>";
                foreach ($proyectos as $key) {
                        echo "<div class='proyectos'>";
                        echo "<form action='index.php?page=proyecto' method='post'>";
                            echo "<img src='$key[logo]'>";
                            echo "<h3>$key[titulo]</h3>";
                            echo "<p>$key[descripcion]</p>";
                            echo "<input type='hidden' name='idProyecto' value='$key[proyecto_id]'>";
                            echo "<input type='submit' name='ver' value='Ver'>";
                            echo "</form>";
                        echo "</div>";
                }
            echo "</div>";
        }
    }
		?>
			
		</div>

	</div>