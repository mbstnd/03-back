<?php

class Controlador{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll(){
        $con = new Conexion();
        $sql = "SELECT id, nombre, texto, texto_adicional, activo FROM info_contacto";
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
        $conexion = $con->getConnection();
        
        // Obtener el ID
        $id = count($this->getAll()) + 1;
        
        // Consulta SQL usando declaraciones preparadas
        $sql = "INSERT INTO info_contacto (id, nombre, icono, texto, texto_adicional, activo) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la declaración
        if ($stmt = $conexion->prepare($sql)) {
            // Verificar si los campos son null y asignar los valores apropiados
            $nombre = $_nuevoObjeto->nombre ?? null;
            $icono = null; // o el valor que necesites para icono
            $texto = $_nuevoObjeto->texto ?? null;
            $texto_adicional = $_nuevoObjeto->texto_adicional ?? null;
            $activo = $_nuevoObjeto->activo ?? false; // Asumiendo que siempre es verdadero
    
            // Vincular los parámetros
            $stmt->bind_param("issssi", $id, $nombre, $icono, $texto, $texto_adicional, $activo);
            
            // Ejecutar la declaración
            $rs = $stmt->execute();
            
            // Cerrar la declaración
            $stmt->close();
        } else {
            $rs = false;
        }
    
        // Cerrar la conexión
        $con->closeConnection();
    
        // Result set = resultado de la ejecución de la query
        if ($rs) {
            return true;
        }
        return null;
    }
    

    public function patchEncenderApagar($_id,$_accion){
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET activo = $_accion WHERE id = $_id";
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
        $sql = "UPDATE info_contacto SET nombre =  '$_nombre' WHERE id = $_id";
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
        $sql = "UPDATE info_contacto SET texto =  '$_texto' WHERE id = $_id";
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

    public function putTextoAdicionalById($_texto_adicional,$_id){
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET texto_adicional =  '$_texto_adicional' WHERE id = $_id";
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
        $sql = "DELETE FROM info_contacto WHERE id =$_id";
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

