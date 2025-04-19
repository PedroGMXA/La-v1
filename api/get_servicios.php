<?php
// Incluir archivo de configuración y conexión a BD
require_once "../config.php"; // Usamos ../ porque config.php está un nivel arriba

// Permitir solicitudes desde cualquier origen (para desarrollo - ajusta si es necesario para producción)
header("Access-Control-Allow-Origin: *");
// Indicar que la respuesta es JSON
header("Content-Type: application/json; charset=UTF-8");

// Array para almacenar los resultados
$servicios = array();
$response = array(); // Array para la respuesta completa

// Preparar la consulta SQL (ajusta los nombres de tabla y columnas según tu BD)
// Asumimos una tabla 'servicios' y queremos algunos campos básicos
// Ordenamos por ID descendente para obtener los más recientes, limitamos a 10 por ejemplo
$sql = "SELECT id, folio, fecha_recibido, cliente_nombre, estado FROM servicios ORDER BY id DESC LIMIT 10"; // Ajusta cliente_nombre si tienes una tabla separada de clientes

if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        // Recorrer los resultados y añadirlos al array $servicios
        while($row = mysqli_fetch_assoc($result)){
            $servicios[] = $row;
        }
        // Liberar el conjunto de resultados
        mysqli_free_result($result);
        $response['status'] = 'success';
        $response['data'] = $servicios;
    } else{
         $response['status'] = 'success';
         $response['message'] = 'No se encontraron servicios.';
         $response['data'] = []; // Devolver array vacío
    }
} else{
    // Si hubo un error en la consulta SQL
    http_response_code(500); // Internal Server Error
    $response['status'] = 'error';
    $response['message'] = "Error al ejecutar la consulta: " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_close($link);

// Devolver los resultados como JSON
echo json_encode($response);
?>