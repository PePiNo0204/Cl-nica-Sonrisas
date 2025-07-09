<?php

require_once '../conexion/conexion.php';  // Asegúrate de incluir la conexión

class EditarUsuarioDAO {

    private $pdo;

    public function __construct() {
        // Aquí obtienes la conexión desde la clase Conexion
        $this->pdo = Conexion::getInstancia()->getConexion();
    }

    // Método para obtener los datos del usuario por su ID
    public function obtenerUsuarioPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE Codigo = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            // Retorna los datos del usuario si existe, o false si no se encuentra
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario ? $usuario : false;
        } catch (PDOException $e) {
            return false;  // Si ocurre un error en la consulta
        }
    }

    // Método para actualizar los datos de un usuario
    public function actualizarUsuario($codigo, $contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Usuarios SET Contraseña = ?, TipoUsuario = ?, Nombre = ?, Ape_Paterno = ?, Ape_Materno = ?, DNI = ?, Telefono = ?, Direccion = ?, Estado = ? WHERE Codigo = ?");
            $stmt->execute([$contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado, $codigo]);

            return true;  // Devuelve verdadero si la actualización es exitosa
        } catch (PDOException $e) {
            return $e->getMessage();  // Devuelve el error si la actualización falla
        }
    }
}
?>
