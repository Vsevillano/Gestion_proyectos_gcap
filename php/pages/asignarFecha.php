<?php
    require_once('php/clases/Admin.php');
    require_once('php/clases/Convocatoria.php');


    if($_SESSION['login']['Perfil'] != 'Admin') {
        header('Location: index.php');
    }


    // Asignamos fecha a todos los proyectos
    if (isset($_POST['cambiar_fecha'])) {
        $fecha = $_POST['fechaPresentacion'];
        $hora = $_POST['horaPresentacion'];
        $id = $_POST['idProyecto'];

        $var = Admin::singleton_admin();
        $var->asignar_fecha($id, $fecha, $hora);
        header('Location: index.php?page=gestion');
    }

?>
	<div class="contenido">
		<div class="info">  
        <h2>Asignación de fecha de presentacion</h2>
        <p>Como administrador del sistema, ahora puedes asignar fecha (dia y hora) para la presentacion del proyecto.</p>
        <p>A continuación se muestra el formulario, donde podrás realizarlo.</p>
            <?php
            $var = Convocatoria::singleton_convocatoria();
            $proyectos = $var->get_proyecto($_POST['idProyecto']);
            echo "<div class='proyecto'>";
                echo "<form action='index.php?page=asignarFecha' method='post'>";
                echo "<input type='hidden' name='idProyecto' value='$proyectos[proyecto_id]'>";
                echo "<h2>Titulo: ".$proyectos['titulo']."</h2>";
                echo "<label for='fechaPresentacion'>Fecha de presentacion</label>";
                echo "<input type='date' name='fechaPresentacion' value='".$proyectos['fechaPresentacion']."'></br></br>";
                echo "<label for='horaPresentacion'>Hora de presentacion</label>";
                echo "<input type='time' name='horaPresentacion' value='".$proyectos['horaPresentacion']."'></br></br>";
                echo "<input type='submit' name='cambiar_fecha' value='Asignar fecha/hora'>";
                echo "</form>";
            echo "</div>";



            ?>
        </div>
    </div>
