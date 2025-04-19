<?php
// Iniciar sesión para poder acceder a las variables de sesión (para errores)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Leer errores de la sesión si existen
$login_err = $_SESSION['login_error'] ?? '';
$username_err = $_SESSION['username_error'] ?? '';
$password_err = $_SESSION['password_error'] ?? '';

// Limpiar los errores de la sesión para que no se muestren de nuevo
unset($_SESSION['login_error']);
unset($_SESSION['username_error']);
unset($_SESSION['password_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LavanderiaMX</title> <!-- Título actualizado -->

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Usaremos una ruta relativa consistente para los assets -->
    <link rel="stylesheet" href="assets/css/estilos.css">
    <!-- <link rel="stylesheet" href="css/style.css"> Reemplazada por estilos.css? -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/login.css"> Asumo que estilos.css contiene esto -->

</head>
<body>

        <div class="titulo__devgmxa"> <!-- Mantengo esta clase por si el CSS la usa -->
            <h1><span class="icono">&lt;/&gt;</span> <span class="dev">LAVANDERIA</span><span class="gmxa">MX</span></h1> <!-- Nombre actualizado -->
        </div>
        <main>

            <div class="contenedor__todo">
                <div class="caja__trasera">
                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar en la página</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja__trasera-register">
                        <h3>¿Aún no tienes una cuenta?</h3>
                        <p>Regístrate para que puedas iniciar sesión</p>
                        <button id="btn__registrarse">Regístrarse</button>
                    </div>
                </div>

                <!--Formulario de Login y registro-->
                <div class="contenedor__login-register">

                    <!--Login-->
                    <!-- Actualizado: action apunta a procesar_login.php, method es POST -->
                    <form action="procesar_login.php" method="post" class="formulario__login">
                        <h2>Iniciar Sesión</h2>

                        <?php
                        // Mostrar errores generales de login
                        if(!empty($login_err)){
                            echo '<div style="color: red; margin-bottom: 10px;">' . htmlspecialchars($login_err) . '</div>';
                        }
                        // Mostrar error específico de usuario
                        if(!empty($username_err)){
                             echo '<div style="color: red; margin-bottom: 5px;">' . htmlspecialchars($username_err) . '</div>';
                        }
                        ?>
                        <!-- Actualizado: añadido name="username" -->
                        <input type="text" placeholder="Nombre de Usuario" name="username" required> <!-- Cambiado placeholder y añadido required -->

                         <?php
                        // Mostrar error específico de contraseña
                        if(!empty($password_err)){
                             echo '<div style="color: red; margin-bottom: 5px;">' . htmlspecialchars($password_err) . '</div>';
                        }
                        ?>
                        <!-- Actualizado: añadido name="password" -->
                        <input type="password" placeholder="Contraseña" name="password" required> <!-- Añadido required -->
                        <button type="submit">Entrar</button> <!-- Añadido type="submit" -->
                    </form>

                    <!--Register-->
                    <!-- Dejamos el formulario de registro como estaba por ahora -->
                    <form action="" class="formulario__register">
                        <h2>Regístrarse</h2>
                        <input type="text" placeholder="Nombre completo">
                        <input type="text" placeholder="Correo Electronico">
                        <input type="text" placeholder="Usuario">
                        <input type="password" placeholder="Contraseña">
                        <button>Regístrarse</button>
                    </form>
                </div>
            </div>

        </main>

        <!-- Usaremos una ruta relativa consistente para los assets -->
        <script src="assets/js/script.js"></script>
</body>
</html>