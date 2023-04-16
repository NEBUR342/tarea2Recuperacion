<?php

namespace Src;

use PDO;
use PDOException;
use Src\Conexion;

class Usuario extends Conexion{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $isAdmin;
    private float $sueldo;

    public function __construct() {
        parent::__construct();
    }

    //------------------------------------------------------ CRUD
    public function create(){
        $q="insert into users(nombre,apellidos,email,is_admin,sueldo) values (:n,:a,:e,:i,:s)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':e'=>$this->email,
                ':i'=>$this->isAdmin,
                ':s'=>$this->sueldo,
            ]);
        }catch(PDOException $e){
            die("Error en create: ".$e->getMessage());
        }
        parent::$conexion=null;
    }
    public static function read($id=null){
        parent::crearConexion();
        $q=($id==null)?"select * from users order by id desc":"select * from users where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            if ($id==null) $stmt->execute();
            else $stmt->execute([":i"=>$id]);
            
        }catch(PDOException $e){
            die("Error en read: ".$e->getMessage());
        }
        parent::$conexion=null;
        if($id==null) return $stmt->fetchAll(PDO::FETCH_OBJ);
        else return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function update($id){
        $q="update users set nombre=:n, apellidos=:a, email=:e, sueldo=:s, is_admin=:p where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id,
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':e'=>$this->email,
                ':s'=>$this->sueldo,
                ':p'=>$this->isAdmin,
            ]);
        }catch(PDOException $e){
            die("Error en update: ".$e->getMessage());
        }
        parent::$conexion=null;
    }

    public static function delete($id){
        parent::crearConexion();
        $q="delete from users where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id,
            ]);
        }catch(PDOException $ex){
            die("Error en delete". $ex->getMessage());
        }
        parent::$conexion=null;
    }

    //------------------------------------------------------ Metodos
    public static function existeEmail($email,$id=null){
        parent::crearConexion();
        $q=($id==null)?"select email from users where email=:e":"select email from users where email=:e AND id!=:i";
        $opcion=($id==null)?[":e"=>$email]:[":e"=>$email,":i"=>$id];
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute($opcion);
        }catch(PDOException $e){
            die("Error en existeEmail: ".$e->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount(); // 0->false  1->true
    }
    //------------------------------------------------------ Getters/Setters

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of isAdmin
     */ 
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set the value of isAdmin
     *
     * @return  self
     */ 
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get the value of sueldo
     */ 
    public function getSueldo()
    {
        return $this->sueldo;
    }

    /**
     * Set the value of sueldo
     *
     * @return  self
     */ 
    public function setSueldo($sueldo)
    {
        $this->sueldo = $sueldo;

        return $this;
    }
}

?>