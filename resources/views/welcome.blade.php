<x-app-layout>
    <div class="p-3 container">
        <h1 class="lh-lg">{{ __('AppName') }}</h1>
        <h2>{{ __('AppDescription') }}</h2>
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
    </div>
</x-app-layout>