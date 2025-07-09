<?php
require_once '../conexion/conexion.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    // Método para agregar un usuario
    public function agregarUsuario($codigo, $contraseña, $tipoUsuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado) {
        try {
            $sql = "INSERT INTO Usuarios (Codigo, Contraseña, TipoUsuario, Nombre, Ape_Paterno, Ape_Materno, DNI, Telefono, Direccion, Estado) 
                    VALUES (:codigo, :contraseña, :tipoUsuario, :nombre, :ape_paterno, :ape_materno, :dni, :telefono, :direccion, :estado)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':contraseña', $contraseña);
            $stmt->bindParam(':tipoUsuario', $tipoUsuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ape_paterno', $ape_paterno);
            $stmt->bindParam(':ape_materno', $ape_materno);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "El código de usuario '$codigo' ya está registrado. Por favor, elija otro.";
            } else {
                return "Error al agregar el usuario: " . $e->getMessage();
            }
        }
    }
}
?>
