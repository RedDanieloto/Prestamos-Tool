import './bootstrap';
import Sortable from 'sortablejs';
import { driver } from "driver.js";
import "driver.js/dist/driver.css";
import Swal from 'sweetalert2';

// Exponer Swal globalmente
window.Swal = Swal;

// Configuración de zona horaria México
const opcionesHora = {
    timeZone: 'America/Mexico_City',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
};

// Función para obtener hora actual de México
window.obtenerHoraMexico = function() {
    return new Intl.DateTimeFormat('es-MX', opcionesHora).format(new Date());
};

// Estado global
let herramientasSeleccionadas = [];
let currentCategory = 'todas';

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initBuscador();
    initBuscadorEmpleados();
    initDriverJS();
    initPrestamoActions();
});

// Filtrar por categoría
window.filterCategory = function(category) {
    currentCategory = category;
    
    // Actualizar botones
    document.querySelectorAll('.category-filter').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    
    const activeBtn = Array.from(document.querySelectorAll('.category-filter')).find(
        btn => btn.textContent.trim().includes(category === 'todas' ? 'Todas' : category)
    );
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-200', 'text-gray-700');
        activeBtn.classList.add('bg-blue-600', 'text-white', 'active');
    }
    
    // Filtrar herramientas
    filtrarHerramientas();
};

// Inicializar buscador de herramientas
function initBuscador() {
    const buscar = document.getElementById('buscar-herramientas');
    if (buscar) {
        buscar.addEventListener('input', filtrarHerramientas);
    }
}

// Inicializar buscador de empleados
function initBuscadorEmpleados() {
    const buscar = document.getElementById('buscar-empleados');
    if (buscar) {
        buscar.addEventListener('input', filtrarEmpleados);
    }
}

// Filtrar herramientas por categoría y búsqueda
function filtrarHerramientas() {
    const buscar = document.getElementById('buscar-herramientas');
    const texto = buscar ? buscar.value.toLowerCase() : '';
    
    document.querySelectorAll('.herramienta-checkbox').forEach(checkbox => {
        const nombre = checkbox.dataset.nombre.toLowerCase();
        const categoria = checkbox.dataset.categoria;
        const label = checkbox.parentElement;
        
        const coincideTexto = nombre.includes(texto);
        const coincideCategoria = currentCategory === 'todas' || categoria === currentCategory;
        
        label.style.display = (coincideTexto && coincideCategoria) ? 'flex' : 'none';
    });
}

// Filtrar empleados por búsqueda
function filtrarEmpleados() {
    const buscar = document.getElementById('buscar-empleados');
    const texto = buscar ? buscar.value.toLowerCase() : '';
    
    document.querySelectorAll('.tecnico-btn').forEach(btn => {
        const nombre = btn.dataset.nombre.toLowerCase();
        const empleado = btn.dataset.empleado.toLowerCase();
        
        const coincideNombre = nombre.includes(texto);
        const coincideEmpleado = empleado.includes(texto);
        
        btn.style.display = (coincideNombre || coincideEmpleado) ? 'block' : 'none';
    });
}

// Actualizar herramientas seleccionadas
window.actualizarSeleccionadas = function() {
    herramientasSeleccionadas = [];
    
    document.querySelectorAll('.herramienta-checkbox:checked').forEach(checkbox => {
        herramientasSeleccionadas.push({
            id: checkbox.dataset.id,
            nombre: checkbox.dataset.nombre,
            categoria: checkbox.dataset.categoria
        });
    });
    
    actualizarPanelSeleccionadas();
    actualizarBotonesEmpleados();
};

// Actualizar panel de seleccionadas
function actualizarPanelSeleccionadas() {
    const panel = document.getElementById('herramientas-seleccionadas');
    const contador = document.getElementById('contador-seleccionadas');
    const btnLimpiar = document.getElementById('btn-limpiar');
    
    contador.textContent = herramientasSeleccionadas.length;
    
    if (herramientasSeleccionadas.length === 0) {
        panel.innerHTML = '<p class="text-gray-500 font-semibold text-center py-6">Selecciona herramientas</p>';
        btnLimpiar.disabled = true;
    } else {
        btnLimpiar.disabled = false;
        panel.innerHTML = herramientasSeleccionadas.map(h => {
            const icono = h.categoria === 'Máquinas' ? '<i class="bi bi-gear"></i>' : 
                         h.categoria === 'Herramientas' ? '<i class="bi bi-hammer"></i>' : '<i class="bi bi-box"></i>';
            return `
                <div class="bg-blue-100 border-l-4 border-blue-500 p-3 rounded flex justify-between items-center">
                    <div>
                        <div class="font-semibold text-gray-800">${icono} ${h.nombre}</div>
                        <div class="text-xs text-gray-600">${h.categoria}</div>
                    </div>
                    <button onclick="removerHerramienta(${h.id})" class="text-red-500 hover:text-red-700 font-bold"><i class="bi bi-x-circle"></i></button>
                </div>
            `;
        }).join('');
    }
}

// Remover una herramienta de la selección
window.removerHerramienta = function(herramientaId) {
    const checkbox = document.querySelector(`.herramienta-checkbox[data-id="${herramientaId}"]`);
    if (checkbox) {
        checkbox.checked = false;
        actualizarSeleccionadas();
    }
};

// Limpiar selección
window.limpiarSeleccionadas = function() {
    document.querySelectorAll('.herramienta-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    actualizarSeleccionadas();
};

// Actualizar estado de botones de empleados
function actualizarBotonesEmpleados() {
    const botones = document.querySelectorAll('.tecnico-btn');
    if (herramientasSeleccionadas.length > 0) {
        botones.forEach(btn => btn.disabled = false);
    } else {
        botones.forEach(btn => btn.disabled = true);
    }
}

// Asignar herramientas a técnico (MÚLTIPLES)
window.asignarHerramientas = function(tecnicoId, tecnicoNombre) {
    if (herramientasSeleccionadas.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: '⚠️ Sin selección',
            text: 'Selecciona al menos una herramienta',
            confirmButtonColor: '#3085d6'
        });
        return;
    }
    
    // Asignar cada herramienta en secuencia
    const asignaciones = herramientasSeleccionadas.map(h => ({
        tecnico_id: tecnicoId,
        herramienta_id: h.id
    }));
    
    asignarMultiples(asignaciones, 0, tecnicoNombre);
};

// Función recursiva para asignar múltiples
function asignarMultiples(asignaciones, index, tecnicoNombre) {
    if (index >= asignaciones.length) {
        // Todas asignadas
        Swal.fire({
            icon: 'success',
            title: '✅ Éxito',
            text: `${asignaciones.length} herramienta(s) asignada(s) a ${tecnicoNombre}`,
            confirmButtonColor: '#28a745'
        }).then(() => {
            limpiarSeleccionadas();
            setTimeout(() => location.reload(), 500);
        });
        return;
    }
    
    const asignacion = asignaciones[index];
    
    fetch('/prestamos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(asignacion)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            asignarMultiples(asignaciones, index + 1, tecnicoNombre);
        } else {
            Swal.fire({
                icon: 'error',
                title: '❌ Error',
                text: `Error en herramienta ${index + 1}/${asignaciones.length}`,
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: '❌ Error de conexión',
            text: `Error en herramienta ${index + 1}/${asignaciones.length}`,
            confirmButtonColor: '#dc3545'
        });
    });
}

// Inicializar tutorial con DriverJS
function initDriverJS() {
    const startButton = document.getElementById('start-tour');
    
    if (!startButton) return;

    const driverObj = driver({
        showProgress: true,
        steps: [
            {
                element: '.category-filter',
                popover: {
                    title: '🎯 Filtrar Categorías',
                    description: 'Filtra por Máquinas, Herramientas u Otros para encontrar rápidamente lo que necesitas.',
                    position: 'bottom'
                }
            },
            {
                element: '#buscar-herramientas',
                popover: {
                    title: '🔍 Buscar Herramientas',
                    description: 'Escribe el nombre de la herramienta que buscas.',
                    position: 'bottom'
                }
            },
            {
                element: '.herramienta-checkbox',
                popover: {
                    title: '✅ Seleccionar Herramientas',
                    description: 'Marca los checkboxes para seleccionar múltiples herramientas.',
                    position: 'right'
                }
            },
            {
                element: '#herramientas-seleccionadas',
                popover: {
                    title: '📍 Herramientas Seleccionadas',
                    description: 'Aquí aparecen todas las herramientas que seleccionaste.',
                    position: 'left'
                }
            },
            {
                element: '#buscar-empleados',
                popover: {
                    title: '🔍 Buscar Empleados',
                    description: 'Busca por nombre o número de empleado.',
                    position: 'bottom'
                }
            },
            {
                element: '.tecnico-btn',
                popover: {
                    title: '👤 Técnico',
                    description: 'Haz click en el técnico para asignarle todas las herramientas seleccionadas.',
                    position: 'left'
                }
            }
        ]
    });

    startButton.addEventListener('click', () => {
        driverObj.drive();
    });
}

// Inicializar acciones de préstamos
function initPrestamoActions() {
    window.devolverHerramienta = function(prestamoId) {
        Swal.fire({
            icon: 'question',
            title: '¿Devolver herramienta?',
            text: 'Confirma que deseas marcar esta herramienta como devuelta',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, devolver',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/prestamos/${prestamoId}/devolver`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Devuelto',
                            text: 'La herramienta ha sido devuelta correctamente',
                            confirmButtonColor: '#28a745'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '❌ Error',
                            text: 'Error al devolver la herramienta',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Error de conexión',
                        text: 'Error al devolver la herramienta',
                        confirmButtonColor: '#dc3545'
                    });
                });
            }
        });
    };
}



