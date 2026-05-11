<nav class="bg-dark text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">

        <a href="{{ url('/') }}" class="text-white text-decoration-none">
            Construction Admin
        </a>

        <div>
            @auth
                <span class="me-3">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </div>
</nav>