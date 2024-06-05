<?php

class Controlador{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll(){
        $con = new Conexion();
        $sql = "SELECT id, pregunta, respuesta, activo FROM pregunta_frecuente;";
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
    
        // Escapar las variables para evitar la inyección de SQL
        $pregunta = mysqli_real_escape_string($con->getConnection(), $_nuevoObjeto->pregunta);
        $respuesta = mysqli_real_escape_string($con->getConnection(), $_nuevoObjeto->respuesta);
    
        // Consultar si la pregunta ya existe en la base de datos
        if ($this->existePregunta($pregunta)) {
            // La pregunta ya existe, retornar un mensaje de error con código 409
            return null; // o puedes retornar un mensaje de error más específico
        }
    
        // Obtener el próximo ID (preferiblemente usando AUTO_INCREMENT en la base de datos)
        $id = count($this->getAll()) + 1;
    
        // Construir la consulta SQL
        $sql = "INSERT INTO pregunta_frecuente (id, pregunta, respuesta, activo) VALUES ($id, '$pregunta', '$respuesta', true)";
    
        // Ejecutar la consulta SQL
        $rs = mysqli_query($con->getConnection(), $sql);
    
        // Cerrar la conexión
        $con->closeConnection();
    
        // Verificar si la consulta fue exitosa
        if($rs){
            return true;
        } else {
            return null;
        }
    }
    
    // Método para verificar si la pregunta ya existe en la base de datos
    private function existePregunta($pregunta) {
        $con = new Conexion();
    
        // Escapar la pregunta para evitar la inyección de SQL
        $pregunta = mysqli_real_escape_string($con->getConnection(), $pregunta);
    
        // Construir la consulta SQL
        $sql = "SELECT COUNT(*) AS count FROM pregunta_frecuente WHERE pregunta = '$pregunta'";
    
        // Ejecutar la consulta SQL
        $rs = mysqli_query($con->getConnection(), $sql);
    
        // Obtener el resultado de la consulta
        $fila = mysqli_fetch_assoc($rs);
        $conteo = $fila['count'];
    
        // Si el conteo es mayor que 0, la pregunta ya existe
        if ($conteo > 0) {
            return true;
        } else {
            return false;
        }
    }
    

    public function patchEncenderApagar($_id,$_accion){
        $con = new Conexion();
        $sql = "UPDATE pregunta_frecuente SET activo = $_accion WHERE id = $_id";
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

    public function putPreguntaById($_pregunta,$_id){
        $con = new Conexion();
        $sql = "UPDATE pregunta_frecuente SET pregunta =  '$_pregunta' WHERE id = $_id";
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

    public function putRespuestaById($_respuesta,$_id){
        $con = new Conexion();
        $sql = "UPDATE pregunta_frecuente SET respuesta =  '$_respuesta' WHERE id = $_id";
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
        $sql = "DELETE FROM pregunta_frecuente WHERE id =$_id";
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

