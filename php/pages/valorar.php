<?php
    require_once('php/clases/Convocatoria.php');

    // Comprobamos si esta activa la sesion
    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }

    // Comprobamos que el token y el usuario coincidan, sino redireccionamos
    if(isset($_GET['token']) && isset($_GET['idProyecto']) ) {
        $var = Convocatoria::singleton_convocatoria();
        $comentario = $var->comprobarTokenValoracion($_GET['token'], $_GET['idProyecto']);

        if(empty($comentario)) {
            header('Location: index.php?page=inicio&error=9');
        }
    }
    else {
        header('Location: index.php?page=inicio');
    }

    // Si pulsa registrar, registramos al usuario
    if(isset($_POST['valorar_proyecto'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->actualiza_valoracion($_POST['idProyecto'], $_POST['puntuacion_valoracion'], $_POST['nombre_valorador']); 
    }

?>
<div class="contenido">
		<div class="info">        
            <h2>Valorar proyecto </h2>
            <form action="index.php?page=valorar" method="post">
                <fieldset>
                    <input type="hidden" name="idProyecto" value="<?php echo $_GET['idProyecto']; ?>"><br><br>
                    <legend>Valoración de proyectos</legend>
                    <label for="nombre_comentador">Nombre completo</label><br><br>
                    <input type="text" name="nombre_valorador" id="nombre_comentador"><br><br>
                    <label for="comentario">Puntuación</label><br><br>
                    <select name="puntuacion_valoracion" id="puntuacion">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <br><br>
                    <input type="submit" name="valorar_proyecto" value="Valorar proyecto"><br><br>
                </fieldset>
                
            </form>
        </div>
    </div>