<nav>
    <ul>
        <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ url('/profile') }}">Perfil</a></li>
        <!-- Más enlaces según necesites -->
        @if(auth()->check())
            <li><a href="{{ url('/logout') }}">Cerrar sesión</a></li>
        @else
            <li><a href="{{ url('/login') }}">Iniciar sesión</a></li>
        @endif
    </ul>
</nav>