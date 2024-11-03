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
        </script>
    </body>
</html>
