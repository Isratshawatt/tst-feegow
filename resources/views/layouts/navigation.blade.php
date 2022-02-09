<nav class="navbar navbar-expand-lg navbar-light bg-dark" style="">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('/images/logo.webp') }}" alt="Logo feegow">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('consulta.agendar') ? 'active' : '' }}" href="{{ route('consulta.agendar') }}">{{ __('Agendar') }}</a>
                </li>
            </ul>
            <span class="navbar-text">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
                {{-- Navbar text with an inline element --}}
            </span>
        </div>
    </div>
</nav>