<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <!-- Aquí puedes agregar enlaces a tus archivos CSS -->
</head>
<body>
    <!-- Incluir el menú -->
    @include('components.menu')

    <!-- Contenido principal -->
    <div class="content">
        @yield('content')
    </div>

       <!-- Aquí puedes agregar enlaces a tus archivos JavaScript -->
       <script>
        // Función para realizar solicitudes protegidas
        function fetchWithAuth(url, options = {}) {
            const token = sessionStorage.getItem('tokennerd');

            if (!token) {
                console.error("Token no encontrado, redirigiendo al inicio de sesión");
                window.location.href = '/login';
                return;
            }

            options.headers = {
                ...options.headers,
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            };

            return fetch(url, options)
                .then(response => {
                    if (response.status === 401) {
                        console.error("Acceso no autorizado, redirigiendo al inicio de sesión");
                        window.location.href = '/login';
                    }
                    return response.json();
                })
                .catch(error => console.error('Error en la solicitud:', error));
        }

        // Ejemplo de uso para obtener datos de una ruta protegida
        function getProtectedData() {
            fetchWithAuth('/api/protected-route')
                .then(data => {
                    if (data) {
                        console.log("Datos protegidos recibidos:", data);
                    }
                });
        }

        // Llamar a la función para probar el acceso a la ruta protegida
        getProtectedData();
    </script>
</body>
</html>