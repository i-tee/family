<ul class="navbar-nav me-auto mb-2 mb-lg-0">

    @if($userTrees->isNotEmpty())
        <ul>
            @foreach($userTrees as $tree)
                <li>{{ $tree->name }}</li>
            @endforeach
        </ul>
    @else
        <span>У вас пока нет дерева</span>
    @endif

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