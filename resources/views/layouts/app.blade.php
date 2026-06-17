<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passaporte.io – @yield('title', 'Eventos')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 flex flex-col">

    {{-- Navbar --}}
    <nav class="navbar bg-base-100 shadow-md px-4 sticky top-0 z-50">
        <div class="navbar-start">
            <a href="{{ route('home') }}" class="text-xl font-bold text-primary flex items-center gap-2">
                🎫 Passaporte.io
            </a>
        </div>
        <div class="navbar-end gap-2">
            @guest
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Entrar</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Cadastrar</a>
            @endguest

            @auth
                @if(auth()->user()->isParticipante())
                    <a href="{{ route('participant.inscriptions.index') }}" class="btn btn-ghost btn-sm">
                        Meus Ingressos
                    </a>
                @endif

                @if(auth()->user()->isOrganizador())
                    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">
                        Painel Admin
                    </a>
                @endif

               <div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-ghost btn-sm flex items-center gap-1">
        👤 {{ auth()->user()->name }}
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-40">
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-error">
                Sair
            </a>
        </li>
    </ul>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
            @endauth
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="container mx-auto px-4 pt-4">
        @if(session('success'))
            <div role="alert" class="alert alert-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div role="alert" class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- Conteúdo --}}
    <main class="container mx-auto px-4 py-6 flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer footer-center p-4 bg-base-100 text-base-content border-t mt-8">
        <p>© {{ date('Y') }} Passaporte.io — Todos os direitos reservados</p>
    </footer>

</body>
</html>
