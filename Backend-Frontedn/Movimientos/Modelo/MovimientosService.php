<?php
require_once __DIR__ . '/config.php';

class MovimientosService {
    private $url_get;
    private $url_post;
    private $url_put;
    private $url_delete;

    public function __construct() {
        $this->url_get = URL_GET;
        $this->url_post = URL_POST;
        $this->url_put = URL_PUT;
        $this->url_delete = URL_DELETE;
    }

    // --- GET ---
    public function obtenerTodosLosMovimientos() {
        $consumo = @file_get_contents($this->url_get);

        if ($consumo === false) {
            $error = error_get_last();
            return ['error' => "Error al consumir el servicio: " . $error['message']];
        }

        $data = json_decode($consumo);
        return $data ?? [];
    }

    // --- POST ---
    public function agregarMovimiento($datos) {
        return $this->ejecutarPeticion(
            $this->url_post,
            "POST",
            $datos,
            "Movimiento agregado correctamente",
            "Error al agregar movimiento"
        );
    }

    // --- PUT ---
    public function actualizarMovimiento($id, $datos) {
        $data = array_merge(["id_movimiento" => $id], $datos);

        return $this->ejecutarPeticion(
            $this->url_put,
            "PUT",
            $data,
            "Movimiento actualizado correctamente",
            "Error al actualizar movimiento"
        );
    }

    // --- DELETE ---
    public function eliminarMovimiento($id) {
        $data = ["id_movimiento" => $id];

        return $this->ejecutarPeticion(
            $this->url_delete,
            "DELETE",
            $data,
            "Movimiento eliminado correctamente",
            "Error al eliminar movimiento"
        );
    }

    // --- Método genérico para POST, PUT, DELETE ---
    private function ejecutarPeticion($url, $metodo, $data, $msgExito, $msgError) {
        if (!function_exists('curl_init')) {
            return ['error' => 'cURL no está disponible en este servidor'];
        }

        $json = json_encode($data);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $metodo,
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Content-Length: ' . strlen($json)
            ]
        ]);

        $respuesta = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => "Error en la petición $metodo: $error"];
        }

        curl_close($ch);

        return $http >= 200 && $http < 300
            ? ['exito' => true, 'mensaje' => $msgExito, 'respuesta' => $respuesta]
            : ['error' => "$msgError. Código HTTP: $http", 'respuesta' => $respuesta];
    }
}

