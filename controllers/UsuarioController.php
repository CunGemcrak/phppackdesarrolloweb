<?php
require_once 'models/Usuario.php';

class UsuarioController {
    private $usuario;

    public function __construct(){
        $this->usuario = new Usuario();
    }

    public function crear() {
        echo 'llego aca al crear';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el cuerpo de la solicitud como JSON
                        $inputData = json_decode(file_get_contents("php://input"), true);

                        echo 'entro aca al post'.$inputData ;

                     	$tdocumento = $inputData['tdocumento'] ?? null;
                        $idusuario = $inputData['idusuario'] ?? null;
                        $imagen = $inputData['imagen'] ?? null;
                        $nombre = $inputData['nombre'] ?? null;
                        $papellido = $inputData['papellido'] ?? null;
                        $sapellido = $inputData['sapellido'] ?? null;
                        $celular = $inputData['celular'] ?? null;
                        $email = $inputData['email'] ?? null;
                        $passwords = $inputData['passwords'] ?? null;
                        $role_id = $inputData['role_id'] ?? null;



            if (isset($tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $passwords, $role_id)) {

                // Inserción de datos en la base de datos
                $result = $this->usuario->crear($tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $passwords, $role_id);

                // Respuesta como JSON
                header('Content-Type: application/json');
                if ($result) {
                    return json_encode(['status' => 'success', 'message' => 'Usuario creado con éxito']);
                } else {
                    return json_encode(['status' => 'error', 'message' => 'Error al crear el usuario']);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'Faltan datos']);
            }
        }
    }

    public function leer() {
        // Leer los datos enviados desde el frontend (React o cualquier otra app)
        $inputData = json_decode(file_get_contents("php://input"), true);

        $email = $inputData['email'] ?? null;
        $passwords = $inputData['passwords'] ?? null;

        // Verificar que los datos necesarios están presentes
        if (!$email || !$passwords) {
            echo json_encode(['error' => 'Email y contraseña son obligatorios']);
            http_response_code(400); // Bad Request
            return;
        }

        // Llamar al método del modelo para buscar al usuario
        $usuario = $this->usuario->leer($email, $passwords);

        // Verificar si el usuario fue encontrado
        if ($usuario) {
            // Si el usuario existe, retornar como JSON
            header('Content-Type: application/json');
            echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
            http_response_code(404); // Not Found
        }
    }



   public function actualizar($id, $inputData) {
    if (!$id) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'ID no proporcionado.']);
        return;
    }

    // Extraer los datos de la entrada
    $tdocumento = $inputData['tdocumento'] ?? null;
    $idusuario = $inputData['idusuario'] ?? null;
    $imagen = $inputData['imagen'] ?? null;
    $nombre = $inputData['nombre'] ?? null;
    $papellido = $inputData['papellido'] ?? null;
    $sapellido = $inputData['sapellido'] ?? null;
    $celular = $inputData['celular'] ?? null;
    $email = $inputData['email'] ?? null;
    $role_id = $inputData['role_id'] ?? null;

    // Verificar si el usuario existe
    $usuario = $this->usuario->encontrar($id);

    if (!$usuario) {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['message' => 'Usuario no encontrado.']);
        return;
    }

    // Llama al modelo para actualizar los datos
    $result = $this->usuario->actualizar($id, $tdocumento, $idusuario, $imagen, $nombre, $papellido, $sapellido, $celular, $email, $role_id);

    if ($result) {
        header('HTTP/1.1 200 OK');
        echo json_encode(['message' => 'Usuario actualizado correctamente.']);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['message' => 'Error al actualizar el usuario.']);
    }
}




//!Actividades de reserva

public function crearreserva() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Leer el cuerpo de la solicitud como JSON
                    $inputData = json_decode(file_get_contents("php://input"), true);



                    $tidentificacion = $inputData['tidentificacion'] ?? null;
                    $idusuario = $inputData['idusuario'] ?? null;
                    $nombre = $inputData['nombre'] ?? null;
                    $papellido = $inputData['papellido'] ?? null;
                    $sapellido = $inputData['sapellido'] ?? null;
                    $celular = $inputData['celular'] ?? null;
                    $mail = $inputData['mail'] ?? null;
                    $paquete = $inputData['paquete'] ?? null;
                    $canpersonas = $inputData['canpersonas'] ?? null;
                    $costopaquete = $inputData['costopaquete'] ?? null;



        if (isset($tidentificacion, $idusuario, $nombre, $papellido, $sapellido, $celular, $mail, $paquete, $canpersonas, $costopaquete)) {

            // Inserción de datos en la base de datos
            $result = $this->usuario->crearreserva($tidentificacion, $idusuario, $nombre,
                                             $papellido, $sapellido, $celular, $mail,
                                              $paquete, $canpersonas, $costopaquete);

            // Respuesta como JSON
            header('Content-Type: application/json');
            if ($result) {
                return json_encode(['status' => 'success', 'message' => 'Usuario creado con éxito']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Error al crear el usuario']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Faltan datos']);
        }
    }
}





public function verreserva($id) {

    // Llamar al método del modelo para buscar al usuario
    $usuario = $this->usuario->verreserva($id);

    // Verificar si el usuario fue encontrado
    if ($usuario) {
        // Si el usuario existe, retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
        http_response_code(404); // Not Found
    }
}

public function actualizarreserva($id) {
    // Verificar si el ID es válido
    if (!$id) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'ID de la reserva no proporcionado.']);
        return;
    }

    // Llama al modelo para actualizar la reserva
    $result = $this->usuario->actualizarreserva($id);

    if ($result) {
        header('HTTP/1.1 200 OK');
        echo json_encode(['message' => 'Reserva actualizada correctamente.']);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['message' => 'Error al actualizar la reserva.']);
    }
}

public function eliminarreserva($id) {
    // Verificar si el ID es válido
    if (!$id) {
        // Responder con error si el ID no se proporciona
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'ID de la reserva no proporcionado.']);
        return;
    }

    // Llama al modelo para eliminar la reserva
    $result = $this->usuario->eliminarreserva($id);

    // Verifica si la eliminación fue exitosa
    if ($result) {
        // Responder con éxito si la reserva fue eliminada
        header('HTTP/1.1 200 OK');
        echo json_encode(['message' => 'Reserva eliminada correctamente.']);
    } else {
        // Responder con error si ocurrió un problema al eliminar la reserva
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['message' => 'Error al eliminar la reserva.']);
    }
}















//!Actividades del administrador
public function admincrearpaquete() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Leer el cuerpo de la solicitud como JSON
                    $inputData = json_decode(file_get_contents("php://input"), true);

                  //  echo 'entro aca al post'.$inputData ;

                    $nombre = $inputData['nombre'] ?? null;
                    $descripcion = $inputData['descripcion'] ?? null;
                    $precio = $inputData['precio'] ?? null;
                    $value = $inputData['value'] ?? null;
                    $tipoPrecio = $inputData['tipoPrecio'] ?? null;
                    $imagenHabitacion = $inputData['imagenHabitacion'] ?? null;
                    $alimentacion = $inputData['alimentacion'] ?? null;
                    $actividades = $inputData['actividades'] ?? null;
                    $adicionales = $inputData['adicionales'] ?? null;




        if (isset($nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales)) {

            // Inserción de datos en la base de datos
            $result = $this->usuario->admincrearpaquete($nombre, $descripcion, $precio, $value, $tipoPrecio, $imagenHabitacion, $alimentacion, $actividades, $adicionales);

            // Respuesta como JSON
            header('Content-Type: application/json');
            if ($result) {
                return json_encode(['status' => 'success', 'message' => 'Usuario creado con éxito']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Error al crear el usuario']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Faltan datos']);
        }
    }
}


public function verpaquetes() {
       // Llamar al método del modelo para obtener todos los paquetes
       $paquetes = $this->usuario->obtenerTodos(); // Ahora puedes acceder al modelo Paquete

       // Verificar si los paquetes fueron encontrados
       if ($paquetes) {
           // Si los paquetes existen, retornarlos como JSON
           header('Content-Type: application/json');
           echo json_encode($paquetes, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
       } else {
           // Si no hay paquetes, retornar un error
           echo json_encode(['error' => 'No se encontraron paquetes']);
           http_response_code(404); // Not Found
       }
   }






   public function eliminarpaquete($id) {
       try {
           if (!$id) {
               header('HTTP/1.1 400 Bad Request');
               echo json_encode(['message' => 'ID del paquete no proporcionado.']);
               return;
           }

           $result = $this->usuario->eliminarpaquete($id); // Lógica del modelo

           if ($result) {
               header('HTTP/1.1 200 OK');
               echo json_encode(['message' => 'Paquete eliminado correctamente.']);
           } else {
               header('HTTP/1.1 500 Internal Server Error');
               echo json_encode(['message' => 'No se pudo eliminar el paquete.']);
           }
       } catch (Exception $e) {
           header('HTTP/1.1 500 Internal Server Error');
           echo json_encode(['message' => 'Error interno del servidor.', 'error' => $e->getMessage()]);
       }
   }



public function adminactualizarpaquete($id) {
    // Verificar si el ID es válido


    // Verificar si el método HTTP es PUT
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Método no permitido. Se requiere PUT.']);
        return;
    }

    // Leer el cuerpo de la solicitud
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!$inputData) {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Datos de entrada no válidos.']);
        return;
    }

    // Asignar los valores de entrada con validación

    $nombre = $inputData['nombre'] ?? null;
    $descripcion = $inputData['descripcion'] ?? null;
    $precio = $inputData['precio'] ?? null;
    $value = $inputData['value'] ?? null;
    $tipoPrecio = $inputData['tipoPrecio'] ?? null;
    $imagenHabitacion = $inputData['imagenHabitacion'] ?? null;
    $alimentacion = $inputData['alimentacion'] ?? null;
    $actividades = $inputData['actividades'] ?? null;
    $adicionales = $inputData['adicionales'] ?? null;
  //  $id = $inputData['cont'];

    // Llamar al modelo para actualizar el paquete
    $result = $this->usuario->adminactualizarpaquete(
        $id,
        $nombre,
        $descripcion,
        $precio,
        $value,
        $tipoPrecio,
        $imagenHabitacion,
        $alimentacion,
        $actividades,
        $adicionales
    );

    // Manejo de la respuesta
    if ($result && $result['status'] === 'success') {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(['message' => $result['message']]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode(['message' => $result['message'] ?? 'Error al actualizar el paquete.']);
    }
}


public function leerusuariosAll() {
    // Leer los datos enviados desde el frontend (React o cualquier otra app)


    // Verificar que los datos necesarios están presentes


    // Llamar al método del modelo para buscar al usuario
    $usuario = $this->usuario->leerusuariosAll();

    // Verificar si el usuario fue encontrado
    if ($usuario) {
        // Si el usuario existe, retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
        http_response_code(404); // Not Found
    }
}





public function bloquearusuario($id) {
    // Leer los datos enviados desde el frontend (React o cualquier otra app)


    // Verificar que los datos necesarios están presentes


    // Llamar al método del modelo para buscar al usuario
    $usuario = $this->usuario->bloquearusuario($id);

    // Verificar si el usuario fue encontrado
    if ($usuario) {
        // Si el usuario existe, retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
        http_response_code(404); // Not Found
    }
}




public function activarusuario($id) {
    // Leer los datos enviados desde el frontend (React o cualquier otra app)


    // Verificar que los datos necesarios están presentes


    // Llamar al método del modelo para buscar al usuario
    $usuario = $this->usuario->activarusuario($id);

    // Verificar si el usuario fue encontrado
    if ($usuario) {
        // Si el usuario existe, retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
        http_response_code(404); // Not Found
    }
}






public function listareservasall() {
    // Leer los datos enviados desde el frontend (React o cualquier otra app)


    // Verificar que los datos necesarios están presentes


    // Llamar al método del modelo para buscar al usuario
    $usuario = $this->usuario->listareservasall();

    // Verificar si el usuario fue encontrado
    if ($usuario) {
        // Si el usuario existe, retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($usuario, JSON_UNESCAPED_SLASHES);  // Usar JSON_UNESCAPED_SLASHES para evitar escapes
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
        http_response_code(404); // Not Found
    }
}




public function adminactivarreservas($id, $estado) {
    // Verificar que los datos necesarios están presentes
    if (empty($id) || empty($estado)) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Faltan datos obligatorios (id o estado).']);
        return;
    }

    // Llamar al método del modelo para actualizar el estado de la reserva
    $resultado = $this->usuario->adminactivarreservas($id, $estado);

    // Verificar el resultado de la operación
    if ($resultado) {
        // Si la actualización fue exitosa, retornar una respuesta JSON
        http_response_code(200); // OK
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Reserva actualizada correctamente']);
    } else {
        // Si no se pudo actualizar, retornar un error
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'No se pudo actualizar la reserva.']);
    }
}


}
?>
