<?php 

    require_once('php/clases/Login.php');

    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }

    $error = '';

    if(isset($_POST['login'])){
        $var = Login::singleton_login();
        $perfil = $var->loginUsuario($_POST['usuario'], $_POST['password']);
        
        switch ($perfil['Perfil']) {
            case 'Admin':
                $_SESSION['login'] = $perfil;
                header('Location: index.php?page=gestion');
                break;
            default:
                $error = "Usuario o contraseña incorrecta";
            break;
        }
	}
?>

	<div class="contenido">
    <div class="info">
		<div class="col-25">        
            <h2>Login</h2>
            <form action="index.php?page=login" method="post">
                <fieldset>
                    <label for="usuario">Usuario</label><br><br>
                    <input type="text" name="usuario" id="usuario"><br><br>
                    <label for="password">Contraseña</label><br><br>
                    <input type="password" name="password" id="password"><br><br>
                    <br><br>
                    <input type="submit" name="login" value="Login"><br><br>
                    <?php
                        if($error != '') {
                            echo "<span style=color:red>".$error."<span>";
                        }
                    ?>
                </fieldset>
            </form>
            </div>
        </div>
    </div>

