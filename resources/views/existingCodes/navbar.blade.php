<!-- resources/views/components/navbar.blade.php -->

<nav id="navbar" class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm transition-all">
    <div class="container">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/pic1.png') }}" alt="HealthLink Logo" height="40" id="navbar-logo">
            <span class="brand-name ms-2 hide-on-scroll" id="brand-name">HealthLink</span>
        </a>
        <!-- Toggler for Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links, Authentication, and Dark Mode Toggle -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navigation Links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link active hide-on-scroll" aria-current="page" href="#home" aria-label="Navigate to Home section">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link hide-on-scroll" href="#purpose" aria-label="Navigate to Purpose section">Purpose</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link hide-on-scroll" href="#features" aria-label="Navigate to Features section">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link hide-on-scroll" href="#benefits" aria-label="Navigate to Benefits section">Benefits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link hide-on-scroll" href="#contact" aria-label="Navigate to Contact section">Contact</a>
                </li>
            </ul>

            <!-- Authentication Links and Dark Mode Toggle Grouped Together -->
            <div class="d-flex align-items-center mt-3 mt-lg-0 ms-lg-3 hide-on-scroll">
                @guest
                    @if (Route::has('login'))
                        <a class="btn btn-outline-success me-2" href="{{ route('login') }}">
                            Login
                        </a>
                    @endif
                @else
                    <!-- Authenticated User Dropdown -->
                    <div class="dropdown me-2">
                        <a id="navbarDropdown" class="btn btn-success dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest

                <!-- Dark Mode Toggle Button -->
                <button id="dark-mode-toggle" class="btn btn-outline-secondary" aria-label="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
