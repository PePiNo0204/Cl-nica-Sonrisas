<?php
require_once '../conexion/conexion.php';

class PacienteDAO {
    public function agregarPaciente($nombre, $ape_paterno, $ape_materno, $dni, $fecha_nacimiento, $telefono, $direccion, $sexo, $estado) {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $sql = "INSERT INTO Pacientes (Nombre, Ape_Paterno, Ape_Materno, DNI, Fecha_Nacimiento, Telefono, Direccion, Sexo, Estado)
                    VALUES (:nombre, :ape_paterno, :ape_materno, :dni, :fecha_nacimiento, :telefono, :direccion, :sexo, :estado)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':ape_paterno', $ape_paterno, PDO::PARAM_STR);
            $stmt->bindParam(':ape_materno', $ape_materno, PDO::PARAM_STR);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

            $stmt->execute();
            return true;  // Paciente agregado correctamente
        } catch (PDOException $e) {
            return "Error al agregar el paciente: " . $e->getMessage();
        }
    }
}
?>
