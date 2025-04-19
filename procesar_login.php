<?php
// Incluir archivo de configuración
require_once "config.php";

// Definir variables e inicializar con valores vacíos
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Procesar datos del formulario cuando se envía
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validar que el nombre de usuario no esté vacío
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingresa tu nombre de usuario.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Validar que la contraseña no esté vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingresa tu contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validar credenciales si no hay errores de entrada
    if(empty($username_err) && empty($password_err)){
        // Preparar una declaración select
        $sql = "SELECT id, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Establecer parámetros
            $param_username = $username;

            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Guardar resultado
                mysqli_stmt_store_result($stmt);

                // Verificar si el usuario existe, si es así, verificar la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Vincular variables de resultado
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        // ¡IMPORTANTE! Asume que la contraseña en la BD está hasheada con password_hash()
                        if(password_verify($password, $hashed_password)){
                            // La contraseña es correcta, así que inicia una nueva sesión

                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirigir al usuario a la página del panel
                            header("location: panel.html"); // O panel.php si lo hacemos dinámico
                            exit; // Asegura que el script se detenga después de la redirección
                        } else{
                            // La contraseña no es válida
                            $login_err = "Nombre de usuario o contraseña inválidos.";
                        }
                    }
                } else{
                    // El nombre de usuario no existe
                    $login_err = "Nombre de usuario o contraseña inválidos.";
                }
            } else{
                echo "¡Ups! Algo salió mal. Por favor inténtalo de nuevo más tarde.";
            }

            // Cerrar declaración
            mysqli_stmt_close($stmt);
        }
    }

    // Cerrar conexión
    mysqli_close($link);

    // Si hubo errores de login, guardarlos en la sesión para mostrarlos en login.html (opcional)
    if(!empty($login_err)){
        $_SESSION["login_error"] = $login_err;
        // Redirigir de vuelta a la página de login para mostrar el error
        header("location: login.html");
        exit;
    }
     if(!empty($username_err)){
        $_SESSION["username_error"] = $username_err;
         header("location: login.html");
         exit;
    }
     if(!empty($password_err)){
        $_SESSION["password_error"] = $password_err;
         header("location: login.html");
         exit;
    }


} else {
    // Si alguien intenta acceder directamente a este script sin POST, redirigir al login
    header("location: login.html");
    exit;
}
?>