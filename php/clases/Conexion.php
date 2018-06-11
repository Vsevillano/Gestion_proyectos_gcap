<?php

require_once("config.php");

class Conexion{
    
    /* Variable de instancia */
    private static $instancia;
    
    /* Variable de conexión */
    private $dbh;
    
    
    /* Constructor */
    public function __construct(){
        try{
            
            $this->dbh = new PDO(CADCONEXION, USER, PSW);
            $this->dbh->exec("SET CHARACTER SET utf8"); 
            
        }catch(PDOException $e){
            
            print "Error!: " . $e->getMessage();
            die();
        } 
    }
    
    /* Funcion para evitar la inyeccion */
    public function prepare($sql) {
        return $this->dbh->prepare($sql);
    }
    
    /* Funcion para saber el ultimo id insertado */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
    
    /* Devuelve la instancia */
    public static function singleton_conexion(){
        if(!isset(self::$instancia)){
            $class = __CLASS__;
            self::$instancia = new $class;
        }
        return self::$instancia;
    }
    
    /* Método para evitar que se pueda clonar el objeto */
    public function __clone() {
        trigger_error('La clonacion de este objeto no esta permitida!', E_USER_ERRROR);
    }
    
}

?>