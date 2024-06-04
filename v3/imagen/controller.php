<?php

class Controlador{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll(){
        $con = new Conexion();
        $sql = "SELECT id, nombre, imagen, activo FROM imagen";
        $rs = mysqli_query($con->getConnection(), $sql);
        if($rs){
            while ($tupla = mysqli_fetch_assoc($rs)){
                $tupla['activo'] = $tupla['activo'] == 1 ? true: false;
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
        $sql = "INSERT INTO imagen (id, nombre, imagen, activo) VALUES ($id,'$_nuevoObjeto->nombre','$_nuevoObjeto->imagen', true)";
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
        $sql = "UPDATE mantenimiento_info SET activo = $_accion WHERE id = $_id";
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

    public function putNombreById($_nombre,$_id){
        $con = new Conexion();
        $sql = "UPDATE mantenimiento_info SET nombre =  '$_nombre' WHERE id = $_id";
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

    public function putTextoById($_texto,$_id){
        $con = new Conexion();
        $sql = "UPDATE mantenimiento_info SET texto =  '$_texto' WHERE id = $_id";
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
        $sql = "DELETE FROM mantenimiento_info WHERE id =$_id";
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

