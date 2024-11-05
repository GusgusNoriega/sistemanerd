<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

     
  
    </head>
    <body class="antialiased">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
    
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br><br>
    
            <button type="submit">Iniciar Sesión</button>
        </form>
    
        <p id="message"></p>

        <button id="accessProtectedRoute">Acceder a Datos del Usuario</button>
        <div id="userData"></div>
    
        <script>
            document.getElementById('loginForm').addEventListener('submit', async (e) => {
                e.preventDefault(); // Evita que se envíe el formulario de la forma tradicional
        
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const message = document.getElementById('message');
        
                try {
                    // Realiza la solicitud POST
                    const response = await fetch('http://sistemanerd.test/api/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ email, password })
                    });
        
                    // Procesa la respuesta
                    const data = await response.json();
        
                    if (response.ok) {
                        // Si el inicio de sesión es exitoso, guarda el token en sessionStorage con el nombre "tokennerd"
                        sessionStorage.setItem('tokennerd', data.token);
                        
                        message.textContent = 'Inicio de sesión exitoso. Token guardado en sessionStorage.';
                        message.style.color = 'green';
                    } else {
                        // Si hay un error, muestra el mensaje de error
                        message.textContent = data.message || 'Error al iniciar sesión';
                        message.style.color = 'red';
                    }
                } catch (error) {
                    message.textContent = 'Error de conexión. Por favor, intenta de nuevo.';
                    message.style.color = 'red';
                    console.error('Error:', error);
                }
            });

            document.getElementById('accessProtectedRoute').addEventListener('click', function() {
                // Recuperar el token de acceso desde localStorage
                const token = sessionStorage.getItem('tokennerd');
                const url = 'http://sistemanerd.test/api/user-data/1';
                
                // Verificar que el token existe
                if (!token) {
                    alert('No se encontró un token de acceso. Por favor, inicia sesión primero.');
                    return;
                }

                // Realizar la solicitud a la ruta protegida
                obtenerJSON(url, token)
                    .then(resultado => {
                        console.log(resultado); // Muestra el resultado en la consola
                        displayUserData(resultado);
                    })
                    .catch(error => {
                        console.error('Error al ejecutar la petición:', error);
                    });
            });

           

            async function obtenerJSON(url, token) {
                try {
                        const response = await fetch(url, {
                            method: 'GET', // 'GET' es el método por defecto, puedes omitir esta línea si deseas
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json', // Opcional, dependiendo de tu API
                            },
                        });

                        if (!response.ok) {
                            throw new Error(`Error en la petición: ${response.status} ${response.statusText}`);
                        }

                        const data = await response.json();
                        return data; // Devuelve solo el JSON de la respuesta
                    } catch (error) {
                        console.error('Error al obtener el JSON:', error);
                        throw error; // Puedes manejar el error según tus necesidades
                    }
            }

            function displayUserData(user) {
                const userDataDiv = document.getElementById('userData');
                userDataDiv.innerHTML = `
                    <h2>Datos del Usuario</h2>
                    <p><strong>ID:</strong> ${user.id}</p>
                    <p><strong>Nombre:</strong> ${user.name}</p>
                    <p><strong>Email:</strong> ${user.email}</p>
                    <!-- Añade más campos según sea necesario -->
                `;
            }
        </script>
    </body>
</html>
