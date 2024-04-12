<nav class ="bg-light d-flex flex-column side py-2">
    <ul class="nav flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('hospital.index') }}" class="nav-link link-dark">
                <i class="fas fa-hospital-symbol"></i>&ensp;医療機関
            </a>
        </li>
        <ul class="px-3 mb-2 mt-n2 list-unstyled">
            <li class="nav-item">
                <a href="{{ route('hospital.create') }}" class="nav-link link-dark">
                    <i class="fas fa-plus"></i>&ensp;新規登録
                </a>
            </li>
        </ul>
        <li>
            <a href="{{ route('insurance.index') }}" class="nav-link link-dark">
                <i class="fas fa-address-card"></i>&ensp;保険者
            </a>
        </li>
        <ul class="px-3 mb-2 mt-n2 list-unstyled">
            <li class="nav-item">
                <a href="{{ route('insurance.create') }}" class="nav-link link-dark">
                    <i class="fas fa-plus"></i>&ensp;新規登録
                </a>
            </li>
        </ul>
        <li>
            <a href="{{ route('code.index') }}" class="nav-link link-dark">
                <i class="fas fa-cog"></i>&ensp;コード
            </a>
        </li>
        <ul class="px-3 mt-n2 list-unstyled">
            <li class="nav-item">
                <a href="{{ route('code.create') }}" class="nav-link link-dark">
                    <i class="fas fa-plus"></i>&ensp;新規登録
                </a>
            </li>
        </ul>
    </ul>
    <hr class="mx-2 mb-2">
</nav>
