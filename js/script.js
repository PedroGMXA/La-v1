// js/script.js
document.addEventListener('DOMContentLoaded', () => {

    const menuToggleButton = document.querySelector('.menu-toggle-button');
    const dashboardContainer = document.querySelector('.dashboard-container');
    const sidebarLinks = document.querySelectorAll('.dashboard-sidebar nav ul li a');

    // --- Sidebar Toggle ---
    menuToggleButton.addEventListener('click', () => {
        dashboardContainer.classList.toggle('sidebar-collapsed');
    });

    // --- Active Sidebar Link ---
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Descomentar si son links reales y evitar recarga: e.preventDefault();
            sidebarLinks.forEach(l => l.classList.remove('active')); // Quita active de todos
             this.classList.add('active'); // Añade active al clickeado

             // Actualizar aria-current
            sidebarLinks.forEach(l => l.removeAttribute('aria-current'));
            this.setAttribute('aria-current', 'page');

            // Aquí podrías cargar el contenido de la sección correspondiente (no implementado)
            console.log('Navegando a:', this.querySelector('span').textContent);
        });
    });


    // --- Sample Data (Simulación) ---
    const sampleServices = [
        { folio: '19W6815', fecha: '2025-04-18', cliente: 'CLIENTE VIP', estado: 'Pendiente'},
        { folio: '19W742', fecha: '2025-04-18', cliente: 'REYNALDO ARIAS', estado: 'Listo'},
        { folio: '19W658', fecha: '2025-04-17', cliente: 'SEBASTIAN VELAZQUEZ', estado: 'En Espera'},
        { folio: '19W651', fecha: '2025-04-17', cliente: 'GRISEL CORTES', estado: 'Entregado'},
        { folio: '19W8504', fecha: '2025-04-16', cliente: 'ARACELI ALCOCER', estado: 'Pendiente'},
        { folio: '19W8187', fecha: '2025-04-16', cliente: 'CLIENTE MOSTRADOR', estado: 'Garantía'},
        { folio: '19W9123', fecha: '2025-04-15', cliente: 'JUAN PEREZ', estado: 'Listo'},
        { folio: '19W9456', fecha: '2025-04-15', cliente: 'MARIA GARCIA', estado: 'Entregado'},
        { folio: '19W9789', fecha: '2025-04-14', cliente: 'PEDRO MARTINEZ', estado: 'Pendiente'},
        { folio: '19W9900', fecha: '2025-04-14', cliente: 'LAURA SANCHEZ', estado: 'En Espera'},
         { folio: '19W9955', fecha: '2025-04-13', cliente: 'CARLOS GOMEZ', estado: 'Listo'},
    ];

    const sampleClients = [
         { codigo: 'CLI001', nombre: 'CLIENTE VIP', email: 'vip@email.com', telefono: '5512345678' },
         { codigo: 'CLI002', nombre: 'REYNALDO ARIAS', email: 'r.arias@email.com', telefono: '5587654321' },
         { codigo: 'CLI003', nombre: 'SEBASTIAN VELAZQUEZ', email: 's.vela@email.com', telefono: '5511223344' },
         { codigo: 'CLI004', nombre: 'GRISEL CORTES', email: 'g.cortes@email.com', telefono: '5544332211' },
         { codigo: 'CLI005', nombre: 'ARACELI ALCOCER', email: 'a.alcocer@email.com', telefono: '5599887766' },
    ];


    // --- Table Rendering ---
    const servicesTbody = document.querySelector('#servicios-table tbody');
    const clientsTbody = document.querySelector('#clientes-table tbody');
    const statusFilter = document.getElementById('status-filter');
    const dataSearch = document.getElementById('data-search');
    const searchButton = document.getElementById('search-button');
    const paginationInfo = document.getElementById('pagination-info');
    const prevPageButton = document.getElementById('prev-page');
    const nextPageButton = document.getElementById('next-page');

    let currentServicesPage = 1;
    const itemsPerPage = 5; // Cuántos servicios mostrar por página
    let filteredServices = [...sampleServices]; // Copia para filtrar/buscar

    function renderServicesTable() {
        if (!servicesTbody) return;
        servicesTbody.innerHTML = ''; // Limpiar tabla

        const startIndex = (currentServicesPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedServices = filteredServices.slice(startIndex, endIndex);

        if (paginatedServices.length === 0 && filteredServices.length > 0) {
             // Si no hay items en esta página pero sí hay datos filtrados (p.ej., última pág vacía)
             currentServicesPage = Math.max(1, currentServicesPage -1); // Ir a pág anterior si existe
             renderServicesTable(); // Volver a renderizar
             return;
        }
        if (paginatedServices.length === 0) {
             servicesTbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 20px;">No se encontraron servicios.</td></tr>';
        } else {
            paginatedServices.forEach(service => {
                const row = document.createElement('tr');
                const statusClass = `status-${service.estado.toLowerCase().replace(' ', '-')}`;

                row.innerHTML = `
                    <td>${service.folio}</td>
                    <td>${service.fecha}</td>
                    <td>${service.cliente}</td>
                    <td><span class="status-badge ${statusClass}">${service.estado}</span></td>
                    <td class="action-buttons">
                        <button class="btn btn-secondary btn-sm" aria-label="Ver detalle de ${service.folio}"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-primary btn-sm" aria-label="Editar ${service.folio}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" aria-label="Eliminar ${service.folio}"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                servicesTbody.appendChild(row);
            });
        }
        updatePaginationControls();
    }

     function renderClientsTable() {
        if (!clientsTbody) return;
        clientsTbody.innerHTML = ''; // Limpiar tabla

        // Simple rendering for clients, no pagination/filter in this example
        sampleClients.slice(0, 5).forEach(client => { // Mostrar solo los primeros 5
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${client.codigo}</td>
                <td>${client.nombre}</td>
                <td>${client.email}</td>
                <td>${client.telefono}</td>
                <td class="action-buttons">
                     <button class="btn btn-secondary btn-sm" aria-label="Ver cliente ${client.nombre}"><i class="fas fa-eye"></i></button>
                     <button class="btn btn-primary btn-sm" aria-label="Editar cliente ${client.nombre}"><i class="fas fa-edit"></i></button>
                </td>
            `;
            clientsTbody.appendChild(row);
        });
         if (sampleClients.length === 0) {
              clientsTbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 20px;">No hay clientes recientes.</td></tr>';
         }
    }


    // --- Filtering and Searching ---
    function applyFiltersAndSearch() {
        const searchTerm = dataSearch.value.toLowerCase();
        const selectedStatus = statusFilter.value;

        filteredServices = sampleServices.filter(service => {
            const matchesSearch = service.folio.toLowerCase().includes(searchTerm) ||
                                  service.cliente.toLowerCase().includes(searchTerm);
            const matchesStatus = selectedStatus === "" || service.estado === selectedStatus;

            return matchesSearch && matchesStatus;
        });

        currentServicesPage = 1; // Reset page to 1 after filtering/searching
        renderServicesTable();
    }

    statusFilter.addEventListener('change', applyFiltersAndSearch);
    searchButton.addEventListener('click', applyFiltersAndSearch);
    dataSearch.addEventListener('keyup', (e) => { // Optional: search on enter key
        if (e.key === 'Enter') {
            applyFiltersAndSearch();
        }
    });


    // --- Pagination ---
     function updatePaginationControls() {
         if (!paginationInfo) return;
        const totalPages = Math.ceil(filteredServices.length / itemsPerPage);
        paginationInfo.textContent = `Página ${currentServicesPage} de ${totalPages > 0 ? totalPages : 1}`;

        prevPageButton.disabled = currentServicesPage === 1;
        nextPageButton.disabled = currentServicesPage === totalPages || totalPages === 0;
    }

    prevPageButton.addEventListener('click', () => {
        if (currentServicesPage > 1) {
            currentServicesPage--;
            renderServicesTable();
        }
    });

    nextPageButton.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredServices.length / itemsPerPage);
        if (currentServicesPage < totalPages) {
            currentServicesPage++;
            renderServicesTable();
        }
    });

    // --- Initial Render ---
    renderServicesTable();
    renderClientsTable();

    // --- Logout Button ---
    const logoutButton = document.querySelector('.logout-button');
    logoutButton.addEventListener('click', () => {
        alert('Simulación de cierre de sesión.');
        // Aquí iría la lógica real de logout
    });

}); // End DOMContentLoaded