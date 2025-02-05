<x-app-layout>
    <div class="p-3 container">
        <h1 class="lh-lg">{{ __('AppName') }}</h1>
        <h2>{{ __('AppDescription') }}</h2>
        @if (Auth::check())
            @isset($mainTreeData)
                <div class="mt-5">
                    <p>{{ __('You tree') }}</p>
                    <div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-primary" href="{{ $mainTreeData['mainTreeLink'] }}">{{ $mainTreeData['mainTreeName'] }}</a>
                            <a title="{{ __('Dashboard') }}" class="btn btn-outline-primary" href="{{ route('dashboard') }}">
                                <i class="bi bi-gear-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endisset
        @else
            <div class="mt-5">
                <p>{{ __('needReg') }}</p>
                <div>
                    <div class="row">
                        <div>
                            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register') }}</a>
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Log in') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>