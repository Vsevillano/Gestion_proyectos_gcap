<?php
require_once 'Conexion.php';
require_once("config.php");
require_once 'PHPMailer/PHPMailerAutoload.php';
class Convocatoria {
    
    private static $instancia;
    private $dbh;    
    
    /* Contructor de convocatoria */ 
    private function __construct(){
        try {
            $this->dbh = Conexion::singleton_conexion();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }
    
    /* Singleton para el convocatoria */ 
    public static function singleton_convocatoria() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    /* Obtiene los proyectos de una convocatoria y un ciclo */ 
    public function get_proyectos_convocatoria($id, $ciclo) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM  Pro_fichaproyecto, Pro_proyectos where Pro_proyectos.convocatoria_id = :id and Pro_proyectos.ciclo = :ciclo and Pro_proyectos.id = Pro_fichaproyecto.proyecto_id;');
            $query->bindParam(':id', $id);
            $query->bindParam(':ciclo', $ciclo);
			$query->execute();
            $this->dbh = null;
			return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los proyectos de una convocatoria y un ciclo */ 
    public function get_proyectos_convocatoria_id($id) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM Pro_convocatorias, Pro_fichaproyecto, Pro_proyectos  where Pro_proyectos.id = Pro_fichaproyecto.proyecto_id  and Pro_convocatorias.id = Pro_proyectos.convocatoria_id and Pro_proyectos.convocatoria_id = :id order by ciclo ');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los proyectos de la convocatoria 'Actual' */ 
    public function comprobar_estado_convocatoria() {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare("SELECT * from Pro_convocatorias where estado = 'Actual'");
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    // Inserta una nueva convocatoria
    public function insertar_convocatoria($convocatoria) {
        $this->dbh = Conexion::singleton_conexion();        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_convocatorias` (`id`, `convocatoria`, `estado`) VALUES (NULL, :convocatoria, 'Abierta')");
            $query->bindParam(':convocatoria', $convocatoria);
            $query->execute();           
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene una convocatoria por nombre */ 
    public function get_convocatoria_nombre($convocatoria) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('select * from Pro_convocatorias where convocatoria = :convocatoria');
            $query->bindParam(':convocatoria', $convocatoria);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene la valoracion de un proyecto por id */ 
    public function get_valoracion($id) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('select * from Pro_valoraciones where fichaproyecto_id = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los comentarios de un proyecto por id */ 
    public function get_comentarios_proyecto($id) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM `Pro_comentarios` WHERE Pro_comentarios.fichaproyecto_id = :id and activo=1');
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los componentes de un proyecto por id */ 
    public function get_componentes($id) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('select * from Pro_componentes where fichaproyecto_id = :id');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    /* Obtiene las anotaciones de un proyecto por id */ 
    public function get_anotaciones($id) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM Pro_anotaciones where Pro_anotaciones.ficha_id = :id');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Inserta una anotacion en un proyecto*/ 
    public function insertar_anotacion($id, $anotacion) { 
        // Generamos token y fecha de expiracion
        $fecha = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"));
        $fecha = date("d/m/Y", $fecha); 
        
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('INSERT INTO `Pro_anotaciones` (`id`, `anotacion`, `fecha`, `ficha_id`) VALUES (NULL, :anotacion, :fecha, :id)');
            $query->bindParam(':id', $id);
            $query->bindParam(':fecha', $fecha);
            $query->bindParam(':anotacion', $anotacion);   
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Asigna mas tiempo de registro a un proyecto*/ 
    public function alargar_fecha_proyecto($id, $tiempo) {
        $fecha = mktime(0, 0, 0, date("m") , date("d")+$tiempo , date("Y"));
        $fecha = date("Y-m-d", $fecha); 
        
        $this->dbh = Conexion::singleton_conexion();    
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_proyectos` SET `expiracion` = :fecha WHERE `Pro_proyectos`.`id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':fecha', $fecha);
            
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Activa los comentarios proyecto por id */ 
    public function activar_comentarios($id) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_fichaproyecto` SET `activarEdicion` = 1 WHERE `Pro_fichaproyecto`.`proyecto_id` = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Desctiva los comentarios proyecto por id */ 
    public function desactivar_comentarios($id) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_fichaproyecto` SET `activarEdicion` = 0 WHERE `Pro_fichaproyecto`.`proyecto_id` = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actializa el estado de una convocatoria */ 
    public function actualizar_convocatoria($idConvocatoria, $estado) {
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_convocatorias` SET `estado` = :estado WHERE `Pro_convocatorias`.`id` = :idConvocatoria');
            $query->bindParam(':estado', $estado);
            $query->bindParam(':idConvocatoria', $idConvocatoria);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene un proyecto por titulo, descripcion o etiquetas */ 
    public function buscar_proyecto($busqueda) {
        $this->dbh = Conexion::singleton_conexion();
        $busqueda = '%'.$busqueda.'%';
        try {
            $query = $this->dbh->prepare('SELECT * from Pro_fichaproyecto where Pro_fichaproyecto.titulo like :busqueda or descripcion like :busqueda or etiquetas like :busqueda');
            $query->bindParam(':busqueda', $busqueda);
			$query->execute();
            $this->dbh = null;
			return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene un proyecto por id */ 
    public function get_proyecto($id) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM `Pro_fichaproyecto` where Pro_fichaproyecto.proyecto_id = :id');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function get_proyecto_proyecto($id) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM `Pro_proyectos` where Pro_proyectos.id = :id');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene todas las convocatorias */ 
    public function get_convocatorias(){
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare("select * from Pro_convocatorias order by id desc");
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene una convocatoria por id */ 
    public function get_convocatoria($id) {
        try {
            $query = $this->dbh->prepare('select * from Pro_convocatorias where id = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene las etiquetas de todos los proyectos */ 
    public function get_etiquetas_proyectos() {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT etiquetas FROM  Pro_fichaproyecto');
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza / completa el registro de un proyecto */ 
    public function actualizar_proyecto_registro($id, $titulo, $descripcion,$enlaceInt, $enlaceExt, $enlaceRepo, $etiquetas, $codigo, $logo) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_fichaproyecto` SET `titulo` = :titulo, `descripcion` = :descripcion, `enlaceinterno` = :enlaceInt, `enlaceexterno` = :enlaceExt, `enlacerepositorio` = :enlaceRepo, codigo = :codigo, `logo` = :logo, `etiquetas` = :etiquetas WHERE `Pro_fichaproyecto`.`proyecto_id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':titulo', $titulo);
            $query->bindParam(':descripcion', $descripcion);
            $query->bindParam(':enlaceInt', $enlaceInt);
            $query->bindParam(':enlaceExt', $enlaceExt);
            $query->bindParam(':enlaceRepo', $enlaceRepo);
            $query->bindParam(':etiquetas', $etiquetas);
            $query->bindParam(':codigo', $codigo);
            $query->bindParam(':logo', $logo);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    /* Actualiza / completa la tabla proyectos */ 
    public function borrar_convocatoria($idConvocatoria) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('DELETE from Pro_convocatorias where id = :id');
            $query->bindParam(':id', $idConvocatoria);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza / completa la tabla proyectos */ 
    public function borrar_proyecto($idProyecto) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('DELETE from Pro_proyectos where id = :id');
            $query->bindParam(':id', $idProyecto);
            $query->execute();
            
            $this->borrar_fichaproyecto($idProyecto);
            $this->borrar_componentes($idProyecto);
            
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza / completa la tabla proyectos */ 
    private function borrar_fichaproyecto($idProyecto) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('DELETE from Pro_fichaproyecto where proyecto_id = :id');
            $query->bindParam(':id', $idProyecto);
            $query->execute();
            
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza / completa la tabla proyectos */ 
    private function borrar_componentes($idProyecto) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('DELETE from Pro_componentes where fichaproyecto_id = :id');
            $query->bindParam(':id', $idProyecto);
            $query->execute();
            
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    /* Actualiza / completa la tabla proyectos */ 
    public function actualizar_fichaProyecto($id, $ciclo) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_proyectos` SET `ciclo` = :ciclo, registrado = 1 WHERE `Pro_proyectos`.`id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':ciclo', $ciclo);
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Solicita que un usuario pueda comentar.*/
    public function solicitar_comentario($id, $email) {
        // Generamos token 
        $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
        
        $this->dbh = Conexion::singleton_conexion();        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_comentarios` (`id`, `fichaproyecto_id`, `email`, `comentario`, `activo`, `nombre`, `token`, `fecha_comentario`) VALUES (NULL, :id_proyecto, :email, '', '0', '', :token, NULL)");
            $query->bindParam(':id_proyecto', $id);
            $query->bindParam(':email', $email);
            $query->bindParam(':token', $token);
            $query->execute();           
            $this->dbh = null;
            
            /* Enviamos el mail */
            $this->dbh = Conexion::singleton_conexion();
            $id = $this->dbh->lastInsertId();
            $this->enviarMailComentario($token, $email, $id);
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Solicita que un usuario pueda comentar.*/
    public function solicitar_valoracion($id, $email) {
        // Generamos token 
        $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
        
        $this->dbh = Conexion::singleton_conexion();        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_valoraciones` (`id`, `fichaproyecto_id`, `email`, `valoracion`, `nombre`, `token`) VALUES (NULL, :id, :email, NULL, '', :token);");
            $query->bindParam(':id', $id);
            $query->bindParam(':email', $email);
            $query->bindParam(':token', $token);
            $query->execute();           
            $this->dbh = null;
            
            $this->dbh = Conexion::singleton_conexion();
            $this->enviarMailValoracion($token, $email, $id);
            header('Location: index.php?page=inicio&error=8');
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Envia un email para que el usuario pueda comentar en un proyecto */
    private function enviarMailValoracion($token, $email,$id) {
        
        $mail = new PHPMailer;
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = GMAIL_USER;                 // SMTP username
        $mail->Password = GMAIL_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        
        $mail->setFrom(MAIL_VALORACION_FROM, 'Gestion de proyectos');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo($email);
        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = MAIL_VALORACION_ASUNTO;
        
            
        $cuerpo = MAIL_VALORACION_MESSAGE.' <a href='.MAIL_VALORACION_URL_TOKEN.'index.php?page=valorar&token='.$token.'&idProyecto='.$id.'>Link red externa</a>
        <a href='.MAIL_URL_TOKEN_INT.'index.php?page=valorar&token='.$token.'&idProyecto='.$id.'>Link red interna</a>';

        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
    
    /* Actualiza la tabla comentarios con el nuevo comentario */
    public function actualiza_valoracion($id, $puntuacion, $nombre) {   
        
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_valoraciones` SET `valoracion` = :puntuacion, `nombre` = :nombre WHERE `Pro_valoraciones`.`fichaproyecto_id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':puntuacion', $puntuacion);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Envia un email para que el usuario pueda comentar en un proyecto */
    private function enviarMailComentario($token, $email,$id) {
        $mail = new PHPMailer;
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = GMAIL_USER;                 // SMTP username
        $mail->Password = GMAIL_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        
        $mail->setFrom(MAIL_COMENTARIO_FROM, 'Gestion de proyectos');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo($email);
        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = MAIL_COMENTARIO_ASUNTO;
                
                    
        $cuerpo = MAIL_COMENTARIO_MESSAGE.' <a href='.MAIL_COMENTARIO_URL_TOKEN.'index.php?page=comentar&token='.$token.'&idProyecto='.$id.'>Link red externa</a>
        <a href='.MAIL_URL_TOKEN_INT.'index.php?page=comentar&token='.$token.'&idProyecto='.$id.'>Link red interna</a>';
        
        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario que va a comentar */ 
    public function comprobarTokenComentario($token, $id) {   
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('select * from Pro_comentarios WHERE id = :id and token = :token');
            $query->bindParam(':id', $id);
            $query->bindParam(':token', $token);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario que va a comentar */ 
    public function comprobarTokenValoracion($token, $id) {   
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('select * from Pro_valoraciones WHERE fichaproyecto_id = :id and token = :token');
            $query->bindParam(':id', $id);
            $query->bindParam(':token', $token);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario que va a comentar */ 
    public function comprobarCorreoValoracion($id, $email) {   
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('SELECT * FROM `Pro_valoraciones` where email = :email and fichaproyecto_id = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':email', $email);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    /* Actualiza la tabla comentarios con el nuevo comentario */
    public function actualiza_comentario($id, $nombre, $comentario) {   
        // Generamos token y fecha de expiracion
        $fecha = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $fecha = date("Y-m-d", $fecha); 
        
        $this->dbh = Conexion::singleton_conexion();        
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_comentarios` SET `comentario` = :comentario, `activo` = 1, `nombre` = :nombre, `fecha_comentario` = :fecha WHERE `Pro_comentarios`.`id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':comentario', $comentario);
            $query->bindParam(':fecha', $fecha);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Inserta un componente en un proyecto por id */
    public function insertar_componente($id, $nombre, $email, $imagen) {
        $this->dbh = Conexion::singleton_conexion();        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_componentes` (`id`, `fichaproyecto_id`, `nombre`, `email`, `imagen`) VALUES (NULL, :id, :nombre, :email, :imagen)");
            $query->bindParam(':id', $id);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':email', $email);
            $query->bindParam(':imagen', $imagen);
            $query->execute();           
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Evita la clonacion de la clase */ 
    public function __clone(){
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }  
}
?>