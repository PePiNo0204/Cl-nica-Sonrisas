<?php
require_once '../conexion/conexion.php';

class Paciente {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    // Método para agregar un paciente
    public function agregarPaciente($nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado) {
        try {
            $sql = "INSERT INTO Pacientes (Nombre, Ape_Paterno, Ape_Materno, DNI, Telefono, Direccion, Estado) 
                    VALUES (:nombre, :ape_paterno, :ape_materno, :dni, :telefono, :direccion, :estado)";
            $stmt = $this->conexion->prepare($sql);
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
                return "El DNI '$dni' ya está registrado. Por favor, elija otro.";
            } else {
                return "Error al agregar el paciente: " . $e->getMessage();
            }
        }
    }

    // Método para obtener todos los pacientes
    public function obtenerPacientes($search = "") {
        $sql = "SELECT * FROM Pacientes WHERE Nombre LIKE :search OR DNI LIKE :search ORDER BY Nombre";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':search', "%$search%");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para cambiar el estado de un paciente
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE Pacientes SET Estado = :estado WHERE PacienteId = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
