<?php
require_once 'config/db.php';

class Usuario{
        private $pdo;

        public function __construct(){
            $this->pdo = $GLOBALS['pdo'];
        }



public function crear($tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $passwords, $role_id) {
    try {
        // Preparar la consulta SQL de inserción
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (tdocumento, idusuario, imagen, nombre, papellido, sapellido, celular, email, passwords, role_id)
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta y comprobar si se ejecutó correctamente
        if ($stmt->execute([$tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $passwords, $role_id])) {
            return true;  // Si la inserción fue exitosa
        } else {
            return false;  // Si algo falló
        }
    } catch (PDOException $e) {
        // Si hay un error con la consulta
        echo "Error al guardar los datos: " . $e->getMessage();
        return false;
    }
}













        public function leer($email, $passwords) {
            // Preparar la consulta SQL para buscar al usuario por email y passwords
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND passwords = ?");
            $stmt->execute([$email, $passwords]); // Ejecutar la consulta

            // Obtener el resultado como un array asociativo
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retornar el usuario encontrado (o null si no se encuentra)
            return $usuario; // No se hace json_encode aquí
        }


public function actualizar($cont, $tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $role_id) {
    try {
        $stmt = $this->pdo->prepare("UPDATE usuarios
                                     SET tdocumento = ?,
                                         idusuario = ?,
                                         imagen = ?,
                                         nombre = ?,
                                         papellido = ?,
                                         sapellido = ?,
                                         celular = ?,
                                         email = ?,
                                         role_id = ?
                                     WHERE cont = ?");
        return $stmt->execute([
            $tdocumento,
            $idusuario,
            $imagen,
            $nombre,
            $papellido,
            $sapellido,
            $celular,
            $email,
            $role_id,
            $cont,
        ]);
    } catch (PDOException $e) {
        error_log('Error en la actualización: ' . $e->getMessage());
        return false;
    }
}

public function encontrar($id) {
    try {
        // Preparar la consulta para buscar al usuario por su ID
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE cont = ?");
        $stmt->execute([$id]);

        // Retorna el usuario como un array asociativo o false si no se encuentra
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        error_log('Error al buscar usuario: ' . $e->getMessage());
        return false;
    }
}







//!Actividad recerva

public function crearreserva($tidentificacion, $idusuario, $nombre,$papellido, $sapellido, $celular, $mail, $paquete, $canpersonas, $costopaquete) {
    try {
        // Preparar la consulta SQL de inserción
        $stmt = $this->pdo->prepare("INSERT INTO reserva (tidentificacion,
        idusuario,
        nombre,
        papellido,
        sapellido,
        celular,
        mail,
        paquete,
        canpersonas,
        costopaquete)
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta y comprobar si se ejecutó correctamente
        if ($stmt->execute([$tidentificacion, $idusuario, $nombre, $papellido, $sapellido, $celular, $mail, $paquete, $canpersonas, $costopaquete])) {
            return true;  // Si la inserción fue exitosa
        } else {
            return false;  // Si algo falló
        }
    } catch (PDOException $e) {
        // Si hay un error con la consulta
        echo "Error al guardar los datos: " . $e->getMessage();
        return false;
    }
}



public function verreserva($id) {
    // Preparar la consulta SQL para buscar todas las reservas por idusuario
    $stmt = $this->pdo->prepare("SELECT * FROM reserva WHERE idusuario = ?");
    $stmt->execute([$id]); // Ejecutar la consulta

    // Obtener todos los resultados como un array asociativo
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar las reservas encontradas
    return $reservas; // No se hace json_encode aquí, eso se hace en el controlador si es necesario
}





public function actualizarreserva($id) {
    try {
        $stmt = $this->pdo->prepare("UPDATE reserva
                                     SET
                                         estado = ?
                                     WHERE cont = ?");
        $success = $stmt->execute([
                                 'Aprobado',  // Corregido el typo
                                 $id
                             ]);

        if ($success) {
            return ['status' => 'success', 'message' => 'Reserva actualizada correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'No se pudo actualizar la reserva'];
        }
    } catch (PDOException $e) {
        error_log('Error en la actualización: ' . $e->getMessage());
        return ['status' => 'error', 'message' => 'Error en la actualización: ' . $e->getMessage()];
    }
}





public function eliminarreserva($id) {
    try {
        // Preparar la consulta para eliminar la reserva
        $stmt = $this->pdo->prepare("DELETE FROM reserva WHERE cont = ?");
        $success = $stmt->execute([$id]);

        if ($success) {
            return ['status' => 'success', 'message' => 'Reserva eliminada correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'No se pudo eliminar la reserva'];
        }
    } catch (PDOException $e) {
        // Registrar el error y devolver un mensaje claro
        error_log('Error en la eliminación: ' . $e->getMessage());
        return ['status' => 'error', 'message' => 'Error en la eliminación: ' . $e->getMessage()];
    }
}






//!Elementos administrador
public function admincrearpaquete($nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales) {
        try {
            // Preparar la consulta SQL de inserción
            $stmt = $this->pdo->prepare("INSERT INTO paquete (nombre, descripcion, precio, value, tipoPrecio, imagenHabitacion,
              alimentacion, actividades, adicionales)
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Ejecutar la consulta y comprobar si se ejecutó correctamente
            if ($stmt->execute([$nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales])) {
                return true;  // Si la inserción fue exitosa
            } else {
                return false;  // Si algo falló
            }
        } catch (PDOException $e) {
            // Si hay un error con la consulta
            echo "Error al guardar los datos: " . $e->getMessage();
            return false;
        }
    }



    // Método para obtener todos los paquetes
        public function obtenerTodos() {
            try {
                // Realizar la consulta para obtener todos los paquetes
                $query = "SELECT * FROM paquete";  // Cambié 'paquetes' por 'paquete' según tu estructura

                // Preparar la consulta
                $stmt = $this->pdo->prepare($query);

                // Ejecutar la consulta
                $stmt->execute();

                // Comprobar si la consulta devolvió resultados
                if ($stmt->rowCount() > 0) {
                    // Si hay paquetes, los devolvemos en un array
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    // Si no hay paquetes, devolvemos un array vacío
                    return [];
                }
            } catch (PDOException $e) {
                // Si hay un error con la consulta
                echo "Error al obtener los paquetes: " . $e->getMessage();
                return null;
            }
        }



        public function eliminarpaquete($id){
            try {
                // Preparar la consulta SQL para eliminar un paquete por ID
                $stmt = $this->pdo->prepare("DELETE FROM paquete WHERE cont = ?");


                // Ejecutar la consulta y pasar el ID del paquete
                $stmt->execute([$id]);

                // Verificar si la eliminación fue exitosa (la cantidad de filas afectadas debe ser > 0)
                if ($stmt->rowCount() > 0) {
                    return true;  // El paquete fue eliminado correctamente
                } else {
                    return false;  // No se encontró el paquete o no se eliminó
                }
            } catch (PDOException $e) {
                // Manejo de errores en la base de datos
                echo "Error al eliminar el paquete: " . $e->getMessage();
                return false;
            }
        }




        public function adminactualizarpaquete($id, $nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales) {
    try {
        // Validación de datos
        if (empty($id) || empty($nombre) || empty($descripcion)) {
            return ['status' => 'error', 'message' => 'Algunos datos requeridos están vacíos'];
        }

        // Asegúrate de que 'cont' es el campo correcto, si no, reemplaza por 'id'
        $stmt = $this->pdo->prepare(
            "UPDATE paquete
             SET nombre = ?, descripcion = ?, precio = ?, value = ?, tipoPrecio = ?, imagenHabitacion = ?, alimentacion = ?, actividades = ?, adicionales = ?
             WHERE cont = ?"
        );

        $success = $stmt->execute([$nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales, $id]);

        // Verifica si alguna fila fue afectada
        if ($stmt->rowCount() > 0) {
            return ['status' => 'success', 'message' => 'Paquete actualizado correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'No se encontró el paquete o no se realizó ninguna actualización'];
        }
    } catch (PDOException $e) {
        error_log('Error en la actualización: ' . $e->getMessage());
        return ['status' => 'error', 'message' => 'Error en la actualización', 'error' => $e->getMessage()];
    }
}






// Método para obtener todos los usuarios
public function leerusuariosAll() {
    try {
        // Realizar la consulta para obtener todos los usuarios
        $query = "SELECT * FROM usuarios";

        // Preparar la consulta
        $stmt = $this->pdo->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Comprobar si la consulta devolvió resultados
        if ($stmt->rowCount() > 0) {
            // Si hay usuarios, devolverlos en un array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Si no hay usuarios, devolver un array vacío
            return [];
        }
    } catch (PDOException $e) {
        // Si hay un error con la consulta, registrar en log
        error_log("Error al obtener los usuarios: " . $e->getMessage());
        return null;
    }
}









public function bloquearusuario($id) {
    try {
        // Actualizar el rol del usuario (bloquearlo)
        $stmt = $this->pdo->prepare("UPDATE usuarios
                                     SET role_id = ?
                                     WHERE cont = ?");
        $success = $stmt->execute([
            '0',
            $id
        ]);

        if ($success) {
            // Si se actualizó correctamente, obtener todos los usuarios
            $usuarios = $this->leerusuariosAll();

            return [
                'status' => '200',
                'message' => 'Usuario bloqueado correctamente',
                'data' => $usuarios // Devolver la lista de usuarios
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'No se pudo bloquear el usuario'
            ];
        }
    } catch (PDOException $e) {
        error_log('Error en la actualización: ' . $e->getMessage());
        return [
            'status' => 'error',
            'message' => 'Error en la actualización: ' . $e->getMessage()
        ];
    }
}


public function activarusuario($id) {
    try {
        // Actualizar el rol del usuario (bloquearlo)
        $stmt = $this->pdo->prepare("UPDATE usuarios
                                     SET role_id = ?
                                     WHERE cont = ?");
        $success = $stmt->execute([
            '2',
            $id
        ]);

        if ($success) {
            // Si se actualizó correctamente, obtener todos los usuarios
            $usuarios = $this->leerusuariosAll();

            return [
                'status' => '200',
                'message' => 'Usuario bloqueado correctamente',
                'data' => $usuarios // Devolver la lista de usuarios
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'No se pudo bloquear el usuario'
            ];
        }
    } catch (PDOException $e) {
        error_log('Error en la actualización: ' . $e->getMessage());
        return [
            'status' => 'error',
            'message' => 'Error en la actualización: ' . $e->getMessage()
        ];
    }
}







// Método para obtener todos los usuarios
public function listareservasall() {
    try {
        // Realizar la consulta para obtener todos los usuarios
        $query = "SELECT * FROM reserva";

        // Preparar la consulta
        $stmt = $this->pdo->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Comprobar si la consulta devolvió resultados
        if ($stmt->rowCount() > 0) {
            // Si hay usuarios, devolverlos en un array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Si no hay usuarios, devolver un array vacío
            return [];
        }
    } catch (PDOException $e) {
        // Si hay un error con la consulta, registrar en log
        error_log("Error al obtener los usuarios: " . $e->getMessage());
        return null;
    }
}








public function adminactivarreservas($id, $estado) {
    try {
        // Validación de datos
        if (empty($id) || empty($estado)) {
            return [
                'status' => 'error',
                'message' => 'Algunos datos requeridos están vacíos'
            ];
        }

        // Preparar la consulta SQL para actualizar el estado
        $stmt = $this->pdo->prepare(
            "UPDATE reserva
             SET estado = ?
             WHERE cont = ?"
        );

        // Ejecutar la consulta con los parámetros proporcionados
        $success = $stmt->execute([$estado, $id]);

        // Verificar si alguna fila fue afectada
        if ($stmt->rowCount() > 0) {

        //  $usuarios = $this->listareservasall();
           return [
                'status' => 'success',
                'message' => 'Reserva actualizada correctamente'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'No se encontró la reserva o no se realizó ninguna actualización'
            ];
        }
    } catch (PDOException $e) {
        // Registrar el error en el log del servidor para depuración
        error_log('Error en la actualización: ' . $e->getMessage());
        return [
            'status' => 'error',
            'message' => 'Error en la actualización',
            'error' => $e->getMessage()
        ];
    }
}





















}




?>
