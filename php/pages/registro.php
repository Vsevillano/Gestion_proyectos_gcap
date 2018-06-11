<?php
    require_once('php/clases/Admin.php');

    // Comprobamos si esta activa la sesion
    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }

    // Comprobamos que el token y el usuario coincidan, sino redireccionamos
    if(isset($_GET['token']) && isset($_GET['idUser']) ) {
        $var = Admin::singleton_admin();
        $usuario = $var->comprobarToken($_GET['token'], $_GET['idUser']);
        if(empty($usuario)) {
            header('Location: index.php?page=inicio&error=1');
        }
    }
    else {
        header('Location: index.php?page=inicio');
    }

    // Si pulsa registrar, registramos al usuario
    if(isset($_POST['registrar'])) {
        if ($_POST['password'] == $_POST['password2']) {
            $var = Admin::singleton_admin();
            $var->actualiza_usuario($_POST['idUser'], $_POST['nombre'], $_POST['password'], $_POST['usuario']);
        }
    }

?>
<div class="contenido">
		<div class="info">        
            <h2>Registro de usuarios</h2>
            <form action="index.php?page=registro" method="post">
                <fieldset>
                    <input type="hidden" name="idUser" value="<?php echo $_GET['idUser']; ?>"><br><br>
                    <legend>Registro de usuarios</legend>
                    <label for="nombre">Nombre completo</label><br><br>
                    <input type="text" name="nombre" id="nombre"><br><br>
                    <label for="usuario">Usuario</label><br><br>
                    <input type="text" name="usuario" id="usuario"><br><br>
                    <label for="password">Contraseña</label><br><br>
                    <input type="password" name="password" id="password"><br><br>
                    <label for="password">Repetir Contraseña</label><br><br>
                    <input type="password" name="password2" id="password2"><br><br>
                    <input type="submit" name="registrar" value="Registrar"><br><br>
                </fieldset>
            </form>
        </div>
    </div>