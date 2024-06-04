<?php

class Controlador{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll() {
        $con = new Conexion();
        $sql = "SELECT id, historia_id, imagen_id FROM historia_imagen";
        $rs = mysqli_query($con->getConnection(), $sql);
    
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function postNuevo($_nuevoObjeto){
        $con = new Conexion();
        // var_dump($_nuevoObjeto->nombre);
        $id = count($this->getAll()) +1;
        $sql = "INSERT INTO historia_imagen (id, historia_id, imagen_id) VALUES ($id,'$_nuevoObjeto->historia_id','$_nuevoObjeto->imagen_id')";
        echo $sql;
        // ejecucion SQL
        // $rs = [];
        // try {
        //     $rs = mysqli_query($con->getConnection(), $sql);
        // } catch (\Throwable $th) {
        //     $rs = null;
        // }
        // // var_dump($rs);
        // // cierre de Conexion
        // $con->closeConnection();
        // // result set = resultado de la ejecucion de la query
        // if($rs){
        //     return true;
        // }
        return null;
    }

    public function patchEncenderApagar($_id,$_accion){
        $con = new Conexion();
        $sql = "UPDATE historia_imagen SET activo = $_accion WHERE id = $_id";
        // echo $sql;
        // ejecucion SQL
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        // cierre de Conexion
        $con->closeConnection();
        // result set = resultado de la ejecucion de la query
        if($rs){
            return true;
        }
        return null;
    }

    public function putHistoriaById($_nombre,$_id){
        $con = new Conexion();
        $sql = "UPDATE historia_imagen SET historia_id =  '$_nombre' WHERE id = $_id";
        // echo $sql;
        // ejecucion SQL
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        // cierre de Conexion
        $con->closeConnection();
        // result set = resultado de la ejecucion de la query
        if($rs){
            return true;
        }
        return null;
    }

    public function putImagenById($_imagen,$_id){
        $con = new Conexion();
        $sql = "UPDATE historia_imagen SET imagen_id =  '$_imagen' WHERE id = $_id";
        // echo $sql;
        // ejecucion SQL
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        // cierre de Conexion
        $con->closeConnection();
        // result set = resultado de la ejecucion de la query
        if($rs){
            return true;
        }
        return null;
    }

    public function deleteById($_id){
        $con = new Conexion();
        $sql = "DELETE FROM historia_imagen WHERE id =$_id";
        // echo $sql;
        // ejecucion SQL
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        // cierre de Conexion
        $con->closeConnection();
        // result set = resultado de la ejecucion de la query
        if($rs){
            return true;
        }
        return null;
    }
}

