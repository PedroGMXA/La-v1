// --- Código existente para login/register --- 
document.addEventListener('DOMContentLoaded', () => {
    // Asegúrate de que estos elementos existen antes de añadir listeners
    const btnIniciarSesion = document.getElementById("btn__iniciar-sesion");
    const btnRegistrarse = document.getElementById("btn__registrarse");

    if (btnIniciarSesion) {
        btnIniciarSesion.addEventListener("click", iniciarSesion);
    }
    if (btnRegistrarse) {
        btnRegistrarse.addEventListener("click", register);
    }

    // Cargar servicios si estamos en la página del panel
    if (document.getElementById('servicios-tbody')) {
        cargarServicios();
    }
});

window.addEventListener("resize", anchoPage);

var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

function anchoPage(){
    // Solo ejecutar si los elementos existen (estamos en login.php)
    if (!caja_trasera_register || !caja_trasera_login) return;

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        if (formulario_login) formulario_login.style.display = "block";
        if (contenedor_login_register) contenedor_login_register.style.left = "0px";
        if (formulario_register) formulario_register.style.display = "none";   
    }
}
anchoPage(); // Ejecutar al cargar

function iniciarSesion(){
    if (!formulario_login || !contenedor_login_register || !formulario_register || !caja_trasera_register || !caja_trasera_login) return;
    if (window.innerWidth > 850){
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    }else{
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register(){
     if (!formulario_register || !contenedor_login_register || !formulario_login || !caja_trasera_register || !caja_trasera_login) return;
    if (window.innerWidth > 850){
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    }else{
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}

// --- NUEVA FUNCIÓN PARA CARGAR SERVICIOS --- 

async function cargarServicios() {
    const tbody = document.getElementById('servicios-tbody');
    if (!tbody) return; // Salir si no encontramos el tbody

    tbody.innerHTML = '<tr><td colspan="5">Cargando servicios...</td></tr>'; // Mostrar mensaje de carga

    try {
        // Hacemos la petición a nuestro script PHP
        const response = await fetch('api/get_servicios.php');

        // Verificamos si la respuesta HTTP fue exitosa (status 200-299)
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        // Convertimos la respuesta a JSON
        const result = await response.json();

        // Verificamos el status interno de nuestra API
        if (result.status === 'success') {
            tbody.innerHTML = ''; // Limpiamos el mensaje de carga o datos anteriores
            const servicios = result.data;

            if (servicios.length > 0) {
                servicios.forEach(servicio => {
                    const tr = document.createElement('tr');

                    // Escapar HTML para prevenir XSS (simple ejemplo)
                    const escapeHTML = str => str ? str.toString().replace(/</g, "&lt;").replace(/>/g, "&gt;") : '';

                    // Ajusta los nombres de las propiedades (folio, fecha_recibido, etc.) 
                    // para que coincidan EXACTAMENTE con los devueltos por tu API PHP
                    tr.innerHTML = `
                        <td>${escapeHTML(servicio.folio)}</td>
                        <td>${escapeHTML(servicio.fecha_recibido)}</td> 
                        <td>${escapeHTML(servicio.cliente_nombre)}</td>
                        <td><span class="status-${escapeHTML(servicio.estado?.toLowerCase() ?? '')}">${escapeHTML(servicio.estado)}</span></td>
                        <td>
                            <button class="btn-action view" data-id="${escapeHTML(servicio.id)}" aria-label="Ver detalle del servicio ${escapeHTML(servicio.folio)}"><i class="fas fa-eye"></i></button>
                            <button class="btn-action edit" data-id="${escapeHTML(servicio.id)}" aria-label="Editar servicio ${escapeHTML(servicio.folio)}"><i class="fas fa-edit"></i></button>
                            <button class="btn-action delete" data-id="${escapeHTML(servicio.id)}" aria-label="Eliminar servicio ${escapeHTML(servicio.folio)}"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                 // Añadir listeners a los nuevos botones (opcional, para futuras acciones)
                addTableActionListeners(tbody);

            } else {
                // Mensaje si no hay servicios
                tbody.innerHTML = '<tr><td colspan="5">No se encontraron servicios.</td></tr>';
            }
        } else {
             // Mostrar mensaje de error de la API
             tbody.innerHTML = `<tr><td colspan="5">Error: ${result.message || 'No se pudieron cargar los datos.'}</td></tr>`;
        }

    } catch (error) {
        console.error('Error al cargar servicios:', error);
        // Mostrar error en la tabla
        tbody.innerHTML = `<tr><td colspan="5">Error al cargar datos. Verifique la consola. (${error.message})</td></tr>`;
    }
}

// Función para añadir listeners a botones de acción (ejemplo)
function addTableActionListeners(container) {
    container.querySelectorAll('.view').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.currentTarget.dataset.id;
            console.log('Ver servicio ID:', id);
            // Aquí podrías abrir un modal, redirigir, etc.
        });
    });
     container.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.currentTarget.dataset.id;
            console.log('Editar servicio ID:', id);
            // Aquí podrías abrir un formulario de edición
        });
    });
      container.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.currentTarget.dataset.id;
            if (confirm(`¿Está seguro de eliminar el servicio con ID ${id}?`)) {
                 console.log('Eliminar servicio ID:', id);
                 // Aquí llamarías a una API PHP para eliminar y luego recargarías la tabla
            }
        });
    });
}

// Llama a anchoPage al inicio por si acaso la ventana ya es pequeña
anchoPage();