<nav class="navbar navbar-dark main-color">
    <div class="container-fluid">
        <div class="row w-100 g-0">
            <div class="col-10">
                <div class="img-logo ms-2">
                    <img src="{{ asset('img/logo_name.png') }}" alt="ナビロゴ">
                    <span class="navbar-brand h1 ms-2 align-bottom">マスター管理</span>
                </div>
            </div>
            @guest
            @else
            <div class="col-2 d-flex align-items-center justify-content-end">
                <div class="dropdown me-2">
                    <a href="#" class="px-3 link-dark text-decoration-none dropdown-toggle" id="users-menu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>&ensp;<span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="users-menu">
                        <li><a class="dropdown-item" href="{{ route('user.index') }}">一覧</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.create') }}">新規登録</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">ログアウト</a></li>
                    </ul>
                </div>
            </div>
            @endguest
        </div>
    </div>
</nav>
