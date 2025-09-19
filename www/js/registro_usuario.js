
//documment. addEventListener('DOMContentLoaded', function() sirve para ejecutar una función cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    //aqui declaran la variable form que es el elemento con id loginForm que se usará para acceder a los campos del formulario
    const form = document.getElementById('loginForm')

    //form.addEventListener('submit', function(e) sirve para ejecutar una función cuando se envíe el formulario y async funtion sirve para que la función se ejecute de forma asíncrona(es decir, sin esperar a que termine la ejecución de la función para continuar con el resto de la página) la e es un parámetro que se pasa a la función cuando se envía el formulario
    form.addEventListener('submit', async function (e) {
        //e.preventDefault() sirve para evitar que el formulario se envíe al servidor
        e.preventDefault();
        //aqui se declara la variables email, password y rol que son los campos del formulario
        //this es el valor de la variable form que es el elemento con id loginForm
        const nombre = this.nombre.value;
        const email = this.email.value;
        const password = this.password.value;
        const rol = this.rol.value;

        //aqui se validan los campos del formulario y si no son válidos se muestra un alerta con el mensaje de error
        if (!nombre || !email || !password || !rol) {
            alert('Por favor, complete todos los campos');
            return;
        }

        //aqui se muestra un mensaje de carga mientras se realiza la operación
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.textContent = 'Registrando...';
        //aqui se deshabilita el botón para que no se pueda hacer click mientras se realiza la operación
        submitBtn.disabled = true;
        
        //aqui se realiza la llamada a la función fetch que se encarga de realizar la petición al servidor
        try {
            //aqui se declara la variable response que es la respuesta del servidor
            const response = await fetch('http://localhost/app_gym/backend/endpoints/usuarios_insert.php', {
                //aqui se declara el método de la petición como POST y se pasan los datos en formato JSON
                method: 'POST',
                //aqui se pasa el encabezado Content-Type con el valor application/json que es el formato JSON
                headers: {
                    'Content-Type': 'application/json'
                },
                //aqui se pasa el cuerpo de la petición con los datos en formato JSON
                //json.strngify es una función de javascript que convierte un objeto en un string JSON válido
                //body: JSON.stringify({ email, password, rol }) es el cuerpo de la petición que contiene los datos del formulario en formato JSON y se pasa como parámetro
                //body es el cuerpo de la petición que contiene los datos del formulario en formato JSON
                body: JSON.stringify({nombre, email, password, rol })
            });

            // Aquí se verifica si la petición ha sido exitosa
            //await response.json() es una función de javascript que convierte una respuesta en un objeto JSON válido es decir, convierte la respuesta del servidor en un objeto
            //await se usa para esperar a que la función fetch se complete y retorne su resultado
            const data = await response.json();

            if (data.success) {
                //aqui se guarda el usuario en localStorage
                localStorage.setItem('user', JSON.stringify(data.user));
                localStorage.setItem('rol', rol);

                //aqui se redirige a la página de inicio del usuario
                window.location.href = './login.html';
            } else {
                alert(data.message || 'Error al registrar usuario');
            }
        } catch (error) {
            alert('Ocurrió un error al registrar el usuario');
            console.error(error);
        } finally {
            submitBtn.textContent = 'Registrar';
            submitBtn.disabled = false;
        }
    });

});