<ul class="navbar-nav me-auto mb-2 mb-lg-0">

    @isset($mainTreeData)
        <!-- Переменная $mainTreeData существует -->
        <li class="nav-item">
            <a class="nav-link" href="{{ $mainTreeData['mainTreeLink'] }}">{{ $mainTreeData['mainTreeName'] }}</a>
        </li>
        <li class="nav-item">
            <a title="{{ __('Dashboard') }}" class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-gear-fill"></i></a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
    @endisset

</ul>

<div class="row align-items-center">
    <div class="col">
        <span>{{ Auth::user()->name }}</span>
    </div>
    <div class="col">
        <span>[{{ Auth::user()->id }}]</span>
    </div>
    <div class="col">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">{{ __('Exit') }}</button>
        </form>
    </div>
</div>