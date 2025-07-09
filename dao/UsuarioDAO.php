<?php
// Incluir la clase Conexion
require_once '../conexion/Conexion.php';

class UsuarioDAO {
    private $conexion;

    public function __construct() {
        // Obtén la instancia de la clase Conexion
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    // Método para agregar un nuevo usuario
    public function agregarUsuario($codigo, $contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado) {
        try {
            // Preparar la consulta SQL para insertar el nuevo usuario
            $sql = "INSERT INTO usuarios (codigo, contraseña, TipoUsuario, nombre, ape_paterno, ape_materno, dni, telefono, direccion, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Preparar la declaración SQL
            $stmt = $this->conexion->prepare($sql);
            
            // Bind de los parámetros
            $stmt->bindParam(1, $codigo);
            $stmt->bindParam(2, $contraseña);
            $stmt->bindParam(3, $tipo_usuario);
            $stmt->bindParam(4, $nombre);
            $stmt->bindParam(5, $ape_paterno);
            $stmt->bindParam(6, $ape_materno);
            $stmt->bindParam(7, $dni);
            $stmt->bindParam(8, $telefono);
            $stmt->bindParam(9, $direccion);
            $stmt->bindParam(10, $estado);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            return true; // Usuario agregado exitosamente
        } catch (Exception $e) {
            return "Error al agregar el usuario: " . $e->getMessage();
        }
    }

    // Método para obtener un usuario por su código
    public function obtenerUsuarioPorCodigo($codigo) {
        try {
            // Preparar la consulta SQL para obtener los datos del usuario
            $sql = "SELECT * FROM usuarios WHERE codigo = ?";
            
            // Preparar la declaración SQL
            $stmt = $this->conexion->prepare($sql);
            
            // Bind del parámetro
            $stmt->bindParam(1, $codigo);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $usuario;
        } catch (Exception $e) {
            return "Error al obtener el usuario: " . $e->getMessage();
        }
    }

    // Método para editar un usuario
    public function editarUsuario($codigo, $contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado) {
        try {
            // Preparar la consulta SQL para actualizar los datos del usuario
            $sql = "UPDATE usuarios SET 
                        contraseña = ?, 
                        TipoUsuario = ?, 
                        nombre = ?, 
                        ape_paterno = ?, 
                        ape_materno = ?, 
                        dni = ?, 
                        telefono = ?, 
                        direccion = ?, 
                        estado = ? 
                    WHERE codigo = ?";
            
            // Preparar la declaración SQL
            $stmt = $this->conexion->prepare($sql);
            
            // Bind de los parámetros
            $stmt->bindParam(1, $contraseña);
            $stmt->bindParam(2, $tipo_usuario);
            $stmt->bindParam(3, $nombre);
            $stmt->bindParam(4, $ape_paterno);
            $stmt->bindParam(5, $ape_materno);
            $stmt->bindParam(6, $dni);
            $stmt->bindParam(7, $telefono);
            $stmt->bindParam(8, $direccion);
            $stmt->bindParam(9, $estado);
            $stmt->bindParam(10, $codigo);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            return true; // Usuario editado exitosamente
        } catch (Exception $e) {
            return "Error al editar el usuario: " . $e->getMessage();
        }
    }
}
?>
