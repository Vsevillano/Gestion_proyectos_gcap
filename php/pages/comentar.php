<?php
    require_once('php/clases/Convocatoria.php');

    // Comprobamos si esta activa la sesion
    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }

    // Comprobamos que el token y el usuario coincidan, sino redireccionamos
    if(isset($_GET['token']) && isset($_GET['idProyecto']) ) {
        $var = Convocatoria::singleton_convocatoria();
        $comentario = $var->comprobarTokenComentario($_GET['token'], $_GET['idProyecto']);

        if(empty($comentario)) {
            header('Location: index.php?page=inicio&error=7');
        }
    }
    else {
        header('Location: index.php?page=inicio');
    }

    // Si pulsa registrar, registramos al usuario
    if(isset($_POST['comentar_proyecto'])) {
        $var = Convocatoria::singleton_convocatoria();
        $var->actualiza_comentario($_POST['idProyecto'], $_POST['nombre_comentador'], $_POST['comentario']); 
    }

?>
<div class="contenido">
		<div class="info">        
            <h2>Comentar proyecto </h2>
            <form action="index.php?page=comentar" method="post">
                <fieldset>
                    <input type="hidden" name="idProyecto" value="<?php echo $_GET['idProyecto']; ?>"><br><br>
                    <legend>Comentar proyecto</legend>
                    <label for="nombre_comentador">Nombre completo</label><br><br>
                    <input type="text" name="nombre_comentador" id="nombre_comentador"><br><br>
                    <label for="comentario">Comentario</label><br><br>
                    <textarea name="comentario" id="comentario" cols="30" rows="10"></textarea><br><br>
                    <input type="submit" name="comentar_proyecto" value="Comentar proyecto"><br><br>
                </fieldset>
                
            </form>
        </div>
    </div>