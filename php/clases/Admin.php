<?php
require_once 'Conexion.php';
require_once("config.php");
require_once 'PHPMailer/PHPMailerAutoload.php';


class Admin {
    
    private static $instancia;
    private $dbh;    
    
    /* Contructor de usuario */ 
    private function __construct(){
        try {
            $this->dbh = Conexion::singleton_conexion();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }
    
    /* Singleton para el usuario */ 
    public static function singleton_admin() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    /* Obtiene un usuario por id */ 
    public function get_usuario($id) {
        try {
            $query = $this->dbh->prepare('select * from Pro_admin WHERE Pro_admin.id = :id');
            $query->bindParam(':id', $id);
			$query->execute();
            $this->dbh = null;
			return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario */ 
    public function comprobarToken($token, $id) {
        
        $fecha = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $fecha = date("Y-m-d", $fecha); 
        
        try {
            $query = $this->dbh->prepare('select * from Pro_admin WHERE Pro_admin.id = :id and Pro_admin.token = :token and Pro_admin.expiracion > :fecha');
            $query->bindParam(':id', $id);
            $query->bindParam(':token', $token);
            $query->bindParam(':fecha', $fecha);
            
			$query->execute();
            $this->dbh = null;
			return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario */ 
    public function comprobarTokenRecuperacion($token, $email) {
        $fecha = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $fecha = date("Y-m-d", $fecha); 
        
        try {
            $query = $this->dbh->prepare('select * from Pro_admin WHERE Pro_admin.email = :email and Pro_admin.token = :token and Pro_admin.expiracion > :fecha and activo = 1');
            $query->bindParam(':email', $email);
            $query->bindParam(':token', $token);
            $query->bindParam(':fecha', $fecha);
            
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Comprueba que el token pertenece al id del usuario */ 
    public function comprobarTokenProyecto($token, $id) {
        $fecha = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $fecha = date("Y-m-d", $fecha); 
        
        try {
            $query = $this->dbh->prepare('select * from Pro_proyectos WHERE Pro_proyectos.id = :id and Pro_proyectos.codigo = :token and Pro_proyectos.expiracion > :fecha');
            $query->bindParam(':id', $id);
            $query->bindParam(':token', $token);
            $query->bindParam(':fecha', $fecha);
            
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    
    /* Registra un usuario */ 
    public function insert_usuario($email){
        try { 
            // Generamos token y fecha de expiracion
            $expiracion = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"));
            $expiracion = date("Y-m-d", $expiracion); 
            
            $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
            
            $query = $this->dbh->prepare("INSERT INTO `Pro_admin` (`id`, `username`, `email`, `password`, `token`, `expiracion`, `nombre`, `activo`) VALUES (NULL, NULL, :email, NULL, :token, :expiracion, NULL, '0')");
            $query->bindParam(':email', $email);
            $query->bindParam(':token', $token);
            $query->bindParam(':expiracion', $expiracion);
            $query->execute();
            
            $id = $this->dbh->lastInsertId();
            
            $this->enviarMailAlta($token, $email, $id);
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    private function enviarMailAlta($token, $email,$id) {
        $mail = new PHPMailer;
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = GMAIL_USER;                 // SMTP username
        $mail->Password = GMAIL_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        
        $mail->setFrom(MAIL_FROM_PROYECTO, 'Gestion de proyectos');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo($email);
        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = MAIL_ASUNTO;
        
        $array = $this->get_id_usuario();
        $id = $array['id'];
        
        $cuerpo = MAIL_MESSAGE.' <a href='.MAIL_URL_TOKEN.'index.php?page=registro&token='.$token.'&idUser='.$id.'>Link red externa</a>
        <a href='.MAIL_URL_TOKEN_INT.'index.php?page=registro&token='.$token.'&idUser='.$id.'>Link red interna</a>';
        
        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } 
    }
    
    /* Actualiza la informacion de un usuario al registrarse */ 
    public function recuperar_pass($correo){
        $this->dbh = Conexion::singleton_conexion();
        
        // Generamos token y fecha de expiracion
        $expiracion = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"));
        $expiracion = date("Y-m-d", $expiracion); 
        
        $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_admin` SET token = :token, expiracion = :fecha WHERE `Pro_admin`.`email` = :email');
            $query->bindParam(':email', $correo);
            $query->bindParam(':token', $token);
            $query->bindParam(':fecha', $expiracion);
            $query->execute();
            $this->dbh = null;
            
            $this->enviarMailRecuperacion($token, $correo);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza la informacion de un usuario al registrarse */ 
    public function actualizar_pass($id,$pass){
        $this->dbh = Conexion::singleton_conexion();
        
        $pass = md5($pass);
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_admin` set password = :pass WHERE `Pro_admin`.`id` = :id');
            $query->bindParam(':pass', $pass);
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    private function enviarMailRecuperacion($token, $email) {
        $mail = new PHPMailer;
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = GMAIL_USER;                 // SMTP username
        $mail->Password = GMAIL_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        
        $mail->setFrom(MAIL_RECUPERACION_FROM, 'Gestion de proyectos');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo($email);
        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = MAIL_RECUPERACION_ASUNTO;
        
        $cuerpo = MAIL_RECUPERACION_MESSAGE.' <a href='.MAIL_RECUPERACION_URL.'index.php?page=cambiarPass&token='.$token.'&email='.$email.'>Link red externa</a>
        <a href='.MAIL_URL_TOKEN_INT.'index.php?page=cambiarPass&token='.$token.'&email='.$email.'>Link red interna</a>';
        
        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
    
    private function enviarMailProyecto($token, $email,$id) {
        $mail = new PHPMailer;
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = GMAIL_USER;                 // SMTP username
        $mail->Password = GMAIL_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        
        $mail->setFrom(MAIL_FROM_PROYECTO, 'Gestion de proyectos');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo($email);
        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = MAIL_ASUNTO_PROYECTO;
        
        $array = $this->get_id_fichaproyecto();
        $id = $array['id'];
        
        
        
        $cuerpo = MAIL_MESSAGE_PROYECTO.' <a href='.MAIL_URL_TOKEN_PROYECTO.'index.php?page=registroProyecto&token='.$token.'&idProyecto='.$id.'>Link red externa</a>
        <a href='.MAIL_URL_TOKEN_INT.'index.php?page=registroProyecto&token='.$token.'&idProyecto='.$id.'>Link red interna</a>';
        
        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        
    }
    
    /* Obtiene las etiquetas de todos los proyectos */ 
    public function get_id_fichaproyecto() {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('select id from Pro_proyectos order by id desc limit 1');
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene las etiquetas de todos los proyectos */ 
    public function get_id_usuario() {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('select id from Pro_admin order by id desc limit 1');
            $query->execute();
            $this->dbh = null;
            return $query->fetch();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza la informacion de un usuario al registrarse */ 
    public function actualiza_usuario($id,$nombre,$password,$usuario){
        $this->dbh = Conexion::singleton_conexion();
        
        $password = md5($password);
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_admin` SET `username` = :usuario, `password` = :pass, `nombre` = :nombre, activo = "1" WHERE `Pro_admin`.`id` = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':usuario', $usuario);
            $query->bindParam(':pass', $password);
            $query->bindParam(':nombre', $nombre);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza la informacion de un usuario */ 
    public function update_usuario($id,$nombre,$email,$usuario){
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('update Pro_usuario SET nombre = :nombre, usuario = :usuario WHERE id = :id');
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':usuario', $usuario);
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    
    /* Registra un usuario */ 
    public function insert_proyecto($email, $id_convocatoria){
        $this->dbh = Conexion::singleton_conexion();
        $expiracion = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"));
        $expiracion = date("Y-m-d", $expiracion); 
        $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid()); 
        
        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_proyectos` (`id`, `convocatoria_id`, `email`, `codigo`, `expiracion`, `registrado`, `ciclo`) VALUES (NULL, :id_convocatoria, :email, :token, :expiracion, '0', '')");
            $query->bindParam(':id_convocatoria', $id_convocatoria);
            $query->bindParam(':email', $email);
            $query->bindParam(':token', $token);
            $query->bindParam(':expiracion', $expiracion);
            $query->execute();
            
            $array = $this->get_id_fichaproyecto();
            $id = $array['id'];
            
            $this->enviarMailProyecto($token, $email, $id);
            $this->insert_fichaProyecto($id);
            
            //Creamos el archivo			   
            $archivo = "upload/dir". $id;
            if (!file_exists($archivo)) {
                mkdir($archivo, 0777, true);
            } 
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Registra un usuario */ 
    private function insert_fichaProyecto($id){
        $this->dbh = Conexion::singleton_conexion();
        
        try { 
            $query = $this->dbh->prepare("INSERT INTO `Pro_fichaproyecto` (`id`, `proyecto_id`, `titulo`, `descripcion`, `enlaceinterno`, `enlaceexterno`, `enlacerepositorio`, `codigo`, `fechaPresentacion`, `horaPresentacion`, `logo`, `calificacion`, `comentarios`, `etiquetas`, `activarEdicion`) VALUES (NULL, :id, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '0')");
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza la informacion de un usuario */ 
    public function asignar_fecha($id,$fecha,$hora){
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_fichaproyecto` SET `fechaPresentacion` = :fecha, `horaPresentacion` = :hora WHERE `Pro_fichaproyecto`.`proyecto_id` = :id');
            $query->bindParam(':fecha', $fecha);
            $query->bindParam(':hora', $hora);
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Actualiza la calificacion de un proyecto*/ 
    public function asignar_nota($id, $nota){
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('UPDATE `Pro_fichaproyecto` SET  `calificacion` = :nota WHERE  `Pro_fichaproyecto`.`proyecto_id` = :id');
            $query->bindParam(':nota', $nota);
            $query->bindParam(':id', $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los proyectos de la convocatoria que estan activos */ 
    public function get_proyectos_convocatoria($idConvocatoria) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * from Pro_fichaproyecto, Pro_proyectos where Pro_fichaproyecto.proyecto_id = Pro_proyectos.id and Pro_proyectos.convocatoria_id = :idConvocatoria and Pro_proyectos.registrado = 1;');
            $query->bindParam(':idConvocatoria', $idConvocatoria);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Obtiene los proyectos de la convocatoria que estan activos */ 
    public function get_proyectos_sinregistrar_convocatoria($idConvocatoria) {
        $this->dbh = Conexion::singleton_conexion();
        
        try {
            $query = $this->dbh->prepare('SELECT * from Pro_fichaproyecto, Pro_proyectos where Pro_fichaproyecto.proyecto_id = Pro_proyectos.id and Pro_proyectos.convocatoria_id = :idConvocatoria and Pro_proyectos.registrado = 0;');
            $query->bindParam(':idConvocatoria', $idConvocatoria);
            $query->execute();
            $this->dbh = null;
            return $query->fetchAll();
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    /* Evita la clonacion de la clase */ 
    public function __clone(){
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }  
}
?>