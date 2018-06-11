<?php 
    require_once('php/clases/Convocatoria.php');


    // Si se quiere comentar, se envia un correo al correo que ha introducido el usuario
    if(isset($_POST['enviar_comentar'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->solicitar_comentario($_POST['idProyecto'], $_POST['email_comentario']);
        header('Location: index.php?page=inicio&error=6');
    }

    // Para insertar valoraciones en el proyecto
    if(isset($_POST['enviar_valoracion'])) {
        $var = Convocatoria::singleton_convocatoria();
        
        $valoracion = $var->comprobarCorreoValoracion($_POST['idProyecto'], $_POST['email_valoracion']);

        if (!empty($valoracion)) {
            header('Location: index.php?page=inicio&error=10');
        }
        else {
            $var->solicitar_valoracion($_POST['idProyecto'], $_POST['email_valoracion']);
        }
    }

    // Activa los comentarios para ese proyecto
    if (isset($_POST['activar_comentarios'])) {
        $var = Convocatoria::singleton_convocatoria();
        
        $var->activar_comentarios($_POST['id_comentario1']);
        header('Location: index.php?page=inicio');
    }

    // Desactiva los comentarios para ese proyecto
    if (isset($_POST['desactivar_comentarios'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->desactivar_comentarios($_POST['id_comentario2']);
        header('Location: index.php?page=inicio');
    }

    // Para insertar anotaciones en el proyecto
    if(isset($_POST['enviar_anotacion'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->insertar_anotacion($_POST['idProyecto'], $_POST['anotacion']);
        header('Location: index.php?page=inicio');
    }



?>
	<div class="contenido">
		<div class="info">
		<?php
			$var = Convocatoria::singleton_convocatoria();
            $proyecto = $var->get_proyecto($_POST['idProyecto']);
            echo '<h2>Proyecto "'.$proyecto['titulo'].'"</h2>';
            
            // Activar / desactivar comentarios (solo admin)
            if(isset($_SESSION['login']['Perfil'])) {
                if ($proyecto['activarEdicion'] == 0) {
                    echo "<form id='info' action='index.php?page=proyecto' method='post'>";
                    echo "<input type='hidden' name='id_comentario1' value='$proyecto[proyecto_id]'>";
                    echo "<input type='submit' name='activar_comentarios' value='Activar comentarios'>";

                    echo "</form>";
                    echo "<br><br><br>";
                }
                 else {
                    echo "<form id='info' action='index.php?page=proyecto' method='post'>";
                    echo "<input type='hidden' name='id_comentario2' value='$proyecto[proyecto_id]'>";
                    echo "<input type='submit' name='desactivar_comentarios' value='Desactivar comentarios'>";

                    echo "</form>";
                    echo "<br><br><br>";
                } 
            }
        
                echo "<div class='proyecto'>";
                    echo "<div class='proyecto_imagen'>";
                        echo "<img src='$proyecto[logo]'>";
                        
                        $var = Convocatoria::singleton_convocatoria();
                        $valoracion = $var->get_valoracion($proyecto['proyecto_id']);
                        
                        // Si se han realizado valoraciones para ese proyecto
                        if (!empty($valoracion)) {
                            $suma = 0;
                            // Realizamos la suma de todas las valoraciones
                            foreach ($valoracion as $key) {
                                $suma += $key['valoracion'];
                                
                            }
                            // Y dividimos entre el total
                            $suma = $suma / count($valoracion);
                        }

                        // Y mostramos en funcion de los resultados
                        if(empty($valoracion)) {
                            echo "<h3>Valoracion media: Aun no hay</h3>";
                        }
                        else {
                            echo "<h3>Valoracion media: ".$suma."</h3>";
                        }

                    echo "</div>";    

                    echo "<div class='proyecto_imagen'>";
                            echo "<h2>$proyecto[titulo]</h2>";
                            echo "<h3>Descripción</h3>";
                            echo "<p>$proyecto[descripcion]</p>";   
                    echo "</div>";
                echo "</div>";

                echo "<div class='proyecto'>";
                echo "<h2>Componentes</h2>";
                $var = Convocatoria::singleton_convocatoria();
                $componentes = $var->get_componentes($_POST['idProyecto']);
                if (!empty($componentes)) {
                    foreach ($componentes as $key) {
                        echo "<div class='componentes'>";
                            echo "<img style='max-width:200px' src='$key[imagen]'>";
                            echo "<h4>$key[nombre]</h4>";   
                        echo "</div>";                
                    }
                }
                else {
                    echo "<p>No se han registrado componentes en este proyecto.</>";
                }
                echo "</div>";    


                echo "<div class='proyecto'>";
                    echo "<div class='proyecto_imagen'>";
                        echo "<div class='proyecto_enlaces'>";
                        echo "<h2>Enlaces al proyecto</h2>";
                            echo "<a href='$proyecto[enlaceinterno]'>Enlace interno</a>";
                            echo "<a href='$proyecto[enlaceexterno]'>Enlace externo</a>";
                            echo "<a href='$proyecto[enlacerepositorio]'>Enlace repositorio</a>";
                            echo "</form>";
                        echo "</div>";
                    echo "</div>";

                    echo "<div class='proyecto_imagen'>";
                        echo "<div class='proyecto_enlaces'>";
                        echo "<h2>Enlace de descarga</h2>";
                        echo "<a href='$proyecto[codigo]'>Descargar proyecto</a>";

                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                echo "<div class='proyecto'>";
                    echo "<h2>Comentarios</h2>";
                    $var = Convocatoria::singleton_convocatoria();
                    $comentarios = $var->get_comentarios_proyecto($proyecto['proyecto_id']);
                    if (!empty($comentarios)) {
                        foreach ($comentarios as $key ) {
                        // create a $dt object with the UTC timezone
                        $dt = new DateTime($key['fecha_comentario'], new DateTimeZone('UTC'));

                        // change the timezone of the object without changing it's time
                        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));

                        // format the datetime
                        

                            echo "<div class='comentario'>";
                            echo "<h3>".$key['nombre']."</h3>";
                            echo "<p id='fecha_comentario'>Fecha del comentario: ".$dt->format('d/m/Y')."</p>";
                            echo "<p>".$key['comentario']."</p>";
                            echo "<hr/>";
                            echo "</div>";

                        }
                    }
                    else {
                    echo "<p>Aun no hay comentarios para este proyecto</p>";        
                    }
                echo "</div>";

                if ($proyecto['activarEdicion'] == 1) {
                    echo "<div class='edicion'>";
                    echo "<div class='proyecto'>";
                    echo "<h2>Insertar comentario</h2>";
                    echo "<form action='index.php?page=proyecto' method='post'>";
                    echo "<label for='email'>Email</label>";
                    echo "<input type='email' name='email_comentario'><br><br>";
                    echo "<input type='hidden' name='idProyecto' value='$proyecto[proyecto_id]'>";
                    echo "<input type='submit' name='enviar_comentar'  id='enviar_comentar' value='Solicitar comentario'>";
                    echo "</form>";
                    echo "</div>";

                    echo "<div class='proyecto'>";
                    echo "<h2>Valorar proyecto</h2>";
                    echo "<form action='index.php?page=proyecto' method='post'>";
                    echo "<label for='email'>Email</label>";
                    echo "<input type='email' name='email_valoracion'><br><br>";
                    echo "<input type='hidden' name='idProyecto' value='$proyecto[proyecto_id]'>";
                    echo "<input type='submit' name='enviar_valoracion'  id='enviar_valoracion' value='Solicitar valoracion'>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                }

                // Si es el admin, mostramos las anotaciones del proyecto
                if (isset($_SESSION['login'])) {
                if($_SESSION['login']['Perfil'] == 'Admin') {
                    $var = Convocatoria::singleton_convocatoria();
                    $anotaciones = $var->get_anotaciones($_POST['idProyecto']); 
                    if (!empty($anotaciones)) {
                        echo "<div class='anotacion'>";
                        echo "<h2>Anotaciones</h2>";
                        foreach ($anotaciones as $key) {
                                echo "<p>Anotacion: <strong>".$key['anotacion']."</strong><p>";
                                echo "<p>Fecha de la anotacion: <strong>".$key['fecha']."</strong><p>";  
                                echo "<hr/>"; 
                        }         
                        echo "</div>"; 
                    } 
                    // Insertar anotacion
                    echo "<div class='proyecto'>";
                    echo "<h2>Insertar anotacion (admin)</h2>";
                    echo "<form action='index.php?page=proyecto' method='post'>";
                    echo "<input type='text' name='anotacion'><br><br>";
                    echo "<input type='hidden' name='idProyecto' value='$proyecto[proyecto_id]'>";
                    echo "<input type='submit' name='enviar_anotacion'  id='enviar_anotacion' value='Añadir anotacion'>";

                    echo "</form>";
                    
                    echo "</div>";
                }
            }
		?>
			
		</div>

	</div>