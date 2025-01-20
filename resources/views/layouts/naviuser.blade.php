<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/dashboard">{{ __('Tree') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">{{ __('Disabled') }}</a>
    </li>
</ul>
<div class="row align-items-center">
    <div class="col">
        <span>{{ Auth::user()->name }}</span>
    </div>
    <div class="col">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">{{ __('Exit') }}</button>
        </form>
    </div>
</div>
