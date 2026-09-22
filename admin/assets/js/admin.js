// admin/assets/js/admin.js
// JavaScript para el panel de administración

function cerrarModal() {
    const modal = document.getElementById('modalError');
    if (modal) {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
    if (window.history && window.history.pushState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('total');
        url.searchParams.delete('mensaje');
        window.history.pushState({}, '', url.toString());
    }
    window.location.href = window.location.pathname;
}

// Auto-cerrar mensajes de éxito después de 3 segundos
function autoCerrarMensajes() {
    const mensajes = document.querySelectorAll('.alert-success');
    mensajes.forEach(function(mensaje) {
        setTimeout(function() {
            mensaje.style.transition = 'opacity 0.5s ease';
            mensaje.style.opacity = '0';
            setTimeout(function() {
                mensaje.style.display = 'none';
            }, 500);
        }, 3000);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-cerrar mensajes
    autoCerrarMensajes();
    
    // Cerrar modal con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarModal();
        }
    });
    
    // Cerrar modal click fuera
    const modal = document.getElementById('modalError');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                cerrarModal();
            }
        });
    }
});
