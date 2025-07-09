<?php
require_once '../conexion/conexion.php';

class Registro {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    // Método para registrar un cambio de estado
    public function registrarCambioEstado($pacienteId, $estadoAnterior, $nuevoEstado, $usuarioId) {
        try {
            $sql = "INSERT INTO Registros (PacienteId, EstadoAnterior, NuevoEstado, UsuarioId, Fecha) 
                    VALUES (:pacienteId, :estadoAnterior, :nuevoEstado, :usuarioId, NOW())";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':pacienteId', $pacienteId, PDO::PARAM_INT);
            $stmt->bindParam(':estadoAnterior', $estadoAnterior, PDO::PARAM_STR);
            $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al registrar el cambio de estado: " . $e->getMessage());
        }
    }

    // Método para obtener todos los registros
    public function obtenerRegistros() {
        try {
            $query = "SELECT * FROM Registros ORDER BY Fecha DESC";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener los registros: " . $e->getMessage());
        }
    }
}
?>
