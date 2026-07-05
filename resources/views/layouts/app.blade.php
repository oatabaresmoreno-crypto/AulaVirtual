{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aula Virtual')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: #161b22;
            --bg-card: #1c2128;
            --accent: #7dc142;
            --accent-hover: #6aad2e;
            --accent-dark: #1a2e0a;
            --text-primary: #e6edf3;
            --text-secondary: #8b949e;
            --border: #30363d;
        }
        body { background-color: var(--bg-primary); color: var(--text-primary); }
    </style>
</head>
<body style="background-color: #0d1117; color: #e6edf3; font-family: 'Inter', sans-serif;">

    {{-- Navbar --}}
    <nav style="background-color: #161b22; border-bottom: 1px solid #30363d;">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}"
               style="font-size: 1.25rem; font-weight: 800; color: #7dc142; letter-spacing: -0.5px;">
                🎓 Aula Virtual
            </a>

            {{-- Links de navegación --}}
            <div class="flex items-center gap-6 text-sm">

                @auth

                    {{-- Admin --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.courses.index') }}"
                           style="color: #8b949e; transition: color 0.2s;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Cursos
                        </a>
                        <a href="{{ route('admin.lessons.index') }}"
                           style="color: #8b949e; transition: color 0.2s;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Lecciones
                        </a>
                        <a href="{{ route('admin.assignments.index') }}"
                           style="color: #8b949e; transition: color 0.2s;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Asignaciones
                        </a>
                        <a href="{{ route('admin.enrollments.index') }}"
                           style="color: #8b949e; transition: color 0.2s;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Inscripciones
                        </a>
                    @endif

                    {{-- Instructor --}}
                    @if(auth()->user()->role === 'instructor')
                        <a href="{{ route('instructor.courses.index') }}"
                           style="color: #8b949e;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Mis Cursos
                        </a>
                        <a href="{{ route('instructor.lessons.index') }}"
                           style="color: #8b949e;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Mis Lecciones
                        </a>
                        <a href="{{ route('instructor.assignments.index') }}"
                           style="color: #8b949e;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Mis Asignaciones
                        </a>
                    @endif

                    {{-- Student --}}
                    @if(auth()->user()->role === 'student')
                        <a href="{{ route('student.courses.index') }}"
                           style="color: #8b949e;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Cursos
                        </a>
                        <a href="{{ route('student.enrollments.index') }}"
                           style="color: #8b949e;"
                           onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                           Mis Inscripciones
                        </a>
                    @endif

                    {{-- Badge de rol --}}
                    <span style="background-color: #1a2e0a; color: #7dc142; font-size: 0.7rem;
                                 padding: 2px 8px; border-radius: 9999px; border: 1px solid #7dc142;
                                 font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ auth()->user()->role }}
                    </span>

                    {{-- Usuario --}}
                    <span style="color: #e6edf3; font-weight: 500;">{{ auth()->user()->name }}</span>

                    {{-- Cerrar sesión --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button style="color: #8b949e; background: none; border: none; cursor: pointer; font-size: 0.875rem;"
                                onmouseover="this.style.color='#f85149'" onmouseout="this.style.color='#8b949e'">
                            Salir
                        </button>
                    </form>

                @else
                    <a href="{{ route('login') }}"
                       style="color: #8b949e;"
                       onmouseover="this.style.color='#7dc142'" onmouseout="this.style.color='#8b949e'">
                       Entrar
                    </a>
                    <a href="{{ route('register') }}"
                       style="background-color: #7dc142; color: #0d1117; padding: 6px 16px;
                              border-radius: 8px; font-weight: 600; font-size: 0.875rem;
                              transition: background-color 0.2s;"
                       onmouseover="this.style.backgroundColor='#6aad2e'"
                       onmouseout="this.style.backgroundColor='#7dc142'">
                        Registrarse
                    </a>
                @endauth

            </div>
        </div>
    </nav>

    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div style="background-color: #1a2e0a; border: 1px solid #7dc142; color: #7dc142;
                        border-radius: 8px; padding: 12px 16px; font-size: 0.875rem;">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div style="background-color: #2d1212; border: 1px solid #f85149; color: #f85149;
                        border-radius: 8px; padding: 12px 16px; font-size: 0.875rem;">
                ✗ {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Contenido de cada página --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>