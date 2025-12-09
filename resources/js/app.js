import './bootstrap';
import Sortable from 'sortablejs';
import { driver } from "driver.js";
import "driver.js/dist/driver.css";

// Inicializar Drag & Drop cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initDragAndDrop();
    initDriverJS();
    initPrestamoActions();
});

// Configurar Drag & Drop con SortableJS
function initDragAndDrop() {
    const herramientasContainer = document.getElementById('herramientas-disponibles');
    
    if (!herramientasContainer) return;

    // Hacer las herramientas arrastrables
    new Sortable(herramientasContainer, {
        group: {
            name: 'herramientas',
            pull: 'clone',
            put: false
        },
        animation: 150,
        sort: false,
        ghostClass: 'opacity-50'
    });

    // Hacer cada zona de técnico un área de destino
    const tecnicoZones = document.querySelectorAll('.tecnico-zone');
    
    tecnicoZones.forEach(zone => {
        new Sortable(zone, {
            group: {
                name: 'herramientas',
                put: true
            },
            animation: 150,
            onAdd: function(evt) {
                const herramientaId = evt.item.dataset.id;
                const tecnicoId = evt.to.dataset.tecnicoId;
                
                // Mostrar modal o directamente registrar préstamo
                registrarPrestamo(tecnicoId, herramientaId, evt.item);
            }
        });
    });
}

// Registrar préstamo mediante AJAX
function registrarPrestamo(tecnicoId, herramientaId, element) {
    const notas = prompt('Notas adicionales (opcional):');
    
    if (notas === null) {
        element.remove();
        return;
    }

    fetch('/prestamos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            tecnico_id: tecnicoId,
            herramienta_id: herramientaId,
            notas: notas
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar la página para actualizar todo
            location.reload();
        } else {
            alert('Error al registrar el préstamo');
            element.remove();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al registrar el préstamo');
        element.remove();
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
                element: '#herramientas-panel',
                popover: {
                    title: '🔧 Herramientas Disponibles',
                    description: 'Aquí se muestran todas las herramientas disponibles para préstamo. Puedes arrastrarlas a los técnicos.',
                    position: 'right'
                }
            },
            {
                element: '.herramienta-item',
                popover: {
                    title: '📦 Herramienta',
                    description: 'Arrastra esta herramienta hacia un técnico para asignarle un préstamo.',
                    position: 'bottom'
                }
            },
            {
                element: '#tecnicos-panel',
                popover: {
                    title: '👥 Técnicos Activos',
                    description: 'Estos son los técnicos activos. Suelta las herramientas en sus áreas para asignar préstamos.',
                    position: 'left'
                }
            },
            {
                element: '.tecnico-zone',
                popover: {
                    title: '🎯 Zona de Asignación',
                    description: 'Suelta las herramientas aquí para asignarlas a este técnico. Se te pedirá agregar notas opcionales.',
                    position: 'top'
                }
            },
            {
                element: '#prestamos-activos',
                popover: {
                    title: '📋 Préstamos Activos',
                    description: 'Aquí se listan todos los préstamos activos. Puedes marcar las herramientas como devueltas.',
                    position: 'top'
                }
            },
            {
                element: '#nav-tecnicos',
                popover: {
                    title: '👤 Gestión de Técnicos',
                    description: 'Accede aquí para crear, editar o eliminar técnicos del sistema.',
                    position: 'bottom'
                }
            },
            {
                element: '#nav-herramientas',
                popover: {
                    title: '🔧 Gestión de Herramientas',
                    description: 'Accede aquí para crear, editar o eliminar herramientas del sistema.',
                    position: 'bottom'
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
    // La función devolverHerramienta se define globalmente para uso inline
    window.devolverHerramienta = function(prestamoId) {
        if (!confirm('¿Confirmar devolución de esta herramienta?')) {
            return;
        }

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
                location.reload();
            } else {
                alert('Error al devolver la herramienta');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al devolver la herramienta');
        });
    };
}

