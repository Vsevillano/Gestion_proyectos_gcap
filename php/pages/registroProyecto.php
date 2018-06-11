<?php
    require_once('php/clases/Convocatoria.php');
    require_once('php/clases/Admin.php');

    // Comprobamos si esta activa la sesion
    if(isset($_SESSION['login'])) {
        header('Location: index.php?page=inicio');
    }

    // Comprobamos que el token y el usuario coincidan, sino redireccionamos
    if(!isset($_POST['registrarProyecto'])) {
    if(isset($_GET['token']) && isset($_GET['idProyecto']) ) {
        $var = Admin::singleton_admin();
        $usuario = $var->comprobarTokenProyecto($_GET['token'], $_GET['idProyecto']);
        if(empty($usuario)) {
            header('Location: index.php?page=inicio&error=2');
        }
    }
    else {
        header('Location: index.php?page=inicio');
    }
    }


    // Si pulsa registrar, registramos el proyecto
    if(isset($_POST['registrarProyecto'])) {
        $var = Convocatoria::singleton_convocatoria();

     
        
        // Registramos cada uno de los componentes
        $componentes = $_POST['nombre_componente'];
        $emails = $_POST['email_componente'];
        $imagen = $_FILES['imagen_componente'];
        foreach ($componentes as $key => $value) {
            
            // Subimos imagen del componente
            if(file_exists("upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($imagen['name'][$key]," ", "-"))){
	            echo $imagen['tmp_name'][$key]. " ya existe. ";
	        }else{
	            $rutaUp = "upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($imagen['name'][$key]," ", "-");
		        move_uploaded_file($imagen['tmp_name'][$key],$rutaUp);
                $imagen['name'][$key] = $rutaUp;
            }

            // Insertamos el componente
            if ($value != '' &&  $emails[$key] != '' && $imagen['name'][$key] != '' ) {
                $var->insertar_componente($_POST['idProyecto'], $value, $emails[$key], $imagen['name'][$key]);
            }
        }

        // Subimos el comprimido
        if(file_exists("upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($_FILES['archivo']['name']," ", "-"))){
		    echo $_FILES['archivo']['name']. " ya existe. ";
		  }else{
		    $rutaUp = "upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($_FILES['archivo']['name']," ", "-");
		    move_uploaded_file($_FILES['archivo']['tmp_name'],$rutaUp);
            $_FILES['archivo']['name'] = $rutaUp;
          }

        $codigo = $_FILES['archivo']['name'];

        // Subimos la imagen del proyecto
        if(file_exists("upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($_FILES['logo_proyecto']['name']," ", "-"))){
		    echo $_FILES['logo_proyecto']['name']. " ya existe. ";
		  }else{
		    $rutaUp = "upload/dir".$_POST['idProyecto']."/".date('Y').date('d').date('m').date('H').date('i').date('s').strtr($_FILES['logo_proyecto']['name']," ", "-");
		    move_uploaded_file($_FILES['logo_proyecto']['tmp_name'],$rutaUp);
            $_FILES['logo_proyecto']['name'] = $rutaUp;
          }
        
        // Actualizamos la tabla ficha_proyecto
        $logo = $_FILES['logo_proyecto']['name'];

        $var->actualizar_proyecto_registro($_POST['idProyecto'], $_POST['titulo_proyecto'], $_POST['descripcion_proyecto'], $_POST['enlace_interno'], $_POST['enlace_externo'],$_POST['enlace_repositorio'],$_POST['etiquetas_proyecto'], $codigo, $logo );
        // Actualizamos la tabla proyecto
        $var->actualizar_fichaProyecto($_POST['idProyecto'], $_POST['ciclo_proyecto']);

        // Redireccionamos avisando que todo ha ido correctamente
        header('Location: index.php?page=inicio&error=3');


    }

?>
<div class="contenido">
		<div class="info">        
            <h2>Registro de proyectos</h2>
            <form action="index.php?page=registroProyecto" method="post" enctype="multipart/form-data">
                <fieldset>
                    <input type="hidden" name="idProyecto" value="<?php echo $_GET['idProyecto']; ?>"><br><br>
                    <legend>Registro de poyectos</legend>
                    <label for="ciclo_proyecto">Ciclo formativo del proyeto</label><br><br>
                    <select name="ciclo_proyecto" id="ciclo_proyecto">
                    <option value="ASIR">ASIR</option>
                    <option value="DAW">DAW</option>
                    </select><br><br>
                    <label for="titulo_proyecto">Titulo del proyecto</label><br><br>
                    <input type="text" name="titulo_proyecto" id="titulo_proyecto"><br><br>
                    <label for="descripcion_proyecto">Descripcion del proyecto</label><br><br>
                    <textarea name="descripcion_proyecto" id="descripcion_proyecto" cols="30" rows="10"></textarea>
                    <label for="enlace_interno">Enlace interno</label><br><br>
                    <input type="text" name="enlace_interno" id="enlace_interno"><br><br>
                    <label for="enlace_externo">Enlace externo</label><br><br>
                    <input type="text" name="enlace_externo" id="enlace_externo"><br><br>
                    <label for="enlace_repositorio">Enlace repositorio</label><br><br>
                    <input type="text" name="enlace_repositorio" id="enlace_repositorio"><br><br>
                    <label for="archivo">Subida del Archivo (.zip)</label><br><br>
                    <input type="file" name="archivo" id="archivo"><br><br>
                    <label for="logo_proyecto">Imagen del proyecto </label><br><br>
                    <input type="file" name="logo_proyecto" id="logo_proyecto"><br><br>
                    <label for="etiquetas_proyecto">Etiquetas (separadas por espacio)</label><br><br>
                    <textarea name="etiquetas_proyecto" id="etiquetas_proyecto" cols="30" rows="5"></textarea>
                    
                    <div class="annadir">
                    <h2>Componentes</h2><input type='button' id='add_componente' name='add_componente' value='+'>
                    </div>
                    <div id="wrapComponentes">
                    <div id="componentes">
                        <label for="nombre_componente">Nombre del componente</label><br><br>
                        <input type="text" name="nombre_componente[]" id="nombre_componente"><br><br>
                        <label for="email_componente">Email del componente</label><br><br>
                        <input type="email" name="email_componente[]" id="email_componente"><br><br>
                        <label for="imagen_componente">Imagen del componente</label><br><br>
                        <input type="file" name="imagen_componente[]" id="imagen_componente"><br><br>
                    </div>
                    </div>

                    <input type="submit" name="registrarProyecto" value="Registrar"><br><br>
                </fieldset>
            </form>
        </div>
    </div>