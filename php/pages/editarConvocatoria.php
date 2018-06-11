<?php
    require_once('php/clases/Convocatoria.php');
    require_once('php/clases/Admin.php');
	require_once('php/clases/config.php');

    $error = '';

    if($_SESSION['login']['Perfil'] != 'Admin') {
        header('Location: index.php');
    }

    // Activa los comentarios para ese proyecto
    if (isset($_POST['activar_comentarios'])) {
        $var = Convocatoria::singleton_convocatoria();
            
        $var->activar_comentarios($_POST['id_comentario1']);
        header('Location: index.php?page=gestion');
    }
    
    // Desactiva los comentarios para ese proyecto
    if (isset($_POST['desactivar_comentarios'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->desactivar_comentarios($_POST['id_comentario2']);
        header('Location: index.php?page=gestion');
    }

    // Borra un proyecto
    if(isset($_POST['borrar_proyecto'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->borrar_proyecto($_POST['idProyecto']);
        header('Location: index.php?page=gestion');
    }


?>
	<div class="contenido">
		<div class="info">  
        
        <?php 
        $var = Convocatoria::singleton_convocatoria();
        $convocatorias = $var->get_convocatoria_nombre($_POST['convocatoria_editar']);
        $proyectos = $var->get_proyectos_convocatoria_id($convocatorias['id']);
        if ($convocatorias['convocatoria'] == $_POST['convocatoria_editar'] ) {
                echo "<h2>Edicion de convocatoria ".$convocatorias['convocatoria']." (".$convocatorias['estado'].")</h2>";
            
        }
        ?>
        
        <br>
        <div class="contenedor_busqueda">
            <div class="buscar">
                <?php
                echo "<form action='index.php?page=mostrar' id='busqueda' method='post'>";
                echo "<input type='search' name='busqueda' placeholder='Buscar proyecto...'>";
                echo "<input type='submit' name='buscar' value=' '>";
                echo "</form>";
                ?>
            </div>
            <?php
                
                
                if ($convocatorias['estado'] == 'Abierta') {
                    echo "<form action='index.php?page=altas' id='' method='post'>";
                    echo "<input type='submit' name='registrar_proyecto' value='Registrar Proyecto'>";
                    echo "<input type='hidden' name='idConvocatoria' value=$convocatorias[id]>";
                    echo "</form>";
                }
            ?>
        </div>
        <br><br>
            <?php



            
            echo "<br><br>";
            echo "<div class='tabla_proyectos'>";
            echo "<table>";
            echo "<tr><td>Email</td><td>Estado</td><td>Titulo</td><td>Ciclo</td><td>Fecha</td><td>Componentes</td><td>Acciones</td></tr>";
            foreach ($proyectos as $key) {
                    echo "<tr>";
                    
                    echo "<td>".$key['email']."</td>";
                    echo "<td>";
                    switch($key['registrado']) {
                        case 0:
                            echo "Pendiente";
                        break;
                        case 1:
                            echo "Registrado";
                        break;
                    }
                    echo "</td>";


                    echo "<td>";
                    if ($key['titulo'] != '') {
                        echo "<form action='index.php?page=proyecto' method='post'>";
                        echo "<input type='hidden' name='idProyecto' value='$key[proyecto_id]'>";
                        echo "<input style='width:100%' type='submit' name='ver' value='$key[titulo]'>";
                        echo "</form>";
                    }
                    
                    echo "</td>";
                    echo "<td>".$key['ciclo']."</td>";

                    if ($key['fechaPresentacion'] != '' && $key['horaPresentacion'] != ''){
                        if ($key['registrado'] == '1') {
                            echo "<td>Presenta ".$key['fechaPresentacion']." / ".$key['horaPresentacion']."</td>";
                        }
                        else {
                            echo "<td>Expira ".$key['expiracion']."</td>";
                        }
                    }
                    else {
                            echo "<td>-</td>";
                    }

                    $var = Convocatoria::singleton_convocatoria();
                    $componentes = $var->get_componentes($key['proyecto_id']);
                    echo "<td>";
                        foreach ($componentes as $key2) {
                           echo $key2['nombre']."<br><br>";
                        }
                    echo "</td>";

                    echo "<td id='columna_35'>";
                        switch ($convocatorias['estado']) {

                            case 'Abierta':
                                //Borrar proyecto 
                                echo "<form action='index.php?page=editarConvocatoria' id='form_acciones2' method='post'>";
                                echo "<input type='hidden' name='idProyecto' value=$key[proyecto_id]>";
                                echo "<input type='submit' name='borrar_proyecto' value='Borrar'>";
                                echo "</form>";

                                // Asignar fecha
                                    if ($key['registrado'] == '1') {
                                        echo "<form action='index.php?page=asignarFecha' id='form_acciones2' method='post'>";
                                        echo "<input type='submit' name='asignar_fecha' value='Asig. Fecha'>";
                                        echo "<input type='hidden' name='idProyecto' value=$key[proyecto_id]>";
                                        echo "</form>";
                                    }
                                

                                // Regenerar token
                                if ($key['registrado'] == '0') {
                                echo "<form action='index.php?page=alargarFecha' id='form_acciones2' method='post'>";
                                echo "<input type='submit' name='alargar_fecha' value='Regenerar token'>"; 
                                echo "<input type='hidden' name='idProyecto' value=$key[proyecto_id]>";
                                echo "</form>";
                                }
                            break;

                            case 'Actual':
                                // Borrar proyecto
                                echo "<form action='index.php?page=editarConvocatoria' id='form_acciones2' method='post'>";
                                echo "<input type='hidden' name='id_comentario2' value='$key[proyecto_id]'>";
                                echo "<input type='submit' name='borrar_proyecto' value='Borrar'>";
                                echo "</form>";                                
                                
                                // Evaluar proyecto
                                if ($key['registrado'] == '1') {
                                echo "<form action='index.php?page=evaluarProyecto' id='form_acciones2' method='post'>";
                                echo "<input type='submit' name='evaluar_proyecto' value='Evaluar'>";
                                echo "<input type='hidden' name='idProyecto' value=$key[proyecto_id]>";
                                echo "</form>"; 
                                                           
                                
                                
                                // Âctivar / Desactivar comentarios
                                $var = Convocatoria::singleton_convocatoria();
                                $proyecto = $var->get_proyecto($key['proyecto_id']);

                                if ($proyecto['activarEdicion'] == 0) {
                                    echo "<form id='form_acciones2' action='index.php?page=editarConvocatoria' method='post'>";
                                    echo "<input type='hidden' name='id_comentario1' value='$key[proyecto_id]'>";
                                    echo "<input type='submit' name='activar_comentarios' value='Activar coment.'>";
                                    echo "</form>";  
                                }
                                else {
                                    echo "<form id='form_acciones2' action='index.php?page=editarConvocatoria' method='post'>";
                                    echo "<input type='hidden' name='id_comentario2' value='$key[proyecto_id]'>";
                                    echo "<input type='submit' name='desactivar_comentarios' value='Desactivar coment.'>";
                                    echo "</form>";
                                }   
                            }      
                                break;

                           default:
                           $var = Convocatoria::singleton_convocatoria();
                           $proyecto = $var->get_proyecto($key['proyecto_id']);
                                // Borrar proyecto
                                echo "<form action='index.php?page=editarConvocatoria' id='form_acciones2' method='post'>";
                                echo "<input type='hidden' name='id_comentario2' value='$key[proyecto_id]'>";
                                echo "<input type='submit' name='borrar_proyecto' value='Borrar'>";
                                echo "</form>";   
                                
                                // Descargar proyecto
                                echo "<form action='$proyecto[codigo]' id='form_acciones2' method='post'>";
                                echo "<input type='submit' name='descargar_proyecto' value='Descargar'>";
                                echo "</form>";   
                            break;
                        }

                        echo "</form>";

                    echo "</td>";

                    echo "</tr>";
            }
            echo "</table>";

            
            echo "</div>";
            ?>
        </div>
    </div>
