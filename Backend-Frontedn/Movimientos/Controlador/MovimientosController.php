<?php
require_once __DIR__ . '/../Modelo/MovimientosService.php';

class MovimientosController {
    private $movimientosService;

    public function __construct() {
        $this->movimientosService = new MovimientosService();
    }

    public function procesarPeticion() {
        $movimientos = [];
        $mensaje = null;
        $accion = $_REQUEST['accion'] ?? 'ver_todos';

        switch ($accion) {
            case 'ver_todos':
                $movimientos = $this->movimientosService->obtenerTodosLosMovimientos();
                break;

            case 'agregar':
                $ok = $this->movimientosService->agregarMovimiento($this->getDatosFormulario());
                $mensaje = $ok ? "Movimiento agregado correctamente." : "Error al agregar movimiento.";
                $movimientos = $this->movimientosService->obtenerTodosLosMovimientos();
                break;

            case 'actualizar':
                $id = $_POST['movimiento_id'] ?? '';
                if (!empty($id)) {
                    $ok = $this->movimientosService->actualizarMovimiento($id, $this->getDatosFormulario());
                    $mensaje = $ok ? "Movimiento actualizado correctamente." : "Error al actualizar movimiento.";
                } else {
                    $mensaje = "Falta el ID para actualizar.";
                }
                $movimientos = $this->movimientosService->obtenerTodosLosMovimientos();
                break;

            case 'eliminar':
                $id = $_POST['movimiento_id'] ?? '';
                if (!empty($id)) {
                    $ok = $this->movimientosService->eliminarMovimiento($id);
                    $mensaje = $ok ? "Movimiento eliminado correctamente." : "Error al eliminar movimiento.";
                } else {
                    $mensaje = "Falta el ID para eliminar.";
                }
                $movimientos = $this->movimientosService->obtenerTodosLosMovimientos();
                break;

            default:
                $mensaje = "Acción no válida.";
                $movimientos = $this->movimientosService->obtenerTodosLosMovimientos();
        }

        // Pasar datos a la vista
        require __DIR__ . '/../Vista/index.php';
    }

    private function getDatosFormulario() {
        return [
            'tipo' => $_POST['tipo'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'cantidad' => $_POST['cantidad'] ?? 0,
            'fecha' => $_POST['fecha'] ?? '',
            'usuario_responsable' => $_POST['usuario_responsable'] ?? '',
            'accion' => $_POST['accion_movimiento'] ?? '',
            'id_producto' => $_POST['id_producto'] ?? null
        ];
    }
}

// Permitir ejecución directa del controlador
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    (new MovimientosController())->procesarPeticion();
}
