<?php
    require_once('php/clases/Admin.php');
    require_once('php/clases/Convocatoria.php');


    if($_SESSION['login']['Perfil'] != 'Admin') {
        header('Location: index.php');
    }


    // Para alargar fecha del proyecto (regenerar token)
    if(isset($_POST['actualizar_fecha'])) {
        $var = Convocatoria::singleton_convocatoria();
        $tiempo = $_POST['tiempo'];
        $var->alargar_fecha_proyecto($_POST['idProyecto'], $tiempo);
        header('Location: index.php?page=gestion&error=2');
    }

    $fecha = mktime(0, 0, 0, date("m") , date("d") , date("Y"));
    $fecha = date("Y-m-d", $fecha); 
    $fecha = split('-',$fecha);
    $fecha = $fecha[2].'/'.$fecha[1].'/'.$fecha[0];

?>
	<div class="contenido">
		<div class="info">  
        <h2>Alargar token para proyecto</h2>
        
        <p>Como administrador del sistema, ahora puedes alargar la fecha de expiración del token para poder registrar el proyecto.</p>
        <p>A continuación se muestra el formulario, donde podrás alargar <strong>a partir de la fecha de hoy (<?php echo $fecha ?>)</strong> el numero de días que quiera.</p>
            <?php
            $var = Convocatoria::singleton_convocatoria();
            $proyectos = $var->get_proyecto($_POST['idProyecto']);
            $proyectos2 = $var->get_proyecto_proyecto($_POST['idProyecto']);

                echo "<div class='evaluacion'>";
                echo "<form action='index.php?page=alargarFecha' method='post'>";

                echo "<h3>Alargar el tiempo para '".$proyectos['titulo']."'</h3>";

                $fecha = split('-',$proyectos2['expiracion']);
                $fecha = 'Dia '.$fecha[2].' del mes '.$fecha[1].' del año '.$fecha[0];
                echo "<input type='hidden' name='idProyecto' value='$proyectos[proyecto_id]'>";
                echo "<p>Fecha de expiracion del token: ".$fecha."</p>";

                echo "<label for='tiempo'>Nº de dias:</label>";
                echo "<input type='number' min='1' name='tiempo'>"; 
                echo "<br><br>";
                echo "<input type='submit' name='actualizar_fecha' value='Alargar fecha'>";
                echo "</form>";

                echo "</div>";


            ?>
        </div>
    </div>
