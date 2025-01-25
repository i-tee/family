<ul class="navbar-nav me-auto mb-2 mb-lg-0">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>

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