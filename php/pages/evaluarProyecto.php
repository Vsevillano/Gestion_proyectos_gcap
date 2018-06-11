<?php
    require_once('php/clases/Admin.php');
    require_once('php/clases/Convocatoria.php');


    if($_SESSION['login']['Perfil'] != 'Admin') {
        header('Location: index.php');
    }


    // Asignamos la nota
    if (isset($_POST['asignar_nota'])) {
        $var = Admin::singleton_admin();
        $var->asignar_nota($_POST['idProyecto'], $_POST['nota']);
        header('Location: index.php?page=gestion');
    }

?>
	<div class="contenido">
		<div class="info">  
        <h2>Evaluacion de proyectos</h2>
        <p>Como administrador del sistema, ahora puedes evaluar la nota del proyecto entre 0 y 10.</p>
        <p>A continuación se muestra el formulario, donde podrás dicha calificación.</p>
            <?php
            $var = Convocatoria::singleton_convocatoria();
            $proyectos = $var->get_proyecto($_POST['idProyecto']);

            echo "<form action='index.php?page=evaluarProyecto' method='post'>";
                echo "<div class='evaluacion'>";
                echo "<h3>Nota para el proyecto ".$proyectos['titulo']."</h3>";

                echo "<input type='hidden' name='idProyecto' value='$proyectos[proyecto_id]'>";
                echo "<label for='nota'>Nota del proyecto</label>";
                echo "<input type='number' min='0' max='10' name='nota' value='$proyectos[calificacion]'>";
                echo "<br><br>";
                echo "<input type='submit' name='asignar_nota' value='Evaluar Proyecto'>";
                echo "</form>";

                echo "</div>";


            ?>
        </div>
    </div>
