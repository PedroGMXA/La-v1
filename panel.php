<?php
// Incluir config para iniciar sesión
require_once "config.php";

// Verificar si el usuario está logueado, si no, redirigir a la página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Obtener el nombre de usuario de la sesión para mostrarlo
$username = htmlspecialchars($_SESSION["username"]); // Usar htmlspecialchars para prevenir XSS

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - LavanderiaMX</title> <!-- Título actualizado -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Ruta CSS actualizada -->
    <link rel="stylesheet" href="assets/css/estilos.css"> <!-- Asumiendo que panel.css está en estilos.css o en otra parte de assets -->
    <link rel="stylesheet" href="css/panel.css"> <!-- Mantengo esta por si acaso -->
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="header-left">
                <button class="menu-toggle-button" aria-label="Alternar menú">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="logo">
                    <a href="#" class="logo-link" aria-label="Ir al inicio del panel">
                        <!-- Icono actualizado -->
                        <i class="fas fa-tint logo-icon" aria-hidden="true"></i> 
                        <span class="logo-text">LAVANDERIA<span class="logo-accent">MX</span></span> <!-- Nombre actualizado -->
                    </a>
                </div>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <!-- Mostrar nombre de usuario de la sesión -->
                    <span class="user-name"><?php echo $username; ?></span> 
                    <!-- Enlace para cerrar sesión -->
                    <a href="logout.php" class="logout-button" aria-label="Cerrar la sesión actual">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </header>

        <aside class="dashboard-sidebar">
            <nav aria-label="Navegación principal">
                <ul>
                    <!-- Los enlaces deberían apuntar a páginas PHP reales o usar JS para cargar contenido -->
                    <li><a href="panel.php" class="active" aria-current="page"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> <span>Panel Principal</span></a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart" aria-hidden="true"></i> <span>Servicios</span></a></li>
                    <li><a href="#"><i class="fas fa-tshirt" aria-hidden="true"></i> <span>Productos</span></a></li>
                    <li><a href="#"><i class="fas fa-users" aria-hidden="true"></i> <span>Clientes</span></a></li>
                    <li><a href="#"><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i> <span>Gastos</span></a></li>
                    <li><a href="#"><i class="fas fa-coins" aria-hidden="true"></i> <span>Pagos</span></a></li>
                    <li><a href="#"><i class="fas fa-box" aria-hidden="true"></i> <span>Caja y Reportes</span></a></li>
                    <li><a href="#"><i class="fas fa-file-invoice" aria-hidden="true"></i> <span>Facturación 4.0</span></a></li>
                    <li><a href="#"><i class="fas fa-barcode" aria-hidden="true"></i> <span>Código de Barras</span></a></li>
                    <li><a href="#"><i class="fas fa-cogs" aria-hidden="true"></i> <span>Configuración</span></a></li>
                    <li><a href="#"><i class="fas fa-shopping-basket" aria-hidden="true"></i> <span>Comprar Accesorios</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard-main">
            <section class="panel-header">
                <h1>Panel Principal</h1>
                 <!-- Mensaje de bienvenida con nombre de usuario -->
                <p>Bienvenido de nuevo, <?php echo $username; ?>.</p>
            </section>

            <section class="quick-stats">
                 <!-- Estos datos deberían cargarse dinámicamente con PHP/JS -->
                 <div class="stat-card">
                     <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                     <div class="stat-info">
                         <span class="stat-value">$0.00</span>
                         <span class="stat-label">Ingresos Hoy</span>
                     </div>
                 </div>
                 <div class="stat-card">
                     <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
                     <div class="stat-info">
                         <span class="stat-value">0</span>
                         <span class="stat-label">Nuevos Clientes</span>
                     </div>
                 </div>
                 <div class="stat-card">
                     <div class="stat-icon"><i class="fas fa-tasks"></i></div>
                     <div class="stat-info">
                         <span class="stat-value">0</span>
                         <span class="stat-label">Tareas Pendientes</span>
                     </div>
                 </div>
                 <div class="stat-card notification-card">
                     <div class="stat-icon"><i class="fas fa-bell"></i></div>
                     <div class="stat-info">
                         <span class="stat-value">0</span>
                         <span class="stat-label">Notificaciones</span>
                     </div>
                 </div>
            </section>

            <section class="main-content-area card">
                <section class="data-list" aria-labelledby="data-list-heading">
                    <div class="data-list-header">
                        <h2 id="data-list-heading">Últimos Servicios</h2>
                        <div class="list-controls">
                            <div class="filter-group">
                                <label for="status-filter" class="sr-only">Estado:</label>
                                <select id="status-filter">
                                    <option value="">Todos los Estados</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Listo">Listo</option>
                                    <option value="En Espera">En Espera</option>
                                    <option value="Entregado">Entregado</option>
                                    <option value="Garantía">Garantía</option>
                                </select>
                            </div>
                            <div class="search-group">
                                <label for="data-search" class="sr-only">Buscar:</label>
                                <input type="text" id="data-search" placeholder="Buscar Folio, Cliente...">
                                <button id="search-button" aria-label="Buscar"><i class="fas fa-search"></i></button>
                            </div>
                             <button class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Servicio</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                         <table id="servicios-table">
                            <thead>
                                <tr>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <!-- ID AÑADIDO AQUÍ -->
                            <tbody id="servicios-tbody">
                                <!-- Los datos se cargarán aquí -->
                                <tr><td colspan="5">Cargando servicios...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <span id="pagination-info">Página 1 de 1</span>
                        <button id="prev-page" aria-label="Página anterior" disabled><i class="fas fa-chevron-left"></i></button>
                        <button id="next-page" aria-label="Página siguiente" disabled><i class="fas fa-chevron-right"></i></button>
                    </div>
                </section>
            </section>

             <section class="main-content-area card">
                 <section class="data-list" aria-labelledby="clientes-heading">
                     <div class="data-list-header">
                         <h2 id="clientes-heading">Clientes Recientes</h2>
                         <button class="btn btn-secondary"><i class="fas fa-user-plus"></i> Nuevo Cliente</button>
                     </div>
                    <div class="table-responsive">
                        <table id="clientes-table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                             <!-- ID AÑADIDO AQUÍ (por si lo necesitas después) -->
                            <tbody id="clientes-tbody">
                                <tr><td colspan="5">Cargando clientes...</td></tr>
                               </tbody>
                        </table>
                     </div>
                 </section>
             </section>

        </main>
    </div>

    <!-- Ruta JS actualizada -->
    <script src="assets/js/script.js"></script>
</body>
</html>