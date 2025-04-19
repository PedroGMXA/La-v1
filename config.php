<?php
define('DB_SERVER', 'localhost'); // O la IP de tu servidor de BD
define('DB_USERNAME', 'tu_usuario_mysql'); // Cambia esto por tu usuario de MySQL
define('DB_PASSWORD', 'tu_contraseña_mysql'); // Cambia esto por tu contraseña de MySQL
define('DB_NAME', 'tu_base_de_datos'); // Cambia esto por el nombre de tu base de datos

/* Intenta conectar a la Base de Datos MySQL */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica la conexión
if($link === false){
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

// Establecer charset a utf8mb4 (recomendado)
mysqli_set_charset($link, "utf8mb4");

// Iniciar la sesión PHP (si no está iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>