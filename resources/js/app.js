import './bootstrap';
import Alpine from 'alpinejs';

// ─── Alpine.js ───────────────────────────────────────────────────────────
window.Alpine = Alpine;
Alpine.start();

// ─── Dark Mode Toggle ────────────────────────────────────────────────────
window.toggleDarkMode = function () {
    const html = document.documentElement;
    html.classList.toggle('dark');
    localStorage.setItem('darkMode', html.classList.contains('dark') ? 'true' : 'false');
};

// Apply saved dark mode preference
if (localStorage.getItem('darkMode') === 'true' ||
    (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
}

// ─── Axios Helpers ───────────────────────────────────────────────────────

/**
 * Fetch all servicios from the API.
 */
window.fetchServicios = async function () {
    try {
        const response = await axios.get('/api/servicios');
        return response.data.data;
    } catch (error) {
        console.error('Error fetching servicios:', error);
        return [];
    }
};

/**
 * Fetch all masajistas from the API.
 */
window.fetchMasajistas = async function () {
    try {
        const response = await axios.get('/api/masajistas');
        return response.data.data;
    } catch (error) {
        console.error('Error fetching masajistas:', error);
        return [];
    }
};

/**
 * Create a new cita via API.
 * @param {Object} payload - Cita data
 */
window.crearCita = async function (payload) {
    try {
        const response = await axios.post('/api/citas', payload);
        return response.data;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            return { success: false, errors: error.response.data.errors };
        }
        console.error('Error creating cita:', error);
        return { success: false, message: 'Error al crear la cita.' };
    }
};

/**
 * Search for clientes by query term.
 * @param {string} query - Search term (name or cedula)
 */
window.searchClientes = async function (query) {
    try {
        const response = await axios.get('/api/clientes/search', { params: { q: query } });
        return response.data.data;
    } catch (error) {
        console.error('Error searching clientes:', error);
        return [];
    }
};

/**
 * Get masajista availability for a specific date.
 * @param {number} cedula - Masajista cedula
 * @param {string} fecha - Date string (YYYY-MM-DD)
 */
window.getDisponibilidad = async function (cedula, fecha) {
    try {
        const response = await axios.get(`/api/masajistas/${cedula}/disponibilidad`, {
            params: { fecha },
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching disponibilidad:', error);
        return null;
    }
};

// ─── Notification Helper ─────────────────────────────────────────────────
window.showNotification = function (message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium animate-slide-down ${
        type === 'success' ? 'bg-primary-600' :
        type === 'error' ? 'bg-red-600' :
        'bg-amber-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// ─── Format Currency ─────────────────────────────────────────────────────
window.formatCurrency = function (amount) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
    }).format(amount);
};
