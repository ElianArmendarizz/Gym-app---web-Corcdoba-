document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Obtener los valores del formulario
        const email = form.email.value;
        const password = form.password.value;
        
        // Validar que todos los campos estén llenos
        if (!email || !password) {
            alert('Por favor, completa todos los campos');
            return;
        }
        
        // Mostrar mensaje de carga
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Iniciando sesión...';
        submitBtn.disabled = true;
        
        try {
            console.log('Enviando datos de login:', { email });
            
            // Enviar datos al servidor
            const response = await fetch('http://localhost/app_gym/backend/endpoints/usuarios_login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });
            
            console.log('Respuesta del servidor:', response);
            
            const data = await response.json();
            console.log('Datos recibidos:', data);
            
            if (data.success) {
                // Guardar datos de usuario en localStorage
                localStorage.setItem('user', JSON.stringify(data.user));
                localStorage.setItem('isLoggedIn', 'true');
                
                // Redirigir al menú principal
                window.location.href = './menu_usuario.html';
            } else {
                alert('Error: ' + data.error);
            }
        } catch (error) {
            console.error('Error completo:', error);
            alert('Error de conexión: ' + error.message);
        } finally {
            // Restaurar el botón
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
});