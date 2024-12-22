<?php

// Requiere el controlador de usuario
require 'controllers/UsuarioController.php';

// Crear una instancia del controlador
$controller = new UsuarioController();

// Obtener la acción desde la URL (GET) o usar 'read' por defecto
$action = $_GET['action'] ?? 'read';

// Obtener el ID desde la URL (GET), por defecto 'null'
$id = $_GET['id'] ?? 'null';
$estado = $_GET['estado'] ?? 'null';

// Obtener los datos JSON enviados en el cuerpo de la solicitud
$inputData = json_decode(file_get_contents("php://input"), true);


// Controlador de las acciones según el parámetro 'action' recibido
switch ($action) {
    // Acciones relacionadas con los usuarios
    case 'crear':
        $controller->crear();
        break;

    case 'buscar':
        $controller->leer();
        break;

    case 'actualizar':
        $controller->actualizar($id, $inputData);
        break;

    // Acciones relacionadas con las reservas
    case 'crearreserva':
        $controller->crearreserva();
        break;

    case 'verreserva':
        $controller->verreserva($id);
        break;

    case 'actualizarreserva':
        $controller->actualizarreserva($id);
        break;

    case 'eliminarreserva':
        $controller->eliminarreserva($id);
        break;

    // Actividades del administrador relacionadas con los paquetes
    case 'crearpaquete':
        $controller->admincrearpaquete();
        break;

    case 'verpaquetes':
        $controller->verpaquetes();
        break;

    case 'adminactualizarpaquete':

        $controller->adminactualizarpaquete($id);
        break;

    case 'eliminarpaquete':

        $controller->eliminarpaquete($id);
        break;

    case 'leerusuariosAll':
      $controller->leerusuariosAll();
      break;



      case 'bloquearusuario':
        $controller->bloquearusuario($id);
      break;

      case 'activarusuario':
      $controller->activarusuario($id);
      break;

      case 'listareservasall':
      $controller->listareservasall($id);
      break;

      case 'adminactivarreservas':
      if ($id !== 'null' && $estado !== 'null') {
          $controller->adminactivarreservas($id, $estado);
      } else {
          echo json_encode(['error' => 'Parámetros insuficientes']);
          http_response_code(400);
      }
      break;

    default:
        // Si no se encuentra la acción, no hacer nada
        break;
}
?>
