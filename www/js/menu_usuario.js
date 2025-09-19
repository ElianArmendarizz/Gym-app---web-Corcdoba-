
// Verificar si el usuario está logueado
document.addEventListener('DOMContentLoaded', function () {
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    const userData = JSON.parse(localStorage.getItem('user') || '{}');

    if (!isLoggedIn || !userData.id) {
        window.location.href = 'login.html';
        return;
    }

    // Mostrar información del usuario
    document.getElementById('welcomeMessage').textContent = `Bienvenido, ${userData.email}`;

    // Mostrar mensaje según el rol
    const rolMessage = document.getElementById('rolMessage');
    switch (userData.rol) {
        case 'usuario':
            rolMessage.textContent = 'Eres un usuario. Puedes acceder a tus rutinas y seguimiento personal.';
            break;
        case 'coach':
            rolMessage.textContent = 'Eres un coach. Puedes gestionar las rutinas de tus clientes.';
            break;
        case 'nutriologo':
            rolMessage.textContent = 'Eres un nutriólogo. Puedes gestionar planes alimenticios.';
            break;
        default:
            rolMessage.textContent = 'Bienvenido a FITBODY.';
    }

    // Configurar logout
    document.getElementById('logoutBtn').addEventListener('click', function () {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('user');
        window.location.href = 'login.html';
    });
});