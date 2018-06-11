<?php 

    require_once('php/clases/Admin.php');

    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }


    if(isset($_POST['recuperar'])){
        $var = Admin::singleton_admin();
        $var->recuperar_pass($_POST['correo_recuperacion']);   
        header('Location: index.php?page=inicio&error=13');

    }
    
    if(isset($_POST['actualizar_contraseña'])){
        if ($_POST['nueva_pass'] == $_POST['repetir_nueva_pass']) {
            $var = Admin::singleton_admin();
            $var->actualizar_pass($_POST['id_usuario'], $_POST['nueva_pass']);   
            header('Location: index.php?page=inicio&error=12');
        }
        else {
            header('Location: index.php?page=inicio&error=14');
        }
    }

    if(isset($_GET['token']) && isset($_GET['email']) ) {
        $var = Admin::singleton_admin();
        $usuario = $var->comprobarTokenRecuperacion($_GET['token'], $_GET['email']);
        if(empty($usuario)) {
            header('Location: index.php?page=inicio&error=11');
        }
        else {
        ?>

        <div class="contenido">
            <div class="info">
		    <div class="col-25">        
            <h2>Actualizar contraseña</h2>
            <p>A continuacion podrá cambiar su contraseña en el siguiente formulario. Una vez cambiadas, pruebe a logearse en el sistema</p>
            <form action="index.php?page=cambiarPass" method="post">
                <fieldset>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id'] ?>"><br><br>
                    <label for="Nueva contraseña">Nueva contraseña</label><br><br>
                    <input type="password" name="nueva_pass" id="nueva_pass"><br><br>
                    <br><br>
                    <label for="repetir contraseña">Repetir contraseña</label><br><br>
                    <input type="password" name="repetir_nueva_pass" id="repetir_nueva_pass"><br><br>
                    <br><br>
                    <input type="submit" name="actualizar_contraseña" value="Actualizar"><br><br>
                </fieldset>
            </form>
            </div>
        </div>
    </div>
    
    <?php
        } 
    }
    else {
?>

	<div class="contenido">
    <div class="info">
		<div class="col-25">        
            <h2>Reuperar contraseña</h2>
            <p>Inserte su correo electronico para cambiar la contraseña. A continuacion se le enviará un email, donde usted mismo podrá restablecer su contraseña.</p>
            <form action="index.php?page=cambiarPass" method="post">
                <fieldset>
                    <label for="usuario">Correo electronico</label><br><br>
                    <input type="text" name="correo_recuperacion" id="correo_recuperacion"><br><br>
                    <br><br>
                    <input type="submit" name="recuperar" value="Recuperar"><br><br>

                </fieldset>
            </form>
            </div>
        </div>
    </div>


<?php
    }
