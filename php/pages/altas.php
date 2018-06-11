<?php 
    require_once('php/clases/Admin.php');

    if($_SESSION['login']['Perfil'] != 'Admin') {
        header('Location: index.php');
    }

    if(isset($_POST['alta'])) {
        $var = Admin::singleton_admin();
        $var->insert_usuario($_POST['email']);
        header("Location: index.php?page=gestion&error=3");

    }

    if(isset($_POST['alta_proyecto'])) {
        $var = Admin::singleton_admin();
        $var->insert_proyecto($_POST['email_proyecto'], $_POST['id_convocatoria']);
        header("Location: index.php?page=gestion&error=1");
    }

    if(!isset($_POST['registrar_proyecto'])) {

?>

	<div class="contenido">
		<div class="info">        
            <h2>Altas de usuarios</h2>
            <div class="formulario">
                <p>Para dar de alta a un usuario como Administrador del sistema, basta con introducir su correo electronico en el siguiente formulario. A través de el email enviado, el usuario podrá seguir los pasos necesarios para completar el registro. Una vez completado el registro, el usuario podrá logearse en el sistema sin problemas.</p>
                <br><br>
                <form action="index.php?page=altas" method="post">
                    <fieldset>
                    <legend>Alta de usuario</legend>

                        <label for="email">Correo electronico</label><br><br>
                        <input type="text" name="email" id="email"><br><br>
                        <input type="submit" name="alta" value="Enviar email">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php
    }
    else {
        

?>
	<div class="contenido">
		<div class="info">        
            <h2>Registro de proyectos</h2>
            <div class="formulario">
                <form action="index.php?page=altas" method="post">
                    <fieldset>
                    <legend>Nuevo proyecto</legend>

                        <label for="email">Correo electronico del alumno</label><br><br>
                        <input type="text" name="email_proyecto" id="email_proyecto"><br><br>
                        <input type="hidden" name="id_convocatoria" value="<?php echo $_POST['idConvocatoria']?>"><br><br>

                        <input type="submit" name="alta_proyecto" value="Dar de alta">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
<?php
    }
